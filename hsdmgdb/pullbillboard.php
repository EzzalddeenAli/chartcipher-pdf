<? 
$nologin = 1;
include "connect.php";
require_once "dom/simple_html_dom.php";

 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

$baseUrl = "https://www.billboard.com/charts/";


function findSong( $t, $a ) 
{
    if( $t == "F**kin Problems" ) $t = "F**kin' Problems";

    $songid = db_query_first_cell( "select songs.id from songs where BillboardName = '" . escMe( $t ).  "' and BillboardArtistName = '" . escMe( $a ).  "'" );
    if( !$songid )
	{
	    $songid = db_query_first_cell( "select songs.id from songs, songnames where songnameid = songnames.id and Name = '" . escMe( $t ).  "' and ArtistBand = '" . escMe( $a ).  "'" );
	    if( !$songid )
		$songid = db_query_first_cell( "select songs.id from songs, songnames where songnameid = songnames.id and Name = '" . escMe( $t ).  "'" );
	}
    return $songid;
}

db_query( "update billboardinfo set artist = replace( artist, '&#039;', '\'' ) where artist like '%&#039;%'" );
db_query( "update billboardinfo set title = replace( title, '&#039;', '\'' ) where title like '%&#039;%'" );

$allcharts = db_query_array( "select * from charts order by chartname", "chartkey", "chartname" );

if( $create )
    {
	$already = array();
	foreach( array( "hot-100"=>"2013-01-01", "pop-songs"=>"2015-01-01" ) as $chart => $earliestdate)
	    {
		$missingrows = db_query_rows( "select * from billboardinfo where chart = '$chart' and rank <= 10 and songid = 0 and thedate >= '$earliestdate'" );
		foreach( $missingrows as $m )
		    {
			$key = "{$chart}_{$m[title]}_{$m[artist]}";
			if( $already[$key] ) continue;
			$already[$key] = 1;
			$song = findSong( $m[title], $m[artist] );
			if( $song )
			    {
				$sql = ( "update billboardinfo set songid = '$song'  where artist = '" . escMe( $m[artist] ) . "' and title = '". escMe( $m[title] ) . "' " );
				db_query( $sql );
			    }
			else
			    {
				echo( count( $already ) . ". no song found for $m[artist], $m[title] ($m[chart], $m[rank], $m[thedate])<br>" );
				//				continue;
				$songnameid = getOrCreate( "songnames", $m[title] );
				$newsongid = db_query_insert_id( "insert into songs( SongNameHard, BillboardName, BillboardArtistName, songnameid, HasBillboard ) values ( '" . escMe($m[title]) . "','" . escMe($m[title]) . "', '" . escMe($m[artist]) . "', $songnameid, 1 ) " );
				$sql = ( "update billboardinfo set songid = '$newsongid'  where artist = '" . escMe( $m[artist] ) . "' and title = '". escMe( $m[title] ) . "' " );
				db_query( $sql );
				
				if( $chart == "hot-100" )
				    {
					$allmyrows = db_query_rows( "select * from billboardinfo where chart = 'hot-100' and rank <= 10 and title = '" . escMe( $m[title] ) . "' and artist = '" . escMe( $m[artist] ) . "'" );
					foreach( $allmyrows as $tmpm )
					    {
						$wdid = db_query_first_cell( "select id from weekdates where realdate = '$tmpm[thedate]'" );
						if( $wdid )
						    db_query( "insert into song_to_weekdate( songid, weekdateid, type ) values ( $newsongid, $wdid, 'position{$tmpm[rank]}' )" );
					    }
				    }
				$art = db_query_first_cell( "select id from artists where Name = '" . escMe( $m[artist] ) . "'" );
				if( $art )
				    {
					db_query( "insert into song_to_artist ( songid, artistid, type ) values ( '$newsongid', '$art', 'primary' )" );
				    }
				echo( count( $already ) . ". created <a href='editsong.php?songid=$newsongid'>$m[title] $m[artist]</a><br>" );
			    }
		    }
	    }
    }

if( $fix )
    {
	$titles = db_query_rows( "select distinct( title ), artist from billboardinfo" );
	foreach( $titles as $trow ) 
	    {
		$t = $trow[title];
		$a = $trow[artist];
		$songid = findSong( $t, $a );
		if( $songid )
		    {
			db_query( "update songs set HasBillboard = 1 where id = '$songid'" );
			db_query( "update billboardinfo set songid = '$songid' where title = '" . escMe( $t ) . "' and artist = '" . escMe( $a ) . "'" );
		    }
	    }
    }


function curl_get_file_contents( $url )
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}
// list all data from requested chart
//db_query( "create table billboardinfo ( chart varchar( 255 ), thedate date, title varchar( 255 ), rank integer, artist varchar( 255 ), lastweek integer, peakpos integer, weeksonchart integer )" );
function getChart($chart , $date = "")
{
    global $baseUrl;
    $origdate = $date;
    if( !$date  ) $date = "";
    if( strtotime( $date ) > time() )
	$date = "";
    $songs = array();;
    
     $titles = array();;
     $artists = array();;
     $covers = array();;
     $ranks = array();;
    $positions = array();;

    $url = $baseUrl . $chart;
    if( $date ) $url .=  "/" . $date;
    file_put_contents( "/tmp/billpull", date( "H:i:s" ) . " -- before pull ---\n", FILE_APPEND );
    $val = curl_get_file_contents($url);
    file_put_contents( "/tmp/billpull", date( "H:i:s" ) . " -- after pull ---\n", FILE_APPEND );
    // //    https://www.billboard.com/charts/hot-100/
    // //    https://www.billboard.com/charts/hot-100
    file_put_contents( "/tmp/t", $val );
    // echo( $url ); exit;
    $contents = str_get_html( $val );
    file_put_contents( "/tmp/billpull", date( "H:i:s" ) . " -- after parse ---\n", FILE_APPEND );
    //    echo( count( $contents->find( ".chart-row__song" ) ) );
    //    exit;
    $date = $origdate;
    foreach( $contents->find( ".js-chart-row" ) as $row )
	{
	    $ele =$row->find( '.chart-row__song', 0) ;
	    $songName = trim( $ele->innertext );
	    $titles[] = $songName;
	    file_put_contents( "/tmp/tm", $ele->innertext );
	    $tmppositions = array();
	    $secondary = $row->find( "div[class=chart-row__secondary]", 0 );
	    $positionInfo = array();
	    foreach( $secondary->find( "div" ) as $d )
		{
		    $span = $d->find( "span", 0 )->innertext;
		    $spanval = $d->find( "span", -1 )->innertext;
		    $positionInfo[$span] = $spanval; 
		}
		    //				foreach( $(item).closest('article').find('.chart-row__secondary > div').each(function(_, item) {
	    // $(item).children('div').each(function(_, item) {
	    // 	positionInfo[$('span:first-child', item).text()] = $('span:last-child', item).text()
	    // });
	    $positions[] = $positionInfo;
		    //				});
	    $rank = $row->find('.chart-row__current-week', 0);
	    $ranks[] = trim( $rank->innertext ); // .replace(/\r?\n|\r/g, "").replace(/\s+/g, ' '));
	    
	    $artist = $row->find('.chart-row__artist', 0);
	    $artistName = trim( $artist->innertext ); //.text().replace(/\r?\n|\r/g, "").replace(/\s+/g, ' ');
	    $artists[] = $artistName;
	}
    
    $retval = array();
    $dt = $contents->find( "time", 0 );
    $dt = $dt->{"datetime"};
    db_query( "delete from billboardinfo where thedate = '$dt' and chart = '$chart'" );
    foreach( $titles as $i=>$t )
	{
	    
	    $tmp = array();
	    $tmp[title] = trim( html_entity_decode( strip_tags( $t ) ) );
	    $tmp[artist] = trim( html_entity_decode( strip_tags( $artists[$i] ) ) );
	    $tmp[rank] = $ranks[$i];
	    $tmp[position] = $positions[$i];
	    $retval[] = $tmp;
	    $weeksonchart = $positions[$i]["Wks on Chart"];
	    $lastweek = $positions[$i]["Last Week"];
	    $peakpos = $positions[$i]["Peak Position"];

	    $songid = findSong( $tmp[title], $tmp[artist] );
	    //	    $songid = db_query_first_cell( "select songs.id from songs, songnames where songnameid = songnames.id and Name = '" . escMe( $tmp[title] ) . "'" );
	    if( $songid )
		db_query( "update songs set HasBillboard = 1 where id = '$songid'" );
	    db_query( "insert into billboardinfo( chart, thedate, title, rank, artist, lastweek, peakpos, weeksonchart, songid ) values ( '" . escMe( $chart ) . "', '" . escMe( $date ) . "', '" . escMe( $tmp[title] ) . "', '" . escMe( $tmp[rank] ) . "', '" . escMe( $tmp[artist] ) . "', '" . escMe( $lastweek ) . "', '$peakpos', '$weeksonchart', '$songid' )" );
	}
    // $('.chart-row__image').each(function(index){
    // 	var style = $(this).attr("style");
    // 	var songCover = "";
    // 	if(style){
    // 		songCover= style.replace("background-image: url(http://","").replace(")","");
    // 	}else{
    // 		var data = $(this).attr("data-imagesrc");
    // 		if(data){
    // 			songCover = data.replace("http://","");
			// 		}	
			// 	}
			// 	if (songCover.indexOf("background-image: url(") != -1) {
			// 		songCover = songCover.split("background-image: url(")[1];
			// 	}
			// 	covers.push(songCover);
			// });

// 			if (titles.length > 1){
// 				for (var i = 0; i < titles.length; i++){
// 					var song = {
// 						"rank": ranks[i],
// 						"title": titles[i],
// 						"artist": artists[i],
// 						"cover": covers[i]
// 					};
// 					var positionInfo = positions[i];
// 					if (positionInfo) {
// 						song['position'] = positionInfo;
// 					}
// 					songs.push(song);

// 					if (i == titles.length - 1){
// 						cb (songs);
// 					}

// 				}
// 			}
// 			else {
// 				cb ([], "no chart found");
// 			}
			
// 	});

// }
    return $retval;
}
// $allcharts["Radio Songs"]= 'radio-songs';
// $allcharts["Digital Song Sales"] =  'digital-song-sales';
// $allcharts["Pop Songs"] =  'pop-songs';
// $allcharts["Country Digital Song Sales"] =  'country-digital-song-sales';
// $allcharts["Country Streaming Songs"] =  'country-streaming-songs';
// $allcharts["Hot Country Songs"] =  'country-songs';
// $allcharts["Country Airplay"] =  'country-airplay';
// $allcharts["Hot Rock Songs"] =  'rock-songs';
// $allcharts["Hot 100"] =  'hot-100';
// $allcharts["Rock Airplay"] =  'rock-airplay';
// $allcharts["Rock Digital Song Sales"] =  'rock-digital-song-sales';
// $allcharts["Rock Streaming Songs"] =  'rock-streaming-songs';
// $allcharts["Alternative Songs"] =  'alternative-songs';
// $allcharts["Adult Alternative Songs"] =  'triple-a';
// $allcharts["Mainstream Rock Songs"] =  'hot-mainstream-rock-tracks';
// $allcharts["Hot R&B/Hip-Hop Songs"] =  'r-b-hip-hop-songs';
// $allcharts["R&B/Hip-Hop Airplay"] =  'hot-r-and-b-hip-hop-airplay';
// $allcharts["R&B/Hip-Hop Digital Song Sales"] =  'r-and-b-hip-hop-digital-song-sales';
// $allcharts["R&B/Hip-Hop Streaming Songs"] =  'r-and-b-hip-hop-streaming-songs';
// $allcharts["Hot R&B Songs"] =  'r-and-b-songs';
// $allcharts["R&B Streaming Songs"] =  'r-and-b-streaming-songs';
// $allcharts["Hot Rap Songs"] =  'rap-song';
// $allcharts["Rap Streaming Songs"] =  'rap-streaming-songs';
// $allcharts["Adult R&B Songs"] =  'hot-adult-r-and-b-airplay';
// $allcharts["Rhythmic Songs"] =  'rhythmic-40';
// $allcharts["Dance/Electronic Digital Song Sales"] =  'dance-electronic-digital-song-sales';
// $allcharts["Dance/Electronic Streaming Songs"] =  'dance-electronic-streaming-songs';
// $allcharts["Dance Club Songs"] =  'dance-club-play-songs';
// $allcharts["Dance/Mix Show Airplay"] =  'hot-dance-airplay';
// $allcharts["Hot Dance/Electronic Songs"] =  'dance-electronic-songs';
// $allcharts["Hot Latin Songs"] =  'latin-songs';
// $allcharts["Latin Digital Song Sales"] =  'latin-digital-song-sales';
// $allcharts["Latin Airplay"] =  'latin-airplay';
// $allcharts["Latin Streaming Songs"] =  'latin-streaming-songs';
// $allcharts["Tropical Songs"] =  'tropical-songs';
// $allcharts["Latin Pop Songs"] =  'latin-pop-songs';
// $allcharts["YouTube"] =  'youtube';
//db_query( "create table charts ( chartname  varchar( 255 ), chartkey varchar( 255 ) )" );
// foreach( $allcharts as $aname => $a )
// {
//     db_query( "insert into charts values( '$aname', '$a' )" );
// }
// exit;

if( $chartname )
    {

	$allchartspu = db_query_array( "select chartkey from charts where chartkey = '$chartname' order by chartkey", "chartkey", "chartkey" );
	$dt = date( "Y-m-d", strtotime( "last Saturday" ) );
	while( strtotime( $dt ) > strtotime( "2013-01-01" ) )
	    {
		foreach( $allchartspu as $aname => $a )
		    {
			echo( "doing $a ... $dt<br>" );
			file_put_contents( "/tmp/billpull", date( "H:i:s" ) . " -- doing $a ... $dt ---\n", FILE_APPEND );
			$any = db_query_first_cell( "select count(*) from billboardinfo where chart = '$a' and thedate = '$dt'" );
			if( $any ) continue;
			$val = getChart( $a, $dt );
		    }
		$dt = date( "Y-m-d", strtotime( "$dt - 7 days" ) );
	    }
    }
include "nav.php";
?>
<h3> Pull Data From Specific Chart</h3>
<form method='post'>
<table>
    <?=outputSelectRow( "Chart", "chartname", $chartname, $allcharts )?>
<tr><td><input type='submit' name='go' value='Go'>
</table>
    <h3>Current Data (Num Weeks Pulled)</h3>

<table class="content" border=1 cellpadding=2 cellspacing = 0>
<tr><th>Chart</th><th>Num Weeks
    <? foreach( $allcharts as $chartid=>$cname ) { 
    $weeks = db_query_array( "select distinct( thedate ) from billboardinfo where chart = '$chartid'", "thedate", "thedate" );
    $weekstr = "'2018-01-03'";
    foreach( $weeks as $w )
    {
	$weekstr .= ", '$w'";
    }
?>
						   <tr><td><?=$cname?> (<?=$chartid?>)</td>
						   <td><?=count( $weeks )?></td>
<td>
<? 
    $miss = db_query_array( "select realdate from weekdates where realdate not in ( $weekstr ) and realdate < '" . date( "Y-m-d" )  . "' and realdate > '2013-01-01' ", "realdate", "realdate" );
						   echo( implode( ", ", $miss ) );
?>
</td>
</tr>
						   <? } ?>
</table>

<br><br><table>
    <tr><td>List and Create Missing: <input type='submit' name='create' value='Create'></td></tr>
    <tr><td><br></td></tr>
    <tr><td><a href='pullbillboardall.php' target=_blank>Pull All</a></td></tr>
    <tr><td><br></td></tr>
<!--    <tr><td>Fix Song Ids: <input type='submit' name='fix' value='Fix'></td></tr> -->
    <? 
    $nonames = db_query_array( "select songs.id, Name from songnames, songs where HasBillboard = 0 and songnameid = songnames.id and CleanUrl not like 'BMG%' and CleanUrl not like 'Client%' and CleanUrl <> '-Test_2_5-10-16'", "id", "Name" );
foreach( $nonames as $cid => $cname ) { ?>
						   <tr><td><a href='editsong.php?songid=<?=$cid?>' target=_blank><?=$cname?></a></td></tr>
	<? } ?>
    <? 

	$songs = db_query_rows( "select songid, title, count( distinct( artist ) ) as cnt, group_concat( distinct( artist ) )  as artistlist from billboardinfo where songid > 0 group by songid, title having cnt > 1" );
foreach( $songs as $tmprow ) { 
?>
    <tr><td><a href='editsong.php?songid=<?=$tmprow[songid]?>' target=_blank><?=$tmprow[title]?> (<?=$tmprow[cnt]?> artists listed - <?=$tmprow[artistlist]?>)</a></td></tr>
	<? } ?>
</table>

