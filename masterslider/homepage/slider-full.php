<link rel="stylesheet" href="masterslider/masterslider/style/masterslider.css" />

	<!-- Master Slider Skin -->
		<link href="masterslider/masterslider/skins/light-2/style.css" rel='stylesheet' type='text/css'>
        
        <!-- MasterSlider Template Style -->
		<link href='masterslider/masterslider/style/ms-autoheight.css' rel='stylesheet' type='text/css'>

<!-- google font Lato -->
<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>

<!-- jQuery -->
<!--<script src="masterslider/masterslider/jquery.min.js"></script>
<script src="masterslider/masterslider/jquery.easing.min.js"></script>-->

<!-- Master Slider -->
<script src="masterslider/masterslider/masterslider.min.js"></script>

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
    padding: 25px 0px;
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
	</head>

	<body>

	<!-- template -->
<? 
include "trenddoingquartermiddle.php";    
$_GET["graphtype"] = "line";
$tmpreportsarr["Key"] = "Key";
$tmpreportsarr["Major-Vs-Minor"] = "Major vs. Minor";
$tmpreportsarr["Average-Tempo"] = "Average Tempo";
$tmpreportsarr["Tempo-Range"] = "Tempo Range";

?>
<div class="ms-autoheight-template">
					<!-- masterslider -->
					<div class="master-slider ms-skin-light-2" id="masterslider">
<? 
    foreach( $tmpreportsarr as $sectionid=>$sectionname ) { 
?>
  <div class="ms-slide">
                 <div class="home-search-header new">
                               <h1><?=$sectionid?></h1>
                            </div>
             <? //include "trendreportincludes/{$sectionid}.php"; ?>
					    </div>
	<? } ?>
    </div>
    <!-- end of masterslider -->
    <div class="ms-staff-info" id="staff-info"> </div>
</div>
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
