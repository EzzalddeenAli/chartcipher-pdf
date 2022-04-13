<?php 
$istrendreport = true;
$doinghomepage = 1;
file_put_contents( "homequeries", date( "H:i:s" ) . ", starting homepage\n", FILE_APPEND );

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


include "trendfunctions.php";

include "trendreportfunctions.php";


include 'header.php'; 

if( date( "m" ) <= 3 )
    $fq = 1;
else if( date( "m" ) <= 6 )
    $fq = 2;
else if( date( "m" ) <= 9 )
    $fq = 3;
else
    $fq = 4;

$qarr = array( $fq . "/" . date( "Y" ) );
$tmpq = getPreviousQuarter( $fq . "/" . date( "Y" ) );
$qarr[] = $tmpq;
for( $i = 0; $i < 2; $i ++  )
    {
	$tmpq = getPreviousQuarter( $tmpq );
	$qarr[] = $tmpq;
    }
$exp = explode( "/", $tmpq );
$search["dates"]["fromq"] = $exp[0]; 
$search["dates"]["fromy"] = $exp[1];
$search["dates"]["toq"] = $fq; 
$search["dates"]["toy"] = date( "Y" );

$_GET["search"] = $search;

$wd = getSetting( "homepageweek" );
$dt = db_query_first_cell( "select Name from weekdates where id = $wd" );
$wdorderby = db_query_first_cell( "select OrderBy from weekdates where id = $wd" );
if( !$_GET["graphtype"] ) $_GET["graphtype"] = "line";
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

	<div class="site-body index-pro new2020">
        <section class="home-top">
			<div class="element-container row">
                
                 <div class="row  row-equal row-padding mobile link-alt">
                            <div class="col-12">
                         <div class="header-inner " >
                        <h1>Chart Cypher Style Sheet</h1>
                <br>

<h2 style="color:black;">Header Styles</h2>
                             <br>
                
    <hr>
<h1 style="margin-bottom:40px;">H1:Poppins, SemiBold, 18pt, #8b26b2</h1>
         <br>                    
<h2 style="margin-bottom:40px;">H2:Poppins, Regular, 16pt, #8b26b2</h2>
                             <br>
<h3 style="margin-bottom:40px;">H3:Poppins, Regular, 14pt, #8b26b2</h3>
                             <br>
                             
<h4 style="margin-bottom:40px;">H4:Poppins, Regular, 15pt, #333333(report list sub-headers)</h4>
                             
                             <br>
                             
      <br>  <br>                         
 <h2 style="color:black;">Paragraph Styles</h2>
                               <br>
                
    <hr>
 <h3 style="color:#000000;">Basic</h3>  
                             <br>
   <p class="basic" style="margin-bottom:100px;">Poppins, Regular, 13pt, #7a7a7a, Line Spacing 26pt.</p>    
                             
                             
                             <br>
  <h3 style="color:#000000;">Highest level reporting</h3>             
                              <br>
<p class="highest-level-report" style="margin-bottom:100px;">Poppins , Regular, 14pt, #333333 , Line Spacing 26 (highest levels report)</p>
                               <br>
 <h3 style="color:#000000;">Report Lists, Landing pages</h3>  
                              <br>
<p class="report-list" style="margin-bottom:100px;">Poppins, Light, 14pt, #333333, Line Spacing 24(report list, landing pages with 4squares)</p>                     
<br>                
<h3 style="color:#000000;">Homepage chart lines</h3>
                             <br>
                             <p>Poppins ,light, 16pt, #333333, Line Spacing 48pt (home page charts)</p>
                      
                             <br>
     <table class="table-charts" style="margin-bottom:100px;">
                            <tbody><tr>
                                <td><a href="home" class="rowlink">item name</a></td>
                                <td> </td>
                            </tr>
                                <tr>
                                    <td><a href="home" class="rowlink">item name</a></td>
                                 <td class="lock"> </td>
                            </tr>
</tbody></table>
                        
<br>
                             
<h3 style="color:#000000;">Characteristics table</h3>
 <p class="characteristics-2"> Poppins, Regular, 14pt, #000000, Line Spacing 42pt (most popular characteristics,new and departing)</p>  
<p class="characteristics-1"> Poppins, Regular, 14pt, #7a7a7a, Line Spacing 42pt(most popular characteristics,new and departing)   </p> 
<div class="row  row-equal row-padding mobile link-alt" style="margin-bottom:100px;">
                            <div class="col-12">
                      
                      <div class="home-search-header  flex-addon">
                                <h3>Most Popular Characteristics</h3>
                           
                            </div>
                         <div class="header-inner ">
                       <table class="table-insights">
                             <thead>
                                 
                              <td></td>
                                 <td>This Week (Date)</td>  
                                 <td>12 Weeks (Date Range)</td>
                                 <td>12 Months (Date Range)</td>
                             </thead>
                            <tbody><tr>
                                <td><a href="home" class="rowlink">Primary Genre</a></td>
                                 <td>Pop(80%)</td>
                                        <td>Hip-Hop(80%)</td>
                                        <td>Hip-Hop(80%)</td>
                   
                            </tr>
                                <tr>
                                    <td><a href="home" class="rowlink">Lyrical Theme</a></td>
                                  <td>Love Relationships(80%)</td>
                                        <td>Lifestyle(80%)</td>
                                        <td>Lifestyle(80%)</td>
                            </tr>
                                
                                   <tr>
                                       <td><a href="home" class="rowlink">Lyrical Mood</a></td>
                                  <td>Nostalgic(80%)</td>
                                        <td>Dramatic(80%)</td>
                                        <td>Dramatic(80%)</td>
                            </tr>
                                
                                   <tr>
                                       <td><a href="home" class="rowlink">Production Mood</a></td>
                                  <td>Happy(75%)</td>
                                        <td>Sad(75%)</td>
                                        <td>Sad(75%)</td>
                            </tr>
                                
                                   <tr>
                                       <td><a href="home" class="rowlink">Dominant Instruments</a></td>
                                  <td>String Section(80%)</td>
                                        <td>Wind Section(80%)</td>
                                        <td>Wind Section(80%)</td>
                            </tr>
                                
                                   <tr>
                                       <td><a href="home" class="rowlink">Major/Minor</a></td>
                                  <td>PMajor(80%)</td>
                                        <td>Minor(80%)</td>
                                        <td>Minor(80%)</td>
                            </tr>
                                
                                   <tr>
                                       <td><a href="home" class="rowlink">Song Length Range</a></td>
                                  <td>Under 3:00(80%)</td>
                                        <td>3:01-3:29(80%)</td>
                                        <td>3:01-3:29(80%)</td>
                            </tr>
                                
                                   <tr>
                                       <td><a href="home" class="rowlink">Average First Chorus</a></td>
                                  <td>0:40(80%)</td>
                                        <td>0:44(80%)</td>
                                        <td>0:44(80%)</td>
                            </tr>
                        </tbody></table>
                        </div><!-- /.header-block-1B -->
                                
                      </div>

</div>
          
                             
                             
                             
<br>
 <div style="margin-bottom:100px;">                           
<h3 style="color:#000000;">Serach Label Text and serach boxes</h3>   
     <br>
<div class="">
<label>Poppins, medium, 12pt, #7a7a7a(search names above the fields)</label>
<select id="comp-select" name="text in search" onchange="fixAspect()">
<option value="">Search box text</option>
<option value="Performing Artist">Performing Artist</option>
                            <option value="Songwriters">Songwriters</option>
                            <option value="Producers">Producers</option>
                            <option value="Record Labels">Record Labels</option>
                            <option value="Songs">Songs</option>
                            <option value="#1 Hits">#1 Hits</option>
                            <option value="Top 10">Top 10</option>
                                                    </select>
</div>
     </div> 
                             
     <br>
                             <h3 style="color:#000000;">Footer Disclaimer</h3>  
                             <br>
                             <p>Poppins, Light, 8pt, #9ca1a9, Line Spacing 12pt (footer disclaimer)</p>
                             <br>
<div class="footer-disclaimer" style="margin-bottom:100px;"><p>footer-disclaimer</p></div>
                             
                             <br>
                             
                           <h3 style="color:#000000;">Date range</h3>        
                             <br>
                             <p>Poppins, Medium, 14pt, #333333(date range headers)</p>
                             <br>

                             <div class="form-header adj" style="margin-bottom:100px;">
        <div class="form-column span-4 element-inline" style="vertical-align:middle;">
            <h3><input type="radio" name="searchby" id="range" value="Quarter" checked=""> <label for="range"><span></span> Select a Quarter and a Year</label></h3>
            <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
									<select name="search[dates][fromq]" id="fromq" onchange="resetYears()">
									<option value="">Select a Quarter</option>
<option value="1">Q1</option>
<option value="2">Q2</option>
<option value="3">Q3</option>
<option value="4">Q4</option>
									</select>
                  <div id="fromqerror"></div>
								</div>
								<div class="form-row-right-inner">
									<select name="search[dates][fromy]" id="fromy" onchange="resetYears()">
									<option value="">Select a Year</option>
<option value="2013">2013</option>
<option value="2014">2014</option>
<option value="2015">2015</option>
<option value="2016">2016</option>
<option value="2017">2017</option>
<option value="2018">2018</option>
<option value="2019">2019</option>
<option value="2020">2020</option>
<option value="2021">2021</option>
									</select>
								</div>
								<div class="form-row-left-inner">
								</div>
								<div class="form-row-right-inner">
    </div>
								<div class="cf"></div>
							</div><!-- /.form-row-left -->
       </div><div class="circle-wrap  element-inline"><div class="circle">-or-</div></div><div class="form-column span-4 element-inline" style="margin-right:0;vertical-align:middle;">
            <h3><input type="radio" name="searchby" id="quarter" value="Year"> <label for="quarter"><span></span> Or Year Range</label> </h3>
             <div class="form-row-full year-select">
                <div class="form-row-left-inner">
                  <select name="search[dates][fromyear]" id="fromyear" onchange="resetQuarters()" disabled="">
                  <option value="">Select</option>
      <option value="2013">2013</option>
<option value="2014">2014</option>
<option value="2015">2015</option>
<option value="2016">2016</option>
<option value="2017">2017</option>
<option value="2018">2018</option>
<option value="2019">2019</option>
<option value="2020">2020</option>
<option value="2021">2021</option>
                  </select>
                </div>
<div class="range">to</div>
                <div class="form-row-right-inner">
                  <select name="search[dates][toyear]" id="toyear" onchange="resetQuarters()" disabled="">
                  <option value="">Select</option>
      <option value="2013">2013</option>
<option value="2014">2014</option>
<option value="2015">2015</option>
<option value="2016">2016</option>
<option value="2017">2017</option>
<option value="2018">2018</option>
<option value="2019">2019</option>
<option value="2020">2020</option>
<option value="2021">2021</option>
                  </select>
                </div>
                <div class="cf"></div>
              </div>

       </div>
     </div>

                             
                             
                             
                             
                             <br>
                             
          <h3 style="color:#000000;">Saved Searches</h3>      
                             <br>
                             <p>Poppins, Light, 14pt, #333333, Line Spacing 35pt(saved searches and recentsearches)</p>
                             <br>
                             <div class="row  row-equal row-padding mobile link-alt" style="margin-bottom:100px;">
                            <div class="col-6">
                       <div class="home-search-header  flex-addon">
                                <h3>Saved Searches</h3>
                                 <a class="search" href="/saved-searches"><img src="assets/images/home/search-view-icon.svg"></a>
                            </div>
                         <div class="header-inner ">
                         <table class="table-section">
                            <tbody><tr>
                                 <td>item name</td>
                                 <td>item date</td>
                                 <td> <a href="home">&gt;</a></td>
                            </tr>
                                <tr>
                                 <td>item name</td>
                                 <td>item date</td>
                                 <td> <a href="home">&gt;</a></td>
                            </tr>
                        </tbody></table>
                        </div><!-- /.header-block-1B -->
                      </div>
                             <div class="col-6">
                   <div class="home-search-header flex-addon">
                                <h3>Recent Searches</h3>
                                 <a class="search" href="/saved-searches"><img src="assets/images/home/search-view-icon.svg"></a>
                            </div>
                         <div class="header-inner ">
                         <table class="table-section">
                            <tbody><tr>
                                 <td>item name</td>
                                 <td>item date</td>
                                 <td> <a href="home">&gt;</a></td>
                            </tr>
                                <tr>
                                 <td>item name</td>
                                 <td>item date</td>
                                 <td> <a href="home">&gt;</a></td>
                            </tr>
                        </tbody></table>
                        </div><!-- /.header-block-1B -->
                      </div>
                      </div>
                             

                        </div><!-- /.header-block-1B -->
                      </div>
                </div>
                
                
                
				

                  
             
        
  
        
        
        
           </div>
                
<? 
//    $toptencache = getDashCache( "toptencache" );
if( !$toptencache )
    {
	ob_start();
?>
                
             
                  <div class="row row-equal row-padding">
                     <div class="col-6 flex">
                          <div class="search-body">
                             <table width="100%" id="search-results-table" class="sortable"><thead><tr>
								<th>NEW AND RETURNING TO THE TOP 10 THIS WEEK</th>
                                <th>GENRE</th>
								<th >CHART POSITION</th>
							</tr></thead>
							<tbody>

    <?php

 $prevwd = db_query_first_cell( "select id from weekdates where OrderBy < ( select OrderBy from weekdates where id = $wd ) order by OrderBy desc limit 1" );
 $prevsongs = db_query_rows("select type, s.* from songs s, song_to_weekdate sw where s.id = sw.songid and weekdateid = $prevwd and songid not in ( " . implode( ", ", array_keys( $songs ) ) . " ) order by case when type = 'position10' then 'zzz' else type end", "id" ) ;
 $allprevsongs = db_query_rows("select type, s.* from songs s, song_to_weekdate sw where s.id = sw.songid and weekdateid = $prevwd order by case when type = 'position10' then 'zzz' else type end", "id" ) ;
//print_r( array_keys( $prevsongs )  );
    $cnt = 0; foreach( $songs as $songrow ) { 
//    if( $songrow["WeekEnteredTheTop10"] != $wd ) continue;
      if( $allprevsongs[$songrow["id"]] ) continue;      
    $cnt++; 
 ?>
							<tr>
								<td class="search-column-1 ">
<? if( $songrow["IsActive"] ) { ?>
								<a class="view-link" href="<?=$songrow[CleanUrl]?>">
<?}  ?>
<?=$songrow["SongNameHard"]?>

<? if( $songrow["IsActive"] ) { ?>
									</a>						
<? } ?>

	</td>
                                <td data-label="GENRE" class="search-column-1">
<? if( $songrow["IsActive"] ) { ?>
<?=getNameById( "genres", $songrow["GenreID"] )?>
<? } ?>
                                    </td>
								<td data-label="CHART POSITION" >
                                   <?=str_replace( "position", "", $songrow[type] )?>							
                                </td>
							</tr>
    <? } 
if( !$cnt )
    {
	echo( "<tr><td>None</td></tr>" );
    }
?>
						</tbody><tfoot></tfoot></table>
                         </div><!-- /.header-block-1B -->
                   </div>
                       <div class="col-6 flex">
                 <div class="search-body">
                             <table width="100%" id="search-results-table" class="sortable"><thead><tr>
								<th>DEPARTURES</th>
                                <th>GENRE</th>
								<th >WEEKS IN THE TOP 10</th>
							</tr></thead>
							<tbody>
    <?php
foreach( $prevsongs as $songrow )
{
?>

							<tr>
								<td data-label="LEFT THE TOP TEN" class="search-column-1 ">
<? if( $songrow["IsActive"] ) { ?>
								<a class="view-link" href="<?=$songrow[CleanUrl]?>">
<? } ?>
	<?=$songrow["SongNameHard"]?>	
<? if( $songrow["IsActive"] ) { ?>
									</a>							
<? } ?>
</td>
                                <td data-label="GENRE" class="search-column-1">
<? 
        $frontendfieldname = "GenreID";
        $frontenduseid = true;

?>
<? if( $songrow["IsActive"] ) { ?>
<?=getNameById( "genres", $songrow["GenreID"] )?>
<? } ?>

                                    </a></td>
								<td data-label="WEEKS IN THE TOP 10" >
<?=$songrow["NumberOfWeeksSpentInTheTop10"]?>
                                </td>
							</tr>
	<? }
if( !count( $prevsongs ) )
    {
	echo( "<tr><td>None</td></tr>" );
    }

 ?>
						</tbody><tfoot></tfoot></table>
                         </div><!-- /.header-block-1B -->
                   </div>
                </div>
      
			    <?  
			    $toptencache = ob_get_contents(); 
	ob_end_clean();
	addDashCache( "toptencache", $toptencache );
    }
echo( $toptencache );
?>
    <? if( 1 == 0 ) { ?>                       
        <div class="header-container">
					<h1>Hot 100 Top 10: Four-Quarter Trends</h1><br>
				</div><!-- /.header-container -->
                  <div class="row row-equal row-padding">
                           <div class="col-12 ">
         <?php
    include 'masterslider/homepage/slider-full-home.php';
                ?>
                      </div></div>
                
<? 
			    }
//			  $fourago = db_query_first( "select * from weekdates where OrderBy < ( select OrderBy from weekdates where id = $wd ) order by OrderBy desc limit 3, 1" );
?>                
                
<? 
//   $fourquartercache = getDashCache( "fourquartercache" );
if( !$fourquartercache )
    {
	ob_start();
?>                
                
                  <div class="header-container">
					<h1>Hot 100 Top 10: Four-Quarter Snapshot (Q<?=$search[dates]["fromq"] . " " . $search[dates]["fromy"]?> - Q<?=$search[dates]["toq"] . " " . $search[dates]["toy"]?>)</h1><br>
				</div><!-- /.header-container -->
                 <div class="row row-equal row-padding link-alt">
                           <div class="col-6 flex">
                           <div class="home-search-header">
                               <h1>MOST POPULAR COMPOSITIONAL CHARACTERISTICS<span>(Click on links to view songs.)</span></h1>
                               
                            </div>
                         <div class="header-inner">
                            <ul class="wdot">

<?php
		      $doingquarterrange = 1;
$characteristics = gatherCharacteristicsSingleQuarter( "whatever", "most");

$todisplay = array();
//$todisplay[] = "Primary Genres";
//$todisplay[] = "Sub-Genres/Influences";
$todisplay[] = "Genres/Influences (Top 3)";
$todisplay[] = "Solo vs. Multiple Lead Vocalists";
$todisplay[] = "Lead Vocal Gender (male, female, male/female)";
$todisplay[] = "Lead Vocal Delivery Type";
$todisplay[] = "Lyrical Themes";
$todisplay[] = "Key (Major vs. Minor)";
$todisplay[] = "Tempo Range (BPM)";
$todisplay[] = "Song Length Range";
//$todisplay[] = "Prominent Instruments";
$todisplay[] = "Prominent Instruments (Top 3)";
$todisplay[] = "Intro Length Range";
//$todisplay[] = "Verse Count";
$todisplay[] = "Chorus Preceding First Verse";
$todisplay[] = "First Chorus: Time Into Song Range";
//$todisplay[] = "Chorus Count";
$todisplay[] = "Last Section";
$todisplay[] = "Outro Length Range";

$allsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] ); 

//print_r( $characteristics );
foreach( $todisplay as $c )
{
    $key = $c . ":";

    $touse = $c . ":";
    $displ =$characteristics[$touse];

    if( $c == "Sub-Genres/Influences (Top 3)" )
{
    $res = getBarTrendDataForRows( "Sub-Genres/Influences", "", array_keys( $allsongs ) );
    uasort( $res, "customSortLastDataCSV" );
    
    $res = fixToUrls( $res, "subgenres" );
    $arr = array_shift( $res );
    $arr2 = array_shift( $res );
    $arr3 = array_shift( $res );
?>
<li>Sub-Genres & Influences (Top 3): <?=$arr[2]?>  (<?=$arr[1]?>)<? if( $arr2 ) { ?>, <?=$arr2[2]?>  (<?=$arr2[1]?>)<? } ?><? if( $arr3[2] ) { ?>, <?=$arr3[2]?>  (<?=$arr3[1]?>)<?php
																      $lastval = $arr3[1];
 }
    $s = array_shift( $res );
    while( $s[1] == $lastval )
	{
	    echo( ", $s[2] ($s[1])" );
	    $s = array_shift( $res );
	}
 ?> 


<? $popped = array_shift( $res ); 
while( $popped[1] == $arr5[1] && $popped[1] && $arr5[1] )
    {
echo( ", " . $popped[2]." (".$popped[1].")" );
$popped = array_shift( $res ); 
    }

?>

 </li><?php
}
else if( $c == "Prominent Instruments (Top 3)" )
{
    $res = getBarTrendDataForRows( "Prominent Instruments", "", array_keys( $allsongs ) );
    uasort( $res, "customSortLastDataCSV" );
    
    $res = fixToUrls( $res, "primaryinstrumentations" );
    $arr = array_shift( $res );
    $arr2 = array_shift( $res );
    $arr3 = array_shift( $res );
?>
<li>Prominent Instruments (Top 3): <?=$arr[2]?>  (<?=$arr[1]?>)<? if( $arr2 ) { ?>, <?=$arr2[2]?>  (<?=$arr2[1]?>)<? } ?><? if( $arr3[2] ) { ?>, <?=$arr3[2]?>  (<?=$arr3[1]?>)<? } ?>
<? $popped = array_shift( $res ); 
while( $popped[1] == $arr3[1] && $popped[1] && $arr3[1] )
    {
echo( ", " . $popped[2]." (".$popped[1].")" );
$popped = array_shift( $res ); 
    }

?>

 </li><?php
}
else
{
 ?>
	<li><?=$c?>: <?=$displ?></li>
<? } 
}?>
                             </ul>
                        </div><!-- /.header-block-1B -->
                   </div>

			    <?  
			    $fourquartercache = ob_get_contents(); 
	ob_end_clean();
	addDashCache( "fourquartercache", $fourquartercache );
    }
echo( $fourquartercache );
?>

<? 
    $industrycache = getDashCache( "industrytrends" );
if( !$industrycache )
    {
	// copied from industry-trend-report
	$_GET["search"] = $search;
	include "industry-trend-report-calcquarter.php";

	ob_start();
	$dontshowvalues = 1;
	include "industrytrendreportincludes/overview-top10.php";
?>
                       <div class="col-6 flex">
                     <div class="home-search-header">
                               <h1>INDUSTRY TRENDS <span>(Click on links to view songs.)</span></h1>
                       
                            </div>
                         <div class="header-inner">
                             <ul class=" wdot">
    <li>Number of New Songs in the Top 10: <?=$numnewarrivals?></li>
    <li>Songs with a Featured Artist: <?=$featuredartist?></li>
                             </ul>
                             
                               <ul class=" wdot">
    <li>Number of Credited Primary Artists: <?=$numprimartists?></li>
    <li>Number of Credited Featured Artists: <?=$numfeatartists?></li>
                             </ul>
                             
                              <ul class=" wdot ">
    <li>Single vs. Multiple Artists: 
<? 
			    if( $numsolohard >= $numduethard )
				{
?>
Single: <?=$numsolo?>
<?php

				}
			    else
				{
?>
Multiple: <?=$numduet?>
<?php
				}
?>
</li>
    <li>Artist/Group with the Most Top 10 Songs (excludes featured artists): <?=$artistmosthits?></li>
                             </ul>
                             
                              <ul class=" wdot">
    <li>Number of Credited Songwriters: <?=$numsongwriters?></li>
    <li>Songwriter with the Most Top 10 Songs: <?=$songwritermosthits?></li>
    <li>Most Popular Songwriting Team Size: <?=$songwritercountmosthits?></li>
                             </ul>
                             
                               <ul class=" wdot">
    <li>Number of Credited Producers: <?=$numproducers?></li>
		      <li>Producer with the Most Top 10 Songs: <?=$producermosthits?></li>
                             </ul>
                             
                              <ul class=" wdot">
    <li>Number of Credited Record Labels: <?=$numlabels?></li>
    <li>Record Label with the Most Top 10 Songs: <?=$labelmosthits?></li>
                             </ul>
                        </div><!-- /.header-block-1B -->
                   </div>
                </div>
			    <?  
			    $industrycache = ob_get_contents(); 
	ob_end_clean();
	addDashCache( "industrytrends", $industrycache );
    }
echo( $industrycache );
?>
               
            </div><!-- /.row -->
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

        
                    
        console.log('test');
            
            if(w.value > 1700){
                
            }
	</script>
<script type="text/javascript">		

		var slider = new MasterSlider();

		slider.control('arrows');	
		//slider.control('bullets' , {autohide:false, align:'bottom', margin:10});	
		slider.control('scrollbar' , {dir:'h',color:'#333'});

		slider.setup('masterslider' , {
		autoHeight:true,
             loop:true,
			width:1400,
			height:430,
			space:1,
			view:'basic',
            fullwidth:true
            
		});

	</script>
<? 
	    file_put_contents( "homequeries", date( "H:i:s" ) . ", ". $numlogqueries . " queries\n", FILE_APPEND );
?>

<?php include 'footer.php';?>
