	</div><!-- .site-content -->
</div><!-- .sidebar & contant wrap -->
	<script type="text/javascript">

/*$('.info-block a').hover(function() {
var href = $(this).attr("href");
window.location.href = href;
return false;
});

$(document).ready(function() {

            $('.info-block a .modal-hover-icon').hover(

               function () {
                 var id = $(this).parent().attr("data-target");
                 $(id).addClass("selected");
               },

               function () {
                  $(".modalDialog.selected").removeClass("selected");
               }
            );

         });




      $( ".info-block a .modal-hover-icon" ).mouseenter(function() {
          var id = $(this).parent().attr("data-target");
          $(id).addClass("selected");
      });
      $( ".info-block a .modal-hover-icon" ).mouseleave(function() {
           $(".modalDialog.selected").removeClass("selected");
      });*/



        $('.info-block a').click(function() {
          $(".modalDialog.selected").removeClass("selected");
        /* var id = $(this).attr("href");*/
         var id = $(this).attr("data-target");
         $(id).addClass("selected");
         });

         $('.close').click(function() {
           $(".modalDialog.selected").removeClass("selected");
          });


$(function() {
$(".modalDialog").click(function(e) {
if ($(e.target).closest(".modalDialog div").length) {

} else {
  $(".modalDialog.selected").removeClass("selected");
    return false;
}
});
})
	       </script>

<script>
$(document).ready(function(){
    $(".sidebar-toggle-box").click(function(){
        $(".site-sidebar").toggleClass("hide-sidebar");
        $(".site-content").toggleClass("merge-left");
    });
    
    
          $(window).resize(function(){
                if ($(window).width() > 1150) {
                      $( ".site-content" ).removeClass( "merge-left" );
                     $( ".site-sidebar" ).removeClass( "hide-sidebar" );
                }
         }); 
    
    

//	$("#saved-searches-table tr, .home-search tr").click(function() {
//        window.document.location = $(this).data("href");
//    });
	$(".home-search-body tr").click(function() {
            if( $(this).data("href") > "" )
                window.document.location = $(this).data("href");
   });

    $(".site-sidebar ul li a").filter(function(){
    	return this.href == location.href.replace(/#.*/, "");
	}).addClass("active");
    
    

	$('.search-header-clear').click(function(){
		$('.search-header-clear-section').each(function(){
		$(this).click();
		});
 	});
    
    
    
    
    
	$('.search-header-clear-section').click(function(){
            var id = $(this).attr( 'id' );
            id = id.replace( "-cs", "" );
//            alert( id );
            clear_form_elements( id );

 	});
<?php
foreach( $autosuggesttables as $key=>$fields ) {
?>
<? foreach( $fields as $f ) {
   $type = $key;
   if( strpos( $f, "writer" ) !== false )
         $type = "writer";
   if( strpos( $f, "featured" ) !== false )
         $type = "featuredartist";
?>
			$( "#autosuggest<?=$f?>" ).autocomplete({
				source: "autocomplete.php?type=<?=$type?>",
				minLength: 2
				    });
			<? } ?>
<? } ?>
			$( "#autosuggestprimaryartist" ).autocomplete({
				source: "autocomplete.php?type=primaryartist",
				    });

			$( "#search-fullform" ).autocomplete({
				source: "autocomplete.php?type=form",
				minLength: 1
				    });
			$( "#search-key" ).autocomplete({
				source: "autocomplete.php?type=key",
				minLength: 1
				    });

});

</script>
<script>
	$(function() {
    	$( ".info-icon" ).tooltip({
        tooltipClass: "hoverbox",
        position: {  my: "center bottom-15",
        at: "center bottom"}
	});
});
</script>
<? if( 1 == 0 ) { ?>
<div style="display:none">
<div id="mystudentcreate">

		<section class="faculty-section">
			<div class="element-container row">
				<div class="faculty-container">
					<div class="faculty-login">
						<div class="faculty-login-header">
							<h2>Create Profile</h2>
						</div><!-- ./faculty-login-header -->
						<div class="faculty-login-body">
							<form>
							<span id="createerr"></span>
                                	<div class="form-row-full">
									<label>First Name</label>
									<input name="createfirstname" id="createfirstname" type="text" placeholder="First Name" />
								</div><!-- /.form-row-full -->
									<div class="form-row-full">
									<label>Last Name</label>
									<input id="createlastname" name="createlastname" type="text" placeholder="Last Name"/>
								</div><!-- /.form-row-full -->
                                	<div class="form-row-full">
                                        <label>Faculty or Student</label>
                                  <select id="facultyorstudent" name="facultyorstudent">
                                 <option selected="selected" disabled="disabled">Please select one</option>
								<option value="student">Student</option>
								<option value="faculty">Faculty</option>
							</select>
                                </div>
								<div class="form-row-full">
									<label>E-Mail Address</label>
									<input id="createemail" type="text" placeholder="E-Mail Address" />
								</div><!-- /.form-row-full -->
								<div class="form-row-full">
									<label>Password</label>
									<input id="createpass" type="password"/>
								</div><!-- /.form-row-full -->
								<div class="form-row-full">
									<input type="submit" style="margin: 0 auto;float: none;display: block;" value="Create Profile" onClick="javascript: return createProfile()" />
								</div>
								<div class="cf"></div>
							</form>

						</div><!-- ./faculty-login-body -->
					</div><!-- /.faculty-login -->
				</div><!-- /.faculty-login-container -->
			</div><!-- /.element-container -->
		</section>
</div>
<div id="mystudentlogin">

		<section class="faculty-section">
			<div class="element-container row">
			<div class="faculty-container">
					<div class="faculty-login">
						<div class="faculty-login-header">
							<h2>Login</h2>
						</div><!-- ./faculty-login-header -->
						<div class="faculty-login-body">
							<form>
<span id="loginerr"></span>
								<div class="form-row-full">
									<label>E-Mail Address</label>
									<input id="loginemail" type="text" placeholder="E-Mail Address" />
								</div><!-- /.form-row-full -->
								<div class="form-row-full">
									<label>Password</label>
									<input id="loginpass" type="password"/>
<!--<a href="#" style="font-size: 12px;margin: 10px 0;display: inline-block;">Forgot Password</a>-->
								</div><!-- /.form-row-full -->
                                <div class="form-row-full">
									<input type="submit" style="margin: 0 auto;float: none;display: block;" value="Log In" onClick="return doLogin()" id="login-btn" />
								</div>
								<div class="cf"></div>
							</form>

						</div><!-- ./faculty-login-body -->
					</div><!-- /.faculty-login -->
				</div><!-- /.faculty-login-container -->
			</div><!-- /.element-container -->
		</section>
</div>
</div>
<? } ?>
<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="up fa fa-arrow-up" aria-hidden="true"></i></button>

<script>
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}


</script>

<script type="text/javascript">
$( document ).ready(function() {
		$('label').contents().filter(function() {
	     return this.nodeType == 3
	      }).each(function(){
	     this.textContent = this.textContent.replace(/:/, " ")
	      });
});


</script>

<script type="text/javascript">

    (function(e,t,o,n,p,r,i){e.visitorGlobalObjectAlias=n;e[e.visitorGlobalObjectAlias]=e[e.visitorGlobalObjectAlias]||function(){(e[e.visitorGlobalObjectAlias].q=e[e.visitorGlobalObjectAlias].q||[]).push(arguments)};e[e.visitorGlobalObjectAlias].l=(new Date).getTime();r=t.createElement("script");r.src=o;r.async=true;i=t.getElementsByTagName("script")[0];i.parentNode.insertBefore(r,i)})(window,document,"https://diffuser-cdn.app-us1.com/diffuser/diffuser.js","vgo");

    vgo('setAccount', '475744837');

    vgo('setTrackByDefault', true);

 

    vgo('process');

</script>
<? 
$tmpurl = $_SERVER["REQUEST_URI"] . "?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&setchart=". $chartid , "", $tmpurl );
$tmpurl = str_replace( "&setchart=". $setchart , "", $tmpurl );
if( strpos( $tmpurl, "?" ) === false )
    $tmpurl .= "?";
$tmpurl .= "&setchart=";
?>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '287943558203756', {
em: 'insert_email_variable'
});
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=287943558203756&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->



<script>
var x, i, j, l, ll, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 0; j < ll; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
//	    alert( s.id );
	    if( s.id == "mysetchart" )
	    {
<? 
//print_r( $_SERVER );
    $tmpurl = $_SERVER['SCRIPT_URL'] . "?" . urldecode( $_SERVER['QUERY_STRING'] );
    if( $_GET["setchart"] )
        $tmpurl = str_replace( "setchart=". $_GET["setchart"] , "", $tmpurl );

?>
	    	    document.location.href = "<?=$tmpurl?>&setchart=" + s.options[i].value;
		    	    break;
	    }
	    else 	    if( s.id == "mysetquarter" )	
	    {
<? 
//print_r( $_SERVER );
    $tmpurl = $_SERVER['SCRIPT_URL'] . "?" . urldecode( $_SERVER['QUERY_STRING'] );
    if( $_GET["thisquarter"] )
    {
        $tmpurl = str_replace( "thisquarter=". $_GET["thisquarter"] , "", $tmpurl );
	}
    if( $_GET["search"]["comparisonaspect"] )
    {
        $tmpurl = str_replace( "search[comparisonaspect]=". $_GET["search"]["comparisonaspect"] , "", $tmpurl );
	}

?>
	    	    document.location.href = "<?=$tmpurl?>&thisquarter=" + s.options[i].value;
		    	    break;
	    }
	    else if( s.id == "mysetbenchmark" )
	    {
	    	    document.location.href = "<?=$benchmarkurlwithouttype?>&search[benchmarktype]=" + encodeURIComponent( s.options[i].value );
		    	    break;
	    }
	    else if( s.id == "mysetreport" )
	    {
		document.location.href = s.options[i].value;
		break;
	    }
	    else if( s.id == "mysetbenchmarktype" )
	    {
	    	    document.location.href = "<?=$benchmarkurlwithoutsubtype?>&search[benchmarksubtype]=" + encodeURIComponent( s.options[i].value );
		    	    break;
	    }
	    else if( s.id == "mysetgraphtype" )
	    {
	    	    document.location.href = "<?=$benchmarkurlwithoutsubtype?>&graphtype=" + encodeURIComponent( s.options[i].value );
		    	    break;
	    }
	    else
	    {
	    	    document.location.href = "<?=$tmpurl?>" + s.options[i].value;
		    	    break;
	    }

            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);

var mychartatend = <?=$chartid?>;
</script>   


</body>
</html>
