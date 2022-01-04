<? 
include "connect.php";

$arr = db_query_array( "Select id, WithoutNumber from songsections", "id", "WithoutNumber" );
foreach( $arr as $a=>$b )
{
    db_query( "update song_to_songsection set WithoutNumberHard = '$b' where songsectionid = $a" );
}

?>