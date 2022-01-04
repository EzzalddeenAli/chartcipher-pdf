<? 
include "connect.php";

$tablename = "introtypes";

$uppercasesingle = "Intro Type";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumnsizes = array("InfoDescr" => 40 );
$extracolumns = array(  "ishook"=> "Is Hook?", "InfoDescr"=> "? Info"  );

$admin_hasadvsearch = true;

include "generic.php";
?>