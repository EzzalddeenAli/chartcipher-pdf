<?
    // [song id] => 0
$fullname = $data[0];
$fullnamearr = explode( ".", $fullname );
$artist = $fullnamearr[0];
$songname = $fullnamearr[1];

$songid = db_query_first_cell( "select songs.id from songs, songnames where songnameid = songnames.id and Name = '" . escMe( $songname ).  "' and ArtistBand = '" . escMe( $artist ).  "'" );

if( !$songid )
    {
	$songnameid = getOrCreate( "songnames", $songname );
	$songid = db_query_insert_id( "insert into songs( SongNameHard, ArtistBand, songnameid ) values ( '" . escMe($songname) . "','" . escMe($artist) . "', $songnameid ) " );
    }

    // [Key] => 26
$toupdate["KeyMajor"] = getData( "Key" );
$key = getData( "Key" );
$key = str_replace( "'", "", $key );
$key = str_replace( "Major", "", $key );
$key = trim( str_replace( "Minor", "", $key ) );
$key = array_shift( explode( " ", $key ) );
$keyid = getIdByName( "songkeys", $key ); 
db_query( "delete from song_to_songkey where songid = $songid" );
if( $keyid )
    {

	db_query( "insert into song_to_songkey ( songid, songkeyid, type, NameHard ) values ( '$songid', '$keyid', ". getData( "Key (Major, Minor, Major Mode, Minor Mode)" ) . ", " . getData( "Key" ) . " )" );
    }
else{
echo( "no matching key for $key<br>" );
}


?>
