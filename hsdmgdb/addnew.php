<?php include "connect.php";

if( $type && $newval )
  {
    $newvalid = db_query_insert_id( "insert into $type ( Name ) values ( '" . $newval . "' )" );
  }
echo( "<input type='checkbox' name='{$type}[{$newvalid}]' checked value='1'> ". stripslashes( $newval )."<br>"  );
?>