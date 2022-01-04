<? //                 | LEAD VOCAL                                                     | 

$vocals = getEnumValues( "VocalsGender" );

foreach( $vocals as $t )
  {
    $fields[] = $t;
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
    $numsongs = count( $songs );
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );
    $total = 0;
    foreach( $vocals as $t )
      {
	$numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and VocalsGender = '$t' " );
	
	$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
	$sheet->write( $rownum, $colnum++, $numforthis/100, $percentformat);
    if( $addnote )
      {
          $songs = db_query_array( "select id from songs where id in ( $songidstr ) and VocalsGender = '$t'  " );
          $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
      }
	$total += $numforthis;
      }
    $sheet->write( $rownum, $colnum++, $total/100, $percentformat);

  }

?>