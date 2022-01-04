<? //                  | AVERAGE INTRO LENGTH                                           | 


$fields[] = "Avg. Intro Length";


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

    $numforthis = db_query_first_cell( "select round( avg( time_to_sec( length ) ) ) from song_to_songsection where songid in ( $songidstr ) and songsectionid = " . INTRO  );
    $sheet->write( $rownum, $colnum++, excelSeconds( $numforthis ), $timeformat );
//    $sheet->write( $rownum, $colnum++, $numforthis );

    // don't need notes
  }


?>