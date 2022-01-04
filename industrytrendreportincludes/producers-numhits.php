<?php
$allproducers = db_query_rows( "select producerid, Name, count(*) as cnt from song_to_producer, producers where producers.id = producerid and songid in ( $allsongsstr ) group by producerid, Name ", "Name" );

$tmpallproducers = db_query_rows( "select producerid, Name, count(*) as cnt from song_to_producer, producers where producers.id = producerid and songid in ( $allsongsnumber1str ) group by producerid, Name ", "producerid" );

$allproducers = array_merge( $allproducers, $allgroups );
ksort( $allproducers );
?>
                    <div class="search-body">
    <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
                    <table id="table1" class="sortable">
                     <tbody>
                    		<tr>
    <th >Producer / Production Team<br><i>(click on column title to sort)</i></th>
    <th class="sorttable_numeric" >Top 10 Hits<br><i>(click on column title to sort)</i></th>
    <th class="sorttable_numeric">#1 Hits<br><i>(click on column title to sort)</i></th>
                    	  </tr>
<? foreach( $allproducers as $producername=>$row ) {
        $num1 = $tmpallproducers[$row[producerid]]["cnt"];

    ?>
                    	  <tr>
                    	  	<td class=""><?=( $row[Name] )?></td>
                    	  	<td class=""><a  href="/search-results.php?search[producer]=<?=$producername?>&<?=$urldatestr?>"><?=number_format( $row[cnt] )?></a></td>
    <? if( $num1 ) { ?>
                    	  	<td class=""><a  href="/search-results.php?search[producer]=<?=$producername?>&<?=$urldatestr?>&search[peakwithin]=1"><?=$num1?></a></td>
                     <? } else { ?>
                                 <td class="">0</td>
                                 <? } ?>

                    	  </tr>
<? } ?>
                    	  </tbody>
                    	</table>
</div>