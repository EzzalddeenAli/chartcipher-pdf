<? //                 | Record Labels                                                  | 


$labels = db_query_rows( "select * from labels order by OrderBy, Name" );

foreach( $labels as $t )
  {
    $fields[] = $t[Name];
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
    foreach( $labels as $trow )
      {
	$t = $trow["id"];
	$numforthis = db_query_first_cell( "select count(*) from songs, song_to_label where songid in ( $songidstr ) and songid = songs.id and  song_to_label.labelid = '$t' " );
	
	$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
	$sheet->write( $rownum, $colnum++, $numforthis/100, $percentformat);

	if( $addnote )
	  {
	    $songs = db_query_array( "select songs.id from songs, song_to_label where songid in ( $songidstr ) and songid = songs.id and  song_to_label.labelid = '$t' " );
	    $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }

      }

  }


$rownum++;
$rownum++;
$rownum++;

$fields = array( "", "Label" );

foreach( $quarterstorun as $q )
  {
    $fields[] = formatQuarterForDisplay( $q );
  }

$colnum = 0;
foreach( $fields as $fname ) {
  $sheet->write( $rownum, $colnum++, $fname, $format_bold );
}



foreach( $labels as $trow )
  {
    $rownum++;
    $colnum = 1;
    $sheet->write( $rownum, $colnum++, $trow["Name"] );

    foreach( $quarterstorun as $q )
      {
	$qspl = explode( "/", $q );
	$songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
	$numsongs = count( $songs );
	// we need to add this in case there were none
	$songs[] = -1;
	
	$songidstr = implode( ", ", $songs );
	$total = 0;
	$t = $trow["id"];
	$numforthis = db_query_first_cell( "select count(*) from songs, song_to_label where songs.id in ( $songidstr ) and song_to_label.labelid = '$t' and songid = songs.id" );
	
	$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
	$sheet->write( $rownum, $colnum++, $numforthis/100, $percentformat);

	if( $addnote )
	  {
	    $songs = db_query_array( "select songs.id from songs, song_to_label where songs.id in ( $songidstr ) and song_to_label.labelid = '$t' and songid = songs.id" );
	    $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }
	
      }

  }


?>