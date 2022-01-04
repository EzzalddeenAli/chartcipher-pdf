<? 
include "connect.php";

$tablename = "charts";

if( 1 == 0 )
    {
if (($handle = fopen("/tmp/chart.csv", "r")) !== FALSE) {
    $started = false;
    $count = 0;
    while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
	if( strtolower( $data[0] ) == "chart" )
            {
                $started = true;
                continue; 
            }
	//	print_r( $data );
	$medium = "";
	if( $data[2] )
	    {
		if( $medium ) $medium .= ",";
		$medium .= "$data[2]";
	    }
	if( $data[3] )
	    {
		if( $medium ) $medium .= ",";
		$medium .= "$data[3]";
	    }
	if( $data[4] )
	    {
		if( $medium ) $medium .= ",";
		$medium .= "$data[4]";
	    }
	$genre = "";
	if( $data[5] )
	    {
		if( $genre ) $genre .= ",";
		$genre .= "$data[5]";
	    }
	if( $data[6] )
	    {
		if( $genre ) $genre .= ",";
		$genre .= "$data[6]";
	    }
	$genre = $genre?"'".escMe( $genre )."'": "NULL";
	$medium = $medium?"'".escMe( $medium )."'": "NULL";
	db_query( "update charts set chartdescr = '" . escMe( $data[1] ) . "' where chartkey = '$data[0]'" );
	//	echo( "update charts set chartmedium = " . $medium . " where chartkey = '$data[0]'<br>" );
	db_query( "update charts set chartmedium = " . $medium . " where chartkey = '$data[0]'" );
	db_query( "update charts set genre = " . $genre . " where chartkey = '$data[0]'" );
	//	echo( "update charts set genre = " . $genre . " where chartkey = '$data[0]'<br>" );
    }
}
    }


$uppercasesingle = "Chart";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

    function anySongsWith( $tablename, $songid ) 
    {
      return false;
      
    }
$extracolumns = array( "chartkey"=>"Key", "chartdescr"=> "Description", "chartmedium"=> "Medium", "genre"=> "Genre", "IsLive"=>"IsLive" );
$extracolumnsizes = array( "chartdescr" => 80, "chartkey" => 40, "chartmedium" => 40, "genre" => 40 );

$specialname = "chartname";
include "generic.php";
?>
