<?php 
$ishomepage = 1 ;
include 'header.php';

        $homevals = db_query_array( "select name, value from homepage", "name", "value" );
?>
<link rel="stylesheet" type="text/css" href="../assets/css/style-temp.css">
<link rel="stylesheet" type="text/css" href="../assets/css/desktop.css" media="screen and (min-width: 768px)">
  <link rel="stylesheet" type="text/css" href="../assets/css/grid.css" />

<script>
$(document).ready(function () {
    updateContainer();
    $(window).resize(function() {
        updateContainer();
    });
});
function updateContainer() {
    var $containerWidth = $(window).width();
    var database_half = $('.database').height() / 2;  
       var inner_half = $('.logo-box').height() / 2;  
    var inner_third = $('.logo-box').height() / 3;  
    var center = database_half - inner_half;  
        var center_safari = database_half;  
    if ($containerWidth <= 1184) {
         $(".logo-box").css('margin-top','');
          $(".logo-box").css('margin-bottom', '');
    }
    if ($containerWidth > 1184) {
        if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1)  { 
  $(".logo-box").css('margin-top',center+'px');
}else{
   $(".logo-box").css('margin-top',center+'px');   
}
      
   
    }
    

}
</script>
<style>
    
      .flex{
        margin-right:20px;
       background-color:#fff;
       padding:0px!important;
}
    
  @media (min-width:1200px){
        .row-equal{
   display: flex!important;
 display:-webkit-flex!important;
        }
    }
    
    @media (max-width:1200px){
            .row-padding{
padding-right:20px;
        }
    }
    
/* [class*="col-"]:last-child {
margin-right:0px;
} */
    
[class*="col-"] {
    padding: 0px 20px 0 0;
    margin-top:20px;
    position:relative;
}
        @media (max-width:1200px){
    [class*="col-"] {
    padding-right:0px;
}}
    
.container {
    padding: 0px 0px 30px 20px;
}
    
     section{
 /* height:100%; */
     padding-top:60px;
}
     section.addon{
     padding:15px 20px 15px 20px;
         position:absolute;
         bottom:10px;
}
 
    
    
    
    .site-body {
    margin-top: 142px;
}
    
    
    @media (min-width:768px){
            .site-body {
    margin-top: 170px;
}
    }
    
        @media (min-width:1150px){
            .site-body {
    margin-top: 122px;
}
    }
   

    
    .left{float:left;}
    .right{float:right;
    display: block;
    right: 20px;
    position: absolute;;}
    
hr{
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #ccc;
    margin: 1em 0;
    padding: 0; 
    border-color:#eee;
}
    

.site-body section header{
    position:absolute;
    top:0px;
    left:0px;
    width:100%;
    height:45px;
}

main {
background-color:transparent;
    margin-top:0px;
}
header h1{
font-size:14px;
color:#ff6633;
}

.boxa{
 width:100%;
background-color:#eff2f7;
    margin-bottom:15px;
}  
.boxa:last-child{
    margin-bottom:0px;
}
    
.box-images{
    float:left;
    width: 122px;
    height: 100px;
    position:relative;
max-height:100%;
   margin-right: 10px;
    overflow:hidden;
}
   
.box-images img{
width:100%;
    height:auto;
}
@media (min-width:1200px) and (max-width:1350px) {
.box-images img{
width:auto;
    height:100%;
}
.box-images{
    padding-right: 0px;
}
   
}
    
.box-text{
    width:100%;
    float:none;
 padding:10px 8px 5px 8px; 
    box-sizing:border-box;
    font-size:13px;
}
    
 p{
margin-bottom:6px;
    font-size:13px;
}
    
 .box-text p{
font-size:14px;
    line-height:20px;
    margin-bottom:5px;
}
    @media  (min-width:1400px)  {
         .box-text {
 padding:10px 15px 0px 15px;
}
    }
    
    @media  (min-width:770px) and (max-width: 1200px) {
         .box-text p{
font-size:16px;
    line-height:24px;
}
    }
    
@media  (min-width:1200px) and (max-width: 1500px) {
  {
    font-size:10px!important;
   }   
    .boxa {
    min-height: 100px!important;
}
    .box-images{
width: auto!important;
height: 100px!important;
}
    .box-images img{
width:auto!important;
    height:100%!important;
      
}
    
    .box-text{
    width:auto!important;
}
                .box-text p{
font-size:12px;
    line-height:16px;
}
}
     @media  (min-width:1750px)  {   
                .box-text p{
font-size:16px;
    line-height:24px;
}  
     }

    
.box-text span{
font-style: italic;
    color:#ff6633;
}
.box-text a{
text-decoration: none;
    color:#ff6633;
}
.box-text a:after{
text-decoration: none;
    color:#ff6633;
   background : url(assets/images/readmore.png) no-repeat!important;
       content: ''!important;
    background-color: transparent!important;
    display: inline-block!important;
    z-index: 99999999999!important;
    width: 15px;
    height: 10px;
    margin-left: 5px;
}
    


 .logo-box {
text-align:center;
     position:relative;
   


}
 /*   @media(min-width:1200px){
     .logo-box {
        position: relative;
top:50%
-webkit-transform: translate(0%, 50%);
-moz-transform: translate(0%, 50%);
-ms-transform: translate(0%, 50%);
-o-transform: translate(0%, 50%);
transform: translate(0%, 50%);

}}*/
    
.logo-box img {
text-align:center;
    padding-bottom:20px;
}

    

#graph img{ 
 width:100%;  
    margin-bottom:20px;
}
    

.section-img img{ 
 width:100%;  
    margin-bottom:20px;
    max-width:555px;
    display:block;
    margin:0 auto;
    
}
    .search a,
    .view-all a,
     .download a{
     color:#7a7a7a;
        font-size:11px;
        text-decoration:none;
    }
    
     .search:before{
     color:#7a7a7a;
        font-size:11px;
            background : url(assets/images/home/hsd-search-icon2.svg) no-repeat!important;
       content: ''!important;
    background-color: transparent!important;
    display: inline-block!important;
    z-index: 99999999999!important;
    width: 10px;
    height: 10px;
    margin-right: 2px;
    }
     .view-all:before{
     color:#7a7a7a;
        font-size:11px;
            background : url(assets/images/home/hsd-view-icon2.svg) no-repeat!important;
       content: ''!important;
    background-color: transparent!important;
    display: inline-block!important;
    z-index: 99999999999!important;
    width: 15px;
    height: 10px;
    margin-right: 0px;
    }
     .download:before{
     color:#7a7a7a;
        font-size:11px;
            background : url(assets/images/home/hsd-download-icon.svg) no-repeat!important;
       content: ''!important;
    background-color: transparent!important;
    display: inline-block!important;
    z-index: 99999999999!important;
    width: 15px;
    height: 12px;
    margin-right: 0px;
    }
    
    .botom-text{
        font-size:12px;
        font-style:italic;
        color:7a7a7a;
        font-weight:300;
    }
    
    @media (min-width:767px){
        
    }
    
    .logo-box input[type=submit] {
    width: 100%;
    float:none;
        max-width:150px;
}

    .graph section {
    background-color: #fff;
    padding: 50px 20px 0px 20px;
}
    
    
    #chartContainer,
    canvasjs-chart-container{
height:310px!important;
    }
 
    
   .adj-column{
min-height:358px!important;
       height:auto;
    }
    
    .canvasjs-chart-canvas{
     max-width:100%!important;   
    }
    
  /*   #chartContainer{
    margin-top: 30px;
    }*/
    
     .essentials-image{
text-align:left;
        overflow:hidden;   
        height:auto;
         min-height:200px;
        width:100%;
        background-color:transparent;
           float:left;
    position:relative;
    margin-bottom: 10px;
    }
      .essentials-image img{
    width:100%;
            height:auto;
    }
    
    @media(min-width:405px){
         .essentials-image{
        height:100%;
        width:200px;
    margin-right: 10px;
    margin-bottom: 0px;
    }
    
    }
    
    
    @media (min-width:1200px){
      .essentials-image{
          text-align:right;
        overflow:hidden;   
        width:100%;
     margin-bottom:10px;
          
    }}
    
    @media (min-width:1355px){
     .essentials-image{
         text-align:center;
        overflow:hidden;
              height:208px;
        width:180px;
              margin-bottom:0px;
    } 
      .essentials-image img{
    height:100%;
            width:auto;
    }}
    
        @media (min-width:1500px){
     .essentials-image{
         text-align:center;
        overflow:hidden;
        width:208px;
              margin-bottom:0px;
    }}
    
    .inner-footer{
        position:relative;
     padding-top:10px; 
        border-top:.6px solid #eee ;
        bottom:0px;
        width:100%;
        height:40px;
    }
       @media (min-width:1200px){
      .inner-footer{
        position:absolute;
    }}
    
     section.main{
        position:relative;
        margin-bottom:0px;
    }
    
    @media (min-width:1200px){
    section.main{
        position:relative;
        margin-bottom:40px;
    }}
    
     section.database{
     height:100%!important;
        position:relative;
    }
    
</style>





<div class="site-body">
        <section class="home-top">
			<div class="element-container row">
				<div class="header-container">
					<h1>Recent Chart Cipher Reports</h1><br>
                           <a href=""><img src="assets/images/home/hit-songs-deconstructed-browse-reports-icon.svg">  Browse Reports</a>
				</div><!-- /.header-container -->
               
                <?php
                include 'masterslider/homepage/start.php';
                ?>
            </div><!-- /.row -->
		</section><!-- /.home-top -->
        
        
		<section class="home-top">
			<div class="element-container row">
				<div class="header-container">
					<h1>What would you like to do?</h1>
				</div><!-- /.header-container -->
                <div class="row row-equal row-padding">
                    
                   <div class="col-3 flex"> 
                         <div class="header-block header-block-1b">
                            <a href="/artist-search">
                                <p>Read a Report</p>
                            </a>
                        </div><!-- /.header-block-1B -->
                        <div class="info-block">
                            <a href="#openModal1"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>                          
                        </div><!-- /.header-block-1B -->
                   </div>
                    
                  <div class="col-3 flex"> 
                          <div class="header-block header-block-2b">
                            <a href="/artist-search">
                                <p>Search for Compositionsal Trends</p>
                            </a>
                        </div><!-- /.header-block-2b -->
                        <div class="info-block">
                            <a href="#openModal2"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-2B -->
                   </div>
                    
                   <div class="col-3 flex"> 
                          <div class="header-block header-block-3b">
                            <a href="/artist-search">
                                <p>Search for iIndustry Trends</p>
                            </a>
                        </div><!-- /.header-block-3b -->
                        <div class="info-block">
                            <a href="#openModal3"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-3B -->
                   </div>
                    
                    
                   <div class="col-3 flex"> 
                          <div class="header-block header-block-4b">
                            <a href="/artist-search">
                                <p>Compare Compositional trends</p>
                            </a>
                        </div><!-- /.header-block-4b -->
                        <div class="info-block">
                            <a href="#openModal4"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-4B -->
                   </div>
                    </div>
                
                 <div class="row row-equal row-padding">
                    
                   <div class="col-3 flex"> 
                         <div class="header-block header-block-5b">
                            <a href="/artist-search">
                                <p>Top 10 Staying Power</p>
                            </a>
                        </div><!-- /.header-block-5B -->
                        <div class="info-block">
                            <a href="#openModal5"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>                          
                        </div><!-- /.header-block-5B -->
                   </div>
                    
                  <div class="col-3 flex"> 
                          <div class="header-block header-block-6b">
                            <a href="/artist-search">
                                <p>Search for Songs by Song Title, Songwriter, Performing Artist or Label</p>
                            </a>
                        </div><!-- /.header-block-6b -->
                        <div class="info-block">
                            <a href="#openModal6"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-6B -->
                   </div>
                    
                   <div class="col-3 flex"> 
                          <div class="header-block header-block-7b">
                            <a href="/artist-search">
                                <p>Power Search</p>
                            </a>
                        </div><!-- /.header-block-7b -->
                        <div class="info-block">
                            <a href="#openModal7"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-7B -->
                   </div>
                    
                    
                   <div class="col-3 flex"> 
                          <div class="header-block header-block-8b">
                            <a href="/artist-search">
                                <p>Browse</p>
                            </a>
                        </div><!-- /.header-block-8b -->
                        <div class="info-block">
                            <a href="#openModal8"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-8B -->
                   </div>
                    </div>
                
                
                
                        <div class="row row-equal row-padding">
                    
                   <div class="col-4 "> 
                        <div class="home-search home-search-2">
                            <div class="home-search-header">
                                <h1>RECENT ARTICLES</h1>
                                <a class="search-view" href="/recent-searches">View All</a>
                                <!-- <a class="search-manage" href="#">Manage</a> -->
                                <div class="cf"></div>
                            </div><!-- /.home-search-header -->
                            <div class="home-search-body">
                                <table width="100%">
                                    <tr data-href="<?=$s[url]?>">
                                        <td class="home-search-column-1">
                                             Believer
                                        </td>
                                        <td class="home-search-column-2">
                                            Imagine Dragons 
                                        </td>
                                        <td class="home-search-column-3">
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                    <tr data-href="<?=$s[url]?>">
                                        <td class="home-search-column-1">
                                             Believer
                                        </td>
                                        <td class="home-search-column-2">
                                            Imagine Dragons 
                                        </td>
                                        <td class="home-search-column-3">
                                           <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                    <tr data-href="<?=$s[url]?>">
                                        <td class="home-search-column-1">
                                             Believer
                                        </td>
                                        <td class="home-search-column-2">
                                            Imagine Dragons 
                                        </td>
                                        <td class="home-search-column-3">
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div><!-- /.home-search-2 -->
                   </div>
                    
                  <div class="col-4 "> 
                         <div class="home-search home-search-2">
                            <div class="home-search-header">
                                <h1>SAVED SERACHES</h1>
                                <a class="search-view" href="/recent-searches">View All</a>
                                <!-- <a class="search-manage" href="#">Manage</a> -->
                                <div class="cf"></div>
                            </div><!-- /.home-search-header -->
                            <div class="home-search-body">
                                <table width="100%">
                                    <tr data-href="<?=$s[url]?>">
                                        <td class="home-search-column-1">
                                            Lorem Ipsum
                                        </td>
                                        <td class="home-search-column-2">
                                            Staying Power
                                        </td>
                                        <td class="home-search-column-3">
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                    <tr data-href="<?=$s[url]?>">
                                        <td class="home-search-column-1">
                                             Lorem Ipsum
                                        </td>
                                        <td class="home-search-column-2">
                                            Artist Search
                                        </td>
                                        <td class="home-search-column-3">
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                    <tr data-href="<?=$s[url]?>">
                                        <td class="home-search-column-1">
                                             Lorem Ipsum
                                        </td>
                                        <td class="home-search-column-2">
                                            Songwriter Search
                                        </td>
                                        <td class="home-search-column-3">
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div><!-- /.home-search-2 -->
                   </div>
                    
                   <div class="col-4 "> 
                          <div class="home-search home-search-2">
                            <div class="home-search-header">
                                <h1>NEW FEATURE RELEASES</h1>
                                <a class="search-view" href="/recent-searches">View All</a>
                                <!-- <a class="search-manage" href="#">Manage</a> -->
                                <div class="cf"></div>
                            </div><!-- /.home-search-header -->
                            <div class="home-search-body">
                                <table width="100%">
                                    <tr data-href="<?=$s[url]?>">
                                        <td class="home-search-column-1">
                                             Filter by Artist, Songwriter & Genre
                                        </td>
                                        <td class="home-search-column-2">
                                            New Feature
                                        </td>
                                        <td class="home-search-column-3">
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                    <tr data-href="<?=$s[url]?>">
                                        <td class="home-search-column-1">
                                             Bar Graphs
                                        </td>
                                        <td class="home-search-column-2">
                                            New Feature
                                        </td>
                                        <td class="home-search-column-3">
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                    <tr data-href="<?=$s[url]?>">
                                        <td class="home-search-column-1">
                                             Staying Power
                                        </td>
                                        <td class="home-search-column-2">
                                            New Feature 
                                        </td>
                                        <td class="home-search-column-3">
                                           <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div><!-- /.home-search-2 -->
                   </div>
                    
                
                    </div>
                
                
                
             
                <!-- /MODAL BOXES -->
                 <div id="openModal1" class="modalDialog">
                    <div class="">
                        <a href="#close" title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-read-a-report-icon.svg">
                        <h2>Read a Report</h2>
                        <p>From here you can access all reports.</p>
                        <P><a href=""><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                 <div id="openModal2" class="modalDialog">
                    <div class="">
                        <a href="#close" title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-search-for-compositional-trends-icon.svg">
                        <h2>Search for Compositional Trends</h2>
                        <p>Look for compositional trends across the Top 10 or for #1 Hits. Filter results by a selected time-period, genre or peak chart position. View results as a line graph or a bar graph.</p>

                        <P><a href=""><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                 <div id="openModal3" class="modalDialog">
                    <div class="">
                        <a href="#close" title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-search-for-industry-trends-icon.svg">
                        <h2>Search for Industry Trends</h2>
                        <p>Find out what degree of success record labels, artists and songwriters are having quarter to quarter and what songs they account for. You can view trends for a selected time-period as a whole, or only look at songs by a specific songwriter, artist or label. Additional filters include peak chart position and genre. View search results as a line graph or a bar graph.</p>

                        <P><a href=""><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                 <div id="openModal4" class="modalDialog">
                    <div class="">
                        <a href="#close" title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-compare-compositional-trends-icon.svg">
                        <h2>Compare Compositional Trends</h2>
                        <p>Compare genres, influences, song structure characteristics, lyrical themes and more across performing artists, songwriters, record labels. You can either look at Top 10 or #1 Hits as a whole, or select up to 10 individual songs, artists, songwriters, or labels to see what compositional characteristics they have in common.  For example, compare 10 songs written by Max Martin to each other.  Or compare compositional characteristics for songs written by Max Martins to those written by Benny Blanco. </p>

                        <P><a href=""><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                  <div id="openModal5" class="modalDialog">
                    <div class="">
                        <a href="#close" title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-top-10-staying-power-icon.svg">
                        <h2>Top 10 Staying Power</h2>
                        <p>Search for how many weeks a song, performing artist, songwriter, record label, primary genre, or lead vocal gender spent in the Top 10 or at #1 during a specific time-period. And then drill down to view the songs and their compositional characteristics.</p>
                        <P><a href=""><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                 <div id="openModal6" class="modalDialog">
                    <div class="">
                        <a href="#close" title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-search-for-songs-icon.svg">
                        <h2>Search for Songs by Song Title, Songwriter, Performing Artist or Label</h2>
                        <p>Search for songs by song title, songwriter, performing artist or label to view their compositional characteristics and filter by peak chart position, genre and more.</p>

                        <P><a href=""><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                 <div id="openModal7" class="modalDialog">
                    <div class="">
                        <a href="#close" title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-power-search-icon.svg">
                        <h2>Power Search</h2>
                        <p>Search for songs with very specific compositional characteristics, including lyrics, titles, vocals, influences, instruments, song structure characteristics and more.  There are over 200 searchable criteria to choose from.</p>

                        <P><a href=""><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                 <div id="openModal8" class="modalDialog">
                    <div class="">
                        <a href="#close" title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-browse-icon.svg">
                        <h2>Browse</h2>
                        <p>Not sure what you are looking for? Here you can browse through all the songs housed in the database. </p>

                        <P><a href=""><button>GET STARTED</button></a></P>
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