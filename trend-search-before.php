<?php include 'header.php';
include "trendfunctions.php";

$thetype = str_replace( ".php", "", $thetype );
$thetype = array_shift( explode( "?", $thetype ) );

if( !$thetype ) $thetype = $searchsubtype;
if( isset( $_GET["graphtype"] ) && $search[dates][toq] == $search[dates][fromq] &&  $search[dates][toy] == $search[dates][fromy] )
{
    $onlyonequarter = true;
}


if( isEssentials() )
{
Header( "Location: index.php?l=1" );
exit;
}


$titles["/compositional-search"] = "Compositional";
$titles["/structure-search"] = "Structure";
$titles["/production-search"] = "Production";
$titles["/lyrical-search"] = "Lyrical";

//print_r( $_SERVER );
$blah = str_replace( ".php", "", $_SERVER[SCRIPT_NAME] );
///echo( $blah ); exit;
$title = strtoupper( $titles[$blah ] );
if( !$title )
    $title = "TREND SEARCH";
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
		/*#comp-select-error {
			margin-left: 15px;
		}*/
	}

			@media (min-width: 767px) {
	.form-row-right.output-wrap{
		margin-top: 32px;
	}
	}
</style>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
			    <h1><?=getOrCreateCustomTitle( "TS: " . $title, $title )?></h1>
						<h2>

<? $cust = getCustomHover( "trend-search-$thetype" );
//$cust2 = str_split( $cust );
// $char = $cust2[251];

// $res = db_query_first_cell( "select count(*) from customhovers where value like '%{$char}%'" );
// //echo( $res );

// db_query( "update customhovers set value = replace( value, '{$char}', ' ' ) where value like '%{$char}%' " );

?>
<?=$cust?$cust:"This search reflects trends occurring within songs that have charted on the $chartname."?></h2>
    <? if( $nomatch ) { ?>
                        <h2 class="error">No matches found for your selected criteria.</h2>
                        <? } ?>

            <a class="search-header-clear">CLEAR ALL</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body moddded">
						<form class="search-form" method='get' name="trendsearchform" id="trendsearchform" action='trend-search-results.php'>
      <input type='hidden' name='searchtype' value='Trend'>
      <input type='hidden' name='fromlink' value='industry'>
      <input type='hidden' name='searchsubtype' value='<?=$thetype?>'>


      <div class="form-header adj">
          <div class="form-column span-4 element-inline" style="vertical-align:middle;">
              <h3><input type="radio" name="searchby" id="range" value="Quarter" <?=!$searchby || $searchby=="Quarter"?"CHECKED":""?>> <label for="range"><span></span> Select a Date Range</label></h3>
                <div class="form-row-full" style="    margin-top: -20px;">
                  <div id="modified" class="form-row-left-inner">
                    <select id="fromq" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][fromq]"  <?=$searchby=="Year"?"disabled":""?>>
                      <option value="">Any</option>
  <? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
                    </select>
                  </div>
                  <div class="form-row-right-inner">
                    <select id="fromy" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][fromy]"  <?=$searchby=="Year"?"disabled":""?>>
                      <option value="">Any</option>
  <? outputSelectValues( $years, $search["dates"]["fromy"] ); ?>
                    </select>
                  </div>
                  <label class="inner-label">- to -</label>
                  <div class="form-row-left-inner">
                    <select id="toq" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][toq]"  <?=$searchby=="Year"?"disabled":""?>>
                      <option value="">Any</option>
  <? outputSelectValues( $quarters, $search["dates"]["toq"] ); ?>
                    </select>
                  </div>
                  <div class="form-row-right-inner">
                    <select id="toy" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][toy]"  <?=$searchby=="Year"?"disabled":""?>>
                      <option value="">Any</option>
  <? outputSelectValues( $years, $search["dates"]["toy"] ); ?>
                    </select>
                  </div>
                                      <div id="fromqerror"></div>
      <div class="cf"></div>
      </div>
         </div><div class="circle-wrap  element-inline"><div class="circle element-inline">-or-</div></div><div class="form-column span-4 element-inline" style="margin-right:0;vertical-align:middle;">
              <h3><input type="radio" name="searchby" id="quarter" <?=$searchby=="Year"?"CHECKED":""?> value="Year"> <label for="quarter"><span></span> Select a Year or Range of Years</label> </h3>
                 <? if( 1 == 1 ) { ?>
                        <div class="form-row-full year-select">

                <div class="form-row-left-inner">
                  <select name="search[dates][fromyear]" class="datesmustbevalidyear" onChange="resetQuarters()" id="fromyear" <?=$searchby=="Year"?"":"disabled"?>>
                  <option value="">Select</option>
      <? outputSelectValues( $years, $search["dates"]["fromyear"] ); ?>
                  </select>
                </div>
                  <div class="range">to</div>
                <div class="form-row-right-inner">
                  <select name="search[dates][toyear]" class="datesmustbevalidyear" onChange="resetQuarters()" id="toyear" <?=$searchby=="Year"?"":"disabled"?>>
                  <option value="">Select</option>
      <? outputSelectValues( $years, $search["dates"]["toyear"] ); ?>
                  </select>
<? if( $_SESSION["loggedin"] ) { ?>
				    <i>You are only seeing this because you&apos;re logged in</i>
									<select name="search[dates][specialendq]"  >
									<option value="">Select an ending Quarter</option>
<? outputSelectValues( $quarters, $search["dates"]["specialendq"] ); ?>
									</select>
<? } ?>

                </div>
                                      <div id="fromyerror"></div>
                <div class="cf"></div>
              </div>
                        <? } ?>
         </div>
							<!--<div class="form-row-left">
</div>
							<div class="form-row-right">
								<label>Season:</label><br/>
								<div id="modified" class="form-row-left-inner">
									<select id="season" name="search[dates][season]" <?=$searchby=="Year"?"":"disabled"?>>
										<option value="">Any</option>
<?php
outputSelectValues( $seasons, $search["dates"]["season"] ); ?>
									</select>
								</div>
</div>-->
								<div class="cf"></div>
<? if( $_SESSION["loggedin"] ) { ?>
<i>You are only seeing this because you're logged in</i>
									<select name="searchclientid"  >
									<option value="">Select a Client</option>
<? outputSelectValues( getClients(), $searchclientid ); ?>
									</select>

<? } ?>

       </div>
<hr class="sep">





					<div class="form-row-left">
								<label>Select Search Criteria</label>
																<select id="comp-select" name="search[comparisonaspect]">
																	<option value="">(Select One)</option>
								    <?php
								$mypossiblesearchfunctions = getMyPossibleSearchFunctions( $thetype );
								foreach( $mypossiblesearchfunctions as $pid=>$pval ) { ?>
								      <option <?=$search[comparisonaspect] == $pid || count( $mypossiblesearchfunctions ) == 1 ?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
								                                                              <? } ?>
																</select>
								</div><!-- /.form-row-left -->

                <div class="form-row-right">
    								<label>Peak Chart Position:</label>
    								<select name="search[peakchart]">
    									<option value="">Entire Chart</option>
    									<?php
    outputSelectValues( $peakvalues, $search["peakchart"] );
    outputClientSelectValues( $search["peakchart"] );
    ?>
    								</select>

    					</div><!-- /.form-row-right -->
	<div class="cf"></div>

								<div class="form-row-left comp-hidden-genre">
								<label>Primary Genre:</label>
																<select name="genrefilter">
																	<option value="">All Genres</option>
								<? outputSelectValues( $allgenresfordropdown, $genrefilter ); ?>
																</select>
						</div><!-- /.form-row-right -->
                            
                            
              							<div class="form-row-right">
              								<div class="cf"></div>
              								<div class="form-row-left-inner">
              								<label><nobr>New Songs / Carryovers:</nobr></label>
              								</div>
              								<div class="cf"></div>
              								<!--<div class="form-row-right-inner">-->
              								<select name="newcarryfilter">
              									<option value="">All Songs</option>
              	   <? outputSelectValuesForNewCarry( $newcarryfilter, "trend" )?>
              								</select>

              								<!--</div>-->
              								</div>
	<div class="cf"></div>



          								<div class="form-row-left">
          								<label>BPM:</label>
								<select name='search[exactbpm]'>
									<option value="">All</option>
<? outputSelectValuesDistinct( "TempoRange", $search[exactbpm] ); ?>
								</select>
          						</div>



          								<div class="form-row-left">
          								<label>Select Songs in a Major or Minor Key:</label>
								<select name='search[majorminor]'>
									<option value="">All</option>
<? outputSelectValuesDistinct( "majorminor", $search[majorminor] ); ?>
								</select>
          						</div>

          								<div class="form-row-left">
          								<label>Select a Specific Lyrical Theme:</label>
								<select name='search[lyricalsubthemeid]'>
									<option value="">All</option>
<? outputSelectValuesForOtherTable( "lyricalsubthemes", $search[lyricalsubthemeid]); ?>
								</select>
          						</div>

          								<div class="form-row-left">
          								<label>Select a Specific Lyrical Mood:</label>
								<select name='search[lyricalmoodid]'>
									<option value="">All</option>
<? outputSelectValuesForOtherTable( "lyricalmoods", $search[lyricalmoodid]); ?>
								</select>
          						</div>

          								<div class="form-row-left">
          								<label>Chart:</label>
								<select name='setchart'>
									<option value="">All</option>
<? outputSelectValuesForOtherTable( "charts", $chartid, false, " and UseOnDb = 1" ); ?>
								</select>
          						</div>






      <div class="form-row-left">

               	<span id="outputformatspan" <?=$onlyonequarter?"style='display:none'":""?> >
               						<label>Output Format <img class="info-icon" title="The line graph illustrates search results quarter by quarter for the time period selected.
               							The bar graph aggregates search results for the time period selected." src="assets/images/info-icon.svg" border="0"></label>
               								<select id="graphtype" name="graphtype">
               									<option value="">(Select One)</option>
    <? foreach( array(  "column"=>"Bar Graph", "line"=>"Line Graph" ) as $pid=>$pval ) { ?>
                     <option <?=$_GET["graphtype"] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                                             <? } ?>
               								</select>

               </span>


        </div><!-- /.form-row-left -->



                                <div class="cf"></div>
						
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
		    if ($("#comp-select").val() == "Primary Genre Breakdown") {
		       $('.comp-hidden-labels').removeClass('hide').addClass('show');
		       $('.comp-hidden-genre').removeClass('show').addClass('hide');
		    }
		    else {
		       $('.comp-hidden-genre').removeClass('hide').addClass('show');
		       $('.comp-hidden-labels').removeClass('show').addClass('hide');
		    }
		    if ($("#comp-select").val() == "Record Labels") {
		       $('.comp-hidden-record').removeClass('hide').addClass('show');
		    }
		    else {
		       $('.comp-hidden-record').removeClass('show').addClass('hide');
		    }
		    if ($("#comp-select").val() == "Song Forms") {
		       $('.comp-hidden-songform').removeClass('hide').addClass('show');
		    }
		    else {
		       $('.comp-hidden-songform').removeClass('show').addClass('hide');
		    }
		    if ($("#comp-select").val() == "Producers") {
		       $('.comp-hidden-producer').removeClass('hide').addClass('show');
		    }
		    else {
		       $('.comp-hidden-producer').removeClass('show').addClass('hide');
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

        $.validator.addMethod("datesmustbevalid", function(value, element) {
		var chosentype = $('input[name=searchby]:checked').val();
		if( chosentype == "Year" ) return true;
                $("#fromqerror").html( "" );
                var datefrom = "";
                var datefromy = "";
                var dateto = "";
                var datetoy = "";
//                alert( element.name );
                for( i = 0; i < document.forms["trendsearchform"].elements.length; i++ )
                {
                    if( document.forms["trendsearchform"].elements[i].name == "search[dates][fromq]" )
                        datefrom = document.forms["trendsearchform"].elements[i].value;
                    if( document.forms["trendsearchform"].elements[i].name == "search[dates][fromy]" )
                        datefromy = document.forms["trendsearchform"].elements[i].value;
                    if( document.forms["trendsearchform"].elements[i].name == "search[dates][toq]" )
                        dateto = document.forms["trendsearchform"].elements[i].value;
                    if( document.forms["trendsearchform"].elements[i].name == "search[dates][toy]" )
                        datetoy = document.forms["trendsearchform"].elements[i].value;
                }
//               alert( datefrom + ", " + dateto + ", " + datefromy + ", " + datetoy );
                if( datefrom > "" && datefromy > "" && dateto == "" && datetoy == "" ) // only one Q
                {
                    return true;
                }
                else if( datefrom == "" && datefromy == "" && dateto == "" && datetoy == "" ) // no dates entered
                {
                    return false;
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

        $.validator.addMethod("datesmustbevalidyear", function(value, element) {
		var chosentype = $('input[name=searchby]:checked').val();
		if( chosentype == "Quarter" ) return true;
                $("#fromyqerror").html( "" );
                var datefromyear = "";
                var datetoyear = "";
//                alert( element.name );
                for( i = 0; i < document.forms["trendsearchform"].elements.length; i++ )
                {
                    if( document.forms["trendsearchform"].elements[i].name == "search[dates][fromyear]" )
                        datefromyear = document.forms["trendsearchform"].elements[i].value;
                    if( document.forms["trendsearchform"].elements[i].name == "search[dates][toyear]" )
                        datetoyear = document.forms["trendsearchform"].elements[i].value;
                }
		if( datefromyear == "" || datetoyear == "" ) // no dates entered
                {
                    return false;
                }
                else if( datefromyear > "" && datetoyear > "" )
                {
                    d1 = new Date( datefromyear, 1, 1 );
                    d2 = new Date( datetoyear, 1, 1 );
                    return d1 <= d2;
                }

                return false;
            }, "* Please enter a valid date range.");

        $.validator.addMethod("onlyifartist", function(value, element) {
                var datefrom = "";
                var datefromy = "";
                var dateto = "";
                var datetoy = "";
//                alert( "value is: " + value );
                for( i = 0; i < document.forms["trendsearchform"].elements.length; i++ )
                {
                    if( document.forms["trendsearchform"].elements[i].name == "searchcriteria[artisttype]" )
                        selindex = document.forms["trendsearchform"].elements[i].selectedIndex;
                }
//                alert( value  + ": " + selindex );

                if( selindex > 0 && value == "" )
                {
                    return false;
                }

                return true;
            }, "* Please enter the name of a songwriter or artist.");

		$('#trendsearchform').validate({
			onfocusout: false,
			onkeyup: false,
			onclick: false,
			rules: {
                  'search[comparisonaspect]': { required: true },
                  'graphtype': { required: true },
                  'search[dates][fromq]': { datesmustbevalid: true },
                  'search[dates][toq]': { datesmustbevalid: true },
                  'search[dates][fromy]': { datesmustbevalid: true },
                  'search[dates][toy]': { datesmustbevalid: true },
                  'search[dates][fromyear]': { datesmustbevalidyear: true },
                  'search[dates][toyear]': { datesmustbevalidyear: true },
                  'searchcriteria[artistid]': { onlyifartist: true },
                   },
                    submitHandler: function(form) {
                    form.submit();
                },
                    errorPlacement: function(error, element) {
                    if (element.attr("name") == "search[dates][fromy]" || element.attr("name") == "search[dates][toy]" || element.attr("name") == "search[dates][fromq]" || element.attr("name") == "search[dates][toq]") {

                            // just another example
                        $("#fromqerror").html( error );
                        $('.form-row-right').first().addClass('important-mt');
		    }
		    else if (element.attr("name") == "search[dates][fromyear]" || element.attr("name") == "search[dates][toyear]") {

			// just another example
                        $("#fromyerror").html( error );
                        $('.form-row-right').first().addClass('important-mt');
                    } else {

			// the default error placement for the rest
                        error.insertAfter(element);

                    }
                }

			});

		});

// jQuery.validator.defaults.onkeyup = function (element, event) {
//         // detectect if is the element you dont want validate
//         // the element has to have the attribute 'data-control="mycitycontrol"'
//         // you can also identify your element as you please
//     if ($(element).data("control") === "datesmustbevalid") {
//         $("#fromqerror").html( "" );
//         return;
//     }
//     if (event.which === 9 && this.elementValue(element) === "") {
//         return;
//     }
//     else if (element.name in this.submitted || element === this.lastElement) {
//         this.element(element);
//     }
// }
$('.datesmustbevalid').change( function() {
			       checkOutputFormat();
			       }
    );

$('.datesmustbevalidyear').change( function() {
			       checkOutputFormat();
			       }
    );
$('#comp-select').change( function() {
			       checkOutputFormat();
			       }
    );

$('#season').change( function() {
	document.forms["trendsearchform"].elements["graphtype"].selectedIndex = 0;
	checkOutputFormat();
	
    });

function checkOutputFormat()
{
		var chosentype = $('input[name=searchby]:checked').val();
		if( chosentype == "Year" )
		    {
			var same = true;
			for( i = 0; i < document.forms["trendsearchform"].elements.length; i++ )
			    {
				if( document.forms["trendsearchform"].elements[i].name == "search[dates][fromyear]" )
				    datefromy = document.forms["trendsearchform"].elements[i].value;
				if( document.forms["trendsearchform"].elements[i].name == "search[dates][toyear]" )
				    datetoy = document.forms["trendsearchform"].elements[i].value;
			    }

			if( datetoy == "" && datefromy == "" )
			    {
				same = false;
			    }
			else if( datefromy != datetoy )
			    same = false;

			var val = $('#comp-select').val();
			if( val == "" || val == "Number of Songs" || val == "Number of Weeks" || val == "Number of Songs (Form)" || val == "Primary Artist Breakdown" || val == "Credited Songwriter Breakdown" || val == "Credited Producer Breakdown" )
			    same = true;

			if( $("#season").val() > "" )
			    same  = true;

			if( same )
			    {
				$("#outputformatspan").css( "display", "none" );
			    }
			else
			    {
				$("#outputformatspan").css( "display", "" );
			    }
		    }
		else
		    {
			var same = true;
			for( i = 0; i < document.forms["trendsearchform"].elements.length; i++ )
			    {
				if( document.forms["trendsearchform"].elements[i].name == "search[dates][fromq]" )
				    datefrom = document.forms["trendsearchform"].elements[i].value;
				if( document.forms["trendsearchform"].elements[i].name == "search[dates][fromy]" )
				    datefromy = document.forms["trendsearchform"].elements[i].value;
				if( document.forms["trendsearchform"].elements[i].name == "search[dates][toq]" )
				    dateto = document.forms["trendsearchform"].elements[i].value;
				if( document.forms["trendsearchform"].elements[i].name == "search[dates][toy]" )
				    datetoy = document.forms["trendsearchform"].elements[i].value;
			    }

			if( dateto == "" && datetoy == "" && datefrom == "" && datefromy == "" )
			    {
				same = false;
			    }
			else if( dateto == "" && datetoy == ""  )
			    {
				// same
			    }
			else if( datefrom != dateto || datefromy != datetoy )
			    same = false;

			var val = $('#comp-select').val();

			if( val == "" || val == "Number of Songs" || val == "Number of Weeks" || val == "Number of Songs (Form)" || val == "Primary Artist Breakdown" || val == "Credited Songwriter Breakdown" || val == "Credited Producer Breakdown" )
			    same = true;


			if( same )
			    {
				$("#outputformatspan").css( "display", "none" );
			    }
			else
			    {
				$("#outputformatspan").css( "display", "" );
			    }
		    }

		var val = $('#comp-select').val();
		//		alert( val );
		if( val == "Songs with Solo vs. Multiple Artists" || val == "Songs with a Featured Artist" )
		    {
			$("#featuredmaindiv").css( "display", "none" );
		    }
		else
		    {
			$("#featuredmaindiv").css( "display", "" );
		    }

    }

$('#submitbutton').on('click', function( e ) {
//            alert( "hmm" );
        e.preventDefault();
        if( $("#trendsearchform").valid() )
        {
            $("#trendsearchform").submit();
        }
    });


function reloadAutocomplete( value )
{
    $( "#artistid").val( "" );
    if( value == "" )
    {
        $( "#artistid").css( "display", "none" );
        return;
    }
    $( "#artistid").css( "display", "" );
    $( "#artistid" ).autocomplete({
          source: "autocomplete.php?type=" + value,
                });
}

checkOutputFormat();
<? if( $searchcriteria[artisttype] ) { ?>
reloadAutocomplete( "<?=$searchcriteria[artisttype]?>" );
$("#artistid").val( "<?=$searchcriteria[artistid]?>" );
<? } ?>

</script>
<script>
   $(document).ready(function(){
     $('#quarter').on('click', function(){
         if ( $(this).is(':checked') ) {
             $('#fromq').attr("disabled", true);
             $('#fromy').attr("disabled", true);
             $('#toq').attr("disabled", true);
             $('#toy').attr("disabled", true);
	     $('#fromq').attr('selectedIndex', 0);
	     $('#toq').attr('selectedIndex', 0);
	     $('#fromy').attr('selectedIndex', 0);
	     $('#toy').attr('selectedIndex', 0);
             $('#fromyear').attr("disabled", false);
             $('#toyear').attr("disabled", false);
             $('#season').attr("disabled", false);
             $('#fromweekdate').attr("disabled", false);
             $('#toweekdate').attr("disabled", false);

         }
      });

      $('#range').on('click', function(){
          if ( $(this).is(':checked') ) {
              $('#fromq').attr("disabled", false);
              $('#fromy').attr("disabled", false);
              $('#toq').attr("disabled", false);
              $('#toy').attr("disabled", false);
              $('#fromyear').attr("disabled", true);
              $('#toyear').attr("disabled", true);
              $('#season').attr("disabled", true);
              $('#fromyear').attr('selectedIndex', 0);
              $('#toyear').attr('selectedIndex', 0);
              $('#season').attr('selectedIndex', 0);
             $('#fromweekdate').attr("disabled", false);
             $('#toweekdate').attr("disabled", false);

          }
       });
    });
</script>
<?php include 'footer.php';?>
