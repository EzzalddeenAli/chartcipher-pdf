<? 
include "connect.php";

if (1 == 1 && ($handle = fopen("/tmp/pop.csv", "r")) !== FALSE) {
    $pop = 229;
    $count = 0;
    while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
	$num = db_query_first_cell( "select count(*) from songs where SongNameHard =  '" . escMe( $data[0] ) . "' " );
	echo( "select count(*) from songs where SongNameHard =  '" . escMe( $data[0] ) . "'<br> " );
	if( $num == 1 )
	    $songid = db_query_first_cell( "select id from songs where SongNameHard = '" . escMe( $data[0] ) . "' " );
	else
	    {
	    $songid = db_query_first_cell( "select id from songs where SongNameHard = '" . escMe( $data[0] ) . "' and ArtistBand = '" . escMe( $data[1] ) . "' " );
	    }

	if( $songid )
	    {
		echo( " insert into song_to_subgenre ( songid, subgenreid ) values ( $songid, $pop )<br>" );
		      db_query( " insert into song_to_subgenre ( songid, subgenreid, type ) values ( $songid, $pop, 'Main' )" );
	    }
	else
	    {
		echo( "hmm $data[0] $artistid---$groupid, $data[1] $key<br>" );
	    }
    }
    exit;
}
?>
