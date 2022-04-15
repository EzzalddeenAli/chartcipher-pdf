<?php
if( isset( $_GET["search"]["chartid"] ) && $_GET["search"][chartid] ) $mybychart = "_bychart";

$nologin = 1;
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions{$mybychart}.php";

$autosuggesttables = array();
//print_r( $GLOBALS );
$hastrendbriefs =  $api->isTrendBriefSub();
$hasdemand = $api->isOnDemandSub();
$hasvideos = $api->canViewOnDemandVideos() || $api->isVideoOnDemandSub();

?>
<!DOCTYPE html>
<html>
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TTS64J4');</script>
<!-- End Google Tag Manager -->
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="stylesheet" href="../assets/css/style.css?ver=<?=time()?>" type="text/css" />
    <link rel="stylesheet" href="../assets/css/style.css?ver=<?=time()?>" type="text/css" />
    <link rel="stylesheet" href="../assets/css/style-tablet.css?ver=<?=time()?>" type="text/css" />

	<link rel="stylesheet" href="../assets/css/desktop.css?ver=<?=time()?>1" type="text/css" media="screen and (min-width: 768px)"/>
	<link rel="stylesheet" href="header-fix-test.css?ver=<?=time()?>" type="text/css" />
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,400italic,600italic,700italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
	<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="//cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>

 <link rel="stylesheet" type="text/css" href="assets/css/grid.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/new-style.css">
 

 


<? if( $istrend|| $ishomepage ) { ?>
	<script src="canvas/source/canvasjs.js"></script>
<? }?>
<? if( $issavedsearch ) { ?>
<!--	<script src="html.sortable.js"></script>-->
<? }?>
<? if( $iscomparable || $searchsubtype || $isindustrytrendreport  ) { ?>
	<script src="table-export/tableExport.js"></script>
	<script src="table-export/html2canvas.js"></script>
<? }?>
	<script src="jquery.sortElements.js"></script>
<? if( $istrendreport ) { ?>
	<script src="canvas/source/canvasjs.js"></script>
   <link rel="stylesheet" type="text/css" href="assets/css/trendreportstyle.css" />
     
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
<? }?>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="/assets/css/featherlight.min.css" type="text/css" rel="stylesheet" />
    <script src="/assets/css/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../assets/js/script.js"></script>
	<!-- Latest compiled and minified CSS -->
	<?if( isAutomaticLogin( $_SERVER["REMOTE_ADDR"] ) && 1 == 0 ) { ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<? } ?>
<!-- Optional theme -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->

<!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->


    <link href="https://pagecdn.io/lib/easyfonts/fonts.css" rel="stylesheet" />
    
</head>
<style type="text/css">
	/*.tool + .tooltip > .tooltip-inner {
      background-color: #ffffff;
      color: #666666;
      border: 1px solid #999999;
      padding: 15px;
      font-size: 12px;
  }
  .tool + .tooltip.bottom > .tooltip-arrow {
    border-bottom: 5px solid #999999;
}*/


    .site-sidebar {
       overflow:visible!important;
    }

   right-wrap
.site-sidebar {
    display: none;
    margin-left: -250px!important;}

    .menu-items ul {
    width: auto !important;
text-align: center !important;
}







   .site-sidebar {
    width: 250px;
    height: 100%;
    position: absolute!important;
    background: #e4e5ea;
    -webkit-transition: all .2s ease-in-out;
    -moz-transition: all .2s ease-in-out;
    -o-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
    margin-left: -250px;
    z-index: 1000;
    overflow-y: auto;
    min-height: 926px;
}
    
     @media (min-width: 1150px){
         .logo-container .sidebar-toggle-box{display: none;}
         

    }

   @media (max-width: 1150px){
       
 

    .logo-container {

 width: 100%!important;
 min-height: 80px!important;
 position: relative!important;
    float:none!important;
}


.site-sidebar {
    width: 250px;
    height: 100%;
    position: absolute!important;
    background: #e4e5ea;
    -webkit-transition: all .2s ease-in-out;
    -moz-transition: all .2s ease-in-out;
    -o-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
    margin-left: -250px;
    z-index: 1000;
    overflow-y: auto;
    min-height: 875px;
}
       .menu-container {
    background-color: #fff;
}





     .menu-bar {
    margin-left: 0px!important;
}
       .menu-bar {
    margin: 0px!important;
    position: absolute!important;
    width: auto!important;
    max-width:50%;
        max-height:85px;
}



       .menu-bar img {
    vertical-align: middle;
      position: absolute;
           padding:10px 0!Important;
             max-height:85px;
}}


.menu-items
{
	margin-right: 6% !important;
	    width: auto !important;
}

.menu-items ul
{
	text-align: right !important;
}

@media (max-width: 1150px)
{
	.menu-items ul
	{
		width: auto !important;
		text-align: center !important;
	}
    	.menu-items
	{
        float:none!important;
	}

}
@media (min-width: 900px)
{

	.menu-text h1
	{
		margin: 0 !important;
	}
}

       .site-sidebar ul li ul {
    padding-top: 0px!important;
}

.site-sidebar ul li ul{
    padding-top:0px;
    padding-bottom:30px;
    display:block;
}

.site-sidebar ul li ul li{
    background-color:#eee;
    border:0px;

}
.site-sidebar ul li ul li a,
       #sub-nav3 a{
    background-size: 0 0;
        font-size:12px;
     padding: 8px 15px 8px 50px;
    line-height:15px;
}


.site-sidebar  > ul > li > a.dropdown:after{
          background : url(assets/images/sidebar-icons/ChevronRight-closed.svg) no-repeat!important;
       content: ''!important;
    background-size:15px 15px!important;
    background-color: transparent!important;
    display: inline-block!important;
    z-index: 99999999999!important;
       height: 15px;
    width: 15px;
    margin-right:10px;
    float:right;
    fill:#ff6633;
    opacity:.8;
}
    
    
    .site-sidebar  > ul > li > a.dropdown:hover::after{
          background : url(assets/images/sidebar-icons/ChevronRight-closed-hover.svg) no-repeat!important;
       content: ''!important;
    background-size:15px 15px!important;
    background-color: transparent!important;
    display: inline-block!important;
    z-index: 99999999999!important;
       height: 15px;
    width: 15px;
    margin-right:10px;
    float:right;
    fill:#ff6633;
    opacity:.8;
}
    
    

    .site-sidebar ul li a.arrow:after{
          background : url(assets/images/sidebar-icons/ChevronRight-opened-hover.svg) no-repeat!important;
       content: ''!important;
    background-size:15px 15px!important;
    background-color: transparent!important;
    display: inline-block!important;
    z-index: 99999999999!important;
       height: 15px;
    width: 15px;
    margin-right:10px;
    float:right;
    fill:#ff6633;
 }

    
        .site-sidebar ul li a.arrow:hover::after{
          background : url(assets/images/sidebar-icons/ChevronRight-opened-hover.svg) no-repeat!important;
       content: ''!important;
    background-size:15px 15px!important;
    background-color: transparent!important;
    display: inline-block!important;
    z-index: 99999999999!important;
       height: 15px;
    width: 15px;
    margin-right:10px;
    float:right;
    fill:#ff6633;
 }
    
    .site-sidebar ul li a.arrow{
        color: #8b26b2;
    }

    
 .site-sidebar ul li a.sidebar-menu-item-13-highlight{
  color:#ff6633;
     background-image:url('assets/images/sidebar-icons/hsd-database-navigation-trend-search-icon-hover.svg');
	background-position: 10% center;
	background-repeat: no-repeat;
 }
 .site-sidebar ul li a.sidebar-menu-item-2-highlight{
  color:#ff6633;
     background-image:url('assets/images/sidebar-icons/sidebar-menu-icon-2-hover.svg');
	background-position: 10% center;
	background-repeat: no-repeat;
 }
 .site-sidebar ul li a.sidebar-menu-item-browse-highlight{
  color:#ff6633;
     background-image:url('assets/images/sidebar-icons/sidebar-menu-icon-browse-hover.svg');
	background-position: 10% center;
	background-repeat: no-repeat;
 }

    li.sidebar-menu-item-document a {
  background-image: url('assets/images/sidebar-icons/hit-songs-deconstructed-reports-icon.svg');
    background-position: 10% center;
    background-repeat: no-repeat;
}

        li.sidebar-menu-item-document a:hover {
  background-image: url('assets/images/sidebar-icons/hit-songs-deconstructed-reports-icon-hover.svg');
    background-position: 10% center;
    background-repeat: no-repeat;
}

    .site-sidebar ul li a.sidebar-menu-item-document-highlight {
          color:#ff6633;
  background-image: url('assets/images/sidebar-icons/hit-songs-deconstructed-reports-icon-hover.svg');
    background-position: 10% center;
    background-repeat: no-repeat;
}


        li.sidebar-menu-item-compositional a {
  background-image: url('assets/images/sidebar-icons/sidebar-menu-icon-compositional.svg');
    background-position: 10% center;
    background-repeat: no-repeat;
}

        li.sidebar-menu-item-compositional a:hover {
  background-image: url('assets/images/sidebar-icons/sidebar-menu-icon-compositional-hover.svg');
    background-position: 10% center;
    background-repeat: no-repeat;
}

    .site-sidebar ul li a.sidebar-menu-item-compositional-highlight {
          color:#ff6633;
  background-image: url('assets/images/sidebar-icons/sidebar-menu-icon-compositional-hover.svg');
    background-position: 10% center;
    background-repeat: no-repeat;
}






    .menu-items {
    margin-right: 0% !important;
}
    .menu-items ul li a {
    font-weight: 500!important;
        padding: 8px 0 8px 15px;
            margin-left: 15px;
}
    @media (min-width: 768px){
.menu-items ul li a {
    padding: 8px 0 8px 23px;

}}
    
        .menu-items ul li:last-child ul#sub-nav2{
          margin-left:-55px;
    }
    

    .menu-items ul li:last-child ul#sub-nav2{
          margin-left:-55px;
    }
    

    .menu-items ul li ul#sub-nav2{
     /*   margin-top:10px;*/
  position:absolute!important;
         margin-left:5px;
          box-shadow: 1px 1px 6px #999;
       /* border:1px solid #999;*/
          background-color:#fff;
            z-index: 30000000000;
               padding: 0px 5px 0px!important;
    }

       .menu-items ul li ul#sub-nav2 li{
      position:relative!important;
   display: block!important;
    width: 130px!important;
    text-align: left!important;
    float: none!important;
     margin:0px 0!important;
     padding:18px 5px!important;
     border-bottom: 1px solid #ddd;

    }

           .menu-items ul li ul#sub-nav2 li a{
    /* margin:10px 15px!important;    */
     padding:0px  0px!important;
     margin-left: 0px!important;
               color:#4f4f4f;
              line-height: 18px;
    }

             .menu-items ul li ul#sub-nav2 li a:hover{
              color:#ff6633;
    }

            .menu-items ul li ul#sub-nav2 li:last-child {
               border-bottom: 0px solid #666;
    }

 .menu-items ul li.user a{
           color:#ff6633;
    }
   /*  .menu-items ul li.user a:after{
              background : url(assets/images/nav-icons/arrow.png) no-repeat!important;
       content: ''!important;
    background-size:7px 9px!important;
    background-color: transparent!important;
    display: inline-block!important;
    z-index: 99999999999!important;
       height: 9px;
    width: 7px;
         margin-top:5px;
    margin-left:4px;
    float:right;
    fill:#ff6633;
    opacity:.8;
     }*/

         .menu-items ul li.user ul li a:after{
    background-size:00 0!important;
     }







    @media (min-width: 1149px){
        .site-body{
            margin-top: 30px;
        }

.logo-container {
 height:122px!important;
}
    .site-sidebar ul {
    padding-top: 123px!important;
}

            .site-sidebar ul li ul {
    padding-top: 0px!important;
}


    }

     .menu-bar{
margin:0px!important;
     position:absolute!important;
     width:100%!important;
     height:100%!important;
 }

    @media (min-width:1150px){
 .menu-bar{
  margin-left:250px!important;
     position:absolute!important;
     width:40%!important;
     height:100%!important;
     max-width:728px;
 }
         .menu-bar img{
width:100%!important;
height:auto!important;
     vertical-align: middle;
     padding-top:25px;
 }
    }


    @media (max-width: 767px){
.menu-bar {
    position:absolute!important;
    display: inline!Important;
    width:100%!important;
        max-width: 100%!important;
    max-height: 100%!important;
}

    }

    .menu-items ul li a {
    margin-left: 10px!important;
}

    .menu-bar img{
 max-width: 100%!important;
    max-height: 100%!important;
    }

    .hidden{
     display:none!important;
    }


#sub-nav3{
 position:absolute!important;
    left:86%!important;
    width:275px!important;
    height:120px;
    background-color:#ffffff;
    margin-top:-90px;
    padding:20px 35px;
    text-align:center;
   box-shadow: 1px 1px 6px #999;
    z-index:20000000000;
}

    #sub-nav3 .arrow-left{
 position:absolute!important;
    left:-8px!important;
    width:16px!important;
    height:16px;
    background-color:#ffffff;
   top:50%;
        margin-top:-8px;
    z-index:20000000000;
           -ms-transform: rotate(50deg); /* IE 9 */
    -webkit-transform: rotate(50deg); /* Safari */
    transform: rotate(50deg);
}
    #sub-nav3 h2{
    font-size:14px;
        font-weight:600;
        line-height: 20px;
        margin:5px 0 10px 0;
}
#sub-nav3 a{
      margin:5 0px;
     padding: 0px;
     background-color: transparent;
    color:#ff6633;
        margin-left: 15px;
}
    #sub-nav3 a:after{
              background : url(assets/images/sidebar-icons/ChevronRight-open.svg) no-repeat!important;
       content: ''!important;
    background-size:35px 35px!important;
    background-color: transparent!important;
    display: inline-block!important;
    z-index: 99999999999!important;
       height: 5px!important;
    width: 5px!important;
        margin-top:5px;
    margin-right:31px!important;
    float:right!important;
    fill:#ff6633!important;
    background-color:transparent!important;
        border-right:1px solid #ff6633;
           border-top:1px solid #ff6633;
            -ms-transform: rotate(50deg); /* IE 9 */
    -webkit-transform: rotate(50deg); /* Safari */
    transform: rotate(50deg);
}

    .footer-disclaimer p:last-child {
    margin-bottom: 0px!Important;
        padding-bottom:10px;
}






@media (min-width: 767px){
.right-wrap {
    display: block;
    position: absolute;
    width: 100%;
    background-color: #ffffff;
}}

@media (min-width: 1150px){
.right-wrap {
    width: calc(100% - 270px);
    margin-left: 270px;
    display: block;
    position: absolute;
    height: 100%;
}}

.menu-container {
    display: flex!important;
    display: -webkit-flex!important;
    float: right;
    padding: 0px;
    width: 100%;
    height: 100%;
    position: relative;
    align-items: center;
    justify-content: center;
    -webkit-justify-content: center;
    -webkit-align-items: center;
}
@media (min-width: 770px){
.menu-container {
    display: flex!important;
    display: -webkit-flex!important;
  /*width: 395px;*/
    align-items: center;
    justify-content: flex-end;
    -webkit-justify-content: flex-end;
    -webkit-align-items: center;
}}
.ad-container {
    display: none;
}
@media (min-width: 770px){
.ad-container {
    display: none;
    /* display: -webkit-flex; */
    position: relative;
    /* display: -webkit-flex; */
    float: left;
    height: 100%;
    /* padding-left: 15px; */
    align-items: center;
    justify-content: center;
    -webkit-justify-content: center;
    -webkit-align-items: center;
    width: calc(100% - 395px)!important;
}}

@media (min-width: 1150px){
.ad-container img, .ad-container-responsive img {
    width: 100%;
    height: auto;
    position: absolute;
    margin: auto;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}}

.ad-container img, .ad-container-responsive img {
    width: 100%;
    height: auto;
    display: block;
    padding: 10px 0 10px 25px;
    max-width: 728px;
        max-height: 93px;
}

.menu-items ul li a {
		display: block;
		 padding: 8px 0 8px 0px;
}
    
    
    
    
    

<? if( $hasdemand ) { ?>
	@media  (max-width:478px){
		.site-body {
	    margin-top: 162px!important;
	}
	}
	<? }?>
</style>
    
    

    <script>
    $(document).ready(function(){
            $('.site-sidebar ul li a.dropdown').click(function(){
                var $target = $($(this).parent());
                var $theclass =  $target.attr('class');
                $target.children('.sub-nav').toggleClass( "hidden" )
                $(this).toggleClass($theclass +'-highlight');
                $(this).toggleClass('arrow');
            });
        });

         $(document).ready(function(){
            $('.menu-items ul li a.dropdown,.site-sidebar ul li, #sub-nav2').hover(function(){
                       var $target = $($(this).parent());
                var $theclass =  $target.attr('class');
                $target.children('#sub-nav2').removeClass( "hidden" )
            },
                                                   function(){
                       var $target = $($(this).parent());
                var $theclass =  $target.attr('class');
                $target.children('#sub-nav2').addClass( "hidden" )
            });
        });

        $(document).ready(function(){
           $('a.locked,#sub-nav3').hover(function(){
                       var $target = $($(this).parent());
                var $theclass =  $target.attr('class');
                $target.children('#sub-nav3').removeClass( "hidden" )
            },
                                                   function(){
                       var $target = $($(this).parent());
                var $theclass =  $target.attr('class');
                $target.children('#sub-nav3').addClass( "hidden" )
            });

          });
        
  
    </script>
    

<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TTS64J4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

	<input type='hidden' name='userid' value='<?=$userid?>' id="userid">
      <input type='hidden' name="proxyloginid" id='proxyloginid' value="<?=$_COOKIE['proxyloginid']?>">
	<header class="site-header fixed-top">
		<div class="logo-container">
			<a href="/index.php"><img src="../assets/images/ChartCipher_logo_horizontal_transparent.png" border="0" /></a>
			<div class="sidebar-toggle-box">
        		<div class="fa fa-bars"></div>
    		</div>
		</div><!-- /.logo-container -->


		<div class="right-wrap" style="display:none;">
			<div class="ad-container">
<? 		
$res = unserialize( db_query_first_cell( "select option_value from {$reportsdbname}.wp_options where option_name = 'sidebars_widgets'" ) );
$adname = str_replace( "text-", "", $res["topad_sidebar"][0] );
file_put_contents( "/tmp/res", $adname . "\n" );
$res = unserialize( db_query_first_cell( "select option_value from {$reportsdbname}.wp_options where option_name = 'widget_text'" ) );
$adval = $res[$adname]["text"];

if( 1 == 0 ) { 
if( $adval ) {
    echo( "$adval" );
}
else
{ 
?>
				<a href="https://www.chartcipher.com/writing-and-producing-with-a-hit-song-mentality/" >
										<img src="https://editorial.chartcipher.com/wp-content/uploads/2017/09/HSD_October2017_Workshop_Banner_Ad_728x90_9.25.gif"></a>
<? } 
}?>
					<div class="cf"></div>
			</div>

				<div class="menu-container">
			<!--<div class="menu-text">
				<h1>Welcome!</h1>
			</div>--><!-- /.menu-text -->
			<div class="menu-items">
				<ul>
				<!--	<li class="menu-item-1"><a href="help">Help</a></li> -->
				<!--	<li class="menu-item-0"><a href="/contact">Contact Us</a></li>-->
				<!--	<li class="menu-item-0"><a href="https://editorial.chartcipher.com" >Chart Cipher</a></li>-->
                  <!--  <li class="menu-item-0"><a href="help">FAQ</a></li>-->
                         <!--    <li class="menu-item-0"><a href="help">Tutorials</a></li> -->

												 												 <? if( $hasdemand ) { ?>
												 											 <!--																								<li>
 <a href="https://www.chartcipher.com/mastery-workshop-subs"  style="padding-left:40px;">My Workshops</a>
												 											 																							 </li>-->
												 											 	<? } ?>

                    <!--<li class="menu-item-0">
                     <? if( $_SESSION["loggedin"] && !$showhovers ) {

                     $hoverlink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                     if( strpos( $hoverlink, "?" ) !== false )
                         $hoverlink .= "&showhovers=1";
                     else
                         $hoverlink .= "?showhovers=1";
                     ?>
                     <a href="<?=$hoverlink?>"><font color='red'>Show Hover Names</font></a>
                                                      <? } ?>
                     <a href="" class="dropdown">Knowledge Base</a>
                    <ul id="sub-nav2" class="hidden">
                    					<li class="menu-item-0"><a href="https://<?=$devstr?>editorial.chartcipher.com/video_categories/subscription-plans/">Subscription Video Overview</a></li>
                    					<li class="menu-item-0"><a href="https://<?=$devstr?>editorial.chartcipher.com/video_categories/product-overview/"  >Video Overview</a></li>
                    					<li class="menu-item-0"><a href="https://<?=$devstr?>editorial.chartcipher.com/video_categories/feature-releases/"  >New feature Releases</a></li>
                    					 <li class="menu-item-0"><a href="https://editorial.chartcipher.com/knowledge-base/about-reports/"  >About the HSD Platform</a></li>
                    					  <li class="menu-item-0"><a href="https://editorial.chartcipher.com/knowledge-base/about-immersion/"  >About IMMERSION</a></li>
                    					   <li class="menu-item-0"><a href="https://editorial.chartcipher.com/knowledge-base/glossary/"  >Glossary</a></li>


                    </ul>
                    </li>-->
                    
                  
<? if( $_SESSION["loggedin"] && 1 == 0 ) { ?>
                    <li class="menu-item-0"><a href='#' onClick="javascript: shorturl2(); return false;"><font color='red'>Copy Link Test 2</font></a></li>
                    <li class="menu-item-0"><a href='#' onClick="javascript: maillink('Subject goes here'); return false;"><font color='red'>Mail Link</font></a></li>
<? } ?>
                    <li class="menu-item-0"><a href="https://editorial.chartcipher.com/video_categories/product-overview/">Tutorials</a></li>
                    
                    <li class="menu-item-0"><a href="https://editorial.chartcipher.com/knowledge-base/glossary/">Glossary</a></li>
                    
                    <li class="menu-item-0"><a href="https://www.chartcipher.com/events/">Upcoming Workshops</a></li>


                    

                <li class="menu-item-0"><a href="https://www.chartcipher.com/contact/">Contact</a></li>
                    <li class="menu-item-0 user">
                        <? if( !isAutomaticLogin( $_SERVER["REMOTE_ADDR"] ) ) { ?>             <!--<a href="" class="dropdown"><?=$user["email"]?></a>-->
<a href="" class="dropdown">My Account</a>                                                                                <? } ?>
                    <ul id="sub-nav2" class="hidden">
                        <? if( !isAutomaticLogin( $_SERVER["REMOTE_ADDR"] ) ) { ?>
                        	<li class="menu-item-0"><a href="https://editorial.chartcipher.com/members" class="dropdown">My Account </a>
                        	</li>
					<li class="menu-item-0"><a href="https://editorial.chartcipher.com/members/logout">Logout</a></li>
<? } else if( !$proxyloginid ) { ?>
</ul>
					<li class="menu-item-0" ><a href="#" data-featherlight="#mystudentcreate" class="tool" data-toggle="tooltip" data-placement="bottom" title="Create a profile to save favorite songs and searches.">Create Profile</a></li>
					<li class="menu-item-0" ><a href="#" data-featherlight="#mystudentlogin">Login</a></li>
<ul class="hidden">
<? } else { ?>
</ul>

					<li class="menu-item-0"><a href="/index.php?proxylogout=true">Logout</a></li>
<ul class="hidden">
<? } ?>
                    </ul>
                    </li>



				</ul>
			</div><!-- /.menu-text -->
               <!-- <div class="menu-bar">
             <a href="http://www.chartcipher.com/workshops/mastery-workshop-1/?utm_source=HSD-&utm_content=WKSHP-&utm_medium=WB&utm_campaign=HSD-WKSHP-WB&ocode=HSD-WKSHP-WB"><img src="../assets/images/banner.jpg" width="100%"/></a>
            </div>-->
			<div class="cf"></div>
		</div><!-- /.menu-container -->
		</div>


		<div class="cf"></div>
	</header><!-- .site-header -->
    <div class="content-wrap">
	<div class="site-sidebar">
		<ul>
	       <li class="sidebar-menu-item-home">
				<a href="/">Home <img class="hide info-icon menu-icon"  src="assets/images/hit-songs-deconstructed-more-information-sidebar-icon.svg"> </a>
           </li>
			<li class="sidebar-menu-item-articles">
				<a href="https://<?=$urlprefix?>editorial.chartcipher.com/articles" >Articles <img class="hide info-icon menu-icon"  src="assets/images/hit-songs-deconstructed-more-information-sidebar-icon.svg"> </a>
			</li>
            <li class="sidebar-menu-item-charts">
				<a  class="dropdown">Charts <img class="hide info-icon menu-icon" title="<?=getOrCreateCustomHover( "Navigation - Staying Power", "Search for how many weeks a song, performing artist, songwriter, record label, primary genre, or lead vocal gender spent in the Top 10 or at #1 during a specific time period.")?>" src="assets/images/hit-songs-deconstructed-more-information-sidebar-icon.svg" border="0"></a>
                  <ul class="sub-nav hidden">
<? $charts = db_query_array( "select id, chartname from charts where UseOnDB = 1 order by OrderBy, chartname", "id", "chartname" );
foreach( $charts as $id => $name ) { 
?>
                      <li><a href="/chart-landing.php?setchart=<?=$id?>"><?=$name?></a></li>
<? } ?>
                </ul>
			</li>
            
            <!-- <li class="sidebar-menu-item-song-trends">
				<a href="/#" >Song trends <img class="info-icon menu-icon"  title="<?=getOrCreateCustomHover( "Navigation - Trend Comparison", "Compare genres, influences, song structure characteristics, lyrical themes and more across performing artists, songwriters, record labels, top
				10 hits and #1 hits.")?>" src="assets/images/hit-songs-deconstructed-more-information-sidebar-icon.svg"> </a>
			</li>
            
             <li class="sidebar-menu-item-artist-trends">
				<a href="/#" >Artist Trends <img class="info-icon menu-icon"  title="<?=getOrCreateCustomHover( "Navigation - Technique Search", "Search for songwriting techniques (i.e.: hook techniques, techniques to hook the listener in and leave them wanting more, genre fusion techniques, duet structure techniques, etc.)." )?> " src="assets/images/hit-songs-deconstructed-more-information-sidebar-icon.svg"  src="assets/images/hit-songs-deconstructed-more-information-sidebar-icon.svg"> </a>
			</li> -->
			
            <? if( isEssentials() ) {  ?>
                    <li class="sidebar-menu-item-song-searches">
                        <a class="locked" href="#">My Dashboard</a>
                        <div id="sub-nav3" class="hidden">
                            <span class="arrow-left"></span>
                           <h2> This feature is available with a PRO subscription. </h2>
                            <a class="upgrade" href="https://editorial.chartcipher.com/members/signup">Click here to upgrade</a>
                            </div>
                    </li>
                    <li class="sidebar-menu-item-10" style="display: none;">
                        <a class="locked" href="#">Recent Searches</a>
                        <div id="sub-nav3" class="hidden">
                            <span class="arrow-left"></span>
                           <h2> This feature is available with a PRO subscription. </h2>
                            <a class="upgrade" href="https://editorial.chartcipher.com/members/signup">Click here to upgrade</a>
                            </div>
                    </li>
                    <li class="sidebar-menu-item-artist-searches" >
                        <a class="locked" href="#">Saved Techniques</a>
                        <div id="sub-nav3" class="hidden">
                            <span class="arrow-left"></span>
                           <h2> This feature is available with a PRO subscription. </h2>
                            <a class="upgrade" href="https://editorial.chartcipher.com/members/signup">Click here to upgrade</a>
                            </div>
                    </li>
                    <li class="sidebar-menu-item-11">
                        <a class="locked" href="#">Favorite Songs</a>
                        <div id="sub-nav3" class="hidden">
                            <span class="arrow-left"></span>
                           <h2> This feature is available with a PRO subscription. </h2>
                            <a class="upgrade" href="https://editorial.chartcipher.com/members/signup">Click here to upgrade</a>
                            </div>
                    </li>
            <? } else if( !isStudent() && !isEssentials() ) {  ?>
                    <li class="sidebar-menu-item-song-searches">
                        <a href="/saved-searches">My Dashboard<img class="hide info-icon menu-icon" title="<?=getOrCreateCustomHover( "Navigation - Saved Searches", "Access or edit your saved searches here.")?>" src="assets/images/hit-songs-deconstructed-more-information-sidebar-icon.svg" border="0"></a>
                    </li>
                    <!--<li class="sidebar-menu-item-artist-searches">
                        <a href="/saved-artists-labels"> Saved Artists Searches<img class="info-icon menu-icon" title="<?=getOrCreateCustomHover( "Navigation - Saved Artists & Labels", "Access or edit your saved artists and labels here.")?>" src="assets/images/hit-songs-deconstructed-more-information-sidebar-icon.svg" border="0"></a>
                    </li>-->
			 <? } ?>
            <li class="sidebar-menu-item-knowledge-base">
				<a  class="dropdown">Knowledge Base <img class="hide info-icon menu-icon" title="<?=getOrCreateCustomHover( "Navigation - Staying Power", "Search for how many weeks a song, performing artist, songwriter, record label, primary genre, or lead vocal gender spent in the Top 10 or at #1 during a specific time period.")?>" src="assets/images/hit-songs-deconstructed-more-information-sidebar-icon.svg" border="0"></a>
                  <ul class="sub-nav hidden">
                      <li><a href="https://editorial.chartcipher.com/knowledge-base/glossary/">Glossary</a></li>
                     <li><a href="https://editorial.chartcipher.com/video_categories/product-overview/">Tutorials</a></li>
                </ul>
			</li>
            <li class="menu-item-0 user">
                <? if( !isAutomaticLogin( $_SERVER["REMOTE_ADDR"] ) ) { ?>             
                  <a  class="dropdown">My Account <img class="hide info-icon menu-icon"  src="assets/images/hit-songs-deconstructed-more-information-sidebar-icon.svg"> </a>                                                                                <? } ?>
                    <ul class="sub-nav hidden">
                        <? if( !isAutomaticLogin( $_SERVER["REMOTE_ADDR"] ) ) { ?>
                        	<li class="menu-item-0"><a href="https://editorial.chartcipher.com/members" class="dropdown">My Account</a></li>
					<li class="menu-item-0"><a href="https://editorial.chartcipher.com/members/logout">Logout</a></li>
                      <? } else if( !$proxyloginid ) { ?>
                    </ul>
					<li class="menu-item-0" ><a href="#" data-featherlight="#mystudentcreate" class="tool" data-toggle="tooltip" data-placement="bottom" title="Create a profile to save favorite songs and searches.">Create Profile</a></li>
					<li class="menu-item-0" ><a href="#" data-featherlight="#mystudentlogin">Login</a></li>
                        <ul class="hidden">
                        <? } else { ?>
                        </ul>
            <li class="menu-item-0"><a href="/index.php?proxylogout=true">Logout</a></li>
        <ul class="hidden">
        <? } ?>
         </ul>
            

		</ul>
		<script type="text/javascript">

$(document).ready(function(){
    // $('[data-toggle="tooltip"]').tooltip();
});



		</script>
		<div class="footer-disclaimer">
			<p>&copy; <?php echo date('Y'); ?> ChartCipher, All Rights Reserved</p>
            
            <p class="hide">Phone:<br>
            212-871-2308</p>
            
            <p>Customer Service:<br>
            customerservice@chartcipher.com</p>
			<p class="hide"><a href="https://www.chartcipher.com/privacy-policy/" >Privacy Policy</a> | <a href="https://www.chartcipher.com/terms" >Terms of Use</a></p>
			<p><a href="http://i360m.com/">Designed by Imagine 360 Marketing</a></p>
		</div>
	</div><!-- /.site-sidebar -->
	<div class="site-content">
                          <? if( !$ishomepage ) {  ?><? } ?>
