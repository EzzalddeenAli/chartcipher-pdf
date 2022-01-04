<? //                 | FIRST SECTION WITHIN TOP 10 SONGS                              | 


if( !$newarrivalsonly )
  {
    $sections = db_query_array( "select songsections.id, songsections.Name from songs, songsections where songsections.id = songs.FirstSection and songs.id in ( $allsongsstr ) order by OrderBy", "id", "Name" );
    logquery( "select songsections.id, songsections.Name from songs, songsections where songsections.id = songs.FirstSection and songs.id in ( $allsongsstr ) order by OrderBy" );
  }
else
  {
    $tmpqarr = array();
    foreach( $quarterstorun as $q )
      {
	$tmpqarr[] = "'" . $q . "'"; 
	$allqstr = implode( ", ", $tmpqarr );
	$sections = db_query_array( "select songsections.id, songsections.Name from songs, songsections where songsections.id = songs.FirstSection and songs.QuarterEnteredTheTop10 in ( $allqstr ) order by OrderBy", "id", "Name" );
      }
  }

foreach( $sections as $sname )
  {
    $fields[] = trim( str_replace( "1", "", $sname ) );
  }
$fields[] = "Total";


foreach( $fields as $fname ) {
  $sheet->write( $rownum, $colnum++, $fname, $format_bold );
}

foreach( $quarterstorun as $q )
  {
    $rownum++;
    $colnum = 1;
    $sheet->write( $rownum, $colnum++, formatQuarterForDisplay( $q ) );

    $qspl = explode( "/", $q );
    $songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
    $totalnum = count( $songs );
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );

    if( $addnote )
      {
          $songs = db_query_array( "select id from songs where id in ( $songidstr )", "id", "id" );
          $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
      }
    


    $totalrow = 0;
    foreach( $sections as $sid=>$sname )
      {
	$numforthis = db_query_first_cell( "select count(*) from songs where FirstSection = '$sid' and id in ( $songidstr )" );
	$numforthis = $numforthis / ($totalnum?$totalnum:1) * 100; 
	
	$num = number_format( $numforthis );
	$sheet->write( $rownum, $colnum++, $num/100, $percentformat);
	if( $addnote )
	  {
	    $songs = db_query_array( "select id from songs where FirstSection = '$sid' and id in ( $songidstr )", "id", "id" );
	    $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }

	$totalrow += $num;
      }
    $sheet->write( $rownum, $colnum++, $totalrow/100, $percentformat);
  }


?>