<? //                 | SONG TITLE WORD COUNT                                          | 

$times = array();
$times[] = "1";
$times[] = "2";
$times[] = "3";
$times[] = "4";
$times[] = "5";

$etimes = array();
$etimes["1"] = " Words";
$etimes["2"] = " Words";
$etimes["3"] = " Words";
$etimes["4"] = " Words";
$etimes["5"] = "+ Words";

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
    $numsongs = count( $songs );
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );
    $total = 0;
    foreach( $times as $t )
      {
	$sign = $t == 5?" >= ":" = ";
	$numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SongTitleWordCount {$sign} $t " );
	
	$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
	$sheet->write( $rownum, $colnum++, $numforthis/100, $percentformat);

	if( $addnote )
	  {
	    $songs = db_query_array( "select id from songs where id in ( $songidstr ) and SongTitleWordCount {$sign} $t " );
	    $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }
	

	$total += $numforthis;
      }
    $sheet->write( $rownum, $colnum++, $total/100, $percentformat);

  }


?>