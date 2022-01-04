<? 
$industrytrendreports = array();

if( 1 == 1 )
{
$tmparr = array();
$tmparr["top10"] = "Top 10 Highlights";
// if( !$doingweeklysearch  && !$doingyearlysearch )
//     $tmparr["mqut"] = "Multi-Quarter Upward Trends";
// if( !$doingweeklysearch  && !$doingyearlysearch )
//     $tmparr["mqdt"] = "Multi-Quarter Downward Trends";
$industrytrendreports["Overview"] = $tmparr;

$tmparr = array();
$tmparr["weeks10"] = "Weeks in the Top 10";
if( !$doingweeklysearch )
    $tmparr["weeks1"] = "Weeks at #1";
if( !$doingweeklysearch  && !$doingyearlysearch )
    $tmparr["gbn"] = "Gone/New";
if( !$doingweeklysearch  && !$doingyearlysearch )
    $tmparr["cvns"] = "Carryovers vs. New Songs";
// $tmparr["pg"] = "Primary Genre";
// $tmparr["sgai"] = "Sub-Genres/Influences";
// $tmparr["lv"] = "Lead Vocal: Gender";
// $tmparr["svsduet"] = "Lead Vocal: Solo vs. Multiple Lead Vocalists";
// $tmparr["svsmult"] = "Songs with Solo vs. Multiple Artists";
// if( !$doingweeklysearch )
//    $tmparr["swithfeat"] = "Songs with a Featured Artist";
//$tmparr["salsoprod"] = "Songs where One or More Songwriter(s) is also a Producer";
// $tmparr["paalsoprod"] = "Songs where One or More Performing Artist(s) is also a Producer";
// $tmparr["salsartist"] = "Songs where One or More Performing Artist(s) is also a Songwriter";
// $tmparr["salsartistandprod"] = "Songs where One or More Performing Artist(s) is also a Songwriter and a Producer";
//$tmparr["svsmultlabel"] = "Songs with Single vs. Multiple Labels";
//$tmparr["samples"] = "Songs that Contain Samples";
//$tmparr["remix"] = "Songs that Are a Remix";
                          
// if( !$doingweeklysearch  && !$doingyearlysearch )
//     $tmparr["atop10first"] = "Songs Where None of the Performing Artists have appeared in the Top 10 in Four or More Quarters";
//$tmparr["primaryatop10first"] = "Songs Where None of the Primary Artists have appeared in the Top 10 in the Past Year vs. Three Years";

$industrytrendreports["Songs"] = $tmparr;

$tmparr = array();
$tmparr["numhits"] = "Number of Top 10 and #1 Hits";
$tmparr["weeks10"] = "Weeks in the Top 10";
if( !$doingweeklysearch )
    $tmparr["weeks1"] = "Weeks at #1";
if( !$doingweeklysearch  && !$doingyearlysearch )
    $tmparr["gbn"] = "Gone/New";
if( !$doingweeklysearch  && !$doingyearlysearch )
    $tmparr["atop10first"] = "Artists That Appear in the Top 10 for the First Time in Four or More Quarters";
$tmparr["PerformingArtistTeamSize"] = "Performing Artist Team Size";
//$tmparr["hits"] = "Number of Top 10 Hits by Performing Artist";
if( !$doingweeklysearch )
    $tmparr["hitspie"] = "Artists With More than One Top 10 Hit";
$industrytrendreports["Performing Artists"]= $tmparr;

$tmparr = array();
$tmparr["numhits"] = "Number of Top 10 and #1 Hits";
$tmparr["weeks10"] = "Weeks in the Top 10";
if( !$doingweeklysearch )
    $tmparr["weeks1"] = "Weeks at #1";
if( !$doingweeklysearch  && !$doingyearlysearch )
    $tmparr["gbn"] = "Gone/New";
if( !$doingweeklysearch  && !$doingyearlysearch )
    $tmparr["top10first"] = "Songwriters That Appear in the Top 10 for the First Time in Four or More Quarters";
$tmparr["SongwriterTeamSize"] = "Songwriter Team Size";
//$tmparr["hits"] = "Number of Top 10 Hits by Songwriter";
if( !$doingweeklysearch )
    $tmparr["hitspie"] = "Songwriters With More than One Top 10 Hit";
$industrytrendreports["Songwriters"]= $tmparr;
}

$tmparr = array();
$tmparr["numhits"] = "Number of Top 10 and #1 Hits";
$tmparr["weeks10"] = "Weeks in the Top 10";
if( !$doingweeklysearch )
    $tmparr["weeks1"] = "Weeks at #1";
if( !$doingweeklysearch  && !$doingyearlysearch )
    $tmparr["gbn"] = "Gone/New";
if( !$doingweeklysearch  && !$doingyearlysearch )
    $tmparr["top10first"] = "Producers and Production Teams That Appear in the Top 10 for the First Time in Four or More Quarters";
$tmparr["ProductionTeamSize"] = "Producer Team Size";
//$tmparr["hits"] = "Number of Top 10 Hits by Producer";
if( !$doingweeklysearch )
    $tmparr["hitspie"] = "Producers and Production Teams With More than One Top 10 Hit";
$industrytrendreports["Producers"]= $tmparr;


$tmparr = array();
$tmparr["numhits"] = "Number of Top 10 and #1 Hits";
if( !$doingweeklysearch  && !$doingyearlysearch )
    $tmparr["gbn"] = "Gone/New";
if( !!$doingyearlysearch )
    $tmparr["cvsnew"] = "Carryovers vs. New Songs";
if( !$doingweeklysearch )
    $tmparr["prominence"] = "Number of Songs";
$tmparr["weeks10"] = "Weeks in the Top 10";
if( !$doingweeklysearch )
    $tmparr["weeks1"] = "Weeks at #1";
if( !$doingweeklysearch  && !$doingyearlysearch )
    $tmparr["toptenfirst"] = "Record Labels That Appear in the Top 10 for the First Time in Four or More Quarters";
$tmparr["pg"] = "Primary Genre";
$industrytrendreports["Record Labels"]= $tmparr;

// $industrytrendreports = array();

$tmparr = array();
$tmparr["saprl"] = "Songwriter/Artist/Producer/Record Label";
if( !$doingweeklysearch )
    $industrytrendreports["Collaborations"]= $tmparr;


if( $iscollabs )
{
    $industrytrendreports = array();
    $tmparr = array();
    $tmparr["saprlbigger"] = "Songwriter/Artist/Producer/Record Label";
    if( !$doingweeklysearch )
	$industrytrendreports["Collaborations"]= $tmparr;

}



// $industrytrendreports = array();
// $tmparr = array();
// $tmparr["pg"] = "Primary Genre";
// $industrytrendreports["Record Labels"]= $tmparr;

// // $tmparr["PerformingArtistTeamSize"] = "Performing Artist Team Size";
// // $industrytrendreports["Performing Artists"]= $tmparr;

// $tmparr = array();
// $tmparr["lv"] = "Lead Vocals: Gender";
// $industrytrendreports["Songs"] = $tmparr;


// $tmparr["ProductionTeamSize"] = "Producer Team Size";
// $industrytrendreports["Producers"]= $tmparr;
// $tmparr["svsduet"] = "Solo Artists vs. Duets/Groups";
// $industrytrendreports["Songs"] = $tmparr;

?>
