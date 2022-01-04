<? //                 | PERCENTAGE OF SONGS THAT FOLLOW AN A-B-A-B-C-B FORM            | 

$fields[] = "A-B-A-B-C-B";


foreach( $fields as $fname ) {
  $sheet->write( $rownum, $colnum++, $fname, $format_bold );
}
logquery( "19: " . $allsongsstr );
foreach( $quarterstorun as $q )
  {
    $rownum++;
    $colnum = 1;
    $sheet->write( $rownum, $colnum++, formatQuarterForDisplay( $q ) );
    $qspl = explode( "/", $q );
    $songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
    $numsongs = count( $songs );
    if( !$numsongs ) $numsongs = 1;
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );

    $numforthis = db_query_first_cell( "select count( * ) from songs where BridgeSurrogateShortForm = 'A-B-A-B-C-B' and id in ( $songidstr )" );
    $sheet->write( $rownum, $colnum++, $numforthis / $numsongs, $percentformat );
	if( $addnote )
	  {
	    $songs = db_query_array( "select id from songs where BridgeSurrogateShortForm = 'A-B-A-B-C-B' and id in ( $songidstr )" );
	    $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }


  }


$rownum++; 
$rownum++; 
$rownum++; 

$colnum=0;
$fields = array( "", "Form" );

foreach( $quarterstorun as $q )
  {
    $fields[] = formatQuarterForDisplay( $q );
  }


foreach( $fields as $fname ) {
  $sheet->write( $rownum, $colnum++, $fname, $format_bold );
}

$inst = db_query_array( "select distinct( BridgeSurrogateShortForm )  from songs where id in ( $allsongsstr ) order by BridgeSurrogateShortForm", "BridgeSurrogateShortForm", "BridgeSurrogateShortForm" );

foreach( $inst as $form )
  {
    $rownum++;
    $colnum = 1;
    $sheet->write( $rownum, $colnum++, $form );

    foreach( $quarterstorun as $q )
      {
	$qspl = explode( "/", $q );
	$songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
	$numsongs = count( $songs );
	// we need to add this in case there were none
	$songs[] = -1;
	
	$songidstr = implode( ", ", $songs );
	$total = 0;
	$numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and BridgeSurrogateShortForm = '$form' " );
	
	$numforthisa = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
	$sheet->write( $rownum, $colnum++, $numforthisa/100, $percentformat);
	// $sheet->write( $rownum, $colnum++, $numforthis);
	// $sheet->write( $rownum, $colnum++, $numsongs);

	if( $addnote )
	  {
          $songs = db_query_array( "select id from songs where id in ( $songidstr ) and BridgeSurrogateShortForm = '$form'" );
          $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }
      }
    
  }




?>