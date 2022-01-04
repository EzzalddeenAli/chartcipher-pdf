<? 
include "connect.php";

$tablename = "imprints";

$uppercasesingle = "Imprint";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

    function anySongsWith( $tablename, $songid ) 
    {
      $res = db_query_first_cell( "select count(*) from song_to_imprint where imprintid = '$songid'" );
      return $res;
      
    }

include "generic.php";
?>