<?
    // [song id] => 0
$artist = $data[0];
// $fullnamearr = explode( ".", $fullname );
// $artist = $fullnamearr[0];
// $songname = $fullnamearr[1];
$songname = $data[1];

$songid = db_query_first_cell( "select songs.id from songs, songnames where songnameid = songnames.id and Name = '" . escMe( $songname ).  "' and ArtistBand = '" . escMe( $artist ).  "'" );

if( !$songid )
    {
	$songnameid = getOrCreate( "songnames", $songname );
	$songid = db_query_insert_id( "insert into songs( SongNameHard, ArtistBand, songnameid ) values ( '" . escMe($songname) . "','" . escMe($artist) . "', $songnameid ) " );
    }

$toupdate = array();
    // [Song Form] => 1
$toupdate["MyPartID"] = getData( "MyPart_id" );
$toupdate["BillboardName"] = getData( "BillboardTitle" );
$toupdate["BillboardArtistName"] = getData( "BillboardArtist" );

$dbsongid = db_query_first_cell( "select id from dbi360_admin.songs where BillboardArtistName = ". $toupdate["BillboardArtistName"] . " and BillboardName = ". $toupdate["BillboardName"] . " " );

if( $dbsongid )
    {
	$toupdate["HSDsongid"] = $dbsongid;
    }

$toupdate["SongForm"] = getData( "Song Form" );
$toupdate["IsActive"] = 1;
$toupdate["SongStructure"] = getData( "Song Form" );
$toupdate["PreChorusSectionLyrics"] = getData( "Pre-Chorus Section Lyrics" );
$toupdate["Tempo"] = getData( "Tempo" );
$toupdate["SongLength"] = getTimeData( "Song Length" );
    // [Vocals vs. Instruments Prevalence] => 4
$toupdate["VocalsInstrumentsPrevalence"] = getData( "Vocal vs. Instrumental Prevalence" );
    // [First Section Type] => 5
 $toupdate["FirstSectionType"] = getData( "First Section Type" );
 $toupdate["IntroLength"] = getTimeData( "Intro Length" );

$toupdate["IntroVocalVsInst"] = getData( "Intro (Instrumental, Vocal)" );
if( $toupdate["IntroVocalVsInst"] == "'Instrumental Intro'" )
    $toupdate["IntroVocalVsInst"] = "'Instrumental Only'";
if( $toupdate["IntroVocalVsInst"] == "'Vocal Intro'" )
    $toupdate["IntroVocalVsInst"] = "'Vocal Only'";
if( $toupdate["IntroVocalVsInst"] == "'No Intro'" )
    $toupdate["IntroVocalVsInst"] = "NULL";

    // [Verse Count] => 8
$toupdate["VerseCount"] = getData( "Verse Count" );
if( $toupdate["VerseCount"] == "NULL" )
    $toupdate["VerseCount"] = "0";
    // [Use Of A Pre-Chorus] => 9
// $toupdate["UseOfAPreChorus"] = getData( "Use Of A Pre-Chorus" );
//     // [Pre-Chorus Count] => 10
$toupdate["PrechorusCount"] = getData( "Pre-Chorus Count" );
if( $toupdate["PrechorusCount"] == "NULL" )
    $toupdate["PrechorusCount"] = "0";
    
    // [Chorus Preceding First Verse] => 11
$toupdate["ChorusPrecedesVerse"] = getData( "Ch Precedes any Section" );
    // [Chorus Count] => 12
$toupdate["ChorusCount"] = getData( "Chorus Count" );
if( $toupdate["ChorusCount"] == "NULL" )
    $toupdate["ChorusCount"] = "0";

    // [First Chorus: Average Time Into Song] => 13
$toupdate["FirstChorusTimeIntoSong"] = getTimeData( "First Chorus: Time Into Song" );
// //echo( "first chorus: " . $data[13] . "<Br>");
//     // [First Chorus: Average Percent Into Song] => 14
// $toupdate["FirstChorusPercent"] = getData( "First Chorus: Average Percent Into Song", true );
//     // [Use Of A Vocal Post-Chorus] => 15
// $toupdate["UseOfAVocalPostChorus"] = getData( "Use Of A Vocal Post-Chorus" );
//     // [Vocal Post-Chorus Count] => 16
$toupdate["VocalPostChorusCount"] = getData( "Vocal Post-Chorus Count" );
    // [Use Of A Bridge] => 17
$toupdate["UseOfABridge"] = getData( "Departure Section" );
    // [Last Section Type] => 18
$toupdate["LastSectionType"] = getData( "Last Section Type" );
    // [Average Outro Length] => 19
$toupdate["OutroLength"] = getTimeData( "Outro Length" );
    // [Outro Instrumental, Vocal or Instrumental & Vocal] => 20
$toupdate["OutroVocalVsInst"] = getData( "Outro (Instrumental, Vocal)" );
if( $toupdate["OutroVocalVsInst"] == "'Instrumental Outro'" )
    $toupdate["OutroVocalVsInst"] = "'Instrumental Only'";
if( $toupdate["OutroVocalVsInst"] == "'Vocal Outro'" )
    $toupdate["OutroVocalVsInst"] = "'Vocal Only'";
if( $toupdate["OutroVocalVsInst"] == "'No Outro'" )
    $toupdate["OutroVocalVsInst"] = "NULL";

    // [Amount of Distinct Parts] => 21
$toupdate["SectionCount"] = getData( "Number of Distinct Sections" );

    // [Melodic Interval Prevalence] => 23
$exp = explode( ",", $data[$headerrow["Melodic Interval Prevalence"]] );
$cd = "";
foreach( $exp as $e )
{
    $e = trim( $e );
    if( !$e ) continue;
    if( $cd )
	$cd .= ","; 
    $cd .= "$e";
}

$toupdate["MelodicIntervalPrevalence"] = $cd?"'$cd'":"NULL";    

    // [Main Melodic Range] => 24
$toupdate["MainMelodicRangeNum"] = getData( "Main Melodic Range (tones)" );
$toupdate["MainMelodicRange"] = getData( "Main Melodic Range" );
    // [Melodic Theme Repetitions (Amount of Themes In Song)] => 25
$toupdate["NumMelodicThemes"] = getData( "Number of Melodic Themes" );

    // [Key] => 26
$toupdate["KeyMajor"] = getData( "Key" );
$key = getData( "Key" );
$key = str_replace( "'", "", $key );
$key = str_replace( "Major", "", $key );
$key = trim( str_replace( "Minor", "", $key ) );
$key = array_shift( explode( " ", $key ) );
$keyid = getIdByName( "songkeys", $key ); 
           db_query( "delete from song_to_songkey where songid = $songid" );
if( $keyid )
    {
	db_query( "insert into song_to_songkey ( songid, songkeyid, type, NameHard ) values ( '$songid', '$keyid', ". getData( "Key (Major, Minor, Major Mode, Minor Mode)" ) . ", " . getData( "Key" ) . " )" );
    }

    // [Key (Major, Minor, Major Mode, Minor Mode)] => 27
$toupdate["SpecificMajorMinor"] = getData( "Key (Major, Minor, Major Mode, Minor Mode)" );
    // [Is Tonal Parallel Mixture] => 28
$toupdate["UseofParallelMode"] = getData( "Use of Parallel Mode" );
    // [%Diatonic Chords] => 31
$toupdate["PercentDiatonicChords"] = getData( "%Diatonic Chords", 1 );
    // [Unique Chords Richness] => 32
// db_query( "alter table songs drop UniqueChordRichness" );
// db_query( "alter table songs add ChordRepetition decimal( 12, 10 )" );
$toupdate["ChordRepetition"] = getData( "Chord Repetition" );
    // [Triad Chord Richness] => 33

// db_query( "alter table songs drop TriadChordRichness, drop Major7thPrevalance, drop SeptachordPrevalance, drop DetailedExperiencesvsAbstract, drop NewWordInterval" );
// db_query( "alter table songs add UseOfTriads decimal( 12, 10 )" );
// db_query( "alter table songs drop InvertedChordPrevalance" );
// db_query( "alter table songs add UseOfInvertedChords decimal( 12, 10 )" );
// db_query( "alter table songs add AverageWordRepetition  decimal( 12, 10 )" );
// db_query( "alter table songs add LiteralExperiencesvsAbstract varchar( 255 )" );
$toupdate["UseOfTriads"] = getData( "Use Of Triads", true );
    // [Inverted Chord Prevalance] => 34
$toupdate["UseOfInvertedChords"] = getData( "Use of Inverted Chords", true );
    // [Septachord Prevalance] => 35
$toupdate["UseOf7thChords"] = getData( "Use of 7th Chords", true );
    // [Major 7th Prevalance] => 36
$toupdate["UseOfMajor7thChords"] = getData( "Use of Major 7th Chords", true );
    // [Chord Degree Prevalence (%I degree Chords, %II, %III, %IV, %V, %VI, %VII)] => 37

$exp = explode( ",", $data[$headerrow["Chord Degree Prevalence"]] );
$cd = "";
foreach( $exp as $e )
{
    $e = trim( $e );
    if( !$e ) continue;
    if( $cd )
	$cd .= ","; 
    $cd .= "$e";
}

$toupdate["ChordDegreePrevalence"] = $cd?"'$cd'":"NULL";    
    // [Timbre] => 38
$toupdate["Timbre"] = getData( "Timbre" );
    // [Acoustic vs Electronic] => 39
$toupdate["ElectricVsAcoustic"] = getData( "Predominantly Acoustic vs Electronic" );
    // [Dominant Instruments] => 40
// $exp = explode( ",", $data[$headerrow["Dominant Instruments"]] );
// foreach( $exp as $e )
// {
//     $e = trim( $e );
//     if( !$e ) continue;
//     $lid = getOrCreate( "instruments", $e );
//     db_query( "insert into song_to_instrument ( songid, instrumentid ) values ( '$songid', '$lid' )" );
// }
//     // [Prominent Instruments] => 41
$exp = explode( ",", $data[$headerrow["Prominent Instruments"]] );
foreach( $exp as $e )
{
    $e = trim( $e );
    if( !$e ) continue;
    $lid = getOrCreate( "primaryinstrumentations", $e );
    db_query( "insert into song_to_primaryinstrumentation ( songid, primaryinstrumentationid ) values ( '$songid', '$lid' )" );
}
    // [Song Title Word Count] => 42
$toupdate["SongTitleWordCount"] = getData( "Song Title Word Count" );
    // [Song Title Appearances] => 43
$toupdate["SongTitleAppearances"] = getData( "Song Title Appearances" );
    // [Person References] => 44
$toupdate["PersonReferences"] = getYesNoData( "Person References" );
    // [Location References] => 45
$toupdate["LocationReferences"] = getYesNoData( "Location References" );
    // [Organization or Brand References] => 46
$toupdate["OrganizationorBrandReferences"] = getYesNoData( "Organization or Brand References" );
    // [Consumer Goods References] => 47
$toupdate["ConsumerGoodsReferences"] = getYesNoData( "Consumer Goods References" );
    // [Creative Works Titles] => 48
$toupdate["CreativeWorksTitles"] = getYesNoData( "Creative Works Title References" );
    // [Detailed Experiences vs Abstract] => 49
$toupdate["LiteralExperiencesvsAbstract"] = getData( "Literal Experiences vs. Abstract" );
    // [Lyrical Sub Themes defining Lyrical Themes] => 50
$exp = explode( ",", $data[$headerrow["Lyrical Sub Themes defining Lyrical Themes"]] );
foreach( $exp as $e )
{
    $e = trim( $e );
    if( !$e ) continue;
    $lid = getOrCreate( "lyricalsubthemes", $e );
    db_query( "insert into song_to_lyricalsubtheme ( songid, lyricalsubthemeid, type ) values ( '$songid', '$lid', 'main' )" );
    $ltid = db_query_first_cell( "select lyricalthemeid from lyricalsubthemes where id = $lid" );
    if( $ltid )
    {
	db_query( "delete from song_to_lyricaltheme where songid = '$songid' and lyricalthemeid = '$ltid'" );
	db_query( "insert into song_to_lyricaltheme ( songid, lyricalthemeid ) values ( '$songid', '$ltid' )" ); 
    }
}
//     // [Lyrical Moods] => 52
$exp = explode( ",", $data[$headerrow["Lyrical Moods"]] );
foreach( $exp as $e )
{
    $e = trim( $e );
    if( !$e ) continue;
    $lid = getOrCreate( "lyricalmoods", $e );
    db_query( "insert into song_to_lyricalmood ( songid, lyricalmoodid ) values ( '$songid', '$lid' )" );
}
    // [Words Repetition (2-4) Prevalence] => 54
$toupdate["WordsRepetitionPrevalence"] = getData( "Use of In-Line Lyric Repetition" );
    // [Line Repetition (2-4) Prevalence] => 55
$toupdate["LineRepetitionPrevalence"] = getData( "Line Repetition", true );
    // [Overall Repetitiveness] => 56
$toupdate["OverallRepetitiveness"] = getData( "Overall Repetitiveness", true );
    // [New Word Interval] => 57
$toupdate["AverageWordRepetition"] = getData( "Average Word Repetition (Full Song)" );
    // [1,000 Common Words Prevalence] => 58
$toupdate["ThousandWordsPrevalence"] = getData( "Common Words Prevalence 1k", true );
    // [10,000 Common Words Prevalence] => 59
$toupdate["TenThousandWordsPrevalence"] = getData( "Common Words Prevalence 10k", true );
    // [50,000 Common Words Prevalence] => 60
$toupdate["FiftyThousandWordsPrevalence"] = getData( "Common Words Prevalence 50k", true );
    // [%Slang Words] => 61
$toupdate["SlangWords"] = getData( "%Slang Words", true );
    // [%Abbreviations] => 62
$toupdate["PercentAbbreviations"] = getData( "%Abbreviations", true );
    // [%Non Dictionary Words] => 63
$toupdate["PercentNonDictionary"] = getData( "%Non Dictionary Words", true );
    // [%Profanity Words] => 64
$toupdate["PercentProfanity"] = getData( "%Profanity Words", true );
    // [Consonance Alliteration Score] => 65
$toupdate["ConsonanceAlliterationScore"] = getData( "Average Consonance Alliteration" );
    // [Assonance Alliteration Score] => 66
$toupdate["AssonanceAlliterationScore"] = getData( "Average Assonance Alliteration" );
    // [Rhyme Density] => 67
$toupdate["RhymeDensity"] = getData( "Rhyme Density", true );
    // [Rhymes Per Syllable] => 68
$toupdate["RhymesPerSyllable"] = getData( "Percentage of Rhyming Syllables", true );
    // [Rhymes Per Line] => 69
$toupdate["RhymesPerLine"] = getData( "Average Rhymes per Line" );
    // [Number Of Rhyme Groups In The Song By ELR] => 70
$toupdate["NumberOfRhymeGroupsELR"] = getData( "Number Of Rhyme Groups In The Song By ELR", true );
    // [End Line Perfect Rhymes Percentage] => 71
$toupdate["EndLinePerfectRhymesPercentage"] = getData( "End-of-Line Perfect Rhyme Percentage", true  );
    // [End Line Secondary Perfect Rhymes Percentage] => 72
$toupdate["EndLineSecondaryPerfectRhymesPercentage"] = getData( "End-of-Line Secondary Perfect Rhyme Percentage", true ); 
    // [End Line Assonance Rhyme Percentage] => 73
$toupdate["EndLineAssonanceRhymePercentage"] = getData( "End-of-Line Assonance Rhyme Percentage", true );
    // [End Line Consonance Rhyme Percentage] => 74
$toupdate["EndLineConsonanceRhymePercentage"] = getData( "End-of-Line Consonance Rhyme Percentage", true ); 
    // [Perfect Rhymes Percentage] => 75
$toupdate["PerfectRhymesPercentage"] = getData( "Perfect Rhyme Percentage", true );
    // [Secondary Perfect Rhymes Percentage] => 76
$toupdate["SecondaryPerfectRhymesPercentage"] = getData( "Secondary Perfect Rhyme Percentage", true );
    // [Assonance Rhyme Percentage] => 77
$toupdate["AssonanceRhymePercentage"] = getData( "Assonance Rhyme Percentage", true );
    // [Consonance Rhyme Percentage] => 78
$toupdate["ConsonanceRhymePercentage"] = getData( "Consonance Rhyme Percentage", true );
    // [End Of Line Rhymes Percentage] => 79
$toupdate["EndOfLineRhymesPercentage"] = getData( "End-of-Line Rhyme Percentage", true );
    // [Mid Line Rhymes Percentage] => 80
$toupdate["MidLineRhymesPercentage"] = getData( "Mid-Line Rhyme Percentage", true );
    // [Internal Rhymes Percentage] => 81
$toupdate["InternalRhymesPercentage"] = getData( "Internal Rhyme Percentage", true );
    // [Mid Word Rhymes] => 82
$toupdate["MidWordRhymes"] = getData( "Mid-Word Rhyme Percentage", true );
    // [Amount of words / Length of song] => 83
// db_query( "alter table songs drop AmountDividedByLength" );
// db_query( "alter table songs add LyricalDensity decimal( 12, 10 )" );
$toupdate["LyricalDensity"] = getData( "Lyrical Density" );

    // [Words Per Line Avg] => 84
$toupdate["WordsPerLineAvg"] = getData( "Average Number of Words per Line" );
    // [Primary Genre] => 85

//     // [Average Intro Length] => 6
// $toupdate["AverageIntroLength"] = getData( "Average Intro Length" );
//     // [Intro Instrumental, Vocal or Instrumental & Vocal] => 7
//    [Production Mood] => 78
if( $data[$headerrow["Primary Genre"]] )
    $toupdate["GenreID"] = getOrCreate( "genres", $data[$headerrow["Primary Genre"]] );
    // [Sub-Genres & Influences] => 86
//echo( "subgenres were ".getData(  ) . "<br>" );
addOtherTableToSong( $songid, "Sub-Genres", "subgenre", "Main" );
addOtherTableToSong( $songid, "Influences", "influence", "Main" );

$exp = explode( ",", $data[$headerrow["Production Mood"]] );
$cd = "";
foreach( $exp as $e )
{
    $e = trim( $e );
    if( !$e ) continue;
    if( $cd )
	$cd .= ","; 
    $cd .= "$e";
}

$toupdate["ProductionMood"] = $cd?"'$cd'":"NULL";    

//    [Danceability] => 79
$toupdate["Danceability"] = getData( "Danceability", true );
	//db_query( "alter table songs add Danceability decimal( 12, 10 )" );
//    [Loudness Range] => 80
	//db_query( "alter table songs add LoudnessRange decimal( 12, 10 )" );
$toupdate["Loudness"] = getData( "Loudness Range" );


    // [Aggressive] => 87
    // [Happy] => 88
    // [Party] => 89
    // [Relaxed] => 90
    // [Melancholic] => 91
    // [Danceability] => 92
    // [Loudness Range] => 93
$tmpstr = "";
foreach( $toupdate as $colname => $val )
{
    if( $tmpstr ) $tmpstr .= ", ";
    $tmpstr .= " $colname = $val";
    //echo( "update songs set $colname = $val where id = $songid<br>" ); 
}
db_query( "update songs set $tmpstr where id = $songid" ); 

include "ccautocalc.php";

$artist = $toupdate["BillboardArtistName"];
$songname = $toupdate["BillboardName"];
//echo( "<a target=_blank href='editsong.php?songid=$songid'>$artist $songname</a><br>" );


?>
