<? 

$nogainers = array();
$nogainers[] = "Number-Of-Songs-Within-The-Top-10";
$nogainers[] = "Average-Song-Length";
$nogainers[] = "Average-Intro-Length";
$nogainers[] = "Average-Tempo";
$nogainers[] = "First-Chorus-Avg-Time-Into-Song";
$nogainers[] = "First-Chorus-Avg-Percent-Into-Song";
$nogainers[] = "Average-Outro-Length";
$nogainers[] = "A-B-A-B-D-B-Form";
$nogainers[] = "";

$reportsarr = array();

$benchmarktypes = array();
$benchmarktypes["Top vs. Bottom of the Charts"] = "Top vs. Bottom of the Charts";
//$benchmarktypes["New Songs vs. Songs that Departed"] = "New Songs vs. Songs that Departed";
$benchmarktypes["New Songs vs. Carryovers"] = "New Songs vs. Carryovers";
$benchmarktypes["Staying Power - 10 Weeks"] = "Staying Power: Song with 10+ Weeks vs. Songs with less than 10 Weeks";
$benchmarktypes["Seasonal Comparisons"] = "Seasonal Comparisons";

$benchmarkdescriptions = array();
$benchmarkdescriptions["Top vs. Bottom of the Charts"] = "Compare the characteristics of songs that peaked at the top half of the chart vs. those at the bottom half.";
$benchmarkdescriptions["New Songs vs. Carryovers"] = "Compare the characteristics of songs that entered the chart for the very first time during the selected time-period vs. those that carried over from previous quarters.";
$benchmarkdescriptions["Staying Power - 10 Weeks"] = "Compare the characteristics of songs that charted for ten or more weeks vs. those that charted for nine or less weeks.";
$benchmarkdescriptions["Seasonal Comparisons"] = "Compare the characteristics of songs based on seasons.";

if(!isNoGenreChart( $chartid ) )
    {
	$benchmarktypes["Genre Comparisons"] = "Genre Comparisons";
	$benchmarkdescriptions["Genre Comparisons"] = "Compare the characteristics of songs by genre.";
    }


$benchmarksubtypes = array();
$benchmarksubtypes["Compositional"] = "Compositional";
$benchmarksubtypes["Lyrical"] = "Lyrical";
$benchmarksubtypes["Production"] = "Production";
$benchmarksubtypes["Structure"] = "Structure";


$benchmarknumerics = array();
$benchmarknumerics["Compositional"]["MainMelodicRange"] =  "MainMelodicRange";
$benchmarknumerics["Compositional"]["NumMelodicThemesRange"] = "NumMelodicThemesRange";
$benchmarknumerics["Compositional"]["ChordRepetitionRange"] = "ChordRepetitionRange";
$benchmarknumerics["Compositional"]["UseOf7thChordsRange"] = "UseOf7thChordsRange";
$benchmarknumerics["Compositional"]["UseOfInvertedChordsRange"] = "UseOfInvertedChordsRange";
$benchmarknumerics["Compositional"]["PercentDiatonicChordsRange"] = "PercentDiatonicChordsRange";

$benchmarknumerics["Structure"]["Average Song Length"] =  "Average Song Length";
$benchmarknumerics["Structure"]["Song Length Range"] =  "Song Length Range";
//$benchmarknumerics["Structure"]["Verse Count"] =  "Verse Count";
//$benchmarknumerics["Structure"]["Pre-Chorus Count"] =  "Pre-Chorus Count";
$benchmarknumerics["Structure"]["Chorus Count"] =  "Chorus Count";

$benchmarknumerics["Production"]["Average Tempo"] =  "Average Tempo";
$benchmarknumerics["Production"]["DanceabilityRange"] =  "DanceabilityRange";

// $benchmarknumerics["Lyrical"]["PersonReferences"] =  "PersonReferences";
// $benchmarknumerics["Lyrical"]["Song Title Word Count"] =  "Song Title Word Count";
// $benchmarknumerics["Lyrical"]["LocationReferences"] =  "LocationReferences";

$benchmarknumerics["Lyrical"]["Song Title Word Count"] = "Song Title Word Count";
$benchmarknumerics["Lyrical"]["InternalRhymesPercentageRange"] = "InternalRhymesPercentageRange";
$benchmarknumerics["Lyrical"]["MidLineRhymesPercentageRange"] = "MidLineRhymesPercentageRange";
$benchmarknumerics["Lyrical"]["RhymeDensityRange"] = "RhymeDensityRange";
$benchmarknumerics["Lyrical"]["EndOfLineRhymesPercentageRange"] = "EndOfLineRhymesPercentageRange";
$benchmarknumerics["Lyrical"]["PercentAbbreviations"] = "PercentAbbreviations";
$benchmarknumerics["Lyrical"]["SlangWords"] = "SlangWords";
$benchmarknumerics["Lyrical"]["ProfanityRange"] = "ProfanityRange";
$benchmarknumerics["Lyrical"]["PersonReferences"] = "PersonReferences";
$benchmarknumerics["Lyrical"]["LocationReferences"] = "LocationReferences";
$benchmarknumerics["Lyrical"]["ThousandWordsPrevalence"] = "ThousandWordsPrevalence";


// Overview
// Songs in the Top 10 >>
// Most Popular Characteristics >>
// Multi-Quarter Trends >>
// Gone/Back >>
// Highest/ Lowest Levels in over a year

// $reportsarr["Overview"]["Songs-in-the-Top-10"] = "Songs In The Top 10";
// if( !$doingthenandnow )
//     $reportsarr["Overview"]["Most-Popular-Characteristics"] = "Most Popular Characteristics";
// if( !$doingyearlysearch && !$doingweeklysearch )
// $reportsarr["Overview"]["Multi-Quarter-Trends"] = "Multi-Quarter Trends";
// if( !$doingyearlysearch && !$doingweeklysearch )
//     $reportsarr["Overview"]["Gone-Back"] = "Gone/New";
// if( !$doingyearlysearch && !$doingweeklysearch )
//     $reportsarr["Overview"]["Highest-Lowest-Levels"] = "Highest/ Lowest Levels In Four Or More Quarters";

// $reportsarr["Artists"]["Multiple-Vs-Solo"] = "Multiple vs. Solo Artist";
// $reportsarr["Artists"]["Songs-With-Featured"] = "Songs with a Featured Artist";


// Genres / Influences
// Primary Genres
// Influences
//$benchmarkreportsarr[] = "Primary Genres";

// not used anymore
$benchmarkreportsarr[] = "Genres";
$benchmarkreportsarr[] = "Influences";
$benchmarkreportsarr[] = "Lyrical Moods";
$benchmarkreportsarr[] = "Lyrical Themes";
$benchmarkreportsarr[] = "Prominent Instruments";
$benchmarkreportsarr[] = "Tempo Range General";
$benchmarkreportsarr[] = "KeyMajorMinor";
$benchmarkreportsarr[] = "Song Title Word Count";
$benchmarkreportsarr[] = "Chorus Count";
$benchmarkreportsarr[] = "First Section";
$benchmarkreportsarr[] = "Last Section";
$benchmarkreportsarr[] =  "Song Length Range";
$benchmarkreportsarr[] =  "Average Song Length";
$benchmarkreportsarr[] =  "NumMelodicThemesRange";
$benchmarkreportsarr[] =  "MelodicIntervalPrevalence";
$benchmarkreportsarr[] =  "MainMelodicRange";
$benchmarkreportsarr[] =  "Key (Major, Minor, Major Mode, Minor Mode)";// 
$benchmarkreportsarr[] =  "PercentDiatonicChordsRange";
$benchmarkreportsarr[] =  "UseOfInvertedChordsRange";
$benchmarkreportsarr[] =  "UseOf7thChordsRange";
$benchmarkreportsarr[] =  "ChordDegreePrevalence";
$benchmarkreportsarr[] =  "ChordRepetitionRange";
$benchmarkreportsarr[] =  "Tempo Range";
$benchmarkreportsarr[] =  "Timbre";
$benchmarkreportsarr[] =  "ProductionMood";
$benchmarkreportsarr[] =  "DanceabilityRange";
$benchmarkreportsarr[] =  "PersonReferences";
$benchmarkreportsarr[] =  "LocationReferences";
$benchmarkreportsarr[] =  "ThousandWordsPrevalence";
$benchmarkreportsarr[] =  "SlangWords";
$benchmarkreportsarr[] =  "ProfanityRange";
$benchmarkreportsarr[] =  "RhymeDensityRange";
$benchmarkreportsarr[] =  "InternalRhymesPercentageRange";
$benchmarkreportsarr[] =  "MidLineRhymesPercentageRange";
$benchmarkreportsarr[] =  "EndLinePerfectRhymesPercentageRange";

//$reportsarr["Genres & Sub-Genres/Influences"]["Influence-Count"] = "Influence Count";

// // Lead Vocals
// // Lead Vocal Gender
// // Lead Vocal Delivery
// $reportsarr["Lead Vocals"]["Solo-vs-Multiple-Lead-Vocalists"] = "Solo vs. Multiple Lead Vocalists";
// $reportsarr["Lead Vocals"]["Lead-Vocal"] = "Lead Vocal Gender (with solo vs. duet/group)";
// $reportsarr["Lead Vocals"]["Lead-Vocal-Grouped"] = "Lead Vocal Gender (male, female, male/female)"; // new
// $reportsarr["Lead Vocals"]["Lead-Vocal-Delivery"] = "Lead Vocal Delivery Type"; // new

// // Lyrics & Title
// // Lyrical Themes >>
// // Song Title Word Count >>
// // Song Title Appearances >>
// $reportsarr["Lyrics & Title"]["Lyrical-Themes"] = "Lyrical Themes";
// $reportsarr["Lyrics & Title"]["Song-Title-Placement"] = "Song Title Placement";
// $reportsarr["Lyrics & Title"]["Song-Title-Word-Count"] = "Song Title Word Count";
// $reportsarr["Lyrics & Title"]["Song-Title-Appearances"] = "Song Title Appearance Count";


// // General Characteristics and Instrumentation
// //     Key
// //     Major vs. Minor
// //     Tempo Range
// //     Song Length Range
// //     Prominent Instruments 
// $reportsarr["General Characteristics & Instruments"]["Key"] = "Key";
// $reportsarr["General Characteristics & Instruments"]["Major-Vs-Minor"] = "Key (Major vs. Minor)";
// $reportsarr["General Characteristics & Instruments"]["Average-Tempo"] = "Average Tempo";
// $reportsarr["General Characteristics & Instruments"]["Tempo-Range"] = "Tempo Range (BPM)";
// $reportsarr["General Characteristics & Instruments"]["Average-Song-Length"] = "Average Song Length";
// $reportsarr["General Characteristics & Instruments"]["Song-Length-Range"] = "Song Length Range";
// $reportsarr["General Characteristics & Instruments"]["Prominent-Instrumentation"] = "Prominent Instruments";

// // Structure
// // First Section >>
// // Intro Length Range >>
// // Use Of A Pre-Chorus >>
// // Chorus Preceding First Verse >>
// // First Chorus: Average Time Intro Song >>
// // First Chorus: Time Intro Song Range >>
// // First Chorus: Average Percent Into Song >>
// // First Chorus: Percent Intro Song Range >>
// // Use Of A Post-Chorus >>
// // Use Of A Bridge Or Bridge Surrogate >>
// // Use Of An Instrumental Break >>
// // Use Of A Vocal Break
// // Last Section >>
// // Outro Length Range >>
// $reportsarr["Song Structure"]["First-Section"] = "First Section";
// $reportsarr["Song Structure"]["Average-Intro-Length"] = "Average Intro Length";
// $reportsarr["Song Structure"]["Intro-Length-Range"] = "Intro Length Range";
// $reportsarr["Song Structure"]["Intro-Instrumental-Combo"] = "Intro Instrumental Vocal or Instrumental";
// $reportsarr["Song Structure"]["Intro-Characteristics"] = "Intro Characteristics";
// $reportsarr["Song Structure"]["Hook-Based-Intros"] = "Hook-Based Intros";
// $reportsarr["Song Structure"]["Verse-Count"] = "Verse Count"; 
// $reportsarr["Song Structure"]["Songs-That-Contain-A-Pre-Chorus"] = "Use Of A Pre-Chorus";
// $reportsarr["Song Structure"]["Pre-Chorus-Count"] = "Pre-Chorus Count"; 
// $reportsarr["Song Structure"]["First-Chorus-Avg-Time-Into-Song"] = "First Chorus: Average Time Into Song";
// $reportsarr["Song Structure"]["First-Chorus-Time-Into-Song-Range"] = "First Chorus: Time Into Song Range";
// $reportsarr["Song Structure"]["First-Chorus-Avg-Percent-Into-Song"] = "First Chorus: Average Percent Into Song";
// $reportsarr["Song Structure"]["First-Chorus-Percent-Into-Song-Range"] = "First Chorus: Percent Into Song Range";
// $reportsarr["Song Structure"]["Chorus-Preceding-First-Verse"] = "Chorus Preceding First Verse";
// $reportsarr["Song Structure"]["Chorus-Count"] = "Chorus Count"; 
// $reportsarr["Song Structure"]["Songs-That-Contain-A-Post-Chorus"] = "Use Of A Post-Chorus"; 
// $reportsarr["Song Structure"]["Post-Chorus-Sections"] = "Post-Chorus Sections"; 
// $reportsarr["Song Structure"]["Post-Chorus-Count"] = "Post-Chorus Count"; 
// $reportsarr["Song Structure"]["Songs-That-Contain-A-Bridge-Or-Bridge-Surrogate"] = "Use Of A \"D\" Section";
// $reportsarr["Song Structure"]["D-Section-Breakdown"] = "\"D\" Section Breakdown";
// $reportsarr["Song Structure"]["Songs-That-Contain-A-PI"] = "Use Of An Instrumental Break";
// $reportsarr["Song Structure"]["Instrumental-Break-Count"] = "Instrumental Break Count"; 
// $reportsarr["Song Structure"]["Songs-That-Contain-A-VB"] = "Use Of A Vocal Break";
// $reportsarr["Song Structure"]["Vocal-Break-Count"] = "Vocal Break Count"; 
// $reportsarr["Song Structure"]["Last-Section"] = "Last Section";
// $reportsarr["Song Structure"]["Average-Outro-Length"] = "Average Outro Length";
// $reportsarr["Song Structure"]["Outro-Length-Range"] = "Outro Length Range";
// //$reportsarr["Song Structure"]["Outro-Characteristics"] = "Outro Characteristics";


// // for testing an individual
// if( $_GET["help3"] )
//     {
//     $reportsarr = array();
//     $reportsarr["Genres & Sub-Genres"]["Primary-Genres"] = "Primary Genres";
//     $reportsarr["Genres & Sub-Genres"]["Sub-Genres-Influencers"] = "Sub-Genres";
//     }
// //$reportsarr["General Characteristics & Instruments"]["Chorus-Count"] = "Chorus Count";
// //$reportsarr["Overview"]["Most-Popular-Characteristics"] = "Most Popular Characteristics";

// // $reportsarr["Lead Vocals"]["Single-vs-Multiple-Lead-Vocalists"] = "Solo vs. Multiple Lead Vocalists";
// // $reportsarr["Lyrics & Title"]["Song-Title-Word-Count"] = "Song Title Word Count";
// //$reportsarr["Genres & Sub-Genres"]["Primary-Genres"] = "Primary Genres";
// //$reportsarr["Lead Vocals"]["Lead-Vocal"] = "Lead Vocal Gender";

// }

// $reportsarr["Genres & Sub-Genres"]["Primary-Genres"] = "Primary Genres";


function getBenchmarkGraphNameConverter( $sectionname )
{
//    if( $sectionname == "Primary Genres" ) return "Primary Genres"; // ok
    if( $sectionname == "Genres" ) return "Genres"; // ok
    if( $sectionname == "Influences" ) return "Influences"; // ok

    return "";
    
}

?>
