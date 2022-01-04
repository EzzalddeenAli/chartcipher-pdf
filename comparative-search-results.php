<?php
$iscomparable = true;

include 'header.php';
include "comparisonfunctions.php";
if( !$search[dates][fromq] && !$search[dates][fromyear] )
{
    if( !$search[dates][season] )	
	$nodates = true;

    $search[dates][fromq] = $search[dates][season]?$search[dates][season]:1;
    $search[dates][fromy] = 2013;

    $rightnow = explode( "/", calculateCurrentQuarter() );

    $search[dates][toq] = $search[dates][season]?$search[dates][season]:$rightnow[0];
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


$season = $search[dates][season];

$quarterstorun = getQuarters( $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
print_r( $quarterstorun );
$pos = $search[peakchart];
if( $pos && strpos( $pos, "client-" ) === false )
    $pos = "<" . $pos;

if( $search[comparisonfilter] == "Weeks at Number 1")
{
	$pos = "<1";
}
if( $search["comparisonfilter"] == "#1 Hits" )
{
	$pos = 1;
}

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


$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], $pos );

file_put_contents( "/tmp/currserach", print_r( $search, true ) );
file_put_contents ("/tmp/currserach", "qtorun: " . print_r( $quarterstorun, true ) . "\n ", FILE_APPEND );
file_put_contents ("/tmp/currserach", "found: " . print_r( $allsongs, true ) . "\n ", FILE_APPEND );
file_put_contents ("/tmp/currserach", "found: " . count( $allsongs ) . " songs\n ", FILE_APPEND );
//print_r( $allsongs );
//exit;
// file_put_contents( "/tmp/currserach", print_r( $search, true ) );
// file_put_contents ("/tmp/currserach", "found: " . print_r( $allsongs, true ) . "\n ", FILE_APPEND );
// file_put_contents ("/tmp/currserach", "found: " . count( $allsongs ) . " songs\n ", FILE_APPEND );
$acrossthetop = getAcrossTheTopComparison( $search );

//print_r( $acrossthetop );
$rows = getRowsComparison( $search, $allsongs );

// file_put_contents( "/tmp/rows", print_r( $rows, true ), FILE_APPEND );
//print_r( $rows );
//exit;
?>
<style>
.search-body #comp-search-table th, .search-body #comp-search-table td {
    width: 8%!important;
}
</style>

	<div class="site-body">
        <? include "searchcriteria-comparative.php"; ?>
		<section class="search-results-bottom">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
<? $str = "BENCHMARK: " . strtoupper( $possiblecomparisonfilters[$search[comparisonfilter]] ); ?>
                          <h1><?=getOrCreateCustomTitle( $str . "- CSR", $str )?></h1>
                        <br>

                     
                        
					</div><!-- /search-header -->
					<div class="search-body">
                        
                        
                            <div class="graph-head" >                       

                                 <div class="left set" style="margin-bottom:20px;">  
                                      <div class="icon download">
                                    <a href="#" id="exportjpg" onclick="return false" class="" style=""> Download</a>

                                         </div>
    <? if( !isStudent() && !isEssentials() ) { ?>
                                       <div class="icon save">
                                                         <a href="#" data-featherlight="#searchlightbox">Save Search</a></div>
<? } ?>
                                                             <div class="icon email ">
                                                                 <a href='#'  onClick='javascript: maillink("<?=$possiblesearchfunctions[$search[comparisonaspect]]?> - <?=$rangedisplay?>"); return false;' >Email</a></div>
                                         <div class="icon copy ">
                                                                 <a href='#' id="copylink" onClick="javascript: shorturl2(); return false;" >Copy Link</a></div>
                                </div>   

    
    
                             <div class="right set" >  
                                <span class='showall' style="display:none" >   
                            <? if( $graphtype != "column" ) { ?>

                                    <div class="icon show-all ">
                                                                <a href='#' onClick='showAllGraph( true ); return false'>Show All</a></div>

                                    <div class="icon hide-all ">
                                                             <a href='#' onClick='showAllGraph( false ); return false' >Hide All</a></div>

                                  </span>                   
                            <? } ?>
                                     

                                           <div class="icon back-search ">
                                               <a  class=" desktop" href="<?=$thetype=="industry"?"trend-search-staying-power.php":"comparative-search.php"?>?<?=$_SERVER['QUERY_STRING']?>" >Back</a></div>

                                                   <div class="icon new-search ">

                                          <a href="https://analytics.chartcipher.com/<?=$thetype=="industry"?"trend-search-staying-power":"comparative-search"?>" >New Search</a> </div>


                            </div>
                        </div>

						<table width="100%" id="comp-search-table">
                                       <tr><td colspan='4'>
<span style="display:none" id="hiddentitle"><?=$str?> <br></span><?=$period?>
<? if( $search[dates][season] ) { ?>
<?=$seasonswithall[$search[dates][season]]?>
<? } ?>


                                </td></tr>
							<tr>
								<th class="comp-search-header-1 sortablecol">
<?=getComparisonColumnName( $possiblecomparisonaspects[$search[comparisonaspect]] )?>
								</th>
<? foreach( $acrossthetop as $aid=>$aval ){ ?>
								<th class="sortablecol">
                                            <?=getComparisonDisplayValue( $aval, $search[comparisonfilter] )?>
								</th>
                                            <? } ?>
							</tr>
                            <?php
                            $sortedrows = array();
                            foreach( $rows as $rid=> $rowval ) {

                                $calcedrow = array();
                                $anynonzero = false;
                                $key = "";
                                foreach( $acrossthetop as $aid=>$aval ){
                                    list( $val, $numsongs ) = getComparisonPercentage( $search["comparisonfilter"], $search["comparisonaspect"], $aid, $rid, $allsongs, true );
                                    if( $search[comparisonfilter] == "Songs" )
                                    {
                                        if( $val != "0%" )
                                            $val = "X";
                                        else
                                            $val = "&nbsp;";
                                    }

                                    $calcedrow[$aid] = array( $val, $numsongs );
                                    if( $val != "0%" && $val != "&nbsp;" ) $anynonzero = true;
                                    if( !$key )
                                        $key = str_pad( 1000 - str_replace( "%", "", $val ), 3, "0", STR_PAD_LEFT ) . "_" . $rowval;
                                }
				//				echo( "$rid, " . print_r( $calcedrow, true ) . "\n\n" );
                                if( !$anynonzero )
                                {
                                    continue;
                                }
                                $sortedrows[ $key ] = array( $rid, $rowval, $calcedrow );
                              }

file_put_contents( "/tmp/comp", print_r( $sortedrows, true ) , FILE_APPEND);
$namegetslinked = false;
if( $thetype == "industry" )
{
//    $namegetslinked = true;
    if( $search[comparisonfilter] != "Songs" )
        ksort( $sortedrows );
}

foreach( $sortedrows as $rid=> list( $rid, $rowval, $calcedrow ) )
{
    $first = true;
                                ?>
							<tr>
<? foreach( $acrossthetop as $aid=>$aval ){

        if( $first ) {
                                    ?>
								<td data-label="Song" class="comp-search-column-1 sortablerow">
                <? if( $calcedrow[$aid][0] != "&nbsp;" && $namegetslinked && ( strpos( $calcedrow[$aid][0], "0%" ) || strpos( $calcedrow[$aid][0], "0%" ) === false ) ) { ?>
                                            <A href='<?=getComparisonURL( $search, $aid, $rowval )?>'>
                                            <?=getComparisonDisplayValue( $rowval, $search[comparisonaspect] )?></a>
                                          <?  } else if( $search[comparisonaspect] != "Songs" && $thetype == "industry" ) { 
	$url = getArtistUrl( $rowval );
	echo( "<a href='/$url'>$rowval</a>" );
?>

<? } else { ?>
                <?=getComparisonDisplayValue( $rowval, $search[comparisonaspect] )?>
                    <? } ?>
								</td>
                                    <? }
        $first = false;
        ?>
								<td class=" sortablerow">
                <? if( !$namegetslinked && ( strpos( $calcedrow[$aid][0], "0%" ) || strpos( $calcedrow[$aid][0], "0%" ) === false ) ) { ?>
                                            <A href='<?=getComparisonURL( $search, $aid, $rowval )?>'><?=$calcedrow[$aid][0]?></a>
						   <? if( $calcedrow[$aid][1] && $search[comparisonfilter] != "Songs" && $search[comparisonfilter] != "Weeks in the Top 10" ) { ?>
                                                   (<?=$calcedrow[$aid][1]?>)
<? } ?>
                            <? } else { ?>
                                                   <?=$calcedrow[$aid][0]?>
                <? } ?>
								</td>
<? } ?>
							</tr>
                                  <? } ?>
                               <tr ><td colspan='400' class="foot" >&copy; <?=date( "Y")?> Chart Cipher. All rights reserved.</td></tr>
						</table>


                        <div class="search-footer">
							<div class="search-footer-left span-3">
							
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
										<a class="black-btn" href="#" onClick='javascript:saveSearch( "saved", "Comparative" ); return false'>SAVE</a>
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
		var searchType = "<?=$searchtype?$searchtype:"Comparative"?>";
	var searchName = "<?=strtoupper( $thetype )?> STAYING POWER: <?=strtoupper( $search[comparisonfilter] )?>";

saveSearch( "recent" );

$(document).ready(function(){
        $("a.expand-btn").click(function(){
            $("a.expand-btn").toggleClass("collapse-btn");
            $("#search-hidden").toggleClass("hide show");
        });
    });
    $(document).ready(function(){
                $("#exportjpg").click(function(){
	    	    $("#hiddentitle").css( "display", "" );
                    $('#comp-search-table').tableExport({type:'png',escape:'false'});
		    setTimeout(function(){ $("#hiddentitle").css( "display", "none" ); }, 500);
  	            ;
                });

        });



    </script>
<?php include 'sortingjavascript.php';?>
<?php include 'footer.php';?>
