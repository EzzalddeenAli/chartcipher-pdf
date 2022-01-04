<?php require_once 'header.php';?>
  <link rel="stylesheet" type="text/css" href="../assets/css/grid.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/new-style.css" />
<style>


</style>
	<div class="site-body index-essentials">
        <section class="home-top">
			<div class="element-container row">
				<div class="header-container">
					<h1>Recent Chart Cipher Reports</h1><br>
                          <!-- <a href="https://editorial.chartcipher.com/"><img src="assets/images/home/hit-songs-deconstructed-browse-reports-icon.svg">  Browse All Song Reports</a>-->
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
                   <div class="col-4 flex"> 
                     <div class="header-block header-block-1b">
                        <a href="https://editorial.chartcipher.com/">
                            <p>Read a Hit Song Deconstructed Report (Essentials)</p>
                        </a>
                     </div><!-- /.header-block-1B -->
                        <div class="info-block">
                            <a data-target="#openModal1"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Essentials HP - Read a Hit Song Deconstructed Report (Essentials)", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>                          
                        </div><!-- /.header-block-1B -->
                   </div>
                    
                  <div class="col-4 flex"> 
                          <div class="header-block header-block-9b">
                            <a href="/genre-search">
                                <p>Read The Quarterly Primary Genre Report</p>
                            </a>
                        </div><!-- /.header-block-2b -->
                        <div class="info-block">
                            <a data-target="#openModal2"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Essentials HP - Read The Quarterly Genre Report", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-2B -->
                   </div>
                    
                   <div class="col-4 flex"> 
                          <div class="header-block header-block-8b">
                            <a href="/browse-database">
                                <p>Browse the Database</p>
                            </a>
                        </div><!-- /.header-block-3b -->
                        <div class="info-block">
                            <a data-target="#openModal3"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Essentials HP - Browse the Database", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-3B -->
                   </div>
                   </div>
                
                 <div class="row row-equal row-padding">
                    
                   <div class="col-4 flex"> 
                         <div class="header-block header-block-10b">
                            <a href="/form-search">
                                <p>Form Search</p>
                            </a>
                        </div><!-- /.header-block-5B -->
                        <div class="info-block">
                            <a data-target="#openModal4"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Essentials HP - Form Search", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>                          
                        </div><!-- /.header-block-5B -->
                   </div>
                    
                  <div class="col-4 flex"> 
                          <div class="header-block header-block-6b">
                            <a href="/search-for-songs">
                                <p>Search for Songs</p>
                            </a>
                        </div><!-- /.header-block-6b -->
                        <div class="info-block">
                            <a data-target="#openModal5"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Essentials HP - Search for Songs by Song Title, Songwriter, Performing Artist or Label", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-6B -->
                   </div>
                    
                   <div class="col-4 flex"> 
                          <div class="header-block header-block-7b">
                            <a href="/advanced-search">
                                <p>Power Search</p>
                            </a>
                        </div><!-- /.header-block-7b -->
                        <div class="info-block">
                            <a data-target="#openModal6"> 
                                <img class="more-info-icon page-icon" title="Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Essentials HP - Power Search", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>    
                        </div><!-- /.header-block-7B -->
                   </div>
                    
                  
                    </div>
                
                
                
<? include "news-searches.php"; ?>
                
             
                <!-- /MODAL BOXES -->
                 <div id="openModal1" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-read-a-report-icon.svg">
                        <h2>Read a Hit Song Deconstructed Report (Essentials)</h2>
                        <p><?=getOrCreateCustomHover( "Essentials Box - Read a Hit Song Deconstructed Report (Essentials)", "From here you can access all Hit Song Deconstructed Essentials reports." )?></p>
                        <P><a href="https://editorial.chartcipher.com/"><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                 <div id="openModal2" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-read-the-quarterly-genre-report-icon.svg">
                        <h2>Read The Quarterly Genre Report</h2>
                        <p><?=getOrCreateCustomHover( "Essentials Box - Read The Quarterly Genre Report", "Presented as a fully interactive table , this report provides an at-a-glance comparison of the most popular compositional characteristics for each primary genre in the Top 10 of the Hot 100 for a specified quarter, across 25+ categories." )?></p>

                        <P><a href="/genre-search"><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                 <div id="openModal3" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-browse-icon.svg">
                        <h2>Browse the Database</h2>
                        <p><?=getOrCreateCustomHover( "Essentials Box - Browse the Database", "Not sure what you are looking for? Here you can browse through all the songs housed in the database.
 " )?></p>

                        <P><a href="/browse-database"><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                 <div id="openModal4" class="modalDialog">
                    <div class="">
                        <a title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-form-search-icon.svg">
                        <h2>Form Search</h2>
                        <p><?=getOrCreateCustomHover( "Essentials Box - Form Search", "Search for songs using a specific form or with a specific first and/or last section. " )?></p>

                        <P><a href="/form-search"><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                  <div id="openModal5" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-search-for-songs-icon.svg">
                        <h2>Search for Songs</h2>
                        <p><?=getOrCreateCustomHover( "Essentials Box - Search for Songs by Song Title, Songwriter, Performing Artist or Label", "Search for songs by song title, songwriter, performing artist or label to view their compositional characteristics and filter by peak chart position, genre and more." )?></p>
                        <P><a href="/search-for-songs"><button>GET STARTED</button></a></P>
                    </div>
                </div>
                
                 <div id="openModal6" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-power-search-icon.svg">
                        <h2>Power Search</h2>
                        <p><?=getOrCreateCustomHover( "Essentials Box - Power Search", "Search for songs with very specific compositional characteristics, including lyrics, titles, vocals, influences, instruments, song structure characteristics and more.  There are over 200 searchable criteria to choose from." )?></p>

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