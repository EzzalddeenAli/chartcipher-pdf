<? 
include "connect.php";

$dt = strtotime( "2009-12-26" ); // a saturday
while( $dt < strtotime( "2023-01-01" ) )
  {
    if( !db_query_first_cell( "select id from weekdates where Name = '" . date( "m/d/y", $dt ) . "'" ) )
    {   
	echo( "insert into weekdates ( Name, OrderBy ) values ( '" . date( "m/d/y", $dt ) . "', $dt )<br>" );
	     db_query( "insert into weekdates ( Name, OrderBy ) values ( '" . date( "m/d/y", $dt ) . "', $dt )" );
      }
    $dt = strtotime( date( "Y-m-d", $dt ) . " + 7 days" );
  }

$w = db_query_rows( "select * from weekdates" );
foreach( $w as $warr )
{
	$d = date( "Y-m-d", $warr[OrderBy] );
	db_query( "update weekdates set realdate = '$d' where id = $warr[id]" );
}

?>
