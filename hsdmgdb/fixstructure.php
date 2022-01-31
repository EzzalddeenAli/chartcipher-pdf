<? 
include "connect.php";
// if( !$allgenresfordropdown )
//     $allgenresfordropdown = db_query_array( "select id, Name from genres order by OrderBy, Name", "id", "Name" );


$songs = db_query_rows( "select id, BillboardName from songs where IsActive = 1 ", "id" );
//print_r( $songs );
foreach( $songs as $songid=>$srow )
{

	echo( "select songnames.id from songnames where Name = '" . escMe( $srow["BillboardName"] ) . "'<br>" );
	$a = db_query_first_cell( "select songnames.id from songnames where Name = '" . escMe( $srow["BillboardName"] ) . "'" );
	echo( "bname: ($songid)" . $srow["BillboardName"] . "<br>");

     $autocalcvalues["songnameid"] = $a;
    foreach( $autocalcvalues as $aid=>$val )
    {
        if( $val )
	    {
		echo( "$srow[CleanUrl] - update songs set $aid = '$val' where id = $songid<br>" );
			db_query( "update songs set $aid = '$val' where id = $songid" );
			}
    }
    
}
exit;

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
