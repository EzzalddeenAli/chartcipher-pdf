<? 
$songstouse = array();
$overtitle = "Songs with a Featured Artist: Q{$oldestq} {$oldesty} - Q{$quarter} {$year}";
if( $doingyearlysearch )
{
	$overtitle = "Songs with a Featured Artist: {$rangedisplay}";
}
$sectionname = "Songs with a Featured Artist";
$specificgraphtype = "line";
include "industrytrendreportincludes/genericgraph.php"; 

?>
