<?php 
$istrendreport = true;
include "trendfunctions.php";
include 'header.php'; 
if( !$_GET["graphtype"] ) $_GET["graphtype"] = "line";

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

if( $search["dates"]["fromweekdate"] )
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

    $allsongs = getSongIdsWithinWeekdates( false, $search[dates][fromweekdate], $search[dates][toweekdate], $search["peakchart"] );
    $allsongsnumber1 = getSongIdsWithinWeekdates( false, $search[dates][fromweekdate], $search[dates][toweekdate], 1 );
    $allsongsstr = implode( ", ", $allsongs );
    $allsongsnumber1str = implode( ", ", $allsongsnumber1 );
    $allsongsallquarters = $allsongs;
    $allsongsallquartersstr = $allsongsstr;

    if( $doingthenandnow )
	{
	    $allsongssecond = getSongIdsWithinWeekdates( false, $search[dates][fromweekdatesecond], $search[dates][toweekdatesecond], $search["peakchart"] );
	    $rangedisplay .= " & $fromweekdatedisplaysecond - $toweekdatedisplaysecond";

	    $allsongsstrsecond = implode( ", ", $allsongssecond );
	    $allsongsallquarterssecond = $allsongssecond;
	    $allsongsallquartersstrsecond = $allsongsstrsecond;
	    if( !$allsongsstrsecond ) $allsongsstrsecond = "-1";
	    $allweekdatestorunsecond = db_query_rows( "select * from weekdates where OrderBy >= '" . $search["dates"]["fromweekdatesecond"]. "' and OrderBy <= '" . $search["dates"]["toweekdatesecond"]. "' order by OrderBy" );

	    if( $search[dates][fromweekdatethird] )
		{
		    $allsongsthird = getSongIdsWithinWeekdates( false, $search[dates][fromweekdatethird], $search[dates][toweekdatethird], $search["peakchart"] );
		    $rangedisplay .= " & $fromweekdatedisplaythird - $toweekdatedisplaythird";
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

    
    $allgenres = db_query_array( "select id, Name from genres order by OrderBy", "id", "Name" );
    $genresongs = array();
    foreach( $allgenres as $genreid=>$genrename )
    {
        $genrefilter = $genreid;
	if( ( $_GET["genrefilter"] == -2 ) && $genrefilter == 2 ) continue;
	else if( $_GET["genrefilter"] && $genrefilter != $_GET["genrefilter"] ) continue;
	$tmpsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
        $genresongs[$genreid] = $tmpsongs;
        if( !count( $tmpsongs ) )
        {
            unset( $allgenres[$genreid] );
        }
    }

    $genrefilter = $_GET["genrefilter"];
}

else if( $search["dates"]["fromyear"] )
{
    $doingyearlysearch = true;
    $replacetotimeperiod = true;

	
    if( $search["dates"]["fromyearsecond"] )
	{
	    $doingthenandnow = true;
	}


    if( !$search["dates"]["toyear"] ) 
	{
	    $search["dates"]["toyear"] = $search["dates"]["fromyear"];
	}

    $rangedisplay = "{$search[dates][fromyear]}";
    if( $search[dates][fromyear] != $search[dates][toyear] )
	$rangedisplay .= " - {$search[dates][toyear]}";

    $yearrange = $rangedisplay;

    $search[dates][fromq] = $season?getFirstSeason( $season ):1;
    $search["dates"]["fromy"] = $search[dates]["fromyear"];
    $search[dates][toq] = $season?getLastSeason( $season ):4;
    if( $search["dates"]["specialendq"] )
	$search[dates][toq] = $search["dates"]["specialendq"];
    $search["dates"]["toy"] = $search[dates]["toyear"];

    $urldatestr = "&search[dates][fromq]=1&search[dates][fromy]=" . $search[dates][fromyear]. "&search[dates][toq]=4&search[dates][toyear]=" . $search[dates][toyear];


    $prevq = 1;
    $prevyear = $search[dates]["fromyear"]-1;

    /// three years ago?    
    $oldestyearly = max( $prevyear - 2, $earliesty );
    $oldestq = 1;
    $oldesty = $oldestyearly;
    
    $quarterstorun = getQuarters( $oldestq, $oldesty, $quarter, $year );

    $prevsongs = getSongIdsWithinQuarter( false, $prevq, $prevyear, 4, $prevyear, $search["peakchart"] );
    $prevsongsstr = implode( ", ", $prevsongs );
    
    $allsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], $search["peakchart"] );
    //    echo( "num: " . count( $allsongs ) );
    $allsongsstr = implode( ", ", $allsongs );
    $allsongsnumber1 = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], 1 );
    if( !count( $allsongsnumber1 ) ) // if there are no songs we should put sometihing in there so it doesn't display everything
	$allsongsnumber1[] = -1;
    //print_r( $allsongsnumber1 );
    $allsongsallquarters = getSongIdsWithinQuarter( false, $oldestq, $oldesty, $search[dates][toq], $search[dates][toy], $search["peakchart"] );
    $allsongsallquartersstr = implode( ", ", $allsongsallquarters );
    
    $allsongsnumber1str = implode( ", ", $allsongsnumber1 );
    if( !$allsongsnumber1str ) $allsongsnumber1str = "-1";
    if( !$allsongsstr ) $allsongsstr = "-1";
    if( !$allsongsallquartersstr ) $allsongsallquartersstr = "-1";
    $allyearstorun = array();
    //    print_r( $search["dates"] );
    for( $i = $search["dates"]["fromyear"]; $i <= $search["dates"]["toyear"]; $i++ )
	{
	    $allyearstorun[$i] = $i;
	}
    if( $doingthenandnow )
	{
	    $yearrange2 = "{$search[dates][fromyearsecond]}";
	    if( $search[dates][fromyearsecond] != $search[dates][toyearsecond] )
		$yearrange2 .= " - {$search[dates][toyearsecond]}";
	    $urldatestrsecond = "&search[dates][fromq]=1&search[dates][fromy]=" . $search[dates][fromyearsecond]. "&search[dates][toq]=4&search[dates][toyear]=" . $search[dates][toyearsecond];
	    
	    $rangedisplay .= " & {$yearrange2}";
	    $allsongssecond = getSongIdsWithinQuarter( false, 1, $search[dates][fromyearsecond], 4, $search[dates][toyearsecond], $search["peakchart"] );
	    $allsongsstrsecond = implode( ", ", $allsongssecond );
	    $allsongsallquarterssecond = $allsongssecond;
	    $allsongsallquartersstrsecond = $allsongsstrsecond;
	    if( !$allsongsstrsecond ) $allsongsstrsecond = "-1";
	    
	    if( $search[dates][fromyearthird] )
		{
		    $yearrange3 = "{$search[dates][fromyearthird]}";
		    if( $search[dates][fromyearthird] != $search[dates][toyearthird] )
			$yearrange3 .= " - {$search[dates][toyearthird]}";
		    $urldatestrthird = "&search[dates][fromq]=1&search[dates][fromy]=" . $search[dates][fromyearthird]. "&search[dates][toq]=4&search[dates][toyear]=" . $search[dates][toyearthird];
		    $rangedisplay .= " & {$yearrange3}";
		    $allsongsthird = getSongIdsWithinQuarter( false, 1, $search[dates][fromyearthird], 4, $search[dates][toyearthird], $search["peakchart"] );
		    //		    print_r( $allsongsthird );exit;
		    $allsongsstrthird = implode( ", ", $allsongsthird );
		    $allsongsallquartersthird = $allsongsthird;
		    $allsongsallquartersstrthird = $allsongsstrthird;
		    if( !$allsongsstrthird ) $allsongsstrthird = "-1";
		    
		}
	    
	    
	}
    $allgenres = db_query_array( "select id, Name from genres order by OrderBy", "id", "Name" );
    $genresongs = array();
    foreach( $allgenres as $genreid=>$genrename )
    {
        $genrefilter = $genreid;
	if( ( $_GET["genrefilter"] == -2 ) && $genrefilter == 2 ) continue;
	else if( $_GET["genrefilter"] && $genrefilter != $_GET["genrefilter"] ) continue;
	$tmpsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
        $genresongs[$genreid] = $tmpsongs;
        if( !count( $tmpsongs ) )
        {
            unset( $allgenres[$genreid] );
        }
    }
    $genrefilter = $_GET["genrefilter"];
}
else
{
include "trenddoingquartermiddle.php";    
}
//echo( "mine: " );
//print_r( $allsongsnumber1str );

include "trendreportfunctions.php";
?> 
	<div class="site-body" >
    <?  include "searchcriteria-trendreport.php"; ?>
		<section class="search-results-bottom">
<!-- begin copied from trend-search -->
<style type="text/css">
	.search-header h1{ float:none; }
	.search-header h2{
    margin-top: 15px;
    color: #7a7a7a;
    font-size: 14px;
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
.temp-hidden {
    padding: 0px 0px 0px 0px;
}

.search-hidden-container {
    padding: 35px 0 35px 0px;
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



ul.listA li.head-label:after{
content: ''!important;
}


.search-body {
    padding: 25px 2%;
}
.graph-wrap, .graph-wrap > div {
    margin: 60px 0;
}

#search-hidden-2 hr{
	
	margin-bottom: 40px;
}

.canvasjs-chart-container{
	margin-bottom: 25px;
}

table.sortable tr:first-child td:last-child {
    display: table-cell;
}

table.sortable  {
  width: 100%;
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
	.tabletitle {
    color: #7a7a7a !important;
    text-align: center !important;
    font-size: 26px !important;
  width: 100%;
	}


</style>

    <script src="sorttable.js"></script>
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
        <div class="head-title"><h1><?=getOrCreateCustomTitle( "Compositional Trend Report - $rangedisplay", "Compositional Trend Report - $rangedisplay" )?></h1></div> 
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
                                     <a href="#" onclick="javascript: maillink(&quot;Trend Report - <?=$rangedisplay?>&quot;); return false;">Email</a></div>
          <div class="icon copy ">
                                     <a href="#"  id="copylink" onclick="javascript: shorturl2(); return false;">Copy Link</a></div>
                           
         
         
         
                         <div class="icon share" style="display:none">
                             <a href="#">Share</a>
                             <div class="subset hidden">
                                 <div class="icon copy">
                                     <a href="#" onclick="javascript: shorturl2(); return false;">Copy Link</a></div>
                                 <div class="icon email">
                                     <a href="#" onclick="javascript: maillink('Subject goes here'); return false;">Email</a></div>
                            </div>
         
                        </div>
                  
                        
    </div>   
    
    
    
       <div class=" set" style="margin-bottom:20px;">                     
               <div class="icon back-search ">
               <a class=" desktop" href="trend-report-search.php?<?=$_SERVER['QUERY_STRING']?>">Back</a></div>
                        
                       <div class="icon new-search ">
           
              <a href="https://analytics.chartcipher.com/read-a-report">New Search</a> </div>

    
    </div>
                        </div>
        
<section>
    <h2>Skip To</h2>
    <hr />
    <ul class="listA">
    <?php
    foreach( $reportsarr as $keyname=>$tmpreportsarr ) {
    	$groupingkey = str_replace( array( " ", "/" , "&"), "-", strtolower( $keyname ) );?>
    	 <li class="head-label"><a href="#<?=$groupingkey?>" class="anchors"><?=$keyname?></a></li>
   		 <? foreach( $tmpreportsarr as $rid=>$rval ) { ?>
   				 <li>
   				 <a href="#<?=$groupingkey?>_<?=$rid?>" class='anchors'><?=$rval?></a></li>
                                               <? }  ?>
                                               <? }  ?>
    </ul>
</section>
             </div>
              
<script>
$(document).ready(function(){
        
             $('ul.listA li span').parent().addClass('list-title');
        
    });
    </script>
    

<?php
foreach( $reportsarr as $keyname=>$tmpreportsarr ) {
        $groupingkey = str_replace( array( " ", "/", "&" ), "-", strtolower( $keyname ) );
?>
        <!-- begin report grouping -->
        <? //if( $keyname != "Overview" ) { ?>
               <a name='<?=$groupingkey?>'></a>
                  
               <div class="search-hidden-container" id="shc-lyricstitle">
               		<h3><a class="expand-btn-2 <?=$groupingkey?>" id="expander-<?=$groupingkey?>"><?=$keyname?></a></h3>
               		<div id="search-hidden-2" class="<?=$groupingkey?> temp-hidden">
     
        	<? 
        foreach( $tmpreportsarr as $sectionid=>$sectionname ) { 
        $groupingkey = str_replace( array( " ", "/", "&" ), "-", strtolower( $keyname ) );
					?>
       				 				<a name="<?=$groupingkey?>_<?=$sectionid?>"></a>
           		 				<? if( $sectionid == "Number-Of-Songs-Within-The-Top-10" ) {  ?>
							 				<section class="graph-section">
   										 <h2>FOUR QUARTER TRENDS: ALL SONGS</h2>
       				 				<? } ?>
      
											<section class="<?=$sectionid?>">
													<!--<a class='backtotop' href='#'>Back To Top >></a>-->
									 				<hr />
             <? include "trendreportincludes/{$sectionid}.php"; ?>
										 </section>
										 
				<? }  ?>
     
    
    							<div class="cf"></div>
    							</div>
    					</div>
				   
    
       <!-- end report grouping -->
	 	 	 <?// } ?>
 <? }  ?>
       
   
<section>
                
                        <div class="search-footer">
							<div class="search-footer-left span-3">
							
							
								<div class="cf"></div>
							</div><!-- /search-footer-left -->
							<div class="search-footer-right span-4">
    <? if( !isStudent() && !isEssentials() ) { ?>
    <a class="black-btn" href="#" data-featherlight="#searchlightbox">SAVE SEARCH</a>
                            <? } ?>
								<a class="orange-btn" href="/trend-search">NEW SEARCH</a>
								<div class="lightbox" id="searchlightbox">
									<div class="save-search-header">
										<h1>SAVE SEARCH</h2>
									</div><!-- /.save-search-header -->
									<div class="save-search-body">
										<label>Name:</label>
										<input type='text' name="searchname" id='searchname' onChange='javascript:document.getElementById( "searchnamehidden").value = this.value; '>
										<a class="black-btn" href="#" onClick='javascript:saveSearch( "saved", "Trend Report" ); return false'>SAVE</a>
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
		var searchType = "<?=$searchtype?$searchtype:"Trend Report"?>";
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
                  		 var $dashPosition = link.indexOf('_');
                  		 
                  		 if (link.indexOf('_') > -1)
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
         
            var hash = document.location.hash.replace( "#", "" );
<? foreach( $reportsarr as $grouping=>$reportarr ) {  
                $groupingkey = str_replace( array( "&", " ", "/" ), "-", strtolower( $grouping ) );
      foreach( $reportarr as  $sectionid=>$sectionname ) { ?>
          if( hash == "<?=$groupingkey?>_<?=$sectionid?>" )
          {
              $( "#expander-<?=$groupingkey?>" ).trigger( "click" );
              document.location.hash = "#" +hash;
          }
          <? }
            }?>
       <? if( 1 == 0 ) 
	      { ?>
       <? foreach( $allgraphnames as $graphname ) { ?>
		       <?=$graphname?>RenderFlag = false;
		       <?=$graphname?>chartOffsetTop = $('#<?=$graphname?>Container').offset().top;
		       <?=$graphname?>chartOuterHeight = $('#<?=$graphname?>Container').outerHeight();
		       <? } ?>
       $(window).scroll(function() {
		   wH = $(window).height(),
		   wS = $(this).scrollTop();
       <? foreach( $allgraphnames as $graphname ) { ?>
	       if (wS > (<?=$graphname?>chartOffsetTop+<?=$graphname?>chartOuterHeight-wH) && !<?=$graphname?>RenderFlag){
		   <?=$graphname?>RenderFlag = true;
		   <?=$graphname?>.render();
	       }
	   <? } ?>
	      });
<? 	     } ?>
	      });


    </script>
<?php include 'footer.php';?>
