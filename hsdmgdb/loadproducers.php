<? 
ini_set('auto_detect_line_endings',TRUE);
include "connect.php"; ?>
<? 
$handle = fopen("/tmp/producers.csv", "r");
while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
    $pid = getOrCreate( "producers", $data[0] );
    if( $pid )
    {
        $sql = ( "update producers set member1 = '" . escMe( trim( $data[1] ) ) . "' where id = $pid" );
        db_query( $sql );
        echo( $data[0] . ": " . $sql . "<br>" );

        $sql = ( "update producers set member2 = '" . escMe( trim( $data[2] ) ) . "' where id = $pid" );
        db_query( $sql );
        echo( $data[0] . ": " . $sql . "<br>" );

        $sql = ( "update producers set member3 = '" . escMe( trim( $data[3] ) ) . "' where id = $pid" );
        db_query( $sql );
        echo( $data[0] . ": " . $sql . "<br>" );

        $sql = ( "update producers set member4 = '" . escMe( trim( $data[4] ) ) . "' where id = $pid" );
        db_query( $sql );
        echo( $data[0] . ": " . $sql . "<br>" );

        $sql = ( "update producers set member5 = '" . escMe( trim( $data[5] ) ) . "' where id = $pid" );
        db_query( $sql );
        echo( $data[0] . ": " . $sql . "<br>" );
        $sql = ( "update producers set member6 = '" . escMe( trim( $data[6] ) ) . "' where id = $pid" );
        db_query( $sql );
        echo( $data[0] . ": " . $sql . "<br>" );
	db_query( "delete from producer_to_member where producerid = $pid" );
	for( $i = 1; $i <=6; $i++ )
	{
	    if( trim( $data[$i]  ))
		{
		    $v = trim( $data[$i] );
		    $newid = getOrCreate( "members", $v, "StageName" );
		    db_query( "insert into producer_to_member ( producerid, memberid ) values ( '$pid', '$newid' )" );
		    
		}
	}
    }
    else
    {
        echo( "no match for $data[0]<br>" );
    }
}

?>
