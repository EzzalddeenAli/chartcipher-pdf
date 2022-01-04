
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
$prevqartists = db_query_array( "select artistid from song_to_artist, song_to_weekdate, weekdates where weekdates.id = weekdateid and song_to_artist.songid = song_to_weekdate.songid and QuarterNumber = $prevquarterid and song_to_artist.type in ( 'creditedsw' )", "artistid", "artistid" );
$prevqartists[] = -1;
$beforeartists = db_query_array( "select artistid from song_to_artist, song_to_weekdate, weekdates where weekdates.id = weekdateid and song_to_artist.songid = song_to_weekdate.songid and QuarterNumber < $prevquarterid and song_to_artist.type in ( 'creditedsw' )", "artistid", "artistid" );
$beforeartists[] = -1;
$prevqartistsstr = implode( ", ", $prevqartists );
$beforeartistsstr = implode( ", ", $beforeartists );

// this is artists who were not on the chart in the previous Q but were in some previous Q... hmm 
$returnedartists = db_query_array( "select Name, artistid from song_to_artist, artists where artistid = artists.id and songid in ( $allsongsstr ) and artistid in ( $beforeartistsstr ) and artistid not in ( $prevqartistsstr )  and type in ( 'creditedsw' )", "Name", "artistid" );


$firstartists = db_query_array( "select artistid, min( QuarterNumber ) from song_to_weekdate, weekdates, song_to_artist where song_to_weekdate.songid = song_to_artist.songid and weekdates.id = weekdateid  and song_to_artist.type in ( 'creditedsw' ) group by artistid having min( QuarterNumber ) = $thisquarterid", "artistid", "artistid" );
$firstartists[] = -1;


$newarrivalsartists = db_query_array( "select artists.id, Name from artists, song_to_artist where artistid = artists.id and artistid in ( " . implode( ", ", $firstartists ) . " ) and type in ( 'creditedsw' ) order by Name ", "Name", "id" );


$newarrivalsartists = array_merge( $returnedartists, $newarrivalsartists );

$goneartists = db_query_array( "select artists.id, Name from artists where artists.id not in ( select artistid from song_to_artist where songid in ( $allsongsstr ) and song_to_artist.type in ( 'creditedsw' )  ) and artists.id in ( $prevqartistsstr ) order by Name  ", "Name", "artistid" );


ksort( $goneartists );
foreach( $goneartists as $newname=>$cid ) { 
	 $clean = "search-results.php?search[writer]=$newname";
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
	 $clean = "search-results.php?search[writer]=$newname";
?>
            <li><span><a  href='<?=$clean?>'><?=$newname?></a></span></li>
<? } 
?> 
                </ul> 
<? } ?>
<? } ?>

<div class="col-6 ">
<? if( 1 == 1 ) {
    ?>    
    <h3>New</h3>
    <p class="subtitle">Did not appear in the Top 10 in the preceding quarter</p>
            <ul class="listB">
<? 
          ksort( $newarrivalsartists );
foreach( $newarrivalsartists as $newname=>$cid ) { 
	 $clean = "search-results.php?search[writer]=$newname";
?>
            <li><span><a  href='<?=$clean?>'><?=$newname?></a></span></li>
<? } 
?> 
    <? } ?>
    </ul>
    </div>
    </div>