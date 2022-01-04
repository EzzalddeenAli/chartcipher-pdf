<? 
include "connect.php";

$tablename = "clients";

function anySongsWith( $tablename, $songid ) 
{
   $res = db_query_first_cell( "select count(*) from songs where ClientID = '$songid'" );
   return $res;
}

$uppercasesingle = "Client";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );
$extracolumnsizes = array( "OrderBy" => 4 );
$extracolumns = array( "OrderBy"=>"Order By"  );

include "generic.php";
?>