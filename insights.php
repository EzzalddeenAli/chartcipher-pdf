<?php 
include 'header.php'; 
$backurl = "chart-landing.php";
include "trendfunctions.php";
include "benchmarkreportfunctions.php";
include "trendreportfunctions.php";
if( !$_GET["graphtype"] ) $_GET["graphtype"] = "column";



?>
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
        <section class="home-top">
			<div class="element-container row">
				
                

                
<? include "insightsreports.php"; ?>

                      </div>
                </div>
		</section><!-- /.home-top -->
	</div><!-- /.site-body -->

<?php include 'footer.php';?>
