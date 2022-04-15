<? 

include "connect.php";

include "nav.php";


?>
<h3>HSD Song Admin</h3>


Welcome!

<? 
$charts = db_query_rows( "select * from charts where UseOnDb = 1 order by OrderBy" );
foreach( $charts as $crow )
{
	$chartid = $crow[id];
	echo( "<h3>$crow[Name]</h3>" );
	$num = db_query_first_cell( "select count(*) from songs where find_in_set( $chartid, chartids )" );
	$numbill = db_query_first_cell( "select count(distinct( title ), artist ) from dbi360_admin.billboardinfo where chart = '$crow[chartkey]'" );
	echo( "Num Songs: $num<br>" );	
	echo( "Num In Billboard Data but not in CC: ". ( $numbill - $num ) . "<br>" );	
	echo( "<br>" );
}

?>


<? include "footer.php"; ?>