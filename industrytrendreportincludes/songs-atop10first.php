<? 
$songstouse = array();
?>
            <div class="search-body">
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table1" class="sortable">
             <tbody>
            		<tr>
            			<th >Song <br><i>(click on column title to sort)</i></th>
            			<th >Artist/Group <br><i>(click on column title to sort)</i></th>
		       	  </tr>
<?php
$thisquarterid = calculateQuarterNumber($search[dates][fromq], $search[dates][fromy] );
$threeago = $thisquarterid - 3;
$oneago = $thisquarterid - 1;

$artistsinthepast = db_query_array( "select artistid from song_to_artist a, song_to_weekdate w, weekdates wd where wd.id = w.weekdateid and a.songid = w.songid and wd.QuarterNumber >= $threeago and wd.QuarterNumber <= $oneago and a.type in ( 'primary', 'featured' ) ", "artistid", "artistid" );
$groupsinthepast = db_query_array( "select groupid from song_to_group a, song_to_weekdate w, weekdates wd where wd.id = w.weekdateid and a.songid = w.songid and wd.QuarterNumber >= $threeago and wd.QuarterNumber <= $oneago and a.type in ( 'primary', 'featured' ) ", "groupid", "groupid" );

$nonesongs = db_query_array( "select CleanUrl, SongNameHard as Name from songs where songs.id not in ( select songid from song_to_artist where artistid in ( ". implode( ", ", $artistsinthepast ). " ) and type in ( 'primary', 'featured' ) ) and songs.id not in ( select songid from song_to_group where groupid in ( ". implode( ", ", $groupsinthepast ). " ) and type in ( 'primary', 'featured' ) ) and songs.id in ( $allsongsstr ) order by Name ", "CleanUrl", "Name" );
		  
foreach( $nonesongs as $n=>$nsong )
{
?>
<tr><td><a  href='<?=$n?>'><?=$nsong?></a></td>
<td>
        <?php
	$songid = db_query_first_cell( "select id from songs where CleanUrl = '$n' " );
        $frontendfieldname = "primaryartist";
        $frontendlinks = true;	   
        $frontenduseid = false;
        $any = false; 
        $artists = getArtists( $songid );
        if( $artists )
            $any = true;
        echo( $artists );
        $artists = getGroups( $songid );
        if( $any && $artists ) echo( ", " );
        if( $artists )
            $any = true;
        echo( $artists );
        $artists = getArtists( $songid, "featured" );
        if( $artists ) { ?> 
            featuring <?=$artists?>
                <? }
        $artists = getGroups( $songid, "featured" );
        if( $artists ) { ?> 
            feat. <?=$artists?>
                <? }
        $frontendlinks = false;	   
 ?>
</td>
</tr>
<?php
}
?>
		  </tbody>
</table>
</div>