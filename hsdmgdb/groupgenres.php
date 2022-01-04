<? 
include "connect.php";

// if (1 == 0 && ($handle = fopen("/tmp/artists.csv", "r")) !== FALSE) {
//     $allgenresfordropdown = db_query_array( "select id, Name from genres order by OrderBy, Name", "id", "Name" );
//     $othergenres = array_flip( $allgenresfordropdown );
//     $started = false;
//     $count = 0;
//     db_query( "delete from artist_to_genre" );
//     db_query( "delete from group_to_genre" );
//     while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
// 	$key = $othergenres[trim(ucwords( $data[1] ))];
// 	$artistid = db_query_first_cell(" select id from artists where Name = '" . escMe( trim( $data[0] ) ) . "'" );
// 	$groupid = db_query_first_cell(" select id from groups where Name = '" . escMe( trim( $data[0] ) ) . "'" );
// 	if( $key && $artistid )
// 	    {
// 		      db_query( " insert into artist_to_genre ( artistid, genreid ) values ( $artistid, $key )" );
// 	    }
// 	else if( $key && $groupid )
// 	    {
// 		      db_query( " insert into group_to_genre ( groupid, genreid ) values ( $groupid, $key )" );
// 	    }
// 	else
// 	    {
// 		echo( "hmm $data[0] $artistid---$groupid, $data[1] $key<br>" );
// 	    }
//     }
//     exit;
// }

if( $update )
  {
      db_query( "delete from group_to_genre" );
      foreach( $genresupdate as $groupid=>$genres )
	  {
	      foreach( $genres as $g=>$throwaway )
		  {
		      db_query( " insert into group_to_genre ( groupid, genreid ) values ( $groupid, $g )" );
		  }
	  }
  }

$res = db_query_rows( "select * from groups where id in ( select groupid from song_to_group where type in ( 'featured', 'primary', 'sample' ) ) order by Name" );

include "nav.php";
?>
<h3>Group Genres</h3>
<form method='post'>
<input type='submit' name='update' value='Update'><br><br>
    <table class="cmstable"><tr><th>Group</th>
<th>Genre</th></tr>

<? foreach( $res as $r ) { 
    outputOtherTableCheckboxes( $r[Name], "genresupdate[{$r[id]}]", $r[id], "genres", false, "", "group" ); 
}
?>
</table>

<input type='submit' name='update' value='Update'><br><br>
</form>
