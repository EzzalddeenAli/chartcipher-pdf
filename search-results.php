<?php 
include 'header.php';

if( !$_SESSION["loggedin"] ) {
//    Header( "Location: index.php" );
//    exit;
}

$newsearchlink = "/";

if( !$newcarryfilter ) $newcarryfilter = $search["newcarryfilter"];
$logtype = "advanced search results";
$searchurl = getSavedSearchUrl( $searchtype );
$searchurl .= "?" . $_SERVER['QUERY_STRING'];
$basesearchurl = getSavedSearchUrl( $searchtype );
$season = $search[dates][season];
if( $_SERVER["HTTP_REFERER"] )
{
    $searchurl = $_SERVER["HTTP_REFERER"];
    if( strpos( $searchurl, "?" ) === false )
        $searchurl .= "?" . $_SERVER['QUERY_STRING'];

}

   	$urldatestr = "&search[dates][fromq]=" . $search[dates][fromq]. "&search[dates][toq]=" . $search[dates][toq];
	$urldatestr .= "&search[dates][fromy]=" . $search[dates][fromy]. "&search[dates][toy]=" . $search[dates][toy];

?><form method='post'>
	<div class="site-body">
<? include "chartchooser.php"; ?>                
      <? include "searchcriteria.php"; ?>
<? $searchresults = getSearchResults( $search ); ?>
		<section class="search-results-bottom">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1>SEARCH RESULTS (<?=count( $searchresults )?>)</h1>
					
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
                        <div class="graph-head">                       

     <div class="left set" style="margin-bottom:20px;">  
     
    <? if( !isStudent() && !isEssentials() ) { ?>
                         <div class="icon save">
                             <a href="#" data-featherlight="#searchlightbox">Save Search</a></div>
<? } ?>                        
                       
                       
                                 <div class="icon email ">
                                     <a href="#" onclick="javascript: maillink(&quot;Song Length Range - 2013 - 2019&quot;); return false;">Email</a></div>
                   <div class="icon copy ">
                                     <a href="#"  id="copylink" onclick="javascript: shorturl2(); return false;">Copy Link</a></div>
                                          
    </div>   
    
    
    
       <div class="right set" style="margin-bottom:20px;">  
                  
               <div class="icon back-search ">
                   <a class=" desktop" href="<?=$searchurl?>">Back</a></div>
                        

    
    </div>
                        </div>
                        
						<h3>Select a song below to view details.</h3>
						<table width="100%" id="search-results-table">
							<tr>
								<th class="sortablecol">
									Song 
    <i>(click to sort)</i>

								</th>
								<th class="sortablecol">
									Artist
    <i>(click to sort)</i>

								</th>
								<th class="sortablecol">
									Date Entered the <?=$chartname?>
    <i>(click to sort)</i>

								</th>
								<th class="sortablecol">
									Peak Chart Position
    <i>(click to sort)</i>


								</th>
<? if( $showdates ) { ?>
								<th>
									Dates
								</th>
<? } ?>
							</tr>
<? foreach( $searchresults as $r ) { ?>
							<tr>
								<td data-label="Song" class="search-column-1 sortablerow">
										<?=$r[BillboardName]?>
<? 
if( isRachel() ) echo( "($r[id])" );
 ?>
								</td>
								<td data-label="Artist" class="search-column-2 sortablerow">
										<?=$r[BillboardArtistName]?>

<?
$chartinfo = getChartInfo( $r[id], $chartid );
 ?>
								</td>
								<td data-label="DateEntered" class="search-column-2 sortablerow">
<?=$chartinfo["WeekEnteredTheTop10"]?>
								</td>
								<td data-label="Peak" class="search-column-2 sortablerow">
<?=$chartinfo["PeakPosition"]?>
								</td>
<? if( $showdates ) { ?>
								<td data-label="Dates" class="search-column-5">
<? $dates = db_query_array( "select Name, type from weekdates w, song_to_weekdate where weekdateid = w.id and songid = $songid order by OrderBy", "Name", "type" ); 
foreach( $dates as $name=>$type )
{
$pos = str_replace( "position", "", $type );
echo( "$name ($pos)<br>" );
}
?>										

								</td>
<? } ?>
							</tr>
<? } ?>

<? if( !count( $searchresults) ) { ?>
							<tr>
								<td data-label="Song" class="search-column-1">
								No Matches.								</td>
								<td data-label="Artist" class="search-column-2">
								</td>
								<td data-label="DateEntered" class="search-column-2">
								</td>
								<td data-label="Peak" class="search-column-2">
								</td>
								<td data-label="Listen" class="search-column-3">

								</td>
<? if( $showdates ) { ?>
								<td data-label="Dates" class="search-column-5">

								</td>
<? } ?>
								<td data-label="Official Video" class="search-column-4">
								</td>
							</tr>
<? } ?>

						</table>
						
						<div class="search-footer">
							<div class="search-footer-left span-3">
								
								<div class="cf"></div>
							</div><!-- /search-footer-left -->
    <? if( !isStudent() && !isEssentials() ) { ?>
							<div class="search-footer-right span-4">
								<a class="black-btn" href="#" data-featherlight="#searchlightbox">SAVE SEARCH</a>
								<a class="orange-btn" href="<?=$basesearchurl?>">NEW SEARCH</a>
								<div class="lightbox" id="searchlightbox">
									<div class="save-search-header">
										<h1>SAVE SEARCH</h2>
									</div><!-- /.save-search-header -->
									<div class="save-search-body">
										<label>Name:</label>
										<input type='text' name="searchname" id='searchname' onChange='javascript:document.getElementById( "searchnamehidden").value = this.value; '>
										<a class="black-btn" href="#" onClick='javascript:saveSearch( "saved", "" ); return false'>SAVE</a>
										<div class="cf"></div>
									</div><!-- /.save-search-body -->
								</div><!-- #searchlightbox -->
							</div><!-- /search-footer-right -->
                            <? } ?>
							<div class="cf"></div>
						</div><!-- /.search-footer -->
					</div><!-- /search-body -->
				</div><!-- /.search-container -->
			</div><!-- /.row -->
		</section><!-- /.search-results-bottom -->
	</div><!-- /.site-body -->
      <input type='hidden' name="searchnamehidden" id='searchnamehidden'>
	<script>
	$(document).ready(function(){
	    $("a.expand-btn").click(function(){
	        $("a.expand-btn").toggleClass("collapse-btn");
	        $("#search-hidden").toggleClass("hide show");
                return false;
	    });
	});
	var sessid = "<?=session_id()?>";
	var searchType = "<?=$searchtype?>";
<? 
$searchname = "";
if( $searchtype == "Record Label" )
    $searchname = $search[label];
if( $searchtype == "Songwriter" )
    $searchname = $search[writer];
if( $searchtype == "Song Title" )
    $searchname = $search[songname];
if( $searchtype == "Performing Artist" )
    $searchname = $search[primaryartist];
?>
	var searchName = "<?=$searchname?>";

if( searchType != "Browse" )
 	saveSearch( "recent" );
var nextUrl = "/<?=$r[CleanUrl]?>";
	</script>	
<?php include 'sortingjavascript.php';?>    
<?php include 'footer.php';?>
