<?php 
include "header.php";
include "trendfunctions.php";
$thetype = str_replace( "/", "", $thetype );
$thetype = str_replace( ".php", "", $thetype );
$thetype = array_shift( explode( "?", $thetype ) );


if( $gorachel )
{
	$rows = db_query_rows( "select ArtistBand, SongNameHard, MajorMinor from songs, song_to_chart where songs.id = songid and chartid = 37 and song_to_chart.YearEnteredTheTop10 = '2022' order by SongNameHard" );
	foreach( $rows as $r )
	{
		echo( $r[SongNameHard] . "<br>" );
		}
exit;
			
}

if( $gorachel2 )
{
    $f = explode( "\n", file_get_contents( "tocheck.txt" ) );
    //    print_r( $f );
    echo( "<table style='width:800px'>" );
	foreach( $f as $songname )
	    {	
		$songname = trim( $songname );
		if( !$songname ) continue;
		$r = db_query_first( "select * from songs left join song_to_chart on songs.id = songid and chartid = 37 and SongNameHard = '".escMe( $songname ) . "'" );
		$s = $r[SongNameHard]; 
		if( !$r["NumberOfWeeksSpentInTheTop10"] )
		    {
			$s = "No Match in billboard";
		    }
		$res = db_query_first( "select group_concat( distinct( chart ) ) as chartnames,  group_concat( distinct( artist ) ) as artistnames from  dbi360_admin.billboardinfo where title = '".escMe( $songname )."' limit 1;" );
		echo( "<tr><td>$songname</td><td>$s</td><td>$r[NumberOfWeeksSpentInTheTop10]</td><td>$res[chartnames]</td><td>$res[artistnames]</td></tr>" );
		}
	echo( "</table>" );
	exit;
}



if( !$thetype ) $thetype = $searchsubtype;
if( isset( $_GET["graphtype"] ) && $search[dates][toq] == $search[dates][fromq] &&  $search[dates][toy] == $search[dates][fromy] )
{
    $onlyonequarter = true;
}


$titles["/compositional-search"] = "Compositional";
$titles["/structure-search"] = "Structure";
$titles["/production-search"] = "Production";
$titles["/lyrical-search"] = "Lyrical";

//print_r( $_SERVER );
$blah = str_replace( ".php", "", $_SERVER["SCRIPT_NAME"] );
///echo( $blah ); exit;
$title = $titles[$blah ] . " Trends";;
if( !$title )
    $title = "Search";
$backurl = "/song-landing.php";
?>
<?php require_once 'thumb/phpThumb.config.php';?>
  <link rel="stylesheet" type="text/css" href="../assets/css/grid.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/new-style.css" />
<!--<link rel="stylesheet" type="text/css" href="../assets/css/full-style.css" />-->
<!-- Master Slider Skin -->
<link href="masterslider/masterslider/skins/light-2/style.css" rel='stylesheet' type='text/css'>
       <!-- MasterSlider Template Style -->
<!--<link href='masterslider/masterslider/style/ms-autoheight.css' rel='stylesheet' type='text/css'>-->
<!-- google font Lato -->
<link href='//fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="masterslider/masterslider/style/masterslider.css" />
<script src="masterslider/masterslider/masterslider.min.js"></script>

	<div class="site-body index-pro ">
<? include "chartchooser.php"; ?>                
        <section class="home-top">
			<div class="element-container row">

                
 						<form class="search-form" method='get' name="trendsearchform" id="trendsearchform" action='trend-search-results.php'>
      <input type='hidden' name='searchtype' value='Compositional'>
      <input type='hidden' name='fromlink' value='industry'>
      <input type='hidden' name='searchsubtype' value='<?=$thetype?>'>

                 <div class="row outter row-equal row-padding">
                    <div class="col-12 flex switch">
               
                       <div class="row inner row-equal row-padding link-alt">
                           <div class="col-12 flex">
                               <div class="home-search-header">
                                        <h2>
                         <div class="custom-select" >
<select id="mysetreport">
<? foreach( $titles as $t=> $display ) { ?>
<option <?=$title == $display . " " . "Trends"?"SELECTED":""?> value="<?=$t?>"><?=$display?> Trends</option>
<? } ?>
</select>
</div>
                                        <div class="cf"></div>
                                </div>
                                 <div class="inner-content ">
                                    <div class="display-list">
                                  <div class="header-inner " >
                               
<div class="form-header adj" style="margin-bottom:50px;">
        <div class="form-column span-4 element-inline" style="vertical-align:middle;">
            <h3><input type="radio" name="searchby" id="range" value="Quarter" <?=!$searchby || $searchby=="Quarter"?"CHECKED":""?>> <label for="range"><span></span> Select a Quarter Range</label></h3>
            <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
                    <select id="fromq" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][fromq]"  <?=$searchby=="Year"?"disabled":""?>>
                      <option value="">Any</option>
  <? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
                    </select>
                </div>
                                    
                  <div id="fromqerror"></div>
								</div>
								<div class="form-row-right-inner">
                    <select id="fromy" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][fromy]"  <?=$searchby=="Year"?"disabled":""?>>
                      <option value="">Any</option>
  <? outputSelectValues( $years, $search["dates"]["fromy"] ); ?>
                    </select>
								</div>
								<div class="form-row-left-inner">
								</div>
								<div class="form-row-right-inner">
    </div>
							
							</div><!-- /.form-row-left -->
            
            <div class="range range-full">to</div>
            	<div class="cf"></div>
            
            <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
                    <select id="toq" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][toq]"  <?=$searchby=="Year"?"disabled":""?>>
                      <option value="">Any</option>
  <? outputSelectValues( $quarters, $search["dates"]["toq"] ); ?>
                    </select>
                </div>
                                    
								</div>
								<div class="form-row-right-inner">
                                
                    <select id="toy" data-control="datesmustbevalid" class="datesmustbevalid" name="search[dates][toy]"  <?=$searchby=="Year"?"disabled":""?>>
                      <option value="">Any</option>
  <? outputSelectValues( $years, $search["dates"]["toy"] ); ?>
                    </select>
								</div>
								<div class="cf"></div>
							</div><!-- /.form-row-left -->
            
            
            
            

       </div><div class="circle-wrap  element-inline"><div class="circle">-or-</div></div><div class="form-column span-4 element-inline" style="margin-right:0;vertical-align:top;">
            <h3><input type="radio" name="searchby" id="quarter" <?=$searchby=="Year"?"CHECKED":""?> value="Year">
                <label for="quarter"><span></span> Or Year Range</label> </h3>
             <div class="form-row-full year-select">
                <div class="form-row-left-inner">
                  <select name="search[dates][fromyear]" class="datesmustbevalidyear" onChange="resetQuarters()" id="fromyear" <?=$searchby=="Year"?"":"disabled"?>>
                  <option value="">Select</option>
      <? outputSelectValues( $years, $search["dates"]["fromyear"] ); ?>
                  </select>
                </div>
<div class="range range-short ">to</div>
                <div class="form-row-right-inner">
                  <select name="search[dates][toyear]" class="datesmustbevalidyear" onChange="resetQuarters()" id="toyear" <?=$searchby=="Year"?"":"disabled"?>>
                  <option value="">Select</option>
      <? outputSelectValues( $years, $search["dates"]["toyear"] ); ?>
                  </select>
<? if( $_SESSION["loggedin"] && 1 == 0 ) { ?>
				    <i>You are only seeing this because you&apos;re logged in</i>
									<select name="search[dates][specialendq]"  >
									<option value="">Select an ending Quarter</option>
<? outputSelectValues( $quarters, $search["dates"]["specialendq"] ); ?>
									</select>
<? } ?>
                </div>
                <div class="cf"></div>
              </div>
                   <div class="range range-question">To Search for seasonal trends, select a season below.</div>                        
            <div class="form-row-full year-select">
                <div class="form-row-inner">
									<select id="season" name="search[dates][season]" <?=$searchby=="Year"?"":"disabled"?>>
										<option value="">Any</option>
<?php
outputSelectValues( $seasons, $search["dates"]["season"] ); ?>
									</select>
                </div>
                <div class="cf"></div>
              </div>
                                  

       </div>
 </div>
                                      
 <div class="form-header " >
             <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
                                        <label>Select Search Focus</label>
																<select id="comp-select" name="search[comparisonaspect]">
																	<option value="">(Select One)</option>
								    <?php
								$mypossiblesearchfunctions = getMyPossibleSearchFunctions( $thetype );
								foreach( $mypossiblesearchfunctions as $pid=>$pval ) { ?>
								      <option <?=$search[comparisonaspect] == $pid || count( $mypossiblesearchfunctions ) == 1 ?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
								                                                              <? } ?>
																</select>
                </div>
                                    
								</div>
								<div class="form-row-right-inner">
                                  <label>Select Peak Chart Position</label>
    								<select name="search[peakchart]">
    									<option value="">Entire Chart</option>
    									<?php
    outputSelectValues( $peakvalues, $search["peakchart"] );
    outputClientSelectValues( $search["peakchart"] );
    ?>
    								</select>
								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
     
     
                  <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                  <label># of weeks on <?=$chartname?></label>
									<select name="search[minweeks]"  >
									<option value="" disabled selected>(Any, 10, +25, 50+) </option>
<?
$minweeksvalues = array( "1-1"=>"1 Week", "1-5"=>"5 Weeks or Less", "1-10"=>"10 Weeks or Less", "10"=>"10 Weeks or More", "20"=>"20 Weeks or More", "30"=>"30 Weeks or More" );
outputSelectValues( $minweeksvalues, $search[minweeks] );
?>

									</select>
								</div>

								<div class="form-row-right-inner" <? if( isNoGenreChart() ){ echo( "style='display:none'" ); }?>>





                                  <label>Select a Specific Genre</label>
									<select name="search[specificsubgenre]" >
									<option value=""  selected>All</option>
									<? outputSelectValuesForOtherTable( "subgenres", $search[specificsubgenre]); ?>
									</select>


								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
 </div>
                                      
                                      
     
                  <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
               	<span id="outputformatspan" <?=$onlyonequarter?"style='display:none'":""?> >
                                   
                                        <label>Select Output Format</label>
               								<select id="graphtype" name="graphtype">
               									<option value="">(Select One)</option>
    <? foreach( array(  "column"=>"Bar Graph", "line"=>"Line Graph" ) as $pid=>$pval ) { ?>
                     <option <?=$_GET["graphtype"] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                                             <? } ?>
               								</select>
</span>                                    &nbsp;
								</div>
								<div class="form-row-right-inner">
                              <!-- <div class="submit-btn-wrap">
                                   <div></div>
                                       <input type="submit" value="Search">
                                    </div>-->
                              
								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
                                      
                                      
                                      
                                      
                                </div><!-- /.header-block-1B -->

                                     </div>
                                </div><!-- /.header-block-1B -->

                           </div>
                           
                     
                   </div>
                </div>
                   </div>
                
                
                               <div class="row outter row-equal row-padding" style="display:none">
                    <div class="col-12 flex switch">
               
                       <div class="row inner row-equal row-padding link-alt">
                           <div class="col-12 flex">
                                <div class="collapsible">
                                   <h2><a class="expand-btn " href="#">Additional Search Filters</a></h2>
                                        <div class="cf"></div>
                               
                                 <div id="search-hidden" class=" hide">
                                    <div class="display-list">
                                  <div class="header-inner " >

                                      
 <div class="form-header " >
             <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                                                      <label>Select a Specifc Lyrical Mood</label>

								<select name='search[lyricalmoodid]'>
									<option value="">All</option>
<? outputSelectValuesForOtherTable( "lyricalmoods", $search[lyricalmoodid]); ?>
								</select>
<!--                                    <div class="select-wrapper">
                                        <label>Select a Specifc Lyrical Sub Theme</label>
								<select name='search[lyricalsubthemeid]'>
									<option value="">All</option>
<? outputSelectValuesForOtherTable( "lyricalsubthemes", $search[lyricalsubthemeid]); ?>
								</select>
                </div>-->

								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
     
     
     
                  <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
                                        <label>Select Songs in a Major or Minor Key</label>

								<select name='search[majorminor]'>
									<option value="">All</option>
<? outputSelectValuesDistinct( "majorminor", $search[majorminor] ); ?>
								</select>
                </div>
                                    
								</div>
								<div class="form-row-right-inner">
                                  <label>Select a Specifc BPM Range</label>
								<select name='search[exactbpm]'>
									<option value="">All</option>
<? outputSelectValuesDistinct( "TempoRange", $search[exactbpm], "Tempo" ); ?>
								</select>
								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
     
     
     
     
<!--rachel--> </div>
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                </div><!-- /.header-block-1B -->

                                     </div>
                                </div><!-- /.header-block-1B -->
 </div>
                           </div>
                           
                     
                   </div>
                </div>
                   </div>
                
                
                 

                            
            <div class="form-row-full quarter-select" style="margin-bottom:70px;">
							
								<div class="form-row-right-inner" style='width:100%;'>
                               <div class="submit-btn-wrap">
                                   <div></div>
                                       <input type="submit" value="Search">
                                    </div>
                              
								</div>
								
				<div class="cf"></div>
		</div>

                            
                            
                
                
                  
                </div>
        
       

        
        
        
        
               
           
		</section><!-- /.home-top -->

        

	</div><!-- /.site-body -->



<script type="text/javascript">		

		var slider = new MasterSlider();

		slider.control('arrows');	
		//slider.control('bullets' , {autohide:false, align:'bottom', margin:10});	
		slider.control('scrollbar' , {dir:'h',color:'#333'});

		slider.setup('masterslider' , {
		autoHeight:true,
             loop:true,
			width:1400,
			height:430,
			space:1,
			view:'basic',
            fullwidth:true
            
		});

	</script>



	<script>
        
               $(document).ready(function(){
        $("a.expand-btn").click(function(){
            $("a.expand-btn").toggleClass("collapse-btn");
            $("#search-hidden").toggleClass("hide show");
        });
    });

        

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
		    // if ($("#comp-select").val() == "Primary Genre") {
		    //    $('.comp-hidden-primary').removeClass('hide').addClass('show');
		    // }
		    // else {
		    //    $('.comp-hidden-primary').removeClass('show').addClass('hide');
		    // }
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
        e.preventDefault();
        if( $("#trendsearchform").valid() )
        {
            $("#trendsearchform").submit();
        }
    });



checkOutputFormat();

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

