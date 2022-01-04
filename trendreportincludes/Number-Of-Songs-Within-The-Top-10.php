<? 
// Number Of Songs Within The Top 10

?>
<? include "trendreportincludes/genericgraph.php"; ?>

         <div class="row">
             <div class="col-4"> 
            <h3>Total Songs</h3>
            <ul class="listB">
            <li><span><?=count( $allsongs )?> Songs</span></li>
            </ul>
             </div>
             <div class="col-4">
            <h3>New Songs</h3>
            <ul class="listB">
<? 
foreach( $newarrivals as $cid=>$newname ) { 
?>
            <li><span><?=getSongnameFromSongid( $cid )?></span></li>
<? } 
?> 
            </ul>
             </div>
             <div class="col-4">
            <h3>Previous Quarter Carryovers</h3>
            <ul class="listB">
<? 
foreach( $carryovers as $cid ) { 
?>
            <li><span><?=getSongnameFromSongid( $cid )?></span></li>
<? } 
?> 
               </ul>
             </div>
        </div>
