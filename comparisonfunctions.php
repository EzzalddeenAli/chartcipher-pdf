<?php

$possiblecomparisonfilters = array();
if( $thetype == "industry" )
{
    $possiblecomparisonfilters["Weeks in the Top 10"] = "Weeks in the Top 10";
    $possiblecomparisonfilters["Weeks at Number 1"] = "Weeks at #1";

    $possiblecomparisonaspects = array();
    $possiblecomparisonaspects["Songs"] = "Songs";
    $possiblecomparisonaspects["Performing Artist"] = "Performing Artist";
    $possiblecomparisonaspects["Songwriters"] = "Songwriters";
    $possiblecomparisonaspects["Producers"] = "Producers";
    $possiblecomparisonaspects["Record Labels"] = "Record Labels";
//    $possiblecomparisonaspects["Primary Genre"] = "Primary Genre";
//    $possiblecomparisonaspects["Lead Vocal Gender"] = "Lead Vocal Gender";

}
else
{
    $possiblecomparisonfilters["Performing Artist"] = "Performing Artist";
    $possiblecomparisonfilters["Songwriters"] = "Songwriters";
    $possiblecomparisonfilters["Producers"] = "Producers";
    $possiblecomparisonfilters["Record Labels"] = "Record Labels";
    $possiblecomparisonfilters["Songs"] = "Songs";
    $possiblecomparisonfilters["#1 Hits"] = "#1 Hits";
    $possiblecomparisonfilters["Top 10"] = "Top 10";


    $pccounts = array();
    $possiblecomparisonaspects = array();
    $pccounts[count( $possiblecomparisonaspects )] = "Genre";
    $possiblecomparisonaspects["Genre"] = "Primary Genre";
    $possiblecomparisonaspects["Sub-Genre/Influence"] = "Sub-Genre/Influence";

    $pccounts[count( $possiblecomparisonaspects )] = "Vocals & Lyrics";
    $possiblecomparisonaspects["VocalsGender"] = "Lead Vocal Gender (with solo vs. duet/group)";
    $possiblecomparisonaspects["Vocals Grouped"] = "Lead Vocal Gender (male, female, male/female)";
    $possiblecomparisonaspects["Solo vs. Multiple Lead Vocalists"] = "Solo vs. Multiple Lead Vocalists";
    $possiblecomparisonaspects["Solo vs. Multiple Artists"] = "Solo vs. Multiple Artists";
    $possiblecomparisonaspects["Songs with a Featured Artist"] = "Songs with a Featured Artist";
    $possiblecomparisonaspects["Lyrical Themes"] = "Lyrical Themes";
    $possiblecomparisonaspects["SongTitleAppearanceRange"] = "Song Title Appearance Count";
    $possiblecomparisonaspects["SongTitleWordCount"] = "Song Title Word Count";
    $possiblecomparisonaspects["Song Title Placement"] = "Song Title Placement";


    $pccounts[count( $possiblecomparisonaspects )] = "General Structure & Instruments";
    $possiblecomparisonaspects["Instrumentation"] = "Prominent Instruments";
    $possiblecomparisonaspects["Electronic Vs Acoustic Instrumentation"] = "Electronic vs. Acoustic Instrumentation";
    $possiblecomparisonaspects["Key"] = "Key";
    $possiblecomparisonaspects["MajorMinor"] = "Key (Major vs. Minor)";
    $possiblecomparisonaspects["TempoRange"] = "Tempo Range (BPM)";
    $possiblecomparisonaspects["SongLengthRange"] = "Song Length Range";
    $possiblecomparisonaspects["timesignatureid"] = "Time Signature";


    $pccounts[count( $possiblecomparisonaspects )] = "First Section";
    $possiblecomparisonaspects["FirstSectionType"] = "First Section Type"; 
    $possiblecomparisonaspects["IntroLengthRangeNums"] = "Intro Length Range";
    $possiblecomparisonaspects["IntroVocalVsInst"] = "Intro Instrumental, Vocal or Instrumental & Vocal";

    $pccounts[count( $possiblecomparisonaspects )] = "Verse";
    $possiblecomparisonaspects["Verse Count"] = "Verse Count";
    $possiblecomparisonaspects["Verse Length Uniformity"] = "Verse Length Uniformity";

    $pccounts[count( $possiblecomparisonaspects )] = "Pre-Chorus"; 
    $possiblecomparisonaspects["Contains Pre-Chorus"] = "Use of a Pre-Chorus";
    $possiblecomparisonaspects["Pre-Chorus Count"] = "Pre-Chorus Count";

    $pccounts[count( $possiblecomparisonaspects )] = "Chorus"; 
    $possiblecomparisonaspects["FirstChorusRange"] = "First Chorus: Time into Song Range";
    $possiblecomparisonaspects["Chorus Count"] = "Chorus Count";
    $possiblecomparisonaspects["ChorusPrecedesVerse"] = "Chorus Precedes First Verse";
    $possiblecomparisonaspects["Chorus Length Uniformity"] = "Chorus Length Uniformity";

    $pccounts[count( $possiblecomparisonaspects )] = "Post-Chorus"; 
    $possiblecomparisonaspects["Contains Post-Chorus"] = "Use of a Post-Chorus";
    //    $possiblecomparisonaspects["Post Chorus Count"] = "Post Chorus Count";// new

    $pccounts[count( $possiblecomparisonaspects )] = "\"D\" (Departure Section)"; 
    $possiblecomparisonaspects["Contains Bridge Surrogate"] = "Use of a Bridge Surrogate";
    $possiblecomparisonaspects["Bridge Count"] = "Bridge Count";

    $pccounts[count( $possiblecomparisonaspects )] = "Instrumental & Vocal Breaks"; 

    //    $possiblecomparisonaspects["Use of an Instrumental or Vocal Break"] = "Use of an Instrumental or Vocal Break";// new
    $possiblecomparisonaspects["Instrumental Break Count"] = "Instrumental Break Count";
    $possiblecomparisonaspects["Vocal Break Count"] = "Vocal Break Count";

    $pccounts[count( $possiblecomparisonaspects )] = "Last Section"; 

    $possiblecomparisonaspects["LastSectionType"] = "Last Section Type";
    $possiblecomparisonaspects["OutroLengthRangeNums"] = "Outro Length Range";


    //    $pccounts[count( $possiblecomparisonaspects )] = "Other"; 

    //    $possiblecomparisonaspects["Vocal Delivery Type"] = "Vocal Delivery Type";


}

function getComparisonColumnName( $str )
{
	if( $str == "Producers" )
	return "Producer / Production Team";
	return $str;
}

function getAcrossTheTopComparison( $search )
{
    global $grouptypes, $thetype;
    $acrossthetop = array();
    
    switch( $search["comparisonfilter"] )
    {
        case "Performing Artist":
        case "Songwriters":
        case "Producers":
            $key = $search["comparisonfilter"]=="Performing Artist"?"primaryartist":"writer";
	if( $search["comparisonfilter"] == "Producers" ) $key = "producer";
        foreach( $search[$key] as $throwaway=>$value )
	    {
            if( !$value ) continue;
            $vals = $grouptypes[$key];
            $table = $vals[0];
            $type = $vals[1];
            $shortname = "wkey{$type}";
            
            $vid = db_query_first_cell( "select id from {$table}s where Name = '" . escMe( $value )."' ");
            if( !$vid && $table == "artist" )
                $vid = db_query_first_cell( "select id from {$table}s where FullBirthName = '" . escMe( $value )."' ");
            
            if( !$vid && $table == "artist" )
            {
                $vid = db_query_first_cell( "select id from groups where Name = '" . escMe( $value )."' ");
                if( $vid )
                {
                    $table = "group";
                }
            }
            $acrossthetop["{$table}_{$vid}"] = $value;
        }
        break;
        case "Record Labels":
        case "Primary Genre":
            $table = $search["comparisonfilter"]=="Record Labels"?"label":"genre";
        $key = $search["comparisonfilter"]=="Record Labels"?"labelid":"GenreID";
//        print_r( $search );
        foreach( $search[$key] as $throwaway=>$value )
        {
            if( !$value ) continue;
            $acrossthetop["{$table}_{$value}"] = getTableValue( $value, $table. "s" );
        }
        
        break;
        case "Vocal Gender":
            $key = "vocalsgender";
            foreach( $search[$key] as $throwaway=>$value )
            {
                if( !$value ) continue;
                $acrossthetop["VocalsGender_{$value}"] = $value;
            }
            break;
        case "Songs":
            $key = "songname";
            foreach( $search[$key] as $throwaway=>$value )
            {
                if( !$value ) continue;
                $sid = db_query_first_cell( "select songs.id from songs, songnames where songs.songnameid = songnames.id and Name = '" . escMe( $value ) . "'" );
                if( !$sid )
                {
                    $sid = db_query_first_cell( "select songs.id from songs, songnames where songs.songnameid = songnames.id and Name like '" . escMe( $value ) . "%'" );
                }
                if( !$sid )
                {
                    $sid = "0";
                }
                $acrossthetop["Song_{$sid}"] = $value;
            }
            break;
        case "#1 Hits":
            $acrossthetop["#1 Hits"] = "#1 Hits";
            break;
        case "Top 10":
            $acrossthetop["Top 10"] = "Top 10";
	    break;
        case "Songwriter Team Size":
            $dist = db_query_array("select distinct( SongwriterCount )  from songs where SongwriterCount > 0 order by SongwriterCount", "SongwriterCount", "SongwriterCount" );
            foreach( $dist as $d )
            {
                $w = $d==1?"Writer":"Writers";
                $acrossthetop["STS_" . $d] = "$d $w"; 
            }
	    break;
        case "All Songs":
            $acrossthetop["All Songs"] = "All Songs";
	    break;
        case "Weeks in the Top 10":
            $acrossthetop["Number of Weeks"] = "Weeks in the Top 10";
	    break;
        case "Weeks at Number 1":
            $acrossthetop["Weeks at #1"] = "Weeks at #1";
            // if( $thetype == "industry" && $search["comparisonaspect"] != "Songs" )
            //     $acrossthetop["Total Number of Weeks"] = "Total Number of Weeks";
	    break;
        default:
            break; 
    }

    return $acrossthetop;
}

function getRowsComparison( $search, $songs )
{
    $rows = array();
    $field = $search["comparisonaspect"];
    $obs = array( "SongTitleAppearanceCount"=>"SongTitleAppearances" );
    $obs["SongLengthRange"] = "SongLength";
    $obs["SongTitleWordCount"] = "SongTitleWordCount";
    $obs["FirstSectionType"] = "FirstSectionType";
    $obs["SongTitleAppearanceRange"] = " SongTitleAppearances ";
    $obs["FirstChorusRange"] = " case when FirstChorusRange = 'Kickoff' then '0:00' else FirstChorusRange end ";

    $tables = array( "Genre"=>"genre", "Lyrical Themes"=>"lyricaltheme", "Sub-Genre/Influence"=>"subgenre", "Record Labels"=>"label", "Instrumentation"=>"primaryinstrumentation" );
    $tables[ "Song Title Placement"] = "placement";


    $songs[] = -1;
    $songstr = implode( ", ", $songs );
    
    switch( $field )
    {
        case "#1 Hits":
            $rows = array( "#1 Hits"=>"#1 Hits" );
            break;
        case "Top 10":
            $rows = array( "Top 10"=>"Top 10" );
            break;
        case "Vocal Delivery Type":
            $rows = array( "Only Rapped"=>"Only Rapped", "Only Sung" =>"Only Sung", "Sung / Rapped"=>"Sung / Rapped" );
	    break;
        case "Lyrical Themes":
        case "Instrumentation":
        case "Song Title Placement":
        case "Sub-Genre/Influence":
        case "Record Labels":
            $hasadv = $field == "Sub-Genre/Influence" || $field == "Instrumentation"?" and HideFromAdvancedSearch = 0":"";
            $table = $tables[$field];
            $exttype = $field == "Instrumentation"?" and type = 'Main'":"";
            $rows = db_query_array( "select {$table}s.id, Name from {$table}s, song_to_{$table} where {$table}id = {$table}s.id {$exttype} and songid in ( $songstr ) {$hasadv} order by OrderBy, Name", "id", "Name" );
	    //	    echo( "select {$table}s.id, Name from {$table}s, song_to_{$table} where {$table}id = {$table}s.id {$exttype} and songid in ( $songstr ) {$hasadv} order by OrderBy, Name" );
            break;
        case "Genre":
            $rows = db_query_array( "select genres.id, Name from genres, songs where GenreID = genres.id and songs.id in ( $songstr ) order by OrderBy", "id", "Name" );
            break;
        case "timesignatureid":
            $rows = db_query_array( "select timesignatures.id, Name from timesignatures, songs where timesignatureid = timesignatures.id and songs.id in ( $songstr ) order by OrderBy, Name", "id", "Name" );
            break;
        case "Performing Artist":
            $rows = db_query_array( "select concat( 'artist_', artists.id ) as id, Name from artists, song_to_artist where artistid = artists.id and song_to_artist.songid in ( $songstr ) and type in ( 'featured', 'primary' ) order by OrderBy, Name", "id", "Name" );
            $rows2 = db_query_array( "select concat( 'group_', groups.id ) as id, Name from groups, song_to_group where groupid = groups.id and song_to_group.songid in ( $songstr ) and type in ( 'featured', 'primary' ) order by OrderBy, Name", "id", "Name" );
            $out = array_merge( $rows, $rows2 );
            $rows = $out;
            asort($rows, SORT_NATURAL | SORT_FLAG_CASE);
//            print_r( $rows );
            break;
        case "Songwriters":
            $rows = db_query_array( "select artists.id, Name from artists, song_to_artist where artistid = artists.id and song_to_artist.songid in ( $songstr ) and type in ( 'creditedsw' ) order by OrderBy, Name", "id", "Name" );
	    break;
        case "Producers":
            $rows = db_query_array( "select producers.id, Name from producers, song_to_producer where producerid = producers.id and song_to_producer.songid in ( $songstr ) order by OrderBy, Name", "id", "Name" );
            break;
        case "Primary Genre":
            $rows = db_query_array( "select genres.id, Name from genres, songs where GenreID = genres.id and songs.id in ( $songstr ) order by OrderBy, Name", "id", "Name" );
            break;
        case "Vocals Grouped":
	    $rows = array( "Male"=>"Male", "Female"=>"Female", "Male/Female"=>"Male/Female" );
	    break;
        case "Lead Vocal Gender":
            $rows = db_query_array( "select VocalsGender from songs where songs.id in ( $songstr ) order by VocalsGender", "VocalsGender", "VocalsGender" );
            break;
        case "Songs":
            $rows = db_query_array( "select songs.id, Name  from songs, songnames where songnames.id = songnameid and songs.id in ( $songstr ) order by OrderBy, Name", "id", "Name" );
            break;
        case "SongLengthRange":
        case "FirstChorusRange":
        case "SongTitleAppearanceRange":
        case "SongTitleWordCount":
        case "IntroVocalVsInst":
        case "LastSectionType":
        case "FirstSectionType":
            $orderby = isset( $obs[$field] )?$obs[$field]:"$field";
            $rows = db_query_array( "select distinct( $field )  from songs where {$GLOBALS[clientwhere]} and songs.id in ( $songstr ) and $field <> '' order by {$orderby}", "$field", "$field" );
	    if( $rows["Inst Break"] )
		$rows["Inst Break"] = "Instrumental Break";
	    //	    echo( "select distinct( $field )  from songs where songs.id in ( $songstr )  and $field <> '' order by {$orderby}" );
            break;
        case "IntroLengthRangeNums":
        case "OutroLengthRangeNums":
            $orderby = isset( $obs[$field] )?$obs[$field]:"$field";
            $rows = db_query_array( "select distinct( $field )  from songs where {$GLOBALS[clientwhere]} and $orderby is not null order by {$orderby}", "$field", "$field" );
	    $rows[""] = (strpos( $field, "Intro" ) !== false)?"No Intro":"No Outro";
//            logquery( "select distinct( $field )  from songs where $field <> '' order by {$orderby}" );
            break;
        case "TempoRange":
            $rows = db_query_array( "select distinct( TempoRange ) from songs where songs.id in ( $songstr ) and Tempo > 0 order by Tempo", "TempoRange", "TempoRange" );
            break;
        case "VocalsGender":
            $rows = db_query_array( "select distinct( VocalsGender ) from songs where songs.id in ( $songstr ) ", "VocalsGender", "VocalsGender" );
            break;
        case "Key":
            $rows = db_query_array( "select distinct( NameHard ) from song_to_songkey where songid in ( $songstr ) and NameHard > ''  order by NameHard ", "NameHard", "NameHard" );
            break;
        case "MajorMinor":
            $rows = db_query_array( "select distinct( MajorMinor ) from songs where songs.id in ( $songstr ) and MajorMinor > ''  order by MajorMinor ", "MajorMinor", "MajorMinor" );
            break;
        case "Electronic Vs Acoustic Instrumentation":
            $rows = db_query_array( "select distinct( ElectricVsAcoustic ) from songs where songs.id in ( $songstr ) and ElectricVsAcoustic > '' order by ElectricVsAcoustic", "ElectricVsAcoustic", "ElectricVsAcoustic" );
            break;
        case "Verse Count":
        case "Pre-Chorus Count":
        case "Chorus Count":
        case "Bridge Count":
	    //        case "Post-Chorus Count":
        case "Instrumental Break Count":
        case "Vocal Break Count":
            $type = str_replace( " Count", "", $field );
            $stype = $type;
            if( $type == "Instrumental Break" ) $stype = "Inst Break";

            $tmp = db_query_array( "select NumSections from SectionShorthand where section = '$stype' and songid in ( $songstr ) order by NumSections", "NumSections", "NumSections" );
            foreach( $tmp as $i )
            {
                $s = $type == "Chorus" || $type == "Pre-Chorus"?"es":"s";
                $rows[$i] = $i . ($i ==1 ?" " . $type:" {$type}{$s}");
            }
        
            break;
        case "InfluenceCount":
            $rows = db_query_array( "select InfluenceCount from songs where  id in ( $songstr ) order by InfluenceCount", "InfluenceCount", "InfluenceCount" );
            break;
        case "Average Song Length":
        case "Average Tempo":
        case "Average Outro Length":
        case "Average Intro Length":
            $rows = array( "Average" );
            break;
        case "Contains Intro":
        case "Contains Bridge Surrogate":
        case "Contains Post-Chorus":
        case "Contains Pre-Chorus":
        case "Contains Outro":
        case "ChorusPrecedesVerse":
            return array( "Yes", "No" );
        case "Chorus Length Uniformity":
        case "Verse Length Uniformity":
        case "Pre-Chorus Length Uniformity":
	    $type = trim( str_replace( "Length Uniformity", "", $field ) );
            $rows = array( 1=>"Same Lengths", 0=> "Different Lengths", 2=>"Does not contain a {$type}" );
            break;
    case "Solo vs. Multiple Lead Vocalists":
	return array( "Solo"=>"Solo Lead Vocalist", "Duet"=>"Multiple Lead Vocalists" );
	break;
    case "Solo vs. Multiple Artists" : 
	return array( "Has A Solo Artist"=>"Has A Solo Artist", "Has Multiple Artists"=>"Has Multiple Artists" );
	break;
    case "Songs with a Featured Artist": 
	return array( "Has A Featured Artist"=>"Has A Featured Artist", "Has No Featured Artist"=>"Has No Featured Artist" );
	break;
        default:
            break;
    }
    return $rows;    
}

function getComparisonPercentage( $comparisonfilter, $comparisonaspect, $aid, $rid, $allsongs, $donumsongstoo = false )
{
    global $search, $nodates, $genrefilter;
    if( !count( $allsongs ) ) {
	if( $donumsongstoo )
	    return array( "0%", 0 );
	return "0%"; // no point since there were no songs to choose from
    }
    if( !$nodates || $genrefilter )
    {
            // if there are no dates, we're including all songs
        $whr = " and songs.id in ( " . implode( ", " , $allsongs ) . " )";
    }
    else
    {
        $whr = "";
    }

    $obs = array( "SongTitleAppearanceCount"=>"SongTitleAppearances" );
    $tables = array( "Genre"=>"genre", "Lyrical Themes"=>"lyricaltheme", "Record Labels"=>"label", "Sub-Genre/Influence"=>"subgenre", "Instrumentation"=>"primaryinstrumentation" );
    $tables[ "Song Title Placement"] = "placement";
    
    switch( $comparisonfilter )
    {
        case "Performing Artist":
        case "Record Labels":
        case "Songwriters":
        case "Producers":
            $ex = explode( "_", $aid );
        $table = $ex[0];
        $val = $ex[1];
	
	$type = "";
	if( $comparisonfilter == "Performing Artist" )
	    {
		$type = " and type in ( 'featured', 'primary' ) ";
	    }
	if( $comparisonfilter == "Songwriters" )
	    {
		$type = " and type in ( 'creditedsw' ) ";
	    }

        $whr .= " and songs.id in ( select songid from song_to_{$table} where {$table}id = $val {$type}  ) ";
        break;
        case "Primary Genre":
            $ex = explode( "_", $aid );
            $table = $ex[0];
            $val = $ex[1];
            $whr .= " and GenreID = $val";
        
        break;
        case "Vocal Gender":
            $ex = explode( "_", $aid );
            $table = $ex[0];
            $val = $ex[1];

            $whr .= " and VocalsGender = '$val'";
            break;
        case "Songs":
            $ex = explode( "_", $aid );
            $table = $ex[0];
            $val = $ex[1];
            $whr .= " and songs.id = '$val'";
            break;
        case "#1 Hits":
            $whr .= " and PeakPosition = '1'";
            break;
        case "Top 10":
            $whr .= " and 1 = 1 ";
            break;
        case "Songwriter Team Size": 
            $ex = explode( "_", $aid );
            $table = $ex[0];
            $val = $ex[1];
            $whr .= " and SongwriterCount = '$val'";
            break;
        default:
            break; 
        
    }
    
    switch( $comparisonaspect )
    {
        case "IntroLengthRangeNums":
            $whr .= " and IntroLengthRange is not null";
            break;
        case "OutroLengthRangeNums":
            $whr .= " and OutroRange is not null";
            break;
        default;
        break;
    }
    
//    echo( "Select songs.id from songs {$exttables} where IsActive = 1 {$whr}" );
    $allsongsforcolumn = db_query_array( "Select songs.id from songs {$exttables} where {$GLOBALS[clientwhere]} {$whr}", "id", "id" );
    if( $_GET["help"] )
	echo( "Select songs.id from songs {$exttables} where {$GLOBALS[clientwhere]} {$whr}<br>" );
    $numsongsforcolumn = count( $allsongsforcolumn );
    if( !$numsongsforcolumn )
	{
	    if( $donumsongstoo )
		return array( "0%", 0 );
	    return "0%"; // no point since there were no songs to choose from
	}
    
    $allsongsforcolumnstr = implode( ", ", $allsongsforcolumn );
    $exttables = "";
    
    switch( $comparisonaspect )
    {
        case "#1 Hits":
            $whr .= " and PeakPosition = '1'";
            break;
        case "Top 10":
        case "All Songs":
            $whr .= " and PeakPosition = '1'";
            break;
        case "Vocal Delivery Type":
	    $rapped = db_query_array( "select id from songs where SubsectionVocalsHard like '%," . RAPPED . ",%' ", "id", "id" );
	    $sung = db_query_array( "select id from songs where SubsectionVocalsHard like '%," . SUNG . ",%' ", "id", "id" );
	    switch( $rid )
		{
                        case "Only Sung":
                            $outarr = array_diff( $sung, $rapped );
			    $outarr[] = -1;
			    $whr .= " and songs.id in ( " . implode( ", ", $outarr ) . " )";
			    break;
                        case "Only Rapped":
                            $outarr = array_diff( $rapped, $sung );
			    $outarr[] = -1;
			    $whr .= " and songs.id in ( " . implode( ", ", $outarr ) . " )";

			    break;
                        case "Sung / Rapped":
                            $outarr = array_intersect( $sung, $rapped );
			    $outarr[] = -1;
			    $whr .= " and songs.id in ( " . implode( ", ", $outarr ) . " )";
			    break;
		}
	    break;
        case "Average Song Length":
        case "Average Tempo":
        case "Average Outro Length":
        case "Average Intro Length":
	    // we want it all... 
            break;
        case "Lyrical Themes":
        case "Record Labels":
        case "Sub-Genre/Influence":
        case "Song Title Placement":
        case "Instrumentation":
            $table = $tables[$comparisonaspect];
            $whr .= " and songs.id in ( select songid from song_to_{$table} where {$table}id = '$rid' )";
            break;
        case "Genre":
            $whr .= " and songs.GenreID = $rid "; 
            break;
        case "SongLengthRange":
        case "TempoRange":
        case "timesignatureid":
        case "FirstChorusRange":
        case "IntroLengthRangeNums":
        case "InfluenceCount":
        case "OutroLengthRangeNums":
        case "VocalsGender":
        case "SongTitleAppearanceRange":
        case "SongTitleWordCount":
        case "IntroVocalVsInst":
        case "FirstSectionType":
        case "LastSectionType":
            $whr .= " and songs.{$comparisonaspect} = '$rid'"; 
            break;
        case "Key":
            $whr .= " and songs.id in ( select songid from song_to_songkey where NameHard = '$rid' )";
            break;
        case "MajorMinor":
            $whr .= " and songs.MajorMinor = '$rid' "; 
            break;
        case "Electronic Vs Acoustic Instrumentation":
            $whr .= " and songs.ElectricVsAcoustic = '$rid' "; 
            break;
        case "Verse Count":
        case "Pre-Chorus Count":
        case "Chorus Count":
        case "Bridge Count":
        case "Instrumental Break Count":
        case "Vocal Break Count":
            $type = str_replace( " Count", "", $comparisonaspect );
            if( $type == "Instrumental Break" ) $type = "Inst Break";
            $whr .= " and songs.id in ( select songid from SectionShorthand where section = '$type' and NumSections = '$rid' )";
            break;
        case "Contains Intro":
            if( $rid == "Yes" )
                $whr .= " and IntroLengthRangeNums > ''";
            else
                $whr .= " and IntroLengthRangeNums = ''";
            break;
        case "ChorusPrecedesVerse":
            if( $rid == "Yes" )
                $whr .= " and ChorusPrecedesVerse = 1";
            else
                $whr .= " and ChorusPrecedesVerse = 0";
            break;
        case "Vocals Grouped":
	    //	    $rows = array( "Male"=>"Male", "Female"=>"Female", "Male/Female"=>"Male/Female" );
	    if( $rid == "Male"  || $rid == "Female" )
		{
		    $whr .= " and songs.VocalsGender in ( 'Solo $rid', 'Duet/Group (All $rid)' ) ";
		}
	    else
		{
		    $whr .= " and songs.VocalsGender = 'Duet/Group (Female/Male)'  ";
		}
	    break;
        case "Contains Bridge Surrogate":
            if( $rid == "Yes" )
            {
                $whr .= " and songs.id in ( select songid from song_to_songsection where BridgeSurrogate = 1 ) ";
            }
            else
            {
                $whr .= " and songs.id not in ( select songid from song_to_songsection where BridgeSurrogate = 1 ) ";
            }
            break;
        case "Contains Post-Chorus":
            if( $rid == "Yes" )
            {
                $whr .= " and songs.id in ( select songid from song_to_songsection where PostChorus = 1 ) ";
            }
            else
            {
                $whr .= " and songs.id not in ( select songid from song_to_songsection where PostChorus = 1 ) ";
            }
            break;
        case "Contains Pre-Chorus":
            if( $rid == "Yes" )
            {
                $whr .= " and songs.id in ( select songid from song_to_songsection where WithoutNumberHard = 'Pre-Chorus' ) ";
            }
            else
            {
                $whr .= " and songs.id not in ( select songid from song_to_songsection where WithoutNumberHard = 'Pre-Chorus' = 1 ) ";
            }
            break;
    case "Verse Length Uniformity":
    case "Pre-Chorus Length Uniformity":
    case "Chorus Length Uniformity":
	$fieldname = str_replace( " Length Uniformity", "", $comparisonaspect );
    $eval = $rid?"=":"<>";
    if( $rid == 2 )
	{
	    $tmp = db_query_array( "select songid from SectionShorthand where songid in ( $allsongsforcolumnstr ) and section = '$fieldname' and NumSections = 0", "songid", "songid" );
	}
    else
	{
	    $tmp = db_query_array( "select songid from SectionShorthand where songid in ( $allsongsforcolumnstr ) and LengthsSame {$eval} 1  and section = '$fieldname'  and NumSections > 0", "songid", "songid" );
	}
       $tmp[] = -1;
       $tmp = implode( ", " , $tmp );
       $whr .= " and songs.id in ( $tmp )";


			
			break;

    case "Solo vs. Multiple Lead Vocalists":
	$whr .= " and VocalsGender like '%$rid%'";
	break;
   case "Solo vs. Multiple Artists" : 
       $tmp = db_query_array( "select id from songs where id in ( $allsongsforcolumnstr ) and (( select count(*) from song_to_group where songid = songs.id and type in ( 'primary', 'featured'  ) ) + ( select count(*) from song_to_artist where songid = songs.id and type in ( 'primary', 'featured' ) ) > 1 )", "id", "id" ); 
       $tmp[] = -1;
       $tmp = implode( ", " , $tmp );

       if( $rid == "Has A Solo Artist" )
	   $whr .= " and songs.id not in ( $tmp )";
       else
	   $whr .= " and songs.id in ( $tmp )";
	break;
    case "Songs with a Featured Artist": 
	if( $rid == "Has A Featured Artist" )
	    {
		$whr .= " and ( songs.id in ( select songid from song_to_artist where type = 'featured' ) or songs.id in ( select songid from song_to_group where type = 'featured' ) )";
	    }
	else
	    {
		$whr .= " and songs.id not in ( select songid from song_to_artist where type = 'featured' or songs.id in ( select songid from song_to_group where type = 'featured' ) ) ";
	    }
	break;
        case "Contains Outro":
            if( $rid == "Yes" )
                $whr .= " and OutroLengthRangeNums > ''";
            else
                $whr .= " and OutroLengthRangeNums = ''";
            break;
        case "Performing Artist":
            $exp = explode( "_", $rid );
            if( count( $exp ) > 1 )
            {
                $table = array_shift( $exp );
                $rid = array_shift( $exp );
            }
            else
            {
                $table = "artist";
            }
            $whr .= " and songs.id in ( select songid from song_to_{$table} where {$table}id = '$rid' and type in ( 'primary', 'featured' ) )";
            break;
        case "Songwriters":
            $table = "artist";
            $whr .= " and songs.id in ( select songid from song_to_{$table} where {$table}id = '$rid' and type in ( 'creditedsw' ) )";
            break;
        case "Producers":
            $table = "producer";
            $whr .= " and songs.id in ( select songid from song_to_{$table} where {$table}id = '$rid' )";
            break;
        case "Primary Genre":
            $table = "genre";
            $whr .= " and GenreID = '$rid' ";
            break;
        case "Lead Vocal Gender":
            $whr .= " and VocalsGender = '$rid' ";
            break;
        case "Songs":
            $whr .= " and songs.id = '$rid' ";
            break;
        default:
            break;
        
        
    }

    if( $comparisonfilter == "Weeks in the Top 10" || $comparisonfilter == "Weeks at Number 1" )
    {
        $extnum1 = "";
        if( $comparisonfilter == "Weeks at Number 1" )
	    {
		$extnum1 = " and type = 'position1'";
	    }
        if( !$nodates )
	    {
		$weekdatestr = " $extnum1 and weekdateid in ( " . implode( ", ",  getWeekdatesForQuarters( $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] ) ) . " )";
	    }

//        echo( $weekdatestr );
        if( $aid == "Number of Weeks" )
            $sql = "select count( distinct(weekdateid) ) from songs, song_to_weekdate where {$GLOBALS[clientwhere]} $extnum1 and songs.id = songid $whr $weekdatestr ";
        else
            $sql = "select count(distinct( weekdateid) ) from songs, song_to_weekdate where {$GLOBALS[clientwhere]} $extnum1 and songs.id = songid $whr $weekdatestr ";
        $cnt = db_query_first_cell( $sql );

	if( $_GET["help"] ) echo( $sql . "<br>");
	//        file_put_contents( "/tmp/comp", $sql. "\n", FILE_APPEND );
	if( $donumsongstoo )
	    return array( "$cnt", "$cnt" );
	else
	    return "$cnt";

    }
    else if( strpos( $comparisonaspect, "Average" ) !== false )
	{
	    $fieldname = "";
	    switch( $comparisonaspect )
		{
		case "Average Song Length":
		    $fieldname = "round( avg( time_to_sec( SongLength ) ) )"; 
		    break;
		case "Average Outro Length":
		case "Average Intro Length":
		    // we want it all... 
		    $short = str_replace( "Average ", "", $comparisonaspect );
                    $short = str_replace( " Length", "", $short );
		    $fieldname = "round( avg( time_to_sec( length ) ) ) ";
   		    $exttables .= ", song_to_songsection";
		    $whr .= "and song_to_songsection.songid = songs.id and song_to_songsection.WithoutNumberHard = '$short'";
		    break;
		case "Average Tempo":
		    $fieldname = "round( avg( Tempo ) )";
		    break;
		}
	    $sql = "select $fieldname from songs {$exttables} where {$GLOBALS[clientwhere]}  $whr";
	    if( $_GET["help"] ) echo( $sql . "<br>");
	    //	    echo( $sql );
	    //	echo( $sql . "<br>num songs: $numsongsforcolumn<br>" ); 
	    if( $comparisonaspect == "Average Tempo" )
		$avg = db_query_first_cell( $sql );
	    else
		$avg = makeTime( db_query_first_cell( $sql ) );
	    if( $donumsongstoo )
		return array( $avg, $avg );
	    else
		return  $avg;
	    
	}
    else
	{
	    $sql = "select distinct( songs.id ) from songs {$exttables} where {$GLOBALS[clientwhere]}  $whr";
	    //	echo( $sql . "<br>num songs: $numsongsforcolumn<br>" ); 
	    $arr = db_query_array( $sql, "id", "id" );
	    $num = count( $arr );
	    
	    $perc = ($num / $numsongsforcolumn) * 100 ;
	    $perc = number_format( $perc );
	    $ext = "";
            //  $ext =  " ($num / $numsongsforcolumn)"; 
            // $ext .= "(". implode( ", ", $arr ). ")"  ;
	    //    if( implode( ", ", $arr ) == 2787 )
	    //       $ext = $sql;
	    if( $_GET["help"] ) echo( $sql . "<br>");
	    if( $donumsongstoo )
		return array( $perc."%" . $ext, $num );
	    else
		return  $perc."%" . $ext;

	}
}


function getComparisonDisplayValue( $val, $fieldname )
{
    if( $fieldname == "TempoRange" )
        return $val . " BPM";
    if( $val == "Number of Weeks" )
        return "Number of Weeks<br>(number of weeks during selected time period)" ;
    if( $val == "Weeks at #1" )
        return "Weeks at #1<br>(number of weeks during selected time period)" ;
    if( $val == "Total Number of Weeks" )
        return "Total Number of Weeks<br>(sum of all weeks)" ;
    if( $val == "Weeks in the Top 10" )
        return "Number of Weeks<br>(number of weeks during selected time period)" ;
    
    return $val;
}


function getComparisonURL( $search, $aid, $rid )
{
    if( $search["comparisonaspect"] == "Songs" )
    {
        $clean = db_query_first_cell( "select CleanUrl from songs, songnames where songnameid = songnames.id and Name = '" . escMe( $rid ) . "'" );
        return "/" . $clean;
    }
    
    $surl= "search-results.php?type=Comparative";
    parse_str( $_SERVER['QUERY_STRING'], $qs );
    $genrefilter = $qs["genrefilter"];
    unset( $qs["search"]["comparisonaspect"] );
    unset( $qs["search"]["comparisonfilter"] );
    unset( $qs["search"]["vocalsgender"] );
    unset( $qs["search"]["GenreID"] );
    unset( $qs["search"]["labelid"] );
    unset( $qs["search"]["songname"] );
    unset( $qs["search"]["writer"] );
    unset( $qs["search"]["producer"] );
    unset( $qs["search"]["primaryartist"] );
    unset( $qs["genrefilter"] );
    $qs["search"]["peakwithin"] = $qs["search"]["peakchart"];
    unset( $qs["search"]["peakchart"] );

    if( $genrefilter )
	{
	    $qs[search]["GenreID"] = $genrefilter;
	}

    switch( $search[comparisonfilter] )
    {
        case "Performing Artist":
            $aid = explode( "_", $aid );
            $aid = $aid[1];
            $val = getTableValue( $aid, "artists" );
            if( !$val )
                $val = getTableValue( $aid, "groups" );
            $qs["search"]["primaryartist"] = $val;
            break;
        case "Songwriters":
            $aid = explode( "_", $aid );
            $aid = $aid[1];
            $qs["search"]["writer"] = getTableValue( $aid, "artists" );
            break;
        case "Producers":
            $aid = explode( "_", $aid );
            $aid = $aid[1];
            $qs["search"]["producer"] = getTableValue( $aid, "producers" );
            break;
        case "Record Labels":
            $aid = explode( "_", $aid );
            $aid = $aid[1];
            $qs["search"]["labelid"] = $aid;
            break;
        case "Primary Genre":
            $aid = explode( "_", $aid );
            $aid = $aid[1];
            $qs["search"]["GenreID"] = $aid;
            break;
        case "Songs":
            $aid = explode( "_", $aid );
            $aid = $aid[1];
            $qs["search"]["songname"] = getSongnameFromSongid( $aid );
            break;
        case "Vocal Gender":
            $aid = explode( "_", $aid );
            $aid = $aid[1];
            $qs["search"]["vocalsgender"] = $aid;
            break;
        case "Weeks at Number 1":
        case "#1 Hits":
            $qs["search"]["peakchart"] = 1;
            break;
        default:
            break;
        
    }

    $field = $search[comparisonaspect] ;
    switch( $field )
    {
        case "#1 Hits":
        case "Weeks at Number 1":
            $qs["search"]["peakchart"] = 1;
            break;
        case "Genre":
            $rid = db_query_first_cell( "select id from genres where Name = '" . escMe( $rid ) . "'" );
            $qs["search"]["GenreID"] = $rid;
            break;
        case "timesignatureid":
            $rid = db_query_first_cell( "select id from timesignatures where Name = '" . escMe( $rid ) . "'" );
            $qs["search"]["$field"] = $rid;
            break;
        case "Sub-Genre/Influence":
            $rid = db_query_first_cell( "select id from subgenres where Name = '" . escMe( $rid ) . "'" );
	    $qs["search"]["subgenres"]["$rid"] = $rid;
            break;
        case "Vocal Delivery Type":
	    switch( $rid )
		{
		case "Only Sung":
		    $qs["search"]["ssvocaltypes"][SUNG]=1;
		    $qs["search"]["ssvocaltypes"][RAPPED]=-1;
//		    $qs["search"]["ssvocaltypes"][SPOKEN]=-1;
		    break;
		case "Only Rapped":
		    $qs["search"]["ssvocaltypes"][SUNG]=-1;
		    $qs["search"]["ssvocaltypes"][RAPPED]=1;
//		    $qs["search"]["ssvocaltypes"][SPOKEN]=-1;
		    break;
		case "Sung / Rapped":
		    $qs["search"]["ssvocaltypes"][SUNG]=1;
		    $qs["search"]["ssvocaltypes"][RAPPED]=1;
//		    $qs["search"]["ssvocaltypes"][SPOKEN]=-1;
		    break;
		}
            break;
        case "Record Labels":
                $table = "labels";
                $rid = db_query_first_cell( "select id from $table where Name = '" . escMe( $rid ) . "'" );
                $qs["search"]["labelid"] = $rid;
                
        case "Lyrical Themes":
        case "Instrumentation":
        case "Song Title Placement":
            if( $field == "Lyrical Themes" )
                $table = "lyricalthemes";
            if( $field == "Song Title Placement" )
                $table = "placements";
            if( $field == "Instrumentation" )
                $table = "primaryinstrumentations";
            $rid = db_query_first_cell( "select id from $table where Name = '" . escMe( $rid ) . "'" );
            $qs["search"][$table]["$rid"] = $rid;
            break;
         $qs["search"]["placements"]["$rid"] = $rid;
            break;
        case "SongTitleAppearanceRange":
        case "SongTitleWordCount":
        case "IntroVocalVsInst":
        case "FirstSectionType":
        case "LastSectionType":
        case "FirstChorusRange":
        case "SongLengthRange":
        case "TempoRange":
	    if( $rid == "Instrumental Break" && $field == "LastSectionType" )
		$rid = "Inst Break";
            $qs["search"][$field] = $rid;
            break;
        case "VocalsGender":
            $qs["search"][strtolower( $field )] = $rid;
            break;
        case "Lead Vocal Gender":
            $qs["search"]["vocalsgender"] = $rid;
            break;
        case "Key":
            $qs["search"]["KeyMajor"] = $rid;
            break;
        case "Key":
            $qs["search"]["keymajor"] = $rid;
            break;
        case "Electronic Vs Acoustic Instrumentation":
	         $qs["search"]["ElectricVsAcoustic"] = $rid;
            break;
        case "IntroLengthRangeNums":	
	         $qs["search"]["introlengthrangenums"] = $rid;
            break;
        case "Verse Count":
        case "Instrumental Break Count":
        case "Pre-Chorus Count":
        case "Chorus Count":
        case "Bridge Count":
        case "Vocal Break Count":

            $type = str_replace( " Count", "", $field );
            if( $type == "Instrumental Break" ) $type = "Inst Break";
            $rid = explode( " ", $rid );
            $rid = $rid[0];
            if( !$rid )
                $rid = -1;
            $qs["search"]["sectioncounts"][$type] = $rid;
            break;
        case "OutroLengthRangeNums":
	         $qs["search"]["OutroLengthRangeNums"] = $rid;
            break;
        case "Performing Artist":
            $exp = explode( "_", $rid );
            $rid = array_shift( $exp );
	         $qs["search"]["primaryartist"] = $rid;
            break;
        case "Primary Genre":
            $rid = db_query_first_cell( "select id from genres where Name = '" . escMe( $rid ) . "'" );
	         $qs["search"]["GenreID"] = $rid;
            break;
       case "Songwriters":
	         $qs["search"]["writer"] = $rid;
            break;
       case "Producers":
	         $qs["search"]["producer"] = $rid;
            break;
       case "InfluenceCount":
	         $qs["search"]["influencecount"] = $rid;
            break;
       case "ChorusPrecedesVerse":
	         $qs["search"]["ChorusPrecedesVerse"] = $rid;
            break;
        case "Contains Intro":
            $not = ( $rid == "No") ? "not":"";
            $qs["search"]["{$not}containssection"][] = "Intro";
            break;
        case "Contains Bridge Surrogate":
            $not = ( $rid == "No") ? "not":"";
            $qs["search"]["{$not}containssection"][] = "Bridge Surrogate";
            break;
        case "Contains Pre-Chorus":
            $not = ( $rid == "No") ? "not":"";
            $qs["search"]["sectioncounts"]["Pre-Chorus"] = $rid=="Yes"?-2:-1;
            break;
        case "Contains Post-Chorus":
            $not = ( $rid == "No") ? "not":"";
            $qs["search"]["{$not}containssection"][] = "Post-Chorus";
            break;
    case "Vocals Grouped": 
	$qs["search"]["vocalsgenderspecific"]= urlencode( $rid=="Male/Female"?"Both":$rid ); 
	break;
    case "Solo vs. Multiple Lead Vocalists":
	$qs["search"]["solovsduet"] = "Solo Lead Vocalist" == $rid?"Solo":"Duet";
	break;
    case "Solo vs. Multiple Artists" : 
	$qs["search"]["mainartisttype"] = ($rid == "Has A Solo Artist")?"single":"multiple";
	break;
    case "Verse Length Uniformity":
    case "Pre-Chorus Length Uniformity":
    case "Chorus Length Uniformity":

	$fieldname = str_replace( " Length Uniformity", "", $field );
    $rows = array( 1=>"Same Lengths", 0=> "Different Lengths", 2=>"Does not contain a $fieldname" );
    $back = array_flip( $rows );
    //    print_r( $back );
    $rid = $back[$rid];
        $argh = $rid?$rid:2;
	if( $rid == 2 )
	    $argh = -1;
	$qs["search"]["uniformity"][$fieldname]= urlencode( $argh ); 
	break;
    case "Songs with a Featured Artist": 
	$qs["search"]["mainartisttype"] = ($rid == "Has A Featured Artist")?"featured":"nofeatured";
	break;
        case "Contains Outro":
            $not = ( $rid == "No") ? "not":"";
            $qs["search"]["{$not}containssection"][] = "Outro";
            break;
        case "MajorMinor":
            $qs["search"]["majorminor"] = $rid;
            break;
        default:
	    if( strpos( $field, "Average" ) === false )
		{
		    echo( "no match for $field<br>" );
		}
	    break;
    }

    $surl .= "&" . http_build_query( $qs );
    
    return $surl;
}
?>
