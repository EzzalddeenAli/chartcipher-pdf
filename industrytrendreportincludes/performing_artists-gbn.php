<div class="row  row-padding">
 <div class="col-12"> <h2 class="sub-header"><?=$sectionname?></h2></div>

<? 

?>
<div class="col-6 ">
    <h3>Gone</h3>
    <p class="subtitle">Do not appear in the Top 10 this quarter after appearing the preceding quarter</p>
            <ul class="listB">
<? 
$thisquarterid = calculateQuarterNumber($search[dates][fromq], $search[dates][fromy] );
$prevquarterid = $thisquarterid-1;

// calculate the previous quarter's artists + all the artists before that
$prevqartists = db_query_array( "select artistid from song_to_artist, song_to_weekdate, weekdates where weekdates.id = weekdateid and song_to_artist.songid = song_to_weekdate.songid and QuarterNumber = $prevquarterid and song_to_artist.type in ( 'primary', 'featured' )", "artistid", "artistid" );
$prevqartists[] = -1;
$beforeartists = db_query_array( "select artistid from song_to_artist, song_to_weekdate, weekdates where weekdates.id = weekdateid and song_to_artist.songid = song_to_weekdate.songid and QuarterNumber < $prevquarterid and song_to_artist.type in ( 'primary', 'featured' )", "artistid", "artistid" );
$beforeartists[] = -1;
$prevqartistsstr = implode( ", ", $prevqartists );
$beforeartistsstr = implode( ", ", $beforeartists );

// calculate the previous quarter's groups + all the groups before that
$prevqgroups = db_query_array( "select groupid from song_to_group, song_to_weekdate, weekdates where weekdates.id = weekdateid and song_to_group.songid = song_to_weekdate.songid and QuarterNumber = $prevquarterid and song_to_group.type in ( 'primary', 'featured' )", "groupid", "groupid" );
$prevqgroups[] = -1;
$beforegroups = db_query_array( "select groupid from song_to_group, song_to_weekdate, weekdates where weekdates.id = weekdateid and song_to_group.songid = song_to_weekdate.songid and QuarterNumber < $prevquarterid and song_to_group.type in ( 'primary', 'featured' )", "groupid", "groupid" );
$beforegroups[] = -1;
$prevqgroupsstr = implode( ", ", $prevqgroups );
$beforegroupsstr = implode( ", ", $beforegroups );

// this is artists who were not on the chart in the previous Q but were in some previous Q... hmm 
$returnedartists = db_query_array( "select Name, artistid from song_to_artist, artists where artistid = artists.id and songid in ( $allsongsstr ) and artistid in ( $beforeartistsstr ) and artistid not in ( $prevqartistsstr )  and type in ( 'primary', 'featured' )", "Name", "artistid" );
$returnedgroups = db_query_array( "select Name, groupid from song_to_group, groups where groupid = groups.id and songid in ( $allsongsstr ) and groupid in ( $beforegroupsstr ) and groupid not in ( $prevqgroupsstr )  and type in ( 'primary', 'featured' )", "Name", "groupid" );

$returnedartists = array_merge( $returnedartists, $returnedgroups );

$firstartists = db_query_array( "select artistid, min( QuarterNumber ) from song_to_weekdate, weekdates, song_to_artist where song_to_weekdate.songid = song_to_artist.songid and weekdates.id = weekdateid  and song_to_artist.type in ( 'primary', 'featured' ) group by artistid having min( QuarterNumber ) = $thisquarterid", "artistid", "artistid" );
$firstartists[] = -1;

$firstgroups = db_query_array( "select groupid, min( QuarterNumber ) from song_to_weekdate, weekdates, song_to_group where song_to_weekdate.songid = song_to_group.songid and weekdates.id = weekdateid  and song_to_group.type in ( 'primary', 'featured' ) group by groupid having min( QuarterNumber ) = $thisquarterid", "groupid", "groupid" );
$firstgroups[] = -1;

$newarrivalsartists = db_query_array( "select artists.id, Name from artists, song_to_artist where artistid = artists.id and artistid in ( " . implode( ", ", $firstartists ) . " ) and type in ( 'primary', 'featured' ) order by Name ", "Name", "id" );
$newarrivalsgroups = db_query_array( "select groups.id, Name from groups, song_to_group where groupid = groups.id and groupid in ( " . implode( ", " , $firstgroups ) . " ) and type in ( 'primary', 'featured' ) order by Name ", "Name", "id" );

$newarrivalsartists = array_merge( $newarrivalsartists, $newarrivalsgroups );

// anyone but someone who had a song in the prev quarter
$newarrivalsartists = array_merge( $returnedartists, $newarrivalsartists );


$goneartists = db_query_array( "select artists.id, Name from artists where artists.id not in ( select artistid from song_to_artist where songid in ( $allsongsstr ) and song_to_artist.type in ( 'primary', 'featured' )  ) and artists.id in ( $prevqartistsstr ) order by Name  ", "Name", "artistid" );

$gonegroups = db_query_array( "select groups.id, Name from groups where groups.id not in ( select groupid from song_to_group where songid in ( $allsongsstr )  and song_to_group.type in ( 'primary', 'featured' )  ) and groups.id in ( $prevqgroupsstr ) order by Name", "Name", "groupid" );

$goneartists = array_merge( $goneartists, $gonegroups );

ksort( $goneartists );
foreach( $goneartists as $newname=>$cid ) { 
	 $clean = "search-results.php?search[primaryartist]=$newname";
?>
            <li><span><a  href='<?=$clean?>'><?=$newname?></a></span></li>
<? } 
?> 
</ul>
</div>

<? if( 1 == 0 ) { ?>
<? if( count( $returnedartists ) ) { ?>
    <h3>Back</h3>
    <p class="subtitle">Returned to the Top 10 after not appearing the preceding quarter</p>
            <ul class="listB">
<?php
          ksort( $returnedartists );
foreach( $returnedartists as $newname=>$artistid ) { 
	 $clean = "search-results.php?search[primaryartist]=$newname";
?>
            <li><span><a  href='<?=$clean?>'><?=$newname?></a></span></li>
<? } 
?> 
                </ul> 
<? } ?>
<? } ?>
      <div class="col-6 ">
<? if( 1 == 1 ) {
// yael had me remove and readd
    ?>    
    <h3>New</h3>
    <p class="subtitle">Did not appear in the Top 10 in the preceding quarter</p>
            <ul class="listB">
<? 
          ksort( $newarrivalsartists );
foreach( $newarrivalsartists as $newname=>$cid ) { 
	 $clean = "search-results.php?search[primaryartist]=$newname";
?>
            <li><span><a  href='<?=$clean?>'><?=$newname?></a></span></li>
<? } 
?> 
    <? } ?>
    </ul>
    </div>
    </div>
    