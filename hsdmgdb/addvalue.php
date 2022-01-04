<?php
include "connect.php";
// $tablename
// $songid
// $type (optional)
// $value
if( $songid && $tablename && $value )
  {
    $shorttablename = substr( $tablename, 0, -1 );
    $inputval = db_query_first_cell( "select id from $tablename where Name = '" . escMe( $value ) ."'" );

    if( $inputval )
    {
        db_query( "delete from song_to_{$shorttablename} where songid = '$songid' and  {$shorttablename}id = '$inputval' and type = '$type'" );
        $ins = db_query_insert_id( "insert into song_to_{$shorttablename} ( songid, {$shorttablename}id ) values ( '$songid', '$inputval' )" );
        if( $type )
        {
            db_query( "update song_to_{$shorttablename} set type = '$type' where id = '$ins'" );
        }
        if( $type == "creditedsw" )
        {
            $songwriters = db_query_first_cell( "select count(*) from song_to_artist where type = 'creditedsw' and songid = '$songid'" );
            db_query( "update songs set SongwriterCount = '$songwriters' where id = $songid" );
        }
        
    }
    else
    {
        echo( "No match for '$value'." );
    }
  }
?>
