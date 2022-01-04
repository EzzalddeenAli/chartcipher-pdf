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
<?=$period?>
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
if( $search["primaryartist"] ) { 
?>
								<tr>
									<td class="search-column-1">
Performing Artist:
</td>									<td class="search-column-2">
<?=$search["primaryartist"]?>
</td></tr>
<? 
}
if( $search["producer"] ) { 
?>
								<tr>
									<td class="search-column-1">
Producer:
</td>									<td class="search-column-2">
<?=$search["producer"]?>
</td></tr>
<? 
}
if( $search["writer"] ) { 
?>
								<tr>
									<td class="search-column-1">
Writer:
</td>									<td class="search-column-2">
<?=$search["writer"]?>
</td></tr>
<? } ?>
<? if( isset( $search[dates][season] ) ) { 
    $tmpurl = "compositional-trends-by-weeks-search-results.php?" . urldecode( $_SERVER['QUERY_STRING'] );
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
    $tmpurl = "compositional-trends-by-weeks-search-results.php?" . $_SERVER['QUERY_STRING'];
$tmpurl = str_replace( "genrefilter={$genrefilter}", "", $tmpurl );
$tmpurl .= "&genrefilter=";
?>
								<tr>
									<td class="search-column-1">
									Primary Genre
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
if( $_SESSION["loggedin"] ) { 
    $tmpurl = "compositional-trends-by-weeks-search-results.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&newcarryfilter=". $newcarryfilter , "", $tmpurl );
$tmpurl .= "&newcarryfilter=";

    ?>
								<tr>
									<td class="search-column-1">

                       New Songs / Carryovers: 
</td>									<td class="search-column-2">
								<select id="newcarryfilter" name="newcarryfilter" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value'>
									<option value="">All Songs</option>
	   <? outputSelectValuesForNewCarry( $newcarryfilter )?>
								</select>

                                </div><!-- /.form-row-right -->
</td></tr>

    <?php
								     }
?>


    <?php
    $tmpurl = "compositional-trends-by-weeks-search-results.php?" . $_SERVER['QUERY_STRING'];
$tmpurl = str_replace( "search[compositionalaspect]={$search[compositionalaspect]}", "", $tmpurl );
$tmpurl .= "&search[compositionalaspect]=";

    ?>
								<tr>
									<td class="search-column-1">
    Comparison Aspect:
</td>									<td class="search-column-2">

 								<select name="search[compositionalaspect]" style="width:200px" onChange='document.location.href="<?=$tmpurl?>" + escape( this.options[this.selectedIndex].value )' >
									<option value="">(Select One)</option>
    <? foreach( $possiblecompositionalaspects as $pid=>$pval ) { ?>
      <option <?=$search[compositionalaspect] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                              <? } ?>
								</select>
</td></tr>

    <?php
    $tmpurl = "compositional-trends-by-weeks-search-results.php?" . $_SERVER['QUERY_STRING'];
$tmpurl = str_replace( "search[outputformat]={$search[outputformat]}", "", $tmpurl );
$tmpurl .= "&search[outputformat]=";

    ?>
								<tr>
									<td class="search-column-1">
    Output Format:
</td>									<td class="search-column-2">

 								<select name="search[outputformat]" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + escape( this.options[this.selectedIndex].value )' >
									<option value="">(Select One)</option>
    <? foreach( $possibletables as $pid=>$pval ) { ?>
      <option <?=$search[outputformat] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                              <? } ?>
								</select>
</td></tr>

							</table>	
						</div><!-- /.search-hidden -->	
					</div><!-- /.search-body -->
				</div><!-- /.search-container -->
			</div><!-- /.row -->
		</section><!-- /.search-results-top -->			
