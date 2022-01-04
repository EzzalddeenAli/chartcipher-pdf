<? 
$genrefilter = "";
$sectionname = "Solo vs. Multiple Lead Vocalists";
$displname = "Lead Vocal: Solo vs. Multiple Lead Vocalists";
$dontincludeall = true;
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

<? $specificgraphtype = "column"; ?>
<?php
if( !$doingweeklysearch  && !$doingyearlysearch ) { 
$songstouse = array( "New Songs" => array_keys( $newarrivals ), "Carryovers"=> array_keys( $carryovers ) );
$overtitle = "$displname: New Songs vs. Carryovers - {$rangedisplay}";
$extgraphnote = "New Vs Carryovers";
?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3><hr />
    <!--<a class='backtotop' href='#'>Back To Top</a>-->
<? include "industrytrendreportincludes/genericgraph.php"; ?>
</div>
<? 
}
$barname = "";
$genrefilter ="";
$labelfilter = "";
?>
<? 
if( !$doingweeklysearch ) { 
$specificgraphtype = "line"; 
$songstouse = array();
$extgraphnote = "(Top 10)";
$overtitle = "$displname (Top 10): Q{$oldestq} {$oldesty} - Q{$quarter} {$year}";
if( $doingyearlysearch )
    $overtitle = "$displname (Top 10): {$rangedisplay}";
?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3><hr>
    <!--<a class='backtotop' href='#'>Back To Top</a>-->
<? include "industrytrendreportincludes/genericgraph.php"; ?>
</div>
<? 
//file_put_contents( "/tmp/hmm", "AFTER FIRST? \n", FILE_APPEND );
$specificgraphtype = "line";
$overtitle = "$displname (#1 Hits): Q{$oldestq} {$oldesty} - Q{$quarter} {$year}";
if( $doingyearlysearch )
    $overtitle = "$displname (#1 Hits): {$rangedisplay}";
$specificpeak = 1;
$extgraphnote = "(#1 Hits)";
 ?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3><hr />
    <!--<a class='backtotop' href='#'>Back To Top</a>-->
<? include "industrytrendreportincludes/genericgraph.php"; ?>
</div>
        </div>
<?php
} 
 $specificpeak = ""; 
?>
