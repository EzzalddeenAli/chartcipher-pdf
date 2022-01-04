<? 
// needs work

$songstouse = array();
$sectionname = "Songwriters that Appear in the Top 10 for the First Time in Four or More Quarters";
?>
            <div class="search-body">
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table1" class="sortable">
             <tbody>
            		<tr>
            			<th >Songwriter <br><i>(click on column title to sort)</i></th>
		       	  </tr>
<?php
$thisquarterid = calculateQuarterNumber($search[dates][fromq], $search[dates][fromy] );
$threeago = $thisquarterid - 3;
$oneago = $thisquarterid - 1;

$artistsinthepast = db_query_array( "select artistid from song_to_artist a, song_to_weekdate w, weekdates wd where wd.id = w.weekdateid and a.songid = w.songid and wd.QuarterNumber >= $threeago and wd.QuarterNumber <= $oneago and a.type in ( 'creditedsw' ) ", "artistid", "artistid" );

$nonesongs = db_query_array( "select artists.Name, artists.id from artists, song_to_artist a where artists.id = a.artistid and a.type = 'creditedsw' and artistid not in ( ". implode( ", ", $artistsinthepast ). " ) and songid in ( $allsongsstr ) order by Name ", "id", "Name" );
		  
foreach( $nonesongs as $n=>$nsong )
{
?>
<tr><td><a  href='search-results.php?<?=$urldatestr?>&search[writer]=<?=urlencode( $nsong )?>&'><?=$nsong?></a></td></tr>
</tr>
<?php
}
?>
		  </tbody>
</table>
</div>