<?php include 'header.php';
include "trendfunctions.php";

?>
<style type="text/css">
	.search-header h1{ float:none; }
	.search-header h2{
    margin-top: 15px;
    color: #7a7a7a;
    font-size: 14px;
	}
	.form-row-left .form-row-right
	{
		width: 100%;
		margin-top: 50px;
	}
	.search-body h2
	{
		color: #7a7a7a;
    	font-size: 14px;
    	font-style: italic;
	}
	@media (min-width: 768px){
		.form-row-left-inner, .form-row-right-inner
		{
			    width: 49%;
		}
	}
</style>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1>GENRE HIGHLIGHTS</h1>
						<a class="search-header-clear">CLEAR ALL</a>
						<div class="cf"></div>
<?php
	$cust = getCustomHover( "genre-search" );
	if( !$cust )
		$cust = "This search depicts top characteristics by primary genre within songs that have charted in the Billboard Hot 100 Top Ten.";
?>
					<h2><?=$cust?></h2>
					</div><!-- /search-header -->
					<div class="search-body">
						<form class="search-form" method='get' action='genre-search-results.php'>
      <input type='hidden' name='searchtype' value='Genre'>
							<div class="form-row-left">
								<label>Select Quarter and Year:</label><br/>
								<div class="form-row-left-inner">
									<select name="search[dates][fromq]">
										<option value="">Any</option>
<? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
									</select>
								</div>
								<div class="form-row-right-inner">
									<select name="search[dates][fromy]">
										<option value="">Any</option>
<? outputSelectValues( $years, $search["dates"]["fromy"] ); ?>
									</select>
								</div>
								<!-- <label class="inner-label">- to -</label>
								<div class="form-row-left-inner">
									<select name="search[dates][toq]">
										<option value="">Any</option>
<? outputSelectValues( $quarters, $search["dates"]["toq"] ); ?>
									</select>
								</div>
								<div class="form-row-right-inner">
									<select name="search[dates][toy]">
										<option value="">Any</option>
<? outputSelectValues( $years, $search["dates"]["toy"] ); ?>
									</select>
								</div> -->
								<div class="cf"></div>
							</div><!-- /.form-row-left -->
							<div class="form-row-right">
								<label>Peak Chart Position:</label>
								<select name="search[peakchart]">
									<option value="">Top 10</option>
									<?php
outputSelectValues( $peakvalues, $search["peakchart"] );
?>
								</select>
							</div><!-- /.form-row-right -->
							<div class="cf"></div>
							<div class="form-row-left">
</div>
							<div class="form-row-right">
							<input type="submit" value="SEARCH" />
								<div class="cf"></div>
							</div><!-- /.form-row-right -->
							<div class="cf"></div>

						</form><!-- /.search-form -->
					</div><!-- /search-body -->
				</div><!-- /.info-container -->
			</div>
		</section><!-- /.song-title-top -->
	</div><!-- /.site-body -->
	<script>

		$("#comp-select").change(function(){
		    if ($("#comp-select").val() == "Performing Artist") {
		       $('.comp-hidden-perform').removeClass('hide').addClass('show');
		    }
		    else {
		       $('.comp-hidden-perform').removeClass('show').addClass('hide');
		    }
		    if ($("#comp-select").val() == "Songwriters") {
		       $('.comp-hidden-songwriters').removeClass('hide').addClass('show');
		    }
		    else {
		       $('.comp-hidden-songwriters').removeClass('show').addClass('hide');
		    }
		    if ($("#comp-select").val() == "Record Labels") {
		       $('.comp-hidden-record').removeClass('hide').addClass('show');
		    }
		    else {
		       $('.comp-hidden-record').removeClass('show').addClass('hide');
		    }
		    if ($("#comp-select").val() == "Primary Genre") {
		       $('.comp-hidden-primary').removeClass('hide').addClass('show');
		    }
		    else {
		       $('.comp-hidden-primary').removeClass('show').addClass('hide');
		    }
		    if ($("#comp-select").val() == "Vocal Gender") {
		       $('.comp-hidden-vocal').removeClass('hide').addClass('show');
		    }
		    else {
		       $('.comp-hidden-vocal').removeClass('show').addClass('hide');
		    }
		});

// to refill existing choices
$( document ).ready(function() {
        $("#comp-select").change();
        $('select[name="search[dates][fromy]"]').val("<?=$search[dates][fromy]?>");
        $('select[name="search[dates][fromq]"]').val("<?=$search[dates][fromq]?>");
    });

	</script>
    <script>
		jQuery(document).ready(function($){

		$.validator.setDefaults({
			errorElement: 'div',

		});

		$('.search-form').validate({

			rules: {
				'search[comparisonaspect]': { required: true },
			}
			});


		});

	</script>
<?php include 'footer.php';?>
