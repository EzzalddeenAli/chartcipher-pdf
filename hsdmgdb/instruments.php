<? 
include "connect.php";

$tablename = "instruments";

$uppercasesingle = "Instrument";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$admin_hasadvsearch = true;

include "generic.php";
?>