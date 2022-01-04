<? 
include "connect.php";

$initquarternumber = 1;
for( $year = 2000; $year < date( "Y" ) + 1; $year++ )
{
    for( $quarter = 1; $quarter <= 4; $quarter++ )
    {
        $weekdates = getWeekdatesForQuarters( $quarter, $year );
        $weekdates[] = -1;
        db_query( "update weekdates set QuarterNumber = $initquarternumber where id in ( ". implode( ", ", $weekdates ) . " )" );
        $initquarternumber++; 
    }
}

$res = db_query_rows( "select * from weekdates" );
     foreach( $res as $r )
{
	db_query( "update weekdates set OrderBy = '" . strtotime( $r[Name] ) . "' where id = $r[id]" );
}

$tablename = "weekdates";

$uppercasesingle = "Week Date";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumnsizes = array( "OrderBy" => 10, "QuarterNumber" => 10 );
$extracolumns = array( "OrderBy"=>"Order By<br> (highest is shown first)", "QuarterNumber"=> "Quarter Number<Br> (Q1/2000 is 1)" );

include "generic.php";
?>