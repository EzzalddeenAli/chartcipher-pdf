<? 
$exp = explode( "-",  $_SERVER["SCRIPT_NAME"] );
//print_r( $_SERVER  );exit;
$thetype = array_shift( $exp );
include "compositional-search.php";
?>