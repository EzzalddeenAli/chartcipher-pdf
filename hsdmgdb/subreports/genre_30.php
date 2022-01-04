<? // | PRIMARY GENRES & SONGS                     

$primarygenres = db_query_rows( "select * from genres order by OrderBy , Name" );
$allsongrows = db_query_rows( "select * from songs where id in ( " . implode( ", ", $allsongs ) . " )" );

foreach( $primarygenres as $prow )
  {
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $prow[Name], $format_bold );


    foreach( $allsongrows as $srow )
      {
          if( $srow[GenreID] != $prow[id] ) continue;
          writeSongArtistRow( $sheet, $srow );
      }

    
    $rownum++;
    $rownum++;
  }


?>