<? 
$nologin = 1;
$nologinrequired = 1;
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions{$mybychart}.php";
$key = $_GET["update"];

$tablename = $tablename?$tablename:"savedsearches";

$exp = explode(",", $key );
foreach( $exp as $keyid=>$id )
{
	$id = str_replace( "ss", "", $id );
	if( $keyid )
		db_query( "update $tablename set OrderBy = '$keyid' where id = $id" );
}
?>