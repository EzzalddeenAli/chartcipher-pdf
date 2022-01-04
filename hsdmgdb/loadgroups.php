<? 
ini_set('auto_detect_line_endings',TRUE);
include "connect.php"; ?>
<? 
    $groups  = db_query_rows( "select * from groups" );
    foreach( $groups as $g )
{
    db_query( "delete from group_to_member where groupid = $g[id]" );
    $exp = explode( ";", $g["artists"] );
    //    print_r( $exp );exit;
    echo( "starting group $g[Name]<br>" );
    foreach( $exp as $v )
	{
	    $v = trim( $v );
	    if( $v )
		{
		    $exp = explode( " ", $v );
		    if( count($exp ) == 2 )
			{
			    $newid = db_query_first_cell( "select id from members where StageName like '" . escMe( $exp[0] )."%".escMe( $exp[1] ). "'" );
			    if( $newid ) echo( "got a match for $v, it's $newid<br>" );
			}
		    if( !$newid )
			{
			    echo( "nope, need to create a new one for $v<br>" );
			    $newid = getOrCreate( "members", $v, "StageName" );
			}

		    db_query( "insert into group_to_member ( groupid, memberid ) values ( '$g[id]', '$newid' )" );
		}
	    
	}
}

?>
