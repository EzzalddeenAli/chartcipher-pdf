
function doAddNew( addtype, displaytype )
{
    var val = prompt( "Please enter a new value for " + displaytype + "." );
    if( val > "" )
	{
	    jQuery.post( "addnew.php", 
			 { "newval": val, 
   			   "type": addtype
			 }
			 ).done(function( data ) {
				 //				 alert( "Data Loaded: " + data );
				 var oldval = jQuery( "#second_" + addtype ).html();
				 jQuery( "#second_" + addtype ).html( oldval + data );
			     });
	    
	}

}



function addValue( fieldname, tablename, type )
{
    var value = $('#autosuggest' + fieldname ).val();
    var songid = $('#songid' ).val();
    // alert( "adding: " + type + ", " + songid + ", " + tablename + ", " + value );
    // return; 
    $.get( "addvalue.php", { type: type, songid: songid, tablename: tablename, value: value } )
	.done(function( data ) {
		if( data.trim() != "" )
		    {
			alert( data );
		    } 
		refreshDiv( tablename, fieldname, type );
		$('#autosuggest' + fieldname ).val('')
		    });
}




function refreshDiv( tablename, fieldname, type )
{   
    var songid = $('#songid' ).val();

    $.get( "updatevalues.php", { type: type, songid: songid, tablename: tablename, fieldname: fieldname } )
	.done(function( data ) {
		//        alert( "data is : " + data );                                                                                                                                                                                                       
		document.getElementById( fieldname + "_div" ).innerHTML = data;
	    });
}

function delValue( tablename, fieldname, connectorid, type )
{
    var songid = $('#songid' ).val();
    $.get( "delvalues.php", { tablename: tablename, fieldname: fieldname, songid: songid, connectorid: connectorid } )
	.done(function( data ) {
		refreshDiv( tablename, fieldname, type );
	    });
}



function resetAll( tabname )
{
    var allInputs = $( "#tabs-" + tabname + " :input" );
    for( i = 0; i < allInputs.length; i++ )
	{
	    if( allInputs[i].type == "checkbox" )
		allInputs[i].checked = false;
	    if( allInputs[i].type == "radio" )
		allInputs[i].checked = false;
	    if( allInputs[i].type == "text" )
		allInputs[i].value = "";
	}
    var allInputs = $( "#tabs-" + tabname + " select" );
    for( i = 0; i < allInputs.length; i++ )
	{
		allInputs[i].selectedIndex = 0;
	}
}

function fillBelow( ele )
{
    frm = document.forms[0];
    name = ele.name.substring( 0, 8 );
    for( i = 0 ; i < frm.elements.length; i++ )
	{
	    tmpname = frm.elements[i].name.substring( 0, 8 );
	    if( tmpname == name )
		{
		    frm.elements[i].selectedIndex = ele.selectedIndex;
		}
	}
}

function fillEnds( ele )
{
    // frm = document.forms[0];
    // name = ele.name.substring( 0, 8 );
    // for( i = 0 ; i < frm.elements.length; i++ )
    // 	{
    // 	    tmpname = frm.elements[i].name.substring( 0, 8 );
    // 	    if( tmpname == name )
    // 		{
    // 		    frm.elements[i].selectedIndex = ele.selectedIndex;
    // 		}
    // 	}
}

function checkAllReports( val )
{
    frm = document.forms[0];
    for( i = 0 ; i < frm.elements.length; i++ )
	{
	    if( frm.elements[i].type == "checkbox" )
		frm.elements[i].checked = val;
	}
    return false;
}
