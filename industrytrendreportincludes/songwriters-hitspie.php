<? 
$sectionname = "Songwriters with more than one hit";
$overtitle = "Songwriters with More Than One Top 10 Hit: Q{$threeagoq} {$threeagoy} - Q$quarter $year";
$timeperiod = "Q{$threeagoq} {$threeagoy} - Q$quarter $year";
$specificgraphtype = "pie";
if($doingyearlysearch)
    {
	$timeperiod = $rangedisplay;
	$overtitle = "Songwriters With More than One Top 10 Hit (Excludes Featured Artists): $rangedisplay";
    }
include "industrytrendreportincludes/genericgraph.php"; 
?>
