<? 
// Outro                       |



$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $sdateq, $sdatey, $edateq, $edatey );
$numsongs = count( $allsongs );
if( !$numsongs ) $numsongs = 1;
$allsongstr = implode( ",", $allsongs );

list( $startdate, $enddate ) = getQuarterTimes( $sdateq, $sdatey );


$thesesongs = db_query_rows( "select songnames.Name as SongName, songs.* from songs, songnames where songnameid = songnames.id and songs.id in ( $allsongstr ) order by SongName", "id" );
$thesesongids = array_keys( $thesesongs );
$numsongs = count( $thesesongs );
$thesesongids[] = -1;

// END STARTING STUFF

$sectiontitle = "Outro Length Range";
$currcolname = "OutroLengthRangeNums";
$orderbycolname = "OutroLengthRangeNums";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );

// start outro length actual 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Outro Length - Actual", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
    addArtistGenreTitles();
$sheet->write( $rownum, $colnum++, "Outro Length", $format_bold );

foreach( $thesesongs as $songrow )
{
    $exists = db_query_first_cell( "select songsectionid from song_to_songsection where WithoutNumberHard = 'Outro' and songid = '$songrow[id]'" );
    if( !$exists )
        continue;
    $val = db_query_first_cell( "select time_to_sec( length ) from song_to_songsection where WithoutNumberHard = 'Outro' and songid = '$songrow[id]'" );

    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    addArtistGenre($songrow);
    $sheet->write( $rownum, $colnum++, excelSeconds( $val ), $timeformat );
}
// end outro length actual

// start outro length actual - bars 
$rownum++; $colnum = 0;
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Outro Length - Actual - Bars", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
    addArtistGenreTitles();
$sheet->write( $rownum, $colnum++, "Outro Length", $format_bold );

foreach( $thesesongs as $songrow )
{
    $exists = db_query_first_cell( "select songsectionid from song_to_songsection where WithoutNumberHard = 'Outro' and songid = '$songrow[id]'" );
    if( !$exists )
        continue;
    $val = db_query_first_cell( "select Bars from song_to_songsection where WithoutNumberHard = 'Outro' and songid = '$songrow[id]'" );

    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    addArtistGenre($songrow);
    $sheet->write( $rownum, $colnum++, $val );
}
// end outro length actual - bars

// new field here rachel

$rownum++; $colnum = 0;
$rownum++; $colnum = 0;


$sectiontitle = "Outro Type";
$tablename = "outrotype";
$orderbycolname = "id";
genreReportSongColumnOtherTable( $sectiontitle, $tablename, $orderbycolname, $thesesongs, $thesesongids );


$sectiontitle = "Outro Recycled Sections";
$currcolname = "RecycledSections";
$orderbycolname = "RecycledSections";
genreReportSongColumnSet( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );

$sectiontitle = "Outro Recycled Vs New Material";
$currcolname = "OutroRecycled";
$orderbycolname = "OutroRecycled";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );


?>