<? 
// Section Length              |

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


// DO Average section length
$rownum++; $colnum = 0;
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Average Section Length", $format_bold );
$rownum++; $colnum = 0;

$tmpsections = db_query_array( "select WithoutNumber from songsections order by OrderBy desc", "WithoutNumber", "WithoutNumber" );
foreach( $tmpsections as $s )
{
    $sheet->write( $rownum, $colnum++, $s, $format_bold );
}


$rownum++;
$colnum = 0;
foreach( $tmpsections as $s )
{
    $sval = db_query_first_cell( "select avg( time_to_sec( length ) ) from song_to_songsection where WithoutNumberHard = '$s' and songid in ( " . implode( ", ", $thesesongids ). " ) " );
    $sheet->write( $rownum, $colnum++, excelSeconds( $sval ) , $timeformat );
}
// end average section length

// DO Average # bars
$rownum++; $colnum = 0;
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Average Number of Bars", $format_bold );
$rownum++; $colnum = 0;

$tmpsections = db_query_array( "select WithoutNumber from songsections order by OrderBy desc", "WithoutNumber", "WithoutNumber" );
foreach( $tmpsections as $s )
{
    $sheet->write( $rownum, $colnum++, $s, $format_bold );
}


$rownum++;
$colnum = 0;
foreach( $tmpsections as $s )
{
    $sval = db_query_first_cell( "select avg( Bars ) from song_to_songsection where WithoutNumberHard = '$s' and songid in ( " . implode( ", ", $thesesongids ). " ) " );
    $sheet->write( $rownum, $colnum++, number_format( $sval ) );
}
// end average # bars



$tmpsections = db_query_array( "select id, Name from songsections, song_to_songsection where songsectionid = songsections.id and songid  in ( " . implode( ", ", $thesesongids ). " )  order by OrderBy desc", "id", "Name" );

// DO actual length - time
$rownum++; $colnum = 0;
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Actual Length - Time", $format_bold );
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Song", $format_bold );
addArtistGenreTitles();
foreach( $tmpsections as $s )
{
    $sheet->write( $rownum, $colnum++, $s, $format_bold );
}



$tmptotals = array(); $tmpnums = array();
foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    addArtistGenre($songrow);

    foreach( $tmpsections as $s=>$throwaway )
    {
        $sval = db_query_first_cell( "select time_to_sec( length ) from song_to_songsection where songsectionid = '$s' and songid = $songrow[id] " );
        if( $sval )
        {
            $sheet->write( $rownum, $colnum++, excelSeconds( $sval ), $timeformat );
            if( !isset( $tmpnums[$s] ) )
            {
                $tmpnums[$s]=0;
                $tmptotals[$s]=0;
            }
            $tmpnums[$s]++;
            $tmptotals[$s] += $sval;
            
        }
        else
        {
            $colnum++;
        }
    }
}

$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Average", $format_bold );
addArtistGenreBlank();
foreach( $tmpsections as $s=>$throwaway )
{
    $tval = $tmptotals[$s];
    $tval = number_format( $tval / $tmpnums[$s] );
    $sheet->write( $rownum, $colnum++, excelSeconds( $tval ), $timeformat );
    
}
$rownum++; $colnum = 0;


// end actual length - time

// DO actual length - bars
$rownum++; $colnum = 0;
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Actual Length - Bars", $format_bold );
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Song", $format_bold );
addArtistGenreTitles();
foreach( $tmpsections as $s )
{
    $sheet->write( $rownum, $colnum++, $s, $format_bold );
}
$tmptotals = array(); $tmpnums = array();
foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    addArtistGenre($songrow);

    foreach( $tmpsections as $s=>$throwaway )
    {
        $sval = db_query_first_cell( "select Bars from song_to_songsection where songsectionid = '$s' and songid = $songrow[id] " );
        $sheet->write( $rownum, $colnum++, $sval);
        if( !$sval )
            continue;
        if( !isset( $tmpnums[$s] ) )
        {
            $tmpnums[$s]=0;
            $tmptotals[$s]=0;
        }
        $tmpnums[$s]++;
        $tmptotals[$s] += $sval;
    }
}
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Average", $format_bold );
addArtistGenreBlank();
foreach( $tmpsections as $s=>$throwaway )
{
    $tval = $tmptotals[$s];
    $tval = number_format( $tval / ($tmpnums[$s]?$tmpnums[$s]:1) );
    $sheet->write( $rownum, $colnum++, $tval, $format_bold );
    
}
logquery( "tmpsections:" . print_r( $tmpsections, true ) );
logquery( "totals:" . print_r( $tmptotals, true ) );
logquery( "tmpnums:" . print_r( $tmpnums, true ) );
$rownum++; $colnum = 0;
// end actual length - bars




?>