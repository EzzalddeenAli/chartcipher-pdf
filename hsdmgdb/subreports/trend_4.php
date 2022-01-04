<? //                  | Average Song Length                                            | 

$fields[] = "Time";


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
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );

    $numforthis = db_query_first_cell( "select round( avg( time_to_sec( SongLength ) ) ) from songs where id in ( $songidstr )" );
    $sheet->write( $rownum, $colnum++, excelSeconds( $numforthis ), $timeformat );
//    $sheet->write( $rownum, $colnum++,  $numforthis, $timeformat );
  }

?>