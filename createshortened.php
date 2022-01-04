<? 
$nologin = 1;
$nologinrequired = 1;
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions{$mybychart}.php";
$url = $_REQUEST["url"];
$hash = $_REQUEST["hash"];
$chartid = $chartid?$chartid:0;

if( $url && $hash )
{
    $fields = array();
    
    // $res = db_query_first_cell( "select code from shortened where redirto = '" . escMe( $url ) . "'" );
    // if( $res )
    // 	$hash = $res; 
    // else
    db_query( "insert into shortened ( code, redirto, chartid ) values ( '$hash' , '" . escMe( $url ) . "', $chartid ) " );
    $fields["val"] = "https://analytics.chartcipher.com/{$hash}";
}    
else
{
    $fields["error"] = "error";
}
echo( json_encode( $fields ) );

?>
