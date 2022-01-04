<? // | SUB GENRE AND INFLUENCER CHART             


$q = array_pop( $quarterstorun );
$qspl = explode( "/", $q );
$thisqsongs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
// figure this out
$previousq = getPreviousQuarter( $q );
$qspl = explode( "/", $previousq );
$prevqsongs = getSongIdsWithinQuarter( false, $qspl[0], $qspl[1] );
$prevnumtotal = count( $prevqsongs )?count( $prevqsongs ):1;
$thisnumtotal = count( $thisqsongs )?count( $thisqsongs ):1;

$prevqsongs[] = -1;
$thisqsongs[] = -1;
$prevqstr = implode( ", ", $prevqsongs );
$thisqstr = implode( ", ", $thisqsongs );



$subgenres = db_query_rows( "select * from subgenres order by OrderBy , Name" );

// header row
$sheet->write( $rownum, $colnum++, "Sub-Genre", $format_bold  );
$sheet->write( $rownum, $colnum++,  $previousq, $format_bold  );
$sheet->write( $rownum, $colnum++,  $q, $format_bold  );

$gainers = array();
$losers = array();
$constants = array();

// now loop through genres
foreach( $subgenres as $p )
  {
  
  $thisarrsong = db_query_array( "select songid from song_to_subgenre where songid in ( $thisqstr ) and subgenreid = $p[id] and type = 'Main'", "songid", "songid" );

    $thisnum = count( $thisarrsong );
    $prevarrsong = db_query_array( "select songid from song_to_subgenre where songid in ( $prevqstr ) and subgenreid = $p[id] and type = 'Main'", "songid", "songid" );
    $prevnum = count( $prevarrsong );

    $thisarr = array( $p[Name], number_format( $thisnum / $thisnumtotal * 100 ), number_format( $prevnum / $prevnumtotal * 100 ), $prevarrsong, $thisarrsong );
    
    if( !$thisnum && !$prevnum )
      continue;

    if( $thisarr[1] == $thisarr[2] )
      $constants[] = $thisarr;
    
    if( $thisarr[1] < $thisarr[2] )
      $losers[] = $thisarr;
    
    if( $thisarr[1] > $thisarr[2] )
      $gainers[] = $thisarr;
    
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $p[Name]  );
    $sheet->write( $rownum, $colnum++, $thisarr[2]/100, $percentformat );
    if( $addnote )
    {
        $sheet->writeNote( $rownum, $colnum-1, getSongNames($prevarrsong)  );
    }
    $sheet->write( $rownum, $colnum++, $thisarr[1]/100, $percentformat );
    if( $addnote )
    {
        $sheet->writeNote( $rownum, $colnum-1, getSongNames($thisarrsong)  );
    }

  }

$rownum++;
$rownum++;
$rownum++;
$colnum = 0;
$sheet->write( $rownum, $colnum++, "On the Rise"  );
$rownum++;
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Genre"  );
$sheet->write( $rownum, $colnum++, "Previous " . $str_quarter  );
$sheet->write( $rownum, $colnum++, "Current " . $str_quarter  );

foreach( $gainers as $g )
  {
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $g[0]  );
    $sheet->write( $rownum, $colnum++, $g[2]/100, $percentformat );
    if( $addnote )
    {
        $sheet->writeNote( $rownum, $colnum-1, getSongNames($g[3])  );
    }
    $sheet->write( $rownum, $colnum++, $g[1]/100, $percentformat );
    if( $addnote )
    {
        $sheet->writeNote( $rownum, $colnum-1, getSongNames($g[4])  );
    }
  }

$rownum++;
$rownum++;
$colnum = 0;
$sheet->write( $rownum, $colnum++, "In Decline"  );
$rownum++;
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Genre"  );
$sheet->write( $rownum, $colnum++, "Previous " . $str_quarter  );
$sheet->write( $rownum, $colnum++, "Current " . $str_quarter  );

foreach( $losers as $g )
  {
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $g[0]  );
    $sheet->write( $rownum, $colnum++, $g[2]/100, $percentformat );
    if( $addnote )
    {
        $sheet->writeNote( $rownum, $colnum-1, getSongNames($g[3])  );
    }
    $sheet->write( $rownum, $colnum++, $g[1]/100, $percentformat );
    if( $addnote )
    {
        $sheet->writeNote( $rownum, $colnum-1, getSongNames($g[4])  );
    }
  }

$rownum++;
$rownum++;
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Constants"  );
$rownum++;
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Genre"  );
$sheet->write( $rownum, $colnum++, "Previous " . $str_quarter  );
$sheet->write( $rownum, $colnum++, "Current " . $str_quarter  );

foreach( $constants as $g )
  {
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $g[0]  );
    $sheet->write( $rownum, $colnum++, $g[2]/100, $percentformat );
    if( $addnote )
    {
        $sheet->writeNote( $rownum, $colnum-1, getSongNames($g[3])  );
    }
    $sheet->write( $rownum, $colnum++, $g[1]/100, $percentformat );
    if( $addnote )
    {
        $sheet->writeNote( $rownum, $colnum-1, getSongNames($g[4])  );
    }
  }



?>