<? 
require_once "connect.php"; 

$charts = db_query_array( "select id, chartkey from charts where UseOnDB = 1 ", "id", "chartkey" );
$weekdates = db_query_array( "select id, Name from weekdates", "id", "Name" );
$bbids = array();
if( 1 == 1 )
    {
    	    db_query( "delete from song_to_weekdate " );
	file_put_contents( "loadbb1.txt", "starting \n" );
foreach( $charts as $cid=>$cname )
{
	file_put_contents( "loadbb1.txt", "-------------------starting $cname \n", FILE_APPEND );
    foreach( $weekdates as $weekdateid=>$wname )
	{
	    $res = db_query_first_cell( "select count(*) from song_to_weekdate where chartid = $cid and weekdateid = $weekdateid" );
	    if( !$res )
		{
	    	file_put_contents( "loadbb1.txt", "starting $cname - $wname \n", FILE_APPEND );

		    $bsongs = db_query( "select * from dbi360_admin.billboardinfo where chart = '$cname' and weekdateid = $weekdateid" );
	    	file_put_contents( "loadbb1.txt", count( $bsongs ) . " results... \n", FILE_APPEND );
		foreach( $bsongs as $brow )
			{
			    if( isset( $bbids[$brow["artist"]][$brow["title"]] ) )
				{
				    $mysongid = $bbids[$brow["artist"]][$brow["title"]];
				}
			    else
				{
				    $mysongid = db_query_first_cell( "select id from songs where BillboardName = '".escMe( $brow[title] ) . "' and BillboardArtistName = '".escMe( $brow[artist] ) . "'" );
				    $bbids[$brow["artist"]][$brow["title"]] = $mysongid;
				    if( !$mysongid )
					{
					    file_put_contents( "loadbb1.txt", "starting no song match for $brow[title] $brow[artist] \n", FILE_APPEND );
					}
				}
			    if( $mysongid )
				{
//				    	file_put_contents( "loadbb1.txt", "$brow[title], $brow[artist] -- insert into song_to_weekdate( songid, weekdateid, chartid, type, actualposition ) values ( $mysongid, $weekdateid, $cid, 'position{$brow[rank]}', {$brow[rank]} )\n", FILE_APPEND );
				    db_query( "insert into song_to_weekdate( songid, weekdateid, chartid, type, actualposition ) values ( $mysongid, $weekdateid, $cid, 'position{$brow[rank]}', {$brow[rank]} )" );
				}
			}
		}
	}
	file_put_contents( "loadbb1.txt", "---------------------ending chart $cname \n", FILE_APPEND );

}
    }

if( 1 == 1 )
    {
db_query( "delete from song_to_chart " );
$songs = db_query_array( "select id from songs", "id", "id" );
       	file_put_contents( "loadbb1.txt", "starting mapping songs to charts\n", FILE_APPEND );
foreach( $songs as $songid )
{
	file_put_contents( "loadbb1.txt", "doing song $songid\n", FILE_APPEND );
    foreach( $charts as $chartid=>$chartname )
	{
	    $firstrow = db_query_first( "select Name, type, OrderBy, weekdates.id from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id  and chartid = $chartid order by OrderBy limit 1" );
	    if( !$firstrow[OrderBy] ) continue;
	    $firstdate = $firstrow[OrderBy];
	    //echo( "autoclcing $songid: " . $firstdate . "<br>" );
	    if( date( "n", $firstdate ) <= 3 )
		{
		    $quarter = "1/" . date( "Y", $firstdate );
		}
	    else if( date( "n", $firstdate ) <= 6 )
		
		{
		    $quarter = "2/" . date( "Y", $firstdate );
		}
	    else if( date( "n", $firstdate ) <= 9 )
		{
		    $quarter = "3/" . date( "Y", $firstdate );
		}
	    else
		{
		    $quarter = "4/" . date( "Y", $firstdate );
		}
	    
	    $firstweek = $firstrow["Name"];
	    $numweeks = db_query_first_cell( "select count(*) from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id and chartid = $chartid order by OrderBy" );
	    $peak = db_query_first_cell( "select type from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id and chartid = $chartid order by actualposition limit 1" );
	    $peak = str_replace( "position", "", $peak );;
	    $entrypos = str_replace( "position", "", $firstrow["type"] );;
	    $year = date( "Y", $firstdate );
	    db_query( "insert into song_to_chart( songid, chartid, PeakPosition, EntryPosition, NumberOfWeeksSpentInTheTop10, YearEnteredTheTop10, QuarterEnteredTheTop10, WeekEnteredTheTop10 ) values ( '$songid', '$chartid', '$peak', '$entrypos', '$numweeks', '$year', '$quarter', '$firstweek' )" );
	}
//	file_put_contents( "loadbb1.txt", "ending song $songid\n", FILE_APPEND );

}

    }
$res = db_query_array( "select songid, group_concat( chartid ) as num from song_to_chart group by songid", "songid", "num" );

foreach( $res as $sid=>$values )
{
    $val = "";
    $values = explode( ",", $values );
    foreach( $values as $vid )
	{
	    $vid = trim( $vid );
	    if( $val )
		$val .= ",";
	    $val .= "$vid";
	}
    
    db_query( "update songs set chartids ='$val' where id = $sid" );
    file_put_contents( "loadbb1.txt", "chart info $sid ($val)\n", FILE_APPEND );
}


?>
