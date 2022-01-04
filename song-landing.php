<?php 
include 'header.php'; 
$backurl = "chart-landing.php";
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
        <section class="home-top">
			<div class="element-container row">
				
       
               
                  <div class="row inner row-equal row-padding link-alt chart-landing">
                         <div class="col-12 flex">
                             <div class="header-inner" >
                             
                                    <div class="row row-equal row-padding">
                                       <div class="col-6 flex">
                                             <div class="header-block header-block-compositional-trends">
                                               <a  href="/compositional-search.php" >
                                                   <h1>Compositional Trends</h1>
                                                    <p>(Sub-genres & influences, instruments, key, etc.)</p>
                                                </a>
                                            </div><!-- /.header-block-1B -->

                                       </div>

                                       <div class="col-6 flex">
                                              <div class="header-block header-block-lyrical-trends">
                                                  <a  href="/lyrical-search.php" >
                                                   <h1>Lyrical Trends</h1>
                                                    <p>(Lyrical theme, rhymes etc.)</p>
                                                </a>
                                            </div><!-- /.header-block-4b -->
                                       </div>
                                    </div>
                                 
                                 
                                    <div class="row row-equal row-padding">
                                       <div class="col-6 flex">
                                             <div class="header-block header-block-production-trends">
                                               <a  href="/production-search.php" >
                                                   <h1>Production Trends</h1>
                                                    <p>(Tempo, timbre, instruments, etc.)</p>
                                                </a>
                                            </div><!-- /.header-block-1B -->

                                       </div>

                                       <div class="col-6 flex">
                                              <div class="header-block header-block-structure-trends">
                                                <a href="/structure-search.php">
                                                   <h1>Structure Trends</h1>
                                                    <p>(Song form, song length, etc.)</p>
                                                </a>
                                            </div><!-- /.header-block-4b -->
                                       </div>
                                    </div>

                             </div>
                           </div>
                   </div>
                       
<? include "saved-searches-inner.php"; ?>

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
