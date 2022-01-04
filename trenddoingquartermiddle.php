<? 
    $quarter = $search["dates"]["fromq"];
    $year = $search["dates"]["fromy"];
    $thisquarter = "$quarter/$year";
    $rangedisplay = "Q{$quarter} {$year}";
    
    $prevquarter = getPreviousQuarter( $thisquarter );
    $exp = explode( "/", $prevquarter );
    $prevq = $exp[0];
    $prevyear = $exp[1];
    
//    echo( "in heremeee" );    
    $oldestyearly = $prevq . "/" . $prevyear;
    for( $i = 0; $i < 2; $i++ )
	{
	    $oldestyearly = getPreviousQuarter( $oldestyearly );
	}
    
    $oldestarr = explode( "/", $oldestyearly );
    $oldestq = $oldestarr[0];
    $oldesty = $oldestarr[1];
    
    $quarterstorun = getQuarters( $oldestq, $oldesty, $quarter, $year );
//    print_r( $quarterstorun ); exit;
    // going back 2    
    $multiquarter = getPreviousQuarter( $thisquarter );
    $multiquarter = getPreviousQuarter( $multiquarter );
    $mqarr = explode( "/", $multiquarter );
    $mqq = $mqarr[0];
    $mqy = $mqarr[1];
    $multiquarter = getQuarters( $mqq, $mqy, $quarter, $year );
    
    
    
    $prevsongs = getSongIdsWithinQuarter( false, $prevq, $prevyear, $search["peakchart"] );
    $prevsongsstr = implode( ", ", $prevsongs );
    
    $allsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search["peakchart"] );
    if( $_GET["help2"] ) 
	{
	    // echo( "all songs here: " );
	    // print_r( $allsongs );
	}
    $allsongsstr = implode( ", ", $allsongs );
    $allsongsnumber1 = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], 1 );
//    echo( "herE:" ) ;
//    print_r( $allsongsnumber1 );

    if( !count( $allsongsnumber1 ) ) // if there are no songs we should put sometihing in there so it doesn't display everything
	$allsongsnumber1[] = -1;
    if( $_GET["help2"] ) 
	{
	    // echo( "all songs number one: " );
	    // print_r( $allsongsnumber1 );
	}
    //print_r( $allsongsnumber1 );
    $allsongsallquarters = getSongIdsWithinQuarter( false, $oldestq, $oldesty, $search[dates][fromq], $search[dates][fromy], $search["peakchart"] );
    $allsongsallquartersstr = implode( ", ", $allsongsallquarters );
    
    $allsongsnumber1str = implode( ", ", $allsongsnumber1 );
    if( !$allsongsnumber1str ) $allsongsnumber1str = "-1";
    if( !$allsongsstr ) $allsongsstr = "-1";
    if( !$allsongsallquartersstr ) $allsongsallquartersstr = "-1";
    
    $newarrivals = db_query_array( "select songs.id, songnames.Name from songs, songnames where {$GLOBALS[clientwhere]} and songnameid = songnames.id and QuarterEnteredTheTop10 = '{$quarter}/{$year}' order by Name ", "id", "Name" );
    $carryovers = array_intersect( $allsongs, $prevsongs );
    
    
    $displayquarter = "";
    if( $quarter == "1"  ) $displayquarter = "first";
    if( $quarter == "2"  ) $displayquarter = "second";
    if( $quarter == "3"  ) $displayquarter = "third";
    if( $quarter == "4"  ) $displayquarter = "fourth";

   $allgenres = db_query_array( "select id, Name from genres order by OrderBy", "id", "Name" );
    $genresongs = array();
    foreach( $allgenres as $genreid=>$genrename )
    {
        $genrefilter = $genreid;
	if( ( $_GET["genrefilter"] == -2 ) && $genrefilter == 2 ) continue;
	else if( $_GET["genrefilter"] && $genrefilter != $_GET["genrefilter"] ) continue;
    	$tmpsongs = getSongIdsWithinQuarter( false, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
        $genresongs[$genreid] = $tmpsongs;
        if( !count( $tmpsongs ) )
        {
            unset( $allgenres[$genreid] );
        }
    }
    $genrefilter = $_GET["genrefilter"];

    
?>
