<?php
$istrendreport = true;
$isindustrytrendreport = true;
include "trendreportfunctions.php";
include "trendfunctions.php";
include 'header.php';

$sorttableids = array();

$doingweeklysearch = false;
$replacetotimeperiod = false;



if( !$_GET["graphtype"] ) $_GET["graphtype"] = "line";
$urldatestr = "&search[dates][fromq]=" . $search[dates][fromq]. "&search[dates][fromy]=" . $search[dates][fromy];


if( $search["dates"]["fromweekdate"] )
{
    include "industry-trend-report-calcweekdates.php";

}
else if( $search["dates"]["fromyear"] )
{
    $doingyearlysearch = true;
    $replacetotimeperiod = true;


    if( !$search["dates"]["toyear"] ) $search["dates"]["toyear"] = $search["dates"]["fromyear"];
    if( $search["dates"]["toyear"] != $search["dates"]["fromyear"] )
	$displquarterstr = "(selected time period)";
    else
	$displquarterstr = "(year)";
    $search["dates"]["fromq"] = 1;
    $search["dates"]["fromy"] = $search[dates]["fromyear"];
    $search["dates"]["toq"] = 4;
    if( $search["dates"]["specialendq"] )
	$search[dates][toq] = $search["dates"]["specialendq"];


    $search["dates"]["toy"] = $search[dates]["toyear"];

     $allsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
     $allsongsstr = implode( ", ", $allsongs );
    if( !$allsongs ) { redirectTo(  "industry-trend-report-search" ); exit; }

    //    print_r( $search["dates"] );
    $urldatestr = "&search[dates][fromq]=" . $search[dates][fromq]. "&search[dates][toq]=" . $search[dates][toq];
    $urldatestr .= "&search[dates][fromy]=" . $search[dates][fromy]. "&search[dates][toy]=" . $search[dates][toy];

    $rangedisplay = "{$search[dates][fromyear]}";
    if( $search[dates][fromyear] != $search[dates][toyear] )
	$rangedisplay .= " - {$search[dates][toyear]}";

    $prevq = 1;
    $prevyear = $search[dates]["fromyear"]-1;
    if( $prevyear < $earliesty ) $prevyear = $earliesty;

    $prevsongs = getSongIdsWithinQuarter( false, $prevq, $prevyear, 4, $prevyear );

    $prevsongsstr = implode( ", ", $prevsongs );

    $prevartists = db_query_array( "select Name, artistid from song_to_artist, artists where type in ( 'featured', 'primary' ) and songid in ( $prevsongsstr )", "Name", "artistid" );
    $prevgroups = db_query_array( "select Name, groupid from song_to_group, groups where type in ( 'featured', 'primary' ) and songid in ( $prevsongsstr )", "Name", "groupid" );

    $prevartists = array_merge( $prevartists, $prevgroups );
    ksort( $prevartists );
// artists for the previous quarter
// THIS IS NAMES NOT IDs
    $prevartistsstr = "";
    foreach( $prevartists as $prevname => $previd )
    {
        if( $prevartistsstr ) $prevartistsstr.= ", ";
    $prevartistsstr .= "'" . escMe( $prevname ) . "'";
    }

    $allsongsnumber1 = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], 1 );
    if( !count( $allsongsnumber1 ) ) // if there are no songs we should put sometihing in there so it doesn't display everything
	$allsongsnumber1[] = -1;
    //print_r( $allsongsnumber1 );
    $allsongsnumber1str = implode( ", ", $allsongsnumber1 );
    $allsongsallquarters = getSongIdsWithinQuarter( false, $oldestq, $oldesty, $search[dates][toq], $search[dates][toy] );
    $allsongsallquartersstr = implode( ", ", $allsongsallquarters );

    $allgenres = db_query_array( "select id, Name from genres order by OrderBy", "id", "Name" );
    $genresongs = array();
    foreach( $allgenres as $genreid=>$genrename )
    {
        $genrefilter = $genreid;
	$tmpsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
        $genresongs[$genreid] = $tmpsongs;
        if( !count( $tmpsongs ) )
        {
            unset( $allgenres[$genreid] );
        }
    }

    $alllabels = db_query_array( "select id, Name from labels order by OrderBy", "id", "Name" );
    $labelsongs = array();
    $genrefilter = "";
    foreach( $alllabels as $labelid=>$labelname )
    {
        $labelfilter = $labelid;
	$tmpsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
        $labelsongs[$labelid] = $tmpsongs;
        if( !count( $tmpsongs ) )
        {
            unset( $alllabels[$labelid] );
        }
    }

    $genrefilter = "";
    $labelfilter = "";

    $allweekdates = getWeekdatesForQuarters( $search["dates"]["fromq"], $search["dates"]["fromy"], $search["dates"]["toq"], $search["dates"]["toy"] );
    $weekdatesstr = implode( ", " , $allweekdates );
    // $returned = db_query_array( "select songid from song_to_weekdate, songs where WeekEnteredTheTop10 not in (" . implode( ", ", $allweekdates ) . " ) and songs.id = songid and songid in ( $allsongsstr ) and songid not in ( $prevsongsstr ) ", "songid", "songid" );

    // $newarrivals = db_query_array( "select songs.id, songnames.Name from songs, songnames where {$GLOBALS[clientwhere]} and songnameid = songnames.id and WeekEnteredTheTop10 in ( " . implode( ", " , $allweekdates ) . " ) order by Name ", "id", "Name" );
    // $carryovers = array_intersect( $allsongs, $prevsongs );

    // $gone = array_diff( $prevsongs, $allsongs );


    $displayquarter = "NONE";

//    $thisquarternumber = calculateQuarterNumber( $search[dates][fromq], $search[dates][fromy] );


    if( !$allsongsnumber1str ) $allsongsnumber1str = "-1";
    if( !$allsongsstr ) $allsongsstr = "-1";
    if( !$allsongsallquartersstr ) $allsongsallquartersstr = "-1";
    $allyearstorun = array();
    $touse = $search["dates"]["fromyear"]==$search["dates"]["toyear"]?$search["dates"]["fromyear"]-3:$search["dates"]["fromyear"];
    if( $touse < $earliesty )
	$touse = $earliesty;
    for( $i = $touse; $i <= $search["dates"]["toyear"]; $i++ )
	{
	    $allyearstorun[] = $i;
	}


}
else
{
    include "industry-trend-report-calcquarter.php";

}

populateSongRows( implode( ", ", $allsongs ) );

$allsongssorted = array();
$allsongssortedno1 = array();
foreach( $allsongs as $songid )
{
    $songname = getSongnameFromSongid( $songid );
    $allsongssorted[$songname] = $songid;
}

foreach( $allsongsnumber1 as $songid )
{
    $songname = getSongnameFromSongid( $songid );
    $allsongssortedno1[$songname] = $songid;
}

ksort( $allsongssorted );
ksort( $allsongssortedno1 );

include "industrytrendfunctions.php";


?>
	<div class="site-body" >
    <?  include "searchcriteria-industrytrendreport.php"; ?>
		<section class="search-results-bottom">
<!-- begin copied from trend-search -->
<style type="text/css">

.listB li span b
{
	font-weight: bold;
}

.search-header h1{ float:none; }
	.search-header h2{
    margin-top: 15px;
    color: #7a7a7a;
    font-size: 14px;
	}
	.tabletitle {
    color: #7a7a7a !important;
    text-align: center !important;
    font-size: 18px !important;
  width: 100%;
	}

    table tr:first-child td:last-child{
    display:none;
    }

section {
     background-color: transparent!important;

}
    .element-container {
 padding: 0 !important;
}
    .search-body td {
    padding: 25px;
}

h2 {
    font-size: 24px;
    font-weight: 300;
    color: #ff6633;
    display: inline-block;
}

.backtotop{
	float: right;
	margin-top: 10px;
}



.search-body #comp-search-table {
    margin: 0px 0 0;
}

.search-body .sortable th, .search-body .sortable td {
    height: 55px;
    border: solid 1px #dddddd;
    padding: 5px 5px;
    width: 15%;
    color: #333333;
        font-weight: 600;
        text-align: center;
}

table.sortable tr:first-child td:last-child {
    display: table-cell;
}

.search-body tr:nth-child(even) {
    background: #ffffff;
}

table.sortable  {
  width: 100%;
}

.sub-graph-wrap,
.sub-graph-wrap > div{
	margin: 20px 0;
}

.graph-wrap,
.graph-wrap > div{
	margin: 20px 0;
}

.sub-graph-wrap > div{
text-align: center;
}


.sub-graph-wrap h3{
margin-bottom: 15px;
}

.Graph-wrap-id h3 {
  display:none;
 }
h2.sub-header{
	font-size: 18px;
	font-weight: normal;
}
section h2{
	font-weight: bold;
}

ul.listA li.head-label a{
font-size: 15px;
font-weight: 700;
color: #7a7a7a;
}
ul.listA li.head-label {
margin-top: 15px;
}

ul.listA li.head-label:first-child {
    margin-top: 0px;
}


ul.listA li{
	list-style-type: none!important;
}


ul.listA li.head-label:after{
content: ''!important;
}
.temp-hidden {
    padding: 0px 0px 0px 0px;
}

.search-hidden-container {
    padding: 35px 0 35px 0px;
}
/*.search-hidden-container h3 a.expand-btn-2{

	margin-left: 15px;
}*/

.search-body {
    padding: 25px 2%;
}
.graph-wrap, .graph-wrap > div {
    margin: 60px 0;
}
#search-hidden-2 section {
    padding: 0px 20px 15px 20px;
}

.Graph-wrap-id hr{
	    margin-bottom: 60px;
}
.canvasjs-chart-container{
	margin-bottom: 25px;
}
section.top10 .search-body h2.tabletitle,
section.mqut .search-body h2.tabletitle,
section.mqdt .search-body h2.tabletitle{
	font-size: 14px!important;
	color: #7a7a7a!important;
	margin-bottom: 10px!important;
	line-height: 1.7!important;
	text-align: left!important;
	font-weight: 200!important;
}

section.mqut .search-body  p.subtitle ,
section.mqdt .search-body  p.subtitle {
font-style: normal!important;
    margin-top: 5px;
    margin-bottom: 5px;
    padding: 0px;
    color: #333333!important;
    font-size: 15px;
    font-weight: 400;
}

h3.tabletitle{
	text-align: left!important;
	margin-bottom: 10px;
	font-size: 15px!important;
	    font-weight: 700;

}

#extranote{
	color: #000;
	font-style: italic;
	font-size: 14px;
  margin-top:15px;
}
</style>

<script language='javascript'>
    function showAllGraph( mychart, val )
{
    for(i = 0; i <  mychart.options.data.length ; i++ )
    {
        mychart.options.data[i].visible = val;
    }
    mychart.render();
}



</script>

<!-- end copied from trend-search -->

    <main style="margin-top: 0px" >
<header>
    <div class="row">
        <div class="head-title"><h1>INDUSTRY TREND REPORT- <?=$rangedisplay?> </h1></div>
        <div class="right search-return"></div>
    </div>
</header>
          <div class="search-body">
        <div class="graph-head">                       

     <div class=" set" style="margin-bottom:20px;">  
    <? if( !isStudent() && !isEssentials() ) { ?>
    
                         <div class="icon save">
                             <a href="#" data-featherlight="#searchlightbox">Save Search</a></div>
                        <? } ?>
                       
                                 <div class="icon email ">
                                     <a href="#" onclick="javascript: maillink(&quot;Industry Trend Report - <?=$rangedisplay?>&quot;); return false;">Email</a></div>
         
                                 <div class="icon copy ">
                                     <a href="#"  id="copylink" onclick="javascript: shorturl2(); return false;">Copy Link</a></div>
                           
         
         
         
                         <div class="icon share" style="display:none">
                             <a href="#">Share</a>
                             <div class="subset hidden">
                                 <div class="icon copy">
                                     <a href="#"  id="copylink2" onclick="javascript: shorturl2(); return false;">Copy Link</a></div>
                                 <div class="icon email">
                                     <a href="#" onclick="javascript: maillink('Subject goes here'); return false;">Email</a></div>
                            </div>
         
                        </div>
                  
                        
    </div>   
    
    
    
       <div class=" set" style="margin-bottom:20px;">                     
               <div class="icon back-search ">
                   <a class=" desktop" href="industry-trend-report-search.php?<?=$_SERVER['QUERY_STRING']?>">Back</a></div>
                        
                       <div class="icon new-search ">
           
              <a href="/read-a-report">New Search</a> </div>

    
    </div>
                        </div>
        
        
<section>
    <h2>Skip To</h2>
    <hr />
    <ul class="listA">
<? foreach( $industrytrendreports as $grouping=>$reportarr ) {
   $groupingkey = str_replace( array( " ", "/" ), "_", strtolower( $grouping ) );
?>
    <li class="head-label"><a href="#<?=$groupingkey?>" class="anchors"><?=$grouping?></a></li>
<? foreach( $reportarr as $rid=>$rdisplay ) { ?>
     <li><a href="#<?=$groupingkey?>-<?=$rid?>" class="<?=$rid?> anchors"><?=$rdisplay?></a></li>

<? } ?>
<? } ?>
    </ul>
</section>

<?php
$prevnum = $numlogqueries; 

foreach( $industrytrendreports as $grouping=>$reportarr ) {
      $groupingkey = str_replace( array( " ", "/" ), "_", strtolower( $grouping ) );
?>
							<a name='<?=$groupingkey?>'></a>

								<div class="search-hidden-container" id="shc-lyricstitle">
									<h3><a class="expand-btn-2 <?=$groupingkey?>" id="expander-<?=$groupingkey?>"><?=$grouping?></a></h3>
									<div id="search-hidden-2" class="<?=$groupingkey?> temp-hidden">
											<!--<h2><?=$grouping?></h2><br />-->

							<? foreach( $reportarr as  $sectionid=>$sectionname ) {
  if($_GET["logqueries"] )
  {
      $tm = time() - $startlogtime;
      file_put_contents( "/tmp/querylog", "(prev was $diffqn) STARTING $groupingkey - $sectionid => $sectionname\n" , FILE_APPEND );
  }

 ?>
       								  <a name="<?=$groupingkey?>-<?=$sectionid?>" class="top"></a>
												<section class="<?=$sectionid?>">
   										  		<h2 class="sub-header"></h2>
   												  <!--<a class='backtotop' href='#'>Back To Top</a>-->
  												  <hr />
            								 <? include "industrytrendreportincludes/{$groupingkey}-{$sectionid}.php"; ?>
												</section>

							<?php
      $diffqn = $numlogqueries - $prevnum;
      $prevnum = $numlogqueries; 
      file_put_contents( "/tmp/querylog", "(prev was $diffqn) ENDING $groupingkey - $sectionid => $sectionname\n" , FILE_APPEND );

 }
							?>

								  	<div class="cf"></div>
									</div>
								</div>

<?php
}?>

<section>
    </div>
                        <div class="search-footer">
							<div class="search-footer-left span-3">
							
								<div class="cf"></div>
							</div><!-- /search-footer-left -->
							<div class="search-footer-right span-4">
    <? if( !isStudent() && !isEssentials() ) { ?>
    <a class="black-btn" href="#" data-featherlight="#searchlightbox">SAVE SEARCH</a>
                            <? } ?>
								<a class="orange-btn" href="/industry-trend-report-search">NEW SEARCH</a>
								<div class="lightbox" id="searchlightbox">
									<div class="save-search-header">
										<h1>SAVE SEARCH</h1>
									</div><!-- /.save-search-header -->
									<div class="save-search-body">
										<label>Name:</label>
										<input type='text' name="searchname" id='searchname' onChange='javascript:document.getElementById( "searchnamehidden").value = this.value; '>
										<a class="black-btn" href="#" onClick='javascript:saveSearch( "saved", "Industrial Trend Report" ); return false'>SAVE</a>
										<div class="cf"></div>
									</div><!-- /.save-search-body -->
								</div><!-- #searchlightbox -->
							</div><!-- /search-footer-right -->
							<div class="cf"></div>
						</div><!-- /.search-footer -->
             </div>
        </div>
</section>

</main>
 </div>
      <input type='hidden' name="searchnamehidden" id='searchnamehidden'>
    <script>
		var sessid = "<?=session_id()?>";
		var searchType = "<?=$searchtype?$searchtype:"Industry Trend Report"?>";
    $(document).ready(function(){
        $("a.expand-btn").click(function(){
            $("a.expand-btn").toggleClass("collapse-btn");
            $("#search-hidden").toggleClass("hide show");
        });

        $("#search-hidden-2.temp-hidden").hide();

        $("a.expand-btn-2").click(function(){
           $(this).toggleClass("collapse-btn");

           var $elem= $(this).parent().siblings('#search-hidden-2.temp-hidden')
           var $elemVisible = $elem.is(':visible');

           if($elemVisible){
                $(this).parent().siblings('#search-hidden-2.temp-hidden').hide();
           }else{
                $(this).parent().siblings('#search-hidden-2.temp-hidden').show();
                }
         });

         $("a.anchors").click(function(){
                 		 var link = $(this).attr('href');
                 		 var $dashPosition = link.indexOf('-');

                 		 if (link.indexOf('-') > -1)
                 		 {
                 		  var $string = link.substring(1,$dashPosition);
                 		 }else{
                 		 var $string = link.substring(1);
                 		 }
                 			 var $section = '#search-hidden-2.' + $string ;
                 			var $elemVisible = $($section).is(':visible');
                 			var btnExpand = 'a.expand-btn-2.' + $string;

            						$(btnExpand).addClass("collapse-btn");

                				if($elemVisible){
                				 $($section).show();
                					} else{
                				 $($section).show();
                  }
            });

    });

    </script>
    <script src="sorttable.js"></script>

 <script language='javascript'>
    $(document).ready(function(){
            $(".exportpng").click(function(){
                    var id = $(this).attr( "id" );
                    $('#' + id + '-table').tableExport({type:'png',escape:'false'});
                });
            var hash = document.location.hash.replace( "#", "" );
<? foreach( $industrytrendreports as $grouping=>$reportarr ) {
      $groupingkey = str_replace( array( " ", "/" ), "_", strtolower( $grouping ) );
      foreach( $reportarr as  $sectionid=>$sectionname ) { ?>
          if( hash == "<?=$groupingkey?>-<?=$sectionid?>" )
          {
              $( "#expander-<?=$groupingkey?>" ).trigger( "click" );
              document.location.hash = "#" +hash;
          }
          <? }
            }?>


        });
</script>
<?php include 'footer.php';?>
