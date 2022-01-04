<?php
//exit;
$displaytype = "Songwriter";
$type = "creditedsw";
$statype = " and ( sta.type ='creditedsw' ) ";
$type = " and ( type ='creditedsw' ) ";
$stype = "writer";

if( $searchsubtype == "performingartists" || $searchsubtype == "artists"  )
{
    $displaytype = "Artist";
    if( $_GET["searchcriteria"]["featuredmain"] )
	{
	    $statype = " and ( sta.type ='" . $_GET["searchcriteria"]["featuredmain"] . "' ) ";
	    $type = " and ( type ='" . $_GET["searchcriteria"]["featuredmain"] . "' ) ";
	    $stype = "primaryartist".$_GET["searchcriteria"]["featuredmain"];
	}
    else
	{
	    $statype = " and ( sta.type ='primary' or sta.type = 'featured' ) ";
	    $type = " and ( type ='primary' or type = 'featured' ) ";
	    $stype = "primaryartist";
	}
    
}
if( $searchsubtype == "producers" || $searchsubtype == "producers"  )
{
    $displaytype = "Producer";
    $type = "";
    $statype = "";
    $stype = "producer";
    
}
if( $searchsubtype == "labels"  )
{
    $displaytype = "Record Label";
    $type = "";
    $statype = "";
    $stype = "label";
    
}
if( $searchsubtype == "forms" || $search[comparisonaspect] == "Number of Songs (Form)")
{
	$displaytype = "Song Form";
	$type = "";
$statype = "";
$stype = "fullform";
}


$secondcol = $search[comparisonaspect]; 
if( $search["peakchart"] && $str == "Number of Weeks" )
    {
	$secondcol = "Weeks at Selected Peak Chart Position";
    }

$rightcolumnclickable = false;
if( strpos( $search[comparisonaspect], "Number" ) === false )
    {
	$rightcolumnclickable = true;
	$displaytype = $search[comparisonaspect];
	$secondcol = "Number of Songs";
	if( strpos( $displaytype, "Producer" ) !== false )
	    $stype = "producer";
	if( strpos( $displaytype, "Songwriter" ) !== false )
	    $stype = "writer";
	if( strpos( $displaytype, "Label" ) !== false )
	    $stype = "writer";
	if( strpos( $displaytype, "Artist" ) !== false )
	    $stype = "primaryartist";

    }

$qs = "";
if( !$nodates )
{
    $qs .= "search[dates][fromq]={$search[dates][fromq]}&";
    $qs .= "search[dates][fromy]={$search[dates][fromy]}&";
    $qs .= "search[dates][toq]={$search[dates][toq]}&";
    $qs .= "search[dates][toy]={$search[dates][toy]}&";
}
    if( $search[specificsubgenre] )
        $qs .= "search[specificsubgenre]={$search[specificsubgenre]}&";

    if( $search[dates][season] )
        $qs .= "search[dates][season]={$search[dates][season]}&";
    if( $search[writer] )
        $qs .= "search[writer]={$search[writer]}&";
    if( $search[producer] )
        $qs .= "search[producer]={$search[producer]}&";
    if( $search[primaryartist] )
        $qs .= "search[primaryartist]={$search[primaryartist]}&";


$qs .= "search[peakchart]={$search[peakchart]}&";
if( $search[artistid] )
    if( $_GET[searchcriteria]["artistid"] )
    {
        if( $_GET[searchcriteria]["artisttype"] == "writer")
            $qs .= "search[writer]={$_GET[searchcriteria][artistid]}&";
        else if( $_GET[searchcriteria]["artisttype"] == "producer")
            $qs .= "search[producer]={$_GET[searchcriteria][artistid]}&";
        else
            $qs .= "search[primaryartist]={$_GET[searchcriteria][artistid]}&";
        
    }
if( $genrefilter )
            $qs .= "search[GenreID]={$genrefilter}&";
if( $producerfilter )
            $qs .= "search[producerid]={$producerfilter}&";
if( $labelfilter )
            $qs .= "search[labelid]={$labelfilter}&";
if( $searchclientid )
            $qs .= "searchclientid={$searchclientid}&";

if( $newcarryfilter == "new" )
    $qs .= "search[toptentype]=New+Songs&";
if( $newcarryfilter == "carryover" )
    $qs .= "search[toptentype]=Carryovers&";


$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], $pos );

$allsongs[] = -1;
$allsongstr = implode( ",", $allsongs );
//exit;

$showmore = 0;
if( $searchsubtype == "producers" )
{
    $showmore = 1;
	$rightcolumnclickable = true;
    $isproducer = 1;
}
if( $searchsubtype == "performingartists" )
{
	$rightcolumnclickable = true;
    $showmore = 1;
}
if( $searchsubtype == "songwriters" )
{
    $showmore = 1;
	$rightcolumnclickable = true;
}
if( $searchsubtype == "labels" )
{
	$rightcolumnclickable = true;
    $showmore = 1;
    $islabel = 1;
}
if( $searchsubtype == "forms" || $search[comparisonaspect] == "Number of Songs (Form)" )
{
    $isforms = 1;
}




?>


<style type="text/css">
	.search-header h1{ float:none; }
	.search-header h2{
    margin-top: 15px;
    color: #7a7a7a;
    font-size: 14px;
	}
    
</style>
                <? if( !$thetype ) $thetype = $searchsubtype; ?>
	<div class="site-body">
        <? include "searchcriteria-trend.php"; ?>
		<section class="search-results-bottom">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
<? $str = getOrCreateCustomTitle( "TSRT - TREND SEARCH: " . strtoupper( getSearchTrendName( $search[comparisonaspect] ) ), "TREND SEARCH: " . strtoupper( getSearchTrendName( $search[comparisonaspect] ) ) ); ?>
    <h1><?=$str?></h1>
        <a style="display:none;" href='#' id="exportjpgold" onClick='return false'  class="save-header-back">Save As Image</a>
					
            <?=$search[comparisonfilter]?>
<!--                     	<h2>
            <?php
            $key = "TREND SEARCH - " . $search[comparisonaspect] . " - " . $searchsubtype . "";
if( $_GET["showkey"] ) echo( "<font color='red'>$key</font><br><Br>" ); 
            $custom = getOrCreateCustomHover( $key, "This search reflects trends occurring within songs that have charted among the Billboard Hot 100 Top Ten." ); 
$custom = "";
?><br><br>
        <?=$custom?$custom:""?>
                                   </h2>

-->
 
					
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
                        
                        
                        <div class="graph-head" >                       

     <div class="left set" style="margin-bottom:20px;">  
         <div class="icon download">
        <a href='#' id="exportjpg" onClick='return false' class="" style=""> Download</a>
             
             </div>
    <? if( !isStudent() && !isEssentials() ) { ?>
                         <div class="icon save">
                             <a href="#" data-featherlight="#searchlightbox">Save Search</a></div>
                        <? }  ?>
                       
                                 
                                 <div class="icon email ">
                                     <a href='#'  onClick='javascript: maillink("<?=$possiblesearchfunctions[$search[comparisonaspect]]?> - <?=$rangedisplay?>"); return false;' >Email</a></div>
         <div class="icon copy ">
                                     <a href='#'  id="copylink" onClick="javascript: shorturl2(); return false;" >Copy Link</a></div>
                           
         
         
         
                         <div class="icon share" style="display:none">
                             <a href='#' >Share</a>
                             <div class="subset hidden">
                                 
                                 <div class="icon email">
                                     <a href='#'  onClick="javascript: maillink('Subject goes here'); return false;" >Email</a></div>
                                 <div class="icon copy">
                                     <a href='#'  onClick="javascript: shorturl2(); return false;" >Copy Link</a></div>
                            </div>
         
                        </div>
                  
                        
    </div>   
    
    
    
       <div class="right set" style="">  

               <div class="icon back-search ">
                   <a  class=" desktop" href="trend-search<?=$thetype?"-$thetype":""?>.php?<?=$_SERVER['QUERY_STRING']?>" >Back</a></div>
                        
                       <div class="icon new-search ">
                           <a href="search-for-<?=$fromlink?$fromlink:"industry"?>-trends.php"  style="display:none;">New Search</a> 
           
              <a href="/search-for-<?=$fromlink?$fromlink:"industry"?>-trends.php" >New Search</a> </div>

    
    </div>
                        </div>
                        
                        
                        
                        
                        

<!-- table goes here -->

						<table width="100%" id="comp-search-table">
                                       <tr><td colspan='4'>
<span style="display:none" id="hiddentitle"><?=$str?> <br></span><?=$period?>
<? if( $doingyearlysearch ) { ?>

                               <?=$search[dates][fromyear]?>
                         <? if( $search[dates][toyear] ) { ?>
                                                        to <?=$search[dates][toyear]?>
                                                        <? } ?>
<? } else { ?>
                               Q<?=$search[dates][fromq]?>/<?=$search[dates][fromy]?>
                         <? if( $search[dates][toq] ) { ?>
                                                        to Q<?=$search[dates][toq]?>/<?=$search[dates][toy]?>
                                                        <? } ?>
<? } ?>
                                
                         <? if( $search[dates][season] ) { ?>
                                                        (<?=$seasons[$search[dates][season]]?>)
                                                        <? } ?>
                                </td></tr>
							<tr>

				    <? if( $shownum ) { ?>
								<th class="sortablecol">
#
</th>
					  <? } ?>
								<th class="comp-search-header-1 sortablecol">
<?=$displaytype?>
    <i>(click to sort)</i>
								</th>
								<th class="sortablecol">
<?=$secondcol?>
    <i>(click to sort<? if( $rightcolumnclickable ) { ?>, click on number for songs<?}  ?>)</i>
								</th>
    <? if ( $showmore ) { ?>
			  <th>&nbsp;</th>
			  <? } ?>
							</tr>
                            <?php

                $tmprows = array();
$rows = getRowsComparison( $search, $allsongs );

$possweekdates = implode( ", ", getWeekdatesForQuarters( $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] ) );


$peakchartstr = "";
if( $search["peakchart"] ) 
    {
    if( !$search[chartid] )
	{
	    $positiononly = str_replace( "<", "", $search["peakchart"] );
	    $tmp = array();
	    for( $i = 1; $i <= $positiononly; $i++ )
		{
		    $tmp[] = "'position{$i}'";
		}
	    $tmp = implode( ", ", $tmp );
	    $peakchartstr = " and stw.type in ( $tmp )";
	}
    else
	{
	    $positiononly = str_replace( "<", "", $search["peakchart"] );
	    $tmp = array();
	    for( $i = 1; $i <= $positiononly; $i++ )
		{
		    $tmp[] = "{$i}";
		}
	    $tmp = implode( ", ", $tmp );
	    $peakchartstr = " and stw.rank in ( $tmp )";
	}
    }
$allbardata = array();


foreach( $rows as $rid=> $rowval ) {
    $exp = explode( "_", $rid );
    $isartist = !$isforms && ($exp[0] == "artist" || count( $exp ) == 1 );
    //    file_put_contents( "/tmp/querylog", "exp:" . print_r( $exp, true ) . "\n" , FILE_APPEND );
    
    $rid = array_pop( $exp );
    if( $search[comparisonaspect] == "Number of Songs" || $search[comparisonaspect] == "Number of Songs (Form)" )
    {
        if( $islabel )
        {
            $num = db_query_first_cell( "select count( distinct( songid ) ) from song_to_label sta where songid in ( $allsongstr ) $type and labelid = $rid " );
        }
	else if( $isforms )
        {
            $num = db_query_first_cell( "select count( distinct( id ) ) from songs where id in ( $allsongstr ) and SongStructure = '$rid' " );
        }
        else if( $isproducer )
        {
            $num = db_query_first_cell( "select count( distinct( songid ) ) from song_to_producer sta where songid in ( $allsongstr ) $type and producerid = $rid " );
        }
        else if( $isartist )
            $num = db_query_first_cell( "select count( distinct( songid ) ) from song_to_artist sta where songid in ( $allsongstr ) $type and artistid = $rid " );
        else
            $num = db_query_first_cell( "select count( distinct( songid ) ) from song_to_group sta where songid in ( $allsongstr ) $type and groupid = $rid " );
    }
    else if( $search[comparisonaspect] == "Number of Weeks" )
    {
	$weekdatepart = " and stw.weekdateid in ( $possweekdates ) ";
	if( $nodatestable )
	    $weekdatepart = "";

        if( $isproducer )
        {
            $sql = "select count( distinct( weekdateid ) ) from song_to_weekdate stw, song_to_producer sta where sta.songid in ( $allsongstr ) $statype and producerid = $rid and sta.songid = stw.songid $peakchartstr $weekdatepart ";
            $num = db_query_first_cell( $sql );
        }
        else if( $islabel )
        {
            $sql = "select count( distinct( weekdateid ) ) from song_to_weekdate stw, song_to_label sta where sta.songid in ( $allsongstr ) $statype and labelid = $rid and sta.songid = stw.songid $peakchartstr $weekdatepart ";
            $num = db_query_first_cell( $sql );
        }
        else if( $isforms )
        {
            $sql = "select count( distinct( weekdateid ) ) from song_to_weekdate stw, songs sta where sta.id in ( $allsongstr ) and SongStructure = '$rid' and sta.id = stw.songid $peakchartstr $weekdatepart ";
            $num = db_query_first_cell( $sql );
        }
        else
        {
	    //            $isartist = db_query_first_cell( "select id from artists where Name = '" . escMe( $rowval ) ."'" );
	    if( $_GET[searchcriteria]["artisttype"] == "writer" || $searchsubtype == "songwriters")
		$statype = " and sta.type in ( 'creditedsw' )";
	    else
		{
		$statype = " and sta.type in ( 'featured', 'primary' )";
		}


            if( $isartist )
		{
		    $thissongs = implode( ", " , db_query_array( "select distinct( songid ) from song_to_artist sta where artistid = $rid and songid in ( $allsongstr ) $statype" , "songid", "songid" ) );
		}
            else
		{
		    $thissongs = implode( ", " , db_query_array( "select distinct( songid ) from song_to_group sta where groupid = $rid and songid in ( $allsongstr ) $statype" , "songid", "songid" ) );
		}

	    if( !$thissongs ) $thissongs = "-1";
	    $sql = "select count( distinct( weekdateid ) ) from song_to_weekdate stw where songid in ( $thissongs )  $weekdatepart  $peakchartstr  ";
            $num = db_query_first_cell( $sql );

            if( $_GET["help"] )
                echo( $sql. "<br>" );
        }
    }
    else
	{
	    if( !count( $allbardata ) )
		{
		$allbardata = getBarTrendDataForRows( $search[comparisonaspect], $search["peakchart"], $allsongs );
		}
	    $num = $allbardata[$rid][4];
	}

// we do 1000 - here so we will get the biggest ones first and can then alphabetize
    $key = str_pad( 1000 - $num, 3, "0", STR_PAD_LEFT ) . "_" . $rowval;
    $tmprows[ $key ] = array( $rid, $rowval, $num );
}
ksort( $tmprows );
$alltotal = 0;
foreach( $tmprows as list( $rid,  $rowval, $num ) ) {
                                ?>
							<tr>
				    <? if( $shownum ) { 
	$nummembers = 0;
	$gid = db_query_first_cell( "select id from groups where Name = '" . escMe( $rowval ) . "' and id = $rid" );
	if( !$gid )
	    {
		$gid = db_query_first_cell( "select id from artists where Name = '" . escMe( $rowval ) . "' and id = $rid" );
		$nummembers = db_query_first_cell( "select count(*) from artist_to_member where artistid = $gid" );
		$numfemale = db_query_first_cell( "select count(*) from artist_to_member, members where members.id = memberid and MemberGender = 'Female' and artistid = $gid" );
		$nummale = db_query_first_cell( "select count(*) from artist_to_member, members where members.id = memberid and MemberGender = 'Male' and artistid = $gid" );
	    }
	else
	    {
		$nummembers = db_query_first_cell( "select count(*) from group_to_member where groupid = $gid" );
		$numfemale = db_query_first_cell( "select count(*) from group_to_member, members where members.id = memberid and MemberGender = 'Female' and groupid = $gid" );
		$nummale = db_query_first_cell( "select count(*) from group_to_member, members where members.id = memberid and MemberGender = 'Male' and groupid = $gid" );
	    }
	$alltotal += $nummembers;
	$err = ($numfemale + $nummale) != $nummembers?"<font color='red'>ERROR, SOMEONE IS MISSING A GENDER</font>":"";
	echo( "<td>" . $nummembers . " ( $numfemale Female, $nummale Male ) $err</td>" );

?>
	<? } ?>
								<td data-label="Song" class="comp-search-column-1  sortablerow">
	<? if( !$rightcolumnclickable ) { ?>
<A href='search-results?<?=$qs?>&search[<?=$stype?>]=<?=urlencode( $rowval )?>'><?=$rowval?></a>
					  <? } else { ?>
<?=$rowval?>
	<? } ?>
								</td>
								<td data-label="Song" class="comp-search-column-2 sortablerow">
                                
	<? if( !$rightcolumnclickable ) { ?>
<?=$num?>
					  <? } else { ?>
<A href='search-results?<?=$qs?>&search[<?=$stype?>]=<?=urlencode( $rowval )?>'><?=$num?></A>
	    <? } ?>
								</td>
    <? if ( $showmore ) { 
	$url = getArtistUrl( $rowval );
?>
<td><a href='/<?=$url?>?<?=getDateStrForArtist()?>'>More About <?=$rowval?></a></td>
									  <? } ?>
							</tr>
                                  <? } ?>
				      <? if( $shownum ) { ?>

    <tr><td>TOTAL: <?=$alltotal?></td></tr>
    <? } ?>
				      <tr ><td colspan='400' class="foot" >&copy; <?=date( "Y")?> Chart Cipher. All rights reserved.</td></tr>
						</table>
                             

<!-- end table -->

                        <div class="search-footer">
							<div class="search-footer-left span-3">
								
								<div class="cf"></div>
							</div><!-- /search-footer-left -->
							<div class="search-footer-right span-4">
    <? if( !isStudent() && !isEssentials() ) { ?>
    <a class="black-btn" href="#" data-featherlight="#searchlightbox">SAVE SEARCH</a>
                            <? } ?>
								<a class="orange-btn" href="/trend-search<?=$thetype?"-$thetype":""?>">NEW SEARCH</a>
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
		</section><!-- /.search-results-bottom -->
	</div><!-- /.site-body -->
      <input type='hidden' name="searchnamehidden" id='searchnamehidden'>
    <script>
		var sessid = "<?=session_id()?>";
		var searchType = "<?=$searchtype?$searchtype:"Trend"?>";
	var searchName = "TREND SEARCH: <?=strtoupper( getSearchTrendName( $search[comparisonaspect] ) )?>";

saveSearch( "recent" );
$(document).ready(function(){
        $("a.expand-btn").click(function(){
            $("a.expand-btn").toggleClass("collapse-btn");
            $("#search-hidden").toggleClass("hide show");
        });
    });
    $(document).ready(function(){
            $("#exportjpg").click(function(){
//                    $(".showme").css( "display", "" );
	    	    $("#hiddentitle").css( "display", "" );
                    $('#comp-search-table').tableExport({type:'png',escape:'false'}); 
		    setTimeout(function(){ $("#hiddentitle").css( "display", "none" ); }, 500);
//                    $(".showme").css( "display", "none" );
                });

        });

    </script>
<?php include 'sortingjavascript.php';?>    

    
<?php include 'footer.php';?>
