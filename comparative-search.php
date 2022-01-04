<?php include 'header.php';
include "comparisonfunctions.php";

if( !$thetype ) $thetype = "compositional";
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

	.song-title-top .form-row-left .form-row-right
	{
		width: 100%;
		margin-top: 37.5px;
	}

	.song-title-top #fromqerror + .form-row-right {
		margin-top: 24px!important;
	}

	.important-mt {
		margin-top: 24px!important;
	}




		@media (min-width: 767px) {
			#fromqerror {
				margin: 50px 10px 0px;
		}
		#comp-select-error {
			margin-left: 15px;
		}
	}
    
    
    @media (min-width:767px){
.form-row-left-inner, .form-row-right-inner {
    float: left;
    width: 22%;
    margin-bottom: 0;
        }
    label.inner-label {
        box-sizing: border-box;
    width: 8%;
}
    }
</style>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
<? 
$pn = $overpagename?$overpagename:"BENCHMARK TOOL";
?>
    <h1>
<?=getOrCreateCustomTitle( $pn . " - Benchmark Tool", $pn )?>
                                     </h1>
						<h2>
<?php
if( $overpagename == "STAYING POWER" ) {
	$cust = getCustomHover( "trend-search-staying-power" );
}
else
{
	$cust = getCustomHover( "comparative-search" );
}
?>
<?=$cust?>
</h2>
						<a class="search-header-clear">CLEAR ALL</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
						<form class="search-form" method='get' id="compsearchform" name="compsearchform" action='comparative-search-results.php'>
      <input type='hidden' name='searchtype' value='Comparative'>
      <input type='hidden' name='thetype' value='<?=$thetype?>'>
                            
                            
                             <div class="form-row-full">
								<label>Date Range:</label><br/>
								<div id="modified" class="form-row-left-inner">
									<select id="fromq" data-control="datesmustbevalid" name="search[dates][fromq]">
										<option value="">Any</option>
<? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
									</select>
								</div>
								<div class="form-row-right-inner">
									<select data-control="datesmustbevalid" name="search[dates][fromy]">
										<option value="">Any</option>
<? outputSelectValues( $years, $search["dates"]["fromy"] ); ?>
									</select>
								</div>
								<label class="inner-label">- to -</label>
								<div class="form-row-left-inner">
									<select data-control="datesmustbevalid" name="search[dates][toq]">
										<option value="">Any</option>
<? outputSelectValues( $quarters, $search["dates"]["toq"] ); ?>
									</select>
								</div>
								<div class="form-row-right-inner">
									<select data-control="datesmustbevalid" name="search[dates][toy]">
										<option value="">Any</option>
<? outputSelectValues( $years, $search["dates"]["toy"] ); ?>
									</select>
								</div>
                                    <div id="fromqerror"></div>
								<div class="cf"></div>
<? if( 1 == 0 ) { ?>
							<!--<div class="form-row-left">
								<label>Season:</label><br/>
								<div id="modified" class="form-row-left-inner">
									<select id="season" name="search[dates][season]">
										<option value="">Any</option>
<?php
outputSelectValues( $seasons, $search["dates"]["season"] ); ?>
									</select>
								</div>
</div>--><? } ?>
								<div class="cf"></div>
                                 <br />
                                 <hr class="sep">


							</div><!-- /.form-row-left -->
<div class="cf"></div>
                            
                            
                            
                            <div class="form-row-left">
								<label>Search Focus</label>
								<select id='comp-aspect' name="search[comparisonaspect]">
									<option value="">(Search Focus)</option>
    <? $tmpcnt = 0; foreach( $possiblecomparisonaspects as $pid=>$pval ) {
    if( $pccounts[$tmpcnt] )
    {
	if( $tmpcnt ) 
	    echo( "</optgroup>\n" );
	echo( "<optgroup label='". $pccounts[$tmpcnt] . "'>\n" );
	
    }
    $tmpcnt++;
 ?>
      <option <?=$search[comparisonaspect] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                              <? } ?>
</optgroup>
								</select>
							</div><!-- /.form-row-right -->
                            
                            <div class="form-row-right">
								<label><?=$overpagename != "STAYING POWER"?"Search Comparison":"Search Criteria"?></label>
								<select id="comp-select" name="search[comparisonfilter]" >
									<option value="">(<?=$overpagename != "STAYING POWER"?"Search Comparison":"Search Criteria"?>)</option>
    <?php
    foreach( $possiblecomparisonfilters as $pid=>$pval ) { ?>
      <option <?=$search[comparisonfilter] == $pid || count( $possiblecomparisonfilters ) == 1 ?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                              <? } ?>
								</select>
							</div><!-- /.form-row-left -->
							<div class="cf"></div>
                            
                            
                            
							
<? if( $overpagename == "STAYING POWER" ) {  ?>
						<div class="form-row-left">
								<label>Primary Genre:</label>
								<select name="genrefilter">
									<option value="">All Primary Genres</option>
								<? outputSelectValues( $allgenresfordropdown, $genrefilter ); ?>


								</select>

					</div><!-- /.form-row-right -->
<? } else { ?>
							<div class="form-row-left">
								<label>Peak Chart Position:</label>
								<select name="search[peakchart]">
									<option value="">Top 10</option>
      <? outputSelectValues( $peakvalues, $search["peakchart"] );
outputClientSelectValues( $search["peakchart"] );
?>
								</select>
							</div><!-- /.form-row-right -->
						<div class="form-row-right">
								<label>Primary Genre:</label>
								<select name="genrefilter">
									<option value="">All Primary Genres</option>
								<? outputSelectValues( $allgenresfordropdown, $genrefilter ); ?>


								</select>

					</div><!-- /.form-row-right -->
<? } ?>
                       
                            
                            <? if( $overpagename == "STAYING POWER" ) {  ?>
						<div class="form-row-right">
								 <label>Specific Performing Artist / Group (Primary or Featured):</label>
      <? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist] ); ?>
					</div><!-- /.form-row-right -->
                            
                            <div class="cf"></div>
                            
                            <div class="form-row-left">
								<label>Specific Songwriter:</label>
      <? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Greg Kurstin)", $search[writer]); ?>
                            </div><!-- /.form-row-right -->
                            
                            <div class="form-row-right">
								 <label>Specific Producer:</label>
<? outputOtherTableAutofillField( "producers", "producer", "(i.e. Ali Payami & Mike Will Made it)", $search[producer] ); ?>
					</div><!-- /.form-row-right -->
                            
                            <div class="cf"></div>
                            
                            <? } ?>

							
							
							
							<div class="comp-hidden comp-hidden-perform hide" id="comp-perform">
								<h3><a class="comp-icon comp-icon-perform">Performing Artist</a></h3>
								<div id="comp-search-hidden" class="temp-hidden">
      <? $i = 0;?>
									<div class="form-row-left">
      <? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist][$i], "", "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
      <? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist][$i], "", "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
                                                                                                                                                   <? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist][$i], "", "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                                                                                                                                                                                                                                                                                <? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist][$i], "", "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
                                                                                                                                                                                                                                                                                                                                                                                                                                             <? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist][$i], "", "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                                                                                                                                                                                                                                                                                                                                                         <? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist][$i], "", "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
                                                                                                                                                   <? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist][$i], "", "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                                                                                                                                                                                                                                                                                <? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist][$i], "", "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
                                                                                                                                                                                                                                                                                                                                                                                                                                             <? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist][$i], "", "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                                                                                                                                                                                                                                                                                                                                                         <? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist][$i], "", "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<a class="search-header-clear-section" id="comp-perform-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->
							<div class="comp-hidden comp-hidden-songwriters hide" id="comp-songwriters">
								<h3><a class="comp-icon comp-icon-songwriters">Songwriters</a></h3>
								<div id="comp-search-hidden" class="temp-hidden">
									<div class="form-row-left">
      <? $i = 0; ?>
                                    <? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Greg Kurstin)", $search[writer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                    <? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Greg Kurstin)", $search[writer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
                                    <? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Greg Kurstin)", $search[writer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                    <? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Greg Kurstin)", $search[writer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
                                    <? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Greg Kurstin)", $search[writer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                    <? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Greg Kurstin)", $search[writer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
                                    <? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Greg Kurstin)", $search[writer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                    <? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Greg Kurstin)", $search[writer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
                                                                                                                                                                                                                                                                                 <? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Greg Kurstin)", $search[writer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <? outputOtherTableAutofillField( "artists", "writer", "(i.e Max Martin, Greg Kurstin)", $search[writer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<a class="search-header-clear-section" id="comp-songwriters-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->



							<div class="comp-hidden comp-hidden-producers hide" id="comp-producers">
								<h3><a class="comp-icon comp-icon-producers">Producers</a></h3>
								<div id="comp-search-hidden" class="temp-hidden">
									<div class="form-row-left">
      <? $i = 0; ?>
                                    <? outputOtherTableAutofillField( "producers", "producer", "(i.e Shampoo Press & Curl, Max Martin)", $search[producer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                    <? outputOtherTableAutofillField( "producers", "producer", "(i.e Shampoo Press & Curl, Max Martin)", $search[producer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
                                    <? outputOtherTableAutofillField( "producers", "producer", "(i.e Shampoo Press & Curl, Max Martin)", $search[producer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                    <? outputOtherTableAutofillField( "producers", "producer", "(i.e Shampoo Press & Curl, Max Martin)", $search[producer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
                                    <? outputOtherTableAutofillField( "producers", "producer", "(i.e Shampoo Press & Curl, Max Martin)", $search[producer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                    <? outputOtherTableAutofillField( "producers", "producer", "(i.e Shampoo Press & Curl, Max Martin)", $search[producer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
                                    <? outputOtherTableAutofillField( "producers", "producer", "(i.e Shampoo Press & Curl, Max Martin)", $search[producer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                    <? outputOtherTableAutofillField( "producers", "producer", "(i.e Shampoo Press & Curl, Max Martin)", $search[producer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
                                    <? outputOtherTableAutofillField( "producers", "producer", "(i.e Shampoo Press & Curl, Max Martin)", $search[producer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
                                                                        <? outputOtherTableAutofillField( "producers", "producer", "(i.e Shampoo Press & Curl, Max Martin)", $search[producer][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<a class="search-header-clear-section" id="comp-producers-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->



							<div class="comp-hidden comp-hidden-record hide" id="comp-record">
								<h3><a class="comp-icon comp-icon-record">Record Labels</a></h3>
								<div id="comp-search-hidden" class="temp-hidden">
									<div class="form-row-left">
      <? $i = 0; ?>
								<select name='search[labelid][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <? outputSelectValuesForOtherTable( "labels", $search["labelid"][$i] ); $i++; ?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[labelid][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <? outputSelectValuesForOtherTable( "labels", $search["labelid"][$i] ); $i++; ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
								<select name='search[labelid][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <? outputSelectValuesForOtherTable( "labels", $search["labelid"][$i] ); $i++; ?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[labelid][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <? outputSelectValuesForOtherTable( "labels", $search["labelid"][$i] ); $i++; ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
								<select name='search[labelid][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <? outputSelectValuesForOtherTable( "labels", $search["labelid"][$i] ); $i++; ?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[labelid][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <? outputSelectValuesForOtherTable( "labels", $search["labelid"][$i] ); $i++; ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
								<select name='search[labelid][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <? outputSelectValuesForOtherTable( "labels", $search["labelid"][$i] ); $i++;?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[labelid][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <? outputSelectValuesForOtherTable( "labels", $search["labelid"][$i] ); $i++; ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
								<select name='search[labelid][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <? outputSelectValuesForOtherTable( "labels", $search["labelid"][$i] ); $i++;?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[labelid][<?=$i?>]'>
									<option value="">(Select One)</option>
<? outputSelectValuesForOtherTable( "labels", $search["labelid"][$i++] ); ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<a class="search-header-clear-section" id="comp-record-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->
      <? $i = 0; ?>
							<div class="comp-hidden comp-hidden-primary hide" id="comp-primary">
								<h3><a class="comp-icon comp-icon-primary">Primary Genre</a></h3>
								<div id="comp-search-hidden" class="temp-hidden">
									<div class="form-row-left">
								<select name='search[GenreID][<?=$i?>]'>
									<option value="">(Select One)</option>
                                <? outputSelectValuesForOtherTable( "genres", $search["GenreID"][$i] ); $i++; ?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[GenreID][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                        <? outputSelectValuesForOtherTable( "genres", $search["GenreID"][$i] ); $i++;?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
								<select name='search[GenreID][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                           <? outputSelectValuesForOtherTable( "genres", $search["GenreID"][$i] );$i++;  ?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[GenreID][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                           <? outputSelectValuesForOtherTable( "genres", $search["GenreID"][$i] ); $i++; ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
								<select name='search[GenreID][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                           <? outputSelectValuesForOtherTable( "genres", $search["GenreID"][$i] ); $i++ ;?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[GenreID][<?=$i?>]'>
									<option value="">(Select One)</option>
									<? outputSelectValuesForOtherTable( "genres", $search["GenreID"][$i] ); $i++ ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
								<select name='search[GenreID][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                           <? outputSelectValuesForOtherTable( "genres", $search["GenreID"][$i] );$i++;  ?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[GenreID][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                           <? outputSelectValuesForOtherTable( "genres", $search["GenreID"][$i] ); $i++; ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
								<select name='search[GenreID][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                           <? outputSelectValuesForOtherTable( "genres", $search["GenreID"][$i] ); $i++ ;?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[GenreID][<?=$i?>]'>
									<option value="">(Select One)</option>
									<? outputSelectValuesForOtherTable( "genres", $search["GenreID"][$i] ); $i++ ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<a class="search-header-clear-section" id="comp-primary-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->
							<div class="comp-hidden comp-hidden-vocal hide" id="comp-vocal">
								<h3><a class="comp-icon comp-icon-vocal">Vocal Gender</a></h3>
                                                                            <? $i = 0; ?>
								<div id="comp-search-hidden" class="temp-hidden">
									<div class="form-row-left">
								<select name='search[vocalsgender][<?=$i?>]'>
									<option value="">(Select One)</option>
                                                                            <? outputSelectValuesForEnum( "VocalsGender", $search["vocalsgender"][$i] ); $i++;?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[vocalsgender][<?=$i?>]'>
									<option value="">(Select One)</option>
									<? outputSelectValuesForEnum( "VocalsGender", $search["vocalsgender"][$i] ); ?>
                                <? $i++; ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
								<select name='search[vocalsgender][<?=$i?>]'>
									<option value="">(Select One)</option>
									<? outputSelectValuesForEnum( "VocalsGender", $search["vocalsgender"][$i] ); ?>
                                <? $i++; ?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[vocalsgender][<?=$i?>]'>
									<option value="">(Select One)</option>
									<? outputSelectValuesForEnum( "VocalsGender", $search["vocalsgender"][$i] ); ?>
                                <? $i++; ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
								<select name='search[vocalsgender][<?=$i?>]'>
									<option value="">(Select One)</option>
									<? outputSelectValuesForEnum( "VocalsGender", $search["vocalsgender"][$i] ); ?>
                                <? $i++; ?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[vocalsgender][<?=$i?>]'>
									<option value="">(Select One)</option>
									<? outputSelectValuesForEnum( "VocalsGender", $search["vocalsgender"][$i] ); ?>
                                <? $i++; ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
								<select name='search[vocalsgender][<?=$i?>]'>
									<option value="">(Select One)</option>
									<? outputSelectValuesForEnum( "VocalsGender", $search["vocalsgender"][$i] ); ?>
                                <? $i++; ?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[vocalsgender][<?=$i?>]'>
									<option value="">(Select One)</option>
									<? outputSelectValuesForEnum( "VocalsGender", $search["vocalsgender"][$i] ); ?>
                                <? $i++; ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
								<select name='search[vocalsgender][<?=$i?>]'>
									<option value="">(Select One)</option>
									<? outputSelectValuesForEnum( "VocalsGender", $search["vocalsgender"][$i] ); ?>
                                <? $i++; ?>
								</select>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
								<select name='search[vocalsgender][<?=$i?>]'>
									<option value="">(Select One)</option>
									<? outputSelectValuesForEnum( "VocalsGender", $search["vocalsgender"][$i] ); ?>
                                <? $i++; ?>
								</select>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<a class="search-header-clear-section" id="comp-vocal-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->

							<div class="comp-hidden comp-hidden-songs hide" id="comp-songs">
								<h3><a class="comp-icon comp-icon-songs">Song</a></h3>
                                                                            <? $i = 0; ?>
								<div id="comp-search-hidden" class="temp-hidden">
									<div class="form-row-left">
<? outputOtherTableAutofillField( "songnames", "songname", "(i.e Hello, Hotline Bling)", $search[songname][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
<? outputOtherTableAutofillField( "songnames", "songname", "(i.e Hello, Hotline Bling)", $search[songname][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
<? outputOtherTableAutofillField( "songnames", "songname", "(i.e Hello, Hotline Bling)", $search[songname][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-left -->
									<div class="form-row-right">
<? outputOtherTableAutofillField( "songnames", "songname", "(i.e Hello, Hotline Bling)", $search[songname][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<div class="form-row-left">
<? outputOtherTableAutofillField( "songnames", "songname", "(i.e Hello, Hotline Bling)", $search[songname][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="form-row-right">
<? outputOtherTableAutofillField( "songnames", "songname", "(i.e Hello, Hotline Bling)", $search[songname][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="form-row-left">
<? outputOtherTableAutofillField( "songnames", "songname", "(i.e Hello, Hotline Bling)", $search[songname][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="form-row-right">
<? outputOtherTableAutofillField( "songnames", "songname", "(i.e Hello, Hotline Bling)", $search[songname][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="form-row-left">
<? outputOtherTableAutofillField( "songnames", "songname", "(i.e Hello, Hotline Bling)", $search[songname][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="form-row-right">
<? outputOtherTableAutofillField( "songnames", "songname", "(i.e Hello, Hotline Bling)", $search[songname][$i], '', "[{$i}]" ); $i++; ?>
									</div><!-- /.form-row-right -->
									<div class="cf"></div>
									<a class="search-header-clear-section" id="comp-songs-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->
				


							<div class="form-row-left">
							<input type="submit" id="submitbutton" name="submitbutton" value="SEARCH" />
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
		    if ($("#comp-select").val() == "Producers") {
		       $('.comp-hidden-producers').removeClass('hide').addClass('show');
		    }
		    else {
		       $('.comp-hidden-producers').removeClass('show').addClass('hide');
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
		    if ($("#comp-select").val() == "Songs") {
		       $('.comp-hidden-songs').removeClass('hide').addClass('show');
		    }
		    else {
		       $('.comp-hidden-songs').removeClass('show').addClass('hide');
		    }
		    fixAspect();	    
		});

// to refill existing choices
$( document ).ready(function() {
        $("#comp-select").change();
    });



	</script>
    <script>
		jQuery(document).ready(function($){

		$.validator.setDefaults({
			errorElement: 'div',

		});
        $.validator.addMethod("datesmustbevalid", function(value, element) {
                $("#fromqerror").html( "" );
                var datefrom = "";
                var datefromy = "";
                var dateto = "";
                var datetoy = "";
//                alert( element.name );
                for( i = 0; i < document.forms["compsearchform"].elements.length; i++ )
                {
                    if( document.forms["compsearchform"].elements[i].name == "search[dates][fromq]" )
                        datefrom = document.forms["compsearchform"].elements[i].value;
                    if( document.forms["compsearchform"].elements[i].name == "search[dates][fromy]" )
                        datefromy = document.forms["compsearchform"].elements[i].value;
                    if( document.forms["compsearchform"].elements[i].name == "search[dates][toq]" )
                        dateto = document.forms["compsearchform"].elements[i].value;
                    if( document.forms["compsearchform"].elements[i].name == "search[dates][toy]" )
                        datetoy = document.forms["compsearchform"].elements[i].value;
                }
//               alert( datefrom + ", " + dateto + ", " + datefromy + ", " + datetoy );
                if( datefrom > "" && datefromy > "" && dateto == "" && datetoy == "" ) // only one Q
                {
                    return true;
                }
                else if( datefrom == "" && datefromy == "" && dateto == "" && datetoy == "" ) // no dates entered
                {
                    return true;
                }
                else if( dateto > "" && datetoy == "" ) // only one of the "to" dates
                {
                    return false;
                }
                else if( dateto == "" && datetoy > "" ) // only one of the "to" dates
                {
                    return false;
                }
                else if( datefrom > "" && datefromy == "" ) // only one of the "from" dates
                {
                    return false;
                }
                else if( datefrom == "" && datefromy > "" ) // only one of the "from" dates
                {
                    return false;
                }
                else if( datefrom > "" && datefromy > "" && dateto > "" && datetoy > "" )
                {
                    d1 = new Date( datefromy, datefrom, 1 );
                    d2 = new Date( datetoy, dateto, 1 );
                    return d1 <= d2;
                }

                return false;
            }, "* Please enter a valid date range.");

		$('.search-form').validate({
			onfocusout: false,
			onkeyup: false,
			onclick: false,
			rules: {
				'search[comparisonaspect]': { required: true },
				'search[comparisonfilter]': { required: true },
                  'search[dates][fromq]': { datesmustbevalid: true },
                  'search[dates][toq]': { datesmustbevalid: true },
                  'search[dates][fromy]': { datesmustbevalid: true },
                  'search[dates][toy]': { datesmustbevalid: true },
			},
                    submitHandler: function(form) {
                    form.submit();
                },
                    errorPlacement: function(error, element) {
                    if (element.attr("name") == "search[dates][fromy]" || element.attr("name") == "search[dates][toy]" || element.attr("name") == "search[dates][fromq]" || element.attr("name") == "search[dates][toq]") {

                            // just another example
                        $("#fromqerror").html( error );
                        console.log('silly goose');
                        $('.form-row-right').first().addClass('important-mt');
                    } else {

                            // the default error placement for the rest
                        error.insertAfter(element);
                        console.log('wild hare');

                    }
                }

			});
            });


    $('#submitbutton').on('click', function( e ) {
//            alert( "hmm" );
        e.preventDefault();
        if( $("#compsearchform").valid() )
        {
            $("#compsearchform").submit();
        }
        });

function fixAspect()
{
val = $("#comp-select").val();
//alert( val );
if( val == "Staying Power" || val == "#1 Hits" )
{
	$("#comp-aspect option").filter(function(i, e) { return $(e).text() == "#1 Hits"}).hide();
}
else
{
	$("#comp-aspect option").filter(function(i, e) { return $(e).text() == "#1 Hits"}).show();
}

}

	</script>
<?php include 'footer.php';?>
