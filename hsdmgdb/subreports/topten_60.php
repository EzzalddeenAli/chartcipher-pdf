<? 
// Bridge and Bridge Surrogate |



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

// all new stuff here rachel

    $rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Percentage of songs with a BRIDGE" );
$perc = db_query_first_cell( "select count( distinct( songid ) ) from song_to_songsection where WithoutNumberHard = 'Bridge' and songid in ( $allsongstr ) " );
    $sheet->write( $rownum, $colnum++, $perc / $numsongs, $percentformat);


    $rownum++; $colnum = 0;
    $rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Percentage of songs with a BRIDGE SURROGATE" );
$perc = db_query_first_cell( "select count( distinct( songid ) ) from song_to_songsection where BridgeSurrogate = 1 and songid in ( $allsongstr ) " );
    $sheet->write( $rownum, $colnum++, $perc / $numsongs, $percentformat);
    $rownum++; $colnum = 0;
    $rownum++; $colnum = 0;

$sectiontype = "Bridge";
$sectiontypeplural = "Bridges";
genreReportSection( $sectiontype, $sectiontypeplural, $thesesongs, $thesesongids, true  );

// more new stuff here
    $rownum++; $colnum = 0;
    $rownum++; $colnum = 0;

$sections = db_query_array( "select ss.id, ss.Name from song_to_songsection sts, songsections ss where sts.songsectionid = ss.id and BridgeSurrogate = 1 and songid in ( $allsongstr )  order by ss.OrderBy desc ", "id", "Name" );

$sheet->write( $rownum, $colnum++, "Bridge Surrogate Section", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
addArtistGenreTitles();
foreach( $sections as $name )
{
    $sheet->write( $rownum, $colnum++, $name, $format_bold );
}

$totsforsection = array();
foreach( $thesesongs as $songrow )
{
    $any = db_query_first_cell( "select count( * ) from song_to_songsection where BridgeSurrogate = 1 and songid  = $songrow[id] " );
    if( !$any ) continue;
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    addArtistGenre($songrow);
    foreach( $sections as $sid=>$sname )
    {
        $exists = db_query_first_cell( "Select WithoutNumberHard from song_to_songsection where songsectionid = '$sid' and songid = '$songrow[id]' and BridgeSurrogate = 1 " );
        $sheet->write( $rownum, $colnum++, $exists?1:0 );
        if( $exists )
        {
            $totsforsection[$sid]["Num"]++;
        }
    }
    
}
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "TOTAL", $format_bold );
addArtistGenreBlank();
foreach( $sections as $sid=>$sname )
{
    $num = $totsforsection[$sid]["Num"];
    if( !$num )
    {
        $colnum++; continue;
    }
    $sheet->write( $rownum, $colnum++, $num );
}

$rownum++; $colnum = 0;


?>