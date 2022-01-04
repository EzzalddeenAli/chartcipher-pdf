<? 
include "connect.php";

if( !$clientfilter )
    $clientwhere = " IsActive = 1 ";

 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

$overalltype = "topten";
$overalltypedisplay = "Top 10";
$addartistgenre = true;

include "genericreport.php";
?>