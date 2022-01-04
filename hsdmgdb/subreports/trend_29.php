<? // LIST OF SONGS

$fields[] = "Songs";


foreach( $fields as $fname ) {
  $sheet->write( $rownum, $colnum++, $fname, $format_bold );
}

foreach( $quarterstorun as $q )
  {
    $rownum++;
    $colnum = 1;
//	$sheet->write( $rownum, $colnum++, $q	);
    $sheet->write( $rownum, $colnum++, formatQuarterForDisplay( $q ) );
    $qspl = explode( "/", $q );
//	$sheet->write( $rownum, $colnum++, print_r( $qspl, true ) );
    $songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
    foreach( $songs as $s )
      {
	$name = db_query_first_cell( "select Name from songnames sn, songs s where sn.id = s.songnameid and s.id = $s" );
	$sheet->write( $rownum, $colnum++, $name );
      }
  }


?>