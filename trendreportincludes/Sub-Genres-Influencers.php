<? 
// Sub-Genres-Influencers 
?>
<? include "trendreportincludes/genericgraph.php"; ?>
<? 
if( $_GET["help2"] || isDev())
{
$fromtrend = 1;
$specificgraphtype = "column";
$genrefilter = "";
$sectionname = "Sub-Genres/Influences";
$displname = "Sub-Genres/Influences";
$extrgraphname = "num1";
//file_put_contents( "/tmp/hmm", "STARTING SUBGENRES \n", FILE_APPEND );
?>

<? $specificgraphtype = "column"; ?>
<?
$extrgraphname = "num3";
if( !$doingyearlysearch ) { 
$songstouse = array( "New Songs" => array_keys( $newarrivals ), "Carryovers"=> array_keys( $carryovers ) );
//print_r( $songstouse );
$overtitle = "$displname: New Songs vs. Carryovers ({$rangedisplay})";
?>
<? include "industrytrendreportincludes/genericgraph.php"; ?>
<div id='extranote'> Note: Songs may have more than one sub-genre/influence.</div>
<? } ?>

<? 
unset( $songstouse );
$barname = "";
$specificgraphtype = "column"; 
$sectionname = "Sub-Genres/Influences";
$rowname = "Sub-Genre/Influence";
$songstouse = array();
$songstouse = $genresongs;
$extrgraphname = "num4";
$overtitle = "$displname By Primary Genre ($rangedisplay)";
$keynames = $allgenres;
$extratext = " Note: Note that songs may have more than one sub-genre/influence." ;
include "industrytrendreportincludes/generictable.php"; 
$overtitle = "";
$extratext = "";
$extrgraphname = "";
unset( $songstouse );
?>


<? } ?>