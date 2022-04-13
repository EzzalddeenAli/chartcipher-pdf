<?php
$iscomparable = true;

include 'header.php';
include "compositionaltrendsbyweeksfunctions.php";


$newsearchlink = "https://analytics.chartcipher.com/compositional-trends-by-weeks-search";

if( $search["primaryartist"] ) 
    {
	$artistfilter = db_query_first_cell( "select id from artists where name = '" . $search["primaryartist"] . "' " );
	if( !$artistfilter )
	    {
		$groupfilter = db_query_first_cell( "select id from groups where name = '" . $search["primaryartist"] . "' " );
	    }
    }
if( $search["writer"] ) $songwriterfilter = db_query_first_cell( "select id from artists where name = '" . $search["writer"] . "' " );
if( $search["producer"] ) $producerfilter = db_query_first_cell( "select id from producers where name = '" . $search["producer"] . "' " );
if( $search["specificsubgenre"] ) $subgenrefilter = $search["specificsubgenre"];



if( !$search[dates][fromq] && !$search[dates][fromyear] )
{
    $nodates = true;
    $search[dates][fromq] = 1;
    $search[dates][fromy] = 2013;

    $rightnow = explode( "/", calculateCurrentQuarter() );

    $search[dates][toq] = $rightnow[0];
    $search[dates][toy] = $rightnow[1];
}

if( $search["dates"]["fromyear"] && !$search["dates"]["toyear"] )
    {
	$search["dates"]["toyear"] = $search["dates"]["fromyear"];
    }
if( $search["dates"]["fromyear"] )
    {
	$search["dates"]["fromy"] = $search["dates"]["fromyear"];
	$search["dates"]["fromq"] = 1;
	$search["dates"]["toy"] = $search["dates"]["toyear"];
	$search["dates"]["toq"] = 4;
    }

if( !$search["dates"]["toy"] )
    {
	$search["dates"]["toy"] = $search["dates"]["fromy"];
	$search["dates"]["toq"] = $search["dates"]["fromq"];
    }

if( $searchby == "Year" )
    {
	$period = "{$search[dates][fromyear]}";
	if( $search[dates][fromyear] != $search[dates][toyear] )
	    {
		$period .= " - {$search[dates][toyear]}";
	    }
    }
else
    {
	$period = "Q{$search[dates][fromq]}/{$search[dates][fromy]}";
	if( $search[dates][fromy] != $search[dates][toy] || $search[dates][fromq] != $search[dates][toq] )
	    {
		$period .= " - Q{$search[dates][toq]}/{$search[dates][toy]}";
	    }
    }

$quarterstorun = getQuarters( $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );

$pos = $search[peakchart];
if( $pos && strpos( $pos, "client-" ) === false )
    $pos = "<" . $pos;


$year = $search["dates"]["fromy"];
$endyear = $search["dates"]["toy"];
$quarter = $search["dates"]["fromq"];
$endquarter = $search["dates"]["toq"];

$allweekdates = getWeekdatesForQuarters( $quarter, $year, $endquarter, $endyear );
// echo( "week: " . count( $allweekdates ) );
// exit;
if( !count( $allweekdates ) ) $allweekdates[] = -1;

$acrossthetop = getAcrossTheTopCompositional( $search[outputformat] );

$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], $pos );

// $allsongsnumweeks = array();
// foreach( $allsongs as $aid )
// {
//     $mynumweeks = db_query_first_cell( "select count(*) from song_to_weekdate where songid = '$aid' and weekdateid in ( " . implode( ", " , $allweekdates ) . " )" );
//     foreach( $acrossthetop as $numweeks=>$displ )
// 	{
// 	    $exp = explode( "-", $numweeks );
// 	    if( $mynumweeks >= $exp[0] && $mynumweeks <= $exp[1] )
// 		{
// 		    $allsongsnumweeks[$numweeks][] = $aid;
// 		}
// 	}
// }

// foreach( $acrossthetop as $key=>$display )
// {
//     if( !$allsongsnumweeks[$key] ) unset( $acrossthetop[$key] );
// }

//print_r( $acrossthetop );
$rows = getRowsCompositional( $search, $allsongs );

// file_put_contents( "/tmp/rows", print_r( $rows, true ), FILE_APPEND );
//print_r( $rows );
//exit;
if( !$period )
    $period = "all dates";
if( $search[outputformat] == 1 )
    {
	$isoverall = true;
	$title = "Songs by " . ($possiblecompositionalaspects[$search[compositionalaspect]]) . "<br> (The percentages in this table are based on the " . count( $allsongs ) . " songs that appeared in the top 10 during {$period} in each specific characteristic).";
    }
else
    {
	$isoverall = false;
	$title = "Songs by Weeks in the Top 10<br> (The percentages in this table are based on the " . count( $allsongs ) . " songs that appeared in the Top 10 during {$period} in each specific week range). ";
    }
?>
<style>
.search-body #comp-search-table th, .search-body #comp-search-table td {
    width: 8%!important;
}
</style>

	<div class="site-body">
        <? include "searchcriteria-compositionaltrendsbyweek.php"; ?>
		<section class="search-results-bottom">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
   

						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
<!-- begin songs by aspect and weeks -->
                        <div class="graph-head" >                       

     <div class="left set" style="margin-bottom:20px;">  
         <div class="icon download">
        <a href='#' id="exportpng" onClick='return false'  class="" style=""> Download</a>
             
             </div>
    <? if( !isStudent() && !isEssentials() ) { ?>
                         <div class="icon save">
                             <a href="#" data-featherlight="#searchlightbox">Save Search</a></div>
<? } ?>                        
                       
                             
                                 <div class="icon email ">
                                     <a href='#'  onClick='javascript: maillink("<?=$possiblesearchfunctions[$search[comparisonaspect]]?> - <?=$rangedisplay?>"); return false;' >Email Link</a></div>
             <div class="icon copy ">
                                     <a href='#'  id="copylink" onClick="javascript: shorturl2(); return false;" >Copy Link</a></div>
                           
         
         
         
                         <div class="icon share" style="display:none">
                             <a href='#' >Share</a>
                             <div class="subset hidden">
                                
                                 <div class="icon email">
                                     <a href='#'  onClick="javascript: maillink('Subject goes here'); return false;" >Email</a></div>
                                  <div class="icon copy">
                                     <a href='#'   id="copylink" onClick="javascript: shorturl2(); return false;" >Copy Link</a></div>
                            </div>
         
                        </div>
                  
                        
    </div>   
    
    
    
       <div class="right set" style="margin-bottom:20px;">  
    <span class='showall' >   
<? if( 1==0 && $graphtype != "column" ) { ?>
        
        <div class="icon show-all ">
                                    <a href='#' onClick='showAllGraph( true ); return false'>Show All</a></div>
        
        <div class="icon hide-all ">
                                 <a href='#' onClick='showAllGraph( false ); return false' >Hide All</a></div>
        
      </span>                   
<? } ?>
                 <div class="icon back-search ">
                   <a  class=" desktop" href="compositional-trends-by-weeks-search.php?<?=$_SERVER['QUERY_STRING']?>" >Back</a></div>
                        
    
    </div>
                        </div>
                        
                        
    <h3><?=$title?></h3>
<? 
include "compositionaltrends-table.php";
?>




<!-- end songs by aspect and weeks --> 

                        <div class="search-footer">
							<div class="search-footer-left span-3">
								<a href="compositional-trends-by-weeks-search.php?<?=$_SERVER['QUERY_STRING']?>" style="float:left;" class="search-header-back">BACK <span class="hide-text">TO SEARCH</span></a>
								<div class="cf"></div>
							</div><!-- /search-footer-left -->
							<div class="search-footer-right span-4">
    <? if( !isStudent() && !isEssentials() ) { ?>
    <a class="black-btn" href="#" data-featherlight="#searchlightbox">SAVE SEARCH</a>
                            <? } ?>
								<a class="orange-btn" href="/comparative-search">NEW SEARCH</a>
								<div class="lightbox" id="searchlightbox">
									<div class="save-search-header">
										<h1>SAVE SEARCH</h2>
									</div><!-- /.save-search-header -->
									<div class="save-search-body">
										<label>Name:</label>
										<input type='text' name="searchname" id='searchname' onChange='javascript:document.getElementById( "searchnamehidden").value = this.value; '>
										<a class="black-btn" href="#" onClick='javascript:saveSearch( "saved", "Compositional Trends By Weeks" ); return false'>SAVE</a>
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
		var searchType = "<?=$searchtype?$searchtype:"Compositional Trend By Week"?>";
	var searchName = "COMPOSITIONAL TRENDS BY WEEK: <?=strtoupper( $search[compositionalaspect] )?>";

saveSearch( "recent" );

$(document).ready(function(){
        $("a.expand-btn").click(function(){
            $("a.expand-btn").toggleClass("collapse-btn");
            $("#search-hidden").toggleClass("hide show");
        });
    });
    $(document).ready(function(){
            $("#exportpng").click(function(){
                    $('#comp-search-table').tableExport({type:'png',escape:'false'});
                });

        });



    </script>
<?php include 'sortingjavascript.php';?>
<?php include 'footer.php';?>
