<? 
$songstouse = array();
?>
            <div class="search-body">
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table1" class="sortable">
             <tbody>
            		<tr>
            			<th >Song <br><i>(click on column title to sort)</i></th>
            			<th >Artist/Songwriter/Producer <br><i>(click on column title to sort)</i></th>
		       	  </tr>
<?php

$sql =( "select concat( songnames.Name, '---', artists.Name ) as CleanUrlArtist, CleanUrl, songnames.Name, artists.Name as ArtistName, count(*) as cnt, group_concat( ' ', sta.type ) as alltypes from songs, songnames, song_to_artist sta, song_to_producer stp, artists where songnames.id = songnameid and songs.id in ( $allsongsstr )  and sta.songid = songs.id and stp.songid = songs.id and sta.type in ( 'creditedsw', 'primary', 'featured' ) and stp.producerid = artists.producerid and artists.id = artistid group by songnames.Name, CleanURL, ArtistName having cnt = 2 order by songnames.Name" );
$nonesongs = db_query_rows( $sql, "CleanUrlArtist" );
$sql =( "select concat( songnames.Name, '---', groups.Name ) as CleanUrlArtist, songnames.Name, groups.Name as GroupName, count(*) as cnt, group_concat( ' ', sta.type ) as alltypes from songs, songnames, song_to_group sta, song_to_producer stp, groups where songnames.id = songnameid and songs.id in ( $allsongsstr )  and sta.songid = songs.id and stp.songid = songs.id and sta.type in ( 'creditedsw', 'primary', 'featured' ) and stp.producerid = groups.producerid and groups.id = groupid group by songnames.Name, CleanURL, GroupName having cnt = 2 order by songnames.Name" );
$nonesongsg = db_query_rows( $sql, "CleanUrlArtist" );

$nonesongs = array_merge( $nonesongs, $nonesongsg );
//print_r( $nonesongs );
ksort( $nonesongs );

//print_r( $nonesongs );		  
foreach( $nonesongs as $nsongrow )
{
    $n = $nsongrow[CleanUrl];
    $nsong = $nsongrow[Name];
?>
<tr><td><a  href='<?=$n?>'><?=$nsong?></a></td>
<td>
<? 
     //     print_r( $nsongrow );
    $typestr = formatTypeStr( trim( $nsongrow["alltypes"] ) );
    echo("$nsongrow[ArtistName] $typestr<br>" );
    ?>
</td>
</tr>
<?php
}
?>
		  </tbody>
</table>
</div>
