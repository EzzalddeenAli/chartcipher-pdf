<? 
ini_set('auto_detect_line_endings',TRUE);
include "connect.php"; ?>
<? 

    if( $gotechniques )
	{
	    $sections = db_query_array( "select Name, id from songsections", "Name", "id" );
	    $firstforsong = array();
	    if (($handle = fopen($_FILES["uploadtechniques"]["tmp_name"], "r")) !== FALSE) {
		$started = false;
		$count = 0;
		$firstsectioncolumn = 0;
		while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
		    if( $data[0] && !$started )
			{
			    $headerrow = array();
			    foreach( $data as $did=>$dval )
				{
				    $headerrow[trim( $dval )] = $did;
				    if( trim( $dval ) == "Section of the Song Where it Appears" && !$firstsectioncolumn )
					{
					$firstsectioncolumn = $did;
					break;
					}
				}
			    $started = true;
			    continue;
			}
		    //		    print_r( $data );
		    file_put_contents( "/tmp/hr", print_r( $headerrow, true ) );
		    file_put_contents( "/tmp/hr", print_r( $data, true ), FILE_APPEND );
		    // echo( $firstsectioncolumn );exit;
		    //		    exit;
		    $songid = $data[$headerrow["Song ID"]];
		    //		    echo( "<Br>songid: " . $songid );
		    if( $songid )
			{
			    if( $delexistingtechniques && !$firstforsong[$songid])
				{
				    db_query("delete from song_to_technique_to_songsection where sttid in( select id from song_to_technique where songid = $songid ) " );
				    db_query("delete from song_to_technique where songid = $songid " );
				}
			    
			    $techniqueid = db_query_first_cell( "select id from techniques where Name = '" . escMe( $data[$headerrow["Technique"]] ) . "'" );
			    if( !$techniqueid )
				{
				    echo( "<font color='red'>No Technique matching " . $data[$headerrow["Technique"]] . "</font><br>" );
				    continue;
				}
			    $sttid = db_query_insert_id( "insert into song_to_technique ( songid, techniqueid ) values ( $songid, '$techniqueid' )" );
			    $extvalues = array();
			    $extvalues["description"] = $data[$headerrow["Description"]];
			    $extvalues["url"] = $data[$headerrow["Video URL to Embed"]];
			    $extvalues["imageurl"] = $data[$headerrow["Image URL to Embed"]];
			    $tcatid = db_query_first_cell( "select id from techniquecategories where Name = '" . escMe( $data[$headerrow["Technique Category"]] ) . "'" );
			    //			    echo( "select id from techniquecategories where Name = '" . escMe( $data[$headerrow["Technique Category"]] ) . "'<br>" );
			    if( $data[$headerrow["Technique Category"]] && !$tcatid )
				{
				    if( isRachel() )
					echo( "select id from techniquecategories where Name = '" . escMe( $data[$headerrow["Technique Category"]] ) . "'<br>" );
				    echo( "<font color='red'>No Technique Category matching " . $data[$headerrow["Technique Category"]] . "</font> <a href='edittechnique.php?id=$techniqueid' target=_blank>view</a><br>" );
				}
			    $extvalues["techniquecategoryid"] = $tcatid;

			    $tsubcatid = db_query_first_cell( "select id from techniquesubcategories where Name = '" . escMe( $data[$headerrow["Technique Sub-Category (If applicable)"]] ) . "' and techniquecategoryid = '$tcatid'" );
			    //			    echo( "select id from techniquesubcategories where Name = '" . escMe( $data[$headerrow["Technique Sub-Category (If applicable)"]] ) . "' and techniquecategoryid = '$tcatid'<br>" );
			    if( $data[$headerrow["Technique Sub-Category (If applicable)"]] && !$tsubcatid )
				{
				    if( isRachel() )
					echo( "select id from techniquesubcategories where Name = '" . escMe( $data[$headerrow["Technique Sub-Category (If applicable)"]] ) . "' and techniquecategoryid = '$tcatid'<br>" );
				    echo( "<font color='red'>No Technique Sub-Category matching " . $data[$headerrow["Technique Sub-Category (If applicable)"]] . "</font> <a href='edittechniquesub.php?id=$tcatid' target=_blank>view</a><br>" );
				}
			    if( $tsubcatid )
				$extvalues["techniquesubcategoryid"] = $tsubcatid;
			    
			    $tsubsubcatid = db_query_first_cell( "select id from techniquesubsubcategories where Name = '" . escMe( $data[$headerrow["Technique Sub-Sub-Category (If applicable)"]] ) . "' and techniquesubcategoryid = '$tsubcatid'" );
			    if( $data[$headerrow["Technique Sub-Sub-Category (If applicable)"]] && !$tsubsubcatid )
				{
				    if( isRachel() )
					echo( "select id from techniquesubsubcategories where Name = '" . escMe( $data[$headerrow["Technique Sub-Sub-Category (If applicable)"]] ) . "' and techniquesubcategoryid = '$tsubcatid'<br>" );
				    echo( "<font color='red'>No Technique Sub-Sub-Category matching " . $data[$headerrow["Technique Sub-Sub-Category (If applicable)"]] . "</font> <a href='edittechniquesubsub.php?id=$tsubcatid' target=_blank>view</a><br>" );
				}
			    if( $tsubsubcatid )
				$extvalues["techniquesubsubcategoryid"] = $tsubsubcatid;
			    
			    foreach( $extvalues as $key=>$value )
				{
				    db_query( "update song_to_technique set $key = '" . escMe( $value ) . "' where id = $sttid" );
				}
			    
			    
			    $firstforsong[$songid] = 1;
			    
			    $colstart = $firstsectioncolumn;
			    $starting = $data[$colstart];
			    while( $starting )
				{
				    $section = trim($data[$colstart]);
				    $sectionid = $sections[$section];
				    if( !$sectionid )
					{
					    echo( "<font color='red'>no match for section: $section</font><br>" );
					    $colstart += 3;
					    $starting = $data[$colstart];
					    continue;
					}
				    $starttimecode = "00:0".$data[$colstart+1];
				    $endtimecode = "00:0".$data[$colstart+2];
				    db_query( "insert into song_to_technique_to_songsection ( sttid, songsectionid, starttime, endtime ) values ( '$sttid', '$sectionid', '$starttimecode', '$endtimecode' )" );
				    $colstart += 3;
				    $starting = $data[$colstart];
				}
			}
		}

	    }
	    $count = count( $firstforsong );
	    $err = "<font color='red'>$count Songs Updated.</font>";
	}
if( $gosamples )
  {
    $firstforsong = array();
    if (($handle = fopen($_FILES["uploadsamples"]["tmp_name"], "r")) !== FALSE) {
        $started = false;
        $count = 0;
        while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
            if( strtolower( $data[0] ) == "song title" )
            {
                $started = true;
                continue; 
            }
            else
                if( !$started )
                    continue;

            if( !$data[0] ) continue;
            $songnameid = getIdByName( "songnames", $data[0] );
            $songid = getIdByName( "songs", $songnameid, "songnameid" );
//            echo( "($data[0]) song id is $songid<br>" );
            if( $songid )
            {
//                print_r( $data );
//                | ContainsSampled | set('Contains Sampled Music','Contains Sampled Vocals','Contains Sampled Music and Vocals') | YES  |     | NULL    |       |

                $sampled = array();
                if( $data[2] )
                    $sampled[] = "Contains Sampled Music";
                if( $data[3] )
                    $sampled[] = "Contains Sampled Vocals";
                $sampled = implode( ",", $sampled );
                
                db_query( "update songs set ContainsSampled = '$sampled', SampledLink = '" . escMe( $data[1] ) . "' where id = $songid" );
                
                for( $i = 4; $i < 30; $i+=3 )
                {
                    if( $data[$i] )
                    {
                        $aid = getIdByName( "artists", $data[$i] );
                        if( !$aid )
                            $aid = getIdByName( "artists", $data[$i], "FullBirthName" );

                        if( !$aid )
                        {
                            $aid = getOrCreate( "artists", $data[$i] );
                        }
                        
                        if( $aid )
                        {
                            db_query("delete from song_to_artist where songid = '$songid' and artistid = '$aid' and type = 'sample' " );
                            addRelatedToSong("artist", $aid, $songid, "sample" );
                        }
                        else
                        {
                            echo( "No artist match for '". $data[$i]. "'<br>" );
                        }
                    }
                    if( $data[$i+1] )
                    {
                        $aid = getOrCreate( "groups", $data[$i+1] );
                        
                        db_query("delete from song_to_group where songid = '$songid' and groupid = '$aid' and type = 'sample' " );
                        addRelatedToSong("group", $aid, $songid, "sample" );
                    }
                    if( $data[$i+2] )
                    {
                        $st = $data[$i+2];
                        $aid = getOrCreate( "samplesongs", $st );
                        db_query("delete from song_to_samplesong where songid = '$songid' and samplesongid = '$aid' " );
                        addRelatedToSong("samplesong", $aid, $songid );
                    }
                }
                $count++;
                
            }
            else
            {
                echo( "no  match for $data[0] <br>" );
            }
        }
    }
    $err = "<font color='red'>$count Songs Updated.</font>";
  }

if( $gosongartists )
  {
    $firstforsong = array();
    if (($handle = fopen($_FILES["uploadsongartists"]["tmp_name"], "r")) !== FALSE) {
	$started = false;
    $count = 0;
	while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
	  if( strtolower( $data[1] ) == "first name" )
	    {
	      $started = true;
	    }
	  else
	    if( !$started )
	      continue;

	  $songnameid = getIdByName( "songnames", $data[0] );
	  $songid = getIdByName( "songs", $songnameid, "songnameid" );

	  if( $songid )
      {
//          echo( "For $data[0], found $songid<br>" );
          for( $i = 1; $i < 101; $i+=2 )
          {
              if( $data[$i] )
              {
                  $aid = getIdByName( "artists", $data[$i], "FirstName", "LastName", $data[$i+1] );
                  if( $aid )
                  {
                      db_query("delete from song_to_artist where songid = '$songid' and artistid = '$aid' and type = '$uploadtype' " );
                      addRelatedToSong("artist", $aid, $songid, $uploadtype );
                          // recalculate this
                      $songwriters = db_query_first_cell( "select count(*) from song_to_artist where type = 'creditedsw' and songid = '$songid'" );
                      db_query( "update songs set SongwriterCount = $songwriters where id = $songid" );
                  }
                  else
                  {
                      echo( "No match for '". $data[$i]. "', '" . $data[$i+1] . "'<br>" );
                  }
              }
          }
          $count++;
                
	    }
	  else
	    {
	      echo( "no  match for $data[0] <br>" );
	    }
	}
      }
    $err = "<font color='red'>$count Artists - $uploadtype Updated.</font>";
  }
    db_query( "update artists set FullBirthName = concat( FirstName, ' ', LastName ) where MiddleName = '' or MiddleName is NULL" );
    db_query( "update artists set FullBirthName = concat( FirstName, ' ', MiddleName, ' ', LastName ) where MiddleName > '' " );

if( $golinks )
  {
    $firstforsong = array();
      move_uploaded_file( $_FILES["uploadfilelinks"]["tmp_name"], "uploadlink.csv" );
      if (($handle = fopen("uploadlink.csv", "r")) !== FALSE) {
	$started = false;
    $count = 0;
	while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
	  if( strtolower( $data[0] ) == "song title" )
	    {
	      $started = true;
	    }
	  else
	    if( !$started )
	      continue;

	  $songnameid = getIdByName( "songnames", $data[0] );
	  $songid = getIdByName( "songs", $songnameid, "songnameid" );

	  if( $songid )
      {
//          echo( "For $data[0], found $songid<br>" );
	      if( $data[1] )
		{
		  db_query( "update songs set SongLyricsLink = '" . escMe( $data[1] ) . "' where id = $songid" ); 
		}
	      if( $data[2] )
		{
		  db_query( "update songs set OfficialVideo = '" . escMe( $data[2] ) . "' where id = $songid" ); 
		}
	      if( $data[3] )
		{
		  db_query( "update songs set iTunes = '" . escMe( $data[3] ) . "' where id = $songid" ); 
		}
	      if( $data[4] )
		{
		  db_query( "update songs set Spotify = '" . escMe( $data[4] ) . "' where id = $songid" ); 
		}
	      if( !$data[5] && $data[2] )
          {
              $you = $data[2]; 
              $you = str_replace( "https://youtu.be", "https://youtube.com/embed" , $you );
              $you = str_replace( "https://www.youtube.com/watch?v=", "https://youtube.com/embed/" , $you );
              db_query( "update songs set OfficialVideoEmbed = '" . escMe( $you ) . "' where id = $songid" ); 
          }
                $count++;
                
	    }
	  else
	    {
	      echo( "no  match for $data[0] <br>" );
	    }
	}
      }
      $err = "<font color='red'>$count Song Links Updated.</font>";
  }

if( $goartists )
  {
    $firstforsong = array();
      move_uploaded_file( $_FILES["uploadartists"]["tmp_name"], "uploadartists.csv" );
      if (($handle = fopen("uploadartists.csv", "r")) !== FALSE) {
	$started = false;
    $count = 0;
    $cols = array();
    $cols[0] = "FirstName";
    $cols[1] = "MiddleName";
    $cols[2] = "LastName";
    $cols[3] = "StageName";
    $cols[4] = "YearBorn";
    $cols[5] = "City";
    $cols[6] = "WhereBorn";
    $cols[7] = "Wikipedia";
    $cols[8] = "ArtistURL";
    

	while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
	  if( strtolower( $data[0] ) == "first name" )
	    {
	      $started = true;
	    }
	  else
	    if( !$started )
	      continue;

      $aname = $data[3];
      if( !$data[3] )
          if( $data[1] ) 
              $aname = $data[0] . " " . $data[1] . " " . $data[2];
          else
              $aname = $data[0] . " " . $data[2];

	  $artistid = getOrCreate( "artists", $aname );

	  if( $artistid )
      {
          for( $i = 0; $i < 10; $i++ )
          {
              if( $i == 3 ) continue;
              if( !$data[$i] ) continue;
              $colname = $cols[$i];
              $you = $data[$i];
              echo( "update artists set $colname = '" . escMe( $you ) . "' where id = $artistid<Br>" ); 
              db_query( "update artists set $colname = '" . escMe( $you ) . "' where id = $artistid" ); 
          }
          $count++;
	    }
	  else
	    {
	      echo( "no  match for $aname <br>" );
	    }
	}
      }
      db_query( "update artists set FullBirthName = concat( FirstName, ' ', LastName ) where MiddleName = '' or MiddleName is NULL" );
      db_query( "update artists set FullBirthName = concat( FirstName, ' ', MiddleName, ' ', LastName ) where MiddleName > '' " );
      $err = "<font color='red'>$count Artists Updated.</font>";
  }

if( $gocharts )
  {
    $firstforsong = array();
      move_uploaded_file( $_FILES["uploadfilechart"]["tmp_name"], "uploadcharts.csv" );
      if (($handle = fopen("uploadcharts.csv", "r")) !== FALSE) {
	$started = false; 
	$tworowsago = array();
	$lastrow = array();
	$rownum = -1;
	$numdates = 0;
	while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
	  $rownum++;
	  //      echo( "for $rownum, first col is: {$data[0]}<br>" );
	  if( strtolower( $data[0] ) == "song" || strtolower( $data[0] ) == "song name" )
	    {
	      $started = true;
	      continue;
	    }
	  else
	    if( !$started )
	      continue;
	  $songnameid = getIdByName( "songnames", trim( $data[0] ) );
	  $songid = getIdByName( "songs", $songnameid, "songnameid" );

	  if( $songid )
	    {
	      if( $delexistingcharts && !$firstforsong[$songid])
		{
		  db_query("delete from song_to_weekdate where songid = $songid " );
		}

	      $firstforsong[$songid] = 1;
	      
	      $s = strtotime( $data[1] );
	      if( $s > strtotime(" next saturday" ) )
		{
		  $s = strtotime( $data[1] . "-" . (date( "Y") - 1  ) );
		}
	      $s = date( "m/d/y", $s );
	      $cid = getIdByName( "weekdates", $s );
	      if( !$cid )
		{
		  echo( "No match for $data[1]: $s<br>" );
		}
	      else
		{
		  db_query("delete from song_to_weekdate where songid = $songid and weekdateid = $cid" );
		  //		  echo( "adding $s to $data[0] in position $data[2]<Br>" );
		  addRelatedToSong( "weekdate", $cid, $songid );
		  db_query("update song_to_weekdate set type = 'position{$data[2]}' where songid = $songid and weekdateid = $cid" );
          $peak = db_query_first_cell( "select type from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
          $peak = str_replace( "position", "", $peak );
          db_query( "update songs set PeakPosition = '$peak' where id = $songid" );

		  $numdates++;
		}
	    }
	  else
	    {
	      echo( "no song matching $data[0]<Br>" );
	    }
	}
      }
      foreach( $firstforsong as $songid=>$val )
	{
	  include "autocalc.php";
	}
      
      $err = "<font color='red'>$numdates dates added.</font>";
  }

if( $go )
{
  // if( $delexisting )
  //   {
  //     db_query( "delete from  artists                 " );
  //     db_query( "delete from  groups                 " );
  //     db_query( "delete from  song_to_artist                 " );
  //     db_query( "delete from  song_to_chorusstructure        " );
  //     db_query( "delete from  song_to_chorustype             " );
  //     db_query( "delete from  song_to_group                  " );
  //     db_query( "delete from  song_to_instrument             " );
  //     db_query( "delete from  song_to_introtype              " );
  //     db_query( "delete from  song_to_lyricaltheme           " );
  //     db_query( "delete from  song_to_placement              " );
  //     db_query( "delete from  song_to_primaryinstrumentation " );
  //     db_query( "delete from  song_to_producer               " );
  //     db_query( "delete from  song_to_retroinfluence         " );
  //     db_query( "delete from  song_to_songsection            " );
  //     db_query( "delete from  song_to_songsectioncount       " );
  //     db_query( "delete from  song_to_songwriter             " );
  //     db_query( "delete from  song_to_subgenre               " );
  //     db_query( "delete from  song_to_vocalexample           " );
  //     db_query( "delete from  song_to_weekdate               " );
  //     db_query( "delete from  placement_to_vocalexample   " );
  //     db_query( "delete from  songs  " );
  //   }
  $countuploaded = 0;
  move_uploaded_file( $_FILES["uploadfile"]["tmp_name"], "upload.csv" );
  if (($handle = fopen("upload.csv", "r")) !== FALSE) {
    $started = false; 
    $tworowsago = array();
    $lastrow = array();
    $rownum = -1;
    while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
        foreach( $data as $did=>$dval )
        {
            $data[$did] = str_replace( "Õ", "'", $dval );
        }
        $rownum++;
            //      echo( "for $rownum, first col is: {$data[0]}<br>" );
        if( strtolower( $data[0] ) == "song name" )
        {
            $started = true; 
            $headerrow = $data;
            $cols = array_flip( $data );
            continue;
        }
        if( !$started )
        {
            $tworowsago = $lastrow;
            $lastrow = $data;
            continue;
        }
        
        $toupdate = array();
        $songname = $data[$cols["Song Name"]];
        if( !$songname )
            continue;
        $artist = $data[$cols["Artist/Band"]];
        $artistband = $artist;
        $songnameid = getOrCreate( "songnames", $songname );
        $songid = getIdByName( "songs", $songnameid, "songnameid", "ArtistBand", $artist );
        if( !$songid )
        {
            echo( "$rownum:  ($songname) insert into songs ( songnameid, ArtistBand ) values ( '$songnameid', '". escMe( $artist ). "' )<br>" );
            $songid = db_query_insert_id( "insert into songs ( songnameid, ArtistBand ) values ( '$songnameid', '". escMe( $artist ). "' )" );
        }
        else
        {
            echo( "found song: $songid<br>" );
        }
//        continue;
        $label = getOrCreate( "labels", $data[$cols["Label"]] );
//        $toupdate["LabelID"] = $label;
        if( $label )
        {
            addRelatedToSong( "label", $label, $songid );
        }
        
            // primary performing artist
        clearRelated( "artist", $songid, "primary" );
        foreach( $headerrow as $columnnumber=>$title )
        {
            if( $title == "Primary Performing Artist" && $data[$columnnumber])
            {
                $aid = getOrCreate( "artists", $data[$columnnumber] );
                addRelatedToSong( "artist", $aid, $songid, "primary" );
            }
        }
        
        
            // primary performing group
        clearRelated( "group", $songid, "primary" );
        foreach( $headerrow as $columnnumber=>$title )
        {
            if( $title == "Primary Performing Group" && $data[$columnnumber])
            {
                $aid = getOrCreate( "groups", $data[$columnnumber] );
                addRelatedToSong( "group", $aid, $songid, "primary" );
            }
        }


        
      // Featured Performing Artist
      clearRelated( "artist", $songid, "featured" );
      addAllRelated( $songid, $headerrow, $data, "Featured Performing Artist", "artist", "featured" );

      // Featured Performing Group
      clearRelated( "group", $songid, "featured" );
      addAllRelated( $songid, $headerrow, $data, "Featured Performing Group", "group", "featured" );

      // sample artist
      clearRelated( "artist", $songid, "sample" );
      addAllRelated( $songid, $headerrow, $data, "Sample Artist", "artist", "sample" );

      // sample group
      clearRelated( "group", $songid, "sample" );
      addAllRelated( $songid, $headerrow, $data, "Sample Group", "group", "sample" );


      /* for( $i = 1; $i <= 10; $i ++ ) */
      /* 	{ */
      /* 	  $val = $data[$cols["#{$i}"]]; */
      /* 	  $val = explode( ",", $val ); */
      /* 	  foreach( $val as $v ) */
      /* 	    { */
      /* 	      $s = trim( $v ); */
      /* 	      $s = strtotime( $s ); */
      /* 	      if( $s > time() ) */
      /* 		{ */
      /* 		  $s = strtotime( $data[1] . "-" . (date( "Y") - 1  ) ); */
      /* 		} */
      /* 	      $s = date( "m/d/y", $s ); */
      /* 	      $cid = getIdByName( "weekdates", $s ); */
      /* 	      db_query("delete from song_to_weekdate where songid = $songid and weekdateid = '$cid'" ); */
      /* 	      addRelatedToSong( "weekdate", $cid, $songid ); */
      /* 	      db_query("update song_to_weekdate set type = 'position{$i}' where songid = $songid and weekdateid = '$cid'" ); */

      /* 	    } */
      /* 	} */

      $imprint = getOrCreate( "imprints", $data[$cols["Imprint"]] );
      $toupdate["Imprint"] = $imprint;

      // credited songwriter
      clearRelated( "artist", $songid, "creditedsw" );
      addAllRelated( $songid, $headerrow, $data, "Credited Songwriter", "artist", "creditedsw" );

      // credited producer
      clearRelated( "artist", $songid, "creditedp" );
      addAllRelated( $songid, $headerrow, $data, "Credited Producer", "artist", "creditedp" );

      $writingproduction = getOrCreate( "producers", $data[$cols["Writing/Production Team"]] );
      $toupdate["WritingProduction"] = $writingproduction;


      $primarygenre = getOrCreate( "genres", array_shift( getImportValuesFromGroup( "PRIMARY GENRE" ) ) );
      $toupdate["GenreID"] = $primarygenre;
      $subgenres = getImportValuesFromGroup( "SUB-GENRES" );
      clearRelated( "subgenre", $songid );
      foreach( $subgenres as $g )
	{
	  $gid = getOrCreate( "subgenres", $g );
	  addRelatedToSong( "subgenre", $gid, $songid );
	}

      $fusion = array_shift( getImportValuesFromGroup( "GENRE FUSION TYPE" ) );
      $toupdate["GenreFusionType"] = $fusion; 

      $eva = array_shift( getImportValuesFromGroup( "ELECTRIC VS. ACOUSTIC" ) );
      $toupdate["ElectricVsAcoustic"] = str_replace( "Electric", "Electronic", $eva );  


      $instrumentations = getImportValuesFromGroup( "PRIMARY INSTRUMENTATION WITHIN THE MIX" );
      clearRelated( "primaryinstrumentation", $songid );
      foreach( $instrumentations as $g )
	{
	  $gid = getOrCreate( "primaryinstrumentations", $g );
	  addRelatedToSong( "primaryinstrumentation", $gid, $songid );
	}

      $themes = getImportValuesFromGroup( "LYRICAL THEMES" );
      clearRelated( "lyricaltheme", $songid );
      foreach( $themes as $g )
	{
	  $gid = getOrCreate( "lyricalthemes", $g );
	  addRelatedToSong( "lyricaltheme", $gid, $songid );
	}

      $eva = array_shift( getImportValuesFromGroup( "CLEVER VS. GENERIC" ) );
      $toupdate["CleverVsGeneric"] = $eva; 

      $toupdate["SongTitleWordCount"] = $data[$cols["Song Title Word Count"]];
      $toupdate["SongTitleAppearances"] = $data[$cols["Song Title Appearances"]];

      $placements = getImportValuesFromGroup( "SONG TITLE PLACEMENT" );
      clearRelated( "placement", $songid );
      foreach( $placements as $i )
	{
	  if( $i == "Multiple Sections" ) continue;
	  $i = trim( str_replace( "Placement-", "", $i ) );
	  $gid = getOrCreate( "placements", $i );
	  addRelatedToSong( "placement", $gid, $songid );
	}

      $toupdate["Lyrics"] = $data[$cols["Song Lyrics"]];

      $pndispl = array_pop( getImportValuesFromGroup( "PRIMARY NARRATIVE" ) );
      $pnarr = array();
      if( $pndispl == "1st Person" || $pndispl == "1st & 3rd" || $pndispl == "1st & 2nd" )
	{
	  $pnarr[] = "1st Person";
	}
      if( $pndispl == "2nd Person" || $pndispl == "2nd & 3rd" || $pndispl == "1st & 2nd" )
	{
	  $pnarr[] = "2nd Person";
	}

      if( $pndispl == "3rd Person" || $pndispl == "2nd & 3rd" || $pndispl == "1st & 3rd" )
	{
	  $pnarr[] = "3rd Person";
	}

      $toupdate["PrimaryNarrative"] = implode( ",", $pnarr );

      db_query( "delete from song_to_vocalexample where songid = $songid" );
      $vtypes = array( "Repeat & Call/Response Vocals", "Creatively Sung Vocals", "Nonsense Vocals" );
      foreach( $vtypes as $v )
	{
	  if( $data[$cols[$v]] )
	    {
	      $ins = db_query_insert_id( "insert into song_to_vocalexample ( songid, vocalexample, exampletype ) values ( '$songid', '" . escMe( $data[$cols[$v]+1] ). "', '$v' )" );
	      $sections = explode( ",", $data[$cols[$v]+2] );
	      foreach( $sections as $s )
		{
		  $s = trim( $s );
		  $tmpid = getIdByName( "placements", $s );
		  db_query( "insert into placement_to_vocalexample ( placementid, vocalexampleid ) values ( $tmpid, $ins )" ); 
		  
		}
	      
	    }
	}

      
      $pndispl = array_pop( getImportValuesFromGroup( "LEAD VOCAL GENDER" ) );
      if( strpos( $pndispl, "Duet/Group" ) !== false )
	{
	  $pndispl = array_pop( getImportValuesFromGroup( "DUET/GROUP TYPE" ) );
	}
      
      $toupdate["VocalsGender"] = $pndispl;
      
      $toupdate["Tempo"] = $data[$cols["Tempo"]];
      $toupdate["FormDescription"] = $data[$cols["Form Description"]];

      $allsongsections = db_query_array( "select Name, SpreadsheetName from songsections order by OrderBy", "Name", "SpreadsheetName" );
      db_query( "delete from song_to_songsection where songid = $songid" );
      
      foreach( $allsongsections as $thename=>$ssname )
	{
	  addSection( $songid, $data, $thename, $ssname ) ;
	}


      $sl = $data[$cols["Song Length"]];
      if( $sl )
      {
          if( strlen( $sl ) == 4 )
              $sl = "00:0{$sl}";
          else 
              $sl = "00:{$sl}";
      }
      else
      {
          $sl = db_query_first_cell( "select max( endtime ) from song_to_songsection where songid = $songid" );
      }
      $toupdate["SongLength"] = $sl;
      

//      exit;
      $toupdate["FirstSectionDescription"] = $data[$cols["First Section Description"]];
      $toupdate["ChorusDescr"] = $data[$cols["Chorus Characteristics"]];

      $chorarr =  getImportValuesFromGroup( "INTRO TYPE" );
      foreach( $chorarr as $displ )
	{
	  $cid = getOrCreate( "introtypes", $displ . " Intro" );
	  addRelatedToSong( "introtype", $cid, $songid );
	  
	}
      
      $chorarr =  getImportValuesFromGroup( "CHORUS KICKOFF TYPE" );
      foreach( $chorarr as $displ )
	{
	  $cid = getOrCreate( "chorustypes", $displ . " Chorus" );
	  addRelatedToSong( "chorustype", $cid, $songid );
	  
	}
      
      // the end
      foreach( $toupdate as $column => $label )
	{
	  if( $label )
	    {
	      $sql = ( "update songs set $column = '" . escMe( $label ) . "' where id = $songid" );
	    }
	  else
	    {
	      $sql = ( "update songs set $column = NULL where id = $songid" );
	    }
	  db_query( $sql );
	  //	  echo( $sql );
	}

      include "autocalc.php";

	  if( !$countuploaded ) $countuploaded = 0;
	  $countuploaded ++;
      
    }
    fclose($handle);
  }
  $err = "<font color='red'>Complete. $countuploaded songs added!</font><br><br>";
}

$tsongs = db_query_rows( "select * from songs", "id" );


foreach( $tsongs as $songid=>$srow )
{
    $peak = db_query_first_cell( "select type from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id order by cast( replace( type, 'position', '' ) as signed ) limit 1" );
    $peak = str_replace( "position", "", $peak );
    db_query( "update songs set PeakPosition = '$peak' where id = $songid" );
    $t = db_query_first_cell( "select count(*) from song_to_weekdate where songid = $songid" );
    db_query( "update songs set NumberOfWeeksSpentInTheTop10 = '$t' where id = $songid" );

}


include "nav.php";
?>
<form method='post' enctype='multipart/form-data'>
<?=$err?>
<br><br><h3>Upload Data</h3>
    File: (csv format ONLY) <input type='file' name='uploadfile'> <br>
<!--    Delete Existing Data: <input type='checkbox' name='delexisting' value='1'><br>-->
<input type='submit' name='go' value='Go'><br>
<br><br>  <h3>Upload Charts</h3><i>Song name, Date, Position</i><br>
    File: (csv format ONLY) <input type='file' name='uploadfilechart'> <br>
    Delete Existing Data: <input type='checkbox' name='delexistingcharts' value='1'><br>
<input type='submit' name='gocharts' value='Go'>
<br><br>    <h3>Upload Song Links</h3> <i>Song Title, Lyrics Link, Youtube Link, iTunes Link, Spotify Link, Youtube Embed Link (optional)</i><br>
    File: (csv format ONLY) <input type='file' name='uploadfilelinks'> <br>
<input type='submit' name='golinks' value='Go Links'>
<br><br>    <h3>Upload Artist Data</h3> <i>First Name,Middle Name,Last Name,Stage Name,Date of Birth (mm/dd/yyyy),City,Country,Wikipedia URL,Artist&apos;s Site URL
</i><br>
    File: (csv format ONLY) <input type='file' name='uploadartists'> <br>
<input type='submit' name='goartists' value='Go Artists'>
<br><br>                                                                                                                                                     <h3>Upload Song Artists</h3> <i>Song Title,First Name,Last Name,First Name,Last Name,First Name,Last Name, (etc)
</i><br>
    File: (csv format ONLY) <input type='file' name='uploadsongartists'> <br>
<select name='uploadtype'>
<option value='creditedsw'>Credited Songwriter</option>
<option value='primary'>Primary Artist</option>
<option value='creditedp'>Credited Producer</option>
<option value='sample'>Sample Artist</option>
<option value='uncredited'>Uncredited Artist</option>
</select><br>
<input type='submit' name='gosongartists' value='Go Song Artists'>

<br><br>                                                                                                                                                     <h3>Upload Samples</h3> <i>
                                                                                                                                                     Song Title, Whosampled link, Sampled Music, Sampled Vocals/Lyrics, Sample Artist 1, Sample Group 1, Sample Song 1, Sample Artist 2, Sample Group 2, Sample Song 2, Sample Artist 3, Sample Group 3, Sample Song 3, Sample Artist 4, Sample Group 4, Sample Song 4, Sample Artist 5, Sample Group 5, Sample Song 5</i><br>
    File: (csv format ONLY) <input type='file' name='uploadsamples'> <br>
<input type='submit' name='gosamples' value='Go Samples'>

<br><br>                                                                                                                                                     <h3>Upload Techniques</h3> <i>
    File: (csv format ONLY) <input type='file' name='uploadtechniques'> <br>
    Delete Existing Data: <input type='checkbox' name='delexistingtechniques' value='1'><br>
<input type='submit' name='gotechniques' value='Go Techniques'>


                                                                                                                                                     </form>
<? include "footer.php"; ?>
