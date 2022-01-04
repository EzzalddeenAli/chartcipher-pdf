<? 

// | 75 | Vocals                      |

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

$sectiontitle = "Vocals";
$currcolname = "VocalsGender";
$orderbycolname = "VocalsGender";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );


genreReportSongColumnOtherTable( "Lead Vocals", "vocal", "OrderBy", $thesesongs, $thesesongids );

genreReportSongColumnOtherTable( "Lead Vocal Types", "vocaltype", "OrderBy", $thesesongs, $thesesongids );

genreReportSongColumnOtherTable( "Background Vocals", "backvocal", "OrderBy", $thesesongs, $thesesongids );

genreReportSongColumnOtherTable( "Background Vocal Types", "backvocaltype", "OrderBy", $thesesongs, $thesesongids );


?>