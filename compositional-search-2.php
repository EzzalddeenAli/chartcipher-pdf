<?php 
include "header.php";

include "trendfunctions.php";

$thetype = str_replace( ".php", "", $thetype );
$thetype = array_shift( explode( "?", $thetype ) );

if( !$thetype ) $thetype = $searchsubtype;
if( isset( $_GET["graphtype"] ) && $search[dates][toq] == $search[dates][fromq] &&  $search[dates][toy] == $search[dates][fromy] )
{
    $onlyonequarter = true;
}


$titles["/compositional-search"] = "Compositional";
$titles["/structure-search"] = "Structure";
$titles["/production-search"] = "Production";
$titles["/lyrical-search"] = "Lyrical";

//print_r( $_SERVER );
$blah = str_replace( ".php", "", $_SERVER["SCRIPT_NAME"] );
///echo( $blah ); exit;
$title = strtoupper( $titles[$blah ] );
if( !$title )
    $title = "TREND SEARCH";
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
                
                
                
                
       
                <div class="row inner row-equal row-padding">
                           <div class="col-12 flex">
                               
                               <div class="home-search-header  chart-header desktop-alt variant2 flex-addon ">
      
<? 
$tmpurl = "trend-search.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&setchart=". $chartid , "", $tmpurl );
$tmpurl = str_replace( "&setchart=". $setchart , "", $tmpurl );
$tmpurl .= "&setchart=";
?>
                         <div class="custom-select" >
								<select name='setchart' onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value'>
									<option value="">All</option>
<? outputSelectValuesForOtherTable( "charts", $chartid, false, " and UseOnDb = 1" ); ?>
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
                
                
                
                

                 <div class="row outter row-equal row-padding">
                    <div class="col-12 flex switch">
               
                       <div class="row inner row-equal row-padding link-alt">
                           <div class="col-12 flex">
                               <div class="home-search-header">
                                        <h2>Compositional Trends</h2>
                                        <div class="cf"></div>
                                </div>
                                 <div class="inner-content ">
                                    <div class="display-list">
                                  <div class="header-inner " >
                               
<div class="form-header adj" style="margin-bottom:50px;">
        <div class="form-column span-4 element-inline" style="vertical-align:middle;">
            <h3><input type="radio" name="searchby" id="range" value="Quarter" checked=""> <label for="range"><span></span> Select a Quarter Range</label></h3>
            <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
                    <select id="fromq" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][fromq]"  <?=$searchby=="Year"?"disabled":""?>>
                      <option value="">Any</option>
  <? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
                    </select>
                </div>
                                    
                  <div id="fromqerror"></div>
								</div>
								<div class="form-row-right-inner">
                    <select id="fromy" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][fromy]"  <?=$searchby=="Year"?"disabled":""?>>
                      <option value="">Any</option>
  <? outputSelectValues( $years, $search["dates"]["fromy"] ); ?>
                    </select>
								</div>
								<div class="form-row-left-inner">
								</div>
								<div class="form-row-right-inner">
    </div>
							
							</div><!-- /.form-row-left -->
            
            <div class="range range-full">to</div>
            	<div class="cf"></div>
            
            <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
									<select name="search[dates][fromq]" id="fromq" onchange="resetYears()">
									<option value=""  disbaled selected>Select</option>
                                          
<option value="2">Q1</option>
<option value="3">Q2</option>
<option value="4">Q3</option>
<option value="5">Q4</option>
									</select>
                </div>
                                    
                  <div id="fromqerror"></div>
								</div>
								<div class="form-row-right-inner">
                                
									<select name="search[dates][fromy]" id="fromy" onchange="resetYears()">
								<option value=""  disbaled selected>Select</option>

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
							</div><!-- /.form-row-left -->
            
            
            
            

       </div><div class="circle-wrap  element-inline"><div class="circle">-or-</div></div><div class="form-column span-4 element-inline" style="margin-right:0;vertical-align:middle;">
            <h3><input type="radio" name="searchby" id="quarter" value="Year"> 
                <label for="quarter"><span></span> Or Year Range</label> </h3>
             <div class="form-row-full year-select">
                <div class="form-row-left-inner">
                  <select name="search[dates][fromyear]" id="fromyear" onchange="resetQuarters()" >
                  <option value="" disabled selected>Select</option>
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
<div class="range range-short ">to</div>
                <div class="form-row-right-inner">
                  <select name="search[dates][toyear]" id="toyear" onchange="resetQuarters()" >
                  <option value="" disabled selected>Select</option>
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
                   <div class="range range-question">To Search for seasonal trends, select a season below.</div>                         
            <div class="form-row-full year-select">
                <div class="form-row-inner">
                 
                  <select name="search[dates][fromyear]" id="fromyear" onchange="resetQuarters()" >
                  <option value="any" selected>Any</option>
      <option value="2013">Q1</option>
<option value="2014">Q2</option>
<option value="2015">Q3</option>
<option value="2016">Q4</option>
<option value="2017">Q1 & Q3</option>
<option value="2018">Q2 & Q4</option>
                  </select>
                </div>
                <div class="cf"></div>
              </div>
                                  

       </div>
 </div>
                                      
 <div class="form-header " >
             <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
                                        <label>Select Search Focus</label>
									<select name="search[dates][fromq]" id="fromq" onchange="resetYears()">
									<option value="" disabled selected>(Select One)</option>
<option value="1">Item 1</option>
<option value="2">Item 2</option>
<option value="3">Item 3</option>
<option value="4">Item 4</option>
									</select>
                </div>
                                    
                  <div id="fromqerror"></div>
								</div>
								<div class="form-row-right-inner">
                                  <label>Select Peak Chart Position</label>
									<select name="search[dates][fromy]" id="fromy" onchange="resetYears()">
									<option value="1"  selected>All</option>

<option value="2">Top 10</option>
<option value="3">Top 25</option>
<option value="4">Top 50</option>

									</select>
								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
     
     
                  <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
                                        <label>Select songs to include (New songs/Carryovers)</label>
									<select name="search[dates][fromq]" id="fromq" onchange="resetYears()">
									<option value=""  selected>All</option>
<option value="2">Only include new songs for the selected time-period</option>
<option value="3">Only include songs that were previously charting</option>

									</select>
                </div>
                                    
                  <div id="fromqerror"></div>
								</div>
								<div class="form-row-right-inner">
                                  <label>Minimum # of weeks on [chart name]</label>
									<select name="search[dates][fromy]" id="fromy" onchange="resetYears()">
									<option value="" disabled selected>(Any, 10, +25, 50+) </option>
<option value="1">Any</option>
<option value="2">5</option>
<option value="3">10</option>
<option value="4">15</option>
<option value="5">20</option>
<option value="6">25</option>
<option value="7">30+</option>
									</select>
								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
 </div>
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                </div><!-- /.header-block-1B -->

                                     </div>
                                </div><!-- /.header-block-1B -->

                           </div>
                           
                     
                   </div>
                </div>
                   </div>
                
                
                               <div class="row outter row-equal row-padding">
                    <div class="col-12 flex switch">
               
                       <div class="row inner row-equal row-padding link-alt">
                           <div class="col-12 flex">
                               <div class="home-search-header">
                                        <h2>Additional Search Filters</h2>
                                        <div class="cf"></div>
                                </div>
                                 <div class="inner-content ">
                                    <div class="display-list">
                                  <div class="header-inner " >

                                      
 <div class="form-header " >
             <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                               
                                        <label>Select A Specific Primary Genre</label>
									<select name="search[dates][fromq]" id="fromq" onchange="resetYears()">
									<option value="" selected>All</option>
<option value="2">Item 2</option>
<option value="3">Item 3</option>
<option value="4">Item 4</option>
									</select>
          
                                    
                  <div id="fromqerror"></div>
								</div>
								<div class="form-row-right-inner">
                                  <label>Select a Specific Sub-Genre/Influence</label>
									<select name="search[dates][fromy]" id="fromy" onchange="resetYears()">
									<option value=""  selected>All</option>
<option value="2">Item 2</option>
<option value="3">Item 3</option>
<option value="4">Item 4</option>

									</select>
								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
     
     
                  <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
                                        <label>Select a Specifc Lyrical Theme</label>
									<select name="search[dates][fromq]" id="fromq" onchange="resetYears()">
									<option value="" selected>All</option>
<option value="2">Item 2</option>
<option value="3">Item 3</option>
<option value="4">Item 4</option>

									</select>
                </div>
                                    
                  <div id="fromqerror"></div>
								</div>
								<div class="form-row-right-inner">
                                  <label>Select a Specifc Lyrical Mood</label>
									<select name="search[dates][fromy]" id="fromy" onchange="resetYears()">
									<option value=""  selected>All</option>

<option value="2">Item 2</option>
<option value="3">Item 3</option>
<option value="4">Item 4</option>
									</select>
								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
     
     
     
                  <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
                                        <label>Select Songs in a Major or Minor Key</label>
									<select name="search[dates][fromq]" id="fromq" onchange="resetYears()">
									<option value=""selected>All</option>

<option value="2">Item 2</option>
<option value="3">Item 3</option>
<option value="4">Item 4</option>

									</select>
                </div>
                                    
                  <div id="fromqerror"></div>
								</div>
								<div class="form-row-right-inner">
                                  <label>Select a Specifc BPM Range</label>
									<select name="search[dates][fromy]" id="fromy" onchange="resetYears()">
									<option value=""  selected>All</option>

<option value="2">Item 2</option>
<option value="3">Item 3</option>
<option value="4">Item 4</option>
									</select>
								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
     
     
     
     
     
                  <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                   
                                        <label>Select Output Format</label>
									<select name="search[dates][fromq]" id="fromq" onchange="resetYears()">
									<option value="" disabled selected>(Select One)</option>
<option value="2">Chart</option>
<option value="3">Graph</option>

									</select>
              
                                    
                  <div id="fromqerror"></div>
								</div>
								<div class="form-row-right-inner">
                               <div class="submit-btn-wrap">
                                   <div></div>
                                       <input type="submit" value="Search">
                                    </div>
                              
								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
 </div>
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                </div><!-- /.header-block-1B -->

                                     </div>
                                </div><!-- /.header-block-1B -->

                           </div>
                           
                     
                   </div>
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

        
                    
//        console.log('test');
            
//            if(w.value > 1700){
                
//            }
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
//	    file_put_contents( "homequeries", date( "H:i:s" ) . ", ". $numlogqueries . " queries\n", FILE_APPEND );
?>

<?php include 'footer.php';?>
