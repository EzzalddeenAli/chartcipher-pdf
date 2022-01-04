<form method='get' id="gsearch" name="gsearch" action="genre-search-results">
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
								</tr>
								<tr>
									<td class="search-column-1">

                         Quarter and Year: 
</td>									<td class="search-column-2">
									<select name="search[dates][fromq]" style="width:100px" onChange='document.forms["gsearch"].submit()'>
<option value=''>All</option>
<? outputSelectValues( $quarters, $search["dates"]["fromq"] ); ?>
									</select>

									<select name="search[dates][fromy]"  style="width:100px" onChange='document.forms["gsearch"].submit()'>
<? outputSelectValues( $years, $search["dates"]["fromy"] ); ?>
									</select>

                                    
</td></tr>
								<tr>
									<td class="search-column-1">
<?=getPeakPositionDisplayName($search[peakchart] )?>
</td>
									<td class="search-column-2">
								<select name="search[peakchart]" onChange='document.forms["gsearch"].submit()'>
									<option value="">Any</option>
									<? 
outputSelectValues( $peakvalues, $search["peakchart"] );
outputClientSelectValues( $search["peakchart"] );
?>
								</select>
</td></tr>
							</table>	
						</div><!-- /.search-hidden -->	
					</div><!-- /.search-body -->
				</div><!-- /.search-container -->
			</div><!-- /.row -->
		</section><!-- /.search-results-top -->			
                            </form>