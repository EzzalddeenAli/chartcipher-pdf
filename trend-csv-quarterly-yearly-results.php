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


$season = $search[dates][season];

$globalseasonstr = str_replace( "4", "0", $season );
$globalseasonstr = $globalseasonstr?" and QuarterNumber % 4 in ($globalseasonstr)" :""; 
//echo( "aa" );exit;

$seasonstr = $season?"Q" . getFirstSeason( $season ) . " ":"";

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
	if( $search["dates"]["specialendq"] )
	    $search["dates"]["toq"] = $search["dates"]["specialendq"];
	
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
	$allsongsnumber1 = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], 1 );
	if( !count( $allsongsnumber1 ) ) // if there are no songs we should put sometihing in there so it doesn't display everything
	    $allsongsnumber1[] = -1;
	//print_r( $allsongsnumber1 );
	//	$allsongsallquarters = getSongIdsWithinQuarter( false, $oldestq, $oldesty, $search[dates][toq], $search[dates][toy] );
	//	$allsongsallquartersstr = implode( ", ", $allsongsallquarters );
	
		$allsongsnumber1str = implode( ", ", $allsongsnumber1 );
	//	if( !$allsongsnumber1str ) $allsongsnumber1str = "-1";
	if( !$allsongsstr ) $allsongsstr = "-1";
	//	if( !$allsongsallquartersstr ) $allsongsallquartersstr = "-1";
	$posstitles = array();
	for( $i = $search["dates"]["fromy"] ; $i <= $search["dates"]["toy"]; $i++ )
	    {
		$posstitles[] = $seasonstr . $i;
	    }
	$firstweekdateid = db_query_first_cell( "select min( OrderBy ) from weekdates where realdate like '" . $search["dates"]["fromyear"] . "%' $globalseasonstr" );
	$lastqn = calculateQuarterNumber( $season?getLastSeason($season):4, $search["dates"]["toy"] );
	if( $search["dates"]["specialendq"] )
	    {
		$lastqn = calculateQuarterNumber( $search["dates"]["specialendq"], $search["dates"]["toy"] );
	    }
	$lastweekdateid = db_query_first_cell( "select max( OrderBy ) from weekdates where QuarterNumber = $lastqn" );
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
	$posstitles = $quarterstorun;
	$firstweekdateid = db_query_first_cell( "select min( OrderBy ) from weekdates where QuarterNumber = '" . calculateQuarterNumber( $search["dates"]["fromq"], $search["dates"]["fromy"] ) . "'" );
	$lastweekdateid = db_query_first_cell( "select max( OrderBy ) from weekdates where QuarterNumber = '" . calculateQuarterNumber( $search["dates"]["toq"], $search["dates"]["toy"] ) . "'" );

	$pos = $search[peakchart];
	if( $pos && strpos( $pos, "client-" ) === false )
	    {
		$pos = "<" . $pos;
	    }
	
	$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], $pos );
	$allsongsstr = implode( ", ", $allsongs );
	$allsongsnumber1 = getSongIdsWithinQuarter( $newarrivalsonly, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], 1 );
	$allsongsnumber1str = implode( ", ", $allsongsnumber1 );


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
    $allsongsnumber1 = array_intersect( $allsongsnumber1, $myartistsongs );
}

if( count( $influences ) )
    {
	$vid = implode( ", ", $influences );
	$table = "subgenre";

        $sql = "select songid from song_to_{$table} where {$table}id in ( $vid )";
        $myartistsongs = db_query_array( $sql, "songid", "songid" );
	$allsongs = array_intersect( $allsongs, $myartistsongs );
	$allsongsnumber1 = array_intersect( $allsongsnumber1, $myartistsongs );
	
    }

if( count( $pinstruments ) )
    {
	$vid = implode( ", ", $pinstruments );
	$table = "primaryinstrumentation";
	
        $sql = "select songid from song_to_{$table} where {$table}id in ( $vid )";
        $myartistsongs = db_query_array( $sql, "songid", "songid" );
	$allsongs = array_intersect( $allsongs, $myartistsongs );
	$allsongsnumber1 = array_intersect( $allsongsnumber1, $myartistsongs );
    }
    $allweekdates = db_query_array("select id, id from weekdates where OrderBy >= '$firstweekdateid' and OrderBy <= '$lastweekdateid'" );
    $weekdatesstr = implode( ", " , $allweekdates );

$allsongsstr = implode( ", ", $allsongs );
$allsongsnumber1str = implode( ", ", $allsongsnumber1 );


$allsongsnonhiphop = db_query_array( "select id from songs where id in ( $allsongsstr ) and GenreID <> 2", "id", "id" );
$allsongshiphop = db_query_array( "select id from songs where id in ( $allsongsstr ) and GenreID = 2", "id", "id" );




if( !$allsongsnumber1str ) $allsongsnumber1str = "-1";
if( !$allsongsstr ) $allsongsstr = "-1";
if( !$thetype ) $thetype = $searchsubtype;
$backurl = "trend-csv-quarterly-yearly.php?" . $_SERVER['QUERY_STRING'];
if( !count( $allsongs  ))
{
   echo( "no songs?" );
   exit; 
    Header( "Location: $backurl&nomatch=1" );
}
else
{


    
    $songsbyquarters = array();
    $songsbyyears = array();
    $peakstr = "";
    $p = $search["peakchart"];
    if( $p )
	{
          $tmp = array();
          for( $i = 1; $i <= $p; $i++ )
          {
              $tmp[] = "'position{$i}'";
          }
          $tmp = implode( ", ", $tmp );
          $peakstr = " and type in ( $tmp )";
	}

    foreach( $allsongs as $a )
	{
	    $quarternumbers = db_query_array( "select distinct( QuarterNumber ), realdate from song_to_weekdate, weekdates where weekdates.id = weekdateid and OrderBy >= $firstweekdateid and OrderBy <= $lastweekdateid and  songid = $a $globalseasonstr $peakstr ", "QuarterNumber", "realdate" ); 
	    foreach( $quarternumbers as $qid=>$realdate )
		{
		    $qid = calculateQuarterDisplay( $qid );
		    $songsbyquarters[$qid][$a] = $a;
		    $date = $seasonstr . date( "Y", strtotime( $realdate ));
		    $songsbyyears[$date][$a] = $a;
		}
	}
    if( $_GET["help"] )
	{
	    echo( "\n\n<br>rows\n\n<br>" );
	    echo( "poss titles: <br>" );
	    print_r( $posstitles );
	    echo( "all songs: <br>" );
	    print_r( $allsongs );
	    echo( "quarters: <br>\n\n" );
	    print_r( $songsbyquarters );
	    echo( "years: <br>\n\n" );
	    print_r( $songsbyyears );
	    echo( "\n\n<br>end\n\n<br>" );
	    exit;
	}

    require_once "Spreadsheet/Excel/Writer.php";
    $xls = new Spreadsheet_Excel_Writer();
    $filename = "trendcsvquarterlyyearlyreport.xls";
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

    if( $doingyearlysearch )
	{
	    $sw = db_query_first_cell( "select Name from weekdates where OrderBy = '$firstweekdateid'" );
	    $ew = db_query_first_cell( "select Name from weekdates where OrderBy = '$lastweekdateid'" );
	}
    else
	{
	    $sw = db_query_first_cell( "select QuarterNumber from weekdates where OrderBy = '$firstweekdateid'" );
	    $ew = db_query_first_cell( "select QuarterNumber from weekdates where OrderBy = '$lastweekdateid'" );
	    $sw = calculateQuarterDisplay( $sw );
	    $ew = calculateQuarterDisplay( $ew );
	}
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
if( $peakstr["peakchart"] ) 
    {
	$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Peak Chart Position: " . $peakvalues[$search["peakchart"]], $format_bold ); 
    }
if( $search["producer"] ) { 
	$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Producer: " . $search["producer"], $format_bold ); 
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
	foreach( $pinstruments as $i )
	    {
		$sheet->write( $rownum, $colnum++, getNameById( "primaryinstrumentations", $i ) );
	    }
    }

	$rownum++; $colnum = 0;
$rownum++;

    foreach( $posstitles as $weekname )
	{
	    if( $doingyearlysearch )
		$thesesongs = $songsbyyears[$weekname];
	    else
		$thesesongs = $songsbyquarters[$weekname];
	    if( !$thesesongs ) continue;
	    $tmpsongs = array();
	    foreach( $thesesongs as $sid )
		{
		    $tmpsongs[$sid] = getSongnameFromSongid( $sid );
		}
	    sort( $tmpsongs );
	    $rownum++;
	    $colnum = 0;
	    $sheet->write( $rownum, $colnum++, $weekname, $format_bold );
	    $sheet->write( $rownum, $colnum++, count( $tmpsongs ) . " Total Song(s)", $format_bold );
	    foreach( $tmpsongs as $sid=> $songname )
		{
		    $rownum++;
		    $colnum = 0;
		    $sheet->write( $rownum, $colnum++,  $songname );
		}
	    
	    $rownum++;
	    $rownum++;
	    
	}

	$dontdo = array();
	$dontdo[] = "Songs with a Featured Artist Genre";
	$dontdo[] = "Producers";
	$dontdo[] = "Sub-Genre/Influence Count";
	$dontdo[] = "Song Title Placement";
	$dontdo[] = "First Chorus: Percent Into Song Range";
	$dontdo[] = "First Chorus: Average Percent Into Song";
	$dontdo[] = "Vocal Delivery (Chorus)";
	$dontdo[] = "Vocal Delivery (Verse)";
	$dontdo[] = "Verse Length Uniformity";
	$dontdo[] = "Pre-Chorus Count";
	$dontdo[] = "Instrumental Break Count";
	$dontdo[] = "Vocal Break Count";
	$dontdo[] = "Post-Chorus Count";
	$dontdo[] = "Pre-Chorus Length Uniformity";
	$dontdo[] = "Song Form";
	$dontdo[] = "Chorus Length Uniformity";


    $aspects = getMyPossibleSearchFunctions();
    file_put_contents( "/tmp/csvdata", "display aspects: " . print_r( $aspects, true  ) . "\n" );	    
    foreach( $aspects as $aspect=>$displayaspect )
	{
	    if( in_array( $dontdo, $aspect ) ) continue;
		if( $aspect == "Number of Songs" || $aspect == "Number of Weeks" || $aspect == "Percentage of Songs" ) continue;
		if( $displayaspect == "Song Form (Number of Songs)" ) continue;
		
		$search["comparisonaspect"] = $aspect;
		$rows = getRowsComparison( $search, $allsongs );	
		$dataforrows = getCSVTrendDataForRows( $search[comparisonaspect], $pos, $doingyearlysearch?$songsbyyears:$songsbyquarters );
		
		$lastdatatimewise = $dataforrows[end( $posstitles)];
		
		// if( $displayaspect == "Songwriter Team Size" )
		//     {
		//     file_put_contents( "/tmp/dataforrows", print_r( $dataforrows, true ) );	    
		//     file_put_contents( "/tmp/dataforrows", "CHOSE: " . end( $posstitles) . "\n", FILE_APPEND );	    
		//     file_put_contents( "/tmp/dataforrows", "BEFORE last data time: " . print_r( $lastdatatimewise, true ) . "\n", FILE_APPEND );	    
		//     file_put_contents( "/tmp/csvdata", "display aspect: " . $displayaspect . "\n", FILE_APPEND );	    
		//     file_put_contents( "/tmp/csvdata", "BEFORE rows: " . print_r( $rows, true ) . "\n", FILE_APPEND );	    
		//     file_put_contents( "/tmp/csvdata", "BEFORE last data time: " . print_r( $lastdatatimewise, true ) . "\n", FILE_APPEND );	    
		// }

	    uasort( $lastdatatimewise, "customSortLastDataCSV" );

	    uksort( $rows, "customSortCSVResults" );

	    // if( $displayaspect == "Songwriter Team Size" )
	    // 	{
	    // 	    file_put_contents( "/tmp/csvdata", "AFTER rows: " . print_r( $rows, true ) . "\n", FILE_APPEND );	    
	    // 	    file_put_contents( "/tmp/csvdata", "AFTER last data time: " . print_r( $lastdatatimewise, true ) . "\n", FILE_APPEND );	    
	    // 	    file_put_contents( "/tmp/csvdata", "data: " . print_r( $dataforrows, true ) . "\n", FILE_APPEND );	    
	    // 	}


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
		    $sheet->write( $rownum, $colnum++, $title, $format_bold );
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
			    $sheet->write( $rownum, $colnum++, $title, $format_bold );
			    
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


	    // start of IT overview
		    file_put_contents( "/tmp/touche", "\n\n ALL SONGS" . $allsongsstr, FILE_APPEND );


$timeperiod = urlencode( $rangedisplay );
$number1link = "search-results?{$urldatestr}&search[peakchart]=1";
$allsongslink = "search-results?{$urldatestr}";

function getPercent( $num, $href = "", $longformat = false )
{
    global $allsongs;
    $perc = number_format( ($num / count( $allsongs ))*100 ). "%";
    $son = $num == 1?"song":"songs";
    if( $href && 1== 0) {
	if( $longformat )
	    return " ($perc of songs, <a  href='$href'>$num</a> $son)";
	else
	    return " $perc of songs (<a  href='$href'>$num</a> $son)";
    }
    else
	{
	if( $longformat )
	    return " ($perc of songs, $num $son)";
	else
	    return " $perc of songs ($num $son)";
	}
}

function getPercentArtists( $num, $href = "", $longformat = false )
{
    global $numartistscount;
    $perc = number_format( ($num / $numartistscount)*100 ). "%";
    $son = $num == 1?"artist":"artists";
    if( $href && 1 == 0 ) {
	if( $longformat )
	    return " ($perc of artists, <a  href='$href'>$num</a> $son)";
	else
	    return " $perc of artists (<a  href='$href'>$num</a> $son)";
    }
    else
	{
	if( $longformat )
	    return " ($perc of artists, $num $son)";
	else
	    return " $perc of artists ($num $son)";
	}
}

function formQSFromArray( $key, $values )
{
    $retval = "";
    foreach( $values as $v )
	{
	    $retval .= "&{$key}=" . urlencode ( $v );
	}
    return $retval;
}

function formHref( $link, $displ )
{
    //    return "<a  href='{$link}'>$displ</a>";
    return $displ;
}

function calcmeWeek( $rows, $songstouse="" )
{
    return calcme( $rows, "", "", "week", $songstouse );
}
function calcme( $rows, $fieldname = "", $href = "", $v = "song", $songstouse  = array() )
{
    global $allsongs;

    if( !$v ) $v = "song";
    if( !count( $songstouse ) )
	$songstouse = $allsongs;
    $max = "";
    $retval = array();
    foreach( $rows as $r )
    {
        if( !$max ) $max = $r["cnt"];
        if( $r["cnt"] == $max )
	    {
		if( $href && 1 == 0  )
		    {
			$retval[] = "<a  href='{$href}&search[$fieldname]={$r[Name]}'>$r[Name]</a>";
		    }
		else
		    {
			$retval[] = $r[Name];
		    }
	    }
    }
    $perc = number_format( ($max / count( $songstouse ))*100 ). "%";
    $pluralv = $v . ( $max > 1 ?"s":"" );
    $each = count( $retval ) > 1?" each":"";
    if( $v == "song" )		// 
        return array( $max,  implode( ", ", $retval ), " ($perc of {$v}s, $max $pluralv{$each})" );
    else
        return array( $max,  implode( ", ", $retval ), " ($max $pluralv{$each})" );
}

list( $artistmax, $artistmosthits, $extraartist )  = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsstr ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'primary' )  group by artists.Name order by cnt desc " ), "primaryartistprimary", $allsongslink );
list( $groupmax, $groupmosthits, $extragroup )  = calcme( db_query_rows( "select groups.Name, count(*) as cnt from songs, groups, song_to_group where songs.id in ( $allsongsstr ) and songs.id = songid and groups.id = groupid and song_to_group.type in ( 'primary' )  group by groups.Name order by cnt desc " ), "primaryartistprimary", $allsongslink );

if( $groupmax > $artistmax )
{
    $artistmosthits = $groupmosthits;
    $artistmosthits .= $extragroup;
}
else if( $groupmax == $artistmax )
{
    $artistmosthits .= ", ". $groupmosthits;
    $artistmosthits .= $extragroup;
}
else
{
    $artistmosthits .= $extraartist;
}


list( $artistmaxhip, $artistmosthitship, $extraartisthip )  = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsstr ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'primary' ) and GenreID = 2  group by artists.Name order by cnt desc " ), "primaryartistprimary", $allsongslink, "", $allsongshiphop  );
list( $groupmaxhip, $groupmosthitship, $extragrouphip )  = calcme( db_query_rows( "select groups.Name, count(*) as cnt from songs, groups, song_to_group where songs.id in ( $allsongsstr ) and songs.id = songid and groups.id = groupid and song_to_group.type in ( 'primary' )  and GenreID = 2 group by groups.Name order by cnt desc " ), "primaryartistprimary", $allsongslink, "", $allsongshiphop );

if( $groupmaxhip > $artistmaxhip )
{
    $artistmosthitship = $groupmosthitship;
    $artistmosthitship .= $extragrouphip;
}
else if( $groupmaxhip == $artistmaxhip )
{
    $artistmosthitship .= ", ". $groupmosthitship;
    $artistmosthitship .= $extragrouphip;
}
else
{
    $artistmosthitship .= $extraartisthip;
}

list( $artistmaxnonhip, $artistmosthitsnonhip, $extraartistnonhip )  = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsstr ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'primary' ) and GenreID = 2  group by artists.Name order by cnt desc " ), "primaryartistprimary", $allsongslink, "", $allsongsnonhiphop  );
list( $groupmaxnonhip, $groupmosthitsnonhip, $extragroupnonhip )  = calcme( db_query_rows( "select groups.Name, count(*) as cnt from songs, groups, song_to_group where songs.id in ( $allsongsstr ) and songs.id = songid and groups.id = groupid and song_to_group.type in ( 'primary' )  and GenreID <> 2 group by groups.Name order by cnt desc " ), "primaryartistprimary", $allsongslink, "", $allsongsnonhiphop );

if( $groupmaxnonhip > $artistmaxnonhip )
{
    $artistmosthitsnonhip = $groupmosthitsnonhip;
    $artistmosthitsnonhip .= $extragroupnonhip;
}
else if( $groupmaxnonhip == $artistmaxnonhip )
{
    $artistmosthitsnonhip .= ", ". $groupmosthitsnonhip;
    $artistmosthitsnonhip .= $extragroupnonhip;
}
else
{
    $artistmosthitsnonhip .= $extraartistnonhip;
}




// echo( "number: " . $allsongsnumber1str );
// print_r( $allsongsnumber1 );
list( $artistmaxno1, $artistmosthitsno1, $extraartistno1 )  = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsnumber1str ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'primary' )  group by artists.Name order by cnt desc " ), "primaryartist", $number1link );
list( $groupmaxno1, $groupmosthitsno1, $extragroupno1 )  = calcme( db_query_rows( "select groups.Name, count(*) as cnt from songs, groups, song_to_group where songs.id in ( $allsongsnumber1str ) and songs.id = songid and groups.id = groupid and song_to_group.type in ( 'primary' )  group by groups.Name order by cnt desc " ), "primaryartist", $number1link );

if( $groupmaxno1 > $artistmaxno1 )
{
    $artistmosthitsno1 = $groupmosthitsno1;
    $artistmosthitsno1 .= $extragroupno1;
}
else if( $groupmaxno1 == $artistmaxno1 )
{
    $artistmosthitsno1 .= ", ". $groupmosthitsno1;
    $artistmosthitsno1 .= $extragroupno1;
}
else
{
    $artistmosthitsno1 .= $extraartistno1;
}

list( $artistmax, $artistlongestweeks, $extraartist ) = calcmeWeek( db_query_rows( "select artists.Name, count(distinct( weekdateid)) as cnt from artists, song_to_artist, song_to_weekdate where song_to_artist.songid = song_to_weekdate.songid and artists.id = artistid and song_to_artist.type in ( 'primary' ) and weekdateid in ( $weekdatesstr ) group by artists.Name order by cnt desc " ) );
list( $groupmax, $grouplongestweeks, $extragroup ) = calcmeWeek( db_query_rows( "select groups.Name, count(distinct( weekdateid)) as cnt from groups, song_to_group, song_to_weekdate where song_to_group.songid = song_to_weekdate.songid and groups.id = groupid and song_to_group.type in ( 'primary' ) and weekdateid in ( $weekdatesstr ) group by groups.Name order by cnt desc " ) );

// $numfeatartists = db_query_first_cell( "select count(distinct( artistid ) ) from song_to_artist where songid in ( $allsongsstr ) and type in ( 'featured' )" );
// $numfeatartists += db_query_first_cell( "select count(distinct( groupid ) ) from song_to_group where songid in ( $allsongsstr )  and type in ( 'featured' )" );

// $numprimartists = db_query_first_cell( "select count(distinct( artistid ) ) from song_to_artist where songid in ( $allsongsstr ) and type in ( 'primary' )" );
// $numprimartists += db_query_first_cell( "select count(distinct( groupid ) ) from song_to_group where songid in ( $allsongsstr )  and type in ( 'primary' )" );

// start num artists
$numartistsarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsstr ) and type in ( 'featured', 'primary' )", "artistid", "artistid" );
$numgroupsarr = db_query_array( "select distinct( groupid ) from song_to_group where songid in ( $allsongsstr )  and type in ( 'featured', 'primary' )", "groupid", "groupid" );

$link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "a[]", $numartistsarr ) . "&" . formQSFromArray( "g[]", $numgroupsarr );
$numartistsarr = array_merge( $numartistsarr, $numgroupsarr );
$numartistscount = count( $numartistsarr );
$numartists = formHref( $link, $numartistscount );

$num1artistsarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsnumber1str ) and type in ( 'featured', 'primary' )", "artistid", "artistid" );
$num1groupsarr = db_query_array( "select distinct( groupid ) from song_to_group where songid in ( $allsongsnumber1str )  and type in ( 'featured', 'primary' )", "groupid", "groupid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "a[]", $num1artistsarr ) . "&" . formQSFromArray( "g[]", $num1groupsarr );
$num1artistsarr = array_merge( $num1artistsarr, $num1groupsarr );
$num1artistscount = count( $num1artistsarr );
$num1artists = formHref( $link, $num1artistscount ) ;

// end num artists

// start num feat artists
$numartistsarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsstr )  and type in ( 'featured' )", "artistid", "artistid" );
$numgroupsarr = db_query_array( "select distinct( groupid ) from song_to_group where songid in ( $allsongsstr )  and type in ( 'featured' )", "groupid", "groupid" );

$link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "a[]", $numartistsarr ) . "&" . formQSFromArray( "g[]", $numgroupsarr );
$numartistsarr = array_merge( $numartistsarr, $numgroupsarr );
$numfeatartists = count( $numartistsarr );
$numfeatartists = formHref( $link, $numfeatartists );

$num1artistsarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsnumber1str )  and type in ( 'featured' )", "artistid", "artistid" );
$num1groupsarr = db_query_array( "select distinct( groupid ) from song_to_group where songid in ( $allsongsnumber1str )  and type in ( 'featured' )", "groupid", "groupid" );

$link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "a[]", $num1artistsarr ) . "&" . formQSFromArray( "g[]", $num1groupsarr );
$num1artistsarr = array_merge( $num1artistsarr, $num1groupsarr );
$num1featartists = count( $num1artistsarr );
$num1featartists = formHref( $link, $num1featartists );

// end num feat artists

// start num prim artists
$numartistsarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsstr )  and type in ( 'primary' )", "artistid", "artistid" );
$numgroupsarr = db_query_array( "select distinct( groupid ) from song_to_group where songid in ( $allsongsstr )  and type in ( 'primary' )", "groupid", "groupid" );

$link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "a[]", $numartistsarr ) . "&" . formQSFromArray( "g[]", $numgroupsarr );
$numartistsarr = array_merge( $numartistsarr, $numgroupsarr );
$numprimartists = count( $numartistsarr );
$numprimartists = formHref( $link, $numprimartists );

$num1artistsarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsnumber1str )  and type in ( 'primary' )", "artistid", "artistid" );
$num1groupsarr = db_query_array( "select distinct( groupid ) from song_to_group where songid in ( $allsongsnumber1str )  and type in ( 'primary' )", "groupid", "groupid" );

$link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "a[]", $num1artistsarr ) . "&" . formQSFromArray( "g[]", $num1groupsarr );
$num1artistsarr = array_merge( $num1artistsarr, $num1groupsarr );
$num1primartists = count( $num1artistsarr );
$num1primartists = formHref( $link, $num1primartists );

// end num prim artists


if( $groupmax > $artistmax )
{
    $artistlongestweeks = $grouplongestweeks;
    $artistlongestweeks .= $extragroup;
}
else if( $groupmax == $artistmax )
{
    $artistlongestweeks .= ", " . $grouplongestweeks;
    $artistlongestweeks .= $extragroup;
}
else
{
    $artistlongestweeks .= $extraartist;
}


list( $artistmaxno1, $artistlongestweeksno1, $extraartistno1 ) = calcmeWeek( db_query_rows( "select artists.Name, count(distinct( weekdateid)) as cnt from artists, song_to_artist, song_to_weekdate where song_to_artist.songid = song_to_weekdate.songid and artists.id = artistid and song_to_artist.type in ( 'primary' ) and song_to_weekdate.type = 'position1'  and weekdateid in ( $weekdatesstr ) group by artists.Name order by cnt desc " ) );

list( $groupmaxno1, $grouplongestweeksno1, $extragroupno1 ) = calcmeWeek( db_query_rows( "select groups.Name, count(distinct( weekdateid)) as cnt from groups, song_to_group, song_to_weekdate where song_to_group.songid  = song_to_weekdate.songid and groups.id = groupid and song_to_group.type in ( 'primary' )  and song_to_weekdate.type = 'position1' and weekdateid in ( $weekdatesstr ) group by groups.Name order by cnt desc " ) );

if( $groupmaxno1 > $artistmaxno1 )
{
    $artistlongestweeksno1 = $grouplongestweeksno1;
    $artistlongestweeksno1 .= $extragroupno1;
}
else if( $groupmaxno1 == $artistmaxno1 )
{
    $artistlongestweeksno1 .= ", " . $grouplongestweeksno1;
    $artistlongestweeksno1 .= $extragroupno1;
}
else
{
    $artistlongestweeksno1 .= $extraartistno1;
}


// begin featured artists

list( $featartistmax, $featartistmosthits, $featextraartist )  = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsstr ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'featured' )  group by artists.Name order by cnt desc " ), "primaryartistfeatured", $allsongslink );
list( $featgroupmax, $featgroupmosthits, $featextragroup )  = calcme( db_query_rows( "select groups.Name, count(*) as cnt from songs, groups, song_to_group where songs.id in ( $allsongsstr ) and songs.id = songid and groups.id = groupid and song_to_group.type in ( 'featured' )  group by groups.Name order by cnt desc " ), "primaryartistfeatured", $allsongslink );

if( $featgroupmax > $featartistmax )
{
    $featartistmosthits = $featgroupmosthits;
    $featartistmosthits .= $featextragroup;
}
else if( $featgroupmax == $featartistmax )
{
    $featartistmosthits .= ", ". $featgroupmosthits;
    $featartistmosthits .= $featextragroup;
}
else
{
    $featartistmosthits .= $featextraartist;
}

list( $featartistmaxno1, $featartistmosthitsno1, $featextraartistno1 )  = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsnumber1str ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'featured' )  group by artists.Name order by cnt desc " ), "primaryartistfeatured", $number1link );
list( $featgroupmaxno1, $featgroupmosthitsno1, $featextragroupno1 )  = calcme( db_query_rows( "select groups.Name, count(*) as cnt from songs, groups, song_to_group where songs.id in ( $allsongsnumber1str ) and songs.id = songid and groups.id = groupid and song_to_group.type in ( 'featured' )  group by groups.Name order by cnt desc " ), "primaryartistfeatured", $number1link );

if( $featgroupmaxno1 > $featartistmaxno1 )
{
    $featartistmosthitsno1 = $featgroupmosthitsno1;
    $featartistmosthitsno1 .= $featextragroupno1;
}
else if( $featgroupmaxno1 == $featartistmaxno1 )
{
    $featartistmosthitsno1 .= ", ". $featgroupmosthitsno1;
    $featartistmosthitsno1 .= $featextragroupno1;
}
else
{
    $featartistmosthitsno1 .= $featextraartistno1;
}



list( $featartistmax, $featartistlongestweeks, $featextraartist ) = calcmeWeek( db_query_rows( "select artists.Name, count(distinct( weekdateid)) as cnt from artists, song_to_artist, song_to_weekdate where song_to_artist.songid = song_to_weekdate.songid and artists.id = artistid and song_to_artist.type in ( 'featured' ) and weekdateid in ( $weekdatesstr ) group by artists.Name order by cnt desc " ) );
list( $featgroupmax, $featgrouplongestweeks, $featextragroup ) = calcmeWeek( db_query_rows( "select groups.Name, count(distinct( weekdateid)) as cnt from groups, song_to_group, song_to_weekdate where song_to_group.songid = song_to_weekdate.songid and groups.id = groupid and song_to_group.type in ( 'featured' ) and weekdateid in ( $weekdatesstr ) group by groups.Name order by cnt desc " ) );

if( $featgroupmax > $featartistmax )
{
    $featartistlongestweeks = $featgrouplongestweeks;
    $featartistlongestweeks .= $featextragroup;
}
else if( $featgroupmax == $featartistmax )
{
    $featartistlongestweeks .= ", " . $featgrouplongestweeks;
    $featartistlongestweeks .= $featextragroup;
}
else
{
    $featartistlongestweeks .= $featextraartist;
}

list( $featartistmaxno1, $featartistlongestweeksno1, $featextraartistno1 ) = calcmeWeek( db_query_rows( "select artists.Name, count(distinct( weekdateid)) as cnt from artists, song_to_artist, song_to_weekdate where song_to_artist.songid = song_to_weekdate.songid and artists.id = artistid and song_to_artist.type in ( 'featured' ) and weekdateid in ( $weekdatesstr ) and song_to_weekdate.type = 'position1' group by artists.Name order by cnt desc " ) );
list( $featgroupmaxno1, $featgrouplongestweeksno1, $featextragroupno1 ) = calcmeWeek( db_query_rows( "select groups.Name, count(distinct( weekdateid)) as cnt from groups, song_to_group, song_to_weekdate where song_to_group.songid = song_to_weekdate.songid and groups.id = groupid and song_to_group.type in ( 'featured' ) and weekdateid in ( $weekdatesstr ) and song_to_weekdate.type = 'position1' group by groups.Name order by cnt desc " ) );

if( $featgroupmaxno1 > $featartistmaxno1 )
{
    $featartistlongestweeksno1 = $featgrouplongestweeksno1;
    $featartistlongestweeksno1 .= $featextragroupno1;
}
else if( $featgroupmaxno1 == $featartistmaxno1 )
{
    $featartistlongestweeksno1 .= ", " . $featgrouplongestweeksno1;
    $featartistlongestweeksno1 .= $featextragroupno1;
}
else
{
    $featartistlongestweeksno1 .= $featextraartistno1;
}




// end featured
list( $swcountmax, $songwritercountmosthits, $extraswcount ) = calcme( db_query_rows( "select case when SongwriterCount >= 5 then '5+' else SongwriterCount end as Name, count(*) as cnt from songs where songs.id in ( $allsongsstr ) group by Name order by cnt desc " ), "SongwriterCount", $allsongslink) ;
$songwritercountmosthits .= $extraswcount;


list( $swmax, $songwritermosthits, $extrasw ) = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsstr ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'creditedsw' )  group by artists.Name order by cnt desc " ), "writer", $allsongslink) ;
$songwritermosthits .= $extrasw;

list( $swmaxnonhip, $songwritermosthitsnonhip, $extrasw ) = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsstr ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'creditedsw' ) and GenreID <> 2 group by artists.Name order by cnt desc " ), "writer", $allsongslink, "", $allsongsnonhiphop ) ;
$songwritermosthitsnonhip .= $extrasw;

list( $swmaxhip, $songwritermosthitship, $extrasw ) = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsstr ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'creditedsw' ) and GenreID = 2 group by artists.Name order by cnt desc " ), "writer", $allsongslink, "", $allsongshiphop) ;
$songwritermosthitship .= $extrasw;




list( $artistmax, $songwriterlongestweeks, $extrasw ) = calcmeWeek( db_query_rows( "select artists.Name, count(distinct( weekdateid) ) as cnt from artists, song_to_artist, song_to_weekdate where song_to_artist.songid = song_to_weekdate.songid and artists.id = artistid and song_to_artist.type in ( 'creditedsw' ) and weekdateid in ( $weekdatesstr ) group by artists.Name order by cnt desc " ) );
$songwriterlongestweeks .= $extrasw;

list( $swmaxno1, $songwritermosthitsno1, $extraswno1 ) = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsnumber1str ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'creditedsw' )  group by artists.Name order by cnt desc " ), "writer", $number1link ) ;
$songwritermosthitsno1 .= $extraswno1;
list( $artistmaxno1, $songwriterlongestweeksno1, $extraswno1 ) = calcmeWeek( db_query_rows( "select artists.Name, count(distinct( weekdateid) ) as cnt from artists, song_to_artist, song_to_weekdate where song_to_artist.songid = song_to_weekdate.songid and artists.id = artistid and song_to_artist.type in ( 'creditedsw' ) and weekdateid in ( $weekdatesstr )  and song_to_weekdate.type = 'position1' group by artists.Name order by cnt desc " ) );
$songwriterlongestweeksno1 .= $extraswno1;

$numsongwritersarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsstr ) and type in ( 'creditedsw' )", "artistid", "artistid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=songwriters&" . formQSFromArray( "a[]", $numsongwritersarr );
$numsongwriters = count( $numsongwritersarr );
$numsongwriters = formHref( $link, $numsongwriters );

$num1songwritersarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsnumber1str ) and type in ( 'creditedsw' )", "artistid", "artistid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=songwriters&" . formQSFromArray( "a[]", $num1songwritersarr );
$num1songwriters = count( $num1songwritersarr );
$num1songwriters = formHref( $link, $num1songwriters );



list( $labelmax, $labelmosthits, $extralabel ) = calcme( db_query_rows( "select labels.Name, count(*) as cnt from songs, labels, song_to_label where songs.id in ( $allsongsstr ) and songs.id = songid and labels.id = labelid  group by labels.Name order by cnt desc " ) , "label", $allsongslink) ;
$labelmosthits .= $extralabel;

list( $labelmaxhip, $labelmosthitship, $extralabel ) = calcme( db_query_rows( "select labels.Name, count(*) as cnt from songs, labels, song_to_label where songs.id in ( $allsongsstr ) and songs.id = songid and labels.id = labelid and GenreID = 2 group by labels.Name order by cnt desc " ) , "label", $allsongslink, "", $allsongshiphop) ;
$labelmosthitship .= $extralabel;

list( $labelmaxnonhip, $labelmosthitsnonhip, $extralabel ) = calcme( db_query_rows( "select labels.Name, count(*) as cnt from songs, labels, song_to_label where songs.id in ( $allsongsstr ) and songs.id = songid and labels.id = labelid and GenreID <> 2 group by labels.Name order by cnt desc " ) , "label", $allsongslink, "", $allsongsnonhiphop ) ;
$labelmosthitsnonhip .= $extralabel;



list( $labelmax, $labellongestweeks, $extralabel ) = calcmeWeek( db_query_rows( "select labels.Name, count(distinct(weekdateid)) as cnt from labels, song_to_label, song_to_weekdate where song_to_label.songid = song_to_weekdate.songid and labels.id = labelid and weekdateid in ( $weekdatesstr ) group by labels.Name order by cnt desc " ) );
//echo( "select labels.Name, count(distinct(weekdateid)) as cnt from songs, labels, song_to_label, song_to_weekdate where songs.id in ( $allsongsstr ) and songs.id = song_to_label.songid and songs.id = song_to_weekdate.songid and labels.id = labelid and weekdateid in ( $weekdatesstr ) group by labels.Name order by cnt desc " );
$labellongestweeks .= $extralabel;


list( $labelmaxno1, $labelmosthitsno1, $extralabelno1 ) = calcme( db_query_rows( "select labels.Name, count(*) as cnt from songs, labels, song_to_label where songs.id in ( $allsongsnumber1str ) and songs.id = songid and labels.id = labelid  group by labels.Name order by cnt desc " )  , "label", $number1link ) ;
$labelmosthitsno1 .= $extralabelno1;
list( $labelmaxno1, $labellongestweeksno1, $extralabelno1 ) = calcmeWeek( db_query_rows( "select labels.Name, count(distinct(weekdateid)) as cnt from labels, song_to_label, song_to_weekdate where song_to_label.songid = song_to_weekdate.songid and labels.id = labelid and weekdateid in ( $weekdatesstr )  and song_to_weekdate.type = 'position1' group by labels.Name order by cnt desc " ) );
//echo( "select labels.Name, count(distinct(weekdateid)) as cnt from songs, labels, song_to_label, song_to_weekdate where songs.id in ( $allsongsstr ) and songs.id = song_to_label.songid and songs.id = song_to_weekdate.songid and labels.id = labelid and weekdateid in ( $weekdatesstr ) group by labels.Name order by cnt desc " );
$labellongestweeksno1 .= $extralabelno1;

$numlabelsarr = db_query_array( "select distinct( labelid ) from song_to_label where songid in ( $allsongsstr ) ", "labelid", "labelid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=labels&" . formQSFromArray( "labels[]", $numlabelsarr );
$numlabels = count( $numlabelsarr );
$numlabels = formHref( $link, $numlabels );

$num1labelsarr = db_query_array( "select distinct( labelid ) from song_to_label where songid in ( $allsongsnumber1str ) ", "labelid", "labelid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=labels&" . formQSFromArray( "labels[]", $num1labelsarr );
$num1labels = count( $num1labelsarr );
$num1labels = formHref( $link, $num1labels );

list( $producermax, $producermosthits, $extraproducer ) = calcme( db_query_rows( "select producers.Name, count(*) as cnt from songs, producers, song_to_producer where songs.id in ( $allsongsstr ) and songs.id = songid and producers.id = producerid  group by producers.Name order by cnt desc " ) , "producer", $allsongslink );
$producermosthits .= $extraproducer;


list( $producermaxhip, $producermosthitship, $extraproducer ) = calcme( db_query_rows( "select producers.Name, count(*) as cnt from songs, producers, song_to_producer where songs.id in ( $allsongsstr ) and songs.id = songid and producers.id = producerid and GenreID = 2 group by producers.Name order by cnt desc " ) , "producer", $allsongslink, "", $allsongshiphop );
$producermosthitship .= $extraproducer;

list( $producermaxnonhip, $producermosthitsnonhip, $extraproducer ) = calcme( db_query_rows( "select producers.Name, count(*) as cnt from songs, producers, song_to_producer where songs.id in ( $allsongsstr ) and songs.id = songid and producers.id = producerid and GenreID <> 2 group by producers.Name order by cnt desc " ) , "producer", $allsongslink , "", $allsongsnonhiphop );
$producermosthitsnonhip .= $extraproducer;



list( $producermax, $producerlongestweeks, $extraproducer ) = calcmeWeek( db_query_rows( "select producers.Name, count(distinct( weekdateid)) as cnt from producers, song_to_producer, song_to_weekdate where song_to_producer.songid = song_to_weekdate.songid and producers.id = producerid and weekdateid in ( $weekdatesstr ) group by producers.Name order by cnt desc " ) );
$producerlongestweeks .= $extraproducer;

list( $producermaxno1, $producermosthitsno1, $extraproducerno1 ) = calcme( db_query_rows( "select producers.Name, count(*) as cnt from songs, producers, song_to_producer where songs.id in ( $allsongsnumber1str ) and songs.id = songid and producers.id = producerid  group by producers.Name order by cnt desc " ) , "producer", $number1link );
$producermosthitsno1 .= $extraproducerno1;
$tmparr = db_query_rows( "select producers.Name, producers.id, count(distinct( weekdateid)) as cnt from producers, song_to_producer, song_to_weekdate where song_to_producer.songid = song_to_weekdate.songid and producers.id = producerid and weekdateid in ( $weekdatesstr ) and song_to_weekdate.type = 'position1' group by producers.Name, producers.id order by cnt desc " );
list( $producermaxno1, $producerlongestweeksno1, $extraproducerno1 ) = calcmeWeek( $tmparr );
$producerlongestweeksno1 .= $extraproducerno1;

$numproducersarr = db_query_array( "select distinct( producerid ) from song_to_producer where songid in ( $allsongsstr )", "producerid", "producerid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=producers&" . formQSFromArray( "producers[]", $numproducersarr );
$numproducers = count( $numproducersarr );
$numproducers = formHref( $link, $numproducers );

$num1producersarr = db_query_array( "select distinct( producerid ) from song_to_producer where songid in ( $allsongsnumber1str )", "producerid", "producerid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=producers&" . formQSFromArray( "producers[]", $num1producersarr );
$num1producers = count( $num1producersarr );
$num1producers = formHref( $link, $num1producers );



list( $genremax, $mostgenre, $extragenre ) = calcme( db_query_rows( "select genres.Name, count(*) as cnt from songs, genres where songs.id in ( $allsongsstr ) and genres.id = GenreID group by genres.Name order by cnt desc " ) , "GenreName", $allsongslink );
$mostgenre .= $extragenre;


// $mostgender = db_query_first( "select VocalsGender, count(*) as cnt from songs where songs.id in ( $allsongsstr ) group by VocalsGender order by cnt desc limit 1" );
// $gen = $mostgender[VocalsGender];
// if( $gen == "Solo Male" )
//     $gen = "Exclusively Male";
// if( $gen == "Solo Female" )
//     $gen = "Exclusively Female";
// $most
$currperc = 0;
$gen = "";
$gennum = "";
$genderdisplay = "";
foreach( array( "Male", "Female" ) as $poss )
{
	$thisgender = db_query_first_cell( "select count(*) as cnt from songs where songs.id in ( $allsongsstr ) and (VocalsGender like '%All $poss%' or VocalsGender = 'Solo $poss' ) " );
//	echo( "select count(*) as cnt from songs where songs.id in ( $allsongsstr ) and (VocalsGender like '%All $poss%' or VocalsGender = 'Solo $poss' )<br> " );
	if( $thisgender >= $currperc )
	    {
		$gen = "Exclusively $poss";
		$gennum = $thisgender;
		$currperc = $gennum;
		$genderdisplay = $poss;
	    }
}
$mostgender = "<a  href='" . $allsongslink . "&search[vocalsgenderspecific]={$genderdisplay}" . "'>$gen</a>" . getPercent( $gennum, "", true );




$mostsubgenre = db_query_first( "select subgenres.Name, subgenres.id, count(*) as cnt from songs, subgenres, song_to_subgenre where songs.id in ( $allsongsstr ) and songs.id = songid and subgenres.id = subgenreid group by subgenres.Name, subgenres.id order by cnt desc limit 1" );
$mostsubgenre = "<a  href='" . $allsongslink . "&search[specificsubgenre]=$mostsubgenre[id]'>".  $mostsubgenre[Name] . "</a>" . getPercent( $mostsubgenre[cnt], "", true );
$featuredartist = db_query_array( "select SongNameHard as Name from songs, song_to_artist where songs.id in ( $allsongsstr ) and songs.id = songid and song_to_artist.type in ( 'featured' ) ", "Name", "Name" ); ;
$featuredgroup = db_query_array( "select SongNameHard as Name from songs, song_to_group where songs.id in ( $allsongsstr ) and songs.id = songid and song_to_group.type in ( 'featured' ) ", "Name", "Name" );
$featuredartist = array_merge( $featuredgroup, $featuredartist );

$featuredartist = count( $featuredartist );
$featuredartist = getPercent( $featuredartist, $allsongslink . "&search[mainartisttype]=featured" );

$numsolo = db_query_array( "select SongNameHard as Name from songs where songs.id in ( $allsongsstr ) and ArtistCount = 1 order by Name", "Name", "Name" );
$numsolo = count( $numsolo );
$numsolo = getPercent( $numsolo, $allsongslink . "&search[mainartisttype]=single" );
$numduet = db_query_array( "select SongNameHard as Name from songs where songs.id in ( $allsongsstr ) and ArtistCount > 1 order by Name", "Name", "Name" );
$numduet = count( $numduet );

$numduet = getPercent( $numduet, $allsongslink . "&search[mainartisttype]=multiple" );


$numproducersarr = db_query_array( "select distinct( producerid ) from song_to_producer where songid in ( $allsongsstr )", "producerid", "producerid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=producers&" . formQSFromArray( "producers[]", $numproducersarr );
$numproducers = count( $numproducersarr );
$numproducers = formHref( $link, $numproducers );

$num1producersarr = db_query_array( "select distinct( producerid ) from song_to_producer where songid in ( $allsongsnumber1str )", "producerid", "producerid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=producers&" . formQSFromArray( "producers[]", $num1producersarr );
$num1producers = count( $num1producersarr );
$num1producers = formHref( $link, $num1producers );


$numnewarrivals = count( $newarrivals );
$link = "search-results?{$urldatestr}&search[toptentype]=New+Songs";
$numnewarrivals = formHref( $link, $numnewarrivals );
$numsongsnumber1 = count( $allsongsnumber1 );
$numsongsnumber1 = formHref( $number1link, $numsongsnumber1 );
$numsongs = count( $allsongs );
$numsongs = formHref( $allsongslink, $numsongs );


$artistalsoproducer = "";
$artistalsosong = "";





$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Songs ", $format_bold );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Number of Top 10 Songs: " );
$sheet->write( $rownum, $colnum++, "$numsongs" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Number of #1 Songs: " );
$sheet->write( $rownum, $colnum++, "$numsongsnumber1" );


$colnum = 0; 
$rownum++;
$num1songsnames = implode( ", ", db_query_array( "select SongNameHard from songs where id in ( " . implode( ", " , $allsongsnumber1 ) . " )", "SongNameHard", "SongNameHard" ) );
$sheet->write( $rownum, $colnum++, "List of #1 Hits: " );
$sheet->write( $rownum, $colnum++, "$num1songsnames" );

if( !$doingweeklysearch && !$doingyearlysearch && 1 == 0 ) {  // this doesn't make sense 
$colnum = 0; 
$rownum++;
    $sheet->write( $rownum, $colnum++, "Number of New Songs: " );
    $sheet->write( $rownum, $colnum++, "$numnewarrivals" );

    
}
$colnum = 0; 
$rownum++;
$rownum++;

$sheet->write( $rownum, $colnum++, "Artists ", $format_bold );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Number of Credited Performing Artists (Primary & Featured): " );
$sheet->write( $rownum, $colnum++, "$numartists" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Number of Credited Performing Artists (Primary & Featured) with #1 Hits: " );
$sheet->write( $rownum, $colnum++, "$num1artists" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Number of Credited Primary Artists: " );
$sheet->write( $rownum, $colnum++, "$numprimartists" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Number of Credited Primary Artists with #1 Hits: " );
$sheet->write( $rownum, $colnum++, "$num1primartists" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Number of Credited Featured Artists: " );
$sheet->write( $rownum, $colnum++, "$numfeatartists" );

$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Number of Credited Featured Artists with #1 Hits: " );
$sheet->write( $rownum, $colnum++, "$num1featartists" );

$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Artist/Group with the most Top 10 Songs (excludes featured artists): " );
$sheet->write( $rownum, $colnum++, "$artistmosthits" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Artist/Group with the most weeks in the Top 10 (excludes featured artists): " );
$sheet->write( $rownum, $colnum++, "$artistlongestweeks" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Artist/Group with the most #1 Songs (excludes featured artists): " );
$sheet->write( $rownum, $colnum++, "$artistmosthitsno1" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Artist/Group with the most weeks at #1 (excludes featured artists): " );
$sheet->write( $rownum, $colnum++, "$artistlongestweeksno1" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Artist/Group with the most songs outside of Hip Hop: " );
$sheet->write( $rownum, $colnum++, "$artistmosthitsnonhip" );
$colnum = 0; 
$rownum++;
//        
$sheet->write( $rownum, $colnum++, "Artist/Group with the most songs in Hip Hop: " );
$sheet->write( $rownum, $colnum++, "$artistmosthitship" );
$colnum = 0; 
$rownum++;
        


$rownum++;
$sheet->write( $rownum, $colnum++, "Songwriters ", $format_bold );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Number of Credited Songwriters: " );
$sheet->write( $rownum, $colnum++, "$numsongwriters" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Number of Credited Songwriters with #1 Hits: " );
$sheet->write( $rownum, $colnum++, "$num1songwriters" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Songwriter with the most Top 10 Songs: " );
$sheet->write( $rownum, $colnum++, "$songwritermosthits" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Songwriter with the most weeks in the Top 10: " );
$sheet->write( $rownum, $colnum++, "$songwriterlongestweeks" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Songwriter with the most #1 Songs: " );
$sheet->write( $rownum, $colnum++, "$songwritermosthitsno1" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Songwriter with the most weeks at #1: " );
$sheet->write( $rownum, $colnum++, "$songwriterlongestweeksno1" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Songwriter with the most songs outside of Hip Hop: " );
$sheet->write( $rownum, $colnum++, "$songwritermosthitsnonhip" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Songwriter with the most songs in Hip Hop: " );
$sheet->write( $rownum, $colnum++, "$songwritermosthitship" );
$colnum = 0; 
$rownum++;






$rownum++;
$sheet->write( $rownum, $colnum++, "Producers ", $format_bold );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Number of Credited Producers: " );
$sheet->write( $rownum, $colnum++, "$numproducers" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Number of Credited Producers with #1 Hits: " );
$sheet->write( $rownum, $colnum++, "$num1producers" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Producer with the most Top 10 Songs: " );
$sheet->write( $rownum, $colnum++, "$producermosthits" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Producer with the most weeks in the Top 10: " );
$sheet->write( $rownum, $colnum++, "$producerlongestweeks" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Producer with the most #1 Songs: " );
$sheet->write( $rownum, $colnum++, "$producermosthitsno1" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Producer with the most weeks at #1: " );
$sheet->write( $rownum, $colnum++, "$producerlongestweeksno1" );

$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Producer with the most Top 10 Songs outside of Hip Hop: " );
$sheet->write( $rownum, $colnum++, "$producermosthitsnonhip" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Producer with the most Top 10 Songs in Hip Hop: " );
$sheet->write( $rownum, $colnum++, "$producermosthitship" );
$colnum = 0; 
$rownum++;


$rownum++;
$sheet->write( $rownum, $colnum++, "Record Labels ", $format_bold );
$colnum = 0; 
$rownum++;
$sheet->write( $rownum, $colnum++, "Number of Credited Record Labels: " );
$sheet->write( $rownum, $colnum++, "$numlabels" );
$colnum = 0; 
$rownum++;
$sheet->write( $rownum, $colnum++, "Number of Credited Record Labels with #1 Hits: " );
$sheet->write( $rownum, $colnum++, "$num1labels" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Record Label with the most top 10 Songs: " );
$sheet->write( $rownum, $colnum++, "$labelmosthits" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Record Label with the most weeks in the Top 10: " );
$sheet->write( $rownum, $colnum++, "$labellongestweeks" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Record Label with the most #1 Songs: " );
$sheet->write( $rownum, $colnum++, "$labelmosthitsno1" );
$colnum = 0; 
$rownum++;

$sheet->write( $rownum, $colnum++, "Record Label with the most weeks at #1: " );
$sheet->write( $rownum, $colnum++, "$labellongestweeksno1" );


$colnum = 0; 
$rownum++;
$sheet->write( $rownum, $colnum++, "Record Label with the most top 10 Songs outside of Hip Hop: " );
$sheet->write( $rownum, $colnum++, "$labelmosthitsnonhip" );

$colnum = 0; 
$rownum++;
$sheet->write( $rownum, $colnum++, "Record Label with the most top 10 Songs in Hip Hop: " );
$sheet->write( $rownum, $colnum++, "$labelmosthitship" );

	    // end of IT overview



    $xls->close();
    exit;
}

?>
