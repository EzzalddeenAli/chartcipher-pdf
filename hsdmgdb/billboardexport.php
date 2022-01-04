<? 
include "connect.php";

 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }
$allcharts = db_query_array( "select * from charts order by chartname", "chartkey", "chartname" );

//db_query( "update billboardinfo set artist = replace( artist, '&#039;', '\'' ) where artist like '%&#039;%'" );
//db_query( "update billboardinfo set title = replace( title, '&#039;', '\'' ) where title like '%&#039;%'" );

$weeks = db_query_array( "select OrderBy, Name from weekdates order by OrderBy", "OrderBy", "Name" );


if( $go )
    {
	$whr = "1";
	if( $chartname )
	    {
		$whr .= " and chart = '$chartname'";
	    }
	if( $fromweek )
	    {
		$from = date( "Y-m-d", $fromweek );
		$whr .= " and thedate >= '$from'";
	    }
	if( $toweek )
	    {
		$to = date( "Y-m-d", $toweek );
		$whr .= " and thedate <= '$to'";
	    }

	    if( $groupresults )
	    {
		    $cols = array();
		    $cols[] = "chart"; 
		    $cols[] = "title"; 
		    $cols[] = "artist"; 
		    $cols[] = "peakpos_alltime"; 
		    $cols[] = "weeksonchart_alltime"; 
		    
		    
		    $rows = db_query_rows( "select chart, title, artist, ( select min( rank ) from dbi360_admin.billboardinfo b where b.artist = b2.artist and b.title = b2.title and b.chart = b2.chart ) as peakpos_alltime,  ( select count( * ) from dbi360_admin.billboardinfo b where b.artist = b2.artist and b.title = b2.title and b.chart = b2.chart ) as weeksonchart_alltime from dbi360_admin.billboardinfo b2 where $whr group by chart, title, artist order by chart, title, artist" );
	    }
	    else
		{
		    $cols = array();
		    $cols[] = "chart"; 
		    $cols[] = "thedate"; 
		    $cols[] = "title"; 
		    $cols[] = "rank"; 
		    $cols[] = "artist"; 
		    $cols[] = "lastweek"; 
		    $cols[] = "peakpos"; 
		    $cols[] = "weeksonchart"; 
		    
		    
		    $rows = db_query_rows( "select ". implode( ", ", $cols ) . " from dbi360_admin.billboardinfo where $whr order by chart, thedate, rank" );
		}

	    header("Content-type: text/csv");
	    header("Cache-Control: no-store, no-cache");
	    header('Content-Disposition: attachment; filename="chart.csv"');
    
	$handle = fopen("php://output", "w");
	fputcsv( $handle, $cols );
	foreach( $rows as $a )
	  {
	      $tmp = array();
	      foreach( $cols as $c )
		  $tmp[] = $a[$c];
	    fputcsv( $handle, $tmp );
	  }
    
	fclose( $handle );
	exit;

	
    }

include "nav.php";

?>

<form method='post'>
<table>
    <?=outputSelectRow( "Chart", "chartname", $chartname, $allcharts )?>
    <?=outputSelectRow( "From Week", "fromweek", $fromweek, $weeks )?>
    <?=outputSelectRow( "To Week", "toweek", $fromweek, $weeks )?>
    <tR><td>Group Results?<br><i>(one line per song)</i></b> </td><td><input type='checkbox' name='groupresults' value='1' <?=$groupresults?"CHECKED":""?>></td></tr>
<tr><td><input type='submit' name='go' value='Go'>
</table>

    <h3>Current Data (Num Weeks Pulled)</h3>
<table>
    <? foreach( $allcharts as $chartid=>$cname ) { ?>
						   <tr><td><?=$cname?> (<?=$chartid?>)</td>
						   <td><?=db_query_first_cell( "select count( distinct( thedate ) ) from dbi360_admin.billboardinfo where chart = '$chartid'" )?></td>
</tr>
						   <? } ?>
</table>
