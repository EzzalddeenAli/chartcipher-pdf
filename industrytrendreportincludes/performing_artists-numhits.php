<?php
$allartists = db_query_rows( "select artistid, Name, sum( case when type = 'primary' then 1 else 0 end ) as cnt, sum( case when type = 'featured' then 1 else 0 end ) as cntfeat from song_to_artist, artists where artists.id = artistid and type in ( 'featured', 'primary' ) and songid in ( $allsongsstr ) group by artistid, Name ", "Name" );
$allgroups = db_query_rows( "select groupid, Name, sum( case when type = 'primary' then 1 else 0 end ) as cnt, sum( case when type = 'featured' then 1 else 0 end ) as cntfeat   from song_to_group, groups where groups.id = groupid and type in ( 'featured', 'primary' ) and songid in ( $allsongsstr ) group by groupid, Name ", "Name" );

$allartists = array_merge( $allartists, $allgroups );
ksort( $allartists );

$tmpallartists1 = db_query_rows( "select artistid, Name, sum( case when type = 'primary' then 1 else 0 end ) as cnt, sum( case when type = 'featured' then 1 else 0 end ) as cntfeat from song_to_artist, artists where artists.id = artistid and type in ( 'featured', 'primary' ) and songid in ( $allsongsnumber1str ) group by artistid, Name ", "Name" );
$tmpallgroups1 = db_query_rows( "select groupid, Name, sum( case when type = 'primary' then 1 else 0 end ) as cnt, sum( case when type = 'featured' then 1 else 0 end ) as cntfeat   from song_to_group, groups where groups.id = groupid and type in ( 'featured', 'primary' ) and songid in ( $allsongsnumber1str ) group by groupid, Name ", "Name" );



?>
                    <div class="search-body">
    <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
                    <table id="table1" class="sortable">
                     <tbody>
                    		<tr>
    <th >Artist/Group<br><i>(click on column title to sort)</i></th>
    <th class="sorttable_numeric" >Top 10 Hits - Main Artist<br><i>(click on column title to sort)</i></th>
    <th class="sorttable_numeric">#1 Hits - Main Artist<br><i>(click on column title to sort)</i></th>
    <th class="sorttable_numeric" >Top 10 Hits - Featured Artist<br><i>(click on column title to sort)</i></th>
    <th class="sorttable_numeric">#1 Hits - Featured Artist<br><i>(click on column title to sort)</i></th>
                    	  </tr>
<? foreach( $allartists as $artistname=>$row ) {
    if( $row[artistid] )
        $num1 = $tmpallartists1[$artistname]["cnt"];
    else
        $num1 = $tmpallgroups1[$artistname]["cnt"];

    if( $row[artistid] )
        $num1f = $tmpallartists1[$artistname]["cntfeat"];
    else
        $num1f = $tmpallgroups1[$artistname]["cntfeat"];

    ?>
                    	  <tr>
                    	  	<td class=""><?=( $row[Name] )?></td>
<? if( $row[cnt] ) { ?>
                    	  	<td class=""><a  href="/search-results.php?search[primaryartistprimary]=<?=$artistname?>&<?=$urldatestr?>"><?=number_format( $row[cnt] )?></a></td>
                     <? } else { ?>
                                 <td class="">0</td>
                                 <? } ?>
    <? if( $num1 ) { ?>
                    	  	<td class=""><a  href="/search-results.php?search[primaryartistprimary]=<?=$artistname?>&<?=$urldatestr?>&search[peakwithin]=1"><?=$num1?></a></td>
                     <? } else { ?>
                                 <td class="">0</td>
                                 <? } ?>
<? if( $row[cntfeat] ) { ?>
                    	  	<td class=""><a  href="/search-results.php?search[primaryartistfeatured]=<?=$artistname?>&<?=$urldatestr?>"><?=number_format( $row[cntfeat] )?></a></td>
                     <? } else { ?>
                                 <td class="">0</td>
                                 <? } ?>
    <? if( $num1f ) { ?>
                    	  	<td class=""><a  href="/search-results.php?search[primaryartistfeatured]=<?=$artistname?>&<?=$urldatestr?>&search[peakwithin]=1"><?=$num1f?></a></td>
                     <? } else { ?>
                                 <td class="">0</td>
                                 <? } ?>

                    	  </tr>
<? } ?>
                    	  </tbody>
                    	</table>
</div>
