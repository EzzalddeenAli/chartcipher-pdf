<? 
$genrefilter = "";
$sectionname = "Songwriter Team Size";
$displname = "Songwriter Team Size";
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
$genrefilter ="";
$labelfilter = "";
?>
<? 
$songstouse = array();
if( !$doingweeklysearch )
{
$specificgraphtype = "line"; 
$overtitle = "$displname (Top 10): Q{$oldestq} {$oldesty} - Q{$quarter} {$year}";
if( $doingyearlysearch )
{
	$overtitle = "$displname (Top 10): {$rangedisplay}";
}
$extgraphnote = "(Top 10)";
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
$extgraphnote = "(#1 Hits)";
$specificpeak = 1;
 ?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3><hr />

<? include "industrytrendreportincludes/genericgraph.php"; ?>
</div>
        </div>
<? } ?>
<? $specificpeak = ""; ?>
