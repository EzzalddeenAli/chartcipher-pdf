<? 
include "connect.php";

$tablename = "artists";

$uppercasesingle = "Artist";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$altname = "Stage Name";

$noprod = db_query_rows( "select * from artists where producerid = 0 or producerid is null" );
foreach( $noprod as $p )
{
	$pid = db_query_first_cell( "select id from producers where Name = '" . escMe( $p[Name] ) . "'" );
	if( $pid )
		db_query( "update artists set producerid = $pid where id = $p[id]" );
	
}

$noprod = db_query_rows( "select * from groups where producerid = 0 or producerid is null" );
foreach( $noprod as $p )
{
	$pid = db_query_first_cell( "select id from producers where Name = '" . escMe( $p[Name] ) . "'" );
	if( $pid )
		db_query( "update groups set producerid = $pid where id = $p[id]" );
	
}

$extracolumnsizes = array( "YearBorn"=>"10", "datecreated"=>"10", "FirstName"=>"10", "MiddleName"=>"10" );
$extracolumns = array( "FirstName"=>"First Name", 
"MiddleName"=>"Middle Name", 
"LastName"=>"Last Name", 
"YearBorn"=>"Date of Birth<br> (mm/dd/yyyy)", 
"City"=>"City", 
"WhereBorn"=>"Country", 
"Wikipedia"=>"Wikipedia URL", 
"ArtistURL"=>"Artist URL",
//"producerid"=>"Producer",
		       "datecreated"=>"Date Created",
//"ArtistVocalGender"=>"Vocal Gender",
//"Gender"=>"Artist Gender"
 );

//$selectcolumns = array( "ArtistVocalGender" );
//$selectoptions = array( "ArtistVocalGender"=> getEnumValues( "ArtistVocalGender", "artists" ) );

// Date of Birth (mm/dd/yyyy)
// City
// Country
// Wikipedia URL
// Artist’s Site URL
// fix me
    // function anySongsWith( $tablename, $songid ) 
    // {
    //   $res = db_query_first_cell( "select count(*) from songs where LabelID = '$songid'" );
    //   return $res;
      
    // }

include "generic.php";
db_query( "update artists set FullBirthName = concat( FirstName, ' ', LastName ) where MiddleName = '' or MiddleName is NULL" );
db_query( "update artists set FullBirthName = concat( FirstName, ' ', MiddleName, ' ', LastName ) where MiddleName > '' " );
?>
