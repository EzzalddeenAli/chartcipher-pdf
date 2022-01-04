<? 
?>
            <div class="search-body">
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table1" class="sortable">
             <tbody>
            		<tr>
            			<th >Record Label <br><i>(click on column title to sort)</i></th>
<!--	            	  <th class="">Weeks in the Top 10 <br><i>(click on column title to sort)</i></th>
	            	      <th class="">Peak Chart Position <br><i>(click on column title to sort)</i></th>-->
	            	  <th class="">Weeks in the Top 10 <?=$displquarterstr?> <br><i>(click on column title to sort)</i></th>
	            	    <th class="">Peak Chart Position <?=$displquarterstr?> <br><i>(click on column title to sort)</i></th>
            	  </tr>
<? 
$alllabelssorted = db_query_rows( "select Name, labelid, group_concat( distinct( songid ) ) as songs from song_to_label, labels where labels.id = labelid and songid in ( $allsongsstr ) group by labelid, Name order by Name", "Name" );
$songsforlabel = array();

ksort( $alllabelssorted );


$allwriterssortedno1 = db_query_rows( "select Name, labelid, group_concat( distinct( songid ) ) as songs from song_to_label, labels where labels.id = labelid and songid in ( $allsongsnumber1str ) group by labelid, Name order by Name", "Name" );

ksort( $allwriterssortedno1 );


foreach( $alllabelssorted as $labelname=>$arow )
{
    $key = $arow[labelid];
    $songsforlabel[$key] = explode( ",", $arow[songs] );
//    $weeks = db_query_first_cell( "select count(distinct( weekdateid)) from song_to_weekdate where songid in ( select songid from song_to_label where labelid = $arow[labelid] ) " );

    $weeksquarter = db_query_first_cell( "select count(distinct( weekdateid)) from song_to_weekdate where songid in ( select songid from song_to_label where labelid = $arow[labelid] ) and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) " );

    $peakinquarter = db_query_first_cell( "select cast( replace( type, 'position', '' ) as signed ) from song_to_weekdate where songid in ($arow[songs]) and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
//    $peakalltime = db_query_first_cell( "select cast( replace( type, 'position', '' ) as signed ) from song_to_weekdate where songid in ($arow[songs]) order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
?>
            	  <tr>
            	  	<td class="">									
			<a class="appendid"  href="/search-results.php?search[label]=<?=$labelname?>&<?=$urldatestr?>">
			<?=$labelname?>
			</a>

</td>
<!--            	  	<td class=""><?=$weeks?></td>
            	  	<td class=""><?=$peakalltime?></td>-->
            	  	<td class=""><?=$weeksquarter?></td>
            	  	<td sorttable_customkey="<?=$peakinquarter?$peakinquarter:9999?>" class=""><?=$peakinquarter?></td>
            	  </tr>
<? }?>
            	  </tbody>
            	</table>
<div id='extranote'> Note: Some songs are affiliated with more than one label</div>
            	</div>           
