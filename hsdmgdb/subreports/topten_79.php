<? 

// | 79 | Energy                      |

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
// breakdown
$sectiontype = "";
chorusTypeReportSection( $sectiontype, $thesesongs, $thesesongids, 3  );

    $rownum++; $colnum = 0;
// high impact
$sectiontype = "";
chorusTypeReportSection( $sectiontype, $thesesongs, $thesesongids, 4  );



?>