<? 
$nologin = 1;
include "connect.php";
define( 'MAX_FILE_SIZE', 9999999 ); // for the parser
require_once "dom/simple_html_dom.php";

$baseUrl = "https://www.billboard.com/charts/";

function fixNum( $str )
{
    return array_shift( explode( "&nbsp;", $str ) );
}


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
    //    $heeders["Cookie"] = "UTDP=33%2C1%2C44%2C3%2C32%2C31%2C30; __cfduid=d9a87f625f231ffe3cdd8c6a16712f13b1608659966; usprivacy=1YNY; _ga_M36NFPZP5H=GS1.1.1608744545.3.0.1608744545.0; _ga=GA1.2.413935423.1608659969; aasd=1%7C1608744545047; __aaxsc=2; OptanonConsent=isIABGlobal=false&datestamp=Wed+Dec+23+2020+09%3A29%3A06+GMT-0800+(Pacific+Standard+Time)&version=6.10.0&hosts=&consentId=7c96c5bf-ecc6-4410-ba28-50be90ae3f44&interactionCount=1&landingPath=NotLandingPage&groups=C0001%3A1%2CC0003%3A1%2CC0002%3A1%2CSPD_BG%3A1%2CC0004%3A1&AwaitingReconsent=false; __tbc=%7Bjzx%7DJWiA01VAggbaXaqUQuVifjQrYugkTkinaR_neUXAl8g_RSzi0v0KH7fq0fJgN7FXX_4AgZkJ3CBNbkn1TJVknA; __pat=0; __pvi=%7B%22id%22%3A%22v-kj1oyrlceosu151h%22%2C%22domain%22%3A%22.billboard.com%22%2C%22time%22%3A1608744545328%7D; xbc=%7Bjzx%7DvXFuuMrV6nxqQdZWU8Ya8FRcx_2ETQ_I0IUvZHic5c9LDWgWi9OO5kM3h3xe0IRnURsi-E2PfJZ2v97W9dqNtPhBUwys_7zydENjBE1ZrGN3nEia8LWjIzWBRXv0teZFFJAJWFL8tJg1OA_yCXJECS8Rbv9kjxBqtJ9e7xoihdnoHCSjIyeGooYdMXrTV7A8bLk-Yho8bR2h6iLZHhe-5sVKfNGAJOSov6b3SsQ6wRaZ4bzhVGRhqP_QcGWi0OI7O1vz0Uo88cRcGnNnkBM0Ox6YId2IKAS2Ih7YZ23WydFyEBLK1EaZhqaES_IkGidE9M8aRyRwRGm-4wRZoW4_w9da_sFCvYLIzanZyHrgYcpXKMNex0kmReT_HCi_cYeaWg72JRzBxywGezRmrdRh5JdZMU1ZFK5kIoCUAitRLYb8trmP8NHMfAnOgIjifZ2RCHbgIjGZ99HYc3Tt90FnHA; _cb_ls=1; _cb=DVixkLCStbzsDT0zas; _chartbeat2=.1608659969451.1608744546292.11.B_jlxFB9u1vkCe4mCRB5X2vkDbJwkj.1; _fbp=fb.1.1608659969509.62443010; _hjTLDTest=1; _hjid=3955b06f-a6ba-4fdf-983e-b211c2727e0e; _pbjs_userid_consent_data=3524755945110770; OneTrustWPCCPAGoogleOptOut=false; __pil=en_US; cX_S=kj0gn78lyah40sws; _gid=GA1.2.35557201.1608670103; _lr_geo_location=US; __gads=ID=7cd82c5c2679cb67-22311c616dc50087:T=1608670103:S=ALNI_MZgvGHuYijwBUFbN30zMsEOd0hr7Q; cX_G=cx%3A3qkp3sxb1d8ds1uvpo2obzbrj7%3A1rlez0fodi6u1; PGMINFO=cc:us-ip:2600:1700:38c0:6c6f:d62f:e7c5:d435:2d74; __cf_bm=64f741d7c93a287451ff43065b470220965800ab-1608744545-1800-ASTJSAYQQ+AJSWiukv/EYSfXDRskFTP9bzASZbPKbCzvfw0eG7C1E1XthT4R3sLqC6B227hCLtaOSfmrxzN9n+H6+c39vzaDQyKo05mzBBOeBxsTmT2Sa0L8GQrUjjPbL7DKLi7q/fwduGPSnBDVw48XYDJOo/PRLPa94h8vl4Oj; sailthru_pageviews=2; permutive-session=%7B%22session_id%22%3A%225c6c6ace-0c93-4709-a90b-836d295385e7%22%2C%22last_updated%22%3A%222020-12-23T17%3A29%3A04.853Z%22%7D; permutive-id=59a68ca2-97eb-4082-a577-f79c803e8b58; AMP_TOKEN=%24NOT_FOUND; _dc_gtm_UA-1266747-9=1; _cb_svref=null; _gat_pianoTracker=1; _gat_auPassiveTagger=1; _gat_UA-1266747-9=1; sailthru_visitor=bab53847-a5c3-4a31-8bc4-45c8c90c1af7; __utp=eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2lkLnBpYW5vLmlvIiwic3ViIjoiUE5JaFMxTW5BcHh6ZW9yIiwiYXVkIjoiT3c5anRpWHh0eiIsImxvZ2luX3RpbWVzdGFtcCI6IjE2MDg3NDQ1NjgyMDEiLCJnaXZlbl9uYW1lIjoiRGF2aWQiLCJmYW1pbHlfbmFtZSI6IlBlbm4iLCJlbWFpbCI6ImRhdmVAaGl0c29uZ3NkZWNvbnN0cnVjdGVkLmNvbSIsImVtYWlsX2NvbmZpcm1hdGlvbl9yZXF1aXJlZCI6ZmFsc2UsImV4cCI6MTYxMTM3MjU2OCwiaWF0IjoxNjA4NzQ0NTY4LCJqdGkiOiJUSWd0U0JLY0t2cWxzejk0In0.J5tYbu_a0iCl3Pm7xLsUniUmYERZJjJpCSOJtz3bt6w; __pid=.billboard.com";
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
						 'Cookie: UTDP=33%2C1%2C44%2C3%2C32%2C31%2C30; __cfduid=d9a87f625f231ffe3cdd8c6a16712f13b1608659966; usprivacy=1YNY; _ga_M36NFPZP5H=GS1.1.1608744545.3.0.1608744545.0; _ga=GA1.2.413935423.1608659969; aasd=1%7C1608744545047; __aaxsc=2; OptanonConsent=isIABGlobal=false&datestamp=Wed+Dec+23+2020+09%3A29%3A06+GMT-0800+(Pacific+Standard+Time)&version=6.10.0&hosts=&consentId=7c96c5bf-ecc6-4410-ba28-50be90ae3f44&interactionCount=1&landingPath=NotLandingPage&groups=C0001%3A1%2CC0003%3A1%2CC0002%3A1%2CSPD_BG%3A1%2CC0004%3A1&AwaitingReconsent=false; __tbc=%7Bjzx%7DJWiA01VAggbaXaqUQuVifjQrYugkTkinaR_neUXAl8g_RSzi0v0KH7fq0fJgN7FXX_4AgZkJ3CBNbkn1TJVknA; __pat=0; __pvi=%7B%22id%22%3A%22v-kj1oyrlceosu151h%22%2C%22domain%22%3A%22.billboard.com%22%2C%22time%22%3A1608744545328%7D; xbc=%7Bjzx%7DvXFuuMrV6nxqQdZWU8Ya8FRcx_2ETQ_I0IUvZHic5c9LDWgWi9OO5kM3h3xe0IRnURsi-E2PfJZ2v97W9dqNtPhBUwys_7zydENjBE1ZrGN3nEia8LWjIzWBRXv0teZFFJAJWFL8tJg1OA_yCXJECS8Rbv9kjxBqtJ9e7xoihdnoHCSjIyeGooYdMXrTV7A8bLk-Yho8bR2h6iLZHhe-5sVKfNGAJOSov6b3SsQ6wRaZ4bzhVGRhqP_QcGWi0OI7O1vz0Uo88cRcGnNnkBM0Ox6YId2IKAS2Ih7YZ23WydFyEBLK1EaZhqaES_IkGidE9M8aRyRwRGm-4wRZoW4_w9da_sFCvYLIzanZyHrgYcpXKMNex0kmReT_HCi_cYeaWg72JRzBxywGezRmrdRh5JdZMU1ZFK5kIoCUAitRLYb8trmP8NHMfAnOgIjifZ2RCHbgIjGZ99HYc3Tt90FnHA; _cb_ls=1; _cb=DVixkLCStbzsDT0zas; _chartbeat2=.1608659969451.1608744546292.11.B_jlxFB9u1vkCe4mCRB5X2vkDbJwkj.1; _fbp=fb.1.1608659969509.62443010; _hjTLDTest=1; _hjid=3955b06f-a6ba-4fdf-983e-b211c2727e0e; _pbjs_userid_consent_data=3524755945110770; OneTrustWPCCPAGoogleOptOut=false; __pil=en_US; cX_S=kj0gn78lyah40sws; _gid=GA1.2.35557201.1608670103; _lr_geo_location=US; __gads=ID=7cd82c5c2679cb67-22311c616dc50087:T=1608670103:S=ALNI_MZgvGHuYijwBUFbN30zMsEOd0hr7Q; cX_G=cx%3A3qkp3sxb1d8ds1uvpo2obzbrj7%3A1rlez0fodi6u1; PGMINFO=cc:us-ip:2600:1700:38c0:6c6f:d62f:e7c5:d435:2d74; __cf_bm=64f741d7c93a287451ff43065b470220965800ab-1608744545-1800-ASTJSAYQQ+AJSWiukv/EYSfXDRskFTP9bzASZbPKbCzvfw0eG7C1E1XthT4R3sLqC6B227hCLtaOSfmrxzN9n+H6+c39vzaDQyKo05mzBBOeBxsTmT2Sa0L8GQrUjjPbL7DKLi7q/fwduGPSnBDVw48XYDJOo/PRLPa94h8vl4Oj; sailthru_pageviews=2; permutive-session=%7B%22session_id%22%3A%225c6c6ace-0c93-4709-a90b-836d295385e7%22%2C%22last_updated%22%3A%222020-12-23T17%3A29%3A04.853Z%22%7D; permutive-id=59a68ca2-97eb-4082-a577-f79c803e8b58; AMP_TOKEN=%24NOT_FOUND; _dc_gtm_UA-1266747-9=1; _cb_svref=null; _gat_pianoTracker=1; _gat_auPassiveTagger=1; _gat_UA-1266747-9=1; sailthru_visitor=bab53847-a5c3-4a31-8bc4-45c8c90c1af7; __utp=eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2lkLnBpYW5vLmlvIiwic3ViIjoiUE5JaFMxTW5BcHh6ZW9yIiwiYXVkIjoiT3c5anRpWHh0eiIsImxvZ2luX3RpbWVzdGFtcCI6IjE2MDg3NDQ1NjgyMDEiLCJnaXZlbl9uYW1lIjoiRGF2aWQiLCJmYW1pbHlfbmFtZSI6IlBlbm4iLCJlbWFpbCI6ImRhdmVAaGl0c29uZ3NkZWNvbnN0cnVjdGVkLmNvbSIsImVtYWlsX2NvbmZpcm1hdGlvbl9yZXF1aXJlZCI6ZmFsc2UsImV4cCI6MTYxMTM3MjU2OCwiaWF0IjoxNjA4NzQ0NTY4LCJqdGkiOiJUSWd0U0JLY0t2cWxzejk0In0.J5tYbu_a0iCl3Pm7xLsUniUmYERZJjJpCSOJtz3bt6w; __pid=.billboard.com',
					       "Host: www.billboard.com",
					       "User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:78.0) Gecko/20100101 Firefox/78.0",
					       "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8", 
					       "Accept-Language: en-US,en;q=0.5",
						 //					       "Accept-Encoding: gzip, deflate, br", 
					       "DNT: 1", 
					       "Connection: keep-alive", 
					       "Upgrade-Insecure-Requests: 1", 
					       "Cache-Control: max-age=0", 
					       "TE: Trailers"
						 ));

    //    curl_setopt($curl, CURLOPT_HEADER, false);
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
    file_put_contents( "/tmp/t", $val );
    // echo( $url ); exit;
    $contents = str_get_html( $val );
    file_put_contents( "pullsave/$chart-{$origdate}.html", $contents );
    file_put_contents( "/tmp/billpull", date( "H:i:s" ) . " -- after parse ---\n", FILE_APPEND );
    //       echo( count( $contents->find( ".chart-row__song" ) ) );
    $count = count( $contents->find( ".chart-list-item" ) );
    // echo( "count? $count<br>" );
    // exit;
    if( !count( $contents->find( ".chart-list-item" ) ) )
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


    foreach( $contents->find( ".chart-list-item" ) as $row )
	{
	    $ele =$row->find( '.chart-list-item__title-text', 0) ;
	    $songName = trim( $ele->innertext );
	    $titles[] = $songName;
	    file_put_contents( "/tmp/tm", $ele->innertext );
	    $tmppositions = array();
	    //	    $secondary = $row->find( "div[class=chart-list-item__stats-cell]", 0 );
	    $positionInfo = array();
	    $positionInfo["Last Week"] = fixNum( $row->find( "div[class=chart-list-item__ministats-cell]", 0 )->innertext );
	    $positionInfo["Wks on Chart"] = fixNum( $row->find( "div[class=chart-list-item__ministats-cell]", 2 )->innertext );
	    $positionInfo["Peak Position"] = fixNum( $row->find( "div[class=chart-list-item__ministats-cell]", 1 )->innertext );
	    $positions[] = $positionInfo;
		    //				});
	    $rank = $row->find('.chart-list-item__rank', 0);
	    $ranks[] = trim( $rank->innertext ); // .replace(/\r?\n|\r/g, "").replace(/\s+/g, ' '));
	    
	    $artist = $row->find('.chart-list-item__artist', 0);
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
//$allcharts = array( "r-b-hip-hop-songs"=>"Hot Hip-Hop/R&B", "country-songs"=>"Hot Country", "pop-songs"=>"Pop Songs" );
$allcharts = array( "christian-songs"=>"Christian Songs", "rock-songs"=>"Hot Rock Songs", "dance-electronic-songs"=>"Hot Dance/Electronic Songs" );
foreach( $allcharts as $chartname=>$chartdisplay )
    {

	$allchartspu = db_query_array( "select chartkey from charts where chartkey = '$chartname' order by chartkey", "chartkey", "chartkey" );

	$weeks = db_query_array( "select distinct( thedate ) from billboardinfo where chart = '$chartname'", "thedate", "thedate" );
	$weekstr = "'2018-01-03'";
	foreach( $weeks as $w )
	    {
		$weekstr .= ", '$w'";
	    }

	$missing = db_query_array( "select realdate from weekdates where realdate not in ( $weekstr ) and realdate <= '" . $nextsat  . "' and realdate > '2013-01-25' ", "realdate", "realdate" );
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
