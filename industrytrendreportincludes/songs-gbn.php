
<div class="row  row-padding">
 <div class="col-12"> <h2 class="sub-header"><?=$sectionname?></h2></div>

<? 
?>
<div class="col-6 ">
    <h3>Gone</h3>
    <p class="subtitle">Do not appear in the Top 10 this quarter after appearing the preceding quarter</p>
            <ul class="listB">
<? 
foreach( $gone as $cid=>$newname ) { 
	 $clean = getCleanURL( $cid );
?>
            <li><span><a  href='<?=$clean?>'><?=getSongnameFromSongid( $cid )?></a></span></li>
<? } 
?> 
</ul> 
 </div>
             
<? if( 1 == 0 ) { ?>
<? if( count( $returned ) ) { ?>
    <h3>Back</h3>
    <p class="subtitle">Returned to the Top 10 after not appearing the preceding quarter</p>
            <ul class="listB">
<? 
foreach( $returned as $cid ) { 
	 $clean = getCleanURL( $cid );
?>
            <li><span><a  href='<?=$clean?>'><?=getSongnameFromSongid( $cid )?></a></span></li>
<? } 
?> 
                </ul> 
<? } ?>
<? } ?>

<div class="col-6 ">
    
    <h3>New</h3>
    <p class="subtitle">Did not appear in the Top 10 in the preceding quarter</p>
            <ul class="listB">
<?php
         $thisquarterid = calculateQuarterNumber($search[dates][fromq], $search[dates][fromy] );
$prevquarterid = $thisquarterid-1;
$newarrivalssongs = db_query_rows( "select  songs.id, SongNameHard as Name, CleanURL from songs where songs.id not in ( select songid from song_to_weekdate, weekdates where weekdates.id = weekdateid and QuarterNumber = '$prevquarterid' ) and songs.id in ( $allsongsstr ) order by Name", "id" );
    
         foreach( $newarrivalssongs as $cid=>$crow ) { 
?>
            <li><span><a  href='<?=$crow[CleanURL]?>'><?=( $crow[Name] )?></a></span></li>
<? } 
?> 
</ul>
</div>
</div>