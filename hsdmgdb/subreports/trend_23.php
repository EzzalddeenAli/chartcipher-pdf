<? //                 | PRIMARY/PROMINENT INSTRUMENTATION FEATURED WITHIN TOP 10 SONGS | 

$inst = array();
$inst[] = "Bass";
$inst[] = "Guitar";
$inst[] = "Piano";
$inst[] = "Strings";
$inst[] = "Synth";
$inst[] = "Wind";



foreach( $inst as $t )
  {
    $fields[] = $t;
  }

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
    foreach( $inst as $t )
      {
	$numforthis = db_query_first_cell( "select count(distinct( songid )) from song_to_primaryinstrumentation, primaryinstrumentations where id = primaryinstrumentationid and songid in ( $songidstr ) and Name like '$t%' " );
	
	$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
	$sheet->write( $rownum, $colnum++, $numforthis/100, $percentformat);

	if( $addnote )
	  {
	    $songs = db_query_array(  "select songid from song_to_primaryinstrumentation, primaryinstrumentations where id = primaryinstrumentationid and songid in ( $songidstr ) and Name like '$t%' ", "songid", "songid" );
	    $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }

      }

  }


$rownum++; 
$rownum++; 
$rownum++; 

$colnum=0;
$fields = array( "", "Instrument" );

foreach( $quarterstorun as $q )
  {
    $fields[] = formatQuarterForDisplay( $q );
  }




foreach( $fields as $fname ) {
  $sheet->write( $rownum, $colnum++, $fname, $format_bold );
}

$inst = db_query_array( "select * from primaryinstrumentations order by Name", "id", "Name" );
foreach( $inst as $t=>$name )
  {
    $rownum++;
    $colnum = 1;
    $sheet->write( $rownum, $colnum++, $name );

    foreach( $quarterstorun as $q )
      {
	$qspl = explode( "/", $q );
	$songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
	$numsongs = count( $songs );
	// we need to add this in case there were none
	$songs[] = -1;
	
	$songidstr = implode( ", ", $songs );
	$total = 0;
	$numforthis = db_query_first_cell( "select count(*) from song_to_primaryinstrumentation where songid in ( $songidstr ) and primaryinstrumentationid = '$t'  and type = 'Main'" );
	
	$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
	$sheet->write( $rownum, $colnum++, $numforthis/100, $percentformat);

	if( $addnote )
	  {
	    $songs = db_query_array( "select songid from song_to_primaryinstrumentation where songid in ( $songidstr ) and primaryinstrumentationid = '$t'  and type = 'Main'", "songid", "songid" );
	    $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }
      }

  }
