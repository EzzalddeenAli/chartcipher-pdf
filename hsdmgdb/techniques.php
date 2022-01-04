<? 
include "connect.php";

$tablename = "techniques";

$uppercasesingle = "Technique";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );
$extracolumnsizes = array( "InfoDescr"=>"150" );
$extracolumns = array( "InfoDescr"=>"Description"  );

    function anySongsWith( $tablename, $songid )
    {
      $res = db_query_first_cell( "select count(*) from song_to_technique where techniqueid = '$songid'" );
      return $res;
      
    }

include "generic.php";
?>
