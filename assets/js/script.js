function saveSearch( type )
{
    saveSeach( type, "" );
}

function saveSearch( type, searchType )
{
var val = $("#searchnamehidden").val();
var userid = $("#userid").val();
var proxyloginid = $("#proxyloginid").val();
if( val == "" && type == "saved" )
{
alert( "Please give this search a name" );
return false;
}

if( type == "recent" )
{
	val = searchName;
}
var  formData = "searchtype=" + searchType + "&userid=" + userid + "&chartid=" + mychartatend + "&proxyloginid=" + proxyloginid + "&type=" + type + "&sessid=" + sessid + "&url=" + encodeURIComponent( document.location.href );  //Name value Pair
formData += "&searchname=" + encodeURIComponent( val );
 
$.ajax({
    url : "saveSearch.php",
    type: "POST",
    data : formData,
    success: function(data, textStatus, jqXHR)
    {
            //data - response from server
//        alert( nextUrl );
	if( type == "recent" )
	{
        $(".appendid").each( function( index, value ) {
                $(this).attr('href', $(this).attr("href") + "?sid=" + data);
            });
	}
	if( type == "saved" || type == "savedartists" )
    {
        var current = $.featherlight.current();
		current.close();
//        alert( "Search saved." );
    }
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
//    alert( "error" ); 
    }
});    

}
function addFavorite( songid )
{
var userid = $("#userid").val();
var  formData = "favoriteid=" + songid + "&userid=" + userid;  //Name value Pair
 
$.ajax({
    url : "addFavorite.php",
    type: "POST",
    data : formData,
    success: function(data, textStatus, jqXHR)
    {	     
    if( data == "removed" )
    {
        $("#savesong").html( "Save Song" );
	}
    else
    {
        $("#savesong").html( "Remove Song" );
    }
        //data - response from server
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
//    alert( "error" ); 
    }
});    

}

function addTechnique( tsid )
{
var userid = $("#userid").val();
var  formData = "favoriteid=" + tsid + "&userid=" + userid;  //Name value Pair
 
$.ajax({
    url : "addTechnique.php",
    type: "POST",
    data : formData,
    success: function(data, textStatus, jqXHR)
    {	     
    if( data == "removed" )
    {
        $("#savetechnique").html( "Add Technique" );
	}
    else
    {
        $("#savetechnique").html( "Remove<br>Technique" );
    }
        //data - response from server
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
//    alert( "error" ); 
    }
});    

}

// no VB because they're the same
var allSections = [    "I",     "A",     "PC",     "B",     "C",     "O",     "IB",     "VB", "OS",     "T" ];


function hideSections( val )
{
    if( val == "" )
    {
        for( var i = 0; i < allSections.length; i++ )
        {
            var area = allSections[i];
            $(".container-" + area ).prop( "disabled", false );
        }
    }
    else
    {
        val = val.replace(/[0-9]/g, '');
        var res = val.split( "-" );
//        alert( res );
        for( var i = 0; i < allSections.length; i++ )
        {
            var area = allSections[i];
            var foundit = res.indexOf( area ) > -1;
            if( foundit )
                $(".container-" + area ).prop( "disabled", false );
            else
                $(".container-" + area).prop( "disabled", true );
        }
            
    }
}

function clear_form_elements(idname) {
  jQuery("#"+idname).find(':input').each(function() {
    switch(this.type) {
        case 'password':
        case 'text':
        case 'textarea':
        case 'file':
        case 'select-one':
        case 'select-multiple':
            jQuery(this).val('');
            break;
        case 'checkbox':
        case 'radio':
            this.checked = false;
    }
  });
}


function doLogin()
{
var username = $(".featherlight-inner #loginemail").val();
var password = $(".featherlight-inner #loginpass").val();

var  formData = "username=" + username + "&password=" + password;

$.ajax({
    url : "dologin.php",
    type: "POST",
    data : formData,
    dataType: "json", 
    success: function(response)
    {
        if( response.id )
        {
            createCookie( "proxyloginid", response.id );
            window.location.reload(true); 
        }
        else
        {
            $(".featherlight-inner #loginerr").html( "<font color='red'>No such email/password were found.</font>" );
        }

    }
});    

return false;
}


function createProfile()
{
var username = $(".featherlight-inner #createemail").val();
var firstname = $(".featherlight-inner #createfirstname").val();
var lastname = $(".featherlight-inner #createlastname").val();
var facultyorstudent = $(".featherlight-inner #facultyorstudent").val();
var password = $(".featherlight-inner #createpass").val();
var userid = $("#userid").val();

var  formData = "username=" + username + "&password=" + password+ "&facultyorstudent=" + facultyorstudent+ "&firstname=" + firstname+ "&lastname=" + lastname + "&userid=" + userid ;
$.ajax({
    url : "docreate.php",
    type: "POST",
    data : formData,
    dataType: "json", 
    success: function(response)
    {
        if( response.id )
        {
            createCookie( "proxyloginid", response.id );
            window.location.reload(true); 
        }
        else
        {
            $(".featherlight-inner #loginerr").html( "<font color='red'>Error creating account.</font>" );
        }

    }
});    

return false;
}




var createCookie = function(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}
    

function reloadTrendReport()
{
	url="trend-report.php?search[dates][fromq]=" + $('#criteria-quarter').val() + "&search[dates][fromy]=" + $('#criteria-year').val();
    url = addJQVar( url, "newcarryfilter" ); 
    url = addJQVar( url, "genrefilter" ); 
    document.location.href = url;
}
function reloadIndustryTrendReport()
{
	url="industry-trend-report.php?search[dates][fromq]=" + $('#criteria-quarter').val() + "&search[dates][fromy]=" + $('#criteria-year').val();
    url = addJQVar( url, "newcarryfilter" ); 
    url = addJQVar( url, "genrefilter" ); 
    document.location.href = url;
}
function reloadCollabReport()
{
    url="collaborations-report.php?search[dates][fromq]=" + $('#criteria-quarter').val() + "&search[dates][fromy]=" + $('#criteria-year').val();
    url = addJQVar( url, "searchclientid" ); 
    document.location.href = url;
}
function reloadIndustryTrendReportWD()
{
	url="industry-trend-report.php?search[dates][fromweekdate]=" + $('#criteria-fromweek').val() + "&search[dates][toweekdate]=" + $('#criteria-toweek').val();
    url = addJQVar( url, "newcarryfilter" ); 
    url = addJQVar( url, "genrefilter" ); 
    document.location.href = url;
}
function reloadIndustryTrendReportYear()
{
	url ="industry-trend-report.php?search[dates][fromyear]=" + $('#criteria-fromyear').val() + "&search[dates][toyear]=" + $('#criteria-toyear').val();
    url = addJQVar( url, "newcarryfilter" ); 
    url = addJQVar( url, "genrefilter" ); 
    document.location.href = url;
}

function reloadCollabReportYear()
{
	url ="collaborations-report.php?search[dates][fromyear]=" + $('#criteria-fromyear').val() + "&search[dates][toyear]=" + $('#criteria-toyear').val();
    url = addJQVar( url, "searchclientid" ); 
    document.location.href = url;
}

function reloadTrendReportWD()
{
	url ="trend-report.php?search[dates][fromweekdate]=" + $('#criteria-fromweek').val() + "&search[dates][toweekdate]=" + $('#criteria-toweek').val();
    url = addJQVar( url, "newcarryfilter" ); 
    url = addJQVar( url, "genrefilter" ); 
    document.location.href = url;
}
function reloadTrendReportYear()
{
	url ="trend-report.php?search[dates][fromyear]=" + $('#criteria-fromyear').val() + "&search[dates][toyear]=" + $('#criteria-toyear').val();
    url = addJQVar( url, "newcarryfilter" ); 
    url = addJQVar( url, "genrefilter" ); 
    document.location.href = url;
}

function addJQVar( url, sel )
{

    if( $("#"+sel ).length )
    {
	url += "&" + sel + "=" + $("#" + sel ).val();
    }
    return url;
}

                                                                                                                                                                                   function compareDataPointYAscend(dataPoint1, dataPoint2) {
    return dataPoint1.y - dataPoint2.y;
}

function compareDataPointYDescend(dataPoint1, dataPoint2) {
//    alert( "comparing " + dataPoint2.y + ", " + dataPoint1.y );
    return dataPoint2.y - dataPoint1.y;

}
$(document).ready(function(){ 

    $(".search-header-clear").click(function() { 
	    $(':input')
	    .not(':button, :submit, :reset, :hidden')
	    .val('')
	    .prop('checked', false)
	    .prop('selected', false);
    });

} );


function geturl(){
    url = document.location.href;
    if( url.indexOf( "?" ) == -1 )
	url += "?";
    url += "&setchart=" + mychartatend;
//    alert( url )
    return url;
}

function getrandom() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 5; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}

function send_request(url, hash) {
var  formData = "url=" + escape( url ) + "&" + "hash=" + escape( hash );
$.ajax({
    url : "createshortened.php",
    type: "POST",
    async: false,
    data : formData,
    dataType: "json", 
    success: function(response)
    {
	Clipboard.copy(response.val);
	//	alert( "The shortened URL\n" + response.val + "\nhas been copied to your clipboard." );
    }
}
);
}
function shorturl(){
    var longurl = geturl();
    send_request(longurl, getrandom() );
}

function shorturl2(){
    var longurl = geturl();
    var hash = getrandom() ;
    Clipboard.copy("https://db.hitsongsdeconstructed.com/" + hash );
    send_request(longurl, hash);
    $("#copylink").text( "Copied!" );
    setTimeout(function(){ $("#copylink").text( "Copy Link" ); }, 2000 );
}

function maillink(subject){
    var longurl = geturl();
    var hash = getrandom() ;
    send_request(longurl, hash);
    window.open( "mailto:?subject=" + escape( subject ) + "&body=" +  "https://db.hitsongsdeconstructed.com/" + hash );
}

// var hashh = window.location.hash.substr(1)

// if (window.location.hash != "") {
//     $.getJSON(endpoint + "/" + hashh, function (data) {
//         data = data["result"];

//         if (data != null) {
//             window.location.href = data;
//         }

//     });
// }

window.Clipboard = (function(window, document, navigator) {
    var textArea,
        copy;

    function isOS() {
        return navigator.userAgent.match(/ipad|iphone/i);
    }

    function createTextArea(text) {
        textArea = document.createElement('textArea');
        textArea.value = text;
        document.body.appendChild(textArea);
    }

    function selectText() {
        var range,
            selection;

        if (isOS()) {
            range = document.createRange();
            range.selectNodeContents(textArea);
            selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
            textArea.setSelectionRange(0, 999999);
        } else {
            textArea.select();
        }
    }

    function copyToClipboard() {        
        document.execCommand('copy');
        document.body.removeChild(textArea);
    }

    copy = function(text) {
        createTextArea(text);
        selectText();
        copyToClipboard();
    };

    return {
        copy: copy
    };
})(window, document, navigator);

// function myFunction() {
//   /* Get the text field */
//   var copyText = document.getElementById("whatever");

//   /* Select the text field */
//   copyText.select();
//   copyText.setSelectionRange(0, 99999); /*For mobile devices*/

//   /* Copy the text inside the text field */
//   document.execCommand("copy");

//   /* Alert the copied text */
//   alert("Copied the text: " + copyText.value);
// } 


function showAllArticles()
{
    $("#articlestable tr" ).removeClass( "hidden" );
    $(".more-art").addClass( "hidden" );
}
