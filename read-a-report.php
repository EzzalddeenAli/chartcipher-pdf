<?php
include 'header.php';?>
  <link rel="stylesheet" type="text/css" href="../assets/css/grid.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/new-style.css" />
<style>


</style>
	<div class="site-body dd-read-report">



		<section class="">
			<div class="element-container row">
				<div class="header-container">
					<h1>Read a Report</h1><br>
					       <a href="/">Back to Home <img src="assets/images/home/hit-songs-deconstructed-back-to-home-arrow.svg"></a>
				</div><!-- /.header-container -->
                <div class="row row-equal row-padding">

                   <div class="col-6 flex">
                         <div class="header-block header-block-read1">
                           <a  href="https://editorial.chartcipher.com/" >
                                <p>A Hit Song Deconstructed Report</p>
                            </a>
                        </div><!-- /.header-block-1B -->
                        <div class="info-block">
                            <a data-target="#openModal1">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Read Report - A Hit Song Deconstructed Report", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Read Report - A Hit Song Deconstructed Report", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-1B -->
                   </div>

                   <div class="col-6 flex">
                          <div class="header-block header-block-read5">
                            <a href="https://editorial.chartcipher.com/treports/">
                                <p>Quarterly Trend Report</p>
                            </a>
                        </div><!-- /.header-block-4b -->
                        <div class="info-block">
                            <a data-target="#openModal5">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Read Report - The Quarterly Trend Report", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Read Report - The Quarterly Trend Report", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-4B -->
                   </div>


                    </div>
                    <div class="row row-equal row-padding">


                                        <div class="col-6 flex">
                                                <div class="header-block header-block-read2">
                                                  <a href="/trend-report-search">
                                                      <p>The Interactive Compositional Trend Report</p>
                                                  </a>
                                              </div>=
                                              <div class="info-block">
                                                  <a data-target="#openModal2">
                                                      <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Read Report - The Top 10 Compositional Trend Report", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                                      <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Read Report - The Top 10 Compositional Trend Report", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                                                  </a>
                                              </div><!-- /.header-block-2B -->
                                         </div>

                       <div class="col-6 flex">
                                                    <div class="header-block header-block-read3">
                                                      <a href="/industry-trend-report-search.php">
                                                          <p>The Interactive Industry Trend Report</p>
                                                      </a>
                                                  </div><!-- /.header-block-3b -->
                                                  <div class="info-block">
                                                      <a data-target="#openModal3">
                                                          <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Read Report - The Industry Trend Report", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                                          <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Read Report - The Industry Trend Report", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                                                      </a>
                                                  </div><!-- /.header-block-3B -->
                                             </div>

  <div class="col-6 flex" style="display:none;">
                           <div class="header-block header-block-read4">
                             <a href="/genre-search">
                                 <p>Genre Highlights</p>
                             </a>
                         </div><!-- /.header-block-4b -->
                         <div class="info-block">
                             <a data-target="#openModal4">
                                 <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Read Report - The Quarterly Genre Report", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                 <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Read Report - The Quarterly Genre Report", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                             </a>
                         </div><!-- /.header-block-4B -->
                    </div>





                        </div>



                       <?php
                include 'news-searches.php';
                ?>




                <!-- /MODAL BOXES -->
                 <div id="openModal1" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-read-a-report-icon.svg">
                        <h2>A Hit Song Deconstructed Report</h2>
                        <p><?=getOrCreateCustomHover( "Read Report Box - A Hit Song Deconstructed Report", "The Chart Cipher Report provides an unparalleled deep dive into the songwriting and production techniques being used in a chart-topping hit. Presented in a practical manner through a combination of charts, graphs, notation and commentary, the reader comes away with a full understanding of the what, how and why behind how the hit was written and produced and gains a wealth of songwriting and production techniques to add to their toolbox." )?></p>
                 <P><a href="https://editorial.chartcipher.com/" ><button>GET STARTED</button></a></P>
                    </div>
                </div>

                 <div id="openModal2" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-the-top-ten-compositional-trend-report-icon.svg">
                        <h2>The Compositional Trend Report</h2>
                        <p><?=getOrCreateCustomHover( "Read Report Box - The Top 10 Compositional Trend Report", "The Top 10 Compositional Trend Report details the compositional trends of the songs that chart in the Billboard Hot 100 Top 10 during a specific quarter across 28&#43; categories, including song length, genres and influences, instruments, the first chorus occurrence, tempo, key and more." )?></p>
												<P><a href="/trend-report-search"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                 <div id="openModal3" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-the-industry-trend-report-icon.svg">
                        <h2>The Industry Trend Report</h2>
                        <p><?=getOrCreateCustomHover( "Read Report Box - The Industry Trend Report", "The Industry Trend Report provides a snapshot of the industry trends as they relate to the songs that land in the Top 10 of the Billboard Hot 100 during a specific quarter.
                        Trend data is presented through graphs  and tables and is broken down by Top 10 hits, #1 hits, primary genres, and new arrival vs. carry over songs in order to further hone in on emerging trends." )?></p>

                        <P><a href="/industry-trend-report-search.php"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                 <div id="openModal4" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-the-quarterly-genre-report-icon.svg">
                        <h2>Genre Highlights</h2>
                        <p><?=getOrCreateCustomHover( "Read Report Box - The Quarterly Genre Report", "The Quarterly Genre Report provides subscribers with an at-a-glance comparison of the most popular compositional characteristics for each primary genre in the Top 10 of the Hot 100 for a specified quarter, across 25&#43; categories. Presented as a fully interactive table, the user has the ability click on each result to view the songs that possess that particular characteristic, and then further drill down on the song to view its compositional characteristics." )?></p>

                        <P><a href="/genre-search"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                 <div id="openModal5" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-the-quarterly-trend-report-icon-2.svg">
                        <h2>Quarterly Trend Report</h2>
                        <p><?=getOrCreateCustomHover( "Read Report Box - The Quarterly Genre Report", "The Quarterly Genre Report provides subscribers with an at-a-glance comparison of the most popular compositional characteristics for each primary genre in the Top 10 of the Hot 100 for a specified quarter, across 25&#43; categories. Presented as a fully interactive table, the user has the ability click on each result to view the songs that possess that particular characteristic, and then further drill down on the song to view its compositional characteristics." )?></p>

                        <P><a href="https://editorial.chartcipher.com/treports/ "><button>GET STARTED</button></a></P>
                    </div>
                </div>





			</div><!-- /.row -->
		</section><!-- /.home-top -->

	</div><!-- /.site-body -->
	<script>
		$(".header-block-read2, .header-block-read4").click(function() {
  window.location = $(this).find("a").attr("href");
  return false;
});




  $('.header-block-read1, .header-block-read3, .header-block-read5').click(function(){
      var location = $(this).find("a").attr("href");
  window.location = $(this).find("a").attr("href");
    return false;
  });
	</script>
<?php include 'footer.php';?>
