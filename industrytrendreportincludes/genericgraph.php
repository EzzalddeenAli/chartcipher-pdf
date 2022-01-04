<? 
if( !$specificgraphtype )
    $specificgraphtype = "{$_GET[graphtype]}";

//    echo( "specific: " . $specificgraphtype );
include "industrytrendreportincludes/genericgraph-{$specificgraphtype}.php";
$songstouse = array();
$specificgraphtype = "";
$specificpeak = ""; 
$overtitle = "";
$extgraphnote = "";
?>