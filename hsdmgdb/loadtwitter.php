<? 
ini_set('auto_detect_line_endings',TRUE);
include "connect.php"; ?>
<? 
// $handle = fopen("/tmp/imembers.csv", "r");
// while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
//     $sql = "update members set InstagramHandle = '" . escMe( $data[3] ) . "', InstagramURL = '" . escMe( $data[4] ) . "' where StageName = '" . escMe( trim( $data[0] ) ) . "'";
// 	echo( $data[0] . " : " . $sql  . "<br>" );
// 		db_query( $sql );
// }

// exit;
    $handle = fopen( "/tmp/missing.csv", "w" );
fputcsv( $handle, array( "Labels" ) );
$res = db_query_rows( "select Name from labels where InstagramURL = '' or InstagramURL is null" );
foreach( $res as $r )
{
fputcsv( $handle, array( $r[Name] ) );
}
fputcsv( $handle, array( "" ) );
fputcsv( $handle, array( "" ) );
fputcsv( $handle, array( "Groups" ) );
$res = db_query_rows( "select Name from groups where InstagramURL = '' or InstagramURL is null" );
foreach( $res as $r )
{
fputcsv( $handle, array( $r[Name] ) );
}

fputcsv( $handle, array( "" ) );
fputcsv( $handle, array( "" ) );
fputcsv( $handle, array( "Members" ) );
$res = db_query_rows( "select StageName from members where InstagramURL = '' or InstagramURL is null" );
foreach( $res as $r )
{
fputcsv( $handle, array( $r[StageName] ) );
}


?>
