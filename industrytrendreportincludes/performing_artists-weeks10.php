<? 
?>
            <div class="search-body">
                 <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table1" class="sortable">
             <tbody>
            		<tr>
            			<th >Artist/Group <br><i>(click on column title to sort)</i></th>
	            	  <th class="">Weeks in the Top 10 - Main Artist <?=$displquarterstr?> <br><i>(click on column title to sort)</i></th>
		<th class="">Peak Chart Position - Main Artist <?=$displquarterstr?> <br><i>(click on column title to sort)</i></th>
	            	  <th class="">Weeks in the Top 10 - Featured Artist <?=$displquarterstr?> <br><i>(click on column title to sort)</i></th>
	            	    <th class="">Peak Chart Position - Featured Artist <?=$displquarterstr?> <br><i>(click on column title to sort)</i></th>
            	  </tr>
<? 
$allartistssorted = db_query_rows( "select Name, artistid, group_concat( distinct( case when type = 'featured' then 0 else songid end ) ) as songs, group_concat( distinct( case when type = 'primary' then 0 else songid end ) ) as songsfeat from song_to_artist, artists where artists.id = artistid and songid in ( $allsongsstr ) and type in ( 'featured', 'primary' ) group by artistid, Name order by Name", "Name" );
$allgroupssorted = db_query_rows( "select Name, groupid, group_concat( distinct( case when type = 'featured' then 0 else songid end ) ) as songs, group_concat( distinct( case when type = 'primary' then 0 else songid end ) ) as songsfeat from song_to_group, groups where groups.id = groupid and songid in ( $allsongsstr ) and type in ( 'featured', 'primary' ) group by groupid, Name order by Name", "Name" );
$songsforartist = array();

$allartistssorted = array_merge( $allartistssorted, $allgroupssorted );
ksort( $allartistssorted );


$tmpweeksquarter = db_query_array( "select count(distinct( weekdateid)) as cnt, artistid from song_to_weekdate stw, song_to_artist sta where sta.songid = stw.songid and sta.type = 'primary' and weekdateid in ( " . implode( ", ", $allweekdates ) . " )  group by artistid", "artistid", "cnt" );
$tmpweeksquarterfeat = db_query_array( "select count(distinct( weekdateid)) as cnt, artistid from song_to_weekdate stw, song_to_artist sta where sta.songid = stw.songid and sta.type = 'featured' and weekdateid in ( " . implode( ", ", $allweekdates ) . " )  group by artistid", "artistid", "cnt" );

$tmpweeksquartergroup = db_query_array( "select count(distinct( weekdateid)) as cnt, groupid from song_to_weekdate stw, song_to_group sta where sta.songid = stw.songid and sta.type = 'primary' and weekdateid in ( " . implode( ", ", $allweekdates ) . " )  group by groupid", "groupid", "cnt" );
$tmpweeksquarterfeatgroup = db_query_array( "select count(distinct( weekdateid)) as cnt, groupid from song_to_weekdate stw, song_to_group sta where sta.songid = stw.songid and sta.type = 'featured' and weekdateid in ( " . implode( ", ", $allweekdates ) . " )  group by groupid", "groupid", "cnt" );

$tmppeakinquarter = db_query_array( "select min( cast( replace( stw.type, 'position', '' ) as signed )) as cnt, artistid from song_to_weekdate stw, song_to_artist sta where sta.songid = stw.songid and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) and sta.type = 'primary' group by artistid  ", "artistid", "cnt" );
$tmppeakinquarterfeat = db_query_array( "select min( cast( replace( stw.type, 'position', '' ) as signed )) as cnt, artistid from song_to_weekdate stw, song_to_artist sta where sta.songid = stw.songid and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) and sta.type = 'featured' group by artistid  ", "artistid", "cnt" );

$tmppeakinquartergroup = db_query_array( "select min( cast( replace( stw.type, 'position', '' ) as signed )) as cnt, groupid from song_to_weekdate stw, song_to_group sta where sta.songid = stw.songid and weekdateid in ( " . implode( ", ", $allweekdates ) . " )  and sta.type = 'primary' group by groupid  ", "groupid", "cnt" );
$tmppeakinquarterfeatgroup = db_query_array( "select min( cast( replace( stw.type, 'position', '' ) as signed )) as cnt, groupid from song_to_weekdate stw, song_to_group sta where sta.songid = stw.songid and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) and sta.type = 'featured' group by groupid  ", "groupid", "cnt" );

foreach( $allartistssorted as $artistname=>$arow )
{
    $isartist = $arow[artistid]?true:false;
    $key = $arow[artistid]?"A_".$arow[artistid]:"G_".$arow[groupid];
    $songsforartist[$key] = explode( ",", $arow[songs] );

    if( $isartist )
	{
	    $weeksquarter = $tmpweeksquarter[$arow[artistid]]; // db_query_first_cell( "select count(distinct( weekdateid)) from song_to_weekdate where songid in ( select songid from song_to_artist where type in ( 'primary' ) and artistid = $arow[artistid] ) and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) " );
	    $weeksquarterfeat = $tmpweeksquarterfeat[$arow[artistid]]; // db_query_first_cell( "select count(distinct( weekdateid)) from song_to_weekdate where songid in ( select songid from song_to_artist where type in ( 'featured' ) and artistid = $arow[artistid] ) and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) " );
	    $peakinquarter = $tmppeakinquarter[$arow[artistid]]; // db_query_first_cell( "select cast( replace( type, 'position', '' ) as signed ) from song_to_weekdate where songid in ($arow[songs]) and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
	    $peakinquarterfeat = $tmppeakinquarterfeat[$arow[artistid]]; // db_query_first_cell( "select cast( replace( type, 'position', '' ) as signed ) from song_to_weekdate where songid in ($arow[songsfeat]) and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
	}
    else
	{
	    $weeksquarter = $tmpweeksquartergroup[$arow[groupid]]; // db_query_first_cell( "select count(distinct( weekdateid)) from song_to_weekdate where songid in ( select songid from song_to_group where type in ( 'primary' ) and groupid = $arow[groupid] ) and weekdateid in ( " . implode( ", ", $allweekdates ) . " )" );
	    $weeksquarterfeat = $tmpweeksquarterfeatgroup[$arow[groupid]]; // db_query_first_cell( "select count(distinct( weekdateid)) from song_to_weekdate where songid in ( select songid from song_to_group where type in ( 'featured' ) and groupid = $arow[groupid] ) and weekdateid in ( " . implode( ", ", $allweekdates ) . " )" );
	    $peakinquarter = $tmppeakinquartergroup[$arow[groupid]]; // db_query_first_cell( "select cast( replace( type, 'position', '' ) as signed ) from song_to_weekdate where songid in ($arow[songs]) and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
	    $peakinquarterfeat = $tmppeakinquarterfeatgroup[$arow[groupid]]; // db_query_first_cell( "select cast( replace( type, 'position', '' ) as signed ) from song_to_weekdate where songid in ($arow[songsfeat]) and weekdateid in ( " . implode( ", ", $allweekdates ) . " ) order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
	}

?>
            	  <tr>
            	  	<td class="">									
			<a  class="appendid" href="/search-results.php?search[primaryartist]=<?=$artistname?>&<?=$urldatestr?>">
			<?=$artistname?>
			</a>

</td>
		       <td class=""><?=$weeksquarter?$weeksquarter:0?></td>
		       <td sorttable_customkey="<?=$peakinquarter?$peakinquarter:9999?>" class=""><?=$peakinquarter?$peakinquarter:0?></td>
		       <td class=""><?=$weeksquarterfeat?$weeksquarterfeat:0?></td>
		       <td sorttable_customkey="<?=$peakinquarterfeat?$peakinquarterfeat:9999?>"  class=""><?=$peakinquarterfeat?$peakinquarterfeat:0?></td>
            	  </tr>
<? }?>
            	  </tbody>
            	</table>
            	</div>           
