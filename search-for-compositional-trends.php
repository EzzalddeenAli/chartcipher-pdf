<?php include 'header.php';?>
  <link rel="stylesheet" type="text/css" href="../assets/css/grid.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/new-style.css" />
<style>


</style>
	<div class="site-body dd-ct-search">



		<section class="">
			<div class="element-container row">
				<div class="header-container">
					<h1><?=getOrCreateCustomTitle( "Search for Compositional Trends", "Search for Compositional Trends" )?></h1><br>
					       <a href="/">Back to Home <img src="assets/images/home/hit-songs-deconstructed-back-to-home-arrow.svg"></a>
				</div><!-- /.header-container -->

                <div class="row row-equal row-padding">
                   <div class="col-3 flex">
                         <div class="header-block header-block-ct1">
                            <a href="/trend-search-influences">
                                <p>Sub/Influences</p>
                            </a>
                        </div><!-- /.header-block-1B -->
                        <div class="info-block">
                            <a data-target="#openModal1">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Comp. Trends - Genre & Influences", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Comp. Trends - Genre & Influences", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-1B -->
                   </div>

                  <div class="col-3 flex">
                          <div class="header-block header-block-ct2">
                            <a href="/trend-search-vocals">
                                <p>Vocals and Lyrics</p></p>
                            </a>
                        </div><!-- /.header-block-2b -->
                        <div class="info-block">
                            <a data-target="#openModal2">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Comp. Trends - Vocals and Lyrics", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Comp. Trends - Vocals and Lyrics", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-2B -->
                   </div>

                   <div class="col-3 flex">
                          <div class="header-block header-block-ct3">
                            <a href="/trend-search-structure">
                                <p>General Structure & Instruments</p>
                            </a>
                        </div><!-- /.header-block-3b -->
                        <div class="info-block">
                            <a data-target="#openModal3">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Comp. Trends - General Structure & Instrumentation", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Comp. Trends - General Structure & Instrumentation", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-3B -->
                   </div>


                   <div class="col-3 flex">
                          <div class="header-block header-block-ct4">
                            <a href="/trend-search-intro">
                                <p>First Section</p>
                            </a>
                        </div><!-- /.header-block-4b -->
                        <div class="info-block">
                            <a data-target="#openModal4">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Comp. Trends - Intro", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Comp. Trends - Intro", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-4B -->
                   </div>
                    </div>

                 <div class="row row-equal row-padding">
                   <div class="col-3 flex">
                         <div class="header-block header-block-ct5">
                            <a href="/trend-search-verse">
                                <p>Verse</p>
                            </a>
                        </div><!-- /.header-block-1B -->
                        <div class="info-block">
                            <a data-target="#openModal5">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Comp. Trends - Verse", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Comp. Trends - Verse", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-1B -->
                   </div>

                  <div class="col-3 flex">
                          <div class="header-block header-block-ct6">
                            <a href="/trend-search-prechorus">
                                <p>Pre-Chorus</p>
                            </a>
                        </div><!-- /.header-block-2b -->
                        <div class="info-block">
                            <a data-target="#openModal6">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Comp. Trends - Pre-Chorus", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Comp. Trends - Pre-Chorus", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-2B -->
                   </div>

                   <div class="col-3 flex">
                          <div class="header-block header-block-ct7">
                            <a href="/trend-search-chorus">
                                <p>Chorus</p>
                            </a>
                        </div><!-- /.header-block-3b -->
                        <div class="info-block">
                            <a data-target="#openModal7">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Comp. Trends - Chorus", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Comp. Trends - Chorus", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-3B -->
                   </div>


                   <div class="col-3 flex">
                          <div class="header-block header-block-ct8">
                            <a href="/trend-search-postchorus">
                                <p>Post-Chorus</p>
                            </a>
                        </div><!-- /.header-block-4b -->
                        <div class="info-block">
                            <a data-target="#openModal8">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Comp. Trends - Post-Chorus", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Comp. Trends - Post-Chorus", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-4B -->
                   </div>
                    </div>

                        <div class="row row-equal row-padding">
                   <div class="col-3 flex">
                     <div class="header-block header-block-ct9">
                        <a href="/trend-search-bridge">
                            <p>"D" (Departure) Sections</p>
                        </a>
                     </div><!-- /.header-block-1B -->
                        <div class="info-block">
                            <a data-target="#openModal9">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Comp. Trends - Bridge and Bridge Surrogates", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Comp. Trends - Bridge and Bridge Surrogates", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-1B -->
                   </div>

                  <div class="col-3 flex">
                          <div class="header-block header-block-ct10">
                            <a href="/trend-search-instrumental">
                                <p>Instrumental and Vocal Breaks</p>
                            </a>
                        </div><!-- /.header-block-2b -->
                        <div class="info-block">
                            <a data-target="#openModal10">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Comp. Trends - Instrumental and Vocal Breaks", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Comp. Trends - Instrumental and Vocal Breaks", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-2B -->
                   </div>

                   <div class="col-3 flex">
                          <div class="header-block header-block-ct11">
                            <a href="/trend-search-outro">
                                <p>Last Section</p>
                            </a>
                        </div><!-- /.header-block-3b -->
                        <div class="info-block">
                            <a data-target="#openModal11">
                                <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Comp. Trends - Outro", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Comp. Trends - Outro", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                            </a>
                        </div><!-- /.header-block-3B -->
                   </div>
                   <div class="col-3 flex">
                     <div class="header-block header-block-read2">
                       <a href="/trend-report-search">
                           <p>The Interactive Compositional Trend Report</p>
                       </a>
                   </div>=
                   <div class="info-block">
                       <a data-target="#openModal12">
                           <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Comp. Trends - Interactive Compositional Trend Report", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                           <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Comp. Trends - Interactive Compositional Trend Report", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
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
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-genres-and-influences-icon.svg">
                        <h2>Genres/Influences</h2>
                        <p><?=getOrCreateCustomHover( "Comp Trend Box - Genre & Influences", "Search for trends pertaining to the percentage of songs that possess a specific influence or fall into a specific primary genre." )?></p>
                        <P><a href="/trend-search-influences"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                 <div id="openModal2" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-vocals-and-lyrics-icon.svg">
                        <h2>Vocals and Lyrics</h2>
                        <p><?=getOrCreateCustomHover( "Comp Trend Box - Vocals and Lyrics", "Search for trends pertaining to the prominence of vocal delivery types and lyrical themes." )?></p>

                        <P><a href="/trend-search-vocals"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                 <div id="openModal3" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-general-structure-and-instrumentation-icon.svg">
                        <h2>General Structure & Instruments</h2>
                        <p><?=getOrCreateCustomHover( "Comp Trend Box - General Structure & Instrumentation", " Search for trends pertaining to general structure, composition and instrumentation, such as key, tempo and more." )?></p>

                        <P><a href="/trend-search-structure"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                 <div id="openModal4" class="modalDialog">
                    <div class="">
                        <a title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-intro-icon.svg">
                        <h2>First Section</h2>
                        <p><?=getOrCreateCustomHover( "Comp Trend Box - Intro", "Search for trends pertaining to intro length ranges and characteristics." )?></p>

                        <P><a href="/trend-search-intro"><button>GET STARTED</button></a></P>
                    </div>
                </div>
              <div id="openModal5" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-verse-icon.svg">
                        <h2>Verse</h2>
                        <p><?=getOrCreateCustomHover( "Comp Trend Box - Verse", " Search for trends pertaining to the number of verses and their lengths." )?></p>

                        <P><a href="/trend-search-verse"><button>GET STARTED</button></a></P>
                    </div>
                </div>
             <div id="openModal6" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-pre-chorus-icon.svg">
                        <h2>Pre-Chorus</h2>
                        <p><?=getOrCreateCustomHover( "Comp Trend Box - Pre-Chorus", "Search for trends pertaining to the inclusion of a pre-chorus, how many pre-choruses, and their lengths." )?></p>

                        <P><a href="/trend-search-prechorus"><button>GET STARTED</button></a></P>
                    </div>
                </div>
               <div id="openModal7" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-chorus-icon.svg">
                        <h2>Chorus</h2>
                        <p><?=getOrCreateCustomHover( "Comp Trend Box - Chorus", "Search for trends pertaining to the number of choruses, their placement, length and other characteristics." )?></p>

                        <P><a href="/trend-search-chorus"><button>GET STARTED</button></a></P>
                    </div>
                </div>
                 <div id="openModal8" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-post-chorus-icon.svg">
                        <h2>Post-Chorus</h2>
                        <p><?=getOrCreateCustomHover( "Comp Trend Box - Post-Chorus", "Search for trends pertaining to the inclusion of a post chorus, post chorus sections, and their characteristics." )?></p>

                        <P><a href="/trend-search-postchorus"><button>GET STARTED</button></a></P>
                    </div>
                </div>
              <div id="openModal9" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-bridge-and-bridge-surrogates-icon.svg">
                        <h2>Bridge and Bridge Surrogates</h2>
                        <p><?=getOrCreateCustomHover( "Comp Trend Box - Bridge and Bridge Surrogates", "Search for trends pertaining to the inclusion of a post chorus, post chorus sections, and their characteristics." )?></p>

                        <P><a href="/trend-search-bridge"><button>GET STARTED</button></a></P>
                    </div>
                </div>
             <div id="openModal10" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-instrumental-and-vocal-breaks-icon.svg">
                        <h2>Instrumental and Vocal Breaks</h2>
                        <p><?=getOrCreateCustomHover( "Comp Trend Box - Instrumental and Vocal Breaks", "Search for trends pertaining to the inclusion of a vocal or instrumental break" )?></p>

                        <P><a href="/trend-search-instrumental"><button>GET STARTED</button></a></P>
                    </div>
                </div>
            <div id="openModal11" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-outro-icon.svg">
                        <h2>Last Section</h2>
                        <p><?=getOrCreateCustomHover( "Comp Trend Box - Outro", "Search for trends pertaining to outro lengths and characteristics." )?></p>

                        <P><a href="/trend-search-outro"><button>GET STARTED</button></a></P>
                    </div>
                </div>
            <div id="openModal12" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-the-top-ten-compositional-trend-report-icon.svg">
                        <h2>The Interactive Compositional Trend Report</h2>
                        <p><?=getOrCreateCustomHover( "Comp. Trend Box - Interactive Compositional Trend Report", "Search the Interactive Compositional Trend Report" )?></p>

                        <P><a href="/trend-search-outro"><button>GET STARTED</button></a></P>
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
