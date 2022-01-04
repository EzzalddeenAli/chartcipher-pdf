<? 
// Vocal Break                 |



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
$sheet->write( $rownum, $colnum++, "Percentage of songs with a VOCAL BREAK" );
$perc = db_query_first_cell( "select count( distinct( songid ) ) from song_to_songsection where WithoutNumberHard = 'Vocal Break' and songid in ( $allsongstr ) " );
    $sheet->write( $rownum, $colnum++, $perc / $numsongs, $percentformat);
    $rownum++; $colnum = 0;

$sectiontype = "Vocal Break";
$sectiontypeplural = "Vocal Breaks";
genreReportSection( $sectiontype, $sectiontypeplural, $thesesongs, $thesesongids, true  );

// new fields here too

    $rownum++; $colnum = 0;
postChorusReportSection( $sectiontype, $thesesongs, $thesesongids  );
?>
