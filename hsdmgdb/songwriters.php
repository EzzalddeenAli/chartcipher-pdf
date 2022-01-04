<? 
include "connect.php";

$tablename = "songwriters";

$uppercasesingle = "Songwriter";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumns = array( "Gender"=>"Gender" );

include "generic.php";
?>
