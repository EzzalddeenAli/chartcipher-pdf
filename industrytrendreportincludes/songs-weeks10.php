<? 
?>
            <div class="search-body">
       
            
                
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="songs-weeks10-table" class="sortable">
             <tbody>
            		<tr>
            			<th>Song <br><i>(click on column title to sort)</i></th>
	            	  <th class="">Weeks in the Top 10 <?=$displquarterstr?> <br><i>(click on column title to sort)</i></th>
	            	  <th class="">Weeks in the Top 10 (all-time) <br><i>(click on column title to sort)</i></th>
	            	    <th class="">Peak Chart Position <?=$displquarterstr?> <br><i>(click on column title to sort)</i></th>
	            	      <th class="">Peak Chart Position (all-time) <br><i>(click on column title to sort)</i></th>
            	  </tr>
<? 
$weeksinqarr = db_query_array( "select count(*) as cnt, songid from song_to_weekdate where songid in ( $allsongsstr ) and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) group by songid", "songid", "cnt" );
//$weeksinqarr = db_query_array( "select count(*) as cnt, songid from song_to_weekdate where songid in ( $allsongsstr ) and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) group by songid", "songid", "cnt" );

$weeksallarr = db_query_array( "select count(*) as cnt, songid from song_to_weekdate where songid in ( $allsongsstr ) group by songid", "songid", "cnt" );
$peakarr = db_query_array( "select min(cast( replace( type, 'position', '' ) as signed ))  as cnt, songid from song_to_weekdate where songid in ( $allsongsstr ) group by songid", "songid", "cnt" );

foreach( $allsongssorted as $songname=>$songid )
{
   $r = getSongRow( $songid );
   $weeks = $weeksallarr[$songid];
   $peakinquarter = $peakarr[$songid];
    //    $peakinquarter = db_query_first_cell( "select cast( replace( type, 'position', '' ) as signed ) from song_to_weekdate where songid = $songid and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
   $weeksinq = $weeksinqarr[$songid];
    //    $weeksinq = db_query_first_cell( "select count(*) from song_to_weekdate where songid = $songid and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
?>
            	  <tr>
            	  	<td class="">									
			<a class="appendid"  href="/<?=$r[CleanUrl]?>">
			<?=$songname?>
			</a>

</td>
            	  	<td class=""><?=$weeksinq?></td>
            	  	<td class=""><?=$weeks?></td>
            	  	<td class=""><?=$peakinquarter?></td>
            	  	<td class=""><?=$r[PeakPosition]?></td>
            	  </tr>
<? }?>
            	  </tbody>
            	</table>
            	</div>           
