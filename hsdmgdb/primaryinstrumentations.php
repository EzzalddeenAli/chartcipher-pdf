<? 
include "connect.php";

$tablename = "primaryinstrumentations";

$uppercasesingle = "Prominent Instrumentation";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$admin_hasadvsearch = true;

include "generic.php";
?>