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
<? if( isset( $searchclientid ) ) { 
    $tmpurl = "search-results.php?" . urldecode( $_SERVER['QUERY_STRING'] );
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
//print_r( $search) ;
      if( is_array( $search ) )
foreach( $search as $s=>$val )
{
if( isset( $searchcolumnsdisplay[$s] ) && checkValForData( $val ) )
{
?>
								<tr>
									<td class="search-column-1">
										<?= formatSearchDisplayName( $searchcolumnsdisplay[$s], $val )?>:
									</td>
									<td class="search-column-2">
									<?=formatSearchDisplay( $s, $val )?>
									</td>
									<td></td>
									<td></td>
								</tr>
<? } ?>
<? } ?>
<? if( !$showdates && $_SESSION["loggedin"] ) 
{
	echo( "<tr><td><a href='{$_SERVER[REQUEST_URI]}&showdates=1'>Show Dates</a></td><td>&nbsp;</td></tr>" );

}

 if( $showdates && $_SESSION["loggedin"] ) 
{
	$r = str_replace( "&showdates=1", "", $_SERVER[REQUEST_URI] );
	echo( "<tr><td><a href='$r'>Hide Dates</a></td><td>&nbsp;</td></tr>" );

}
if( isRachel()  )
{
	$r = str_replace( "&help=1", "", $_SERVER[REQUEST_URI] );
	if( !$help )
	echo( "<tr><td><a href='{$_SERVER[REQUEST_URI]}&help=1'>Show Help</a></td><td>&nbsp;</td></tr>" );	
	else
	echo( "<tr><td><a href='$r'>Show Help</a></td><td>&nbsp;</td></tr>" );	
}

?>
							</table>	
						</div><!-- /.search-hidden -->	
					</div><!-- /.search-body -->
				</div><!-- /.search-container -->
			</div><!-- /.row -->
		</section><!-- /.search-results-top -->			
