<? // | BALANCE OF POWER CHART                     
$q = array_pop( $quarterstorun );
$qspl = explode( "/", $q );
$thisqsongs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
// figure this out
$previousq = getPreviousQuarter( $q );
$qspl = explode( "/", $previousq );
$prevqsongs = getSongIdsWithinQuarter( false, $qspl[0], $qspl[1] );

$songoverlap = array_intersect( $thisqsongs, $prevqsongs );
$songoverlap[] = -1;

$songoverlap = implode( ",", $songoverlap );

$primarygenres = db_query_rows( "select * from genres order by OrderBy , Name" );

// header row
$sheet->write( $rownum, $colnum++, "Primary Genre", $format_bold  );
$sheet->write( $rownum, $colnum++,  $q. " New Songs", $format_bold  );
$sheet->write( $rownum, $colnum++,  $previousq. "-". $q . " Carryovers", $format_bold  );
$sheet->write( $rownum, $colnum++,  $previousq. " Decharted Hits", $format_bold  );
$sheet->write( $rownum, $colnum++, "Balance Of Power Shift", $format_bold  );

$tmpqarr = getQuartersForString( $q );

$qstr = "( " . implode( ", ", $tmpqarr ) . " )";

$toshow = array();
foreach( $prevqsongs as $sid )
  {
    if( !in_array( $sid, $thisqsongs ) )
      {
	$toshow[] = $sid;
      }
  }
$toshow[] = -1;
$dechartedstr = implode( ", " , $toshow ); 



// now loop through genres
foreach( $primarygenres as $p )
  {
    $carryoversongs = db_query_array( "select id from songs where GenreID = $p[id] and id in ( $songoverlap ) ", "id", "id" );
    $newsongs = db_query_array( "select id from songs where GenreID = $p[id] and QuarterEnteredTheTop10 in $qstr", "id", "id" );
    reportlog(  "select id from songs where GenreID = $p[id] and QuarterEnteredTheTop10 in $qstr" );
    $dechartedsongs = db_query_array( "select id from songs where GenreID = $p[id] and id in ( $dechartedstr ) ", "id", "id" );

    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $p[Name]  );
    $sheet->write( $rownum, $colnum++, count( $newsongs )  );
    if( $addnote )
        $sheet->writeNote( $rownum, $colnum-1, getSongNames( $newsongs )  );

    $sheet->write( $rownum, $colnum++, count( $carryoversongs )  );
    if( $addnote )
        $sheet->writeNote( $rownum, $colnum-1, getSongNames( $carryoversongs )  );
    $sheet->write( $rownum, $colnum++, count( $dechartedsongs )  );
    if( $addnote )
        $sheet->writeNote( $rownum, $colnum-1, getSongNames( $dechartedsongs )  );
    $sheet->write( $rownum, $colnum++, count( $newsongs ) - count( $dechartedsongs )  );

    

  }


?>