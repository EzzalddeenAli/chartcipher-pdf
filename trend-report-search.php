<?php include 'header.php';
include "trendfunctions.php";

if( isEssentials() )
{
Header( "Location: index.php?l=1" );
exit;
}

$weekdates = db_query_array( "select OrderBy, Name from weekdates where OrderBy <= " . strtotime( "next Saturday" ) . " order by OrderBy desc" );
// if( !$search["dates"]["fromy"] )
// {

// 	if( date( "m" ) <= 3 )
//         $fq = 1;
//     else if( date( "m" ) <= 6 )
//         $fq = 2;
//     else if( date( "m" ) <= 9 )
//         $fq = 3;
//     else
//         $fq = 4;

//     $exp = explode( "/", getPreviousQuarter( $fq . "/" . date( "Y" ) ) );

//     $search["dates"]["fromq"] = $exp[0];
//     $search["dates"]["fromy"] = $exp[1];
// }

?>
<style type="text/css">
	.search-header h1{ float:none; }
	.search-header h2{
    margin-top: 15px;
    color: #7a7a7a;
    font-size: 14px;
    line-height:24px;
	}
	.form-row-left .form-row-right
	{
		width: 100%;
		margin-top: 50px;
	}
</style>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1><?=getOrCreateCustomTitle( "TRS - COMPOSITIONAL TREND REPORT", "COMPOSITIONAL TREND REPORT" )?></h1>
<?php
	$cust = getCustomHover( "trend-report-search" );
	if( !$cust )
		$cust = "This search reflects trends occurring within songs that have charted among the Billboard Hot 100 Top Ten.";
?>
					<h2><?=$cust?></h2>
						<a class="search-header-clear">CLEAR ALL</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body modded">
						<form class="search-form" method='get' name="searchform" action='trend-report.php'>
      <input type='hidden' name='searchtype' value='Trend Report'>

			<div class="form-header adj">
	        <div class="form-column span-4 element-inline" style="vertical-align:middle;">
	            <h3><input type="radio" name="searchby" id="range" value="Quarter" <?=!$searchby || $searchby=="Quarter"?"CHECKED":""?>> <label for="range"><span></span> Select a Quarter and a Year</label></h3>
                <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
									<select name="search[dates][fromq]" onChange="resetYears()" id="fromq"  <?=$searchby=="Year"?"disabled":""?>>
									<option value="">Select a Quarter</option>
<? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
									</select>
									<div id="fromqerror"></div>
								</div>
								<div class="form-row-right-inner">
									<select name="search[dates][fromy]" onChange="resetYears()" id="fromy"  <?=$searchby=="Year"?"disabled":""?>>
									<option value="">Select a Year</option>
<?php
outputSelectValues( $years, $search["dates"]["fromy"] ); ?>
									</select>
								</div>
                <div class="cf"></div>
</div>
	       </div><div class="circle-wrap  element-inline"><div class="circle element-inline">-or-</div></div><div class="form-column span-4 element-inline" style="margin-right:0;vertical-align:middle;">
	            <h3><input type="radio" name="searchby" id="quarter" <?=$searchby=="Year"?"CHECKED":""?> value="Year"> <label for="quarter"><span></span> Or Year Range</label> </h3>
                 <? if( 1 == 1 ) { ?>
              					<div class="form-row-full year-select">

								<div class="form-row-left-inner">
									<select name="search[dates][fromyear]" onChange="resetQuarters()" id="fromyear" <?=$searchby=="Year"?"":"disabled"?>>
									<option value="">Select</option>
<? outputSelectValues( $years, $search["dates"]["fromyear"] ); ?>
									</select>
								</div>
                	<div class="range">to</div>
								<div class="form-row-right-inner">
									<select name="search[dates][toyear]" onChange="resetQuarters()" id="toyear" <?=$searchby=="Year"?"":"disabled"?>>
									<option value="">Select</option>
<? outputSelectValues( $years, $search["dates"]["toyear"] ); ?>
									</select>

<? if( $_SESSION["loggedin"] ) { ?>
<i>You are only seeing this because you're logged in</i>
									<select name="search[dates][specialendq]"  >
									<option value="">Select an ending Quarter</option>
<? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
									</select>



<br><br>								<label>Select A Year Range (2 and 3):</label>
								<div class="cf"></div>
								<div class="form-row-left-inner">
									<select name="search[dates][fromyearsecond]" onChange="$('.graphtype').val( 'column' );">
									<option value="">Select</option>
<? outputSelectValues( $years, $search["dates"]["fromyearsecond"] ); ?>
									</select>
								</div>
								<div class="form-row-right-inner">
									<select name="search[dates][toyearsecond]" onChange="$('.graphtype').val( 'column' );">
									<option value="">Select</option>
<? outputSelectValues( $years, $search["dates"]["toyearsecond"] ); ?>
									</select>
								</div>

								<div class="cf"></div>
								<div class="form-row-left-inner">
									<select name="search[dates][fromyearthird]"   onChange="$('.graphtype').val( 'column' );">
									<option value="">Select</option>
<? outputSelectValues( $years, $search["dates"]["fromyearthird"] ); ?>
									</select>
								</div>
								<div class="form-row-right-inner">
									<select name="search[dates][toyearthird]"   onChange="$('.graphtype').val( 'column' );">
									<option value="">Select</option>
<? outputSelectValues( $years, $search["dates"]["toyearthird"] ); ?>
									</select>
								</div>


<? } ?>
								</div>
                                      <div id="fromyerror"></div>
                <div class="cf"></div>
							</div>
									      <? } ?>
												<!--<div class="form-row-full year-select" style="    margin-top: -10px;">
													<label style="    margin-bottom: 12px;">To search for seasonal trends, select a season below.</label><br/>
													<div id="modified" class="form-row-left-inner">
														<select id="season" name="search[dates][season]" disabled>
															<option value="">Any</option>
					<?php
					outputSelectValues( $seasonswithall, $search["dates"]["season"] ); ?>
														</select>
													</div>
												      <div class="cf"></div>
												    </div>-->





</div>

								<div class="cf"></div>

	     </div>



<? if( $_SESSION["loggedin"] ) { ?>
              							<div class="form-row-right">
								<label>OR Select A Week Date Range:</label>
								<div class="cf"></div>
								<div class="form-row-left-inner">
									<select name="search[dates][fromweekdate]">
									<option value="">Select</option>
<? outputSelectValues( $weekdates, $search["dates"]["fromweekdate"] ); ?>
									</select>
								</div>
								<div class="form-row-right-inner">
									<select name="search[dates][toweekdate]" >
									<option value="">Select</option>
<? outputSelectValues( $weekdates, $search["dates"]["toweekdate"] ); ?>
									</select>
								</div>

								<div class="cf"></div>
								<div class="form-row-left-inner">
									<select name="search[dates][fromweekdatesecond]"   onChange="$('.graphtype').val( 'column' );">
									<option value="">Select</option>
<? outputSelectValues( $weekdates, $search["dates"]["fromweekdatesecond"] ); ?>
									</select>
								</div>
								<div class="form-row-right-inner">
									<select name="search[dates][toweekdatesecond]"  onChange="$('.graphtype').val( 'column' );">
									<option value="">Select</option>
<? outputSelectValues( $weekdates, $search["dates"]["toweekdatesecond"] ); ?>
									</select>
								</div>

								<div class="cf"></div>
								<div class="form-row-left-inner">
									<select name="search[dates][fromweekdatethird]"   onChange="$('.graphtype').val( 'column' );">
									<option value="">Select</option>
<? outputSelectValues( $weekdates, $search["dates"]["fromweekdatethird"] ); ?>
									</select>
								</div>
								<div class="form-row-right-inner">
									<select name="search[dates][toweekdatethird]"   onChange="$('.graphtype').val( 'column' );">
									<option value="">Select</option>
<? outputSelectValues( $weekdates, $search["dates"]["toweekdatethird"] ); ?>
									</select>
								</div>

								</div>
<? } ?>

    <? if( 1 == 0 ) { ?>
                <div class="form-row-left third">
  								<label>Or Select a Year:</label><br/>

  								<div class="form-row-right-inner">
  									<select name="search[dates][toyear]">
  									<option value="">Select a Year</option>
  <?php
  outputSelectValues( $years, $search["dates"]["toyear"] ); ?>
  									</select>
  								</div>
                  <div class="cf"></div>
  </div>
									      <? } ?>

<? if( 1 == 1 ) { ?>
                            <hr class="sep">
<? if( $_SESSION["loggedin"] ) { ?>
							<div class="form-row-left quarter-select">
								<div class="cf"></div>
<i>You are only seeing this because you're logged in</i>
									<select name="searchclientid"  >
									<option value="">Select a Client</option>
<? outputSelectValues( getClients(), $searchclientid ); ?>
									</select>

</div>
                            <hr class="sep">
<? } ?>

							<div class="form-row-left quarter-select">
								<div class="cf"></div>
								<div class="form-row-left-inner">
								<label>Primary Genre:</label>
								</div>
								<div class="cf"></div>

								<select name="genrefilter">
									<option value="">All Primary Genres</option>
								<? outputSelectValues( $allgenresfordropdown, $genrefilter ); ?>
								</select>
<div class="cf"></div>

								</div>



                <div class="form-row-right year-select">

<div class="form-row-left-inner">
<label>Output: <img class="info-icon" title="The line graph illustrates search results quarter by quarter for the time period selected.
           The bar graph aggregates search results for the time period selected." src="assets/images/info-icon.svg" border="0"></label>
</div>
<div class="cf"></div>
<!--<div class="form-row-right-inner">-->
<select id="comp-select" name="graphtype" class="graphtype">
<option value=''>(Select One)</option>
<?php
foreach( array(  "column"=>"Bar Graph", "line"=>"Line Graph" ) as $pid=>$pval ) { ?>
<option <?=$_GET["graphtype"] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                             <? } ?>
</select>
<!--</div>-->
<div class="cf"></div>

</div><!-- /.form-row-right -->


<? } ?>



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
                <div class="form-row-right">
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
</div>
							<div class="form-row-right">
							<input type="submit" value="SEARCH" id="searchbutton" />
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

function resetRed()
{
$("#fromq").removeClass( "error" );
$("#fromy").removeClass( "error" );
$("#fromyear").removeClass( "error" );
$("#toyear").removeClass( "error" );
}

		jQuery(document).ready(function($){

		$.validator.setDefaults({
			errorElement: 'div',

		});

        $.validator.addMethod("datesmustbevalid", function(value, element) {
                $("#fromqerror").html( "" );
                var datefrom = "";
                var datefromy = "";
                var datetoyear = "";
                var datefromyear = "";
                var datefromweekdate = "";
                var datetoweekdate = "";
//                alert( element.name );
                for( i = 0; i < document.forms["searchform"].elements.length; i++ )
                {
                    if( document.forms["searchform"].elements[i].name == "search[dates][fromweekdate]" )
                        datefromweekdate = document.forms["searchform"].elements[i].value;
                    if( document.forms["searchform"].elements[i].name == "search[dates][toweekdate]" )
                        datetoweekdate = document.forms["searchform"].elements[i].value;
                    if( document.forms["searchform"].elements[i].name == "search[dates][fromq]" )
                        datefrom = document.forms["searchform"].elements[i].value;
                    if( document.forms["searchform"].elements[i].name == "search[dates][fromy]" )
                        datefromy = document.forms["searchform"].elements[i].value;
                    if( document.forms["searchform"].elements[i].name == "search[dates][fromyear]" )
                        datefromyear = document.forms["searchform"].elements[i].value;
                    if( document.forms["searchform"].elements[i].name == "search[dates][toyear]" )
                        datetoyear = document.forms["searchform"].elements[i].value;
                }
//		               alert( datefrom + ", " + datefromy );
		if( datefromweekdate > "" ) // we're an admin, obviously
		 {
		     return true;
		 }
                if( datefrom > "" && datefromy > "" && datefromyear == "" && datetoyear == "" ) // only one Q
                {
		    //		    alert( "a89" );
		    resetRed();
                    return true;
                }
                else if( datefrom == "" && datefromy == "" && datefromyear == "" && datetoyear == "" ) // only one Q
                {
		    //		    alert( "a89" );
                    return false;
                }
                else if( datefrom == "" && datefromy == "" && datefromyear > "" && datetoyear > "" ) // no dates entered
                {
		    //		    alert( "a8" );
		    resetRed();
                    return true;
                }
                else if( datefrom == "" && datefromy == "" && datefromyear > "" && datetoyear > "" && datefromyear <= datetoyear ) // no dates entered
                {
		    //		    		    alert( "a8" );
		    resetRed();
                    return true;
                }
                else if( datefrom > "" && datefromyear > "" ) // both are chosen
                {
		    //		    alert( "a7" );
                    return false;
                }
                else if( datefrom > "" && datetoyear > "" ) // both are chosen
                {
		    //		    alert( "a6" );
                    return false;
                }
                else if( datefromy > "" && datetoyear > "" ) // both are chosen
                {
		    //		    alert( "a5" );
                    return false;
                }
                else if( datefromyear == "" && datetoyear > "" ) // both are chosen
                {
		    //		    alert( "a57" );
                    return false;
                }
                else if( datefromy > "" && datefromyear > "" ) // both are chosen
                {
		    //		    alert( "a4" );
                    return false;
                }
                else if( datefrom > "" && datefromy == "" ) // only one of the "from" dates
                {
		    //		    alert( "a3" );
                    return false;
                }
                else if( datefrom == "" && datefromy > "" ) // only one of the "from" dates
                {
		    //		    alert( "a2" );
                    return false;
                }
                else if( datetoyear > "" && datefromyear > "" && datefromyear > datetoyear ) // only one of the "from" dates
                {
		    //		    alert( "a1" );
                    return false;
                }

                return false;
            }, "* Please enter a valid date range.");


		$('.search-form').validate({

			rules: {
				'graphtype': { required: true },
				'search[dates][fromq]': { datesmustbevalid: true },
				'search[dates][toyear]': { datesmustbevalid: true },
				'search[dates][fromyear]': { datesmustbevalid: true },
				'search[dates][fromy]': { datesmustbevalid: true },
				'search[comparisonaspect]': { required: true },
				},
       submitHandler: function(form) {
              $("#searchbutton").val( "PLEASE WAIT..." );
	      form.submit();
        },
                    errorPlacement: function(error, element) {
                    if (element.attr("name") == "search[dates][fromy]" || element.attr("name") == "search[dates][toyear]" || element.attr("name") == "search[dates][fromq]"  || element.attr("name") == "search[dates][fromyear]" || element.attr("name") == "search[dates][toweekdate]"  || element.attr("name") == "search[dates][fromweekdate]") {

                            // just another example
                        $("#fromqerror").html( error );
                        $('.form-row-right').first().addClass('important-mt');
                    } else {

                            // the default error placement for the rest
                        error.insertAfter(element);

                    }

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
