<?php include 'header.php';?>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1><?=getOrCreateCustomTitle( "SEARCH FOR SONGS WITH SPECIFIC CRITERIA", "SEARCH FOR SONGS WITH SPECIFIC CRITERIA" )?></h1>
						<a class="search-header-clear" onClick='document.location.href="advanced-search"'>CLEAR ALL</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
						<h2>Search for songs according to specific criteria</h2>
						<form class="search-form" action="search-results" method='get'>
      <input type='hidden' name='searchtype' value='Advanced'>
							<div class="form-row-left">
								<label>Date Range:</label><br/>
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
								<label class="inner-label">- to -</label>
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
								</div>
								<div class="cf"></div>
							</div><!-- /.form-row-left -->
							<!--<div class="form-row-right">
								<label>Primary Genre:</label>
								<select name='search[GenreID]'>
									<option value="">Any</option>
<? outputSelectValues( $allgenresfordropdown, $search["GenreID"] ); ?>
								</select>
							</div>--><!-- /.form-row-right -->

							<div class="form-row-right">
								<label>Peak Chart Position:</label>
								<select name="search[peakchart]">
									<option value="">Top 10</option>
      <? outputSelectValues( $peakvalues, $search["peakchart"] );
outputClientSelectValues( $search["peakchart"] );
?>
								</select>
							</div><!-- /.form-row-left -->
							<div class="cf"></div>

							<div class="form-row-left">
              								<label><nobr>New Songs / Carryovers:</nobr></label><br/>
              								<select name="search[newcarryfilter]">
              									<option value="">All Songs</option>
              	   <? outputSelectValuesForNewCarry( $newcarryfilter, "trend" )?>
              								</select>

							</div><!-- /.form-row-left -->
							<div class="form-row-right">
</div>
							<div class="cf"></div>

							<div class="form-row-left">
								<h1 style="margin-bottom:0;">Additional Criteria <span>(To add additional search criteria, please select the information below)</span></h1>
							</div><!-- /.form-row-left -->
							<div class="form-row-right">
							<input type="submit" value="SEARCH" />
								<div class="cf"></div>
							</div><!-- /.form-row-right -->
							<div class="cf"></div>


							<div class="search-hidden-container"  id="shc-artists">
								<h3><a class="expand-btn-16">Artists</a></h3>
								<div id="search-hidden-16" class="temp-hidden hide-16">
									<div class="form-column span-5 element-inline">

										<div class="form-row-full">
											<label>Artist:</label>

<? outputOtherTableAutofillField( "artists", "primaryartistprimary", "(i.e Adele, The Weeknd)", $search[primaryartistprimary] ); ?>

										</div><!-- /.form-row-full -->

										<div class="form-row-full">
											<label>Number of Credited Artists:</label>
											<select  name="search[ArtistCount]">
												<option value="">Any</option>
<? outputSelectValues( array( "1"=>"1", "2"=>"2", "3"=>"3", "4"=>"4", "5+"=>"5+" ), $search["ArtistCount"] ); ?>
											</select>
										</div><!-- /.form-row-full -->



									</div><!-- /.form-column -->
									<div class="form-column span-4 element-inline">

										<div class="form-row-full">
											<label>Solo vs. Multiple Artists:</label>
											<select name='search[svsmult]'>
												<option value="">Any</option>
<?php
outputSelectValues( $svsmulttypes, $search["svsmult"] );
?>
</select>
										</div><!-- /.form-row-full -->

										<div class="form-row-full">
											<label>Featured Artists:</label>
									<select name="search[mainartisttype]">
										<option value="">Any</option>
<?php
$artisttypes = array( "featured"=> "Only songs with a featured artist", "nofeatured" => "Only songs without a featured artist" );
outputSelectValues( $artisttypes, $search["mainartisttype"] );
?>
									</select>
										</div><!-- /.form-row-full -->



										<br/>
									</div><!-- /.form-column -->
									<div class="form-column span-1 element-inline" style="margin-right:0;">
									</div>
									<a class="search-header-clear-section"  id="shc-artists-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->








														<div class="search-hidden-container"  id="shc-songwriters">
															<h3><a class="expand-btn-17">Songwriters</a></h3>
															<div id="search-hidden-17" class="temp-hidden hide-17">
																<div class="form-column span-5 element-inline">

																	<div class="form-row-full">
																		<label>Songwriter:</label>
										<? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Pharrell)", $search[writer] ); ?>
																	</div><!-- /.form-row-full -->
</div>
	<div class="form-column span-4 element-inline">
																	<div class="form-row-full">
																		<label>Number of Credited Songwriters:</label>
																		<select  name="search[SongwriterCount]">
												<option value="">Any</option>
<? outputSelectValues( array( "1"=>"1", "2"=>"2", "3"=>"3", "4"=>"4", "5+"=>"5+" ), $search["SongwriterCount"] ); ?>
											</select>

																	</div><!-- /.form-row-full -->
	<br />



																</div><!-- /.form-column -->
																<div class="form-column span-4 element-inline">
																	<div class="form-row-full">
<!--																		<label>Credit Type:</label>
																		<select  name="search[CreditType]">
																			<option value="">Any</option>
																	<option>All</option>
<? outputSelectValues( $songwritertypes, $search["CreditType"] ); ?>
																		</select>-->
																	</div><!-- /.form-row-full -->
																	<br/>
																</div><!-- /.form-column -->
																<div class="form-column span-1 element-inline" style="margin-right:0;">
																</div>
																<a class="search-header-clear-section"  id="shc-songwriters-cs">CLEAR SECTION</a>
																<div class="cf"></div>
															</div><!-- /.temp-hidden -->
														</div><!-- /.search-hidden-container -->





														<div class="search-hidden-container"  id="shc-producers">
															<h3><a class="expand-btn-18">Producers</a></h3>
															<div id="search-hidden-18" class="temp-hidden hide-18">
																<div class="form-column span-5 element-inline">

																	<div class="form-row-full">
																		<label>Producer:</label>
<? outputOtherTableAutofillField( "producers", "producer", "(i.e Shampoo Press & Curl, Max Martin)", $search[producer] ); ?>
																	</div><!-- /.form-row-full -->


																</div><!-- /.form-column -->
																<div class="form-column span-4 element-inline">
																	<div class="form-row-full">
																		<label>Number of Credited Producers:</label>
																		<select  name="search[ProducerCount]">
												<option value="">Any</option>
<? outputSelectValues( array( "1"=>"1", "2"=>"2", "3"=>"3", "4"=>"4", "5+"=>"5+" ), $search["ProducerCount"] ); ?>
											</select>
																	</div><!-- /.form-row-full -->
																	<br />
																</div><!-- /.form-column -->
																<div class="form-column span-1 element-inline" style="margin-right:0;">
																</div>
																<a class="search-header-clear-section"  id="shc-producers-cs">CLEAR SECTION</a>
																<div class="cf"></div>
															</div><!-- /.temp-hidden -->
														</div><!-- /.search-hidden-container -->



														<div class="search-hidden-container"  id="shc-recordlabels">
															<h3><a class="expand-btn-19">Record Labels</a></h3>
															<div id="search-hidden-19" class="temp-hidden hide-19">
																<div class="form-column span-5 element-inline">

																	<div class="form-row-full">
															<label>Record Label:</label>
															<select name='search[labelid]'>
																<option value="">Any</option>
							<? outputSelectValuesForOtherTable( "labels", $search["labelid"] ); ?>
															</select>
																	</div><!-- /.form-row-full -->

																</div><!-- /.form-column -->
																<div class="form-column span-4 element-inline">
																	<div class="form-row-full">
<!--																		<label>Number of Credited Record Labels:</label>
																		<select  name="search[LabelCount]">
																			<option value="">Any</option>
<? outputSelectValues( array( "1"=>"1", "2"=>"2" ), $search["LabelCount"] ); ?>
																		</select>-->
																	</div><!-- /.form-row-full -->
																	<br />
																</div><!-- /.form-column -->
																<div class="form-column span-1 element-inline" style="margin-right:0;">
																</div>
																<a class="search-header-clear-section"  id="shc-recordlabels-cs">CLEAR SECTION</a>
																<div class="cf"></div>
															</div><!-- /.temp-hidden -->
														</div><!-- /.search-hidden-container -->














								<div class="search-hidden-container"  id="shc-subgenres">
															<h3><a class="expand-btn-3">Primary Genre & Sub-Genres/Influences</a></h3>
															<div id="search-hidden-3" class="temp-hidden hide-3">
																<div class="form-column span-2 element-inline">
																	<div class="form-row-full">
																 								 <label>Primary Genre:</label>
																 								 <select name='search[GenreID]'>
																 									 <option value="">Any</option>
<? outputSelectValues( $allgenresfordropdown, $search["GenreID"] ); ?>
		 </select>
																  </div><!-- /.form-row-right -->
 <label>Sub-Genres/Influences:</label>
							        <? $subgenres = getTableRowsArray( "subgenres", " and category in ('Rock', '') ", true, true );
							$count = 0;
							$nextcol = "";
							foreach( $subgenres as $key=>$val )
							{
							    $count++;
							    if( $count == 18 )
							    {
							        ob_start();
							    }
							?>

																	<div class="form-row-full">
																		<input type="checkbox" id="sub-<?=$key?>"  <?=checkboxArray( "subgenres", $key, $key )?>> <label class="checkbox-label" for="sub-<?=$key?>"><span></span> <?=$val?></label>
																	</div><!-- /.form-row-full -->
							<?php
							 }

							$nextcol = ob_get_contents();
							ob_end_clean();
							?>

																</div><!-- /.form-column -->
																<div class="form-column span-2 element-inline">
							    <? echo( $nextcol ) ; ?>

																<label>World Influences:</label>
							                                    <? $subgenres = getTableRowsArray( "subgenres", "and category = 'World' ", true, true );
							foreach( $subgenres as $key=>$val )
							{
							?>
																	<div class="form-row-full">
																		<input type="checkbox" id="sub-<?=$key?>"  <?=checkboxArray( "subgenres", $key, $key )?>> <label class="checkbox-label" for="sub-<?=$key?>"><span></span> <?=$val?></label>
																	</div><!-- /.form-row-full -->
							<? } ?>
																</div><!-- /.form-column -->
																<div class="form-column span-2 element-inline" style="margin-right:0;">
																	<label>Time Period Influences:</label>
							    <? $subgenres = getTableRowsArray( "subgenres", "and category = 'Retro' ", true, true );
							foreach( $subgenres as $key=>$val )
							{
							?>
																	<div class="form-row-full">
																		<input type="checkbox" id="sub-<?=$key?>" <?=checkboxArray( "subgenres", $key, $key )?>> <label class="checkbox-label" for="sub-<?=$key?>"><span></span> <?=$val?></label>
																	</div><!-- /.form-row-full -->
							<? } ?>




																</div><!-- /.form-column -->
																<a class="search-header-clear-section"   id="shc-subgenres-cs">CLEAR SECTION</a>
																<div class="cf"></div>
															</div><!-- /.temp-hidden -->
														</div><!-- /.search-hidden-container -->

								<div class="search-hidden-container"  id="shc-instruments">
															<h3><a class="expand-btn-4">Instruments</a></h3>
															<div id="search-hidden-4" class="temp-hidden hide-4">
							    <? $instr = getTableRowsArray( "primaryinstrumentations", "", true, true, " and type = 'Main' " );
							$third = ceil( count( $instr ) / 3 );
							$count = 0;
							$numcols = 0;
							foreach( $instr as $key=>$val )
							{
							    if( !$count )
							    {
							        $numcols++;
							        if( $numcols == 3 )
							            echo( '<div class="form-column span-2 element-inline" style="margin-right:0;">' );
							        else
							            echo( '<div class="form-column span-2 element-inline">' );
							    }
							?>

										<div class="form-row-full">
                                             <input type="checkbox" id="instr-<?=$key?>" <?=checkboxArray( "primaryinstrumentations", $key, $key )?>> <label class="checkbox-label" for="instr-<?=$key?>"><span></span> <?=$val?></label>
										</div><!-- /.form-row-full -->
<?php
                  $count++;
                  if( $count == $third )
                  {
                      $count = 0;
                      echo( "</div>" );
                  }
}
if( $count )
{
    echo( "</div>" );
}
?>
									<a  id="shc-instruments-cs" class="search-header-clear-section">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->


							<div class="search-hidden-container"  id="shc-vocals">
								<h3><a class="expand-btn-2">Vocals</a></h3>
								<div id="search-hidden-2" class="temp-hidden hide-2">
									<div class="form-column span-5 element-inline">

										<div class="form-row-full">
								<label>Lead Vocal Gender:</label>
											<select name='search[vocalsgenderspecific]'>
												<option value="">Any</option>
<?php
//$artisttypes = array( "Female"=> "Female", "Male" => "Male", "Both"=>"Female & Male" );
	           $artisttypes = array( "Female"=> "Female", "Male" => "Male", "Both"=>"Female & Male", "Duet/Group (All Female)"=> "Female Duet/Group", "Duet/Group (All Male)"=> "Male Duet/Group" );
outputSelectValues( $gendertypes, $search["vocalsgenderspecific"] );
?>
											</select>
										</div><!-- /.form-row-full -->
										<div class="form-row-full">
								<label>Solo vs Multiple Lead Vocalists:</label>
											<select name='search[svsmultlead]'>
												<option value="">All</option>
<?php
outputSelectValues( $leadsvsmulttypes, $search["svsmultlead"] );
?>
											</select>

							</div><!-- /.form-row-left -->


										<div class="form-row-full">
											<label>Lead Vocal Delivery Type:</label>
									<select name="search[vocaldelivery]">
										<option value="">Any</option>
<?php
outputSelectValues( $vocaldeliverytypes, $search["vocaldelivery"] );
?>
									</select>
										</div><!-- /.form-row-full -->


										<!--<div class="form-row-full">
											<label>Song Section Contains Sung Lead Vocals:</label>
											<select  name="search[vocals][Sung]">
												<option value="">Any</option>
<? outputSelectValues( $mainsections, $search["vocals"]["Sung"] ); ?>

											</select>
										</div>--><!-- /.form-row-full -->


										<!--<div class="form-row-full">
											<label>Song Section Contains Rapped Lead Vocals</label>
											<select  name="search[vocals][Rapped]">
												<option value="">Any</option>
<? outputSelectValues( $mainsections, $search["vocals"]["Rapped"] ); ?>
											</select>
										</div>--><!-- /.form-row-full -->
										<!--<div class="form-row-full">
											<label> Song Section Contains Spoken Lead Vocals:</label>
											<select name="search[vocals][Spoken]">
												<option value="">Any</option>
<? outputSelectValues( $mainsections, $search["vocals"]["Spoken"] ); ?>
											</select>
										</div>--><!-- /.form-row-full -->
									</div><!-- /.form-column -->
									<div class="form-column span-2 element-inline">
										<label style="margin-bottom:25px;">Song Contains:</label>

										<?php
										    $res = getTableRows( "vocals" );
										    foreach( $res as $tmpr ) {
										    $r = $tmpr[id];
if( !db_query_first_cell( "select count(*) from song_to_vocal where vocalid = $r" ) ) continue;
										    ?>
										<div class="form-row-full">
  											<input type="checkbox" id="vts-<?=$r?>" <?=checkboxArray( "ssvocaltypes", $r, $r )?>> <label class="checkbox-label" for="vts-<?=$r?>"><span></span> <?=$tmpr[Name]?></label> <?php /* <img class="info-icon" title="<?=$tmpr[InfoDescr]?>" src="assets/images/info-icon.svg" border="0" /> */ ?>
  										</div><!-- /.form-row-full -->
										<? } ?>


									</div><!-- /.form-column -->
									<div class="form-column span-1 element-inline" style="margin-right:0;">
									</div>
									<a class="search-header-clear-section"  id="shc-vocals-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->

							<div class="search-hidden-container" id="shc-lyricstitle">
										<h3><a class="expand-btn">Lyrics &amp; Title</a></h3>
										<div id="search-hidden" class="temp-hidden hide">
											<div class="form-column span-2 element-inline">
												<label style="margin-bottom:25px;">Lyrical Themes:</label>
		<? $res = getTableRows( "lyricalthemes" );
		foreach( $res as $r ) { ?>
												<div class="form-row-full">
													<input type="checkbox" id="lyrics-<?=$r[Name]?>"  <?=checkboxArray( "lyricalthemes", $r[id], $r[id] )?> > <label class="checkbox-label" for="lyrics-<?=$r["Name"]?>"><span></span> <?=$r["Name"]?></label> <img class="info-icon" title="<?=$r["InfoDescr"]?>" src="assets/images/info-icon.svg" border="0" />
												</div><!-- /.form-row-full -->
		<? } ?>
											</div><!-- /.form-column -->
											<div class="form-column span-2 element-inline">
												<div class="form-row-full">
													<label>Song Title Appearance Count:</label>
													<select name='search[songtitleappearancecount]'>
														<option value="">Any</option>
											<? outputSelectValuesDistinct( "SongTitleAppearanceRange", $search["songtitleappearancecount"], "SongTitleAppearances" ); ?>

													</select>
												</div><!-- /.form-row-full -->
												<div class="form-row-full">
													<label>Song Title Word Count:</label>
													<select name='search[SongTitleWordCount]'>
														<option value="">Any</option>

		<? outputSelectValues( $stwcvals, $search["SongTitleWordCount"] ); ?>


													</select>
												</div><!-- /.form-row-full -->
											</div><!-- /.form-column -->
											<div class="form-column span-2 element-inline" style="margin-right:0;">
												<label style="margin-bottom:25px;">Song Title Placement:</label>
		<?php
		    $res = getTableRows( "placements", true, "OrderBy desc" );
		foreach( $res as $r ) { ?>
												<div class="form-row-full">
													<input type="checkbox" id="placements-<?=$r[Name]?>"  <?=checkboxArray( "placements", $r[id], $r[id] )?> > <label class="checkbox-label" for="placements-<?=$r["Name"]?>"><span></span> <?=$r["Name"]?></label> <img class="info-icon" title="<?=$r["InfoDescr"]?>" src="assets/images/info-icon.svg" border="0" />
												</div><!-- /.form-row-full -->
		<? } ?>
											</div><!-- /.form-column -->
											<a class="search-header-clear-section" id="shc-lyricstitle-cs">CLEAR SECTION</a>
											<div class="cf"></div>
										</div><!-- /.temp-hidden -->
									</div><!-- /.search-hidden-container -->



											<div class="search-hidden-container"  id="shc-gs">
														<h3><a class="expand-btn-15">General Structure</a></h3>
														<div id="search-hidden-15" class="temp-hidden hide-15">
															<div class="form-column span-8 element-inline">
																	<div class="form-row-left">
																			<label>Song Tempo (bpm) Range:</label>
																			<select name="search[bpm]" style="margin-bottom:5px;">
																				<option value="">Any</option>
																				<? outputSelectValues( $bpmvalues, $search["bpm"] ); ?>
																			</select>
																			<br/>
																			<label class='full'> or Exact: </label><input type='text' name='search[exactbpm]' value='<?=$search["exactbpm"]?>' style="width:100px" >
																</div><!-- /.form-row-right -->
																<div class="form-row-right">
																	<label >Song Length:</label>
																	<select name="search[SongLengthRange]" style="margin-bottom:5px;">
																		<option value="">Any</option>
																		<? outputSelectValuesDistinct( "SongLengthRange", $search["SongLengthRange"], "SongLength" ); ?>
																	</select>
																	<br/>
																	<label class='full'> or Exact: </label><input type='text' name='search[SongLengthExact]' value='<?=$search["SongLengthExact"]?>' style="width:100px" >
															</div><!-- /.form-row-right -->
															<div class="form-row-left">
																<label class='full'>Key:</label>
																<input type='text' name='search[KeyMajor]' id="search-key" value='<?=$search["KeyMajor"]?>' >
															</div><!-- /.form-row-full -->

															<div class="form-row-right">
																<label>Major vs. Minor:</label>
																<select name='search[MajorMinor]'>

																<option value="">All</option>
														<? outputSelectValuesDistinct( "MajorMinor", $search["MajorMinor"], "MajorMinor" ); ?>
																</select>
															</div><!-- /.form-row-full -->

															<div class="form-row-left">
										<label>Form: <em>(Leave Blank For All)</em></label>
										<p>To search for a specific form, please enter it below, be sure to include a hyphen in between sections</p>
  											<input type="text" name="search[fullform]" id="search-fullform" placeholder="(i.e. A-B-A-B-C-B)" onChange='javascript:hideSections( this.value )'>
</div>
																<div class="form-row-right">
																	<label >Time Signature:</label>
																	<select name="search[timesignatureid]" style="margin-bottom:5px;">
																		<option value="">Any</option>
																		<? outputSelectValuesForOtherTable( "timesignatures", $search["timesignatureid"] ); ?>
																	</select>
															</div><!-- /.form-row-right -->
																<br/>
															</div><!-- /.form-column -->

															<div class="form-column span-1 element-inline" style="margin-right:0;">
															</div>
															<a class="search-header-clear-section"  id="shc-gs-cs">CLEAR SECTION</a>
															<div class="cf"></div>
														</div><!-- /.temp-hidden -->
													</div><!-- /.search-hidden-container -->



							<div class="search-hidden-container"  id="container-I">
								<h3><a class="expand-btn-6">Intro</a></h3>
								<div id="search-hidden-6" class="temp-hidden hide-6">
									<div class="form-column span-5 element-inline">
										<div class="form-row-full">
											<label>Contains an Intro<img class="info-icon" title="<?=getCustomHover( "Intro" )?>" src="assets/images/info-icon.svg" border="0" />:</label>
											<select name="search[contains][Intro]" class="container-I">
												<option value="">--</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</div><!-- /.form-row-full -->
										<div class="form-row-full">
											<label>Intro Length:</label>
											<select name="search[introlengthrange]" class="container-I">
												<option value="">Any</option>
<? outputSelectValues( $introlengthsotherway, $search["introlengthrange"] ); ?>
											</select>
										</div><!-- /.form-row-full -->
										<div class="form-row-full">
											<label>Intro % Total Song:</label>
											<select name='search[percentoftotal][Intro]'  class="container-I">
												<option value="">Any</option>
    <? outputSelectValues( $intropercentoftotalsong, $search["percentoftotal"]["Intro"] ); ?>
											</select>
										</div><!-- /.form-row-full -->
										<div class="form-row-full">
											<label>Instrumental/Vocal Category:</label>
											<select name="search[IntroVocalVsInst]"  class="container-I">
												<option value="">Any</option>
<? outputSelectValuesForEnum( "IntroVocalVsInst", $search["IntroVocalVsInst"] );?>
											</select>
										</div><!-- /.form-row-full -->
									</div><!-- /.form-column -->
									<div class="form-column span-2 element-inline">
                                                                        <? $res = getTableRows("introtypes" );
foreach( $res as $r ) { 
if( $r["ishook"] ) continue;
?>
										<div class="form-row-full">
											<input class="container-I" type="checkbox" id="introtypes-<?=$r[Name]?>" <?=checkboxArray( "introtypes", $r[id], $r[id] )?> > <label class="checkbox-label" for="introtypes-<?=$r["Name"]?>"><span></span> <?=$r["Name"]?></label> <img class="info-icon" title="<?=$r["InfoDescr"]?>" src="assets/images/info-icon.svg" border="0" />
										</div><!-- /.form-row-full -->
<? } ?>

									</div><!-- /.form-column -->
									<div class="form-column span-1 element-inline" style="margin-right:0;">
									</div>
									<a class="search-header-clear-section" id="container-I-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->

							<div class="search-hidden-container" id="container-A">
								<h3><a class="expand-btn-7">Verse</a></h3>
								<div id="search-hidden-7" class="temp-hidden hide-7">
									<div class="form-column span-full element-inline" style="margin-right:0">
										<div class="form-row-left">
											<label>Verse <img class="info-icon" title="<?=getCustomHover( "Verse" )?>" src="assets/images/info-icon.svg" border="0" /> Section Count: </label>
											<select class="container-A" name="search[sectioncounts][Verse]">
												<option value="">--</option>
    <? outputSelectValues( getFiveValuesSection( "Verse" ), $search["sectioncounts"]["Verse"] ); ?>
											</select>
										</div><!-- /.form-row-left -->
										<div class="form-row-right">
											<label>Verse Length Uniformity:</label>
											<select class="container-A" name="search[uniformity][Verse]">
												<option value="">Any</option>
    <? outputSelectValues( getLengthUniformity( "Verse" ), $search["uniformity"]["Verse"] ); ?>

											</select>
										</div><!-- /.form-row-right -->
										<div class="cf"></div>
										<div class="form-row-left">
											<label>Verse % Of Total Song:</label>
											<select class="container-A" name='search[percentoftotal][Verse]'>
												<option value="">Any</option>
    <? outputSelectValues( $percentoftotalsong, $search["percentoftotal"]["Verse"] ); ?>
											</select>
										</div><!-- /.form-row-full -->
										<div class="form-row-right">
											<input class="container-B" type="checkbox" id="brkverse-contains" <?=checkboxArray( "bdfield", "Verse", "Verse" )?> > <label class="checkbox-label" for="brkverse-contains"><span></span> Contains Breakdown Verse</label> <img class="info-icon" title="<?=getCustomHover( "Contains Breakdown Verse" )?>" src="assets/images/info-icon.svg" border="0" />
										</div><!-- /.form-row-right -->
										<div class="cf"></div>
									</div><!-- /.form-column -->
									<a class="search-header-clear-section"  id="container-A-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->

							<div class="search-hidden-container" id="container-PC">
								<h3><a class="expand-btn-8">Pre-Chorus</a></h3>
								<div id="search-hidden-8" class="temp-hidden hide-8">
									<div class="form-column span-full element-inline" style="margin-right:0">
										<div class="form-row-left">
											<label>Pre-Chorus <img class="info-icon" title="<?=getCustomHover( "Pre-Chorus" )?>" src="assets/images/info-icon.svg" border="0" /> Section Count:</label>
											<select class="container-PC" name="search[sectioncounts][Pre-Chorus]">
												<option value="">--</option>
    <? outputSelectValues( getFiveValuesSection( "Pre-Chorus" ), $search["sectioncounts"]["Pre-Chorus"] ); ?>
											</select>
										</div><!-- /.form-row-left -->
										<div class="form-row-right">
											<label>Pre-Chorus Length Uniformity:</label>
											<select class="container-PC" name="search[uniformity][Pre-Chorus]">
												<option value="">Any</option>
    <? outputSelectValues( getLengthUniformity( "Pre-Chorus" ), $search["uniformity"]["Pre-Chorus"] ); ?>

											</select>
										</div><!-- /.form-row-right -->
										<div class="cf"></div>
										<div class="form-row-left">
											<label>Pre-Chorus % Of Total Song:</label>
											<select class="container-PC" name='search[percentoftotal][Pre-Chorus]'>
												<option value="">Any</option>
    <? outputSelectValues( $prechoruspercentoftotalsong, $search["percentoftotal"]["Pre-Chorus"] ); ?>
											</select>
										</div><!-- /.form-row-full -->
										<div class="form-row-right">
											<input class="container-B" type="checkbox" id="brkpchorus-contains" <?=checkboxArray( "bdfield", "Pre-Chorus", "Pre-Chorus" )?>> <label class="checkbox-label" for="brkpchorus-contains"><span></span> Contains Breakdown Pre-Chorus</label> <img class="info-icon" title="<?=getCustomHover( "Contains Breakdown Pre-Chorus" )?>" src="assets/images/info-icon.svg" border="0" />
										</div><!-- /.form-row-right -->


									</div><!-- /.form-column -->
									<a class="search-header-clear-section"  id="container-PC-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->

							<div class="search-hidden-container" id="container-B">
								<h3><a class="expand-btn-9">Chorus</a></h3>
								<div id="search-hidden-9" class="temp-hidden hide-9">
									<div class="form-column span-full element-inline" style="margin-right:0">
										<div class="form-row-left">
											<label>Chorus  <img class="info-icon" title="<?=getCustomHover( "Chorus" )?>" src="assets/images/info-icon.svg" border="0" /> Section Count:</label>
											<select class="container-B" name="search[sectioncounts][Chorus]">
												<option value="">--</option>
    <? outputSelectValues( getFiveValuesSection( "Chorus" ), $search["sectioncounts"]["Chorus"] ); ?>
											</select>
										</div><!-- /.form-row-left -->
										<div class="form-row-right">
											<label>Chorus % Of Total Song:</label>
											<select class="container-B" name='search[percentoftotal][Chorus]'>
												<option value="">Any</option>
    <? outputSelectValues( $percentoftotalsong, $search["percentoftotal"]["Chorus"] ); ?>
											</select>
										</div><!-- /.form-row-right -->
										<div class="cf"></div>
										<div class="form-row-left">
											<label>1st Chorus Occurence (Time Into song):</label>
											<select class="container-B" name="search[FirstChorusDescr]">
												<option value="">Any</option>
    <? outputSelectValues( $firstchorustime, $search["FirstChorusDescr"] ); ?>
    </select>
										</div><!-- /.form-row-left -->
										<div class="form-row-right">
											<label>1st Chorus Occurence (% Into Song):</label>
											<select class="container-B" name="search[FirstChorusPercentRange]">
												<option value="">Any</option>
    <? outputSelectValues( $firstchoruspercents, $search["FirstChorusPercentRange"] ); ?>

											</select>
										</div><!-- /.form-row-right -->
										<div class="cf"></div>
										<div class="form-row-left">
											<label>Chorus Length Uniformity:</label>
											<select class="container-B" name="search[uniformity][Chorus]">
												<option value="">Any</option>
    <? outputSelectValues( getLengthUniformity( "Chorus" ), $search["uniformity"]["Chorus"] ); ?>

											</select>
										</div><!-- /.form-row-left -->
										<div class="form-row-right">
											<label>Chorus Precedes Verse:</label>
											<select name="search[ChorusPrecedesVerse]" class="container-I">
												<option value="">--</option>
    <option <?=$search[ChorusPrecedesVerse]>0?"SELECTED":""?> value="1">Yes</option>
    <option <?=$search[ChorusPrecedesVerse]<0?"SELECTED":""?> value="-1">No</option>
											</select>

										</div><!-- /.form-row-right -->
										<div class="cf"></div>
    <div class="form-row-left">
											<input class="container-B" type="checkbox" id="brkchorus-contains" <?=checkboxArray( "bdfield", "Chorus", "Chorus" )?>> <label class="checkbox-label" for="brkchorus-contains"><span></span> Contains Breakdown Chorus</label> <img class="info-icon" title="<?=getCustomHover( "Contains Breakdown Chorus" )?>" src="assets/images/info-icon.svg" border="0" />
										</div><!-- /.form-row-left -->
										<div class="form-row-right"><!--
    <input class="container-B" type="checkbox" id="bigchorus-contains" name="search[bpchorus]" <?=$search[bpchorus]=="4"?"CHECKED":"" ?> value="4"> <label class="checkbox-label" for="bigchorus-contains"><span></span> Contains High Impact Chorus</label> <img class="info-icon" title="<?=getCustomHover( "Contains High Impact Chorus" )?>" src="assets/images/info-icon.svg" border="0" />-->
										</div><!-- /.form-row-right -->
										<div class="cf"></div>
									</div><!-- /.form-column -->
									<a class="search-header-clear-section"  id="container-B-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->

							<div class="search-hidden-container"  id="container-PC">
								<h3><a class="expand-btn-14">Post-Chorus</a></h3>
								<div id="search-hidden-14" class="temp-hidden hide-14">
									<div class="form-column span-full element-inline" style="margin-right:0">
										<div class="form-row-left">
											<label>Post-Chorus <img class="info-icon" title="<?=getOrCreateCustomHover( "Post-Chorus", "Post-Chorus" )?>" src="assets/images/info-icon.svg" border="0" /> Section Count:</label>
											<select class="container-C" id="postchoruscount" name="search[sectioncounts][PostChorus]">
												<option value="">--</option>
    <? outputSelectValues( getFiveValuesSection( "Post-Chorus" ), $search["sectioncounts"]["PostChorus"] ); ?>
											</select>
										</div><!-- /.form-row-left -->
 <!-- /.form-row-right -->

										<div class="form-row-right">
											<label>Post-Chorus Section:</label>
											<select class="container-C" id="bridgepercent" name='search[postchorussections]'>
												<option value="">Any</option>
<?php
        $fs = $mainsections;
unset( $fs["Pre-Chorus"] );
unset( $fs["Intro"] );
unset( $fs["Chorus"] );
                 outputSelectValues( $fs, $search["postchorussections"] ); ?>


											</select>
										</div><!-- /.form-row-left -->
 <!-- /.form-row-right -->
										<div class="cf"></div>
										<div class="form-row-left">

                     <? $res = getTableRows("postchorustypes", false );
foreach( $res as $r ) { ?>
										<div class="form-row-full">
											<input class="container-I" type="checkbox" id="postchorustypes-<?=$r[Name]?>" <?=checkboxArray( "postchorustypes", $r[id], $r[id] )?> > <label class="checkbox-label" for="postchorustypes-<?=$r["Name"]?>"><span></span> <?=$r["Name"]?></label> <img class="info-icon" title="<?=$r["InfoDescr"]?>" src="assets/images/info-icon.svg" border="0" />
										</div><!-- /.form-row-full -->
<? } ?>



                     </div><!-- /.form-row-left -->


									</div><!-- /.form-column -->
									<a class="search-header-clear-section"  id="container-C">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->


							<div class="search-hidden-container"  id="container-BS">
								<h3><a class="expand-btn-10">Bridge / Bridge Surrogate</a></h3>
								<div id="search-hidden-10" class="temp-hidden hide-10">
									<div class="form-column span-full element-inline" style="margin-right:0">
<!--										<div class="form-row-left">
											<input class="container-C" type="checkbox" id="bridge-contains" <?=checkboxArray( "containssection", "Bridge", "Bridge" )?> > <label class="checkbox-label" for="bridge-contains"><span></span> Contains a Bridge</label>
										</div>--><!-- /.form-row-left -->
										<!-- <div class="form-row-right">
											<input type="checkbox" id="bridgesurr-contains" <?=checkboxArray( "containssection", "Bridge Surrogate", "Bridge Surrogate" )?> > <label class="checkbox-label" for="bridgesurr-contains"><span></span> Contains a Bridge Surrogate</label>  <img class="info-icon" title="<?=getCustomHover( "Bridge Surrogate" )?>" src="assets/images/info-icon.svg" border="0" />
										</div> --><!-- /.form-row-right -->
										<!--<div class="circle element-inline">-or-</div>
										<div class="cf"></div> -->
										<div class="form-row-left">
											<label>Bridge Section Count <img class="info-icon" title="<?=getCustomHover( "Bridge" )?>" src="assets/images/info-icon.svg" border="0" />:</label>
											<select class="container-C" id="bridgecount" name="search[sectioncounts][Bridge]">
												<option value="">--</option>
    <? outputSelectValues( getFiveValuesSection( "Bridge" ), $search["sectioncounts"]["Bridge"] ); ?>
											</select>
										</div><!-- /.form-row-left -->

										<div class="form-row-right">
											<label>Bridge Surrogate Section Count <img class="info-icon" title="<?=getCustomHover( "Bridge Surrogate" )?>" src="assets/images/info-icon.svg" border="0" />:</label>
											<select class="container-C" id="bridgecount" name="search[sectioncounts][BridgeSurrogate]">
												<option value="">--</option>
    <? outputSelectValues( getFiveValuesSection( "Bridge Surrogate" ), $search["sectioncounts"]["BridgeSurrogate"] ); ?>
											</select>
										</div><!-- /.form-row-right -->
<!--										<div class="form-row-right">
											<label>Bridge Surrogate Section Count:</label>
											<select class="container-C" name="search[BridgeSurrCount]">
												<option value="">--</option>
    <? // outputSelectValues( getFiveValuesSection( "Bridge Surrogate" ), $search["BridgeSurrCount"] ); ?>
											</select>
										</div> --> <!-- /.form-row-right -->
<!--										<div class="cf"></div>-->
										<div class="form-row-left">
											<label>Bridge % of Total Song:</label>
											<select class="container-C" id="bridgepercent" name='search[percentoftotal][Bridge]'>
												<option value="">Any</option>
    <? outputSelectValues( $prechoruspercentoftotalsong, $search["percentoftotal"]["Bridge"] ); ?>
											</select>
										</div>

										<div class="form-row-right">
											<label>Bridge Surrogate % of Total Song:</label>
											<select class="container-C" id="bridgepercent" name='search[percentoftotal][BridgeSurrogate]'>
												<option value="">Any</option>
		<? outputSelectValues( $prechoruspercentoftotalsong, $search["percentoftotal"]["BridgeSurrogate"] ); ?>
											</select>
										</div>

										<div class="form-row-right" style="float:right;">
											<label>Bridge Surrogate Sections</label>
											<select class="container-C" id="bridgecount" name="search[bridgesurrogatesections]">
												<option value="">--</option>
														<option value="Verse">Verse</option>
														<option value="Pre-Chorus">Pre-Chorus</option>
														<option value="Chorus">Chorus</option>
														<option value="Vocal Break">Vocal Break</option>
														<option value="Instrumental Break">Instrumental Break</option>
														<option value="Turnaround">Turnaround</option>
											</select>
										</div>
										<!-- /.form-row-left -->
<!-- /.form-row-right -->
										<div class="cf"></div>
									</div><!-- /.form-column -->
									<a class="search-header-clear-section"  id="container-C">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->



							<div class="search-hidden-container"  id="container-IB">
								<h3><a class="expand-btn-11">Instrumental / Vocal Break</a></h3>
								<div  id="search-hidden-11" class="temp-hidden hide-11">
									<div class="form-column span-full element-inline" style="margin-right:0">
<!--										<div class="form-row-left">
											<input class="container-IB" type="checkbox" id="ins-ins" <?=checkboxArray( "containssection", "Inst Break", "Inst Break" )?> > <label class="checkbox-label" for="ins-ins"><span></span> Contains an Instrumental Break</label> <img class="info-icon" title="<?=getCustomHover( "Instrumental Break" )?>" src="assets/images/info-icon.svg" border="0" />
										</div>--><!-- /.form-row-left -->
<!--										<div class="form-row-right">
											<input class="container-IB" type="checkbox" id="ins-vocal"  <?=checkboxArray( "containssection", "Vocal Break", "Vocal Break" )?> > <label class="checkbox-label" for="ins-vocal"><span></span> Contains a Vocal Break</label> <img class="info-icon" title="<?=getCustomHover( "Vocal Break" )?>" src="assets/images/info-icon.svg" border="0" />
										</div>--> <!-- /.form-row-right -->
										<div class="cf"></div>
										<div class="form-row-left">
											<label>Instrumental Break <img class="info-icon" title="<?=getCustomHover( "Instrumental Break" )?>" src="assets/images/info-icon.svg" border="0" /> Count:</label>
											<select class="container-IB" name="search[sectioncounts][Inst Break]">
												<option value="">--</option>
    <? outputSelectValues( getFiveValuesSection( "Instrumental Break" ), $search["sectioncounts"]["Inst Break"] ); ?>
											</select>
										</div><!-- /.form-row-left -->
										<div class="form-row-right">
											<label>Vocal Break <img class="info-icon" title="<?=getCustomHover( "Vocal Break" )?>" src="assets/images/info-icon.svg" border="0" /> Count:</label>
											<select class="container-VB" name="search[sectioncounts][Vocal Break]">
												<option value="">--</option>
    <? outputSelectValues( getFiveValuesSection( "Vocal Break" ), $search["sectioncounts"]["Vocal Break"] ); ?>
											</select>
										</div><!-- /.form-row-right -->
										<div class="form-row-left">
											<label>Instrumental Break % Of Total Song:</label>
											<select class="container-IB" name="search[percentoftotal][Inst Break]">
												<option value="">--</option>
    <? outputSelectValues( $prechoruspercentoftotalsong, $search["percentoftotal"]["Inst Break"] ); ?>
											</select>
										</div><!-- /.form-row-left -->
										<div class="form-row-right">
											<label>Vocal Break % Of Total Song::</label>
											<select class="container-VB" name="search[percentoftotal][Vocal Break]">
												<option value="">--</option>
    <? outputSelectValues( $prechoruspercentoftotalsong, $search["percentoftotal"]["Vocal Break"] ); ?>
											</select>
										</div><!-- /.form-row-right -->
										<div class="cf"></div>
										<div class="form-row-left">
											<input class="container-IB" type="checkbox" id="brkib-contains"  <?=checkboxArray( "bdfield", "Inst Break", "Inst Break" )?> > <label class="checkbox-label" for="brkib-contains"><span></span> Contains Breakdown Instrumental Break</label> <img class="info-icon" title="<?=getCustomHover( "Contains Breakdown Instrumental Break" )?>" src="assets/images/info-icon.svg" border="0" />
										</div><!-- /.form-row-right -->
										<div class="form-row-right">
											<input class="container-VB" type="checkbox" id="brkvb-contains"  <?=checkboxArray( "bdfield", "Vocal Break", "Vocal Break" )?> > <label class="checkbox-label" for="brkvb-contains"><span></span> Contains Breakdown Vocal Break</label> <img class="info-icon" title="<?=getCustomHover( "Contains Breakdown Vocal Break" )?>" src="assets/images/info-icon.svg" border="0" />
										</div><!-- /.form-row-right -->


										<label>Instrumental Break Dominant Instrument:</label><br>

											    <? $instr = getTableRowsArray( "instruments", "", false, true, " and type in ( select id from songsections where name like 'Inst. Break%' ) " );
											$third = ceil( count( $instr ) / 4 );
											$count = 0;
											foreach( $instr as $key=>$val )
											{
											    if( !$count )
											    {
											            echo( '<div class="form-column element-inline span-1" style="margin-bottom:0;">' );
											    }
											?>

										<div class="form-row-full">
											<input class="container-IB" type="checkbox" id="instrPI-<?=$key?>"  <?=checkboxArray( "instbrkpi", $key, $key )?> > <label class="checkbox-label" for="instrPI-<?=$key?>"><span></span> <?=$val?></label>
										</div><!-- /.form-row-full -->
											<?php
											                  $count++;
											    if( $count == $third )
											    {
											        $count = 0;
											        echo( "</div>" );
											    }
											}
											if( $count )
											{
											    echo( "</div>" );
											}
											?>

									</div><!-- /.form-column -->
									<a class="search-header-clear-section"  id="container-IB-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->
<!-- I think outro always has to show -->
							<div class="search-hidden-container"  id="container-O">
								<h3><a class="expand-btn-12">Outro</a></h3>
								<div id="search-hidden-12" class="temp-hidden hide-12">
									<div class="form-column span-4 element-inline">
										<div class="form-row-full">
											<label>Contains an Outro<img class="info-icon" title="<?=getCustomHover( "Outro" )?>" src="assets/images/info-icon.svg" border="0" />:</label>
											<select name="search[contains][Outro]" class="container-I">
												<option value="">--</option>
    <option <?=$search[contains][Outro]=="Yes"?"SELECTED":""?> value="Yes">Yes</option>
												<option <?=$search[contains][Outro]=="No"?"SELECTED":""?> value="No">No</option>
											</select>
										</div><!-- /.form-row-full -->
										<div class="form-row-full">
											<label>Outro Length (Time):</label>
											<select class="container-O" name="search[OutroRange]">
												<option value="">Any</option>
<? outputSelectValues( $introlengthsotherway, $search["OutroRange"] ); ?>
								</select>
										</div><!-- /.form-row-full -->
										<div class="form-row-full">
											<label>Outro % Of Total Song:</label>
											<select class="container-O" name='search[percentoftotal][Outro]'>
												<option value="">Any</option>
    <? outputSelectValues( $intropercentoftotalsong, $search["percentoftotal"]["Outro"] ); ?>
											</select>
										</div><!-- /.form-row-full -->
										<div class="form-row-full">
											<label>Recycled vs. New Material<img class="info-icon" title="<?=getCustomHover( "Recycled Vs. New Material" )?>" src="assets/images/info-icon.svg" border="0" />:</label>
											<select name="search[OutroRecycled]">
												<option value="">Any</option>
												<? outputSelectValuesForEnum( "OutroRecycled", $search["OutroRecycled"] ); ?>
											</select>
										</div><!-- /.form-row-full -->
										<div class="form-row-full">
											<label>Instrumental/Vocal:</label>
											<select name="search[OutroVocalVsInst]">
												<option value="">Any</option>
												<? outputSelectValuesForEnum( "OutroVocalVsInst", $search["OutroVocalVsInst"] ); ?>
											</select>
										</div><!-- /.form-row-full -->
									</div><!-- /.form-column -->
									<div class="form-column span-2 element-inline">
											<label>Outro Characteristics:</label>

                                                                        <? $res = getTableRows("outrotypes" );
foreach( $res as $r ) { ?>
										<div class="form-row-full">
											<input class="container-I" type="checkbox" id="outrotypes-<?=$r[Name]?>"  <?=checkboxArray( "outrotypes", $r[id], $r[id] )?> ?> <label class="checkbox-label" for="outrotypes-<?=$r["Name"]?>"><span></span> <?=$r["Name"]?></label> <img class="info-icon" title="<?=$r["InfoDescr"]?>" src="assets/images/info-icon.svg" border="0" />
										</div><!-- /.form-row-full -->
<? } ?>

    </div><!-- /.form-column -->
									<div class="form-column span-1 element-inline" style="margin-right:0;">
									</div>
									<a class="search-header-clear-section" id="container-O-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->



							</div><!-- /.search-hidden-container -->



							<div class="search-hidden-container search-hidden-container-last"  id="container-O">
								<h3><a class="expand-btn-13">Ending</a></h3>
								<div id="search-hidden-13" class="temp-hidden hide-13">
									<div class="form-column span-4 element-inline">

										<div class="form-row-full">
											<label>Ending Type:</label>
<?php
    $res = getTableRows( "endingtypes", false );
foreach( $res as $r ) { ?>
										<div class="form-row-full">
											<input type="checkbox" id="endingtypes-<?=$r[Name]?>"  <?=checkboxArray( "endingtypes", $r[id], $r[id] )?> > <label class="checkbox-label" for="endingtypes-<?=$r["Name"]?>"><span></span> <?=$r["Name"]?></label> <img class="info-icon" title="<?=$r["InfoDescr"]?>" src="assets/images/info-icon.svg" border="0" />
										</div><!-- /.form-row-full -->
<? } ?>
										</div><!-- /.form-row-full -->

									</div><!-- /.form-column -->
									<a class="search-header-clear-section" id="container-O-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->

							<div class="form-row-left">

							</div><!-- /.form-row-left -->
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
		$(document).ready(function(){
		    $("a.expand-btn").click(function(){
		        $("a.expand-btn").toggleClass("collapse-btn");
		        $("#search-hidden").toggleClass("hide show");
		    });
		     $("a.expand-btn-2").click(function(){
		        $("a.expand-btn-2").toggleClass("collapse-btn-2");
		        $("#search-hidden-2").toggleClass("hide-2 show-2");
		    });
		     $("a.expand-btn-3").click(function(){
		        $("a.expand-btn-3").toggleClass("collapse-btn-3");
		        $("#search-hidden-3").toggleClass("hide-3 show-3");
		    });
		      $("a.expand-btn-4").click(function(){
		        $("a.expand-btn-4").toggleClass("collapse-btn-4");
		        $("#search-hidden-4").toggleClass("hide-4 show-4");
		    });
		      $("a.expand-btn-5").click(function(){
		        $("a.expand-btn-5").toggleClass("collapse-btn-5");
		        $("#search-hidden-5").toggleClass("hide-5 show-5");
		    });
		        $("a.expand-btn-6").click(function(){
		        $("a.expand-btn-6").toggleClass("collapse-btn-6");
		        $("#search-hidden-6").toggleClass("hide-6 show-6");
		    });
		        $("a.expand-btn-7").click(function(){
		        $("a.expand-btn-7").toggleClass("collapse-btn-7");
		        $("#search-hidden-7").toggleClass("hide-7 show-7");
		    });
		        $("a.expand-btn-8").click(function(){
		        $("a.expand-btn-8").toggleClass("collapse-btn-8");
		        $("#search-hidden-8").toggleClass("hide-8 show-8");
		    });
		        $("a.expand-btn-9").click(function(){
		        $("a.expand-btn-9").toggleClass("collapse-btn-9");
		        $("#search-hidden-9").toggleClass("hide-9 show-9");
		    });
		        $("a.expand-btn-10").click(function(){
		        $("a.expand-btn-10").toggleClass("collapse-btn-10");
		        $("#search-hidden-10").toggleClass("hide-10 show-10");
		    });
		        $("a.expand-btn-11").click(function(){
		        $("a.expand-btn-11").toggleClass("collapse-btn-11");
		        $("#search-hidden-11").toggleClass("hide-11 show-11");
		    });
		        $("a.expand-btn-12").click(function(){
		        $("a.expand-btn-12").toggleClass("collapse-btn-12");
		        $("#search-hidden-12").toggleClass("hide-12 show-12");
		    });
		        $("a.expand-btn-13").click(function(){
		        $("a.expand-btn-13").toggleClass("collapse-btn-13");
		        $("#search-hidden-13").toggleClass("hide-13 show-13");
		    });
		        $("a.expand-btn-14").click(function(){
		        $("a.expand-btn-14").toggleClass("collapse-btn-14");
		        $("#search-hidden-14").toggleClass("hide-14 show-14");
		    });
		    		$("a.expand-btn-15").click(function(){
		        $("a.expand-btn-15").toggleClass("collapse-btn-15");
		        $("#search-hidden-15").toggleClass("hide-15 show-15");
		    });
				$("a.expand-btn-16").click(function(){
				$("a.expand-btn-16").toggleClass("collapse-btn-16");
				$("#search-hidden-16").toggleClass("hide-16 show-16");
		});
		$("a.expand-btn-17").click(function(){
		$("a.expand-btn-17").toggleClass("collapse-btn-17");
		$("#search-hidden-17").toggleClass("hide-17 show-17");
});
$("a.expand-btn-18").click(function(){
$("a.expand-btn-18").toggleClass("collapse-btn-18");
$("#search-hidden-18").toggleClass("hide-18 show-18");
});
$("a.expand-btn-19").click(function(){
$("a.expand-btn-19").toggleClass("collapse-btn-19");
$("#search-hidden-19").toggleClass("hide-19 show-19");
});



		});
	</script>

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

   			$('#bridgesurr-contains').click(function(){
			    if ($(this).is(':checked'))
			    {
			      $("#bridgecount").prop('disabled', true);
			      $("#bridgepercent").prop('disabled', true);
			    }
                else
                {
			      $("#bridgecount").prop('disabled', false);
			      $("#bridgepercent").prop('disabled', false);
                }
			  });
            $("#bridgecount").change(function(){
                    if ($(this).prop('selectedIndex') > 0 || $('#bridgepercent').prop('selectedIndex') > 0)
                    {
                        $('#bridgesurr-contains').prop( 'disabled', true );
                    }
                    else
                    {
                        $('#bridgesurr-contains').prop( 'disabled', false );

                    }

                }
                );
            $("#bridgepercent").change(function(){
                    if ($(this).prop('selectedIndex') > 0 || $('#bridgecount').prop('selectedIndex') > 0)
                    {
                        $('#bridgesurr-contains').prop( 'disabled', true );
                    }
                    else
                    {
                        $('#bridgesurr-contains').prop( 'disabled', false );

                    }

                }
                );



   		});
   </script>
<?php include 'footer.php';?>
