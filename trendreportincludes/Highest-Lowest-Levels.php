           <!-- tenth list-->
     <h3>Highest Level In Four Or More Quarters</h3>  
            <!-- eleventh list-->
          <p class="subtitle">Reached their highest level in four or more quarters</p>
    <ul class="listB">
<?php
$characteristics = gatherCharacteristicsMultipleQuarters( $quarterstorun, "highest");
if( !count( $characteristics ) )
    $characteristics[ "None"] = "";
 foreach( $characteristics as $c=>$displ ) { 
 if( $displ == "No" ) continue; ?>
    <li>
<span><span><?=$c?></span> <?=$displ?></span></li>
<? } ?>
    </ul> 
                    <!-- twelfth list-->
     <h3>Lowest Level In Four Or More Quarters</h4</h3>  
          <p class="subtitle">Reached their lowest level in four or more quarters</p>
    <ul class="listB">
<?php
$characteristics = gatherCharacteristicsMultipleQuarters( $quarterstorun, "lowest");
if( !count( $characteristics ) )
    $characteristics[ "None"] = "";
 foreach( $characteristics as $c=>$displ ) { 
 if( $displ == "No" ) continue; ?>
    <li>
<span><span><?=$c?></span> <?=$displ?></span></li>
<? } ?>
    </ul> 
