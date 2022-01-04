<? //                 | OUTRO LENGTH RANGE                                             | 

$times = array();
$times["(0:01-0:09)"] = "Short";
$times["(0:10-0:19)"] = "Moderately Short";
$times["(0:20-0:29)"] = "Moderately Long";
$times["(0:30 +)"] = "Long";

foreach( $times as $extra => $t )
{
    $fields[] = $t . " " . $extra;
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
    $numsongs = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and OutroRange <> 'None' " );
    $total = 0;
    foreach( $times as $t )
      {
          $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and OutroRange = '$t' " );
	
          $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
          $sheet->write( $rownum, $colnum++, $numforthis/100, $percentformat);
          if( $addnote )
          {
              $songs = db_query_array( "select id from songs where id in ( $songidstr ) and OutroRange = '$t' and OutroRange <> 'None'" );
              $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
          }
          $total += $numforthis;
      }
    $sheet->write( $rownum, $colnum++, $total/100, $percentformat);

  }


?>