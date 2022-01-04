<? 

// | 73 | Song Title                  |

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

$sectiontitle = "Song Title Words Count";
$currcolname = "SongTitleWordCount";
$orderbycolname = "SongTitleWordCount";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids, true, " Word(s)");


$sectiontitle = "Song Title Appearances";
$currcolname = "SongTitleAppearanceRange";
$orderbycolname = "SongTitleAppearances";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );



// start SongTitleAppearances actual 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Song Title Appearances - Actual", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Song Title Appearances", $format_bold );

foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $sheet->write( $rownum, $colnum++, $songrow[SongTitleAppearances] );
}
// end song title appearances actual
$rownum++; $colnum = 0;



$sectiontitle = "Song Title Placements";
$thistype = "placement";
genreReportSongMulti( $sectiontitle, $thistype, $thesesongs, $thesesongids );


?>