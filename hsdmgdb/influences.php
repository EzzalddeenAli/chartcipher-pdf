<? 
include "connect.php";

$tablename = "influences";

$uppercasesingle = "Influence";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );
$extracolumns = array( "category"=>"Category", "influencegroupid"=>"Influence Group", "OrderBy"=> "Order By", "HideFromHSDCharts"=>"Hide From HSD Charts" );
$extracolumnsizes = array( "OrderBy" => 4, "InfoDescr" => 40 );
$obdesc = "asc";
$admin_hasadvsearch = true;

$selectcolumns = array( "influencegroupid" );
$selectoptions = array( "influencegroupid"=> db_query_array( "select id, Name from influencegroups" ) );



// $res = db_query_rows( "select * from $tablename order by OrderBy, Name" );
// $i = 10; 
// foreach( $res as $r )
// {
// 	db_query( "update subgenres set OrderBy = $i where id = $r[id]" );
// 	$i += 10;
// }



include "generic.php";
?>