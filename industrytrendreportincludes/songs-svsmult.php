        <div class="graph-wrap">
<? 
$songstouse = array( "Top 10"=>array(), "#1"=>$allsongsnumber1 ); 
$overtitle = "Songs with Solo vs. Multiple Artists: $rangedisplay";
$sectionname = "Songs with Solo vs. Multiple Artists";
$specificgraphtype = "column";
$extgraphnote = "(Quarter)";
include "industrytrendreportincludes/genericgraph.php"; 

?>
</div>
<div id="extranote"> Note: Multiple Artists reflects songs that have more than one artist, featured or otherwise. </div>
<?php
if( !$doingweeklysearch ) { 
$genrefilter = $labelfilter = ""; 
$songstouse = array();
$sectionname = "Songs with Solo vs. Multiple Artists";
$specificgraphtype = "line"; 
$overtitle = "Songs with Solo vs. Multiple Artists: Q{$oldestq} {$oldesty} - Q$quarter $year";
if( $doingyearlysearch )
{
	$overtitle = "Songs with Solo vs. Multiple Artists: {$rangedisplay}";
}
$extgraphnote = "(Year)";
?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3>
    <hr />
<!--<a class='backtotop' href='#'>Back To Top</a>-->
<? include "industrytrendreportincludes/genericgraph.php"; ?>
<div id="extranote"> Note: Multiple Artists reflects songs that have more than one artist, featured or otherwise. </div>
</div>
<? } ?>