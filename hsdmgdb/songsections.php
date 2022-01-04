<? 
include "connect.php";

$tablename = "songsections";

$uppercasesingle = "Song Section";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumnsizes = array( "OrderBy" => 4, "Abbreviation"=>4, "ShortAbbreviation"=>2, "InAbbreviated"=>1 );
$extracolumns = array( "OrderBy"=>"Order By (highest is shown first)", "SpreadsheetName"=>"Spreadsheet Name", "WithoutNumber"=>"Without Number", "Abbreviation"=>"Abbreviation", "ShortAbbreviation"=>"Short Abbreviation", "InAbbreviated"=>"In Short Form (1 or 0)" );

include "generic.php";
?>