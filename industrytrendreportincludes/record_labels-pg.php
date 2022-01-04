<div class="graph-wrap">
<?php
$alllabels = db_query_array( "select id, Name from labels order by OrderBy", "id", "Name" );
$genrefilter = "";

if( !$labelsongs ) { 
    $labelsongs = array();
    foreach( $alllabels as $labelid=>$labelname )
	{
	    $labelfilter = $labelid;
	    if( $doingweeklysearch )
		$tmpsongs = getSongIdsWithinWeekdates( false, $search[dates][fromweekdate], $search[dates][toweekdate] );
	    else // yearly can do this
		$tmpsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy] );
	    
	    if( count( $tmpsongs ) )
		$labelsongs[$labelid] = $tmpsongs;
	    if( !count( $tmpsongs ) )
		{
		    unset( $alllabels[$labelid] );
		}
	}
}
$labelfilter = "";
$sectionname = "Primary Genres";
$displname = "Primary Genre";
$barname = "";
$specificgraphtype = "column"; 
$rowname = "Primary Genre";
$overtitle = "$displname By Record Label: $rangedisplay";
$songstouse = $labelsongs;
$keynames = $alllabels;
$extratext = " Note: Some songs are affiliated with more than one label" ;

$keyislabel = true;
include "industrytrendreportincludes/generictable.php"; 
$keyislabel = false;
?>
</div>
