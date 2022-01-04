<?php
$possibletables = array();
$possibletables["1"] = "Weeks in the Top 10";
$possibletables["2"] = "Weeks at #1";


    $possiblecompositionalaspects = array();
    $possiblecompositionalaspects["Genre"] = "Primary Genre";
//    $possiblecompositionalaspects["VocalsGender"] = "Lead Vocal Gender";

    $possiblecompositionalaspects["Sub-Genre/Influence"] = "Sub-Genre/Influence";
    $possiblecompositionalaspects["InfluenceCount"] = "Influence Count";
    $possiblecompositionalaspects["Vocal Delivery Type"] = "Vocal Delivery Type";
    $possiblecompositionalaspects["Lyrical Themes"] = "Lyrical Themes";
    $possiblecompositionalaspects["SongTitleAppearanceRange"] = "Song Title Appearance Count";
    $possiblecompositionalaspects["Song Title Placement"] = "Song Title Placement";
    $possiblecompositionalaspects["SongLengthRange"] = "Song Length Range";
    $possiblecompositionalaspects["TempoRange"] = "Tempo Range";
    $possiblecompositionalaspects["timesignatureid"] = "Time Signature";
    $possiblecompositionalaspects["Key"] = "Key";
    $possiblecompositionalaspects["MajorMinor"] = "Major vs. Minor";
    $possiblecompositionalaspects["FirstChorusRange"] = "First Chorus (Time)";
    $possiblecompositionalaspects["Electronic Vs Acoustic Instrumentation"] = "Electronic Vs Acoustic Instrumentation";
    $possiblecompositionalaspects["Instrumentation"] = "Instrumentation";
    $possiblecompositionalaspects["IntroLengthRangeNums"] = "Intro Length (Time)";
    $possiblecompositionalaspects["Verse Count"] = "Verse Count";
    $possiblecompositionalaspects["Pre-Chorus Count"] = "Pre-Chorus Count";
    $possiblecompositionalaspects["Chorus Count"] = "Chorus Count";
    $possiblecompositionalaspects["Bridge Count"] = "Bridge Count";
    $possiblecompositionalaspects["Instrumental Break Count"] = "Instrumental Break Count";
    $possiblecompositionalaspects["Vocal Break Count"] = "Vocal Break Count";
    $possiblecompositionalaspects["OutroLengthRangeNums"] = "Outro Length (Time)";
    $possiblecompositionalaspects["Contains Intro"] = "Contains Intro";
    $possiblecompositionalaspects["Contains Bridge Surrogate"] = "Contains Bridge Surrogate";
    $possiblecompositionalaspects["Contains Post-Chorus"] = "Contains Post-Chorus";
    $possiblecompositionalaspects["Contains Outro"] = "Contains Outro";

function getCompositionalColumnName( $str )
{
	if( $str == "Producers" )
	return "Producer / Production Team";
	return $str;
}

function getAcrossTheTopCompositional( $outputformat )
{
    global $possibletables;
    $acrossthetop = array( "1-5000"=>$possibletables[$outputformat] ) ;
    return $acrossthetop;
}

function getRowsCompositional( $search, $songs )
{
    $rows = array();
    $field = $search["compositionalaspect"];
    $obs = array( "SongTitleAppearanceCount"=>"SongTitleAppearances" );
    $obs["SongLengthRange"] = "SongLength";
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
        case "Lead Vocal Gender":
            $rows = db_query_array( "select VocalsGender from songs where songs.id in ( $songstr ) order by VocalsGender", "VocalsGender", "VocalsGender" );
            break;
        case "Songs":
            $rows = db_query_array( "select songs.id, Name  from songs, songnames where songnames.id = songnameid and songs.id in ( $songstr ) order by OrderBy, Name", "id", "Name" );
            break;
        case "SongLengthRange":
        case "FirstChorusRange":
        case "IntroLengthRangeNums":
        case "OutroLengthRangeNums":
        case "SongTitleAppearanceRange":
            $orderby = isset( $obs[$field] )?$obs[$field]:"$field";
            $rows = db_query_array( "select distinct( $field )  from songs where {$GLOBALS[clientwhere]} and $field <> '' order by {$orderby}", "$field", "$field" );
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
        case "Contains Intro":
        case "Contains Bridge Surrogate":
        case "Contains Post-Chorus":
        case "Contains Outro":
            return array( "Yes", "No" );
        default:
            break;
    }
    return $rows;    
}

function getCompositionalPercentage( $weekstype, $compositionalaspect, $rid, $allsongs )
{
    global $search, $nodates, $genrefilter, $allweekdates;
    //    echo( "hmm????" );exit;
    // if( !$nodates || $genrefilter )
    // {
    //         // if there are no dates, we're including all songs
    //     $whr = " and songs.id in ( " . implode( ", " , $allsongs ) . " )";
    // }
    // else
    // {
    //     $whr = "";
    // }

    $whr = " and weekdateid in ( " . implode( ", " , $allweekdates ) . " )";
    $obs = array( "SongTitleAppearanceCount"=>"SongTitleAppearances" );
    $tables = array( "Genre"=>"genre", "Lyrical Themes"=>"lyricaltheme", "Record Labels"=>"label", "Sub-Genre/Influence"=>"subgenre", "Instrumentation"=>"primaryinstrumentation" );
    $tables[ "Song Title Placement"] = "placement";
    
    // need to filter by num weeks here
    // ACK
    // only include the songs that are calculated to have this many weeks
    // $songsforthisweek = $allsongsnumweeks[$numweeks];
    // if( !count( $songsforthisweek ) )
    // 	$songsforthisweek[] = -1;
    $songsforthisweek = $allsongs;

    switch( $compositionalaspect )
    {
        case "IntroLengthRangeNums":
        case "OutroLengthRangeNums":
            $whr .= " and $compositionalaspect > ''";
            break;
        default;
        break;
    }


    $exttables = "";
    
    switch( $compositionalaspect )
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
            $table = $tables[$compositionalaspect];
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
            $whr .= " and songs.{$compositionalaspect} = '$rid'"; 
            break;
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
            $type = str_replace( " Count", "", $compositionalaspect );
            if( $type == "Instrumental Break" ) $type = "Inst Break";
            $whr .= " and songs.id in ( select songid from SectionShorthand where section = '$type' and NumSections = '$rid' )";
            break;
        case "Contains Intro":
            if( $rid == "Yes" )
                $whr .= " and IntroLengthRangeNums > ''";
            else
                $whr .= " and IntroLengthRangeNums = ''";
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

    $whr .= " and songs.id in ( " . implode( ", " , $songsforthisweek ) . " ) ";

    if( $weekstype == 2 )
	$whr .= " and song_to_weekdate.type = 'position1'";

    $sql = "select count( distinct( song_to_weekdate.weekdateid )) as numweekdates, count( distinct( song_to_weekdate.songid ) ) as numsongs from songs, song_to_weekdate {$exttables} where {$GLOBALS[clientwhere]} and song_to_weekdate.songid = songs.id $whr";
    if( $_GET["help"] ) 
	echo( $sql . " <br>$weekstype ---- num songs: $numsongsforcolumn<br>" ); 

    $arr = db_query_first( $sql );
    $num = $arr["numweekdates"];
    $numsongs = $arr["numsongs"];
    
    //     $ext =  " ($num / $numsongstodivideby)"; 
    //     $ext .= "<br> num for this week " . count( $songsforthisweek );
    // $ext .= "(". implode( ", ", $arr ). ")"  ;
    //    if( implode( ", ", $arr ) == 2787 )
     //         $ext .= "<br>$compositionalaspect<br>".$sql;
    return  array( $num , $numsongs ); // . $ext
}


function getCompositionalDisplayValue( $val, $fieldname )
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


function getCompositionalURL( $search, $numweeks, $rid )
{
    global $genrefilter, $artistfilter, $songwriterfilter, $producerfilter, $groupfilter;
    if( $search["compositionalaspect"] == "Songs" )
    {
        $clean = db_query_first_cell( "select CleanUrl from songs, songnames where songnameid = songnames.id and Name = '" . escMe( $rid ) . "'" );
        return "/" . $clean;
    }
    
    $of = $search["outputformat"];
    $surl= "search-results.php?type=Comparative";
    parse_str( $_SERVER['QUERY_STRING'], $qs );
    $genrefilter = $qs["genrefilter"];
    unset( $qs["search"]["compositionalaspect"] );
    unset( $qs["search"]["outputformat"] );
    unset( $qs["search"]["vocalsgender"] );
    unset( $qs["search"]["GenreID"] );
    unset( $qs["search"]["labelid"] );
    unset( $qs["search"]["songname"] );
    unset( $qs["search"]["fromyear"] );
    unset( $qs["search"]["dates"] );
    // fix dates
    foreach( array( "fromy", "fromq", "toq", "toy" ) as $ele )
	$qs["search"]["dates"][$ele] = $search["dates"][$ele];

    unset( $qs["search"]["producer"] );
    unset( $qs["search"]["writer"] );
    unset( $qs["search"]["primaryartist"] );
    unset( $qs["genrefilter"] );
    $qs["search"]["peakwithin"] = $qs["search"]["peakchart"];
    unset( $qs["search"]["peakchart"] );
    if( $of == 2 ) $qs["search"]["peakwithin"] = 1;

    if( $genrefilter )
	{
	    $qs[search]["GenreID"] = $genrefilter;
	}
    // need to add numweeks here? rachel

    //    $qs[search]["numweeksinperiod"] = $numweeks;
    if( $search[specificsubgenre] )
        $qs["search"][specificsubgenre]=$search[specificsubgenre];
    if( $producerfilter )
        $qs[search][producerid] = $producerfilter;
    if( $songwriterfilter )
        $qs[search][writerid] = $songwriterfilter;
    if( $artistfilter )
        $qs[search][artistid]=$artistfilter;
    if( $groupfilter )
        $qs[search][groupid]=$groupfilter;

    $field = $search[compositionalaspect] ;
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
	    //	    echo( "select id from subgenres where Name = '" . ( $rid ) . "'" );
            $rid = db_query_first_cell( "select id from subgenres where Name = '" . escMe( $rid ) . "'" );
	    //	    echo( "ris:" . $rid . "\n"  );
	    $qs["search"]["subgenres"][$rid] = $rid;
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
        case "FirstChorusRange":
        case "SongLengthRange":
        case "TempoRange":
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
        case "Contains Intro":
            $not = ( $rid == "No") ? "not":"";
            $qs["search"]["{$not}containssection"][] = "Intro";
            break;
        case "Contains Bridge Surrogate":
            $not = ( $rid == "No") ? "not":"";
            $qs["search"]["{$not}containssection"][] = "Bridge Surrogate";
            break;
        case "Contains Post-Chorus":
            $not = ( $rid == "No") ? "not":"";
            $qs["search"]["{$not}containssection"][] = "Post-Chorus";
            break;
        case "Contains Outro":
            $not = ( $rid == "No") ? "not":"";
            $qs["search"]["{$not}containssection"][] = "Outro";
            break;
        default:
            echo( "no match for $field<br>" );
            break;
        
    }

    $surl .= "&" . http_build_query( $qs );
    
    return $surl;
}
?>
