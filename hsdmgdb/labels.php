<? 
include "connect.php";

$tablename = "labels";

$uppercasesingle = "Label";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumns = array( "TwitterHandle"=>"TwitterHandle", "TwitterURL"=>"TwitterURL", "InstagramHandle"=>"InstagramHandle", "InstagramURL"=>"InstagramURL" );
/* $extracolumns = array( "Imprint"=>"Imprint" ); */

    /* function anySongsWith( $tablename, $songid )  */
    /* { */
    /*   $res = db_query_first_cell( "select count(*) from songs where LabelID = '$songid'" ); */
    /*   return $res; */
      
    /* } */

include "generic.php";
?>