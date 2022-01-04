<? 
include "connect.php";

$tablename = "endingtypes";

$uppercasesingle = "Ending Type";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumnsizes = array( "OrderBy" => 4, "InfoDescr" => 40 );
$extracolumns = array( "OrderBy"=>"Order By (highest is shown first)", "InfoDescr"=> "Info <b>DO NOT USE QUOTES</b>" );
//$admin_hasadvsearch = true;

include "generic.php";
?>