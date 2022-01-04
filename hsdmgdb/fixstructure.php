<? 
include "connect.php";
// if( !$allgenresfordropdown )
//     $allgenresfordropdown = db_query_array( "select id, Name from genres order by OrderBy, Name", "id", "Name" );


$songs = db_query_rows( "select * from songs where IsActive = 1 ", "id" );
foreach( $songs as $songid=>$srow )
{

$arr = db_query_array( "select distinct( influenceid ) from song_to_influence where songid = '$songid' and type = 'Main' ", "influenceid", "influenceid" );
$autocalcvalues["InfluencesHard"] = "," . implode( ",", $arr ) . ",";
    // // $anyfemale = db_query_first_cell( "select count(*) from song_to_artist a, artist_to_member b, members c where c.id = b.memberid and type = 'primary' and MemberGender = 'Female' and songid = $songid and a.artistid = b.artistid" );    
    
    // // $anyfemalegroup = db_query_first_cell( "select count(*) from song_to_group a, group_to_member b, members c where c.id = b.memberid and type = 'primary' and MemberGender = 'Female' and songid = $songid and a.groupid = b.groupid" ); 


    // // $anyfemalefeat = db_query_first_cell( "select count(*) from song_to_artist a, artist_to_member b, members c where c.id = b.memberid and type = 'featured' and MemberGender = 'Female' and songid = $songid and a.artistid = b.artistid" );    
    
    // // $anyfemalefeat += db_query_first_cell( "select count(*) from song_to_group a, group_to_member b, members c where c.id = b.memberid and type = 'featured' and MemberGender = 'Female' and songid = $songid and a.groupid = b.groupid" ); 

    // // $anymalefeat = db_query_first_cell( "select count(*) from song_to_artist a, artist_to_member b, members c where c.id = b.memberid and type = 'featured' and MemberGender = 'Male'  and songid = $songid and a.artistid = b.artistid" );    
    
    // // $anymalefeat += db_query_first_cell( "select count(*) from song_to_group a, group_to_member b, members c where c.id = b.memberid and type = 'featured' and MemberGender = 'Male' and songid = $songid and a.groupid = b.groupid" ); 



    // $autocalcvalues["PrimaryGender"] = $anyfemale || $anyfemalegroup ? "Female":"Male";
    // $autocalcvalues["FeatGender"] = "";
    
    // if( $anyfemalefeat || $anymalefeat )
    // 	{
    // 	    if( $anymalefeat && $anyfemalefeat )
    // 		$autocalcvalues["FeatGender"] = "Both";
    // 	    else if ( $anymalefeat )
    // 		$autocalcvalues["FeatGender"] = "Male";
    // 	    else
    // 		$autocalcvalues["FeatGender"] = "Female";

    // 	}

    // $arr = db_query_array( "select distinct( subgenreid ) from song_to_subgenre where songid = '$songid' and type = 'Main' ", "subgenreid", "subgenreid" );
    // $autocalcvalues["SubgenresHard"] = "," . implode( ",", $arr ) . ",";
    foreach( $autocalcvalues as $aid=>$val )
    {
	echo( "$srow[CleanUrl] - update songs set $aid = '$val' where id = $songid<br>" );
	db_query( "update songs set $aid = '$val' where id = $songid" );
    }
    
}


// $dist = db_query_rows( "select type, Name, song_to_songkey.id from song_to_songkey, songkeys where songkeyid = songkeys.id" );
// foreach($dist as $d )
// {
//     echo( "update song_to_songkey set NameHard = '$d[Name] $d[type]' where id = $d[id]<br>" );
//     db_query( "update song_to_songkey set NameHard = '$d[Name] $d[type]' where id = $d[id]" );
// }

exit;


// foreach( $songs as $songid=>$srow )
// {
// $autocalcvalues = array();
// $songwriters = db_query_first_cell( "select count(*) from song_to_artist where type in ( 'featured', 'primary' ) and songid = '$songid'" );
// $songwriters += db_query_first_cell( "select count(*) from song_to_group where type in ( 'featured', 'primary' ) and songid = '$songid'" );
// $autocalcvalues["ArtistCount"] = $songwriters;

// $songwriters = db_query_first_cell( "select count(*) from song_to_producer where songid = '$songid'" );
// $autocalcvalues["ProducerCount"] = $songwriters;

//     foreach( $autocalcvalues as $aid=>$val )
//       {
// echo( "$srow[CleanUrl] - update songs set $aid = '$val' where id = $songid<br>" );
// db_query( "update songs set $aid = '$val' where id = $songid" );
//       }

// continue;
//     $songstructure = db_query_first_cell( "select group_concat( ShortAbbreviation  order by starttime separator '-'  ) from song_to_songsection, songsections where songsectionid = songsections.id and songid = $songid group by songid ;" );
// $shortsongstructure = db_query_first_cell( "select group_concat( ShortAbbreviation  order by starttime separator '-'  ) from song_to_songsection, songsections where songsectionid = songsections.id and songid = $songid and InAbbreviated = 1 group by songid ;" );
// $shortsongstructure = "-". $shortsongstructure. "-";

// $bsshortsongstructure = db_query_first_cell( "select group_concat( case when BridgeSurrogate = 1 then 'D' else ShortAbbreviation end  order by starttime separator '-'  ) from song_to_songsection, songsections where songsectionid = songsections.id and songid = $songid and ( InAbbreviated = 1 or BridgeSurrogate = 1 ) group by songid ;" );
// $bsshortsongstructure = "-". $bsshortsongstructure. "-";
// echo( "bsbefore: " . $bsshortsongstructure . "<br>" );


// // this was the best way I could think to remove dupes
// $sects = db_query_array( "select distinct( ShortAbbreviation ) as S from songsections where InAbbreviated = 1", "S", "S" );
// $sects["D"] = "D";
// foreach( $sects as $s )
//   {
//     for( $i = 1; $i < 10; $i++ )
//       {
// 	$shortsongstructure = str_replace( "-{$s}-{$s}-", "-{$s}-", $shortsongstructure );
// 	$bsshortsongstructure = str_replace( "-{$s}-{$s}-", "-{$s}-", $bsshortsongstructure );
//       }
//   }

// $shortsongstructure = substr( $shortsongstructure, 1, -1 );
// $bsshortsongstructure = substr( $bsshortsongstructure, 1, -1 );
// $autocalcvalues = array();
// $autocalcvalues["AbbrevSongStructure"] = $shortsongstructure;
// $autocalcvalues["BridgeSurrogateShortForm"] = $bsshortsongstructure;
//     foreach( $autocalcvalues as $aid=>$val )
//       {
// echo( "update songs set $aid = '$val' where id = $songid<br>" );
// db_query( "update songs set $aid = '$val' where id = $songid" );
//       }
//     //    exit;

// }
// exit;

// foreach( $songs as $songid=>$srow )
// {
//     $peak = db_query_first_cell( "select type from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
//     $peak = str_replace( "position", "", $peak );
//     db_query( "update songs set PeakPosition = '$peak' where id = $songid" );
//     echo( "update songs set PeakPosition = '$peak' where id = $songid<br>" );
    
    
// }
// exit;
// // foreach( $songs as $songid=> $tmprow )
// // {
// //     $arr = db_query_rows( "select * from song_to_songsection where songid = $tmprow[id]", "songsectionid" );
// //     foreach( $arr as $songsectionid=>$ssrow )
// //     {
// // //        echo( $songsectionid ); 
// //         $tmpvt = db_query_array( "select vocalid from song_to_vocal where songid = $songid and type = '$songsectionid'", "vocalid", "vocalid" );
// //         db_query( "update song_to_songsection set VocalsHard = '," . escMe( implode( ",", $tmpvt ) ) . ",' where songid = $songid and songsectionid = $songsectionid" );
// //     }
    
// // }

// // $mscols = array(); 
// // $mscols[] = "V1V2BackingComments";
// // $mscols[] = "V1V2MelodyComments";
// // $mscols[] = "PreChorusMTIComments";
// // $mscols[] = "VersePreChorusBackingMusicComments";
// // $mscols[] = "OutroTypeComments";
// // $mscols[] = "Lyrics";
// // $mscols[] = "VocalTypeExamples";
// // $mscols[] = "FormDescription";
// // $mscols[] = "FirstSectionDescription";
// // $mscols[] = "IntroDescr";
// // $mscols[] = "ChorusDescr";
// // $mscols[] = "ArtistBand";
// // $mscols[] = "Composition";
// // $mscols[] = "FirstChorusMTIDetails";
// // $mscols[] = "SubgenreFusionTypeDescription";
// // $mscols[] = "OutroCharacteristicsDescr";
// // $mscols[] = "EndingDetails";

// // foreach( $songs as $songid=>$tmprow )
// // {

// // db_query( "delete from SectionShorthand where songid = '$songid'" );

// // foreach( $mainsections as $m )
// // {
// //     if( $m == "Instrumental Break" ) $m = "Inst Break";
// //     $samearr = db_query_first( "select count( distinct( Bars ) ) as bars, count(*) as num, sum( sectionpercent ) as percent from song_to_songsection where songid = '$songid' and WithoutNumberHard = '$m'" );
// //     $same = $samearr["bars"];
// //     $num = $samearr["num"];
// //     $percent = $samearr["percent"];
    
// //     db_query( "insert into SectionShorthand ( songid, section, LengthsSame, NumSections, PercentOfSong ) values ( '$songid', '$m', $same, $num, '$percent' ) " );
// // }
// // }

// // foreach( $songs as $songid )
// //   {
// //     $shortsongstructure = db_query_first_cell( "select group_concat( ShortAbbreviation  order by starttime separator '-'  ) from song_to_songsection, songsections where songsectionid = songsections.id and songid = $songid and InAbbreviated = 1 group by songid ;" );
// //     $orig  = $shortsongstructure; 
// //     $shortsongstructure = "-". $shortsongstructure. "-";
    
// //     // this was the best way I could think to remove dupes
// //     $sects = db_query_array( "select distinct( ShortAbbreviation ) as S from songsections where InAbbreviated = 1", "S", "S" );
// //     foreach( $sects as $s )
// //       {
// // 	for( $i = 1; $i < 10; $i++ )
// // 	  {
// // 	    $shortsongstructure = str_replace( "-{$s}-{$s}-", "-{$s}-", $shortsongstructure );
// // 	  }
// //       }
    
// //     $shortsongstructure = substr( $shortsongstructure, 1, -1 );
// //     if( $orig != $shortsongstructure )
// //       {
// // 	echo( $orig . " changed to " . $shortsongstructure . "<br>"  );
// // 	echo( "update songs set AbbrevSongStructure = '$shortsongstructure' where id = '$songid'<br>" );
// // 	db_query( "update songs set AbbrevSongStructure = '$shortsongstructure' where id = '$songid'" );
// //       }
// //   }

?>
