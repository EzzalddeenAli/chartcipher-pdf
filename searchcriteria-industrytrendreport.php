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
<? 
if( !$basetype ) $basetype = "industry-trend-report";
if( $iscollabs )
    $basetype = "collaborations-report";

if( isset( $searchclientid ) ) { 
    $tmpurl = "{$basetype}.php?" . urldecode( $_SERVER['QUERY_STRING'] );
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
<?  if( !$doingweeklysearch && !$doingyearlysearch ) { ?>
								<tr>
									<td class="search-column-1">

                         Dates: 
</td>									<td class="search-column-2">
									<select id="criteria-quarter" style="width: 200px" name="search[dates][fromq]" onChange="reloadIndustryTrendReport()">
<? echo( "<option value=''>Please Choose</option>" ); ?>
<? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
									</select>
									<select id="criteria-year" style="width: 200px" name="search[dates][fromy]"  onChange="reloadIndustryTrendReport()">
<?  echo( "<option value=''>Please Choose</option>" ); ?>
<?  outputSelectValues( $years, $search["dates"]["fromy"] ); ?>
									</select>
</td></tr>
    <?php
}
if( $_GET["genrefilter"] ) { 
    $tmpurl = "{$basetype}.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&genrefilter=". $genrefilter , "", $tmpurl );
$tmpurl .= "&genrefilter=";

    ?>
								<tr>
									<td class="search-column-1">

                       Primary Genre: 
</td>									<td class="search-column-2">
								<select id="genrefilter" name="genrefilter" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value'>
									<option value="">All Genres</option>
								<? outputSelectValues( $allgenresfordropdown, $genrefilter ); ?>
								</select>

                                </div><!-- /.form-row-right -->
</td></tr>
<? } 
 if( $doingweeklysearch && $search["dates"]["fromweekdate"] )
 {
?>

								<tr>
									<td class="search-column-1">

                         Weeks: 
</td>									<td class="search-column-2">
<? $allllweekdates = db_query_array( "select OrderBy, Name from weekdates where OrderBy <= " . strtotime( "next Saturday" ) . " order by OrderBy desc" );
?>
									<select id="criteria-fromweek" style="width: 200px" name="search[dates][fromweekdate]" onChange="reloadIndustryTrendReportWD()">
<?  if( $_SESSION["loggedin"] ) { echo( "<option value=''>Please Choose</option>" ); } ?>
<? outputSelectValues( $allllweekdates, $search["dates"]["fromweekdate"] ); ?>
									</select>
									<select id="criteria-toweek" style="width: 200px" name="search[dates][toweekdate]"  onChange="reloadIndustryTrendReportWD()">
<?  if( $_SESSION["loggedin"] ) { echo( "<option value=''>Please Choose</option>" ); } ?>
<? outputSelectValues( $allllweekdates, $search["dates"]["toweekdate"] ); ?>
									</select>
</td></tr>

<?php

}
 if( $doingyearlysearch && $search["dates"]["fromyear"] )
 {
?>

								<tr>
									<td class="search-column-1">

                         Years: 
</td>									<td class="search-column-2">
									<select id="criteria-fromyear" style="width: 200px" name="search[dates][fromyear]" onChange="reloadIndustryTrendReportYear()">
<?  if( $_SESSION["loggedin"] ) { echo( "<option value=''>Please Choose</option>" ); } ?>
<? outputSelectValues( $years, $search["dates"]["fromyear"] ); ?>
									</select>
									<select id="criteria-toyear" style="width: 200px" name="search[dates][toyear]"  onChange="reloadIndustryTrendReportYear()">
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
