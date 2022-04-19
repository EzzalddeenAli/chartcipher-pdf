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


if( 1 == 0 )
{

// Overview
// Songs in the Top 10 >>
// Most Popular Characteristics >>
// Multi-Quarter Trends >>
// Gone/Back >>
// Highest/ Lowest Levels in over a year

$reportsarr["Overview"]["Songs-in-the-Top-10"] = "Songs In The Top 10";
if( !$doingthenandnow )
    $reportsarr["Overview"]["Most-Popular-Characteristics"] = "Most Popular Characteristics";
if( !$doingyearlysearch && !$doingweeklysearch )
$reportsarr["Overview"]["Multi-Quarter-Trends"] = "Multi-Quarter Trends";
if( !$doingyearlysearch && !$doingweeklysearch )
    $reportsarr["Overview"]["Gone-Back"] = "Gone/New";
if( !$doingyearlysearch && !$doingweeklysearch )
    $reportsarr["Overview"]["Highest-Lowest-Levels"] = "Highest/ Lowest Levels In Four Or More Quarters";

$reportsarr["Artists"]["Multiple-Vs-Solo"] = "Multiple vs. Solo Artist";
$reportsarr["Artists"]["Songs-With-Featured"] = "Songs with a Featured Artist";


// Genres / Influences
// Primary Genres
// Influences
//$reportsarr["Genres & Sub-Genres"]["Genres"] = "Genres";
$reportsarr["Genres/Influencers"] = "Genres/Influencers";
//$reportsarr["Genres/Influences"]["Influence-Count"] = "Influence Count";

// Lead Vocals
// Lead Vocal Gender
// Lead Vocal Delivery
$reportsarr["Lead Vocals"]["Solo-vs-Multiple-Lead-Vocalists"] = "Solo vs. Multiple Lead Vocalists";
$reportsarr["Lead Vocals"]["Lead-Vocal"] = "Lead Vocal Gender (with solo vs. duet/group)";
$reportsarr["Lead Vocals"]["Lead-Vocal-Grouped"] = "Lead Vocal Gender (male, female, male/female)"; // new
$reportsarr["Lead Vocals"]["Lead-Vocal-Delivery"] = "Lead Vocal Delivery Type"; // new

// Lyrics & Title
// Lyrical Themes >>
// Song Title Word Count >>
// Song Title Appearances >>
$reportsarr["Lyrics & Title"]["Lyrical-Themes"] = "Lyrical Themes";
$reportsarr["Lyrics & Title"]["Song-Title-Placement"] = "Song Title Placement";
$reportsarr["Lyrics & Title"]["Song-Title-Word-Count"] = "Song Title Word Count";
$reportsarr["Lyrics & Title"]["Song-Title-Appearances"] = "Song Title Appearance Count";


// General Characteristics and Instrumentation
//     Key
//     Major vs. Minor
//     Tempo Range
//     Song Length Range
//     Prominent Instruments 
$reportsarr["General Characteristics & Instruments"]["Key"] = "Key";
$reportsarr["General Characteristics & Instruments"]["Major-Vs-Minor"] = "Key (Major vs. Minor)";
$reportsarr["General Characteristics & Instruments"]["Average-Tempo"] = "Average Tempo";
$reportsarr["General Characteristics & Instruments"]["Tempo-Range"] = "Tempo Range (BPM)";
$reportsarr["General Characteristics & Instruments"]["Average-Song-Length"] = "Average Song Length";
$reportsarr["General Characteristics & Instruments"]["Song-Length-Range"] = "Song Length Range";
$reportsarr["General Characteristics & Instruments"]["Prominent-Instrumentation"] = "Prominent Instruments";

// Structure
// First Section >>
// Intro Length Range >>
// Use Of A Pre-Chorus >>
// Chorus Preceding First Verse >>
// First Chorus: Average Time Intro Song >>
// First Chorus: Time Intro Song Range >>
// First Chorus: Average Percent Into Song >>
// First Chorus: Percent Intro Song Range >>
// Use Of A Post-Chorus >>
// Use Of A Bridge Or Bridge Surrogate >>
// Use Of An Instrumental Break >>
// Use Of A Vocal Break
// Last Section >>
// Outro Length Range >>
$reportsarr["Song Structure"]["First-Section"] = "First Section";
$reportsarr["Song Structure"]["Average-Intro-Length"] = "Average Intro Length";
$reportsarr["Song Structure"]["Intro-Length-Range"] = "Intro Length Range";
$reportsarr["Song Structure"]["Intro-Instrumental-Combo"] = "Intro Instrumental Vocal or Instrumental";
$reportsarr["Song Structure"]["Intro-Characteristics"] = "Intro Characteristics";
$reportsarr["Song Structure"]["Hook-Based-Intros"] = "Hook-Based Intros";
$reportsarr["Song Structure"]["Verse-Count"] = "Verse Count"; 
$reportsarr["Song Structure"]["Songs-That-Contain-A-Pre-Chorus"] = "Use Of A Pre-Chorus";
$reportsarr["Song Structure"]["Pre-Chorus-Count"] = "Pre-Chorus Count"; 
$reportsarr["Song Structure"]["First-Chorus-Avg-Time-Into-Song"] = "First Chorus: Average Time Into Song";
$reportsarr["Song Structure"]["First-Chorus-Time-Into-Song-Range"] = "First Chorus: Time Into Song Range";
$reportsarr["Song Structure"]["First-Chorus-Avg-Percent-Into-Song"] = "First Chorus: Average Percent Into Song";
$reportsarr["Song Structure"]["First-Chorus-Percent-Into-Song-Range"] = "First Chorus: Percent Into Song Range";
$reportsarr["Song Structure"]["Chorus-Preceding-First-Verse"] = "Chorus Preceding First Verse";
$reportsarr["Song Structure"]["Chorus-Count"] = "Chorus Count"; 
$reportsarr["Song Structure"]["Songs-That-Contain-A-Post-Chorus"] = "Use Of A Post-Chorus"; 
$reportsarr["Song Structure"]["Post-Chorus-Sections"] = "Post-Chorus Sections"; 
$reportsarr["Song Structure"]["Post-Chorus-Count"] = "Post-Chorus Count"; 
$reportsarr["Song Structure"]["Songs-That-Contain-A-Bridge-Or-Bridge-Surrogate"] = "Use Of A \"D\" Section";
$reportsarr["Song Structure"]["D-Section-Breakdown"] = "\"D\" Section Breakdown";
$reportsarr["Song Structure"]["Songs-That-Contain-A-PI"] = "Use Of An Instrumental Break";
$reportsarr["Song Structure"]["Instrumental-Break-Count"] = "Instrumental Break Count"; 
$reportsarr["Song Structure"]["Songs-That-Contain-A-VB"] = "Use Of A Vocal Break";
$reportsarr["Song Structure"]["Vocal-Break-Count"] = "Vocal Break Count"; 
$reportsarr["Song Structure"]["Last-Section"] = "Last Section";
$reportsarr["Song Structure"]["Average-Outro-Length"] = "Average Outro Length";
$reportsarr["Song Structure"]["Outro-Length-Range"] = "Outro Length Range";
//$reportsarr["Song Structure"]["Outro-Characteristics"] = "Outro Characteristics";


// for testing an individual
if( $_GET["help3"] )
    {
    $reportsarr = array();
//    $reportsarr["Genres & Sub-Genres"]["Primary-Genres"] = "Primary Genres";
    $reportsarr["Genres & Sub-Genres"]["Sub-Genres-Influencers"] = "Sub-Genres";
    }
//$reportsarr["General Characteristics & Instruments"]["Chorus-Count"] = "Chorus Count";
//$reportsarr["Overview"]["Most-Popular-Characteristics"] = "Most Popular Characteristics";

// $reportsarr["Lead Vocals"]["Single-vs-Multiple-Lead-Vocalists"] = "Solo vs. Multiple Lead Vocalists";
// $reportsarr["Lyrics & Title"]["Song-Title-Word-Count"] = "Song Title Word Count";
//$reportsarr["Genres & Sub-Genres"]["Primary-Genres"] = "Primary Genres";
//$reportsarr["Lead Vocals"]["Lead-Vocal"] = "Lead Vocal Gender";

}

//$reportsarr["Genres & Sub-Genres"]["Primary-Genres"] = "Primary Genres";


function getTrendGraphNameConverter( $sectionname )
{
    if( $sectionname == "Number Of Songs Within The Top 10" ) return "Number Of Songs Within The Top 10"; // ok
    if( $sectionname == "Carryovers vs. New Songs" ) return "Carryovers vs. New Songs"; // ok
    if( $sectionname == "Intro Instrumental Vocal or Instrumental" ) return "Intro Instrumental Vocal or Instrumental"; // ok
    if( $sectionname == "Song Title Placement" ) return "Song Title Placement"; // ok
    if( $sectionname == "Songs with a Featured Artist" ) return "Songs with a Featured Artist"; // ok
    if( $sectionname == "Songs with Solo vs. Multiple Artists" ) return "Songs with Solo vs. Multiple Artists"; // ok
    if( $sectionname == "Multiple vs. Solo Artist" ) return "Songs with Solo vs. Multiple Artists"; // ok
    if( $sectionname == "Songs With Featured" ) return "Songs with a Featured Artist"; // ok
    if( $sectionname == "Songs with Single vs. Multiple Labels" ) return "Songs with Single vs. Multiple Labels"; // ok
    if( $sectionname == "Songs that Are a Remix" ) return "Songs that Are a Remix"; // ok
    if( $sectionname == "Songs that Contain Samples" ) return "Songs that Contain Samples"; // ok
    if( $sectionname == "Artists with more than one hit" ) return "Artists with More Than One Hit"; // ok
    if( $sectionname == "Record labels with more than one hit" ) return "Record Labels with More Than One Hit"; // ok
    if( $sectionname == "Songwriters with more than one hit" ) return "Songwriters with More Than One Hit"; // ok
    if( $sectionname == "Producers and Production Teams with more than one hit" ) return "Producers and Production Teams with More Than One Hit"; // ok
    if( $sectionname == "Songs with an Artist in the Top 10 for the First Time in 1 Year vs. 3 Years" ) return "Songs with an Artist in the Top 10 for the First Time in 1 Year vs. 3 Years"; // ok
    if( $sectionname == "Songs with a Primary Artist in the Top 10 for the First Time in 1 Year vs. 3 Years" ) return "Songs with a Primary Artist in the Top 10 for the First Time in 1 Year vs. 3 Years"; // ok
    if( $sectionname == "Artists that Appear in the Top 10 for the First Time in 1 Year vs. 3 Years" ) return "Artists that Appear in the Top 10 for the First Time in 1 Year vs. 3 Years"; // ok
    if( $sectionname == "Songwriters that Appear in the Top 10 for the First Time in 1 Year vs. 3 Years" ) return "Songwriters that Appear in the Top 10 for the First Time in 1 Year vs. 3 Years"; // ok
    if( $sectionname == "Record Labels that Appear in the Top 10 for the First Time in 1 Year vs. 3 Years" ) return "Record Labels that Appear in the Top 10 for the First Time in 1 Year vs. 3 Years"; // ok
    if( $sectionname == "Record Labels" ) return "Record Labels"; // ok
    if( $sectionname == "Songwriters" ) return "Percentage of Songs"; // ok
    if( $sectionname == "Songwriter Team Size" ) return "Songwriter Team Size"; // ok
    if( $sectionname == "Producer Team Size" ) return "Producer Team Size"; // ok
    if( $sectionname == "Performing Artist Team Size" ) return "Performing Artist Team Size"; // ok
    if( $sectionname == "Tempo Range (BPM)" ) return "Tempo Range"; // ok
    if( $sectionname == "Lead Vocals" ) return "Lead Vocals"; // ok
    if( $sectionname == "Solo vs. Multiple Lead Vocalists" ) return "Solo vs. Multiple Lead Vocalists"; // ok
    if( $sectionname == "Lead Vocal" ) return "Lead Vocals"; // ok
    if( $sectionname == "Lead Vocal Gender (with solo vs. duet/group)" ) return "Lead Vocal Gender"; // ok
    if( $sectionname == "Lead Vocal Delivery Type" ) return "Lead Vocal Delivery"; // ok
//    if( $sectionname == "Primary Genres" ) return "Primary Genres"; // ok
    if( $sectionname == "Key (Major vs. Minor)" ) return "Major vs. Minor"; // ok
    if( $sectionname == "Key" ) return "Key"; // ok
    if( $sectionname == "Sub-Genres" ) return "Sub-Genres"; // ok
    if( $sectionname == "Lyrical Themes" ) return "Lyrical Themes";
    if( $sectionname == "Song Title Word Count" ) return "Song Title Word Count"; // ok
    if( $sectionname == "Sub-Genre Count" ) return "Sub-Genre Count"; // ok
    if( $sectionname == "Song Title Appearance Count" ) return "Song Title Appearances"; // ok
    if( $sectionname == "Prominent Instruments" ) return "Prominent Instruments"; // ok
    if( $sectionname == "Electronic Vs. Acoustic Songs" ) return "Electronic Vs. Acoustic Songs"; // ok
    if( $sectionname == "A-B-A-B-D-B Form" ) return "A-B-A-B-D-B Form";  // ok
    if( $sectionname == "Average Song Length" ) return "Average Song Length"; // ok
    if( $sectionname == "Song Length Range" ) return "Song Length Range"; // ok
    if( $sectionname == "First Section" ) return "First Section"; // ok
    if( $sectionname == "Average Intro Length" ) return "Average Intro Length"; // ok
    if( $sectionname == "Average Tempo" ) return "Average Tempo"; // ok
    if( $sectionname == "Intro Length Range" ) return "Intro Length Range"; // ok 
    if( $sectionname == "Use Of A Pre-Chorus" ) return "Use Of A Pre-Chorus";
    if( $sectionname == "Chorus Preceding First Verse" ) return "Chorus Preceding First Verse"; 
    if( $sectionname == "First Chorus: Average Time Into Song" ) return "First Chorus: Average Time Into Song"; // ok
    if( $sectionname == "First Chorus: Time Into Song Range" ) return "First Chorus: Time Into Song Range"; //  ok
    if( $sectionname == "First Chorus: Average Percent Into Song" ) return "First Chorus: Average Percent Into Song"; // ok
    if( $sectionname == "First Chorus: Percent Into Song Range" ) return "First Chorus: Percent Into Song Range"; // ok
    if( $sectionname == "Use Of A Post-Chorus" ) return "Use Of A Post-Chorus";  // ok
    if( $sectionname == "Departure Section" ) return "Departure Section"; //  ok
    if( $sectionname == "Use Of A \"D\" Section" ) return "Departure Section"; //  ok
    if( $sectionname == "\"D\" Section Breakdown" ) return "\"D\" Section Breakdown"; //  ok
    if( $sectionname == "Use Of An Instrumental Break" ) return "Use Of An Instrumental Break"; // ok
    if( $sectionname == "Use Of A Vocal Break" ) return "Use Of A Vocal Break"; // ok
    if( $sectionname == "Last Section" ) return "Last Section"; // ok
    if( $sectionname == "Average Outro Length" ) return "Average Outro Length"; // ok
    if( $sectionname == "Intro Characteristics" ) return $sectionname; // ok
    if( $sectionname == "Hook-Based Intros" ) return $sectionname; // ok
    if( $sectionname == "Vocal Break Count" ) return $sectionname; // ok
    if( $sectionname == "Intro Instrumental Vocal or Instrumental" ) return "Intro: Instrumental, Vocal, Combo"; // ok
    if( $sectionname == "Pre-Chorus Count" ) return $sectionname; // ok
    if( $sectionname == "Post-Chorus Count" ) return $sectionname; // ok
    if( $sectionname == "Post-Chorus Sections" ) return $sectionname; // ok
    if( $sectionname == "Chorus Count" ) return $sectionname; // ok
    if( $sectionname == "Instrumental Break Count" ) return $sectionname; // ok
    if( $sectionname == "Verse Count" ) return $sectionname; // ok
    if( $sectionname == "Outro Length Range" ) return $sectionname; // ok
    if( $sectionname == "Lead Vocal Gender (male, female, male/female)" ) return "Lead Vocal Grouped" ; // ok

    return "";
    
}

function gatherCharacteristicsSingleQuarter( $thisquarter, $type )
{
    $retval = array();
    global $reportsarr, $nogainers, $quarterstorun, $search, $industrytrendreports, $doingyearlysearch, $doingweeklysearch, $doingquarterrange, $doinghomepage, $possiblesearchfunctions;
    $pos = $search["peakchart"];
    $arrtouse = $reportsarr;
    if( $type == "most" || $type == "least" )
	{
	    if( $doingyearlysearch ) // this is sooo ugly
		$qarr = "fullrange";
	    else if( $doingweeklysearch ) // this is sooo ugly
		$qarr = "fullrangeweek";
	    else if( $doingquarterrange ) // this is sooo ugly
		$qarr = "fullrangequarter";
	    else
		$qarr = array( $thisquarter );
	}
    else	
	{	
	    $qarr = $quarterstorun;
	}

	    if( $doingweeklysearch )
		$allsongs = getSongIdsWithinWeekdates( false, $search[dates][fromweekdate], $search[dates][toweekdate], $pos );
	    else 
		$allsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], $pos );
	    //	    echo( count( $allsongs ) . "<br>" );
	$flip = array_flip( $possiblesearchfunctions );

	    // if( $_GET["help"] ) 
	    // 	echo( "num total songs: " . count( $allsongs ) . "<br>");
	    //	    print_r( $arrtouse );
    foreach( $arrtouse as $tmpreportsarr )
    {
        foreach( $tmpreportsarr as $reportname=>$displ )
        {
            if( $displ == "Songwriters" ) continue;
            if( $displ == "Key" ) continue;
//            if( $displ == "Prominent Instruments" ) continue;
	    // for the ordering
	    if( isset( $retval[$displ . ":"] ) ) 
		{
		    continue;
		}
            // if( !getTrendGraphNameConverter( $displ ) ) { 
	    // 	//		echo( "skipping $displ<br>" );
	    // 	continue;
	    // }
            if( in_array( $reportname, $nogainers ) ) continue;
            $comparisonaspect = $reportname;
            $mysearch = $search;
            $mysearch["comparisonaspect"] =$comparisonaspect;
	    //	    echo( $reportname . "<br>");
            
	    //	    echo( "num songs: " . count( $allsongs ) . "<br>");
            $rows = getRowsComparison( $mysearch, $allsongs );
            $data = getTrendDataForRows( $qarr, $comparisonaspect, $pos );
	    if( $displ == "Intro Length Range" )
		{
		    //		    		    print_r( $data );
		}

		if( $displ == "Lead Vocal Gender" )
		    {
			// hard coding this one
			$newoutput = array();
			foreach( array( "Male", "Female", "Female/Male" ) as $gender )
			    {
				$val = 0;
				$singlecount = 0;
				foreach( $data as $quarterstr=>$values )
				    {
					foreach( $values as $dkey=>$d )
					    {
						//						echo( "$dkey, $gender " . print_r( $d, true ) ." <br>" );
						$thisval = $d[4] * 100 / ($d["numsongs"]);

						if( strpos( $dkey, "All $gender" ) !== false || strpos( $dkey, "Solo $gender" ) !== false )
						    {
							//							echo( "adding {$d[0]} to $gender<br>" );
							$val += $thisval;
							$singlecount += $d[4];
						    }
						if( $gender == "Female/Male" && $dkey ==  "Duet/Group (Female/Male)" )
						    {
							//							echo( "adding {$d[0]} to $both<br>" );
							$val += $thisval;
							$singlecount += $d[4];
						    }
					    }
					$genderstr = $gender == "Female/Male"?$gender:"Exclusively $gender";
					$dtstr = $_GET["search"]["dates"]["fromq"] . "/" . $_GET["search"]["dates"]["fromy"] . "-" . $_GET["search"]["dates"]["toq"] . "/" . $_GET["search"]["dates"]["toy"];
					$qs = calcTrendQSStart( $dtstr );
					$newoutput[$quarterstr][$genderstr] = array( number_format( $val ), 0, 0, "search-results?$qs&search[vocalsgenderspecific]={$gender}", $singlecount );
				    }
			    }
			// print_r( $data );
			//			print_r( $newoutput );
			$data = $newoutput;
		    }
            
                // MAX VALUES
            
            $max = 0;
            $min = 10000;
            foreach( $data as $quarterstr=>$values )
            {
                
                foreach( $values as $vid=>$varr )
                {
		    // if( $displ == "Outro Length Range" )
		    // 	echo( "in one, $vid: " . print_r( $varr, true ) );
		    if( strpos( $displ, " Count" ) !== false && !$vid ) continue;
		    if( $vid == "null" ) continue;
		    if( $vid == "None" ) continue;
		    if( strpos( $displ, "Post-Chorus Sections" ) !== false && $vid == "No Post-Chorus" ) continue;
                    if( $vid === "Duet/Group (All)" || $vid === "No Outro" || $vid === "No Intro" ) {
                            // if( $displ == "Use Of A Post-Chorus" )
                            //     echo ("skipping" );
                        continue;
                    }
                    if( $type == "most" )
                    {
                            // if( $displ == "Use Of A Post-Chorus" )
                            //     echo( "comparing $max to $varr[0]<br>" );
                        
                        if( $varr[0] > $max ) $max = $varr[0];
                    }
                    if( $type == "least" )
                    {
                        if( $varr[0] < $min ) $min = $varr[0];
                    }
                }
                
            }
            $valtouse = 0;
            if( $type == "most" )
                $valtouse = $max;
            if( $type == "least" )
                $valtouse = $min;
            
	    // if( $displ == "Use Of A Bridge Or Bridge Surrogate" )
	    // 	echo( "$displ: " . $valtouse . print_r( $data, true ) . "<br>");
            
            $matchingarr = array();
	    $numsongs = 0;
            foreach( $data as $quarterstr=>$values )
            {
                foreach( $values as $vid=>$varr )
                {
                    if( $varr[0] == $valtouse )
                    {

                        $touse = $rows[$vid]?$rows[$vid]:$vid;
			if( strtolower( $touse ) === "no" ) continue;
			if( strtolower( $touse ) === "yes" && $valtouse < 50 ) continue;
			if( strpos( $displ, " Count" ) !== false && !$touse ) continue;
			if( strpos( $displ, "Post-Chorus Sections" ) !== false && $touse == "No Post-Chorus" ) continue;
			//			if( $touse == "Chorus does not precede First Verse" ) continue;
			if( $doinghomepage )
			    {
				$touse = "<a href='$varr[3]'>$touse</a>";
			    }
                        $matchingarr[] = $touse;
			$numsongs = $varr[4];
                        if( !$rows[$vid] ) {
                            // echo( "<br><br>$comparisonaspect: no match so - $vid - ... <br>" );
                            // print_r( $rows );
                            // echo( "<br>" );
                            // print_r( $data );
                            // echo( "<br>" );
                        }
                    }
                }
            }
//        echo( "$comparisonaspect : val:" . $valtouse . "<br>" );
	    
            if( count( $matchingarr ) )
		{
		    $son = $numsongs > 1?"songs":"song";
		    $each = count( $matchingarr ) > 1 ?" each":"";
		    if( $numsongs )
			{
			if( $_SESSION["loggedin"] )
			    $retval[$displ . ":"] = implode( ", ", $matchingarr ) . " ($numsongs {$son}{$each}, {$valtouse}% of songs)"; //  
			else
			    $retval[$displ . ":"] = implode( ", ", $matchingarr ) . " ({$valtouse}% of songs)"; // , $numsongs {$son}{$each}
			}
		}
//        print_r( $matchingarr );
            
        }
    }
    

    return $retval;
}


function gatherCharacteristicsMultipleQuarters( $quarterstorun, $type )
{
    $retval = array();
    global $reportsarr, $nogainers, $search, $oldestq, $oldesty, $quarter, $year, $thisquarter, $industrytrendreports;

    $qarr = $quarterstorun;

        $arrtouse = $reportsarr;
//echo( "arr:" ) ;
//	    print_r( $arrtouse );
//	    print_r( $quarterstorun );
    foreach( $arrtouse as $tmpreportsarr )
    {
        foreach( $tmpreportsarr as $reportname=>$displ )
        {

//	    echo( "doing $reportname ($displ)" );
//	    continue;
            if( in_array( $reportname, $nogainers ) ) continue;
//	    echo( "doing $reportname<br>" );
            $comparisonaspect = $reportname;
            $mysearch = $search;
            $mysearch["comparisonaspect"] =$comparisonaspect;
            $mysearch["dates"]["fromq"] = $oldestq;
            $mysearch["dates"]["fromy"] = $oldesty;
            $mysearch["dates"]["toq"] = $quarter;
            $mysearch["dates"]["toy"] = $year;

            $allsongs = getSongIdsWithinQuarter( false, $oldestq, $oldesty, $quarter, $year, $pos );
            
            $rows = getRowsComparison( $mysearch, $allsongs );
                // echo( "<br><br>rows: <br><br>" );
//            echo( $reportname . "<br>" );
                // print_r( $rows );
                // echo( "<br><br>" );
            $data = getTrendDataForRows( $qarr, $comparisonaspect );


		if( $displ == "Lead Vocal Gender" )
		    {
			// hard coding this one
			$newoutput = array();
			foreach( array( "Male", "Female", "Female/Male" ) as $gender )
			    {
				$val = 0;
				foreach( $data as $quarterstr=>$values )
				    {
					foreach( $values as $dkey=>$d )
					    {
						//						echo( "$dkey, $gender <br>" );
						if( strpos( $dkey, "All $gender" ) !== false || strpos( $dkey, "Solo $gender" ) !== false )
						    {
							$val += $d[0];
						    }
						if( $gender == "Female/Male" && $dkey ==  "Duet/Group (Female/Male)" )
						    {
							$val += $d[0];
						    }
					    }
					$genderstr = $gender == "Female/Male"?$gender:"Exclusively $gender";
					$newoutput[$quarterstr][$genderstr] = array( $val );
				    }
			    }
			// print_r( $data );
			// print_r( $newoutput );
			$data = $newoutput;
		    }

		if( strpos( $displ, "Key" ) !== false && count( $rows ) == 2 && 1==0)
	    	{
	    	    echo( "<br><br>data: <br><br>" ); 
	    	    print_r( $data );
	    	    echo( "<br><br>" );
	    	    print_r( $rows );
	    	    echo( "<br><br>" );
	    	}
            
                // MAX VALUES
            
            
            $matchingarr = array();
            
            
            foreach( $rows as $key=>$rowdispl )
            {
                $oktoadd = true;
                $maxmin = 0;
                if( $type == "lowest" ) $maxmin = 99999;
                $prevvalue = 0;
                if( $type == "downward" ) $prevvalue = 99999;
                foreach( $data as $tmpquarter=>$values )
                {
                    // if( $displ == "Outro Length Range" )
		    // 	echo( $rowdispl . "<br>" );
                    $thisval = $values[$key][0];
                    if( !$thisval ) $thisval = 0;

		    // these values will not display nmw
		    if( $rowdispl === "null" ) $oktoadd = false;
		    if( $rowdispl === "No Outro" ) $oktoadd = false;
		    if( $rowdispl === "No Intro" ) $oktoadd = false;
                        // if( $rowdispl == "No Intro" )
                        //     echo( $quarter . ": " . $thisval. "<br>" );
//                echo( $tmpquarter . ", " . $thisquarter . "<br>");
                    if( $type == "upward" )
                    {
			// was 3
                        if( $thisval-1 <= $prevvalue ) $oktoadd = false;
                    }
                    if( $type == "downward" )
                    {
			// was 3? 
                        if( $thisval+1 >= $prevvalue ) $oktoadd = false;
		// if( strpos( $displ, "Key" ) !== false && count( $rows ) == 2 )
	    	// {
		// 	echo( "$displ($rowdispl): $thisval, $prevvalue<br>" );
		// 	echo( "$oktoadd<Br>" );
		// }
                    }
                    if( $type == "highest" )
                    {
                        if( $thisquarter != $tmpquarter && $maxmin < $thisval )
                        {
			    // if( strpos( $displ, "Song Length Range" ) !== false )
			    // 	echo( "$tmpquarter ($rowdispl) ($thisval) SETTING MAX to $thisval, was " . $maxmin . "<br>");
                            $maxmin = $thisval;
                        }
			if( $thisquarter == $tmpquarter )
			    {
				//                        echo( "$rowdispl ($thisval) MAX:" . $maxmin . "<br>");
				$oktoadd = $thisval-1 > $maxmin;
			    }
                    }
                    if( $type == "lowest" )
                    {
                        if( $thisquarter != $tmpquarter && $thisval < $maxmin )
                            $maxmin = $thisval;
                        if( $thisquarter == $tmpquarter )
                        {
//                        echo( "$rowdispl ($thisval) MIN:" . $maxmin . "<br>" );
                            $oktoadd = $thisval+1 < $maxmin;
                        }
                    }
                    $prevvalue = $thisval;
                    
                }
                if( $oktoadd ) $matchingarr[] = $rowdispl;
                
            }
            
//       echo( "$comparisonaspect : val:" . $valtouse . "<br>" );
            if( count( $matchingarr  ) )
                $retval[$displ . ":"] = implode( ", ", $matchingarr ) . "";
//       print_r( $matchingarr );
            
        }
    }
    return $retval;
}


function gatherCharacteristics2Quarters( $quarter, $year, $prevq, $prevyear, $type )
{
    $retval = array();
    global $reportsarr, $nogainers, $search, $thisquarter, $industrytrendreports;

    $qarr = $quarterstorun;
    if( isset( $industrytrendreports ) )
        $arrtouse = $industrytrendreports;
    else
	{
	    $arrtouse = $reportsarr;
	    $fixtures = array( "Primary-Genres"=>"Primary Genres", "Sub-Genres-Influencers"=>"Sub-Genres", "Influence-Count"=>"Influence Count" );
	    array_unshift( $arrtouse, $fixtures );
	}

    foreach( $arrtouse as $tmpreportsarr )
    {
        foreach( $tmpreportsarr as $reportname=>$displ )
        {
            
//        if( $displ != "Lead Vocal" ) continue;
            if( $displ == "Songwriters" ) continue;
            if( !getTrendGraphNameConverter( $displ ) ) continue;
            if( in_array( $reportname, $nogainers ) ) continue;
            $comparisonaspect = getTrendGraphNameConverter( $displ );
            $mysearch = $search;
            $mysearch["comparisonaspect"] =$comparisonaspect;
            $mysearch["dates"]["fromq"] = $prevq;
            $mysearch["dates"]["fromy"] = $prevyear;
            $mysearch["dates"]["toq"] = $quarter;
            $mysearch["dates"]["toy"] = $year;
            
            $allsongs = getSongIdsWithinQuarter( false, $prevq, $prevyear, $quarter, $year, $pos );
            
            $rows = getRowsComparison( $mysearch, $allsongs );
                // echo( "<br><br>rows: <br><br>" ); 
                // print_r( $rows );
                // echo( "<br><br>" );
            $qarr = array( "$prevq/$prevyear", "$quarter/$year" );

            $data = getTrendDataForRows( $qarr, $comparisonaspect );

		if( $displ == "Lead Vocal Gender" )
		    {
			// hard coding this one
			$newoutput = array();
			foreach( array( "Male", "Female", "Female/Male" ) as $gender )
			    {
				$val = 0;
				foreach( $data as $quarter=>$values )
				    {
					foreach( $values as $dkey=>$d )
					    {
						//						echo( "$dkey, $gender <br>" );
						if( strpos( $dkey, "All $gender" ) !== false || strpos( $dkey, "Solo $gender" ) !== false )
						    {
							$val += $d[0];
						    }
						if( $gender == "Female/Male" && $dkey ==  "Duet/Group (Female/Male)" )
						    {
							$val += $d[0];
						    }
					    }
					$genderstr = $gender == "Female/Male"?$gender:"Exclusively $gender";
					$newoutput[$quarter][$genderstr] = array( $val );
				    }
			    }
			// print_r( $data );
			// print_r( $newoutput );
			$data = $newoutput;
		    }

		// if( $displ == "Key" )
		//     {
		// 	echo( "<br><br>data: <br><br>" ); 
		// 	echo( nl2br( print_r( array_keys( $data ), true ) ) );
		// 	echo( "<br><br>" );
		//     }
            
                // MAX VALUES
            
            $matchingarr = array();
            
            foreach( $rows as $key=>$rowdispl )
            {
                $oktoadd = false;
                $maxmin = 0;
                $prevvalue = "";
                foreach( $data as $tmpquarter=>$values )
                {
                    $thisval = $values[$key][0];
                    if( $thisquarter == $tmpquarter )
                    {
                        if( $type == "back" )
                        {
                            if( !$prevvalue && $thisval ) $oktoadd = true;
                        }
                        if( $type == "gone" )
                        {
                            if( $prevvalue && !$thisval )
                            {
                                $oktoadd = true;
//                            echo( "$prevvalue , $thisval so adding $rowdispl!<br>" );
                            }
                        }
                    }
                    else
                    {
                            // not this quarter
                        $prevvalue = $thisval;
                    }
                    
                }
                if( $oktoadd ) $matchingarr[] = $rowdispl;
                
        }
            
//       echo( "$comparisonaspect : val:" . $valtouse . "<br>" );
            if( count( $matchingarr  ) )
                $retval[$displ . ":"] = implode( ", ", $matchingarr ) . "";
//        print_r( $matchingarr );
            
        }
    }
    return $retval;
}





function printGainersLosers( $dataforrows, $rows ) // not sure if rows is neede
{
    $thisq= array_pop( $dataforrows );
    $prevq= array_pop( $dataforrows );

    $gainers = array();
    $losers = array();
    $constants = array();

    if( $_GET["help"] ) { 
        print_r( $rows );
        echo( "<br><br> This Q:" );
        print_r( $thisq );
    }
    foreach( $rows as $rowid=>$rowval )
    {
        $currval = $thisq[$rowid][0];
        $prevval = $prevq[$rowid][0];
        if( !$currval && !$prevval ) continue;

        if( abs( ceil( $currval - $prevval ) ) <= 3 )
            $constants[] = "$rowval" . ($_GET["help"]?" ($prevval $currval)" :"" );
        else if( ( ceil( $currval - $prevval ) ) > 0 )
            $gainers[] = "$rowval" . ($_GET["help"]?" ($prevval $currval)" :"" );
        else if( ( ceil( $currval - $prevval ) ) < 0 )
            $losers[] = "$rowval" . ($_GET["help"]?" ($prevval $currval)" :"" );
    }

    if( !$gainers )
        $gainers[] = "None";
    if( !$losers )
        $losers[] = "None";
    if( !$constants )
        $constants[] = "None";
    
    $retval = "";
    
    $retval .= "<div class='row'>";
    $retval .= "<div class='col-4'> ";
    $retval .= "<h3>On the Rise - Top 10</h3>";
    $retval .= "<ul class='listB'>";
    foreach( $gainers as $g )
        $retval .= "<li><span>$g</span></li>";
    $retval .= "</ul>";
    $retval .= "</div>";
    $retval .= "<div class='col-4'>";
    $retval .= "<h3>In Decline - Top 10</h3>";
    $retval .= "<ul class='listB'>";
    foreach( $losers as $g )
        $retval .= "<li><span>$g</span></li>";
    $retval .= "</ul>";
    $retval .= "</div>";
    $retval .= "<div class='col-4'>";
    $retval .= "<h3>Constants - Top 10 (+/- 3%)</h3>";
    $retval .= "<ul class='listB'>";
    foreach( $constants as $g )
        $retval .= "<li><span>$g</span></li>";
    $retval .= "</ul>";
    $retval .= "</div>";
    $retval .= "</div>";
    return $retval;
    
}


?>
