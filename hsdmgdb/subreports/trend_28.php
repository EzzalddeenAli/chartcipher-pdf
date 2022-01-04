<? //                 | Title Appearances                                              | 

$times = array();
$times[] = "None";
$times[] = "1 - 5 Times";
$times[] = "6 - 10 Times";
$times[] = "11 - 15 Times";
$times[] = "16 - 20 Times";
$times[] = "21+ Times";

$etimes = array();
$etimes[] = array( 0, 0 );
$etimes[] = array( 1, 5 );
$etimes[] = array( 6, 10 );
$etimes[] = array( 11, 15 );
$etimes[] = array( 16, 20 );
$etimes[] = array( 21, 9999 );

foreach( $times as $t )
  {
    $fields[] = $t;
  }
    $fields[] = "Total";

foreach( $fields as $fname ) {
  $sheet->write( $rownum, $colnum++, $fname . (isset( $etimes[$fname])?" " . $etimes[$fname]:""), $format_bold );
}

foreach( $quarterstorun as $q )
  {
    $rownum++;
    $colnum = 1;
    $sheet->write( $rownum, $colnum++, formatQuarterForDisplay( $q ) );
    $qspl = explode( "/", $q );
    $songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
    $numsongs = count( $songs );
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );
    $total = 0;
    foreach( $times as $tid=> $t )
      {
	$vals = $etimes[$tid];
	$numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SongTitleAppearances >= {$vals[0]}  and SongTitleAppearances <= {$vals[1]} " );
	if( !$vals[0] )
	  $numforthis += db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SongTitleAppearances is null " );
	  
	logquery( "select count(*) from songs where id in ( $songidstr ) and SongTitleAppearances >= {$vals[0]}  and SongTitleAppearances <= {$vals[1]} " );
	
	$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
	$sheet->write( $rownum, $colnum++, $numforthis/100, $percentformat);

	if( $addnote )
	  {
	    $or = !$vals[0]?" or SongTitleAppearances is null":"";
	    $songs = db_query_array( "select id from songs where id in ( $songidstr ) and ((SongTitleAppearances >= {$vals[0]}  and SongTitleAppearances <= {$vals[1]}) $or) " );
	    $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }
	

	$total += $numforthis;
      }
    $sheet->write( $rownum, $colnum++, $total/100, $percentformat);

  }



?>