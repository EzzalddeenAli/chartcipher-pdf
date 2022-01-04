    
                      <!-- Eigth list-->
          <h3>Gone</h3>
     <p class="subtitle">Do not appear in the Top 10 in <?=$rangedisplay?> after appearing the preceding quarter</p>
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
