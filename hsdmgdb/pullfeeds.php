<? 
$nologin = 1;
include "connect.php";

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


if( 1 == 1 )
    {
foreach( $resources as $name=>$r )
{
    $out = curl_get_file_contents( $r );
    echo( "pulling $r<br>" );

    file_put_contents( "rsssaves/{$name}.xml", $out );
    
}
    }

// MariaDB [dbi360_admin]> create table xmlitems ( feedid varchar( 20 ), link text, title varchar( 255 ), pubdate datetime, description text, guid text );
// MariaDB [dbi360_admin]> create table xmlelements ( itemid integer, fieldname varchar( 255 ), fieldvalue text );

function cleanChars( $val )
{
    $val = str_replace( "’", "'", $val );
    $val = str_replace( "”", "\"", $val );
    $val = str_replace( "“", "\"", $val );
    $val = str_replace( "–", "-", $val );
    $val = html_entity_decode( $val );

    return escMe( $val );
}

foreach( $resources as $name=>$r )
{
    $filename =  "rsssaves/{$name}.xml";

    if(@simplexml_load_file($filename)){
	$feeds = simplexml_load_file($filename);
    }else{
	$invalidurl = true;
	echo "<h2>Invalid RSS feed URL. $r</h2>";
    }
    if( $feeds )
	{
	    $site = $feeds->channel->title;
	    $sitelink = $feeds->channel->link;
	    
	    // echo "<h1>".$site."</h1>";
	    foreach ($feeds->channel->item as $item) {
		$guid = cleanChars( $item->guid );
		$link = cleanChars( $item->link );
		$title = cleanChars( $item->title );
		echo( $title. "<br>" );
		//		file_put_contents( "/tmp/titles", $title . "\n", FILE_APPEND );
		$pubdate = cleanChars( date( "Y-m-d H:i:s", strtotime( $item->pubDate ) ) );
		$description = cleanChars( $item->description );
		if( !$guid )
		    {
			echo( "no guid!<br>" );
			continue;
		    }
		db_query( "delete from xmlitems where guid = '$guid'" );
		db_query( "delete from xmlelements where guid = '$guid'" );
		db_query( "insert into xmlitems ( sitename, feedid, link, title, pubdate, description, guid ) values ( '" . cleanChars( $site ) . "', '" . cleanChars( $name ) . "', '$link', '$title', '$pubdate', '$description', '$guid' )" );
		$already = array();
		foreach( $item as $k=>$v )
		    {
			if( $k == "guid" ) continue;
			if( $k == "pubDate" ) continue;
			if( $k == "link" ) continue;
			if( $k == "enclosure" ) continue;
			db_query( "insert into xmlelements ( guid, fieldname, fieldvalue ) values ( '$guid', '" . cleanChars( $k ) . "', '" . cleanChars( $v ) . "' )" );
		    }
	    }
	}    
}


?>
