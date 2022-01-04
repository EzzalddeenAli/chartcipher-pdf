<?php
$istrend = true;
$nologin = 1;

if( isset( $_GET["search"]["chartid"] ) && $_GET["search"][chartid] ) $mybychart = "_bychart";
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions{$mybychart}.php";
include "trendfunctions{$mybychart}.php";

if( $search["primaryartist"] ) $artistfilter = db_query_first_cell( "select id from artists where name = '" . $search["primaryartist"] . "' " );
if( $search["writer"] ) $songwriterfilter = db_query_first_cell( "select id from artists where name = '" . $search["writer"] . "' " );
if( $search["producer"] ) $producerfilter = db_query_first_cell( "select id from producers where name = '" . $search["producer"] . "' " );
if( $search["specificsubgenre"] ) $subgenrefilter = $search["specificsubgenre"];

$globalseasonstr = str_replace( "4", "0", $season );
$globalseasonstr = $globalseasonstr?" and QuarterNumber % 4 in ($globalseasonstr)" :""; 

$season = $search[dates][season];
if( !$search[dates][fromq] && !$search[dates][fromyear] )
{
//    $nodates = true;
    $search[dates][fromq] = $season?getFirstSeason( $season ):1;
    $search[dates][fromy] = 2013;
    $rightnow = explode( "/", calculateCurrentQuarter() );
    
    $search[dates][toq] = $season?getLastSeason( $season ):$rightnow[0];
    $search[dates][toy] = $rightnow[1];
    // if( $season == "4,1" ) // we need to cross over into the next year, UGH
    // 	$search[dates][toy]++;
	
    $nodatestable = true;
}

if( $search["dates"]["fromyear"] )
    {
	$doingyearlysearch = true;
	$replacetotimeperiod = true;
	
	
	if( !$search["dates"]["toyear"] ) 
	    {
		$search["dates"]["toyear"] = $search["dates"]["fromyear"];
	    }
	$rangedisplay = "{$search[dates][fromyear]}";
	if( $search[dates][fromyear] != $search[dates][toyear] )
	    $rangedisplay .= " - {$search[dates][toyear]}";
	
	$search[dates][fromq] = $season?getFirstSeason( $season ):1; 
	$search["dates"]["fromy"] = $search[dates]["fromyear"];
	$search[dates][toq] = $season?getLastSeason( $season ):4;
	$search["dates"]["toy"] = $search[dates]["toyear"];
	// if( $season == "4,1" ) // we need to cross over into the next year, UGH
	//     $search[dates][toy]++;
	//	print_r( $search["dates"] );
	$urldatestr = "&search[dates][fromq]=" . $search[dates][fromq]. "&search[dates][toq]=" . $search[dates][toq];

	if( $search[dates][toyear] == $search[dates][fromyear] )
	    {
		if( $_GET["graphtype"] == "line" || !$_GET["graphtype"] )
		    {
			$graphtype = "column";	
			$_GET["graphtype"] = "column";
		    }
		$onlyoneyear = true;
	    }
	
	if( !$graphtype ) $graphtype = "line";
	
	
	$prevq = 1;
	$prevyear = $search[dates]["fromyear"]-1;
	
	/// three years ago?    
	$oldestyearly = max( $prevyear - 2, $earliesty );
	$oldestq = 1;
	$oldesty = $oldestyearly;
	
	$quarterstorun = getQuarters( $oldestq, $oldesty, $quarter, $year );
	
	// $prevsongs = getSongIdsWithinQuarter( false, $prevq, $prevyear, 4, $prevyear );
	// $prevsongsstr = implode( ", ", $prevsongs );
	
	$pos = $search[peakchart];
	if( $pos && strpos( $pos, "client-" ) === false )
	    {
		$pos = "<" . $pos;
	    }

	$allsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], $pos );
	//	echo( "after" );
	$allsongsstr = implode( ", ", $allsongs );
	// $allsongsnumber1 = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], 1 );
	// if( !count( $allsongsnumber1 ) ) // if there are no songs we should put sometihing in there so it doesn't display everything
	//     $allsongsnumber1[] = -1;
	//print_r( $allsongsnumber1 );
	//	$allsongsallquarters = getSongIdsWithinQuarter( false, $oldestq, $oldesty, $search[dates][toq], $search[dates][toy] );
	//	$allsongsallquartersstr = implode( ", ", $allsongsallquarters );
	
	//	$allsongsnumber1str = implode( ", ", $allsongsnumber1 );
	//	if( !$allsongsnumber1str ) $allsongsnumber1str = "-1";
	if( !$allsongsstr ) $allsongsstr = "-1";
	//	if( !$allsongsallquartersstr ) $allsongsallquartersstr = "-1";

      $s = str_replace( "4", "0", $search[dates][fromq] );
      $quarternumbers = $season?" and QuarterNumber % 4 in ($s)" :""; 
	$firstweekdateid = db_query_first_cell( "select min( OrderBy ) from weekdates where realdate like '" . $search["dates"]["fromyear"] . "%' $quarternumbers" );
      $s = str_replace( "4", "0", $search[dates][toq] );
      $quarternumbers = $season?" and QuarterNumber % 4 in ($s)" :""; 
	$lastweekdateid = db_query_first_cell( "select max( OrderBy ) from weekdates where realdate like '" . $search["dates"]["toyear"] . "%' $quarternumbers" );
	//	echo( $quarternumbers ); exit;
    }
else
    {
	if( !$search[dates][toq] )
	    {
		$search[dates][toq] = $search[dates][fromq];
		$search[dates][toy] = $search[dates][fromy];
	    }
	if( $search[dates][toq] == $search[dates][fromq] &&  $search[dates][toy] == $search[dates][fromy] )
	    {
		if( $_GET["graphtype"] == "line" || !$_GET["graphtype"] )
		    {
			$graphtype = "column";	
			$_GET["graphtype"] = "column";
		    }
		$onlyonequarter = true;
	    }
	
	if( !$graphtype ) $graphtype = "line";
	
	$quarterstorun = getQuarters( $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
	
	$firstweekdateid = db_query_first_cell( "select min( OrderBy ) from weekdates where QuarterNumber = '" . calculateQuarterNumber( $search["dates"]["fromq"], $search["dates"]["fromy"] ) . "'" );
	$lastweekdateid = db_query_first_cell( "select max( OrderBy ) from weekdates where QuarterNumber = '" . calculateQuarterNumber( $search["dates"]["toq"], $search["dates"]["toy"] ) . "'" );

	$pos = $search[peakchart];
	if( $pos && strpos( $pos, "client-" ) === false )
	    {
		$pos = "<" . $pos;
	    }
	
	$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], $pos );
	
    }
if( $searchcriteria[artistid] )
{

    $table = "artist";
    $vid = db_query_first_cell( "select id from {$table}s where Name = '" . escMe( $searchcriteria[artistid] )."' ");
    if( !$vid )
        $vid = db_query_first_cell( "select id from {$table}s where FullBirthName = '" . escMe( $searchcriteria[artistid] )."' ");
    
    if( !$vid && $table == "artist" )
    {
        $vid = db_query_first_cell( "select id from groups where Name = '" . escMe( $searchcriteria[artistid] )."' ");
        if( $vid )
        {
            $table = "group";
        }
    }
    
    if( $searchcriteria[artisttype] == "producer" )
    {
        $table = "producer";
        $vid = db_query_first_cell( "select id from producers where Name = '" . escMe( $searchcriteria[artistid] )."' ");
        $sql = "select songid from song_to_{$table} where {$table}id = $vid";
//        echo( $sql . "\n<br>" );
        $myartistsongs = db_query_array( $sql, "songid", "songid" );
    }
    else if( $searchcriteria[artisttype] == "primaryartist" )
    {
	$typestr = "'featured', 'primary'";
	if( $_GET["searchcriteria"]["featuredmain"] )
	    $typestr = "'" . $_GET["searchcriteria"]["featuredmain"] . "'";
        $sql = "select songid from song_to_{$table} where type in ( $typestr ) and {$table}id = $vid";

        $myartistsongs = db_query_array( $sql, "songid", "songid" );
    }
    else
    {
            // writers have to be an artist, but oh well
        $sql = "select songid from song_to_{$table} where type in ( 'creditedsw' ) and {$table}id = $vid";
//        echo( $sql . "\n<br>" );
        $myartistsongs = db_query_array( $sql, "songid", "songid" );
    }
    $allsongs = array_intersect( $allsongs, $myartistsongs );
}

if( $newcarryfilter )
    {
	if( $newcarryfilter == "new" )
	    {
		$f = db_query_first_cell( "select id from weekdates where OrderBy = '$firstweekdateid'" );
		$l = db_query_first_cell( "select id from weekdates where OrderBy = '$lastweekdateid'" );
		$newsongs = db_query_array( "select songid, min( weekdateid ) from song_to_weekdate group by songid having min( weekdateid ) >= $f and min( weekdateid ) <= $l", "songid", "songid" );
		//echo( "select songid, min( weekdateid ) from song_to_weekdate group by songid having min( weekdateid ) >= $f and min( weekdateid ) <= $l" );
		$allsongs = array_intersect( $allsongs, $newsongs );
		
	    }
	else
	    {
		$newsongs = db_query_array( "select songid, min( weekdateid ) from song_to_weekdate group by songid having min( weekdateid ) < $f", "songid", "songid" );
		$allsongs = array_intersect( $allsongs, $newsongs );
	    }
    }

if( count( $influences ) )
    {
	$vid = implode( ", ", $influences );
	$table = "subgenre";

        $sql = "select songid from song_to_{$table} where {$table}id in ( $vid )";
        $myartistsongs = db_query_array( $sql, "songid", "songid" );
	$allsongs = array_intersect( $allsongs, $myartistsongs );
	
    }

if( count( $pinstruments ) )
    {
	$vid = implode( ", ", $pinstruments );
	$table = "primaryinstrumentation";
	
        $sql = "select songid from song_to_{$table} where {$table}id in ( $vid )";
        $myartistsongs = db_query_array( $sql, "songid", "songid" );
	$allsongs = array_intersect( $allsongs, $myartistsongs );
    }

if( !$thetype ) $thetype = $searchsubtype;
$backurl = "trend-csv.php?" . $_SERVER['QUERY_STRING'];
if( !count( $allsongs  ))
{
   echo( "no songs?" );
   exit; 
    Header( "Location: $backurl&nomatch=1" );
}
else
{


    if( $graphtype == "column" || !$graphtype )

	{
	    if( !count( $posstitles ) )
		$posstitles = getCSVPossTitles();
	    // print_r( $posstitles );
	    // exit;
	    
	    
	    $songsbyweeks = array();
	    $songsbyweekscache = array();
	    foreach( $allsongs as $a )
		{
		    if( $weektype == "weeksduring" )
			$numweeks = db_query_first_cell( "select count(weekdateid) from song_to_weekdate, weekdates where weekdates.id = weekdateid and OrderBy >= $firstweekdateid and OrderBy <= $lastweekdateid and  songid = $a " ); 
		    else
			$numweeks = db_query_first_cell( "select count(weekdateid) from song_to_weekdate, weekdates where weekdates.id = weekdateid and  songid = $a " ); // and OrderBy >= $firstweekdateid and OrderBy <= $lastweekdateid // all weeks for the song now
		    
		    $songsbyweekscache[$a] = $numweeks;
		    if( $numweeks <=4 )
			{
			    $songsbyweeks["1-4"][] = $a;
			}
		    else if( $numweeks <=9 )
			{
			    $songsbyweeks["5-9"][] = $a;
			}
		    else if( $numweeks <=19 )
			{
			    $songsbyweeks["10-19"][] = $a;
			}
		    else if( $numweeks <=29 )
			{
			    $songsbyweeks["20-29"][] = $a;
			}
		    else
			{
			    $songsbyweeks["30-999"][] = $a;
			}
		    
		    if( $numweeks == 1 )
			{
			    $songsbyweeks["1-1"][] = $a;
			}
		    else
			{
			    $songsbyweeks["2-+"][] = $a;
			}
		    
		    if( $numweeks >= 30 )
			{
			    $songsbyweeks["30-+"][] = $a;
			}
		    if( $numweeks >= 20 )
			{
			    $songsbyweeks["20-+"][] = $a;
			}
		    if( $numweeks >= 10 )
			{
			    $songsbyweeks["10-+"][] = $a;
			}
		    else
			{
			    $songsbyweeks["1-9"][] = $a;
			}
		    if( $numweeks >= 5 )
			{
			    $songsbyweeks["5-+"][] = $a;
			}
		    
		    $songsbyweeks["1-+"][] = $a;
		}
	    if( $_GET["help3"] )
		{
		    echo( "\n\n<br>rows\n\n<br>" );
		    print_r( $allsongs );
		    print_r( $songsbyweeks );
		    echo( "\n\n<br>end\n\n<br>" );
		    exit;
		}
	}
    else
	{
	    $songsbyweeks = array();
	    $chosenselections = $posstitles;
	    $songsbyweekscache = array();
	    foreach( $allsongs as $a )
		{
		    if( $weektype == "weeksduring" )
			$numweeks = db_query_first_cell( "select count(weekdateid) from song_to_weekdate, weekdates where weekdates.id = weekdateid and OrderBy >= $firstweekdateid and OrderBy <= $lastweekdateid and  songid = $a " ); 
		    else
			$numweeks = db_query_first_cell( "select count(weekdateid) from song_to_weekdate, weekdates where weekdates.id = weekdateid and  songid = $a " ); // and OrderBy >= $firstweekdateid and OrderBy <= $lastweekdateid // all weeks for the song now
		    
		    $songsbyweekscache[$a] = $numweeks;
		    if( $numweeks <=4 )
			{
			    $songsbyweeks["1-4"][] = $a;
			}
		    else if( $numweeks <=9 )
			{
			    $songsbyweeks["5-9"][] = $a;
			}
		    else if( $numweeks <=19 )
			{
			    $songsbyweeks["10-19"][] = $a;
			}
		    else if( $numweeks <=29 )
			{
			    $songsbyweeks["20-29"][] = $a;
			}
		    else
			{
			    $songsbyweeks["30-999"][] = $a;
			}
		    
		    if( $numweeks == 1 )
			{
			    $songsbyweeks["1-1"][] = $a;
			}
		    else
			{
			    $songsbyweeks["2-+"][] = $a;
			}
		    
		    if( $numweeks >= 30 )
			{
			    $songsbyweeks["30-+"][] = $a;
			}
		    if( $numweeks >= 20 )
			{
			    $songsbyweeks["20-+"][] = $a;
			}
		    if( $numweeks >= 10 )
			{
			    $songsbyweeks["10-+"][] = $a;
			}
		    else
			{
			    $songsbyweeks["1-9"][] = $a;
			}
		    if( $numweeks >= 5 )
			{
			    $songsbyweeks["5-+"][] = $a;
			}
		    
		    $songsbyweeks["1-+"][] = $a;
		}


	    if( $chosenselections )
		{
		    $songswithinweeks = array();
		    //		    echo( count( $allsongs ) . ":<br>" );
		    foreach( $chosenselections as $c )
			{
			    foreach( $songsbyweeks[$c] as $sid )
				{
				    $songswithinweeks[$sid] = $sid;
				}
			}
		    // print_r( $chosenselections );
		    //		    print_r( $songsbyweeks );
		    $allsongs = $songswithinweeks;
		    //		    exit;

		}
	    $posstitles = array();
	    if( $doingyearlysearch )
		{
		    for( $i = $search["dates"]["fromyear"]; $i <= $search["dates"]["toyear"]; $i++ )
			{
			    $posstitles[$i] = $i;
			    $maxwd = db_query_first_cell( "select max( OrderBy ) from weekdates where realdate like '{$i}-%'" ); 
			    $minwd = db_query_first_cell( "select min( OrderBy ) from weekdates where realdate like '{$i}-%'" ); 
			    $songsbyweeks[$i] = db_query_array( "select songid from song_to_weekdate, weekdates where weekdateid = weekdates.id and OrderBy >= '$minwd' and OrderBy <= '$maxwd' and songid in ( " . implode( ", ", $allsongs ) . " )" , "songid", "songid" ); 
			}
		}
	    else
		{
		    $posstitles = getQuarters( $search["dates"]["fromq"], $search["dates"]["fromy"], $search["dates"]["toq"], $search["dates"]["toy"] );
		    foreach( $posstitles as $p )
			{
			    $exp = explode( "/", $p );
			    $qn = calculateQuarterNumber($exp[0], $exp[1] );
			    $maxwd = db_query_first_cell( "select max( OrderBy ) from weekdates where QuarterNumber = '$qn'" ); 
			    $minwd = db_query_first_cell( "select min( OrderBy ) from weekdates where QuarterNumber = '$qn'" ); 
			    $songsbyweeks[$p] = db_query_array( "select songid from song_to_weekdate, weekdates where weekdateid = weekdates.id and OrderBy >= '$minwd' and OrderBy <= '$maxwd' and songid in ( " . implode( ", ", $allsongs ) . " ) ", "songid", "songid" ); 

			}
		}
	}
    //	    print_r( $songsbyweeks );exit;

    require_once "Spreadsheet/Excel/Writer.php";
    $xls = new Spreadsheet_Excel_Writer();
    $filename = "trendcsvreport.xls";
    $xls->setVersion(8);
    $xls->send( $filename );

    $percentformat =& $xls->addFormat();
    $percentformat->setNumFormat( "0%" );

    $timeformat =& $xls->addFormat();
    $timeformat->setNumFormat( "MM:SS" );
    $timeformathours =& $xls->addFormat();
    $timeformathours->setNumFormat( "HH:MM:SS" );

    $format_bold =& $xls->addFormat();
    $format_bold->setBold();

    $rownum = 0;
    $colnum = 0;
    $sheet =& $xls->addWorksheet("Output");

    $sw = db_query_first_cell( "select Name from weekdates where OrderBy = '$firstweekdateid'" );
    $ew = db_query_first_cell( "select Name from weekdates where OrderBy = '$lastweekdateid'" );
    $totweeks = db_query_first_cell( "select count(*) from weekdates where OrderBy >= '$firstweekdateid' and OrderBy <= '$lastweekdateid'" );
    $sheet->write( $rownum, $colnum++, "All Songs for $sw - $ew ($totweeks weeks)", $format_bold );

    if( $genrefilter ) {  
	$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Genre: " . $allgenresfordropdown[$genrefilter], $format_bold ); 
    }
    if( $search["primaryartist"] ) { 
	$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Artist: " . $search["primaryartist"], $format_bold ); 
    }
    if( $search["writer"] ) {
	$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Writer: " . $search["writer"], $format_bold ); 
    }
$tmpvalues = array( "1"=> "#1", "3"=>"Top 3", "5"=>"Top 5");
if( $search["peakchart"] ) 
    {
	$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Peak Chart Position: " . $peakvalues[$search["peakchart"]], $format_bold ); 
    }
if( $search["producer"] ) { 
	$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Producer: " . $search["producer"], $format_bold ); 
}
if( $newcarryfilter ) { 
	$rownum++; $colnum = 0;
	$p = getValuesForNewCarry( "trend" );
	$sheet->write( $rownum, $colnum++, "New Songs / Carryovers: " . $p[$newcarryfilter] , $format_bold ); 
}
if( $search["specificsubgenre"] ) 
    {
	$rownum++; $colnum = 0;
	$sheet->write( $rownum, $colnum++, "Sub-Genre/Influence: " . getNameById( "subgenres", $search["specificsubgenre"] ) , $format_bold ); 
    }

if( count( $influences ) )
    {
	$rownum++; $colnum = 0;
	$sheet->write( $rownum, $colnum++, "Sub-Genre/Influence(s): ", $format_bold );
	foreach( $influences as $i )
	    {
		$sheet->write( $rownum, $colnum++, getNameById( "subgenres", $i ) );
	    }
    }
if( count( $pinstruments ) )
    {
	$rownum++; $colnum = 0;
	$sheet->write( $rownum, $colnum++, "Instrument(s): ", $format_bold );
	foreach( $influences as $i )
	    {
		$sheet->write( $rownum, $colnum++, getNameById( "primaryinstrumentation", $i ) );
	    }
    }

	$rownum++; $colnum = 0;
if( $weektype == "weeksduring" )
    $sheet->write( $rownum, $colnum++, "The number of weeks in this report reflects only weeks during the selected time period." );
else
    $sheet->write( $rownum, $colnum++, "The number of weeks in this report reflects \"all time\" weeks.  Not only does it include number of weeks during the selected time period, but it also accounts for weeks in the Top 10 prior to the selected time period and beyond the selected time period." );
$rownum++;
$rownum++;

    foreach( $posstitles as $weekname )
	{
	    $thesesongs = $songsbyweeks[$weekname];
	    if( !$thesesongs ) continue;
	    $tmpsongs = array();
	    foreach( $thesesongs as $sid )
		{
		    $tmpsongs[$sid] = $songsbyweekscache[$sid];
		}
	    asort( $tmpsongs, SORT_NUMERIC );
	    $rownum++;
	    $colnum = 0;
	    $sheet->write( $rownum, $colnum++, formatCSVTitle( $weekname ), $format_bold );
	    $sheet->write( $rownum, $colnum++, count( $tmpsongs ) . " Total Song(s)", $format_bold );
	    foreach( $tmpsongs as $sid=> $numweeks )
		{
		    $rownum++;
		    $colnum = 0;
		    $sheet->write( $rownum, $colnum++,  getSongnameFromSongid( $sid ) );
		    $sheet->write( $rownum, $colnum++,  $numweeks);
		}
	    
	    $rownum++;
	    $rownum++;
	    
	}


    $aspects = getMyPossibleSearchFunctions();
    foreach( $aspects as $aspect=>$displayaspect )
	{
	    if( $aspect == "Number of Songs" || $aspect == "Number of Weeks" || $aspect == "Percentage of Songs" ) continue;
	    if( $displayaspect == "Song Form (Number of Songs)" ) continue;

    $search["comparisonaspect"] = $aspect;
	    $rows = getRowsComparison( $search, $allsongs );	
	    $dataforrows = getCSVTrendDataForRows( $search[comparisonaspect], $pos, $songsbyweeks );

	    if( strpos( $displayaspect, "Average Time" ) === false && strpos( $displayaspect, "Average Song Length" ) === false && strpos( $displayaspect, "Average Intro Length" ) === false && strpos( $displayaspect, "Average Outro Length" ) === false && strpos( $displayaspect, "Average Tempo" ) === false )
		{
	    $rownum++;
	    $colnum = 0;
	    //	    $sheet->write( $rownum, $colnum++, $aspect, $format_bold );
	    $sheet->write( $rownum, $colnum++, $displayaspect, $format_bold );

	    

	    $rownum++;
	    $colnum = 1;
	    foreach( $rows as $title )
		{
		    $sheet->write( $rownum, $colnum++, $title, $format_bold );
		}
	    $rownum++;
	    foreach( $posstitles as $title ) 
		{
		    $drows = $dataforrows[$title];
		    if( !$drows ) continue;
		    $colnum = 0;
		    $sheet->write( $rownum, $colnum++, formatCSVTitle( $title ), $format_bold );
		    foreach( $rows as $rowtitle=>$throwaway )
			{
			    $data = $drows[$rowtitle];
			    $sheet->write( $rownum, $colnum++, $data[0]/100, $percentformat );
			}
		    $rownum++;
		    // print_r( $rows );
		    // print_r( $dataforrows );
		    // exit;
		}

		}
	    if( strpos( $displayaspect, "Percent Into" ) === false )
		{

		    $rownum++;
		    $colnum = 0;
		    //	    $sheet->write( $rownum, $colnum++, $aspect, $format_bold );
		    $sheet->write( $rownum, $colnum++, $displayaspect, $format_bold );
		    
		    
		    $rownum++;
		    $colnum = 1;
		    foreach( $rows as $title )
			{
			    $sheet->write( $rownum, $colnum++, $title, $format_bold );
			}
		    $rownum++;
		    foreach( $posstitles as $title ) 
			{
			    $drows = $dataforrows[$title];
			    if( !$drows ) continue;
			    $colnum = 0;
			    $sheet->write( $rownum, $colnum++, formatCSVTitle( $title ), $format_bold );
			    
			    foreach( $rows as $rowtitle=>$throwaway )
				{
				    $data = $drows[$rowtitle];
				    if( strpos( $displayaspect, "Average Time" ) !== false || strpos( $displayaspect, "Average Song Length" ) !== false || strpos( $displayaspect, "Average Intro Length" ) !== false || strpos( $displayaspect, "Average Outro Length" ) !== false ) 
					{
					    $sheet->write( $rownum, $colnum++, $data[1], $timeformat );
					}
				    else if( strpos( $displayaspect, "Average Tempo" ) !== false ) 
					{
					    $sheet->write( $rownum, $colnum++, isset( $data[4] )?$data[4]:$data[0] ); 
}
				    else
					{
					    $val = isset( $data[4] )?$data[4]:$data[0];
					    if( !$val ) $val = 0;
					    $sheet->write( $rownum, $colnum++, $val ); 
					}
				    //				    $sheet->write( $rownum, $colnum++, $data["sql"] );
				}
			    $rownum++;
			    // print_r( $rows );
			    // print_r( $dataforrows );
			    // exit;
			}
		    file_put_contents( "/tmp/touche", "\n\n" . $displayaspect . "\n" . print_r( $rows, true ), FILE_APPEND );
		    file_put_contents( "/tmp/touche", "\n\n" . $displayaspect . "\n" . print_r( $dataforrows, true ), FILE_APPEND );

		}
	    $rownum++;
	    $rownum++;
	    //	    break;
	}
    $xls->close();
    exit;
}

?>
