<? 
?>
            <div class="search-body">
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table1" class="sortable">
             <tbody>
            		<tr>
            			<th >Songwriter <br><i>(click on column title to sort)</i></th>
<!--	            	  <th class="">Weeks in the Top 10 <br><i>(click on column title to sort)</i></th>
	            	      <th class="">Peak Chart Position <br><i>(click on column title to sort)</i></th>-->
	            	  <th class="">Weeks in the Top 10 <?=$displquarterstr?> <br><i>(click on column title to sort)</i></th>
	            	    <th class="">Peak Chart Position <?=$displquarterstr?> <br><i>(click on column title to sort)</i></th>
            	  </tr>
<? 
$allartistssorted = db_query_rows( "select Name, artistid, group_concat( distinct( songid ) ) as songs from song_to_artist, artists where artists.id = artistid and songid in ( $allsongsstr ) and type in ( 'creditedsw' ) group by artistid, Name order by Name", "Name" );
$songsforartist = array();

ksort( $allartistssorted );


$allwriterssortedno1 = db_query_rows( "select Name, artistid, group_concat( distinct( songid ) ) as songs from song_to_artist, artists where artists.id = artistid and songid in ( $allsongsnumber1str ) and type in ( 'creditedsw' ) group by artistid, Name order by Name", "Name" );

ksort( $allwriterssortedno1 );

$tmpweeksquarter = db_query_array( "select count(distinct( weekdateid)) as cnt, artistid from song_to_weekdate stw, song_to_artist sta where sta.songid = stw.songid and sta.type = 'creditedsw' and weekdateid in ( " . implode( ", ", $allweekdates ) . " )  group by artistid", "artistid", "cnt" );
$tmppeakinquarter = db_query_array( "select min( cast( replace( stw.type, 'position', '' ) as signed )) as cnt, artistid from song_to_weekdate stw, song_to_artist sta where sta.songid = stw.songid and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) and sta.type = 'creditedsw' group by artistid  ", "artistid", "cnt" );

foreach( $allartistssorted as $artistname=>$arow )
{
    $key = $arow[artistid];
    $songsforartist[$key] = explode( ",", $arow[songs] );

    $weeksquarter = $tmpweeksquarter[$arow[artistid]]; // db_query_first_cell( "select count(distinct( weekdateid)) from song_to_weekdate where songid in ( select songid from song_to_artist where type in ( 'creditedsw' ) and artistid = $arow[artistid] ) and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) " );

    $peakinquarter = $tmppeakinquarter[$arow[artistid]]; //db_query_first_cell( "select cast( replace( type, 'position', '' ) as signed ) from song_to_weekdate where songid in ($arow[songs]) and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
?>
            	  <tr>
            	  	<td class="">									
			<a class="appendid"  href="/search-results.php?search[writer]=<?=$artistname?>&<?=$urldatestr?>">
			<?=$artistname?>
			</a>

</td>
            	  	<td class=""><?=$weeksquarter?></td>
            	  	<td sorttable_customkey="<?=$peakinquarter?$peakinquarter:9999?>" class=""><?=$peakinquarter?></td>
            	  </tr>
<? }?>
            	  </tbody>
            	</table>
            	</div>           
