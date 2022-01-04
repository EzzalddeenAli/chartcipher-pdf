<? 
include "connect.php";

 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

$overalltype = "genre";
$overalltypedisplay = "Genre";

include "genericreport.php";
?>