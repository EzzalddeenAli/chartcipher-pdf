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
								<tr>
									<td class="search-column-1">
    Output Format: 
</td>									<td class="search-column-2">
    <?php
    $tmpurl = "chartinfo.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&graphtype=". $_GET["graphtype"] , "", $tmpurl );
$tmpurl = str_replace( "&graphtype=". $graphtype , "", $tmpurl );
$tmpurl .= "&graphtype=";
    ?>
 								<select name="graphtype" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value' >
    <? 
    if( !$_GET["graphtype"] ) $_GET["graphtype"] = $graphtype;
foreach( array(  "table"=>"Table", "line"=>"Line Graph" ) as $pid=>$pval ) { ?>
      <option <?=$_GET["graphtype"] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                              <? } ?>
								</select>
</td></tr>
    <?php
    $tmpurl = "chartinfo.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&chartgenre=". $_GET["chartgenre"] , "", $tmpurl );
$tmpurl = str_replace( "&chartgenre=". $chartgenre , "", $tmpurl );
$tmpurl .= "&chartgenre=";
    ?>
								<tr>
									<td class="search-column-1">
Chart Genre
</td>									<td class="search-column-2">
 								<select name="chartgenre" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value' >
<option value=''>All</option>
    <? 
$chartgenres = getSetValues(  "genre", "charts" );
foreach( $chartgenres as $pid=>$pval ) { ?>
      <option <?=$_GET["chartgenre"] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                              <? } ?>
								</select>
</td></tr>

    <?php
    $tmpurl = "chartinfo.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&chartmedium=". $_GET["chartmedium"] , "", $tmpurl );
$tmpurl = str_replace( "&chartmedium=". $chartmedium , "", $tmpurl );
$tmpurl .= "&chartmedium=";
    ?>
								<tr>
									<td class="search-column-1">
Chart Medium
</td>									<td class="search-column-2">
 								<select name="chartmedium" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value' >
<option value=''>All</option>
    <? 
$chartmediums = getSetValues(  "chartmedium", "charts" );
foreach( $chartmediums as $pid=>$pval ) { ?>
      <option <?=$_GET["chartmedium"] == $pid?"SELECTED":""?> value="<?=$pid?>"><?=$pval?></option>
                                                              <? } ?>
								</select>
</td></tr>


							</table>	
						</div><!-- /.search-hidden -->	
					</div><!-- /.search-body -->
				</div><!-- /.search-container -->
			</div><!-- /.row -->
		</section><!-- /.search-results-top -->			
