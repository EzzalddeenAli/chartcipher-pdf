<? 
$nologin = 1;
require_once "hsdmgdb/connect.php";
require_once "functions.php";

function outputCSV($data) {
    $output = fopen("php://output", "w");
    foreach ($data as $row)
	fputcsv($output, $row); // here you can change delimiter/enclosure
    fclose($output);
}

$tables = db_query_rows( "show tables" );

if( $csv )
    {
	header("Content-type: text/x-csv");
	header("Content-Disposition: attachment; filename=export.csv");
	$arr = array();
foreach( $tables as $t )
{
    $t = $t[0];
	$r = db_query_first( "select * from $t" );
	if( isset($r["InfoDescr"]) )
	{
	    $done = false;
	    $rows = db_query_rows( "Select Name, InfoDescr from $t where InfoDescr > '' " );
	    foreach( $rows as $r )
		{
		    if( !$done )
			$arr[] = array( $t );
		    $done = true;

		    $arr[] = array( $r[Name], $r[InfoDescr] );
		}
	    $arr[] = array( "" );
	}
	
	if( $t == "customhovers" )
	{
	    $arr[] = array( $t );
	    $rows = db_query_rows( "Select Name, Value from $t where Value > '' " );
	    foreach( $rows as $r )
		{
		    if( strpos( $r[Value], "Search for" ) !== false ) continue;
		    if( strpos( $r[Value], "FIX ME" ) !== false ) continue;
		    if( strpos( $r[Value], "This search reflects" ) !== false ) continue;
		    if( strpos( $r[Value], "Look for" ) !== false ) continue;
		    //		    echo( "<tr><td>" . $r[Name] . "</td><td>" . $r[Value] . "</td></tr>" );
		    $arr[] = array( $r[Name], $r[Value] );
		}
	    $arr[] = array( "" );
	}
}
outputCSV( $arr );
exit;

    }
else
    {
	echo( "<a href='exportdescriptions.php?csv=1'>Export</a>" );

echo( "<table>" );
foreach( $tables as $t )
{
    $t = $t[0];
	$r = db_query_first( "select * from $t" );
	if( isset( $r["InfoDescr"] ) )
	{
	    $done = false;
	    $rows = db_query_rows( "Select Name, InfoDescr from $t where InfoDescr > '' " );
	    foreach( $rows as $r )
		{
		    if( !$done )
			echo( "<tr><td>$t</td></tr>" );
		    $done = true;
		    echo( "<tr><td>" . $r[Name] . "</td><td>" . $r[InfoDescr] . "</td></tr>" );
		}
	    echo( "<tr><td>&nbsp;</td></tr>" );
	}
	
	if( $t == "customhovers" )
	{
	    echo( "<tr><td>$t</td>" );
	    $rows = db_query_rows( "Select Name, Value from $t where Value > '' " );
	    foreach( $rows as $r )
		{
		    if( strpos( $r[Value], "Search for" ) !== false ) continue;
		    if( strpos( $r[Value], "FIX ME" ) !== false ) continue;
		    if( strpos( $r[Value], "This search reflects" ) !== false ) continue;
		    if( strpos( $r[Value], "Look for" ) !== false ) continue;
		    echo( "<tr><td>" . $r[Name] . "</td><td>" . $r[Value] . "</td></tr>" );
		}
	    echo( "<tr><td>&nbsp;</td></tr>" );
	}
	
}
echo( "</table>" );
    }
?>
