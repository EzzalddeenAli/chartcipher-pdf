<? // | PRIMARY GENRE: TRENDS                      

$primarygenres = db_query_rows( "select * from genres order by OrderBy , Name" );
$allsongrows = db_query_rows( "select * from songs where id in ( " . implode( ", ", $allsongs ) . " )" );

$primarygenres[] = array( "id"=>0, "Name"=>"Unassigned" );

$rownum++;
$colnum = 0;

$sheet->write( $rownum, $colnum++, "GENRE", $format_bold  );
foreach( $quarterstorun as $q )
  {
    $sheet->write( $rownum, $colnum++, formatQuarterForDisplay( $q ), $format_bold  );
  }

$totalsperquarter = array();
$genreamountsbyquarter = array();
$notes = array();
foreach( $quarterstorun as $q )
  {
    $qspl = explode( "/", $q );
    $songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
    $numsongs = count( $songs );
    $totalsperquarter[$q] = $numsongs;

    $songs[] = -1;
    $songidstr = implode( ", ", $songs );

    foreach( $primarygenres as $p )
      {
          $ext = "";
          if( !$p[id] )
              $ext = " or GenreID is null ";
          $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and ( GenreID = '$p[id]'  $ext ) " );
          $genreamountsbyquarter[$q][$p[id]] = $numforthis;
          if( $addnote )
          {   
              $numarr = db_query_array( "select id from songs where id in ( $songidstr ) and ( GenreID = '$p[id]'  $ext ) ", "id", "id" );
              
              $notes[$q][$p[id]] = getSongNames( $numarr ) ;
          }
      }
    
  }


foreach( $primarygenres as $p )
  {
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $p[Name]  );
    foreach( $quarterstorun as $q )
      {
	$percent = $genreamountsbyquarter[$q][$p[id]];
	$total = $totalsperquarter[$q];
	if( !$total ) $total = 1;
	$sheet->write( $rownum, $colnum++, $percent / $total, $percentformat );
	if( $addnote )
	{
		$sheet->writeNote( $rownum, $colnum-1, $notes[$q][$p[id]], $percentformat );
	}
      }
  }

?>