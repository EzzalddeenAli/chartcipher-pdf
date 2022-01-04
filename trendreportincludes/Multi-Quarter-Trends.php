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
