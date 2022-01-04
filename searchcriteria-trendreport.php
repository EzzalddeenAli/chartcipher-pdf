		<section class="search-results-top" style="padding-top: 0px">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-body">
						<h3><a class="expand-btn <?=$expanderdefaultclass?>" href="#">Search Criteria</a></h3>
						<div id="search-hidden" <?=$openeddefaultclass?>>
							<table width="100%" id="search-criteria-table">
								<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>
<? if( isset( $searchclientid ) ) { 
    $tmpurl = "industry-trend-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "searchclientid={$searchclientid}", "", $tmpurl );
$tmpurl .= "&searchclientid=";
?>
								<tr>
									<td class="search-column-1">
									Client:
</td>									<td class="search-column-2">

 								<select name="searchclientid" style="width:200px" onChange='document.location.href="<?=$tmpurl?>" + escape( this.options[this.selectedIndex].value )' >
								<option value="">Do Not Use</option>
<? 
outputSelectValues( getClients(), $searchclientid ); ?>

								</select>
</td></tr>

<? } ?>
		     <? 
if( !$search["dates"]["fromweekdate"] &&!$search["dates"]["fromyear"] ) { ?>
								<tr>
									<td class="search-column-1">

                         Dates: 
</td>									<td class="search-column-2">
									<select id="criteria-quarter" style="width: 200px" name="search[dates][fromq]" onChange="reloadTrendReport()">
<? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
									</select>
									<select id="criteria-year" style="width: 200px" name="search[dates][fromy]"  onChange="reloadTrendReport()">
<? 
outputSelectValues( $years, $search["dates"]["fromy"] ); ?>
									</select>
</td></tr>
								  <? } ?>
    <?php
if( 1 || $_SESSION["loggedin"] ) { 
    $tmpurl = "trend-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&genrefilter=". $genrefilter , "", $tmpurl );
$tmpurl .= "&genrefilter=";

    ?>
<? if( isset( $search[dates][season] ) ) { 
    $tmpurl = "trend-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "search[dates][season]={$search[dates][season]}", "", $tmpurl );
$tmpurl .= "&search[dates][season]=";
?>
								<tr>
									<td class="search-column-1">
									Season:
</td>									<td class="search-column-2">

 								<select name="search[dates][season]" style="width:200px" onChange='document.location.href="<?=$tmpurl?>" + escape( this.options[this.selectedIndex].value )' >
									<option value="">All</option>
<? 
outputSelectValues( $seasonswithall, $search["dates"]["season"] ); ?>

								</select>
</td></tr>

<? } ?>
								<tr>
									<td class="search-column-1">

                       Primary Genre: 
</td>									<td class="search-column-2">
								<select id="genrefilter" name="genrefilter" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value'>
									<option value="">All Primary Genres</option>
								<? outputSelectValues( $allgenresfordropdown, $_GET["genrefilter"] ); ?>
								</select>

                                </div><!-- /.form-row-right -->
</td></tr>

    <?php
      }
if( $_SESSION["loggedin"] ) { 
    $tmpurl = "trend-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&newcarryfilter=". $newcarryfilter , "", $tmpurl );
$tmpurl .= "&newcarryfilter=";

    ?>
								<tr>
									<td class="search-column-1">

                       New Songs / Carryovers: 
</td>									<td class="search-column-2">
								<select id="newcarryfilter" name="newcarryfilter" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value'>
									<option value="">All Songs</option>
	   <? outputSelectValuesForNewCarry( $newcarryfilter, "trend" )?>
								</select>

                                </div><!-- /.form-row-right -->
</td></tr>

    <?php
    $tmpurl = "trend-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&search[peakchart]=". $search[peakchart] , "", $tmpurl );
$tmpurl .= "&search[peakchart]=";

    ?>
								<tr>
									<td class="search-column-1">
<?=getPeakPositionDisplayName($search[peakchart] )?>
</td>									<td class="search-column-2">

 								<select name="search[peakchart]" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value' >
									<option value="">(Select One)</option>
    <? 

outputSelectValues( $peakvalues, $search["peakchart"] );

?>


    <?php
      }

    $tmpurl = "trend-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&graphtype=". $_GET["graphtype"] , "", $tmpurl );
$tmpurl = str_replace( "&graphtype=". $graphtype , "", $tmpurl );
$tmpurl .= "&graphtype=";
//echo( "$tmpurl -- $_GET[graphtype]" );
    ?>
<? if( !$doingthenandnow && isset( $_GET[graphtype] )){ ?>
								<tr>
									<td class="search-column-1">
    Output Format: 
</td>									<td class="search-column-2">
 								<select name="graphtype" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value' >
    <? foreach( array(  "column"=>"Bar Graph", "line"=>"Line Graph" ) as $pid=>$pval ) { ?>
      <option <?=$_GET["graphtype"] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                              <? } ?>
								</select>
</td></tr>
                                      <? } ?>
<? 
 if( $_SESSION["loggedin"] && $search["dates"]["fromweekdate"] )
 {
?>

								<tr>
									<td class="search-column-1">

                         Weeks: 
</td>									<td class="search-column-2">
<? $allllweekdates = db_query_array( "select OrderBy, Name from weekdates where OrderBy <= " . strtotime( "next Saturday" ) . " order by OrderBy desc" );
?>
									<select id="criteria-fromweek" style="width: 200px" name="search[dates][fromweekdate]" onChange="reloadTrendReportWD()">
<?  if( $_SESSION["loggedin"] ) { echo( "<option value=''>Please Choose</option>" ); } ?>
<? outputSelectValues( $allllweekdates, $search["dates"]["fromweekdate"] ); ?>
									</select>
									<select id="criteria-toweek" style="width: 200px" name="search[dates][toweekdate]"  onChange="reloadTrendReportWD()">
<?  if( $_SESSION["loggedin"] ) { echo( "<option value=''>Please Choose</option>" ); } ?>
<? outputSelectValues( $allllweekdates, $search["dates"]["toweekdate"] ); ?>
									</select>
<br><br>
									<select id="criteria-fromweeksecond" style="width: 200px" name="search[dates][fromweekdatesecond]" onChange="reloadTrendReportWD()">
<?  if( $_SESSION["loggedin"] ) { echo( "<option value=''>Please Choose</option>" ); } ?>
<? outputSelectValues( $allllweekdates, $search["dates"]["fromweekdatesecond"] ); ?>
									</select>
									<select id="criteria-toweeksecond" style="width: 200px" name="search[dates][toweekdatesecond]"  onChange="reloadTrendReportWD()">
<?  if( $_SESSION["loggedin"] ) { echo( "<option value=''>Please Choose</option>" ); } ?>
<? outputSelectValues( $allllweekdates, $search["dates"]["toweekdatesecond"] ); ?>
									</select>


</td></tr>

<?php

}
?>
<? 
 if( $_SESSION["loggedin"] && $search["dates"]["fromyear"] )
 {
?>

								<tr>
									<td class="search-column-1">

                         Years: 
</td>									<td class="search-column-2">
<? 
?>
									<select id="criteria-fromyear" style="width: 200px" name="search[dates][fromyear]" onChange="reloadTrendReportYear()">
<?  if( $_SESSION["loggedin"] ) { echo( "<option value=''>Please Choose</option>" ); } ?>
<? outputSelectValues( $years, $search["dates"]["fromyear"] ); ?>
									</select>
									<select id="criteria-toyear" style="width: 200px" name="search[dates][toyear]"  onChange="reloadTrendReportYear()">
<?  if( $_SESSION["loggedin"] ) { echo( "<option value=''>Please Choose</option>" ); } ?>
<? outputSelectValues( $years, $search["dates"]["toyear"] ); ?>
									</select>
</td></tr>

<?php

}
?>

							</table>	
						</div><!-- /.search-hidden -->	
					</div><!-- /.search-body -->
				</div><!-- /.search-container -->
			</div><!-- /.row -->
		</section><!-- /.search-results-top -->			
