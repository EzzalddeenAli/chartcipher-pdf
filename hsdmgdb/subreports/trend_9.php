<? //                  | FIRST SECTION BEING A CHORUS (Before Or After Intro)           | 

$fields[] = "% of songs";


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
    if( !$numsongs  ) $numsongs = 1;
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );

    $sql = ( "select count(*) from songs where id in ( $songidstr ) and ( FirstSection = " . CHORUS1 . " or ( FirstSection = " . INTRO . " and id in ( select songid from song_to_songsection where songsectionid = " . CHORUS1 . " and sectioncount = 2 ) ) )" ) ;
    logquery( $sql );

    $numforthis = db_query_first_cell( "$sql" ) ;
    $sheet->write( $rownum, $colnum++, $numforthis / $numsongs, $percentformat );

	if( $addnote )
	  {
	    $songs = db_query_array( "select id from songs where id in ( $songidstr ) and ( FirstSection = " . CHORUS1 . " or ( FirstSection = " . INTRO . " and id in ( select songid from song_to_songsection where songsectionid = " . CHORUS1 . " and sectioncount = 2 ) ) )" ) ;
	    $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }

  }



?>