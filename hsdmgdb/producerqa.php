<? 
include "connect.php";

 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }
    $years = array();
    for( $i = 2013; $i <= date( "Y" ); $i++ ) 
        $years["$i"] = "$i";

    $quarters = array();
    for( $i = 1; $i <= 4; $i++ ) 
        $quarters["$i"] = "Q$i";


if( $go )
  {
  $songids = getSongIdsWithinQuarter( false, $dates[fromq], $dates[fromy], $dates[toq], $dates[toy] );
    
  $overallarr = array();
  $toadd = array();
  $toadd[] = "Song Title";
  $toadd[] = "Performing Artist/Group";
  $toadd[] = "Week Entered Top 10";
  $toadd[] = "Production Group 1";
  $toadd[] = "Production Group 2";
  $toadd[] = "Production Group 3";
  $toadd[] = "Production Group 4";
  $toadd[] = "Production Group 5";
  $toadd[] = "Production Group 6";
  $toadd[] = "Production Group 7";
  $toadd[] = "Production Group 8";
  $toadd[] = "Production Group 9";
  $toadd[] = "Production Group 10";
  $overallarr[] = $toadd;

  foreach( $songids as $songid )
      {
	  $toadd = array();
	  $toadd[] = getSongnameFromSongid( $songid );
	  $artists = db_query_array( "select Name from song_to_artist, artists where artists.id = artistid and type in ( 'featured', 'primary' ) and songid = '$songid'", "Name", "Name" );
	  $groups = db_query_array( "select Name from song_to_group, groups where groups.id = groupid and type in ( 'featured', 'primary' ) and songid = '$songid'", "Name", "Name" );
	  $artists = array_merge( $artists, $groups );
	  $toadd[] = implode( ", ", $artists );

	  $toadd[] = db_query_first_cell("select Name from weekdates, songs where weekdates.id = WeekEnteredTheTop10 and songs.id = $songid" );

	  $producers = db_query_array( "select Name from song_to_producer, producers where producers.id = producerid and songid = '$songid'", "Name", "Name" );
	  foreach( $producers as $p )
	      $toadd[] = $p;

	  $overallarr[] = $toadd;
      }


	header("Content-type: text/csv");
	header("Cache-Control: no-store, no-cache");
	header('Content-Disposition: attachment; filename="chart-'.$drow[Name].'.csv"');
    
	$handle = fopen("php://output", "w");
	foreach( $overallarr as $a )
	  {
	    fputcsv( $handle, $a );
	  }
    
	fclose( $handle );
	exit;
  }

include "nav.php";
?>
<form method='post'>
Date Range:<br/>
									<select name="dates[fromq]">
										<option value="">Any</option>
<? outputSelectValues( $quarters, $dates["fromq"] ); ?>
									</select>
									<select  name="dates[fromy]">
										<option value="">Any</option>
<? outputSelectValues( $years, $dates["fromy"] ); ?>
									</select>
<br> - to - <bR>
								<div class="form-row-left-inner">
									<select  name="dates[toq]">
										<option value="">Any</option>
<? outputSelectValues( $quarters, $dates["toq"] ); ?>
									</select>

									<select  name="dates[toy]">
										<option value="">Any</option>
<? outputSelectValues( $years, $dates["toy"] ); ?>
									</select>

<input type='submit' name='go' value='Go'>
</form>

<? include "footer.php"; ?>
