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

$quarter = $fq;
$year = date( "Y" );
$oldestq = $exp[0];
$oldesty = $exp[1];
$quarterstorun = getQuarters( $oldestq, $oldesty, $quarter, $year );

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

	<div class="site-body index-pro ">
<? include "chartchooser.php"; ?>                
             
               
                
               <div class="row  row-equal row-padding mobile link-alt">
                            <div class="col-6">
                       <div class="home-search-header  flex-addon">
                                <h2>Highest Levels in Four or More Quarters</h2>
                               
                            </div>
                         <div class="header-inner " >
                         <table class="table insights-section">
<?php
$characteristics = gatherCharacteristicsMultipleQuarters( $quarterstorun, "highest");
if( !count( $characteristics ) )
    $characteristics[ "None"] = "";
 foreach( $characteristics as $c=>$displ ) { 
 if( $displ == "No" ) continue; ?>
                     <tr>
                                <td><span><span><?=$c?></span> <?=$displ?></span>
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
                                <h2>View Trend Graph</h2>
                                 <a class="search" href="/saved-searches"> View Trend <img src="assets/images/home/search-view-icon.svg" /></a>
                            </div>
                         <div class="header-inner insight-graph" >
                      
                        </div><!-- /.header-block-1B -->
                                 <div class="info-block">
                             <p>Compositional characteristics that are at their highest levels in four or more quarters.</p>
                        </div>
                      </div>
                      </div>
        
                
                
                

                
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
<?php include 'footer.php';?>
