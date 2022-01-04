<? 
// First Section Type          |



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
$sectiontitle = "First Section Type";
$currcolname = "FirstSection";
$orderbycolname = "FirstSection";
$displayinstead = db_query_array( "select ID, WithoutNumber from songsections", "ID", "WithoutNumber" );
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );
$displayinstead = array();


?>