<? 
?>
            <div class="search-body">
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>

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
            	</div>           
