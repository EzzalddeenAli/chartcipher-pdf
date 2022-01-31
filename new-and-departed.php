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

	<div class="site-body index-pro ">
        <section class="home-top">
			<div class="element-container row">
				
<? 
    $whatsnewcache = getDashCache( "whatsnewcachemore" );
if( !$whatsnewcache || 1 )
    {
	ob_start();
?>
                
                
                
                
                     
                         
                <div class="row inner row-equal row-padding">
                           <div class="col-12 flex">
                               
                               <div class="home-search-header  chart-header desktop-alt variant2 flex-addon ">
      
                         <div class="custom-select" >
                              <select>
                                <option value="0">Chart Name</option>
                                <option value="1">Chart Name 2</option>
                                <option value="2">Chart Name 3</option>
                                <option value="3">Chart Name 4</option>
                                <option value="4">Chart Name 5</option>
                                <option value="5">Chart Name 6</option>
                                <option value="6">Chart Name 7</option>
                                <option value="7">Chart Name 8</option>
                                <option value="8">Chart Name 9</option>
                                <option value="9">Hot Rock Alternative Songs</option>

                              </select>
                            </div>
                                <span>
                                    <ul>
                                        <li><a href="home" class="email-link">Email Link</a></li>
                                        <li><a href="home" class="copy-link">Copy Link</a></li>
                                        <li><a href="home" class="back-link">Back Link</a></li>
                                    </ul> 
                                    </span>
                            </div>
                               
                           </div>
                           
                     
                   </div>
                
                       
                <div class="row inner row-equal row-padding mobile-alt">
                           <div class="col-12 flex">
                               
                               <div class="home-search-header  chart-header variant2 flex-addon ">
                                <span>
                                    <ul>
                                        <li><a href="home" class="email-link">Email </a></li>
                                        <li><a href="home" class="copy-link">Copy Link</a></li>
                                        <li><a href="home" class="back-link">Back </a></li>
                                    </ul> 
                                    </span>
                            </div>
                               
                           </div>
                           
                     
                   </div>
             
                

               
                       <div class="row inner row-equal row-padding link-alt">
                           <div class="col-12 flex">
                               <div class="home-search-header">
                                        <h2>New and Departing Songs: Week of X</h2>
                                        <div class="cf"></div>
                                </div>
                                 <div class="inner-content ">
                                    <div class="display-list">
                                  <div class="header-inner " >
                                             <table role="table" class="table-insights table-new-departed ">
                             <thead role="rowgroup">
                                 <tr role="row">
                                              <th role="columnheader"></th>
                                     <th role="columnheader">New</th>  
                                     <th role="columnheader">Departed</th>
                                 </tr>
                             </thead>
                            <tbody role="rowgroup">
                                
                             <tr role="row">
                                <td role="cell"><a href="home" class="rowlink">Primary Genre</a></td>
                                 <td role="cell">Pop(80%)</td>
                                        <td role="cell">Hip-Hop(80%)</td>
                                  
                   
                            </tr>
                                  <tr role="row">
                                    <td role="cell"><a href="home" class="rowlink">Lyrical Theme</a></td>
                                  <td role="cell">Love Relationships(80%)</td>
                                        <td role="cell">Lifestyle(80%)</td>
                                     
                            </tr>
                                
                                    <tr role="row">
                                       <td role="cell"><a href="home" class="rowlink">Lyrical Mood</a></td>
                                  <td role="cell">Nostalgic(80%)</td>
                                        <td role="cell">Dramatic(80%)</td>
                                       
                            </tr>
                                
                                    <tr role="row">
                                       <td role="cell"><a href="home" class="rowlink">Production Mood</a></td>
                                  <td role="cell">Happy(75%)</td>
                                        <td role="cell">Sad(75%)</td>
                                   
                            </tr>
                                
                                    <tr role="row">
                                       <td role="cell"><a href="home" class="rowlink">Dominant Instruments</a></td>
                                  <td role="cell">String Section(80%)</td>
                                        <td role="cell">Wind Section(80%)</td>
                                      
                            </tr>
                                
                                    <tr role="row">
                                       <td role="cell"><a href="home" class="rowlink">Major/Minor</a></td>
                                  <td role="cell">PMajor(80%)</td>
                                        <td role="cell">Minor(80%)</td>
                                     
                            </tr>
                                
                                   <tr role="row">
                                       <td role="cell"><a href="home" class="rowlink">Song Length Range</a></td>
                                  <td role="cell">Under 3:00(80%)</td>
                                        <td role="cell">3:01-3:29(80%)</td>
                                      
                            </tr>
                                
                                  <tr role="row">
                                       <td role="cell"><a href="home" class="rowlink">Average First Chorus</a></td>
                                  <td role="cell">0:40(80%)</td>
                                        <td role="cell">0:44(80%)</td>
                                   
                            </tr>
                        </tbody></table>
                                </div><!-- /.header-block-1B -->

                                     </div>
                                </div><!-- /.header-block-1B -->

                           </div>
                           
                     
                
                   </div>
			    <?  
			    $whatsnewcache = ob_get_contents(); 
	ob_end_clean();
	addDashCache( "whatsnewcache", $whatsnewcache );
    }
echo( $whatsnewcache );
?>

                
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
<? 
	    file_put_contents( "homequeries", date( "H:i:s" ) . ", ". $numlogqueries . " queries\n", FILE_APPEND );
?>

<?php include 'footer.php';?>
