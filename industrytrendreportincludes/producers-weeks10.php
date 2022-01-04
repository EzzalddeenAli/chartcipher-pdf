<? 
?>
            <div class="search-body">
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table1" class="sortable">
             <tbody>
            		<tr>
            			<th >Producer / Production Team <br><i>(click on column title to sort)</i></th>
<!--	            	  <th class="">Weeks in the Top 10 <br><i>(click on column title to sort)</i></th>
	            	      <th class="">Peak Chart Position <br><i>(click on column title to sort)</i></th>-->
	            	  <th class="">Weeks in the Top 10 <?=$displquarterstr?> <br><i>(click on column title to sort)</i></th>
	            	    <th class="">Peak Chart Position <?=$displquarterstr?> <br><i>(click on column title to sort)</i></th>
            	  </tr>
<? 
$allproducerssorted = db_query_rows( "select Name, producerid, group_concat( distinct( songid ) ) as songs from song_to_producer, producers where producers.id = producerid and songid in ( $allsongsstr ) group by producerid, Name order by Name", "Name" );
$songsforproducer = array();

ksort( $allproducerssorted );


$allproducerssortedno1 = db_query_rows( "select Name, producerid, group_concat( distinct( songid ) ) as songs from song_to_producer, producers where producers.id = producerid and songid in ( $allsongsnumber1str ) group by producerid, Name order by Name", "Name" );

ksort( $allproducerssortedno1 );

$tmpweeksquarter = db_query_array( "select count(distinct( weekdateid)) as cnt, producerid from song_to_weekdate stw, song_to_producer sta where sta.songid = stw.songid and weekdateid in ( " . implode( ", ", $allweekdates ) . " )  group by producerid", "producerid", "cnt" );
$tmppeakinquarter = db_query_array( "select min( cast( replace( stw.type, 'position', '' ) as signed )) as cnt, producerid from song_to_weekdate stw, song_to_producer sta where sta.songid = stw.songid and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) group by producerid  ", "producerid", "cnt" );



foreach( $allproducerssorted as $producername=>$arow )
{
    $key = $arow[producerid];
    $songsforproducer[$key] = explode( ",", $arow[songs] );
//    $weeks = db_query_first_cell( "select count(distinct( weekdateid)) from song_to_weekdate where songid in ( select songid from song_to_producer where  producerid = $arow[producerid] ) " );

    $weeksquarter = $tmpweeksquarter[$arow[producerid]]; // db_query_first_cell( "select count(distinct( weekdateid)) from song_to_weekdate where songid in ( select songid from song_to_producer where producerid = $arow[producerid] ) and weekdateid in ( select id from weekdates where QuarterNumber = '$thisquarternumber' ) " );

    $peakinquarter = $tmppeakinquarter[$arow[producerid]]; // db_query_first_cell( "select cast( replace( type, 'position', '' ) as signed ) from song_to_weekdate where songid in ($arow[songs]) and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
//    $peakalltime = db_query_first_cell( "select cast( replace( type, 'position', '' ) as signed ) from song_to_weekdate where songid in ($arow[songs]) order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
?>
            	  <tr>
            	  	<td class="">									
			<a class="appendid"  href="/search-results.php?search[producer]=<?=urlencode( $producername )?>&<?=$urldatestr?>">
			<?=$producername?>
			</a>

</td>
            	  	<td class=""><?=$weeksquarter?></td>
            	  	<td sorttable_customkey="<?=$peakinquarter?$peakinquarter:9999?>" class=""><?=$peakinquarter?></td>
            	  </tr>
<? }?>
            	  </tbody>
            	</table>
            	</div>           
