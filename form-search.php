<?php include 'header.php';?>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1>FORM SEARCH</h1>
						<a class="search-header-clear">CLEAR ALL</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
						<form class="search-form" action="search-results" method='get'>
      <input type='hidden' name='searchtype' id='searchtype' value='Song Form'>
							<div class="form-header adj">
								<div class="form-column span-4 element-inline" style="vertical-align:middle;">
      <h3><input type="radio" name="searchby" id="searchby-form" value="Search by a specific form" <?=!$searchby || $searchby == "Search by a specific form"?"CHECKED":""?>> <label for="searchby-form"><span></span> Search by a specific form</label></h3>
								</div><div class="circle-wrap  element-inline"><div class="circle element-inline">-or-</div></div><div class="form-column span-4 element-inline" style="margin-right:0;vertical-align:middle;">
									<h3><input type="radio" name="searchby" id="searchby-sections" value="Search by sections" <?=$searchby == "Search by sections"?"CHECKED":""?>> <label for="searchby-sections"><span></span> Search by a first and/or last section</label> </h3>
								</div>
							</div><!-- /form-header -->
							<div class="form-column span-5 element-inline">
								<label style="float:left;">Form<img class="info-icon" title="<?=getCustomHover( "Core Form" )?>" src="assets/images/info-icon.svg" border="0" />: </label>
                                <div style="clear:both;"></div>
								<p style="margin-bottom:30px;">To search for a specific form, please enter it below, be sure to include a hyphen in between sections</p>
								<div class="form-row-full">
										<input type="text" name="search[fullform]" value="<?=$search[fullform]?>" id="search-fullform" placeholder="(i.e. A-B-A-B-C-B)" onChange='javascript:hideSections( this.value )'>
									</div>	<!-- /.form-row-full -->
							</div><!-- /.form-column -->
							<div class="form-column span-5 element-inline" style="margin-right:0;">
								<label>Song Beginning &amp; Ending:</label>
								<div class="form-row-full">
									<select name="search[FirstSectionType]" id="search-firstsectiontype" disabled>
										<option value="">Any First Section</option>
										<?php
										$fs = $mainsections;
										unset( $fs["Pre-Chorus"] );
										unset( $fs["Bridge"] );
										unset( $fs["Inst Break"] );
										unset( $fs["Vocal Break"] );
										unset( $fs["Outro"] );
										outputSelectValues( $fs, $search["FirstSectionType"] ); ?>
									</select>
								</div><!-- /.form-row-full -->
								<div class="form-row-full">
									<select name="search[LastSectionType]" id="search-lastsectiontype" disabled>
										<option value="">Any Last Section</option>
										<?php
	                                    $fs = $mainsections;
										unset( $fs["Pre-Chorus"] );
										unset( $fs["Intro"] );
										     outputSelectValues( $fs, $search["LastSectionType"] ); ?>
									</select>
								</div><!-- /.form-row-full -->
								<div class="cf"></div>
							</div><!-- /.form-column -->

								<h1>Additional Criteria <span>(The following items are not required)</span></h1>
								<div class="form-row-full">
									<label>Date Range:</label> <br/>
									<div class="form-row-left-search">
									<select name="search[dates][fromq]">
										<option value="">Any</option>
<? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
									</select>
									</div>
									<div class="form-row-right-search">
									<select name="search[dates][fromy]">
										<option value="">Any</option>
<? outputSelectValues( $years, $search["dates"]["fromy"] ); ?>
									</select>
									</div>
									<label class="inner-label">- to -</label>
									<div class="form-row-left-search">
									<select name="search[dates][toq]">
										<option value="">Any</option>
<? outputSelectValues( $quarters, $search["dates"]["toq"] ); ?>
									</select>
									</div>
									<div class="form-row-right-search">
									<select name="search[dates][toy]">
										<option value="">Any</option>
<? outputSelectValues( $years, $search["dates"]["toy"] ); ?>
									</select>
									</div>
									<div class="cf"></div>
								</div><!-- /.form-row-full -->
								<div class="form-row-left">
									<label>Peak Chart Position:</label>
								<select name="search[peakchart]">
									<option value="">Top 10</option>
      <? outputSelectValues( $peakvalues, $search["peakchart"] );
outputClientSelectValues( $search["peakchart"] );
 ?>
								</select>
								</div><!-- /.form-row-left -->
								<div class="form-row-right">
									<label>Primary Genre:</label>
								<select name='search[GenreID]'>
									<option value="">Any</option>
<? outputSelectValuesForOtherTable( "genres", $search["GenreID"] ); ?>
								</select>
								</div><!-- /.form-row-left -->
								<div class="cf"></div>
								<div class="form-row-left">
									<label>Primary Vocal Gender:</label>
								<select name='search[vocalsgender]'>
									<option value="">Any</option>
									<? outputSelectValuesForEnum( "VocalsGender", $search["vocalsgender"] ); ?>
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
									<label>Recording Artist / Group:</label>
<? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist] ); ?>
								</div><!-- /.form-row-left -->
								<div class="form-row-right">
									<label>Songwriter:</label>
      <? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Greg Kurstin)", $search[writer]); ?>
								</div><!-- /.form-row-left -->
								<div class="cf"></div>


								<div class="form-row-left">

              								<div class="cf"></div>
              								<div class="form-row-left-inner">
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
   		$(document).ready(function(){
   			$('#searchby-form').click(function(){
			    if ($(this).is(':checked'))
			    {
			      $("#search-firstsectiontype").prop('disabled', true);
			      $("#search-lastsectiontype").prop('disabled', true);
			      $("#search-fullform").prop('disabled', false);
			    }
			  });
   			$('#searchby-sections').click(function(){
			    if ($(this).is(':checked'))
			    {
			      $("#search-fullform").prop('disabled', true);
			      $("#search-firstsectiontype").prop('disabled', false);
			      $("#search-lastsectiontype").prop('disabled', false);
			    }
			  });
            <? if( $searchby == "Search by sections") { ?>

                $('#searchby-sections').click();
                <? } ?>
            $('#search-fullform').focus();
   		});
   </script>
<?php include 'footer.php';?>
