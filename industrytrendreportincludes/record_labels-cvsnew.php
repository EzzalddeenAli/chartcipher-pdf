<? 

$labels = db_query_array( "select labels.id, Name from labels, song_to_label where labelid = labels.id and songid in ( $allsongsstr ) order by Name", "id", "Name" );



?>
                            <div class="search-body">
<h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
                            <table id="table1" class="sortable">
                             <tbody>
                            		<tr>
                            			<th >Record Label  <br><i>(click on column title to sort)</i></th>
                	            	  <th class="">New (# of songs) <br><i>(click on column title to sort)</i></th>
                	            	    <th class="">Carryovers (# of songs)  <br><i>(click on column title to sort)</i></th>
                            	  </tr>
<? 
$baselink = calcTrendQSStartBar();
$tmpcarryarr = db_query_array( "select count( distinct( songid )) as cnt, labelid from song_to_label where songid in ( $allsongsstr ) and songid in ( " . implode( ", " , $prevsongs ) . " ) group by labelid ", "labelid", "cnt" );
if( $doingweeklysearch || $doingyearlysearch )
    $tmpnewarr = db_query_array( "select count( distinct( songid )) as cnt, labelid from song_to_label, songs where songs.id = songid and  songid in ( $allsongsstr ) and WeekEnteredTheTop10 in ( $weekdatesstr )  group by labelid", "labelid", "cnt" );
else
    $tmpnewarr = db_query_array( "select count( distinct( songid )) as cnt, labelid from song_to_label, songs where songs.id = songid and  songid in ( $allsongsstr ) and QuarterEnteredTheTop10 = '{$search[dates][fromq]}/{$search[dates][fromy]}' group by labelid", "labelid", "cnt" );

foreach( $labels as $lid=>$name ) { 

    $carry = $tmpcarryarr[$lid]; //db_query_first_cell( "select count( distinct( songid )) from song_to_label where songid in ( $allsongsstr ) and songid in ( " . implode( ", " , $prevsongs ) . " ) and labelid = '$lid' " );
if( $doingweeklysearch || $doingyearlysearch )
{
    $new = $tmpnewarr[$lid]; //db_query_first_cell( "select count( distinct( songid )) from song_to_label, songs where songs.id = songid and  songid in ( $allsongsstr ) and WeekEnteredTheTop10 in ( $weekdatesstr )  and labelid = '$lid'" );
}
else
{
    $new = $tmpnewarr[$lid]; //db_query_first_cell( "select count( distinct( songid )) from song_to_label, songs where songs.id = songid and  songid in ( $allsongsstr ) and QuarterEnteredTheTop10 = '{$search[dates][fromq]}/{$search[dates][fromy]}'  and labelid = '$lid'" );
}


?>
                            	  <tr>
                            	  	<td class=""><a  href='search-results.php?<?=$baselink?>&search[labelid]=<?=$lid?>'><?=$name?></a></td>
<? if( $new > 0 ) { ?>
                            	  	<td class=""><a  href='search-results.php?<?=$baselink?>&search[labelid]=<?=$lid?>&search[toptentype]=New Songs'><?=$new?></a></td>
<? } else { ?>
<td>0 </td>
<? } ?>
                            	  	<td class="">
<? if( $carry > 0 ) { ?>
<a  href='search-results.php?<?=$baselink?>&search[labelid]=<?=$lid?>&search[toptentype]=Carryovers'><?=$carry?></a>
<? } else { ?>
0 
<? } ?>
</td>
                            	  </tr>
<? } ?>
                            	  </tbody>
                            	</table>
<div id='extranote'> Note: Some songs are affiliated with more than one label</div>
                            	</div>           
