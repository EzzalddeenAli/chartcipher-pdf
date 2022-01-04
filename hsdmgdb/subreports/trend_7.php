<? //                  | FIRST CHORUS OCCURRENCE RANGE (PERCENT INTO SONG)              | 

$times = array();
$times[] = "Kickoff";
$times[] = "Early";
$times[] = "Moderately Early";
$times[] = "Moderately Late";
$times[] = "Late";

$etimes = array();
$etimes["Kickoff"] = "<1%";
$etimes["Early"] = "(1-9%)";
$etimes["Moderately Early"] = "(10-19%)";
$etimes["Moderately Late"] = "(20-29%)";
$etimes["Late"] = "(30%+)";

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
    // we need to add this in case there were none
    $songs[] = -1;
    $songidstr = implode( ", ", $songs );
    $numsongs = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and FirstChorusPercentRange is not null" );
    
    $total = 0;
    foreach( $times as $t )
      {
	$numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and FirstChorusPercentRange = '$t' " );
	
	$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
	$sheet->write( $rownum, $colnum++, $numforthis/100, $percentformat);
	if( $addnote )
	  {
	    $songs = db_query_array( "select id from songs where id in ( $songidstr ) and FirstChorusPercentRange = '$t' " );
	    $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }
	
	$total += $numforthis;
      }
    $sheet->write( $rownum, $colnum++, $total/100, $percentformat);

  }

?>