<? 
include "connect.php";

$tablename = "groups";

$uppercasesingle = "Group";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );


$extracolumnsizes = array( "artists"=>"100", "datecreated"=>"10" );
$extracolumns = array( "artists"=>"Artists (separate by semi colon)", "GroupVocalGender"=>"Vocal Gender", "TwitterHandle"=>"TwitterHandle", "TwitterURL"=>"TwitterURL", "InstagramHandle"=>"InstagramHandle", "InstagramURL"=>"InstagramURL", "datecreated"=>"Date Created" );

// fix me
    /* function anySongsWith( $tablename, $songid )  */
    /* { */
    /*   $res = db_query_first_cell( "select count(*) from songs where LabelID = '$songid'" ); */
    /*   return $res; */
      
    /* } */
$selectcolumns = array( "GroupVocalGender" );
$selectoptions = array( "GroupVocalGender"=> getEnumValues( "GroupVocalGender", "groups" ) );

include "generic.php";
?>