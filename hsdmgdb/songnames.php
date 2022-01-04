<? 
include "connect.php";

$tablename = "songnames";

$uppercasesingle = "Song Title";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$issinglecolumn = 1;

include "generic.php";
?>