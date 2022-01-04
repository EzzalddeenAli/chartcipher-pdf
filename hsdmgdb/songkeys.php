<? 
include "connect.php";

$tablename = "songkeys";

$uppercasesingle = "Key";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$issinglecolumn = 1;

function anySongsWith( $tablename, $songid ) 
{
   $res = db_query_first_cell( "select count(*) from songs where songkeyid = '$songid'" );
   return $res;
}



//$extracolumns = array( "majorminor"=>"Major/Minor" );
/* db_query( "insert into songkeys ( Name, majorminor ) values ('A', 'Major' ), ('A#/Bb', 'Minor' ), ('B', ''), */
/*   (  'C', '' ),  */
/*   ('C#/Db', '' ),  */
/*   ('D', '' ),  */
/*   ('D#/Eb', ''  ),  */
/*   ('E', '' ),  */
/*   ('F', '' ),  */
/*   ('F#/Gb', '' ),  */
/*   ('G', '' ),  */
/*   ('G#/Ab', '' )" ); */

include "generic.php";
?>
