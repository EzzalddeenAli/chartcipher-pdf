<? 
$nologin = 1;
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions{$mybychart}.php";

// +-----------+--------------+------+-----+---------+----------------+
// | Field     | Type         | Null | Key | Default | Extra          |
// +-----------+--------------+------+-----+---------+----------------+
// | id        | int(11)      | NO   | PRI | NULL    | auto_increment |
// | userid    | int(11)      | YES  |     | NULL    |                |
// | Name      | varchar(255) | YES  |     | NULL    |                |
// | url       | text         | YES  |     | NULL    |                |
// | sessionid | varchar(255) | YES  |     | NULL    |                |
// +-----------+--------------+------+-----+---------+----------------+
$type= $type?$type:"saved";

$tablename = "{$type}searches";
if( $type == "savedartists" )
    $tablename = "savedartists";

$onemin = date( "Y-m-d H:i:s", strtotime( "5 minutes ago" ) );
if( $type != "saved"  && $type != "savedartists" )
{
	$ext = $proxyloginid?" and proxyloginid = '$proxyloginid'":"";
	db_query( "delete from $tablename where userid = '$userid' and url = '" . escMe( $url ) . "' and dateadded > '$onemin' $ext " );
}

if( !$proxyloginid ) $proxyloginid = 0;

$ins = db_query_insert_id( "insert into $tablename ( userid, proxyloginid, Name, url, sessionid, chartid, searchtype, dateadded ) values ( '$userid', '$proxyloginid', '". escMe( $searchname )."', '". escMe( $url )."', '". escMe( $sessid )."', '". escMe( $chartid )."', '". escMe( $searchtype )."', now() )" );
echo( $ins );
?>
