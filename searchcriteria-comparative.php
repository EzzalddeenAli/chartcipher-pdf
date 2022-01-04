		<section class="search-results-top">
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
									<td></td>
								</tr>
    <? if( !$nodates ){  ?>
								<tr>
									<td class="search-column-1">

                         Dates: 
</td>									<td class="search-column-2">
<?=$period?><br>
</td></tr>
                         <? } else { ?>
								<tr>
									<td class="search-column-1">
Dates:
</td>									<td class="search-column-2">
All Dates
</td></tr>

    <? } ?>
<? 
if( $search["primaryartist"] && !is_array( $search["primaryartist"] ) ) { 
?>
								<tr>
									<td class="search-column-1">
Performing Artist:
</td>									<td class="search-column-2">
<?=$search["primaryartist"]?>
</td></tr>
<? 
}
if( $search["producer"] && !is_array( $search["producer"] ) ) { 
?>
								<tr>
									<td class="search-column-1">
Producer:
</td>									<td class="search-column-2">
<?=$search["producer"]?>
</td></tr>
<? 
}
if( $search["writer"] && !is_array( $search["writer"] ) ) { 
?>
								<tr>
									<td class="search-column-1">
Writer:
</td>									<td class="search-column-2">
<?=$search["writer"]?>
</td></tr>
<? } ?>


<? if( isset( $search[dates][season] )&& 1 == 0  ) { 
    $tmpurl = "comparative-search-results.php?" . $_SERVER['QUERY_STRING'];
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
outputSelectValues( $seasons, $search["dates"]["season"] ); ?>

								</select>
</td></tr>

<? } ?>
<? if( isset( $genrefilter ) ) { 
    $tmpurl = "comparative-search-results.php?" . $_SERVER['QUERY_STRING'];
$tmpurl = str_replace( "genrefilter={$genrefilter}", "", $tmpurl );
$tmpurl .= "&genrefilter=";
?>
								<tr>
									<td class="search-column-1">
									Primary Genre:
</td>									<td class="search-column-2">

 								<select name="genrefilter" style="width:200px" onChange='document.location.href="<?=$tmpurl?>" + escape( this.options[this.selectedIndex].value )' >
									<option value="">All Primary Genres</option>
<? outputSelectValues( $allgenresfordropdown, $genrefilter ); ?>
								</select>
</td></tr>

<? } ?>
<!--                         <? if( $search[peakchart]  ){ ?>
								<tr>
									<td class="search-column-1">
<?=getPeakPositionDisplayName($search[peakchart] )?>
</td>									<td class="search-column-2">

  <?=getPeakPositionDisplayValue( $search[peakchart] ) ?>
</td></tr>
                                                              <? } else { ?>
								<tr>
									<td class="search-column-1">
<?=getPeakPositionDisplayName($search[peakchart] )?>
</td>							
		<td class="search-column-2">
Top 10
</td></tr>
    <? } ?>
-->
    <?php
    $tmpurl = "comparative-search-results.php?" . $_SERVER['QUERY_STRING'];
$tmpurl = str_replace( "search[comparisonaspect]={$search[comparisonaspect]}", "", $tmpurl );
$tmpurl .= "&search[comparisonaspect]=";

    ?>
								<tr>
									<td class="search-column-1">
    Aspect 1:
</td>									<td class="search-column-2">

 								<select name="search[comparisonaspect]" style="width:200px" onChange='document.location.href="<?=$tmpurl?>" + escape( this.options[this.selectedIndex].value )' >
									<option value="">(Select One)</option>
    <? $tmpcnt = 0; foreach( $possiblecomparisonaspects as $pid=>$pval ) {
    if( $pccounts[$tmpcnt] )
    {
	if( $tmpcnt ) 
	    echo( "</optgroup>\n" );
	echo( "<optgroup label='". $pccounts[$tmpcnt] . "'>\n" );
	
    }
    $tmpcnt++;
?>
      <option <?=$search[comparisonaspect] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                              <? } ?>
</optgroup>
								</select>
</td></tr>
								<tr>
    <?php
    $tmpurl = "comparative-search-results.php?" . $_SERVER['QUERY_STRING'];
$tmpurl = str_replace( "search[comparisonfilter]={$search[comparisonfilter]}", "", $tmpurl );
$tmpurl .= "&search[comparisonfilter]=";

    ?>
									<td class="search-column-1">
    Aspect 2:
</td>									<td class="search-column-2">
<? if( $thetype != "industry" ) { ?>
<?=$search[comparisonfilter]?>
<? } else { ?>

 								<select name="search[comparisonfilter]" style="width:200px" onChange='document.location.href="<?=$tmpurl?>" + escape( this.options[this.selectedIndex].value )' >
									<option value="">(Select One)</option>
    <? foreach( $possiblecomparisonfilters as $pid=>$pval ) { ?>
      <option <?=$search[comparisonfilter] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                              <? } ?>
								</select>
<? } ?>
</td></tr>
    

							</table>	
						</div><!-- /.search-hidden -->	
					</div><!-- /.search-body -->
				</div><!-- /.search-container -->
			</div><!-- /.row -->
		</section><!-- /.search-results-top -->			
