<? 
$nologin = 1;
include "connect.php";
define( 'MAX_FILE_SIZE', 9999999 ); // for the parser
require_once "dom/simple_html_dom.php";

$baseUrl = "https://www.billboard.com/charts/";


function findSong( $t, $a ) 
{
    if( $t == "F**kin Problems" ) $t = "F**kin' Problems";
    if( $t == "Old Town Road" ) return 3155;

    $songid = db_query_first_cell( "select songs.id from songs where BillboardName = '" . escMe( $t ).  "' and BillboardArtistName = '" . escMe( $a ).  "'" );
    if( !$songid )
	{
	    $songid = db_query_first_cell( "select songs.id from songs, songnames where songnameid = songnames.id and Name = '" . escMe( $t ).  "' and ArtistBand = '" . escMe( $a ).  "'" );
	    if( !$songid )
		$songid = db_query_first_cell( "select songs.id from songs, songnames where songnameid = songnames.id and Name = '" . escMe( $t ).  "' and BillboardName = '' " );
	}
    return $songid;
}

db_query( "update billboardinfo set artist = replace( artist, '&#039;', '\'' ) where artist like '%&#039;%'" );
db_query( "update billboardinfo set title = replace( title, '&#039;', '\'' ) where title like '%&#039;%'" );

$allcharts = db_query_array( "select * from charts where IsLive = 1 order by chartname", "chartkey", "chartname" );

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
// echo( $date . "<br>");
// return;
//exit;
    if( strtotime( $date ) > time() )
	$date = "";
    $songs = array();;
    
     $titles = array();;
     $artists = array();;
     $covers = array();;
     $ranks = array();;
    $positions = array();;
    sleep( 2 );
    $url = $baseUrl . $chart;
    if( $date ) $url .=  "/" . $date;
    file_put_contents( "/tmp/billpull", date( "H:i:s" ) . " -- before pull $url ---\n", FILE_APPEND );
    echo( date( "H:i:s" ) . " -- before pull $url ---<Br>\n" );
    $val = curl_get_file_contents($url);
    file_put_contents( "/tmp/billpull", date( "H:i:s" ) . " -- after pull ---\n", FILE_APPEND );
    // //    https://www.billboard.com/charts/hot-100/
    // //    https://www.billboard.com/charts/hot-100
    //    file_put_contents( "/tmp/t", $val );
    // echo( $url ); exit;
    //    echo( strlen( $val ) );
    $contents = str_get_html( $val );
    
    file_put_contents( "pullsave/$chart-{$origdate}.html", $contents );
    file_put_contents( "/tmp/billpull", date( "H:i:s" ) . " -- after parse ---\n", FILE_APPEND );
    // echo( count( $contents->find( "html" ) ) );
    // exit;
    $count = count( $contents->find( ".chart-list__element" ) );
    // echo( "count? $count<br>" );
    // exit;
    if( !count( $contents->find( ".chart-list__element" ) ) )
	{
	    file_put_contents( "/tmp/billpull", date( "H:i:s" ) . " -- NO RESULTS FOR $url ---\n", FILE_APPEND );
	    echo( date( "H:i:s" ) . " -- NO RESULTS FOR $url ---\n" );

	    if( strlen( $val ) > 4000 )
		{
		    mail( "rachelc@gmail.com", "no valid results for $chart, $date", "check on this!", "From: info@chartcipher.com" );
		}
	    exit;
	}
    $date = $origdate;


    if( $oldformat )
	{
	    // number one first
	    $row =$contents->find( '.chart-number-one__info', 0) ;
	    $ele =$row->find( '.chart-number-one__title', 0) ;
	    $songName = trim( $ele->innertext );
	    $titles[] = $songName;
	    //    file_put_contents( "/tmp/tm", $ele->innertext );
	    $tmppositions = array();
	    $positionInfo = array();
	    $positionInfo["Last Week"] = $row->find( "div[class=chart-number-one__last-week]", 0 )->innertext;
	    $positionInfo["Wks on Chart"] = $row->find( "div[class=chart-number-one__weeks-on-chart]", 0 )->innertext;
	    $positionInfo["Peak Position"] = 1;
	    $positions[] = $positionInfo;
	    //				});
	    $ranks[] = 1;
	    
	    $artist = $row->find('.chart-number-one__artist a', 0);
	    $artistName = trim( $artist->innertext ); //.text().replace(/\r?\n|\r/g, "").replace(/\s+/g, ' ');
	    if(!$artistName )
		$artistName = trim( $row->find('.chart-number-one__artist', 0)->innertext );
	    
	    $artists[] = $artistName;
	    // end number one
	}


    foreach( $contents->find( ".chart-list__element" ) as $row )
	{
	    $ele =$row->find( '.chart-element__information__song', 0) ;
	    $songName = trim( $ele->innertext );
	    $titles[] = $songName;
	    file_put_contents( "/tmp/tm", $ele->innertext );
	    $tmppositions = array();
	    //	    $secondary = $row->find( "div[class=chart-list-item__stats-cell]", 0 );
	    $positionInfo = array();
	    $positionInfo["Last Week"] = $row->find( "span[class=text--last]", 0 )->innertext;
	    $positionInfo["Wks on Chart"] = $row->find( "span[class=text--week]", 0 )->innertext;
	    $positionInfo["Peak Position"] = $row->find( "span[class=text--peak]", 0 )->innertext;
	    $positions[] = $positionInfo;
		    //				});
	    $rank = $row->find('.chart-element__rank__number', 0);
	    $ranks[] = trim( $rank->innertext ); // .replace(/\r?\n|\r/g, "").replace(/\s+/g, ' '));
	    
	    $artist = $row->find('.chart-element__information__artist', 0);
	    $artistName = trim( $artist->innertext ); //.text().replace(/\r?\n|\r/g, "").replace(/\s+/g, ' ');
	    // if(!$artistName )
	    // 	$artistName = trim( $row->find('.chart-list-item__artist', 0)->innertext );
	    $artists[] = $artistName;
	}

    // print_r( $artists );
    // print_r( $titles );
    // print_r( $ranks );
    // print_r( $positions );
    // exit;

    
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
	    $weeksonchart = str_replace( " Weeks on Chart", "", $positions[$i]["Wks on Chart"] );
	    $lastweek = str_replace( " Last Week", "", $positions[$i]["Last Week"] );
	    $peakpos = str_replace( " Peak Rank", "", $positions[$i]["Peak Position"] );

	    $songid = findSong( $tmp[title], $tmp[artist] );
	    //	    $songid = db_query_first_cell( "select songs.id from songs, songnames where songnameid = songnames.id and Name = '" . escMe( $tmp[title] ) . "'" );
	    if( $songid )
		db_query( "update songs set HasBillboard = 1 where id = '$songid'" );
	    db_query( "insert into billboardinfo( chart, thedate, title, rank, artist, lastweek, peakpos, weeksonchart, songid ) values ( '" . escMe( $chart ) . "', '" . escMe( $date ) . "', '" . escMe( $tmp[title] ) . "', '" . escMe( $tmp[rank] ) . "', '" . escMe( $tmp[artist] ) . "', '" . escMe( $lastweek ) . "', '$peakpos', '$weeksonchart', '$songid' )" );
	}
    return $retval;
}

$nextsat = date( "Y-m-d", strtotime( "next Saturday" ) );
//	 $allcharts = array( "hot-100"=>"Hot 100", "latin-songs"=>"Hot Latin", "r-b-hip-hop-songs"=>"Hot Hip-Hop/R&B", "country-songs"=>"Hot Country", "pop-songs"=>"Pop Songs" );
//	 $allcharts = array( "hot-100"=>"Hot 100", "r-b-hip-hop-songs"=>"Hot Hip-Hop/R&B", "country-songs"=>"Hot Country", "pop-songs"=>"Pop Songs" );
	 $allcharts = array( "hot-100"=>"Hot 100" );
foreach( $allcharts as $chartname=>$chartdisplay )
    {

	$allchartspu = db_query_array( "select chartkey from charts where chartkey = '$chartname' order by chartkey", "chartkey", "chartkey" );


	$weeks = db_query_array( "select distinct( thedate ) from billboardinfo where chart = '$chartname'", "thedate", "thedate" );
	$weekstr = "'2018-01-03'";
	foreach( $weeks as $w )
	    {
		$weekstr .= ", '$w'";
	    }

	$missing = db_query_array( "select realdate from weekdates where realdate not in ( $weekstr ) and realdate <= '" . $nextsat  . "' and realdate > '2010-01-01' ", "realdate", "realdate" );
	//	echo( "select realdate from weekdates where realdate not in ( $weekstr ) and realdate <= '" . $nextsat  . "' and realdate > '2013-01-01'<Br>" );
	echo( "for $chartname:" );
	// print_r( $missing );
	// exit;
	foreach( $missing as $dt )
	    {
		// echo( "doing $chartname ... $dt<br>" );
		// exit;
		file_put_contents( "/tmp/billpull", date( "H:i:s" ) . " -- doing $chartname ... $dt ---\n", FILE_APPEND );
		$val = getChart( $chartname, $dt );
	    }
    }

db_query( "update billboardinfo set artist = replace( artist, '&#039;', '\'' ) where artist like '%&#039;%'" );
db_query( "update billboardinfo set title = replace( title, '&#039;', '\'' ) where title like '%&#039;%'" );


if( $create )
    {
	echo( "doing?\n" );
	$already = array();
	$dt = date( "Y-m-d", strtotime( "next Saturday" ) );
	$alldts = array( $dt );

	//	$alldts = array( '2020-01-11', '2020-01-18', '2020-01-25', '2020-02-01', '2020-02-08', '2020-02-15', '2020-02-22', '2020-02-29', '2020-03-07', '2020-03-14', '2020-03-21', '2020-03-28'  );

	foreach( $alldts as $dt )
	    {
		//	$dt = "2020-01-04";
		foreach( array( "hot-100"=>$dt, "pop-songs"=>$dt ) as $chart => $earliestdate)
		    {
			echo( "select * from billboardinfo where chart = '$chart' and rank <= 10 and songid = 0 and thedate >= '$earliestdate'<br>\n" );
			$missingrows = db_query_rows( "select * from billboardinfo where chart = '$chart' and rank <= 10 and thedate >= '$earliestdate' order by thedate limit 10" );
			foreach( $missingrows as $m )
			    {
				$key = "{$chart}_{$m[title]}_{$m[artist]}_{$m[thedate]}";
				if( $already[$key] ) continue;
				$already[$key] = 1;
				$song = findSong( $m[title], $m[artist] );
				if( $song )
				    {
					$sql = ( "update billboardinfo set songid = '$song'  where artist = '" . escMe( $m[artist] ) . "' and title = '". escMe( $m[title] ) . "' and songid = 0 " );
					echo( $sql . "<br>");
					db_query( $sql );
					$wdid = db_query_first_cell( "select id from weekdates where realdate = '$m[thedate]'" );
					if( $wdid && $chart == "hot-100" )
					    {
						echo( "checking for rank {$m[rank]}\n" );
						$exists = db_query_first_cell( "select type from song_to_weekdate where songid = '$song' and weekdateid = '$wdid'" );
						if( !$exists )
						    {
							echo( "okay..... adding rank {$m[rank]}\n" );
							db_query( "insert into song_to_weekdate( songid, weekdateid, type ) values ( $song, $wdid, 'position{$m[rank]}' )" );
						    }
					    }
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

    }


$res =db_query_array( "select distinct( thedate ) from billboardinfo where weekdateid is null", "thedate", "thedate" );
foreach( $res as $r )
{
    $w = db_query_first_cell( "select id from weekdates where realdate = '$r'" );
    if( $w )
	db_query( "update billboardinfo set weekdateid = $w where thedate = '$r'" );
}

$songids = db_query_array( "select id from songs", "id", "id" );
foreach( $songids as $songid )
{
    $peak = db_query_first_cell( "select type from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
    $numweeks = db_query_first_cell( "select count(*) from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by OrderBy" );
    $peak = str_replace( "position", "", $peak );

    $firstrow = db_query_first( "select Name, type, OrderBy, weekdates.id from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by OrderBy limit 1" );
    $firstdate = $firstrow[OrderBy];
    if( date( "n", $firstdate ) <= 3 )
	{
	    $quarter = "1/" . date( "Y", $firstdate );
	}
    else if( date( "n", $firstdate ) <= 6 )
	{
	    $quarter = "2/" . date( "Y", $firstdate );
	}
    else if( date( "n", $firstdate ) <= 9 )
	{
	    $quarter = "3/" . date( "Y", $firstdate );
	}
    else
	{
	    $quarter = "4/" . date( "Y", $firstdate );
	}

    $autocalcvalues = array();
    
    $autocalcvalues["QuarterEnteredTheTop10"] = $quarter;
    $autocalcvalues["WeekEnteredTheTop10"] = $firstrow[id];
    $autocalcvalues["YearEnteredTheTop10"] = date( "Y", $firstdate );
    $autocalcvalues["EntryPosition"] = str_replace( "position", "", $firstrow["type"] );
    $autocalcvalues["NumberOfWeeksSpentInTheTop10"] = $numweeks;
    $autocalcvalues["PeakPosition"] = str_replace( "position", "", $peak );
    foreach( $autocalcvalues as $aid=>$val )
      {
	db_query( "update songs set $aid = '$val' where id = $songid" );
      }


}


?>
