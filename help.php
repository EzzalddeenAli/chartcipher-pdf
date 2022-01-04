<?php 
$nologinrequired = 1;
include 'header.php';?>
	<div class="site-body">
		<section class="home-top">
			<div class="element-container row">
				<div class="header-container">
					<h1>Help</h1>
				</div><!-- /.header-container -->
				<div class="header-blocks">
					</div><!-- /.header-block-5 -->
				</div>
			</div><!-- /.row -->
		</section><!-- /.home-top -->
		<section class="home-bottom">
		</section><!-- /.home-bottom -->
	</div><!-- /.site-body -->
	<script>
		$(".header-block").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});
	</script>
<?php include 'footer.php';?>