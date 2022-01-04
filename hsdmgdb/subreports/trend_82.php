<? //                 | Songwriter Count                                               | 

$fields = array( "Quarter", "Average Tempo" );

foreach( $fields as $fname ) {
  $sheet->write( $rownum, $colnum++, $fname, $format_bold );
}

foreach( $quarterstorun as $q )
  {
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, formatQuarterForDisplay( $q ) );
    $qspl = explode( "/", $q );
    $songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
    $numsongs = count( $songs );
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );

    $numforthis = db_query_first_cell( "select avg(Tempo) from songs where id in ( $songidstr ) " );
		
	$sheet->write( $rownum, $colnum++, floor( $numforthis ));

	if( $addnote )
	  {
	    $songs = db_query_array( "select id from songs where id in ( $songidstr ) " );
	    $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }
  }


$rownum++;$colnum = 0;
$rownum++;$colnum = 0;

$sheet->write( $rownum, $colnum++, "Tempo Range", $format_bold );
$rownum++;$colnum = 0;

$fields = array();
$fields[] = "Quarter";

$colheaders = array();
foreach( $quarterstorun as $q )
  {
    $qspl = explode( "/", $q );
    $songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
    $songs[] = -1;
    $songidstr = implode( ", ", $songs );
    $dist = db_query_array( "select distinct( TempoRange ) from songs where id in ( $songidstr )", "TempoRange", "TempoRange" );
    foreach( $dist  as $poss )
    {
        $colheaders[str_pad( $poss, 10, "0", STR_PAD_LEFT)] = $poss;
    }
  }

ksort( $colheaders );
$colheaders = array_values( $colheaders );

$sheet->write( $rownum, $colnum++, "Quarter", $format_bold );
foreach( $colheaders as $c )
{
    $sheet->write( $rownum, $colnum++, $c, $format_bold );
}



foreach( $quarterstorun as $q )
  {
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, formatQuarterForDisplay( $q ) );
    $qspl = explode( "/", $q );
    $songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
    $numsongs = count( $songs );
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );
    foreach( $colheaders as $c )
    {
        $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and TempoRange = '$c' " );
	
	$sheet->write( $rownum, $colnum++, $numforthis);

	if( $addnote )
	  {
	    $songs = db_query_array( "select id from songs where id in ( $songidstr ) and TempoRange = '$c'" );
	    $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }
	
        
    }
  }
?>