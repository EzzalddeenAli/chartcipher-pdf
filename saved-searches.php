<?php include 'header.php';

$issavedsearch = 1;
if( isEssentials() ) 
{
Header( "Location: index.php?l=1" );
exit;
}

$allcharts = db_query_array( "select id, Name from charts", "id", "Name" );
if( $delid )
{
	db_query( "delete from savedsearches where userid = '$userid' and id = $delid" );
//	$err = "<font color='red'>Deleted.</font>";
}
if( $delall )
{
	$ext = $_COOKIE["proxyloginid"]?" and proxyloginid = '$_COOKIE[proxyloginid]'":"";
	db_query( "delete from savedsearches where userid = '$userid' $ext " );
	header("Location: saved-searches.php?errmsg=delall");

}
if( $errmsg == "delall" )
{
	$err = "<font color='red'>Deleted all saved searches.</font>";
}
?>
<style type="text/css">
.editable { cursor: pointer; }

.search-header h1 { float:none; }

.search-header h2 {
    margin-top: 15px;
    color: #7a7a7a;
    font-size: 14px;
}
</style>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1><?=getOrCreateCustomTitle( "My Dashboard", "My Dashboard" )?></h1>

<!--
<h2>    <? $cust = getOrCreateCustomHover( "saved-searches", "View and manage your saved searches." );?>
<?=$cust?></h2>-->

						<a href="#" class="search-header-manage">Manage</a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
<?=$err?>
						<table width="100%" id="saved-searches-table">
    <tbody>
							<tr>
								<th>
									Name
								</th>
								<th>
									Chart
								</th>
								<th>
									View Search Criteria
								</th>
								<th>
									Date Saved
								</th>
								<th>
									View Results
								</th>
								<th>
									<a href="saved-searches.php?delall=1" class="delete-btn-all">Delete All</a>
								</th>
							</tr>
        
<? $searches = getSavedSearches(); 
foreach( $searches as $s ) { 
//print_r( $s );
	 $url = $s[url];
//	 if( strpos( $url , "?" ) === false )
//	 	 $url .= "?" ; 
//		 $url .= "&savedid={$s[id]}";
	 $query = "";
	 switch( $s[searchtype] ){  
         case "Song":
             $query = "song-search";
             $searchurl = str_replace( "search-results", $query, $s[url] );
             break; 
         case "Song Title":
             $query = "song-title-search";
             $searchurl = str_replace( "search-results", $query, $s[url] );
             break; 
         case "Spotlight":
             $searchurl = $s[url];
             break; 
         case "Levels":
             $searchurl = $s[url];
             break; 
             
         case "Benchmark":
             $query = "benchmark";
             $searchurl = str_replace( "benchmark-report", $query, $s[url] );
             break; 
             
         case "Comparative":
             $query = "comparative-search";
             $searchurl = str_replace( "comparative-search-results", $query, $s[url] );
             break; 
             
         case "Songwriter":
             $query = "songwriter-search";
             $searchurl = str_replace( "search-results", $query, $s[url] );
             break; 
             
         case "Record Label":
             $query = "label-search";
             $searchurl = str_replace( "search-results", $query, $s[url] );
             break; 
             
         case "Song Form":
             $query = "form-search";
             $searchurl = str_replace( "search-results", $query, $s[url] );
             break; 
             
         case "Performing Artist":
             $query = "artist-search";
             $searchurl = str_replace( "search-results", $query, $s[url] );
             break; 
             
         case "Performing Artist":
             $query = "artist-search";
             $searchurl = str_replace( "search-results", $query, $s[url] );
             break; 
             
         case "Trend":
	     	     parse_str( $s[url], $tmpattrs);
	     if( $tmpattrs["searchsubtype"] ) $query = $tmpattrs["searchsubtype"] . "-search";
		//	     print_r( $tmpattrs );
             $searchurl = str_replace( "trend-search-results", $query, $s[url] );
             break; 
         case "Artist Genre":
             $query = "artist-genre-search";
             $searchurl = str_replace( "artist-genre-search-results", $query, $s[url] );
             break; 
         case "Artist Pairing":
             $query = "primary-artist-genre-search";
             $searchurl = str_replace( "artist-pairing-search-results", $query, $s[url] );
             break; 
             
         case "Trend Report":
             $query = "trend-report";
             $searchurl = str_replace( "trend-report-search", $query, $s[url] );
             break; 
             
         case "Compositional Trends By Weeks":
             $query = "search";
             $searchurl = str_replace( "search-results", $query, $s[url] );
             break; 
             
         case "Industrial Trend Report":
             $query = "industry-trend-report-search";
             $searchurl = str_replace( "industry-trend-report", $query, $s[url] );
             break; 
             
         case "Technique":
         case "Genre":
             $query = "search";
             $searchurl = str_replace( "search-results", $query, $s[url] );
	     break;
         default: 
             $query = "advanced-search";
             $searchurl = str_replace( "search-results", $query, $s[url] );
     }
//     echo( $searchurl );
?>
							<tr class="saved-searches-table-row" data-href="<?=$searchurl?>" id="ss<?=$s[id]?>">
								<td data-label="Name" class="search-column-1 " > 
<span id="span<?=$s[id]?>" class='editable'><?=$s[Name]?></span>
								</td>
								<td data-label="Chart" class="search-column-2">
<?= $allcharts[$s["chartid"]]?>
								</td>
								<td data-label="Search Type" class="search-column-2">
<a href="<?=$searchurl?>">View Search Criteria</a> 
								</td>
								<td data-label="Date" class="search-column-3">
<?=prettyFormatDate( $s[dateadded] ) ?>
								</td>
								<td data-label="Results" class="search-column-3">
<a href="<?=$url?>">Results</a>
								</td>
								<td class="search-column-4">
									<a href="saved-searches.php?delid=<?=$s[id]?>" onClick='return confirm( "Are you sure you want to delete this saved search?" )' class="delete-btn">Delete</a>
									<a href="<?=$url?>"><img src="assets/images/home/search-arrow-icon.svg" /></a>
									<a class="view-song" href="<?=$url?>">View</a>
                                    <div class="cf"></div>
								</td>
							</tr>
<?} 
if( !count( $searches ) ) { 
?>
							<tr >
								<td  class="search-column-1">
None saved yet.
								</td>
								<td  class="search-column-2">
								</td>
								<td  class="search-column-3">
								</td>
								<td class="search-column-4">
								</td>
                                <td class="search-column-4">
								</td>
							</tr>
<? } ?>
</tbody>
						</table>
					</div><!-- /search-body -->
				</div><!-- /.search-container -->
			</div>
		</section><!-- /.song-title-top -->
	</div><!-- /.site-body -->
	<script>
	$(document).ready(function(){
	    $(".search-header-manage").click(function(){
	        $(".delete-btn").toggleClass("show");
	        $(".delete-btn-all").toggleClass("show");
	        $(".search-column-4 img").toggleClass("hide");
	    });

	    $(".search-table").on('click','.delete-btn',function(){
    		$(this).closest('tr').remove();
    	});

	    $(".search-table").on('click','.delete-btn-all',function(){
    		$(".search-table").empty();
      	});
	});
 $(function () {
    //Loop through all Labels with class 'editable'.
    $(".editable").each(function () {
        //Reference the Label.
        var label = $(this);
 
 labelname = label.attr( "id" ).replace( "span", "" );
// alert( labelname );
        //Add a TextBox next to the Label.
        label.after("<input name='labelname[" + labelname + "]' type='text' style = 'display:none' />");
 
        //Reference the TextBox.
        var textbox = $(this).next();
 
        //Set the name attribute of the TextBox.
        textbox[0].name = this.id.replace("lbl", "txt");
 
        //Assign the value of Label to TextBox.
        textbox.val(label.html());
 
        //When Label is clicked, hide Label and show TextBox.
	textbox.click(function ( e ) {
	e.stopPropagation();
	});
        label.click(function ( e ) {
	e.stopPropagation();
            $(this).hide();
            $(this).next().show();
        });
 
        //When focus is lost from TextBox, hide TextBox and show Label.
        textbox.focusout(function () {
                name = $(this).attr( "name" ).replace( "span", "" ); 
                val = $(this).val();
                $.ajax({
                      method: "GET",
                            url: "updatessname.php?toupdate[" + name + "]=" + escape( val )
                            });
                
            $(this).hide();
            $(this).prev().html($(this).val());
            $(this).prev().show();
        });
    });
});
  $( function() {
          $( "table tbody" ).sortable( {
                update: function( event, ui ) {
                      // $(this).children().each(function(index) {
                      //         $(this).find('td').last().html(index + 1)
                      //             });

                      var toup = "";
                      $(".saved-searches-table-row").each(function(index) {
                              toup += "," +  $(this).attr( "id" );
                          });
//                      alert( toup );
                      $.ajax({
                            method: "GET",
                                  url: "updatesavedsearches.php?update=" + toup
                                  });
                  }
                  
              });
      } );

	</script>	
<?php include 'footer.php';?>
