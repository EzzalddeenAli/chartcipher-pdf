<?php include 'header.php';

if( isEssentials() ) 
{
Header( "Location: index.php?l=1" );
exit;
}



$delid  = $_GET["delid"];
if( $delid )
{
	$ext = $_COOKIE["proxyloginid"]?" and proxyloginid = '$_COOKIE[proxyloginid]'":"";
	db_query( "delete from favorites where userid = '$userid' and songid = $delid $ext" );
	$err = "<font color='red'>Deleted.</font>";
}
if( $_GET["delall"] )
{
	$ext = $_COOKIE["proxyloginid"]?" and proxyloginid = '$_COOKIE[proxyloginid]'":"";
	db_query( "delete from favorites where userid = '$userid' $ext " );
	header("Location: favorite-songs.php?errmsg=delall");

}
if( $_GET["errmsg"] == "delall" )
{
	$err = "<font color='red'>Deleted all favorites.</font>";
}

?>
<style type="text/css">
.editable { cursor: pointer; }

.search-header h1 { float:none; }

.search-header h2 {
    margin-top: 15px;
    color: #7a7a7a;
    font-size: 14px;
}
</style>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1>FAVORITE SONGS</h1>
<h2>    <? $cust = getOrCreateCustomHover( "favorite-songs", "View and manage your favorite songs." );?>
<?=$cust?></h2>
						<a href="#" class="search-header-manage">Manage</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
<?=$err?>
						<table width="100%" id="saved-searches-table">
							<tr>
								<th>
									Artist/Group
								</th>
								<th>
									Song Title
								</th>
								<th>
									Date Saved
								</th>
								<th>
									<a href="favorite-songs.php?delall=1" class="delete-btn-all">Delete All</a>
								</th>
							</tr>
<?php
$favorites = getFavoriteSongs();
foreach( $favorites as $songid=> $dateadded ) { 
 ?>
							<tr data-href='search-results-item?id=<?=$songid?>'>
								<td data-label="Name" class="search-column-1">
<a href="search-results-item?id=<?=$songid?>"><?php
        $artists = getArtists( $songid );
    if( !$artists )
        $artists = getGroups( $songid );
    echo( $artists );
    ?>
        </a>

								</td>
								<td data-label="Search Type" class="search-column-2">
<a href="search-results-item?id=<?=$songid?>"><?=getSongnameFromSongid( $songid )?></a>
								</td>
								<td data-label="Date" class="search-column-3">
<?=prettyFormatDate( $dateadded )?>
								</td>
								<td class="search-column-4">
									<a href="favorite-songs.php?delid=<?=$songid?>" class="delete-btn">Delete</a>
									<a href="search-results-item?id=<?=$songid?>"><img src="assets/images/home/search-arrow-icon.svg" /></a>
									<div class="cf">
								</td>
							</tr>
<? } 

if( !count( $favorites ) ) {  ?>
							<tr data-href='url://'>
								<td data-label="Name" class="search-column-1">
None yet.
								</td>
								<td data-label="Search Type" class="search-column-2">

								</td>
								<td data-label="Date" class="search-column-3">

								</td>
								<td class="search-column-4">
								</td>
							</tr>
<? } ?>
						</table>
					</div><!-- /search-body -->
				</div><!-- /.search-container -->
			</div>
		</section><!-- /.song-title-top -->
	</div><!-- /.site-body -->
	<script>
	$(document).ready(function(){
	    $(".search-header-manage").click(function(){
	        $(".delete-btn").toggleClass("show");
	        $(".delete-btn-all").toggleClass("show");
	        $(".search-column-4 img").toggleClass("hide");
	    });

	    $(".search-table").on('click','.delete-btn',function(){
    		$(this).closest('tr').remove();
    	});

	    $(".search-table").on('click','.delete-btn-all',function(){
    		$(".search-table").empty();
      	});
	});
	</script>	
<?php include 'footer.php';?>