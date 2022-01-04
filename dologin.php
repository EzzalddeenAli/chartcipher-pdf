<? 
$nologin = 1;
$nologinrequired = 1;
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions{$mybychart}.php";
$user = $_REQUEST["username"];
$pass = $_REQUEST["password"];


$fields = array();

$res = db_query_first_cell( "select id from proxylogins where email = '$user' and password = '$pass'" );

if( $res )
{
    $fields["id"] = $res;
}
else
{
    $fields["error"] = "notfound";
}
echo( json_encode( $fields ) );

?>