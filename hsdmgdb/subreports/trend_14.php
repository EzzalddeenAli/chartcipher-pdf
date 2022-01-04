<? //                 | NUMBER OF SONGS IN THE TOP 10                                  | 


$fields[] = "Total Songs";
$fields[] = "New Songs";
$fields[] = "Carryovers";

$sheet->writeNote( $rownum, $colnum, "aaa" );

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
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );

    // we need to add this in case there were none
    
    $newarrivals = db_query_first_cell( "select count(*) from songs where QuarterEnteredTheTop10 like '%$q' and id in ( $songidstr )" );
    logquery( "select count(*) from songs where QuarterEnteredTheTop10 = '$q' and id in ( $songidstr )" );
    $carryovers = $totalnum - $newarrivals; 


    $sheet->write( $rownum, $colnum++, $totalnum );
    if( $addnote )
      {
	$sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
//	$sheet->writeNote( $rownum, $colnum-1, "aaa" );
      }
    $sheet->write( $rownum, $colnum++, $newarrivals );
    if( $addnote )
      {
          $newarrivalsarr = db_query_array( "select id from songs where QuarterEnteredTheTop10 like '%$q' and id in ( $songidstr )", "id", "id" );
//	        file_put_contents( "/tmp/note", "adding note?\n". , FILE_APPEND );
         $sheet->writeNote( $rownum, $colnum-1, getSongNames( $newarrivalsarr ) );
      }
    $sheet->write( $rownum, $colnum++, $carryovers );
    if( $addnote )
      {
          $carryoversarr = db_query_array( "select id from songs where QuarterEnteredTheTop10 not like '%$q' and id in ( $songidstr )", "id", "id" );
//	$sheet->writeNote( $rownum, $colnum-1, "aaa" );
         $sheet->writeNote( $rownum, $colnum-1, getSongNames( $carryoversarr ) );
      }

  }

//$sheet->writeNote( 1, 1, "bbb" );



?>