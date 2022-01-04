<?php include 'header.php';
include "compositionaltrendsbyweeksfunctions.php";


if( isEssentials() )
{
Header( "Location: index.php?l=1" );
exit;
}

if( !$title )
    $title = "COMPOSITIONAL TRENDS BY NUMBER OF WEEKS IN THE TOP 10";
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
			    <h1><?=getOrCreateCustomTitle( "CTRBWS - " . $title, $title )?></h1>
						<h2>

<? $cust = getOrCreateCustomHover( "compositional-trends-by-week", "This search reflects weekly trends occurring within songs that have charted among the Billboard Hot 100 Top 10." ); ?>
<?=$cust?></h2>
    <? if( $nomatch ) { ?>
                        <h2 class="error">No matches found for your selected criteria.</h2>
                        <? } ?>

            <a class="search-header-clear">CLEAR ALL</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body moddded">
						<form class="search-form" id="trendsearchform" name="trendsearchform" method='get' action='compositional-trends-by-weeks-search-results.php'>
      <input type='hidden' name='searchtype' value='Compositional By Weeks'>
      <input type='hidden' name='searchsubtype' value='<?=$thetype?>'>


      <div class="form-header adj">
          <div class="form-column span-4 element-inline" style="vertical-align:middle;">
              <h3><input type="radio" name="searchby" id="range" value="Quarter" <?=!$searchby || $searchby=="Quarter"?"CHECKED":""?>> <label for="range"><span></span> Select a Date Range</label></h3>
                <div class="form-row-full" style="    margin-top: -20px;">
                  <div id="modified" class="form-row-left-inner">
                    <select id="fromq" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][fromq]" <?=$searchby=="Year"?"disabled":""?>>
                      <option value="">Any</option>
  <? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
                    </select>
                  </div>
                  <div class="form-row-right-inner">
                    <select id="fromy" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][fromy]" <?=$searchby=="Year"?"disabled":""?>>
                      <option value="">Any</option>
  <? outputSelectValues( $years, $search["dates"]["fromy"] ); ?>
                    </select>
                  </div>
                  <label class="inner-label">- to -</label>
                  <div class="form-row-left-inner">
                    <select id="toq" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][toq]" <?=$searchby=="Year"?"disabled":""?>>
                      <option value="">Any</option>
  <? outputSelectValues( $quarters, $search["dates"]["toq"] ); ?>
                    </select>
                  </div>
                  <div class="form-row-right-inner">
                    <select id="toy" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][toy]" <?=$searchby=="Year"?"disabled":""?>>
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

                </div>
                                      <div id="fromyerror"></div>
                <div class="cf"></div>
              </div>
                        <? } ?>
         </div>
							<div class="form-row-left" style="display:none;">
								<label>Season:</label><br/>
								<div id="modified" class="form-row-left-inner">
									<select id="season" name="search[dates][season]">
										<option value="">Any</option>
<? 
outputSelectValues( $seasons, $search["dates"]["season"] ); ?>
									</select>
								</div>
</div>
								<div class="cf"></div>

       </div>
<hr class="sep">







					<div class="form-row-left">
								<label>Search Focus</label>
																<select id="comp-select" name="search[compositionalaspect]">
																	<option value="">(Select One)</option>
								    <?php
								foreach( $possiblecompositionalaspects as $pid=>$pval ) { ?>
								      <option <?=$search[compositionalaspect] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
								                                                              <? } ?>
																</select>
								</div><!-- /.form-row-left -->

               
                            <div class="form-row-right">
  <label>Search Criteria:</label>
<select name='search[outputformat]' id='search[outputformat]'>
<option value="">Please Choose</option>
<? outputSelectValues( $possibletables, $search["outputformat"] ); ?>
</select>
  </div><!-- /.form-row-right -->
                            
                            
                             <div class="form-row-right" style="display:none;">
    								<label>Peak Chart Position:</label>
    								<select name="search[peakchart]">
    									<option value="">Top 10</option>
    									<?php
    outputSelectValues( $peakvalues, $search["peakchart"] );
    outputClientSelectValues( $search["peakchart"] );
    ?>
    								</select>

    					</div><!-- /.form-row-right -->
                            
	<div class="cf"></div>


              							<div class="form-row-left">
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
								<label>Primary Genre:</label>
																<select name="genrefilter">
																	<option value="">All Genres</option>
								<? outputSelectValues( $allgenresfordropdown, $genrefilter ); ?>
																</select>
						</div><!-- /.form-row-right -->

            <div class="form-row-right">
            <label>Specific Performing Artist / Group (Primary or Featured):</label>
      <? outputOtherTableAutofillField( "artists", "primaryartist", "(i.e Adele, The Weeknd)", $search[primaryartist] ); ?>
        </div><!-- /.form-row-right -->


      <!--<div class="form-row-right">

               <? if( $thetype != "performingartists" && $thetype != "songwriters" && $thetype != "producers" ) { ?>
         <label>Performing Artist/Songwriter/Producer</label>
	 <? } else if( $thetype == "performingartists" ) { ?>
         <label>Performing Artist</label>
	 <? } else if( $thetype == "producers" ) { ?>
         <label>Producer</label>
	 <? } else { ?>
         <label>Songwriter</label>
	 <? } ?>
      							<select id="comp-select2" name="searchcriteria[artisttype]" onChange="reloadAutocomplete( this.options[this.selectedIndex].value )">
      								<option value="">All</option>
	 <? if( $thetype != "songwriters" && $thetype != "producers" ) { ?>
             <option <?=$searchcriteria[artisttype]=="primaryartist"?"SELECTED  ":""?> value="primaryartist">Select A Performing Artist</option>
<? }
if( $thetype != "performingartists" && $thetype != "producers" ) { ?>
      								<option <?=$searchcriteria[artisttype]=="writer"?"SELECTED  ":""?> value="writer">Select A Songwriter</option>
<? }
if( $thetype != "performingartists" && $thetype != "songwriters" ) { ?>
      								<option <?=$searchcriteria[artisttype]=="producer"?"SELECTED  ":""?> value="producer">Select A Producer</option>
<? } ?>
      							</select>
      	</div> --><!-- /.form-row-right -->
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

  

  <div class="form-row-right">
  </div><!-- /.form-row-right -->

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
		    if ($("#comp-select").val() == "Record Labels") {
		       $('.comp-hidden-record').removeClass('hide').addClass('show');
		    }
		    else {
		       $('.comp-hidden-record').removeClass('show').addClass('hide');
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
                  'search[compositionalaspect]': { required: true },
                  'search[outputformat]': { required: true },
                  'search[dates][fromq]': { datesmustbevalid: true },
                  'search[dates][toq]': { datesmustbevalid: true },
                  'search[dates][fromy]': { datesmustbevalid: true },
                  'search[dates][toy]': { datesmustbevalid: true },
                  'search[dates][fromyear]': { datesmustbevalidyear: true },
                  'search[dates][toyear]': { datesmustbevalidyear: true },
                   },
                    submitHandler: function(form) {
                    form.submit();
                },
                    errorPlacement: function(error, element) {
                    if (element.attr("name") == "search[dates][fromy]" || element.attr("name") == "search[dates][toy]" || element.attr("name") == "search[dates][fromq]" || element.attr("name") == "search[dates][toq]") {

                            // just another example
			//			alert( "hm" );
                        $("#fromyerror").html( "" );
                        $("#fromqerror").html( error );
                        $('.form-row-right').first().addClass('important-mt');
                    } else if (element.attr("name") == "search[dates][fromyear]" || element.attr("name") == "search[dates][toyear]") {

                            // just another example
                        $("#fromqerror").html( "" );
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
//			       checkOutputFormat();
			       }
    );

$('#comp-select').change( function() {
//			       checkOutputFormat();
			       }
    );

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
              $('#fromyear').attr('selectedIndex', 0);
              $('#toyear').attr('selectedIndex', 0);
             $('#fromweekdate').attr("disabled", false);
             $('#toweekdate').attr("disabled", false);

          }
       });
    });

function resetQuarters()
{
    $("#fromq").val( "" );
    $("#fromy").val( "" );
    $("#fromweekdate").val( "" );
    $("#toweekdate").val( "" );
}
function resetYears()
{
    $("#fromyear").val( "" );
    $("#toyear").val( "" );
    $("#fromweekdate").val( "" );
    $("#toweekdate").val( "" );
}

</script>
<?php include 'footer.php';?>
