<? 
include "connect.php";

$tablename = "chorusstructures";

$uppercasesingle = "Chorus Structure";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumnsizes = array( "InfoDescr" => 40 );
$extracolumns = array( "InfoDescr"=> "? Info"  );

include "generic.php";
?>