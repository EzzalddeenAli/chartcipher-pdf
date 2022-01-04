<? 

// | 77 | Form                        |

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

// start form 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Form/Structure", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Abbreviated Form", $format_bold );
$sheet->write( $rownum, $colnum++, "Full Form", $format_bold );

foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $sheet->write( $rownum, $colnum++, $songrow[AbbrevSongStructure] );
    $sheet->write( $rownum, $colnum++, $songrow[SongStructure] );
}
// start form end form
$rownum++; $colnum = 0;


?>