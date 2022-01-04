<? 
// Post Chorus                 |


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
$sheet->write( $rownum, $colnum++, "Post-Chorus Type", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
addArtistGenreTitles();
$sheet->write( $rownum, $colnum++, "Section", $format_bold );
$colheaders = db_query_array( "select postchorustypes.id, postchorustypes.Name from song_to_postchorustype, postchorustypes  where songid in ( " . implode( ", " , $thesesongids ) . " ) and postchorustypeid = postchorustypes.id order by OrderBy, Name", "id", "Name" );

foreach( $colheaders as $c )
    {
        $sheet->write( $rownum, $colnum++, $c, $format_bold );
    }

foreach( $thesesongs as $songrow )
    {
        $sections = db_query_array( "select ss.Name, ss.id from song_to_songsection sts, songsections ss where sts.songsectionid = ss.id and songid = $songrow[id] and PostChorus = 1 order by starttime", "id", "Name" );
        if( count( $sections ) )
            $numsongs++;

        foreach( $sections as $sectionid => $sectionname )
        {
            $vals = db_query_array( "select postchorustypeid from song_to_postchorustype where songid = $songrow[id] and type = $sectionid ", "postchorustypeid", "postchorustypeid" );
            $rownum++;
            $colnum = 0;
            $sheet->write( $rownum, $colnum++, $songrow[SongName] );
            addArtistGenre( $songrow );
            $sheet->write( $rownum, $colnum++, $sectionname );

            $counter = 0;
            foreach( $colheaders as $colid=>$c )
            {
                $val = 0;
                if( $vals[$colid] )
                {
                    $val = 1;
                    if( !isset( $totals[$counter] ) ) $totals[$counter] = 0;
                $totals[$counter]++;
                }
                $sheet->write( $rownum, $colnum++, $val );
                $counter++;
            }
        }
    }
        


$rownum++; $colnum = 0;
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Post-Chorus Section", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
addArtistGenreTitles();
$colheaders = db_query_array( "select ss.Name, ss.id from song_to_songsection sts, songsections ss where sts.songsectionid = ss.id and songid in ( " . implode( ", " , $thesesongids ) . " ) and PostChorus = 1 order by OrderBy desc", "id", "Name" );

foreach( $colheaders as $c )
    {
        $sheet->write( $rownum, $colnum++, $c, $format_bold );
    }

foreach( $thesesongs as $songrow )
    {
        $vals = db_query_array( "select ss.Name, ss.id from song_to_songsection sts, songsections ss where sts.songsectionid = ss.id and songid = $songrow[id] and PostChorus = 1 order by starttime", "id", "id" );
        if( !count( $vals ) )
            continue;
        $numsongs++;

        $rownum++;
        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $songrow[SongName] );
        addArtistGenre($songrow);
        
        $counter = 0;
        foreach( $colheaders as $colid=>$c )
        {
            $val = 0;
            if( $vals[$colid] )
            {
                $val = 1;
                if( !isset( $totals[$counter] ) ) $totals[$counter] = 0;
                $totals[$counter]++;
            }
            $sheet->write( $rownum, $colnum++, $val );
            $counter++;
        }
    }

?>