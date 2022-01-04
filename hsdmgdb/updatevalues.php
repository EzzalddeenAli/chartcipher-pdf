<?php
include "connect.php";

// $songid
// $tablename
// $fieldname
// $type (optional)

$and = "";
if( $type )
  {
    $and = " and type = '$type'";
  }
$shorttablename = substr( $tablename, 0, -1 );

$res = db_query_rows( "select s.*, se.id as connectorid from song_to_{$shorttablename} se, $tablename s where se.{$shorttablename}id = s.id and songid = $songid $and order by Name" );

if( count( $res ) )
  {
    foreach( $res as $r )
      {
	  $ext = "";
	  if( $tablename == "producers" )
	      {
		  $ext = implode( ", ", db_query_array( "select concat( memberid, ':', StageName ) as memberid from producer_to_member, members where members.id = memberid and  producerid  =$r[id]", "memberid", "memberid" ) );
	      }
	  if( $tablename == "groups" )
	      {
		  $ext = implode( ", ", db_query_array( "select concat( memberid, ':', StageName ) as memberid from group_to_member, members where members.id = memberid and  groupid  =$r[id]", "memberid", "memberid" ) );
	      }
	  if( $tablename == "artists" )
	      {
		  $ext = implode( ", ", db_query_array( "select concat( memberid, ':', StageName ) as memberid from artist_to_member, members where members.id = memberid and  artistid  =$r[id]", "memberid", "memberid" ) );
	      }
		  if( $ext )
		      $ext = "($ext)";

        echo( "$r[Name] {$ext}<a href='#' onClick='javascript: if( confirm( \"Are you sure you want to remove this?\" ) ) { delValue( \"$tablename\", \"$fieldname\", \"$r[connectorid]\", \"$type\" ); } return false'>del</a><br>" );
      }
  }
else echo( "None added yet." );
?>

