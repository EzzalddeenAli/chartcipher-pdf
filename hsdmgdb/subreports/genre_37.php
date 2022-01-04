<? // | RETRO SPOTLIGHT                            

$q = array_pop( $quarterstorun );
$qspl = explode( "/", $q );
$thisqsongs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );

$retroinfluences = db_query_rows( "select * from subgenres where category = 'Retro' and HideFromAdvancedSearch = 0 order by OrderBy , Name" );

// header row
$sheet->write( $rownum, $colnum++, "Retro Type", $format_bold  );
foreach( $retroinfluences as $r )
  {
    $sheet->write( $rownum, $colnum++, $r["Name"], $format_bold  );
  }


foreach( $thisqsongs as $songid )
  {
    $rownum++;
    $colnum = 0;
    $infl = db_query_array( "select subgenreid from song_to_subgenre where songid = $songid", "subgenreid", "subgenreid" );
    $srow = getSongRow( $songid );
    $sheet->write( $rownum, $colnum++, getSongname( $srow[songnameid] ) );
    
    foreach( $retroinfluences as $r )
      {
	$sheet->write( $rownum, $colnum++, isset( $infl[$r[id]] )?1:0 );
      }
    
  }

?>