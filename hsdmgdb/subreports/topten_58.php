<? 
// Chorus                      |



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

$sectiontype = "Chorus";
$sectiontypeplural = "Choruses";
genreReportSection( $sectiontype, $sectiontypeplural, $thesesongs, $thesesongids  );

$sectiontitle = "First Chorus Occurance - Range";
$currcolname = "FirstChorusRange";
$orderbycolname = "case when FirstChorusRange = 'Kickoff' then 0 else FirstChorusRange end";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );

// start first chorus occurence actual 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "First Chorus Occurrence - Actual", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Genre", $format_bold );
$sheet->write( $rownum, $colnum++, "First Chorus Time", $format_bold );

foreach( $thesesongs as $songrow )
{
    $exists = db_query_first_cell( "select songsectionid from song_to_songsection where WithoutNumberHard = 'Chorus'  and songid = '$songrow[id]'" );
    if( !$exists )
        continue;
    $val = db_query_first_cell( "select min( time_to_sec( starttime ) ) from song_to_songsection where WithoutNumberHard = 'Chorus' and songid = '$songrow[id]'" );

    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $sheet->write( $rownum, $colnum++, getTableValue( $songrow[GenreID], "genres" ) );
    $sheet->write( $rownum, $colnum++, excelSeconds( $val ), $timeformat );
}
// end first chorus occurence actual

$rownum++; $colnum = 0;
$rownum++; $colnum = 0;

// need to add here rachel
stanzasReportSection( $sectiontype, $thesesongs, $thesesongids  );

$rownum++; $colnum = 0;
// breakdown
$sectiontype = "Chorus";
chorusTypeReportSection( $sectiontype, $thesesongs, $thesesongids, 3  );

$rownum++; $colnum = 0;
// high impact
chorusTypeReportSection( $sectiontype, $thesesongs, $thesesongids, 4  );

?>