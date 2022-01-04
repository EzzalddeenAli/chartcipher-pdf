<?php include 'header.php';
$chartrow = db_query_first( "select * from charts where chartkey = '$chartkey'" ); 
?>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1><?=getOrCreateCustomTitle( "BROWSE CHART LIST", "BROWSE" )?></h1>
						<a class="search-header-clear">CLEAR ALL</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
						<form class="search-form">
							<div class="comp-hidden-browse comp-hidden-perform" id="comp-perform">
								<h3><a class="comp-icon comp-icon-perform"><?=$chartrow[chartname]?> <?=$thedate?></a></h3>
								<div id="comp-search-hidden" class="temp-hidden-browse">
      								<table width="100%" id="browse-table">
<tr>
<th>Rank</th>
<th>Title</th>
<th>Artist</th>
</tr>
<?php
    $arr = db_query_rows( "select * from billboardinfo where chart = '$chartkey' and thedate = '$thedate' order by rank", "rank" );
    foreach( $arr as $r )
{
 ?>
										<tr <? if ( $r[rank] == $hirank ) echo( "style='background-color: #eeffff'" ) ; ?>>
											<td class="search-column-2">
<a name='rank<?=$r[rank]?>'></a>
											<?=$r[rank]?>
											</td>

											<td class="search-column-2">
											<?=$r[title]?>
											</td>
											
											<td class="search-column-2">
											<?=$r[artist]?>
											</td>
											
											
										</tr>
<? } ?>
									</table>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->
      
							

						</form><!-- /.search-form -->
					</div><!-- /search-body -->
				</div><!-- /.info-container -->
			</div>
		</section><!-- /.song-title-top -->
	</div><!-- /.site-body -->
<?php include 'footer.php';?>