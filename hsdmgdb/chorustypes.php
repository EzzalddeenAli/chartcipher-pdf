<? 
include "connect.php";

$tablename = "chorustypes";

$uppercasesingle = "Chorus Type";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );
$extracolumnsizes = array( "OrderBy" => 4, "InfoDescr" => 40 );
$extracolumns = array( "OrderBy"=>"Order By", "InfoDescr"=> "? Info"  );

include "generic.php";
?>