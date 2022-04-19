<?php

//     db_query( "delete from song_to_lyricaltheme" );
// $res = db_query_rows( "select lt.id, songid from song_to_lyricalsubtheme st, lyricalthemes lt, lyricalsubthemes ls where ls.LyricalTheme = lt.Name and st.lyricalsubthemeid = ls.id" );
//   //echo( "select lt.id, songid from song_to_lyricalsubtheme st, lyricalthemes lt, lyricalsubthemes ls where ls.LyricalTheme = lt.Name and st.lyricalsubthemeid = ls.id" );
// foreach( $res as $r )
// {
// db_query( "delete from song_to_lyricaltheme where songid = '$r[songid]' and lyricalthemeid = '$r[id]'" );
//         db_query( "insert into song_to_lyricaltheme ( songid, lyricalthemeid ) values ( $r[songid], $r[id] )" ); 
// } 


function isRounder( $comparisonaspect )
{
    if( in_array( $comparisonaspect, array( "AssonanceAlliterationScore", "WordsPerLineAvg", "ConsonanceAlliterationScore", "Loudness", "ChordRepetition", "AverageWordRepetition", "RhymesPerLine", "LyricalDensity", "MainMelodicRangeNum" ) ) )
	return true;
    return false;

}


function isHighestToLowest( $title )
{
//    file_put_contents( "doing", $title, FILE_APPEND );
    if( $title == "Key (major/minor)" || 
	$title == "Chord degree prevalence" ||
	$title == "Lyrical Moods" ||
	$title == "Lyrical Themes" ||
	$title == "UseOf7thChordsRange" || 
	$title == "ChordRepetitionRange" || 
	$title == "ChordDegreePrevalence" || 
	$title == "UseOfInvertedChordsRange" || 
	$title == "MelodicIntervalPrevalence" || 
	$title == "NumMelodicThemesRange" || 
	$title == "TotalAlliterationRange" || 
	$title == "MainMelodicRange" || 
	$title == "LyricalSubThemes" || 
	$title == "PercentDiatonicChordsRange" || 
	$title == "Prominent Instruments" || 
	//	$title == "Primary Genre" || 
	$title == "ProfanityRange" || 
	$title == "Genres" || 
	$title == "Influences" || 
	$title == "VocalsInstrumentsPrevalence" || 
	$title == "LastSectionType" || 
	$title == "Song Form" || 
	$title == "RhymeDensityRange" || 
	$title == "EndOfLineRhymesPercentageRange" || 
	$title == "EndLinePerfectRhymesPercentageRange" || 
	$title == "MidLineRhymesPercentageRange" || 
	$title == "ThousandWordsPrevalenceRange" || 
	$title == "TotalAlliterationRange" || 
	$title == "Timbre" || 
	$title == "SlangWordsRange" || 
	$title == "LocationReferencesRange" || 
	$title == "GeneralPersonReferencesRange" || 
	$title == "GeneralLocationReferencesRange" || 
	$title == "PersonReferencesRange" || 
	$title == "SlangWordsRange" || 
	$title == "OverallRepetitivenessRange" || 
	$title == "InternalRhymesPercentageRange" || 
	$title == "FirstSectionType" || 
	$title == "Timbre" || 
	$title == "Danceability" || 
	$title == "DanceabilityRange" || 
	$title == "ProductionMood" || 
	$title == "UseOfMajor7thChordsRange" || 
	$title == "VerseCount" || 
	$title == "PreChorusCount" || 
	$title == "UseofParallelMode" || 
	$title == "LiteralExperiencesvsAbstract" || 
	$title == "ChorusCount" || 
	$title == "Chorus Precedes Any Section" || 
	$title == "Departure Section" || 
	$title == "NumMelodicThemesRange" || 
	$title == "First Section" || 
	$title == "Last Section" || 
	$title == "SongTitleWordCount" || 
	$title == "SlangWords" || 
	$title == "SlangWordsRange" || 
	$title == "PersonReferences" || 
	$title == "LocationReferences" || 
	$title == "GeneralPersonReferences" || 
	$title == "GeneralLocationReferences" || 
	$title == "Key (Major, Minor, Major Mode, Minor Mode)" || 
	$title == "PercentDiatonicChordsRange" || 
	$title == "Word Prevalence (Top 1000 words)" || 
	$title == "LineRepetitionPrevalenceRange" 
	)

    return true; 
return false;

}



function isNotPercent( $comparisonaspect )
{
	return true;
    return false;
}

$possiblesearchfunctions = array();

// produiction
//$possiblesearchfunctions["Primary Genre Breakdown"] = "Genre Breakdown";
$possiblesearchfunctions["Genres"] = "Genres";
$possiblesearchfunctions["Influences"] = "Influences";
$possiblesearchfunctions["Prominent Instruments"] = "Prominent Instruments";
//$possiblesearchfunctions["Average Tempo"] = "Average Tempo (BPM)";
$possiblesearchfunctions["Tempo Range General"] = "Tempo Range (BPM)";
//$possiblesearchfunctions["Tempo Range"] = "Tempo Range (BPM) (Specific)";
$possiblesearchfunctions["Timbre"] = "Timbre";
$possiblesearchfunctions["ProductionMood"] = "Production Mood";
$possiblesearchfunctions["Danceability"] = "Danceability (Average)";
$possiblesearchfunctions["DanceabilityRange"] = "Danceability";
// end production

//structure
$possiblesearchfunctions["Average Song Length"] = "Average Song Length";
$possiblesearchfunctions["Song Length Range"] = "Song Length Range";
$possiblesearchfunctions["First Section"] = "First Section Type";
//$possiblesearchfunctions["Verse Count"] = "Verse Count";
//$possiblesearchfunctions["Pre-Chorus Count"] = "Pre-Chorus Count";
$possiblesearchfunctions["Chorus Count"] = "Chorus Count";
//$possiblesearchfunctions["Departure Section"] = "Departure Section";
$possiblesearchfunctions["Last Section"] = "Last Section Type";
// end structure

$possiblesearchfunctions["Average Intro Length"] = "Average Intro Length";
$possiblesearchfunctions["Intro Length Range"] = "Intro Length Range";
$possiblesearchfunctions["Genre Count"] = "Genre Count";
$possiblesearchfunctions["Influence Count"] = "Influence Count";
$possiblesearchfunctions["Use Of A Pre-Chorus"] = "Use Of A Pre-Chorus";
$possiblesearchfunctions["Chorus Precedes Any Section"] = "Chorus Precedes Any Section";
$possiblesearchfunctions["First Chorus: Time Into Song Range"] = "First Chorus: Time Into Song Range";
$possiblesearchfunctions["First Chorus: Percent Into Song Range"] = "First Chorus: Percent Into Song Range";
$possiblesearchfunctions["First Chorus: Average Time Into Song"] = "First Chorus: Average Time Into Song";
$possiblesearchfunctions["First Chorus: Average Percent Into Song"] = "First Chorus: Average Percent Into Song";
$possiblesearchfunctions["Use Of A Vocal Post-Chorus"] = "Use Of A Vocal Post-Chorus";
$possiblesearchfunctions["Average Outro Length"] = "Average Outro Length";
$possiblesearchfunctions["Outro Length Range"] = "Outro Length Range";
$possiblesearchfunctions["Song Title Appearances"] = "Song Title Appearances";
$possiblesearchfunctions["Electronic Vs. Acoustic Songs"] = "Predominantly Acoustic vs Electronic";

$possiblesearchfunctions["Vocal Post-Chorus Count"] = "Vocal Post-Chorus Count";
$possiblesearchfunctions["Number of Songs (Form)"] = "Number of Songs (Form)";

$possiblesearchfunctions["Intro Instrumental Vocal or Instrumental"] = "Intro (Instrumental or Vocal)";
$possiblesearchfunctions["Outro Instrumental Vocal or Instrumental"] = "Outro (Instrumental or Vocal)";





$possiblesearchfunctions["ConsonanceAlliterationScore"] = "Consonance Alliteration Score";
$possiblesearchfunctions["AssonanceAlliterationScore"] = "Assonance Alliteration Score";

// 
$possiblesearchfunctions["Key"] = "Key";
$possiblesearchfunctions["KeyMajorMinor"] = "Key (Major vs. Minor)";
$possiblesearchfunctions["Key (Major, Minor, Major Mode, Minor Mode)"] = "Key (Major, Minor, Major Mode, Minor Mode)";
$possiblesearchfunctions["MainMelodicRange"] = "Main Melodic Range";
$possiblesearchfunctions["MainMelodicRangeNum"] = "Main Melodic Range (Number)";
$possiblesearchfunctions["MelodicIntervalPrevalence"] = "Melodic Interval Prevalence";
$possiblesearchfunctions["NumMelodicThemes"] = "Amount of Themes In Song";
$possiblesearchfunctions["NumMelodicThemesRange"] = "Diverse Melodic Themes";
$possiblesearchfunctions["ChordRepetition"] = "Chord Repetition (Average)";
$possiblesearchfunctions["ChordRepetitionRange"] = "Chord Repetition";
$possiblesearchfunctions["UseOf7thChords"] = "Use of 7th Chords (Average)";
$possiblesearchfunctions["UseOf7thChordsRange"] = "Use of 7th Chords";
$possiblesearchfunctions["UseOfInvertedChords"] = "Use Of Inverted Chords (Average)";
$possiblesearchfunctions["UseOfInvertedChordsRange"] = "Use of Inverted Chords";
$possiblesearchfunctions["PercentDiatonicChords"] = "Diatonic Chord Prevalence (Average)";
$possiblesearchfunctions["PercentDiatonicChordsRange"] = "Diatonic Chord Prevalence";
$possiblesearchfunctions["ChordDegreePrevalence"] = "Chord Degree Prevalence";
//


$possiblesearchfunctions["WordsRepetitionPrevalence"] = "Use of In-Line Lyric Repetition";
$possiblesearchfunctions["PercentNonDictionary"] = "Use of Non Dictionary Words";
$possiblesearchfunctions["RhymesPerSyllable"] = "Percentage of Rhyming Syllables (Average)";
$possiblesearchfunctions["RhymesPerSyllableRange"] = "Percentage of Rhyming Syllables";
$possiblesearchfunctions["RhymesPerLine"] = "Rhymes Per Line"; // average?
$possiblesearchfunctions["RhymesPerLineRange"] = "Rhymes per Line (Range)";
$possiblesearchfunctions["NumberOfRhymeGroupsELR"] = "Number Of Rhyme Groups In The Song By ELR (Average)";
$possiblesearchfunctions["NumberOfRhymeGroupsELRRange"] = "Number Of Rhyme Groups In The Song By ELR";
$possiblesearchfunctions["VocalsInstrumentsPrevalence"] = "Vocal vs. Instrumental Prevalence";
$possiblesearchfunctions["ConsumerGoodsReferences"] = "Consumer Goods References";
$possiblesearchfunctions["CreativeWorksTitles"] = "Creative Works Title References";
$possiblesearchfunctions["EndLineSecondaryPerfectRhymesPercentage"] = "Use of Perfect Secondary Rhymes";
$possiblesearchfunctions["PerfectRhymesPercentage"] = "Use of Perfect Rhymes (Average)";
$possiblesearchfunctions["PerfectRhymesPercentageRange"] = "Use of Perfect Rhymes";

//lyrical
$possiblesearchfunctions["Lyrical Moods"] = "Lyrical Moods";
$possiblesearchfunctions["Lyrical Themes"] = "Lyrical Themes";
$possiblesearchfunctions["LyricalSubThemes"] = "Lyrical Sub-themes";
$possiblesearchfunctions["Song Title Word Count"] = "Song Title Word Count";
$possiblesearchfunctions["ConsonanceRhymePercentage"] = "Use of Consonance Rhymes (Average)";
$possiblesearchfunctions["ConsonanceRhymePercentageRange"] = "Use of Consonance Rhymes";
$possiblesearchfunctions["AssonanceRhymePercentage"] = "Use of Assonance Rhymes (Average)";
$possiblesearchfunctions["AssonanceRhymePercentageRange"] = "Use of Assonance Rhymes";
$possiblesearchfunctions["InternalRhymesPercentage"] = "Use of Internal Rhymes (Average)";
$possiblesearchfunctions["InternalRhymesPercentageRange"] = "Use of Internal Rhymes";
$possiblesearchfunctions["MidWordRhymes"] = "Use of Mid-Word Rhymes (Average)";
$possiblesearchfunctions["MidWordRhymesRange"] = "Use of Mid-Word Rhymes";
$possiblesearchfunctions["MidLineRhymesPercentage"] = "Use of Mid-Line Rhymes (Average)";
$possiblesearchfunctions["MidLineRhymesPercentageRange"] = "Use of Mid-Line Rhymes";
$possiblesearchfunctions["RhymeDensity"] = "Rhyme Density (Average)";
$possiblesearchfunctions["RhymeDensityRange"] = "Rhyme Density";
//$possiblesearchfunctions["LineRepetitionPrevalence"] = "Line Repetition (Average)";
//$possiblesearchfunctions["LineRepetitionPrevalenceRange"] = "Line Repetition";
$possiblesearchfunctions["EndOfLineRhymesPercentage"] = "Use of End-of-Line Rhymes (Average)";
$possiblesearchfunctions["EndOfLineRhymesPercentageRange"] = "Use of End-of-Line Rhymes";
$possiblesearchfunctions["EndLinePerfectRhymesPercentage"] = "Use of End-of-Line Perfect Rhymes (Average)";
$possiblesearchfunctions["EndLinePerfectRhymesPercentageRange"] = "Use of End-of-Line Perfect Rhymes";
$possiblesearchfunctions["EndLineAssonanceRhymePercentage"] = "Use of End-of-Line Assonance Rhymes (Average)";
$possiblesearchfunctions["EndLineAssonanceRhymePercentageRange"] = "Use of End-of-Line Assonance Rhymes";
$possiblesearchfunctions["EndLineConsonanceRhymePercentage"] = "End-of-Line Consonance Rhymes";
//$possiblesearchfunctions["PercentAbbreviations"] = "Use of Word Abbreviations";
$possiblesearchfunctions["SlangWordsRange"] = "Use of Slang";
$possiblesearchfunctions["PercentProfanity"] = "Use of Profanity";
$possiblesearchfunctions["ProfanityRange"] = "Profanity";
$possiblesearchfunctions["PersonReferences"] = "Person References (Average)";
$possiblesearchfunctions["PersonReferencesRange"] = "Person References";
$possiblesearchfunctions["GeneralPersonReferences"] = "General Person References (Average)";
$possiblesearchfunctions["GeneralPersonReferencesRange"] = "General Person References";
$possiblesearchfunctions["LocationReferences"] = "Location References (Average)";
$possiblesearchfunctions["LocationReferencesRange"] = "Location References";
$possiblesearchfunctions["GeneralLocationReferences"] = "General Location References (Average)";
$possiblesearchfunctions["GeneralLocationReferencesRange"] = "General Location References";
$possiblesearchfunctions["OrganizationorBrandReferences"] = "Organization or Brand References";
$possiblesearchfunctions["ThousandWordsPrevalenceRange"] = "Usage of Very Common Words";
$possiblesearchfunctions["TenThousandWordsPrevalence"] = "Words Prevalence - Top 10,000 Words";
$possiblesearchfunctions["FiftyThousandWordsPrevalence"] = "Words Prevalence - Top 50,000 Words";
//

$possiblesearchfunctions["WordsPerLineAvg"] = "Words Per Line (Average)";
$possiblesearchfunctions["PreChorusSectionLyrics"] = "Pre-Chorus Section Lyrics";
$possiblesearchfunctions["UseofParallelMode"] = "Use of Parallel Mode";
$possiblesearchfunctions["UseOfTriads"] = "Use Of Triads (Average)";
$possiblesearchfunctions["UseOfTriadsRange"] = "Use Of Triads";
$possiblesearchfunctions["AverageWordRepetition"] = "Average Word Repetion (Full Song) (Average)";
$possiblesearchfunctions["AverageWordRepetitionRange"] = "Average Word Repetition (Full Song) ";
$possiblesearchfunctions["LiteralExperiencesvsAbstract"] = "Literal Experiences vs. Abstract";
$possiblesearchfunctions["LyricalDensity"] = "Lyrical Density (Average)";
$possiblesearchfunctions["LyricalDensityRange"] = "Lyrical Density";
//$possiblesearchfunctions["UseOfMajor7thChords"] = "Major 7th Prevalence (Average)";
//$possiblesearchfunctions["UseOfMajor7thChordsRange"] = "Major 7th Prevalence";
$possiblesearchfunctions["SecondaryPerfectRhymesPercentage"] = "End-of-Line Secondary Rhymes";
$possiblesearchfunctions["FirstChorusTimeIntoSong"] = "First Chorus: Time Into Song";
$possiblesearchfunctions["SectionCountRange"] = "Number of Distinct Sections";



$possiblesearchfunctions["Loudness"] = "Loudness (Average)";
$possiblesearchfunctions["LoudnessRange"] = "Loudness";

$possiblesearchfunctions["SectionCount"] = "Number of Distinct Sections (Specific)";

$possiblesearchfunctions["OverallRepetitiveness"] = "Overall Repetitiveness (Average)";
$possiblesearchfunctions["OverallRepetitivenessRange"] = "Overall Repetitiveness";
$possiblesearchfunctions["ConsonanceAlliterationScore"] = "Average Consonance Alliteration (Average)";
$possiblesearchfunctions["AssonanceAlliterationScore"] = "Average Assonance Alliteration (Average)";
$possiblesearchfunctions["ConsonanceAlliterationScoreRange"] = "Average Consonance Alliteration";
$possiblesearchfunctions["AssonanceAlliterationScoreRange"] = "Average Assonance Alliteration";
$possiblesearchfunctions["TotalAlliterationRange"] = "Total Alliteration";



$possibletopnumbers = array();
$possibletopnumbers["Top 3"] = "Top 3 Songs";
$possibletopnumbers["Top 5"] = "Top 5 Songs";
$possibletopnumbers["Top 10"] = "Top 10 Songs";


function getMyPossibleSearchFunctions( $type = "" )
{
    global $possiblesearchfunctions;
    // if( $type == "influences" )
    // {
    //     $tmp = array( "Primary Genres", "Sub-Genres/Influences" );
    // }
    // if( $type == "vocals" )
    // {
    //     $tmp = array( "Lyrical Themes", "Song Title Word Count", "Song Title Appearances" );
    // }
    if( $type == "structure" )
    {
        $tmp = array( "Average Song Length" , 
		      "Song Length Range", 
		      "First Section Type", 
		      "Verse Count", 
		      "Pre-Chorus Count", 
		      "Chorus Count", 
		      "Departure Section", 
		      "Last Section Type" ); //", "Number of Songs (Form)
	//", "Prominent Instruments"        $tmp = array( "Song Length Range", "Average Song Length", "Song Form", "Number of Songs (Form)" , "First Section Type", "Average Intro Length", "Intro Length Range", "Intro Instrumental Vocal or Instrumental", "Verse Count", "Pre-Chorus Count", "Chorus Count", "Use Of A Pre-Chorus", "Chorus Precedes Any Section", "First Chorus: Time Into Song Range", "First Chorus: Percent Into Song Range", "First Chorus: Average Time Into Song", "First Chorus: Average Percent Into Song", "Vocal Post-Chorus Count", "Use Of A Vocal Post-Chorus", "Departure Section", "Last Section Type", "Average Outro Length", "Outro Length Range", "Outro (Instrumental or Vocal)", "Number of Distinct Sections" ); //", "Prominent Instruments", "Key", "KeyMajorMinor
    }
    if( $type == "compositional" )
	{
	    $tmp = array( "Diverse Melodic Themes", 
			  "Melodic Interval Prevalence", 
			  "Main Melodic Range", 
			  "Number of Melodic Themes", 
			  "Key (Major vs. Minor)", 
			  "Key (Major, Minor, Major Mode, Minor Mode)", 
			  "Diatonic Chord Prevalence", 
			  "Use of Inverted Chords", 
			  "Use of 7th Chords", 
			  "Chord Degree Prevalence", 
			  "Chord Repetition", 
			  "Major 7th Prevalence" );
	    //	    $tmp = array( "Number of Distinct Melodic Themes", "Melodic Interval Prevalence", "Main Melodic Range", "Main Melodic Range (Number)", "Number of Melodic Themes", "Key", "Key (Major vs. Minor)", "Key (Major, Minor, Major Mode, Minor Mode)", "Use of Parallel Mode", "Diatonic Chord Prevalence", "Use of Inverted Chords", "Use Of Triads", "Use of 7th Chords", "Chord Degree Prevalence" );
	}

    if( $type == "production" )
	{
	    $tmp = array(
			  "Influences", 
			  "Prominent Instruments", 
			  "Average Tempo", 
			  "Tempo Range (BPM)", 
			  "Tempo Range (BPM) (Specific)", 
			  "Timbre", 
			  "Production Mood", 
			  "DanceabilityRange" );
	    //	    $tmp = array( "Average Tempo", "Tempo Range (BPM)", "Tempo Range (Specific)", "Vocal vs. Instrumental Prevalence", "Timbre", "Primary Genres", "Sub-Genres", "Influences", "Production Mood", "DanceabilityRange", "LoudnessRange", "Prominent Instruments" );

	    if( !isNoGenreChart() )
	    {
	    array_unshift( $tmp,  "Genres" );
	    }
	}

    if( $type == "lyrical" )
	{
	    $tmp = array(  "Song Title Word Count", 
"Person References", 
"Location References", 
"Lyrical Themes", 
"Lyrical Moods", 
"Line Repetition", 
"Usage of Very Common Words", 
"Use of Word Abbreviations", 
"Use of Slang", 
"Profanity", 
"RhymeDensityRange", 
"Use of End-of-Line Rhymes", 
"Use of Internal Rhymes", 
"Use of Mid-Line Rhymes", 
"Overall Repetitiveness", 
"Use of End-of-Line Perfect Rhymes", 
"Total Alliteration" );
	    
	    //	    $tmp = array(  "Song Title Word Count", "Song Title Appearances", "Person References", "Location References", "Organization or Brand References", "Consumer Goods References", "Creative Works Title References", "Literal Experiences vs. Abstract", "Lyrical Sub-themes", "Lyrical Themes", "Lyrical Moods", "Use of In-Line Lyric Repetition", "Line Repetition", "Overall Repetitiveness", "Usage of Very Common Words", "Words Prevalence - Top 10,000 Words", "Words Prevalence - Top 10,000 Words", "Use of Word Abbreviations", "Use of Slang", "Use of Profanity", "Average Consonance Alliteration", "Average Assonance Alliteration", "RhymeDensityRange", "RhymesPerLineRange", "Percentage of Rhyming Syllables", "Average Rhymes per Line", "Number Of Rhyme Groups In The Song By ELR", "Use of End-of-Line Perfect Rhymes", "Use of End-of-Line Assonance Rhymes", "Use of Perfect Rhymes", "Use of Consonance Rhymes", "Use of Assonance Rhymes", "Use of End-of-Line Rhymes", "Use of Internal Rhymes", "Use of Mid-Word Rhymes", "Use of Mid-Line Rhymes", "Lyrical Density", "Words Per Line (Average)", "Rhymes Per Line", "AverageWordRepetitionRange" );
	    
	}


    if( count( $tmp ) )
    {
        $retval = array();
        foreach( $possiblesearchfunctions as $k=>$v )
        {
            if( in_array( $k, $tmp ) || in_array( $v, $tmp ) )
                $retval[$k] = $v;
        }
        return $retval;
    }
    return $possiblesearchfunctions;
}



function calcTrendQSStart( $q, $seasontouse = "" )
{
    global $search, $nodates, $specificpeak, $barname, $genrefilter, $newcarryfilter, $doingweeklysearch, $doingyearlysearch, $season, $withimprint, $lyricalmoodfilter, $lyricalsubthemefilter, $lyricalthemefilter, $bpmfilter, $majorminorfilter, $minweeksfilter, $barname, $columns;
    $seasontouse = $seasontouse?$seasontouse:$season;
    $qspl = explode( "/", $q );
    $qs = "";
    file_put_contents( "/tmp/q", "for rachel: $q\n", FILE_APPEND );
    if( strpos( $q, "-" ) !== false )
	{
	    // this is for most popular characteristics
	    list( $start, $end ) = explode( "-", $q );
	    $exp = explode( "/", $start );
	    $qs .= "search[dates][fromq]=" . ( count( $exp ) > 1?array_shift( $exp ):"1")."&";
	    $qs .= "search[dates][fromy]=" . array_shift( $exp ) . "&";
	    $exp = explode( "/", $end );
	    $qs .= "search[dates][toq]=" . ( count( $exp ) > 1?array_shift( $exp ):"1")."&";
	    $qs .= "search[dates][toy]=" . array_shift( $exp ) . "&";
	}
    // else if( $seasontouse == FALLWINTER )
    // 	{
    // 	    $tmpyear = $q;
    //     $qs .= "search[dates][fromq]=4&";
    //     $qs .= "search[dates][fromy]={$tmpyear}&";
    //     $qs .= "search[dates][toq]=1&";
    //     $qs .= "search[dates][toy]=" . ($tmpyear) . "&";
    // 	}
    // else if( $seasontouse == SPRINGSUMMER )
    // 	{
    //     $qs .= "search[dates][fromq]=2&";
    //     $qs .= "search[dates][fromy]={$qspl[1]}&";
    //     $qs .= "search[dates][toq]=3&";
    //     $qs .= "search[dates][toy]={$qspl[1]}&";
    // 	}
    else if( $seasontouse && $seasontouse != ALLSEASONS && $seasontouse != ALLSEASONS24 )
	{
	    $tmpyear = $qspl[count( $qspl ) - 1];
	    $qs .= "search[dates][fromq]=" . getFirstSeason( $seasontouse ) . "&";
	    $qs .= "search[dates][fromy]={$tmpyear}&";
	    $qs .= "search[dates][toq]=" . getFirstSeason( $seasontouse ) . "&";
	    $qs .= "search[dates][toy]=$tmpyear&";
	}
    else if( $doingyearlysearch && !$q )
    {
        $qs .= "search[dates][fromq]=1&";
        $qs .= "search[dates][fromy]={$search[dates][fromyear]}&";
	if( $search["dates"]["specialendq"])
	    $qs .= "search[dates][toq]=" . $search["dates"]["specialendq"] . "&";
	else
	    $qs .= "search[dates][toq]=4&";
        $qs .= "search[dates][toy]={$search[dates][toyear]}&";
    }
    else if ( $doingyearlysearch )
	{
        $qs .= "search[dates][fromq]=1&";
        $qs .= "search[dates][fromy]={$q}&";
	if( $search["dates"]["specialendq"] && $q == $search["dates"]["toy"])
	    $qs .= "search[dates][toq]=" . $search["dates"]["specialendq"] . "&";
	else
	    $qs .= "search[dates][toq]=4&";
        $qs .= "search[dates][toy]={$q}&";
	}
    else if( $doingweeklysearch && !$q )
    {
        $qs .= "search[dates][fromweekdate]={$search[dates][fromweekdate]}&";
        $qs .= "search[dates][toweekdate]={$search[dates][toweekdate]}&";
    }
    else if ( $doingweeklysearch )
	{
        $qs .= "search[dates][fromweekdate]={$q}&";
        $qs .= "search[dates][toweekdate]={$q}&";
	}
    else if( !$nodates )
    {
        $qs .= "search[dates][fromq]={$qspl[0]}&";
        $qs .= "search[dates][fromy]={$qspl[1]}&";
    }




    if( $barname == "Carryovers" )
    {
        $qs .= "search[toptentype]=Carryovers&";
    }
    else if( $barname == "New Songs" )
    {
        $qs .= "search[toptentype]=New+Arrivals&";
    }
    else if( $search["toptentype"] )
    {
        $qs .= "search[toptentype]={$search[toptentype]}&";
    }
    if( $search["chartid"] )
    {
        $qs .= "search[chartid]={$search[chartid]}&";
    }
    if( $bpmfilter )
    {
        $qs .= "search[TempoRange]=$bpmfilter&";
    }
    if( $majorminorfilter )
    {
        $qs .= "search[majorminor]=$majorminorfilter&";
    }
    if( $lyricalsubthemefilter )
    {
        $qs .= "search[lyricalsubthemes][$lyricalsubthemefilter]=1&";
    }
    if( $minweeksfilter )
    {
        $qs .= "search[minweeks]=$minweeksfilter&";
    }
    if( $lyricalthemefilter )
    {
        $qs .= "search[lyricalthemes][$lyricalthemefilter]=1&";
    }
    if( $lyricalmoodfilter )
    {
        $qs .= "search[lyricalmoods][$lyricalmoodfilter]=1&";
    }
    if( $withimprint )
    {
        $qs .= "search[withimprint]=1&";
    }
    if( $_GET["searchclientid"] )
        $qs .= "searchclientid={$_GET[searchclientid]}&";
    if( $specificpeak )
    {
        $qs .= "search[peakwithin]={$specificpeak}&";
    }
    else if( $search["benchmarktype"] )
	{
	    if( !is_array( $columns[$barname] ) )
	        $qs .= "search[peakwithin]={$columns[$barname]}&";
	}
    else
        $qs .= "search[peakwithin]={$search[peakchart]}&";

    if( $seasontouse )
        $qs .= "search[dates][season]={$seasontouse}&";
    if( $genrefilter )
        $qs .= "search[GenreID]={$genrefilter}&";
    if( $search[specificsubgenre] )
        $qs .= "search[specificsubgenre]={$search[specificsubgenre]}&";
    if( $search[specificinfluence] )
        $qs .= "search[specificinfluence]={$search[specificinfluence]}&";
    //    if( $search["lyricalmoodid"] )
    //        $qs .= "search[lyricalmoodid]={$search[lyricalmoodid]}&";
    //    if( $search["lyricalthemeid"] )
    //        $qs .= "search[writerid]={$search[lyricalthemeid]}&";
    if( $newcarryfilter == "new" )
        $qs .= "search[toptentype]=New+Songs&";
    if( $newcarryfilter == "carryover" )
        $qs .= "search[toptentype]=Carryovers&";
    return $qs;
}

function calcTrendQSStartBar()
{
    global $search, $nodates, $genrefilter, $specificpeak, $barname, $doingweeklysearch, $newcarryfilter, $doingyearlysearch, $doingthenandnow, $dateurlstouse, $withimprint, $lyricalmoodfilter, $lyricalsubthemefilter, $lyricalthemefilter, $bpmfilter, $majorminorfilter, $minweeksfilter, $columns, $season;
//    echo( "<br>min: $minweeksfilter<br>" );
    $qspl = explode( "/", $q );
    $qs = "";
//    file_put_contents( "/tmp/barname", "$barname, $specificpeak \n", FILE_APPEND );
    if( $doingweeklysearch )
    {
	if( $doingthenandnow )
	    {
		// echo( "hmm ($barname)" );
		// print_r( $dateurlstouse );
		$qs .= "&".$dateurlstouse[$barname] . "&";
		//		echo( $qs );
	    }
	else
	    {
		$qs .= "search[dates][fromweekdate]={$search[dates][fromweekdate]}&";
		$qs .= "search[dates][toweekdate]={$search[dates][toweekdate]}&";
	    }
    }
    else if ( $doingyearlysearch )
	{
	if( $doingthenandnow )
	    {
		//		 echo( "hmm ($barname)" );
		$qs .= "&".$dateurlstouse[$barname] . "&";
		if( $_GET["help3"] )
		    {
		    echo( nl2br( print_r( $dateurlstouse , true) ) );
		    echo( $qs . "<br>");
		    }
	    }
	else
	    {
		$qs .= "search[dates][fromq]=1&";
		$qs .= "search[dates][fromy]={$search[dates][fromy]}&";
		if( $search["dates"]["specialendq"])
		    $qs .= "search[dates][toq]=" . $search["dates"]["specialendq"] . "&";
		else
		    $qs .= "search[dates][toq]=4&";
		$qs .= "search[dates][toy]={$search[dates][toy]}&";
	    }

	}
    else if( !$nodates )
    {
        $qs .= "search[dates][fromq]={$search[dates][fromq]}&";
        $qs .= "search[dates][fromy]={$search[dates][fromy]}&";
        $qs .= "search[dates][toq]={$search[dates][toq]}&";
        $qs .= "search[dates][toy]={$search[dates][toy]}&";
    }
    if( $specificpeak )
    {
        $qs .= "search[peakwithin]={$specificpeak}&";
    }
    if( $season )
    {
        $qs .= "search[season]={$season}&";
    }
    else if( $search["benchmarktype"] )
	{
	    if( !is_array( $columns[$barname] ) )
		$qs .= "search[peakwithin]={$columns[$barname]}&";
	}
    if( $search["peakchart"] )
        $qs .= "search[peakwithin]={$search[peakchart]}&";
    if( $search["chartid"] )
    {
        $qs .= "search[chartid]={$search[chartid]}&";
    }
    if( $newcarryfilter == "new" )
        $qs .= "search[toptentype]=New+Songs&";
    if( $newcarryfilter == "carryover" )
        $qs .= "search[toptentype]=Carryovers&";
    if( $barname && $barname == "Carryovers" )
    {
        $qs .= "search[toptentype]=Carryovers&";
    }
    if( $barname && $barname == "New Songs" )
    {
        $qs .= "search[toptentype]=New+Songs&";
    }
    if( $search["chartid"] )
    {
        $qs .= "search[chartid]={$search[chartid]}&";
    }
    if( $bpmfilter )
    {
        $qs .= "search[TempoRange]=$bpmfilter&";
    }
    if( $majorminorfilter )
    {
        $qs .= "search[majorminor]=$majorminorfilter&";
    }
    if( $lyricalsubthemefilter )
    {
        $qs .= "search[lyricalsubthemes][$lyricalsubthemefilter]=1&";
    }
    if( $minweeksfilter )
    {
        $qs .= "search[minweeks]=$minweeksfilter&";
    }
    if( $lyricalthemefilter )
    {
        $qs .= "search[lyricalthemes][$lyricalthemefilter]=1&";
    }
    if( $lyricalmoodfilter )
    {
        $qs .= "search[lyricalmoods][$lyricalmoodfilter]=1&";
    }
    if( $search[specificsubgenre] )
        $qs .= "search[specificsubgenre]={$search[specificsubgenre]}&";
    if( $search[specificinfluence] )
        $qs .= "search[specificinfluence]={$search[specificinfluence]}&";
    if( $search["toptentype"] )
    {
        $qs .= "search[toptentype]={$search[toptentype]}&";
    }
    if( $genrefilter )
        $qs .= "search[GenreID]={$genrefilter}&";
    if( $withimprint )
        $qs .= "search[withimprint]={$withimprint}&";
    if( $_GET["searchclientid"] )
        $qs .= "searchclientid={$_GET[searchclientid]}&";
    return $qs;
}


$cachedtrenddata = array();

function getTrendDataForRows( $quarterstorun, $comparisonaspect, $peak="", $songstouse = array() )
{
    //    print_r( $quarterstorun );exit;
    global $newarrivalsonly, $cachedtrenddata, $searchsubtype, $dontincludeall, $sectionname, $doingweeklysearch, $allweekdatestorun, $allyearstorun, $doingyearlysearch, $genrefilter, $season, $seasonswithall, $withimprint, $possiblesearchfunctions;
    //    file_put_contents("/tmp/hmm",  "before: " . print_r( $songstouse, true ), FILE_APPEND );
    if( !count( $songstouse ) )
        $songstouse = array();
    if( !$quarterstorun )
        $quarterstorun = array();

    if( in_array( $possiblesearchfunctions, $comparisonaspect ) )
	{
	    $comparisonaspect = array_search( $possiblesearchfunctions, $comparisonaspect );
	}

    $key = "line:" . $comparisonaspect . "_" . $peak . "_" . (is_array( $quarterstorun)?implode( ",", $quarterstorun ):$quarterstorun) . "_" . implode( ",", $songstouse ) . "." . $doingyearlysearch . "_" . $doingweeklysearch . "_" . $season . "_" . $withimprint . "_" . $genrefilter . "." . implode( ",", $allweekdatestorun ) . ".". implode( ",", $allyearstorun );
    //    echo( $key );

    // echo( "<br>key is '$key'<br>" ) ; 
    // print_r( array_keys( $cachedtrenddata ) );

    // file_put_contents( "/tmp/hmm", "key is: $key \n", FILE_APPEND );
    // file_put_contents( "/tmp/hmm", "cache hit?: " . ( isset( $cachedtrenddata[$key] ) ) . " \n", FILE_APPEND );
    //    print_r( $quarterstorun );
    if( isset( $cachedtrenddata[$key] ) ) { 
//        file_put_contents( "/tmp/hmm", "cache values?: " . ( print_r( $cachedtrenddata[$key], true ) ) . " \n", FILE_APPEND );
	if( $_GET["help"] )
	    echo( "cache hit $key<br>\n" );
	       return $cachedtrenddata[$key];        
    }
    $retval = array();
    // logquery( "key is: $key" );
    // logquery( "CACHE is: ". print_r( $cachedtrenddata, true ) );
//    echo( "peak here is $peak" );

    $torun = $quarterstorun;
    if( $quarterstorun == "fullrange" )
	{
	    $tmpvals = array_values( $allyearstorun );
	    $torun = array( $tmpvals[0] . "-" . $tmpvals[count( $tmpvals )-1] );
	    //	    print_r( $torun );
	}
    else if( $quarterstorun == "fullrangeweek" )
	{
	    // print_r( $allweekdatestorun );
	    // exit;
	    $torun = array( $allweekdatestorun[0][OrderBy] . "-" . $allweekdatestorun[count( $allweekdatestorun )-1][OrderBy] );
	    //	    print_r( $torun );
	}
    else if( $quarterstorun == "fullrangequarter" )
	{
	    // print_r( $allweekdatestorun );
	    // exit;
	    $torun = array( $_GET["search"]["dates"]["fromq"] . "/" . $_GET["search"]["dates"]["fromy"] . "-" . $_GET["search"]["dates"]["toq"] . "/" . $_GET["search"]["dates"]["toy"] );
	    //	    print_r( $torun );
	}
    else if( $doingweeklysearch )
	$torun = $allweekdatestorun;
    else if( $doingyearlysearch )
	{
	    $torun = $allyearstorun;
	}
    // echo( "week: " . $doingweeklysearch );
    // if( $doingyearlysearch ) print_r( $torun );
    $theseseasons = calcSeasonsToLoop( $_GET["search"]["dates"]["season"] );
    $specialendq = $_GET["search"]["dates"]["specialendq"];
    if( $_GET["help"] ) echo( "seasons to run: " . print_r( $theseseasons, true ) . "<br>\n\n" );

    foreach( $theseseasons as $tmpseason ) // i hate this so much
	{
	    if( $_GET["help"] ) echo( "STARTING SEASON $tmpseason<br>\n" );
	    if( $_GET["help"] ) echo( " torun: " ); 
	    if( $_GET["help"] ) print_r( $torun );
	    if( $_GET["help"] ) echo( "\n\n" );
	    foreach( $torun as $q )
		{
		    if( $quarterstorun == "fullrange" )
			{
			    //			    print_r( $torun );
			    $exp = explode( "-", $q );
			    $songs = getSongIdsWithinQuarter( $newarrivalsonly, 1, $exp[0], 4, $exp[1], $peak, false, $tmpseason );
			}
		    else if( $quarterstorun == "fullrangeweek" )
			{
			    $exp = explode( "-", $q );
			    $songs = getSongIdsWithinWeekdates( $newarrivalsonly, $exp[0], $exp[1], $peak, false, $tmpseason );
			    
			}
		    else if( $quarterstorun == "fullrangequarter" )
			{
			    $exp = explode( "-", $q );
			    //			    print_r( $exp );
			    $songs = getSongIdsWithinQuarter( $newarrivalsonly, $_GET["search"]["dates"]["fromq"], $_GET["search"]["dates"]["fromy"], $_GET["search"]["dates"]["toq"], $_GET["search"]["dates"]["toy"], $peak, false, $tmpseason );
			    
			}
		    else if( $doingweeklysearch )
			{
			    $q = $q[OrderBy];
			    $songs = getSongIdsWithinWeekdates( $newarrivalsonly, $q, $q, $peak, false, $tmpseason );
			}
		    else if( $doingyearlysearch )
			{
			    if( $_GET["help"] )
				echo( "doingyear.y<br>" );
			    
			    // if( $tmpseason == FALLWINTER )
			    // 	{
			    // 	    if( $_GET["help"] )
			    // 		echo( "doingweirdseason<br>" );
			    // 	    $songs = getSongIdsWithinQuarter( $newarrivalsonly, getFirstSeason( $tmpseason), $q, getLastSeason( $tmpseason), $q+1, $peak, false, $tmpseason );
			    // 	}
			    // else
			    // 	{
			    $lastquarter = $season?getLastSeason( $tmpseason):4;
			    if( $q == $_GET["search"]["dates"]["toyear"] && $specialendq )
				{
				$lastquarter = $specialendq;

			    if( $_GET["help"] )
				echo( "doing it, ($q)<br>" );
				}
			    if( $_GET["help"] )
				echo( "$q," . $_GET["search"]["dates"]["toyear"]  . ", last quarter = $lastquarter, ($q)<br>" );
				    $songs = getSongIdsWithinQuarter( $newarrivalsonly, $tmpseason?getFirstSeason( $tmpseason):1, $q, $lastquarter, $q, $peak, false, $tmpseason );
				    //				}
			}
		    else
			{
			    $qspl = explode( "/", $q );
			    $songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1], "", "", $peak, false, $tmpseason );
			}
		    //		    print_r( $songs );
		    //		           file_put_contents( "/tmp/hmm",  "this is what we're counting1: " .  count( $songs ) . ": " . print_r( $songs, true ), FILE_APPEND );
		    if( count( $songstouse ) )
			{
			    //			    file_put_contents( "/tmp/hmm",  "YES is what we're counting2: " .  count( $songstouse ) . ": " . print_r( $songstouse, true ), FILE_APPEND );
			    // if we're only doing a subset, use these
			    $songs = array_intersect( $songs, $songstouse );
			}
		    //		    file_put_contents( "/tmp/hmm",  "this is what we're counting: " . count( $songs ) . ": " . print_r( $songs, true ), FILE_APPEND );
		    $numsongs = count( $songs );
		    // we need to add this in case there were none
		    if( !count( $songs ) )
			$songs[] = -1;
		    if( !$numsongs ) $numsongs = 1;
		    $songidstr = implode( ", ", $songs );
		    $qs = calcTrendQSStart( $q, $tmpseason );
		    if( $_GET["help"] ) echo( "for $q and ($tmpseason) : $qs \n<br>\n" );
		    $thiskey = $q;
		    if( $tmpseason )
			{
			    if( isQuarterInFuture( getFirstSeason( $tmpseason ), $q ) ) continue;
			}
		    if( $tmpseason ) $thiskey .= " (" . $seasonswithall[$tmpseason] . ")";

		    switch( $comparisonaspect )
			{
			// case "Primary Genres":
			// case "Primary Genre Breakdown":
			//     $labels = db_query_array( "select genres.id, count(*) as num from genres, songs where GenreID = genres.id and songs.id in ( $songidstr ) group by genres.id ", "id", "num" );
			//     foreach( $labels as $t=>$numforthis )
			// 	{
			// 	    // $t = $trow["id"];
			// 	    // $numforthis = db_query_first_cell( "select count(*) from songs where songs.id in ( $songidstr ) and  GenreID = '$t' " );
				    
			// 	    $number = $numforthis;
			// 	    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			//     if( !$numforthis )
			// 	$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			// 	    $retval[$thiskey][$t]["season"] = $tmpseason;
			// 	    $retval[$thiskey][$t][0] = $numforthis;
			// 	    $retval[$thiskey][$t][1] = $numforthis . "%";
			// 	    $retval[$thiskey][$t][2] = $t;
			// 	    $retval[$thiskey][$t][3] = "search-results?$qs&search[GenreID]=" . urlencode( $t ); 
			// 	    $retval[$thiskey][$t][4] = $number;
			// 	}
			//     break;
			case "Genres":
			    // removed 1/27/2022
			    // if( $genrefilter )
			    // 	{
			    // 	    $genrename = db_query_first_cell( "select Name from genres where id = $genrefilter" );
			    // 	    $ext = " and subgenres.Name <> '$genrename'";
			    // 	}
			    $sql = "select subgenreid, count(*) as num from song_to_subgenre, subgenres where type = 'Main' and subgenreid = subgenres.id and songid in ( $songidstr ) and HideFromAdvancedSearch = 0 $ext group by subgenreid ";
			    $subgenres = db_query_array( $sql, "subgenreid", "num" );
//			    if( $_GET["help3"] ) echo( "\ninfluence search: " . $sql . "\n<br>" );
			    
			    foreach( $subgenres as $t=>$numforthis )
				{
				    //                    $t = $trow["id"];
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_subgenre where songid in ( $songidstr ) and songid = songs.id and  song_to_subgenre.subgenreid = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[specificsubgenrealso]=" . urlencode( $t ); 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Influences":
			    if( $genrefilter )
				{
				    $genrename = db_query_first_cell( "select Name from genres where id = $genrefilter" );
				    $ext = " and influences.Name <> '$genrename'";
				}
			    $sql = "select influenceid, count(*) as num from song_to_influence, influences where type = 'Main' and influenceid = influences.id and songid in ( $songidstr ) and HideFromAdvancedSearch = 0 $ext group by influenceid ";
			    $influences = db_query_array( $sql, "influenceid", "num" );
//			    if( $_GET["help3"] ) echo( "\ninfluence search: " . $sql . "\n<br>" );
			    
			    foreach( $influences as $t=>$numforthis )
				{
				    //                    $t = $trow["id"];
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_influence where songid in ( $songidstr ) and songid = songs.id and  song_to_influence.influenceid = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[specificinfluencealso]=" . urlencode( $t ); 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "LyricalSubThemes":
			    $lyricalthemes = db_query_array( "select lyricalsubthemeid, count(*)  as num from song_to_lyricalsubtheme, lyricalsubthemes where lyricalsubthemeid = lyricalsubthemes.id and songid in ( $songidstr ) group by lyricalsubthemeid ", "lyricalsubthemeid", "num" );
			    foreach( $lyricalthemes as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_lyricaltheme where songid in ( $songidstr ) and songid = songs.id and  song_to_lyricaltheme.lyricalthemeid = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[lyricalsubthemes][" . urlencode( $t ) . "]=1"; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Lyrical Themes":
			    $lyricalthemes = db_query_array( "select lyricalthemeid, count(*)  as num from song_to_lyricaltheme, lyricalthemes where lyricalthemeid = lyricalthemes.id and songid in ( $songidstr )  and HideFromAdvancedSearch = 0  group by lyricalthemeid ", "lyricalthemeid", "num" );
			    foreach( $lyricalthemes as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_lyricaltheme where songid in ( $songidstr ) and songid = songs.id and  song_to_lyricaltheme.lyricalthemeid = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[lyricalthemes][" . urlencode( $t ) . "]=1"; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Lyrical Moods":
			case "LyricalMoods":
			    $lyricalmoods = db_query_array( "select lyricalmoodid, count(*)  as num from song_to_lyricalmood, lyricalmoods where lyricalmoodid = lyricalmoods.id and songid in ( $songidstr )   group by lyricalmoodid ", "lyricalmoodid", "num" );
			    foreach( $lyricalmoods as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_lyricalmood where songid in ( $songidstr ) and songid = songs.id and  song_to_lyricalmood.lyricalmoodid = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[lyricalmoods][" . urlencode( $t ) . "]=1"; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Song Title Word Count":
			    //                SongTitleWordCount
			    $stwc = db_query_array( "select SongTitleWordCount, count(*) as num from songs where id in ( $songidstr ) and SongTitleWordCount > 0 group by SongTitleWordCount order by SongTitleWordCount  ", "SongTitleWordCount", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SongTitleWordCount is not null " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SongTitleWordCount = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[SongTitleWordCount]=" . urlencode( $t ) . ":{$t}"; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Tempo Range":
			case "Tempo Range General":
			    //                TempoRange
			    $nospaces = str_replace( " ", "", $comparisonaspect );
		$zero = "0";
		if( $nospaces == "TempoRangeGeneral" )
		    $zero = "''";
		//		echo( "select $nospaces, count(*) as num from songs where id in ( $songidstr ) and TempoRange > $zero group by $nospaces order by $nospaces<br><br>" );
			    $stwc = db_query_array( "select $nospaces, count(*) as num from songs where id in ( $songidstr ) and $nospaces > $zero group by $nospaces order by $nospaces  ", "$nospaces", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $nospaces > $zero  " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and TempoRange = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[$comparisonaspect]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Song Title Appearances":
			    //songtitleappearancecount
			    $stwc = db_query_array( "select SongTitleAppearanceRange, count(*) as num from songs where id in ( $songidstr ) and SongTitleAppearanceRange is not null group by SongTitleAppearanceRange order by SongTitleAppearances  ", "SongTitleAppearanceRange", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SongTitleAppearanceRange is not null  " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SongTitleAppearanceRange = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[songtitleappearancecount]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Key":
			    $stwc = db_query_array( "select NameHard, count(*) as num from song_to_songkey where songid in ( $songidstr ) and NameHard > '' group by NameHard order by NameHard ", "NameHard", "num" );

			    // needs rachel
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and KeyMajor = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[KeyMajor]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Song Form":
			    $stwc = db_query_array( "select SongStructure, count(*) as num from songs where id in ( $songidstr ) and SongStructure > '' group by SongStructure order by SongStructure ", "SongStructure", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SongStructure > '' " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and KeyMajor = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[fullform]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "KeyMajorMinor":
			    $stwc = db_query_array( "select majorminor, count(*) as num from songs where id in ( $songidstr ) and majorminor > '' group by majorminor order by majorminor ", "majorminor", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and majorminor > '' " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and majorminor = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t . "(" . $numsongs . ")";
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[majorminor]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Key (Major, Minor, Major Mode, Minor Mode)":
			    $stwc = db_query_array( "select SpecificMajorMinor, count(*) as num from songs where id in ( $songidstr ) and SpecificMajorMinor > '' group by majorminor order by SpecificMajorMinor ", "SpecificMajorMinor", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SpecificMajorMinor > '' " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SpecificMajorMinor = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t . "(" . $numsongs . ")";
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[SpecificMajorMinor]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Prominent Instruments":
			    $primaryinstrumentations = db_query_array( "select primaryinstrumentations.id, count(*) as num from song_to_primaryinstrumentation, primaryinstrumentations where primaryinstrumentationid = primaryinstrumentations.id and songid in ( $songidstr ) and type = 'Main'  and HideFromAdvancedSearch = 0 group by primaryinstrumentations.id ", "id", "num" );
			    foreach( $primaryinstrumentations as $t=>$numforthis )
				{
				    //                    $t = $trow["id"];
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_primaryinstrumentation where songid in ( $songidstr ) and songid = songs.id and  song_to_primaryinstrumentation.primaryinstrumentationid = '$t' and type = 'Main' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[primaryinstrumentations][" . urlencode( $t ) . "]=1"; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Song Length Range":
			    $stwc = db_query_array( "select SongLengthRange, count(*) as num from songs where id in ( $songidstr ) and SongLengthRange is not null group by SongLengthRange order by SongLength ", "SongLengthRange", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SongLengthRange is not null" );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SongLengthRange = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[SongLengthRange]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "First Section":
			    $stwc = db_query_array( "select FirstSectionType, count(*) as num from songs where id in ( $songidstr ) and FirstSectionType is not null group by FirstSectionType order by SongLength ", "FirstSectionType", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and FirstSectionType is not null" );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and FirstSectionType = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[FirstSectionType]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Intro Length Range":
			    $stwc = db_query_array( "select IntroLengthRange, count(*) as num from songs where id in ( $songidstr ) and IntroLengthRange is not null group by IntroLengthRange order by SongLength ", "IntroLengthRange", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and IntroLengthRange is not null" );
			    $tmptot = 0;
			    foreach( $stwc as $s )
				$tmptot+= $s;
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and IntroLengthRange = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($tmptot?$tmptot:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($tmptot?$tmptot:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[introlengthrange]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Genre/Influence Count":
			    $stwc = db_query_array( "select InfluenceCount, count(*) as num from songs where id in ( $songidstr ) and InfluenceCount is not null group by InfluenceCount order by InfluenceCount ", "InfluenceCount", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and InfluenceCount is not null" );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and InfluenceCount = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[influencecount]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Use Of A Pre-Chorus":
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and PrechorusCount is not " );
			    foreach( array( 0, 1 ) as $t )
				{
			    if( $t )
				$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and PrechorusCount > 0 " );
			    else
				$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and PrechorusCount = 0  " );
				    
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[UseOfAPreChorus]=" . ($t?1:-1); 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Chorus Precedes Any Section":
			    
			    foreach( array( 0, 1 ) as $t )
				{
				    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and ChorusPrecedesVerse= $t " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[ChorusPrecedesVerse]=" . urlencode( $t?1:-1 ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "First Chorus: Time Into Song Range":
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and FirstChorusRange is not null " );
			    $stwc = db_query_array( "select case when FirstChorusRange is null then 'No Chorus' else FirstChorusRange end as FirstChorusRange, count(*) as num from songs where id in ( $songidstr ) group by FirstChorusRange order by SongLength ", "FirstChorusRange", "num" );
			    if( $_GET["help"] )
				echo( "select FirstChorusRange, count(*) as num from songs where id in ( $songidstr ) and FirstChorusRange is not null group by FirstChorusRange order by SongLength" );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and FirstChorusRange = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[FirstChorusRange]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "First Chorus: Percent Into Song Range":
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and FirstChorusPercentRange is  not null " );
			    $stwc = db_query_array( "select case when FirstChorusPercentRange is null then 'No Chorus' else FirstChorusPercentRange end as FirstChorusPercentRange, count(*) as num from songs where id in ( $songidstr ) group by FirstChorusPercentRange order by SongLength ", "FirstChorusPercentRange", "num" );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and FirstChorusPercentRange = '$t' " );
				    $displ = $t;
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$displ][0] = $numforthis;
				    $retval[$thiskey][$displ][1] = $numforthis . "%";
				    $retval[$thiskey][$displ][2] = $t;
				    $retval[$thiskey][$displ][3] = "search-results?$qs&search[FirstChorusPercentRange]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Use Of A Vocal Post-Chorus":
			    
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and VocalPostChorusCount is  not null " );
			    foreach( array( 0, 1 ) as $t )
				{
				    if( $t )
					$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and VocalPostChorusCount > 0 " );
				    else
					$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and VocalPostChorusCount = 0 " );
				    $number = $numforthis;
				    
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[UseOfAVocalPostChorus]=" . ($t?1:-1); 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Last Section":
			    $stwc = db_query_array( "select LastSectionType, count(*) as num from songs where id in ( $songidstr ) and LastSectionType is not null group by LastSectionType order by SongLength ", "LastSectionType", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and LastSectionType is  not null " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and LastSectionType = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[LastSectionType]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Outro Length Range":
			    $stwc = db_query_array( "select OutroRange, count(*) as num from songs where id in ( $songidstr ) and OutroRange is not null group by OutroRange order by SongLength ", "OutroRange", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and OutroRange is  not null " );
			    $tmptot = 0;
			    foreach( $stwc as $s )
				$tmptot+= $s;
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and OutroRange = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($tmptot?$tmptot:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($tmptot?$tmptot:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t=="None"?"No Outro":$t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[OutroRange]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			    
			case "Intro Instrumental Vocal or Instrumental":
			case "Outro Instrumental Vocal or Instrumental":
			    $field = "IntroVocalVsInst";
			$fieldshort = "Intro";
			if( strpos( $comparisonaspect, "Outro" ) !== false )
			    {
			    $field = "OutroVocalVsInst";
			    $fieldshort = "Outro";
			    }
	
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $field is  not null " );
			//echo( "select case when $field is null then 'No $fieldshort' else $field end as $field, count(*) as num from songs where id in ( $songidstr ) group by $field order by case when $field like '%&%' then 'zz' else $field end" ); //and $field is not null 
			$stwc = db_query_array( "select case when $field is null then 'No $fieldshort' else $field end as $field, count(*) as num from songs where id in ( $songidstr ) group by $field order by case when $field like '%&%' then 'zz' else $field end ", "$field", "num" ); //and $field is not null 
			    $tmptot = 0;
			    foreach( $stwc as $s )
				$tmptot+= $s;
			    foreach( $stwc as $t=>$numforthis )
				{
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($tmptot?$tmptot:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($tmptot?$tmptot:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[$field]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			    
			case "Section Allocation":
			    break;
			case "Major vs. Minor":
			    //			    echo( "select MajorMinor, count(*) as num from songs where id in ( $songidstr ) and MajorMinor > '' group by MajorMinor order by MajorMinor<br>" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and MajorMinor is  not null " );
			    $stwc = db_query_array( "select MajorMinor, count(*) as num from songs where id in ( $songidstr ) and MajorMinor > '' group by MajorMinor order by MajorMinor ", "MajorMinor", "num" );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and MajorMinor = '$t' " );
				    $number = $numforthis;
				    $displ = $t;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$displ][0] = $numforthis;
				    $retval[$thiskey][$displ][1] = $numforthis . "%";
				    $retval[$thiskey][$displ][2] = $t;
				    $retval[$thiskey][$displ][3] = "search-results?$qs&search[majorminor]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$displ][4] = $number;
				}
			    break;

			case "Chorus Count":
			case "Verse Count":
			    $fieldname = str_replace( " ", "", $comparisonaspect );
			$rows = db_query_array( "select  $fieldname, count(*) as num from songs where id in ( $songidstr ) group by $fieldname order by num ", "$fieldname", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $fieldname is  not null " );
			foreach( $rows as $t=>$numforthis )
			    {
				$number = $numforthis;
				
				$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				$retval[$thiskey][$t]["season"] = $tmpseason;
				$retval[$thiskey][$t][0] = $numforthis;
				$retval[$thiskey][$t][1] = $numforthis . "%";
				$retval[$thiskey][$t][2] = $t;
				$retval[$thiskey][$t][3] = "search-results?$qs&search[$fieldname]=" . urlencode( $t?$t:-1 ); 
				$retval[$thiskey][$t][4] = $number;
			    }
			break;
			    // begin trend report specific graphs!!!!!
			case "Number Of Songs Within The Top 10":
			case "Carryovers vs. New Songs":
			    $rows = array( "Total Songs in the Top 10", "New Songs", "Carryovers" );
			foreach( $rows as $t=>$val )
			    {
				if( $val == "Total Songs in the Top 10" )
				    $numforthis = $numsongs;
				else if( $val == "New Songs" )
				    {
					$numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and QuarterEnteredTheTop10 = '$q'" );
				    }
				else
				    {
					$numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and QuarterEnteredTheTop10 <> '$q'" );
				    }
				$number = $numforthis;
				
				//                    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
				$retval[$thiskey][$t]["season"] = $tmpseason;
				$retval[$thiskey][$t][0] = $numforthis;
				$retval[$thiskey][$t][1] = $numforthis;
				$retval[$thiskey][$t][2] = $t;
				$retval[$thiskey][$t][3] = "search-results?$qs&search[toptentype]=" . urlencode( $val ); 
				$retval[$thiskey][$t][4] = $number;
			    }
			break;
			case "Electronic Vs. Acoustic Songs":
			    $stwc = db_query_array( "select ElectricVsAcoustic from songs where id in ( $songidstr ) and ElectricVsAcoustic is not null order by ElectricVsAcoustic  ", "ElectricVsAcoustic", "ElectricVsAcoustic" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and ElectricVsAcoustic is  not null " );
			    foreach( $stwc as $t )
				{
				    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and ElectricVsAcoustic = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[ElectricVsAcoustic]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Average Intro Length":
			case "Average Outro Length":
			    
			    $short = str_replace( "Average ", "", $comparisonaspect );
			$short = str_replace( " Length", "", $short );
			$rows = array( "Average" );
			foreach( $rows as $t=>$val )
			    {
				$numforthis = db_query_first_cell( "select round( avg( time_to_sec( {$short}Length ) ) ) from songs where id in ( $songidstr ) " );
				
				$display = makeTimeSeconds( $numforthis );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				$retval[$thiskey][$t][0] = $numforthis;
				$retval[$thiskey][$t][1] = $display;
				$retval[$thiskey][$t][2] = $t;
				//                    $retval[$thiskey][$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
			    }
			break;
			case "Average Song Length":
			    $rows = array( "Average" );
			    foreach( $rows as $t=>$val )
				{
				    $numforthis = db_query_first_cell( "select round( avg( time_to_sec( SongLength ) ) ) from songs where id in ( $songidstr )" );
				    
				    $display = makeTime( $numforthis );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $display;
				    $retval[$thiskey][$t][2] = $t;
				    //                    $retval[$thiskey][$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
				}
			    break;
			case "Average Tempo":
			    $rows = array( "Average" );
			    foreach( $rows as $t=>$val )
				{
				    $numforthis = db_query_first_cell( "select round( avg( Tempo ) ) from songs where id in ( $songidstr )" );
				    
				    $display = $numforthis;
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $display;
				    $retval[$thiskey][$t][2] = $t;
				    //                    $retval[$thiskey][$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
				}
			    break;
			case "First Chorus: Average Time Into Song":
			    $rows = array( "Average" );
			    foreach( $rows as $t=>$val )
				{
				    $numforthis = db_query_first_cell( "select round( avg( time_to_sec( FirstChorusTimeIntoSong ) ) ) from songs where id in ( $songidstr ) and FirstChorusTimeIntoSong is not null" ); // chorus 1
				    
				    $display = makeTimeSeconds( $numforthis );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $display;
				    $retval[$thiskey][$t][2] = $t;
				    //                    $retval[$thiskey][$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
				}
			    break;
			case "First Chorus: Average Percent Into Song":
			    $rows = array( "Average" );
			    foreach( $rows as $t=>$val )
				{
				    $numforthis = db_query_first_cell( "select round( avg( time_to_sec( FirstChorusPercent ) ) ) from songs where id in ( $songidstr ) and FirstChorusTimeIntoSong is not null" ); // chorus 1
				    
				    $numforthis = number_format( $numforthis );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    //                    $retval[$thiskey][$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
				}
			    break;

		case "UseofParallelMode":
		case "SlangWords":
		case "CreativeWorksTitles":
		case "PersonReferences":
		case "GeneralLocationReferences":
		case "GeneralPersonReferences":
		case "LocationReferences":
		case "OrganizationorBrandReferences":
		case "ConsumerGoodsReferences":
		case "WordsRepetitionPrevalence":
		case "PercentProfanity":
		case "PercentAbbreviations":
		case "PercentNonDictionary":
				$numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect is not null " );
			    foreach( array( 0, 1 ) as $t )
				{
				    if( $t )
					$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect > 0 " );
				    else
					$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect = 0 " );
				    $number = $numforthis;
				    
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
				    if( !$numforthis )
					$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[$comparisonaspect]=" . ($t?1:-1); 
				    $retval[$thiskey][$t][4] = $number;
				}

		    break;
		case "OverallRepetitiveness":
		case "ConsonanceAlliterationScore":
		case "AssonanceAlliterationScore":
		case "PercentDiatonicChords":
		case "LineRepetitionPrevalence":
		case "ThousandWordsPrevalence":
		case "TenThousandWordsPrevalence":
		case "FiftyThousandWordsPrevalence":
		case "PercentNonProfanity":
		case "RhymeDensity":
		case "RhymesPerSyllable":
		case "RhymesPerLine":
		case "NumberOfRhymeGroupsELR":
		case "EndLinePerfectRhymesPercentage":
		case "EndLineSecondaryPerfectRhymesPercentage":
		case "EndLineAssonanceRhymePercentage":
		case "PerfectRhymesPercentage":
		case "AssonanceRhymePercentage":
		case "ConsonanceRhymePercentage":
		case "EndOfLineRhymesPercentage":
		case "MidLineRhymesPercentage":
		case "InternalRhymesPercentage":
		case "MidWordRhymes":
		case "WordsPerLineAvg":
		case "PreChorusSectionLyrics":
		case "MainMelodicRangeNum":
		case "ChordRepetition":
		case "UseOfTriads":
		case "UseOfInvertedChords":
		case "AverageWordRepetition":
		case "LyricalDensity":
		case "IntroLength":
		case "OutroLength":
		case "UseOf7thChords":
		case "UseOfMajor7thChords":
		case "EndLineConsonanceRhymePercentage":
		case "SecondaryPerfectRhymesPercentage":
		case "Danceability":
		case "FirstChorusTimeIntoSong":
		case "NumMelodicThemes":
		case "SectionCount":
		case "Loudness":

		    $rounder = 0;
		
		if( isRounder( $comparisonaspect ) ) $rounder = 2;

                $rows = array( "Average" );
                foreach( $rows as $t=>$val )
                {
		    $numforthisrow = db_query_first( "select round( avg( $comparisonaspect ), $rounder ) as value, count(*) as num from songs where id in ( $songidstr ) " ); // chorus 1
		    $numforthis = $numforthisrow["value"];
                    $number = $numforthisrow["num"];
		    $numforthis = number_format( $numforthis, $rounder );
                    $retval[$thiskey][$t][0] = $numforthis;
                    $retval[$thiskey][$t][1] = $numforthis . ($rounder?"":"%");
                    $retval[$thiskey][$t][2] = $t;
		    $retval[$thiskey][$t][4] = $number;

                }
                break;
		//enums
		case "MainMelodicRange":
		case "MelodicIntervalPrevalence":
		case "VocalsInstrumentsPrevalence":
		case "LiteralExperiencesvsAbstract":
		case "Timbre":
		case "ChordDegreePrevalence":
		case "ProductionMood":

			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect is not null  " );
		    $rows = getSetValues( $comparisonaspect );
		    $isenum = false;
		    if( !count( $rows ) ) 
			{
			    $isenum = true;
			    $rows = getEnumValues( $comparisonaspect );
			}
		    foreach( $rows as $t )
				{

				    if( $isenum )
					$numforthis = db_query_first_cell( "select count(*) as num from songs where id in ( $songidstr ) and $comparisonaspect = '$t'" );
				    else
					$numforthis = db_query_first_cell( "select count(*) as num from songs where id in ( $songidstr ) and $comparisonaspect like '%$t%'" );


				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and $comparisonaspect = '$t' " );
				    $number = $numforthis;
				    $displ = $t;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$t]["season"] = $tmpseason;
				    $retval[$thiskey][$displ][0] = $numforthis;
				    $retval[$thiskey][$displ][1] = $numforthis . "%";
				    $retval[$thiskey][$displ][2] = $t . " " . ($numforthis * 100 / ($numsongs?$numsongs:1));
				    $retval[$thiskey][$displ][3] = "search-results?$qs&search[$comparisonaspect]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$displ][4] = $number;
				}
			    //			    print_r( $retval["2013"] );
			    //			    exit;
			    break;

		case "SectionCountRange":
		case "PercentDiatonicChordsRange":
		case "ChordRepetitionRange":
		case "UseOfTriadsRange":
		case "UseOfInvertedChordsRange":
		case "UseOf7thChordsRange":
		case "UseOfMajor7thChordsRange":
		case "LineRepetitionPrevalenceRange":
		case "OverallRepetitivenessRange":
		case "AverageWordRepetitionRange":
		case "ConsonanceAlliterationScoreRange":
		case "AssonanceAlliterationScoreRange":
		case "RhymeDensityRange":
		case "RhymesPerSyllableRange":
		case "RhymesPerLineRange":
		case "NumberOfRhymeGroupsELRRange":
		case "EndLinePerfectRhymesPercentageRange":
		case "ThousandWordsPrevalenceRange":
		case "LocationReferencesRange":
		case "PersonReferencesRange":
		case "GeneralLocationReferencesRange":
		case "GeneralPersonReferencesRange":
		case "EndLineAssonanceRhymePercentageRange":
		case "PerfectRhymesPercentageRange":
		case "ConsonanceRhymePercentageRange":
		case "AssonanceRhymePercentageRange":
		case "EndOfLineRhymesPercentageRange":
		case "InternalRhymesPercentageRange":
		case "MidWordRhymesRange":
		case "MidLineRhymesPercentageRange":
		case "SlangWordsRange":
		case "LyricalDensityRange":
		case "DanceabilityRange":
		case "ProfanityRange":
		case "LoudnessRange":
		case "TotalAlliterationRange":
		case "TempoRangeGeneral":
		case "NumMelodicThemesRange":
		    $fieldname = $comparisonaspect;

		//		if( $comparisonaspect == "NumMelodicThemesRange" || $comparisonaspect == "SectionCountRange" || $comparisonaspect == "TempoRange" )
		    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect is not null " );
		    $stwc = db_query_array( "select $comparisonaspect, count(*) as num from songs where id in ( $songidstr ) and $comparisonaspect is not null group by $comparisonaspect order by $comparisonaspect ", "$comparisonaspect", "num" );
		    //		    echo( "select $comparisonaspect, count(*) as num from songs where id in ( $songidstr ) and $comparisonaspect is not null group by $comparisonaspect order by $comparisonaspect" );
		    $percent = "%";
		    //		    echo( "numsongS: $numsongs" );
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and $comparisonaspect = '$t' " );
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$thiskey][$t][0] = $numforthis;
			    $retval[$thiskey][$t][1] = $numforthis . $percent;
			    $retval[$thiskey][$t][2] = $t;
			    $retval[$thiskey][$t][3] = "search-results?$qs&search[$comparisonaspect]=" . urlencode( $t ) . ""; 
			    $retval[$thiskey][$t][4] = $number;
			}
		    break;





			default: 
			    echo( "no match ($comparisonaspect) ($sectionname)!!! getTrendDataForRows<br>" );
			    break;
			}
		    //	echo( $q . "<br>" );
		}
	    //   file_put_contents( "/tmp/hmm", "putting this in?: " . ( print_r( $retval, true ) ) . " \n" );
	    $cachedtrenddata[$key] = $retval;
	}
    return $retval;
}
    
function getBarTrendDataForRows( $comparisonaspect, $peak="", $songstouse = array() )
{
    global $newarrivalsonly, $cachedtrenddata, $searchsubtype, $allsongs, $dontincludeall, $search, $sectionname, $timeperiod, $genrefilter, $subgenrefilter, $keyislabel, $notdoingall, $withimprint, $possiblesearchfunctions;
    if( !$songstouse )
	$songstouse = $allsongs;
//echo( $comparisonaspect );    
    if( in_array( $possiblesearchfunctions, $comparisonaspect ) )
	{
	    $comparisonaspect = array_search( $possiblesearchfunctions, $comparisonaspect );
	}

    $key = $comparisonaspect . implode( ",", $songstouse ) . "_" . $peak . "_" . $dontincludeall . "_". $newarrivalsonly . "_" . $searchsubtype . "_" . $withimprint;
    // file_put_contents( "/tmp/hmm", "key is: $key \n", FILE_APPEND );
    // file_put_contents( "/tmp/hmm", "cache hit?: " . ( isset( $cachedtrenddata[$key] ) ) . " \n", FILE_APPEND );
    if( isset( $cachedtrenddata[$key] ) ) { 
	// i don't think we need this cache?
	//        file_put_contents( "/tmp/hmm", "cache values?: " . ( print_r( $cachedtrenddata[$key], true ) ) . " \n", FILE_APPEND );
	//	return $cachedtrenddata[$key];        
    }
    $retval = array();
    foreach( array( 1 ) as $ignoreme )
	{
	    $songs = $songstouse; 
	    $numsongs = count( $songs );
	    // we need to add this in case there were none
	    if( !$numsongs ) $numsongs = 1;
	    $songidstr = implode( ", ", $songs );
	    if( !$songidstr ) $songidstr = "-1";
	    $qs = calcTrendQSStartBar();
	    //	    echo( "mine?". $qs. "<br>\n" );
	    switch( $comparisonaspect )
		{
		case "Tempo Range":
		case "Tempo Range General":
		case "TempoRange":
		case "TempoRangeGeneral":
		    //                TempoRange
		    $nospaces = str_replace( " ", "", $comparisonaspect );
		$zero = "0";
		if( $nospaces == "TempoRangeGeneral" )
		    $zero = "''";
		    $stwc = db_query_array( "select $nospaces, count(*) as num from songs where id in ( $songidstr ) and $nospaces > $zero group by $nospaces order by $nospaces  ", "$nospaces", "num" );
		    //		    echo( "select $nospaces, count(*) as num from songs where id in ( $songidstr ) and $nospaces > 0 group by $nospaces order by $nospaces" );
		    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $nospaces > $zero  " );
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and TempoRange = '$t' " );
			    $number = $numforthis;
			    
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );

			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[$comparisonaspect]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;
			}
		    break;
			case "Genres":
			    // if( $genrefilter )
			    // 	{
			    // 	    $genrename = db_query_first_cell( "select Name from genres where id = $genrefilter" );
			    // 	    $ext = " and subgenres.Name <> '$genrename'";
			    // 	}
			    $sql = "select subgenreid, count(*) as num from song_to_subgenre, subgenres where type = 'Main' and subgenreid = subgenres.id and songid in ( $songidstr ) and HideFromAdvancedSearch = 0 $ext group by subgenreid ";
			    $subgenres = db_query_array( $sql, "subgenreid", "num" );
			    if( $_GET["help"] ) echo( "\ninfluence search: " . $sql . "\n<br>" );
			    
			    foreach( $subgenres as $t=>$numforthis )
				{
				    //                    $t = $trow["id"];
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_subgenre where songid in ( $songidstr ) and songid = songs.id and  song_to_subgenre.subgenreid = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$t]["season"] = $tmpseason;
				    $retval[$t][0] = $numforthis;
				    $retval[$t][1] = $numforthis . "%";
				    $retval[$t][2] = $t;
				    $retval[$t][3] = "search-results?$qs&search[specificsubgenrealso]=" . urlencode( $t ); 
				    $retval[$t][4] = $number;
				}
			    break;
			case "Influences":
			    if( $genrefilter )
				{
				    $genrename = db_query_first_cell( "select Name from genres where id = $genrefilter" );
				    $ext = " and influences.Name <> '$genrename'";
				}
			    $sql = "select influenceid, count(*) as num from song_to_influence, influences where type = 'Main' and influenceid = influences.id and songid in ( $songidstr ) and HideFromAdvancedSearch = 0 $ext group by influenceid ";
			    $influences = db_query_array( $sql, "influenceid", "num" );
			    if( $_GET["help"] ) echo( "\ninfluence search: " . $sql . "\n<br>" );
			    
			    foreach( $influences as $t=>$numforthis )
				{
				    //                    $t = $trow["id"];
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_influence where songid in ( $songidstr ) and songid = songs.id and  song_to_influence.influenceid = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$t]["season"] = $tmpseason;
				    $retval[$t][0] = $numforthis;
				    $retval[$t][1] = $numforthis . "%";
				    $retval[$t][2] = $t;
				    $retval[$t][3] = "search-results?$qs&search[specificinfluencealso]=" . urlencode( $t ); 
				    $retval[$t][4] = $number;
				}
			    break;
		// case "Primary Genre Breakdown":
		// case "Primary Genres":
		//     $labels = db_query_array( "select genres.id, count(*) as num from genres, songs where GenreID = genres.id and songs.id in ( $songidstr ) group by genres.id", "id", "num" );
		//     foreach( $labels as $t=>$numforthis )
		// 	{
		// 	    // $t = $trow["id"];
		// 	    // $numforthis = db_query_first_cell( "select count(*) from songs where songs.id in ( $songidstr ) and  GenreID = '$t' " );
		// 	    $number = $numforthis;
			    
		// 	    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
		// 	    if( !$numforthis )
		// 		$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
		// 	    $retval[$t][0] = $numforthis;
		// 	    $retval[$t][1] = $numforthis . "%";
		// 	    $retval[$t][2] = $t;
		// 	    $retval[$t][3] = "search-results?$qs&search[GenreID]=" . urlencode( $t ); 
		// 	    $retval[$t][4] = $number;
		// 	    if( $keyislabel )
		// 		{
		// 		    $retval[$t]["numsongs"] = db_query_first_cell( "select count(*) as num from songs where GenreID = '$t' and songs.id in ( $songidstr )" );
		// 		}
		// 	}
		//     break;
		case "Lyrical Themes":
		    $lyricalthemes = db_query_array( "select lyricalthemeid, count(*) as num from song_to_lyricaltheme, lyricalthemes where lyricalthemeid = lyricalthemes.id and songid in ( $songidstr )  and HideFromAdvancedSearch = 0  group by lyricalthemeid ", "lyricalthemeid", "num" );
		    foreach( $lyricalthemes as $t=>$numforthis )
			{
			    // $t = $trow["id"];
			    // $numforthis = db_query_first_cell( "select count(*) from songs, song_to_lyricaltheme where songid in ( $songidstr ) and songid = songs.id and  song_to_lyricaltheme.lyricalthemeid = '$t' " );
			    
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[lyricalthemes][" . urlencode( $t ) . "]=1"; 
			    $retval[$t][4] = $number;
			}
		    break;
		case "Lyrical Moods":
		    $lyricalmoods = db_query_array( "select lyricalmoodid, count(*) as num from song_to_lyricalmood, lyricalmoods where lyricalmoodid = lyricalmoods.id and songid in ( $songidstr )  and HideFromAdvancedSearch = 0  group by lyricalmoodid ", "lyricalmoodid", "num" );
		    foreach( $lyricalmoods as $t=>$numforthis )
			{
			    // $t = $trow["id"];
			    // $numforthis = db_query_first_cell( "select count(*) from songs, song_to_lyricalmood where songid in ( $songidstr ) and songid = songs.id and  song_to_lyricalmood.lyricalmoodid = '$t' " );
			    
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[lyricalmoods][" . urlencode( $t ) . "]=1"; 
			    $retval[$t][4] = $number;
			}
		    break;
		case "Song Title Word Count":
		    //                SongTitleWordCount
		    $stwc = db_query_array( "select SongTitleWordCount, count(*) as num from songs where id in ( $songidstr ) and SongTitleWordCount > 0 group by SongTitleWordCount order by SongTitleWordCount" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SongTitleWordCount > 0 " );
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SongTitleWordCount = '$t' " );
			    
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[SongTitleWordCount]=" . urlencode( $t ) . ":{$t}"; 
			    $retval[$t][4] = $number;
			}
		    break;
		case "Tempo Range":
		case "Tempo Range General":
		case "TempoRange":
		case "TempoRangeGeneral":
		    //                TempoRange
		    $nospaces = str_replace( " ", "", $comparisonaspect );
		$zero = "0";
		if( $nospaces == "TempoRangeGeneral" )
		    $zero = "''";

		    $stwc = db_query_array( "select $nospaces, count(*) as num from songs where id in ( $songidstr ) and $nospaces > $zero group by $nospaces order by $nospaces  ", "$nospaces", "num" );
		    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $nospaces > $zero  " );
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and TempoRange = '$t' " );
			    
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[$comparisonaspect]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;
			}
		    break;
		case "Song Title Appearances":
		    //songtitleappearancecount
		    $stwc = db_query_array( "select SongTitleAppearanceRange, count(*) as num from songs where id in ( $songidstr ) and SongTitleAppearanceRange is not null group by SongTitleAppearanceRange order by SongTitleAppearances  ", "SongTitleAppearanceRange", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SongTitleAppearanceRange > 0 " );
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SongTitleAppearanceRange = '$t' " );
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[songtitleappearancecount]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;
			}
		    break;
		case "Prominent Instruments":
		    $primaryinstrumentations = db_query_array( "select primaryinstrumentationid, count(*) as num from song_to_primaryinstrumentation, primaryinstrumentations where primaryinstrumentationid = primaryinstrumentations.id and songid in ( $songidstr ) and type = 'Main'  and HideFromAdvancedSearch = 0 group by primaryinstrumentationid  " );
		    foreach( $primaryinstrumentations as $t=>$numforthis )
			{
			    // $t = $trow["id"];
			    // $numforthis = db_query_first_cell( "select count(*) from songs, song_to_primaryinstrumentation where songid in ( $songidstr ) and songid = songs.id and  song_to_primaryinstrumentation.primaryinstrumentationid = '$t' and type = 'Main' " );
			    
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[primaryinstrumentations][" . urlencode( $t ) . "]=1"; 
			    $retval[$t][4] = $number;
			    $retval[$t]["name"] = getNameById( "primaryinstrumentations", $t );
			}
		    break;
		case "Key":
//echo( "select NameHard, count(*) as num from song_to_songkey where songid in ( $songidstr ) and NameHard > '' group by NameHard order by NameHard" );
		    $stwc = db_query_array( "select NameHard, count(*) as num from song_to_songkey where songid in ( $songidstr ) and NameHard > '' group by NameHard order by NameHard ", "NameHard", "num" );
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and KeyMajor = '$t' " );
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?{$qs}&search[KeyMajor]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;
			}

		    //		    echo( "hmmrace: ($qs)" );
		    //		    print_r( $retval );
		    
		    break;
		case "Song Form":
		    $stwc = db_query_array( "select SongStructure, count(*) as num from songs where id in ( $songidstr ) and SongStructure > '' group by SongStructure order by SongStructure ", "SongStructure", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SongStructure > '' " );
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and KeyMajor = '$t' " );
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t]["season"] = $tmpseason;
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[fullform]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;
			}
		    break;
		case "KeyMajorMinor":
		    $stwc = db_query_array( "select majorminor, count(*) as num from songs where id in ( $songidstr ) and majorminor > '' group by majorminor order by majorminor ", "majorminor", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and majorminor > '' " );
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and majorminor = '$t' " );
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[majorminor]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;
			}
		    
		    
		    
		    break;
		case "Key (Major, Minor, Major Mode, Minor Mode)":
		    $stwc = db_query_array( "select SpecificMajorMinor, count(*) as num from songs where id in ( $songidstr ) and SpecificMajorMinor > '' group by SpecificMajorMinor order by SpecificMajorMinor ", "SpecificMajorMinor", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SpecificMajorMinor > '' " );
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SpecificMajorMinor = '$t' " );
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[SpecificMajorMinor]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;
			}
		    
		    
		    
		    break;
		case "Song Length Range":
		    $stwc = db_query_array( "select SongLengthRange, count(*) as num from songs where id in ( $songidstr ) and SongLengthRange is not null group by SongLengthRange order by SongLength ", "SongLengthRange", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SongLengthRange is not null " );
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SongLengthRange = '$t' " );
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[SongLengthRange]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;
			}
		    break;
		case "First Section":
		    $stwc = db_query_array( "select FirstSectionType, count(*) as num from songs where id in ( $songidstr ) and FirstSectionType is not null group by FirstSectionType order by SongLength ", "FirstSectionType", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and FirstSectionType is not null " );
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and FirstSectionType = '$t' " );
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[FirstSectionType]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;
			}
		    break;
		case "Intro Length Range":
		    $stwc = db_query_array( "select IntroLengthRange, count(*) as num from songs where id in ( $songidstr ) and IntroLengthRange is not null group by IntroLengthRange order by SongLength ", "IntroLengthRange", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and IntroLengthRange is not null " );
		    $tmptot = 0;
		    foreach( $stwc as $s )
			$tmptot+= $s;
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and IntroLengthRange = '$t' " );
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($tmptot?$tmptot:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($tmptot?$tmptot:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[introlengthrange]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;
			}
		    break;
		case "Genre/Influence Count":
		    $stwc = db_query_array( "select InfluenceCount, count(*) as num from songs where id in ( $songidstr ) and InfluenceCount is not null group by InfluenceCount order by SongLength ", "InfluenceCount", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and InfluenceCount is not null " );
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and InfluenceCount = '$t' " );
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[influencecount]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;
			}
		    break;
		case "Use Of A Pre-Chorus":
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and PrechorusCount is not null " );
		    foreach( array( 0, 1 ) as $t )
			{
			    if( $t )
				$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and PrechorusCount > 0 " );
			    else
				$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and PrechorusCount = 0  " );
			    
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[UseOfAPreChorus]=" . ($t?1:-1); 
			    $retval[$t][4] = $number;
			}
		    break;
		case "Chorus Precedes Any Section":
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and ChorusPrecedesVerse is not null " );
		    
		    foreach( array( 0, 1 ) as $t )
			{
			    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and ChorusPrecedesVerse= $t " );
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[ChorusPrecedesVerse]=" . urlencode( $t?1:-1 ) . ""; 
			    $retval[$t][4] = $number;
			}
		    break;
		case "First Chorus: Time Into Song Range":
			    $stwc = db_query_array( "select case when FirstChorusRange is null then 'No Chorus' else FirstChorusRange end as FirstChorusRange, count(*) as num from songs where id in ( $songidstr ) group by FirstChorusRange order by SongLength ", "FirstChorusRange", "num" );
			    //		    $stwc = db_query_array( "select FirstChorusRange, count(*) as num from songs where id in ( $songidstr ) and FirstChorusRange is not null group by FirstChorusRange order by SongLength ", "FirstChorusRange", "num" );
			    if( $_GET["help"] )
				echo( "select FirstChorusRange, count(*) as num from songs where id in ( $songidstr ) and FirstChorusRange is not null group by FirstChorusRange order by SongLength<br>" );
		    $tmptot = 0;
		    foreach( $stwc as $s )
			$tmptot+= $s;
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and FirstChorusRange = '$t' " );
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($tmptot?$tmptot:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($tmptot?$tmptot:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "%";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[FirstChorusRange]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;
			}
		    break;
		case "First Chorus: Percent Into Song Range":
			    $stwc = db_query_array( "select FirstChorusPercentRange, count(*) as num from songs where id in ( $songidstr ) and FirstChorusPercentRange is not null group by FirstChorusPercentRange order by SongLength ", "FirstChorusPercentRange", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and FirstChorusPercentRange is not null " );
		    //		echo( "select FirstChorusPercentRange, count(*) as num from songs where id in ( $songidstr ) and FirstChorusPercentRange is not null group by FirstChorusPercentRange order by SongLength" );
		    $tmptot = 0;
		    foreach( $stwc as $s )
			$tmptot+= $s;
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and FirstChorusPercentRange = '$t' " );
			    $displ = $t;
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($tmptot?$tmptot:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($tmptot?$tmptot:1), 1 );
			    $retval[$displ][0] = $numforthis;
			    $retval[$displ][1] = $numforthis . "%";
			    $retval[$displ][2] = $t;
			    $retval[$displ][3] = "search-results?$qs&search[FirstChorusPercentRange]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;
			}
		    break;
		case "Use Of A Vocal Post-Chorus":
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and VocalPostChorusCount is not null " );
		    
		    foreach( array( 0, 1 ) as $t )
                {
                    if( $t )
                        $numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and VocalPostChorusCount > 0 " );
                    else
                        $numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and VocalPostChorusCount = 0 " );
                        
                    
                    $number = $numforthis;
                    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $numforthis . "%";
                    $retval[$t][2] = $t;
                    $retval[$t][3] = "search-results?$qs&search[UseOfAVocalPostChorus]=" . ($t?1:-1); 
                    $retval[$t][4] = $number;
                }
                break;
		case "Departure Section":

			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and UseOfABridge is not null " );
		    foreach( array( 0, 1 ) as $t )
		    {
			if( !$t ) 
			    $numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and UseOfABridge = 0  " );
			else
			    $numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and UseOfABridge = 1  " );
                        
			$number = $numforthis;
			$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			$retval[$t][0] = $numforthis;
			$retval[$t][1] = $numforthis . "%";
			$retval[$t][2] = $t;
			if( !$t )
			    $retval[$t][3] = "search-results?$qs&search[UseOfABridge]=-1";
			else if( $t == 1 )
			    $retval[$t][3] = "search-results?$qs&search[UseOfABridge]=1";
			$retval[$t][4] = $number;
			
		    }
		    break;
            case "Last Section":
                $stwc = db_query_array( "select LastSectionType, count(*) as num from songs where id in ( $songidstr ) and LastSectionType is not null group by LastSectionType order by SongLength ", "LastSectionType", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and LastSectionType is not null " );
                foreach( $stwc as $t=>$numforthis )
                {
//                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and LastSectionType = '$t' " );
                    $number = $numforthis;
                    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $numforthis . "%";
                    $retval[$t][2] = $t;
                    $retval[$t][3] = "search-results?$qs&search[LastSectionType]=" . urlencode( $t ) . ""; 
                    $retval[$t][4] = $number;
                }
                break;
            case "Outro Length Range":
                $stwc = db_query_array( "select OutroRange, count(*) as num from songs where id in ( $songidstr ) and OutroRange is not null group by OutroRange order by SongLength ", "OutroRange", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and OutroRange is not null " );
		$tmptot = 0;
		foreach( $stwc as $s )
		    $tmptot+= $s;
                foreach( $stwc as $t=>$numforthis )
                {
//                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and OutroRange = '$t' " );
                    $number = $numforthis;
                    $numforthis = number_format( $numforthis * 100 / ($tmptot?$tmptot:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($tmptot?$tmptot:1), 1 );
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $numforthis . "%";
                    $retval[$t][2] = $t=="None"?"No Outro":$t;
                    $retval[$t][3] = "search-results?$qs&search[OutroRange]=" . urlencode( $t ) . ""; 
                    $retval[$t][4] = $number;
                }
                break;

            case "Section Allocation":
                break;
		case "Intro Instrumental Vocal or Instrumental":
		case "Outro Instrumental Vocal or Instrumental":
		    $field = "IntroVocalVsInst";
		$fieldshort = "Intro";
		if( strpos( $comparisonaspect, "Outro" ) !== false )
		    {
		    $field = "OutroVocalVsInst";
		    $fieldshort = "Outro";
		    }
		
		$stwc = db_query_array( "select case when $field is null then 'No $fieldshort' else $field end as $field, count(*) as num from songs where id in ( $songidstr ) group by $field order by case when $field like '%&%' then 'zz' else $field end  ", "$field", "num" ); //and $field is not null 
		$tmptot = 0;
		foreach( $stwc as $s )
		    $tmptot+= $s;
		foreach( $stwc as $t=>$numforthis )
		    {
			$number = $numforthis;
			$numforthis = number_format( $numforthis * 100 / ($tmptot?$tmptot:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($tmptot?$tmptot:1), 1 );
			$retval[$t]["season"] = $tmpseason;
			$retval[$t][0] = $numforthis;
			$retval[$t][1] = $numforthis . "%";
			$retval[$t][2] = $t;
			$retval[$t][3] = "search-results?$qs&search[$field]=" . urlencode( $t ) . ""; 
			$retval[$t][4] = $number;
		    }
		break;
			    
            case "Major vs. Minor":
                $stwc = db_query_array( "select MajorMinor, count(*) as num from songs where id in ( $songidstr ) and MajorMinor > '' group by MajorMinor order by MajorMinor  ", "MajorMinor", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and MajorMinor is not null " );
		//echo( "aaaa:select MajorMinor, count(*) as num from songs where id in ( $songidstr ) and MajorMinor is not null group by MajorMinor order by MajorMinor" );
                foreach( $stwc as $t=>$numforthis )
                {
//                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and MajorMinor  = '$t' " );
                    $number = $numforthis;
                    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $numforthis . "%";
                    $retval[$t][2] = $t;
                    $retval[$t][3] = "search-results?$qs&search[majorminor]=" . urlencode( $t ) . ""; 
                    $retval[$t][4] = $number;
                }
                break;
            case "Ending Types":
                $endingtypes = db_query_array( "select endingtypeid, count(*) as num from song_to_endingtype, endingtypes where endingtypeid = endingtypes.id and songid in ( $songidstr ) group by endingtypeid  ", "endingtypeid", "num" );
                foreach( $endingtypes as $t=>$numforthis )
                {
//                    $t = $trow["id"];
//                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_endingtype where songid in ( $songidstr ) and songid = songs.id and  song_to_endingtype.endingtypeid = '$t' " );
                    
                    $number = $numforthis;
                    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $numforthis . "%";
                    $retval[$t][2] = $t;
                    $retval[$t][3] = "search-results?$qs&search[endingtypes][$t]=" . urlencode( $t ); 
                    $retval[$t][4] = $number;
                }
                break;
		    
		//     $rows = array();
		//     //		    echo( "select  songid, count(*) as num from song_to_songsection where PostChorus = 1 and songid in ( $songidstr ) group by songid<br>" );
		//     $tmprows = db_query_array( "select  id, VocalPostChorusCount as num from songs where VocalPostChorusCount > 0 and songid in ( $songstr ) group by songid", "id", "VocalPostChorusCount" );
		//     foreach( $tmprows as $t=>$num )
		// 	{
		// 		    if( !$rows[$num] ) $rows[$num] = 0;
		// 		    $rows[$num]++;
		// 	}
		    
		//     if( $numsongs > count( $tmprows ) )
		// 	$rows[0] = $numsongs - count( $tmprows );
		//     //		    print_r( $rows );
		//     foreach( $rows as $t=>$numforthis )
		// 	{
		// 	    $number = $numforthis;
			    
		// 	    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
		// 	    if( !$numforthis )
		// 		$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
		// 	    $retval[$t]["season"] = $tmpseason;
		// 	    $retval[$t][0] = $numforthis;
		// 	    $retval[$t][1] = $numforthis . "%";
		// 	    $retval[$t][2] = $t;
		// 	    $retval[$t][3] = "search-results?$qs&search[sectioncounts][PostChorus]=" . urlencode( $t?$t:-1 ); 
		// 	    $retval[$t][4] = $number;
		// 	}


		//     break;
		    
	    case "Vocal Post-Chorus Count":
            case "Pre-Chorus Count":
            case "Chorus Count":
            case "Verse Count":
		if( $comparisonaspect == "Pre-Chorus Count" )
		    $fieldname = "PrechorusCount";
		else $fieldname = str_replace( "- ", "", $comparisonaspect );
	    $fieldname = str_replace( " ", "", $comparisonaspect );
	    $fieldname = str_replace( "-", "", $fieldname );
	    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $fieldname is not null " );
            $rows = db_query_array( "select $fieldname, count(*) as num from songs where id in ( $songidstr ) group by $fieldname order by $fieldname", "$fieldname", "num" );
	    $totnum = 0;
                foreach( $rows as $t=>$numforthis )
                {
//                    $numforthis = db_query_first_cell( "select count(*) from SectionShorthand where songid in ( $songidstr ) and NumSections = '$t' and section = '$fieldname' " );
                    
                    $number = $numforthis;
		    $totnum += $number;
                    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $numforthis . "%";
                    $retval[$t][2] = $t;
                    $retval[$t][3] = "search-results?$qs&search[$fieldname]=" . urlencode( $t?$t:-1 ); 
                    $retval[$t][4] = $number;
                }

		//		print_r( $retval );
                break;
           // begin trend report specific graphs!!!!!
            case "Carryovers vs. New Songs":
            case "Number Of Songs Within The Top 10":
                 $q = $search["dates"]["fromq"] . "/" . $search["dates"]["fromy"];
            if( $comparisonaspect == "Carryovers vs. New Songs" ) 
                $rows = array( "New Songs", "Carryovers" );
            else
                $rows = array( "Total Songs in the Top 10", "New Songs", "Carryovers" );
                foreach( $rows as $t=>$val )
                {
                    if( $val == "Total Songs in the Top 10" )
                        $numforthis = $numsongs;
                    else if( $val == "New Songs" )
                    {
//                        echo( "select count(*) from songs where id in ( $songidstr ) and QuarterEnteredTheTop10 = '$q'" );
//                        echo( "select count(*) from songs where id in ( $songidstr ) and QuarterEnteredTheTop10 = '$q'<br>" );
                        $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and QuarterEnteredTheTop10 = '$q'" );
                    }
                    else
                    {
                        $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and QuarterEnteredTheTop10 <> '$q'" );
                    }

                    $number = $numforthis;
                   $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $numforthis . "%";
                    $retval[$t][2] = $val;
                    $retval[$t][3] = "search-results?$qs&search[toptentype]=" . urlencode( $val ); 
                    $retval[$t][4] = $number;
                }
                break;
            case "Electronic Vs. Acoustic Songs":
                $stwc = db_query_array( "select ElectricVsAcoustic, count(*) as num from songs where id in ( $songidstr ) and ElectricVsAcoustic is not null group by ElectricVsAcoustic order by ElectricVsAcoustic  ", "ElectricVsAcoustic", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and ElectricVsAcoustic is not null " );
                foreach( $stwc as $t=>$numforthis )
                {
//                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and ElectricVsAcoustic = '$t' " );
                    $number = $numforthis;
                    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $numforthis . "%";
                    $retval[$t][2] = $t;
                    $retval[$t][3] = "search-results?$qs&search[ElectricVsAcoustic]=" . urlencode( $t ) . ""; 
                    $retval[$t][4] = $number;
                }
                break;
            case "Average Intro Length":
            case "Average Outro Length":

                $short = str_replace( "Average ", "", $comparisonaspect );
                $short = str_replace( " Length", "", $short );
                $rows = array( "Average" );
                foreach( $rows as $t=>$val )
                {
                    $numforthis = db_query_first_cell( "select round( avg( time_to_sec( {$short}Length ) ) ) from songs where id in ( $songidstr ) and {$short}Length is not null" );

                    $display = makeTimeSeconds( $numforthis );
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $display;
                    $retval[$t][2] = $t;
//                    $retval[$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
                }
                break;
            case "Average Tempo":

                $rows = array( "Average" );
                foreach( $rows as $t=>$val )
                {
                    $numforthis = db_query_first_cell( "select round( avg( Tempo )) from songs where id in ( $songidstr )" );

                    $display = $numforthis;
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $display;
                    $retval[$t][2] = $t;
//                    $retval[$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
                }
                break;
            case "A-B-A-B-D-B Form":
                $rows = array( "A-B-A-B-D-B Form" );
                foreach( $rows as $t=>$val )
                {
                    $otherform = "A-B-A-B-C-B";
                    $value = "A-B-A-B-D-B";
                    $where = " AND ( AbbrevSongStructure = '" . escMe( $value ) . "' or BridgeSurrogateShortForm = '" . escMe( $value ) . "' or SongStructure = '" . escMe( $value ) . "' or AbbrevSongStructure = '" . escMe( $otherform ) . "' or BridgeSurrogateShortForm = '" . escMe( $otherform ) . "' or SongStructure = '" . escMe( $otherform ) . "' ) ";

                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) $where" );

                    $number = $numforthis;
                    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
                    $display = $numforthis . "%";
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $display;
                    $retval[$t][2] = $t;
                    $retval[$t][3] = "search-results?$qs&search[fullform]=" . urlencode( "A-B-A-B-D-B" ); 
                    $retval[$t][4] = $number;
                }
                break;
                
            case "Average Song Length":
                $rows = array( "Average" );
                foreach( $rows as $t=>$val )
                {
                    $numforthis = db_query_first_cell( "select round( avg( time_to_sec( SongLength ) ) ) from songs where id in ( $songidstr )" );

                    $display = makeTime( $numforthis );
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $display;
                    $retval[$t][2] = $t;
//                    $retval[$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
//                    $retval[$t][4] = $number;
                }
                break;
        case "First Chorus: Average Time Into Song":
                $rows = array( "Average" );
                foreach( $rows as $t=>$val )
                {
		    $numforthis = db_query_first_cell( "select round( avg( time_to_sec( FirstChorusTimeIntoSong ) ))from songs where id in ( $songidstr ) " ); // chorus 1

                    $display = makeTimeSeconds( $numforthis );
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $display;
                    $retval[$t][2] = $t;
//                    $retval[$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
//                    $retval[$t][4] = $number;
                }
                break;
        case "First Chorus: Average Percent Into Song":
                $rows = array( "Average" );
                foreach( $rows as $t=>$val )
                {
		    $numforthis = db_query_first_cell( "select round( avg( time_to_sec( FirstChorusPercent ) ) ) from songs where id in ( $songidstr ) " ); // chorus 1

                    $number = $numforthis;
                   $numforthis = number_format( $numforthis );
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $numforthis . "%";
                    $retval[$t][2] = $t;
//                    $retval[$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
//                    $retval[$t][4] = $number;
                }
                break;
		case "UseofParallelMode":
		case "PersonReferences":
		case "LocationReferences":
		case "GeneralPersonReferences":
		case "GeneralLocationReferences":
		case "CreativeWorksTitles":
		case "OrganizationorBrandReferences":
		case "ConsumerGoodsReferences":
		case "SlangWords":
		case "WordsRepetitionPrevalence":
		case "PercentProfanity":
		case "PercentAbbreviations":
		case "PercentNonDictionary":
				$numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect is not null " );
			    foreach( array( 0, 1 ) as $t )
				{
				    if( $t )
					$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect > 0 " );
				    else
					$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect = 0 " );
				    $number = $numforthis;
				    
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
				    if( !$numforthis )
					$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$t]["season"] = $tmpseason;
				    $retval[$t][0] = $numforthis;
				    $retval[$t][1] = $numforthis . "%";
				    $retval[$t][2] = $t;
				    $retval[$t][3] = "search-results?$qs&search[$comparisonaspect]=" . ($t?1:-1); 
				    $retval[$t][4] = $number;
				}

		    break;

		case "OverallRepetitiveness":
		case "ConsonanceAlliterationScore":
		case "AssonanceAlliterationScore":
		case "PercentDiatonicChords":
		case "LineRepetitionPrevalence":
		case "ThousandWordsPrevalence":
		case "TenThousandWordsPrevalence":
		case "FiftyThousandWordsPrevalence":
		case "PercentNonDictionary":
		case "PercentNonProfanity":
		case "RhymeDensity":
		case "RhymesPerSyllable":
		case "RhymesPerLine":
		case "NumberOfRhymeGroupsELR":
		case "EndLinePerfectRhymesPercentage":
		case "EndLineSecondaryPerfectRhymesPercentage":
		case "EndLineAssonanceRhymePercentage":
		case "PerfectRhymesPercentage":
		case "AssonanceRhymePercentage":
		case "ConsonanceRhymePercentage":
		case "EndOfLineRhymesPercentage":
		case "MidLineRhymesPercentage":
		case "InternalRhymesPercentage":
		case "MidWordRhymes":
		case "WordsPerLineAvg":
		case "PreChorusSectionLyrics":
		case "MainMelodicRangeNum":
		case "ChordRepetition":
		case "UseOfTriads":
		case "UseOfInvertedChords":
		case "AverageWordRepetition":
		case "LyricalDensity":
		case "IntroLength":
		case "OutroLength":
		case "UseOf7thChords":
		case "UseOfMajor7thChords":
		case "EndLineConsonanceRhymePercentage":
		case "SecondaryPerfectRhymesPercentage":
		case "Danceability":
		case "FirstChorusTimeIntoSong":
		case "NumMelodicThemes":
		case "Loudness":
		case "SectionCount":

		    $rounder = 0;
		    if( isRounder( $comparisonaspect ) )
			{
			    $rounder = 2;
			}
                $rows = array( "Average" );
                foreach( $rows as $t=>$val )
                {
		    $numforthis = db_query_first_cell( "select round( avg( $comparisonaspect ), $rounder ) from songs where id in ( $songidstr ) " ); // chorus 1

                    $number = $numforthis;
		    $numforthis = number_format( $numforthis, $rounder );
                    $retval[$t][0] = $numforthis;
                    $retval[$t][1] = $numforthis . ($rounder?"":"%");
                    $retval[$t][2] = $t;

                }
                break;
		case "LyricalSubThemes": 
		case "LyricalMoods": 
		    $shorttablename = substr(strtolower( $comparisonaspect ), 0, -1);

		$vals = db_query_array( "select {$shorttablename}s.id, count(*) as num from song_to_{$shorttablename}, {$shorttablename}s where {$shorttablename}id = {$shorttablename}s.id and songid in ( $songidstr ) group by {$shorttablename}s.id ", "id", "num" );
		foreach( $vals as $t=>$numforthis )
		    {
			$number = $numforthis;
			
			$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			if( !$numforthis )
			    $numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			$retval[$t]["season"] = $tmpseason;
			$retval[$t][0] = $numforthis;
			$retval[$t][1] = $numforthis . "%";
			$retval[$t][2] = $t;
			$retval[$t][3] = "search-results?$qs&search[{$shorttablename}s][" . urlencode( $t ) . "]=1"; 
			$retval[$t][4] = $number;
		    }
		break;

		case "ChordDegreePrevalence":
		case "ProductionMood":

		case "MainMelodicRange":
		case "MelodicIntervalPrevalence":
		case "Timbre":
		case "LiteralExperiencesvsAbstract":
		case "VocalsInstrumentsPrevalence":

		    $rows = getSetValues( $comparisonaspect );
		$isenum = false;
		    if( !count( $rows ) ) 
			{
			    $isenum = true;
			    $rows = getEnumValues( $comparisonaspect );
			}

			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect is not null  " );
		    foreach( $rows as $t )
				{
				    if( $isenum ) 
					$numforthis = db_query_first_cell( "select count(*) as num from songs where id in ( $songidstr ) and $comparisonaspect = '$t'" );
				    else
					$numforthis = db_query_first_cell( "select count(*) as num from songs where id in ( $songidstr ) and $comparisonaspect like '%$t%'" );
				    //				    echo( "select count(*) as num from songs where id in ( $songidstr ) and $comparisonaspect like '$t'<Br>" );

				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and $comparisonaspect = '$t' " );
				    $number = $numforthis;
				    $displ = $t;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$t]["season"] = $tmpseason;
				    $retval[$displ][0] = $numforthis;
				    $retval[$displ][1] = $numforthis . "%";
				    $retval[$displ][2] = $t . " " . ($numforthis * 100 / ($numsongs?$numsongs:1));
				    $retval[$displ][3] = "search-results?$qs&search[$comparisonaspect]=" . urlencode( $t ) . ""; 
				    $retval[$displ][4] = $number;
				}
			    //			    print_r( $retval["2013"] );
			    //			    exit;
			    break;


		case "SectionCountRange":
		case "PercentDiatonicChordsRange":
		case "ChordRepetitionRange":
		case "UseOfTriadsRange":
		case "UseOfInvertedChordsRange":
		case "UseOf7thChordsRange":
		case "UseOfMajor7thChordsRange":
		case "LineRepetitionPrevalenceRange":
		case "OverallRepetitivenessRange":
		case "AverageWordRepetitionRange":
		case "ConsonanceAlliterationScoreRange":
		case "AssonanceAlliterationScoreRange":
		case "RhymeDensityRange":
		case "RhymesPerSyllableRange":
		case "RhymesPerLineRange":
		case "NumberOfRhymeGroupsELRRange":
		case "EndLinePerfectRhymesPercentageRange":
		case "LocationReferencesRange":
		case "GeneralLocationReferencesRange":
		case "GeneralPersonReferencesRange":
		case "PersonReferencesRange":
		case "ThousandWordsPrevalenceRange":
		case "EndLineAssonanceRhymePercentageRange":
		case "PerfectRhymesPercentageRange":
		case "ConsonanceRhymePercentageRange":
		case "AssonanceRhymePercentageRange":
		case "EndOfLineRhymesPercentageRange":
		case "InternalRhymesPercentageRange":
		case "MidWordRhymesRange":
		case "SlangWordsRange":
		case "MidLineRhymesPercentageRange":
		case "LyricalDensityRange":
		case "DanceabilityRange":
		case "ProfanityRange":
		case "LoudnessRange":
		case "TotalAlliterationRange":
		case "TempoRangeGeneral":
		case "NumMelodicThemesRange":
		    $fieldname = $comparisonaspect;

		//		;		
		if( $comparisonaspect == "NumMelodicThemesRange"  || $comparisonaspect == "SectionCountRange"  || $comparisonaspect == "TempoRange")
		    $stwc = db_query_array( "select $fieldname, count(*) as num from songs where id in ( $songidstr ) and $fieldname > '' group by $fieldname order by SongLength ", "$fieldname", "num" );
		else $stwc = db_query_array( "select $fieldname, count(*) as num from songs where id in ( $songidstr ) and $fieldname is not null group by $fieldname order by SongLength ", "$fieldname", "num" );
		$numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect is not null " );

		    $percent = "%";
		    foreach( $stwc as $t=>$numforthis )
			{
			    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and $fieldname = '$t' " );
			    $number = $numforthis;
			    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			    $retval[$t][0] = $numforthis;
			    $retval[$t][1] = $numforthis . "$percent";
			    $retval[$t][2] = $t;
			    $retval[$t][3] = "search-results?$qs&search[$fieldname]=" . urlencode( $t ) . ""; 
			    $retval[$t][4] = $number;

			}
		    break;

            default:
            echo( "no match ($field) {$sectionname}!!! getBarTrendDataForRows<br>" );
            break;
        }
    }
    $cachedtrenddata[$key] = $retval;
    return $retval;
}



function getRowsComparison( $search, $songs )
{
    global $firstchoruspercentsdisplay, $introlengthsotherway, $firstchorustimedisplay, $searchsubtype, $graphname, $shownos, $dontincludeall, $sectionname, $genrefilter, $withimprint;
    $rows = array();
    $field = $search["comparisonaspect"];

    $songs[] = -1;
    $songstr = implode( ", ", $songs );
    //            echo( "field: " . $field . "<br>");
    switch( $field )
    {
    // case "Primary Genre Breakdown":
    //     case "Primary Genres":
    //         $rows = db_query_array( "select distinct( genres.id ), Name from songs, genres where songs.id in ( $songstr ) and GenreID = genres.id order by Name ", "id", "Name" );
    //         break;
        case "Number of Songs (Form)":
            $rows = db_query_array( "select SongStructure, count(*) as cnt from songs where id in ( $songstr ) group by SongStructure order by cnt desc ", "SongStructure", "SongStructure" );
            break;
        case "Tempo Range General":
        case "Tempo Range":
        case "TempoRangeGeneral":
        case "TempoRange":
	    $fstr = str_replace( " ", "", $field );
            $rows = db_query_array( "select $fstr from songs where id in ( $songstr ) and $fstr is not null order by Tempo  ", "$fstr", "$fstr" );
            break;
        case "Genres":
		// if( $genrefilter )
		//     {
		// 	$genrename = db_query_first_cell( "select Name from genres where id = $genrefilter" );
		// 	$ext = " and subgenres.Name <> '$genrename'";
		//     }
		//				if( $_GET["help"] ) $ext .= " and subgenres.Name like '%Funk' ";
		if( $_GET["help"] ) echo ( "list: select distinct( subgenres.id ), Name from song_to_subgenre, subgenres where  type = 'Main' and songid in ( $songstr ) and subgenreid = subgenres.id and type = 'Main' and HideFromAdvancedSearch = 0 $ext order by Name<br>\n" );
            $rows = db_query_array( "select distinct( subgenres.id ), Name from song_to_subgenre, subgenres where  type = 'Main' and songid in ( $songstr ) and subgenreid = subgenres.id and type = 'Main' and HideFromAdvancedSearch = 0 $ext order by Name", "id", "Name" );

            break;
        case "Influences":
		if( $genrefilter )
		    {
			$genrename = db_query_first_cell( "select Name from genres where id = $genrefilter" );
			$ext = " and influences.Name <> '$genrename'";
		    }
		//				if( $_GET["help"] ) $ext .= " and influences.Name like '%Funk' ";
		if( $_GET["help"] ) echo ( "list: select distinct( influences.id ), Name from song_to_influence, influences where  type = 'Main' and songid in ( $songstr ) and influenceid = influences.id and type = 'Main' and HideFromAdvancedSearch = 0 $ext order by Name<br>\n" );
            $rows = db_query_array( "select distinct( influences.id ), Name from song_to_influence, influences where  type = 'Main' and songid in ( $songstr ) and influenceid = influences.id and type = 'Main' and HideFromAdvancedSearch = 0 $ext order by Name", "id", "Name" );

            break;
        case "Lyrical Themes":
            $rows = db_query_array( "select distinct( lyricalthemes.id ), Name from song_to_lyricaltheme, lyricalthemes where songid in ( $songstr ) and lyricalthemeid = lyricalthemes.id  and HideFromAdvancedSearch = 0 order by Name ", "id", "Name" );
            break;
        case "Lyrical Moods":
            $rows = db_query_array( "select distinct( lyricalmoods.id ), Name from song_to_lyricalmood, lyricalmoods where songid in ( $songstr ) and lyricalmoodid = lyricalmoods.id  and HideFromAdvancedSearch = 0 order by Name ", "id", "Name" );
            break;
        case "Lyrical Sub Themes":
            $rows = db_query_array( "select distinct( lyricalsubthemes.id ), Name from song_to_lyricalsubtheme, lyricalsubthemes where songid in ( $songstr ) and lyricalsubthemeid = lyricalsubthemes.id  order by Name ", "id", "Name" );
            break;
        case "Song Title Word Count":
            $rows = db_query_array( "select SongTitleWordCount from songs where id in ( $songstr ) and SongTitleWordCount > 0 order by SongTitleWordCount  ", "SongTitleWordCount", "SongTitleWordCount" );
            break;
        case "Key":
            $rows = db_query_array( "select NameHard from song_to_songkey where songid in ( $songstr ) and NameHard > '' order by NameHard", "NameHard", "NameHard" );
            break;
        case "KeyMajorMinor":
            $rows = db_query_array( "select majorminor from songs where songs.id in ( $songstr ) and majorminor > '' order by majorminor", "majorminor", "majorminor" );
            break;
        case "Key (Major, Minor, Major Mode, Minor Mode)":
            $rows = db_query_array( "select SpecificMajorMinor from songs where songs.id in ( $songstr ) and SpecificMajorMinor > '' order by SpecificMajorMinor", "SpecificMajorMinor", "SpecificMajorMinor" );
            break;
    case "Song Form":
	//	echo( "select SongStructure, count(*) as num from songs where id in ( $songstr ) and SongStructure > '' group by SongStructure order by SongStructure" );
	$rows = db_query_array( "select SongStructure, count(*) as num from songs where id in ( $songstr ) and SongStructure > '' group by SongStructure order by SongStructure ", "SongStructure", "SongStructure" );
	break;
    case "Song Title Appearances":
            $rows = db_query_array( "select SongTitleAppearanceRange from songs where id in ( $songstr ) and SongTitleAppearanceRange is not null order by SongTitleAppearances  ", "SongTitleAppearanceRange", "SongTitleAppearanceRange" );
            break;
        case "Prominent Instruments":
            $rows = db_query_array( "select distinct( primaryinstrumentations.id ), Name from song_to_primaryinstrumentation, primaryinstrumentations where songid in ( $songstr ) and primaryinstrumentationid = primaryinstrumentations.id and type = 'Main'  and HideFromAdvancedSearch = 0 order by Name", "id", "Name" );
            break;
        case "Song Length Range":
            $rows = db_query_array( "select SongLengthRange from songs where id in ( $songstr ) and SongLengthRange is not null order by SongLength  ", "SongLengthRange", "SongLengthRange" );
            break;
        case "First Section":
            $rows = db_query_array( "select FirstSectionType from songs where id in ( $songstr ) and FirstSectionType is not null order by FirstSectionType  ", "FirstSectionType", "FirstSectionType" );
            break;
        case "Intro Length Range":
//            print_r($introlengths);
            $rows = db_query_array( "select  distinct( IntroLengthRange ) from songs where  id in ( $songstr ) and IntroLengthRange > '' order by case when IntroLengthRange ='None' then '0:00' else IntroLengthRangeNums end", "IntroLengthRange", "IntroLengthRange" );
            foreach( $rows as $rid=>$rval )
            {
                $rows[$rid] = $introlengthsotherway[$rval]?$introlengthsotherway[$rval]:$rval;
            }
            break;
        case "Genre/Influence Count":
            $rows = db_query_array( "select InfluenceCount from songs where  id in ( $songstr ) order by InfluenceCount", "InfluenceCount", "InfluenceCount" );
            break;
        case "Use Of A Vocal Post-Chorus":
            $rows = array( 1=>"Yes", 0=> "No" );
            break;
        case "Use Of A Pre-Chorus":
            $rows = array( 1=>"Yes", 0=> "No" );
            break;
        case "Chorus Precedes Any Section":
            $rows = array( 1=>"Chorus precedes Any Section", 0=> "Chorus does not precede Any Section" );
            break;
        case "First Chorus: Time Into Song Range":
            $rows = db_query_array( "select case when FirstChorusRange is null then 'No Chorus' else FirstChorusRange end as FirstChorusRange from songs where id in ( $songstr ) order by case when FirstChorusRange = 'Kickoff' then '0:00' else FirstChorusRange end  ", "FirstChorusRange", "FirstChorusRange" );
            foreach( $rows as $rid=>$rval )
            {
                $rows[$rid] = $firstchorustimedisplay[$rval]?$firstchorustimedisplay[$rval]:$rval;
            }
            break;
        case "First Chorus: Percent Into Song Range":
            $rows = db_query_array( "select case when FirstChorusPercentRange is null then 'No Chorus' else FirstChorusPercentRange end as FirstChorusPercentRange from songs where id in ( $songstr ) order by FirstChorusPercent  ", "FirstChorusPercentRange", "FirstChorusPercentRange" );

            foreach( $rows as $rid=>$rval )
            {
                $rows[$rid] = $firstchoruspercentsdisplay[$rval]?$firstchoruspercentsdisplay[$rval]:$rval;
            }
            break;
    case "Departure Section":
            $rows = array( 1=>"Yes", 0=> "No" );
            break;
        case "Last Section":
            $rows = db_query_array( "select LastSectionType from songs where id in ( $songstr ) and LastSectionType is not null order by LastSectionType  ", "LastSectionType", "LastSectionType" );
            foreach( $rows as $rid=>$rval )
            {
                $rows[$rid] = str_replace( "Inst", "Instrumental", $rval );
            }
            break;
        case "Outro Length Range":
            $rows = db_query_array( "select OutroRange from songs where id in ( $songstr ) and OutroRange > '' order by case when OutroRange ='None' then '0:00' else OutroLengthRangeNums end  ", "OutroRange", "OutroRange" );
            foreach( $rows as $rid=>$rval )
            {
                $val = $introlengthsotherway[$rval]?$introlengthsotherway[$rval]:$rval;
                if( $val == "None" ) $val = "No Outro";
                $rows[$rid] = $val;
            }
            break;

        case "Intro Instrumental Vocal or Instrumental":
            $rows = db_query_array( "select case when IntroVocalVsInst is null then 'No Intro' else IntroVocalVsInst end as IntroVocalVsInst  from songs where id in ( $songstr )  order by case when IntroVocalVsInst like '%&%' then 'zz' else IntroVocalVsInst end ", "IntroVocalVsInst", "IntroVocalVsInst" );
            break;
        case "Outro Instrumental Vocal or Instrumental":
            $rows = db_query_array( "select case when OutroVocalVsInst is null then 'No Outro' else OutroVocalVsInst end as OutroVocalVsInst from songs where id in ( $songstr ) order by case when OutroVocalVsInst like '%&%' then 'zz' else OutroVocalVsInst end ", "OutroVocalVsInst", "OutroVocalVsInst" );
            break;
        case "Major vs. Minor":
            $rows = db_query_array( "select MajorMinor from songs where id in ( $songstr ) and MajorMinor > '' order by MajorMinor  ", "MajorMinor", "MajorMinor" );
            break;
        case "Verse Count":
            $rows = db_query_array( "select VerseCount from songs where id in ( $songstr ) order by VerseCount", "VerseCount", "VerseCount" );
            break;
        case "Pre-Chorus Count":
            $rows = db_query_array( "select PrechorusCount from songs where id in ( $songstr ) order by PrechorusCount", "PrechorusCount", "PrechorusCount" );
            break;
        case "Chorus Count":
            $rows = db_query_array( "select ChorusCount from songs where id in ( $songstr ) order by ChorusCount", "ChorusCount", "ChorusCount" );
            break;
        case "Vocal Post-Chorus Count":
            $rows = db_query_array( "select VocalPostChorusCount from songs where id in ( $songstr ) order by VocalPostChorusCount", "VocalPostChorusCount", "VocalPostChorusCount" );
            break;
// begin trend report specific graphs!!!!!
            case "Carryovers vs. New Songs":
            $rows = array( "New Songs", "Carryovers" );
            break;

        case "Number Of Songs Within The Top 10":
            $rows = array( "Total Songs in the Top 10", "New Songs", "Carryovers" );
            break;
        case "Electronic Vs. Acoustic Songs":
            $rows = db_query_array( "select ElectricVsAcoustic from songs where id in ( $songstr ) and ElectricVsAcoustic is not null order by ElectricVsAcoustic  ", "ElectricVsAcoustic", "ElectricVsAcoustic" );
            break;
        case "A-B-A-B-D-B Form":
            $rows = array( "A-B-A-B-D-B Form" );
            break;
        case "Average Song Length":
        case "Average Tempo":
        case "Average Outro Length":
        case "First Chorus: Average Time Into Song":
        case "First Chorus: Average Percent Into Song":
        case "Average Intro Length":
            $rows = array( "Average" );
            break;
		case "UseofParallelMode":
		case "CreativeWorksTitles":
		case "SlangWords":
		case "PersonReferences":
		case "LocationReferences":
		case "GeneralPersonReferences":
		case "GeneralLocationReferences":
		case "OrganizationorBrandReferences":
		case "ConsumerGoodsReferences":
		case "PercentAbbreviations":
		case "WordsRepetitionPrevalence":
		case "PercentProfanity":
		case "PercentNonDictionary":
		    $rows = array( 1=>"Yes", 0=> "No" );
		    break;
		case "LyricalSubThemes": 
		case "LyricalMoods": 
		    
		    $shorttablename = substr(strtolower( $field ), 0, -1);
		    
		    $rows = db_query_array( "select distinct( {$shorttablename}s.id ), Name from song_to_{$shorttablename}, {$shorttablename}s where songid in ( $songstr ) and {$shorttablename}id = {$shorttablename}s.id order by Name", "id", "Name" );
		    
		    break;

		case "OverallRepetitiveness":
		case "ConsonanceAlliterationScore":
		case "AssonanceAlliterationScore":
		case "Loudness":
		case "PercentDiatonicChords":
		case "LineRepetitionPrevalence":
		case "ThousandWordsPrevalence":
		case "TenThousandWordsPrevalence":
		case "FiftyThousandWordsPrevalence":
		case "PercentNonProfanity":
		case "RhymeDensity":
		case "RhymesPerSyllable":
		case "RhymesPerLine":
		case "NumberOfRhymeGroupsELR":
		case "VocalPostChorusCount":
		case "EndLinePerfectRhymesPercentage":
		case "EndLineSecondaryPerfectRhymesPercentage":
		case "EndLineAssonanceRhymePercentage":
		case "PerfectRhymesPercentage":
		case "AssonanceRhymePercentage":
		case "ConsonanceRhymePercentage":
		case "EndOfLineRhymesPercentage":
		case "MidLineRhymesPercentage":
		case "InternalRhymesPercentage":
		case "MidWordRhymes":
		case "WordsPerLineAvg":
		case "PreChorusSectionLyrics":
		case "SectionCount":
		case "MainMelodicRangeNum":
		case "ChordRepetition":
		case "AverageWordRepetition":
		case "LyricalDensity":
		case "UseOf7thChords":
		case "UseOfMajor7thChords":
		case "EndLineConsonanceRhymePercentage":
		case "SecondaryPerfectRhymesPercentage":
		case "Danceability":
		case "FirstChorusTimeIntoSong":
		    $rows = array( "Average" );
		    

		    break;
		case "ChordDegreePrevalence":
		case "MelodicIntervalPrevalence":
		case "VocalsInstrumentsPrevalence":
		case "MainMelodicRange":
		case "LiteralExperiencesvsAbstract":
		case "Timbre":
		case "ProductionMood":
		    $rows = getSetValues( $field );
		//		print_r( $rows );
		if( !count( $rows ) ) {
		    $rows = getEnumValues( $field );
		}
		else
		    {
			foreach( $rows as $rid=>$r )
			    {
				$any = db_query_first_cell( "select count(*) from songs where id in ( $songstr ) and find_in_set( '$r' ,$field ) > 0" );
				//				echo( "select count(*) from songs where id in ( $songstr ) and find_in_set( '$r', $field ) > 0<br>" );
				if( !$any )
				    unset( $rows[$rid] );
			    }
			//			print_r( $rows );
		    }
		break;
		
		case "SectionCountRange":
		case "UseOfTriads":
		case "UseOfInvertedChords":
		case "NumMelodicThemes":
		case "PercentDiatonicChordsRange":
		case "ChordRepetitionRange":
		case "UseOfTriadsRange":
		case "UseOfInvertedChordsRange":
		case "UseOf7thChordsRange":
		case "UseOfMajor7thChordsRange":
		case "LineRepetitionPrevalenceRange":
		case "OverallRepetitivenessRange":
		case "AverageWordRepetitionRange":
		case "ConsonanceAlliterationScoreRange":
		case "AssonanceAlliterationScoreRange":
		case "RhymeDensityRange":
		case "RhymesPerSyllableRange":
		case "RhymesPerLineRange":
		case "NumberOfRhymeGroupsELRRange":
		case "EndLinePerfectRhymesPercentageRange":
		case "LocationReferencesRange":
		case "GeneralLocationReferencesRange":
		case "GeneralPersonReferencesRange":
		case "PersonReferencesRange":
		case "ThousandWordsPrevalenceRange":
		case "EndLineAssonanceRhymePercentageRange":
		case "PerfectRhymesPercentageRange":
		case "ConsonanceRhymePercentageRange":
		case "AssonanceRhymePercentageRange":
		case "EndOfLineRhymesPercentageRange":
		case "InternalRhymesPercentageRange":
		case "MidWordRhymesRange":
		case "SlangWordsRange":
		case "MidLineRhymesPercentageRange":
		case "LyricalDensityRange":
		case "DanceabilityRange":
		case "ProfanityRange":
		case "LoudnessRange":
		case "TotalAlliterationRange":
		case "TempoRangeGeneral":
		case "NumMelodicThemesRange":

		    $field = str_replace( " ", "", $field );
		//		echo( "select $field from songs where id in ( $songstr ) and $field > '' order by $field" );
		    $rows = db_query_array( "select $field from songs where id in ( $songstr ) and $field > '' order by $field  ", "$field", "$field" );
		break;

        default:
            echo( "no match ($field) ($sectionname) getRowsComparison<br>" );
            break;
    }
    return $rows;    
}

function formatYAxis( $value )
{
    if( !$value ) return "0";
    return $value;
}

function getSearchTrendName( $name )
{
    global $possiblesearchfunctions, $searchsubtype;
    // if( $name == "Primary Genres" ) return $name;
    // if( $name == "Primary Genre Breakdown" ) return $name;
    // if( $searchsubtype == "subgenres" ) return "Sub-Genres";
    // if( $searchsubtype == "influences" ) return "Influences";
    // if( $searchsubtype == "vocals" ) return "Vocals and Lyrics";
    // if( $searchsubtype == "structure" ) return "General Structure &amp; Instruments";
    // if( $searchsubtype == "intro" ) return "First Section";
    // if( $searchsubtype == "verse" ) return "Verse";
    // if( $searchsubtype == "prechorus" ) return "Pre-Chorus";
    // if( $searchsubtype == "form" ) return "Song Form";
    // if( $searchsubtype == "chorus" ) return "Chorus";
    // if( $searchsubtype == "postchorus" ) return "Post-Chorus";
    // if( $searchsubtype == "bridge" ) return "Bridge and Bridge Surrogates";
    // if( $searchsubtype == "instrumental" ) return "Instrumental and Vocal Breaks";
    // if( $searchsubtype == "outro" ) return "Last Section";

    return $possiblesearchfunctions[$name];
}


function trendsortByValue( $a, $b )
{
    if ($a[0] == $b[0]) {
         return ($a[3] > $b[3]) ? 1 : -1;;
    }
    return ($a[0] > $b[0]) ? -1 : 1;
    
}




function getCSVTrendDataForRows( $comparisonaspect, $peak="", $songsbyweeks = array() )
{
    global $newarrivalsonly, $cachedtrenddata, $searchsubtype, $dontincludeall, $sectionname, $genrefilter, $season, $possiblesearchfunctions;
//    file_put_contents("/tmp/hmm",  "before: " . print_r( $songstouse, true ), FILE_APPEND );

    $retval = array();
//    echo( "peak here is $peak" );

    if( in_array( $possiblesearchfunctions, $comparisonaspect ) )
	{
	    $comparisonaspect = array_search( $possiblesearchfunctions, $comparisonaspect );
	}

    foreach( $songsbyweeks as $thiskey=>$songs ) // i hate this so much
	{
	    $numsongs = count( $songs );
	    // we need to add this in case there were none
	    if( !count( $songs ) )
		$songs[] = -1;
	    if( !$numsongs ) $numsongs = 1;
	    $songidstr = implode( ", ", $songs );
	    
	    
	    switch( $comparisonaspect )
		{
			// case "Primary Genre Breakdown":
			// case "Primary Genres":
			//     $labels = db_query_array( "select genres.id, count(*) as num from genres, songs where GenreID = genres.id and songs.id in ( $songidstr ) group by genres.id ", "id", "num" );
			//     foreach( $labels as $t=>$numforthis )
			// 	{
			// 	    // $t = $trow["id"];
			// 	    // $numforthis = db_query_first_cell( "select count(*) from songs where songs.id in ( $songidstr ) and  GenreID = '$t' " );
				    
			// 	    $number = $numforthis;
			// 	    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			//     if( !$numforthis )
			// 	$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			// 	    $retval[$thiskey][$t]["season"] = $tmpseason;
			// 	    $retval[$thiskey][$t][0] = $numforthis;
			// 	    $retval[$thiskey][$t][1] = $numforthis . "%";
			// 	    $retval[$thiskey][$t][2] = $t;
			// 	    $retval[$thiskey][$t][3] = "search-results?$qs&search[GenreID]=" . urlencode( $t ); 
			// 	    $retval[$thiskey][$t][4] = $number;
			// 	}
			//     break;
			case "Genres":
			    // if( $genrefilter )
			    // 	{
			    // 	    $genrename = db_query_first_cell( "select Name from genres where id = $genrefilter" );
			    // 	    $ext = " and subgenres.Name <> '$genrename'";
			    // 	}
			    $sql = "select subgenreid, count(*) as num from song_to_subgenre, subgenres where type = 'Main' and subgenreid = subgenres.id and songid in ( $songidstr ) and HideFromAdvancedSearch = 0 $ext group by subgenreid ";
			    $subgenres = db_query_array( $sql, "subgenreid", "num" );
			    if( $_GET["help"] ) echo( "\ninfluence search: " . $sql . "\n<br>" );
			    
			    foreach( $subgenres as $t=>$numforthis )
				{
				    //                    $t = $trow["id"];
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_subgenre where songid in ( $songidstr ) and songid = songs.id and  song_to_subgenre.subgenreid = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[specificsubgenrealso]=" . urlencode( $t ); 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Influences":
			    if( $genrefilter )
				{
				    $genrename = db_query_first_cell( "select Name from genres where id = $genrefilter" );
				    $ext = " and influences.Name <> '$genrename'";
				}
			    $sql = "select influenceid, count(*) as num from song_to_influence, influences where type = 'Main' and influenceid = influences.id and songid in ( $songidstr ) and HideFromAdvancedSearch = 0 $ext group by influenceid ";
			    $influences = db_query_array( $sql, "influenceid", "num" );
			    if( $_GET["help"] ) echo( "\ninfluence search: " . $sql . "\n<br>" );
			    
			    foreach( $influences as $t=>$numforthis )
				{
				    //                    $t = $trow["id"];
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_influence where songid in ( $songidstr ) and songid = songs.id and  song_to_influence.influenceid = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[specificinfluencealso]=" . urlencode( $t ); 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Lyrical Themes":
			    $lyricalthemes = db_query_array( "select lyricalthemeid, count(*)  as num from song_to_lyricaltheme, lyricalthemes where lyricalthemeid = lyricalthemes.id and songid in ( $songidstr )  and HideFromAdvancedSearch = 0  group by lyricalthemeid ", "lyricalthemeid", "num" );
			    foreach( $lyricalthemes as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_lyricaltheme where songid in ( $songidstr ) and songid = songs.id and  song_to_lyricaltheme.lyricalthemeid = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[lyricalthemes][" . urlencode( $t ) . "]=1"; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Lyrical Moods":
			    $lyricalmoods = db_query_array( "select lyricalmoodid, count(*)  as num from song_to_lyricalmood, lyricalmoods where lyricalmoodid = lyricalmoods.id and songid in ( $songidstr )  and HideFromAdvancedSearch = 0  group by lyricalmoodid ", "lyricalmoodid", "num" );
			    foreach( $lyricalmoods as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_lyricalmood where songid in ( $songidstr ) and songid = songs.id and  song_to_lyricalmood.lyricalmoodid = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[lyricalmoods][" . urlencode( $t ) . "]=1"; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Lyrical Sub-themes":
			case "LyricalSubThemes":
			    $lyricalthemes = db_query_array( "select lyricalsubthemeid, count(*)  as num from song_to_lyricalsubtheme, lyricalsubthemes where lyricalsubthemeid = lyricalsubthemes.id and songid in ( $songidstr ) group by lyricalsubthemeid ", "lyricalsubthemeid", "num" );
			    foreach( $lyricalthemes as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_lyricaltheme where songid in ( $songidstr ) and songid = songs.id and  song_to_lyricaltheme.lyricalthemeid = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[lyricalsubthemes][" . urlencode( $t ) . "]=1"; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Song Title Word Count":
			    //                SongTitleWordCount
			    $stwc = db_query_array( "select SongTitleWordCount, count(*) as num from songs where id in ( $songidstr ) and SongTitleWordCount > 0 group by SongTitleWordCount order by SongTitleWordCount  ", "SongTitleWordCount", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SongTitleWordCount is not null " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SongTitleWordCount = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[SongTitleWordCount]=" . urlencode( $t ) . ":{$t}"; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Tempo Range":
			case "Tempo Range General":
			case "TempoRange":
			case "TempoRangeGeneral":
			    //                TempoRange
			    $nospaces = str_replace( " ", "", $comparisonaspect );
		$zero = "0";
		if( $nospaces == "TempoRangeGeneral" )
		    $zero = "''";

			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $nospaces > $zero  " );
			    $stwc = db_query_array( "select $nospaces, count(*) as num from songs where id in ( $songidstr ) and $nospaces > $zero group by $nospaces order by $nospaces  ", "$nospaces", "num" );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and TempoRange = '$t' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[$nospaces]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Song Title Appearances":
			    //songtitleappearancecount
			    $stwc = db_query_array( "select SongTitleAppearanceRange, count(*) as num from songs where id in ( $songidstr ) and SongTitleAppearanceRange is not null group by SongTitleAppearanceRange order by SongTitleAppearances  ", "SongTitleAppearanceRange", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SongTitleAppearanceRange is not null " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SongTitleAppearanceRange = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[songtitleappearancecount]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Key":
			    $stwc = db_query_array( "select NameHard, count(*) as num from song_to_songkey where songid in ( $songidstr ) and NameHard > '' group by NameHard order by NameHard ", "NameHard", "num" );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and KeyMajor = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[KeyMajor]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Song Form":
			    $stwc = db_query_array( "select SongStructure, count(*) as num from songs where id in ( $songidstr ) and SongStructure > '' group by SongStructure order by SongStructure ", "SongStructure", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SongStructure > '' " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and KeyMajor = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[fullform]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "KeyMajorMinor":
			    $stwc = db_query_array( "select majorminor, count(*) as num from songs where id in ( $songidstr ) and majorminor > '' group by majorminor order by majorminor ", "majorminor", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and majorminor > '' " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and majorminor = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t . "(" . $numsongs . ")";
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[majorminor]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Key (Major, Minor, Major Mode, Minor Mode)":
			    $stwc = db_query_array( "select SpecificMajorMinor, count(*) as num from songs where id in ( $songidstr ) and SpecificMajorMinor > '' group by SpecificMajorMinor order by SpecificMajorMinor ", "SpecificMajorMinor", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SpecificMajorMinor > '' " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SpecificMajorMinor = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t . "(" . $numsongs . ")";
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[SpecificMajorMinor]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Prominent Instruments":
			    $primaryinstrumentations = db_query_array( "select primaryinstrumentations.id, count(*) as num from song_to_primaryinstrumentation, primaryinstrumentations where primaryinstrumentationid = primaryinstrumentations.id and songid in ( $songidstr ) and type = 'Main'  and HideFromAdvancedSearch = 0 group by primaryinstrumentations.id ", "id", "num" );
			    foreach( $primaryinstrumentations as $t=>$numforthis )
				{
				    //                    $t = $trow["id"];
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_primaryinstrumentation where songid in ( $songidstr ) and songid = songs.id and  song_to_primaryinstrumentation.primaryinstrumentationid = '$t' and type = 'Main' " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[primaryinstrumentations][" . urlencode( $t ) . "]=1"; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Song Length Range":
			    $stwc = db_query_array( "select SongLengthRange, count(*) as num from songs where id in ( $songidstr ) and SongLengthRange is not null group by SongLengthRange order by SongLength ", "SongLengthRange", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and SongLengthRange is not null " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SongLengthRange = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[SongLengthRange]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "First Section":
			    $stwc = db_query_array( "select FirstSectionType, count(*) as num from songs where id in ( $songidstr ) and FirstSectionType is not null group by FirstSectionType order by SongLength ", "FirstSectionType", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and FirstSectionType is not null " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and FirstSectionType = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[FirstSectionType]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Intro Length Range":
			    $stwc = db_query_array( "select IntroLengthRange, count(*) as num from songs where id in ( $songidstr ) and IntroLengthRange is not null group by IntroLengthRange order by SongLength ", "IntroLengthRange", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and IntroLengthRange is not null " );
			    $tmptot = 0;
			    foreach( $stwc as $s )
				$tmptot+= $s;
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and IntroLengthRange = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($tmptot?$tmptot:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($tmptot?$tmptot:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[introlengthrange]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Genre/Influence Count":
			    $stwc = db_query_array( "select InfluenceCount, count(*) as num from songs where id in ( $songidstr ) and InfluenceCount is not null group by InfluenceCount order by InfluenceCount ", "InfluenceCount", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and InfluenceCount is not null " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and InfluenceCount = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[influencecount]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Use Of A Pre-Chorus":
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and PrechorusCount is not null " );
			    foreach( array( 0, 1 ) as $t )
				{
			    if( $t )
				$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and PrechorusCount > 0 " );
			    else
				$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and PrechorusCount = 0  " );
				    
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[UseOfAPreChorus]=" . ($t?1:-1); 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Chorus Precedes Any Section":
			    
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and ChorusPrecedesVerse is not null " );
			    foreach( array( 0, 1 ) as $t )
				{
				    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and ChorusPrecedesVerse= $t " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[ChorusPrecedesVerse]=" . urlencode( $t?1:-1 ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "First Chorus: Time Into Song Range":
			    $stwc = db_query_array( "select case when FirstChorusRange is null then 'No Chorus' else FirstChorusRange end as FirstChorusRange, count(*) as num from songs where id in ( $songidstr ) group by FirstChorusRange order by SongLength ", "FirstChorusRange", "num" );
			    // if( $_GET["help"] )
			    // 	echo( "select FirstChorusRange, count(*) as num from songs where id in ( $songidstr ) and FirstChorusRange is not null group by FirstChorusRange order by SongLength" );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and FirstChorusRange = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[FirstChorusRange]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "First Chorus: Breakdown Arrangement":
			    $stwc = db_query_array( "select FirstChorusBreakdown, count(*) as num from songs where id in ( $songidstr ) group by FirstChorusBreakdown order by FirstChorusBreakdown desc ", "FirstChorusBreakdown", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and FirstChorusBreakdown is not null " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and FirstChorusRange = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[FirstChorusBreakdown]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "First Chorus: Percent Into Song Range":
			    $stwc = db_query_array( "select case when FirstChorusPercentRange is null then 'No Chorus' else FirstChorusPercentRange end as FirstChorusPercentRange, count(*) as num from songs where id in ( $songidstr ) group by FirstChorusPercentRange order by SongLength ", "FirstChorusPercentRange", "num" );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and FirstChorusPercentRange = '$t' " );
				    $displ = $t;
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$displ][0] = $numforthis;
				    $retval[$thiskey][$displ][1] = $numforthis . "%";
				    $retval[$thiskey][$displ][2] = $t;
				    $retval[$thiskey][$displ][3] = "search-results?$qs&search[FirstChorusPercentRange]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Use Of A Vocal Post-Chorus":
			    
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and VocalPostChorusCount is not null " );
			    foreach( array( 0, 1 ) as $t )
				{
				    if( $t )
					$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and VocalPostChorusCount > 0 " );
				    else
					$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and VocalPostChorusCount = 0 " );
				    $number = $numforthis;
				    
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[UseOfAVocalPostChorus]=" . ($t?1:-1); 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Departure Section":
			    
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and UseOfABridge is not null " );
			    foreach( array( 0, 1 ) as $t )
				{
				    if( !$t ) 
					$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and UseOfABridge > 0 " );
				    else
					$numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and UseOfABridge = 0 " );
				    $number = $numforthis;
				    
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    if( !$t )
					$retval[$thiskey][$t][3] = "search-results?$qs&search[UseOfABridge]=-1";
				    else if( $t == 1 )
					$retval[$thiskey][$t][3] = "search-results?$qs&search[UseOfABridge]=1";
				    $retval[$thiskey][$t][4] = $number;
				    
				}
			    break;
			case "Last Section":
			    $stwc = db_query_array( "select LastSectionType, count(*) as num from songs where id in ( $songidstr ) and LastSectionType is not null group by LastSectionType order by SongLength ", "LastSectionType", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and LastSectionType is not null " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and LastSectionType = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[LastSectionType]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Outro Length Range":
			    $stwc = db_query_array( "select OutroRange, count(*) as num from songs where id in ( $songidstr ) and OutroRange is not null group by OutroRange order by SongLength ", "OutroRange", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and OutroRange is not null " );
			    $tmptot = 0;
			    foreach( $stwc as $s )
				$tmptot+= $s;
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and OutroRange = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($tmptot?$tmptot:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($tmptot?$tmptot:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t=="None"?"No Outro":$t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[OutroRange]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			    
			case "Intro Instrumental Vocal or Instrumental":
			case "Outro Instrumental Vocal or Instrumental":
			    $field = "IntroVocalVsInst";
			$fieldshort = "Intro";
			if( strpos( $comparisonaspect, "Outro" ) !== false )
			    {
				$fieldshort = "Outro";
			    $field = "OutroVocalVsInst";
			    }
	
			$stwc = db_query_array( "select case when $field is null then 'No $fieldshort' else $field end as $field, count(*) as num from songs where id in ( $songidstr )  group by $field order by case when $field like '%&%' then 'zz' else $field end ", "$field", "num" ); //and $field is not null
			    $tmptot = 0;
			    foreach( $stwc as $s )
				$tmptot+= $s;
			    foreach( $stwc as $t=>$numforthis )
				{
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($tmptot?$tmptot:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($tmptot?$tmptot:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[$field]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			    
			case "Major vs. Minor":
			    //echo( "select MajorMinor, count(*) as num from songs where id in ( $songidstr ) and MajorMinor is not null group by MajorMinor order by MajorMinor" );
			    $stwc = db_query_array( "select MajorMinor, count(*) as num from songs where id in ( $songidstr ) and MajorMinor > '' group by MajorMinor order by MajorMinor ", "MajorMinor", "num" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and MajorMinor is not null " );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and MajorMinor = '$t' " );
				    $number = $numforthis;
				    $displ = $t;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$displ][0] = $numforthis;
				    $retval[$thiskey][$displ][1] = $numforthis . "%";
				    $retval[$thiskey][$displ][2] = $t . " " . ($numforthis * 100 / ($numsongs?$numsongs:1));
				    $retval[$thiskey][$displ][3] = "search-results?$qs&search[majorminor]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$displ][4] = $number;
				}
			    //			    print_r( $retval["2013"] );
			    //			    exit;
			    break;
			    
			//     $rows = array();
			//     $tmprows = db_query_array( "select  id, VocalPostChorusCount as num from songs where VocalPostChorusCount > 0 and songid in ( $songstr ) group by songid", "id", "VocalPostChorusCount" );
			//     foreach( $tmprows as $t=>$num )
			// 	{
			// 	    if( !$rows[$num] ) $rows[$num] = 0;
			// 	    $rows[$num]++;
			// 	}
			//     if( count( $songs ) - count( $tmprows ) )
			// 	$rows[0] = count( $songs ) - count( $tmprows );
			    
			//     foreach( $rows as $t=>$numforthis )
			// 	{
			// 	    $number = $numforthis;
				    
			// 	    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			//     if( !$numforthis )
			// 	$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			// 	    $retval[$thiskey][$t]["season"] = $tmpseason;
			// 	    $retval[$thiskey][$t][0] = $numforthis;
			// 	    $retval[$thiskey][$t][1] = $numforthis . "%";
			// 	    $retval[$thiskey][$t][2] = $t;
			// 	    $retval[$thiskey][$t][3] = "search-results?$qs&search[][PostChorus]=" . urlencode( $t?$t:-1 ); 
			// 	    $retval[$thiskey][$t][4] = $number;
			// 	}
			//     break;
		case "Vocal Post-Chorus Count":
			case "Chorus Count":
			case "Verse Count":

			    // to fix
			    $fieldname = str_replace( " ", "", $comparisonaspect );
			    $fieldname = str_replace( "-", "", $fieldname );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $fieldname is not null " );
			$rows = db_query_array( "select  $fieldname, count(*) as num from songs where id in ( $songidstr ) group by $fieldname order by $fieldname", "$fieldname", "num" );
			foreach( $rows as $t=>$numforthis )
			    {
				//                    $numforthis = db_query_first_cell( "select count(*) from SectionShorthand where songid in ( $songidstr ) and NumSections = '$t' and section = '$fieldname' " );
				$number = $numforthis;
				
				$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				$retval[$thiskey][$t]["season"] = $tmpseason;
				$retval[$thiskey][$t][0] = $numforthis;
				$retval[$thiskey][$t][1] = $numforthis . "%";
				$retval[$thiskey][$t][2] = $t;
				$retval[$thiskey][$t][3] = "search-results?$qs&search[$fieldname]=" . urlencode( $t?$t:-1 ); 
				$retval[$thiskey][$t][4] = $number;
			    }

			$totnum = db_query_first_cell( "select count(distinct( id)) as num from songs where songid in ( $songidstr ) " );
			if( $totnum < $numsongs )
			    {
				$number = $numsongs - $totnum;
				$numforthis = $number;
				$t = "No " . str_replace( " Count", "", $comparisonaspect );
				$retval[$thiskey][$t]["season"] = $tmpseason;
				$retval[$thiskey][$t][0] = $numforthis;
				$retval[$thiskey][$t][1] = $numforthis . "%";
				$retval[$thiskey][$t][2] = $t;
				$retval[$thiskey][$t][3] = "search-results?$qs&search[$fieldname]=-1";
				$retval[$thiskey][$t][4] = $number;
			    }
			
			break;
			case "Number Of Songs Within The Top 10":
			case "Carryovers vs. New Songs":
			    $rows = array( "Total Songs in the Top 10", "New Songs", "Carryovers" );
			foreach( $rows as $t=>$val )
			    {
				if( $val == "Total Songs in the Top 10" )
				    $numforthis = $numsongs;
				else if( $val == "New Songs" )
				    {
					$numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and QuarterEnteredTheTop10 = '$q'" );
				    }
				else
				    {
					$numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and QuarterEnteredTheTop10 <> '$q'" );
				    }
				$number = $numforthis;
				
				//                    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
				$retval[$thiskey][$t]["season"] = $tmpseason;
				$retval[$thiskey][$t][0] = $numforthis;
				$retval[$thiskey][$t][1] = $numforthis;
				$retval[$thiskey][$t][2] = $t;
				$retval[$thiskey][$t][3] = "search-results?$qs&search[toptentype]=" . urlencode( $val ); 
				$retval[$thiskey][$t][4] = $number;
			    }
			break;
			    
			case "Electronic Vs. Acoustic Songs":
			    $stwc = db_query_array( "select ElectricVsAcoustic from songs where id in ( $songidstr ) and ElectricVsAcoustic is not null order by ElectricVsAcoustic  ", "ElectricVsAcoustic", "ElectricVsAcoustic" );
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and ElectricVsAcoustic is not null " );	
		    foreach( $stwc as $t )
				{
				    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and ElectricVsAcoustic = '$t' " );
				    $number = $numforthis;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    $retval[$thiskey][$t][3] = "search-results?$qs&search[ElectricVsAcoustic]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$t][4] = $number;
				}
			    break;
			case "Average Intro Length":
			case "Average Outro Length":
			    
			    $short = str_replace( "Average ", "", $comparisonaspect );
			$short = str_replace( " Length", "", $short );
			$rows = array( "Average" );
			
			foreach( $rows as $t=>$val )
			    {
				$numforthis = db_query_first_cell( "select round( avg( time_to_sec( {$short}Length ) ) ) from songs where id in ( $songidstr ) " );
				
				$display = makeTimeSeconds( $numforthis );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				$retval[$thiskey][$t][0] = $numforthis;
				$retval[$thiskey][$t][1] = $display;
				$retval[$thiskey][$t][2] = $t;
				//                    $retval[$thiskey][$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
			    }
			break;
			case "Average Song Length":
			    $rows = array( "Average" );
			    foreach( $rows as $t=>$val )
				{
				    $numforthis = db_query_first_cell( "select round( avg( time_to_sec( SongLength ) ) ) from songs where id in ( $songidstr )" );
				    
				    $display = makeTime( $numforthis );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $display;
				    $retval[$thiskey][$t][2] = $t;
				    //                    $retval[$thiskey][$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
				}
			    break;
			case "Average Tempo":
			    $rows = array( "Average" );
			    foreach( $rows as $t=>$val )
				{
				    $numforthis = db_query_first_cell( "select round( avg( Tempo ) ) from songs where id in ( $songidstr )" );
				    
				    $display = $numforthis;
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $display;
				    $retval[$thiskey][$t][2] = $t;
				    //                    $retval[$thiskey][$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
				}
			    break;
			case "First Chorus: Average Time Into Song":
			    $rows = array( "Average" );
			    foreach( $rows as $t=>$val )
				{
				    $numforthis = db_query_first_cell( "select round( avg( FirstChorusTimeIntoSong ) ) from songs where id in ( $songidstr ) " ); // chorus 1
				    
				    $display = makeTimeSeconds( $numforthis );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $display;
				    $retval[$thiskey][$t][2] = $t;
				    //                    $retval[$thiskey][$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
				}
			    break;
			case "First Chorus: Average Percent Into Song":
			    $rows = array( "Average" );
			    foreach( $rows as $t=>$val )
				{
				    $numforthis = db_query_first_cell( "select round( avg( FirstChorusPercent ) ) from songs where id in ( $songidstr ) " ); // chorus 1
				    
				    $numforthis = number_format( $numforthis );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$t][0] = $numforthis;
				    $retval[$thiskey][$t][1] = $numforthis . "%";
				    $retval[$thiskey][$t][2] = $t;
				    //                    $retval[$thiskey][$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
				}

		case "UseofParallelMode":
		case "CreativeWorksTitles":
		case "PersonReferences":
		case "LocationReferences":
		case "GeneralPersonReferences":
		case "GeneralLocationReferences":
		case "OrganizationorBrandReferences":
		case "ConsumerGoodsReferences":
		case "SlangWords":
		case "PercentProfanity":
		case "WordsRepetitionPrevalence":
		case "PercentAbbreviations":
		case "PercentNonDictionary":
				$numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect is not null " );
		    foreach( array( 0, 1 ) as $t )
		    {
			if( $t )
			    $numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect > 0 " );
			else
			    $numforthis = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect = 0 " );
			$number = $numforthis;
			
			
			$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			if( !$numforthis )
			    $numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			$retval[$t]["season"] = $tmpseason;
			$retval[$t][0] = $numforthis;
			$retval[$t][1] = $numforthis . "%";
			$retval[$t][2] = $t;
			$retval[$t][3] = "search-results?$qs&search[$comparisonaspect]=" . ($t?1:-1); 
			$retval[$t][4] = $number;
		    }
		
		case "LyricalSubThemes": 
		case "LyricalMoods": 
		    $shorttablename = substr(strtolower( $comparisonaspect ), 0, -1);

		$vals = db_query_array( "select {$shorttablename}s.id, count(*) as num from song_to_{$shorttablename}, {$shorttablename}s where {$shorttablename}id = {$shorttablename}s.id and songid in ( $songidstr ) group by {$shorttablename}s.id ", "id", "num" );
		foreach( $vals as $t=>$numforthis )
		    {
			//                    $t = $trow["id"];
			//                    $numforthis = db_query_first_cell( "select count(*) from songs, song_to_primaryinstrumentation where songid in ( $songidstr ) and songid = songs.id and  song_to_primaryinstrumentation.primaryinstrumentationid = '$t' and type = 'Main' " );
			$number = $numforthis;
			
			$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			if( !$numforthis )
			    $numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
			$retval[$thiskey][$t]["season"] = $tmpseason;
			$retval[$thiskey][$t][0] = $numforthis;
			$retval[$thiskey][$t][1] = $numforthis . "%";
			$retval[$thiskey][$t][2] = $t;
			$retval[$thiskey][$t][3] = "search-results?$qs&search[{$shorttablename}s][" . urlencode( $t ) . "]=1"; 
			$retval[$thiskey][$t][4] = $number;
		    }
		

		break;
		case "OverallRepetitiveness":
		case "ConsonanceAlliterationScore":
		case "AssonanceAlliterationScore":
		case "PercentDiatonicChords":
		case "WordsRepetitionPrevalence":
		case "LineRepetitionPrevalence":
		case "NumMelodicThemes":
		case "ThousandWordsPrevalence":
		case "TenThousandWordsPrevalence":
		case "FiftyThousandWordsPrevalence":
		case "PercentNonProfanity":
		case "RhymeDensity":
		case "RhymesPerSyllable":
		case "RhymesPerLine":
		case "NumberOfRhymeGroupsELR":
		case "VocalPostChorusCount":
		case "EndLinePerfectRhymesPercentage":
		case "EndLineSecondaryPerfectRhymesPercentage":
		case "EndLineAssonanceRhymePercentage":
		case "PerfectRhymesPercentage":
		case "AssonanceRhymePercentage":
		case "ConsonanceRhymePercentage":
		case "EndOfLineRhymesPercentage":
		case "MidLineRhymesPercentage":
		case "InternalRhymesPercentage":
		case "MidWordRhymes":
		case "WordsPerLineAvg":
		case "PreChorusSectionLyrics":
		case "MainMelodicRangeNum":
		case "ChordRepetition":
		case "UseOfTriads":
		case "UseOfInvertedChords":
		case "AverageWordRepetition":
		case "LyricalDensity":
		case "UseOf7thChords":
		case "UseOfMajor7thChords":
		case "EndLineConsonanceRhymePercentage":
		case "SecondaryPerfectRhymesPercentage":
		case "Danceability":
		case "FirstChorusTimeIntoSong":
		case "Loudness":
		case "SectionCount":
		    $rows = array( "Average" );
		    $rounder = 0;
		    if( isRounder( $comparisonaspect ) )
			{
			    $rounder = 2;
			}
		foreach( $rows as $t=>$val )
		    {
			
			$numforthis = db_query_first_cell( "select round( avg( $comparisonaspect ), $rounder ) from songs where id in ( $songidstr ) " ); // chorus 1
			$numforthis = number_format( $numforthis, $rounder );			
			$retval[$thiskey][$t]["season"] = $tmpseason;
			$retval[$thiskey][$t][0] = $numforthis;
			$retval[$thiskey][$t][1] = $numforthis . ($rounder?"":"%");
			$retval[$thiskey][$t][2] = $t;
			//                    $retval[$thiskey][$t][3] = "search-results?$qs&search[instbrkpi][$t]=" . urlencode( $t ); 
		    }


		    break;
		case "ChordDegreePrevalence":
		case "MelodicIntervalPrevalence":
		case "VocalsInstrumentsPrevalence":
		case "Timbre":
		case "MainMelodicRange":
		case "ProductionMood":
		case "LiteralExperiencesvsAbstract":
		    $rows = getSetValues( $comparisonaspect );
		$isenum = false;
		if( !count( $rows ) ) { 
		    $isenum = true;
		    $rows = getEnumValues( $comparisonaspect );
		}
			    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect is not null  " );
			    foreach( $rows as $t )
				{
				    if( $isenum )
					$numforthis = db_query_first_cell( "select count(*) as num from songs where id in ( $songidstr ) and $comparisonaspect = '$t'" );
				    else
					$numforthis = db_query_first_cell( "select count(*) as num from songs where id in ( $songidstr ) and $comparisonaspect like '%$t%'" );

				    $number = $numforthis;
				    $displ = $t;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
				    if( !$numforthis )
					$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$displ][0] = $numforthis;
				    $retval[$thiskey][$displ][1] = $numforthis. "%";
				    $retval[$thiskey][$displ][2] = $t . " " . ($numforthis * 100 / ($numsongs?$numsongs:1));
				    $retval[$thiskey][$displ][3] = "search-results?$qs&search[$comparisonaspect]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$displ][4] = $number;
				}
			    //			    print_r( $retval["2013"] );
			    //			    exit;
			    break;



		case "SectionCountRange":
		case "PercentDiatonicChordsRange":
		case "ChordRepetitionRange":
		case "UseOfTriadsRange":
		case "UseOfInvertedChordsRange":
		case "UseOf7thChordsRange":
		case "UseOfMajor7thChordsRange":
		case "LineRepetitionPrevalenceRange":
		case "OverallRepetitivenessRange":
		case "AverageWordRepetitionRange":
		case "ConsonanceAlliterationScoreRange":
		case "AssonanceAlliterationScoreRange":
		case "RhymeDensityRange":
		case "RhymesPerSyllableRange":
		case "RhymesPerLineRange":
		case "NumberOfRhymeGroupsELRRange":
		case "EndLinePerfectRhymesPercentageRange":
		case "LocationReferencesRange":
		case "GeneralPersonReferencesRange":
		case "GeneralLocationReferencesRange":
		case "PersonReferencesRange":
		case "ThousandWordsPrevalenceRange":
		case "EndLineAssonanceRhymePercentageRange":
		case "PerfectRhymesPercentageRange":
		case "ConsonanceRhymePercentageRange":
		case "AssonanceRhymePercentageRange":
		case "EndOfLineRhymesPercentageRange":
		case "InternalRhymesPercentageRange":
		case "MidWordRhymesRange":
		case "SlangWordsRange":
		case "MidLineRhymesPercentageRange":
		case "LyricalDensityRange":
		case "DanceabilityRange":
		case "ProfanityRange":
		case "LoudnessRange":
		case "TotalAlliterationRange":
		case "TempoRangeGeneral":
		case "NumMelodicThemesRange":
		//     $percent = "%";
		// if( isNotPercent( $comparisonaspect ) )
		    //		if( $comparisonaspect == "NumMelodicThemesRange" || $comparisonaspect == "TempoRangeGeneral" || $comparisonaspect == "SectionCountRange" )
		$zero = "0";
		if( $nospaces == "TempoRangeGeneral" )
		    $zero = "''";

		    $numsongs = db_query_first_cell( "select count(distinct( id)) from songs where id in ( $songidstr ) and $comparisonaspect > $zero " );
		    $percent = "";
			    $stwc = db_query_array( "select $comparisonaspect, count(*) as num from songs where id in ( $songidstr ) and $comparisonaspect > '' group by $comparisonaspect order by $comparisonaspect ", "$comparisonaspect", "num" );
			    foreach( $stwc as $t=>$numforthis )
				{
				    //                    $numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and $comparisonaspect = '$t' " );
				    $number = $numforthis;
				    $displ = $t;
				    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
			    if( !$numforthis )
				$numforthis = number_format( $number * 100 / ($numsongs?$numsongs:1), 1 );
				    $retval[$thiskey][$t]["season"] = $tmpseason;
				    $retval[$thiskey][$displ][0] = $numforthis;
				    $retval[$thiskey][$displ][1] = $numforthis . $percent ;
				    $retval[$thiskey][$displ][2] = $t . " " . ($numforthis * 100 / ($numsongs?$numsongs:1));
				    $retval[$thiskey][$displ][3] = "search-results?$qs&search[$comparisonaspect]=" . urlencode( $t ) . ""; 
				    $retval[$thiskey][$displ][4] = $number;
				}
			    //			    print_r( $retval["2013"] );
			    //			    exit;
			    break;
		default: 			    
			    echo( "no match ($comparisonaspect) ($sectionname)!!! getTrendDataForRows<br>" );
			    break;
		}
		    //	echo( $q . "<br>" );
	}
	    //   file_put_contents( "/tmp/hmm", "putting this in?: " . ( print_r( $retval, true ) ) . " \n" );
    return $retval;
}


function formatCSVTitle( $title )
{
global $graphtype;
       if( $graphtype == "line" ) return $title;
    if( $title == "1-+" ) return "All Weeks";
    if( $title == "1-9" ) return "9 or Less";
    $exp = explode( "-", $title );
    $retval = $exp[0];
    if( $retval == $exp[1] )
	{
	    $retval .= ($retval>1)?" Weeks":" Week";
	}
    else
	{
	    if( $exp[1] == "+" || $exp[1] == "999" )
		$retval .= "+ Weeks";
	    else 
		$retval .= "-{$exp[1]} Weeks";
	}
    return $retval; 
 }
function getCSVPossTitles()
{
    $posstitles = array();
    $posstitles[] = "1-+";
    $posstitles[] = "1-4";
    $posstitles[] = "5-9";
    $posstitles[] = "10-19";
    $posstitles[] = "20-29";
    $posstitles[] = "30-999";
    $posstitles[] = "1-1";
    $posstitles[] = "2-+";
    $posstitles[] = "5-+";
    $posstitles[] = "10-+";
    $posstitles[] = "20-+";
    $posstitles[] = "30-+";
    $posstitles[] = "1-9";
    return $posstitles;
}

function customSortCSVResults( $a, $b )
{
	global $lastdatatimewise;
	$aval = $bval = 999;
	$counter = 0;
	foreach( $lastdatatimewise as $key=>$val )
	    {
		if( $a === $key )
		    {
			$aval = $counter;
		    }
		if( $b === $key )
		    {
			$bval = $counter;
		    }
		$counter++;
	    }
	if( $aval  == $bval ) return 0;
	return ($aval < $bval)?-1:1; // descending

}

function customSortLastDataCSV( $a, $b )
{
    if( intval( $a[4] ) === intval( $b[4] ) ){
	if( isset( $a["name"] ) )
	    {
		return ($a["name"] < $b["name"])?-1:1; // descending
	    }
	return 0;
    }
	return ($a[4] < $b[4])?1:-1; // descending
}

function isTrendTable( $name )
{
    if( $name == "Number of Songs" || $name == "Number of Weeks" || $name == "Number of Songs (Form)" ) 
	return true;
    return false;

}

?>
