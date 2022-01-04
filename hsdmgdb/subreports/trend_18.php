<? //                 | Percentage Of Songs That Contain A Prominent IB or VB          | 

$fields[] = "Inst. Break";
$fields[] = "Vocal Break";


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
    $numsongs = count($songs);
    if( !$numsongs ) $numsongs = 1;
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );

    $numforthis = db_query_first_cell( "select count( distinct( songid ) )  from song_to_songsection where songid in ( $songidstr ) and songsectionid in ( 7 )"  );
    $sheet->write( $rownum, $colnum++, $numforthis / $numsongs, $percentformat );

    if( $addnote )
      {
	$songs = db_query_array( "select songid from song_to_songsection where songid in ( $songidstr ) and songsectionid in ( 7 )"  , "songid", "songid" );
	$sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
      }

    $numforthis = db_query_first_cell( "select count( distinct( songid ) )  from song_to_songsection where songid in ( $songidstr ) and songsectionid in ( 8 )"  );
    //    logquery( "select count( distinct( songid ) )  from song_to_songsection where songid in ( $songidstr ) and songsectionid in ( 7, 8 )"  );
    $sheet->write( $rownum, $colnum++, $numforthis / $numsongs, $percentformat );

    if( $addnote )
      {
	$songs = db_query_array( "select songid from song_to_songsection where songid in ( $songidstr ) and songsectionid in ( 8 )"  , "songid", "songid" );
	$sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
      }

  }



?>