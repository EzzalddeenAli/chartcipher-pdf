<?php 
include 'header.php'; 
$backurl = "chart-landing.php";
include "benchmarkreportfunctions.php";
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
                
 						<form class="search-form" method='get' name="benchmarkform" id="benchmarkform" action='benchmark-report.php'>
      <input type='hidden' name='searchtype' value='Benchmark'>

                

                 <div class="row outter row-equal row-padding">
                    <div class="col-12 flex switch">
               
                       <div class="row inner row-equal row-padding link-alt">
                           <div class="col-12 flex">
                               <div class="home-search-header">
                                        <h2>Benchmark Songs</h2>
                                        <div class="cf"></div>
                                </div>
                                 <div class="inner-content ">
                                    <div class="display-list">
                                  <div class="header-inner " >
                               
<div class="form-header adj" style="margin-bottom:50px;">
        <div class="form-column span-4 element-inline" style="vertical-align:middle;">
            <h3><input type="radio" name="searchby" id="range" value="Quarter" checked=""> <label for="range"><span></span> Select a Quarter Range</label></h3>
            <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
									<select name="search[dates][fromq]" id="fromq" onchange="resetYears()">
									<option value=""  disabled selected>Select</option>
                                       
  <? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
									</select>
                </div>
                                    
                  <div id="fromqerror"></div>
								</div>
								<div class="form-row-right-inner">
									<select name="search[dates][fromy]" id="fromy" onchange="resetYears()">
									<option value=""  disabled selected>Select</option>

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
									<select name="search[dates][toq]" id="toq" onchange="resetYears()">
									<option value=""  disabled selected>Select</option>
                                        
  <? outputSelectValues( $quarters, $search["dates"]["toq"] ); ?>
									</select>
                </div>
                                    
								</div>
								<div class="form-row-right-inner">
                                
									<select name="search[dates][toy]" id="toy" onchange="resetYears()">
									<option value=""  disabled selected>Select</option>
 
  <? outputSelectValues( $years, $search["dates"]["toy"] ); ?>
									</select>
								</div>
								<div class="cf"></div>
							</div><!-- /.form-row-left -->
            
            
            
            

       </div><div class="circle-wrap  element-inline"><div class="circle">-or-</div></div><div class="form-column span-4 element-inline" style="margin-right:0;vertical-align:top;">
            <h3><input type="radio" name="searchby" id="quarter" value="Year"> 
                <label for="quarter"><span></span> Or Year Range</label> </h3>
             <div class="form-row-full year-select">
                <div class="form-row-left-inner">
                  <select name="search[dates][fromyear]" id="fromyear" class="datesmustbevalidyear" onchange="resetQuarters()" <?=$searchby=="Year"?"":"disabled"?>>
                  <option value="" disabled selected>Select</option>
      <? outputSelectValues( $years, $search["dates"]["fromyear"] ); ?>
                  </select>
                </div>
<div class="range range-short ">to</div>
                <div class="form-row-right-inner">
                  <select name="search[dates][toyear]" id="toyear" class="datesmustbevalidyear" onchange="resetQuarters()" <?=$searchby=="Year"?"":"disabled"?>>
                  <option value="" disabled selected>Select</option>
      <? outputSelectValues( $years, $search["dates"]["toyear"] ); ?>
                  </select>
                </div>
                <div class="cf"></div>
              </div>
            <div class="form-row-full year-select">
                <div class="form-row-inner">
                 
                </div>
                <div class="cf"></div>
              </div>
                                  

       </div>
 </div>
                                      
 <div class="form-header " >
             <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
                                        <label>Benchmark Focus</label>
									<select id="benchmarktype" name="search[benchmarktype]" onChange="showSeasons( this.options[this.selectedIndex].value )">
									<option value="" disabled selected>(Select One)</option>

								<? outputSelectValues( $benchmarktypes, $search[benchmarktype] ); ?>
									</select>
                </div>
                                    
								</div>
								<div id="seasonaldiv" class="form-row-right-inner" style="display:<?=$search[benchmarktype]=="Seasonal Comparisons"?"":"none"?>">
                                    <div class="select-wrapper">
<label>Season (Use the command key to select multiple seasons.) </label>
									<select id="seasons" name="search[dates][season][]" multiple style="height:85px">
<?php
outputSelectValues( $seasons, $search["dates"]["season"] ); ?>
									</select>
</div>

								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
   



 </div>

             <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
                                        <label>Benchmark Aspect</label>
																		<select name="search[benchmarksubtype]" >
									<option value="" disabled selected>(Select One)</option>

								<? outputSelectValues( $benchmarksubtypes, $search[benchmarksubtype] ); ?>
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
                                    &nbsp;
								</div>
								<div class="form-row-right-inner">
                               <div class="submit-btn-wrap">
                                       <input type="submit" value="Search">
                                    </div>
                              
								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
 </div>
                                      
                                      
                                      
                                      
                                      
                                </div><!-- /.header-block-1B -->

                                     </div>
                                </div><!-- /.header-block-1B -->

                           </div>
                           
                     
                   </div>
                </div>
                   
                               <div class="row outter row-equal row-padding" style="display:none">
                    <div class="col-12 flex switch">
               
                       <div class="row inner row-equal row-padding link-alt">
                           <div class="col-12 flex">
                               <div class="collapsible">
                                   
                                   <h2><a class="expand-btn " href="#">Additional Search Filters</a>
                                   </h2>

                                        <div class="cf"></div>
                               
                                 <div id="search-hidden" class="hide">
                                    <div class="display-list">
                                  <div class="header-inner " >

                                      
 <div class="form-header " >
             <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
								</div>
								<div class="form-row-right-inner">
                                  <label>Select a Specific Genre</label>
									<select name="search[subgenreid]" >
									<option value=""  selected>All</option>
									<? outputSelectValuesForOtherTable( "subgenres", $search[subgenreid]); ?>
									</select>
								</div>
								
				<div class="cf"></div>
		</div><!-- /.form-row-left -->
     
     
                  <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
                                    <div class="select-wrapper">
                                        <label>Select a Specifc Lyrical Theme</label>
								<select name='search[lyricalthemeid]'>
									<option value="">All</option>
<? outputSelectValuesForOtherTable( "lyricalthemes", $search[lyricalthemeid]); ?>
								</select>
                </div>
                                    
								</div>
								<div class="form-row-right-inner">
                                  <label>Select a Specifc Lyrical Mood</label>

								<select name='search[lyricalmoodid]'>
									<option value="">All</option>
<? outputSelectValuesForOtherTable( "lyricalmoods", $search[lyricalmoodid]); ?>
								</select>
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
     
     
     
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                </div><!-- /.header-block-1B -->

                                     </div>
                                </div><!-- /.header-block-1B -->
                                     </div>
                           </div>
                           
                     
                   </div>
                </div>
                   </div>
                
                
                
                
                  
                </div>
            
            
            <div class="form-row-full quarter-select">
								<div class="form-row-left-inner">
                                    
								</div>
								<div class="form-row-right-inner">
                               <div class="submit-btn-wrap">
                                   <div></div>
                                    </div>
                              
								</div>
								
				<div class="cf"></div>
		</div>
            
        
       </div>

        
        
        
        
               
          
		</section><!-- /.home-top -->

        

	</div><!-- /.site-body -->





	<script>
        
        
        /*
		$(".header-block").click(function() {
  window.location = $(this).find("a").attr("href");
  return false;
});
  
        
        
        
        
 if(window.outerHeight){
       var w = window.outerWidth;
      var h = window.outerHeight;
  }
  else {
      var w  = document.body.clientWidth;
      var h = document.body.clientHeight; 
  }     
        
         var moreItems = document.querySelectorAll('.more-items');
        moreItems = [...moreItems];
        
        moreItems.forEach(element => console.log(element));
        
        console.log(w + 'this');
        
                if(w > 1702 || w < 1002){
            console.log('works');
             moreItems.forEach(element => element.style.display="none");     
        }else{
            moreItems.forEach(element => element.style.display="block");
        } 
   
    
    window.addEventListener('resize', function(event){
    var w  = document.body.clientWidth;
      var h = document.body.clientHeight;    
        
         var moreItems = document.querySelectorAll('.more-items');
        moreItems = [...moreItems];
        
        moreItems.forEach(element => console.log(element));
        
        console.log(w + 'this');
        
                if(w > 1702 || w < 1002){
            console.log('works');
             moreItems.forEach(element => element.style.display="none");     
        }else{
            moreItems.forEach(element => element.style.display="block");
        } 
});
        
        

        
              
    
       
            
        
        
       */ 

    
     
	</script>
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
                for( i = 0; i < document.forms["benchmarkform"].elements.length; i++ )
                {
                    if( document.forms["benchmarkform"].elements[i].name == "search[dates][fromq]" )
                        datefrom = document.forms["benchmarkform"].elements[i].value;
                    if( document.forms["benchmarkform"].elements[i].name == "search[dates][fromy]" )
                        datefromy = document.forms["benchmarkform"].elements[i].value;
                    if( document.forms["benchmarkform"].elements[i].name == "search[dates][toq]" )
                        dateto = document.forms["benchmarkform"].elements[i].value;
                    if( document.forms["benchmarkform"].elements[i].name == "search[dates][toy]" )
                        datetoy = document.forms["benchmarkform"].elements[i].value;
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
                for( i = 0; i < document.forms["benchmarkform"].elements.length; i++ )
                {
                    if( document.forms["benchmarkform"].elements[i].name == "search[dates][fromyear]" )
                        datefromyear = document.forms["benchmarkform"].elements[i].value;
                    if( document.forms["benchmarkform"].elements[i].name == "search[dates][toyear]" )
                        datetoyear = document.forms["benchmarkform"].elements[i].value;
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
                for( i = 0; i < document.forms["benchmarkform"].elements.length; i++ )
                {
                    if( document.forms["benchmarkform"].elements[i].name == "searchcriteria[artisttype]" )
                        selindex = document.forms["benchmarkform"].elements[i].selectedIndex;
                }
//                alert( value  + ": " + selindex );

                if( selindex > 0 && value == "" )
                {
                    return false;
                }

                return true;
            }, "* Please enter the name of a songwriter or artist.");

        $.validator.addMethod("onlyifseasons", function(value, element) {
		var val = $("#benchmarktype").val();
		//		alert( "chosen:" + val );
		var thesevalues = $("#seasons").val();
		//		alert( "these: " + thesevalues );

		if( val == "Seasonal Comparisons" && ((""+thesevalues) == "null" ) )
		    return false;
                return true;
            }, "* Please choose one or more seasons.");

		$('#benchmarkform').validate({
			onfocusout: false,
			onkeyup: false,
			onclick: false,
			rules: {
                  'search[benchmarktype]': { required: true },
                  'search[benchmarksubtype]': { required: true },
                  'graphtype': { required: true },
                  'search[dates][fromq]': { datesmustbevalid: true },
                  'search[dates][toq]': { datesmustbevalid: true },
                  'search[dates][fromy]': { datesmustbevalid: true },
                  'search[dates][toy]': { datesmustbevalid: true },
                  'search[dates][season][]': { onlyifseasons: true },
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
	document.forms["benchmarkform"].elements["graphtype"].selectedIndex = 0;
	checkOutputFormat();
	
    });

function checkOutputFormat()
{
		var chosentype = $('input[name=searchby]:checked').val();
		if( chosentype == "Year" )
		    {
			var same = true;
			for( i = 0; i < document.forms["benchmarkform"].elements.length; i++ )
			    {
				if( document.forms["benchmarkform"].elements[i].name == "search[dates][fromyear]" )
				    datefromy = document.forms["benchmarkform"].elements[i].value;
				if( document.forms["benchmarkform"].elements[i].name == "search[dates][toyear]" )
				    datetoy = document.forms["benchmarkform"].elements[i].value;
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
			for( i = 0; i < document.forms["benchmarkform"].elements.length; i++ )
			    {
				if( document.forms["benchmarkform"].elements[i].name == "search[dates][fromq]" )
				    datefrom = document.forms["benchmarkform"].elements[i].value;
				if( document.forms["benchmarkform"].elements[i].name == "search[dates][fromy]" )
				    datefromy = document.forms["benchmarkform"].elements[i].value;
				if( document.forms["benchmarkform"].elements[i].name == "search[dates][toq]" )
				    dateto = document.forms["benchmarkform"].elements[i].value;
				if( document.forms["benchmarkform"].elements[i].name == "search[dates][toy]" )
				    datetoy = document.forms["benchmarkform"].elements[i].value;
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
        if( $("#benchmarkform").valid() )
        {
            $("#benchmarkform").submit();
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

function showSeasons( val )
{
if( val == "Seasonal Comparisons" )
    $("#seasonaldiv").css( "display", "" );
else
    $("#seasonaldiv").css( "display", "none" );
}

        
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
