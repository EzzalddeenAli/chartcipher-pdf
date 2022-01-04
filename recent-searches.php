<?php include 'header.php';

if( isEssentials() ) 
{
Header( "Location: index.php?l=1" );
exit;
}


if( $delid )
{
	db_query( "delete from recentsearches where userid = '$userid' and id = $delid" );
	$err = "<font color='red'>Deleted.</font>";
}
if( $delall )
{
	$ext = $_COOKIE["proxyloginid"]?" and proxyloginid = '$_COOKIE[proxyloginid]'":"";
	db_query( "delete from recentsearches where userid = '$userid' $ext " );
	header("Location: recent-searches.php?errmsg=delall");

}
if( $errmsg == "delall" )
{
	$err = "<font color='red'>Deleted all recent searches.</font>";
}

?>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1><?=getOrCreateCustomTitle( "RECENT SEARCHES", "RECENT SEARCHES" )?></h1>
						<a href="#" class="search-header-manage">Manage</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
<?=$err?>
						<table width="100%" id="saved-searches-table">
							<tr>
								<th>
									Name
								</th>
								<th>
									Search Type
								</th>
								<th>
									Date
								</th>
								<th>
									<a href="recent-searches.php?delall=1" class="delete-btn-all">Delete All</a>
								</th>
							</tr>
<? $searches = getRecentSearches( 40 ); 
$already = array();
foreach( $searches as $s ) { 
	 if( isset( $already[$s[url]] ) ) continue;
$already[$s[url]] = 1;
?>

							<tr data-href="<?=$s[url]?>">
								<td data-label="Name" class="search-column-2">
<?=$s[Name]?$s[Name]:"Advanced Search"?>
								</td>
								<td data-label="Search Type" class="search-column-2">
<?=$s[searchtype]?>
								</td>
								<td data-label="Date" class="search-column-3">
<?=prettyFormatDateWithTime( $s[dateadded] ) ?>
								</td>
								<td class="search-column-4">
									<a href="recent-searches.php?delid=<?=$s[id]?>" class="delete-btn">Delete</a>
									<a href="<?=$s[url]?>"><img src="assets/images/home/search-arrow-icon.svg" /></a>
									<div class="cf">
								</td>
							</tr>
<? } 
if( !count( $searches ) ) {  ?>
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