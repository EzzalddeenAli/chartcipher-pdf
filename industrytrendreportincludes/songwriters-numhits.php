<?php
$allartists = db_query_rows( "select artistid, Name, count(*) as cnt from song_to_artist, artists where artists.id = artistid and type in ( 'creditedsw' ) and songid in ( $allsongsstr ) group by artistid, Name ", "Name" );
$allgroups = db_query_rows( "select groupid, Name, count(*) as cnt  from song_to_group, groups where groups.id = groupid and type in ( 'creditedsw' ) and songid in ( $allsongsstr ) group by groupid, Name ", "Name" );

$tmpallartistsnumber1 = db_query_array( "select artistid, Name, count(*) as cnt from song_to_artist, artists where artists.id = artistid and type in ( 'creditedsw' ) and songid in ( $allsongsnumber1str ) group by artistid, Name ", "Name", "cnt" );
$tmpallgroupsnumber1 = db_query_array( "select groupid, Name, count(*) as cnt  from song_to_group, groups where groups.id = groupid and type in ( 'creditedsw' ) and songid in ( $allsongsnumber1str ) group by groupid, Name ", "Name", "cnt" );

$allartists = array_merge( $allartists, $allgroups );
ksort( $allartists );
?>
                    <div class="search-body">
    <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
                    <table id="table1" class="sortable">
                     <tbody>
                    		<tr>
    <th >Songwriter<br><i>(click on column title to sort)</i></th>
    <th class="sorttable_numeric" >Top 10 Hits<br><i>(click on column title to sort)</i></th>
    <th class="sorttable_numeric">#1 Hits<br><i>(click on column title to sort)</i></th>
                    	  </tr>
<? foreach( $allartists as $artistname=>$row ) {
    if( $row[artistid] )
	$num1 = $tmpallartistsnumber1[$artistname];
    else
	$num1 = $tmpallgroupsnumber1[$artistname];
    ?>
                    	  <tr>
                    	  	<td class=""><?=( $row[Name] )?></td>
                    	  	<td class=""><a  href="/search-results.php?search[writer]=<?=$artistname?>&<?=$urldatestr?>"><?=number_format( $row[cnt] )?></a></td>
    <? if( $num1 ) { ?>
                    	  	<td class=""><a  href="/search-results.php?search[writer]=<?=$artistname?>&<?=$urldatestr?>&search[peakwithin]=1"><?=$num1?></a></td>
                     <? } else { ?>
                                 <td class="">0</td>
                                 <? } ?>

                    	  </tr>
<? } ?>
                    	  </tbody>
                    	</table>
</div>
