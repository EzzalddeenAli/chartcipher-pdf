<? 
//Songs and Charting          

$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $sdateq, $sdatey, $edateq, $edatey );
$numsongs = count( $allsongs );
if( !$numsongs ) $numsongs = 1;
$allsongstr = implode( ",", $allsongs );

list( $startdate, $enddate ) = getQuarterTimes( $sdateq, $sdatey );

if( $edateq )
{
list( $throwaway, $enddate ) = getQuarterTimes( $edateq, $edatey );
}

$thesesongs = db_query_rows( "select songnames.Name as SongName, songs.* from songs, songnames where songnameid = songnames.id and songs.id in ( $allsongstr ) order by SongName", "id" );
$thesesongids = array_keys( $thesesongs );
$numsongs = count( $thesesongs );
$thesesongids[] = -1;

// END STARTING STUFF


$primarygenres = db_query_rows( "select * from genres order by OrderBy , Name", "id" ); 
foreach( $primarygenres as $pid=> $prow )
{
    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "$prow[Name]", $format_bold );
    foreach( $thesesongs as $s )
    {
        if( $s[GenreID] == $pid )
        {
            $rownum++; $colnum = 0;
            $sheet->write( $rownum, $colnum++, "$s[SongName]" );
            addArtistGenre($s);
        }
    }
    
        $rownum++; $colnum = 0;
    
}

$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Song Name", $format_bold );
addArtistGenreTitles();
$sheet->write( $rownum, $colnum++, "Total Weeks On Chart", $format_bold );
foreach( $thesesongs as $songrow )
{
    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    addArtistGenre( $songrow );
    $tot = db_query_first_cell( "select count(*) from song_to_weekdate stw, weekdates w where w.id = stw.weekdateid and songid = '$songrow[id]' and OrderBy >= '$startdate' and OrderBy < '$enddate' " );
    $sheet->write( $rownum, $colnum++, $tot );
    
}

?>