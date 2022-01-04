<?php
$istrend = true;
$nologin = 1;
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions{$mybychart}.php";
include "chartfunctions.php";

if( $doit )
{
$songids = db_query_array( "select id from songs", "id", "id" );
foreach( $songids as $songid )
{
    $peak = db_query_first_cell( "select type from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
    $numweeks = db_query_first_cell( "select count(*) from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by OrderBy" );
    $peak = str_replace( "position", "", $peak );

    $firstrow = db_query_first( "select Name, type, OrderBy, weekdates.id from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by OrderBy limit 1" );
    $firstdate = $firstrow[OrderBy];
    if( date( "n", $firstdate ) <= 3 )
	{
	    $quarter = "1/" . date( "Y", $firstdate );
	}
    else if( date( "n", $firstdate ) <= 6 )
	{
	    $quarter = "2/" . date( "Y", $firstdate );
	}
    else if( date( "n", $firstdate ) <= 9 )
	{
	    $quarter = "3/" . date( "Y", $firstdate );
	}
    else
	{
	    $quarter = "4/" . date( "Y", $firstdate );
	}

    $autocalcvalues = array();
    
    $autocalcvalues["QuarterEnteredTheTop10"] = $quarter;
    $autocalcvalues["WeekEnteredTheTop10"] = $firstrow[id];
    $autocalcvalues["YearEnteredTheTop10"] = date( "Y", $firstdate );
    $autocalcvalues["EntryPosition"] = str_replace( "position", "", $firstrow["type"] );
    $autocalcvalues["NumberOfWeeksSpentInTheTop10"] = $numweeks;
    $autocalcvalues["PeakPosition"] = str_replace( "position", "", $peak );
    foreach( $autocalcvalues as $aid=>$val )
      {
	db_query( "update songs set $aid = '$val' where id = $songid" );
      }


}
}

$allcharts = db_query_array( "select chartkey, chartname from charts", "chartkey", "chartname");
$weekdatearr = db_query_array( "select realdate, Name from weekdates", "realdate", "Name");
$weekdatearrbyid = db_query_array( "select realdate, id from weekdates", "realdate", "id");
$songrow = db_query_first( "select * from songs where id = $songid" );


$frontendfieldname = "primaryartist";
$frontendlinks = false;	   
$frontenduseid = false;
$any = false; 
$songtitlestr = $songrow[SongNameHard] . " - ";
$artists = getArtists( $songid );
if( $artists )
    $any = true;
$songtitlestr .= ( $artists );
$artists = getGroups( $songid );
if( $any && $artists ) $songtitlestr .= ( ", " );
if( $artists )
    $any = true;
$songtitlestr .= ( $artists );
$artists = getArtists( $songid, "featured" );
if( $artists ) {  
    $songtitlestr .= " feat. $artists";
}
$artists = getGroups( $songid, "featured" );
if( $artists ) { 
    $songtitlestr .= " feat. $artists";
}
$frontendlinks = false;	   

if( isEssentials() || !$songrow[id]) 
{
Header( "Location: index.php?l=1" );
exit;
}

if( !$graphtype ) $graphtype = "table";
// $w = db_query_rows( "select * from weekdates" );
// foreach( $w as $warr )
// {
// 	$d = date( "Y-m-d", $warr[OrderBy] );
// 	db_query( "update weekdates set realdate = '$d' where id = $warr[id]" );
// }

$colors = array( "#1fb5ad","#fa8564","#efb3e6","#fdd752","#aec785","#9972b5","#91e1dd", "#ed8a6b", "#2fcc71", "#689bd0", "#a38671", "#e74c3c", "#34495e", "#9b59b6", "#1abc9c", "#95a5a6", "#5e345e", "#a5c63b", "#b8c9f1", "#e67e22", "#ef717a", "#3a6f81", "#5065a1", "#345f41", "#d5c295", "#f47cc3", "#ffa800", "#ffcd02", "#c0392b", "#3498db", "#2980b9", "#5b48a2", "#98abd5", "#79302a", "#16a085", "#f0deb4", "#2b2b2b" );
$allweekdatestorun = db_query_array( "select distinct( thedate ) from billboardinfo where songid = $songid order by thedate", "thedate", "thedate" );

$rows = getRowsComparison( $songid );
$dataforrows = getChartInfoForSong( $songid );
if( $help )
{
//    print_r( $allsongs );
    print_r( $dataforrows );
}

include 'header.php';

// if( $search[comparisonaspect] == "Number of Songs" || $search[comparisonaspect] == "Number of Weeks" )
// {
// //    print_r( $dataforrows );
// //    exit;
//     include "trend-search-results-table.php";
//     exit;
// }



?>
    <? if( $graphtype == "table" ) { ?>
        <? include "chart-search-results-table.php"; ?>

	       <? } else { ?>
<style type="text/css">
	.search-header h1{ float:none; }
	.search-header h2{
    margin-top: 15px;
    color: #7a7a7a;
    font-size: 14px;
	}
    
    ul.instructions li{
         list-style-type: initial!important;
        margin-left:15px!important;
        padding-bottom:6px;
       font-weight: 500;
    }
    
    #chartContainer h2 {
/*    padding-bottom:20px; */
    }
</style>

	<div class="site-body">
        <? include "searchcriteria-chart.php"; ?>
		<section class="search-results-bottom">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
        <h1><?=getOrCreateCustomTitle( "CHART SEARCH", "CHART SEARCH:")?> <?=$songtitlestr?></h1>
            <?php
$key = "CHART SEARCH";
if( $_GET["showkey"] ) echo( "<font color='red'>$key</font><br><Br>" ); 
$custom = getOrCreateCustomHover( $key, "This search reflects chart info for a particular song in the Billboard Hot 100 Top Ten." );
?>

            <h2><?=$custom?>

<br><br>
                            <ul class="instructions">
           <li>To add or remove items from the graph below, please click on the item in the legend.</li>
            <li>To view the songs that correspond to a datapoint, hover over the datapoint and click on the link in the pop-up.</li>
                            </ul>


    </h2>
                <? if( !$thetype ) $thetype = $searchsubtype; ?>
						<a href="<?=$songrow[CleanUrl]?>" class="search-header-back">BACK <span class="hide-text">TO SONG</span></a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
<span class='showall'>    <a href='#' onClick='showAllGraph( true ); return false' style="background-color: #32323a;display: inline-block;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;text-align: center;font-size: 14px;color: #ffffff;text-decoration: none;padding: 12px;">Show All</a>      <a href='#' onClick='showAllGraph( false ); return false' style="background-color: #ff6633;display: inline-block;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;text-align: center;font-size: 14px;color: #ffffff;text-decoration: none;padding: 12px;">Hide All</a></span>
        <a href='#' id="exportjpg" onClick='return false' style="background-color: #aeb2b7;display: inline-block;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;text-align: center;font-size: 14px;color: #ffffff;text-decoration: none;padding: 12px;">Save As Image</a></span>
<script language='javascript'>

        function saveCanvas()
{
    chart.exportCanvas( chart.canvas, "png", chart.exportFileName);

}
    function showAllGraph( val )
{
    for(i = 0; i <  chart.options.data.length ; i++ )
    {
        chart.options.data[i].visible = val;
    }
    chart.render();
}
</script>    
<!-- begin graph -->
	<div id="chartContainer" style="height:600px;">
	</div>
    <!-- end graph -->    
                        <div class="search-footer">
							<div class="search-footer-left span-3">
								<a href="<?=$songrow[CleanUrl]?>" style="float:left;" class="search-header-back">BACK <span class="hide-text">TO SONG</span></a>
								<div class="cf"></div>
							</div><!-- /search-footer-left -->
							<div class="search-footer-right span-4">
    <? if( !isStudent() && !isEssentials() && 1 == 0 ) { ?>
    <a class="black-btn" href="#" data-featherlight="#searchlightbox">SAVE SEARCH</a>
								<a class="orange-btn" href="/trend-search<?=$thetype?"-$thetype":""?>">NEW SEARCH</a>
                            <? } ?>
								<div class="lightbox" id="searchlightbox">
									<div class="save-search-header">
										<h1>SAVE SEARCH</h2>
									</div><!-- /.save-search-header -->
									<div class="save-search-body">
										<label>Name:</label>
										<input type='text' name="searchname" id='searchname' onChange='javascript:document.getElementById( "searchnamehidden").value = this.value; '>
										<a class="black-btn" href="#" onClick='javascript:saveSearch( "saved", "Chart Info" ); return false'>SAVE</a>
										<div class="cf"></div>
									</div><!-- /.save-search-body -->
								</div><!-- #searchlightbox -->
							</div><!-- /search-footer-right -->
							<div class="cf"></div>
						</div><!-- /.search-footer -->
					</div><!-- /search-body -->
				</div><!-- /.search-container -->
			</div><!-- /.row -->
		</section><!-- /.search-results-bottom -->
	</div><!-- /.site-body -->
      <input type='hidden' name="searchnamehidden" id='searchnamehidden'>
    <script>
		var sessid = "<?=session_id()?>";
		var searchType = "<?=$searchtype?$searchtype:"Chart"?>";
	var searchName = "CHART SEARCH: <?=$songtitlestr?>";

saveSearch( "recent" );
$(document).ready(function(){
        $("a.expand-btn").click(function(){
            $("a.expand-btn").toggleClass("collapse-btn");
            $("#search-hidden").toggleClass("hide show");
        });
    });

    </script>

 <!-- end chart code -->
    <? $gray = "#444444"; ?>
    <? 
// $labelextra = "%";

// if( strpos( $search[comparisonaspect], "Average" ) !== false )
    $labelextra = "";

include "chart-search-results-{$graphtype}.php";  ?>

<!-- end chart code -->
    <? } ?>    
<?php include 'footer.php';?>
<? ?>
