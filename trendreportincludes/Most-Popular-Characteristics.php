<?php
// Glance
?>
  <!--  <p class="sub-title">This section spotlights the key compositional characteristics of all the songs that charted in the Hot 100 Top 10 during <?=$rangedisplay?>.</p>-->
        <!-- First list-->
        <h3>Most Popular Compositional Characteristics (<?=$rangedisplay?>):</h3>
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
