<? 
require_once "connect.php"; 

$charts = db_query_array( "select id, chartkey from charts where UseOnDB = 1", "id", "chartkey" );
$weekdates = db_query_array( "select id, Name from weekdates", "id", "Name" );
if( 1 == 1 )
    {
foreach( $charts as $cid=>$cname )
{
    foreach( $weekdates as $weekdateid=>$wname )
	{
	    $res = db_query_first_cell( "select count(*) from song_to_weekdate where chartid = $cid and weekdateid = $weekdateid" );
	    if( !$res )
		{
//		    echo( "starting $cname - $wname<br>" );
		    $bsongs = db_query_rows( "select * from dbi360_admin.billboardinfo where chart = '$cname' and weekdateid = $weekdateid" );
//		    echo( count( $bsongs ) . " results...<br>" );
		    foreach( $bsongs as $brow )
			{
			    $mysongid = db_query_first_cell( "select id from songs where BillboardName = '".escMe( $brow[title] ) . "' and BillboardArtistName = '".escMe( $brow[artist] ) . "'" );
			    if( $mysongid )
				{
				    db_query( "insert into song_to_weekdate( songid, weekdateid, chartid, type ) values ( $mysongid, $weekdateid, $cid, 'position{$brow[rank]}' )" );
				}
			}
		}
	}

}
    }

if( 1 == 1 )
    {
db_query( "delete from song_to_chart" );
$songs = db_query_array( "select id from songs", "id", "id" );
foreach( $songs as $songid )
{
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
	    $peak = db_query_first_cell( "select type from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id and chartid = $chartid order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
	    $peak = str_replace( "position", "", $peak );;
	    $entrypos = str_replace( "position", "", $firstrow["type"] );;
	    $year = date( "Y", $firstdate );
	    db_query( "insert into song_to_chart( songid, chartid, PeakPosition, EntryPosition, NumberOfWeeksSpentInTheTop10, YearEnteredTheTop10, QuarterEnteredTheTop10, WeekEnteredTheTop10 ) values ( '$songid', '$chartid', '$peak', '$entrypos', '$numweeks', '$year', '$quarter', '$firstweek' )" );
	}

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
}


?>
