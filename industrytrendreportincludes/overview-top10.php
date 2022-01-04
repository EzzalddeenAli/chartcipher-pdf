<?php
$timeperiod = urlencode( $rangedisplay );
$number1link = "search-results?{$urldatestr}&search[peakchart]=1";
$allsongslink = "search-results?{$urldatestr}";

$target = $doinghomepage?"":"{$target}";

function getPercent( $num, $href = "", $longformat = false )
{
    global $allsongs, $target;
    $perc = number_format( ($num / count( $allsongs ))*100 ). "%";
    $son = $num == 1?"song":"songs";
    if( $href ) {
	if( $longformat )
	    return " ($perc of songs, <a {$target} href='$href'>$num</a> $son)";
	else
	    return " $perc of songs (<a {$target} href='$href'>$num</a> $son)";
    }
    else
	{
	if( $longformat )
	    return " ($perc of songs, $num $son)";
	else
	    return " $perc of songs ($num $son)";
	}
}

function getPercentArtists( $num, $href = "", $longformat = false )
{
    global $numartistscount, $target;
    $perc = number_format( ($num / $numartistscount)*100 ). "%";
    $son = $num == 1?"artist":"artists";
    if( $href ) {
	if( $longformat )
	    return " ($perc of artists, <a {$target} href='$href'>$num</a> $son)";
	else
	    return " $perc of artists (<a {$target} href='$href'>$num</a> $son)";
    }
    else
	{
	if( $longformat )
	    return " ($perc of artists, $num $son)";
	else
	    return " $perc of artists ($num $son)";
	}
}

function formQSFromArray( $key, $values )
{
    $retval = "";
    foreach( $values as $v )
	{
	    $retval .= "&{$key}=" . urlencode ( $v );
	}
    return $retval;
}

function formHref( $link, $displ )
{
	global $target;
    return "<a $target href='{$link}'>$displ</a>";
}

function calcmeWeek( $rows )
{
    return calcme( $rows, "", "", "week" );
}
function calcme( $rows, $fieldname = "", $href = "", $v = "song" )
{
    global $allsongs, $target;
    $max = "";
    $retval = array();
    foreach( $rows as $r )
    {
        if( !$max ) $max = $r["cnt"];
        if( $r["cnt"] == $max )
	    {
		if( $href )
		    {
			$retval[] = "<a {$target} href='{$href}&search[$fieldname]={$r[Name]}'>$r[Name]</a>";
		    }
		else
		    {
			$retval[] = $r[Name];
		    }
	    }
    }
    $perc = number_format( ($max / count( $allsongs ))*100 ). "%";
    $pluralv = $v . ( $max > 1 ?"s":"" );
    $each = count( $retval ) > 1?" each":"";
    if( $v == "song" )		// 
        return array( $max,  implode( ", ", $retval ), " ($perc of {$v}s, $max $pluralv{$each})" );
    else
        return array( $max,  implode( ", ", $retval ), " ($max $pluralv{$each})" );
}
    if( !$allsongsstr ) $allsongsstr = "-1";

list( $artistmax, $artistmosthits, $extraartist )  = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsstr ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'primary' )  group by artists.Name order by cnt desc " ), "primaryartistprimary", $allsongslink );
list( $groupmax, $groupmosthits, $extragroup )  = calcme( db_query_rows( "select groups.Name, count(*) as cnt from songs, groups, song_to_group where songs.id in ( $allsongsstr ) and songs.id = songid and groups.id = groupid and song_to_group.type in ( 'primary' )  group by groups.Name order by cnt desc " ), "primaryartistprimary", $allsongslink );

if( $groupmax > $artistmax )
{
    $artistmosthits = $groupmosthits;
    $artistmosthits .= $extragroup;
}
else if( $groupmax == $artistmax )
{
    $artistmosthits .= ", ". $groupmosthits;
    $artistmosthits .= $extragroup;
}
else
{
    $artistmosthits .= $extraartist;
}

// echo( "number: " . $allsongsnumber1str );
// print_r( $allsongsnumber1 );
    if( !$allsongsnumber1str ) $allsongsnumber1str = "-1";
list( $artistmaxno1, $artistmosthitsno1, $extraartistno1 )  = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsnumber1str ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'primary' )  group by artists.Name order by cnt desc " ), "primaryartist", $number1link );
list( $groupmaxno1, $groupmosthitsno1, $extragroupno1 )  = calcme( db_query_rows( "select groups.Name, count(*) as cnt from songs, groups, song_to_group where songs.id in ( $allsongsnumber1str ) and songs.id = songid and groups.id = groupid and song_to_group.type in ( 'primary' )  group by groups.Name order by cnt desc " ), "primaryartist", $number1link );

if( $groupmaxno1 > $artistmaxno1 )
{
    $artistmosthitsno1 = $groupmosthitsno1;
    $artistmosthitsno1 .= $extragroupno1;
}
else if( $groupmaxno1 == $artistmaxno1 )
{
    $artistmosthitsno1 .= ", ". $groupmosthitsno1;
    $artistmosthitsno1 .= $extragroupno1;
}
else
{
    $artistmosthitsno1 .= $extraartistno1;
}

list( $artistmax, $artistlongestweeks, $extraartist ) = calcmeWeek( db_query_rows( "select artists.Name, count(distinct( weekdateid)) as cnt from artists, song_to_artist, song_to_weekdate where song_to_artist.songid = song_to_weekdate.songid and artists.id = artistid and song_to_artist.type in ( 'primary' ) and weekdateid in ( $weekdatesstr ) group by artists.Name order by cnt desc " ) );
list( $groupmax, $grouplongestweeks, $extragroup ) = calcmeWeek( db_query_rows( "select groups.Name, count(distinct( weekdateid)) as cnt from groups, song_to_group, song_to_weekdate where song_to_group.songid = song_to_weekdate.songid and groups.id = groupid and song_to_group.type in ( 'primary' ) and weekdateid in ( $weekdatesstr ) group by groups.Name order by cnt desc " ) );

// $numfeatartists = db_query_first_cell( "select count(distinct( artistid ) ) from song_to_artist where songid in ( $allsongsstr ) and type in ( 'featured' )" );
// $numfeatartists += db_query_first_cell( "select count(distinct( groupid ) ) from song_to_group where songid in ( $allsongsstr )  and type in ( 'featured' )" );

// $numprimartists = db_query_first_cell( "select count(distinct( artistid ) ) from song_to_artist where songid in ( $allsongsstr ) and type in ( 'primary' )" );
// $numprimartists += db_query_first_cell( "select count(distinct( groupid ) ) from song_to_group where songid in ( $allsongsstr )  and type in ( 'primary' )" );

// start num artists
$numartistsarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsstr ) and type in ( 'featured', 'primary' )", "artistid", "artistid" );
$numgroupsarr = db_query_array( "select distinct( groupid ) from song_to_group where songid in ( $allsongsstr )  and type in ( 'featured', 'primary' )", "groupid", "groupid" );

$link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "a[]", $numartistsarr ) . "&" . formQSFromArray( "g[]", $numgroupsarr );
$numartistsarr = array_merge( $numartistsarr, $numgroupsarr );
$numartistscount = count( $numartistsarr );
$numartists = formHref( $link, $numartistscount );
// end num artists


$num1artistsarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsnumber1str ) and type in ( 'featured', 'primary' )", "artistid", "artistid" );
$num1groupsarr = db_query_array( "select distinct( groupid ) from song_to_group where songid in ( $allsongsnumber1str )  and type in ( 'featured', 'primary' )", "groupid", "groupid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "a[]", $num1artistsarr ) . "&" . formQSFromArray( "g[]", $num1groupsarr );
$num1artistsarr = array_merge( $num1artistsarr, $num1groupsarr );
$num1artistscount = count( $num1artistsarr );
$num1artists = formHref( $link, $num1artistscount );



// start num feat artists
$numartistsarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsstr )  and type in ( 'featured' )", "artistid", "artistid" );
$numgroupsarr = db_query_array( "select distinct( groupid ) from song_to_group where songid in ( $allsongsstr )  and type in ( 'featured' )", "groupid", "groupid" );

$link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "a[]", $numartistsarr ) . "&" . formQSFromArray( "g[]", $numgroupsarr );
$numartistsarr = array_merge( $numartistsarr, $numgroupsarr );
$numfeatartists = count( $numartistsarr );
$numfeatartists = formHref( $link, $numfeatartists );

$num1artistsarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsnumber1str )  and type in ( 'featured' )", "artistid", "artistid" );
$num1groupsarr = db_query_array( "select distinct( groupid ) from song_to_group where songid in ( $allsongsnumber1str )  and type in ( 'featured' )", "groupid", "groupid" );

$link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "a[]", $num1artistsarr ) . "&" . formQSFromArray( "g[]", $num1groupsarr );
$num1artistsarr = array_merge( $num1artistsarr, $num1groupsarr );
$num1featartists = count( $num1artistsarr );
$num1featartists = formHref( $link, $num1featartists );
// end num feat artists

// start num prim artists
$numartistsarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsstr )  and type in ( 'primary' )", "artistid", "artistid" );
$numgroupsarr = db_query_array( "select distinct( groupid ) from song_to_group where songid in ( $allsongsstr )  and type in ( 'primary' )", "groupid", "groupid" );

$link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "a[]", $numartistsarr ) . "&" . formQSFromArray( "g[]", $numgroupsarr );
$numartistsarr = array_merge( $numartistsarr, $numgroupsarr );
$numprimartists = count( $numartistsarr );
$numprimartists = formHref( $link, $numprimartists );

$num1artistsarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsnumber1str )  and type in ( 'primary' )", "artistid", "artistid" );
$num1groupsarr = db_query_array( "select distinct( groupid ) from song_to_group where songid in ( $allsongsnumber1str )  and type in ( 'primary' )", "groupid", "groupid" );

$link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "a[]", $num1artistsarr ) . "&" . formQSFromArray( "g[]", $num1groupsarr );
$num1artistsarr = array_merge( $num1artistsarr, $num1groupsarr );
$num1primartists = count( $num1artistsarr );
$num1primartists = formHref( $link, $num1primartists );

// end num prim artists


if( $groupmax > $artistmax )
{
    $artistlongestweeks = $grouplongestweeks;
    $artistlongestweeks .= $extragroup;
}
else if( $groupmax == $artistmax )
{
    $artistlongestweeks .= ", " . $grouplongestweeks;
    $artistlongestweeks .= $extragroup;
}
else
{
    $artistlongestweeks .= $extraartist;
}


list( $artistmaxno1, $artistlongestweeksno1, $extraartistno1 ) = calcmeWeek( db_query_rows( "select artists.Name, count(distinct( weekdateid)) as cnt from artists, song_to_artist, song_to_weekdate where song_to_artist.songid = song_to_weekdate.songid and artists.id = artistid and song_to_artist.type in ( 'primary' ) and song_to_weekdate.type = 'position1'  and weekdateid in ( $weekdatesstr ) group by artists.Name order by cnt desc " ) );

list( $groupmaxno1, $grouplongestweeksno1, $extragroupno1 ) = calcmeWeek( db_query_rows( "select groups.Name, count(distinct( weekdateid)) as cnt from groups, song_to_group, song_to_weekdate where song_to_group.songid  = song_to_weekdate.songid and groups.id = groupid and song_to_group.type in ( 'primary' )  and song_to_weekdate.type = 'position1' and weekdateid in ( $weekdatesstr ) group by groups.Name order by cnt desc " ) );

if( $groupmaxno1 > $artistmaxno1 )
{
    $artistlongestweeksno1 = $grouplongestweeksno1;
    $artistlongestweeksno1 .= $extragroupno1;
}
else if( $groupmaxno1 == $artistmaxno1 )
{
    $artistlongestweeksno1 .= ", " . $grouplongestweeksno1;
    $artistlongestweeksno1 .= $extragroupno1;
}
else
{
    $artistlongestweeksno1 .= $extraartistno1;
}


// begin featured artists

list( $featartistmax, $featartistmosthits, $featextraartist )  = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsstr ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'featured' )  group by artists.Name order by cnt desc " ), "primaryartistfeatured", $allsongslink );
list( $featgroupmax, $featgroupmosthits, $featextragroup )  = calcme( db_query_rows( "select groups.Name, count(*) as cnt from songs, groups, song_to_group where songs.id in ( $allsongsstr ) and songs.id = songid and groups.id = groupid and song_to_group.type in ( 'featured' )  group by groups.Name order by cnt desc " ), "primaryartistfeatured", $allsongslink );

if( $featgroupmax > $featartistmax )
{
    $featartistmosthits = $featgroupmosthits;
    $featartistmosthits .= $featextragroup;
}
else if( $featgroupmax == $featartistmax )
{
    $featartistmosthits .= ", ". $featgroupmosthits;
    $featartistmosthits .= $featextragroup;
}
else
{
    $featartistmosthits .= $featextraartist;
}

list( $featartistmaxno1, $featartistmosthitsno1, $featextraartistno1 )  = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsnumber1str ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'featured' )  group by artists.Name order by cnt desc " ), "primaryartistfeatured", $number1link );
list( $featgroupmaxno1, $featgroupmosthitsno1, $featextragroupno1 )  = calcme( db_query_rows( "select groups.Name, count(*) as cnt from songs, groups, song_to_group where songs.id in ( $allsongsnumber1str ) and songs.id = songid and groups.id = groupid and song_to_group.type in ( 'featured' )  group by groups.Name order by cnt desc " ), "primaryartistfeatured", $number1link );

if( $featgroupmaxno1 > $featartistmaxno1 )
{
    $featartistmosthitsno1 = $featgroupmosthitsno1;
    $featartistmosthitsno1 .= $featextragroupno1;
}
else if( $featgroupmaxno1 == $featartistmaxno1 )
{
    $featartistmosthitsno1 .= ", ". $featgroupmosthitsno1;
    $featartistmosthitsno1 .= $featextragroupno1;
}
else
{
    $featartistmosthitsno1 .= $featextraartistno1;
}



list( $featartistmax, $featartistlongestweeks, $featextraartist ) = calcmeWeek( db_query_rows( "select artists.Name, count(distinct( weekdateid)) as cnt from artists, song_to_artist, song_to_weekdate where song_to_artist.songid = song_to_weekdate.songid and artists.id = artistid and song_to_artist.type in ( 'featured' ) and weekdateid in ( $weekdatesstr ) group by artists.Name order by cnt desc " ) );
list( $featgroupmax, $featgrouplongestweeks, $featextragroup ) = calcmeWeek( db_query_rows( "select groups.Name, count(distinct( weekdateid)) as cnt from groups, song_to_group, song_to_weekdate where song_to_group.songid = song_to_weekdate.songid and groups.id = groupid and song_to_group.type in ( 'featured' ) and weekdateid in ( $weekdatesstr ) group by groups.Name order by cnt desc " ) );

if( $featgroupmax > $featartistmax )
{
    $featartistlongestweeks = $featgrouplongestweeks;
    $featartistlongestweeks .= $featextragroup;
}
else if( $featgroupmax == $featartistmax )
{
    $featartistlongestweeks .= ", " . $featgrouplongestweeks;
    $featartistlongestweeks .= $featextragroup;
}
else
{
    $featartistlongestweeks .= $featextraartist;
}

list( $featartistmaxno1, $featartistlongestweeksno1, $featextraartistno1 ) = calcmeWeek( db_query_rows( "select artists.Name, count(distinct( weekdateid)) as cnt from artists, song_to_artist, song_to_weekdate where song_to_artist.songid = song_to_weekdate.songid and artists.id = artistid and song_to_artist.type in ( 'featured' ) and weekdateid in ( $weekdatesstr ) and song_to_weekdate.type = 'position1' group by artists.Name order by cnt desc " ) );
list( $featgroupmaxno1, $featgrouplongestweeksno1, $featextragroupno1 ) = calcmeWeek( db_query_rows( "select groups.Name, count(distinct( weekdateid)) as cnt from groups, song_to_group, song_to_weekdate where song_to_group.songid = song_to_weekdate.songid and groups.id = groupid and song_to_group.type in ( 'featured' ) and weekdateid in ( $weekdatesstr ) and song_to_weekdate.type = 'position1' group by groups.Name order by cnt desc " ) );

if( $featgroupmaxno1 > $featartistmaxno1 )
{
    $featartistlongestweeksno1 = $featgrouplongestweeksno1;
    $featartistlongestweeksno1 .= $featextragroupno1;
}
else if( $featgroupmaxno1 == $featartistmaxno1 )
{
    $featartistlongestweeksno1 .= ", " . $featgrouplongestweeksno1;
    $featartistlongestweeksno1 .= $featextragroupno1;
}
else
{
    $featartistlongestweeksno1 .= $featextraartistno1;
}




// end featured
list( $swcountmax, $songwritercountmosthits, $extraswcount ) = calcme( db_query_rows( "select case when SongwriterCount >= 5 then '5+' else SongwriterCount end as Name, count(*) as cnt from songs where songs.id in ( $allsongsstr ) group by Name order by cnt desc " ), "SongwriterCount", $allsongslink) ;
$songwritercountmosthits .= $extraswcount;


list( $swmax, $songwritermosthits, $extrasw ) = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsstr ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'creditedsw' )  group by artists.Name order by cnt desc " ), "writer", $allsongslink) ;
$songwritermosthits .= $extrasw;
list( $artistmax, $songwriterlongestweeks, $extrasw ) = calcmeWeek( db_query_rows( "select artists.Name, count(distinct( weekdateid) ) as cnt from artists, song_to_artist, song_to_weekdate where song_to_artist.songid = song_to_weekdate.songid and artists.id = artistid and song_to_artist.type in ( 'creditedsw' ) and weekdateid in ( $weekdatesstr ) group by artists.Name order by cnt desc " ) );
$songwriterlongestweeks .= $extrasw;

list( $swmaxno1, $songwritermosthitsno1, $extraswno1 ) = calcme( db_query_rows( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist where songs.id in ( $allsongsnumber1str ) and songs.id = songid and artists.id = artistid and song_to_artist.type in ( 'creditedsw' )  group by artists.Name order by cnt desc " ), "writer", $number1link ) ;
$songwritermosthitsno1 .= $extraswno1;
list( $artistmaxno1, $songwriterlongestweeksno1, $extraswno1 ) = calcmeWeek( db_query_rows( "select artists.Name, count(distinct( weekdateid) ) as cnt from artists, song_to_artist, song_to_weekdate where song_to_artist.songid = song_to_weekdate.songid and artists.id = artistid and song_to_artist.type in ( 'creditedsw' ) and weekdateid in ( $weekdatesstr )  and song_to_weekdate.type = 'position1' group by artists.Name order by cnt desc " ) );
$songwriterlongestweeksno1 .= $extraswno1;

$numsongwritersarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsstr ) and type in ( 'creditedsw' )", "artistid", "artistid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=songwriters&" . formQSFromArray( "a[]", $numsongwritersarr );
$numsongwriters = count( $numsongwritersarr );
$numsongwriters = formHref( $link, $numsongwriters );

$num1songwritersarr = db_query_array( "select distinct( artistid ) from song_to_artist where songid in ( $allsongsnumber1str ) and type in ( 'creditedsw' )", "artistid", "artistid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=songwriters&" . formQSFromArray( "a[]", $num1songwritersarr );
$num1songwriters = count( $num1songwritersarr );
$num1songwriters = formHref( $link, $num1songwriters );



list( $labelmax, $labelmosthits, $extralabel ) = calcme( db_query_rows( "select labels.Name, count(*) as cnt from songs, labels, song_to_label where songs.id in ( $allsongsstr ) and songs.id = songid and labels.id = labelid  group by labels.Name order by cnt desc " ) , "label", $allsongslink) ;
$labelmosthits .= $extralabel;
list( $labelmax, $labellongestweeks, $extralabel ) = calcmeWeek( db_query_rows( "select labels.Name, count(distinct(weekdateid)) as cnt from labels, song_to_label, song_to_weekdate where song_to_label.songid = song_to_weekdate.songid and labels.id = labelid and weekdateid in ( $weekdatesstr ) group by labels.Name order by cnt desc " ) );
//echo( "select labels.Name, count(distinct(weekdateid)) as cnt from songs, labels, song_to_label, song_to_weekdate where songs.id in ( $allsongsstr ) and songs.id = song_to_label.songid and songs.id = song_to_weekdate.songid and labels.id = labelid and weekdateid in ( $weekdatesstr ) group by labels.Name order by cnt desc " );
$labellongestweeks .= $extralabel;


list( $labelmaxno1, $labelmosthitsno1, $extralabelno1 ) = calcme( db_query_rows( "select labels.Name, count(*) as cnt from songs, labels, song_to_label where songs.id in ( $allsongsnumber1str ) and songs.id = songid and labels.id = labelid  group by labels.Name order by cnt desc " )  , "label", $number1link ) ;
$labelmosthitsno1 .= $extralabelno1;
list( $labelmaxno1, $labellongestweeksno1, $extralabelno1 ) = calcmeWeek( db_query_rows( "select labels.Name, count(distinct(weekdateid)) as cnt from labels, song_to_label, song_to_weekdate where song_to_label.songid = song_to_weekdate.songid and labels.id = labelid and weekdateid in ( $weekdatesstr )  and song_to_weekdate.type = 'position1' group by labels.Name order by cnt desc " ) );
//echo( "select labels.Name, count(distinct(weekdateid)) as cnt from songs, labels, song_to_label, song_to_weekdate where songs.id in ( $allsongsstr ) and songs.id = song_to_label.songid and songs.id = song_to_weekdate.songid and labels.id = labelid and weekdateid in ( $weekdatesstr ) group by labels.Name order by cnt desc " );
$labellongestweeksno1 .= $extralabelno1;

$numlabelsarr = db_query_array( "select distinct( labelid ) from song_to_label where songid in ( $allsongsstr ) ", "labelid", "labelid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=labels&" . formQSFromArray( "labels[]", $numlabelsarr );
$numlabels = count( $numlabelsarr );
$numlabels = formHref( $link, $numlabels );

$num1labelsarr = db_query_array( "select distinct( labelid ) from song_to_label where songid in ( $allsongsnumber1str ) ", "labelid", "labelid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=labels&" . formQSFromArray( "labels[]", $num1labelsarr );
$num1labels = count( $num1labelsarr );
$num1labels = formHref( $link, $num1labels );

list( $producermax, $producermosthits, $extraproducer ) = calcme( db_query_rows( "select producers.Name, count(*) as cnt from songs, producers, song_to_producer where songs.id in ( $allsongsstr ) and songs.id = songid and producers.id = producerid  group by producers.Name order by cnt desc " ) , "producer", $allsongslink );
$producermosthits .= $extraproducer;
list( $producermax, $producerlongestweeks, $extraproducer ) = calcmeWeek( db_query_rows( "select producers.Name, count(distinct( weekdateid)) as cnt from producers, song_to_producer, song_to_weekdate where song_to_producer.songid = song_to_weekdate.songid and producers.id = producerid and weekdateid in ( $weekdatesstr ) group by producers.Name order by cnt desc " ) );
$producerlongestweeks .= $extraproducer;

list( $producermaxno1, $producermosthitsno1, $extraproducerno1 ) = calcme( db_query_rows( "select producers.Name, count(*) as cnt from songs, producers, song_to_producer where songs.id in ( $allsongsnumber1str ) and songs.id = songid and producers.id = producerid  group by producers.Name order by cnt desc " ) , "producer", $number1link );
$producermosthitsno1 .= $extraproducerno1;
$tmparr = db_query_rows( "select producers.Name, producers.id, count(distinct( weekdateid)) as cnt from producers, song_to_producer, song_to_weekdate where song_to_producer.songid = song_to_weekdate.songid and producers.id = producerid and weekdateid in ( $weekdatesstr ) and song_to_weekdate.type = 'position1' group by producers.Name, producers.id order by cnt desc " );
list( $producermaxno1, $producerlongestweeksno1, $extraproducerno1 ) = calcmeWeek( $tmparr );
$producerlongestweeksno1 .= $extraproducerno1;

$numproducersarr = db_query_array( "select distinct( producerid ) from song_to_producer where songid in ( $allsongsstr )", "producerid", "producerid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=producers&" . formQSFromArray( "producers[]", $numproducersarr );
$numproducers = count( $numproducersarr );
$numproducers = formHref( $link, $numproducers );

$num1producersarr = db_query_array( "select distinct( producerid ) from song_to_producer where songid in ( $allsongsnumber1str )", "producerid", "producerid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=producers&" . formQSFromArray( "producers[]", $num1producersarr );
$num1producers = count( $num1producersarr );
$num1producers = formHref( $link, $num1producers );



list( $genremax, $mostgenre, $extragenre ) = calcme( db_query_rows( "select genres.Name, count(*) as cnt from songs, genres where songs.id in ( $allsongsstr ) and genres.id = GenreID group by genres.Name order by cnt desc " ) , "GenreName", $allsongslink );
$mostgenre .= $extragenre;


// $mostgender = db_query_first( "select VocalsGender, count(*) as cnt from songs where songs.id in ( $allsongsstr ) group by VocalsGender order by cnt desc limit 1" );
// $gen = $mostgender[VocalsGender];
// if( $gen == "Solo Male" )
//     $gen = "Exclusively Male";
// if( $gen == "Solo Female" )
//     $gen = "Exclusively Female";
// $most
$currperc = 0;
$gen = "";
$gennum = "";
$genderdisplay = "";
foreach( array( "Male", "Female" ) as $poss )
{
	$thisgender = db_query_first_cell( "select count(*) as cnt from songs where songs.id in ( $allsongsstr ) and (VocalsGender like '%All $poss%' or VocalsGender = 'Solo $poss' ) " );
//	echo( "select count(*) as cnt from songs where songs.id in ( $allsongsstr ) and (VocalsGender like '%All $poss%' or VocalsGender = 'Solo $poss' )<br> " );
	if( $thisgender >= $currperc )
	    {
		$gen = "Exclusively $poss";
		$gennum = $thisgender;
		$currperc = $gennum;
		$genderdisplay = $poss;
	    }
}
$mostgender = "<a $target href='" . $allsongslink . "&search[vocalsgenderspecific]={$genderdisplay}" . "'>$gen</a>" . getPercent( $gennum, "", true );


//     // $ = db_query_rows( "select artists.id, Name,  sta.type as type from artists, song_to_artist sta, song_to_producer stp where sta.artistid = artists.id  and sta.songid = $songid and stp.songid = $songid and sta.type in ('featured', 'primary' ) and stp.producerid = artists.producerid ", "Name");
// $artistalsoproducer = db_query_array( "select artists.Name, count(*) as cnt from songs, artists, song_to_artist, song_to_producer where song_to_producer.producerid = artists.producerid and songs.id in ( $allsongsstr ) and songs.id = song_to_artist.songid and songs.id = song_to_producer.producerid and song_to_artist.type in ( 'featured', 'primary' ) group by artists.Name", "Name", "Name" );
// $groupalsoproducer = db_query_array( "select groups.Name, count(*) as cnt from songs, groups, song_to_group, song_to_producer where song_to_producer.producerid = groups.producerid and songs.id in ( $allsongsstr ) and songs.id = song_to_group.songid and songs.id = song_to_producer.producerid and song_to_group.type in ( 'featured', 'primary' ) group by groups.Name", "Name", "cnt" );
// $artistalsoproducer = array_merge( $artistalsoproducer, $groupalsoproducer );
// $featuredartist = count( $featuredartist );
// $featuredartist = getPercent( $featuredartist );


$mostsubgenre = db_query_first( "select subgenres.Name, subgenres.id, count(*) as cnt from songs, subgenres, song_to_subgenre where songs.id in ( $allsongsstr ) and songs.id = songid and subgenres.id = subgenreid group by subgenres.Name, subgenres.id order by cnt desc limit 1" );
$mostsubgenre = "<a $target href='" . $allsongslink . "&search[specificsubgenre]=$mostsubgenre[id]'>".  $mostsubgenre[Name] . "</a>" . getPercent( $mostsubgenre[cnt], "", true );
$featuredartist = db_query_array( "select SongNameHard as Name from songs, song_to_artist where songs.id in ( $allsongsstr ) and songs.id = songid and song_to_artist.type in ( 'featured' ) ", "Name", "Name" ); ;
$featuredgroup = db_query_array( "select SongNameHard as Name from songs, song_to_group where songs.id in ( $allsongsstr ) and songs.id = songid and song_to_group.type in ( 'featured' ) ", "Name", "Name" );
$featuredartist = array_merge( $featuredgroup, $featuredartist );

$featuredartist = count( $featuredartist );
$featuredartist = getPercent( $featuredartist, $allsongslink . "&search[mainartisttype]=featured" );

$numsolo = db_query_array( "select SongNameHard as Name from songs where songs.id in ( $allsongsstr ) and ArtistCount = 1 order by Name", "Name", "Name" );
$numsolo = count( $numsolo );
$numsolohard = $numsolo;
$numsolo = getPercent( $numsolo, $allsongslink . "&search[mainartisttype]=single" );
$numduet = db_query_array( "select SongNameHard as Name from songs where songs.id in ( $allsongsstr ) and ArtistCount > 1 order by Name", "Name", "Name" );
$numduet = count( $numduet );
$numduethard = $numduet;

$numduet = getPercent( $numduet, $allsongslink . "&search[mainartisttype]=multiple" );


$numproducersarr = db_query_array( "select distinct( producerid ) from song_to_producer where songid in ( $allsongsstr )", "producerid", "producerid" );
$link = "list-values.php?timeperiod={$timeperiod}&type=producers&" . formQSFromArray( "producers[]", $numproducersarr );
$numproducers = count( $numproducersarr );
$numproducers = formHref( $link, $numproducers );


$numnewarrivals = count( $newarrivals );
$link = "search-results?{$urldatestr}&search[toptentype]=New+Songs";
$numnewarrivals = formHref( $link, $numnewarrivals );
$numsongsnumber1 = count( $allsongsnumber1 );
$numsongsnumber1 = formHref( $number1link, $numsongsnumber1 );
$numsongs = count( $allsongs );
$numsongs = formHref( $allsongslink, $numsongs );


$artistalsoproducer = "";
$artistalsosong = "";

if( 1 == 0 ) { 

    // songwriter and producer and artist start
    $sql =( "select artistid, concat( SongNameHard, '---', artists.Name ) as CleanUrlArtist, CleanUrl, SongNameHard as Name, artists.Name as ArtistName, count(*) as cnt, group_concat( ' ', sta.type ) as alltypes from songs, song_to_artist sta, song_to_producer stp, artists where songs.id in ( $allsongsstr )  and sta.songid = songs.id and stp.songid = songs.id and sta.type in ( 'creditedsw', 'primary', 'featured' ) and stp.producerid = artists.producerid and artists.id = artistid group by SongNameHard, CleanURL, ArtistName, artistid having cnt = 2 order by SongNameHard" );
    $nonesongs = db_query_rows( $sql, "CleanUrlArtist" );
    $sql =( "select groupid, concat( SongNameHard, '---', groups.Name ) as CleanUrlArtist, CleanUrl, SongNameHard as Name, groups.Name as ArtistName, count(*) as cnt, group_concat( ' ', sta.type ) as alltypes from songs, song_to_group sta, song_to_producer stp, groups where songs.id in ( $allsongsstr )  and sta.songid = songs.id and stp.songid = songs.id and sta.type in ( 'creditedsw', 'primary', 'featured' ) and stp.producerid = groups.producerid and groups.id = groupid group by SongNameHard, CleanURL, ArtistName, groupid having cnt = 2 order by SongNameHard" );
    $nonesongsg = db_query_rows( $sql, "CleanUrlArtist" );
    
    $allthreesongs = array_merge( $nonesongs, $nonesongsg );
    ksort( $nonesongs );
    
    $artistalsobotharr = array();
    $groupsalsobotharr = array();
    $songalsobotharr = array();
    foreach( $allthreesongs as $nsongrow )
	{
	    if( $nsongrow[artistid] )
		$artistalsobotharr[ $nsongrow[artistid]] = $nsongrow[artistid];
	    else
		$groupsalsobotharr[ $nsongrow[groupid]] = $nsongrow[groupid];
	    $songalsobotharr[ $nsongrow[CleanUrl]] = $nsongrow[CleanUrl];
	}
    
    $link = "list-values.php?timeperiod={$timeperiod}&type=songs&" . formQSFromArray( "songs[]", $songalsobotharr );
    $numsongsbothcount = count( $songalsobotharr );
    $numsongsboth = getPercent( $numsongsbothcount, $link );
    
    $link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "groups[]", $groupsalsobotharr ) . formQSFromArray( "artists[]", $artistalsobotharr );
    $artistalsobothcount = count( $artistalsobotharr ) + count( $groupsalsobotharr );
    $artistalsoboth = getPercentArtists( $artistalsobothcount, $link );
}
// songwriter and producer and artist end

if( 1 == 0 ) { 
    // songwriter and producer start
    $sql =( "select concat( songnames.Name, '---', artists.Name ) as CleanUrlArtist, CleanUrl, songnames.Name, artists.Name as ArtistName, count(*) as cnt, group_concat( ' ', sta.type ) as alltypes from songs, songnames, song_to_artist sta, song_to_producer stp, artists where songnames.id = songnameid and songs.id in ( $allsongsstr )  and sta.songid = songs.id and stp.songid = songs.id and sta.type in ( 'creditedsw' ) and stp.producerid = artists.producerid and artists.id = artistid group by songnames.Name, CleanURL, ArtistName having cnt = 1 order by songnames.Name" );
    $nonesongs = db_query_rows( $sql, "CleanUrlArtist" );
    $sql =( "select concat( songnames.Name, '---', groups.Name ) as CleanUrlArtist, CleanUrl, songnames.Name, groups.Name as ArtistName, count(*) as cnt, group_concat( ' ', sta.type ) as alltypes from songs, songnames, song_to_group sta, song_to_producer stp, groups where songnames.id = songnameid and songs.id in ( $allsongsstr )  and sta.songid = songs.id and stp.songid = songs.id and sta.type in ( 'creditedsw' ) and stp.producerid = groups.producerid and groups.id = groupid group by songnames.Name, CleanURL, ArtistName having cnt = 1 order by songnames.Name" );
    $nonesongsg = db_query_rows( $sql, "CleanUrlArtist" );
    
    $nonesongs = array_merge( $nonesongs, $nonesongsg );
    ksort( $nonesongs );
    
    //print_r( array_keys( $nonesongs ) );
    $tmparr = array();
    foreach( $nonesongs as $nsongrow )
	{
	    if( !isset( $allthreesongs[$nsongrow[CleanUrlArtist] ]  ) )
		{
		    $tmparr[ $nsongrow[CleanUrl]] = $nsongrow[CleanUrl];
		}
	}
    
    $link = "list-values.php?timeperiod={$timeperiod}&type=songs&" . formQSFromArray( "songs[]", $tmparr );
    $numsongsswproducercount = count( $tmparr );
    $numsongsswproducer = getPercent( $numsongsswproducercount, $link );
    // songwriter and producer end
    
    
    // artist and producer start
    $sql =( "select artistid, concat( songnames.Name, '---', artists.Name ) as CleanUrlArtist, CleanUrl, songnames.Name, artists.Name as ArtistName, count(*) as cnt, group_concat( ' ', sta.type ) as alltypes from songs, songnames, song_to_artist sta, song_to_producer stp, artists where songnames.id = songnameid and songs.id in ( $allsongsstr )  and sta.songid = songs.id and stp.songid = songs.id and sta.type in (  'featured', 'primary' ) and stp.producerid = artists.producerid and artists.id = artistid group by songnames.Name, CleanURL, ArtistName, artistid having cnt = 1 order by songnames.Name" );
    $nonesongs = db_query_rows( $sql, "CleanUrlArtist" );
    $sql =( "select groupid, concat( songnames.Name, '---', groups.Name ) as CleanUrlArtist, CleanUrl, songnames.Name, groups.Name as ArtistName, count(*) as cnt, group_concat( ' ', sta.type ) as alltypes from songs, songnames, song_to_group sta, song_to_producer stp, groups where songnames.id = songnameid and songs.id in ( $allsongsstr )  and sta.songid = songs.id and stp.songid = songs.id and sta.type in ( 'featured', 'primary' ) and stp.producerid = groups.producerid and groups.id = groupid group by songnames.Name, CleanURL, ArtistName, groupid having cnt = 1 order by songnames.Name" );
    $nonesongsg = db_query_rows( $sql, "CleanUrlArtist" );
    
    $nonesongs = array_merge( $nonesongs, $nonesongsg );
    ksort( $nonesongs );
    
    //echo( "<br><br>hmm<br><br>" );
    //print_r( array_keys( $nonesongs ) );
    $tmparr = array();
    $artistalsoprod = array();
    $groupsalsoprod = array();
    foreach( $nonesongs as $nsongrow )
	{
	    if( !isset( $allthreesongs[$nsongrow[CleanUrlArtist] ]  ) )
		{
		    $tmparr[ $nsongrow[CleanUrl]] = $nsongrow[CleanUrl];
		    if( $nsongrow[artistid] )
			$artistalsoprod[$nsongrow[artistid]] = $nsongrow[artistid];
		    else
			$groupsalsoprod[$nsongrow[groupid]] = $nsongrow[groupid];
		}
	}
    
    //print_r( $tmparr );
    $link = "list-values.php?timeperiod={$timeperiod}&type=songs&" . formQSFromArray( "songs[]", $tmparr );
    $numsongsartistproducercount = count( $tmparr );
    $numsongsartistproducer = getPercent( $numsongsartistproducercount, $link );
    
    $link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "artists[]", $artistalsoprod ) . formQSFromArray( "groups[]", $groupsalsoprod );
    $artistalsoprodcount = count( $artistalsoprod ) + count( $groupsalsoprod );
    $artistalsoprod = getPercentArtists( $artistalsoprodcount, $link );
    // artist and producer end
}
if( 1 == 0 ) { 
    // songwriter and artist start
    $sql =( "select concat( songnames.Name, '---', artists.Name ) as CleanUrlArtist, CleanUrl, songnames.Name, artists.Name as ArtistName, count(*) as cnt, group_concat( ' ', sta.type ) as alltypes, artistid from songs, songnames, song_to_artist sta, artists where songnames.id = songnameid and songs.id in ( $allsongsstr )  and sta.songid = songs.id and sta.type in ( 'creditedsw', 'primary', 'featured' ) and artists.id = artistid group by songnames.Name, CleanURL, ArtistName, artistid having cnt = 2 order by songnames.Name" );
    $nonesongs = db_query_rows( $sql, "CleanUrlArtist" );
    
    $sql =( "select concat( songnames.Name, '---', groups.Name ) as CleanUrlArtist, CleanUrl, songnames.Name, groups.Name as ArtistName, count(*) as cnt, group_concat( ' ', sta.type ) as alltypes, groupid from songs, songnames, song_to_group sta, groups where songnames.id = songnameid and songs.id in ( $allsongsstr )  and sta.songid = songs.id and sta.type in ( 'creditedsw', 'primary', 'featured' ) and groups.id = groupid group by songnames.Name, CleanURL, ArtistName, groupid having cnt = 2 order by songnames.Name" );
    $nonesongsg = db_query_rows( $sql, "CleanUrlArtist" );
	
    $tmpsongs = array_merge( $nonesongs, $nonesongsg );
    ksort( $nonesongs );
	
    $artistalsosw = array();
    $groupsalsosw = array();
    $songaalsosw = array();
    foreach( $tmpsongs as $nsongrow )
	{
	    if( !isset( $allthreesongs[$nsongrow[CleanUrlArtist] ]  ) )
		    {
			if( $nsongrow[artistid] )
			    $artistalsosw[$nsongrow[artistid]] = $nsongrow[artistid];
			else
			    $groupsalsosw[$nsongrow[groupid]] = $nsongrow[groupid];
			$songaalsosw[$nsongrow[CleanUrl]] = $nsongrow[CleanUrl];
		    }
	}
    
    $link = "list-values.php?timeperiod={$timeperiod}&type=songs&" . formQSFromArray( "songs[]", $songaalsosw );
    $numsongsaalsoswcount = count( $songaalsosw );
    $numsongsaalsosw = getPercent( $numsongsaalsoswcount, $link );
    
    $link = "list-values.php?timeperiod={$timeperiod}&type=artists&" . formQSFromArray( "artists[]", $artistalsosw ) . formQSFromArray( "groups[]", $groupsalsosw );
    $artistalsoswcount = count( $artistalsosw ) + count( $groupsalsosw );
    $artistalsosw = getPercentArtists( $artistalsoswcount, $link );
    
    // songwriter  and artist end
}




if( !$dontshowvalues ) { 

?>
            <div class="search-body">
                 <h3 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h3>

    <ul class="listB">


<!--
<li><span><b>Percentage of song with</b></span></li>

<li><span>    A featured artist: 48% (50% in 2016): <?=$var?></span></li>
<li><span>    Multiple artist: 47% (33% in 2016): <?=$var?></span></li>
<li><span>    Exclusively male vocals: 58% (53% in 2016): <?=$var?></span></li>
<li><span>    5+ credited songwriters 56% (42% in 2016): <?=$var?></span></li>
-->


<li class="overview-head-title"><span><b>Songs</b></span></li>

<li><span>Number of Top 10 Songs: <?=$numsongs?> </span></li>
<li><span>Number of #1 Songs: <?=$numsongsnumber1?> </span></li>
    <? if( !$doingweeklysearch && !$doingyearlysearch ) { ?>
<li><span>Number of New Songs: <?=$numnewarrivals?> </span></li>
     <? } ?>
<li><span>Songs with a featured artist: <?=$featuredartist?></span></li>
<li><span>Songs with a single artist: <?=$numsolo?>  </span></li>
<li><span>Songs with multiple artists: <?=$numduet?> </span></li>
<li><span>Most popular Primary Genre: <?=$mostgenre?></span></li>
<li><span>Most popular influence: <?=$mostsubgenre?></span></li>
<li><span>Most popular lead vocal gender: <?=$mostgender?></span></li>
<!--<li><span>Songs where One or More Songwriter(s) is also a Producer <?=$numsongsswproducer?></span></li>
<li><span>Songs where One or More Performing Artist(s) is also a Producer: <?=$numsongsartistproducer?></span></li>
<li><span>Songs where One or More Performing Artist(s) is also a Songwriter:  <?=$numsongsaalsosw?></span></li>
<li><span>Songs where One or More Performing Artist(s) is also a Songwriter and a Producer:  <?=$numsongsboth?></span></li>-->

<li class="overview-head-title"><span><b>Artists</b></span></li>

<li><span>Number of Credited Performing Artists (Primary & Featured): <?=$numartists?> </span></li>
<li><span>Number of Credited Performing Artists (Primary & Featured) with #1 Hits: <?=$num1artists?> </span></li>
<li><span>Number of Credited Primary Artists: <?=$numprimartists?></span></li>
<li><span>Number of Credited Primary Artists with #1 Hits: <?=$num1primartists?></span></li>
<li><span>Number of Credited Featured Artists: <?=$numfeatartists?></span></li>
<li><span>Number of Credited Featured Artists with #1 Hits: <?=$num1featartists?></span></li>

<li><span>Artist/Group with the most Top 10 Songs (excludes featured artists): <?=$artistmosthits?></span></li>
<li><span>Artist/Group with the most weeks in the Top 10 (excludes featured artists): <?=$artistlongestweeks?></span></li>
<li><span> Artist/Group with the most #1 Songs (excludes featured artists): <?=$artistmosthitsno1?></span></li>
<li><span>Artist/Group with the most weeks at #1 (excludes featured artists): <?=$artistlongestweeksno1?></span></li>
<li><span>Featured Artist with the most Top 10 Songs: <?=$featartistmosthits?></span></li>
<li><span>Featured Artist with the most weeks in the Top 10: <?=$featartistlongestweeks?></span></li>
<li><span>Featured Artist with the most #1 Songs: <?=$featartistmosthitsno1?></span></li>
<li><span>Featured Artist with the most weeks at #1: <?= $featartistlongestweeksno1?></span></li>
<!--<li><span>Artists that also have songwriting credits on the same song:  <?=$artistalsosw?></span></li>
<li><span>Artists that also have producer credits on the same song:  <?=$artistalsoprod?></span></li>
<li><span>Artists that also have songwriting and producer credits on the same song: <?=$artistalsoboth?></span></li>-->



<li class="overview-head-title"><span><b>Songwriters</b></span></li>

<li><span>Number of Credited Songwriters: <?=$numsongwriters?></span></li>
<li><span>Number of Credited Songwriters with #1 Hits: <?=$num1songwriters?></span></li>
<li><span>Songwriter with the most Top 10 Songs: <?=$songwritermosthits?></span></li>
<li><span>Songwriter with the most weeks in the Top 10: <?=$songwriterlongestweeks?></span></li>
<li><span>Songwriter with the most #1 Songs: <?=$songwritermosthitsno1?></span></li>
<li><span>Songwriter with the most weeks at #1: <?=$songwriterlongestweeksno1?></span></li>
<li><span>Most popular songwriting team size: <?=$songwritercountmosthits?></span></li>


<li class="overview-head-title"><span><b>Producers</b></span></li>

<li><span>Number of Credited Producers: <?=$numproducers?></span></li>
<li><span>Number of Credited Producers with #1 Hits: <?=$num1producers?></span></li>
<li><span>Producer with the most Top 10 Songs: <?=$producermosthits?></span></li>
<li><span>Producer with the most weeks in the Top 10: <?=$producerlongestweeks?></span></li>
<li><span>Producer with the most #1 Songs: <?=$producermosthitsno1?></span></li>
<li><span>Producer with the most weeks at #1: <?=$producerlongestweeksno1?></span></li>

<li class="overview-head-title"><span><b>Record Labels</b></span></li>

<li><span>Number of Credited Record Labels: <?=$numlabels?></span></li>
<li><span>Number of Credited Record Labels with #1 Hits: <?=$num1labels?></span></li>
<li><span>Record Label with the most top 10 Songs: <?=$labelmosthits?></span></li>
<li><span>Record Label with the most weeks in the Top 10: <?=$labellongestweeks?> </span></li>
<li><span>Record Label with the most #1 Songs: <?=$labelmosthitsno1?></span></li>
<li><span>Record Label with the most weeks at #1: <?=$labellongestweeksno1?></span></li>

</ul>
            	</div>
<? } ?>
