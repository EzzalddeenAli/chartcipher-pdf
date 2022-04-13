<?php
$istrend = true;
$nologin = 1;


if( isset( $_GET["search"]["chartid"] ) && $_GET["search"][chartid] ) $mybychart = "_bychart";
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions{$mybychart}.php";
include "trendfunctions{$mybychart}.php";
$searchsubtype = str_replace( "/", "", $searchsubtype );
$thetype = str_replace( "/", "", $thetype );


if( $_GET["gome"] )
{

$res = db_query_array( "select songid, group_concat( chartid ) as num from song_to_chart group by songid", "songid", "num" );

foreach( $res as $sid=>$values )
{
    $val = "";
    $values = explode( ",", $values );
    foreach( $values as $vid )
	{
	    $vid = trim( $vid );
	    if( $val )
		$val .= ",";
	    $val .= "$vid";
	}
    
    db_query( "update songs set chartids ='$val' where id = $sid" );
    file_put_contents( "loadbb1.txt", "chart info $sid ($val)\n", FILE_APPEND );

}
}



if( isEssentials() ) 
{
Header( "Location: index.php?l=1" );
exit;
}
$font = "Poppins";
//$font = "Arial";


$newsearchlink =  "/song-landing.php";


// db_query( "delete from song_to_songkey" );
// $rows = db_query_rows( "select id, KeyMajor, SpecificMajorMinor from songs", "id" );
// foreach( $rows as $sid=>$keyrow )
// {
// 	$key = $keyrow["KeyMajor"];
// 	$mode = $keyrow["SpecificMajorMinor"];
// $key = str_replace( "Major", "", $key );
// $key = trim( str_replace( "Minor", "", $key ) );
// $keyid = getIdByName( "songkeys", $key ); 
// if( $keyid )
//     {
// 	db_query( "insert into song_to_songkey ( songid, songkeyid, type, NameHard ) values ( '$sid', '$keyid', '". $mode . "', '" . $key . "' )" );
//     }
// }
// exit;

$backurl = ($thetype?"$thetype":"trend")."-search.php".$_SERVER['QUERY_STRING'];

$bpmfilter = $search["exactbpm"];
$majorminorfilter = $search["majorminor"];
$lyricalmoodfilter = $search["lyricalmoodid"];
$lyricalsubthemefilter = $search["lyricalsubthemeid"];
$lyricalthemefilter = $search["lyricalthemeid"];
$subgenrefilter = $search["specificsubgenre"];
$minweeksfilter = $search["minweeks"];

$season = $search[dates][season];
if( !$search[dates][fromq] && !$search[dates][fromyear] && !$search[dates][fromweekdate] )
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
	    $rangedisplay .= " - " . ($search["dates"]["specialendq"]?"Q".$search["dates"]["specialendq"]:""). " {$search[dates][toyear]}";
	
	$search[dates][fromq] = $season?getFirstSeason( $season ):1; 
	$search["dates"]["fromy"] = $search[dates]["fromyear"];
	$search[dates][toq] = $season?getLastSeason( $season ):4;
	    if( $search["dates"]["specialendq"] )
	    $search[dates][toq] = $search["dates"]["specialendq"];

	

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
	$allyearstorun = array();
	for( $i = $search["dates"]["fromyear"]; $i <= $search["dates"]["toyear"]; $i++ )
	    {
		$allyearstorun[] = $i;
	    }
	
    }
else if( $search["dates"]["fromweekdate"] )
{
    $doingweeklysearch = true;
    $replacetotimeperiod = true;
    if( $search["dates"]["fromweekdatesecond"] )
	{
	    $doingthenandnow = true;
	}

    $fromweekdatedisplay = db_query_first_cell( "select Name from weekdates where OrderBy = '" . $search["dates"]["fromweekdate"]. "'" );
    $toweekdatedisplay = db_query_first_cell( "select Name from weekdates where OrderBy = '" . $search["dates"]["toweekdate"]. "'" );
    $fromweekdatedisplaysecond = db_query_first_cell( "select Name from weekdates where OrderBy = '" . $search["dates"]["fromweekdatesecond"]. "'" );
    $toweekdatedisplaysecond = db_query_first_cell( "select Name from weekdates where OrderBy = '" . $search["dates"]["toweekdatesecond"]. "'" );
    $fromweekdatedisplaythird = db_query_first_cell( "select Name from weekdates where OrderBy = '" . $search["dates"]["fromweekdatethird"]. "'" );
    $toweekdatedisplaythird = db_query_first_cell( "select Name from weekdates where OrderBy = '" . $search["dates"]["toweekdatethird"]. "'" );
    $urldatestr = "&search[dates][fromweekdate]=" . $search[dates][fromweekdate]. "&search[dates][toweekdate]=" . $search[dates][toweekdate];
    $urldatestrsecond = "&search[dates][fromweekdate]=" . $search[dates][fromweekdatesecond]. "&search[dates][toweekdate]=" . $search[dates][toweekdatesecond];
    $urldatestrthird = "&search[dates][fromweekdate]=" . $search[dates][fromweekdatethird]. "&search[dates][toweekdate]=" . $search[dates][toweekdatethird];

    $rangedisplay = "$fromweekdatedisplay - $toweekdatedisplay";

    $allsongs = getSongIdsWithinWeekdates( false, $search[dates][fromweekdate], $search[dates][toweekdate] );
    $allsongsnumber1 = getSongIdsWithinWeekdates( false, $search[dates][fromweekdate], $search[dates][toweekdate], 1 );
    $allsongsstr = implode( ", ", $allsongs );
    $allsongsnumber1str = implode( ", ", $allsongsnumber1 );
    $allsongsallquarters = $allsongs;
    $allsongsallquartersstr = $allsongsstr;

    if( $doingthenandnow )
	{
	    $rangedisplay .= " vs. $fromweekdatedisplaysecond - $toweekdatedisplaysecond";
	    $allsongssecond = getSongIdsWithinWeekdates( false, $search[dates][fromweekdatesecond], $search[dates][toweekdatesecond] );
	    $allsongsstrsecond = implode( ", ", $allsongssecond );
	    $allsongsallquarterssecond = $allsongssecond;
	    $allsongsallquartersstrsecond = $allsongsstrsecond;
	    if( !$allsongsstrsecond ) $allsongsstrsecond = "-1";
	    $allweekdatestorunsecond = db_query_rows( "select * from weekdates where OrderBy >= '" . $search["dates"]["fromweekdatesecond"]. "' and OrderBy <= '" . $search["dates"]["toweekdatesecond"]. "' order by OrderBy" );

	    if( $search[dates][fromweekdatethird] )
		{
		    $rangedisplay .= " vs. $fromweekdatedisplaythird - $toweekdatedisplaythird";
		    $allsongsthird = getSongIdsWithinWeekdates( false, $search[dates][fromweekdatethird], $search[dates][toweekdatethird] );
		    //		    print_r( $allsongsthird );exit;
		    $allsongsstrthird = implode( ", ", $allsongsthird );
		    $allsongsallquartersthird = $allsongsthird;
		    $allsongsallquartersstrthird = $allsongsstrthird;
		    if( !$allsongsstrthird ) $allsongsstrthird = "-1";
		    $allweekdatestorunthird = db_query_rows( "select * from weekdates where OrderBy >= '" . $search["dates"]["fromweekdatethird"]. "' and OrderBy <= '" . $search["dates"]["toweekdatethird"]. "' order by OrderBy" );

		}


	}


    if( !$allsongsnumber1str ) $allsongsnumber1str = "-1";
    if( !$allsongsstr ) $allsongsstr = "-1";
    $allweekdatestorun = db_query_rows( "select * from weekdates where OrderBy >= '" . $search["dates"]["fromweekdate"]. "' and OrderBy <= '" . $search["dates"]["toweekdate"]. "' order by OrderBy" );

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
	
	$pos = $search[peakchart];
	if( $pos && strpos( $pos, "client-" ) === false )
	    {
		$pos = "<" . $pos;
	    }
	
	$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], $pos );
	$rangedisplay = "{$search[dates][fromq]}/{$search[dates][fromy]} to {$search[dates][toq]}/{$search[dates][toy]}";
	
    }

if( !$thetype ) $thetype = $searchsubtype;
$backurl = ($thetype?"$thetype":"trend" )."-search.php?" . $_SERVER['QUERY_STRING'];
if( !count( $allsongs  ))
{
//      echo( "no songs?" );
//      exit; 
   Header( "Location: $backurl&nomatch=1" );
}
if( $search[comparisonaspect] == "Number of Songs" || $search[comparisonaspect] == "Number of Weeks" || $search[comparisonaspect] == "Number of Songs (Form)" )
{
// dont do this stuff
}
else
{
    $rows = getRowsComparison( $search, $allsongs );
    if( $_GET["help"] )
	{
	    echo( "\n\n<br>rows\n\n<br>" );
	print_r( $rows );
	    echo( "\n\n<br>end\n\n<br>" );
	}

    // exit;
// new colors
$colors = array( "#eeac6f", "#f5ca7d", "#8475a2", "#ebac9a", "#faa33c", "#38226d", "#da857a", "#f9e3b7", "#e3ddf2", "#d7719f", "#bb0e2c", "#1fb5ad","#fa8564","#efb3e6","#fdd752","#aec785","#9972b5","#91e1dd", "#ed8a6b", "#2fcc71", "#689bd0", "#a38671", "#e74c3c", "#34495e", "#9b59b6", "#1abc9c", "#95a5a6", "#5e345e", "#a5c63b", "#b8c9f1", "#e67e22", "#ef717a", "#3a6f81", "#5065a1", "#345f41", "#d5c295", "#f47cc3", "#ffa800", "#ffcd02", "#c0392b", "#3498db", "#2980b9", "#5b48a2", "#98abd5", "#79302a", "#16a085", "#f0deb4", "#2b2b2b" );
    //$colors = array( "#1fb5ad","#fa8564","#efb3e6","#fdd752","#aec785","#9972b5","#91e1dd" ); 
    // $colors = array( "#5d97cc","#fb833b", "#aeaeae", "#4b6986", "#7f5237", "#ffffff" ); 
    // $colors = array( "#A860AB", "#FF2705", "#FFFF17", "#1DFF0D", "#10FFEF", "#1020FF", "#FF03BC", "#FFAEB3" );
    
    if( $graphtype == "column" || $graphtype == "pie" )
	{
	    $dataforrows = getBarTrendDataForRows( $search[comparisonaspect], $pos );
	}
    else
	{
	    $dataforrows = getTrendDataForRows( $quarterstorun, $search[comparisonaspect], $pos );
	}
}
if( $help )
    {
	//    print_r( $allsongs );
	print_r( $dataforrows );
    }

include 'header.php';

if( isTrendTable( $search[comparisonaspect] ) )
{
//    print_r( $dataforrows );
//    exit;
    if( $search["chartid"] )
	include "trend-search-results-table-bychart.php"; 
   else
	include "trend-search-results-table.php";
    exit;
}



?>
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
<? include "chartchooser.php"; ?>                
        <? include "searchcriteria-trend.php"; ?>
		<section class="search-results-bottom">
			<div class="element-container row">
                <div class="col-12 flex">

				<div class="search-container">
			
					<div class="search-body" >
                        
<div class="graph-head" >                       

     <div class="left set" style="margin-bottom:20px;">  
         
         
             <ul class="icon-list">
                     <li><a href='#' id="exportjpg" onClick='return false' class="download-link">Download</a></li>
               
                 <li><a href="#" data-featherlight="#searchlightbox"  class="save-link">Save Search</a></li>
                                    </ul>
         
        
    <? if( !isStudent() && !isEssentials() ) { ?>
                         <div class="icon save" style="display:none;">
                             <a href="#" data-featherlight="#searchlightbox">Save Search</a></div>
<? } ?>                        
                     
                           
         
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
<? if( $graphtype != "column" ) { ?>
        
        <div class="icon show-all ">
                                    <a href='#' onClick='showAllGraph( true ); return false'>Show All</a></div>
        
        <div class="icon hide-all ">
                                 <a href='#' onClick='showAllGraph( false ); return false' >Hide All</a></div>
        
      </span>                   
<? } ?>
           
           
           <ul class="icon-list">
<!--                     <li><a href="<?=$thetype?"$thetype":"trend"?>-search.php?<?=$_SERVER['QUERY_STRING']?>"  class="back-link">Back Link</a></li>-->
               
                                    </ul>
           
           
       
                

    
    </div>
                        </div>
                        
                        
                      
            
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
                        <div class="search-footer" style="display:none;">
							<div class="search-footer-left span-3">
								<a href="<?=$thetype?"$thetype":"trend"?>-search.php?<?=$_SERVER['QUERY_STRING']?>" style="float:left;" class="search-header-back">BACK <span class="hide-text">TO SEARCH</span></a>
								<div class="cf"></div>
							</div><!-- /search-footer-left -->
							<div class="search-footer-right span-4">
    <? if( !isStudent() && !isEssentials() ) { ?>
    <a class="black-btn" href="#" data-featherlight="#searchlightbox">SAVE SEARCH</a>
                            <? } ?>
								<a class="orange-btn" href="/song-landing.php">NEW SEARCH</a>
								<div class="lightbox" id="searchlightbox">
									<div class="save-search-header">
										<h1>SAVE SEARCH</h2>
									</div><!-- /.save-search-header -->
									<div class="save-search-body">
										<label>Name:</label>
										<input type='text' name="searchname" id='searchname' onChange='javascript:document.getElementById( "searchnamehidden").value = this.value; '>
										<a class="black-btn" href="#" onClick='javascript:saveSearch( "saved", "Trend" ); return false'>SAVE</a>
										<div class="cf"></div>
									</div><!-- /.save-search-body -->
								</div><!-- #searchlightbox -->
							</div><!-- /search-footer-right -->
							<div class="cf"></div>
						</div><!-- /.search-footer -->
					</div><!-- /search-body -->
				</div><!-- /.search-container -->
			</div><!-- /.row -->
            </div>
		</section><!-- /.search-results-bottom -->
	</div><!-- /.site-body -->



      <input type='hidden' name="searchnamehidden" id='searchnamehidden'>
    <script>
		var sessid = "<?=session_id()?>";
		var searchType = "<?=$searchtype?$searchtype:"Trend"?>";
	var searchName = "<?=getSearchTrendName( $search[comparisonaspect] )?>";

$(document).ready(function(){
saveSearch( "recent" );
        $("a.expand-btn").click(function(){
            $("a.expand-btn").toggleClass("collapse-btn");
            $("#search-hidden").toggleClass("hide show");
        });
    });

    </script>


<script>
      $(document).ready(function(){
           $('.icon.share').hover(function(){
                       var $target = $($(this).children('.subset'));
              //  var $theclass =  $target.attr('class');
                $target.removeClass( "hidden" );
            },
                                                   function(){
                       var $target = $($(this).children('.subset'));
              //  var $theclass =  $target.attr('class');
                $target.addClass( "hidden" )
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

<!-- end chart code -->
    

