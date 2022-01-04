<? 
?>
            <div class="search-body">
    <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table2" class="sortable">
             <tbody>
            		<tr>
            			<th>Record Label <br><i>(click on column title to sort)</i></th>
                <th class="">Weeks at #1 <?=$displquarterstr?><br><i>(click on column title to sort)</i></th>
<!--	            	  <th class="">Weeks at #1 (all-time) <br><i>(click on column title to sort)</i></th>-->
            	  </tr>
<? 
$todisplay = array();
$weeksalltime = array();
foreach( $allwriterssortedno1 as $labelname=>$arow ) { 
   $sql =  "select count(*) from song_to_weekdate where type = 'position1'  and weekdateid in ( $weekdatesstr ) and songid in ( $arow[songs] ) ";
   $weeks = db_query_first_cell($sql );
   $key = str_pad(100-$weeks, 3, "0", STR_PAD_LEFT) . "_" . $labelname;
   $todisplay[$key] = $labelname;
   // $sql =  "select count(*) from song_to_weekdate where type = 'position1'  and songid in ( select songid from song_to_label where labelid = '$arow[labelid]' ) ";
   // $weeksat = db_query_first_cell($sql );
   // $weeksalltime[$labelname] = $weeksat;
}

ksort( $todisplay );
foreach( $todisplay as $sorter=> $labelname )
{
    $weeks = 100-number_format( array_shift( explode( "_", $sorter ) ) );
    $labelrow = $alllabelssortedno1[$labelname];
    $weeksat = $weeksalltime[$labelname];
?>
            	  <tr>
            	  	<td class="">									
			<a class="appendid"  href="/search-results.php?search[label]=<?=$labelname?>&<?=$urldatestr?>&search[peakchart]=1">
			<?=$labelname?>
			</a>
</td>
            	  	<td class=""><?=$weeks?></td>
<!--            	  	<td class=""><?=$weeksat?></td>-->
            	  </tr>
<?} ?>
            	  </tbody>
            	</table>
<div id='extranote'> Note: Some songs are affiliated with more than one label</div>
            	</div>           
