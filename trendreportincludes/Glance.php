<? 
// Glance
?>
        <!-- First list-->
        <h3>Most Popular Compositional Characteristics:</h3>
    <ul class="listB">
<?php
$characteristics = gatherCharacteristicsSingleQuarter( $thisquarter, "most");
if( !count( $characteristics ) )
    $characteristics[ "None"] = "";
 foreach( $characteristics as $c=>$displ ) { ?>
    <li>
<span><span><?=$c?></span> <?=$displ?></span></li>
<? } ?>
    </ul>
    <? if( 1 == 0 ) { ?> 
              <!-- Second list-->
        <h3>Least Popular Characteristics:</h3>
    <ul class="listB">
<?php
$characteristics = gatherCharacteristicsSingleQuarter( $thisquarter, "least");
if( !count( $characteristics ) )
    $characteristics[ "None"] = "";
 foreach( $characteristics as $c=>$displ ) { ?>
    <li>
<span><span><?=$c?></span> <?=$displ?></span></li>
<? } ?>
    </ul>
          <? } ?>
<? if( !$doingyearlysearch && !$doingweeklysearch ) { ?>
         <!-- Third list-->
          <h3>Multi-Quarter Upward Trends:</h3>
    <p class="subtitle">Increased in prominence for two or more quarters</p>
    <ul class="listB">
<?php
$characteristics = gatherCharacteristicsMultipleQuarters( $multiquarter, "upward");
if( !count( $characteristics ) )
    $characteristics[ "None"] = "";
 foreach( $characteristics as $c=>$displ ) { ?>
    <li>
<span><span><?=$c?></span> <?=$displ?></span></li>
<? } ?>
    </ul>
            <!-- Fourth list-->
          <h3>Multi-Quarter Downward Trends</h3>
        <p class="subtitle">Decreased in prominence for two or more quarters</p>
    <ul class="listB">
<?php
$characteristics = gatherCharacteristicsMultipleQuarters( $multiquarter, "downward");
if( !count( $characteristics ) )
    $characteristics[ "None"] = "";
 foreach( $characteristics as $c=>$displ ) { ?>
    <li>
<span><span><?=$c?></span> <?=$displ?></span></li>
<? } ?>
    </ul>
            <!-- sixth list-->
<? if( !$newcarryfilter ) { ?>    
                      <!-- Eigth list-->
          <h3>Gone</h3>
     <p class="subtitle">Do not appear in the Top 10 in Q<?=$quarter?>/<?=$year?> after appearing the preceding quarter</p>
    <ul class="listB">
<?php
     $characteristics = gatherCharacteristics2Quarters( $quarter, $year, $prevq, $prevyear, "gone");
if( !count( $characteristics ) )
    $characteristics[ "None"] = "";
 foreach( $characteristics as $c=>$displ ) { ?>
    <li>
<span><span><?=$c?></span> <?=$displ?></span></li>
<? } ?>
    </ul>
                     <!-- ninth list-->
          <h3>New</h3>
    <p class="subtitle">New or returned to the Top 10 after not appearing the preceding quarter</p>
    <ul class="listB">
<?php
     $characteristics = gatherCharacteristics2Quarters( $quarter, $year, $prevq, $prevyear, "back");
if( !count( $characteristics ) )
    $characteristics[ "None"] = "";
 foreach( $characteristics as $c=>$displ ) { ?>
    <li>
<span><span><?=$c?></span> <?=$displ?></span></li>
<? } ?>
    </ul>
	  <? } ?>
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
<? } ?>
