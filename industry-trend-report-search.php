<?php

include 'header.php';
include "trendfunctions.php";

$weekdates = db_query_array( "select OrderBy, Name from weekdates where OrderBy <= " . strtotime( "next Saturday" ) . " order by OrderBy desc" );

if( isEssentials() )
{
Header( "Location: index.php?l=1" );
exit;
}
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

if( $_SESSION["loggedin"] )
{
    if( !$search["dates"]["toy"] )
    {
        $search["dates"]["toq"] =     $search["dates"]["fromq"];
        $search["dates"]["toy"] =     $search["dates"]["fromy"];
    }
}

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
</style>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
    <h1><?=getOrCreateCustomTitle( "INDUSTRY TREND REPORT SEARCH", "INDUSTRY TREND REPORT" )?></h1>
						<h2>The Industry Trend Report provides a snapshot of the industry trends as they relate to the songs that land in the Top 10 of the Billboard Hot 100. Trend data is broken down by Top 10 hits, #1 hits, primary genres, and new arrival vs. carryover songs in order to further hone in on emerging trends</h2>
						<a class="search-header-clear">CLEAR ALL</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body modded">
						<form class="search-form" id="searchform" name="searchform" method='get' action='industry-trend-report.php'>
      <input type='hidden' name='searchtype' value='Trend Report'>

      <div class="form-header adj">
        <div class="form-column span-4 element-inline" style="vertical-align:middle;">
            <h3><input type="radio" name="searchby" id="range" value="Quarter" checked=""> <label for="range"><span></span> Select a Quarter and a Year</label></h3>
            <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
									<select name="search[dates][fromq]" id="fromq" onChange="resetYears()">
									<option value="">Select a Quarter</option>
<? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
									</select>
                  <div id="fromqerror"></div>
								</div>
								<div class="form-row-right-inner">
									<select name="search[dates][fromy]"  id="fromy" onChange="resetYears()">
									<option value="">Select a Year</option>
<? outputSelectValues( $years, $search["dates"]["fromy"] ); ?>
									</select>
								</div>
								<div class="form-row-left-inner">
<? if( $_SESSION["loggedin"] && 1 == 0 )
{
    ?>
    To
									<select name="search[dates][toq]">
<? outputSelectValues( $quarters, $search["dates"]["toq"] ); ?>
									</select>
    <?php
}
    ?>
								</div>
								<div class="form-row-right-inner">
<? if( $_SESSION["loggedin"] && 1 == 0  )
{
    ?>
									<select name="search[dates][toy]">
<? outputSelectValues( $years, $search["dates"]["toy"] ); ?>
									</select>
    <? } ?>
    </div>
								<div class="cf"></div>
							</div><!-- /.form-row-left -->
       </div><div class="circle-wrap  element-inline"><div class="circle">-or-</div></div><div class="form-column span-4 element-inline" style="margin-right:0;vertical-align:middle;">
            <h3><input type="radio" name="searchby" id="quarter" value="Year"> <label for="quarter"><span></span> Or Year Range</label> </h3>
             <div class="form-row-full year-select">
                <div class="form-row-left-inner">
                  <select name="search[dates][fromyear]" id="fromyear" onChange="resetQuarters()" disabled>
                  <option value="">Select</option>
      <? outputSelectValues( $years, $search["dates"]["fromyear"] ); ?>
                  </select>
                </div>
<div class="range">to</div>
                <div class="form-row-right-inner">
                  <select name="search[dates][toyear]" id="toyear" onChange="resetQuarters()" disabled>
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
                </div>
                <div class="cf"></div>
              </div>

       </div>
     </div>









<!-- /.form-row-left -->

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


							<div class="cf"></div>
							<div class="form-row-left">
<? if( $_SESSION["loggedin"] ) { ?>
<i>You are only seeing this because you're logged in</i>
									<select name="searchclientid"  >
									<option value="">Select a Client</option>
<? outputSelectValues( getClients(), $searchclientid ); ?>
									</select>

<? } ?>
</div>
							<div class="form-row-right">
							<input type="submit" value="SEARCH" id="searchbutton" />
								<div class="cf"></div>
							</div><!-- /.form-row-right -->
							<div class="cf"></div>

						</form><!-- /.search-form -->
<? if( $_SESSION["loggedin"] ) { ?>
OR
						<form class="search-form2" method='get' action='industry-trend-report.php'>
      <input type='hidden' name='searchtype' value='Trend Report'>
							<div class="form-row-left">
								<label>Select A Week Date:</label><br/>
								<div class="form-row-left-inner">
									<select id="fromweekdate" name="search[dates][fromweekdate]">
									<option value="">Select</option>
<? outputSelectValues( $weekdates, $search["dates"]["fromweekdate"] ); ?>
									</select>
								</div>
								<div class="form-row-right-inner">
									<select id="toweekdate" name="search[dates][toweekdate]" >
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

								<div class="form-row-left-inner">
								</div>
								<div class="form-row-right-inner">
								<div class="cf"></div>
								<div class="form-row-right">
							</div><!-- /.form-row-right -->
							</div><!-- /.form-row-left -->
							<div class="form-row-right">
							</div><!-- /.form-row-right -->
							<div class="cf"></div>
							<div class="form-row-left">
</div>
<? if( $_SESSION["loggedin"] ) { ?>
<i>You are only seeing this because you're logged in</i>
									<select name="searchclientid"  >
									<option value="">Select a Client</option>
<? outputSelectValues( getClients(), $searchclientid ); ?>
									</select>

<? } ?>
							<div class="form-row-right">
							<input type="submit" value="SEARCH" id="searchbutton" />
								<div class="cf"></div>
							</div><!-- /.form-row-right -->
</form>

				 <? } ?>

					</div><!-- /search-body -->
          <div class="cf"></div>
				</div><!-- /.info-container -->
			</div>
		</section><!-- /.song-title-top -->
	</div><!-- /.site-body -->
    <script>
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
//                alert( element.name );
                for( i = 0; i < document.forms["searchform"].elements.length; i++ )
                {
                    if( document.forms["searchform"].elements[i].name == "search[dates][fromq]" )
                        datefrom = document.forms["searchform"].elements[i].value;
                    if( document.forms["searchform"].elements[i].name == "search[dates][fromy]" )
                        datefromy = document.forms["searchform"].elements[i].value;
                    if( document.forms["searchform"].elements[i].name == "search[dates][toyear]" )
                        datetoyear = document.forms["searchform"].elements[i].value;
                    if( document.forms["searchform"].elements[i].name == "search[dates][fromyear]" )
                        datefromyear = document.forms["searchform"].elements[i].value;
                }
		//		alert( datefrom + ", " + dateto + ", " + datefromy + ", " + datetoy );
                if( datefrom > "" && datefromy > "" && datefromyear == "" && datetoyear == "" ) // only one Q
                {
		    //		    		    alert( "a89" );
		    resetRed();
                    return true;
                }
                else if( datefrom == "" && datefromy == "" && datefromyear == "" && datetoyear == "" ) // only one Q
                {
		    //		    		    alert( "a89" );
                    return false;
                }
                else if( datefrom == "" && datefromy == "" && datefromyear > "" && datetoyear == "" ) // no dates entered
                {
		    //		    		    alert( "a8" );
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
		    //		    		    alert( "a7" );
                    return false;
                }
                else if( datefrom > "" && datetoyear > "" ) // both are chosen
                {
		    //		    		    alert( "a6" );
                    return false;
                }
                else if( datefromy > "" && datetoyear > "" ) // both are chosen
                {
		    //		    		    alert( "a5" );
                    return false;
                }
                else if( datefromyear == "" && datetoyear > "" ) // both are chosen
                {
		    //		    		    alert( "a57" );
                    return false;
                }
                else if( datefromy > "" && datefromyear > "" ) // both are chosen
                {
		    //		    		    alert( "a4" );
                    return false;
                }
                else if( datefrom > "" && datefromy == "" ) // only one of the "from" dates
                {
		    //		    		    alert( "a3" );
                    return false;
                }
                else if( datefrom == "" && datefromy > "" ) // only one of the "from" dates
                {
		    //		    		    alert( "a2" );
                    return false;
                }
                else if( datetoyear > "" && datefromyear > "" && datefromyear > datetoyear ) // only one of the "from" dates
                {
		    //		    		    alert( "a1" );
                    return false;
                }

                return false;
            }, "* Please enter a valid date range.");

		$('.search-form').validate({

       submitHandler: function(form) {
              $("#searchbutton").val( "PLEASE WAIT..." );
	      form.submit();
        },
			rules: {
				'search[dates][fromq]': { datesmustbevalid: true },
				'search[dates][toyear]': { datesmustbevalid: true },
				'search[dates][fromyear]': { datesmustbevalid: true },
				'search[dates][fromy]': { datesmustbevalid: true }
			},
                    errorPlacement: function(error, element) {
			    if (element.attr("name") == "search[dates][fromy]" || element.attr("name") == "search[dates][toyear]" || element.attr("name") == "search[dates][fromq]" || element.attr("name") == "search[dates][fromyear]") {

				// just another example
				$("#fromqerror").html( error );
				$('.form-row-right').first().addClass('important-mt');
			    } else {

				// the default error placement for the rest
				error.insertAfter(element);

			    }

			}

		    });



		$('.search-form2').validate({

			rules: {
				'search[dates][fromweek]': { required: true },
				'search[dates][toweek]': { required: true }
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
               $('#fromyear').attr("disabled", false);
               $('#toyear').attr("disabled", false);

           }
        });

        $('#range').on('click', function(){
            if ( $(this).is(':checked') ) {
                $('#fromq').attr("disabled", false);
                $('#fromy').attr("disabled", false);
                $('#fromyear').attr("disabled", true);
                $('#toyear').attr("disabled", true);

            }
         });
      });
function resetRed()
{
$("#fromq").removeClass( "error" );
$("#fromy").removeClass( "error" );
$("#fromyear").removeClass( "error" );
$("#toyear").removeClass( "error" );
}
  </script>

<?php include 'footer.php';?>
