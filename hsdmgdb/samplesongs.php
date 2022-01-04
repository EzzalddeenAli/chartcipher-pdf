<? 
include "connect.php";

$tablename = "samplesongs";

$uppercasesingle = "Sample Song";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );
$extracolumnsizes = array( "Year"=>"10" );
$extracolumns = array( "Year"=>"Year" );

include "generic.php";
?>