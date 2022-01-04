<? 

// | 70 | Key                         |

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

    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "Key", $format_bold );
    $rownum++; $colnum = 0;

    $colheaders = array();
    $colheaders = db_query_array( "select songkeys.id, songkeys.Name from songs, songkeys  where songs.id in ( " . implode( ", " , $thesesongids ) . " ) and songkeyid = songkeys.id order by OrderBy, Name", "id", "Name" );

    $sheet->write( $rownum, $colnum++, "Song title", $format_bold );
    addArtistGenreTitles();
    $sheet->write( $rownum, $colnum++, "Key", $format_bold );
    $sheet->write( $rownum, $colnum++, "Major/Minor", $format_bold );

    
    $totals = array( "" );
    foreach( $thesesongs as $songrow )
    {
        $rownum++;
        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $songrow[SongName] );
        addArtistGenre($songrow);
        $k = getTableValue( $songrow[songkeyid], "songkeys" );
        $sheet->write( $rownum, $colnum++, $k );
        $sheet->write( $rownum, $colnum++, $songrow[majorminor] );
        if( !isset( $keys[$k] ) ) $keys[$k] = array();
        if( !isset( $keys[$k][$songrow[majorminor]] ) ) $keys[$k][$songrow[majorminor]] = 0;
        $keys[$k][$songrow[majorminor]] ++;
        

    }
    
$rownum++;        $colnum = 0;
$rownum++;        $colnum = 0;
$sheet->write( $rownum, $colnum++, "Key", $format_bold );
$sheet->write( $rownum, $colnum++, "Major/Minor", $format_bold );
$sheet->write( $rownum, $colnum++, "Percentage", $format_bold );

foreach( $keys as $k=>$arr )
{
    foreach( $arr as $majorminor=>$count )
    {
        $rownum++;        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $k );
        $sheet->write( $rownum, $colnum++, $majorminor );
        $sheet->write( $rownum, $colnum++, $count/$numsongs, $percentformat );
        
    }
    
}

?>