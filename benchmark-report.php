<?php 
$istrendreport = true;

if( !isset( $mainurl ) ) $mainurl = "benchmark-report.php";
include "trendfunctions.php";
include 'header.php'; 
include "benchmarkreportfunctions.php";
if( !$_GET["graphtype"] ) $_GET["graphtype"] = "column";
$graphtype = $_GET["graphtype"];
$backurl = "benchmark.php";
$sorttableids = array();
$newsearchlink = "/benchmark.php";
$allgraphnames = array();
if( count( $search[dates][season] ) )
    $season = $search[dates][season];

	$pos = $search[peakchart];
	if( $pos && strpos( $pos, "client-" ) === false )
	    {
		$pos = "<" . $pos;
	    }

	    $overridepos = $pos;

if( !$search["benchmarksubtype"] ) $search["benchmarksubtype"] = "Compositional";

$typestouse = getMyPossibleSearchFunctions( strtolower( $search["benchmarksubtype"] ) );
if( $search["benchmarktype"] == "Genre Comparisons" )
    {
	$typestouse = $benchmarknumerics[$search[benchmarksubtype]];
    }

if( ($search["benchmarktype"] == "Seasonal Comparisons") && !$season )
    {
	//	echo( "in here" );
	Header( "Location: /benchmark.php?needsseason=1&" . $_SERVER["QUERY_STRING"] );
	echo( "<script>document.location.href = 'benchmark.php?needsseason=1&" . $_SERVER["QUERY_STRING"]."';</script>" );
	exit;
    }

if( ($search["benchmarktype"] == "Cross Chart Comparisons") && !$search["comparechartids"] )
    {
	//	echo( "in here" );
	Header( "Location: /benchmark.php?needschart=1&" . $_SERVER["QUERY_STRING"] );
	echo( "<script>document.location.href = 'benchmark.php?needschart=1&" . $_SERVER["QUERY_STRING"]."';</script>" );
	exit;
    }

if( in_array( intval( $chartid ), array( 6, 3, 15, 42, 43 ) ) || in_array( intval( $_GET["setchart"] ), array( 6, 3, 15, 42, 43 ) )  )
{
	if( $search["benchmarktype"] == "Genre Comparisons" )
	{
	Header( "Location: benchmark.php" );
	echo( "<script language='javascript'>document.location.href = 'benchmark.php';</script>" );
	exit;
	}
	
}


//print_r( $season) ;
if( !$search["dates"]["fromy"] && !$search["dates"]["fromweekdate"] && !$search["dates"]["fromyear"] )
{

	if( date( "m" ) <= 3 )
        $fq = 1;
    else if( date( "m" ) <= 6 )
        $fq = 2;
    else if( date( "m" ) <= 9 )
        $fq = 3;
    else
        $fq = 4;

    $exp = explode( "/", getPreviousQuarter( $fq . "/" . date( "Y" ) ) );
    
    $search["dates"]["fromq"] = $season?getFirstSeason( $season ):$exp[0]; 
   $search["dates"]["fromy"] = $season?getLastSeason( $season ):$exp[1];
}


//echo( $search["benchmarktype"] );
switch( $search["benchmarktype"] ) { 
    case "Top vs. Bottom of the Charts":
    $columns = array( "Top $topmiddle"=>"1:$topmiddle", "Bottom $topmiddle"=> "$bottommiddle:$maxnumperchart" );
    break;
    case "Seasonal Comparisons":
	$columns = array();
	//	print_r( $season );
	foreach( $season as $s )
	    {
		$columns[$seasonswithall[$s]] = array( "season"=>$s );
	    }
    break;
    case "Cross Chart Comparisons":
    $allcharts = db_query_array( "select id, Name from charts", "id", "Name" );
	$columns = array();
	foreach( $search["comparechartids"] as $s )
	    {
		$columns[$allcharts[$s]] = array( "crosschartid"=>$s );
	    }
//	    print_r( $columns );
    break;
    case "New Songs vs. Carryovers":
	$columns = array( "New Songs"=> array( "newcarryfilter"=>"new" ), "Carryovers"=> array("newcarryfilter"=>"carryover" ) );
    break;
    case "Staying Power - 10 Weeks":
	$columns = array( "Song with 10+ Weeks"=>array( "minweeksfilter"=>"10" ), "Songs with less than 10 Weeks"=> array( "minweeksfilter"=>"1-9" ) );
    break;
    case "Genre Comparisons":
	$columns = db_query_array( "select id, Name from subgenres order by OrderBy", "Name", "id" );
    break;
default:
    $columns = array( "Top $topmiddle"=>"1:$topmiddle", "Bottom $topmiddle"=> "$bottommiddle:$maxnumperchart" );
}

//print_r( $benchmarkreportsarr );
if( !$search["comparisonaspect"]  )
    {
	$search["comparisonaspect"] = array_key_first( $typestouse );
	if( !$search["comparisonaspect"]  ) $search["comparisonaspect"] = $typestouse[0];
    }


if( $search["dates"]["fromyear"] )
{

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
}
else
{
    $rangedisplay = "Q{$search[dates][fromq]}/{$search[dates][fromy]} - Q{$search[dates][toq]}/{$search[dates][toy]}";
}

    $urldatestr = "&search[dates][fromq]={$search[dates][fromq]}&search[dates][fromy]=" . $search[dates][fromy]. "&search[dates][toq]={$search[dates][toq]}&search[dates][toyear]=" . $search[dates][toy];

    $allsongsbench = array();
$alllllsongs = array();
//echo( "clinetid: " . $searchclientid );
//print_r( $columns );
    foreach( $columns as $c=>$benchmarkpeak )
    {

    $newcarryfilter = "";
    $minweeksfilter = "";
    $season = "";
    if( is_array( $benchmarkpeak ) )
	{
	    foreach( $benchmarkpeak as $type=>$val )
		{
		    if( $type == "newcarryfilter" )
			$newcarryfilter = $val;
		    if( $type == "minweeksfilter" )
			$minweeksfilter = $val;
		    if( $type == "crosschartid" )
			$crosschartfilter = $val;
		    if( $type == "season" )
			{
			$season = $val;
			}
		}
	        $benchmarkpeak = $overridepos;
	}
    // add to the trend-search-results-type too
	if( $search["benchmarktype"] == "Genre Comparisons" )
	{
	    $subgenrefilter = $benchmarkpeak;
	    $benchmarkpeak = $overridepos;
	}		
	if( $search["benchmarktype"] != "Staying Power - 10 Weeks" )
	    {
		$minweeksfilter = $search["minweeks"];
	    }

    //    echo( "min: $minweeksfilter" );
    //    echo( $minweeksfilter );
	if( $search["benchmarktype"] != "New Songs vs. Carryovers" )
	    $newcarryfilter = "new";


	$allsongstop = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], $benchmarkpeak, false, $season );
	if( !count( $allsongstop ) )
	    {
//	    echo( "removing $c" );
		unset( $columns[$c] );
		continue;
	    }
	//	echo( "$subgenrefilter: " . count( $allsongstop ) . "<br>");
	$allsongsbench[$c] = $allsongstop;
	//	print_r( $allsongstop );
	$alllllsongs = array_merge( $alllllsongs, $allsongstop );
    }	     
//echo( "all the songs: " );
//print_r( $alllllsongs );
//echo( count( $alllllsongs ) );
$rows = getRowsComparison( $search, $alllllsongs );
//    $allgenres = db_query_array( "select id, Name from genres order by OrderBy", "id", "Name" );
//    $genrefilter = $_GET["subgenrefilter"];

include "trend-datedisplaycalc.php";
include "trendreportfunctions.php";
?> 
	<div class="site-body index-pro ">
<? include "chartchooser.php"; ?>                
<? if( 1 == 0 ) { ?>
        <? include "searchcriteria-benchmark.php"; ?>
<?  } ?>
             
        <section class="home-top">
			<div class="element-container row">


               
                
               <div class="row  row-equal row-padding mobile link-alt">
                            <div class="col-4">
                       <div class="home-search-header  flex-addon">
                                <h2>

<? if( $search["benchmarktype"] != "Cross Chart Comparisons" ) { ?>
                         <div class="custom-select" >
								<select id="mysetbenchmark">
								<? outputSelectValues( $benchmarktypes, $search[benchmarktype] ); ?>
								</select>
<? } else { ?>
<?=$search["benchmarktype"]?>
</div>
<? } ?>
                         <div class="custom-select" >

								<select id="mysetbenchmarktype">
								<? outputSelectValues( $benchmarksubtypes, $search[benchmarksubtype] ); ?>
								</select>

</h2>
                               
                            </div>
                         <div class="header-inner " >
                         <table class="table insights-section">
<?php
// for the footer
    $benchmarkurlwithouttype = "$mainurl?" . urldecode( $_SERVER['QUERY_STRING'] );
    $benchmarkurlwithouttype = str_replace( "&search[benchmarktype]=". $search[benchmarktype] , "", $benchmarkurlwithouttype );
    $benchmarkurlwithouttype = str_replace( "&search[comparisonaspect]=". $search[comparisonaspect] , "", $benchmarkurlwithouttype );
    $benchmarkurlwithoutsubtype = "$mainurl?" . urldecode( $_SERVER['QUERY_STRING'] );
    $benchmarkurlwithoutsubtype = str_replace( "&search[benchmarksubtype]=". $search[benchmarksubtype] , "", $benchmarkurlwithoutsubtype );
    $benchmarkurlwithoutsubtype = str_replace( "&search[comparisonaspect]=". $search[comparisonaspect] , "", $benchmarkurlwithoutsubtype );
// end for the footer
    $tmpurl = "$mainurl?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&search[comparisonaspect]=". $search[comparisonaspect] , "", $tmpurl );
$tmpurl .= "&search[comparisonaspect]=";


 foreach( $typestouse as $c=>$displ ) { 

 ?>
                     <tr>
                                <td><span><span><a href='<?=$tmpurl?><?=$c?>'><?=$possiblesearchfunctions[$displ]?$possiblesearchfunctions[$displ]:$displ?></a></span> <?=$notsuredispl?></span>
</td>
                                  <td></td>
                            </tr>
	 <? } ?>
                        
                        </table>
                        </div><!-- /.header-block-1B -->
                      </div>
                             <div class="col-8">
                   <div class="home-search-header flex-addon">
                                <h2>Trend Graph</h2>
<ul>                 <li><a href="#" data-featherlight="#searchlightbox"  class="save-link">Save Search</a></li></ul>
<!--                         <div class="custom-select" >
								<select id="mysetgraphtype">
     <? foreach( array(  "column"=>"Bar Graph", "line"=>"Line Graph" ) as $pid=>$pval ) { ?>
                     <option <?=$_GET["graphtype"] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                                             <? } ?>
								</select>
</div>-->

<?     $tmpurl = "trend-search-results.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&search[benchmarktype]=". $search[benchmarktype] , "", $tmpurl );
if( strpos( $tmpurl, "comparisonaspect") === false )
    $tmpurl .= "&search[comparisonaspect]=" . $search[comparisonaspect];

?>
<!--                                 <a class="search" href="/<?=$tmpurl?>"> View >></a>-->
                            </div>
                         <div class="header-inner insight-graph" >


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
                             
                             <div class="info-block"><p>
<?=$benchmarkdescriptions[$search["benchmarktype"]]?>
									     </p>
                        </div>
    <!-- end graph -->    


                      
                        </div><!-- /.header-block-1B -->
                      </div>
                      </div>
        
                
                
	<? if( 1 == 0 ) { ?>                

                
                               <div class="row  row-equal row-padding mobile link-alt">
                            <div class="col-12">
                       <div class="home-search-header  flex-addon">
                                <h2>Reports</h2>
                                 
                            </div>
                         <div class="header-inner " >
                        <h4>Weekly Snapshots: Week of X</h4>
                             <p>Highest Levels in Four or More Quarters<span class="arrow"> >></span></p>
                              <p>Lowest Levels in Four or More Quarters<span class="arrow"> >></span></p>
                              <p>New/Departing Songs<span class="arrow"> >></span></p>
                           
                             
                             
                             <h4>Chart Movement</h4>
                             <p>Up the Chart (found in 75% or more of songs)<span class="arrow"> >></span></p>
                              <p>Down the Chart (found in 75% or more of songs)<span class="arrow"> >></span></p>
                             
                                    <h4>Staying Power</h4>
                             <p>What characteristics are found in 75% or more of songs that have charted for over 10 weeks during the year?<span class="arrow"> >></span></p>
                        
                                    <h4>Spotlights</h4>
                             <p>Compositional Spotlight<span class="arrow"> >></span></p>
                              <p>Lyrical Spotlight<span class="arrow"> >></span></p>
                              <p>Production Spotlight<span class="arrow"> >></span></p>
                              <p>Structure Spotlight<span class="arrow"> >></span></p>
                              <p>#1 Hit Spotlight<span class="arrow"> >></span></p>
                             
                             
                                <h4>Cross Charts Reports</h4>
                             <p>What do songs that are charting on multiple charts have in common?<span class="arrow"> >></span></p>
                          
                        
                        </div><!-- /.header-block-1B -->
                      </div>
                            
                      </div>
                
                
                
					    <? }?>
                
                
                  
                </div>
        
        
       
               <div class="row  row-equal row-padding mobile link-alt">
                            <div class="col-6">
                       <div class="home-search-header ">
                                <h3>Saved Searches and Reports</h3>
                                 <a style="display:none;" class="search" href="/saved-searches"><img src="assets/images/home/search-view-icon.svg" /></a>
                            </div>
                         <div class="header-inner" >
                         <table class="table table-section table-search">
<? $searches = getSavedSearches(); 
$i = 0;
foreach( $searches as $s ) { 
	 $url = $s[url] . "&savedid={$s[id]}";
$i++; 
if( $i > 5 ) continue;
?>
                            <tr>
                                <td><a href="<?=$url?>" class="rowlink"><?=$s[Name]?></a></td>
                                <td><?=prettyFormatDate( $s[dateadded] ) ?></td>
                                      <td> </td>
                            </tr>
<? } ?>

                        </table>
                        </div><!-- /.header-block-1B -->
                      </div>
                             <div class="col-6" >
                   <div class="home-search-header ">
                                <h3>Recent Searches</h3>
                                 <a style="display:none;" class="search" href="/saved-searches"><img src="assets/images/home/search-view-icon.svg" /></a>
                            </div>
                         <div class="header-inner " >
                         <table class="table table-section ">
<? $searches = getRecentSearches( 40 ); 
$already = array();
foreach( $searches as $s ) { 
	 if( isset( $already[$s[url]] ) ) continue;
$already[$s[url]] = 1;
if( count( $already ) > 3 ) continue;
$name = $s[Name]?$s[Name]:"Advanced Search";
$name = str_replace( "Trend Search: ", "", $name );

?>
                                                    <tr data-href="<?=$s[url]?>">
<td>
<a class='rowlink' href='<?=$url?>'><?=$name?></a>            </td>
                                    <td></td>
                                    <td></td>
                                                    </tr>
<? } ?>
                        </table>
                        </div><!-- /.header-block-1B -->
                      </div>
                      </div>
        
        
        
            </div><!-- /.row -->
       

		</section><!-- /.home-top -->

        

	</div><!-- /.site-body -->

	<script>
                    
	$(document).ready(function(){
	    $("a.expand-btn").click(function(){
	        $("a.expand-btn").toggleClass("collapse-btn");
	        $("#search-hidden").toggleClass("hide show");
                return false;
	    });
	});
  
	</script>

<?php include 'footer.php';?>
 <!-- end chart code -->
    <? $gray = "#444444"; ?>
    <? $labelextra = "%";

if( strpos( $search[comparisonaspect], "Average" ) !== false )
    $labelextra = "";
?>
								<div class="lightbox" id="searchlightbox">
									<div class="save-search-header">
										<h1>SAVE SEARCH</h2>
									</div><!-- /.save-search-header -->
									<div class="save-search-body">
										<label>Name:</label>
										<input type='text' name="searchname" id='searchname' onChange='javascript:document.getElementById( "searchnamehidden").value = this.value; '>
										<a class="black-btn" href="#" onClick='javascript:saveSearch( "saved", "Benchmark" ); return false'>SAVE</a>
										<div class="cf"></div>
									</div><!-- /.save-search-body -->
								</div><!-- #searchlightbox -->
      <input type='hidden' name="searchnamehidden" id='searchnamehidden'>
    <script>
		var sessid = "<?=session_id()?>";
		var searchType = "Benchmark";
	var searchName = "<?=$possiblesearchfunctions[$search[comparisonaspect]]  . ( $datedisplay ? ": " . $datedisplay:"" )?>";
</script>
<? 
include "trend-search-results-{$graphtype}.php";  ?>
