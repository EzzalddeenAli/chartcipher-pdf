<? 
$songstouse = array();
?>
            <div class="search-body">
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table1" class="sortable">
             <tbody>
            		<tr>
            			<th >Song <br><i>(click on column title to sort)</i></th>
            			<th >Artist/Songwriter <br><i>(click on column title to sort)</i></th>
		       	  </tr>
<?php

$nonesongs = db_query_array( "select CleanUrl, songnames.Name from songs, songnames where songnames.id = songnameid and (songs.id in ( select songid from song_to_artist where type in ( 'creditedsw', 'featured', 'primary' ) group by songid, artistid having count(*) > 1 ) or songs.id in ( select songid from song_to_artist where type in ( 'creditedsw', 'featured', 'primary' ) group by artistid, songid having count(*) > 1 )) and songs.id in ( $allsongsstr ) order by Name ", "CleanUrl", "Name" );
		  
foreach( $nonesongs as $n=>$nsong )
{
?>
<tr><td><a  href='<?=$n?>'><?=$nsong?></a></td>
<td>
        <?php
	$songid = db_query_first_cell( "select id from songs where CleanUrl = '$n' " );
	$sql = ( "select artists.id, Name, group_concat( type ) as type from artists, song_to_artist where artistid = artists.id and songid = $songid and type in ( 'creditedsw', 'featured', 'primary' ) having count(*) > 1 ");
    $artists = db_query_rows( "select artists.id, Name, group_concat( type ) as type from artists, song_to_artist where artistid = artists.id and songid = $songid and type in ( 'creditedsw', 'featured', 'primary' ) group by artists.id, Name having count(*) > 1 ", "Name");
    $groups = db_query_rows( "select groups.id, Name, group_concat( type ) as type from groups, song_to_group where groupid = groups.id and songid = $songid and type in ( 'creditedsw', 'featured', 'primary' ) group by groups.id, Name having count(*) > 1 ", "Name");
    $impl = array_merge( $artists, $groups );
    ksort( $impl );
    foreach( $impl as $irow )
    {
        $typestr = formatTypeStr($irow[type]);
        echo("$irow[Name] $typestr<br>" );
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