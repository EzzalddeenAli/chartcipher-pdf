<?php 
include 'header.php';?>
  <link rel="stylesheet" type="text/css" href="../assets/css/grid.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/new-style.css" />
<style>
.header-container h1:before, .header-container h1:after {
    width: 600%;
}

@media (min-width: 1000px){
.row-equal {
    flex-wrap: wrap;
}}

[class*="col-"] {
    margin-bottom: 0px;
    margin-right: 0px;
    background-color: transparent;
}
.inner-container{
	margin: 12px;
	box-sizing: border-box;
	    background-color: #ffffff;
}

.element-container {
    padding-left: 12px;
    padding-right: 12px;
}
 .col-4:last-child {
     background-color: transparent;
 }  
 
 .col-3.flex, .col-4.flex, .col-6.flex {
      padding-bottom: 0px!important; 
 }
 
 .header-container {
     margin: 10px 12px 0px 12px;
 }
   .chart-img {
       height: 200px!important;
   }
  .chart-img {
      float: none;
      width: 100%!important;
      overflow: hidden;
      margin-bottom: 15px;
      width: 200px;
     height: 200px!important;
  } 
  .chart-img img {
      width: 100%;
      height: auto;
      max-width: 100%;
  }
  
  .chart-summary {
      width: 100% !important;
      height: auto !important;
      padding: 15px 25px 25px;
          text-align: center;
          min-height: 170px;
              position: relative;
              margin: -7px 0 0;
  }
  
  .chart-summary h1 {
   /*   font-family: 'Open sans'!Important;*/
      text-align: center;
      font-size: 16px!Important;
      line-height: 26px;
      color: #333;
      font-weight: normal;
      margin: 0;
      font-style: normal!Important;
      text-transform: none!important;
  }
  .chart-summary p, .chart-summary {
      font-family: 'Open sans'!Important;
      font-size: 13px;
      color: #7a7a7a;
      line-height: 22px;
  }
  .chart-summary p {
      font-family: 'Open-Sans', sans-serif;
      font-size: 14px;
      color: #333;
      margin: 10px 0 10px 0;
  }
  
  .chart-summary a{
  	color: #8b26b2;
  	text-decoration: none;
  	
  }
   
</style>
	<div class="site-body dd-read-report">
      
        
        
		<section class="">
			<div class="element-container row">
				<div class="header-container">
					<h1>Articles</h1><br>
					       <a href="/">Back to Home <img src="assets/images/home/hit-songs-deconstructed-back-to-home-arrow.svg"></a>
				</div><!-- /.header-container -->
                <div class="row row-equal row-padding">
                    
                   <div class="col-4 flex"> 
                      <div class="inner-container">
                        <div class="chart-img">
                        	<img width="200" height="146" src="https://editorial.chartcipher.com/wp-content/uploads/2017/11/hit-songs-deconstructed-website-wire-feel-it-still-portugal-the-man.jpg" class="attachment-200x170 size-200x170 wp-post-image" alt="">
                        	</div>
                        	<div class="chart-summary">
                        		<h1>Feel It Still Deconstructed</h1>
                        		<!--<p>Feel It Still is the second single from Portugal. The Man’s 2017 album, Woodstock. Equally accessible and left-of-center, the song has gone on to become the most successful of the band’s career, connecting with Portugal. The Man’s core Rock audience and successfully crossing over into&hellip;</p>-->
                        		<p>Feel It Still is the second single from Portugal. The Man’s 2017 album, Woodstock. Equally accessible and left-of-center, the song has gone on to become the most successful of the band’s career, c... </p>
                        		 <a href="https://editorial.chartcipher.com/2017/11/28/feel-still-deconstructed-final/">Continue Reading</a>   
                        			
                        		
                        		
                        	</div>
                        </div>
                   </div>
                    
                 <div class="col-4 flex"> 
                    <div class="inner-container">
                       <!-- /.header-block-1B -->
                       <div class="header-block header-block-read2">
                           <a href="/trend-report-search">
                               <p>The Compositional Trend Report</p>
                           </a>
                       </div><!-- /.header-block-2b -->
                      </div>
                 </div>
                 <div class="col-4 flex"> 
                    <div class="inner-container">
                       <!-- /.header-block-1B -->
                       <div class="header-block header-block-read2">
                           <a href="/trend-report-search">
                               <p>The Compositional Trend Report</p>
                           </a>
                       </div><!-- /.header-block-2b -->
                      </div>
                 </div>
                 <div class="col-4 flex"> 
                    <div class="inner-container">
                       <!-- /.header-block-1B -->
                       <div class="header-block header-block-read2">
                           <a href="/trend-report-search">
                               <p>The Compositional Trend Report</p>
                           </a>
                       </div><!-- /.header-block-2b -->
                      </div>
                 </div>
                 <div class="col-4 flex"> 
                    <div class="inner-container">
                       <!-- /.header-block-1B -->
                       <div class="header-block header-block-read2">
                           <a href="/trend-report-search">
                               <p>The Compositional Trend Report</p>
                           </a>
                       </div><!-- /.header-block-2b -->
                      </div>
                 </div>
                 <div class="col-4 flex"> 
                    <div class="inner-container">
                       <!-- /.header-block-1B -->
                       <div class="header-block header-block-read2">
                           <a href="/trend-report-search">
                               <p>The Compositional Trend Report</p>
                           </a>
                       </div><!-- /.header-block-2b -->
                      </div>
                 </div>                      
                   
                    </div>
                    
                    
                    
                
            
                       
                
                
                
             
                
                 
                
                 
                
                 
                
                 
                
                  
                
                
                
			</div><!-- /.row -->
		</section><!-- /.home-top -->

	</div><!-- /.site-body -->
	<script>
		$(".header-block").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});
	</script>
<?php include 'footer.php';?>