<? 

include "connect.php";

 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }


if( $go )
{
$songs = db_query_array( "select songnames.name, songs.id  from songs, songnames where songs.songnameid = songnames.id order by name", "id", "name" );
//print_r( $songs );exit;
$allcharts = db_query_array( "select chartkey, chartname from charts", "chartkey", "chartname");
header("Content-type: text/csv");
header("Cache-Control: no-store, no-cache");
header('Content-Disposition: attachment; filename="allchartinfo.csv"');

$headerrow = array();
$headerrow[] =  "songid" ;
foreach( $allcharts as $a ) $headerrow[] = $a;
$handle = fopen("php://output", "w");
fputcsv( $handle, $headerrow );
foreach( $songs as $songid=>$songname )
    {
	$tmp = array();
	$tmp[] = $songname;
	$thesecharts = db_query_array( " select min( peakpos ) as peakpos, chart from billboardinfo where songid = $songid group by chart", "chart", "peakpos" ); 
	
	foreach( $allcharts as $c=>$displ )
	    {
		$tmp[] = $thesecharts[$c]?$thesecharts[$c]:"";
	    }
	fputcsv( $handle, $tmp );
    }

fclose( $handle );
exit;

}


include "nav.php";
?>
<h3>HSD Chart Info</h3>
<form method='post'>
<input type='submit' name='go' value='Download Export'>
</form>
<? include "footer.php"; ?>
