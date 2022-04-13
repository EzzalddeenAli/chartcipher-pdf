<? 
$nologin = 1;
include "connect.php";

$allcharts = db_query_array( "select * from charts order by chartname", "chartkey", "chartname" );

//db_query( "update billboardinfo set artist = replace( artist, '&#039;', '\'' ) where artist like '%&#039;%'" );
//db_query( "update billboardinfo set title = replace( title, '&#039;', '\'' ) where title like '%&#039;%'" );

$weeks = db_query_array( "select OrderBy, Name from weekdates order by OrderBy", "OrderBy", "Name" );


$date = db_query_first_cell( "select max( thedate ) from billboardinfo" ); 

if( $go )
    {
	$whr = "1";
	if( $maincharts )
	    {
		$whr .= " and chart in ('hot-100', 'country-songs', 'dance-electronic-songs', 'rock-songs', 'christian-songs', 'pop-songs' )";
	    }
	    else
	    {
		$whr .= " and chart in ('latin-songs', 'r-and-b-songs', 'rap-song' )";
	    }
	if( $fromweek )
	    {
		$from = date( "Y-m-d", $fromweek );
		$whr .= " and thedate >= '$from'";
	    }
	if( $toweek )
	    {
		$to = date( "Y-m-d", $toweek );
		$whr .= " and thedate <= '$to'";
	    }

	$cols = array();
	$cols[] = "title"; 
	$cols[] = "artist"; 
	$cols[] = "charts"; 
	$rows = db_query_rows( "select title, artist, group_concat( distinct( chart ) ) as charts from dbi360_admin.billboardinfo where $whr and concat( artist, '-', title ) not in ( select concat( BillboardArtistName, '-', BillboardName ) from  accipher_admin.songs ) and thedate = '$date' group by artist, title" );

	header("Content-type: text/csv");
	header("Cache-Control: no-store, no-cache");
	header('Content-Disposition: attachment; filename="missingsongs.csv"');
	
	$handle = fopen("php://output", "w");
	fputcsv( $handle, $cols );
	foreach( $rows as $a )
	    {
		$tmp = array();
		foreach( $cols as $c )
		    $tmp[] = $a[$c];
		fputcsv( $handle, $tmp );
	    }
	
	fclose( $handle );
	exit;
	
	
    }

//include "nav.php";

?>

<form method='post'>
<h3>Missing Songs</h3>
<table>
<tr><td><input type='radio' name='maincharts' value='1' checked> Main Charts (Hot 100, Country, Top 40, Dance, Rock, Christian)<br>
<input type='radio' name='maincharts' value='0'> Extra Charts (Latin, R&B, Rap)<br>

<tr><td><input type='submit' name='go' value='Go'></td></tr>
</table>

