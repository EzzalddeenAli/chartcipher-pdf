
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

// calculate the previous quarter's producers + all the producers before that
$prevqproducers = db_query_array( "select producerid from song_to_producer, song_to_weekdate, weekdates where weekdates.id = weekdateid and song_to_producer.songid = song_to_weekdate.songid and QuarterNumber = $prevquarterid ", "producerid", "producerid" );
$prevqproducers[] = -1;
$beforeproducers = db_query_array( "select producerid from song_to_producer, song_to_weekdate, weekdates where weekdates.id = weekdateid and song_to_producer.songid = song_to_weekdate.songid and QuarterNumber < $prevquarterid", "producerid", "producerid" );
$beforeproducers[] = -1;
$prevqproducersstr = implode( ", ", $prevqproducers );
$beforeproducersstr = implode( ", ", $beforeproducers );

// this is producers who were not on the chart in the previous Q but were in some previous Q... hmm 
$returnedproducers = db_query_array( "select Name, producerid from song_to_producer, producers where producerid = producers.id and songid in ( $allsongsstr ) and producerid in ( $beforeproducersstr ) and producerid not in ( $prevqproducersstr ) ", "Name", "producerid" );


//echo( "select producerid, min( QuarterNumber ) from song_to_weekdate, weekdates, song_to_producer where song_to_weekdate.songid = song_to_producer.songid and weekdates.id = weekdateid  group by producerid having min( QuarterNumber ) = $thisquarterid" );
$firstproducers = db_query_array( "select producerid, min( QuarterNumber ) from song_to_weekdate, weekdates, song_to_producer where song_to_weekdate.songid = song_to_producer.songid and weekdates.id = weekdateid  group by producerid having min( QuarterNumber ) = $thisquarterid", "producerid", "producerid" );
$firstproducers[] = -1;


$newarrivalsproducers = db_query_array( "select producers.id, Name from producers, song_to_producer where producerid = producers.id and producerid in ( " . implode( ", ", $firstproducers ) . " ) order by Name ", "Name", "id" );


$newarrivalsproducers = array_merge( $returnedproducers, $newarrivalsproducers );

$goneproducers = db_query_array( "select producers.id, Name from producers where producers.id not in ( select producerid from song_to_producer where songid in ( $allsongsstr ) ) and producers.id in ( $prevqproducersstr ) order by Name  ", "Name", "producerid" );
//echo( "select producers.id, Name from producers where producers.id not in ( select producerid from song_to_producer where songid in ( $allsongsstr ) ) and producers.id in ( $prevqproducersstr ) order by Name" );


ksort( $goneproducers );
foreach( $goneproducers as $newname=>$cid ) { 
	 $clean = "search-results.php?search[producer]=$newname";
?>
            <li><span><a  href='<?=$clean?>'><?=$newname?></a></span></li>
<? } 
?> 
</ul>     
</div>
       
<? if( 1 == 0 ) { ?>
<? if( count( $returnedproducers ) ) { ?>
    <h3>Back</h3>
    <p class="subtitle">Returned to the Top 10 after not appearing the preceding quarter</p>
            <ul class="listB">
<?php
          ksort( $returnedproducers );
foreach( $returnedproducers as $newname=>$producerid ) { 
	 $clean = "search-results.php?search[producer]=$newname";
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
          ksort( $newarrivalsproducers );
foreach( $newarrivalsproducers as $newname=>$cid ) { 
	 $clean = "search-results.php?search[producer]=$newname";
?>
            <li><span><a  href='<?=$clean?>'><?=$newname?></a></span></li>
<? } 
?> 
    <? } ?>
    </ul>
    </div>
    </div>