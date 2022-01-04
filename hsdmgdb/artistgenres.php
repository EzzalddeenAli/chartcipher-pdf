<? 
include "connect.php";


if( $update )
  {
      db_query( "delete from artist_to_genre" );
      foreach( $genresupdate as $artistid=>$genres )
	  {
	      foreach( $genres as $g=>$throwaway )
		  {
		      db_query( " insert into artist_to_genre ( artistid, genreid ) values ( $artistid, $g )" );
		  }
	  }
  }

$res = db_query_rows( "select * from artists where id in ( select artistid from song_to_artist where type in ( 'featured', 'primary' ) ) order by Name" );

include "nav.php";
?>
<h3>Artist Genres</h3>
<form method='post'>
<input type='submit' name='update' value='Update'><br><br>
    <table class="cmstable"><tr><th>Artist</th>
<th>Genre</th></tr>

<? foreach( $res as $r ) { 
    $overbgc = "";
   if( !db_query_first_cell( "select count(*) from artist_to_genre where artistid = '$r[id]'" ) )
       $overbgc = "bgcolor='#f24b4b'";
    outputOtherTableCheckboxes( $r[Name], "genresupdate[{$r[id]}]", $r[id], "genres", false, "", "artist" ); 
}
?>
</table>

<input type='submit' name='update' value='Update'><br><br>
</form>