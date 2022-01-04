<? 
// needs work

$songstouse = array();
$sectionname = "Producers and Production Teams that Appear in the Top 10 for the First Time in Four or More Quarters";
?>
            <div class="search-body">
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table1" class="sortable">
             <tbody>
            		<tr>
            			<th >Producer / Production Team <br><i>(click on column title to sort)</i></th>
		       	  </tr>
<?php
$thisquarterid = calculateQuarterNumber($search[dates][fromq], $search[dates][fromy] );
$threeago = $thisquarterid - 3;
$oneago = $thisquarterid - 1;

$producersinthepast = db_query_array( "select producerid from song_to_producer a, song_to_weekdate w, weekdates wd where wd.id = w.weekdateid and a.songid = w.songid and wd.QuarterNumber >= $threeago and wd.QuarterNumber <= $oneago  ", "producerid", "producerid" );
$producersinthepast[] = -1;

$nonesongs = db_query_array( "select producers.Name, producers.id from producers, song_to_producer a where producers.id = a.producerid and songid not in ( select songid from song_to_producer where producerid in ( ". implode( ", ", $producersinthepast ). " ) ) and songid in ( $allsongsstr ) order by Name ", "id", "Name" );
		  
foreach( $nonesongs as $n=>$nsong )
{
?>
<tr><td><a  href='search-results.php?<?=$urldatestr?>&search[producer]=<?=urlencode( $nsong )?>&'><?=$nsong?></a></td></tr>
</tr>
<?php
}
?>
		  </tbody>
</table>
</div>