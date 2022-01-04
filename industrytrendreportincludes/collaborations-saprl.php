<? 
if( $doingyearlysearch )
    {
	$startquarterid = calculateQuarterNumber($search[dates][fromq], $search[dates][fromy] );
	$endquarterid = calculateQuarterNumber($search[dates][toq], $search[dates][toy] );
	$songrows = db_query_rows( "select * from songs where id in (select songid from song_to_weekdate, weekdates where QuarterNumber >= $startquarterid and QuarterNumber<= $endquarterid and weekdateid = weekdates.id ) and IsActive = 1", "id" );
	$yearweekdates = db_query_array( "select id from weekdates where QuarterNumber >= $startquarterid and QuarterNumber<= $endquarterid", "id", "id" );
    }
else
    {
	$thisquarterid = calculateQuarterNumber($search[dates][fromq], $search[dates][fromy] );
	$threeago = $thisquarterid - 3;
	$songrows = db_query_rows( "select * from songs where id in (select songid from song_to_weekdate, weekdates where QuarterNumber >= $threeago and QuarterNumber<= $thisquarterid and weekdateid = weekdates.id ) and IsActive = 1", "id" );
	$yearweekdates = db_query_array( "select id from weekdates where QuarterNumber >= $threeago and QuarterNumber<= $thisquarterid", "id", "id" );
    }

$results = array();
$csongstr = implode( ", ", array_keys( $songrows ) );

$songwritersarr = db_query_array( "select group_concat( Name ) as Name, songid from artists, song_to_artist where songid in ( $csongstr ) and artistid = artists.id and type = ( 'creditedsw' ) group by songid order by Name", "songid", "Name" );

$artistsarr = db_query_array( "select group_concat( Name ) as Name, songid from artists, song_to_artist where songid in ( $csongstr ) and artistid = artists.id and type in ( 'featured', 'primary' ) group by songid order by Name", "songid", "Name" );

$groupsarr = db_query_array( "select group_concat( Name ) as Name, songid from groups, song_to_group where songid in ( $csongstr ) and groupid = groups.id and type in ( 'featured', 'primary' ) group by songid order by Name", "songid", "Name" );

$labelsarr = db_query_array( "select group_concat( Name ) as Name, songid from labels, song_to_label where songid in ( $csongstr ) and labelid = labels.id group by songid order by Name", "songid", "Name" );

$producersarr = db_query_array( "select group_concat( Name ) as Name, songid from producers, song_to_producer where songid in ( $csongstr ) and producerid = producers.id group by songid order by Name", "songid", "Name" );

$peakchartarr = db_query_array( "select min( cast( replace( type, 'position', '' ) as signed ) ) as cnt, songid from song_to_weekdate where songid in ( $csongstr ) and weekdateid in ( " . implode( ", ", $yearweekdates ) . " ) group by songid", "songid", "cnt" );

foreach( $songrows as $songrow )
{
    $tmp = array();
//    echo( "checking on $songrow[CleanUrl] <br>" );
    $songwriters = explode( ",", $songwritersarr[$songrow[id]] ); //db_query_array( "select Name from artists, song_to_artist where songid = $songrow[id] and artistid = artists.id and type in ( 'creditedsw' ) order by Name", "Name", "Name" );
    natcasesort( $songwriters );
    $songwriterstr = implode( ", ", array_diff( $songwriters, ['']) );
    $artists = explode( ",", $artistsarr[$songrow[id]] ); // db_query_array( "select Name from artists, song_to_artist where songid = $songrow[id] and artistid = artists.id and type in ( 'featured', 'primary' ) order by Name", "Name", "Name" );
    $groups = explode( ",", $groupsarr[$songrow[id]] ); //  = db_query_array( "select Name from groups, song_to_group where songid = $songrow[id] and groupid = groups.id and type in ( 'featured', 'primary' ) order by Name", "Name", "Name" );
    $artists = array_merge( $artists, $groups );
    
    natcasesort( $artists );
    $artistsstr = implode( ", ", array_diff( $artists, ['']) );

    $labels = explode( ",", $labelsarr[$songrow[id]] ); //db_query_array( "select Name from labels, song_to_label where songid = $songrow[id] and labelid = labels.id order by Name", "Name", "Name" );
    natcasesort( $labels );
    $labelsstr = implode( ", ", array_diff( $labels, ['']) );

    $producers = explode( ",", $producersarr[$songrow[id]] );// db_query_array( "select Name from producers, song_to_producer where songid = $songrow[id] and producerid = producers.id order by Name", "Name", "Name" );
    natcasesort( $producers );
    $producersstr = implode( ", ", array_diff( $producers, ['']) );

    $peakchartstr = $peakchartarr[$songrow[id]]; // db_query_first_cell( "select cast( replace( type, 'position', '' ) as signed ) from song_to_weekdate where songid = $songrow[id] and weekdateid in ( " . implode( ", ", $yearweekdates ) . " ) order by cast( replace( type, 'position', '' ) as signed ) limit 1" );

    $key = $songwriterstr . "_" . $artistsstr . "_" . $labelsstr . "_" . $producersstr . "_" . $songrow[id];
    
    if( isset( $results[$key] ) )
    {
        $tmp = $results[$key];
        $tmp[numsongs][] = "<a  href='$songrow[CleanUrl]'>" . getSongnameFromSongid( $songrow[id] ) . "</a>";
    }
    else
    {
        $tmp = array();
        $tmp[numsongs][] = "<a  href='$songrow[CleanUrl]'>" . getSongnameFromSongid( $songrow[id] ) . "</a>";
        $tmp[artistname] = $artistsstr;
        $tmp[peakchart] = $peakchartstr;
        $tmp[producername] = $producersstr;
        $tmp[songwritername] = $songwriterstr;
        $tmp[labelname] = $labelsstr;
    }

	$results[$key] = $tmp;
}
array_multisort(array_keys($results), SORT_NATURAL | SORT_FLAG_CASE, $results);

if( $doingyearlysearch )
{
    $prevquarter = $search[dates][fromq];
    $prevyear = $search[dates][fromyear];
    $quarter = $search[dates][toq];
    $year = $search[dates][toyear];
}
else
{
    $prev = getPreviousQuarter( "{$search[dates][fromq]}/{$search[dates][fromy]}" );
    $prev = getPreviousQuarter( $prev );
    $prev = getPreviousQuarter( $prev );
    list( $prevquarter, $prevyear ) = explode( "/", $prev );
}
    ?>
            <div class="search-body">
<!--        <a href='#collaborations-saprl' id="collab-saprl" onClick='return false'  class="save-header-back exportpng">Save As Image</a>-->
<h2 class="tabletitle"><?=$sectionname?>: Q<?=$prevquarter?> <?=$prevyear?> to Q<?=$quarter?> <?=$year?> </h2>

                       <table id="collab-saprl-table" class="sortable">
             <tbody>
            		<tr>
                <th class="">Song<br><i>(click on column title to sort)</i></th>
	            	  <th class="">Artist     <br><i>(click on column title to sort)</i></th>
            			<th  class="">Songwriter / Team     <br><i>(click on column title to sort)</i></th>
	            	    <th class="">Producer / Team     <br><i>(click on column title to sort)</i></th>
	            	       <th class="">Record Label <br><i>(click on column title to sort)</i></th>
                <th class="">Peak Chart Position<br><i>(click on column title to sort)</i></th>
            	  </tr>
<? foreach( $results as $arr ) { ?>
            	  <tr>
                                 <td class=""><?=implode( ", ", $arr[numsongs] )?></td>
            	  	<td class=""><?=$arr[artistname]?></td>
            	  	<td class=""><?=$arr[songwritername]?></td>
            	  	<td class=""><?=$arr[producername]?></td>
            	  		<td class=""><?=$arr[labelname]?></td>
            	  		<td class=""><?=$arr[peakchart]?></td>
            	  </tr>
                                 <? } ?>
            	  </tbody>
            	</table>
            	</div>           
