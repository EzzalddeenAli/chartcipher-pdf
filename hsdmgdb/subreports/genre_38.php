<? // | SUB-GENRE & INFLUENCER FUSION              

$q = array_pop( $quarterstorun );
$qspl = explode( "/", $q );
$thisqsongs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1], "", "", "", true );

$primarygenres = db_query_array( "select * from genres order by OrderBy , Name", "id", "Name" );

foreach( $thisqsongs as $songid )
  {
    $infl = db_query_array( "select retroinfluenceid from song_to_retroinfluence where songid = $songid", "retroinfluenceid", "retroinfluenceid" );
    $srow = getSongRow( $songid );
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, "Song Title:", $format_bold );
    $sheet->write( $rownum, $colnum++, getSongname( $srow[songnameid] ) );
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, "Primary Genre:", $format_bold );
    $sheet->write( $rownum, $colnum++, $primarygenres[ $srow[GenreID]] );


    $subgenres = implode( ", ", db_query_array( "select Name from song_to_subgenre sts, subgenres s where songid = $songid and sts.subgenreid = s.id and sts.type = 'Main' order by OrderBy", "Name", "Name" ) );
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, "Sub-Genres & Influencers:", $format_bold );
    $sheet->write( $rownum, $colnum++, $subgenres );

    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, "Mix Type:" , $format_bold);
    $sheet->write( $rownum, $colnum++, $srow[GenreFusionType] );

    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, "Composition:", $format_bold );
    $sheet->write( $rownum, $colnum++, convertBadChars( $srow[SubgenreFusionTypeDescription] ) );
    file_put_contents( "/tmp/comp", $srow[SubgenreFusionTypeDescription] . "\n", FILE_APPEND );    
    file_put_contents( "/tmp/comp", convertBadChars( $srow[SubgenreFusionTypeDescription] ) . "\n", FILE_APPEND );    
    $rownum++;
  }			  
?>