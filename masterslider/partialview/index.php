<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<title>Master Slider Partial View Template</title>	
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<!-- Base MasterSlider style sheet -->
		<link rel="stylesheet" href="masterslider/masterslider/style/masterslider.css" />
		
		<!-- Master Slider Skin -->
		<link href="masterslider/masterslider/skins/default/style.css" rel='stylesheet' type='text/css'>
		 
		<!-- MasterSlider Template Style -->
		<link href='masterslider/masterslider/style/ms-partialview.css' rel='stylesheet' type='text/css'>
		
		<!-- google font Lato -->
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
		
		<!-- jQuery -->
		<script src="masterslider/masterslider/jquery.min.js"></script>
		<script src="masterslider/masterslider/jquery.easing.min.js"></script>
		
		<!-- Master Slider -->
		<script src="masterslider/masterslider/masterslider.min.js"></script>

	</head>
		
	<body>
	
	<!-- template -->
	<div class="ms-partialview-template" id="partial-view-1">
				<!-- masterslider -->
				<div class="master-slider ms-skin-default" id="masterslider">
				    <div class="ms-slide">
				        <img src="../masterslider/style/blank.gif" data-src="img/1.jpg" alt="lorem ipsum dolor sit"/>  
				        <div class="ms-info">
				        	<h3>CHILDHOOD MEMORIES</h3>
				        	<h4>JOHN WILIAM</h4>
				        	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.</p>
			        	</div>   
				    </div>
				    <div class="ms-slide">
				        <img src="../masterslider/style/blank.gif" data-src="img/2.jpg" alt="lorem ipsum dolor sit"/>     
				          <div class="ms-info">
				        	<h3>CONSECTETUR ADIPISCING ELIT</h3>
				        	<h4>JOHN WILIAM</h4>
				        	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.</p>
			        	</div> 
				    </div>
				    <div class="ms-slide">
				        <img src="../masterslider/style/blank.gif" data-src="img/3.jpg" alt="lorem ipsum dolor sit"/>    
				         <div class="ms-info">
				        	<h3>SUSPENDISSE UT PULVINAR MAURIS</h3>
				        	<h4>JOHN WILIAM</h4>
				        	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.</p>
			        	</div> 
				    </div>
				    <div class="ms-slide">
				        <img src="../masterslider/style/blank.gif" data-src="img/4.jpg" alt="lorem ipsum dolor sit"/>    
				          <div class="ms-info">
				        	<h3>SED DAPIBUS SIT AMET FELIS</h3>
				        	<h4>JOHN WILIAM</h4>
				        	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.</p>
			        	</div>   
				    </div>
				    <div class="ms-slide">
				        <img src="../masterslider/style/blank.gif" data-src="img/cover.jpg" alt="lorem ipsum dolor sit"/>     
						
						<h5 class="ms-layer video-title video-top-title" style="left:133px; top:29px "
				        	data-effect="left(150)"
				        	data-duration="3500"
				        	data-ease="easeOutExpo"
				        	data-delay="50"
				        >DIRECTOR’S CUT</h5>
						
						<h4 class="ms-layer video-title" style="left:130px; top:44px "
				        	data-effect="front(500)"
				        	data-duration="5000"
				        	data-ease="easeOutExpo"
				        	data-delay="400"
				        >CHEETAHS ON THE EDGE</h4>
				        
				        <h5 class="ms-layer video-title video-sub-title" style="left:130px; top:90px "
				        	data-effect="right(50)"
				        	data-duration="3500"
				        	data-ease="easeOutExpo"
				        	data-delay="1000"
				        >Groundbreaking footage of the world’s fastest runner</h5>
				        
				        <a href="http://player.vimeo.com/video/53914149" data-type="video"> vimeo video </a>   
						<div class="ms-info">
				        	<h3>CHEETAHS ON THE EDGE</h3>
				        	<h4>GREGORY WILSON</h4>
				        	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.</p>
			        	</div>   
				    </div>
				    <div class="ms-slide">
				        <img src="../masterslider/style/blank.gif" data-src="img/5.jpg" alt="lorem ipsum dolor sit"/>  
				            <div class="ms-info">
				        	<h3>CONSECTETUR ADIPISCING ELIT</h3>
				        	<h4>JOHN WILIAM</h4>
				        	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.</p>
			        	</div>  
				    </div>
				    <div class="ms-slide">
				        <img src="../masterslider/style/blank.gif" data-src="img/6.jpg" alt="lorem ipsum dolor sit"/>    
				           <div class="ms-info">
				        	<h3>SED A SEM AT LIBERO SODALES</h3>
				        	<h4>JOHN WILIAM</h4>
				        	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.</p>
			        	</div>  
				    </div>
				    <div class="ms-slide">
				        <img src="../masterslider/style/blank.gif" data-src="img/7.jpg" alt="lorem ipsum dolor sit"/>  
				            <div class="ms-info">
				        	<h3>VITAE ULTRICIES ALIQUET</h3>
				        	<h4>JOHN WILIAM</h4>
				        	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.</p>
			        	</div>  
				    </div>
				</div>
				<!-- end of masterslider -->
	</div>
	<!-- end of template -->

	</body>
	
	<script type="text/javascript">		
	
		var slider = new MasterSlider();

		slider.control('arrows');	
		slider.control('slideinfo',{insertTo:"#partial-view-1" , autohide:false, align:'bottom', size:160});
		slider.control('circletimer' , {color:"#FFFFFF" , stroke:9});

		slider.setup('masterslider' , {
			width:760,
			height:400,
			space:10,
			loop:true,
			view:'partialWave',
			layout:'partialview'
		});

	</script>
</html>
