<? //                 | PERCENTAGE OF SONGS THAT CONTAIN A BRIDGE                      | 

$fields = array();
$fields[] = "PERCENTAGE OF SONGS THAT CONTAIN A BRIDGE";
$fields[] = strtoupper( $str_quarter ) ;
$fields[] = "Bridge";


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
    if( !$numsongs ) $numsongs = 1;
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );

    $numforthis = db_query_first_cell( "select count( * ) from song_to_songsection where songid in ( $songidstr ) and songsectionid = " . BRIDGE1 );
    $sheet->write( $rownum, $colnum++,  $numforthis / $numsongs, $percentformat );

    if( $addnote )
      {
          $songs = db_query_array( "select songid from song_to_songsection where songid in ( $songidstr ) and songsectionid = " . BRIDGE1, "songid", "songid" );
          $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
      }
  }


$rownum++;
$colnum = 0;
$rownum++;

$fields = array();
$fields[] = "PERCENTAGE OF SONGS THAT CONTAIN A BRIDGE SURROGATE";
$fields[] = strtoupper( $str_quarter ) ;
$fields[] = "TOTAL SONGS";

$sectionids = db_query_array( "select distinct( songsectionid ), Name from song_to_songsection, songsections where songid in ( $allsongsstr ) and BridgeSurrogate = 1 and songsectionid = songsections.id", "songsectionid", "Name" );
foreach( $sectionids as $sname )
{
    $fields[] = $sname;
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
    if( !$numsongs ) $numsongs = 1;
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );

    $numforthis = db_query_first_cell( "select count( distinct( songid ) ) from song_to_songsection where songid in ( $songidstr ) and BridgeSurrogate = 1" );
    $sheet->write( $rownum, $colnum++,  $numforthis / $numsongs, $percentformat );

    if( $addnote )
      {
          $songs = db_query_array( "select distinct( songid ) from song_to_songsection where songid in ( $songidstr ) and BridgeSurrogate = 1", "songid", "songid" );
          $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
      }

    foreach( $sectionids as $sid=>$sname )
    {
        $numforthis = db_query_first_cell( "select count( distinct( songid ) ) from song_to_songsection where songid in ( $songidstr ) and BridgeSurrogate = 1 and songsectionid = $sid" );
        $sheet->write( $rownum, $colnum++,  $numforthis / $numsongs, $percentformat );
        
        if( $addnote )
        {
            $songs = db_query_array( "select distinct( songid ) from song_to_songsection where songid in ( $songidstr ) and BridgeSurrogate = 1 and songsectionid = $sid", "songid", "songid" );
            $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
        }
    }



  }


$rownum++;
$colnum = 0 ;
$rownum++;

$fields = array();
$fields[] = "PERCENTAGE OF SONGS THAT CONTAIN A BRIDGE OR BRIDGE SURROGATE (COMBINED TOTAL)";
$fields[] = strtoupper( $str_quarter ) ;
$fields[] = "TOTAL SONGS";

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
    if( !$numsongs ) $numsongs = 1;
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );

    $numforthis = db_query_first_cell( "select count( distinct( songid ) ) from song_to_songsection where songid in ( $songidstr ) and ( songsectionid = " . BRIDGE1 . " or BridgeSurrogate = 1 )" );
    $sheet->write( $rownum, $colnum++,  $numforthis / $numsongs, $percentformat );

    if( $addnote )
      {
          $songs = db_query_array( "select distinct( songid ) from song_to_songsection where songid in ( $songidstr ) and BridgeSurrogate = 1", "songid", "songid" );
          $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
      }

  }




?>