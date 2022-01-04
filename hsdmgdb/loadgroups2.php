<? 
ini_set('auto_detect_line_endings',TRUE);
include "connect.php"; ?>
<? 
$handle = fopen("/tmp/hsdGroups.csv", "r");
while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
    if( $data[0] == "Group" ) continue;

    $name = $data[1];
    if($data[2])	$name .= " " . $data[2];
    if($data[3])	$name .= " " . $data[3];

    $pid = db_query_first_cell( "select id from members where StageName = '" . escMe( $name ) . "'" );
    if( !$pid )
    {
		echo( "no match for $data[0] - $name<br>" );
    }
    else
	{
	$sql = "update members set MemberGender = '" . escMe( $data[4] ) . "' where id = $pid";
	echo( $data[0] . " : " . $sql  . "<br>" );
	db_query( $sql );
	}
}

?>
