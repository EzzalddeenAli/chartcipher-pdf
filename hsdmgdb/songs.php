<? 
include "connect.php";
$singleautofillfields = array( "songnameid"=>"songnames", "primarygroupid"=>"groups", "creditedsongwriter1"=>"artists", "creditedsongwriter2"=>"artists", "creditedsongwriter3"=>"artists", "creditedsongwriter4"=>"artists", "creditedsongwriter5"=>"artists", "creditedproducer1"=>"artists", "creditedproducer2"=>"artists", "creditedproducer3"=>"artists", "writingproduction"=>"producers", "imprint"=>"imprints", "labelid"=>"labels" );

$tablename = "songs";

$uppercasesingle = "Song";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$bgc = "aa";

if( $addnew && $songnameid )
  {
    $songnameid = db_query_first_cell( "select id from songnames where Name = '" . escMe( $songnameid ) . "'" );
    $songid = db_query_insert_id( "insert into $tablename ( songnameid, ArtistBand ) values ( '$songnameid', '" . escMe( $artistband ) . "' )" );
    header( "Location: editsong.php?songid=$songid" );
    exit;
  }
if( $del )
  {
$tables = array();
	$tables[] = "song_to_artist";
	$tables[] = "song_to_backvocal";
	$tables[] = "song_to_backvocaltype";
	$tables[] = "song_to_bridgecharacteristic";
	$tables[] = "song_to_chorusstructure";
	$tables[] = "song_to_chorustype";
	$tables[] = "song_to_containssampled";
	$tables[] = "song_to_endingtype";
	$tables[] = "song_to_group";
	$tables[] = "song_to_imprint";
	$tables[] = "song_to_instrument";
	$tables[] = "song_to_introtype";
	$tables[] = "song_to_label";
	$tables[] = "song_to_lyricaltheme";
	$tables[] = "song_to_outrotype";
	$tables[] = "song_to_placement";
	$tables[] = "song_to_postchorustype";
	$tables[] = "song_to_primaryinstrumentation";
	$tables[] = "song_to_producer";
	$tables[] = "song_to_retroinfluence";
	$tables[] = "song_to_rocksubgenre";
	$tables[] = "song_to_samplesong";
	$tables[] = "song_to_sampletype";
	$tables[] = "song_to_songkey";
	$tables[] = "song_to_songsection";
	$tables[] = "song_to_songsectioncount";
	$tables[] = "song_to_songwriter";
	$tables[] = "song_to_subgenre";
	$tables[] = "song_to_technique";
	$tables[] = "song_to_vocal";
	$tables[] = "song_to_vocalexample";
	$tables[] = "song_to_vocaltype";
	$tables[] = "song_to_weekdate";
	$tables[] = "song_to_worldsubgenre";
	$tables[] = "song_to_wowfactor";

//    $tables = array( "song_to_chorusstructure", "song_to_artist", "song_to_lyricaltheme", "song_to_placement", "song_to_primaryinstrumentation", "song_to_producer", "song_to_retroinfluence", "song_to_songsection", "song_to_songsectioncount", "song_to_songwriter", "song_to_subgenre" );
    foreach( $tables as $t )
      {
	db_query( "delete from $t where songid = $del" );
      }

    db_query( "delete from songs where id = $del" );
    $err = "<font color='red'>Song deleted.</font>";
  }

if( $col )
  {
    if( $col == "label" )
      {
	$ext  = " and songs.LabelID = '$val'" ;
	
      }
      else     if( $col == "songnames" )
      {
	$ext  = " and songs.songnameid = '$val'" ;
	
      }
    else if( $col == "imprint" )
      {
	$ext  = " and songs.Imprint = '$val'" ;
	
      }
    else
      {
	$shorttablename = substr($col, 0, -1);
	//	echo( "select songid from song_to_{$shorttablename} where {$shorttablename}id = $val" ); 
	$vals = db_query_array( "select songid from song_to_{$shorttablename} where {$shorttablename}id = $val", "songid", "songid" ); 
	$vals[] = -1;
	$ext  = " and songs.id in ( ". implode( ", ", $vals ) . " ) ";
	$extra = "<h4>Displaying $col: " . getNameById( $col, $val  ) . "</h4><br>"; 
      }
  }

if( $onlyquarter && $starty )
{
	if( !$startq )
	{
		$sids = getSongIdsWithinQuarter( false, $startq, $starty );
	}
	else
	    {
		$sids = getSongIdsWithinQuarter( false, 1, $starty, 4, $starty );
	    }
	
	$ext .= " and songs.id in ( " . implode( ", ", $sids ) . " )";
}
if( $genreid )
{
	$ext .= " and GenreID = $genreid";
}
if( $activeonly )
{
	$ext .= " and IsActive = 1";
}
if( $hasimprint )
{
	$ext .= " and songs.id in ( select songid from song_to_imprint )";
}
if( $clientid )
{
	$ext .= " and ClientID = $clientid";
}
if( $weekdateid )
{
	$sids = db_query_array( "select songid from song_to_weekdate where weekdateid = '$weekdateid'", "songid", "songid" );
	$ext .= " and songs.id in ( " . implode( ", ", $sids ) . " )";
}

$res = db_query_rows( "select songnames.Name as SongName, songs.* from $tablename, songnames where   songnameid = songnames.id $ext order by SongName limit 500" );


include "nav.php";
if( isRachel() ) echo ( "select songnames.Name as SongName, songs.* from $tablename, songnames where   songnameid = songnames.id $ext order by SongName limit 500" );
?>

<h3><?=$uppercase?></h3>
<form method='post' action='<?=$tablename?>.php'>
<?=$err?>

<h4>  Add New </h4>
<table class="add">
  <?=outputOtherTableAutofill( "Song Name", "songnameid", "" )?>
  <?=outputInputRow( "Artist/Band", "artistband", "" )?>
</table>
<input type='submit' name='addnew' value='Add'>
<br><br>
<b>Search: </b><br>
<?   echo( "<select name='startq'>" );
  echo( "<option></option>" );
  for( $i = 1; $i <= 4; $i++ )
    {
      $sel = ($startq==$i)?"SELECTED":"";
      echo( "<option $sel value='$i'>$i</option>" );
    }
  echo( "</select>" );

  echo( "<select name='starty'>" );
  echo( "<option></option>" );
  for( $i = 2010; $i <= date( "Y" ); $i++ )
    {
      $sel = ($starty==$i)?"SELECTED":"";
      echo( "<option $sel value='$i'>$i</option>" );
    }
  echo( "</select>" );

?>
<table class="filter">  <?=outputOtherTableSelect( "Primary Genre", "genreid", $genreid, "genres" )?></table>
<table class="filter">  <?=outputOtherTableSelect( "Client", "clientid", $clientid, "clients" )?></table>
<table class="filter">  <?=outputOtherTableSelect( "Week Dates", "weekdateid", $weekdateid, "weekdates" )?></table>
<br>
Also Display:<br>
<select class="multiple" name='extrafields[]' multiple style="width:200px">
<? 
if( !$extrafields ) $extrafields = array();
$poss = array();
$poss["Tempo"] = "Tempo";
$poss["FirstChorusRange"] = "First Chorus Range";
$poss["Imprint"] = "Imprint";
$poss["TotalCount"] = "Team Size";
foreach( $poss as $key=>$display )
{
	$sel = in_array( $key, $extrafields )?"SELECTED":"";
	echo( "<option value='$key' $sel>$display</option>" );
}
?>
</select>
<br>
<br>    <input type='checkbox' name='activeonly' value='1' <?=$activeonly?"CHECKED":""?>> Active Only?<br>
<br>    <input type='checkbox' name='hasimprint' value='1' <?=$hasimprint?"CHECKED":""?>> Only If Has Imprint?<br>
<input type='submit' name='onlyquarter' value='Filter'>
<br><br><?=$extra?>
<?php
// echo( "<br>" );
// $checking = db_query_rows( "select Name, weekdateid, type, count(*) as cnt, group_concat( songid ) as songids from song_to_weekdate, weekdates where weekdateid = weekdates.id group by Name, weekdateid, type having cnt > 1" );
// foreach( $checking as $crow )
// {
// 	echo( "<font color='red'>Error: multiple songs for $crow[Name] - $crow[type] -" );
// 	$exp = explode( ",", $crow[songids] );

// 	foreach( $exp as $e )
// 	{
// 		echo("- <a href='editsong.php?songid=$e'>".getSongnameFromSongid( $e ) . "</a> " );
// 	}
// 	echo("</font><br>" );
// }
// if( count( $checking ) )
//     echo( "<Br>");

    foreach( $res as $r ) { 
if( strtolower( $r[SongName][0] ) != $lastfirst )
{
	if( $lastfirst ) echo (" || " );
	$lastfirst = $r[SongName][0];
	echo( "<a href='#letter{$lastfirst}'><b>{$lastfirst}</b></a> " );
	$lastfirst = strtolower( $r[SongName][0] );
}
}

?>
<br>   <i> <?=count( $res )?> Total Results matching your search.</i><br>
  <table class="content" width='800' border=1 cellpadding=2 cellspacing=0><tr><th>Is Active</th><th>ID</th><th>Song Name</th><th>Artist/Band</th><th>Chart Dates for Hot 100</th><th>Songwriters</th><th>Genre</th><th>Lyrics Tester</th>
<? foreach( $extrafields as $e ) {  ?>
<th><?=$poss[$e]?></th>
<? } ?>
<th>Del?</th></tr>

  <? if( !count( $res ) ) { ?><tr><td colspan='4'>No <?=$lowercase?> found.</td></tr>
			    <? } ?>

			    <? 
$lastfirst = "";
foreach( $res as $r ) { 
if( strtolower( $r[SongName][0] ) != $lastfirst )
{
	$lastfirst = $r[SongName][0];
	echo( "<tr><td colspan='10'><b>Starting with </b><a name='letter{$lastfirst}'><b>{$lastfirst}</b></a></td></tr>" );
	$lastfirst = strtolower( $r[SongName][0] );
}
//   $artists = getArtists( $r[id] );
//   if( !$artists )
// {
//     $artists = getGroups( $r[id] );
// }
$artists = $r[ArtistBand];
  $hmm = db_query_first( "select time_to_sec( SongLength ) as total, sum( time_to_sec( length ) ) as parts from songs, song_to_songsection where id = $r[id] and songid = songs.id" );
  $hmmstr = "";
  if( $hmm["total"] != $hmm["parts"] )
    {
	//      $hmmstr = "<br><font color='red'>Warning: The total time does not add up to the time of the sections ($hmm[total] seconds vs $hmm[parts] seconds)</font>";
    }
  $datesarr = db_query_array( "select Name, type from song_to_weekdate, weekdates where weekdateid = weekdates.id and songid = $r[id] and chartid = 37 order by OrderBy", "Name", "type" );
  $t = array();
  foreach( $datesarr as $d=>$pos )
  {
  $t[] = $d .  " (#" . str_replace( "position", "",$pos ) . ")";
  }
  $dates = implode( ", ", $t );
$songwriters = db_query_first_cell( "select count(*) from song_to_artist where type = 'creditedsw' and songid = '$songid'" );

?>
<tr>
<td >&nbsp;&nbsp;<?=$r[IsActive]?"Yes":"No"?></td>
<td >&nbsp;&nbsp;<?=$r[id]?>&nbsp;&nbsp;</td>
<td><a href='editsong.php?songid=<?=$r[id]?>'><?=$r[SongName]?></a><?=$hmmstr?></td><td><?=$artists?></td>
<td><?=$dates?></td>
<td><?=$songwriters?></td>
<td><?=getTableValue( $r[GenreID], "genres" )?></td>
<!--<td><a href='getlyrics.php?id=<?=$r[id]?>' target=_blank>Testing</a></td>-->
<? foreach( $extrafields as $e ) { 
if( $e == "Imprint" ) {
    $imp = db_query_array( "select Name from imprints, song_to_imprint where imprintid = imprints.id and songid = $r[id]", "Name", "Name" );
    $imp = implode( ", ", $imp );
    echo( "<th>$imp</th>" );
}
else{
?>
<th><?=$r[$e]?></th>
<? }
} ?>
<td>
<A onClick='return confirm( "Are you sure you want to delete this?" )' href='songs.php?del=<?=$r[id]?>'>Del?</a>
</td></tr>
  <? }?>
</table>
<br>
<br><br>

<br><br>
<script>
    var availableTagsSongnames = [
                         <? $arr = db_query_rows( "select * from songnames" );
                         foreach( $arr as $row ) { echo( "\"$row[Name]\", "); } ?>
			 ];

	if( typeof availableTagsSongnames != "undefined" )
	    {
		$(function() {
			<? foreach( array( "songnameid" ) as $sid ) { ?>
			$( "#autosuggest<?=$sid?>" ).autocomplete({
				source: availableTagsSongnames
				    });
			<? } ?>
			    
		    });
	    }
</script>
<? include "footer.php"; ?>
