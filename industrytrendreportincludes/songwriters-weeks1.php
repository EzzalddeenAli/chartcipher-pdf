<? 
$tmpweeks = db_query_array( "select count( * ) as cnt, artistid from song_to_artist sta, song_to_weekdate stw where stw.songid = sta.songid and weekdateid in ( $weekdatesstr ) and stw.type = 'position1' and sta.type = ( 'creditedsw' ) group by artistid", "artistid", "cnt" );
?>
            <div class="search-body">
    <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table2" class="sortable">
             <tbody>
            		<tr>
            			<th>Songwriter <br><i>(click on column title to sort)</i></th>
	            	  <th class="">Weeks at #1 <?=$displquarterstr?><br><i>(click on column title to sort)</i></th>
<!--	            	  <th class="">Weeks at #1 (all-time) <br><i>(click on column title to sort)</i></th>-->
            	  </tr>
<? 
$todisplay = array();
$weeksalltime = array();

foreach( $allwriterssortedno1 as $artistname=>$arow ) { 
//   $sql =  "select count(*) from song_to_weekdate where type = 'position1'  and weekdateid in ( $weekdatesstr ) and songid in ( $arow[songs] ) ";
    $weeks = $tmpweeks[$arow[artistid]]; // db_query_first_cell($sql );
    $key = str_pad(100-$weeks, 3, "0", STR_PAD_LEFT) . "_" . $artistname;
    $todisplay[$key] = $artistname;
}

ksort( $todisplay );
foreach( $todisplay as $sorter=> $artistname )
{
    $weeks = 100-number_format( array_shift( explode( "_", $sorter ) ) );
    $artistrow = $allartistssortedno1[$artistname];
    $weeksat = $weeksalltime[$artistname];
?>
            	  <tr>
            	  	<td class="">									
			<a class="appendid"  href="/search-results.php?search[writer]=<?=$artistname?>&<?=$urldatestr?>&search[peakchart]=1">
			<?=$artistname?>
			</a>
</td>
            	  	<td class=""><?=$weeks?></td>
<!--            	  	<td class=""><?=$weeksat?></td>-->
            	  </tr>
<?} ?>
            	  </tbody>
            	</table>
            	</div>           
