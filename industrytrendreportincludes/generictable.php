<? 
$search[comparisonaspect] = getTrendGraphNameConverter( $sectionname );
//echo( $search[comparisonaspect] );
$rows = getRowsComparison( $search, $allsongs );
// print_r( $rows );
?>

            <div class="search-body">
    <h2 class="tabletitle"><?=$overtitle?></h2>
            <table class="sortable">
             <tbody>
            		<tr>
            			<th><?=$rowname?> <br><i>(click on column title to sort)</i></th>
<? foreach( $keynames as $keyid=>$display ) { 
if( !$songstouse[$keyid] ) continue;
 ?>
	            	  <th class=""><?=$display?> <br><i>(click on column title to sort)</i></th>
<?} ?>
            	  </tr>
<? 
//                  print_r( $songstouse );
foreach( $rows as $rowid=>$rowname )
{
?>
            	  <tr>
            	  	<td class="">									
<?=$rowname?>
</td>
<?php
$tmpdata = $dataforrows[$keyid];
foreach( $keynames as $keyid=>$display )
{
$genrefilter = $keyid;
// file_put_contents( "/tmp/hmm", "\n\ndisplay is : $display\n", FILE_APPEND );
// file_put_contents( "/tmp/hmm", "songs for this genre are ($keyid) : " . print_r( $songstouse[$keyid], true ) . "\n", FILE_APPEND );
if( !$songstouse[$keyid] ) continue;
$dataforrows = getBarTrendDataForRows( $search[comparisonaspect], $specificpeak, $songstouse[$keyid] );
$tmpdata = $dataforrows[$rowid];

if( $keyislabel )
{
	$tmpdata[3] .= "&search[labelid]=$keyid";
}
$tmpext = "";
$ckey = $tmpdata[1];
if( $tmpdata["numsongs"] )
{
	$tmpext = " ($tmpdata[numsongs])";
	$ckey = $tmpdata[numsongs];
}

echo( "<td sorttable_customkey=\"$ckey\">" );
if( $tmpdata[0] )
{
echo( "<a  href='$tmpdata[3]'>$tmpdata[1]</a>$tmpext" );
}
else
{
	echo( "-" );
}
echo( "</td>" );
}

?>

            	  </tr>
<? }?>
            	  </tbody>
            	</table>
            	</div>           
<? if( $extratext ) { ?>
<div id='extranote'><?=$extratext?></div>
<? } 
$extratext = "";
?>
