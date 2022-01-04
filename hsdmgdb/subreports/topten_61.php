<? 
// Instrumental Break          |


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
$sheet->write( $rownum, $colnum++, "Percentage of songs with an INSTRUMENTAL BREAK" );
$perc = db_query_first_cell( "select count( distinct( songid ) ) from song_to_songsection where WithoutNumberHard = 'Inst Break' and songid in ( $allsongstr ) " );
    $sheet->write( $rownum, $colnum++, $perc / $numsongs, $percentformat);

    $rownum++; $colnum = 0;


$sectiontype = "Inst Break";
$sectiontypeplural = "Inst Breaks";
genreReportSection( $sectiontype, $sectiontypeplural, $thesesongs, $thesesongids, true  );

// begin dominant instrument

$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Instrumental Break Dominant Instrument", $format_bold );
$rownum++; $colnum = 0;

$numsongs = 0;
$colheaders = array();
$insttypes = db_query_first_cell( "select group_concat( id ) from songsections where WithoutNumber = 'Inst Break'" );
$colheaders = db_query_array( "select instruments.id, instruments.Name from song_to_instrument, instruments  where songid in ( " . implode( ", " , $thesesongids ) . " ) and instrumentid = instruments.id and type in ( $insttypes ) order by OrderBy, Name", "id", "Name" );

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
addArtistGenreTitles();
foreach( $colheaders as $c )
{
    $sheet->write( $rownum, $colnum++, $c, $format_bold );
}
    
    $totals = array( "" );
    foreach( $thesesongs as $songrow )
    {
        $poss = $songrow[$currcolname];
        $vals = db_query_array( "select instrumentid from song_to_instrument where songid = $songrow[id] and type in ( $insttypes )", "instrumentid", "instrumentid" );
        if( !count( $vals) ) continue;
        $numsongs++;
        $rownum++;
        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $songrow[SongName] );
        addArtistGenre( $songrow );

        $counter = 0;
        foreach( $colheaders as $colid=>$c )
        {
            $val = 0;
//            logquery( "checking for $colid among " . print_r( $vals, true ) );
            if( $vals[$colid] )
            {
//                logquery( "got one!" );
                $val = 1;
                if( !isset( $totals[$counter] ) ) $totals[$counter] = 0;
                $totals[$counter]++;
            }
            $sheet->write( $rownum, $colnum++, $val );
            $counter++;
        }
    }
    
genreReportWriteTotals( $totals, $numsongs );




$rownum++; $colnum = 0;
postChorusReportSection( $sectiontype, $thesesongs, $thesesongids  );



?>