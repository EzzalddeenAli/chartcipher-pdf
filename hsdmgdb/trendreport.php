<? 
include "connect.php";

 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

$overalltype = "trend";
$overalltypedisplay = "Trend";

include "genericreport.php";
?>