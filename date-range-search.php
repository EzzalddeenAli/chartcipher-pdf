<?php include 'header.php';?>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1>DATE RANGE SEARCH</h1>
						<a class="search-header-clear">CLEAR ALL</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
						<h2>To find songs that were present in the Hot 100 Top 10 during a specific time period, enter the date range
below.</h2>
						<form class="search-form" action="search-results" method='get'>
      <input type='hidden' name='searchtype' value='Date Range'>

							<div class="form-row-full">
                        		<div class="cf"></div> 
								<div id="modified" class="form-row-left-inner">
									<select id="fromq" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][fromq]">
										<option value="">Any</option>
<? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
									</select>
								</div>
								<div class="form-row-right-inner">
									<select data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][fromy]">
										<option value="">Any</option>
<? outputSelectValues( $years, $search["dates"]["fromy"] ); ?>
									</select>
								</div>	
								<label class="inner-label">- to -</label>
								<div class="form-row-left-inner">
									<select data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][toq]">
										<option value="">Any</option>
<? outputSelectValues( $quarters, $search["dates"]["toq"] ); ?>
									</select>
								</div>
								<div class="form-row-right-inner">
									<select data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][toy]">
										<option value="">Any</option>
<? outputSelectValues( $years, $search["dates"]["toy"] ); ?>
									</select>
								</div>
                                    <div id="fromqerror"></div>
		<div class="cf"></div>
                                
							</div><!-- /.form-row-full -->
                            
                            <hr class="sep">
							<h1>Additional Criteria <span>(The following items are not required)</span></h1>
							

								
	<div class="cf"></div>
								
							<div class="form-row-left">
								<label>Primary Genre:</label>
								<select name='search[GenreID]'>
									<option value="">Any</option>
<? outputSelectValues( $allgenresfordropdown, $search["GenreID"] ); ?>
								</select>
							</div><!-- /.form-row-left -->
                       
                            <div class="form-row-right">
								<label>Genre/Influence:</label>
								<select name='search[specificsubgenre]'>
									<option value="">Any</option>
<? outputSelectValuesForOtherTable( "subgenres", $search["specificsubgenre"], true ); ?>
								</select>
							</div><!-- /.form-row-left -->
                            <div class="cf"></div>
							<div class="form-row-left">
								<label>Performing Artist:</label>
								<? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist] ); ?>
							</div><!-- /.form-row-left -->
							
							<div class="form-row-right">
								<label>Songwriter:</label>
								<? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Greg Kurstin)", $search[writer] ); ?>
							</div><!-- /.form-row-left -->
							<div class="cf"></div>
							<div class="form-row-left">
								<label>Producer:</label>
<? outputOtherTableAutofillField( "producers", "producer", "(i.e Shampoo Press & Curl, Max Martin)", $search[producer] ); ?>
							</div><!-- /.form-row-left -->
							<div class="form-row-right">
								<label>Record Label:</label>
								<select name='search[labelid]'>
									<option value="">Any</option>
<? outputSelectValuesForOtherTable( "labels", $search["labelid"] ); ?>
								</select>
							</div><!-- /.form-row-left -->
                            
                            
						<div class="form-row-left">
								<label>Peak Chart Position:</label>
								<select name="search[peakchart]">
									<option value="">Top 10</option>
									<? 
outputSelectValues( $peakvalues, $search["peakchart"] );
outputClientSelectValues( $search["peakchart"] );
?>
								</select>

					</div><!-- /.form-row-right -->
							<div class="form-row-right">
              								<div class="cf"></div>
              								<div class="form-row-right-inner">
              								<label><nobr>New Songs / Carryovers:</nobr></label>
              								</div>
              								<div class="cf"></div>
              								<select name="search[toptentype]">
              									<option value="">All Songs</option>
              	   <? outputSelectValuesForNewCarry( $search["toptentype"], "trend" )?>
              								</select>


							</div><!-- /.form-row-left -->
							
							<div class="cf"></div>
							<div class="form-row-full">
								<input type="submit" value="SEARCH" />
								<div class="cf"></div>
							</div><!-- /.form-row-full -->
						</form><!-- /.search-form -->
					</div><!-- /search-body -->
				</div><!-- /.info-container -->
			</div>
		</section><!-- /.song-title-top -->
	</div><!-- /.site-body -->
     <script>
	jQuery(document).ready(function($){
	
	$.validator.setDefaults({
		errorElement: 'div',
		
	});
	
	$('.search-form').validate({
		
		rules: {
//			'search[primaryartist]': { required: true }
		}
		});
		/*$(document).on('click', '#submit', function(e) {
			if ($(".search-form").valid()) {
				console.log ( 'It worked!' );	
			}
			else{
				e.preventDefault(); 
			}
		});*/
//		$('#autosuggestprimaryartist').focus();
		
	});
	
	</script>
<?php include 'footer.php';?>