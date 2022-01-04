<? 
// needs work

$songstouse = array();
$sectionname = "Artists that Appear in the Top 10 for the First Time in Four or More Quarters";
?>
            <div class="search-body">
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table1" class="sortable">
             <tbody>
            		<tr>
            			<th >Artist/Group <br><i>(click on column title to sort)</i></th>
		       	  </tr>
<?php
$thisquarterid = calculateQuarterNumber($search[dates][fromq], $search[dates][fromy] );
$threeago = $thisquarterid - 3;
$oneago = $thisquarterid - 1;

$artistsinthepast = db_query_array( "select artistid from song_to_artist a, song_to_weekdate w, weekdates wd where wd.id = w.weekdateid and a.songid = w.songid and wd.QuarterNumber >= $threeago and wd.QuarterNumber <= $oneago and a.type in ( 'primary', 'featured' ) ", "artistid", "artistid" );

$groupsinthepast = db_query_array( "select groupid from song_to_group a, song_to_weekdate w, weekdates wd where wd.id = w.weekdateid and a.songid = w.songid and wd.QuarterNumber >= $threeago and wd.QuarterNumber <= $oneago and a.type in ( 'primary', 'featured' ) ", "groupid", "groupid" );

$nonesongs = db_query_array( "select artists.Name, artists.id from artists, song_to_artist a where artists.id = a.artistid and type in ( 'primary', 'featured' ) and artistid not in ( ". implode( ", ", $artistsinthepast ). " ) and songid in ( $allsongsstr ) order by Name ", "Name", "Name" );
$nonesongs2 = db_query_array( "select groups.Name, groups.id from groups, song_to_group a where groups.id = a.groupid and type in ( 'primary', 'featured' ) and groupid not in ( ". implode( ", ", $groupsinthepast ). " ) and songid in ( $allsongsstr ) order by Name ", "Name", "Name" );

$nonesongs = array_merge( $nonesongs, $nonesongs2 );
ksort( $nonesongs );

foreach( $nonesongs as $n=>$nsong )
{
?>
<tr><td><a  href='search-results.php?<?=$urldatestr?>&search[primaryartist]=<?=urlencode( $nsong )?>&'><?=$nsong?></a></td></tr>
</tr>
<?php
}
?>
		  </tbody>
</table>
</div>
