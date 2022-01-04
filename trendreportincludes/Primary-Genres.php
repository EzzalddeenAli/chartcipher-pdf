<? 
// Primary-Genres 
?>
<? include "trendreportincludes/genericgraph.php"; ?>
<?

if( !$doingweeklysearch  && !$doingyearlysearch && ($_GET["help2"]|| isDev()) ) { 

 $specificpeak = "";
 $specificgraphtype = "column"; 

    $newarrivals = db_query_array( "select songs.id, songnames.Name from songs, songnames where {$GLOBALS[clientwhere]} and songnameid = songnames.id and QuarterEnteredTheTop10 = '{$quarter}/{$year}' order by Name ", "id", "id" );
$carryovers = array_diff( $allsongs, $newarrivals );

//$gone = array_diff( $prevsongs, $allsongs );

$displname = "Primary Genres";
$songstouse = array( "New Songs" => array_keys( $newarrivals ), "Carryovers"=> array_keys( $carryovers ) );
$overtitle = "$displname: New Songs vs. Carryovers ({$rangedisplay})";
$extrgraphname = "nsvc";	   
$fromtrend = 1;
?>
<? include "industrytrendreportincludes/genericgraph.php"; ?>
<? 
unset( $songstouse );
$fromtrend = 0;
$extrgraphname = "";
$songstouse = "";
 ?>
      <? } ?>

