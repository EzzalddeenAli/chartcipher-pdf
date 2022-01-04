<? 
// not sure if we need this -- 1/2/2018
$allartistssortedno1 = db_query_rows( "select Name, artistid, group_concat( distinct( case when type = 'featured' then 0 else songid end ) ) as songs, group_concat( distinct( case when type = 'primary' then 0 else songid end ) ) as songsfeat from song_to_artist, artists where artists.id = artistid and songid in ( $allsongsnumber1str ) and type in ( 'featured', 'primary' ) group by artistid, Name order by Name", "Name" );
$allgroupssortedno1 = db_query_rows( "select Name, groupid, group_concat( distinct( case when type = 'featured' then 0 else songid end ) ) as songs, group_concat( distinct( case when type = 'primary' then 0 else songid end ) ) as songsfeat from song_to_group, groups where groups.id = groupid and songid in ( $allsongsnumber1str ) and type in ( 'featured', 'primary' ) group by groupid, Name order by Name", "Name" );

$allartistssortedno1 = array_merge( $allartistssortedno1, $allgroupssortedno1 );
ksort( $allartistssortedno1 );


?>
            <div class="search-body">
    <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table2" class="sortable">
             <tbody>
            		<tr>
            			<th >Artist/Group <br><i>(click on column title to sort)</i></th>
                <th class="">Weeks at #1 - Main Artist <?=$displquarterstr?><br><i>(click on column title to sort)</i></th>
                <th class="">Weeks at #1 - Featured Artist <?=$displquarterstr?><br><i>(click on column title to sort)</i></th>
            	  </tr>
<? 
$todisplay = array();

$weeksfeatarr = array();

$tmpweeks = db_query_array( "select count( * ) as cnt, artistid from song_to_artist sta, song_to_weekdate stw where stw.songid = sta.songid and weekdateid in ( $weekdatesstr ) and stw.type = 'position1' and sta.type = ( 'primary' ) group by artistid", "artistid", "cnt" );
$tmpweeksgroup = db_query_array( "select count( * ) as cnt, groupid from song_to_group sta, song_to_weekdate stw where stw.songid = sta.songid and weekdateid in ( $weekdatesstr ) and stw.type = 'position1' and sta.type = ( 'primary' ) group by groupid", "groupid", "cnt" );

$tmpweeksfeat = db_query_array( "select count( * ) as cnt, artistid from song_to_artist sta, song_to_weekdate stw where stw.songid = sta.songid and weekdateid in ( $weekdatesstr ) and stw.type = 'position1' and sta.type = ( 'featured' ) group by artistid", "artistid", "cnt" );
$tmpweeksgroupfeat = db_query_array( "select count( * ) as cnt, groupid from song_to_group sta, song_to_weekdate stw where stw.songid = sta.songid and weekdateid in ( $weekdatesstr ) and stw.type = 'position1' and sta.type = ( 'featured' ) group by groupid", "groupid", "cnt" );

foreach( $allartistssortedno1 as $artistname=>$arow ) { 
   // $sql =  "select count(*) from song_to_weekdate where type = 'position1'  and weekdateid in ( $weekdatesstr ) and songid in ( $arow[songs] ) ";
   // $weeks = db_query_first_cell($sql );
   
   // $sql =  "select count(*) from song_to_weekdate where type = 'position1'  and weekdateid in ( $weekdatesstr ) and songid in ( $arow[songsfeat] ) ";
   // $weeksfeat = db_query_first_cell($sql );
    if( $arow[artistid] )
	{
	    $weeks = $tmpweeks[$arow[artistid]];
	    $weeksfeat = $tmpweeksfeat[$arow[artistid]];
	}
    else
	{
	    $weeks = $tmpweeksgroup[$arow[groupid]];
	    $weeksfeat = $tmpweeksgroupfeat[$arow[groupid]];
	}
   
   $key = str_pad(100-$weeks, 3, "0", STR_PAD_LEFT) . "_" . $artistname;
   $todisplay[$key] = $artistname;
   $weeksfeatarr[$artistname] = $weeksfeat;
}

ksort( $todisplay );
foreach( $todisplay as $sorter=> $artistname )
{
    $weeks = 100-number_format( array_shift( explode( "_", $sorter ) ) );
    $artistrow = $allartistssortedno1[$artistname];
    $weeksfeat = $weeksfeatarr[$artistname];
?>
            	  <tr>
            	  	<td class="">									
			<a  class="appendid" href="/search-results.php?search[primaryartist]=<?=$artistname?>&<?=$urldatestr?>&search[peakchart]=1">
			<?=$artistname?>
			</a>
</td>
            	  	<td class=""><?=$weeks?$weeks:0?></td>
            	  	<td class=""><?=$weeksfeat?$weeksfeat:0?></td>
            	  </tr>
<?} ?>
            	  </tbody>
            	</table>
            	</div>           
