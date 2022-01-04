<? 
include "connect.php";

$tablename = "timesignatures";

$uppercasesingle = "Time Signature";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

function anySongsWith( $tablename, $songid ) 
{
   $res = db_query_first_cell( "select count(*) from songs where timesignatureid = '$songid'" );
   return $res;
}



$issinglecolumn = 1;

/* db_query( "insert into timesignatures ( Name ) values ( '4/4' ),  */
/* ( '3/4' ),  */
/* ( '6/4' ),  */
/* ( '6/8' ),  */
/* ( '12/8' ),  */
/* ( '2/2' ) " ); */

include "generic.php";
?>
