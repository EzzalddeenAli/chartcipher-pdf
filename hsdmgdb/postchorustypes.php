<? 
include "connect.php";

$tablename = "postchorustypes";

$uppercasesingle = "Post-Chorus Type";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );
$extracolumnsizes = array( "InfoDescr" => 40 );
$extracolumns = array( "InfoDescr"=> "Info <b>DO NOT USE QUOTES</b>"  );

include "generic.php";
?>