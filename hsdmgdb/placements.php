<? 
include "connect.php";

$tablename = "placements";

$uppercasesingle = "Placement";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumnsizes = array( "OrderBy" => 4, "InfoDescr" => 40 );
$extracolumns = array( "OrderBy"=>"Order By (highest is shown first)", "InfoDescr"=> "Info <b>DO NOT USE QUOTES</b>" );
$admin_hasadvsearch = true;

include "generic.php";
?>