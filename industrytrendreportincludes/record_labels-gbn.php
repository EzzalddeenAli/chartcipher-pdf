<? 

?>
    <h2 class="sub-header"><?=$sectionname?></h2>
    <h3>Gone</h3>
    <p class="subtitle">Do not appear in the Top 10 this quarter after appearing the preceding quarter</p>
            <ul class="listB">
<? 
$thisquarterid = calculateQuarterNumber($search[dates][fromq], $search[dates][fromy] );
$prevquarterid = $thisquarterid-1;

// calculate the previous quarter's labels + all the labels before that
$prevqlabels = db_query_array( "select labelid from song_to_label, song_to_weekdate, weekdates where weekdates.id = weekdateid and song_to_label.songid = song_to_weekdate.songid and QuarterNumber = $prevquarterid", "labelid", "labelid" );
//echo( "select labelid from song_to_label, song_to_weekdate, weekdates where weekdates.id = weekdateid and song_to_label.songid = song_to_weekdate.songid and QuarterNumber = $prevquarterid" );
$prevqlabels[] = -1;
// $beforelabels = db_query_array( "select labelid from song_to_label, song_to_weekdate, weekdates where weekdates.id = weekdateid and song_to_label.songid = song_to_weekdate.songid and QuarterNumber < $prevquarterid", "labelid", "labelid" );
// $beforelabels[] = -1;
$prevqlabelsstr = implode( ", ", $prevqlabels );
//$beforelabelsstr = implode( ", ", $beforelabels );

// this is labels who were not on the chart in the previous Q but were in some previous Q... hmm 
//$returnedlabels = db_query_array( "select Name, labelid from song_to_label, labels where labelid = labels.id and songid in ( $allsongsstr ) and labelid in ( $beforelabelsstr ) and labelid not in ( $prevqlabelsstr ) ", "Name", "labelid" );


$firstlabels = db_query_array( "select labelid, min( QuarterNumber ) from song_to_weekdate, weekdates, song_to_label where song_to_weekdate.songid = song_to_label.songid and weekdates.id = weekdateid  group by labelid having min( QuarterNumber ) = $thisquarterid", "labelid", "labelid" );
$firstlabels[] = -1;


$newarrivalslabels = db_query_array( "select labels.id, Name from labels, song_to_label where labelid = labels.id and labelid in ( " . implode( ", ", $firstlabels ) . " ) order by Name ", "Name", "id" );


$gonelabels = db_query_array( "select labels.id, Name from labels where labels.id not in ( select labelid from song_to_label where songid in ( $allsongsstr ) ) and labels.id in ( $prevqlabelsstr ) order by Name  ", "Name", "labelid" );

ksort( $gonelabels );
foreach( $gonelabels as $newname=>$cid ) { 
	 $clean = "search-results.php?search[label]=$newname";
?>
            <li><span><a  href='<?=$clean?>'><?=$newname?></a></span></li>
<? } 
if( !count( $gonelabels ) )
{
    echo( "<li><span>None</span></li>" );
}

?> 
</ul>                
<? if( 1 == 0 && count( $returnedlabels ) ) { ?>
    <h3>Back</h3>
    <p class="subtitle">Returned to the Top 10 after not appearing the preceding quarter</p>
            <ul class="listB">
<?php
          ksort( $returnedlabels );
foreach( $returnedlabels as $newname=>$labelid ) { 
	 $clean = "search-results.php?search[label]=$newname";
?>
            <li><span><a  href='<?=$clean?>'><?=$newname?></a></span></li>
<? } 
?> 
                </ul> 
<? } ?>
<? if( 1 == 1 ) {
    ?>    
    <h3>New</h3>
    <p class="subtitle">Appears in the Top 10 for the first time since Q<?=$earliestq?> <?=$earliesty?></p>
            <ul class="listB">
<? 
          ksort( $newarrivalslabels );
    
foreach( $newarrivalslabels as $newname=>$cid ) { 
	 $clean = "search-results.php?search[label]=$newname";
?>
            <li><span><a  href='<?=$clean?>'><?=$newname?></a></span></li>
<? }
if( !count( $newarrivalslabels ) )
{
    echo( "<li><span>None</span></li>" );
}
?> 
    <? } ?>
