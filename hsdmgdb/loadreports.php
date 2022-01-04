<? 
ini_set('auto_detect_line_endings',TRUE);
include "connect.php"; ?>
<? 
$handle = fopen("/tmp/tofix.csv", "r");
while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
    $d = trim( $data[0] );
    $songnameid = getIdByName( "songnames", $d );
//    echo( "songname id is: $songnameid ($d)<br>" );
    if( !$songnameid )
    {
        echo( "no match for $data[0]<Br>" );
        continue;
    }
    $songid = getIdByName( "songs", $songnameid, "songnameid" );

    if( $songid )
    {
        $sql = ( "update songs set HSDReport = '" . escMe( $data[1] ) . "' where id = $songid" );
        db_query( $sql );
//        echo( $data[0] . ": " . $sql . "<br>" );
    }
    else
    {
        echo( "no match for $data[0]<br>" );
    }
}

?>