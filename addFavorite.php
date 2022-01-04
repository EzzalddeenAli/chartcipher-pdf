<? 
$nologin = 1;
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions.php";


$id = db_query_first_cell( "select id from favorites where userid = '$userid' and proxyloginid = '$proxyloginid' and songid = '$favoriteid'" );

if( $id )
{
db_query( "delete from favorites where userid = '$userid' and proxyloginid = '$proxyloginid' and songid = '" .  escMe( $favoriteid )."'" );
echo( "removed" );
}
else
{
    db_query( "insert into favorites ( userid, proxyloginid, songid, dateadded ) values ( '$userid', '$proxyloginid', '". escMe( $favoriteid )."', now() )" );
    echo( "added" );
}
    
?>
