<? 
//error_reporting( E_ALL );
include "connect.php";
include "../functions.php";
include "../trendfunctions.php";
 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

function incrementRow( $rownum, $colnum )
{
    global $sheet, $includelinks; 
    // if( $colnum )
    // 	{
	    if( $includelinks )
		echo( "</tr>" );
	    //	}

    if( $includelinks )
	echo( "<tr>" );
    $rownum++;
    return $rownum;
}


function writeCell( $rownum, $colnum, $val, $format = "", $href = "" )
{
    global $sheet, $includelinks; 
    
    if( $includelinks )
	{
	    echo( "<td>" );
	    if( $href )
		echo( "<a href='$href'>$val</a>" );
	    else
		echo( $val );
	    echo( "</td>" );
	    $colnum++;
	}
    else
	{
	    $sheet->write( $rownum, $colnum++, $val, $format );
	}
    return $colnum; 
}

if( $export )
{


    if( !$includelinks )
	{
	    require_once "Spreadsheet/Excel/Writer.php";
	    $xls = new Spreadsheet_Excel_Writer();
	    $filename = "GenderReport.xls";
	    $xls->send( $filename );
	    $format_bold =& $xls->addFormat();
	    $format_bold->setBold();
	    
	    $sheet =& $xls->addWorksheet("Gender Report");
	    $sheet->setColumn( 0, 0, 30 );
	    $sheet->setColumn( 1, 40, 12 );
	    writeCell( $rownum, $colnum++, "This report considers members of groups individually, therefore the number of artists, songwriters, and producers may not match the ITR data which considers all members of a group as one.", $format_bold );
	    $rownum++;
	}
    else
	{

	    file_put_contents( "/tmp/d", "" );
	    echo( "This report considers members of groups individually, therefore the number of artists, songwriters, and producers may not match the ITR data which considers all members of a group as one.

 <table border=1 cellpadding=2 cellspacing=0>" );
	}
    $doingyearlysearch = true;

    $allyearstorun = array();
    $numberones = array();
    $hiphop = array();
    $nothiphop = array();
    for( $i = 2013; $i <= date( "Y" ); $i++ )
	{
	    $allyearstorun[] = $i;
	}

    // calculate "all" songs for each type

    $tmpallsongs = getSongIdsWithinQuarter( false, 1, 2013, 4, date( "Y" ) );
    $tmpno1songs = getSongIdsWithinQuarter( false, 1, 2013, 4, date( "Y" ), 1);
    $genrefilter = 2;
    $tmphiphopsongs = getSongIdsWithinQuarter( false, 1, 2013, 4, date( "Y" ) );
    $genrefilter = -2;
    $tmpnothiphopsongs = getSongIdsWithinQuarter( false, 1, 2013, 4, date( "Y" ) );
    unset( $genrefilter );

    $allsongs  = getSongIdsWithinQuarter( false, 1, 2013, 4, date( "Y" ) );
    $tmphiphopsongs = db_query_array( "select id from songs where GenreID = 2", "id", "id" );
    $tmpnonhiphopsongs = db_query_array( "select id from songs where GenreID > 2", "id", "id" );
    $tmphiphopsongs = array_intersect( $allsongs, $tmphiphopsongs );
    $tmpnonhiphopsongs = array_intersect( $allsongs, $tmpnonhiphopsongs );

    //    file_put_contents( "/tmp/yoy", print_r( $allsongs, true ) );
    $search["dates"]["toyear"] = $search["dates"]["fromyear"];

    $allsongsbyyear = array();


    function formLink( $type, $array )
    {
	$str = "https://analytics.chartcipher.com/hsdmgdb/tempgenderlist.php?type=$type&";
	if( is_array( $array ) )
	    $str.= "vals=" . implode( ",", $array ). "&"; 
	else
	    $str.= "vals=" . str_replace( " ", '', $array ). "&"; 
	return $str;
    }


    foreach( array( "Top 10", "Hip Hop", "Non-Hip Hop" ) as $subtype )
	{
	    if( $subtype == "Hip Hop" )
		$genrefilter = 2;
	    else if( $subtype == "Non-Hip Hop" )
		$genrefilter = -2;
	    else
		$genrefilter = "";

	    foreach( array( "Songwriters", "Producers", "Artists" ) as $type )
		{
		    $rownum = incrementRow( $rownum, $colnum );
		    $colnum = 0;
		    
		    writeCell( $rownum, $colnum++, $subtype . ": " . $type, $format_bold, "" );

		    $rownum = incrementRow( $rownum, $colnum );
		    $colnum = 0;
		    $cols = array( "Year", "# of Songs", "# of " . $type, "# Female", "# Male", "# Not Set", "% Female", "% Male", "% Not Set" );
		    foreach( $cols as $c )
			{
			    $colnum = writeCell( $rownum, $colnum, $c );
			    if( $subtype == "Hip Hop" && $c == "# of Songs" )
				{
				    $colnum = writeCell( $rownum, $colnum, "# of Hip Hop Songs" );
				}
			    if( $subtype == "Non-Hip Hop" && $c == "# of Songs" )
				{
				    $colnum = writeCell( $rownum, $colnum, "# of Non-Hip Hop Songs" );
				}

			}
		    $rownum = incrementRow( $rownum, $colnum );
		    foreach( $allyearstorun as $yearnum )
			{
			    $colnum = 0;
			    $colnum = writeCell( $rownum, $colnum, $yearnum );
			    
			    $tname = substr( strtolower( $type ), 0, -1 );
			    $typestr = "1=1";
			    if( $tname == "artist" )
				{
				    $typestr = "type in ( 'primary', 'featured' )";
				}
			    if( $tname == "songwriter" )
				{
				    $typestr = "type in ( 'creditedsw' )";
				    $tname = "artist";
				}
			    
			    $allsongs  = getSongIdsWithinQuarter( false, 1, $yearnum, $yearnum==2019?4:4, $yearnum );

			    if( $subtype == "Top 10" )
				{
				    $allsongsbyyear[$yearnum] = $allsongs;
				}
			    else
				{
				    $colnum = writeCell( $rownum, $colnum, count( $allsongsbyyear[$yearnum] ), "", formLink( "songs", $allsongsbyyear[$yearnum] ) );
				}
			    
			    $colnum = writeCell( $rownum, $colnum, count( $allsongs ), "", formLink( "songs", $allsongs ) );
			    

			    $sql = "select b.memberid, MemberGender from song_to_{$tname} a, {$tname}_to_member b, members c where {$typestr}  and a.{$tname}id = b.{$tname}id and c.id = b.memberid and songid in ( " . implode( ", ", $allsongs ) . " )";
			    $producers = db_query_array( $sql, "memberid", "MemberGender" );
			    // $sql = "select c.FirstName, c.LastName, b.memberid, MemberGender from song_to_{$tname} a, {$tname}_to_member b, members c where {$typestr}  and a.{$tname}id = b.{$tname}id and c.id = b.memberid and songid in ( " . implode( ", ", $allsongs ) . " )";
			    // $producersbig = db_query_rows( $sql );
			    // if( $yearnum == 2020 && $type == "Artists" )
			    // 	{
			    // file_put_contents( "/tmp/query", "$yearnum: $sql;\n", FILE_APPEND  );
			    // file_put_contents( "/tmp/query", "$yearnum: " . (print_r( $producersbig, true ) ) . "\n", FILE_APPEND  );
			    // 	}			    

			    if( $type == "Artists" )
			    	{
			    	    $tname = "group";
			    	    $sql = "select b.memberid, MemberGender from song_to_{$tname} a, {$tname}_to_member b, members c where {$typestr}  and a.{$tname}id = b.{$tname}id and c.id = b.memberid and songid in ( " . implode( ", ", $allsongs ) . " )";
			    	    file_put_contents( "/tmp/query", "$sql;\n" , FILE_APPEND );
			    	    $producersgroup = db_query_array( $sql, "memberid", "MemberGender" );
			    	    foreach( $producersgroup as $pid=>$pgen )
			    		$producers[$pid] = $pgen;
			    	}
			    
			    $numfemale = 0;
			    $femalevals = array();
			    $nummale = 0;
			    $malevals = array();
			    $numnone = 0;
			    $nonevals = array();
			    foreach( $producers as $mid => $gender )
				{
				    if( $gender == "Female" ) $numfemale++;
				    if( $gender == "Female" ) $femalevals[] = $mid;
				    if( $gender == "Male" ) $nummale++;
				    if( $gender == "Male" ) $malevals[] = $mid;
				    if( !$gender ) $numnone++;
				    if( !$gender ) $nonevals[] = $mid;
				    
				}
			    
			    
			    $colnum = writeCell( $rownum, $colnum, count($producers) );
			    $femalepercent = round( 100 * $numfemale / count( $producers ) );
			    $malepercent = round( 100 * $nummale / count( $producers ) );
			    $nonepercent = 100 - $femalepercent - $malepercent;
			    
			    $colnum = writeCell( $rownum, $colnum, $numfemale, "", formLink( "members", $femalevals ) );
			    $colnum = writeCell( $rownum, $colnum, $nummale, "", formLink( "members", $malevals ) );
			    $colnum = writeCell( $rownum, $colnum, $numnone++, "", formLink( "members", $nonevals ) );

			    $colnum = writeCell( $rownum, $colnum, $femalepercent . "%" );
			    $colnum = writeCell( $rownum, $colnum, $malepercent . "%" );
			    $colnum = writeCell( $rownum, $colnum, $nonepercent . "%" );
			    
			    
			    $rownum = incrementRow( $rownum, $colnum );
			    
			}
		}
	    

	    // if( $subtype == "Top 10" ) 
	    // 	{ 
		    
		    $genders = array( "Female", "Male" );
		    foreach( $genders as $gender )
			{
			    
			    $rownum = incrementRow( $rownum, $colnum );
			    $colnum = 0;
			    
			    $colnum = writeCell( $rownum, $colnum, $subtype . ": " . $gender . " Primary Artists with a Featured Artist", $format_bold );
			    $rownum = incrementRow( $rownum, $colnum );
			    $colnum = 0;
			    $cols = array( "Year", "# of Songs with a Feat Artist and a $gender Primary Artist", "% of Songs with a Female Feat Artist", "% of Songs with a Male Feat Artist", "% of Songs with a Female and Male Feat Artist", "# Female", "# Male", "# Both"  );
			    foreach( $cols as $c )
				{
				    $colnum = writeCell( $rownum, $colnum, $c );
				}
			    $rownum = incrementRow( $rownum, $colnum );
			    foreach( $allyearstorun as $yearnum )
				{
				    $colnum = 0;
				    $colnum = writeCell( $rownum, $colnum, $yearnum  );
				    
				    // all songs
				    $allsongs  = getSongIdsWithinQuarter( false, 1, $yearnum, $yearnum==2019?4:4, $yearnum );
				    // now let's narrow this down to just by gender
				    
				    $genrestr = "";
				    if( $subtype == "Hip Hop" )
					$genrestr = " and GenreID = 2";

				    if( $subtype == "Non-Hip Hop" )
					$genrestr = " and GenreID > 2";

				    $allsongs = db_query_array( "select id from songs where PrimaryGender = '$gender' and id in ( " . implode( ", " , $allsongs ) . " ) $genrestr", "id", "id" );
				    
				    
				    if( count( $allsongs ) )
					$songwithfeatured = db_query_array( "select id from songs where id in ( " . implode( ", " , $allsongs ) . " ) and FeatGender > ''  $genrestr", "id", "id" );
				    else 
					$songwithfeatured = array();
				    
				    if( count( $songwithfeatured ) )
					{
					$sql = "select FeatGender, count(*) cnt, group_concat(' ', id ) as listofids from songs where id in ( " . implode( ", ", $songwithfeatured ) . " )  $genrestr group by FeatGender ";
					$results = db_query_rows( $sql, "FeatGender" );
					}
				    else
					{
					    $results = array();
					}
				    
				    $colnum = writeCell( $rownum, $colnum, count($songwithfeatured), "", formLink( "songs", $songwithfeatured ) );
				    
				    $femalepercent = round( 100 * $results["Female"]["cnt"] / count( $songwithfeatured ) );
				    $malepercent = round( 100 * $results["Male"]["cnt"] / count( $songwithfeatured ) );
				    $bothpercent = 100 - $femalepercent - $malepercent;
				    
				    $colnum = writeCell( $rownum, $colnum, $femalepercent . "%" );
				    $colnum = writeCell( $rownum, $colnum, $malepercent . "%" );
				    $colnum = writeCell( $rownum, $colnum, $bothpercent . "%" );
				    
				    $colnum = writeCell( $rownum, $colnum, $results["Female"]["cnt"], "", formLink( "songs", $results["Female"]["listofids"] ) );
				    $colnum = writeCell( $rownum, $colnum, $results["Male"]["cnt"], "", formLink( "songs", $results["Male"]["listofids"] ) );
				    $colnum = writeCell( $rownum, $colnum, $results["Both"]["cnt"], "", formLink( "songs", $results["Both"]["listofids"] ) );


				    
				    
				    $rownum = incrementRow( $rownum, $colnum );
				    
				}
			}
		    
		    //		
	 
	    $genrefilter = false;
	}





    $collabs = array();
    $collabs["% of Female writers working with primary Female artists"] = array( "Female", "writer", "Female", "artist" );
    $collabs["% of Female writers working with Female producers"] = array( "Female", "writer", "Female", "producer" );
    $collabs["% of Female primary artists working with Female producers"] = array( "Female", "artist", "Female", "producer" );
    $collabs["% of Male writers working with primary Female artists"] = array( "Male", "writer", "Female", "artist" );
    $collabs["% of Male writers working with Female producers"] = array( "Male", "writer", "Female", "producer" );
    $collabs["% of Male primary artists working with Female producers"] = array( "Male", "artist", "Female", "producer" );

    foreach( array( "Top 10", "Hip Hop", "Non-Hip Hop" ) as $subtype )
	{
	    if( $subtype == "Hip Hop" )
		$genrefilter = 2;
	    else if( $subtype == "Non-Hip Hop" )
		$genrefilter = -2;
	    else
		$genrefilter = "";



	    foreach( $collabs as $collabtype=>$params )
		{
		    $rownum = incrementRow( $rownum, $colnum );
		    $colnum = 0;
	    
		    $colnum = writeCell( $rownum, $colnum, "$subtype - $collabtype", $format_bold );
		    $rownum = incrementRow( $rownum, $colnum );
		    $colnum = 0;
		    $cols = array( "Year" );
		    
		    $persongender = $params[0];
		    $persontype = $params[1];
		    $typestr = "";
		    $shorttable = $persontype;
		    $extrasonggender = "";
		    $withextrasonggender = "";
		    if( $persontype == "artist" )
			{
			    $typestr = " and type = 'primary'";
			    $extrasonggender = "and PrimaryGender = '$persongender'";
			}
		    if( $persontype == "writer" )
			{
			    $typestr = " and type = 'creditedsw'";
			    $shorttable = "artist";
			}
		    
		    
		    $withpersongender = $params[2];
		    $withpersontype = $params[3];
		    $withtypestr = "";
		    $withshorttable = $withpersontype;
		    
		    if( $withpersontype == "artist" )
			{
			    $withtypestr = " and type = 'primary'";
			    $withextrasonggender = "and PrimaryGender = '$withpersongender'";
			}
		    if( $withpersontype == "writer" )
			{
			    $withtypestr = " and type = 'creditedsw'";
			    $withshorttable = "artist";
			}
		    
		    $cols[] = "# of $params[0] {$params[1]}s";  
		    $cols[] = "% working with {$params[2]} {$params[3]}s";  
		    $cols[] = "# working with {$params[2]} {$params[3]}s";  
		    foreach( $cols as $c )
			{
			    $colnum = writeCell( $rownum, $colnum, $c );
			}
		    $rownum = incrementRow( $rownum, $colnum );
		    foreach( $allyearstorun as $yearnum )
			{
			    $rownum = incrementRow( $rownum, $colnum );
			    $colnum = 0;
			    $colnum = writeCell( $rownum, $colnum, $yearnum );
			    
			    $songs = $allsongsbyyear[$yearnum];

			    if( $subtype == "Hip Hop" )
				$songs = array_intersect( $songs, $tmphiphopsongs );
			    else if( $subtype == "Non-Hip Hop" )
				$songs = array_intersect( $songs, $tmpnonhiphopsongs );


			    if( $includelinks )
				{
				    file_put_contents( "/tmp/d", "doing $yearnum, $subtype, $collabtype\n\n", FILE_APPEND );
				    file_put_contents( "/tmp/d", "select memberid from {$shorttable}_to_member a, members b, song_to_{$shorttable} c, songs d where d.id = songid and c.{$shorttable}id = a.{$shorttable}id and MemberGender = '$persongender' and a.memberid = b.id and songid in ( " . implode( ",", $songs ) . " ) $typestr $extrasonggender \n\n", FILE_APPEND );
				    if( $shorttable == "artist" )
					file_put_contents( "/tmp/d", "select memberid from group_to_member a, members b, song_to_group c, songs d where d.id = songid and c.groupid = a.groupid and MemberGender = '$persongender' and a.memberid = b.id and songid in ( " . implode( ",", $songs ) . " ) $typestr $extrasonggender \n\n", FILE_APPEND );
				    file_put_contents( "/tmp/d", implode( ", ", $songs ) . "\n\n", FILE_APPEND );
				}
			    
			    $peopletotalcount = array();
			    $allpeople = array();
			    foreach( $songs as $songid )
				{
				    $peopletocount = db_query_array( "select memberid from {$shorttable}_to_member a, members b, song_to_{$shorttable} c, songs d where d.id = songid and c.{$shorttable}id = a.{$shorttable}id and MemberGender = '$persongender' and a.memberid = b.id and songid = '$songid' $typestr $extrasonggender ", "memberid", "memberid" );
				    if( $shorttable == "artist" )
					{
					    $grouppeopletocount = db_query_array( "select memberid from group_to_member a, members b, song_to_group c, songs d where d.id = songid and c.groupid = a.groupid and MemberGender = '$persongender' and a.memberid = b.id and songid = '$songid' $typestr $extrasonggender ", "memberid", "memberid" );
					    foreach( $grouppeopletocount as $mid )
						$peopletocount[$mid] = $mid;

					}

				    $otherpeoplecount = db_query_array( "select memberid from {$withshorttable}_to_member a, members b, song_to_{$withshorttable} c, songs d where  c.{$withshorttable}id = a.{$withshorttable}id and MemberGender = '$withpersongender' and a.memberid = b.id and songid = '$songid' $withtypestr $withextrasonggender ", "memberid", "memberid" );
				    if( $withshorttable == "artist" )
					{
					    $withgrouppeopletocount = db_query_array( "select memberid from group_to_member a, members b, song_to_group c, songs d where  c.groupid = a.groupid and MemberGender = '$withpersongender' and a.memberid = b.id and songid = '$songid' $withtypestr $withextrasonggender ", "memberid", "memberid" );
					    foreach( $withgrouppeopletocount as $mid )
						$otherpeoplecount[$mid] = $mid;
					    
					}

				    foreach( $peopletocount as $personid )
					{
					    $allpeople[$personid] = 1;
					    foreach( $otherpeoplecount as $otherpersonid )
						{
						    // ok, we have a match on both sides and it's not the same person
						    if( $otherpersonid != $personid )
							$peopletotalcount[$personid] = 1;
						}
					}
				    
				}
			    $colnum = writeCell( $rownum, $colnum, count( $allpeople ), "", formLink( "members", array_keys($allpeople) ) );
			    if( $allpeople )
				$percent = round( 100 * count( $peopletotalcount ) / count($allpeople) ); 
			    else
				$percent = "0";
			    $colnum = writeCell( $rownum, $colnum, $percent . "%" );
			    $colnum = writeCell( $rownum, $colnum, count($peopletotalcount), "", formLink( "members", array_keys( $peopletotalcount ) ) );
			}
		    
		    $rownum = incrementRow( $rownum, $colnum );
		}

	}

    $collabs = array();
    $collabs["% of songs with a Female credited songwriter and a credited Female producer"] = array( "Female", "writer", "Female", "producer", 0 );
    $collabs["% of songs with a Female primary artist and a credited Female songwriter"] = array( "Female", "artist", "Female", "writer", 0 );
    $collabs["% of songs with a Female primary artist and a Female producer"] = array( "Female", "artist", "Female", "producer", 0 );
    $collabs["% and # of songs that have a female primary artist that is also one of the songwriters"] = array( "Female", "artist", "Female", "writer", 1 );
    $collabs["% and # of songs that have a female primary artist that is also one of the producers"] = array( "Female", "artist", "Female", "producer", 1 );
    $collabs["% and # of songs that have a female primary artist that is also one of the songwriters and one of the producers"] = array( "Female", "artist", "Female", "writer,producer", 1 );
    

    $subtype = "Top 10";

    foreach( $collabs as $collabtype=>$params )
	{
	    $rownum = incrementRow( $rownum, $colnum );
	    $colnum = 0;
	    
	    $colnum = writeCell( $rownum, $colnum, "$subtype - $collabtype", $format_bold );
	    $rownum = incrementRow( $rownum, $colnum );
	    $colnum = 0;
	    $cols = array( "Year" );
	    
	    $issame = $params[4];
	    $persongender = $params[0];
	    $persontype = $params[1];
	    $typestr = "";
	    $shorttable = $persontype;
	    $extrasonggender = "";
	    $withextrasonggender = "";
	    if( $persontype == "artist" )
		{
		    $typestr = " and type = 'primary'";
		    $extrasonggender = "and PrimaryGender = '$persongender'";
		}
	    if( $persontype == "writer" )
		{
		    $typestr = " and type = 'creditedsw'";
		    $shorttable = "artist";
		}
	    
	    
	    $withpersongender = $params[2];
	    $withpersontype = $params[3];
	    $withtypestr = "";
	    $withshorttable = $withpersontype;
	    $third = "";
	    
	    if( $withpersontype == "artist" )
		{
		    $withtypestr = " and type = 'primary'";
		    $withextrasonggender = "and PrimaryGender = '$withpersongender'";
		}
	    if( $withpersontype == "writer" )
		{
		    $withtypestr = " and type = 'creditedsw'";
		    $withshorttable = "artist";
		}
	    if( $withpersontype == "writer,producer" )
		{
		    $withtypestr = " and type = 'creditedsw'";
		    $withshorttable = "artist";

		    $third = "producer"; 

		}
	    
	    $cols[] = "Total # of songs";  
	    $cols[] = "% of songs";  
	    $cols[] = "# of songs";  
	    foreach( $cols as $c )
		{
		    $colnum = writeCell( $rownum, $colnum, $c );
		}
	    $rownum = incrementRow( $rownum, $colnum );
	    foreach( $allyearstorun as $yearnum )
		{
		    $rownum = incrementRow( $rownum, $colnum );
		    $colnum = 0;
		    $colnum = writeCell( $rownum, $colnum, $yearnum );
		    
		    $songs = $allsongsbyyear[$yearnum];
		    
		    
		    if( $includelinks )
			{
			    file_put_contents( "/tmp/d", "doing $yearnum, $subtype, $collabtype\n\n", FILE_APPEND );
			    file_put_contents( "/tmp/d", "select memberid from {$shorttable}_to_member a, members b, song_to_{$shorttable} c, songs d where d.id = songid and c.{$shorttable}id = a.{$shorttable}id and MemberGender = '$persongender' and a.memberid = b.id and songid in ( " . implode( ",", $songs ) . " ) $typestr $extrasonggender \n\n", FILE_APPEND );
			    if( $shorttable == "artist" )
				file_put_contents( "/tmp/d", "select memberid from group_to_member a, members b, song_to_group c, songs d where d.id = songid and c.groupid = a.groupid and MemberGender = '$persongender' and a.memberid = b.id and songid in ( " . implode( ",", $songs ) . " ) $typestr $extrasonggender \n\n", FILE_APPEND );
			    file_put_contents( "/tmp/d", implode( ", ", $songs ) . "\n\n", FILE_APPEND );
			}
		    
		    $songtotalcount = array();
		    $allpeople = array();
		    foreach( $songs as $songid )
			{
			    $peopletocount = db_query_array( "select memberid from {$shorttable}_to_member a, members b, song_to_{$shorttable} c, songs d where d.id = songid and c.{$shorttable}id = a.{$shorttable}id and MemberGender = '$persongender' and a.memberid = b.id and songid = '$songid' $typestr $extrasonggender ", "memberid", "memberid" );
			    if( $shorttable == "artist" )
				{
				    $grouppeopletocount = db_query_array( "select memberid from group_to_member a, members b, song_to_group c, songs d where d.id = songid and c.groupid = a.groupid and MemberGender = '$persongender' and a.memberid = b.id and songid = '$songid' $typestr $extrasonggender ", "memberid", "memberid" );
				    foreach( $grouppeopletocount as $mid )
					$peopletocount[$mid] = $mid;
				    
				}
			    
			    $otherpeoplecount = db_query_array( "select memberid from {$withshorttable}_to_member a, members b, song_to_{$withshorttable} c, songs d where  c.{$withshorttable}id = a.{$withshorttable}id and MemberGender = '$withpersongender' and a.memberid = b.id and songid = '$songid' $withtypestr $withextrasonggender ", "memberid", "memberid" );
			    if( $withshorttable == "artist" )
				{
				    $withgrouppeopletocount = db_query_array( "select memberid from group_to_member a, members b, song_to_group c, songs d where  c.groupid = a.groupid and MemberGender = '$withpersongender' and a.memberid = b.id and songid = '$songid' $withtypestr $withextrasonggender ", "memberid", "memberid" );
				    foreach( $withgrouppeopletocount as $mid )
					$otherpeoplecount[$mid] = $mid;
				    
				}
			    
			    $thirdcount = array();
			    if( $third )
				{
				    $thirdcount = db_query_array( "select memberid from {$third}_to_member a, members b, song_to_{$third} c, songs d where  c.{$third}id = a.{$third}id and MemberGender = '$withpersongender' and a.memberid = b.id and songid = '$songid' ", "memberid", "memberid" );
				}

			    foreach( $peopletocount as $personid )
				{
				    $allpeople[$personid] = 1;
				    foreach( $otherpeoplecount as $otherpersonid )
					{
					    // ok, we have a match on both sides and it's not the same person

					    if( $issame )
						{

						    if( $third )
							{
							    if( $otherpersonid == $personid && $thirdcount[$personid] )
								$songtotalcount[$songid] = 1;
							    
							}
						    else
							{
							    if( $otherpersonid == $personid )
								$songtotalcount[$songid] = 1;
							}
						}
					    else
						{
						    if( $otherpersonid != $personid )
							$songtotalcount[$songid] = 1;
						}
					}
				}
			    
			}
		    $colnum = writeCell( $rownum, $colnum, count( $songs ), "", formLink( "songs", array_keys($songs) ) );
		    if( count( $songtotalcount ) )
			$percent = round( 100 * count( $songtotalcount ) / count($songs) ); 
		    else
			$percent = "0";
		    $colnum = writeCell( $rownum, $colnum, $percent . "%" );
		    $colnum = writeCell( $rownum, $colnum, count($songtotalcount), "", formLink( "songs", array_keys( $songtotalcount ) ) );
		}
	    
	    $rownum = incrementRow( $rownum, $colnum );

	}
    


    if( !$includelinks )
	{
	    $xls->close();
	}
	    exit;
}

include "nav.php";
?>
<h3>Gender Report</h3>
<form method='post'>
<input type='checkbox' name='includelinks' value='1'> Include Links<br>
<input type='submit' name='export' value='Export'>
</form>

