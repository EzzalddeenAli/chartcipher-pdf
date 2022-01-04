<?php 

include 'header.php'; 
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
<? 
$allcharts = db_query_array( "select id, chartkey from charts", "chartkey", "id" );
?>
	<div class="site-body index-pro ">
        <section class="home-top">
			<div class="element-container row">
				
                       <div class="row inner row-equal row-padding link-alt">
                           <div class="col-6 flex">
                               <div class="home-search-header variant2">
                                        <h1>Charts</h1>
                                        <div class="cf"></div>
                                </div>
                                 <div class="inner-content home-page-charts">
                                    <div class="display-list">
                                  <div class="header-inner " >
                                             <table class="table table-charts">
                                                <tr>
                                                    <td><a href="chart-landing.php?setchart=<?=$allcharts["hot-100"]?>" class="norowlink"><span>Billboard Hot 100</span></a></td>
                                                     <td class=""> </td>
                                                </tr>
                                                <tr>
                                                    <td><a href="chart-landing.php?setchart=<?=$allcharts["pop-songs"]?>" class="norowlink"><span>Pop Airplay</span></a></td>
                                                     <td class="nolock"> </td>
                                               </tr>
                                                 <tr>
                                                    <td><a href="chart-landing.php?setchart=<?=$allcharts["country-songs"]?>" class="norowlink"><span>Hot Country Songs</span></a></td>
                                                     <td class="nolock"> </td>
                                               </tr>
                                                 <tr>
                                                    <td><a href="chart-landing.php?setchart=<?=$allcharts["r-b-hip-hop-songs"]?>" class="norowlink"><span>Hot R&B/Hip Hop Songs</span></a></td>
                                                    <td class="nolock"> </td>
                                                 </tr>
                                                     <tr>
                                                    <td><a href="chart-landing.php?setchart=<?=$allcharts["dance-electronic-songs"]?>" class="norowlink"><span>Hot Dance/Electric Songs</span></a></td>
                                                     <td class="nolock"> </td>
                                               </tr>
                                                 <tr>
                                                    <td><a href="chart-landing.php?setchart=<?=$allcharts["rock-songs"]?>" class="norowlink"><span>Hot Rock Alternative Songs</span></a></td>
                                                     <td class="nolock"> </td>
                                                     
                                               </tr>
                                               <tr>
                                                    <td><a href="chart-landing.php?setchart=<?=$allcharts["christian-songs"]?>" class="norowlink"><span>Hot Christian Songs</span></a></td>
                                                    <td class="nolock"> </td>
                                               </tr>
                                                 <tr>
                                                    <td><a href="chart-landing.php?setchart=<?=$allcharts["latin-songs"]?>" class="norowlink"><span>Hot Latin Songs</span></a></td>
                                                     <td class="nolock"> </td>
                                               </tr>
                                </table>
                                </div><!-- /.header-block-1B -->

                                     </div>
                                </div><!-- /.header-block-1B -->

                           </div>
                           
                           
                       <div class="col-6 flex">
                 
                       <div class="home-search-header variant2">
                                <h1>Recent Articles and Reports</h1>
                                <div class="cf"></div>
                            </div>
            <div class="inner-content">
                            <div class="display-list">
<? 
    $limit = 6;
$res = db_query_rows( "select post_name, post_title, ID from {$reportsdbname}.wp_posts where  post_status = 'publish' and post_type = 'articles' order by post_date desc limit $limit" );
$i = 0; 
foreach( $res as $r ) { 
$img = db_query_first_cell( "SELECT guid      FROM {$reportsdbname}.wp_postmeta AS pm      INNER JOIN {$reportsdbname}.wp_posts AS p ON pm.meta_value=p.ID       WHERE pm.post_id = '$r[ID]'        AND pm.meta_key = '_thumbnail_id'       ORDER BY p.post_date DESC" );
$i++; 
$img = str_replace( "https://editorial.chartcipher.com/wp-content/uploads/", "../wpuploads/", $img );
if( $i == 4 ) echo( "           <div class=\"more-items\">" );
?> 

                                <div class="item-wrap">
                                    <div class="item-image">
                                        <a href='https://editorial.chartcipher.com/articles/<?=$r[post_name]?>'><img src="<?=phpThumbURL("src={$img}&w=177", '/thumb/phpThumb.php')?>"/></a>

                                    </div>
                                    <div id="word-count" class="item-text">
                                        <!--<h4><?=$r["post_title"]?></h4>-->
                                        <a  href='https://editorial.chartcipher.com/articles/<?=$r[post_name]?>'>
                                     <?=$r["post_title"]?>
                                        </a>
                                    </div>
                                </div>
							   <? }?>
							       <? if( $i >= 4 ) { ?>                             </div><? } ?>
                             </div>
                        </div><!-- /.header-block-1B -->
                        <div class="info-block2">
                             <a class="view-item-left eye-icon" href="https://editorial.chartcipher.com/articles/"></a>
                            
                             <a class="view-item-right eye-icon" href="https://editorial.chartcipher.com/articles/">View All >></a>
                        </div><!-- /.header-block-1B -->
                   </div>
                
                  
                </div>
        
       
               <div class="row  row-equal row-padding mobile link-alt">
                            <div class="col-6">
                       <div class="home-search-header ">
                                <h3>Saved Searches</h3>
                                 <a style="display:none;" class="search" href="/saved-searches"><img src="assets/images/home/search-view-icon.svg" /></a>
                            </div>
                         <div class="header-inner" >
                         <table class="table table-section">
<? $searches = getSavedSearches(); 
$i = 0;
foreach( $searches as $s ) { 
	 $url = $s[url] . "&savedid={$s[id]}";
$i++; 
if( $i > 5 ) continue;
?>
                            <tr>
                                <td><a href="<?=$url?>" class="rowlink"><?=$s[Name]?></a></td>
                                <td><?=prettyFormatDate( $s[dateadded] ) ?></td>
                                      <td> </td>
                            </tr>
<? } ?>

                        </table>
                        </div><!-- /.header-block-1B -->
                      </div>
                             <div class="col-6" >
                   <div class="home-search-header ">
                                <h3>Recent Searches</h3>
                                 <a style="display:none;" class="search" href="/saved-searches"><img src="assets/images/home/search-view-icon.svg" /></a>
                            </div>
                         <div class="header-inner " >
                         <table class="table table-section ">
<? $searches = getRecentSearches( 40 ); 
$already = array();
foreach( $searches as $s ) { 
	 if( isset( $already[$s[url]] ) ) continue;
$already[$s[url]] = 1;
if( count( $already ) > 3 ) continue;
$name = $s[Name]?$s[Name]:"Advanced Search";
$name = str_replace( "Trend Search: ", "", $name );

?>
                                                    <tr data-href="<?=$s[url]?>">
<td>
<a class='rowlink' href='<?=$url?>'><?=$name?></a>            </td>
                                    <td></td>
                                    <td></td>
                                                    </tr>
<? } ?>
                        </table>
                        </div><!-- /.header-block-1B -->
                      </div>
                      </div>
        
        
        
            </div><!-- /.row -->
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
