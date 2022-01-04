<?php include 'header.php';?>
  <link rel="stylesheet" type="text/css" href="../assets/css/grid.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/new-style.css" />
<style>


</style>
	<div class="site-body dd-browse">



		<section class="">
			<div class="element-container row">
				<div class="header-container">
					<h1><?=getOrCreateCustomTitle( "Staying Power", "Staying Power" )?></h1><br>
					       <a href="/">Back to Home <img src="assets/images/home/hit-songs-deconstructed-back-to-home-arrow.svg"></a>
				</div><!-- /.header-container -->
                <div class="row row-equal row-padding">
                  <div class="col-6 flex">
                         <div class="header-block header-block-stay1">
                           <a href="/trend-search-staying-power ">
                               <p>Artist, Songwriters, Producers and Labels</p>
                           </a>
                       </div><!-- /.header-block-4b -->
                       <div class="info-block">
                           <a data-target="#openModal1">
                               <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Staying Power - Artist, Songs, Producers and Labels", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                               <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Staying Power - Artist, Songs, Producers and Labels", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                           </a>
                       </div><!-- /.header-block-4B -->
                  </div>

                   <div class="col-6 flex">
                         <div class="header-block header-block-stay2">
                            <a href="/compositional-trends-by-weeks-search">
                                <p>Compositional Characteristics</p>
                            </a>
                        </div><!-- /.header-block-1B -->
                        <div class="info-block">
                            <a data-target="#openModal2">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Staying Power - Compositional Characteristics", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Staying Power - Compositional Characteristics", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-1B -->
                   </div>

                    </div>

        

                       <?php
                include 'news-searches.php';
                ?>




                <!-- /MODAL BOXES -->
                 <div id="openModal1" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-artist-songwriters-producers-labels-icon.svg">
                        <h2>Artist, Songwriters, Producers and Labels</h2>
                        <p><?=getOrCreateCustomHover( "Staying Power Box - Artist, Songwriters, Producers and Labels", "Access a list of all performing artists in the database and their corresponding songs." )?></p>
                        <P><a href="/trend-search-staying-power"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                 <div id="openModal2" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-compositional-characteristics-icon.svg">
                        <h2>Compositional Characteristics</h2>
                        <p><?=getOrCreateCustomHover( "Staying Power Box - Compositional Characteristics", "Access a list of all performing artists in the database and their corresponding songs. " )?></p>
                        <P><a href="/compositional-trends-by-weeks-search"><button>GET STARTED</button></a></P>
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
