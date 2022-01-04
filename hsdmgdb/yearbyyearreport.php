<?php
include "connect.php";
include "../functions.php";
include "../trendfunctions.php";
 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

if( $export )
{
    // $genrefilter = 2;
    // $tmphiphopsongs = getSongIdsWithinQuarter( false, 1, 2013, 4, date( "Y" ) );
    // $genrefilter = -2;
    // $tmpnothiphopsongs = getSongIdsWithinQuarter( false, 1, 2013, 4, date( "Y" ) );
    // unset( $genrefilter );
    // print_r( $tmphiphopsongs );
    // echo( "<br><br>" );
    // print_r( $tmpnothiphopsongs );
    // exit;
    require_once "Spreadsheet/Excel/Writer.php";
    $xls = new Spreadsheet_Excel_Writer();
    $filename = "YearOverYear.xls";
    $xls->send( $filename );
    $format_bold =& $xls->addFormat();
    $format_bold->setBold();

    $sheet =& $xls->addWorksheet("Year Report");
    $sheet->setColumn( 0, 0, 30 );
    $sheet->setColumn( 1, 40, 12 );
    $doingyearlysearch = true;

    $allyearstorun = array();
    $numberones = array();
    $hiphop = array();
    $imprint = array();
    $nothiphop = array();
    for( $i = 2013; $i <= date( "Y" ); $i++ )
	{
	    $allyearstorun[] = $i;
	}

    // calculate "all" songs for each type

    $tmpallsongs = getSongIdsWithinQuarter( false, 1, 2013, 4, date( "Y" ) );
    $tmpno1songs = getSongIdsWithinQuarter( false, 1, 2013, 4, date( "Y" ), 1);
    $genrefilter = 2;
    $tmphiphopsongs = getSongIdsWithinQuarter( false, 1, 2013, 4, date( "Y" ) );
    $genrefilter = -2;
    $tmpnothiphopsongs = getSongIdsWithinQuarter( false, 1, 2013, 4, date( "Y" ) );
    unset( $genrefilter );

    $allsongs  = getSongIdsWithinQuarter( false, 1, 2013, 4, date( "Y" ) );
    $tmpimprintsongs = db_query_array( "select songid from song_to_imprint", "songid", "songid" );
    $tmpimprintsongs = array_intersect( $allsongs, $tmpimprintsongs );

    //    file_put_contents( "/tmp/yoy", print_r( $allsongs, true ) );
    $search["dates"]["toyear"] = $search["dates"]["fromyear"];

    $songsections = db_query_rows( "select * from songsections", "id" );

    $sectiontitles = array( 
"Performing Artist Team Size"=>"Performing Artist Team Size No 5+", 
"Producer Team Size"=>"Producer Team Size No 5+",
"Songwriter Team Size"=>"Songwriter Team Size No 5+", 
"Total Team Size"=>"Total Team Size No 5+", 
"Songs with Solo vs. Multiple Artists"=>"Songs with Solo vs. Multiple Artists", 
"Songs with a Featured Artist"=>"Songs with a Featured Artist", 
 );
    $subsectiontitles = array( "Top 10", "#1 Hits", "Non-Hip Hop", "Hip Hop", "Imprint" );
    file_put_contents( "/tmp/yoy", "" );// clear it
    foreach( $sectiontitles as $sectiontitle=>$comparisonaspect )
	{

	    foreach( $subsectiontitles as $subtitle )
		{
		    $colnum = 0;

		    $search = array( "comparisonaspect"=>$comparisonaspect );
		    $search["dates"]["fromq"] = 1;
		    $search["dates"]["fromy"] = 2013;
		    $search["dates"]["toq"] = 4;
		    $search["dates"]["toy"] = date( "Y" );
		    $quarterstorun = getQuarters( 1, 2013, 4, date( "Y" ) );

		    if( $subtitle == "Top 10" )
			{
			    $allsongs = $tmpallsongs;
			    $allsongsstr = implode( ", ", $allsongs );
			    $trenddata = getTrendDataForRows( $quarterstorun, $comparisonaspect );
			    $cols = getRowsComparison( $search, $allsongs );
			}
		    if( $subtitle == "#1 Hits" )
			{
			    $allsongs = $tmpno1songs;
			    $allsongsstr = implode( ", ", $allsongs );
			    $pos = "1";
			    $trenddata = getTrendDataForRows( $quarterstorun, $comparisonaspect, $pos );
			    $cols = getRowsComparison( $search, $allsongs );
			    $pos = "";
			}
		    if( $subtitle == "Non-Hip Hop" )
			{
			    $allsongs = $tmpnothiphopsongs;
			    $allsongsstr = implode( ", ", $allsongs );
			    $genrefilter = -2;
			    $trenddata = getTrendDataForRows( $quarterstorun, $comparisonaspect );
			    $cols = getRowsComparison( $search, $allsongs );
			    unset( $genrefilter );
			}

		    if( $subtitle == "Hip Hop" )
			{
			    $allsongs = $tmphiphopsongs;
			    $allsongsstr = implode( ", ", $allsongs );
			    $genrefilter = 2;
			    $trenddata = getTrendDataForRows( $quarterstorun, $comparisonaspect );
			    $cols = getRowsComparison( $search, $allsongs );
			    unset( $genrefilter );
			}

		    if( $subtitle == "Imprint" )
			{
			    $allsongs = $tmpimprintsongs;
			    $allsongsstr = implode( ", ", $allsongs );
			    $withimprint = true;
			    $trenddata = getTrendDataForRows( $quarterstorun, $comparisonaspect );
			    $cols = getRowsComparison( $search, $allsongs );
			    $withimprint = false;
			}

		    file_put_contents( "/tmp/yoy", "$searchcriteria $subtitle songs:" . $allsongsstr, FILE_APPEND );
		    file_put_contents( "/tmp/yoy", "$searchcriteria $subtitle cols:" . print_r( $cols, true ), FILE_APPEND );
		    file_put_contents( "/tmp/yoy", "$searchcriteria $subtitle trend data:" . print_r( $trenddata, true ), FILE_APPEND );

		    // do percentages
		    $sheet->write( $rownum, $colnum++, $sectiontitle . ": " . $subtitle, $format_bold );
		    $sheet->write( $rownum, $colnum++, "% of Songs", $format_bold );
		    $rownum++;
		    $colnum = 0;
		    $sheet->write( $rownum, $colnum++, "" );
		    foreach( $cols as $c )
			{
			    $sheet->write( $rownum, $colnum++, $c );
			}
		    $rownum++;
		    foreach( $allyearstorun as $yearnum )
			{
			    $colnum = 0;
			    $sheet->write( $rownum, $colnum++, $yearnum );
			    foreach( $cols as $c )
				{
				    $val = $trenddata[$yearnum][$c][1]?$trenddata[$yearnum][$c][1]:"0%";
				    if( $includelinks && $val != "0%" )
 					$sheet->writeUrl( $rownum, $colnum++, "https://analytics.chartcipher.com/" . $trenddata[$yearnum][$c][3], $val ); 
				    else
					$sheet->write( $rownum, $colnum++, $val );
				}

			    $rownum++;
			    
			}
		    $rownum++;
		    $rownum++;
		    $colnum = 0;
		    // do percentages
		    $sheet->write( $rownum, $colnum++, $sectiontitle . ": " . $subtitle, $format_bold );
		    $sheet->write( $rownum, $colnum++, "# of Songs", $format_bold );
		    //		    $rownum++;
		    $rownum++;
		    $colnum = 0;
		    $sheet->write( $rownum, $colnum++, "" );
		    foreach( $cols as $c )
			{
			    $sheet->write( $rownum, $colnum++, $c );
			}
		    $rownum++;
		    foreach( $allyearstorun as $yearnum )
			{
			    $colnum = 0;
			    $sheet->write( $rownum, $colnum++, $yearnum );
			    foreach( $cols as $c )
				{
				    $val = $trenddata[$yearnum][$c][4]?$trenddata[$yearnum][$c][4]:0;
				    if( $includelinks && $val > 0 )
 					$sheet->writeUrl( $rownum, $colnum++, "https://analytics.chartcipher.com/" . $trenddata[$yearnum][$c][3], $val ); 
				    else
					$sheet->write( $rownum, $colnum++, $val );
				}		
			    $rownum++;
			    
			}
		    $rownum++;
		    $rownum++;
		}
	}
	    

    $xls->close();
    exit;
}

include "nav.php";
?>
<h3>Year Over Year Report<h3>
<form method='post'>
<input type='checkbox' name='includelinks' value='1'> Include Links<br>
<input type='submit' name='export' value='Export'>
</form>

