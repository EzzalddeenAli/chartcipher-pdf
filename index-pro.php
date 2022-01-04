<?php require_once 'header.php';?>
  <link rel="stylesheet" type="text/css" href="../assets/css/grid.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/new-style.css" />
<style>


</style>
	<div class="site-body index-pro">
        <section class="home-top">
			<div class="element-container row">
				<div class="header-container">
					<h1>Recent Chart Cipher Reports</h1><br>
				</div><!-- /.header-container -->

                <?php
                include 'masterslider/homepage/start.php';
                ?>
            </div><!-- /.row -->
		</section><!-- /.home-top -->


		<section class="">
			<div class="element-container row">
				<div class="header-container">
					<h1>What would you like to do?</h1>
				</div><!-- /.header-container -->
                <div class="row row-equal row-padding">

                   <div class="col-3 flex">
                         <div class="header-block header-block-1b">
                            <a href="/read-a-report">
                                <p>Read a Report</p>
                            </a>
                        </div><!-- /.header-block-1B -->
                        <div class="info-block">
                            <a  data-target="#openModal1">
                            <div class="modal-hover-icon"></div>
                            </a>
                        </div><!-- /.header-block-1B -->
                   </div>
                    
                    <div class="col-3 flex">
                          <div class="header-block header-block-6b">
                            <a href="/advanced-search">
                                <p>Find Songs with Specific Criteria</p>
                            </a>
                        </div><!-- /.header-block-6b -->
                        <div class="info-block">
                            <a data-target="#openModal6">
                               <div class="modal-hover-icon"></div>
                            </a>
                        </div><!-- /.header-block-6B -->
                   </div>

                  <div class="col-3 flex">
                          <div class="header-block header-block-2b">
                            <a href="/search-for-compositional-trends.php">
                                <p>Compositional Trends</p>
                            </a>
                        </div><!-- /.header-block-2b -->
                        <div class="info-block">
                            <a data-target="#openModal2">
                               <div class="modal-hover-icon"></div>
                            </a>
                        </div><!-- /.header-block-2B -->
                   </div>

                   <div class="col-3 flex">
                          <div class="header-block header-block-3b">
                            <a href="/search-for-industry-trends">
                                <p>Artists, Writers, Producers & Labels</p>
                            </a>
                        </div><!-- /.header-block-3b -->
                        <div class="info-block">
                            <a  data-target="#openModal3">
                               <div class="modal-hover-icon"></div>
                            </a>
                        </div><!-- /.header-block-3B -->
                   </div>

                    </div>

                 <div class="row row-equal row-padding">
                     
                      <div class="col-3 flex">
                          <div class="header-block header-block-4b">
                            <a href="/comparative-search">
                                <p>Benchmark Tool</p>
                            </a>
                        </div><!-- /.header-block-4b -->
                        <div class="info-block">
                            <a data-target="#openModal4">
                              <div class="modal-hover-icon"></div>
                            </a>
                        </div><!-- /.header-block-4B -->
                   </div>

                   <div class="col-3 flex">
                         <div class="header-block header-block-5b">
                            <a href="/staying-power">
                                <p>Staying Power</p>
                            </a>
                        </div><!-- /.header-block-5B -->
                        <div class="info-block">
                            <a data-target="#openModal5">
                              <div class="modal-hover-icon"></div>
                            </a>
                        </div><!-- /.header-block-5B -->
                   </div>

                   <div class="col-3 flex">
                          <div class="header-block header-block-7b">
                            <a href="/technique-search">
                                <p>Hit Song Technique Library</p>
                            </a>
                        </div><!-- /.header-block-7b -->
                        <div class="info-block">
                            <a data-target="#openModal7">
                               <div class="modal-hover-icon"></div>
                            </a>
                        </div><!-- /.header-block-7B -->
                   </div>


                   <div class="col-3 flex">
                           <div class="header-block header-block-browse6">
                             <a href="/browse?val=logicfiles ">
                                 <p>Logic Projects</p>
                             </a>
                         </div><!-- /.header-block-3b -->
                         <div class="info-block">
                             <a data-target="#openModal8">
                                 <img class="more-info-icon page-icon" title="<?=getOrCreateCustomHover( "Browse - Logic Projects", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon.svg" border="0">
                                 <img class="more-info-icon page-icon orange" title="<?=getOrCreateCustomHover( "Browse - Logic Projectsa", "Look for compositional trends across the Top 10 or for #1 Hits. Filter by genre, artist or songwriter." )?>" src="assets/images/hit-songs-deconstructed-more-information-tile-icon-hover.svg" border="0">
                             </a>
                         </div><!-- /.header-block-3B -->
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
                        <h2>Read a Report</h2>
                        <p><?=getOrCreateCustomHover( "Pro Box - Read A Report", "From here you can access all reports.")?></p>
                        <P><a href="/read-a-report"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                 <div id="openModal2" class="modalDialog">
                    <div class="">
                        <a title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-search-for-compositional-trends-icon.svg">
                        <h2>Compositional Trends</h2>
                        <p><?=getOrCreateCustomHover( "Pro Box - Search For Compositional Trends", "Look for compositional trends across the Top 10 or for #1 Hits. Filter results by a selected time period, genre or peak chart position. View results as a line graph or a bar graph.")?></p>

                        <P><a href="/search-for-compositional-trends.php"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                 <div id="openModal3" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-search-for-industry-trends-icon.svg">
                        <h2>Artists, Writers, Producers & Labels</h2>
                        <p><?=getOrCreateCustomHover( "Pro Box - Search for Industry Trends", "Find out what degree of success record labels, artists and songwriters are having quarter to quarter and what songs they account for. You can view trends for a selected time-period as a whole, or only look at songs by a specific songwriter, artist or label. Additional filters include peak chart position and genre. View search results as a line graph or a bar graph." )?></p>

                        <P><a href="/search-for-industry-trends"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                 <div id="openModal4" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-compare-compositional-trends-icon.svg">
                        <h2>Benchmark Tool</h2>
                        <p><?=getOrCreateCustomHover( "Pro Box - Compare Compositional Trends", "Compare genres, influences, song structure characteristics, lyrical themes and more across performing artists, songwriters, record labels. You can either look at Top 10 or #1 Hits as a whole, or select up to 10 individual songs, artists, songwriters, or labels to see what compositional characteristics they have in common.  For example, compare 10 songs written by Max Martin to each other.  Or compare compositional characteristics for songs written by Max Martin to those written by Benny Blanco. " )?></p>

                        <P><a href="/comparative-search"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                  <div id="openModal5" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-top-10-staying-power-icon.svg">
                        <h2>Staying Power</h2>
                        <p><?=getOrCreateCustomHover( "Pro Box - Top 10 Staying Power", "Search for how many weeks a song, performing artist, songwriter, record label, primary genre, or lead vocal gender spent in the Top 10 or at #1 during a specific time-period. And then drill down to view the songs and their compositional characteristics." )?></p>
                        <P><a href="/staying-power"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                 <div id="openModal6" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-search-for-songs-icon.svg">
                        <h2>Find Songs with Specific Criteria</h2>
                        <p><?=getOrCreateCustomHover( "Pro Box - Search for Songs by Song Title, Songwriter, Performing Artist or Label", "Search for songs by song title, songwriter, performing artist or label to view their compositional characteristics and filter by peak chart position, genre and more." )?></p>

                        <P><a href="/advanced-search"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                 <div id="openModal7" class="modalDialog">
                    <div class="">
                        <a  title="Close" class="close">X</a>
                        <img src="assets/images/home/hit-songs-deconstructed-techniques-icon.svg">
                        <h2>Songwriting Techniques Archive</h2>
                           <p><?=getOrCreateCustomHover( "Pro Box - Technique Search", "Search for songwriting techniques (i.e.: hook techniques, techniques to hook the listener in and leave them wanting more, genre fusion techniques, duet structure techniques, etc.)" )?></p>

                        <P><a href="/technique-search"><button>GET STARTED</button></a></P>
                    </div>
                </div>

                <div id="openModal8" class="modalDialog">
                   <div class="">
                       <a  title="Close" class="close">X</a>
                       <img src="assets/images/home/hit-songs-deconstructed-logic-projects-icon.svg">
                       <h2>Logic Projects</h2>
                       <p><?=getOrCreateCustomHover( "Browse Box - Logic Projects", "View Logic Projects.")?></p>
                       <P><a href="/browse?val=logicfiles "><button>GET STARTED</button></a></P>
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
