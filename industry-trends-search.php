<?php include 'header.php';
include "comparisonfunctions.php";

?>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1><?=getOrCreateCustomTitle( "ITS - TREND COMPARISONS", "TREND COMPARISONS" )?></h1>
						<a class="search-header-clear">CLEAR ALL</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
						<form class="search-form" method='get' action='comparative-search-results.php'>
      <input type='hidden' name='searchtype' value='Comparative'>
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
							<div class="form-row-right">
								<label>Peak Chart Position:</label>
								<select name="search[peakchart]">
									<option value="">Top 10</option>
      <? outputSelectValues( $peakvalues, $search["peakchart"] ); 
outputClientSelectValues( $search["peakchart"] );
?>
								</select>
							</div><!-- /.form-row-right -->
							<div class="cf"></div>
							<div class="form-row-left">
								<label>Search Focus</label>
								<select id="comp-select" name="search[comparisonfilter]" onChange='fixAspect()'>
									<option value="">(Search Focus)</option>
    <? foreach( $possiblecomparisonfilters as $pid=>$pval ) { ?>
      <option <?=$search[comparisonfilter] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                              <? } ?>
								</select>
							</div><!-- /.form-row-left -->
							<div class="form-row-right">
								<label>Search Comparison</label>
								<select id='comp-aspect' name="search[comparisonaspect]">
									<option value="">(Search Comparison)</option>
    <? foreach( $possiblecomparisonaspects as $pid=>$pval ) { ?>
      <option <?=$search[comparisonaspect] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                              <? } ?>
								</select>
							</div><!-- /.form-row-right -->
							<div class="cf"></div>
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
									<a class="search-header-clear-section" id="comp-songwriters-cs">CLEAR SECTION</a>
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
									<a class="search-header-clear-section" id="comp-vocal-cs">CLEAR SECTION</a>
									<div class="cf"></div>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->
							<div class="form-row-left">
							
							</div><!-- /.form-row-right -->
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
				'search[comparisonfilter]': { required: true }
			}
			});
			
			
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