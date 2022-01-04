<? 
include "connect.php";
$_SESSION["loggedin"] = 0;
$_SESSION["isadminlogin"] = 0;
Header( "Location: index.php" );
?>