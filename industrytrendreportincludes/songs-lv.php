<? 
$genrefilter = "";
$sectionname = "Lead Vocal";
$displname = "Lead Vocal: Gender";
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

<?php
if( !$doingweeklysearch ) {
$barname = "";
$genrefilter ="";
$labelfilter = "";

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
      if( !$doingyearlysearch ) { 
$specificgraphtype = "column"; 
$specificpeak = ""; 
$songstouse = array( "New Songs" => array_keys( $newarrivals ), "Carryovers"=> array_keys( $carryovers ) );
$overtitle = "Lead Vocal Gender: New Songs vs. Carryovers - {$rangedisplay}";
$extgraphnote = "New Vs Carryovers";
?>
        <div class="Graph-wrap-id"><h3><?=$overtitle?></h3><hr />
   <!--<a class='backtotop' href='#'>Back To Top</a>-->
<? include "industrytrendreportincludes/genericgraph.php"; ?>
</div>
<? 
      }
}
$specificpeak = ""; 
$barname = "";
$genrefilter ="";
$labelfilter = "";

?>
