<? 
include "connect.php";

$tablename = "genres";

$uppercasesingle = "Genre";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

    function anySongsWith( $tablename, $songid ) 
    {
      $res = db_query_first_cell( "select count(*) from songs where GenreID = '$songid'" );
      return $res;
      
    }

//genres.php
include "generic.php";
?>