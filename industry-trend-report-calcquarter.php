<? 
    $displquarterstr =  "(quarter)";

        // start normal dates stuff
    if( !$search["dates"]["fromy"] )
    {

        if( date( "m" ) <= 3 )
            $fq = 1;
        else if( date( "m" ) <= 6 )
            $fq = 2;
        else if( date( "m" ) <= 9 )
            $fq = 3;
        else
            $fq = 4;

        $exp = explode( "/", getPreviousQuarter( $fq . "/" . date( "Y" ) ) );

        $search["dates"]["fromq"] = $exp[0];
        $search["dates"]["fromy"] = $exp[1];
    }
    $urldatestr = "&search[dates][fromq]=" . $search[dates][fromq]. "&search[dates][fromy]=" . $search[dates][fromy];
    if( $doinghomepage )
    	$urldatestr .= "&search[dates][toq]=" . $search[dates][toq]. "&search[dates][toy]=" . $search[dates][toy];
    

    $quarter = $search["dates"]["fromq"];
    $year = $search["dates"]["fromy"];
    $thisquarter = "$quarter/$year";
    $rangedisplay = "Q{$quarter} {$year}";
    if( $doinghomepage )
        $rangedisplay .= "- Q{$search[dates][toq]} {$search[dates][toy]}";


    $prevquarter = getPreviousQuarter( $thisquarter );
    $exp = explode( "/", $prevquarter );
    $prevq = $exp[0];
    $prevyear = $exp[1];


    $oldestyearly = $prevq . "/" . $prevyear;
    for( $i = 0; $i < 2; $i++ )
    {
        $oldestyearly = getPreviousQuarter( $oldestyearly );
    }

    $oldestarr = explode( "/", $oldestyearly );
    $oldestq = $oldestarr[0];
    $oldesty = $oldestarr[1];

    $threeago = $prevq . "/" . $prevyear;
    for( $i = 0; $i < 2; $i++ )
    {
        $threeago = getPreviousQuarter( $threeago );
    }
    $threeagoarr = explode( "/", $threeago );
    $threeagoq = $threeagoarr[0];
    $threeagoy = $threeagoarr[1];

    // going back 2
    $multiquarter = getPreviousQuarter( $thisquarter );
    $multiquarter = getPreviousQuarter( $multiquarter );
    $mqarr = explode( "/", $multiquarter );
    $mqq = $mqarr[0];
    $mqy = $mqarr[1];
    $multiquarter = getQuarters( $mqq, $mqy, $quarter, $year );

    $quarterstorun = getQuarters( $oldestq, $oldesty, $quarter, $year );

    $allweekdates = getWeekdatesForQuarters( $quarter, $year, $search["dates"]["toq"], $search["dates"]["toy"] );
    $weekdatesstr = implode( ", " , $allweekdates );

    $prevsongs = getSongIdsWithinQuarter( false, $prevq, $prevyear );
    $prevsongsstr = implode( ", ", $prevsongs );

    $allsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
    $allsongsnumber1 = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], 1 );
    if( $_GET["help"] ) exit;
    //    exit;
    $allsongsstr = implode( ", ", $allsongs );
    $allsongsnumber1str = implode( ", ", $allsongsnumber1 );
        if( !$allsongs&& !$doinghomepage ) { 
	if( $iscollabs )
{
		        redirectTo(  "collaborations-report-search" ); 
}
else
{
		        redirectTo(  "industry-trend-report-search" ); 
}
exit; 
}

    if( !$prevsongsstr ) $prevsongsstr = "-1";
    $prevartists = db_query_array( "select Name, artistid from song_to_artist, artists where type in ( 'featured', 'primary' ) and songid in ( $prevsongsstr )", "Name", "artistid" );
    $prevgroups = db_query_array( "select Name, groupid from song_to_group, groups where type in ( 'featured', 'primary' ) and songid in ( $prevsongsstr )", "Name", "groupid" );

    $prevartists = array_merge( $prevartists, $prevgroups );
    ksort( $prevartists );
// artists for the previous quarter
// THIS IS NAMES NOT IDs
    $prevartistsstr = "";
    foreach( $prevartists as $prevname => $previd )
    {
        if( $prevartistsstr ) $prevartistsstr.= ", ";
    $prevartistsstr .= "'" . escMe( $prevname ) . "'";
    }


    $allgenres = db_query_array( "select id, Name from genres order by OrderBy", "id", "Name" );
    $genresongs = array();
    foreach( $allgenres as $genreid=>$genrename )
    {
        $genrefilter = $genreid;
        $tmpsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
        $genresongs[$genreid] = $tmpsongs;
        if( !count( $tmpsongs ) )
        {
            unset( $allgenres[$genreid] );
        }
    }

    $alllabels = db_query_array( "select id, Name from labels order by OrderBy", "id", "Name" );
    $labelsongs = array();
    $genrefilter = "";
    foreach( $alllabels as $labelid=>$labelname )
    {
        $labelfilter = $labelid;
        $tmpsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
        $labelsongs[$labelid] = $tmpsongs;
        if( !count( $tmpsongs ) )
        {
            unset( $alllabels[$labelid] );
        }
    }

//print_r( $labelsongs );exit;
    $genrefilter = "";
    $labelfilter = "";
    if( !$allsongsstr ) $allsongsstr = "-1";
    $allsongsallquarters = getSongIdsWithinQuarter( false, $oldestq, $oldesty, $search[dates][fromq], $search[dates][fromy] );
    $allsongsallquartersstr = implode( ", ", $allsongsallquarters );
    $returned = db_query_array( "select songid from song_to_weekdate, songs where QuarterEnteredTheTop10 <> '$thisquarter' and songs.id = songid and songid in ( $allsongsstr ) and songid not in ( $prevsongsstr ) ", "songid", "songid" );

if( !$doinghomepage )
{
    $newarrivals = db_query_array( "select songs.id, songnames.Name from songs, songnames where {$GLOBALS[clientwhere]} and songnameid = songnames.id and QuarterEnteredTheTop10 = '{$quarter}/{$year}' order by Name ", "id", "Name" );
}
else
{
	$qarrstr = "'-1'";
	foreach( $qarr as $q )
	    {
		$qarrstr .= ", '$q'";
	    }
    $newarrivals = db_query_array( "select songs.id, songnames.Name from songs, songnames where {$GLOBALS[clientwhere]} and songnameid = songnames.id and QuarterEnteredTheTop10 in ($qarrstr) order by Name ", "id", "Name" );
}
    $carryovers = array_intersect( $allsongs, $prevsongs );

    $gone = array_diff( $prevsongs, $allsongs );


    $displayquarter = "";
    if( $quarter == "1"  ) $displayquarter = "first";
    if( $quarter == "2"  ) $displayquarter = "second";
    if( $quarter == "3"  ) $displayquarter = "third";
    if( $quarter == "4"  ) $displayquarter = "fourth";

    $thisquarternumber = calculateQuarterNumber( $search[dates][fromq], $search[dates][fromy] );
?>
