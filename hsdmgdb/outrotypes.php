<? 
include "connect.php";

$tablename = "outrotypes";

$uppercasesingle = "Outro Type";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumnsizes = array( "InfoDescr" => 40 );
$extracolumns = array(  "InfoDescr"=> "? Info"  );

$admin_hasadvsearch = true;

include "generic.php";
?>