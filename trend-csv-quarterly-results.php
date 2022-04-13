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
//echo( $globalseasonstr );exit;

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


    
    $songsbyquarters = array();
    $songsbyyears = array();
    foreach( $allsongs as $a )
	{
	    $quarternumbers = db_query_array( "select distinct( QuarterNumber ), realdate from song_to_weekdate, weekdates where weekdates.id = weekdateid and OrderBy >= $firstweekdateid and OrderBy <= $lastweekdateid and  songid = $a $globalseasonstr ", "QuarterNumber", "realdate" ); 
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
if( $peakvalues["peakchart"] ) 
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
	$sheet->write( $rownum, $colnum++, "Genre/Influence: " . getNameById( "subgenres", $search["specificsubgenre"] ) , $format_bold ); 
    }

if( count( $influences ) )
    {
	$rownum++; $colnum = 0;
	$sheet->write( $rownum, $colnum++, "Genre/Influence(s): ", $format_bold );
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


    $aspects = getMyPossibleSearchFunctions();
    file_put_contents( "/tmp/csvdata", "display aspects: " . print_r( $aspects, true  ) . "\n" );	    
    foreach( $aspects as $aspect=>$displayaspect )
	{
	    if( $aspect == "Number of Songs" || $aspect == "Number of Weeks" || $aspect == "Percentage of Songs" ) continue;
	    if( $displayaspect == "Song Form (Number of Songs)" ) continue;

    $search["comparisonaspect"] = $aspect;
	    $rows = getRowsComparison( $search, $allsongs );	
	    $dataforrows = getCSVTrendDataForRows( $search[comparisonaspect], $pos, $doingyearlysearch?$songsbyyears:$songsbyquarters );
	    
	    $lastdatatimewise = $dataforrows[end( $posstitles)];

	    if( $displayaspect == "Songwriter Team Size" )
		{
		    file_put_contents( "/tmp/dataforrows", print_r( $dataforrows, true ) );	    
		    file_put_contents( "/tmp/dataforrows", "CHOSE: " . end( $posstitles) . "\n", FILE_APPEND );	    
		    file_put_contents( "/tmp/dataforrows", "BEFORE last data time: " . print_r( $lastdatatimewise, true ) . "\n", FILE_APPEND );	    
		    file_put_contents( "/tmp/csvdata", "display aspect: " . $displayaspect . "\n", FILE_APPEND );	    
		    file_put_contents( "/tmp/csvdata", "BEFORE rows: " . print_r( $rows, true ) . "\n", FILE_APPEND );	    
		    file_put_contents( "/tmp/csvdata", "BEFORE last data time: " . print_r( $lastdatatimewise, true ) . "\n", FILE_APPEND );	    
		}

	    uasort( $lastdatatimewise, "customSortLastDataCSV" );

	    uksort( $rows, "customSortCSVResults" );

	    if( $displayaspect == "Songwriter Team Size" )
		{
		    file_put_contents( "/tmp/csvdata", "AFTER rows: " . print_r( $rows, true ) . "\n", FILE_APPEND );	    
		    file_put_contents( "/tmp/csvdata", "AFTER last data time: " . print_r( $lastdatatimewise, true ) . "\n", FILE_APPEND );	    
		    file_put_contents( "/tmp/csvdata", "data: " . print_r( $dataforrows, true ) . "\n", FILE_APPEND );	    
		}


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
    $xls->close();
    exit;
}

?>
