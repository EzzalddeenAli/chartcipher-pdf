<? //                 | LAST SECTION WITHIN TOP 10 SONGS                               | 

if( !$newarrivalsonly )
  {
    $sql ="select group_concat( distinct( songsections.id ) ) as ssids, songsections.WithoutNumber from songs, songsections where songsections.id = songs.LastSectionID and songs.id in ( $allsongsstr ) group by WithoutNumber order by min( OrderBy )";
    
    $sections = db_query_array( $sql, "ssids", "WithoutNumber" );

  }
else
  {
    $tmpqarr = array();
    foreach( $quarterstorun as $q )
      {
          $tmpqarr = array_merge( $tmpqarr, getQuartersForString( $q ) );
      }
	$allqstr = implode( ", ", $tmpqarr );
	$sections = db_query_array( "select group_concat( distinct( songsections.id ) ) as ssids, songsections.WithoutNumber from songs, songsections where songsections.id = songs.LastSectionID and songs.QuarterEnteredTheTop10 in ( $allqstr ) group by WithoutNumber", "ssids", "WithoutNumber" );
    logquery( "select group_concat( distinct( songsections.id ) ) as ssids, songsections.WithoutNumber from songs, songsections where songsections.id = songs.LastSectionID and songs.QuarterEnteredTheTop10 in ( $allqstr ) group by WithoutNumber" );
  }

//logquery( print_r( $sections, true ) );

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

    $totalrow = 0;
    foreach( $sections as $sid=>$sname )
      {
	$numforthis = db_query_first_cell( "select count(*) from songs where LastSectionID in ( $sid ) and id in ( $songidstr )" );
	$numforthis = $numforthis / ($totalnum?$totalnum:1) * 100; 
	
	$num = number_format( $numforthis );
	$sheet->write( $rownum, $colnum++, $num/100, $percentformat);
    if( $addnote )
      {
          $songs = db_query_array( "select id from songs where LastSectionID in ( $sid ) and id in ( $songidstr )" );
          $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
      }

	$totalrow += $num;
      }
    $sheet->write( $rownum, $colnum++, $totalrow/100, $percentformat);
  }

?>