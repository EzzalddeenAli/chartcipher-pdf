<?php

//db_query( "insert into song_to_weekdate ( songid, weekdateid, type ) values ( '$songid', '592', 'position5' )" );
//db_query( "insert into song_to_weekdate ( songid, weekdateid, type ) values ( '$songid', '610', 'position6' )" );

    $autocalcvalues = array();

  //  $firstrow = db_query_first( "select Name, type, OrderBy, weekdates.id from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by OrderBy limit 1" );
//     $firstdate = $firstrow[OrderBy];
// //echo( "autoclcing $songid: " . $firstdate . "<br>" );
//       if( date( "n", $firstdate ) <= 3 )
//       {
// 	$quarter = "1/" . date( "Y", $firstdate );
//       }
//     else if( date( "n", $firstdate ) <= 6 )

//       {
// 	$quarter = "2/" . date( "Y", $firstdate );
//       }
//     else if( date( "n", $firstdate ) <= 9 )
//       {
// 	$quarter = "3/" . date( "Y", $firstdate );
//       }
//     else
//       {
// 	$quarter = "4/" . date( "Y", $firstdate );
//       }

  //  $numweeks = db_query_first_cell( "select count(*) from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by OrderBy" );
    //$peak = db_query_first_cell( "select type from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by cast( replace( type, 'position', '' ) as signed ) limit 1" );


//$autocalcvalues["QuarterEnteredTheTop10"] = $quarter;
//$autocalcvalues["WeekEnteredTheTop10"] = $firstrow[id];
//$autocalcvalues["YearEnteredTheTop10"] = date( "Y", $firstdate );
//$autocalcvalues["EntryPosition"] = str_replace( "position", "", $firstrow["type"] );
//$autocalcvalues["NumberOfWeeksSpentInTheTop10"] = $numweeks;
//$autocalcvalues["PeakPosition"] = str_replace( "position", "", $peak );
//$autocalcvalues["FirstSection"] = $firstsection; // not sure we need this
// $autocalcvalues["LastSectionID"] = $lastsection; // not sure we need this


// SectionCountRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "SectionCountRange", "SectionCount", "1-3, 3-6, 6+", "" );

// MelodicThemeRepetitionsRange
$sectioncount = db_query_first_cell( "select NumMelodicThemes from songs where id = $songid" );
if( $sectioncount >= 5 )
    $autocalcvalues["NumMelodicThemesRange"] = "5+";
else
    $autocalcvalues["NumMelodicThemesRange"] = $sectioncount;

if( !$autocalcvalues["NumMelodicThemesRange"] )
    $autocalcvalues["NumMelodicThemesRange"] = "";
else if( $autocalcvalues["NumMelodicThemesRange"] == 1 )
    $autocalcvalues["NumMelodicThemesRange"] = "Low Use";
else if( $autocalcvalues["NumMelodicThemesRange"] == 2 || $autocalcvalues["NumMelodicThemesRange"] == 3 )
    $autocalcvalues["NumMelodicThemesRange"] = "Low-Mid Use";
else if( $autocalcvalues["NumMelodicThemesRange"] == 4 )
    $autocalcvalues["NumMelodicThemesRange"] = "Mid-High Use";
else if( $autocalcvalues["NumMelodicThemesRange"] == "5+" )
    $autocalcvalues["NumMelodicThemesRange"] = "Mid-High Use";

//Number of Melodic Themes (Range): https://analytics.chartcipher.com/4jZUD (Low use: 1, Low-Mid use: 2-3, Mid-High use: 4, High use: >=5)


// PercentDiatonicChordsRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "PercentDiatonicChordsRange", "PercentDiatonicChords", "70-, 70-80, 80-100, 100+", "", array( "Chromatic Influence / Multiple Keys", "Somewhat Diatonic", "Primarily Diatonic", "Entirely Diatonic" ) );
				    //Diatonic Chord Prevalence: https://analytics.chartcipher.com/4NmgW (Very Diatonic - over 90%, Diatonic - 80-90%, Somewhat Diatonic - 70-80%,  - Lower than 70%)

// ChordRepetitionRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "ChordRepetitionRange", "ChordRepetition", "1.5-, 1.5-4.5, 4.5+", "", array( "Low Repetition", "Moderate Repetition", "High Repetition" ) );
//Not Repetitive, Somewhat Repetitive, Very Repetitive, Highly Repetitive)


$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "ThousandWordsPrevalenceRange", "ThousandWordsPrevalence", "45-, 45-55, 55-65, 65+", "", array( "Little Use", "Some", "Moderate", "Very Frequent" ) );
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "GeneralLocationReferencesRange", "GeneralLocationReferences", "0-, 0-5, 5-14, 14+", "", array( "None", "Few", "Frequent", "Very Frequent" ) );
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "LocationReferencesRange", "LocationReferences", ".01-, .01-3, 3-7, 7+", "", array( "None", "Few", "Frequent", "Very Frequent" ) );
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "PersonReferencesRange", "PersonReferences", "0.01-, 0.01-4, 4-12, 12+", "", array( "None", "Few", "Frequent", "Very Frequent" ) );
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "GeneralPersonReferencesRange", "GeneralPersonReferences", "0.01-, 0.01-8, 8-17, 17+", "", array( "None", "Few", "Frequent", "Very Frequent" ) );


if( $autocalcvalues["ChordRepetitionRange"] == "Under 3.5" )
$autocalcvalues["ChordRepetitionRange"] = "Not Repetitive";
if( $autocalcvalues["ChordRepetitionRange"] == "3.5 - 4.5" )
$autocalcvalues["ChordRepetitionRange"] = "Somewhat Repetitive";
if( $autocalcvalues["ChordRepetitionRange"] == "4.5 - 5.5" )
$autocalcvalues["ChordRepetitionRange"] = "Very Repetitive";
if( $autocalcvalues["ChordRepetitionRange"] == "Above 5.5" )
$autocalcvalues["ChordRepetitionRange"] = "Highly Repetitive";

//Melodic Interval Prevalence: https://analytics.chartcipher.com/SDMaD (change category division: P1-M2, m3-P5, m6+)
//Use of Septachords: https://analytics.chartcipher.com/KwzgA (Low use of 7 chords - Under 10%, Low-Mid use of 7 chords- 10-25%, Mid-High use of 7 chords- 25-40%, High use of 7 chords- >40%)



// UseOfTriadsRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "UseOfTriadsRange", "UseOfTriads", "35-, 35-50, 50-60, 60+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );

// UseOfInvertedChordsRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "UseOfInvertedChordsRange", "UseOfInvertedChords", "0.001-, 0.001-9, 9-14, 14+", "", array( "None", "Sporadic Use", "Moderate Use", "Frequent Use" ) );
//Use of Inverted Chords: https://analytics.chartcipher.com/URAn2 (Incidental / Low use of Inverted Chords - Under 7%, Low-Mid use of Inverted Chords - 7-10%, Mid-High use of Inverted Chords - 10-15%, High use of Inverted Chords - Above 15%)

// UseOf7thChordsRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "UseOf7thChordsRange", "UseOf7thChords", "0.0001-, 0.0001-13, 13-35, 35+", "", array( "None", "Sporadic Use", "Moderate Use", "Frequent Use" )  );

// UseOfMajor7thChordsRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "UseOfMajor7thChordsRange", "UseOfMajor7thChords", "5-, 5-10, 10-20, 20+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );
//Major 7th Prevalence: https://analytics.chartcipher.com/k8NNc (Low use - Under 5%, Low-Mid use - 5%-10%, Mid-High use - 10%-20%, High use - Above 20%)

// LineRepetitionPrevalenceRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "LineRepetitionPrevalenceRange", "LineRepetitionPrevalence", "15-, 15-25, 25-35, 35+", "", array( "Low", "Low-Mid", "High-Mid", "High" ) );


// OverallRepetitivenessRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "OverallRepetitivenessRange", "OverallRepetitiveness", "60-, 60-67, 67-75, 75+", "", array( "Low", "Moderate", "High", "Very High" )  );

// AverageWordRepetitionRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "AverageWordRepetitionRange", "AverageWordRepetition", "2.5-, 2.5-3, 3-3.5, 3.5+", "", array( "Low", "Low-Mid", "High-Mid", "High" ) );

// Slang
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "SlangWordsRange", "SlangWords", "1-, 1-8, 8-20, 20+", "", array( "Low", "Some", "Frequent", "Very Frequent" ) );

// ConsonanceAlliterationScoreRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "ConsonanceAlliterationScoreRange", "ConsonanceAlliterationScore", "0.6-, 0.6-0.9, 0.9-1.2, 1.2+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );
//Average Consonance Alliteration: https://analytics.chartcipher.com/CrXE5 (High - Above 1.2, High-Mid - 0.9-1.2, Low-Mid -0.6-0.9, Low - Under 0.6)

// AssonanceAlliterationScoreRange 
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "AssonanceAlliterationScoreRange", "AssonanceAlliterationScore", "0.3-, 0.3-0.6, 0.6-0.9, 0.9+", "", array( "Low", "Low-Mid", "High-Mid", "High" ) );
//Average Assonance Alliteration: https://analytics.chartcipher.com/gUaud (High - Above 0.9, High-Mid - 0.6-0.9, Low-Mid -0.3-0.6, Low - Under 0.3)

// RhymeDensityRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "RhymeDensityRange", "RhymeDensity", "25-, 25-33, 33-50, 50+", "", array( "Low", "Moderate", "High", "Very High" )  );
//Rhyme Density: https://analytics.chartcipher.com/wAJmL (High - Above 50%, High-Mid - 33%-50%, Low-Mid - 25%-33%, Low - Under 25%)

// RhymesPerSyllableRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "RhymesPerSyllableRange", "RhymesPerSyllable", "15-, 15-18, 18-22, 22+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );

// RhymesPerLineRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "RhymesPerLineRange", "RhymesPerLine", "1.25-, 1.25-1.5, 1.5-2, 2+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );


// NumberOfRhymeGroupsELRRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "NumberOfRhymeGroupsELRRange", "NumberOfRhymeGroupsELR", "15-, 15-20, 20-30, 30+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );

// EndLinePerfectRhymesPercentageRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "EndLinePerfectRhymesPercentageRange", "EndLinePerfectRhymesPercentage", "10-, 10-20, 20-30, 30+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );
//Use of End-of-Line Perfect Rhymes: https://analytics.chartcipher.com/W6XUu (High - Above 30%, High-Mid - 20%-30%, Low-Mid - 10%-20%, Low - Under 10%)

// EndLineAssonanceRhymePercentageRange 
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "EndLineAssonanceRhymePercentageRange", "EndLineAssonanceRhymePercentage", "10-, 10-20, 20-30, 30+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );
//Use of End-of-Line Assonance Rhymes: https://analytics.chartcipher.com/IDRuX (High - Above 30%, High-Mid - 20%-30%. Low-Mid - 10%-20%, ow - Under 10%)

// PerfectRhymesPercentageRange					
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "PerfectRhymesPercentageRange", "PerfectRhymesPercentage", "20-, 20-30, 30-40, 40+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );
//Use of Perfect Rhymes: https://analytics.chartcipher.com/JmraH (High - Above 60%, High-Mid - 40%-60%, Low-Mid - 20%-40%, Low - Under 20%)

// AssonanceRhymePercentageRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "AssonanceRhymePercentageRange", "AssonanceRhymePercentage", "20-, 20-30, 30-40, 40+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );
//Use of Assonance Rhymes: https://analytics.chartcipher.com/hZdUs (High - Above 40%, High-Mid - 30%-40%, Low-Mid - 20%-30%, Low - Under 20%)

// ConsonanceRhymePercentageRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "ConsonanceRhymePercentageRange", "ConsonanceRhymePercentage", "1-, 1-5, 5-10, 10+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );
//Use of Consonance Rhymes: https://analytics.chartcipher.com/BpK2h (High - Above 10%, High-Mid -5%-10%, Low-Mid -1%-5%, Low - Under 1%)

// EndOfLineRhymesPercentageRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "EndOfLineRhymesPercentageRange", "EndOfLineRhymesPercentage", "40-, 40-50, 50-60, 60+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );
//Use of End-of-Line Rhymes: https://analytics.chartcipher.com/fhD8a (High - Above 60%, High-Mid -50%-60%, Low-Mid -40%-50%, Low - Under 40%)

// MidLineRhymesPercentageRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "MidLineRhymesPercentageRange", "MidLineRhymesPercentage", "40-, 40-50, 50-60, 60+", "", array( "Little to None", "Occasional", "Moderate", "Frequent" )  );
//Use of Mid-Line Rhymes: https://analytics.chartcipher.com/rfFfs (High - Above 60%, High-Mid -50%-60%, Low-Mid -40%-50%, Low - Under 40%)

// InternalRhymesPercentageRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "InternalRhymesPercentageRange", "InternalRhymesPercentage", "5-, 5-10, 10-15, 15-30, 30+", "", array( "Little to None", "Occasional", "Moderate", "Frequent", "Very Frequent" )  );
//Use of internal Rhymes: https://analytics.chartcipher.com/NzYY3 (High - Above 15%, High-Mid - 10%-15%, Low-Mid -5%-20%, Low - Under 5%)

// MidWordRhymesRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "MidWordRhymesRange", "MidWordRhymes", "10-, 10-20, 20-30, 30+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );
//Use of Mid Word Rhymes: https://analytics.chartcipher.com/wWOoJ (High - Above 30%, High-Mid - 20%-30%, Low-Mid -10%-20%, Low - Under 10%)

// LyricalDensityRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "LyricalDensityRange", "LyricalDensity", "1-, 1-1.23, 1.23-1.26, 1.26+", "", array( "Low", "Low-Mid", "High-Mid", "High" )  );

// DanceabilityRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "DanceabilityRange", "Danceability", "70-, 70-90, 90+", "", array( "Low", "Moderate", "High" )  );
//Danceability: https://analytics.chartcipher.com/ShbcB (High - >90%, Moderate  - 70%-90%, Low - under 70%)

$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "ProfanityRange", "PercentProfanity", "0.00001-, 0.00001-7, 7+", "", array( "None", "Sporadic Use", "Heavy Use" )  );

// LoudnessRange
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "LoudnessRange", "Loudness", "4-, 4-6, 6-9, 9+", "", array( "Low", "Low-Mid", "High-Mid", "High" ) );
$autocalcvalues = getAutoCalcRange( $autocalcvalues, $songid, "TotalAlliterationRange", "TotalAlliteration", "1-, 1-2, 2-3, 3+", "", array( "Little to None", "Moderate", "Frequent", "Very Frequent" ) );
//Loudness: https://analytics.chartcipher.com/cs0Nb (High, High-Mid, Low-Mid, Low)


// SongNameHard etc

$autocalcvalues["SongNameHard"] = escMe( db_query_first_cell( "select BillboardName from songs where id = $songid"  ) );
$autocalcvalues["ArtistBand"] = escMe( db_query_first_cell( "select BillboardArtistName from songs where id = $songid"  ) );

// $totalsec = db_query_first_cell( "select time_to_sec( SongLength ) from songs where id = $songid" );
// $firstchorusstart = db_query_first_cell( "select time_to_sec( FirstChorusTimeIntoSong ) from songs where id = $songid " );

// db_query( "update songs set FirstChorusPercent = " .  number_format( $firstchorusstart * 100 / ($totalsec?$totalsec:1), 2, ".", "" ) . " where id = $songid" ); 


//FirstChorusPercentRange  
//FirstChorusPercent       

// $times = array();
// $times[] = "Kickoff";
// $times[] = "0:01 - 0:19";
// $times[] = "0:20 - 0:39";
// $times[] = "0:40 - 0:59";
// $times[] = "1:00 +";

// $etimes = array();
// $etimes[] = array( '00:00:00', '00:00:01' );
// $etimes[] = array( '00:00:01', '00:00:20' );
// $etimes[] = array( '00:00:20', '00:00:40' );
// $etimes[] = array( '00:00:40', '00:01:00' );
// $etimes[] = array( '00:01:00', '23:00:00' );

// db_query( "update songs set FirstChorusRange = null where id = $songid" );
// foreach( $times as $k=>$t )
//   {
//     $et = $etimes[$k];
//     //    echo( "update songs set FirstChorusRange = '$t' where FirstChorusTimeIntoSong >= '$et[0]' and FirstChorusTimeIntoSong < '$et[1]' )<br>" );
//     db_query( "update songs set FirstChorusRange = '$t' where FirstChorusTimeIntoSong >= '$et[0]' and FirstChorusTimeIntoSong < '$et[1]' and id = $songid" );
//   }


// db_query( "update songs set FirstChorusPercentRange = null where id = $songid" );
// $arr = array( 0=>"Kickoff", "10"=>"Early", 20=>"Moderately Early", "30"=>"Moderately Late", "100"=>"Late");
// foreach( $arr as $a=>$descr )
// {
//     db_query( "update songs set FirstChorusPercentRange = '$descr' where FirstChorusPercent <= $a and FirstChorusPercentRange is null and id = $songid" );
// }

// db_query( "update songs set FirstChorusDescr = null, FirstChorusPercentRange = null where FirstChorusRange is null and id = $songid" );





//FirstChorusRange

// db_query( "update songs set FirstChorusDescr = null where id = $songid" );
// $firstchorusarr = db_query_rows( "select time_to_sec( FirstChorusTimeIntoSong ), id as songid from songs where id = $songid" );
// foreach( $firstchorusarr as $frow )
// {
//     $firstchorusstart = $frow["tm"];
//     if( $firstchorusstart <= 0  )
// 	db_query( "update songs set FirstChorusDescr = 'Kickoff' where id = $frow[songid]" );
//     else if( $firstchorusstart < 20  )
// 	db_query( "update songs set FirstChorusDescr = 'Early' where id = $frow[songid]" );
//     else if( $firstchorusstart < 40  )
// 	db_query( "update songs set FirstChorusDescr = 'Moderately Early' where id = $frow[songid]" );
//     else if( $firstchorusstart < 60  )
// 	db_query( "update songs set FirstChorusDescr = 'Moderately Late' where id = $frow[songid]" );
//     else
// 	db_query( "update songs set FirstChorusDescr = 'Late' where id = $frow[songid]" );
// }



// OutroLengthRangeNums
    // this is a description of how LONG the outro is      

// SongLengthRange
    // start these are general updates
$arr = db_query_array( "select distinct( subgenreid ) from song_to_subgenre where songid = '$songid' and type = 'Main' ", "subgenreid", "subgenreid" );
$autocalcvalues["SubgenresHard"] = "," . implode( ",", $arr ) . ",";

$arr = db_query_array( "select distinct( influenceid ) from song_to_influence where songid = '$songid' and type = 'Main' ", "influenceid", "influenceid" );
$autocalcvalues["InfluencesHard"] = "," . implode( ",", $arr ) . ",";

$arr = db_query_array( "select distinct( lyricalthemeid ) from song_to_lyricaltheme where songid = '$songid' ", "lyricalthemeid", "lyricalthemeid" );
$autocalcvalues["LyricalThemesHard"] = "," . implode( ",", $arr ) . ",";


//$autocalcvalues["NumberOfWeeksSpentInTheTop10"] = db_query_first_cell( "select count(*) from song_to_weekdate where songid = $songid" );    

$tmpstr = "";
foreach( $autocalcvalues as $colname => $val )
{
    if( $tmpstr ) $tmpstr .= ", ";
    $tmpstr .= " $colname = '$val'";
}
db_query( "update songs set $tmpstr where id = $songid" ); 



//db_query( "update songs set MajorMinor = 'Major' where id in ( select songid from song_to_songkey where NameHard like '%Major%' ) and id = $songid" );
//db_query( "update songs set MajorMinor = 'Minor' where id in ( select songid from song_to_songkey where NameHard like '%Minor%' ) and id = $songid" );



?>
