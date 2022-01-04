<? 
$sectionname = "Primary Genres";
$songstouse = array();
$displname = "Primary Genre";
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
if( !$doingweeklysearch ) { 
$genrefilter = $labelfilter = ""; 
$sectionname = "Primary Genres";
$songstouse = array();
$specificgraphtype = "line"; 
$overtitle = "$displname (Top 10): Q{$oldestq} {$oldesty} - Q{$quarter} {$year}";
if( $doingyearlysearch )
    $overtitle = "$displname (Top 10): {$rangedisplay}";
$extgraphnote = "(Top 10)";
?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3>
    <hr />
<!--<a class='backtotop' href='#'>Back To Top</a>-->
<? include "industrytrendreportincludes/genericgraph.php"; ?>
</div>
<? $specificgraphtype = "line"; ?>
<? 
$extgraphnote = "(#1 Hits)";
$overtitle = "$displname (#1 Hits): Q{$oldestq} {$oldesty} - Q{$quarter} {$year}";
if( $doingyearlysearch )
    $overtitle = "$displname (#1 Hits): {$rangedisplay}";
$specificpeak = 1;
 ?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3><hr />
     <!--<a class='backtotop' href='#'>Back To Top</a>-->
<? include "industrytrendreportincludes/genericgraph.php"; ?>
</div>
<? } ?>
<? $specificpeak = ""; ?>
    <? $specificgraphtype = "column"; ?>
<?php
if( !$doingweeklysearch  && !$doingyearlysearch ) { 

$songstouse = array( "New Songs" => array_keys( $newarrivals ), "Carryovers"=> array_keys( $carryovers ) );
$overtitle = "$displname: New Songs vs. Carryovers - {$rangedisplay}";
?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3><hr />
     <!--<a class='backtotop' href='#'>Back To Top</a>-->
<? include "industrytrendreportincludes/genericgraph.php"; ?>
</div>
      <? } ?>
        </div>
