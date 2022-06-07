<?
function cdp_sort( $a, $b )
{
$sorter["%I"] = 7;
$sorter["%II"] = 6;
$sorter["%III"] = 5;
$sorter["%IV"] = 4;
$sorter["%V"] = 3;
$sorter["%VI"] = 2;
$sorter["%VII"] = 1;
return $sorter[$a] > $sorter[$b];
}
function tempo_sort( $a, $b )
{
$sorter["Under 79"] = 7;
$sorter["80-99"] = 6;
$sorter["100-119"] = 5;
$sorter["120-149"] = 4;
$sorter["150+"] = 3;

return $sorter[$a] > $sorter[$b];


}
function cr_sort( $a, $b )
{
//"None", "Low Repetition", "Moderate Repetition", "High Repetition"
$sorter["None"] = 7;
$sorter["Low Repetition"] = 6;
$sorter["Moderate Repetition"] = 5;
$sorter["High Repetition"] = 4;
return $sorter[$a] > $sorter[$b];


}
function yesno_sort( $a, $b )
{
$sorter["Yes"] = 7;
$sorter["No"] = 6;

return $sorter[$a] > $sorter[$b];


}

function profanity_sort( $a, $b )
{
$sorter["None"] = 8;
$sorter["Sporadic Use"] = 7;
$sorter["Heavy Use"] = 6;



return $sorter[$a] > $sorter[$b];


}
function timbre_sort( $a, $b )
{
$sorter["Primarily Bright"] = 8;
$sorter["Primarily Dark"] = 7;
$sorter["Mixed"] = 6;



return $sorter[$a] > $sorter[$b];


}

function danceability_sort( $a, $b )
{
$sorter["Low"] = 8;
$sorter["Moderate"] = 7;
$sorter["High"] = 6;

return $sorter[$a] > $sorter[$b];


}
function melodicrange_sort( $a, $b )
{
$sorter["Horizontal"] = 8;
$sorter["Mixed-Horizontal"] = 7;
$sorter["Mixed-Vertical"] = 6;
$sorter["Vertical"] = 5;

return $sorter[$a] > $sorter[$b];


}

function frequency_sort( $a, $b )
{
$sorter["Very Frequent"] = 9;
$sorter["High Use"] = 9;
$sorter["Frequent"] = 8;
$sorter["Mid-High Use"] = 8;
$sorter["Moderate"] = 7;
$sorter["Occasional"] = 6;
$sorter["Low-Mid Use"] = 6;
$sorter["Little to None"] = 5;
$sorter["Low Use"] = 5;

$sorter["Entirely Diatonic"] = 9;
$sorter["Primarily Diatonic"] = 8;
$sorter["Somewhat Diatonic"] = 7;
$sorter["Chromatic Influence / Multiple Keys"] = 6;

return $sorter[$a] > $sorter[$b];


}
function frequency_sort_lowestfirst( $a, $b )
{
$sorter["None"] = 10;
$sorter["Low"] = 9;
$sorter["Few"] = 9;
$sorter["Little Use"] = 9;
$sorter["Sporadic Use"] = 9;
$sorter["Little to None"] = 9;
$sorter["Occasional"] = 8;
$sorter["Low-Mid"] = 8;
$sorter["Some"] = 8;
$sorter["Moderate"] = 7;
$sorter["Moderate Use"] = 7;
$sorter["High-Mid"] = 7;
$sorter["Frequent"] = 6;
$sorter["Very Frequent"] = 5;
$sorter["Frequent Use"] = 5;
$sorter["High"] = 5;

return $sorter[$a] > $sorter[$b];


}


//print_r( $rows );
//print_r( $presortedbarkey );
//echo( $search["comparisonaspect"] );
	   if( $search["comparisonaspect"] == "ChordDegreePrevalence" )
	   {
	   	uksort( $presortedbarkey, 'cdp_sort' );
		
	   }
	   elseif( $search["comparisonaspect"] == "ChordRepetitionRange" )
	   {
	   	uksort( $presortedbarkey, 'cr_sort' );
		
	   }
	   elseif( $search["comparisonaspect"] == "ProfanityRange" )
	   {
	   	uksort( $presortedbarkey, 'profanity_sort' );
		
	   }
	   elseif( $search["comparisonaspect"] == "Timbre" )
	   {
	   	uksort( $presortedbarkey, 'timbre_sort' );
		
	   }
	   elseif( $search["comparisonaspect"] == "MainMelodicRange" )
	   {
	   	uksort( $presortedbarkey, 'melodicrange_sort' );
	   }
	   elseif( $search["comparisonaspect"] == "Tempo Range General" ||  $search["comparisonaspect"] == "TempoRangeGeneral" )
	   {
	   	uksort( $presortedbarkey, 'tempo_sort' );
	   }
	   elseif( $search["comparisonaspect"] == "OverallRepetitivenessRange" 
	   ||    $search["comparisonaspect"] == "SlangWordsRange" 
	   ||    $search["comparisonaspect"] == "GeneralLocationReferencesRange" 
	   ||    $search["comparisonaspect"] == "UseOf7thChordsRange" 
	   ||    $search["comparisonaspect"] == "EndOfLineRhymesPercentageRange" 
	   ||    $search["comparisonaspect"] == "EndLinePerfectRhymesPercentageRange" 
	   ||    $search["comparisonaspect"] == "OverallRepetitivenessRange" 
	   ||    $search["comparisonaspect"] == "ThousandWordsPrevalenceRange" 
	   ||    $search["comparisonaspect"] == "UseOfInvertedChordsRange" 
	   ||    $search["comparisonaspect"] == "MidLineRhymesPercentageRange" 
	   ||    $search["comparisonaspect"] == "RhymeDensityRange" 
	   ||    $search["comparisonaspect"] == "LocationReferencesRange" 
	   ||    $search["comparisonaspect"] == "PersonReferencesRange" 
	   ||    $search["comparisonaspect"] == "TotalAlliterationRange" 
	   ||    $search["comparisonaspect"] == "GeneralPersonReferencesRange" 
)
	   {
	   	uksort( $presortedbarkey, 'frequency_sort_lowestfirst' );
		
	   }
	   elseif( $search["comparisonaspect"] == "MidLineRhymesPercentageRange"
	   ||    $search["comparisonaspect"] == "PercentDiatonicChordsRange" 
	   ||    $search["comparisonaspect"] == "NumMelodicThemesRange" 
	    || $search["comparisonaspect"] == "InternalRhymesPercentageRange" )
	   {
	   	uksort( $presortedbarkey, 'frequency_sort' );
		
	   }
	   elseif( $search["comparisonaspect"] == "DanceabilityRange" )
	   {
	   	uksort( $presortedbarkey, 'danceability_sort' );
		
	   }
	   elseif( $search["comparisonaspect"] == "Departure Section" )
	   {
	   	uksort( $presortedbarkey, 'yesno_sort' );
		
	   }
	   else
	   	asort( $presortedbarkey );

?>