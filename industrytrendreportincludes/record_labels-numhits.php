<?php
$alllabels = db_query_rows( "select labelid, Name, count(*) as cnt from song_to_label, labels where labels.id = labelid and songid in ( $allsongsstr ) group by labelid, Name ", "Name" );
$tmpalllabels1 = db_query_rows( "select labelid, Name, count(*) as cnt from song_to_label, labels where labels.id = labelid and songid in ( $allsongsnumber1str ) group by labelid, Name ", "labelid" );
//print_r($tmpalllabels1);
$alllabels = array_merge( $alllabels, $allgroups );
ksort( $alllabels );
?>
                    <div class="search-body">
    <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
                    <table id="table1" class="sortable">
                     <tbody>
                    		<tr>
    <th >Record Label<br><i>(click on column title to sort)</i></th>
    <th class="sorttable_numeric" >Top 10 Hits<br><i>(click on column title to sort)</i></th>
    <th class="sorttable_numeric">#1 Hits<br><i>(click on column title to sort)</i></th>
                    	  </tr>
<? foreach( $alllabels as $labelname=>$row ) {
    $num1 = $tmpalllabels1[$row[labelid]]["cnt"];
    ?>
                    	  <tr>
                    	  	<td class=""><?=( $row[Name] )?></td>
                    	  	<td class=""><a  href="/search-results.php?search[label]=<?=$labelname?>&<?=$urldatestr?>"><?=number_format( $row[cnt] )?></a></td>
    <? if( $num1 ) { ?>
                    	  	<td class=""><a  href="/search-results.php?search[label]=<?=$labelname?>&<?=$urldatestr?>&search[peakwithin]=1"><?=$num1?></a></td>
                     <? } else { ?>
                                 <td class="">0</td>
                                 <? } ?>

                    	  </tr>
<? } ?>
                    	  </tbody>
                    	</table>

<div id='extranote'> Note: Some songs are affiliated with more than one label</div>
</div>