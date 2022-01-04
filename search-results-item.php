<?php 

$nologin = 1;
require_once "hsdmgdb/connect.php";
require_once "functions.php";

if( !$id )
{
    // echo( "hmm" );
    // print_r( $GLOBALS );
    $name = $_SERVER["REDIRECT_URL"];
    $name = str_replace( ".php", "", $name );
    $name = substr( $name, 1 );
}

$url = db_query_first_cell( "select redirto from shortened where code = '$name'" );
if( $url )
{
Header( "Location: $url" );
exit;
}


    Header( "Location: index.php" );
    exit; 


?>