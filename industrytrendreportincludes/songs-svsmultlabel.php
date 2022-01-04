        <div class="graph-wrap">
<? 
$songstouse = array( "Top 10"=>array(), "#1"=>$allsongsnumber1 ); 
$overtitle = "Songs with Single vs. Multiple Labels: $rangedisplay";
$sectionname = "Songs with Single vs. Multiple Labels";
$specificgraphtype = "column";
if( !$doingweeklysearch  && !$doingyearlysearch )
    $extgraphnote = "(Quarter)";
else
    $extgraphnote = "";
include "industrytrendreportincludes/genericgraph.php"; 

?>
</div>
<div id="extranote"> Note: Multiple Labels reflects songs that are affiliated with more than one record label.</div>
<?php
$genrefilter = $labelfilter = ""; 
$songstouse = array();
if( !$doingweeklysearch ) { 
$sectionname = "Songs with Single vs. Multiple Labels";
$specificgraphtype = "line"; 
$overtitle = "Songs with Single vs. Multiple Labels: Q{$oldestq} {$oldesty} - Q$quarter $year";
if( $doingyearlysearch )
{
	$overtitle = "Songs with Single vs. Multiple Labels: {$rangedisplay}";
}
$extgraphnote = "(Year)";
?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3>
    <hr />
<a class='backtotop' href='#'>Back To Top</a>
<? include "industrytrendreportincludes/genericgraph.php"; ?>
<div id="extranote"> Note: Multiple Labels reflects songs that are affiliated with more than one record label.</div>
</div>
<? } ?>