<? // | PRIMARY GENRE CHART PERFORMANCE            

$primarygenres = db_query_rows( "select * from genres order by OrderBy , Name" );
$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $sdateq, $sdatey, $edateq, $edatey );

// really don't know about this one rachel
$allsongsatnum1before = getSongIdsWithinQuarter( $newarrivalsonly, 1, 2000, $sdateq, $sdatey, 1 );
$allsongsatnum1before[] = -1;

$allsongstocheck = array_intersect( $allsongs, $allsongsatnum1before );

$allsongrows = db_query_rows( "select * from songs where id in ( " . implode( ", ", $allsongstocheck ) . " )" );

reportlog( implode( ", ", $allsongstocheck ) );
foreach( $primarygenres as $prow )
  {
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $prow[Name], $format_bold );


    foreach( $allsongrows as $srow )
      {
	reportlog( "$srow[id],  $srow[GenreID]" );
	if( $srow[GenreID] != $prow[id] ) continue;
	writeSongArtistRow( $sheet, $srow );
      }

    
    $rownum++;
    $rownum++;
  }


?>