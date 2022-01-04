<? 
$genrefilter = "";
$sectionname = "Sub-Genres/Influences";
$displname = "Sub-Genres/Influences";
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
<div id='extranote'> Note: Songs may have more than one sub-genre/influence.</div>
</div>

<? 
if( !$doingweeklysearch ) { 
$barname = "";
$genrefilter = $labelfilter = ""; 
$sectionname = "Sub-Genres/Influences";
$songstouse = array();
$specificgraphtype = "line"; 
$songstouse = array();
$overtitle = "$displname (Top 10): Q{$oldestq} {$oldesty} - Q{$quarter} {$year}";
$extgraphnote = "(Top 10)";
if( $doingyearlysearch )
    $overtitle = "$displname (Top 10): {$rangedisplay}";
?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3>
<hr />
 <!--<a class='backtotop' href='#'>Back To Top</a>-->
<? include "industrytrendreportincludes/genericgraph.php"; ?>
<div id='extranote'> Note: Songs may have more than one sub-genre/influence.</div>
</div>

     <? 
//file_put_contents( "/tmp/hmm", "AFTER FIRST? \n", FILE_APPEND );
$specificgraphtype = "line";
$extgraphnote = "(#1 Hits)";
$overtitle = "$displname (#1 Hits): Q{$oldestq} {$oldesty} - Q{$quarter} {$year}";
$specificpeak = 1;
if( $doingyearlysearch )
    $overtitle = "$displname (#1 Hits): {$rangedisplay}";

 ?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3><hr />
  <!--<a class='backtotop' href='#'>Back To Top</a>-->
<? include "industrytrendreportincludes/genericgraph.php"; ?>
<div id='extranote'> Note: Songs may have more than one sub-genre/influence.</div>
</div>
<? $specificpeak = ""; ?>

<? $specificgraphtype = "column"; ?>
<?php
if( !$doingyearlysearch ) { 
$songstouse = array( "New Songs" => array_keys( $newarrivals ), "Carryovers"=> array_keys( $carryovers ) );
$overtitle = "$displname: New Songs vs. Carryovers - {$rangedisplay}";
if( 1 == 0 && count( $returned ) )
    $songstouse["Returned"] = $returned;
    $extgraphnote = "(Returned)";
?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3><hr />
    <!--<a class='backtotop' href='#'>Back To Top</a>-->
<? include "industrytrendreportincludes/genericgraph.php"; ?>
<div id='extranote'> Note: Songs may have more than one sub-genre/influence.</div>

</div>
<? } ?>
<? } ?>
     <div class="Graph-wrap-id"><h3>By Sub-Genre</h3><hr />
    <!--<a class='backtotop' href='#'>Back To Top</a>-->
<? $specificgraphtype = "column"; 
$sectionname = "Sub-Genres/Influences";
$rowname = "Sub-Genre/Influence";
$songstouse = array();
$songstouse = $genresongs;
$overtitle = "$displname: $rangedisplay By Primary Genre";
$keynames = $allgenres;
$extratext = " Note: Note that songs may have more than one sub-genre/influence." ;
include "industrytrendreportincludes/generictable.php"; 
?>
</div>


        </div>
