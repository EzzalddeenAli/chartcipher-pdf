<? 
include "connect.php";

$tablename = "sampletypes";

$uppercasesingle = "Sample Type";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumns = array( "OrderBy"=> "Order By" );
$extracolumnsizes = array( "OrderBy" => 4, "InfoDescr" => 40, "Name" => 40 );

include "generic.php";
?>