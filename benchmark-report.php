<?php 
$istrendreport = true;
include "trendfunctions.php";
include "benchmarkreportfunctions.php";
include 'header.php'; 
if( !$_GET["graphtype"] ) $_GET["graphtype"] = "column";
$graphtype = $_GET["graphtype"];
$backurl = "benchmark.php";
$sorttableids = array();
$allgraphnames = array();
$season = $search[dates][season];
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
    case "Top 25 vs. Bottom 25":
    $columns = array( "Top 25"=>"1:25", "Bottom 25"=> "75:100" );
    break;
    case "New Songs vs. Carryovers":
	$columns = array( "New Songs"=> array( "newcarryfilter"=>"new" ), "Carryovers"=> array("newcarryfilter"=>"carryover" ) );
    break;
    case "Staying Power - 10 Weeks":
	$columns = array( "Song with 10+ Weeks"=>array( "minweeksfilter"=>"10" ), "Songs with less than 10 Weeks"=> array( "minweeksfilter"=>"1-9" ) );
    break;
default:
    $columns = array( "Top 25"=>"1:25", "Bottom 25"=> "75:100" );
}

//print_r( $benchmarkreportsarr );
if( !$search["comparisonaspect"]  )
    $search["comparisonaspect"] = $benchmarkreportsarr[0];
//echo( $search["comparisonaspect"] );
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
    foreach( $columns as $c=>$benchmarkpeak )
    {

    $newcarryfilter = "";
    $minweeksfilter = "";
    if( is_array( $benchmarkpeak ) )
	{
	    foreach( $benchmarkpeak as $type=>$val )
		{
		    if( $type == "newcarryfilter" )
			$newcarryfilter = $val;
		    if( $type == "minweeksfilter" )
			$minweeksfilter = $val;
		}
	        $benchmarkpeak = "";
	}
    //    echo( "min: $minweeksfilter" );
    //    echo( $minweeksfilter );
	$allsongstop = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], $benchmarkpeak );
	$allsongsbench[$c] = $allsongstop;
	//	print_r( $allsongstop );
	$alllllsongs = array_merge( $alllllsongs, $allsongstop );
    }	     
//echo( "all the songs: " );
//print_r( $alllllsongs );
$rows = getRowsComparison( $search, $alllllsongs );
    $allgenres = db_query_array( "select id, Name from genres order by OrderBy", "id", "Name" );
    $genrefilter = $_GET["genrefilter"];

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
                            <div class="col-6">
                       <div class="home-search-header  flex-addon">
                                <h2>

                         <div class="custom-select" >
								<select id="mysetbenchmark">
								<? outputSelectValues( $benchmarktypes, $search[benchmarktype] ); ?>
								</select>
</div>

</h2>
                               
                            </div>
                         <div class="header-inner " >
                         <table class="table insights-section">
<?php
// for the footer
    $benchmarkurlwithouttype = "benchmark-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
    $benchmarkurlwithouttype = str_replace( "&search[benchmarktype]=". $search[benchmarktype] , "", $benchmarkurlwithouttype );
// end for the footer
    $tmpurl = "benchmark-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&search[comparisonaspect]=". $search[comparisonaspect] , "", $tmpurl );
$tmpurl .= "&search[comparisonaspect]=";
 foreach( $benchmarkreportsarr as $c=>$displ ) { 

 ?>
                     <tr>
                                <td><span><span><a href='<?=$tmpurl?><?=$displ?>'><?=$possiblesearchfunctions[$displ]?$possiblesearchfunctions[$displ]:$displ?></a></span> <?=$notsuredispl?></span>
<!--<a href="home" class="rowlink">Primary Genres: R&B/Soul</a>-->
</td>
                                  <td></td>
                            </tr>
<? } ?>
                        
                        </table>
                        </div><!-- /.header-block-1B -->
                      </div>
                             <div class="col-6">
                   <div class="home-search-header flex-addon">
                                <h2>Trend Graph</h2>
<?     $tmpurl = "trend-search-results.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&search[benchmarktype]=". $search[benchmarktype] , "", $tmpurl );
if( strpos( $tmpurl, "comparisonaspect") === false )
    $tmpurl .= "&search[comparisonaspect]=" . $search[comparisonaspect];

?>
                                 <a class="search" href="/<?=$tmpurl?>"> View >></a>
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
        
       

		</section><!-- /.home-top -->

        

	</div><!-- /.site-body -->

	<script>
        /*
		$(".header-block").click(function() {
  window.location = $(this).find("a").attr("href");
  return false;
});
  
        
        
        
        
 if(window.outerHeight){
       var w = window.outerWidth;
      var h = window.outerHeight;
  }
  else {
      var w  = document.body.clientWidth;
      var h = document.body.clientHeight; 
  }     
        
         var moreItems = document.querySelectorAll('.more-items');
        moreItems = [...moreItems];
        
        moreItems.forEach(element => console.log(element));
        
        console.log(w + 'this');
        
                if(w > 1702 || w < 1002){
            console.log('works');
             moreItems.forEach(element => element.style.display="none");     
        }else{
            moreItems.forEach(element => element.style.display="block");
        } 
   
    
    window.addEventListener('resize', function(event){
    var w  = document.body.clientWidth;
      var h = document.body.clientHeight;    
        
         var moreItems = document.querySelectorAll('.more-items');
        moreItems = [...moreItems];
        
        moreItems.forEach(element => console.log(element));
        
        console.log(w + 'this');
        
                if(w > 1702 || w < 1002){
            console.log('works');
             moreItems.forEach(element => element.style.display="none");     
        }else{
            moreItems.forEach(element => element.style.display="block");
        } 
});
        
        

        
              
    
       
            
        
        
       */ 

                    
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
<? 
include "trend-search-results-{$graphtype}.php";  ?>
