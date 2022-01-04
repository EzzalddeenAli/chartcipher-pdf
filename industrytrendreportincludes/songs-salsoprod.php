<? 
$songstouse = array();
?>
            <div class="search-body">
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table1" class="sortable">
             <tbody>
            		<tr>
            			<th >Song <br><i>(click on column title to sort)</i></th>
            			<th >Artist/Producer <br><i>(click on column title to sort)</i></th>
		       	  </tr>
<?php

$sql =( "select CleanUrl, songnames.Name from songs, songnames where songnames.id = songnameid and (songs.id in ( select sta.songid from song_to_artist sta, artists, song_to_producer stp where sta.type in ( 'creditedsw' ) and artists.producerid = stp.producerid and artists.id = sta.artistid and sta.songid = stp.songid ) or songs.id in ( select sta.songid from song_to_group sta, groups, song_to_producer stp where sta.type in ( 'creditedsw' ) and groups.producerid = stp.producerid and groups.id = sta.groupid and sta.songid = stp.songid ) ) and songs.id in ( $allsongsstr ) order by Name" );
//echo( $sql );
$nonesongs = db_query_array( $sql, "CleanUrl", "Name" );
		  
foreach( $nonesongs as $n=>$nsong )
{
?>
<tr><td><a  href='<?=$n?>'><?=$nsong?></a></td>
<td>
        <?php
	$songid = db_query_first_cell( "select id from songs where CleanUrl = '$n' " );
    $sql = ( "select artists.id, Name,  sta.type as type from artists, song_to_artist sta, song_to_producer stp where sta.artistid = artists.id  and sta.songid = $songid and stp.songid = $songid and sta.type in ('creditedsw' ) and stp.producerid = artists.producerid ");
    $artists = db_query_rows( "select artists.id, Name,  sta.type as type from artists, song_to_artist sta, song_to_producer stp where sta.artistid = artists.id  and sta.songid = $songid and stp.songid = $songid and sta.type in ('creditedsw' ) and stp.producerid = artists.producerid ", "Name");
    $groups = db_query_rows( "select groups.id, Name,  sta.type as type from groups, song_to_group sta, song_to_producer stp where sta.groupid = groups.id and sta.songid = $songid and stp.songid = $songid and sta.type in ('creditedsw' ) and stp.producerid = groups.producerid ", "Name");
    $impl = array_merge( $artists, $groups );
    ksort( $impl );
//    echo( $sql . "<br>");
    foreach( $impl as $irow )
    {
        echo("$irow[Name]<br>" );
    }
    ?>
</td>
</tr>
<?php
}
?>
		  </tbody>
</table>
</div>