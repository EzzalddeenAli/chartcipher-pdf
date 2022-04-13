<?php
require_once "constants.php";
require_once "amember4/amember4.php";
$minweeksvalues = array( "1-1"=>"1 Week", "1-5"=>"5 Weeks or Less", "1-10"=>"10 Weeks or Less", "10"=>"10 Weeks or More", "20"=>"20 Weeks or More", "30"=>"30 Weeks or More" );
$api = am4PluginsManager::getAPI();
$user = am4PluginsManager::getAPI()->getUser();
$access = Am_Lite::getInstance()->getAccess();
//echo( "access: " ); print_r( $access );
//echo( "user: " ); print_r( $user );exit;
// print_r( $_COOKIE );
// exit;
$expanderdefaultclass = "collapse-btn"; // or blank
$openeddefaultclass = ""; // class="hide"
define( 'ALLSEASONS24', '1,2,3,4' );
define( 'ALLSEASONS', '4,1,2,3' );
//define( 'FALLWINTER', '4,1' );
//define( 'SPRINGSUMMER', '2,3' );
define( 'WINTERCOMPARISON', '1,1' );
define( 'SUMMERCOMPARISON', '3,3' );
define( 'FALLCOMPARISON', '4,4' );
define( 'SPRINGCOMPARISON', '2,2' );
$seasonswithall = array( WINTERCOMPARISON=>"Winter", SPRINGCOMPARISON => "Spring", SUMMERCOMPARISON=> "Summer", FALLCOMPARISON=> "Fall" );
$seasons = $seasonswithall; 

//$clientwhere = $_SESSION["loggedin"]?" IsActive = 1 ":"IsActive = 1 and ( songs.ClientID is null or songs.ClientID = 0 )";

$clientwhere = "IsActive = 1";
if( $searchclientid )
{
	$clientwhere = " songs.Clientid = $searchclientid";
}
if( $get )
    {
    print_r( $_COOKIE );exit;
    }
$GLOBALS["clientwhere"] = $clientwhere;
if( !$chartid ) 
    $chartid = 37; 

if( $chartid != 37 )
    {
	$peakvalues = array( "10"=>"Top 10");
    }
else
    $peakvalues = array( "25"=>"Top 25", "50"=>"Top 50");


$clientwhere .= " and find_in_set( $chartid, chartids )";

$chartname = db_query_first_cell( "select Name from charts where id = $chartid" );

$anyokay = false;
foreach( $access as $a )
{
    if( strtotime( $a["expire_date"] ) > time()  && strtotime( $a["begin_date"] ) < time() )
        $anyokay = true;
}
//    print_r( $access );
//    exit;
if( $_SERVER[REMOTE_ADDR] == "76.198.132.181" )
    $anyokay = 1;
if( $nouserrequired )
    {
	$anyokay = true; 
	// this is for the sitemap and the song pages
    }

if( $_SESSION["origurl"] )
{
    $orig = $_SESSION["origurl"];
    unset( $_SESSION["origurl"] );
    Header( "Location: $orig" );
    exit;
}

//echo( "access: " ); print_r( $access );
//echo( "user: " ); print_r( $user );exit;
//print_r( $_COOKIE ); exit;

//$anyokay = true;
if( !$anyokay && !$_GET["forcelogin"] )
{
//echo( is_una() );exit;
// echo( "access: " ); print_r( $access );
// echo( "user: " ); print_r( $user );exit;
//print_r( $access );
//exit;
//    print_r( $_SERVER );exit;
    $_SESSION["origurl"] = $_SERVER["REQUEST_URI"];
    if( isAutomaticLogin() && !$user )
        Header( "Location: https://editorial.chartcipher.com/members?goimmersion=1" );
    else if( isAutomaticLogin() )
        Header( "Location: https://editorial.chartcipher.com/" );
    else
        Header( "Location: https://editorial.chartcipher.com/members/login?help" );
    
    exit;
}

//print_r( $user );

// echo("<br>" );

// echo( "cla?". $user[user_id] . "<br>" );
//if( !$api->isLoggedin() )
// {
//    echo( "not logged in to amember?". $api->isLoggedIn() );
// }
//    print_r( $user );
// exit;
//
$isstudent = isset( $_COOKIE["proxylogintype"] ) && $_COOKIE["proxylogintype"] == "student";
//$isstudent = false;
//print_r( $_COOKIE );


// we're not doing this anymore
// if( isAutomaticLogin( $_SERVER["REMOTE_ADDR"] ) ) {
//     if( !$_COOKIE["proxylogintype"] && !$choosing )
//     {
//         if( is_berklee() )
//             Header( "Location: subscriber-type.php" );
//         else
//             Header( "Location: generic-login.php" );
//     }
// }

if( $_GET["proxylogout"] )
{
    setcookie( "proxylogintype", 0, time() -1);
    setcookie( "proxyloginid", 0, time() -1 );
    Header( "Location: index.php" );
}



$proxyloginid = is_numeric( $_COOKIE["proxyloginid"] )?$_COOKIE["proxyloginid"]:"" ;
$userid = $user["user_id"];
//echo( $userid );
if( $_GET["forcelogin"] || !$userid )
{
    setcookie( "mytemplogin", 9571 );
    $userid = 9571;
}
else if( !$userid )
{
    $userid = $_COOKIE["mytemplogin"];
}
//echo( $userid );exit;
$nologinrequired = 1;
if( !$nologinrequired && !$_COOKIE["mytemplogin"] )
{
    if( !$userid )
    {
        // echo( "notok" );
        // print_r( $_COOKIE );
        Header( "Location: https://editorial.chartcipher.com/members/login/index?goimmersion=1" );
        exit;
    }
    $ok = false;
    $access = Am_Lite::getInstance()->getAccess();
    $immersionprods = Am_Lite::getInstance()->getCategoryProducts( 27 );
    $allimmersionprods = array();
    $bothimmersionprods = array();
    foreach( $immersionprods as $i )
    {
        $allimmersionprods[$i] = $i;
        $bothimmersionprods[$i] = $i; 
    }
    
    
    $ok = count( getMyImmersionProducts() );
    if( $ispdf )
    {
	if( !$ok && !hasWorkshopAccess()  )
	    {
		//        echo( "notok" );
		Header( "Location: https://editorial.chartcipher.com/members/login/index" );
		exit;
	    }
    }
    else if( !$ok )
    {
//        echo( "notok" );
        Header( "Location: https://editorial.chartcipher.com/members/login/index" );
        exit;
    }
    
}

    // if( !isset( $_COOKIE["hasreports"] ) || 1)
    // {
    //     $hasreports = hasReportsAccess();
    //     setcookie( "hasreports", $hasreports, time() + 90000000, "/", ".chartcipher.com" );
    //     $_COOKIE = $hasreports;
    // }
    // else
    // {
    //     $hasreports = $_COOKIE["hasreports"];
    // }
//if( $_GET["hmm"] ) echo( "<br>has: $hasreports<br>" );
function getAllAmemberProducts()
{
    return Am_Lite::getInstance()->getProducts();
    
}
function getMyImmersionProducts()
{
    global $api, $user;
    $access = Am_Lite::getInstance()->getAccess();
    $immersionprods = Am_Lite::getInstance()->getCategoryProducts( 27 );
    $allimmersionprods = array();
    foreach( $immersionprods as $i )
    {
        $allimmersionprods[$i] = $i;
    }
    
    $myprods = array();
    // if( $_GET["help"] )
    // 	{
    // 	    print_r( $access );
    // 	    exit;
    // 	}
    foreach( $access as $a )
    {
        if( strtotime( $a["begin_date"] ) > time() ) continue;
        if( strtotime( $a["expire_date"] ) < time() ) continue;
        if( strtotime( $a["begin_date"] ) > time() ) continue;
        if( isset( $allimmersionprods[$a["product_id"]] ) )
            $myprods[] = $a;
    }
    return $myprods;

}
if( $_GET["help"] )
    {
	// print_r( $_SERVER );
	// exit;
    }

$myisessentials = -1;

function isEssentials()
{
    global $api, $user , $myisessentials;
    if( $myisessentials == -1 )
	{
	    $access = Am_Lite::getInstance()->getAccess();
	    if( $_GET["hmm"] )
		{
		    //		    echo( "mine:" );
		    //		    print_r( $access );
		}
	    $allimmersionprods = array();
	    $immersionprods = Am_Lite::getInstance()->getCategoryProducts( 24 );
	    foreach( $immersionprods as $i )
		{
		    $allimmersionprods[$i] = $i;
		}
	    
	    $immersionprods = Am_Lite::getInstance()->getCategoryProducts( 25 );
	    foreach( $immersionprods as $i )
		{
		    $allimmersionprods[$i] = $i;
		}
	    
	    $myprods = array();
	    foreach( $access as $a )
		{
		    if( strtotime( $a->expire_date ) > time() )
			{
			    if( isset( $allimmersionprods[$a["product_id"]] ) )
				$myprods[] = $a;
			}
		}
	    if( $_GET["hmm"] ) echo( "<Br><br>count is : " . count( $myprods ) );
	    $myisessentials = count( $myprods );
	}
    return $myisessentials?true:false;

}
function isTrendReportDownload()
{
    global $api, $user , $myisessentials;
    if( $myisessentials == -1 )
	{
	    $access = Am_Lite::getInstance()->getAccess();
	    if( $_GET["hmm"] )
		{
		    //		    echo( "mine:" );
		    //		    print_r( $access );
		}
	    $allimmersionprods = array();
	    $immersionprods = Am_Lite::getInstance()->getCategoryProducts( 11 ); // all premiere
	    foreach( $immersionprods as $i )
		{
		    $allimmersionprods[$i] = $i;
		}
	    $immersionprods = Am_Lite::getInstance()->getCategoryProducts( 2 ); // all pro
	    foreach( $immersionprods as $i )
		{
		    $allimmersionprods[$i] = $i;
		}
	    
	    $immersionprods = Am_Lite::getInstance()->getCategoryProducts( 19 ); // reports
	    foreach( $immersionprods as $i )
		{
		    $allimmersionprods[$i] = $i;
		}
	    
	    $myprods = array();
	    foreach( $access as $a )
		{
		    if( strtotime( $a->expire_date ) > time() )
			{
			    if( isset( $allimmersionprods[$a["product_id"]] ) )
				$myprods[] = $a;
			}
		}
	    if( $_GET["hmm"] ) echo( "<Br><br>count is : " . count( $myprods ) );
	    $myisessentials = count( $myprods );
	}
    return $myisessentials?true:false;

}

function getDisplaySongSectionValue( $songid, $column, $type = "enum" )
{
    $outval = array();
    if( $type == "enum" )
        $poss = getEnumValues( "$column", "song_to_songsection" );
    else
        $poss = getSetValues( "$column", "song_to_songsection" );
        
    foreach( $poss as $p )
    {
        $any = db_query_array( "select Name from song_to_songsection, songsections where songsectionid = songsections.id and $column like '%$p%' and songid = '$songid' order by starttime", "Name", "Name" );
        if( count( $any ) )
            $outval[] = $p . " (<i>" . implode( ", " , $any )  . "</i>)";
    }
    return implode( ", ", $outval ); 
    
}

function getDisplaySongSectionValueOtherTable( $songid, $othertable )
{
    $outval = array();
    $poss = db_query_array( "select id, Name from {$othertable}s ","id", "Name" );
        
    foreach( $poss as $pid=>$pval )
    {
        $any = db_query_array( "select Name from song_to_songsection sts, songsections, song_to_{$othertable} sto where sts.songsectionid = songsections.id and {$othertable}id = $pid and sts.songid = '$songid' and sto.songid = sts.songid and type = songsectionid order by starttime", "Name", "Name" );
//        echo( "select Name from song_to_songsection sts, songsections, song_to_{$othertable} sto where sts.songsectionid = songsections.id and {$othertable}id = $pid and sts.songid = '$songid' and sto.songid = sts.songid and type = songsectionid order by starttime" );
        if( count( $any ) )
            $outval[] = $pval . " (<i>" . implode( ", " , $any )  . "</i>)";
    }
    return implode( ", ", $outval ); 
    
}

function getFiveValuesSection( $displ )
{
    $fivevalues = array();
    if( $displ == "Inst Break" )
        $displ = "Instrumental Break";
    if( $displ == "Instrumental Break" ) 
        $fivevalues[ "-1"] = "Does not contain an $displ";
    else 
        $fivevalues[ "-1"] = "Does not contain a $displ";
    $plurdispl = $displ . "s";
    if( strpos( $displ, "Chorus" ) !== false )
    {
    $plurdispl = $displ . "es";

    }
    $fivevalues[ "-2"] = "One or more {$plurdispl}";
    $max = 5;
    if( $displ == "Chorus" )
        $max = 7;
    for( $i = 1; $i <= $max; $i++ )
    {
        $k = $i . " " . $displ;
        if( $i > 1 )
            $k .=  " Sections";
        $fivevalues[$i] = $k;
    }
    return $fivevalues;
}
function getLengthUniformity( $displ )
{
    $fivevalues = array();
    $fivevalues["1"] = "All $displ lengths are the same";
    $fivevalues["2"] = "All or some of the $displ lengths differ";
    $fivevalues["-1"] = "Does not contain a $displ";
    return $fivevalues;
}

    $years = array();
    
$GLOBALS["firstyear"] = $earliesty;

    for( $i = $GLOBALS["firstyear"]; $i <= date( "Y" ); $i++ ) 
        $years["$i"] = "$i";

    $quarters = array();
    for( $i = 1; $i <= 4; $i++ ) 
        $quarters["$i"] = "Q$i";

    // $grouptypes = array( "writer"=> array( "artist", "creditedsw" ) );
    // $grouptypes["primaryartist"] = array( "artist", "primary" );
    // $grouptypes["featuredartist"] = array( "artist", "featured" );
    // $grouptypes["producer"] = array( "producer", "" );
    // $grouptypes["primaryartistfeatured"] = array( "artist", "featured" );
    // $grouptypes["primaryartistprimary"] = array( "artist", "primary" );

    $singlecolumnfields = array();
    $singlecolumnfields["songtitleappearancecount"] = "SongTitleAppearanceRange";
    $singlecolumnfields["bpm"] = "Tempo";
    $singlecolumnfields["exactbpm"] = "Tempo";
    $singlecolumnfields["introlengthrange"] = "IntroLengthRange";
    $singlecolumnfields["influencecount"] = "InfluenceCount";
    $singlecolumnfields["introlengthrangenums"] = "IntroLengthRangeNums";
    $singlecolumnfields["sectioncounts"] = "NumSections";
    $singlecolumnfields["RecycledSections"] = "RecycledSections";
    $singlecolumnfields["percentoftotal"] = "PercentOfSong";
    $singlecolumnfields["uniformity"] = "LengthsSame";
    $singlecolumnfields["vocalsgender"] = "songs.VocalsGender";


$searchcolumnsdisplay = array();
$searchcolumnsdisplay["season"] = "Season";
$searchcolumnsdisplay["primaryartist"] = "Primary Artist";
$searchcolumnsdisplay["primaryartistprimary"] = "Primary Artist";
$searchcolumnsdisplay["primaryartistfeatured"] = "Featured Artist";
$searchcolumnsdisplay["ArtistBand"] = "Artist";
$searchcolumnsdisplay["Tempo Range General"] = "Tempo Range (Broad)";
//$searchcolumnsdisplay["GenreID"] = "Primary Genre";
$searchcolumnsdisplay["ArtistGenreID"] = "Artist Genre";
$searchcolumnsdisplay["TotalCount"] = "Total Team Size";
//$searchcolumnsdisplay["GenreName"] = "Primary Genre";
$searchcolumnsdisplay["timesignatureid"] = "Time Signature";
$searchcolumnsdisplay["label"] = "Record Label";
$searchcolumnsdisplay["labelid"] = "Record Label";
$searchcolumnsdisplay["vocaldeliverytype"] = "Vocal Delivery Type";


$searchcolumnsdisplay["vocaldelivery"] = "Vocal Delivery";
$searchcolumnsdisplay["svsmult"] = "Solo vs Multiple Artists";
$searchcolumnsdisplay["svsmultlead"] = "Solo vs Multiple Lead Vocalists";
$searchcolumnsdisplay["CreditType"] = "Credit Type";
$searchcolumnsdisplay["vocalsgenderspecific"] = "Lead Vocal Gender";


$searchcolumnsdisplay["ElectricVsAcoustic"] = "Electronic vs. Acoustic Instrumentation";
// $searchcolumnsdisplay["writer"] = "Songwriter";
// $searchcolumnsdisplay["producer"] = "Producer";
// $searchcolumnsdisplay["producerid"] = "Producer";
// $searchcolumnsdisplay["writerid"] = "Songwriter";
// $searchcolumnsdisplay["artistid"] = "Artist";
// $searchcolumnsdisplay["artistorwriter"] = "Artist/Writer";
// $searchcolumnsdisplay["artistorwriterorproducer"] = "Artist/Writer/Producer";
// $searchcolumnsdisplay["groupid"] = "Group";
// $searchcolumnsdisplay["othergroupid"] = "Group";
// $searchcolumnsdisplay["songname"] = "Song Title";
$searchcolumnsdisplay["postchorus"] = "Contains Post-Chorus";
$searchcolumnsdisplay["postchorussections"] = "Contains Post-Chorus Of Type";
$searchcolumnsdisplay["bridgesurrogatesections"] = "Contains Bridge Surrogate Of Type";
$searchcolumnsdisplay["InstOrVocal"] = "Contains an Instrumental or Vocal Break";
$searchcolumnsdisplay["peakchart"] = "Peak Chart Position";
$searchcolumnsdisplay["TempoRange"] = "Tempo";
$searchcolumnsdisplay["FeaturedGender"] = "Featured Artist Gender";
$searchcolumnsdisplay["PrimaryGender"] = "Primary Artist Gender (Female if any primary artist is female)";
$searchcolumnsdisplay["VerseCount"] = "Verse Count";
$searchcolumnsdisplay["VocalPostChorusCount"] = "Vocal Post-Chorus Count";
$searchcolumnsdisplay["ChorusCount"] = "Chorus Count";
$searchcolumnsdisplay["peakwithin"] = "Peak Chart Position";
$searchcolumnsdisplay["vocalsgender"] = "Vocal Gender";
$searchcolumnsdisplay["solovsduet"] = "Solo vs. Multiple Lead Vocalists";
//$searchcolumnsdisplay["GenreFusionType"] = "Sub-Genre Fusion Type";

$searchcolumnsdisplay["dates"] = "Chart Dates";
$searchcolumnsdisplay["songtitleappearancecount"] = "Song Title Appearance Count";
$searchcolumnsdisplay["introlengthrange"] = "Intro Length";
$searchcolumnsdisplay["influencecount"] = "Genre/Influence Count";
$searchcolumnsdisplay["introlengthrangenums"] = "Intro Length";
$searchcolumnsdisplay["FirstSectionType"] = "First Section";
$searchcolumnsdisplay["FirstChorusBreakdown"] = "First Chorus: Breakdown Arrangement";
$searchcolumnsdisplay["SongTitleAppearanceRange"] = "Song Title Appearances";
$searchcolumnsdisplay["FirstChorusRange"] = "First Chorus (Time)";
$searchcolumnsdisplay["OutroLengthRangeNums"] = "Outro Length (Time)";
$searchcolumnsdisplay["ChorusPrecedesVerse"] = "Chorus Precedes Any Section";
$searchcolumnsdisplay["mainartisttype"] = "Artist Type";
$searchcolumnsdisplay["mainlabeltype"] = "Label Type";
$searchcolumnsdisplay["artistinlast"] = "Artist Type";
$searchcolumnsdisplay["primaryartistinlast"] = "Primary Artist Type";
$searchcolumnsdisplay["timesignatureid"] = "Time Signature";
$searchcolumnsdisplay["songkeyid"] = "Key";
$searchcolumnsdisplay["KeyMajor"] = "Key";
$searchcolumnsdisplay["SpecificMajorMinor"] = "Key (Major, Minor, Major Mode, Minor Mode)";
$searchcolumnsdisplay["majorminor"] = "Major/Minor";
$searchcolumnsdisplay["LastSectionType"] = "Last Section";
$searchcolumnsdisplay["OutroRange"] = "Outro Range";
$searchcolumnsdisplay["introvocalvsinst"] = "Instrumental/Vocal Category";
$searchcolumnsdisplay["BridgeSurrCount"] = "Bridge Surrogate Count";
$searchcolumnsdisplay["FirstChorusPercentRange"] = "1st Chorus Occurence (% Into Song)";
$searchcolumnsdisplay["FirstChorusDescr"] = "1st Chorus Occurence (Time Into song)";
$searchcolumnsdisplay["OutroVocalVsInst"] = "Outro Instrumental/Vocal";
$searchcolumnsdisplay["IntroVocalVsInst"] = "Intro Instrumental/Vocal";
$searchcolumnsdisplay["endingtypes"] = "Ending Type";
$searchcolumnsdisplay["PeakPosition"] = "Peak Position";
$searchcolumnsdisplay["WeekEnteredTheTop10"] = "Week Entered the Top 10";
$searchcolumnsdisplay["NumberOfWeeksSpentInTheTop10"] = "Number Of Weeks Spent In The Top 10";
// $searchcolumnsdisplay["OutroRecycled"] = "Recycled vs. New Material";
// $searchcolumnsdisplay["containssampled"] = "Contains Sampled Material";
// $searchcolumnsdisplay["RecycledSections"] = "Outro: Recycled Section";
$searchcolumnsdisplay["fullform"] = "Structure";
$searchcolumnsdisplay["toptentype"] = "Top Ten Type";
$searchcolumnsdisplay["outrotypes"] = "Outro Characteristics";
$searchcolumnsdisplay["bridgecharacteristics"] = "Bridge Characteristics";
$searchcolumnsdisplay["postchorustypes"] = "Post-Chorus Characteristics";
$searchcolumnsdisplay["bpm"] = "BPM Range";
$searchcolumnsdisplay["exactbpm"] = "Exact BPM";
$searchcolumnsdisplay["SongTitleWordCount"] = "Song Title Word Count";
// $searchcolumnsdisplay["ProducerCount"] = "Producer Team Size";
// $searchcolumnsdisplay["LabelCount"] = "Record Label Size";
// $searchcolumnsdisplay["ArtistCount"] = "Performing Artist Team Size";
// $searchcolumnsdisplay["SongwriterCount"] = "Songwriter Team Size";
//$searchcolumnsdisplay["clevergeneric"] = "Clever/Generic";
// $searchcolumnsdisplay["notcontainssection"] = "Doesn't Contain Section";
// $searchcolumnsdisplay["containssection"] = "Contains Section(s)";
// $searchcolumnsdisplay["contains"] = "Contains Section(s)";
// $searchcolumnsdisplay["vocals"] = "Lead Vocals";
$searchcolumnsdisplay["lyricalthemes"] = "Lyrical Themes";
$searchcolumnsdisplay["lyricalsubthemes"] = "Lyrical Sub-Themes";
$searchcolumnsdisplay["lyricalmoods"] = "Lyrical Moods";
$searchcolumnsdisplay["minweeks"] = "Minimum # of Weeks on chart";
$searchcolumnsdisplay["placements"] = "Placements";
$searchcolumnsdisplay["IsRemix"] = "Song Is A Remix";
$searchcolumnsdisplay["primaryinstrumentations"] = "Instruments";
$searchcolumnsdisplay["chorustypes"] = "Chorus Types";
//$searchcolumnsdisplay["withimprint"] = "Has Imprint";
$searchcolumnsdisplay["bpchorus"] = "Contains a High Impact Chorus";
$searchcolumnsdisplay["bdfield"] = "Contains a Breakdown Segment";
$searchcolumnsdisplay["subgenres"] = "Genres";
$searchcolumnsdisplay["influences"] = "Influences";
$searchcolumnsdisplay["specificsubgenre"] = "Genre";
$searchcolumnsdisplay["specificinfluence"] = "Influence";
$searchcolumnsdisplay["newcarryfilter"] = "New Songs / Carryovers";
$searchcolumnsdisplay["specificsubgenrealso"] = "Genre";
$searchcolumnsdisplay["specificinfluencealso"] = "Influence";
$searchcolumnsdisplay["introtypes"] = "Intro Types";
$searchcolumnsdisplay["ssvocaltypes"] = "Vocals";
$searchcolumnsdisplay["numweeksinperiod"] = "Number of Weeks in Selected Time Period";
$searchcolumnsdisplay["instbrkpi"] = "Instrumental Break Dominant Instrument";
$searchcolumnsdisplay["BridgeSurrogateType"] = "Bridge Surrogate Type";
$searchcolumnsdisplay["sectioncounts"] = "Section Counts";
$searchcolumnsdisplay["percentoftotal"] = "Percent Of Total";
$searchcolumnsdisplay["IsRemix"] = "Is This Song A Remix";
$searchcolumnsdisplay["uniformity"] = "Section Uniformity";
$searchcolumnsdisplay["SongLengthRange"] = "Song Length";
$searchcolumnsdisplay["SongLengthExact"] = "Song Length";
$searchcolumnsdisplay["weekdateid"] = "Week Of";


$searchcolumnsdisplay["LyricalMoods"] = "Lyrical Moods";
$searchcolumnsdisplay["LyricalSubThemes"] = "Lyrical Sub-themes";
$searchcolumnsdisplay["ConsonanceAlliterationScore"] = "Consonance Alliteration Score";
$searchcolumnsdisplay["AssonanceAlliterationScore"] = "Assonance Alliteration Score";
$searchcolumnsdisplay["MainMelodicRange"] = "Main Melodic Range";
$searchcolumnsdisplay["PercentDiatonicChords"] = "Diatonic Chord Prevalence";
$searchcolumnsdisplay["Timbre"] = "Timbre";
$searchcolumnsdisplay["WordsRepetitionPrevalence"] = "Use of In-Line Lyric Repetition";
$searchcolumnsdisplay["LineRepetitionPrevalence"] = "Line Repetition";
$searchcolumnsdisplay["SlangWordsRange"] = "Use of Slang";
$searchcolumnsdisplay["ThousandWordsPrevalence"] = "Words Prevalence - Top 1000 Words";
$searchcolumnsdisplay["TenThousandWordsPrevalence"] = "Words Prevalence - Top 10,000 Words";
$searchcolumnsdisplay["FiftyThousandWordsPrevalence"] = "Words Prevalence - Top 10,000 Words";
$searchcolumnsdisplay["PercentAbbreviations"] = "Use of Word Abbreviations";
$searchcolumnsdisplay["PercentNonDictionary"] = "Use of Non Dictionary Words";
$searchcolumnsdisplay["RhymeDensity"] = "Rhyme Density";
$searchcolumnsdisplay["RhymesPerSyllable"] = "Percentage of Rhyming Syllables";
$searchcolumnsdisplay["RhymesPerLine"] = "Average Rhymes Per Line";
$searchcolumnsdisplay["NumberOfRhymeGroupsELR"] = "Number Of Rhyme Groups In The Song By ELR";
$searchcolumnsdisplay["VocalsInstrumentsPrevalence"] = "Vocal vs. Instrumental Prevalence";
$searchcolumnsdisplay["PersonReferences"] = "Person References";
$searchcolumnsdisplay["LocationReferences"] = "Location References";
$searchcolumnsdisplay["LocationReferencesRange"] = "Location References";
$searchcolumnsdisplay["GeneralLocationReferencesRange"] = "General Location References";
$searchcolumnsdisplay["PersonReferencesRange"] = "Location References";
$searchcolumnsdisplay["GeneralPersonReferencesRange"] = "General Person References";
$searchcolumnsdisplay["OrganizationorBrandReferences"] = "Organization or Brand References";
$searchcolumnsdisplay["ConsumerGoodsReferences"] = "Consumer Goods References";
$searchcolumnsdisplay["CreativeWorksTitles"] = "Creative Works Title References";
$searchcolumnsdisplay["EndLinePerfectRhymesPercentage"] = "Use of End-of-Line Perfect Rhymes";
$searchcolumnsdisplay["EndLineSecondaryPerfectRhymesPercentage"] = "Use of Perfect Secondary Rhymes";
$searchcolumnsdisplay["EndLineAssonanceRhymePercentage"] = "Use of End-of-Line Assonance Rhymes";
$searchcolumnsdisplay["PerfectRhymesPercentage"] = "Use of Perfect Rhymes";
$searchcolumnsdisplay["AssonanceRhymePercentage"] = "Use of Assonance Rhymes";
$searchcolumnsdisplay["ConsonanceRhymePercentage"] = "Use of Consonance Rhymes";
$searchcolumnsdisplay["EndOfLineRhymesPercentage"] = "Use of End-of-Line Rhymes";
$searchcolumnsdisplay["MidLineRhymesPercentage"] = "Use of Mid-Line Rhymes";
$searchcolumnsdisplay["InternalRhymesPercentage"] = "Use of Internal Rhymes";
$searchcolumnsdisplay["MidWordRhymes"] = "Use of Mid-Word Rhymes";
$searchcolumnsdisplay["WordsPerLineAvg"] = "Words Per Line Average";
$searchcolumnsdisplay["ChordDegreePrevalence"] = "Chord Degree Prevalence";
$searchcolumnsdisplay["PreChorusSectionLyrics"] = "Pre-Chorus Section Lyrics";
$searchcolumnsdisplay["MainMelodicRangeNum"] = "Main Melodic Range (Number)";
$searchcolumnsdisplay["UseofParallelMode"] = "Use of Parallel Mode";
$searchcolumnsdisplay["UseOfAPreChorus"] = "Use of A Pre-Chorus";
$searchcolumnsdisplay["UseOfAVocalPostChorus"] = "Use of A Vocal Post-Chorus";
$searchcolumnsdisplay["PreChorusCount"] = "Pre-Chorus Count";
$searchcolumnsdisplay["ChorusCount"] = "Chorus Count";
$searchcolumnsdisplay["VerseCount"] = "Verse Count";
$searchcolumnsdisplay["UseOfABridge"] = "Departure Section";
$searchcolumnsdisplay["ProductionMood"] = "Production Mood";
$searchcolumnsdisplay["ChordRepetition"] = "Chord Repetition";
$searchcolumnsdisplay["UseOfTriads"] = "Use Of Triads";
$searchcolumnsdisplay["UseOfInvertedChords"] = "Use Of Inverted Chords";
$searchcolumnsdisplay["AverageWordRepetition"] = "Average Word Repetition";
$searchcolumnsdisplay["LiteralExperiencesvsAbstract"] = "Literal Experiences vs. Abstract";
$searchcolumnsdisplay["LyricalDensity"] = "Lyrical Density";
$searchcolumnsdisplay["MelodicIntervalPrevalence"] = "Melodic Interval Prevalence";
$searchcolumnsdisplay["UseOf7thChords"] = "Use of Septachords";
$searchcolumnsdisplay["UseOfMajor7thChords"] = "Major 7th Prevalance";
$searchcolumnsdisplay["PercentProfanity"] = "Use of Profanity";
$searchcolumnsdisplay["EndLineConsonanceRhymePercentage"] = "End-of-Line Consonance Rhymes";
$searchcolumnsdisplay["SecondaryPerfectRhymesPercentage"] = "End-of-Line Secondary Rhymes";
$searchcolumnsdisplay["Danceability"] = "Danceability";
$searchcolumnsdisplay["FirstChorusTimeIntoSong"] = "First Chorus: Time Into Song";
$searchcolumnsdisplay["SectionCountRange"] = "Number of Distinct Sections";
$searchcolumnsdisplay["NumMelodicThemes"] = "Amount of Themes In Song";
$searchcolumnsdisplay["PercentDiatonicChordsRange"] = "Diatonic Chord Prevalence (Range)";
$searchcolumnsdisplay["ChordRepetitionRange"] = "Chord Repetition (Range)";
$searchcolumnsdisplay["UseOfTriadsRange"] = "Use Of Triads (Range)";
$searchcolumnsdisplay["UseOfInvertedChordsRange"] = "Use of Inverted Chords (Range)";
$searchcolumnsdisplay["UseOf7thChordsRange"] = "Use of Septachords (Range)";
$searchcolumnsdisplay["UseOfMajor7thChordsRange"] = "Major 7th Prevalance (Range)";
$searchcolumnsdisplay["LineRepetitionPrevalenceRange"] = "Line Repetition (Range)";
$searchcolumnsdisplay["OverallRepetitivenessRange"] = "Overall Repetitiveness (Range)";
$searchcolumnsdisplay["AverageWordRepetitionRange"] = "Average Word Repetition (Full Song)";
$searchcolumnsdisplay["ConsonanceAlliterationScoreRange"] = "Average Consonance Alliteration (Range)";
$searchcolumnsdisplay["AssonanceAlliterationScoreRange"] = "Average Assonance Alliteration (Range)";
$searchcolumnsdisplay["RhymeDensityRange"] = "Rhyme Density (Range)";
$searchcolumnsdisplay["RhymesPerSyllableRange"] = "Percentage of Rhyming Syllables (Range)";
$searchcolumnsdisplay["RhymesPerLineRange"] = "Average Rhymes per Line (Range)";
$searchcolumnsdisplay["NumberOfRhymeGroupsELRRange"] = "Number Of Rhyme Groups In The Song By ELR (Range)";
$searchcolumnsdisplay["EndLinePerfectRhymesPercentageRange"] = "Use of End-of-Line Perfect Rhymes (Range)";
$searchcolumnsdisplay["EndLineAssonanceRhymePercentageRange"] = "Use of End-of-Line Assonance Rhymes (Range)";
$searchcolumnsdisplay["PerfectRhymesPercentageRange"] = "Use of Perfect Rhymes (Range)";
$searchcolumnsdisplay["ConsonanceRhymePercentageRange"] = "Use of Consonance Rhymes (Range)";
$searchcolumnsdisplay["AssonanceRhymePercentageRange"] = "Use of Assonance Rhymes (Range)";
$searchcolumnsdisplay["EndOfLineRhymesPercentageRange"] = "Use of End-of-Line Rhymes (Range)";
$searchcolumnsdisplay["InternalRhymesPercentageRange"] = "Use of Internal Rhymes (Range)";
$searchcolumnsdisplay["MidWordRhymesRange"] = "Use of Mid-Word Rhymes (Range)";
$searchcolumnsdisplay["MidLineRhymesPercentageRange"] = "Use of Mid-Line Rhymes (Range)";
$searchcolumnsdisplay["LyricalDensityRange"] = "Lyrical Density (Range)";
$searchcolumnsdisplay["DanceabilityRange"] = "Danceability (Range)";
$searchcolumnsdisplay["ProfanityRange"] = "Profanity (Range)";
$searchcolumnsdisplay["LoudnessRange"] = "Loudness (Range)";
$searchcolumnsdisplay["Loudness"] = "Loudness";
$searchcolumnsdisplay["TempoRangeGeneral"] = "Tempo Range (General)";
$searchcolumnsdisplay["NumMelodicThemesRange"] = "Number of Melodic Themes (Range)";
$searchcolumnsdisplay["SectionCount"] = "Number of Distinct Sections (Specific)";








$bpmvalues = array();
$bpmvalues["0:49"] = "<50";
$bpmvalues["50:59"] = "50 - 59";
$bpmvalues["60:69"] = "60 - 69";
$bpmvalues["70:79"] = "70 - 79";
$bpmvalues["80:89"] = "80 - 89";
$bpmvalues["90:99"] = "90 - 99";
$bpmvalues["100:109"] = "100 - 109";
$bpmvalues["110:119"] = "110 - 119";
$bpmvalues["120:129"] = "120 - 129";
$bpmvalues["130:139"] = "130 - 139";
$bpmvalues["140:149"] = "140 - 149";
$bpmvalues["150:100000"] = "150+";

$bridgesurrogatetypes = array();
$bridgesurrogatetypes["Inst Break"] = "Instrumental Break";
$bridgesurrogatetypes["Vocal Break"] = "Vocal Break";
$bridgesurrogatetypes["Other"] = "Other";


$stwcvals = array();
$stwcvals["1:1"] = "1 Word";
$stwcvals["2:2"] = "2 Words";
$stwcvals["3:3"] = "3 Words";
$stwcvals["4:4"] = "4 Words";
$stwcvals["5:999"] = "5+ Words";

$introlengths = array();
$introlengths["Short"] = "0:01 - 0:09 (Short)";
$introlengths["Moderately Short"] = "0:10 - 0:19 (Moderately Short)";
$introlengths["Moderately Long"] = "0:20 - 0:29 (Moderately Long)";
$introlengths["Long"] = "0:30 + (Long)";

$introlengthsotherway = array();
$introlengthsotherway["Short"] = "0:01 - 0:09";
$introlengthsotherway["Moderately Short"] = "0:10 - 0:19";
$introlengthsotherway["Moderately Long"] = "0:20 - 0:29";
$introlengthsotherway["Long"] = "0:30 +";
$introlengthsotherway["No Intro"] = "No Intro";
$introlengthsotherway["No Outro"] = "No Outro";

$intropercents = array();
$intropercents["0:.99"] = "Less than 1%";
$intropercents["1:4.99"] = "1% - 4%";
$intropercents["5:9.99"] = "5% - 9%";
$intropercents["10:14.99"] = "10% - 14%";
$intropercents["15:9999"] = "15%+";

$firstchoruspercents = array();
$firstchoruspercents["Kickoff"] = "Kickoff";
$firstchoruspercents["No Chorus"] = "No Chorus";
$firstchoruspercents["Early"] = "1% - 9% into the song";
$firstchoruspercents["Moderately Early"] = "10% - 19% into the song";
$firstchoruspercents["Moderately Late"] = "20% - 29% into the song";
$firstchoruspercents["Late"] = "30%+ into the song";

$firstchoruspercentsdisplay = array();
$firstchoruspercentsdisplay["Kickoff"] = "Kickoff";
$firstchoruspercentsdisplay["Early"] = "1% - 9%";
$firstchoruspercentsdisplay["Moderately Early"] = "10% - 19%";
$firstchoruspercentsdisplay["Moderately Late"] = "20% - 29%";
$firstchoruspercentsdisplay["Late"] = "30%+";

$firstchorustime = array();
$firstchorustime["Kickoff"] = "Kickoff";
$firstchorustime["Early"] = "0:01 - 0:19 into the song";
$firstchorustime["Moderately Early"] = "0:20 - 0:39 into the song";
$firstchorustime["Moderately Late"] = "0:40 - 0:59 into the song";
$firstchorustime["Late"] = "1:00+ into the song";

$firstchorustimedisplay = array();
$firstchorustimedisplay["0:01 - 0:19"] = "0:01 - 0:19";
$firstchorustimedisplay["0:20 - 0:39"] = "0:20 - 0:39";
$firstchorustimedisplay["0:40 - 0:59"] = "0:40 - 0:59";
$firstchorustimedisplay["1:00 +"] = "1:00+";

$percentoftotalsong = array();
$percentoftotalsong["0.01:19.99"] = "Less than 20%";
$percentoftotalsong["20:29.99"] = "20% - 29%";
$percentoftotalsong["30:39.99"] = "30% - 39%";
$percentoftotalsong["40:49.99"] = "40% - 49%";
$percentoftotalsong["50:59.99"] = "50% - 59%";
$percentoftotalsong["60:101"] = "60%+";

$prechoruspercentoftotalsong = array();
$prechoruspercentoftotalsong["0.01:9.99"] = "Less than 10%";
$prechoruspercentoftotalsong["10:19.99"] = "10% - 19%";
$prechoruspercentoftotalsong["20:29.99"] = "20% - 29%";
$prechoruspercentoftotalsong["30:39.99"] = "30% - 39%";
$prechoruspercentoftotalsong["40:49.99"] = "40% - 49%";
$prechoruspercentoftotalsong["50:101"] = "50%+";

$intropercentoftotalsong = array();
$intropercentoftotalsong["0.01:1.99"] = "1%";
$intropercentoftotalsong["2:2.99"] = "2%";
$intropercentoftotalsong["3:3.99"] = "3%";
$intropercentoftotalsong["4:4.99"] = "4%";
$intropercentoftotalsong["5:101"] = "5%+";

$mtivals = array();
$mtivals["MTI/Energy Level Decrease "] = "MTI/Energy Level Decrease ";
$mtivals["MTI/Energy Level Linear "] = "MTI/Energy Level Linear ";
$mtivals["MTI/Energy Level Increase "] = "MTI/Energy Level Increase ";
$mtivals["MTI/Energy Level Decrease/Increase "] = "MTI/Energy Level Decrease/Increase ";
$mtivals["MTI/Energy Level Increase/Decrease"] = "MTI/Energy Level Increase/Decrease";

    
function outputSelectValuesForEnum( $column, $value = "", $table = "songs"  )
{
    global $ignorecolumns;
    $values = getEnumValues( $column, $table );
    if( isset( $ignorecolumns[$column] ) )
    {
        $ignorearr = $ignorecolumns[$column];
        foreach( $ignorearr as $val )
        {
            if( isset( $values[$val] ) )
                unset( $values[$val] );
        }
    }

    outputSelectValues( $values, $value );
}
function outputSelectValuesForSet( $column, $value = "", $table = "songs"  )
{
    global $ignorecolumns;
    $values = getSetValues( $column, $table );
    if( isset( $ignorecolumns[$column] ) )
    {
        $ignorearr = $ignorecolumns[$column];
        foreach( $ignorearr as $val )
        {
            if( isset( $values[$val] ) )
                unset( $values[$val] );
        }
    }
    outputSelectValues( $values, $value );
}
function getValuesForNewCarry($type = "" )
{
	$values = array();
	if( $type == "trend" )
	    {
		$values["new"] = "Only include new songs for the selected time period";
		$values["carryover"] = "Only include songs that were previously charting";
	    }
	else
	    {
		$values["new"] = "Only include new songs for the selected time period";
		$values["carryover"] = "Only include songs that were previously charting";
	    }
	return $values;
}
function outputSelectValuesForNewCarry( $value = "", $type = "" )
{
    $values = getValuesForNewCarry( $type );
    outputSelectValues( $values, $value );
}
function outputSelectValuesForOtherTable( $othertablename, $value = "", $inother = false, $extrawhere = "" )
{
    global $ignorecolumns;
    $desc = "desc";
    if( $othertablename == "subgenres" || $othertablename == "influences" || $othertablename == "charts" )
        $desc = "asc";
    $where = "";
    if( $inother )
    {
        $otherid = substr( $othertablename, 0, -1 );
        $othertable = "song_to_" . $otherid;
        $otherid .= "id";
            // this has 2 things very specific to subgenres so if you need to add more, code more  -- rachel
        $where = ", $othertable where {$othertablename}.id = {$otherid}  and type = 'Main' and HideFromAdvancedSearch = 0 ";
    }

if( $extrawhere )
{
	if( !$where ) $where = " where 1 ";
	$where .=  $extrawhere;
}    
  $possiblevals = db_query_array( "select {$othertablename}.id, Name from $othertablename $where order by OrderBy {$desc}, Name", "id", "Name" );

    if( isset( $ignorecolumns[$othertablename] ) )
    {
//        print_r( $ignorecolumns[$othertablename] );
        $ignorearr = $ignorecolumns[$othertablename];
//        print_r( $possiblevals );
        foreach( $ignorearr as $val )
        {
//            echo( "looking for $val" );
            if( in_array( $val, $possiblevals ) )
            {
                $hmm = array_search( $val, $possiblevals );
                unset( $possiblevals[$hmm] );
            }
        }
    }

    outputSelectValues( $possiblevals, $value );
}

function outputSelectValuesDistinct( $field, $value = "", $orderby = "" )
{
    global $ignorecolumns;
    $orderby = $orderby?$orderby:$field;

    $possiblevals = db_query_array( "select distinct( $field ) from songs where {$GLOBALS[clientwhere]} and $field <> '' order by {$orderby}", "$field", "$field" );
    if( isset( $ignorecolumns[$column] ) )
    {
        $ignorearr = $ignorecolumns[$column];
        foreach( $ignorearr as $val )
        {
            if( isset( $possiblevals[$val] ) )
                unset( $possiblevals[$val] );
        }
    }

    
    outputSelectValues( $possiblevals, $value );
}

function outputOtherTableAutofillField( $othertablename, $name, $placeholder = "", $displayvalue="", $style="", $extarraykey = "" )
{
    global $autosuggesttables;
    $asname = $name;
    if( $extarraykey )
    {
        $asname .= $extarraykey;
        $asname = str_replace( "[", "", $asname );
        $asname = str_replace( "]", "", $asname );
    }

    $autosuggesttables[$othertablename][] = $asname;

    echo( "<input {$style} autocomplete='off' type='text' name='search[{$name}]$extarraykey' id='autosuggest{$asname}' placeholder=\"$placeholder\" value=\"$displayvalue\" > " );
}

function formatSearchDisplayName( $default, $value )
{
    if( $default == "Peak Chart Position" && strpos( $value, "client-" ) !== false )
    {
        return "Client";
    }
    return $default;
}

function formatSearchDisplay( $key, $value )
{
    global $peakvalues, $bpmvalues, $stwcvals, $singlecolumnfields, $grouptypes, $percentoftotalsong, $intropercentoftotalsong, $prechoruspercentoftotalsong, $firstchorustime, $firstchoruspercents, $intropercents, $svsmulttypes, $leadsvsmulttypes, $songwritertypes, $gendertypes, $vocaldeliverytypes, $introlengthsotherway, $seasonswithall, $dontmatchinstruments, $minweeksvalues, $maxnumperchart, $topmiddle, $bottommiddle;
;
    switch( $key ) {
        
        case "dates":
	    $where = "";
	    if( $value["season"] && $value["fromq"] )
		{
		    //		    $where .= "hmm $value[season]" . getFirstSeason( $value[season] );;
		    $value["fromq"] = getFirstSeason( $value["season"] );
		}
            if( $value["fromweekdate"] && $value["toweekdate"] )
            {
                $where .= ( date( "m/d/y", $value["fromweekdate"] ) . " - " . date( "m/d/y", $value["toweekdate"] ) );
            }
            else if( $value["fromq"] && $value["fromy"] )
            {
                $where .= ( "Q".$value["fromq"] . "/" . $value["fromy"] );
            }
            else if( $value["fromy"] )
            {
                $where .= $value["fromy"];
            }
            if( $value[toq] &&  $value[toy] )
                $where .= " to Q" . ( $value["toq"] . "/" . $value["toy"] );
            else if( $value[toy] )
                $where .= " to $value[toy]";
            
	    if( $value["season"] )
	    $where .= " (" . $seasonswithall[$value[season]] . ")";
	    $where = trim( $where );
            break;
                // this is an autofill field with one type for the same table 
        case "songname":
            $tname = $key;
            $where = $value;
            break; 

        case "season":
            $where = $seasonswithall[$value];
            break; 

        case "artistinlast":
        case "primaryartistinlast":
            $rows = array( "First time in one year"=>"pastyear", "First time in three Years"=>"past3years" );
            $where = array_search( $value, $rows );
            break;
            
        case "mainartisttype":
            $rows = array( "Has A Solo Artist"=>"single", "Has A Featured Artist"=>"featured", "Has No Featured Artist"=>"nofeatured", "Has Multiple Artists"=>"multiple" );
            $where = array_search( $value, $rows );
            break;
        case "minweeks":
	    $where = $minweeksvalues[$value];
	    if( !$where )
		$where = $value;
	    break;
        case "mainlabeltype":
            $rows = array( "Has A Single Label"=>"single", "Has Multiple Labels"=>"multiple" );
            $where = array_search( $value, $rows );
            break;
        case "postchorus":
        case "ChorusPrecedesVerse":
        case "HasPrechorus":
        case "InstOrVocal":
		case "UseofParallelMode":
		case "SlangWords":
		case "PersonReferences":
		case "UseOfAPreChorus":
		case "UseOfAVocalPostChorus":
		case "UseOfABridge":
		case "LocationReferences":
		case "OrganizationorBrandReferences":
		case "ConsumerGoodsReferences":
		case "CreativeWorksTitles":
		case "PercentAbbreviations":
		case "PercentNonDictionary":
            $where = $value > 0 ?"Yes":"No";
            break; 

        case "label":
            $where = $value;
            break; 
            ; 
                // this is an pulldown field with one type for the same table 
        case "labelid":
            $where = getTableValue( $value, "labels" );
            break; 
            ; 
        case "lyricalmoodid":
            $where = getTableValue( $value, "lyricalmoods" );
            break; 
            ; 
        case "lyricalthemeid":
            $where = getTableValue( $value, "lyricalthemes" );
            break; 
            ; 
        case "solovsduet":
            $vocals = array( "Solo"=>"Solo Lead Vocalist", "Duet"=>"Multiple Lead Vocalists" );
            $where = $vocals[$value];
            break; 
            ; 
                // this is for simple song fields
        case "GenreID":
	    global $allgenresfordropdown;
	    $where = $allgenresfordropdown[$value];
            break; 
            ; 
        case "GenreName":
            $where = $value;
            break; 
            ; 
            
        case "FirstChorusPercentRange":
            $where = $firstchoruspercents[$value];
            break; 
            ; 
        case "FirstChorusDescr":
            $where = $firstchorustime[$value];
            break; 
            ; 
        case "timesignatureid":
            $where = getTableValue( $value, "timesignatures" );
            break; 
            ; 
        case "WeekEnteredTheTop10":
        case "weekdateid":
            $where = getTableValue( $value, "weekdates" );
            break; 
            ; 
        case "BridgeSurrCount":
            $where = $value;
            if( $value == -2 )
                $where = "One or more";
            if( $value == -1 )
                $where = "None";
            
            break;
    case "CreditType": 
	$where = $songwritertypes[$value];
	break;
    case "OutroRange":
    case "introlengthrange":
	$where = $introlengthsotherway[$value];
	break;
        case "songtitleappearancecount":
        case "postchorussections":
        case "bridgesurrogatesections":
        case "SongTitleAppearanceRange":
        case "songkeyid": // i think this is wrong
            case "SpecificMajorMinor":
        case "majorminor":
        case "influencecount":
        case "introlengthrangenums":
        case "FirstSectionType":
        case "LastSectionType":
        case "KeyMajor":
        case "OutroLengthRangeNums":
        case "FirstChorusRange":
        case "ElectricVsAcoustic":
        case "SongLengthRange":
        case "SongLengthExact":
        case "introvocalvsinst":
        case "PeakPosition":
        case "NumberOfWeeksSpentInTheTop10":
        case "IntroVocalVsInst":
        case "TempoRange":
        case "Tempo Range General":
        case "TotalCount":
        case "PrimaryGender":
        case "FeatGender":
        case "OutroVocalVsInst":
        case "OutroRecycled":
            $where = $value;
        
            break; 
            // this is for set song fields
        case "containssampled":
        case "FirstChorusBreakdown":
            $where = $value;
            if( $value == 1 ) $where = "Yes";
            if( $value == -1 ) $where = "No";
            break; 
            ;
        case "FirstChorusBreakdown":
            $where = $value;
            if( $value == 1 ) $where = "First Chorus is a Breakdown";
            if( $value == -1 ) $where = "First Chorus is not a Breakdown";
            break; 
            ;
        case "toptentype":
	    $arr = getValuesForNewCarry( "trend");
	    $where = $arr[$value];
	    if( !$where )
		$where = $value;
	break;
        case "fullform":
            $where = strtoupper( $value );
            break; 
                // this is a basic set field with checkboxes
        case "RecycledSections":
        case "ArtistBand":
            $where = $value;
            break; 
        case "peakchart":
        case "peakwithin":
            $where = $peakvalues[$value];
            if( strpos( $value, "client-" ) !== false )
            {
                $where = getPeakPositionDisplayValue( $value );
            }
	    if( !$where )
		{
		    if( $value == "1:$topmiddle" )
			$where = "Top $topmiddle";
		    if( $value == "$bottommiddle:$maxnumperchart" )
			$where = "Bottom $topmiddle";
		}

            break; 
        case "bpm":
            $where = $bpmvalues[$value];
            break;
        case "IsRemix":
            $where = $value>0?"Yes":"No";
            break;
        case "exactbpm":
            $where = $value;
            break;
        case "SongTitleWordCount":
            $where = $stwcvals[$value];
            if( !$where )
            {
                $valarr = explode( ":", $value );
                $where = array_pop( $valarr );
            }
            
        break; 
        ; 
        case "clevergeneric":
            $where = implode( ", ", array_keys( $value ) );
            break;
        case "vocalsgender":
        case "GenreFusionType":
            $where = $value;
            break; 
        case "notcontainssection":
        case "containssection":
            $where= implode( ", ", $value  );
        break;
        case "contains":
        case "vocals":
            $vals = array();
            foreach( $value as $type=>$chosen )
            {
                if( !$chosen )
                    continue;
                $vals[] = "$type: $chosen";
            }
            $where = implode( "; ", $vals );
            break;
// this is where this is a one to many table with multiple checkboxes
        case "bpchorus":
            $where = "Yes";
            break;
        case "bdfield":
            $where = implode( ", ", $value );
            break;
        case "newcarryfilter":	
	$arr = getValuesForNewCarry();
	$where = $arr[$value];
	break;
        case "specificsubgenre":
        case "specificsubgenrealso":
            $where = getTableValue( $value, "subgenres" );
            break;
        case "specificinfluence":
        case "specificinfluencealso":
            $where = getTableValue( $value, "influences" );
            break;
        case "subgenres":
        case "influences":
        case "placements":
        case "endingtypes":
        case "chorustypes":
        case "lyricalthemes":
        case "lyricalsubthemes":
        case "lyricalmoods":
        case "primaryinstrumentations":
        case "introtypes":
        case "outrotypes":
        case "bridgecharacteristics":
        case "postchorustypes":
                // maybe change this to a subselect  ( where song.id in ( ) )???  or change this to do an array_intersect.. hmm....
	    $tmp = "";
	    if(  $key == "primaryinstrumentations" && $dontmatchinstruments) 
		{
		    $tmp = " Does not contain ";
		}

            $vals = array();
        $tname = substr( $key, 0, 3 );
        foreach( $value as $chosen=>$throwaway )
        {
            if( !$chosen )
                continue;
            $vals[] = getTableValue( $chosen, $key );

        }
        $where = $tmp . implode( "; ", $vals );
        break;
	case "newcarryfilter": 
// not sure yet rachel
	break;

        case "numweeksinperiod":
	    $exp = explode( "-", $value );
	    if( $exp[1] > 50 )
		{
		    $where = "{$exp[0]}+ Weeks";
		}
	    else
		{
		if( $exp[0] == $exp[1] )
		    $where = "$exp[0] Week";
		else
		    $where = "$exp[0]-$exp[1] Weeks";
		}
	break;
        case "ssvocaltypes":
            $arr = array();
            $res = db_query_array( "select * from vocals", "id", "Name" );
            foreach( $value as $key=>$val )
            {
		//		if( $key == 25 ) continue;
                if( $key == "Chorus" )
                {
                    $val = str_replace( " Vocals", "", $val );
                    $arr[] = "Contains a $val Chorus";
                }
                else
                {
                    if( $val > 0 )
                        $arr[] = $res[$key];
                    // else 
                    //     $arr[] = "Not " . $res[$key];
                }
            }
	    if( count( $arr ) == 1 )
		{
		    $where = implode( "" , $arr );
		    $where = $where;
		}
	    else
		$where = implode( " and " , $arr );

            break;

                // instrumental break primary instrument
        case "instbrkpi":
            foreach( $value as $type=>$throwaway )
            {
                $pi = getTableValue( $type, "instruments" );
                $vals[$pi] = $pi;
            }
            $where = implode( "; ", $vals );
            break;

        case "BridgeSurrogateType":
            if( $value == "Other" )
            {
                $where = " Contains Other Bridge Surrogate ";
            }
            else
            {
                $where .= "Contains $value Bridge Surrogate";
            }
            break;
        case "IsRemix":
            $where = $value?"Yes":"No";
            break;
        case "withimprint":
            $where = $value?"Yes":"Any";
            break;
        case "sectioncounts":
        case "percentoftotal":
        case "uniformity":
            $field = $singlecolumnfields[$key];
        $arr = array();
        foreach( $value as $type=>$val )
        {
            if( !$val )
                continue;
            if( $key == "percentoftotal" && ( $type == "Intro" || $type == "Outro") )
                $arr[] = "$type: " . $intropercentoftotalsong[$val];
            else if( $key == "percentoftotal" && ( $type == "Pre-Chorus" || $type == "Bridge" || $type == "Inst Break" || $type == "Vocal Break") )
                $arr[] = "$type: " . $prechoruspercentoftotalsong[$val];
            else if( $key == "percentoftotal" )
                $arr[] = "$type: " . $percentoftotalsong[$val];
            else if( $key == "sectioncounts" )
            {
                $tmptype = $type;
                if( $tmptype == "BridgeOrSurr" )
                    $tmptype = "Bridge or Bridge Surrogate";
                if( $tmptype == "BridgeSurrogate" )
                    $tmptype = "Bridge Surrogate";
                if( $tmptype == "PostChorus" )
                    $tmptype = "Post-Chorus";
                $uni = getFiveValuesSection($tmptype);
                $arr[] = $uni[$val];
            }
            else if( $key == "uniformity" )
            {
                $uni = getLengthUniformity($type);
                $arr[] = $uni[$val];
            }
        }
        $where = implode( ", " , $arr );
        break;
		case "VocalPostChorusCount":
		case "PreChorusCount":
		case "VerseCount":
		case "ChorusCount":
		    if( $value > 0 ) 
			$where = $value;
		else
		    $where = "None";

		break;
	
        default :
	    global $searchcolumnsdisplay;
	    if( array_search( $searchcolumnsdisplay, $key ) )
		{
		    return $value;
		}
	    else if( $searchcolumnsdisplay[$key] )
		{
		    return $value;

		}
	    else
		echo( "no match 2 for $key<br>" );
            break;
    }
    return $where;

}




function getSearchResults( $search )
{
    global $quarters, $years, $grouptypes, $singlecolumnfields, $dontmatchinstruments;
    $tables = array( "songs"=> "songs" );
    $where = "1";
    $columns = array( "songs.*" );
    $season = $search["dates"]["season"];

        // this is FOR autofill field with multiple types for the same table 

    $where .= " and {$GLOBALS[clientwhere]} ";

    $cnt = 0;
    //    print_r( $search );    
    if( is_array( $search ) )
    foreach( $search as $key=>$value )
    {
	$cnt++;
        if( !$value ) continue;
        switch( $key ) {

            case "peakwithin";
            if( !$search["dates"]["fromq"] && !$search["dates"]["fromy"] )
                $where .= " and songs.PeakPosition <= $value";
            break;
	case "newcarryfilter":
	    break;
            case "dates":
                if( $value["fromq"] || $value["fromy"] )
                {
                    $peak = $search["peakwithin"]?"<".$search["peakwithin"]:$search["peakchart"];
		    if( strpos( $search["peakwithin"], ":" ) !== false )
			$peak = $search["peakwithin"];
			if( $search["season"] )
			$season = $search["season"];
                    $sids = getSongIdsWithinQuarter( false, $value[fromq], $value[fromy], $value[toq], $value[toy], $peak, false, $season );
                    logquery( "peak is?" . $peak );
                    $sids[] = "-1";
                    $where .= " and songs.id in( " . implode( ", " , $sids ) . " )";
                }
                else if( $value["fromweekdate"] && $value["toweekdate"] )
                {
                    $peak = $search["peakwithin"]?"<".$search["peakwithin"]:$search["peakchart"];
			if( $search["season"] )
			$season = $search["season"];
                    $sids = getSongIdsWithinWeekdates( false, $value[fromweekdate], $value[toweekdate], $peak, false, $season );
                    logquery( "peak is?" . $peak );
                    $sids[] = "-1";
                    $where .= " and songs.id in( " . implode( ", " , $sids ) . " )";
                }
                
                break;
case "season":
     break;
                    // this is an autofill field with one type for the same table 
            case "GenreName":
                $tname = "genre";
                $value = db_query_first_cell( "select id from {$tname}s where Name = '". escMe( $value ). "'" );
                $where .= " AND GenreID = $value";
                break; 
            case "GenreID":
		if( $value > 0 )
		    $where .= " and songs.GenreID = $value"; 
		else
		    $where .= " and songs.GenreID <> " . abs( $value ) . ""; 
		break;
            case "KeyMajor":
                $tname = "songkey";
                $currtable = "song_to_{$tname}";
                $tables[$currtable] = $currtable;
                $where .= " AND song_to_{$tname}.songid = songs.id ";
                $where .= " AND song_to_{$tname}.NameHard = '$value' ";
                break; 
                    // this is for simple song fields
            case "songtitleappearancecount":
            case "introlengthrange":
            case "influencecount":
            case "introlengthrangenums":
            case "FirstSectionType":
            case "SongTitleAppearanceRange":
            case "songkeyid":
            case "timesignatureid":
            case "SpecificMajorMinor":
            case "majorminor":
            case "LastSectionType":
            case "OutroRange":
            case "OutroLengthRangeNums":
            case "FirstChorusRange":
            case "FirstChorusBreakdown":
            case "PeakPosition":
            case "WeekEnteredTheTop10":
            case "NumberOfWeeksSpentInTheTop10":
            case "SongLengthRange":
            case "vocalsgender":
            case "GenreFusionType":
            case "ElectricVsAcoustic":
            case "introvocalvsinst":
        case "TotalCount":
            case "TempoRange":
            case "BridgeSurrCount":
            case "FirstChorusPercentRange":
            case "ArtistBand":
            case "FirstChorusDescr":
            case "OutroVocalVsInst":
            case "IntroVocalVsInst":
            case "exactbpm":
            case "OutroRecycled":
                $field = $singlecolumnfields[$key];
                if( !$field ) $field = $key;


                $oper = "=";
                if( $key == "FirstChorusPercentRange" && $value == "No Chorus" ) 
		    {		
			$value = "NULL";
			$oper = "is";
		    }
                if( $key == "FirstChorusRange" && $value == "No Chorus" ) 
		    {		
			$value = "NULL";
			$oper = "is";
		    }
                if( $key == "IntroVocalVsInst" && $value == "No Intro" ) 
		    {		
			$value = "NULL";
			$oper = "is";
		    }
                if( $key == "OutroVocalVsInst" && $value == "No Outro" ) 
		    {		
			$value = "NULL";
			$oper = "is";
		    }
                if( $key == "BridgeSurrCount" && $value == "-2" )
                {
                    $value = "1";
                    $oper = ">=";
                }
                
                if( $value == "Duet/Group (All)" )
                {
                    $oper = " LIKE ";
                    $value = "Duet%";
                }
		if( $field != "IntroLengthRange" && $field != "OutroRange"  && ($value == "No Intro" || $value == "No Outro" ) )
		    {
//		    echo( "setting $field" );
			$value = "";
		    }
		if( $value == "NULL" )
		    $where .= " AND {$field} {$oper} " . escMe( $value ) . " ";
		else
		    $where .= " AND {$field} {$oper} '" . escMe( $value ) . "' ";
                break; 
                    // this is for set song fields
	case "SongLengthExact": 
	    $where .= " and SongLength = '" . escMe( $value ) . "'";
	    break;

            case "toptentype":
		
		if( $value == "new" ) $value = "New Songs";
		if( $value == "carryover" ) $value = "Carryovers";
		if( $search[dates][fromweekdate] )
		    {
			$allweeks = db_query_array("select OrderBy, id from weekdates where OrderBy >= {$search[dates][fromweekdate]} and OrderBy <= {$search[dates][toweekdate]}", "OrderBy", "id" );
			if( $value == "Total Songs In The Chart" ) $where .= "";
			else if( $value == "New Songs" )
			    {
				$where .= " and WeekEnteredTheTop10 in ( " . implode( ", " , $allweeks ) . " )";
			    }
			else if( $value == "Carryovers" )
			    {
				$where .= " and WeekEnteredTheTop10 not in ( " . implode( ", " , $allweeks ) . " )";
			    }

		    }
		else
		    {
			if( $value == "Total Songs In The Top 10" ) $where .= "";
			else if( $value == "New Songs" )
			    {
				$allquarters = getQuarters( $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
				//		    print_r( $search[dates] );
				$tmpres = " 1 = 0";
				foreach( $allquarters as $tmpq )
				    {
					$tmpres .= " or " . getQuarterEnteredTheTopTenString( $tmpq, $season ) ;
				    }
				$where .= " and ( $tmpres )";
			    }
			else if( $value == "Carryovers" )
			    {
				$allquarters = getQuarters( $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
				$tmpres = " 1 = 1";
				foreach( $allquarters as $tmpq )
				    {
					$tmpres .= " and " . getQuarterEnteredTheTopTenString( $tmpq, $season, "not" ) ;
				    }
				$where .= " and ( $tmpres )";
			    }
		    }
                break;
            case "fullform":
                if( strtoupper( $value ) == "A-B-A-B-D-B" )
                {
                    $otherform = "A-B-A-B-C-B";
                    $where .= " AND ( SongStructure = '" . escMe( $value ) . "' or SongStructure = '" . escMe( $otherform ) . "' ) ";
                }
                else
                    $where .= " AND ( SongStructure = '" . escMe( $value ) . "' ) ";
                    
                break; 
                    // this is a basic set field with checkboxes
            case "EndingType":
                $field = $key;
                foreach( $value as $v=>$throwaway )
                {
                    $where .= " AND {$field} like '%" . escMe( $v ) . "%' ";
                }
                break; 
                    // this is an autofill field with multiple types for the same table 
	case "CreditType" : 
	    // we handle this below
	    break;
            case "bpm":
            case "SongTitleWordCount":
                $field = isset( $singlecolumnfields[$key] )?$singlecolumnfields[$key] :$key;
                $s = explode( ":", $value );
		if( strpos( $value, ":" ) === false )
		$s[1] = $s[0];
                $where .= " AND {$field} >= $s[0] AND {$field} <= $s[1] " ;
                break; 
                ; 
            // case "outropercents":
            // case "intropercents":
            //     $tname = $key=="intropercents"?"ipcs":"opcs";
            //     $currtable = "song_to_songsection {$tname}";
                
            //     $tables[$currtable] = $currtable;

            //     $field = "PercentOfSong";
            //     $s = explode( ":", $value );
            //     $where .= " AND {$tname}.songid = songs.id" ;
            //     $where .= " AND {$tname}.{$field} >= $s[0] AND ipcs.{$field} <= $s[1] " ;
            //     $without = ($key == "intropercents")?"Intro":"Outro";
            //     $where .= " AND {$tname}.WithoutNumberHard = '$without' ";
            //     break; 
            //     ; 
            case "clevergeneric":
                $where .= " AND ( 1 = 0 " ;
                foreach( $value as $v=>$throwaway )
                {
                    $where .= " OR CleverVsGeneric = '$value' " ;
                }
                $where .= " ) " ;
                break;
            case "notcontainssection":
            case "containssection":
                foreach( $value as $sname )
            {
                $not = $key=="notcontainssection"?" NOT ":"";
                $where .= " AND songs.AllSections {$not}  like '%,$sname,%'";
            }
            break; 
            case "solovsduet":
                $where .= " AND songs.VocalsGender like '%$value%'";
            break; 
            case "contains":
                foreach( $value as $type=>$chosen )
                {
                    if( !$chosen )
                        continue;
                    if( $chosen == "Yes" )
                        $where .= " AND AllSections like '%,$type,%' ";
                    else if( $chosen == "No" )
                        $where .= " AND AllSections not like '%,$type,%' ";
                }
                break;
            case "vocals":
                foreach( $value as $type=>$chosen )
                {
                    if( !$chosen )
                        continue;
                    $shortname = "sv$type";
                    $currtable = "song_to_songsection $shortname";
                    $tables[$currtable] = $currtable;
                    $where .= " AND ( {$shortname}.songid = songs.id ";
                    $where .= " AND {$shortname}.VocalsHard like '%$type%'";
                    $where .= " AND {$shortname}.WithoutNumberHard = '$chosen' )";
                }
                break;
// this is where this is a one to many table with multiple checkboxes
            case "specificsubgenre":
            case "specificsubgenrealso":
                $where .= " and SubgenresHard like '%,$value,%'";
                break;
            case "specificinfluencealso":
            case "specificinfluence":
                $where .= " and InfluencesHard like '%,$value,%'";
                break;
            case "ProductionMood":
            case "MainMelodicRange":
            case "ChordDegreePrevalence":
                $where .= " and {$key} like '%$value%'";
                break;
            case "subgenres":
            case "influences":
            case "placements":
            case "lyricalthemes":
            $fieldname = $key == "subgenres"?"SubgenresHard":"PlacementsHard";
	    if( $key == "influences" )
		$fieldname = "InfluencesHard";
            if( $key == "lyricalthemes" )
                $fieldname = "LyricalThemesHard";

            
            foreach( $value as $chosen=>$throwaway )
            {
                $where .= " and {$fieldname} like '%,$chosen,%'";
            }
            break;
            case "primaryinstrumentations":
            case "chorustypes":
            case "endingtypes":
            case "outrotypes":
            case "lyricalthemes":
            case "lyricalsubthemes":
            case "lyricalmoods":
            case "weekdates":
            case "postchorustypes":
            case "bridgecharacteristics":
            case "introtypes":
                    // maybe change this to a subselect  ( where song.id in ( ) )???  or change this to do an array_intersect.. hmm....
                
		if( $key == "primaryinstrumentations" && $dontmatchinstruments)
		    {
			$where .= " and songs.id not in ( select songid from song_to_primaryinstrumentation where primaryinstrumentationid in ( " . implode( ", ", array_keys( $value ) ) . " ) )"; 
		    }
		else
		    {

			$tname = substr( $key, 0, 3 );
			foreach( $value as $chosen=>$throwaway )
			    {
				if( !$chosen )
				    continue;
				$shortname = "lt{$key}{$chosen}";
				$remove1 = substr( $key, 0, -1 );
				$currtable = "song_to_{$remove1} $shortname";
				$tables[$currtable] = $currtable;
				$where .= " AND ( {$shortname}.songid = songs.id ";
				$where .= " AND {$shortname}.{$remove1}id = '$chosen' )";
			    }
		    }
                break;

            case "bpchorus":
                    // maybe change this to a subselect  ( where song.id in ( ) )???  or change this to do an array_intersect.. hmm....
                $choruses = implode( ", ", db_query_array( "select id from songsections where WithoutNumber = 'Chorus'", "id", "id" ) );
                $where .= " AND songs.id in ( select stc.songid from song_to_chorustype stc where chorustypeid = '$value' and type in ( $choruses ) )";
                break;

            // case "postchorus":
            //     if( $value > 0 )
            //         $where .= " AND songs.id in ( select pc.songid from song_to_songsection pc where PostChorus = 1 ) ";
            //     else
            //         $where .= " AND songs.id not in ( select pc.songid from song_to_songsection pc where PostChorus = 1 ) ";
                    
            //     break;
            // case "postchorussections":
	    // 	if( $value == "No Post-Chorus" )
            //         $where .= " AND songs.id not in ( select pc.songid from song_to_songsection pc where PostChorus = 1 and WithoutNumberHard = '$value' ) ";
	    // 	else
            //         $where .= " AND songs.id in ( select pc.songid from song_to_songsection pc where PostChorus = 1 and WithoutNumberHard = '$value' ) ";
            //     break;
	// case "vocaldelivery": 
	//     if( $value == "onlysung" )
	// 	{
	// 	    $where .= " and songs.id in ( select songid from song_to_vocal where vocalid = " . SUNG . " ) ";
	// 	    $where .= " and songs.id not in ( select songid from song_to_vocal where vocalid = " . RAPPED . " ) ";
	// 	}
	//     if( $value == "onlyrapped" )
	// 	{
	// 	    $where .= " and songs.id not in ( select songid from song_to_vocal where vocalid = " . SUNG . " ) ";
	// 	    $where .= " and songs.id in ( select songid from song_to_vocal where vocalid = " . RAPPED . " ) ";
	// 	}
	//     if( $value == "rappedandsung" )
	// 	{
	// 	    $where .= " and songs.id in ( select songid from song_to_vocal where vocalid = " . SUNG . " ) ";
	// 	    $where .= " and songs.id in ( select songid from song_to_vocal where vocalid = " . RAPPED . " ) ";
	// 	}
	//     break;
	// case "svsmult": 
	//     if( $value == "Solo" )
	// 	{
	// 	    $where .= " and ArtistCount = 1";
	// 	}
	//     if( $value == "Multiple" )
	// 	{
	// 	    $where .= " and ArtistCount > 1 ";
	// 	}
	//     break;
	// case "svsmultlead": 
	//     if( $value == "Solo" )
	// 	{
	// 	    $where .= " and VocalsGender like '%Solo%'" ;
	// 	}
	//     if( $value == "Multiple" )
	// 	{
	// 	    $where .= " and VocalsGender like '%Duet%'" ;
	// 	}
	//     break;
	// case "vocalsgenderspecific": 
	//     if( $value == "Female" )
	// 	{
	// 	    $where .= " and VocalsGender in ( 'Solo Female', 'Duet/Group (All Female)' )";
	// 	}
	//     if( $value == "Male" )
	// 	{
	// 	    $where .= " and VocalsGender in ( 'Solo Male', 'Duet/Group (All Male)' )";
	// 	}
	//     if( $value == "Both" )
	// 	{
	// 	    $where .= " and VocalsGender in ( 'Duet/Group (Female/Male)' )";
	// 	}
	//     break;
            case "weekdateid":
                    $where .= " AND songs.id in ( select pc.songid from song_to_weekdate pc where weekdateid = '$value' )";
                break;
            case "bridgesurrogatesections":
		$value = str_replace( "Instrumental Break", "Inst Break", $value );
		if( $value == "No Bridge Surrogate" )
                    $where .= " AND songs.id not in ( select pc.songid from song_to_songsection pc where BridgeSurrogate = 1 )";
		else
                    $where .= " AND songs.id in ( select pc.songid from song_to_songsection pc where BridgeSurrogate = 1 and WithoutNumberHard = '$value' )";
                break;

            case "InstOrVocal":
                if( $value > 0 )
                    $where .= " AND songs.id in ( select pc.songid from song_to_songsection pc where WithoutNumberHard = 'Inst Break' or WithoutNumberHard = 'Vocal Break' )";
                else
                    $where .= " AND songs.id not in ( select pc.songid from song_to_songsection pc where WithoutNumberHard = 'Inst Break' or WithoutNumberHard = 'Vocal Break' )";
                    
                break;

            case "ChorusPrecedesVerse":
                if( $value > 0 )
                    $where .= " AND ChorusPrecedesVerse = 1";
                else
                    $where .= " AND ChorusPrecedesVerse = 0";
                break;

            case "bdfield":
                foreach( $value as $v )
                {
                        // maybe change this to a subselect  ( where song.id in ( ) )???  or change this to do an array_intersect.. hmm....
                    $fields = implode( ", ", db_query_array( "select id from songsections where WithoutNumber = '$v'", "id", "id" ) );
                    $where .= " AND songs.id in ( select stc.songid from song_to_chorustype stc where chorustypeid = '3' and type in ( $fields ) )";
                }
                break;
        case "numweeksinperiod":
	    $weekdateids = getWeekdatesForQuarters( $search["dates"]["fromq"], $search["dates"]["fromy"], $search["dates"]["toq"], $search["dates"]["toy"] );
	    $exp = explode( "-", $value );
	    $where .= " AND ( select count(*) from song_to_weekdate pc where weekdateid in( " . implode( ", " , $weekdateids ) . ") and songid = songs.id ) BETWEEN $exp[0] and $exp[1] ";


	    // not sure
	    break;
            case "ssvocaltypes":
                foreach( $value as $type=>$throwaway )
                {
		    //		    if( $type == 25 ) continue;
                    if( $type == "Chorus" )
                    {
                        $t = substr( $type, 0, 3 );
                        $shortname = "sv{$t}";
                        $currtable = "song_to_songsection $shortname";
                        $tables[$currtable] = $currtable;
                        $where .= " AND ( {$shortname}.songid = songs.id ";
                        $where .= " AND {$shortname}.VocalsHard like '%$throwaway%'";
                        $where .= " AND {$shortname}.WithoutNumberHard = '$type'";
                        $where .= "  )";
                    }
                    else
                    {
                        if( $throwaway > 0 )
                            $where .= " AND SubsectionVocalsHard like '%,{$type},%'";
                        else
                            $where .= " AND SubsectionVocalsHard not like '%,{$type},%'";
                    }
                }
                break;

                    // instrumental break primary instrument
            case "instbrkpi":
                foreach( $value as $type=>$throwaway )
                {
                    $arr = db_query_array( "select distinct( stpi.songid ) from song_to_instrument stpi, song_to_songsection stspi where stspi.WithoutNumberHard = 'Inst Break' and stpi.type = stspi.songsectionid and instrumentid = '$type'", "songid", "songid" );
                    $arr[] = "-1";
                    $where .= " AND songs.id in (  ";
                    $where .= implode( ", " , $arr );
                    $where .= "  )";
                }
                break;

            case "BridgeSurrogateType":
                $shortname = "bst";
                $currtable = "song_to_songsection $shortname";
                $tables[$currtable] = $currtable;
                $where .= " AND ( {$shortname}.songid = songs.id ";
                $where .= " AND {$shortname}.BridgeSurrogate = 1 ";
                if( $value == "Other" )
                {
                    $where .= " AND ( {$shortname}.WithoutNumberHard <> 'Inst Break' and {$shortname}.WithoutNumberHard <> 'Vocal Break' ) ";
                }
                else
                {
                    $where .= " AND {$shortname}.WithoutNumberHard = '$value'";
                }
                $where .= "  )";
                break;
            case "mainartisttype":
                if( $value == "single" )
                {
                    $where .= "  and (( select count(*) from song_to_group where songid = songs.id and type in ( 'primary', 'featured' )) + ( select count(*) from song_to_artist where songid = songs.id and type in ( 'primary', 'featured' ) ) = 1 ) ";
                }
                else if( $value == "nofeatured" )
                {
                    $where .= "  and (( select count(*) from song_to_group where songid = songs.id and type in (  'featured' ) ) + ( select count(*) from song_to_artist where songid = songs.id and type in (  'featured' ) ) = 0 ) ";
                }
                else if( $value == "featured" )
                {
                    $where .= "  and (( select count(*) from song_to_group where songid = songs.id and type in (  'featured' ) ) + ( select count(*) from song_to_artist where songid = songs.id and type in (  'featured' ) ) > 0 ) ";
                }
                else
                {
                        // multiple
                    $where .= " AND  (( select count(*) from song_to_group where songid = songs.id and type in ( 'primary', 'featured'  ) ) + ( select count(*) from song_to_artist where songid = songs.id and type in ( 'primary', 'featured' ) ) > 1 )";
                    
                }
                break;
            case "MelodicIntervalPrevalence":
                    $where .= "  and find_in_set( '$value', MelodicIntervalPrevalence ) > 0  ";
	    break;
            case "mainlabeltype":
                if( $value == "single" )
                {
                    $where .= "  and ( select count(*) from song_to_label where songid = songs.id  ) = 1 ";
                }
                else
                {
                        // multiple
                    $where .= "  and ( select count(*) from song_to_label where songid = songs.id  ) > 1 ";
                    
                }
                break;
            case "percentoftotal":
            case "sectioncounts":
            case "uniformity":
                $field = $singlecolumnfields[$key];
                foreach( $value as $type=>$val )
                {
                    if( !$val )
                        continue;

                    if( $type == "PostChorus" )
                    {
                        $where .= " and (select count(*) from song_to_songsection where songid = songs.id and PostChorus = 1) ";
                        if( $val == -1 )
                            $where .= " = 0 ";
                        else if( $val == -2 )
                            $where .= " > 0 ";
                        else 
                            $where .= " = $val ";
                        break;
                    }
                    if( $type == "BridgeSurrogate" )
                    {
                        $where .= " and (select count(*) from song_to_songsection where songid = songs.id and BridgeSurrogate = 1) ";
                        if( $val == -1 )
                            $where .= " = 0 ";
                        else if( $val == -2 )
                            $where .= " > 0 ";
                        else 
                            $where .= " = $val ";
                        break;
                    }
                    if( $type == "BridgeOrSurr" )
                    {
                        $where .= " and (select count(*) from song_to_songsection where songid = songs.id and (BridgeSurrogate = 1 or WithoutNumberHard = 'Bridge') ) ";
                        if( $val == -1 )
                            $where .= " = 0 ";
                        else if( $val == -2 )
                            $where .= " > 0 ";
                        else 
                            $where .= " = $val ";
                        break;
                    }
                    
                    $t = substr( $type, 0, 3 );
                    $shortname = "sshort{$t}";
                    $currtable = "SectionShorthand $shortname";
                    if( !isset( $tables[$currtable] ) )
                    {
                        $tables[$currtable] = $currtable;
                        $where .= " AND {$shortname}.songid = songs.id ";
                        $where .= " AND {$shortname}.section = '$type'";
                    }
                    if( $key == "uniformity" )
                    {
                            // all are the same is 1, different is 2
                        if( $val == -1 )
                            $where .= " AND {$shortname}.NumSections = 0 ";
			else if( $val == 2 )
                            $where .= " AND {$shortname}.{$field} > 1 AND {$shortname}.NumSections > 0 ";
                        else
                            $where .= " AND {$shortname}.{$field} = 1 AND {$shortname}.NumSections > 0 ";
                            
                    }
                    else if( $key == "percentoftotal" )
                    {
                            // all are the same is 1, different is 2
                        $v = explode( ":", $val );
                        
                        $where .= " AND {$shortname}.{$field} >= '$v[0]' ";
                        $where .= " AND {$shortname}.{$field} <= '$v[1]' ";
                            
                    }
                    else if( $key == "sectioncounts" && $val == -1 )
                    {
                        $where .= " AND {$shortname}.{$field} = '0'";
                    }
                    else if( $key == "sectioncounts" && $val == -2 )
                    {
                        $where .= " AND {$shortname}.{$field} >= 1";
                    }
                    else
                    {
                        $where .= " AND {$shortname}.{$field} = '$val'";
                    }
                        
                }
                break;
		
	case "minweeks":
	     $valuearr = explode( "-", $value );
	     if( count( $valuearr ) > 1 )
		 $where .= " and song_to_chart.NumberOfWeeksSpentInTheTop10 >= $valuearr[0] and song_to_chart.NumberOfWeeksSpentInTheTop10 <= $valuearr[1] ";
	     else
		 $where .= " and song_to_chart.NumberOfWeeksSpentInTheTop10 >= $value";
	     break;
		case "Tempo Range":
		case "Tempo Range General":
		    $nospaces = str_replace( " ", "", $key );
		    $where .= " and {$nospaces} = '$value'";
		    break;
		case "UseofParallelMode":
		case "CreativeWorksTitles":
		case "SlangWords":
		case "PersonReferences":
		case "UseOfAVocalPostChorus":
		case "UseOfAPreChorus":
		case "UseOfABridge":
		case "LocationReferences":
		case "OrganizationorBrandReferences":
		case "ConsumerGoodsReferences":
		case "PercentAbbreviations":
		case "PercentNonDictionary":
		// if( $key == "UseOfAPreChorus")
		// 		$key = "PreChorusCount";
		// if( $key == "UseOfAVocalPostChorus")
		// 		$key = "VocalPostChorusCount";
		// if( $key == "UseOfABridge")
		// 		$key = "BridgeCount";
		    if( $value > 0 ) 
		    $where .= " and {$key} > 0";
		else
		    $where .= " and {$key} = 0";
		break;
		case "PreChorusCount":
		case "VerseCount":
		case "ChorusCount":
		case "VocalPostChorusCount":
		    if( $value > 0 ) 
		    $where .= " and {$key} = $value";
		else
		    $where .= " and {$key} = 0";

		break;


            default :
		global $searchcolumnsdisplay;
	    if( array_search( $searchcolumnsdisplay, $key ) )
		{
		    $key = array_search( $searchcolumnsdisplay );
		    $where .= " and {$key} = '$value'";
		}
	    else if( $searchcolumnsdisplay[$key] )
		{
		    $where .= " and {$key} = '$value'";

		}
	    else
                echo( "no match 3 for $key (help)<br>" );
                break;
        }
    }
    $tables[] = "song_to_chart";
    $where .= " and song_to_chart.songid = songs.id and chartid = $_SESSION[chartid]";
    $sql = "select song_to_chart.*, " . implode( ", ", $columns ) . " from " . implode( ", ", $tables ) . " where $where order by BillboardName";
    if( $_GET["help"] ) echo( "<br>this is the final search: $sql<br>" );
    logquery( $sql );
    $retval = db_query_rows( $sql, "id" );
    file_put_contents( "/tmp/prim", "\n $sql", FILE_APPEND );
    return $retval;

}

function getFirstWeek( $songid )
{
    return db_query_first_cell( "select Name from song_to_weekdate, weekdates where songid = '$songid' and weekdateid = weekdates.id order by OrderBy" );
}

function getFirstWeekId( $songid )
{
    return db_query_first_cell( "select weekdates.id from song_to_weekdate, weekdates where songid = '$songid' and weekdateid = weekdates.id order by OrderBy" );
}

function prettyFormatDate( $date )
{
    return date( "F j, Y", strtotime( $date ) );
}

function mdyFormatDate( $date )
{
    if( $date )
	return date( "m/d/y", strtotime( $date ) );
}

function prettyFormatDatewithTime( $date )
{
    return date( "F j, Y g:iA", strtotime( $date ) );
}
function getSavedSearches( $limit = 100000 )
{
    global $userid, $proxyloginid;
    $sessid = session_id();
    $whr = $userid?" userid = '$userid'":" sessionid = '$sessid'";
    $whr .= $proxyloginid?" and proxyloginid = '$proxyloginid'":"";
//    echo( "select * from savedsearches where $whr order by dateadded desc limit $limit" );
//echo( "select * from savedsearches where $whr order by OrderBy, dateadded desc limit $limit" );
    return db_query_rows( "select * from savedsearches where $whr order by OrderBy, dateadded desc limit $limit" );
}

function getSavedArtists( $limit = 100000 )
{
    global $userid, $proxyloginid;
    $sessid = session_id();
    $whr = $userid?" userid = '$userid'":" sessionid = '$sessid'";
    $whr .= $proxyloginid?" and proxyloginid = '$proxyloginid'":"";
    return db_query_rows( "select * from savedartists where $whr order by OrderBy, dateadded desc limit $limit" );
}

function getPreviousSearch()
{
    $s = getRecentSearches(1);
    if( count( $s ) )
    {
        $s = array_pop( $s );
        return $s[url];
    }
    return "/advanced-search";

}

function getRecentSearches( $limit = 100000 )
{
    global $userid, $proxyloginid;
    $sessid = session_id();
    $whr = $userid?" userid = '$userid'":" sessionid = '$sessid'";
    $whr .= $proxyloginid?" and proxyloginid = $proxyloginid":"";
    $whr .= " and url not like '%devdb%' and url not like '%rider.edu%'";
    return db_query_rows( "select * from recentsearches where $whr and searchtype > '' order by dateadded desc limit $limit" );
}

function getFavoriteSongs( $limit = 100000 )
{
    global $userid, $proxyloginid;
    $sessid = session_id();
    $whr = "userid = '$userid'";
    $whr .= $proxyloginid?" and proxyloginid = $proxyloginid":"";
    return db_query_array( "select songid, dateadded from favorites where $whr order by dateadded desc limit $limit", "songid", "dateadded" );
}

function getTechniqueLibrary( $limit = 100000 )
{
    global $userid, $proxyloginid;
    $sessid = session_id();
    $whr = "userid = '$userid'";
    $whr .= $proxyloginid?" and proxyloginid = $proxyloginid":"";
//echo( "select tsid, dateadded from tlibrary where $whr order by dateadded desc limit $limit" );
    return db_query_rows( "select * from tlibrary where $whr order by OrderBy, dateadded desc limit $limit", "tsid" );
}

function checkValForData( $val )
{
    if( !is_array( $val ) )
    {
        return $val?true:false;
    }
    else
    {
        if( !count( $val ) )
            return false;
        $any = false;
        foreach( $val as $v )
        {
            if( $v ) $any = true;
        }
        return $any;
    }
}

$favorites = getFavoriteSongs();

function getTableRows( $table, $fordisplay = true, $orderby="OrderBy" )
{
    $whr = $fordisplay?" and HideFromAdvancedSearch = 0 ":"";
    return db_query_rows( "Select * from $table where 1 $whr  order by {$orderby}, Name" );
}
function getTableRowsArray( $table, $extrawhere = "", $fordisplay = true, $addhidewithnone = false, $hidetype = "" )
{
    $whr = $extrawhere;
    $whr .= $fordisplay?" and HideFromAdvancedSearch = 0 ":"";
    $tableext = "";
    if( $addhidewithnone )
    {
        $remove1 = substr( $table, 0, -1 );
        $whr .= " and id in ( select distinct( {$remove1}id ) from song_to_{$remove1} where songid <> 2832 {$hidetype} ) ";
    }
    // if( $table == "subgenres" )
    // 	echo( "Select * from $table where 1 $whr  order by OrderBy, Name" ); 
    return db_query_array( "Select * from $table where 1 $whr  order by OrderBy, Name", "id", "Name" );
}

function fixForAutocomplete( $row )
{
    $row = htmlentities( $row );
    $row = str_replace( "&amp;", "&", $row );
    return $row; 
}

function checkboxArray( $title, $value, $arraykey="" )
{
    global $_GET;
    echo( " name=\"search[{$title}][{$arraykey}]\" value=\"$value\"" );
    $search = $_GET["search"];
    $val = $search[$title];
    if( is_array( $val ) && in_array( $value, $val ) )
        echo( " CHECKED " );
}

$hovers = array();
$hovers = array();
function getCustomHover( $name )
{
    global $hovers;
    if( !count( $hovers ) )
        {
            $hovers = db_query_array( "select Name, Value from customhovers", "Name", "Value" );
        }
    // if( !isset( $hovers[$name] ) )
    // {
    //     db_query( "insert into customhovers ( Name )  values ( '" . escMe( $name ) . "' )" );
    //     $hovers = db_query_array( "select Name, Value from customhovers", "Name", "Value" );
        
    // }
    db_query( "update customhovers set usecount = usecount+1 where Name = '" . escMe( $name ) . "'" );
    $ext = $_GET["showhovers"]?"<a href='http://analytics.chartcipher.com/hsdmgdb/customhovers.php#$name'><font color='red'>$name</font></a>":$ext;
    return $ext.$hovers[$name];
}
$mygraphnotes = array();
function getOrCreateGraphNote( $sectionname, $extgraphnote = "" )
{
    global $mygraphnotes, $replacetotimeperiod;
    if( $sectionname ) $sectionname .= " " . $extgraphnote;
    if( !count( $mygraphnotes ) )
    {
        $mygraphnotes = db_query_array( "select Name, Value from graphnotes", "Name", "Value" );
        file_put_contents( "/tmp/gn", print_r( $mygraphnotes, true ) );
    }
    if( !in_array( $sectionname, array_keys( $mygraphnotes ) ) )
        {
            db_query( "insert into graphnotes ( Name )  values ( '" . escMe( $sectionname ) . "' )" );
            $mygraphnotes = db_query_array( "select Name, Value from graphnotes", "Name", "Value" );
            file_put_contents( "/tmp/gn",  "insert into graphnotes ( Name )  values ( '" . escMe( $sectionname ) . "' )\n", FILE_APPEND  );
            file_put_contents( "/tmp/gn", print_r( $mygraphnotes, true ), FILE_APPEND );
        }
    $descr = $mygraphnotes[$sectionname];
    $descr = nl2br( trim( $descr ) );
    if( $replacetotimeperiod )
    	$descr = str_replace( "the quarter", "the selected time period", $descr );

    $ext = $_GET["showhovers"]?"$sectionname: $ext":$ext;
    return $ext.$descr;
}
function getOrCreateCustomHover( $name, $default )
{
    global $hovers;
    if( !count( $hovers ) )
        {
            $hovers = db_query_array( "select Name, Value from customhovers", "Name", "Value" );
        }
    if( !isset( $hovers[$name] ) && $default )
    {
        $exp = explode( "-", $default );
        if( count( $exp ) > 1 )
        {
            $cat = $exp[0];
        }
        db_query( "insert into customhovers ( Name, Value, hovercategory )  values ( '" . escMe( $name ) . "', '" . escMe( $default ) . "', '" . escMe( $hovercategory ) . "' )" );
        $hovers = db_query_array( "select Name, Value from customhovers", "Name", "Value" );
    }
    db_query( "update customhovers set usecount = usecount+1 where Name = '" . escMe( $name ) . "'" );
    $ext = $_GET["showhovers"]?"<a  href='http://analytics.chartcipher.com/hsdmgdb/customhovers.php#$name'><font color='red'>$name</font></a>":$ext;
    return $ext.$hovers[$name];
}

function getOrCreateCustomTitle( $name, $default )
{
	$val = db_query_first_cell( "select Value from customtitles where Name = '" . escMe( $name ) . "'" );
    if( !$val && $default )
    {
        db_query( "insert into customtitles ( Name, Value )  values ( '" . escMe( $name ) . "', '" . escMe( $default ) . "' )" );
	$val = db_query_first_cell( "select Value from customtitles where Name = '" . escMe( $name ) . "'" );
    }
    db_query( "update customtitles set usecount = usecount+1 where Name = '" . escMe( $name ) . "'" );
    $ext = $_GET["showhovers"]?"<a  href='http://analytics.chartcipher.com/hsdmgdb/customtitles.php#$name'><font color='red'>$name</font></a>":"";
    return $ext . $val;
}

function addItalicsToParentheses( $value )
{
    $value = str_replace( "(", "(<i>", $value );
    $value = str_replace( ")", "</i>)", $value );
    return $value;
}

function getSavedSearchUrl( $type )
{
	 switch( $type ){  
// | Comparative       |
         case "Comparative":
             $query = "comparative-search";
             break; 
             
         case "Compositional Trend By Week":
             $query = "compositional-trends-by-weeks-search-results";
             break; 
             
// | Song Form         |
         case "Song Form":
             $query = "form-search";
             break; 
             
             
         case "Date Range":
             $query = "date-range-search";
             break; 
             
// | Trend Report      |
         case "Trend Report":
             $query = "trend-report-search";
             break; 
// | Trend             |
         case "Trend":
             $query = "trend-search";
             break; 
// | Genre             |

         case "Genre":
             $query = "genre-search";
             break; 
             
         case "Technique":
             $query = "technique-search";
             break; 
             
         default: 
             $query = "advanced-search";

     }
     return $query    ;
}


// this just says "if true, we can't do saved searches and stuff"
// so this needs to be false for all non automatic logins and all who have not created an account or logged in

function isStudent()
{
    global $proxyloginid; 
    if(  isAutomaticLogin() )
    {
        if( $proxyloginid ) return false;
        else return true;
    }
    return false;

}

function outputClientSelectValues( $selected )
{
    global $_SESSION;
    if( $_SESSION["loggedin"] && 1 == 0 )
    {
        $r = db_query_array( "select concat( 'client-', id ) as id, Name from clients where id in ( select distinct( ClientID ) from songs ) order by OrderBy", "id", "Name" );

        outputSelectValues( $r, $selected );
    }

}

function getPeakPositionDisplayName( $val )
{
    return strpos( $val, "client-" ) !== false?"Client:":"Peak Chart Position:";
}
function getPeakPositionDisplayValue( $val, $thevalues = array() )
{
    global $peakvalues;
    if( !count( $thevalues ) ) $thevalues = $peakvalues;
    if( strpos( $val, "client-" ) !== false )
    {
        $val = str_replace( "client-", "", $val );
        return getTableValue( $val, "clients" );
    }
    else
    {
        return $thevalues[$val]?$thevalues[$val]:$val;
    }
}

function getCleanURL( $cid )
{
	return db_query_first_cell( "select CleanURL from songs where id = $cid" );
}

function calculateCurrentQuarter( $tm  = "" )
{
    if( !$tm )
	$tm = time();
	$mon = date( "m", $tm );
	$y = date( "Y", $tm );
	if( $mon < 4 ) return "1/$y";
	if( $mon < 7 ) return "2/$y";
	if( $mon < 10 ) return "3/$y";
	return "4/$y";
	
}

function redirectTo( $url )
{
    echo( "<script language=javascript>
document.location.href='$url';
</script>" );
}


function calcSeasonsToLoop( $tmpseason )
{
    $theseseasons = array();
    if( !$tmpseason )
	{
	    $theseseasons[] = "";
	}
    else
	{
	    if( $tmpseason == ALLSEASONS )
		{
		    $theseseasons[] = WINTERCOMPARISON;
		    $theseseasons[] = SUMMERCOMPARISON;
		}
	    else if( $tmpseason == ALLSEASONS24 )
		{
		    $theseseasons[] = SPRINGCOMPARISON;
		    $theseseasons[] = FALLCOMPARISON;
		}
	    else
		{
		    $theseseasons[] = $tmpseason;
		}
	}
    return $theseseasons;
}


function fixTitleText(  $s ){

    return str_replace( '"', '\"', $s );
}

function isQuarterInFuture( $quarter, $year )
{
    return strtotime( (($quarter-1)*3+1)."/1/{$year}" ) > time();
}

function getGeneralArtistGenres( $featuredmain, $allsongs, $addall = false )
{
	$artistsforsongs = db_query_array( "select artistid from song_to_artist where songid in ( ". implode( ", ", $allsongs ) . " ) and type = '$featuredmain'", "artistid", "artistid" );
	$artistsforsongs[] = -1;
	$genres =  db_query_array( "select genres.id, genres.Name from genres where id in ( select genreid from artist_to_genre where  artistid in ( " . implode( ", " , $artistsforsongs ) . ") ) order by OrderBy, Name", "id", "Name" );
	//	echo( "select genres.id, genres.Name from genres where id in ( select genreid from artist_to_genre where  artistid in ( " . implode( ", " , $artistsforsongs ) . ") ) order by OrderBy, Name<br>" );

	$groupsforsongs = db_query_array( "select groupid from song_to_group where songid in ( ". implode( ", ", $allsongs ) . " ) and type = '$featuredmain'", "groupid", "groupid" );
	$groupsforsongs[] = -1;
	$genres2 =  db_query_array( "select genres.id, genres.Name from genres where id in ( select genreid from group_to_genre where groupid in ( " . implode( ", " , $groupsforsongs ) . ") ) order by OrderBy, Name", "id", "Name" );
	//	echo( "select genres.id, genres.Name from genres where id in ( select genreid from group_to_genre where groupid in ( " . implode( ", " , $groupsforsongs ) . ") ) order by OrderBy, Name<Br>" );
	

	// print_r( $genres );
	// print_r( $genres2 );
	$genres = $genres + $genres2;
	if( $addall )
	    $genres["0"] = "All Genres";

	//		print_r( $genres );
	return $genres;

}
if( $_SERVER["SERVER_NAME"] == "analytics.chartcipher.com" && strpos( $_SERVER['REQUEST_URI'], "autocomplete.php" ) === false && strpos( $_SERVER['REQUEST_URI'], "/members" ) === false   && strpos( $_SERVER['REQUEST_URI'], ".jpg" ) === false  && strpos( $_SERVER['REQUEST_URI'], ".svg" ) === false  && strpos( $_SERVER['REQUEST_URI'], ".png" ) === false && strpos( $_SERVER['REQUEST_URI'], "wp-admin" ) === false && strpos( $_SERVER['REQUEST_URI'], ".gif" ) === false && strpos( $_SERVER['REQUEST_URI'], ".css" ) === false&& strpos( $_SERVER['REQUEST_URI'], "ajax" ) === false && strpos( $_SERVER['REQUEST_URI'], "saveSearch" ) === false && strpos( $_SERVER['REQUEST_URI'], "hsdmgdb" ) === false )
    db_query( "insert into immersionusage( dateadded, email, userid, pagehit, ipaddress, sessionid, domain ) values ( now(), '$proxyloginid', '".($userid?$userid:0)."', '" . escMe( $_SERVER['REQUEST_URI'] ) . "', '" . escMe( $_SERVER['REMOTE_ADDR'] ) . "', '" . session_id() . "', '" . $_SERVER["SERVER_NAME"] . "' )" );

if( $_SERVER["SERVER_NAME"] == "analytics.chartcipher.com" && strpos( $_SERVER['REQUEST_URI'], "autocomplete.php" ) === false && strpos( $_SERVER['REQUEST_URI'], "/members" ) === false   && strpos( $_SERVER['REQUEST_URI'], ".jpg" ) === false  && strpos( $_SERVER['REQUEST_URI'], ".svg" ) === false  && strpos( $_SERVER['REQUEST_URI'], ".png" ) === false && strpos( $_SERVER['REQUEST_URI'], "wp-admin" ) === false && strpos( $_SERVER['REQUEST_URI'], ".gif" ) === false && strpos( $_SERVER['REQUEST_URI'], ".css" ) === false&& strpos( $_SERVER['REQUEST_URI'], "ajax" ) === false && strpos( $_SERVER['REQUEST_URI'], "saveSearch" ) === false && strpos( $_SERVER['REQUEST_URI'], "hsdmgdb" ) === false )
    db_query( "insert into immersionusage( dateadded, email, userid, pagehit, ipaddress, sessionid, domain ) values ( now(), '$proxyloginid', '".($userid?$userid:0)."', '" . escMe( $_SERVER['REQUEST_URI'] ) . "', '" . escMe( $_SERVER['REMOTE_ADDR'] ) . "', '" . session_id() . "', '" . $_SERVER["SERVER_NAME"] . "' )" );


function getDashCache( $name )
{
	$date = date( "Y-m-d" );
//	return "";
	return db_query_first_cell("select value from dashcache where thedate = '$date' and name = '$name'" );
}

function addDashCache( $name, $value )
{
	$date = date( "Y-m-d" );
	$value = escMe( $value );
	db_query( "delete from dashcache where thedate = '$date' and name = '$name'" );
	db_query("insert into dashcache ( thedate, name, value ) values (  '$date',  '$name', '$value' ) "  );
}

function getChartInfo( $songid, $chartid="" )
{
    if( !$chartid ) $chartid = $_SESSION["chartid"];
    return db_query_first( "select * from song_to_chart where songid = $songid and chartid = $chartid" );
}


?>
