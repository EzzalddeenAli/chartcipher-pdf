<?php
    $doingweeklysearch = true;
    $replacetotimeperiod = true;
// gah
    $fromweekdatedisplay = db_query_first_cell( "select Name from weekdates where OrderBy = '" . $search["dates"]["fromweekdate"]. "'" );
    $toweekdatedisplay = db_query_first_cell( "select Name from weekdates where OrderBy = '" . $search["dates"]["toweekdate"]. "'" );
    $fromweekdatedisplaysecond = db_query_first_cell( "select Name from weekdates where OrderBy = '" . $search["dates"]["fromweekdatesecond"]. "'" );
    $toweekdatedisplaysecond = db_query_first_cell( "select Name from weekdates where OrderBy = '" . $search["dates"]["toweekdatesecond"]. "'" );
    $fromweekdatedisplaythird = db_query_first_cell( "select Name from weekdates where OrderBy = '" . $search["dates"]["fromweekdatethird"]. "'" );
    $toweekdatedisplaythird = db_query_first_cell( "select Name from weekdates where OrderBy = '" . $search["dates"]["toweekdatethird"]. "'" );
    $urldatestr = "&search[dates][fromweekdate]=" . $search[dates][fromweekdate]. "&search[dates][toweekdate]=" . $search[dates][toweekdate];
    $urldatestrsecond = "&search[dates][fromweekdate]=" . $search[dates][fromweekdatesecond]. "&search[dates][toweekdate]=" . $search[dates][toweekdatesecond];
    $urldatestrthird = "&search[dates][fromweekdate]=" . $search[dates][fromweekdatethird]. "&search[dates][toweekdate]=" . $search[dates][toweekdatethird];

    if( $search["dates"]["fromweekdatesecond"] )
	{
	    $doingthenandnow = true;
	}


    $rangedisplay = "$fromweekdatedisplay - $toweekdatedisplay";
    $displquarterstr = "(selected timeframe)";

    $allweekdates = db_query_array("select id, id from weekdates where OrderBy >= '{$search[dates][fromweekdate]}' and OrderBy <= '{$search[dates][toweekdate]}'" );
    $weekdatesstr = implode( ", " , $allweekdates );
    $prevweekdate = db_query_first_cell( "select OrderBy from weekdates where OrderBy < {$search[dates][fromweekdate]} order by OrderBy desc limit 1" );

    $prevsongs = getSongIdsWithinWeekdates( false, $prevweekdate, $prevweekdate ); // getSongIdsWithinQuarter( false, $prevq, $prevyear ); -- not sure

    $prevsongsstr = implode( ", ", $prevsongs );


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

    $allsongs = getSongIdsWithinWeekdates( false, $search[dates][fromweekdate], $search[dates][toweekdate] );
    $allsongsnumber1 = getSongIdsWithinWeekdates( false, $search[dates][fromweekdate], $search[dates][toweekdate], 1 );
    $allsongsstr = implode( ", ", $allsongs );
    $allsongsnumber1str = implode( ", ", $allsongsnumber1 );

    $allgenres = db_query_array( "select id, Name from genres order by OrderBy", "id", "Name" );
    $genresongs = array();
    foreach( $allgenres as $genreid=>$genrename )
    {
        $genrefilter = $genreid;
        $tmpsongs = getSongIdsWithinWeekdates( false, $search[dates][fromweekdate], $search[dates][toweekdate] );
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
        $tmpsongs = getSongIdsWithinWeekdates( false, $search[dates][fromweekdate], $search[dates][toweekdate] );
        $labelsongs[$labelid] = $tmpsongs;
        if( !count( $tmpsongs ) )
        {
            unset( $alllabels[$labelid] );
        }
    }

    $genrefilter = "";
    $labelfilter = "";
    $allsongsallquarters = getSongIdsWithinWeekdates( false, $search[dates][fromweekdate], $search[dates][toweekdate] );// should be oldesty, oldestq
    $allsongsallquartersstr = implode( ", ", $allsongsallquarters );

    $returned = db_query_array( "select songid from song_to_weekdate, songs where WeekEnteredTheTop10 not in (" . implode( ", ", $allweekdates ) . " ) and songs.id = songid and songid in ( $allsongsstr ) and songid not in ( $prevsongsstr ) ", "songid", "songid" );

    $newarrivals = db_query_array( "select songs.id, songnames.Name from songs, songnames where {$GLOBALS[clientwhere]} and songnameid = songnames.id and WeekEnteredTheTop10 in ( " . implode( ", " , $allweekdates ) . " ) order by Name ", "id", "Name" );
    $carryovers = array_intersect( $allsongs, $prevsongs );

    $gone = array_diff( $prevsongs, $allsongs );


    $displayquarter = "NONE";

//    $thisquarternumber = calculateQuarterNumber( $search[dates][fromq], $search[dates][fromy] );

?>