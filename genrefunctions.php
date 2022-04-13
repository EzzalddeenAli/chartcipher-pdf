<? 
$cols[] = "Number of Songs Within The Top 10";
$cols[] = "Percentage Of Songs Within The Top 10";
$cols[] = "Top Label(s)";
$cols[] = "Top Songwriter Team Size(s)";
$cols[] = "Top Lead Vocal";
$cols[] = "Top Genre/Influence(s)";
$cols[] = "Electronic Vs. Acoustic Songs";
$cols[] = "Top Instruments (in addition to drums/percussion)";
$cols[] = "Top Lyrical Theme(s)";
$cols[] = "Top Title Word Count(s)";
$cols[] = "Top Title Appearance Range(s)";
$cols[] = "Top Tempo Range(s)";
//$cols[] = "Most Popular Form";
$cols[] = "Top Song Length Range(s)";
$cols[] = "Top First Section Type(s)";
$cols[] = "Top Intro Length Range(s)";
$cols[] = "Top Verse Section Count";
$cols[] = "Percentage Of Songs That Contain A Pre-Chorus";
$cols[] = "Percentage Of Songs That Contain A Post-Chorus";
$cols[] = "Top Chorus Section Count";
$cols[] = "Top First Chorus Occurrence Range (Time Into Song)";
$cols[] = "Top First Chorus Occurrence Range (Percent Into Song)";
$cols[] = "Percentage Of Songs That Contain A Bridge";
$cols[] = "Percentage Of Songs That Contain A Bridge Surrogate";
$cols[] = "Percentage Of Songs That Contain An Instrumental Break";
$cols[] = "Percentage Of Songs That Contain A Vocal Break";
$cols[] = "Top Last Section Type(s)";
$cols[] = "Top Outro Length Range(s)";

function calcGenreQSStart( $q )
{
    global $search, $nodates;
    $qspl = explode( "/", $q );
    $qs = "";
    if( !$nodates )
    {
        $qs .= "search[dates][fromq]={$qspl[0]}&";
        $qs .= "search[dates][fromy]={$qspl[1]}&";
    }
    $qs .= "search[peakchart]={$search[peakchart]}&";
    return $qs;
}

function calcGenreURL( $start, $column, $mynote )
{
    $mynote = urlencode( $mynote );
    if( $column == "primaryinstrumentations" || $column == "lyricalthemes" )
    {
        $start .= "search[{$column}][$mynote]=1";
        
    }
    else if( $column == "SongTitleWordCount" )
    {
        $start .= "search[{$column}]={$mynote}:{$mynote}";
        
    }
    else if( $column == "Bridge" )
    {
        $start .= "search[sectioncounts][Bridge]=-2";
    }
    else if( $column == "VocalBreak" )
    {
        $start .= "search[sectioncounts][Vocal+Break]=-2";
    }
    else if( $column == "InstBreak" )
    {
        $start .= "search[sectioncounts][Inst+Break]=-2";
    }
    else if( $column == "BridgeSurrCount" )
    {
        $start .= "search[BridgeSurrCount]=-2";
    }
    else
        $start .= "search[{$column}]=$mynote";
    return $start;
}

function appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, $column )
{
    if( !$allvalues )
        return array();
    $num = 0;
    foreach( $primarygenres as $pid=>$prow )
    {
        $vals = $allvalues[$num];
        $note = $notesarr[$num];

        foreach( $vals as $vid=>$vval )
        {
            $mynote = isset( $note[$vid] )?$note[$vid]:-1;
            if( $retval[$pid][0] )
                $retval[$pid][0] .= "<br>";
            if( $mynote != -1 )
            {
                $url = calcGenreURL( "search-results?$initqs&search[GenreID]=$pid&", $column, $mynote ); 
//                $retval[$pid][0] .= print_r( $vals, true ) ."<br>" . print_r( $note, true ) ;
                if( $vval != "0%" )
                    $retval[$pid][0] .= "<a href='$url'>$vval</a>";
                else
                    $retval[$pid][0] .= "$vval";

            }
            else
            {
                $retval[$pid][0] .= "$vval";
            }
        }
        
        $num++;
    }
    return $retval;
}




function getGenreValues( $quarterstorun, $col )
{
	global $allsongs, $allsongstr, $numsongs, $primarygenres, $genres, $numingenre, $genresongsstr, $firstchoruspercentsdisplay;

        // there should only be one
    $q = $quarterstorun[0];
    $initqs = calcGenreQSStart( $q );



    switch( $col )
    {
        case "Number of Songs Within The Top 10":

            foreach( $primarygenres as $gid=>$grow )
            {
                $retval[$gid][0] = $numingenre[$gid];
                $retval[$gid][1] = "search-results?$initqs&search[GenreID]=$gid";
            }
            break;
        case "Percentage Of Songs Within The Top 10":
            foreach( $primarygenres as $gid=>$grow )
            {
                $retval[$gid][0] = number_format( $numingenre[$gid] / $numsongs * 100 ) . "%";
                $retval[$gid][1] = "search-results?$initqs&search[GenreID]=$gid";
            }
            break;
        case "Top Label(s)":
            foreach( $primarygenres as $p )
            {
                $tmpgenresongs = $genresongsstr[$p[id]];
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( songid ) from songs, song_to_label, labels where GenreID = '$p[id]' and labelid = labels.id and songid = songs.id and songs.id in ( $tmpgenresongs ) group by Name order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, labels.id, Name from songs, labels, song_to_label where songid = songs.id and GenreID = '$p[id]' and labelid = labels.id and songs.id in ( $tmpgenresongs ) group by id, Name having count(*) = $max order by OrderBy ", "id", "Name"  );
                
                $each = count( $labels ) > 1 ?" each":"";
                $notesarr[] = array_keys( $labels );
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
                // FIGURE OUT STARTING HERE RACHEL
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "labelid" );
            break;
        case "Top Songwriter Team Size(s)":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) group by SongwriterCount order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, SongwriterCount from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) group by SongwriterCount having count(*) = $max order by SongwriterCount", "SongwriterCount", "SongwriterCount"  );
                foreach( $labels as $key => $val )
                {
                    if( $key == 1 )
                        $labels[$key] = $val . " Writer";
                    else
                        $labels[$key] = $val . " Writers";
                }
                $each = count( $labels ) > 1 ?" each":"";
                $notesarr[] = array_keys( $labels );
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "SongwriterCount" );
            
            break;
        case "Top Lead Vocal":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and VocalsGender > '' group by VocalsGender order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, VocalsGender from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and VocalsGender > '' group by VocalsGender having count(*) = $max order by VocalsGender", "VocalsGender", "VocalsGender"  );
                $notesarr[] = array_keys( $labels );
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "vocalsgender" );
            
            break;
        case "Top Genre/Influence(s)":
            foreach( $primarygenres as $p )
            {
		$tomatch = $p[Name];
		if( $p[id] == 8 ) $tomatch = "Dance/Club";
                $max = db_query_first_cell( "select count(*) as cnt from songs, subgenres, song_to_subgenre sts where GenreID = '$p[id]' and subgenreid = subgenres.id and songs.id = sts.songid and songs.id in ( $allsongstr ) and sts.type = 'Main' and subgenres.Name <> '$tomatch'  and HideFromAdvancedSearch = 0 group by Name order by cnt desc limit 1" );
                if( !$max ) $max = "0";

                $subgenres = db_query_array( "select group_concat( songs.id ) as sids, Name, subgenres.id from songs, subgenres, song_to_subgenre sts where GenreID = '$p[id]' and sts.type = 'Main'  and subgenreid = subgenres.id and songs.id in ( $allsongstr ) and songs.id = sts.songid  and subgenres.Name <> '$tomatch' and HideFromAdvancedSearch = 0 group by subgenres.id, Name having count(*) = $max order by OrderBy ", "id", "Name"  );
                $notesarr[] = array_keys( $subgenres );
                $each = count( $subgenres ) > 1 ?" each":"";
                $subgenres[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $subgenres );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "specificsubgenre" );
            break;
        case "Electronic Vs. Acoustic Songs":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and ElectricVsAcoustic > '' group by ElectricVsAcoustic order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, ElectricVsAcoustic from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and ElectricVsAcoustic > '' group by ElectricVsAcoustic having count(*) = $max order by ElectricVsAcoustic", "ElectricVsAcoustic", "ElectricVsAcoustic"  );
                $notesarr[] = array_keys( $labels );
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "ElectricVsAcoustic" );
            break;
        case "Top Instruments (in addition to drums/percussion)":
            foreach( $primarygenres as $p )
            {
                $tmpgenresongs = $genresongsstr[$p[id]];
                $max = db_query_first_cell( "select count(*) as cnt from songs, primaryinstrumentations, song_to_primaryinstrumentation sts where GenreID = '$p[id]' and primaryinstrumentationid = primaryinstrumentations.id and songs.id = sts.songid and songs.id in ( $tmpgenresongs ) and type = 'Main' and primaryinstrumentations.id <> 5 group by Name order by cnt desc limit 1" );
                if( !$max ) $max = "0";
                $primaryinstrumentations = db_query_array( "select group_concat( songs.id ) as sids, Name, primaryinstrumentations.id from songs, primaryinstrumentations, song_to_primaryinstrumentation sts where GenreID = '$p[id]' and primaryinstrumentationid = primaryinstrumentations.id and songs.id in ( $tmpgenresongs ) and songs.id = sts.songid  and type = 'Main' and primaryinstrumentations.id <> 5 group by Name, primaryinstrumentations.id having count(*) = $max order by OrderBy ", "id", "Name"  );
                $notesarr[] = array_keys( $primaryinstrumentations );
                $each = count( $primaryinstrumentations ) > 1 ?" each":"";
                $primaryinstrumentations[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $primaryinstrumentations );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "primaryinstrumentations" );
            break;
        case "Top Lyrical Theme(s)":
            foreach( $primarygenres as $p )
            {
                $tmpgenresongs = $genresongsstr[$p[id]];
                $max = db_query_first_cell( "select count(*) as cnt from lyricalthemes, song_to_lyricaltheme sts, songs where GenreID = '$p[id]' and lyricalthemeid = lyricalthemes.id and songs.id = sts.songid and songs.id in ( $tmpgenresongs ) and Name <> 'Lyrical Fusion Songs' group by Name order by cnt desc limit 1" );
                if( !$max ) $max = "0";
                $lyricalthemes = db_query_array( "select group_concat( songs.id ) as sids, Name, lyricalthemes.id from songs, lyricalthemes, song_to_lyricaltheme sts where GenreID = '$p[id]' and Name <> 'Lyrical Fusion Songs' and lyricalthemeid = lyricalthemes.id and songs.id in ( $tmpgenresongs ) and songs.id = sts.songid group by Name, lyricalthemes.id having count(*) = $max order by OrderBy ", "id", "Name"  );
                $notesarr[] = array_keys( $lyricalthemes );
                $each = count( $lyricalthemes ) > 1 ?" each":"";
                $lyricalthemes[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $lyricalthemes );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "lyricalthemes" );
            break;
        case "Top Title Word Count(s)":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) group by SongTitleWordCount order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, SongTitleWordCount from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) group by SongTitleWordCount having count(*) = $max order by SongTitleWordCount", "SongTitleWordCount", "SongTitleWordCount"  );
                $notesarr[] = array_keys( $labels );
                foreach( $labels as $key => $val )
                {
                    if( $key == 1 )
                        $labels[$key] = $val . " Word";
                    else
                        $labels[$key] = $val . " Words";
                }
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "SongTitleWordCount" );
            break;
        case "Top Title Appearance Range(s)":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and SongTitleAppearanceRange > '' group by SongTitleAppearanceRange order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, SongTitleAppearanceRange from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and SongTitleAppearanceRange > ''  group by SongTitleAppearanceRange having count(*) = $max order by SongTitleAppearanceRange", "SongTitleAppearanceRange", "SongTitleAppearanceRange"  );
                $notesarr[] = array_keys( $labels );
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "songtitleappearancecount" );
            break;
        case "Top Tempo Range(s)":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and TempoRange > '' and TempoRange <> 'N/A' group by TempoRange order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                $labels = array();
                if( $max )
                {
                    $labels = db_query_array( "select group_concat( songs.id ) as sids, TempoRange from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and TempoRange > ''  group by TempoRange having count(*) = $max order by TempoRange", "TempoRange", "TempoRange"  );
                    $notesarr[] = array_keys( $labels );
                    $each = count( $labels ) > 1 ?" each":"";
                    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                }
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "TempoRange" );
            break;
        case "Most Popular Form":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and AbbrevSongStructure > '' group by AbbrevSongStructure order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, AbbrevSongStructure from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and AbbrevSongStructure > ''  group by AbbrevSongStructure having count(*) = $max order by AbbrevSongStructure", "AbbrevSongStructure", "AbbrevSongStructure"  );
                $notesarr[] = array_keys( $labels );
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "fullform" );
            break;
        case "Top Song Length Range(s)":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and SongLengthRange > '' group by SongLengthRange order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, SongLengthRange from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and SongLengthRange > ''  group by SongLengthRange having count(*) = $max order by SongLengthRange", "SongLengthRange", "SongLengthRange"  );
                $notesarr[] = array_keys( $labels );
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "SongLengthRange" );
            break;
        case "Top First Section Type(s)":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and FirstSectionType > '' group by FirstSectionType order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, FirstSectionType from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and FirstSectionType > ''  group by FirstSectionType having count(*) = $max order by FirstSectionType", "FirstSectionType", "FirstSectionType"  );
                $notesarr[] = array_keys( $labels );
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "FirstSectionType" );
            break;
        case "Top Intro Length Range(s)":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and IntroLengthRangeNums > '' group by IntroLengthRangeNums order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, IntroLengthRangeNums from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and IntroLengthRangeNums > ''  group by IntroLengthRangeNums having count(*) = $max order by IntroLengthRangeNums", "IntroLengthRangeNums", "IntroLengthRangeNums"  );
                $notesarr[] = array_keys( $labels );
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "introlengthrangenums" );
            break;
        case "Top Verse Section Count":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and VerseCount > '' group by VerseCount order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, VerseCount from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and VerseCount > ''  group by VerseCount having count(*) = $max order by VerseCount", "VerseCount", "VerseCount"  );
                $notesarr[] = array_keys( $labels );
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "VerseCount" );
            break;
        case "Percentage Of Songs That Contain A Pre-Chorus":
            foreach( $primarygenres as $p )
            {
                $tmpsongids = db_query_array( "select id from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and PrechorusCount > 0 ", "id", "id" );
                $max = count( $tmpsongids );
                if( count( $tmpsongids ) )
                    $notesarr[][] = 1;
                else
                    $notesarr[][] = 1;
                if( !$max ) $max = "0";
                $labels = array();
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%"; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "HasPrechorus" );
            break;
        case "Percentage Of Songs That Contain A Post-Chorus":
            foreach( $primarygenres as $p )
            {
                $tmpsongids = db_query_array( "select id from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and songs.id in ( select songid from song_to_songsection where PostChorus = 1 ) ", "id", "id" );
                $max = count( $tmpsongids );
                if( count( $tmpsongids ) )
                    $notesarr[][] = 1;
                else
                    $notesarr[][] = 1;
                $labels = array();
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%"; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "postchorus" );
            break;
        case "Top Chorus Section Count":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and ChorusCount > '' group by ChorusCount order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, ChorusCount from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and ChorusCount > ''  group by ChorusCount having count(*) = $max order by ChorusCount", "ChorusCount", "ChorusCount"  );
                $notesarr[] = array_keys( $labels );
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "ChorusCount" );
            break;
        case "Top First Chorus Occurrence Range (Time Into Song)":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and FirstChorusRange > '' group by FirstChorusRange order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, FirstChorusRange from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and FirstChorusRange > ''  group by FirstChorusRange having count(*) = $max order by FirstChorusRange", "FirstChorusRange", "FirstChorusRange"  );
                $notesarr[] = array_keys( $labels );
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "FirstChorusRange" );
            break;
        case "Top First Chorus Occurrence Range (Percent Into Song)":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and FirstChorusPercentRange > '' group by FirstChorusPercentRange order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, FirstChorusPercentRange from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and FirstChorusPercentRange > ''  group by FirstChorusPercentRange having count(*) = $max order by FirstChorusPercent", "FirstChorusPercentRange", "FirstChorusPercentRange"  );
                $notesarr[] = array_keys( $labels );
		
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $l = array();
                foreach( $labels as $k )
                {
                    $l[] = $firstchoruspercentsdisplay[$k]?$firstchoruspercentsdisplay[$k]:"$k";
                }
                $allvalues[] = $l;
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "FirstChorusPercentRange" );
            break;
        case "Percentage Of Songs That Contain A Bridge":
            foreach( $primarygenres as $p )
            {
                $tmpsongids = db_query_array( "select id from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and BridgeCount > 0 ", "id", "id" );
                $max = count( $tmpsongids );
                if( count( $tmpsongids ) )
                    $notesarr[][] = 1;
                else
                    $notesarr[][] = 1;
                $labels = array();
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%"; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "Bridge" );
            break;
        case "Percentage Of Songs That Contain A Bridge Surrogate":
            foreach( $primarygenres as $p )
            {
                $tmpsongids = db_query_array( "select id from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and songs.BridgeSurrCount >= 1 ", "id", "id" );
                $max = count( $tmpsongids );
                if( count( $tmpsongids ) )
                    $notesarr[][] = 1;
                else
                    $notesarr[][] = 1;
                $labels = array();
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%"; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "BridgeSurrCount" );
            break;
        case "Percentage Of Songs That Contain A Vocal Break":
            foreach( $primarygenres as $p )
            {
                $tmpsongids = db_query_array( "select id from songs, SectionShorthand where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and songid = songs.id and section = 'Vocal Break' and PercentOfSong  > 0 ", "id", "id" );
              // reportlog( "hmm" . print_r( $tmpsongids, true ) );
              // reportlog( "hmm count" . count( $tmpsongids ) );
              // reportlog( "total" .  $numingenre[$p[id]] ) ;
                if( count( $tmpsongids ) )
                    $notesarr[][] = 1;
                else
                    $notesarr[][] = 1;
                $max = count( $tmpsongids );
                if( !$max ) $max = "0";
                $labels = array();
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%"; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "VocalBreak" );
            break;
        case "Percentage Of Songs That Contain An Instrumental Break":
            foreach( $primarygenres as $p )
            {
                $tmpsongids = db_query_array( "select id from songs, SectionShorthand where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and songid = songs.id and section = 'Inst Break' and PercentOfSong > 0 ", "id", "id" );
                    // reportlog( "hmm" . print_r( $tmpsongids, true ) );
                    // reportlog( "hmm count" . count( $tmpsongids ) );
                    // reportlog( "total" . ( $numingenre[$p[id]] ) );
                if( count( $tmpsongids ) )
                    $notesarr[][] = 1;
                else
                    $notesarr[][] = 1;
                $max = count( $tmpsongids );
                if( !$max ) $max = "0";
                $labels = array();
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%"; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "InstBreak" );
            break;
        case "Top Last Section Type(s)":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and LastSectionType > '' group by LastSectionType order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, LastSectionType from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and LastSectionType > ''  group by LastSectionType having count(*) = $max order by LastSectionType", "LastSectionType", "LastSectionType"  );
                $notesarr[] = array_keys( $labels );
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "LastSectionType" );
            break;
        case "Top Outro Length Range(s)":
            foreach( $primarygenres as $p )
            {
                $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and OutroLengthRangeNums > '' group by OutroLengthRangeNums order by cnt desc limit 1" );
                $max = $maxarr[0];
                $tmpsongids = explode( ",", $maxarr[1] );
                if( !$max ) $max = "0";
                $labels = db_query_array( "select group_concat( songs.id ) as sids, OutroLengthRangeNums from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and OutroLengthRangeNums > ''  group by OutroLengthRangeNums having count(*) = $max order by OutroLengthRangeNums", "OutroLengthRangeNums", "OutroLengthRangeNums"  );
                $notesarr[] = array_keys( $labels );
                $each = count( $labels ) > 1 ?" each":"";
                $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
                $allvalues[] = array_values( $labels );
            }
            $retval = appendGenreValues( $retval, $primarygenres, $allvalues, $notesarr, $initqs, "OutroLengthRangeNums" );
            break;
    }
    
    return $retval;
    
}
?>