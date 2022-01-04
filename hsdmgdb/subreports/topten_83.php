<? 

// | 83 | Section Start Points                       |

$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $sdateq, $sdatey, $edateq, $edatey );
$numsongs = count( $allsongs );
if( !$numsongs ) $numsongs = 1;
$allsongstr = implode( ",", $allsongs );

$thesesongs = db_query_rows( "select songnames.Name as SongName, songs.* from songs, songnames where songnameid = songnames.id and songs.id in ( $allsongstr ) order by SongName", "id" );
$thesesongids = array_keys( $thesesongs );
$numsongs = count( $thesesongs );
$thesesongids[] = -1;
$allsongsstr = implode( ", ", $thesesongids );
// END STARTING STUFF

// tempo has to stay the same because it's crazy
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Section Starting Points", $format_bold );
$rownum++; $colnum = 0;

$colheaders = array();
$colheaders = db_query_array( "select distinct( songsectionid ), Name from song_to_songsection, songsections where songsectionid = songsections.id and songid in ( $allsongsstr ) order by songsections.OrderBy desc ","songsectionid", "Name" );

$sheet->write( $rownum, $colnum++, "Song", $format_bold );
foreach( $colheaders as $c )
{
    $sheet->write( $rownum, $colnum++, $c, $format_bold );
}

$totals = array();
foreach( $thesesongs as $songrow )
{

	$times = db_query_array( "select time_to_sec( starttime ) as starttime, songsectionid from song_to_songsection where songid = $songrow[id]", "songsectionid", "starttime" );
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    foreach( $colheaders as $key=>$throwaway )
    {
        if( isset( $times[$key] ) )
        {
            $sheet->write( $rownum, $colnum++, excelSeconds( $times[$key] ), $timeformat );
        }
        else
        {
            $sheet->write( $rownum, $colnum++, "" );
        }
    }

}


?>