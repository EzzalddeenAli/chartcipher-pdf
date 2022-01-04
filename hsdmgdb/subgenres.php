<? 
include "connect.php";

$tablename = "subgenres";

$uppercasesingle = "Influence";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );
$extracolumns = array( "category"=>"Category", "OrderBy"=> "Order By", "HideFromHSDCharts"=>"Hide From HSD Charts" );
$extracolumnsizes = array( "OrderBy" => 4, "InfoDescr" => 40 );
$obdesc = "asc";
$admin_hasadvsearch = true;
// $res = db_query_rows( "select * from $tablename order by OrderBy, Name" );
// $i = 10; 
// foreach( $res as $r )
// {
// 	db_query( "update subgenres set OrderBy = $i where id = $r[id]" );
// 	$i += 10;
// }



include "generic.php";
?>