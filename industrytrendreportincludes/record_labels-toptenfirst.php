<? 
// needs work

$songstouse = array();
$sectionname = "Record Labels that Appear in the Top 10 for the First Time in Four or More Quarters";
?>
            <div class="search-body">
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table1" class="sortable">
             <tbody>
            		<tr>
            			<th >Record Label <br><i>(click on column title to sort)</i></th>
		       	  </tr>
<?php
$thisquarterid = calculateQuarterNumber($search[dates][fromq], $search[dates][fromy] );
$threeago = $thisquarterid - 3;
$oneago = $thisquarterid - 1;

$labelsinthepast = db_query_array( "select labelid from song_to_label a, song_to_weekdate w, weekdates wd where wd.id = w.weekdateid and a.songid = w.songid and wd.QuarterNumber >= $threeago and wd.QuarterNumber <= $oneago  ", "labelid", "labelid" );
$labelsinthepast[] = -1;

$nonesongs = db_query_array( "select labels.Name, labels.id from labels, song_to_label a where labels.id = a.labelid and labelid not in ( ". implode( ", ", $labelsinthepast ). " ) and songid in ( $allsongsstr ) order by Name ", "id", "Name" );
		  
foreach( $nonesongs as $n=>$nsong )
{
?>
<tr><td><a  href='search-results.php?<?=$urldatestr?>&search[label]=<?=urlencode( $nsong )?>&'><?=$nsong?></a></td></tr>
</tr>
<?php
}
if( !count( $nonesongs ) )
{
	echo( "<tr><td>None</tD></tr>" );
}
?>
		  </tbody>
</table>
<div id='extranote'> Note: Some songs are affiliated with more than one label</div>
</div>