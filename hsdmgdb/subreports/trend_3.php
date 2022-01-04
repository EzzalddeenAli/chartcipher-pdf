<? //                  | AVERAGE PERCENT INTO A SONG WHERE THE FIRST CHORUS HITS        | 

$fields[] = "First Chorus Hit";


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

    $numforthis = db_query_first_cell( "select avg( FirstChorusPercent ) from songs where id in ( $songidstr ) and FirstChorusRange is not null" );
    $sheet->write( $rownum, $colnum++, $numforthis/100, $percentformat );
  }


?>