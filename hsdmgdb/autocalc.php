<?php
    // auto calc
    db_query( "update song_to_songsection set length = sec_to_time( time_to_sec( endtime ) - time_to_sec( starttime ) ) where songid = $songid" );
    
    $autocalcvalues = array();

    $firstrow = db_query_first( "select Name, type, OrderBy, weekdates.id from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by OrderBy limit 1" );
    $firstdate = $firstrow[OrderBy];
//echo( "autoclcing $songid: " . $firstdate . "<br>" );
      if( date( "n", $firstdate ) <= 3 )
      {
	$quarter = "1/" . date( "Y", $firstdate );
      }
    else if( date( "n", $firstdate ) <= 6 )

      {
	$quarter = "2/" . date( "Y", $firstdate );
      }
    else if( date( "n", $firstdate ) <= 9 )
      {
	$quarter = "3/" . date( "Y", $firstdate );
      }
    else
      {
	$quarter = "4/" . date( "Y", $firstdate );
      }

    $numweeks = db_query_first_cell( "select count(*) from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by OrderBy" );
    $peak = db_query_first_cell( "select type from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
    $firstsection = db_query_first_cell("select songsectionid from song_to_songsection, songsections where songid = $songid and songsectionid = songsections.id order by starttime limit 1" );
    $lastsection = db_query_first_cell("select songsectionid from song_to_songsection, songsections where songid = $songid and songsectionid = songsections.id order by endtime desc limit 1" );
    $bridgesurrcount = db_query_first_cell("select count(*) from song_to_songsection where songid = $songid and BridgeSurrogate = 1" );

$autocalcvalues["BridgeSurrCount"] = $bridgesurrcount;

// $keymajor = "";
// $keymajor = getTableValue( $songkeyid, "songkeys" ) . " " . $majorminor;
// $autocalcvalues["KeyMajor"] = trim( $keymajor );
$dist = db_query_rows( "select distinct( type ) from song_to_songkey where songid = $songid" );
if( count( $dist ) > 1 )
    {
	$autocalcvalues["MajorMinor"] = "Both";
    }
else
    {
	$autocalcvalues["MajorMinor"] = db_query_first_cell( "select type from song_to_songkey where songid = $songid" );
    }

$dist = db_query_rows( "select type, Name, song_to_songkey.id from song_to_songkey, songkeys where songid = $songid and songkeyid = songkeys.id" );
foreach($dist as $d )
{
    db_query( "update song_to_songkey set NameHard = '$d[Name] $d[type]' where id = $d[id]" );
}

    $firstsectiontype = db_query_first_cell("select WithoutNumber from song_to_songsection, songsections where songid = $songid and songsectionid = songsections.id order by starttime limit 1" );
    $lastsectiontype = db_query_first_cell("select WithoutNumber from song_to_songsection, songsections where songid = $songid and songsectionid = songsections.id order by endtime desc limit 1" );

    $songstructure = db_query_first_cell( "select group_concat( ShortAbbreviation  order by starttime separator '-'  ) from song_to_songsection, songsections where songsectionid = songsections.id and songid = $songid group by songid ;" );
$shortsongstructure = db_query_first_cell( "select group_concat( ShortAbbreviation  order by starttime separator '-'  ) from song_to_songsection, songsections where songsectionid = songsections.id and songid = $songid and InAbbreviated = 1 group by songid ;" );
$shortsongstructure = "-". $shortsongstructure. "-";

$bsshortsongstructure = db_query_first_cell( "select group_concat( case when BridgeSurrogate = 1 then 'D' else ShortAbbreviation end  order by starttime separator '-'  ) from song_to_songsection, songsections where songsectionid = songsections.id and songid = $songid and ( InAbbreviated = 1 or BridgeSurrogate = 1 ) group by songid ;" );
$bsshortsongstructure = "-". $bsshortsongstructure. "-";


// this was the best way I could think to remove dupes
$sects = db_query_array( "select distinct( ShortAbbreviation ) as S from songsections where InAbbreviated = 1", "S", "S" );
$sects["D"] = "D";
foreach( $sects as $s )
  {
    for( $i = 1; $i < 10; $i++ )
      {
	$shortsongstructure = str_replace( "-{$s}-{$s}-", "-{$s}-", $shortsongstructure );
	$bsshortsongstructure = str_replace( "-{$s}-{$s}-", "-{$s}-", $bsshortsongstructure );
      }
  }

$shortsongstructure = substr( $shortsongstructure, 1, -1 );
$bsshortsongstructure = substr( $bsshortsongstructure, 1, -1 );

    $firstchorusstart = db_query_first_cell( "select time_to_sec( starttime ) from song_to_songsection where songid = $songid and songsectionid = " . CHORUS1 );
    $firstversestart = db_query_first_cell( "select time_to_sec( starttime ) from song_to_songsection where songid = $songid and songsectionid = " . VERSE1 );
    $outrolength = db_query_first_cell( "select time_to_sec( length ) from song_to_songsection where songid = $songid and songsectionid = " . OUTRO );
    $totalsec = db_query_first_cell( "select time_to_sec( SongLength ) from songs where id = $songid" );

$autocalcvalues["FirstChorusPercent"] = number_format( $firstchorusstart * 100 / ($totalsec?$totalsec:1), 2 ); 

    $autocalcvalues["ChorusPrecedesVerse"] = $firstchorusstart<$firstversestart?1:0;


    // this is a description of the PERCENT into the song 
    // if( $autocalcvalues["FirstChorusPercent"] <= 0  )
    // 	$autocalcvalues["FirstChorusPercentRange"] = "Kickoff";
    // else if( $autocalcvalues["FirstChorusPercent"] < 10   )
    // 	$autocalcvalues["FirstChorusPercentRange"] = "Early";
    // else if( $autocalcvalues["FirstChorusPercent"] < 20  )
    // 	$autocalcvalues["FirstChorusPercentRange"] = "Moderately Early";
    // else if( $autocalcvalues["FirstChorusPercent"] < 30  )
    // 	$autocalcvalues["FirstChorusPercentRange"] = "Moderately Late";
    // else
    // 	$autocalcvalues["FirstChorusPercentRange"] = "Late";


    // this is a description of the TIME into the song 
db_query( "update songs set FirstChorusDescr = null" );
$firstchorusarr = db_query_rows( "select time_to_sec( starttime ) as tm, songid from song_to_songsection where songsectionid = " . CHORUS1 );
foreach( $firstchorusarr as $frow )
{
    $firstchorusstart = $frow["tm"];
    if( $firstchorusstart <= 0  )
	db_query( "update songs set FirstChorusDescr = 'Kickoff' where id = $frow[songid]" );
    else if( $firstchorusstart < 20  )
	db_query( "update songs set FirstChorusDescr = 'Early' where id = $frow[songid]" );
    else if( $firstchorusstart < 40  )
	db_query( "update songs set FirstChorusDescr = 'Moderately Early' where id = $frow[songid]" );
    else if( $firstchorusstart < 60  )
	db_query( "update songs set FirstChorusDescr = 'Moderately Late' where id = $frow[songid]" );
    else
	db_query( "update songs set FirstChorusDescr = 'Late' where id = $frow[songid]" );
}

    // this is a description of how LONG the outro is      
if( !$outrolength  )
    $autocalcvalues["OutroRange"] = "No Outro";
else if ( $outrolength < 10 )
    $autocalcvalues["OutroRange"] = "Short";
else if ( $outrolength < 20 )
    $autocalcvalues["OutroRange"] = "Moderately Short";
else if ( $outrolength < 30 )
    $autocalcvalues["OutroRange"] = "Moderately Long";
else
    $autocalcvalues["OutroRange"] = "Long";

$versecount = db_query_first_cell( "select count(*) from song_to_songsection, songsections where songsectionid = songsections.id and songid = $songid and Name like 'Verse%'" );
$prechoruscount = db_query_first_cell( "select count(*) from song_to_songsection, songsections where songsectionid = songsections.id and songid = $songid and Name like 'Pre-Chorus%'" );

$bridgecount = db_query_first_cell( "select count(*) from song_to_songsection, songsections where songsectionid = songsections.id and songid = $songid and Name like 'Bridge%'" );
$breakcount = db_query_first_cell( "select count(*) from song_to_songsection, songsections where songsectionid = songsections.id and songid = $songid and Name like '%Break%'" );
$choruscount = db_query_first_cell( "select count(*) from song_to_songsection, songsections where songsectionid = songsections.id and songid = $songid and Name like 'Chorus%'" );

if( $artistband && $songnameid )
{
    $autocalcvalues["SongNameHard"] = escMe( getSongname( $songnameid ) );
    $clean = findClean( $artistband . "-" . getSongname( $songnameid ) );
    $autocalcvalues["CleanUrl"] = $clean;
}
else if( $clientid && $songnameid )
{
    $clientname = getTableValue( $clientid, "clients" );
    $autocalcvalues["SongNameHard"] = escMe( getSongname( $songnameid ) );
    $clean = findClean( $clientname . "-" . getSongname( $songnameid ) );
    $autocalcvalues["CleanUrl"] = $clean;
}

if( !$allgenresfordropdown )
    $allgenresfordropdown = db_query_array( "select id, Name from genres order by OrderBy, Name", "id", "Name" );

$nosubgenreid = db_query_first_cell( "select id from subgenres where Name = '" . $allgenresfordropdown[$genreid]. "'" );
$num = db_query_first_cell( "select count( * ) from song_to_subgenre, subgenres where songid = '$songid' and subgenreid = subgenres.id and subgenreid <> '$nosubgenreid' and HideFromAdvancedSearch = 0" );
$autocalcvalues["SubgenreCount"] = $num;

$noinfluenceid = db_query_first_cell( "select id from influences where Name = '" . $allgenresfordropdown[$genreid]. "'" );
$num = db_query_first_cell( "select count( * ) from song_to_influence, influences where songid = '$songid' and influenceid = influences.id and influenceid <> '$noinfluenceid' and HideFromAdvancedSearch = 0" );
$autocalcvalues["InfluenceCount"] = $num;

if( $choruscount == 0 || $versecount == 0 ) 
    $autocalcvalues["ChorusPrecedesVerse"] = 0; 

$autocalcvalues["VerseCount"] = $versecount;
$autocalcvalues["ChorusCount"] = $choruscount;
$autocalcvalues["BridgeCount"] = $bridgecount;
$autocalcvalues["BreakCount"] = $breakcount;
$autocalcvalues["PrechorusCount"] = $prechoruscount;
$autocalcvalues["QuarterEnteredTheTop10"] = $quarter;
$autocalcvalues["WeekEnteredTheTop10"] = $firstrow[id];
$autocalcvalues["YearEnteredTheTop10"] = date( "Y", $firstdate );
$autocalcvalues["EntryPosition"] = str_replace( "position", "", $firstrow["type"] );
$autocalcvalues["NumberOfWeeksSpentInTheTop10"] = $numweeks;
$autocalcvalues["PeakPosition"] = str_replace( "position", "", $peak );
$autocalcvalues["FirstSection"] = $firstsection;
$autocalcvalues["LastSectionID"] = $lastsection;
$autocalcvalues["FirstSectionType"] = $firstsectiontype;
$autocalcvalues["LastSectionType"] = $lastsectiontype;
$autocalcvalues["SongStructure"] = $songstructure;
$autocalcvalues["AbbrevSongStructure"] = $shortsongstructure;
$autocalcvalues["BridgeSurrogateShortForm"] = $bsshortsongstructure;

$songwriters = db_query_first_cell( "select count(*) from song_to_artist where type = 'creditedsw' and songid = '$songid'" );
$autocalcvalues["SongwriterCount"] = $songwriters;

$songwriters = db_query_first_cell( "select count(*) from song_to_artist where type in ( 'featured', 'primary' ) and songid = '$songid'" );
$songwriters += db_query_first_cell( "select count(*) from song_to_group where type in ( 'featured', 'primary' ) and songid = '$songid'" );
$autocalcvalues["ArtistCount"] = $songwriters;

$songwriters = db_query_first_cell( "select count(*) from song_to_artist where type in ( 'primary' ) and songid = '$songid'" );
$songwriters += db_query_first_cell( "select count(*) from song_to_group where type in ( 'primary' ) and songid = '$songid'" );
$autocalcvalues["LeadArtistCount"] = $songwriters;

$songwriters = db_query_first_cell( "select count(*) from song_to_producer where songid = '$songid'" );
$autocalcvalues["ProducerCount"] = $songwriters;

$songwriters = db_query_first_cell( "select count(*) from song_to_label where songid = '$songid'" );
$autocalcvalues["LabelCount"] = $songwriters;

$tmpp = db_query_array( "select distinct(memberid) from song_to_producer s, producer_to_member p where songid = '$songid' and s.producerid = p.producerid", "memberid", "memberid" );
$tmpa = db_query_array( "select distinct(memberid) from song_to_artist s, artist_to_member p where songid = '$songid' and s.artistid = p.artistid", "memberid", "memberid" );
$tmpg = db_query_array( "select distinct(memberid) from song_to_group s, group_to_member p where songid = '$songid' and s.groupid = p.groupid", "memberid", "memberid" );

$merged = array_merge( $tmpa, $tmpp, $tmpg );
$unique = array_unique( $merged );

$autocalcvalues["TotalCount"] = count( $unique );



$anyfemale = db_query_first_cell( "select count(*) from song_to_artist a, artist_to_member b, members c where c.id = b.memberid and type = 'primary' and MemberGender = 'Female' and songid = $songid and a.artistid = b.artistid" );    

$anyfemalegroup = db_query_first_cell( "select count(*) from song_to_group a, group_to_member b, members c where c.id = b.memberid and type = 'primary' and MemberGender = 'Female' and songid = $songid and a.groupid = b.groupid" ); 


$anyfemalefeat = db_query_first_cell( "select count(*) from song_to_artist a, artist_to_member b, members c where c.id = b.memberid and type = 'featured' and MemberGender = 'Female' and songid = $songid and a.artistid = b.artistid" );    

$anyfemalefeat += db_query_first_cell( "select count(*) from song_to_group a, group_to_member b, members c where c.id = b.memberid and type = 'featured' and MemberGender = 'Female' and songid = $songid and a.groupid = b.groupid" ); 

$anymalefeat = db_query_first_cell( "select count(*) from song_to_artist a, artist_to_member b, members c where c.id = b.memberid and type = 'featured' and MemberGender = 'Male'  and songid = $songid and a.artistid = b.artistid" );    

$anymalefeat += db_query_first_cell( "select count(*) from song_to_group a, group_to_member b, members c where c.id = b.memberid and type = 'featured' and MemberGender = 'Male' and songid = $songid and a.groupid = b.groupid" ); 



$autocalcvalues["PrimaryGender"] = $anyfemale || $anyfemalegroup ? "Female":"Male";
$autocalcvalues["FeatGender"] = "";

if( $anyfemalefeat || $anymalefeat )
    {
	if( $anymalefeat && $anyfemalefeat )
	    $autocalcvalues["FeatGender"] = "Both";
	else if ( $anymalefeat )
	    $autocalcvalues["FeatGender"] = "Male";
	else
	    $autocalcvalues["FeatGender"] = "Female";
	
    }






$arr = db_query_array( "select distinct( WithoutNumberHard ) from song_to_songsection where songid = '$songid' ", "WithoutNumberHard", "WithoutNumberHard" );
if( db_query_first_cell( "select sum( BridgeSurrogate )  from song_to_songsection where songid = '$songid'" ) )
    $arr[] = "Bridge Surrogate";
if( db_query_first_cell( "select sum( PostChorus )  from song_to_songsection where songid = '$songid'" ) )
    $arr[] = "Post-Chorus";

$autocalcvalues["AllSections"] = "," . implode( ",", $arr ) . ",";
$arr = db_query_array( "select distinct( placementid ) from song_to_placement where songid = '$songid' ", "placementid", "placementid" );
$autocalcvalues["PlacementsHard"] = "," . implode( ",", $arr ) . ",";
$arr = db_query_array( "select distinct( subgenreid ) from song_to_subgenre where songid = '$songid' and type = 'Main' ", "subgenreid", "subgenreid" );
$autocalcvalues["SubgenresHard"] = "," . implode( ",", $arr ) . ",";

$arr = db_query_array( "select distinct( lyricalthemeid ) from song_to_lyricaltheme where songid = '$songid' ", "lyricalthemeid", "lyricalthemeid" );
$autocalcvalues["LyricalThemesHard"] = "," . implode( ",", $arr ) . ",";
    
$arr = db_query_array( "select vocaltypeid from song_to_vocaltype where songid = $songid", "vocaltypeid", "vocaltypeid" );
$autocalcvalues["SubsectionVocalTypesHard"] = "," . implode( ",", $arr ) . ",";

$arr = db_query_array( "select vocalid from song_to_vocal where songid = $songid", "vocalid", "vocalid" );
$autocalcvalues["SubsectionVocalsHard"] = "," . implode( ",", $arr ) . ",";
 
$autocalcvalues["NumberOfWeeksSpentInTheTop10"] = db_query_first_cell( "select count(*) from song_to_weekdate where songid = $songid" );    

$chor = db_query_first_cell( "select chorustypeid from song_to_chorustype where type = 4 and chorustypeid = 3 and songid = $songid" );
$autocalcvalues["FirstChorusBreakdown"] = $chor?1:-1;

    /* $sql .= ", QuarterEnteredTheTop10 = '$qettt'"; */
    /* $sql .= ", YearEnteredTheTop10 = '$yettt'"; */
    //    $sql .= ", EntryPosition = '$ep'";
    //    $sql .= ", NumberOfWeeksSpentInTheTop10 = '$nwtt'";
    //    $sql .= ", PeakPosition = '$pp'";
    foreach( $autocalcvalues as $aid=>$val )
      {
	//echo( "update songs set $aid = '$val' where id = $songid<br>" );
	db_query( "update songs set $aid = '$val' where id = $songid" );
      }
    //    exit;

    // start these are general updates
    db_query( "update songs set SongLengthRange = 'Under 3:00' where SongLength < '00:03:00' and id = '$songid'" );
    db_query( "update songs set SongLengthRange = '3:00 - 3:29' where SongLength >= '00:03:00' and SongLength < '00:03:30'  and id = '$songid'" );
    db_query( "update songs set SongLengthRange = '3:30 - 3:59' where SongLength >= '00:03:30' and SongLength < '00:04:00'  and id = '$songid'" );
    db_query( "update songs set SongLengthRange = '4:00 +' where SongLength >= '00:04:00'  and id = '$songid'" );

    db_query( "update songs set IntroLengthRange = 'No Intro' where id not in ( select songid from song_to_songsection where songsectionid = " . INTRO  . " )  and id = '$songid'");
    db_query( "update songs set IntroLengthRange = 'Short' where id in ( select songid from song_to_songsection where songsectionid = " . INTRO . " and length >= '00:00:01' and length < '00:00:10' )  and id = '$songid'" );
    db_query( "update songs set IntroLengthRange = 'Moderately Short' where id in ( select songid from song_to_songsection where songsectionid = " . INTRO . " and length >= '00:00:10' and length < '00:00:20' ) and id = '$songid'" );
    db_query( "update songs set IntroLengthRange = 'Moderately Long' where id in ( select songid from song_to_songsection where songsectionid = " . INTRO . " and length >= '00:00:20' and length < '00:00:30' )  and id = '$songid'" );
    db_query( "update songs set IntroLengthRange = 'Long' where id in ( select songid from song_to_songsection where songsectionid = " . INTRO . " and length >= '00:00:30' )  and id = '$songid'" );

    // end these are general updates

    $tmp = db_query_rows( "select *, time_to_sec( length ) as lengthinsec from song_to_songsection where songid = $songid order by starttime" );
    $i = 0;
    foreach( $tmp as $t )
      {
	$i++;
	$lengthinsec = $t["lengthinsec"];
	$perc = $totalsec?number_format( $lengthinsec*100/$totalsec, 2 ):0; 
	db_query( "update song_to_songsection set sectionpercent = '$perc', sectioncount = '$i' where songid = $songid and songsectionid = $t[songsectionid]" );
      }


$times = array();
$times[] = "None";
$times[] = "1 - 5 Times";
$times[] = "6 - 10 Times";
$times[] = "11 - 15 Times";
$times[] = "16 - 20 Times";
$times[] = "21+ Times";

$etimes = array();
$etimes[] = array( 0, 0 );
$etimes[] = array( 1, 5 );
$etimes[] = array( 6, 10 );
$etimes[] = array( 11, 15 );
$etimes[] = array( 16, 20 );
$etimes[] = array( 21, 9999 );

foreach( $times as $k=>$t )
  {
    $et = $etimes[$k];
    db_query( "update songs set SongTitleAppearanceRange = '$t' where SongTitleAppearances >= '$et[0]' and SongTitleAppearances <= '$et[1]'" );
  }


db_query( "update songs set IntroLengthRangeNums = '' where id not in ( select songid from song_to_songsection where songsectionid = " . INTRO  . " )");

$times = array();
$times[] = "0:01 - 0:09";
$times[] = "0:10 - 0:19";
$times[] = "0:20 - 0:29";
$times[] = "0:30 +";

$etimes = array();
$etimes[] = array( '00:00:01', '00:00:10' );
$etimes[] = array( '00:00:10', '00:00:20' );
$etimes[] = array( '00:00:20', '00:00:30' );
$etimes[] = array( '00:00:30', '23:00:00' );

foreach( $times as $k=>$t )
  {
    $et = $etimes[$k];
    db_query( "update songs set IntroLengthRangeNums = '$t' where id in ( select songid from song_to_songsection where songsectionid = " . INTRO . " and length >= '$et[0]' and length < '$et[1]' )" );
  }


db_query( "update songs set OutroLengthRangeNums = '' where id not in ( select songid from song_to_songsection where songsectionid = " . OUTRO  . " )");

$times = array();
$times[] = "0:01 - 0:09";
$times[] = "0:10 - 0:19";
$times[] = "0:20 - 0:29";
$times[] = "0:30 +";

$etimes = array();
$etimes[] = array( '00:00:01', '00:00:10' );
$etimes[] = array( '00:00:10', '00:00:20' );
$etimes[] = array( '00:00:20', '00:00:30' );
$etimes[] = array( '00:00:30', '23:00:00' );

foreach( $times as $k=>$t )
  {
    $et = $etimes[$k];
    db_query( "update songs set OutroLengthRangeNums = '$t' where id in ( select songid from song_to_songsection where songsectionid = " . OUTRO . " and length >= '$et[0]' and length < '$et[1]' )" );
  }



// $possranges = array( "79 or less" => array( 0, 79 ) );
// $possranges["80 - 109"] = array( 80, 109 );
// $possranges["110+"] = array( 110, 4000 );
// foreach( $possranges as $displ => $arr )
// {
//     $min = $arr[0];
// $max = $arr[1];
// }
$i = 0; 
while( $i < 400 )
  {
    $endi = $i + 9;
    $t = "$i - $endi";
    db_query( "update songs set TempoRange = '$t' where Tempo >= '$i' and Tempo <= '$endi'" );
    $i+= 10;
  }
db_query( "update songs set TempoRange = '' where Tempo is null" );
db_query( "update songs set TempoRange = '' where Tempo = 0" );



$times = array();
$times[] = "Kickoff";
$times[] = "0:01 - 0:19";
$times[] = "0:20 - 0:39";
$times[] = "0:40 - 0:59";
$times[] = "1:00 +";

$etimes = array();
$etimes[] = array( '00:00:00', '00:00:01' );
$etimes[] = array( '00:00:01', '00:00:20' );
$etimes[] = array( '00:00:20', '00:00:40' );
$etimes[] = array( '00:00:40', '00:01:00' );
$etimes[] = array( '00:01:00', '23:00:00' );

db_query( "update songs set FirstChorusRange = null" );
foreach( $times as $k=>$t )
  {
    $et = $etimes[$k];
    //    echo( "update songs set FirstChorusRange = '$t' where id in ( select songid from song_to_songsection where songsectionid = " . CHORUS1 . " and starttime >= '$et[0]' and starttime < '$et[1]' )<br>" );
    db_query( "update songs set FirstChorusRange = '$t' where id in ( select songid from song_to_songsection where songsectionid = " . CHORUS1 . " and starttime >= '$et[0]' and starttime < '$et[1]' )" );
  }


    // if( $autocalcvalues["FirstChorusPercent"] <= 0  )
    // 	$autocalcvalues["FirstChorusPercentRange"] = "Kickoff";
    // else if( $autocalcvalues["FirstChorusPercent"] < 10   )
    // 	$autocalcvalues["FirstChorusPercentRange"] = "Early";
    // else if( $autocalcvalues["FirstChorusPercent"] < 20  )
    // 	$autocalcvalues["FirstChorusPercentRange"] = "Moderately Early";
    // else if( $autocalcvalues["FirstChorusPercent"] < 30  )
    // 	$autocalcvalues["FirstChorusPercentRange"] = "Moderately Late";
    // else
    // 	$autocalcvalues["FirstChorusPercentRange"] = "Late";


db_query( "update songs set FirstChorusPercentRange = null" );
$arr = array( 0=>"Kickoff", "10"=>"Early", 20=>"Moderately Early", "30"=>"Moderately Late", "100"=>"Late");
foreach( $arr as $a=>$descr )
{
    db_query( "update songs set FirstChorusPercentRange = '$descr' where FirstChorusPercent <= $a and FirstChorusPercentRange is null" );
//    echo( "update songs set FirstChorusPercentRange = '$descr' where FirstChorusPercent <= $a and FirstChorusPercentRange is null<br>" );
}

db_query( "update songs set FirstChorusDescr = null, FirstChorusPercentRange = null where FirstChorusRange is null" );





db_query( "delete from SectionShorthand where songid = '$songid'" );

foreach( $mainsections as $m )
{
    if( $m == "Instrumental Break" ) $m = "Inst Break";
    $samearr = db_query_first( "select count( distinct( Bars ) ) as bars, count(*) as num, sum( sectionpercent ) as percent from song_to_songsection where songid = '$songid' and WithoutNumberHard = '$m'" );
    $same = $samearr["bars"];
    $num = $samearr["num"];
    $percent = $samearr["percent"];

    // if( $m == "Bridge" )
    // {
    //         // adding bridge surrogate there
    //     $num += db_query_first_cell( "select count( * ) from song_to_songsection where songid = '$songid' and BridgeSurrogate = 1" );
    //     $percent += db_query_first_cell( "select sum( sectionpercent ) from song_to_songsection where songid = '$songid' and BridgeSurrogate = 1" );
    // }
    
    db_query( "insert into SectionShorthand ( songid, section, LengthsSame, NumSections, PercentOfSong ) values ( '$songid', '$m', $same, $num, '$percent' ) " );
}



// fixing msword characters
$tmprow = db_query_first( "select * from songs where id = $songid" );
$mscols[] = "V1V2BackingComments";
$mscols[] = "V1V2MelodyComments";
$mscols[] = "PreChorusMTIComments";
$mscols[] = "VersePreChorusBackingMusicComments";
$mscols[] = "OutroTypeComments";
$mscols[] = "Lyrics";
$mscols[] = "VocalTypeExamples";
$mscols[] = "FormDescription";
$mscols[] = "FirstSectionDescription";
$mscols[] = "IntroDescr";
$mscols[] = "ChorusDescr";
$mscols[] = "ArtistBand";
$mscols[] = "Composition";
$mscols[] = "FirstChorusMTIDetails";
$mscols[] = "SubgenreFusionTypeDescription";
$mscols[] = "OutroCharacteristicsDescr";
$mscols[] = "EndingDetails";

foreach( $mscols as $colname )
{
	$newval = convertBadChars( $tmprow[$colname] );
	if( $tmprow[$colname] != $newval )
	{
//        echo( "would update $colname to $newval<br>" );
       db_query( "update songs set $colname = '" . escMe( $newval ) . "' where id = $songid" );
	}
}



?>
