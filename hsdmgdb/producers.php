<? 
include "connect.php";

$tablename = "producers";

$uppercasesingle = "Production Group";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumns = array( "member1"=>"Member 1", "member2"=>"Member 2", "member3"=>"Member 3", "member4"=>"Member 4", "member5"=>"Member 5", "member6"=>"Member 6", "Gender"=>"Gender", "TwitterHandle"=>"TwitterHandle", "TwitterURL"=>"TwitterURL", "InstagramHandle"=>"InstagramHandle", "InstagramURL"=>"InstagramURL" );


include "generic.php";
?>