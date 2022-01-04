<? 
include "connect.php";
include "../functions.php";
include "../trendfunctions.php";
 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }


include "nav.php";
?>
<h3>Gender Report
<form method='post'>

<?php

   $vals = explode( ",", $vals );
   echo( "<b>Total Number: " . count( $vals ) . "</b><br>" );
echo( "<table border='1' cellpadding='2' cellspacing=0>" );
      $i = 1;
 if( $type == "songs" ) { 

     function getMF( $gender )
     {
	 if( $gender == "Male" )
	     return "<font color='blue'>Male</font>";
	 if( $gender == "Female" )
	     return "<font color='red'>Female</font>";
	 return $gender;
     }

 foreach( $vals as $v )
  {
      $row = getSongRow( $v );
      echo( "<tr><td valign='top'>{$i}.</td><td valign='top'><a href='editsong.php?id=$v'>$row[CleanUrl]</a></td>" );
      echo( "<td valign='top'>Primary Artists:<br>" );
      $a = db_query_array( "select StageName, MemberGender from members a, song_to_artist b, artist_to_member c where songid = $v and a.id = c.memberid and b.artistid = c.artistid and type in ( 'primary' )", "StageName", "MemberGender" );
      $b = db_query_array( "select StageName, MemberGender from members a, song_to_group b, group_to_member c where songid = $v and a.id = c.memberid and b.groupid = c.groupid and type in ( 'primary' )", "StageName", "MemberGender" );
      foreach( $a as $t=>$g )  echo( "$t - " . getMF( $g ) . "<br>" );
      foreach( $b as $t=>$g )  echo( "$t - " . getMF( $g ) . "<br>" );
      echo( "</td>" );
      echo( "<td valign='top'>Featured Artists:<br>" );
      $a = db_query_array( "select StageName, MemberGender from members a, song_to_artist b, artist_to_member c where songid = $v and a.id = c.memberid and b.artistid = c.artistid and type in ( 'featured' )", "StageName", "MemberGender" );
      $b = db_query_array( "select StageName, MemberGender from members a, song_to_group b, group_to_member c where songid = $v and a.id = c.memberid and b.groupid = c.groupid and type in ( 'featured' )", "StageName", "MemberGender" );
      foreach( $a as $t=>$g )  echo( "$t - " . getMF( $g ) . "<br>" );
      foreach( $b as $t=>$g )  echo( "$t - " . getMF( $g ) . "<br>" );
      echo( "</td>" );
	  echo( "<td valign='top'>Songwriters:<br>" );
      $a = db_query_array( "select StageName, MemberGender from members a, song_to_artist b, artist_to_member c where songid = $v and a.id = c.memberid and b.artistid = c.artistid and type in ( 'creditedsw' )", "StageName", "MemberGender" );
      $b = db_query_array( "select StageName, MemberGender from members a, song_to_group b, group_to_member c where songid = $v and a.id = c.memberid and b.groupid = c.groupid and type in ( 'creditedsw' )", "StageName", "MemberGender" );
      foreach( $a as $t=>$g )  echo( "$t - " . getMF( $g ) . "<br>" );
      foreach( $b as $t=>$g )  echo( "$t - " . getMF( $g ) . "<br>" );

      echo( "</td>" );
	  echo( "<td valign='top'>Producers:<br>" );
      $a = db_query_array( "select StageName, MemberGender from members a, song_to_producer b, producer_to_member c where songid = $v and a.id = c.memberid and b.producerid = c.producerid ", "StageName", "MemberGender" );
      foreach( $a as $t=>$g )  echo( "$t - " . getMF( $g ) . "<br>" );

      echo( "</td>" );
      echo( "</tr>" );
      $i++;
  }

 }

 if( $type == "artists" ) { 

 foreach( $vals as $v )
  {
      $v = explode( ":", $v );
      $row = array();
      if( $v[0] == "a" )
	  $row = db_query_first( "select * from artists where id = $v[1]" );
      else if( $v[0] == "g" )
	  $row = db_query_first( "select * from groups where id = $v[1]" );
      else if( $v[0] == "p" )
	  $row = db_query_first( "select * from producers where id = $v[1]" );
      echo( "<tr><td>{$i}.</td><td>$row[Name]</td>" );
      echo( "</tr>" );
      $i++;
  }

 }

 if( $type == "members" ) { 

 foreach( $vals as $v )
  {
      $row = db_query_first( "select * from members where id = $v" );
      echo( "<tr><td valign='top'>{$i}.</td><td valign='top'>$row[StageName]</td>" );
      echo( "<td valign='top'>$row[MemberGender]</td>" );
      echo( "<td valign='top'>Primary Artist For:<br>" );
      $a = db_query_array( "select CleanURL, QuarterEnteredTheTop10 as Dt from songs a, song_to_artist b, artist_to_member c where IsActive = 1 and memberid = $v and a.id = b.songid and b.artistid = c.artistid and type = 'primary' ", "CleanURL", "Dt" );
      foreach( $a as $t=>$g )  echo( "$t - $g<br>" );
      $a = db_query_array( "select CleanURL, QuarterEnteredTheTop10 as Dt from songs a, song_to_group b, group_to_member c where IsActive = 1 and memberid = $v and a.id = b.songid and b.groupid = c.groupid and type = 'primary' ", "CleanURL", "Dt" );
      foreach( $a as $t=>$g )  echo( "$t - $g<br>" );
      echo( "</td>" );
      echo( "<td valign='top'>Featured Artist For:<br>" );
      $a = db_query_array( "select CleanURL, QuarterEnteredTheTop10 as Dt from songs a, song_to_artist b, artist_to_member c where IsActive = 1 and memberid = $v and a.id = b.songid and b.artistid = c.artistid and type = 'featured' ", "CleanURL", "Dt" );
      foreach( $a as $t=>$g )  echo( "$t - $g<br>" );
      $a = db_query_array( "select CleanURL, QuarterEnteredTheTop10 as Dt from songs a, song_to_group b, group_to_member c where IsActive = 1 and memberid = $v and a.id = b.songid and b.groupid = c.groupid and type = 'featured' ", "CleanURL", "Dt" );
      foreach( $a as $t=>$g )  echo( "$t - $g<br>" );
      echo( "</td>" );
      echo( "<td valign='top'>Songwriter For:<br>" );
      $a = db_query_array( "select CleanURL, QuarterEnteredTheTop10 as Dt from songs a, song_to_artist b, artist_to_member c where IsActive = 1 and memberid = $v and a.id = b.songid and b.artistid = c.artistid and type = 'creditedsw' ", "CleanURL", "Dt" );
      foreach( $a as $t=>$g )  echo( "$t - $g<br>" );
      echo( "</td>" );
      echo( "<td valign='top'>Producer For:<br>" );
      $a = db_query_array( "select CleanURL, QuarterEnteredTheTop10 as Dt from songs a, song_to_producer b, producer_to_member c where IsActive = 1 and memberid = $v and a.id = b.songid and b.producerid = c.producerid ", "CleanURL", "Dt" );
      foreach( $a as $t=>$g )  echo( "$t - $g<br>" );
      echo( "</td>" );
      echo( "</tr>" );
      $i++;
  }

 }

 ?>



</form>

