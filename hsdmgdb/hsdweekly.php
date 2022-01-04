<? 
include "connect.php";
$nextweek = time() + 14*24*60*60;
$dates = db_query_rows( "select * from weekdates where OrderBy < $nextweek order by OrderBy desc", "id" );

 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

function getTop3OneToMultiple( $weekdateid, $type, $tabletype="" )
{
  $retval = array();
  $whr = $tabletype?" and sts.type = '$tabletype'":"";
  $top3 = db_query_rows( "select s.id as songid, sn.Name as songname, type as position from songs s, song_to_weekdate stw, songnames sn where sn.id = songnameid and weekdateid = $weekdateid and s.id = songid and stw.type in ( 'position1', 'position2', 'position3' ) ", "position" );

  foreach( $top3 as $pkey=>$val )
    {
      $songid = $val["songid"];
      $values = array();
      
      $sql = ( "select g.Name from {$type}s g, song_to_{$type} sts where $songid = sts.songid and g.id = sts.{$type}id $whr" );
      $values = db_query_array( $sql, "Name", "Name" );
      
      $val["Name"] = implode( ", ", $values );
      $val["songname"] = getSongnameFromSongid( $val["songid"] );
      $retval[$pkey] = $val;
    }
  
  return $retval;
}

// returns array of displayname to $position=> ( array( Name, position, songname ) )
function getTop3Enum( $weekdateid, $columnname )
{
  return getTop3EnumWithReplacement( $weekdateid, $columnname );
}
function getTop3EnumWithReplacement( $weekdateid, $columnname, $replacements = array() )
{
  $retval = array();

  $top3 = db_query_rows( "select s.id as songid, sn.Name as songname, $columnname as Name, type as position from songs s, song_to_weekdate stw, songnames sn where weekdateid = $weekdateid and s.id = songid and stw.type in ( 'position1', 'position2', 'position3' ) and sn.id = songnameid and Name is not null and Name > '' ", "position" );

  foreach( $top3 as $pkey=>$val )
    {
      $key = $val["Name"];
      if( isset( $replacements[$key] ) )
	$key .= $replacements[$key];
      $val["Name"] = $key;
      $val["songname"] = getSongnameFromSongid( $val["songid"] );
      $retval[$pkey] = $val;
    }

  return $retval;
}

function addSummary( $summary, $summary2, $static="", $chart="", $positionsub = "" )
{
  global $overallarr; 

  if( !$positionsub ) $positionsub = "Top {$static}:"; 
  if( !$chart )
    $chart = $static; 

    $overallarr[] = array( "" );
    $overallarr[] = array( "" );
    $overallarr[] = array( "", "Summary #1:", "Most Popular of the Week: " . $summary );
    $overallarr[] = array( "", "Summary #2:", "Hot 100 Top 3 Spotlight - " . $summary2 );
    $overallarr[] = array( "" );
    $overallarr[] = array( "" );
    $overallarr[] = array("","","Static Variables:","$static");
    $overallarr[] = array("","","Chart Title:","$chart");
    $overallarr[] = array("","","Position Sub Title:","$positionsub");
    
  
}

function getStandardEnum( $weekdateid, $columnname )
{
  return getStandardEnumWithReplacement( $weekdateid, $columnname );
}

function getStandardEnumWithReplacement( $weekdateid, $columnname, $replacements = array() )
{
  $ig = $columnname == "SongwriterCount" ?"":"and $columnname > ''";
  $retval = db_query_rows( "select {$columnname}, group_concat( s.id ) as songids, count(*) cnt from songs s, song_to_weekdate stw where weekdateid = $weekdateid and s.id =  songid  $ig group by {$columnname}", "{$columnname}" )  ;
  //  reportlog( "select {$columnname}, group_concat( s.id ) as songids, count(*) cnt from songs s, song_to_weekdate stw where weekdateid = $weekdateid and s.id =  songid and {$columnname} > '' group by {$columnname}", "{$columnname}" )  ;
  if( !count( $replacements ) )
    return $retval; 

  $newval = array();
  foreach( $retval as $key=>$row )
    {
      if( isset( $replacements[$key] ) )
	$key .= $replacements[$key];
      $newval[$key] = $row;
    }
  return $newval;
}

function getStandardPrevEnum( $weekdateid, $columnname )
{
  return getStandardPrevEnumWithReplacement( $weekdateid, $columnname );
}

function getStandardPrevEnumWithReplacement( $weekdateid, $columnname, $replacements = array() )
{
  $ig = $columnname == "SongwriterCount" ?"":"and $columnname > ''";
  $retval = db_query_array( "select {$columnname}, group_concat( s.id ) as songids, count(*) cnt from songs s, song_to_weekdate stw where weekdateid = $weekdateid and s.id =  songid $ig group by {$columnname}", "{$columnname}", "cnt" );
  if( !count( $replacements ) )
    return $retval; 

  $newval = array();
  foreach( $retval as $key=>$row )
    {
      if( isset( $replacements[$key] ) )
	$key .= $replacements[$key];
      $newval[$key] = $row;
    }
  return $newval;

}

function getStandardOneToMultiple( $weekdateid, $type, $tabletype = "" )
{
	$whr = $tabletype?" and sts.type = '$tabletype'":"";
    if( hasColumn( $type . "s", "HideFromHSDCharts" ) )
        $whr .= " and HideFromHSDCharts = 0" ;
    
    $sql = ( "select g.Name, group_concat( s.id ) as songids, count(*) cnt from {$type}s g, songs s, song_to_weekdate stw, song_to_{$type} sts where weekdateid = $weekdateid and s.id = stw.songid and s.id = sts.songid and g.id = sts.{$type}id $whr group by Name" );
    $thisweek = db_query_rows( $sql, "Name" );
    return $thisweek; 
}

function getStandardOneToMultiplePrev( $weekdateid, $type, $tabletype="" )
{
	$whr = $tabletype?" and sts.type = '$tabletype'":"";
    if( hasColumn( $type . "s", "HideFromHSDCharts" ) )
        $whr .= " and HideFromHSDCharts = 0" ;

    $prevsql = "select g.Name, group_concat( s.id ) as songids, count(*) cnt from {$type}s g, songs s, song_to_weekdate stw, song_to_{$type} sts where weekdateid = $weekdateid and s.id = stw.songid and s.id = sts.songid and g.id = sts.{$type}id $whr group by Name";

    $prevweek = db_query_array( $prevsql, "Name", "cnt" );
    return $prevweek; 
}


// inputs are array of name=>value 
function calcAndPrint( $title, $array, $lastweekvalues, $top3, $summarybegin, $static = "", $chart = "", $positionsub = "" )
{
  global $overallarr, $weekdateid; 
  if( !$static ) 
    $static = $summarybegin;
  $retval = array();
  $total = 0;
  /* $lwtotal = 0; */
  /* foreach( $lastweekvalues as $key=>$num ) */
  /*   { */
  /*     $lwtotal += $num; */
  /*   } */

  $songtitles = array();

  foreach( $array as $name=>$valuearr )
    {
      $songtitles[$name] = implode( ", ", db_query_array( "select Name from songs s, songnames sn, song_to_weekdate stw where songnameid = sn.id and s.id in ( $valuearr[songids] ) and stw.songid = s.id and weekdateid = $weekdateid order by cast( replace( type, \"position\", \"\" ) as decimal ); ", "Name", "Name" ) );

      $value = $valuearr["cnt"];
      $value = str_pad( $value, 3, "0", STR_PAD_LEFT );
      if( !isset( $retval[$value] ) ) $retval[$value] = array();
      $retval[$value][] = $name;
      $total += $value;
    }
  foreach( $lastweekvalues as $name=>$throwaway )
  {
      if( !isset( $array[$name] ) )
      {
          $retval[0][] = $name;
      }
  }


  $total = 10;
  $lwtotal = 10;
  krsort( $retval );

  $overallarr[] = array("$title");
  $overallarr[] = array();
  $overallarr[] = array();
  $overallarr[] = array( "","RANK","$title","TW","LW","Movement" );

  $count = 1;  
  $summary = ""; 
  $summary2 = $summarybegin; 
  $summcount = 1;
  

  foreach( $retval as $num=>$values )
    {
      $startswith = "";
      if( count( $values ) > 1 ) 
	{
	  $startswith = "T";
	}
      $anyyet = 0;
      if( $count < 2 )
	{
	  //	  $summary .= " #{$count}: ";
	}
      foreach( $values as $v )
	{
	  if( $count < 2 )
	    {
	      if( $anyyet ) $summary .= ", ";
	      $summary .= strtoupper( $v ) . " (" . $songtitles[$v] . ") ";
	    }
	  $anyyet = 1;
	  $tw = number_format( $num/$total*100 );
	  $lwnum = $lastweekvalues[$v];
	  $lw = number_format( $lwnum/$lwtotal*100 );
	  
	  $movement = "S";
	  if( $lw == $tw ) $movement = "S";
	  else if( !$lwnum ) $movement = "N";
	  else if( $lw > $tw ) $movement = "D";
	  else if( $lw < $tw ) $movement = "U";
	  
	  $overallarr[] = array( "", $startswith . $count, $v, $tw . "%", $lw . "%", $movement );
	}
      $count++;
    }

// top3 is array of displayname to $position=> ( array( Name, position, songname ) )

  $summary2 .= " ";
  ksort( $top3 ); 
  file_put_contents( "/tmp/top3", $title . ":" . "\n" . print_r( $top3 , true ), FILE_APPEND );
  foreach( $top3 as $t )
    {
      $pos = str_replace( "position", "", $t["position"] );
      /* if( $pos > 1 ) */
      /* 	$summary2 .= ", ";  */
      $summary2 .= "#{$pos}: " . strtoupper( $t["Name"] ) . " ($t[songname]) ";
    }

  addSummary( $summary, $summary2, $static, $chart, $positionsub);
  $overallarr[] = array();
  $overallarr[] = array();

}


if( $go )
  {
    $drow = $dates[$weekdateid];
    $previd = db_query_first_cell( "select id from weekdates where OrderBy < $drow[OrderBy] order by OrderBy desc limit 1" );
    
    $totest = array();
//    $totest[] = "FirstChorusDescr";
    $totest[] = "SongLengthRange";
    $totest[] = "IntroLengthRange";
    $totest[] = "ElectricVsAcoustic";
    $totest[] = "SongTitleWordCount";
    $totest[] = "SongwriterCount";
    $totest[] = "VocalsGender";
//    $totest[] = "FirstChorusDescr";
    $totest[] = "SongLengthRange";
    $totest[] = "IntroLengthRange";
    $totest[] = "ElectricVsAcoustic";
    $totest[] = "SongTitleWordCount";
    //    $totest[] = "SongwriterCount";

    $no = 1;
    if($no)
      {
    foreach( $totest as $t )
      {
	$tres = db_query_array( "select distinct( songid ) from songs, song_to_weekdate where songid = songs.id and weekdateid in ( $previd, $weekdateid ) and $t is null ", "songid", "songid" );
	if( count( $tres ) )
	  {
	    echo( "<font color='red'>Missing Value for $t:</font>" );
	    foreach( $tres as $songid )
	      {
		echo( getSongnameFromSongid( $songid ) . "; " );
	      }
	    $anybad = true;
	    echo( "<br>" );
	  }
      }
      }

    if( !$anybad  )
      {
	$overallarr = array();
	
	$arr = array("Global" );
	$overallarr[] = $arr;
	$overallarr[] = array();
	$arr = array("", "Week Of:", $drow[Name]);
	$overallarr[] = $arr;
	$overallarr[] = array();
	$overallarr[] = array("", "Spotify URL:" );
	$overallarr[] = array();
	$overallarr[] = array();
	$overallarr[] = array();
	$overallarr[] = array();
	
	// example of a 1 to 1 table
	// genre report 
	$genres = db_query_rows( "select Name, group_concat( s.id ) as songids, count(*) cnt from genres g, songs s, song_to_weekdate stw where weekdateid = $weekdateid and s.id =  songid and g.id = GenreID group by Name", "Name" );
	$top3 = db_query_rows( "select g.Name as Name, sn.Name as songname, type as position from genres g, songs s, song_to_weekdate stw, songnames sn where sn.id = songnameid and weekdateid = $weekdateid and s.id =  songid and g.id = GenreID and stw.type in ( 'position1', 'position2', 'position3' ) ", "position" );
	$prevgenres = db_query_array( "select Name, count(*) cnt from genres g, songs s, song_to_weekdate stw where weekdateid = $previd and s.id =  songid and g.id = GenreID group by Name", "Name", "cnt" );
	calcAndPrint( "GENRE", $genres, $prevgenres, $top3, "Primary Genre", "", "Genre", "Top Genre:" );
	
	// end genre
	
	
	// example of a 1 to multiple table
	// subgenre report 
	$top3 = getTop3OneToMultiple( $weekdateid, "subgenre", "Main" );
	$thisweek = getStandardOneToMultiple( $weekdateid, "subgenre", "Main" );
	$prevweek = getStandardOneToMultiplePrev( $previd, "subgenre", "Main" );
	calcAndPrint( "SUB-GENRES & INFLUENCERS", $thisweek, $prevweek, $top3, "Sub-Genres & Influencers", "", "Sub-Genres & Influencers", "Top Sub-Genre & Influencer:" );
	// end subgenre
	
	
	// example of enum column
	// lead vocals

	$top3 = getTop3Enum( $weekdateid, "VocalsGender" );
	$values = getStandardEnum( $weekdateid, "VocalsGender" );
	$prevvalues = getStandardPrevEnum( $previd, "VocalsGender" );
	calcAndPrint( "LEAD VOCAL", $values, $prevvalues, $top3, "Lead Vocal", "", "Lead Vocal", "Top Lead Vocal:" );
	// end lead vocals
	
	// example of a 1 to multiple table
	// lyrical themes report 
	$top3 = getTop3OneToMultiple( $weekdateid, "lyricaltheme" );
	$thisweek = getStandardOneToMultiple( $weekdateid, "lyricaltheme" );
	$prevweek = getStandardOneToMultiplePrev( $previd, "lyricaltheme" );
	calcAndPrint( "LYRICAL THEMES", $thisweek, $prevweek, $top3, "Lyrical Themes", "", "Lyrical Themes", "Top Lyrical Theme:" );
	// end lyrical themes
	
	// example of enum column with replacement
	// first chorus occurence
	$replacements = array();
	$replacements["Moderately Late"] = " (0:40 - 0:59)";
	$replacements["Early"] = " (0:01 - 0:19)";
	$replacements["Late"] = " (1:00+)";
	$replacements["Kickoff"] = " (0:00)";
	$replacements["Moderately Early"] = " (0:20 - 0:39)";
	
	$top3 = getTop3EnumWithReplacement( $weekdateid, "FirstChorusDescr", $replacements );
	$values = getStandardEnumWithReplacement( $weekdateid, "FirstChorusDescr", $replacements );
	$prevvalues = getStandardPrevEnumWithReplacement( $previd, "FirstChorusDescr", $replacements );
	calcAndPrint( "FIRST CHORUS OCCURRENCE", $values, $prevvalues, $top3, "First Chorus Occurrence" );
	// end lead vocals
	
	
	// example of enum column
	// song length
	$top3 = getTop3Enum( $weekdateid, "SongLengthRange" );
	$values = getStandardEnum( $weekdateid, "SongLengthRange" );
	$prevvalues = getStandardPrevEnum( $previd, "SongLengthRange" );
	calcAndPrint( "SONG LENGTH", $values, $prevvalues, $top3, "Song Length" );
	// end song length
	
	
	// example of enum column with replacement
	// intro length
	$replacements = array();
	$replacements["Moderately Short"] =" (0:10 - 0:19)";
	$replacements["Short"] = " (0:01 - 0:09)";
	$replacements["Moderately Long"] = " (0:20 - 0:29)";
	$replacements["Long"] = " (0:30+)";
	
	$top3 = getTop3EnumWithReplacement( $weekdateid, "IntroLengthRange", $replacements );
	$values = getStandardEnumWithReplacement( $weekdateid, "IntroLengthRange", $replacements );
	$prevvalues = getStandardPrevEnumWithReplacement( $previd, "IntroLengthRange", $replacements );
	calcAndPrint( "INTRO LENGTH", $values, $prevvalues, $top3, "Intro Length" );
	// end intro length
	
	
	
	// example of enum column
	// ELECTRIC VS. ACOUSTIC
	$top3 = getTop3Enum( $weekdateid, "ElectricVsAcoustic" );
	$values = getStandardEnum( $weekdateid, "ElectricVsAcoustic" );
	$prevvalues = getStandardPrevEnum( $previd, "ElectricVsAcoustic" );
	calcAndPrint( "ELECTRONIC VS. ACOUSTIC", $values, $prevvalues, $top3, "Electronic Vs. Acoustic" );
	// end ELECTRIC VS. ACOUSTIC
	
	
	// example of enum column with replacement
	// SONG TITLE WORD COUNT
	$replacements = array();
	$replacements["1"] =" Word";
	for( $i = 2; $i < 40; $i++ ) 
	  $replacements["$i"] = " Words";
	
	$top3 = getTop3EnumWithReplacement( $weekdateid, "SongTitleWordCount", $replacements );
	$values = getStandardEnumWithReplacement( $weekdateid, "SongTitleWordCount", $replacements );
	$prevvalues = getStandardPrevEnumWithReplacement( $previd, "SongTitleWordCount", $replacements );
	calcAndPrint( "SONG TITLE WORD COUNT", $values, $prevvalues, $top3, "Song Title Word Count" );
	// end SONG TITLE WORD COUNT
	


	// example of CUSTOM
	// SONG TITLE APPEARANCES
	$calc = array();
	$calc[] = array( 0, 0, "0 Times" );
	$calc[] = array( 1, 5, "1 - 5 Times" );
	$calc[] = array( 6, 10, "6 - 10 Times" );
	$calc[] = array( 11, 15, "11 - 15 Times" );
	$calc[] = array( 16, 20, "16 - 20 Times" );
	$calc[] = array( 21, 9990, "21+ Times" );
    
	$values = "";
	$columnname = "SongTitleAppearances";
	foreach( $calc as $crow )
	  {
	    $thisrow = db_query_first( "select '$crow[2]' as my{$columnname}, group_concat( s.id ) as songids, count(*) cnt from songs s, song_to_weekdate stw where weekdateid = $weekdateid and s.id =  songid and {$columnname} >= $crow[0]  and {$columnname} <= $crow[1] group by my{$columnname}", "my{$columnname}" )  ;
	    if( $thisrow["cnt"] ) 
	      $values[$crow[2]] = $thisrow;
	  }

	$prevvalues = array();
	foreach( $calc as $crow )
	  {
	    $thisrow = db_query_first( "select '$crow[2]' as my{$columnname}, group_concat( s.id ) as songids, count(*) cnt from songs s, song_to_weekdate stw where weekdateid = $previd and s.id =  songid and {$columnname} >= $crow[0]	and {$columnname} <= $crow[1] group by my{$columnname}", "my{$columnname}" )  ;
	    $prevvalues[$crow[2]] = $thisrow["cnt"];
	  }

	$res = db_query_rows(" select $columnname as mycol, type as position, s.id from songs s, song_to_weekdate stw where weekdateid = '$weekdateid' and s.id = songid and type in ( 'position1', 'position2', 'position3' ) order by type " );
	$top3 = array();
	foreach( $res as $r )
	  {
	    foreach( $calc as $crow )
	      {
		if( $crow[0] <= $r["mycol"] && $crow[1] >= $r["mycol"] )
		  {
		    // Name, sn.Name as songname, type as position
		    
		    $r["Name"] = $crow[2];
		    $r["songname"] = getSongnameFromSongid( $r["id"] );
		    $top3[$r["position"]] = $r;
		  }
	      }
	  }
	calcAndPrint( "SONG TITLE APPEARANCES", $values, $prevvalues, $top3, "Song Title Appearances" );
	// end SONG TITLE APPEARANCES


	// example of a 1 to multiple table
	// primary instrumentation report 
	$top3 = getTop3OneToMultiple( $weekdateid, "primaryinstrumentation", "Main" );
	$thisweek = getStandardOneToMultiple( $weekdateid, "primaryinstrumentation", "Main" );
	$prevweek = getStandardOneToMultiplePrev( $previd, "primaryinstrumentation", "Main" );
	calcAndPrint( "PRIMARY INSTRUMENTATION", $thisweek, $prevweek, $top3, "Primary Instrumentation" );
	// end primary instrumentation


	// example of a 1 to multiple table
	// label report 
	$thisweek = getStandardOneToMultiple( $weekdateid, "label" );
	$prevweek = getStandardOneToMultiplePrev( $previd, "label" );
	$top3 = getTop3OneToMultiple( $weekdateid, "label" );
	calcAndPrint( "RECORD LABELS", $thisweek, $prevweek, $top3, "Record Label" );

	// labels moved
	// example of a 1 to 1 table
	/* $labels = db_query_rows( "select Name, group_concat( s.id ) as songids, count(*) cnt from labels g, songs s, song_to_weekdate stw where weekdateid = $weekdateid and s.id =	 songid and g.id = LabelID group by Name", "Name" ); */
	/* $prevlabels = db_query_array( "select Name, count(*) cnt from labels g, songs s, song_to_weekdate stw where weekdateid = $previd and s.id =	 songid and g.id = LabelID group by Name", "Name", "cnt" ); */
	/* calcAndPrint( "RECORD LABELS", $labels, $prevlabels, "Record Label" ); */

	// end label


	// example of CUSTOM
	// SONGWRITER COUNT
	$replacements = array();
	$replacements["0"] =" Writers";
	$replacements["1"] =" Writer";
	for( $i = 2; $i < 40; $i++ ) 
	  $replacements["$i"] = " Writers";

	$top3 = getTop3EnumWithReplacement( $weekdateid, "SongwriterCount", $replacements );
	$values = getStandardEnumWithReplacement( $weekdateid, "SongwriterCount", $replacements );
	$prevvalues = getStandardPrevEnumWithReplacement( $previd, "SongwriterCount", $replacements );
	calcAndPrint( "SONGWRITERS", $values, $prevvalues, $top3, "Songwriter" );
	// end SONGWRITERS





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
  }

include "nav.php";
?>
<form method='post'>
  Export data for this week: <select name='weekdateid'>
  <? foreach( $dates as $drow ) { ?>
<option value='<?=$drow[id]?>' <?=$weekdateid==$drow[id]?"SELECTED":""?>><?=$drow[Name]?></option>
				  <? } ?>
</select>

<input type='submit' name='go' value='Go'>
</form>

<? include "footer.php"; ?>
