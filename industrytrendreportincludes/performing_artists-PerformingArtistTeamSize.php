<? 
$genrefilter = "";
$sectionname = "Performing Artist Team Size";
$displname = "Performing Artist Team Size";
//file_put_contents( "/tmp/hmm", "STARTING SUBGENRES \n", FILE_APPEND );
?>
        <div class="graph-wrap">
<? $specificgraphtype = "column"; ?>
<? 
$overtitle = "$displname: {$rangedisplay}";
$songstouse = array( "Top 10"=>array(), "#1"=>$allsongsnumber1 ); 
?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3>
<? include "industrytrendreportincludes/genericgraph.php"; ?>
</div>

<?php

if( !$doingweeklysearch ) 
{
$genrefilter ="";
$labelfilter = "";

$specificgraphtype = "line"; 
$songstouse = array();
$overtitle = "$displname (Top 10): Q{$oldestq} {$oldesty} - Q{$quarter} {$year}";
$extgraphnote = "(Top 10)";
if( $doingyearlysearch )
{
	$overtitle = "$displname (Top 10): {$rangedisplay}";
}
?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3>
<hr />


<? include "industrytrendreportincludes/genericgraph.php"; ?>
</div>
<? 
$specificgraphtype = "line";
$overtitle = "$displname (#1 Hits): Q{$oldestq} {$oldesty} - Q{$quarter} {$year}";
if( $doingyearlysearch )
{
	$overtitle = "$displname (#1 Hits): {$rangedisplay}";
}
$specificpeak = 1;
$extgraphnote = "(#1 Hits)"; 
?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3><hr />

<? include "industrytrendreportincludes/genericgraph.php"; ?>
</div>
<? $specificpeak = ""; ?>
        </div>
<? } ?>
