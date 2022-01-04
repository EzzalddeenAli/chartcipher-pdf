<?php
include "connect.php";
// $tablename
// $songid
// $type (optional)
// $connectorid
if( $songid && $tablename && $connectorid )
  {
    $value = trim( $value[0] );
    $shorttablename = substr( $tablename, 0, -1 );
    
    //echo( "delete from song_to_{$shorttablename} where id = $connectorid" );
    db_query( "delete from song_to_{$shorttablename} where id = $connectorid" );
  }
?>
