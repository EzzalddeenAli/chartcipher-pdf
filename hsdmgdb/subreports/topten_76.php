<? 

// | 76 | Tempo                       |

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

// tempo has to stay the same because it's crazy
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Tempo", $format_bold );
$rownum++; $colnum = 0;

$colheaders = array();
foreach( $thesesongs as $songrow )
{
    $poss = calculateTempoString( $songrow );
    if( $poss )
    {
        $tempodiv = floor( $songrow[Tempo] / 10 );
        $colheaders[str_pad( $tempodiv, 10, "0", STR_PAD_LEFT)] = $poss;
    }
}

ksort( $colheaders );
$colheaders = array_values( $colheaders );

$sheet->write( $rownum, $colnum++, "Song", $format_bold );
foreach( $colheaders as $c )
{
    $sheet->write( $rownum, $colnum++, $c, $format_bold );
}

$totals = array();
foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );

    $poss = calculateTempoString( $songrow );
    foreach( $colheaders as $colid=>$c )
    {
        $val = 0;
        if( $poss == $c )
        {
            $val = 1;
            if( !isset( $totals[$colid] ) ) $totals[$colid] = 0;
            $totals[$colid]++;
        }
        $sheet->write( $rownum, $colnum++, $val );
        
    }
    
}

genreReportWriteTotals( $totals, $numsongs, true );

// start tempo actual 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Tempo - Actual", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Tempo", $format_bold );

foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $sheet->write( $rownum, $colnum++, $songrow[Tempo] );
}
// end tempo actual
$rownum++; $colnum = 0;


?>