<? 

// | 78 | Song Length                 |

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


$sectiontitle = "Song Length";
$currcolname = "SongLengthRange";
$orderbycolname = "SongLength";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );




// start Song Length actual 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Song Length - Actual", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Song Length", $format_bold );

foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $val = db_query_first_cell( "select time_to_sec( SongLength ) from songs where id = $songrow[id]" ) ;
    $sheet->write( $rownum, $colnum++, excelSeconds( $val ), $timeformat );
}
// end song title appearances actual
$rownum++; $colnum = 0;


?>