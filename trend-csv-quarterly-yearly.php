<?php include 'header.php';
include "trendfunctions.php";

$thetype = str_replace( ".php", "", $thetype );
$thetype = array_shift( explode( "?", $thetype ) );

if( !$thetype ) $thetype = $searchsubtype;
if( $search[dates][toq] == $search[dates][fromq] &&  $search[dates][toy] == $search[dates][fromy] )
{
    $onlyonequarter = true;
}


if( !$title )
    $title = "Quarterly Trend Report – Quarterly and Yearly";
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
			    <h1>Quarterly Trend Report – Quarterly and Yearly</h1>
						<h2>

By selecting a range of years, each year will appear as a separate row.
    <? if( $nomatch ) { ?>
                        <h2 class="error">No matches found for your selected criteria.</h2>
                        <? } ?>

            <a class="search-header-clear">CLEAR ALL</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body moddded">
						<form class="search-form" method='get' name="trendsearchform" id="trendsearchform" action='trend-csv-quarterly-yearly-results.php'>
      <input type='hidden' name='searchtype' value='Trend'>
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
<i>You are only seeing this because you're logged in</i>
									<select name="search[dates][specialendq]"  >
									<option value="">Select an ending Quarter</option>
<? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
									</select>




<? } ?>
<? if( $_SESSION["loggedin"] && 1 == 1 ) { ?>
<Br><br>

								<label>Specific Quarter:</label><br/>
								<div id="modified" class="form-row-left-inner">
									<select id="season" name="search[dates][season]" <?=$searchby=="Year"?"":"disabled"?>>
										<option value="">Any</option>
<? 
unset( $seasons["4,1,2,3"] );
unset( $seasons[ALLSEASONS24] );
outputSelectValues( $seasons, $search["dates"]["season"] ); ?>
									</select>
								</div>
<? } ?>

                </div>
                                      <div id="fromyerror"></div>
                <div class="cf"></div>
              </div>
                        <? } ?>
         </div>
								<div class="cf"></div>

       </div>
<hr class="sep">



					<div class="form-row-left">
    								<label>Sub-Genres/Influences To Use:</label>
								<br><br>
<? 
$possinfluences = db_query_array( "select Name, id from subgenres", "id", "Name" );
foreach( $possinfluences as $tmp=>$disp )
{
echo( "<input style='display: inline !important' type='checkbox' name='influences[]' value='$tmp' " . (in_array( $influences, $tmp )?"CHECKED":"") . "> " . $disp . "<br>" );
}
?>
								</div><!-- /.form-row-left -->

                <div class="form-row-right">
    								<label>Instruments To Use:</label>
								<br><br>
<? 
$possinfluences = db_query_array( "select Name, id from primaryinstrumentations", "id", "Name" );
foreach( $possinfluences as $tmp=>$disp )
{
echo( "<input style='display: inline !important' type='checkbox' name='pinstruments[]' value='$tmp' " . (in_array( $pinstruments, $tmp )?"CHECKED":"") . "> " . $disp . "<br>" );
}
?>

    					</div><!-- /.form-row-right -->
					<div class="form-row-left">
								</div><!-- /.form-row-left -->

                <div class="form-row-right">
    								<label>Peak Chart Position:</label>
    								<select name="search[peakchart]">
    									<option value="">Top 10</option>
    									<?php
    $tmpvalues = array( "1"=> "#1", "3"=>"Top 3", "5"=>"Top 5");
    outputSelectValues( $tmpvalues, $search["peakchart"] );
    outputClientSelectValues( $search["peakchart"] );
    ?>
    								</select>

    					</div><!-- /.form-row-right -->
	<div class="cf"></div>
								<div class="form-row-left">
								<label>Primary Genre:</label>
																<select name="genrefilter">
																	<option value="">All Genres</option>
								<? outputSelectValues( $allgenresfordropdown, $genrefilter ); ?>
																</select>
						</div><!-- /.form-row-right -->


          								<div class="form-row-right">
          						</div><!-- /.form-row-right -->

<div class="cf"></div>


        <div class="form-row-right " >

          </div>


            <div class="cf"></div>

            <div class="form-row-left">

                     <? if( $thetype != "performingartists" && $thetype != "songwriters" && $thetype != "producers" ) { ?>
               <label>Performing Artist/Songwriter/Producer</label>
          <? } else if( $thetype == "performingartists" ) { ?>
               <label>Select a Specific Performing Artist</label>
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


              </div> <!-- /.form-row-right -->

              <div class="form-row-right output-wrap" >
                  <input type="text" name="searchcriteria[artistid]" id="artistid" value="<?=$searchcriteria[artistid]?>" <?=$searchcriteria[artistid]?"":'style="display:none"'?> >
                </div>


      <div class="form-row-left">


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
			       }
    );

$('.datesmustbevalidyear').change( function() {
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
