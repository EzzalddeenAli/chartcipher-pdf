<? 
include "connect.php";

 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }


$tablename = "users";

$uppercasesingle = "User";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumns = array( "username"=>"Username", "password"=>"Password", "isadmin"=>"Is Admin", "inactive"=>"Inactive" );

    function anySongsWith( $tablename, $songid )
    {
	return false;
      
    }

include "generic.php";
?>
