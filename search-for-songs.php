<?php include 'header.php';?>
  <link rel="stylesheet" type="text/css" href="../assets/css/grid.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/new-style.css" />
<style>

   
</style>
	<div class="site-body dd-songs">
      
        
        
		<section class="">
			<div class="element-container row">
				<div class="header-container">
					<h1><?=getOrCreateCustomTitle( "Search for Songs", "Search for Songs" )?></h1><br>
					       <a href="/">Back to Home <img src="assets/images/home/hit-songs-deconstructed-back-to-home-arrow.svg"></a>
				</div><!-- /.header-container -->
                <div class="row row-equal row-padding">
                    
                   <div class="col-4 flex"> 
                         <div class="header-block header-block-songs1">
                            <a href="/song-title-search">
                                <p>By Song Title</p>
                            </a>
                        </div><!-- /.header-block-1B -->
                        <div class="info-block">
                            <a data-target="#openModal1"> 
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Search Songs - By Song Title", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Search Songs - By Song Title", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>                          
                        </div><!-- /.header-block-1B -->
                   </div>
                    
                  <div class="col-4 flex"> 
                          <div class="header-block header-block-songs6">
                            <a href="/date-range-search ">
                                <p>By Date Range</p>
                            </a>
                        </div><!-- /.header-block-2b -->
                        <div class="info-block">
                            <a data-target="#openModal6"> 
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Search Songs - By Date Range", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Search Songs - By Date Range", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-2B -->
                   </div>
                    
                    <div class="col-4 flex"> 
                         <div class="header-block header-block-songs3">
                            <a href="/artist-search">
                                <p>By Performing Artist</p>
                            </a>
                        </div><!-- /.header-block-1B -->
                        <div class="info-block">
                            <a data-target="#openModal3"> 
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Search Songs - By Performing Artist", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Search Songs - By Performing Artist", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>                          
                        </div><!-- /.header-block-1B -->
                   </div>
                    
               </div>
                
                
                <div class="row row-equal row-padding">
                    
                   <div class="col-4 flex"> 
                          <div class="header-block header-block-songs2">
                            <a href="/songwriter-search">
                                <p>By Songwriter</p>
                            </a>
                        </div><!-- /.header-block-2b -->
                        <div class="info-block">
                            <a data-target="#openModal2"> 
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Search Songs - By Songwriter", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Search Songs - By Songwriter", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-2B -->
                   </div>
                    
                  <div class="col-4 flex"> 
                          <div class="header-block header-block-songs5">
                            <a href="/producer-search">
                                <p>By Producer</p>
                            </a>
                        </div><!-- /.header-block-2b -->
                        <div class="info-block">
                            <a data-target="#openModal5"> 
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Search Songs - By Producer", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Search Songs - By Producer", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-2B -->
                   </div>
                    
                    <div class="col-4 flex"> 
                          <div class="header-block header-block-songs4">
                            <a href="/label-search">
                                <p>By Record Label</p>
                            </a>
                        </div><!-- /.header-block-2b -->
                        <div class="info-block">
                            <a data-target="#openModal4"> 
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Search Songs - By Record Label", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Search Songs - By Record Label", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-2B -->
                   </div>
                </div>
                
                
                
                
                <div class="row row-equal row-padding">
                    
                   <div class="col-4 flex"> 
                          <div class="header-block header-block-songs7">
                            <a href="/form-search ">
                                <p>By Form</p>
                            </a>
                        </div><!-- /.header-block-2b -->
                        <div class="info-block">
                            <a data-target="#openModal7"> 
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Search Songs - By Form", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Search Songs - By Form", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-2B -->
                   </div>
                    
                  <div class="col-4 flex"> 
                          <div class="header-block header-block-songs8">
                            <a href="/song-search">
                                <p>By Combo Search</p>
                            </a>
                        </div><!-- /.header-block-2b -->
                        <div class="info-block">
                            <a data-target="#openModal8"> 
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Search Songs - By Combo Search", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Search Songs - By Combo Search", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-2B -->
                   </div>
                    
                    <div class="col-4 flex"> 
                          <div class="header-block header-block-songs9">
                            <a href="/advanced-search">
                                <p>Power Search</p>
                            </a>
                        </div><!-- /.header-block-2b -->
                        <div class="info-block">
                            <a data-target="#openModal9"> 
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Search Songs - By Power Search", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Search Songs - By Power Search", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-2B -->
                   </div>
                </div>
                
            
                       <?php
                include 'news-searches.php';
                ?>
                
                
                
             
                <!-- /MODAL BOXES -->
                 <div id="openModal1" class="modalDialog">
                    <div class="">
                        <a title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-search-by-song-title-icon.svg">
                        <h2>By Song Title</h2>
                        <p><?=getOrCreateCustomHover( "Search Songs Box - By Song Title", "Search for a specific song." )?></p>
                        <P><a href="/song-title-search"><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                 <div id="openModal2" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-search-by-songwriters-icon.svg">
                        <h2>By Songwriter</h2>
                        <p><?=getOrCreateCustomHover( "Search Songs Box - By Songwriter", "Search for songs by a specific songwriter." )?></p>

                        <P><a href="/songwriter-search"><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                 <div id="openModal3" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-search-by-performing-artists-icon.svg">
                        <h2>By Performing Artist</h2>
                        <p><?=getOrCreateCustomHover( "Search Songs Box - By Performing Artist", "Search for songs performed by a specific artist." )?></p>

                        <P><a href="/artist-search"><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                 <div id="openModal4" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-search-by-record-labels-icon.svg">
                        <h2>By Record Label</h2>
                        <p><?=getOrCreateCustomHover( "Search Songs Box - By Record Label", "Search for songs released by a specific record label." )?></p>

                        <P><a href="/label-search"><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                <div id="openModal5" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-browse-by-producers-icon.svg">
                        <h2>By Producer Search</h2>
                        <p><?=getOrCreateCustomHover( "Search Songs Box - By Producer Search", "Search for songs produced by a specific producer")?></p>

                        <P><a href="/producer-search"><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                <div id="openModal6" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-date-range-icon.svg">
                        <h2>By Date Range</h2>
                        <p><?=getOrCreateCustomHover( "Search Songs Box - By Date Range", "Search for songs present in the Hot 100 Top 10 during a specific date range.")?></p>

                        <P><a href="/date-range-search "><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                
                <div id="openModal7" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-form-icon.svg">
                        <h2>By Form</h2>
                        <p><?=getOrCreateCustomHover( "Search Songs Box - By Form", "Search for songs with a specific form, first section or last section.")?></p>

                        <P><a href="/form-search "><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                <div id="openModal8" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-combo-search-icon.svg">
                        <h2>By Combo Search</h2>
                        <p><?=getOrCreateCustomHover( "Search Songs Box - By Combo Search", "Search for songs based on a combination of criteria.")?></p>

                        <P><a href="/song-search"><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                <div id="openModal9" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-power-search-icon.svg">
                        <h2>By Power Search</h2>
                        <p><?=getOrCreateCustomHover( "Search Songs Box - By Power Search", "Search for songs with very specific compositional characteristics.")?></p>

                        <P><a href="/advanced-search"><button>GET STARTED</button></a></P>
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