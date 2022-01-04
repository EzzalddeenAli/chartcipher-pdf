<? 
ini_set('auto_detect_line_endings',TRUE);
include "connect.php"; ?>
<? 
$handle = fopen("/tmp/hsdProducers.csv", "r");
while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
    if( $data[0] == "Artist" ) continue;
    $pid = db_query_first_cell( "select id from members where StageName = '" . escMe( $data[0] ) . "'" );
    if( !$pid )
    {

	$groupid  =db_query_first_cell( "select id from groups where Name = '" . escMe( $data[0] ) . "'" );
	$producerid  =db_query_first_cell( "select id from producers where Name = '" . escMe( $data[0] ) . "'" );
	if( $groupid )
	    {
		echo( $data[0] . " : " . "we found a group though?" . $data[1] . "<br>" );
		if( $data[1] == "Male" || $data[1] == "All Male Duet/Group" )
		    {
			$sql = "update members set MemberGender = 'Male' where id in ( select memberid from group_to_member where groupid = '$groupid' )";
			echo( $sql . "<br>" );
			db_query( $sql );
		    }
		else if( $data[1] == "Female" || $data[1] == "All Female Duet/Group" )
		    {
			$sql = "update members set MemberGender = 'Female' where id in ( select memberid from producer_to_member where producerid = '$producerid' )";
			echo( $sql . "<br>" );
			db_query( $sql );
		    }
		else 
		    {
			echo( "no match for gender $data[1]<br>" );
		    }
	    }
	else if( $producerid )
	    {
		echo( $data[0] . " : " . "we found a production group though?" . $data[1] . "<br>" );
		if( $data[1] == "Male" || $data[1] == "All Male Duet/Group" )
		    {
			$sql = "update members set MemberGender = 'Male' where id in ( select memberid from producer_to_member where producerid = '$producerid' )";
			echo( $sql . "<br>" );
			db_query( $sql );
		    }
		else if( $data[1] == "Female" || $data[1] == "All Female Duet/Group" )
		    {
			$sql = "update members set MemberGender = 'Female' where id in ( select memberid from producer_to_member where producerid = '$producerid' )";
			echo( $sql . "<br>" );
			db_query( $sql );
		    }
		else 
		    {
			echo( "no match for gender $data[1]<br>" );
		    }

	    }
	else
	    {
		echo( "no match for $data[0]<br>" );

	    }
	
    }
    else
	{
	$sql = "update members set TwitterHandle = '" . escMe( $data[2] ) . "', MemberGender = '" . escMe( $data[1] ) . "', TwitterURL = '" . escMe( $data[3] ) . "' where id = $pid";
	echo( $data[0] . " : " . $sql  . "<br>" );
	db_query( $sql );
	}
}

?>
