<style type="text/css">
	.search-header h1{ float:none; }
	.search-header h2{
    margin-top: 15px;
    color: #7a7a7a;
    font-size: 14px;
	}
    
</style>
	<div class="site-body">
        <? include "searchcriteria-chart.php"; ?>
		<section class="search-results-bottom">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
    <h1>Charting for <?=$songrow[CleanUrl]?></h1>
        <a href='#' id="exportpng" onClick='return false'  class="save-header-back">Save As Image</a>
						<h2>
            <?php
            $key = "Charting Info - Table";
if( $_GET["showkey"] ) echo( "<font color='red'>$key</font><br><Br>" ); 
$custom = getOrCreateCustomHover( $key, "This search reflects charting info for the selected song." ); ?>
        <?=$custom?>
<br><br>

    </h2>
						<a href="<?=$songrow[CleanUrl]?>" class="search-header-back">BACK <span class="hide-text">TO SEARCH</span></a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">

<!-- table goes here -->

						<table width="100%" id="comp-search-table">
							<tr>
								<th class="comp-search-header-1 sortablecol">
Chart
    <i>(click to sort)</i>
								</th>
								<th class="sortablecol">
Week Entered the Chart
    <i>(click to sort)</i>
								</th>
								<th class="sortablecol">
Week Entered the Top Ten
    <i>(click to sort)</i>
								</th>
								<th class="sortablecol">
Number of Weeks
    <i>(click to sort)</i>
								</th>
								<th class="sortablecol">
Peak Chart Position
    <i>(click to sort)</i>
								</th>
							</tr>
                            <?php

$rows = getRowsComparison( $songid );

foreach( $rows as $chartkey ) {
    $chartname = $allcharts[$chartkey];
    $min = mdyFormatDate( db_query_first_cell( "select min( thedate ) from billboardinfo where songid = '$songid' and chart = '$chartkey'" ) );
    $min10 = mdyFormatDate( db_query_first_cell( "select min( thedate ) from billboardinfo where songid = '$songid' and chart = '$chartkey' and rank <= 10" ) );
    if( !$min10 ) $min10 = "Never";
    $num = db_query_first_cell( "select count(*) from billboardinfo where songid = '$songid' and chart = '$chartkey'" );
    $peak = db_query_first_cell( "select min( rank ) from billboardinfo where songid = '$songid' and chart = '$chartkey'" );
    //echo( "select min( rank ) from billboardinfo where songid = '$songid' and chart = '$chartkey'<br>" );
                                ?>
							<tr>
								<td data-label="Chart" class="comp-search-column-1  sortablerow">
<?=$chartname?>
								</td>
								<td data-label="Entered Charts" class="comp-search-column-1 sortablerow">
<?=$min?>
								</td>
								<td data-label="Entered Top 10" class="comp-search-column-1 sortablerow">
<?=$min10?>
								</td>
								<td data-label="Num Weeks" class="comp-search-column-1 sortablerow">
<?=$num?>
								</td>
								<td data-label="Peak" class="comp-search-column-1 sortablerow">
<?=$peak?>
								</td>
							</tr>
                                  <? } ?>
				      <tr ><td colspan='400' class="foot" >&copy; <?=date( "Y")?> Chart Cipher. All rights reserved.</td></tr>
						</table>
                             

<!-- end table -->

                        <div class="search-footer">
							<div class="search-footer-left span-3">
								<a href="<?=$songrow[CleanUrl]?>" style="float:left;" class="search-header-back">BACK <span class="hide-text">TO SONG</span></a>
								<div class="cf"></div>
							</div><!-- /search-footer-left -->
							<div class="search-footer-right span-4">
    <? if( !isStudent() && !isEssentials() && 1 == 0 ) { ?>
    <a class="black-btn" href="#" data-featherlight="#searchlightbox">SAVE SEARCH</a>
								<a class="orange-btn" href="/trend-search<?=$thetype?"-$thetype":""?>">NEW SEARCH</a>
                            <? } ?>
								<div class="lightbox" id="searchlightbox">
									<div class="save-search-header">
										<h1>SAVE SEARCH</h2>
									</div><!-- /.save-search-header -->
									<div class="save-search-body">
										<label>Name:</label>
										<input type='text' name="searchname" id='searchname' onChange='javascript:document.getElementById( "searchnamehidden").value = this.value; '>
										<a class="black-btn" href="#" onClick='javascript:saveSearch( "saved", "Chart Search" ); return false'>SAVE</a>
										<div class="cf"></div>
									</div><!-- /.save-search-body -->
								</div><!-- #searchlightbox -->
							</div><!-- /search-footer-right -->
							<div class="cf"></div>
						</div><!-- /.search-footer -->
					</div><!-- /search-body -->
				</div><!-- /.search-container -->
			</div><!-- /.row -->
		</section><!-- /.search-results-bottom -->
	</div><!-- /.site-body -->
      <input type='hidden' name="searchnamehidden" id='searchnamehidden'>
    <script>
		var sessid = "<?=session_id()?>";
		var searchType = "<?=$searchtype?$searchtype:"Chart"?>";
	var searchName = "CHART INFO: <?=$songtitlestr?>";

saveSearch( "recent" );
$(document).ready(function(){
        $("a.expand-btn").click(function(){
            $("a.expand-btn").toggleClass("collapse-btn");
            $("#search-hidden").toggleClass("hide show");
        });
    });
    $(document).ready(function(){
            $("#exportpng").click(function(){
//                    $(".showme").css( "display", "" );
                    $('#comp-search-table').tableExport({type:'png',escape:'false'}); 
//                    $(".showme").css( "display", "none" );
                });

        });

    </script>
<?php include 'sortingjavascript.php';?>    

    
<?php include 'footer.php';?>
