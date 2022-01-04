<? 

// | 80 | Total Section Breakdown     |

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


// DO TOTAL SECTION BREAKDOWN
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Total Section Breakdown", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$tmpsections = db_query_array( "select WithoutNumber from songsections order by OrderBy desc", "WithoutNumber", "WithoutNumber" );
foreach( $tmpsections as $s )
{
    $sheet->write( $rownum, $colnum++, $s, $format_bold );
}


foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    foreach( $tmpsections as $s )
    {
        $sval = db_query_first_cell( "select sum( sectionpercent ) from song_to_songsection where WithoutNumberHard = '$s' and songid = '$songrow[id]'" );
        $sval = ( $sval / 100  );
        $sheet->write( $rownum, $colnum++, $sval, $percentformat );
    }
}
// end total section breakdown


?>