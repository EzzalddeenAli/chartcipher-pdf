<link rel="stylesheet" href="masterslider/masterslider/style/masterslider.css" />

	<!-- Master Slider Skin -->
		<link href="masterslider/masterslider/skins/default/style.css" rel='stylesheet' type='text/css'>
        
        <!-- MasterSlider Template Style -->
		<link href='masterslider/masterslider/style/home-style.css' rel='stylesheet' type='text/css'>

<!-- google font Lato -->
<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>

<!-- jQuery -->
<!--<script src="masterslider/masterslider/jquery.min.js"></script>
<script src="masterslider/masterslider/jquery.easing.min.js"></script>-->

<!-- Master Slider -->
<script src="masterslider/masterslider/masterslider.min.js"></script>  
	</head>

	<body>

	<!-- template -->
<? 
include "trendfunctions.php";    
include "trendreportfunctions.php";    
include "trenddoingquartermiddle.php";    
$_GET["graphtype"] = "line";
$tmpreportsarr["Key"] = "Key";
$tmpreportsarr["Major-Vs-Minor"] = "Major vs. Minor";
$tmpreportsarr["Average-Tempo"] = "Average Tempo";
$tmpreportsarr["Tempo-Range"] = "Tempo Range";

?>

					<!-- masterslider -->
					<div class="master-slider ms-skin-default" id="masterslider">
<? 
    foreach( $tmpreportsarr as $sectionid=>$sectionname ) { 
?>
   <div class="ms-slide <?=$sectionid?>" data-delay="14">
                 <div class="home-search-header new">
                               <h1><?=$sectionid?></h1>
                            </div>
            <? include "trendreportincludes/{$sectionid}.php"; ?>
      
					    </div>
	<? } ?>
    </div>
    <!-- end of masterslider -->
    <div class="ms-staff-info" id="staff-info"> </div>

<!-- end of template -->
<script type="text/javascript">		

		var slider = new MasterSlider();

		slider.control('arrows');	
		//slider.control('bullets' , {autohide:false, align:'bottom', margin:10});	
		slider.control('scrollbar' , {dir:'h',color:'#333'});

		slider.setup('masterslider' , {
		autoHeight:true,
             loop:true,
			width:1400,
			
			space:1,
			view:'basic',
            fullwidth:true
            
		});

	</script>
