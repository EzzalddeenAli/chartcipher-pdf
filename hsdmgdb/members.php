<? 
include "connect.php";

$tablename = "members";

$uppercasesingle = "Member";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

if( $fixme )
    {
	$sql = "delete from artist_to_member where artistid not in ( select id from artists )";
	db_query( $sql );
	$sql = "delete from group_to_member where groupid not in ( select id from groups )";
	db_query( $sql );
	$sql = "delete from producer_to_member where producerid not in ( select id from producers )";
	db_query( $sql );
	$sql = "delete from members where id not in ( select memberid from artist_to_member ) and id not in ( select memberid from producer_to_member ) and id not in ( select memberid from group_to_member )";
	db_query( $sql );

    }

$specialname = "StageName";

$extracolumnsizes = array( "artists"=>"100", "datecreated"=>"10" );
$extracolumns = array( "FirstName"=>"First Name", "LastName"=>"Last Name", "MemberGender"=>"Gender", "TwitterHandle"=>"TwitterHandle", "TwitterURL"=>"TwitterURL", "InstagramHandle"=>"InstagramHandle", "InstagramURL"=>"InstagramURL" );

$selectcolumns = array( "MemberGender" );
$selectoptions = array( "MemberGender"=> getEnumValues( "MemberGender", "members" ) );

// fix me
    function anySongsWith( $tablename, $songid )
    {
	$res1 = db_query_array( "select concat( 'Artist: ', Name ) as Name from artists where artists.id in ( select artistid from artist_to_member where memberid = $songid )", "Name", "Name" );
      $res2 = db_query_array( "select concat( 'Group: ', Name ) as Name from groups where groups.id in ( select groupid from group_to_member where memberid = $songid )", "Name", "Name"  );
      $res3 = db_query_array( "select concat( 'Producer: ', Name ) as Name from producers where producers.id in ( select producerid from producer_to_member where memberid = $songid )", "Name", "Name"  );
      foreach( $res2 as $r )
	  $res1[] = $r;
      foreach( $res3 as $r )
	  $res1[] = $r;
      return $res1;
    }

include "generic.php";
?>
