<? 
?>
            <div class="search-body">
    <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table2" class="sortable">
             <tbody>
            		<tr>
            			<th>Producer / Production Team <br><i>(click on column title to sort)</i></th>
                <th class="">Weeks at #1 <?=$displquarterstr?><br><i>(click on column title to sort)</i></th>
<!--	            	  <th class="">Weeks at #1 (all-time) <br><i>(click on column title to sort)</i></th>-->
            	  </tr>
<? 
$tmpweeks = db_query_array( "select count( * ) as cnt, producerid from song_to_producer sta, song_to_weekdate stw where stw.songid = sta.songid and weekdateid in ( $weekdatesstr ) and stw.type = 'position1' group by producerid", "producerid", "cnt" );

$todisplay = array();
$weeksalltime = array();

foreach( $allproducerssortedno1 as $producername=>$arow ) { 
    //   $sql =  "select count(*) from song_to_weekdate where type = 'position1'  and weekdateid in ( $weekdatesstr ) and songid in ( $arow[songs] ) ";
    $weeks = $tmpweeks[$arow[producerid]]; // db_query_first_cell($sql );
    $key = str_pad(100-$weeks, 3, "0", STR_PAD_LEFT) . "_" . $producername;
    $todisplay[$key] = $producername;

//   $sql =  "select count(*) from song_to_weekdate where type = 'position1'  and songid in ( select songid from song_to_producer where producerid = '$arow[producerid]' ) ";
//   $weeksat = db_query_first_cell($sql );
//   $weeksalltime[$producername] = $weeksat;
}

ksort( $todisplay );
foreach( $todisplay as $sorter=> $producername )
{
    $weeks = 100-number_format( array_shift( explode( "_", $sorter ) ) );
    $producerrow = $allproducerssortedno1[$producername];
    $weeksat = $weeksalltime[$producername];
?>
            	  <tr>
            	  	<td class="">									
			<a class="appendid"  href="/search-results.php?search[producer]=<?=$producername?>&<?=$urldatestr?>&search[peakchart]=1">
			<?=$producername?>
			</a>
</td>
            	  	<td class=""><?=$weeks?></td>
<!--            	  	<td class=""><?=$weeksat?></td>-->
            	  </tr>
<?} ?>
            	  </tbody>
            	</table>
            	</div>           
