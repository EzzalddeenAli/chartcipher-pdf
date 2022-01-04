<? 
$barname = "";
$songstouse = array( "Top 10"=>array(), "#1"=>$allsongsnumber1 ); 
$overtitle = "Number Of Songs: {$rangedisplay}";
$extgraphnote = "(Quarter)";
$sectionname = "Record Labels";
$specificgraphtype = "column";

$extratext = " Note: Some songs are affiliated with more than one label" ;
include "industrytrendreportincludes/genericgraph.php"; 

$allinrange = getSongIdsWithinQuarter( false, $threeagoq, $threeagoy, $search[dates][fromq], $search[dates][fromy] );
$number1inrange = getSongIdsWithinQuarter( false, $threeagoq, $threeagoy, $search[dates][fromq], $search[dates][fromy], 1 );
$songstouse = array( "Top 10"=>$allinrange, "#1"=>$number1inrange ); 
$barname = "";

$origdates = $search[dates];
$newdates = array( "fromq"=>$oldestq, "fromy"=> $oldesty, "toq"=>$quarter, "toy"=> $year );
$search[dates] = $newdates;
$overtitle = "Number Of Songs: Q{$oldestq} {$oldesty} - Q{$quarter} {$year}";
if( $doingyearlysearch )
{
	$overtitle = "Number Of Songs: {$rangedisplay}";
}
$extgraphnote = "(Whole Year)";
$sectionname = "Record Labels";
$specificgraphtype = "column";
$extratext = " Note: Some songs are affiliated with more than one label" ;
$beforeallsongs = $allsongsallquarters; $allsongsallquarters = $allinrange;
include "industrytrendreportincludes/genericgraph.php"; 
$allsongsallquarters = $beforeallsongs;
$songstouse = array();
$search[dates] = $origdates;

?>

<? 
$barname = "";

$songstouse = array();

$overtitle = "Number Of Songs: Q{$oldestq} {$oldesty} - Q{$quarter} {$year}";
if( $doingyearlysearch )
{
	$overtitle = "Number Of Songs: {$rangedisplay}";
}
$sectionname = "Record Labels";
$specificgraphtype = "line";
$extgraphnote = "(Year)";
$extratext = " Note: Some songs are affiliated with more than one label" ;
$beforeallsongs = $allsongsallquarters; $allsongsallquarters = $allinrange;
include "industrytrendreportincludes/genericgraph.php"; 
$allsongsallquarters = $beforeallsongs;

?>
