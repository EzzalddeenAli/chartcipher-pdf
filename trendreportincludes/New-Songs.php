<? 
// New Songs
?>
    <p >This section focuses exclusively on songs that entered into the Top 10 for the first time during Q<?=$quarter?> <?=$year?>. The purpose is to show the latest trends independently of the songs that have been in the Top 10 for two or more quarters (i.e. carryovers). The <?=$rangedisplay?> new arrivals were:</p>
    <ul class="listB">
<? foreach( $newarrivals as $newarrid=>$newarrname ) { ?>
    <li><span><span><?=$newarrname?></span></span></li>
<? } ?>
    </ul>
