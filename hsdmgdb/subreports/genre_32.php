<? // | NEW ARRIVALS / CARRYOVERS / DECHARTED HITS 

$primarygenres = db_query_rows( "select * from genres order by OrderBy , Name" );

$sheet->write( $rownum, $colnum++, "New Songs", $format_bold  );
$rownum++;
$colnum = 0;

$extsw = "";
if( $songwriterfilter )
  {
      $extsw = " and songs.id in ( select songid from song_to_artist where artistid = '$songwriterfilter' and type = 'creditedsw' )"; 
  }
  
if( $clientfilter )
  {
      $extsw .= " and songs.ClientID = $clientfilter"; 
  }
  

foreach( $primarygenres as $p )
  {
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $p[Name]  );



    $qstr = "( ";

    $tmpqarr = array( "'-1'" );
    foreach( $quarterstorun as $q )
      {
          $tmpqarr = array_merge( $tmpqarr, getQuartersForString( $q ) );
      }

    $qstr .= implode( ", ", $tmpqarr ) . " )";
    // figure this out
    $songs = db_query_rows( "select * from songs where GenreID = $p[id] and QuarterEnteredTheTop10 in $qstr $extsw" );
    
    foreach( $songs as $srow )
    {
        writeSongArtistRow( $sheet, $srow );
    }
    $rownum++;
    $colnum = 0;
  }

$rownum++;

$sheet->write( $rownum, $colnum++, "Carryovers", $format_bold  );
$rownum++;
$colnum = 0;

foreach( $primarygenres as $p )
  {
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $p[Name]  );


    $qspl = explode( "/", $q );
    $thisqsongs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
    // figure this out
    $previousq = getPreviousQuarter( $q );
    $qspl = explode( "/", $previousq );
    $prevqsongs = getSongIdsWithinQuarter( false, $qspl[0], $qspl[1] );

    $songoverlap = array_intersect( $thisqsongs, $prevqsongs );
    $songoverlap[] = -1;
    
    $songoverlap = implode( ",", $songoverlap );
    $songs = db_query_rows( "select * from songs where GenreID = $p[id] and id in ( $songoverlap ) " );
    
    foreach( $songs as $srow )
      {
          writeSongArtistRow( $sheet, $srow );
      }
    $rownum++;
    $colnum = 0;
  }


$rownum++;

$sheet->write( $rownum, $colnum++, "Decharted Hits", $format_bold  );
$rownum++;
$colnum = 0;

foreach( $primarygenres as $p )
  {
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $p[Name]  );

    $qspl = explode( "/", $q );
    $thisqsongs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
    // figure this out
    $previousq = getPreviousQuarter( $q );
    $qspl = explode( "/", $previousq );
    $prevqsongs = getSongIdsWithinQuarter( false, $qspl[0], $qspl[1] );

    /* reportlog( "this: " . print_r( $thisqsongs, true ) ); */
    /* reportlog( "decharted :" . print_r( $prevqsongs, true ) ); */


    $toshow = array();
    foreach( $prevqsongs as $sid )
      {
	if( !in_array( $sid, $thisqsongs ) )
	  {
	    $toshow[] = $sid;
	  }
      }
    $toshow[] = -1;
    $toshowstr = implode( ", " , $toshow ); 

    reportlog( "toshow:" . print_r( $toshow, true ) );
    // figure this out

    $songs = db_query_rows( "select * from songs where GenreID = $p[id] and id in ( $toshowstr ) " );
    
    foreach( $songs as $srow )
      {
	writeSongArtistRow( $sheet, $srow );
      }
    $rownum++;
    $colnum = 0;
  }



?>