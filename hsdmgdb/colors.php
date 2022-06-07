<? 
include "connect.php";

$tablename = "colors";

$uppercasesingle = "Color";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumnsizes = array( "OrderBy" => 4 );
$extracolumns = array( "OrderBy"=>"Order By (lowest is shown first, FIRST MUST BE 0 )" );
//$admin_hasadvsearch = true;

$obdesc = "asc";
include "generic.php";
?>