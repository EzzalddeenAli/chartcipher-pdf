					<div class="search-body">
                        
                      
						<h1><a class="expand-btn " href="#">Search Criteria</a></h1>
						<div id="search-hidden" class="hide">
							<table width="100%" id="search-criteria-table">
    <?php
?>


<? if( isset( $searchclientid ) ) { 
    $tmpurl = "benchmark-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
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
    <? if( !$nodates ){  ?>
								<tr>
									<td class="search-column-1">

                         Dates: 
</td>									<td class="search-column-2">

<? if( $doingyearlysearch ) { ?>

                               <?=$search[dates][fromyear]?>
                         <? if( $search[dates][toyear] ) { ?>
                                                        to <?=$search["dates"]["specialendq"]?"Q" . $search["dates"]["specialendq"]:""?> <?=$search[dates][toyear]?>
                                                        <? } ?>
<? } else if( $doingweeklysearch ) { ?>

<?=$rangedisplay?>

<? } else { ?>
                               Q<?=$search[dates][fromq]?>/<?=$search[dates][fromy]?>
                         <? if( $search[dates][toq] ) { ?>
                                                        to Q<?=$search[dates][toq]?>/<?=$search[dates][toy]?>
                                                        <? } ?>
<? } ?>
<?     $tmpurl = "benchmark.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "search[dates][toy]={$search[dates][toy]}", "", $tmpurl );
$tmpurl = str_replace( "search[dates][toq]={$search[dates][toq]}", "", $tmpurl );
$tmpurl = str_replace( "search[dates][toyear]={$search[dates][toyear]}", "", $tmpurl );
$tmpurl = str_replace( "search[dates][fromy]={$search[dates][fromy]}", "", $tmpurl );
$tmpurl = str_replace( "search[dates][fromq]={$search[dates][fromq]}", "", $tmpurl );
$tmpurl = str_replace( "search[dates][fromyear]={$search[dates][fromyear]}", "", $tmpurl );
?>
<A href='<?=$tmpurl?>'>New Dates  >> </a>
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
$tmpurl = "benchmark-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&search[specificsubgenre]=". $search[specificsubgenre] , "", $tmpurl );
$tmpurl .= "&search[specificsubgenre]=";
if( $search["specificsubgenre"] || 1  ) { 
?>
								<tr>
									<td class="search-column-1">
Genre:
</td>									<td class="search-column-2">

								<select name="genrefilter" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value'>
									<option value="">All Genres/Influences</option>
<? outputSelectValuesForOtherTable( "subgenres", $search[specificsubgenre], true ); ?>
								</select>
</td></tr>
    <? } ?>


<? 
$tmpurl = "benchmark-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&search[majorminor]=". $search[majorminor] , "", $tmpurl );
$tmpurl .= "&search[majorminor]=";
?>
								<tr>
									<td class="search-column-1">
Songs in a Major or Minor Key:
</td>									<td class="search-column-2">

								<select name="search[majorminor]" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value'>
									<option value="">All</option>
<? outputSelectValuesDistinct( "majorminor", $search[majorminor] ); ?>
								</select>
</td></tr>


<? 
$tmpurl = "benchmark-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&search[exactbpm]=". $search[exactbpm] , "", $tmpurl );
$tmpurl .= "&search[exactbpm]=";
?>
								<tr>
									<td class="search-column-1">
BPM:
</td>									<td class="search-column-2">

								<select name="search[exactbpm]" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value'>
									<option value="">All</option>
<? outputSelectValuesDistinct( "TempoRange", $search[exactbpm] ); ?>
								</select>
</td></tr>



<? 
$tmpurl = "benchmark-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&search[lyricalthemeid]=". $search[lyricalthemeid] , "", $tmpurl );
$tmpurl .= "&search[lyricalthemeid]=";
?>
								<tr>
									<td class="search-column-1">
Lyrical Theme:
</td>									<td class="search-column-2">

								<select name="search[lyricalsubthemeid]" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value'>
									<option value="">All</option>
<? outputSelectValuesForOtherTable( "lyricalthemes", $search[lyricalthemeid]); ?>

								</select>
</td></tr>


<? 
if( 1 == 0 ) { 
$tmpurl = "benchmark-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&search[lyricalsubthemeid]=". $search[lyricalsubthemeid] , "", $tmpurl );
$tmpurl .= "&search[lyricalsubthemeid]=";
?>
								<tr>
									<td class="search-column-1">
Lyrical Sub Theme:
</td>									<td class="search-column-2">

								<select name="search[lyricalsubthemeid]" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value'>
									<option value="">All</option>
<? outputSelectValuesForOtherTable( "lyricalsubthemes", $search[lyricalsubthemeid]); ?>

								</select>
</td></tr>



<? } ?>




<? 
$tmpurl = "benchmark-report.php?" . urldecode( $_SERVER['QUERY_STRING'] );
$tmpurl = str_replace( "&search[lyricalmoodid]=". $search[lyricalmoodid] , "", $tmpurl );
$tmpurl .= "&search[lyricalmoodid]=";
?>
								<tr>
									<td class="search-column-1">
Lyrical Mood:
</td>									<td class="search-column-2">

								<select name="search[lyricalmoodid]" style="width:400px" onChange='document.location.href="<?=$tmpurl?>" + this.options[this.selectedIndex].value'>
									<option value="">All</option>
<? outputSelectValuesForOtherTable( "lyricalmoods", $search[lyricalmoodid]); ?>

								</select>
</td></tr>







							</table>	
						</div><!-- /.search-hidden -->	
					</div><!-- /.search-body -->
