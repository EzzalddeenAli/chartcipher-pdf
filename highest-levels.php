<?php 
    if( !$leveltype )
	{
	    $leveltype = "highest";
	    $leveltypecaps = "Highest";

	}



$istrendreport = true;

function fixToUrls( $res, $isname )
{
    global $qs, $urldatestr;
    foreach( $res as $rid=>$rval )
	{
	    if( $isname )
		$rval[2] = "<a href='{$rval[3]}&{$qs}'>" . getNameById( $isname, $rval[2] ) . "</a>";
	    else
		$rval[2] = "<a href='{$rval[3]}&{$qs}'>$rval[2]</a>";
	    $res[$rid] = $rval;
	}
    return $res;
}

if( !$_GET["graphtype"] ) $_GET["graphtype"] = "line";
$graphtype = $_GET["graphtype"];
$backurl = "insights.php";

include "trendfunctions.php";

include "trendreportfunctions.php";




include 'header.php'; 
include "benchmarkreportfunctions.php";


if( date( "m" ) <= 3 )
    $fq = 1;
else if( date( "m" ) <= 6 )
    $fq = 2;
else if( date( "m" ) <= 9 )
    $fq = 3;
else
    $fq = 4;

if( !$_GET["thisquarter"] )
    {
	$fq = 4;
	$fy = date( "Y" )-1;
	$thisquarter = $fq . "/" . $fy;
    }

$istesting = 0; 
if( $istesting )
    {
	if( !$_GET["thisquarter"] )
	    {
		$thisquarter = "4" . "/" . "2021" ;
		$fq = "4";
	    }
    }

if( $_GET["thisquarter"] )
    {
	$thisquarter = $_GET["thisquarter"];
	$exp = explode( "/", $thisquarter );
	$fq = $exp[0];
	$fy = $exp[1];
    }


$qarr = array( $thisquarter );
$tmpq = getPreviousQuarter( $thisquarter );

$qarr[] = $tmpq;

$numtoadd = 2;
if( $leveltype == "upward" || $leveltype == "downward" ) 
    $numtoadd = 2;
for( $i = 0; $i < $numtoadd; $i ++  )
    {
	$tmpq = getPreviousQuarter( $tmpq );
	$qarr[] = $tmpq;
    }
$exp = explode( "/", $tmpq );
$search["dates"]["fromq"] = $exp[0]; 
$search["dates"]["fromy"] = $exp[1];
$search["dates"]["toq"] = $fq; 
$search["dates"]["toy"] = $fy;
if( $istesting )
    {
	$search["dates"]["toy"] = "2021";
    }
$quarter = $fq;
$year = $search["dates"]["toy"];
$oldestq = $exp[0];
$oldesty = $exp[1];
$quarterstorun = getQuarters( $oldestq, $oldesty, $quarter, $year );

// echo( $oldesty );
// echo( $oldestq . "<br>");
// echo( $fq );
// echo( $search["dates"]["toy"] . "<br>");
// print_r( $quarterstorun );




// if( !$search["benchmarksubtype"] && $search["comparisonaspect"] ) {
//     foreach( array( "structure", "compositional", "production", "lyrical" ) as $subtype )
// 	{
// 	    $vals = getMyPossibleSearchFunctions( $subtype );
	    
// 	    echo( $possiblesearchfunctions[$search["comparisonaspect"]] );
// 	    if( in_array( $search["comparisonaspect"], $vals ) || in_array( $possiblesearchfunctions[$search["comparisonaspect"]], $vals ) )
// 		{
// 		    echo( "setting it to $subtype " );
// 		$search["benchmarksubtype"] = ucwords( $subtype );
// 		}
// 	}
// }
if( !$search["benchmarksubtype"] )
    $search["benchmarksubtype"] = "Compositional";
$subtypecaps = $search["benchmarksubtype"];

$tmptypestouse = getMyPossibleSearchFunctions( strtolower( $search["benchmarksubtype"] ) );
$typestouse = array();
// averages don't make sense
foreach( $tmptypestouse as $t=>$d )
{
    if( strpos( $t, "Average" ) !== false )
	continue;
    $typestouse[$t] =$d;
}

$reportsarr = array( $typestouse );



$_GET["search"] = $search;

$wd = getSetting( "homepageweek" );
$dt = db_query_first_cell( "select Name from weekdates where id = $wd" );
$wdorderby = db_query_first_cell( "select OrderBy from weekdates where id = $wd" );
if( !$_GET["graphtype"] ) $_GET["graphtype"] = "line";


$allsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );

include "trend-datedisplaycalc.php";

    $benchmarkurlwithoutsubtype = "{$leveltype}-levels.php?" . urldecode( $_SERVER['QUERY_STRING'] );
    $levelswithouttype = "-levels.php?" . urldecode( $_SERVER['QUERY_STRING'] );
    $benchmarkurlwithoutsubtype = str_replace( "&search[benchmarksubtype]=". $search[benchmarksubtype] , "", $benchmarkurlwithoutsubtype );
    $benchmarkurlwithoutsubtype = str_replace( "&search[comparisonaspect]=". $search[comparisonaspect] , "", $benchmarkurlwithoutsubtype );

?>
<?php require_once 'thumb/phpThumb.config.php';?>
  <link rel="stylesheet" type="text/css" href="../assets/css/grid.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/new-style.css" />
<!--<link rel="stylesheet" type="text/css" href="../assets/css/full-style.css" />-->
<!-- Master Slider Skin -->
<link href="masterslider/masterslider/skins/light-2/style.css" rel='stylesheet' type='text/css'>
       <!-- MasterSlider Template Style -->
<!--<link href='masterslider/masterslider/style/ms-autoheight.css' rel='stylesheet' type='text/css'>-->
<!-- google font Lato -->
<link href='//fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="masterslider/masterslider/style/masterslider.css" />
<script src="masterslider/masterslider/masterslider.min.js"></script>

	<div class="site-body index-pro ">
<? include "chartchooser.php"; ?>                
             
               
                
               <div class="row  inner row-equal element-container mobile link-alt">
                            <div class="col-6">
                       <div class="home-search-header  flex-addon">
                        <div class="custom-select" >
								<select id="mysetinsighttype">
<option value='gospotlight'>Most Popular Characteristics</option>
<? foreach( $insightsarr as $itype=>$display ) { ?>
<option <?=$leveltype == $itype?"SELECTED":""?> value='<?=$itype?>'><?=$display?></option>
<? } ?></select>
</div>

                        <div class="custom-select" >

								<select id="mysetbenchmarktype">
								<? outputSelectValues( $benchmarksubtypes, $search[benchmarksubtype] ); ?>
								</select>
                               </div>
                        <div class="custom-select" >
<? 
	$allquarters = array(); 
for( $i = $earliesty; $i <= date( "Y" ); $i++ )
    {
	for( $j = 1; $j <= 4; $j++ )
	    {
		if( $j . "/" . $i == "2/2022" ) break;
		$allquarters[$j . "/" . $i] = $j . "/" . $i;
		if( $j . "/" . $i == calculateCurrentQuarter() )
		    break;
	    }
    }
$allquarters = array_reverse( $allquarters );

?>
								<select id="mysetquarter">
								<? outputSelectValues( $allquarters, $thisquarter ); ?>
								</select>

                               </div>
                            </div>
                         <div class="header-inner " >
                         <table class="table insights-section">
<?php
	$flip = array_flip( $possiblesearchfunctions );

	//	print_r( $possiblesearchfunctions );
$linkwithoutcomparison = "{$leveltype}-levels.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$linkwithoutcomparison = str_replace( "&search[comparisonaspect]=". $search[comparisonaspect] , "", $linkwithoutcomparison );
$linkwithoutcomparison .= "&search[comparisonaspect]=";
$characteristics = gatherCharacteristicsMultipleQuarters( $quarterstorun, "{$leveltype}");
if( !count( $characteristics ) )
    $characteristics[ "There are no ". strtolower( $leveltypecaps ) ." trends for ".strtolower( $search[benchmarksubtype] )." for Q$thisquarter."] = "";
// echo( "a:" . $search["comparisonaspect"] ) ;
// echo( "b:" . getSearchTrendName( $search["comparisonaspect"] ) );
// print_r( $characteristics );
if( !in_array( $characteristics[$search["comparisonaspect"] . ":"] ) && !$characteristics[getSearchTrendName( $search["comparisonaspect"] ) . ":"] )
    $search["comparisonaspect"] = "";

foreach( $characteristics as $c=>$displ ) { 
if( strpos( $c, "Average" ) !== false )
 if( $displ == "No" ) continue; 

$aspect = $flip[str_replace( ":", "", $c )];

if( !$search["comparisonaspect"]  )
    {
	$search["comparisonaspect"] = $aspect;
    }
if( $search["comparisonaspect"] == $aspect )
    {
	$savemeval = $displ; 
    }


?>
                     <tr>
                                <td>
<a href="<?=$linkwithoutcomparison?><?=$aspect?>" ><span><span><?=$c?></span> <?=$displ?></span></a>
</td>
                                  <td></td>
                            </tr>
<? }
//echo( "sa:" . $savemeval );
 ?>
                        
                        </table>
                        </div><!-- /.header-block-1B -->
                      </div>
                             <div class="col-6">
                   <div class="home-search-header flex-addon">
    <? if( $search["comparisonaspect"] ) { ?>
                                <h2>Trend Graph</h2>

<?     $tmpurl = "trend-search-results.php?" . urldecode( $_SERVER['QUERY_STRING'] );
 //$tmpurl = str_replace( "&search[benchmarktype]=". $search[benchmarktype] , "", $tmpurl );
if( strpos( $tmpurl, "comparisonaspect") === false )
    $tmpurl .= "&search[comparisonaspect]=" . $search[comparisonaspect];

   foreach( $search["dates"]  as $k=>$v )
   $tmpurl .= "&search[dates][$k]=$v";

?>
                       
                       <a href="#" data-featherlight="#searchlightbox"  class="save-link">Save Search</a>
                       
                       
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


                      
                                 <div class="info-block"><p>
					   <? if( $leveltype == "upward" ) { ?>
<?=$search["benchmarksubtype"]?> characteristics that increased in prominence for three or more quarters.
									     <? } else if( $leveltype == "downward" ) { ?>
<?=$search["benchmarksubtype"]?> characteristics that decreased in prominence for three or more quarters.
															<? } else { ?>
                             <?=$search["benchmarksubtype"]?> characteristics that are at their <?=$leveltype?> levels in four or more quarters.
																    <? } ?>
</p>
                        </div>

					   <? } ?>
                        </div><!-- /.header-block-1B -->
                      </div>
        </div>
			<div class="element-container row">

<? include "insightsreports.php"; ?>                
                
                      </div>
                
                
                
                  
                </div>
        
       

		</section><!-- /.home-top -->

        

	</div><!-- /.site-body -->
								<div class="lightbox" id="searchlightbox">
									<div class="save-search-header">
										<h1>SAVE SEARCH</h2>
									</div><!-- /.save-search-header -->
									<div class="save-search-body">
										<label>Name:</label>
										<input type='text' name="searchname" id='searchname' onChange='javascript:document.getElementById( "searchnamehidden").value = this.value; '>
										<a class="black-btn" href="#" onClick='javascript:saveSearch( "saved", "Levels" ); return false'>SAVE</a>
										<div class="cf"></div>
									</div><!-- /.save-search-body -->
								</div><!-- #searchlightbox -->
      <input type='hidden' name="searchnamehidden" id='searchnamehidden'>
    <script>
		var sessid = "<?=session_id()?>";
		var searchType = "levels";
	var searchName = "<?=$possiblesearchfunctions[$search[comparisonaspect]]  . ( $datedisplay ? ": " . $datedisplay:"" )?>";
</script>


<?php include 'footer.php';?>
    <? if( $search["comparisonaspect"] ) { ?>

 <!-- end chart code -->
    <? $gray = "#444444"; ?>
    <? $labelextra = "%";

$rows = getRowsComparison( $search, $allsongs );
$dataforrows = getTrendDataForRows( $quarterstorun, $search[comparisonaspect], $pos );
//echo( "sav:" . $savemeval );
$savemeval = explode( ", ", $savemeval );
// print_r( $savemeval );
// print_r( $rows );
foreach( $rows as $r=>$rval )
    {
	if( !in_array( $rval, $savemeval ) )
	    {
		//		echo( "removing '$r'<br>" );
		unset( $rows[$r] );
	    }
    }
//print_r( $rows );
$colors = array( "#1fb5ad","#fa8564","#efb3e6","#fdd752","#aec785","#9972b5","#91e1dd", "#ed8a6b", "#2fcc71", "#689bd0", "#a38671", "#e74c3c", "#34495e", "#9b59b6", "#1abc9c", "#95a5a6", "#5e345e", "#a5c63b", "#b8c9f1", "#e67e22", "#ef717a", "#3a6f81", "#5065a1", "#345f41", "#d5c295", "#f47cc3", "#ffa800", "#ffcd02", "#c0392b", "#3498db", "#2980b9", "#5b48a2", "#98abd5", "#79302a", "#16a085", "#f0deb4", "#2b2b2b" );

if( strpos( $search[comparisonaspect], "Average" ) !== false )
    $labelextra = "";
?>
<? 
include "trend-search-results-{$graphtype}.php";  ?>
    <? } ?>
