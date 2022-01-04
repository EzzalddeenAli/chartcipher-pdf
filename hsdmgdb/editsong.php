<? include "connect.php"; ?>
<? 

// $tmpsongs = db_query_rows( "select songkeyid, MajorMinor, id from songs" );
// foreach( $tmpsongs as $d )
// {
// 	db_query( "insert into song_to_songkey ( songid, songkeyid, type ) values ( '$d[id]', '$d[songkeyid]', '$d[MajorMinor]' )" );
// }

if( $ack )
{
	// $c = db_query_array( "select distinct( Name ) from artists where id in ( select artistid from song_to_artist where type = 'creditedp' )", "Name", "Name" );
	// foreach( $c as $cname )
	// {
    //     $res = db_query_first_cell( "select id from producers where Name = '$cname'" );
    //     if( !$res )
    //     {
    //         $sql = "insert into producers ( Name, member1 ) values ( '" . escMe( $cname ) . "', '" . escMe( $cname ) . "' )";
    //         echo( $sql."<Br>" );
    //         db_query( $sql );
    //     }
	// }
//    $row = db_query_rows( "Select songid, Name from song_to_artist, artists where artists.id = artistid and type = 'creditedp'" );
    // foreach( $row as $r )
    // {
    //     $cname = $r[Name];
    //     $res = db_query_first_cell( "select id from producers where Name = '$cname'" );
    //     $sql = "insert into song_to_producer ( songid, producerid ) values ( $r[songid], $res )";
    //     db_query( $sql );
    //     echo( $sql . "<Br>" );
    // }
    // exit;
}

/* db_query( "delete from song_to_producer" ); */
/* $res = db_query_rows("select WritingProduction, ID from songs where WritingProduction > ''" ); */
/* foreach( $res as $r ) */
/*   { */
/*     db_query( "insert into song_to_producer( songid, producerid ) values ( '$r[ID]', '$r[WritingProduction]' ) " ); */
/*   } */

$refreshdivs = array();
$songsections = db_query_rows( "select * from songsections order by OrderBy desc", "id" );
$singleautofillfields = array( "songnameid"=>"songnames", "writingproduction"=>"producers", "imprint"=>"imprints", "labelid"=>"labels" );


if( !$songid )
  {
    Header( "Location: songs.php" );
    exit;
  }
if( $update )
  {

    foreach( $singleautofillfields as $s=>$tablename )
      {
	$newval = db_query_first_cell("select id from $tablename where Name = '". escMe( $_POST[$s] )."'" );
	if( !$newval && $_POST[$s] )
	  {
	    $err .= "<font color='red'>Warning: No matching value for '". stripslashes( $_POST[$s] )."' in table '$s'. No value was saved.</font>";
	  }
	$$s = $newval;
      }

 

    $sql = "update songs set songnameid = '". escMe( $songnameid )."'";
    if( $_FILES["LogicFilename"]["tmp_name"] )
	{
	    $newfilename = "logicfiles/{$songid}_Logic.zip";
	    move_uploaded_file( $_FILES["LogicFilename"]["tmp_name"], "../$newfilename" );
	    $sql .= ", LogicFilename = '". escMe( $newfilename )."'";
	    $sql .= ", LogicFilenameDate = now()";
	}
    else if( $clearLogicFilename ) 
	{
	    $sql .= ", LogicFilename = ''";
	}

    $sql .= ", timesignatureid = '". escMe( $timesignatureid )."'";
    $sql .= ", timesignatureid2 = '". escMe( $timesignatureid2 )."'";
    $sql .= ", timesignatureid3 = '". escMe( $timesignatureid3 )."'";
    $sql .= ", ArtistBand = '". escMe( $artistband )."'";
    //    print_r( $_POST );exit;
    $exp = explode( "^", $billboardname );
    $mybillboardtitle = $exp[0];
    $mybillboardartist = $exp[1];
    $sql .= ", BillboardName = '". escMe( $exp[0] )."'";
    $sql .= ", BillboardArtistName = '". escMe( $exp[1] )."'";
    $sql .= ", IsRemix = '". escMe( $IsRemix )."'";
    $sql .= ", SampledLink = '". escMe( $SampledLink )."'";
    $sql .= ", IsActive = '". escMe( $IsActive )."'";
    $sql .= ", IntroDescr = '". escMe( $introdescr )."'";
    if( $releasedate )
	{
	    $sql .= ", ReleaseDate = '". escMe( date( "Y-m-d", strtotime( $releasedate ) ) )."'";
	}
    else
	{
	   $sql .= ", ReleaseDate = NULL";
	}
    $sql .= ", Composition = '". escMe( $composition )."'";
    $sql .= ", MixType = '". escMe( $mixtype )."'";
    $sql .= ", SongLyricsLink = '". escMe( $songlyrics )."'";
    $sql .= ", HSDReport = '". escMe( $hsdreport )."'";
    $sql .= ", ChorusDescr = '". escMe( $chorusdescr )."'";
    $sql .= ", FormDescription = '". escMe( $formdescription )."'";
    $sql .= ", FirstSectionDescription = '". escMe( $fsdescription )."'";
    $sql .= ", SubgenreFusionTypeDescription = '". escMe( $SubgenreFusionTypeDescription )."'";
    $sql .= ", iTunes = '". escMe( $itunes )."'";
    $sql .= ", OfficialVideo = '". escMe( $officialvideo )."'";
    $sql .= ", OfficialVideoEmbed = '". escMe( $officialvideoembed )."'";
    $sql .= ", Spotify = '". escMe( $spotify )."'";
//    $sql .= ", majorminor = '". escMe( $majorminor )."'";
    $sql .= ", Tempo = '". escMe( $tempo )."'";
    //    $sql .= ", PrimaryArtistId = '$primaryartistid'";
    $sql .= ",  WritingProduction = '". escMe( $writingproduction )."'";


//    $sql .= ", songkeyid = '". escMe( $songkeyid )."'";
    $sql .= ", Imprint = '". escMe( $imprint )."'";
    $sql .= ", GenreID = '". escMe( $genreid )."'";
    $sql .= ", ClientID = '". escMe( $clientid )."'";
    $sql .= ", EndingDetails = '". escMe( $EndingDetails )."'";
    //    $sql .= ", LabelID = '$labelid'";
    $sql .= ", OutroCharacteristicsDescr = '". escMe( $OutroCharacteristicsDescr )."'";
    $sql .= ", FirstChorusMTIDetails = '". escMe( $fcmtidetails )."'";
    $sql .= ", FirstChorusMTI = ". getSetNull( $fcmti );
    $sql .= ", RecycledSections = ". getSetNull( $RecycledSections );

    $sql .= ", PrimaryNarrative = ". getSetNull( $primnarr );
    $sql .= ", ContainsSampled = ". getSetNull( $containssampled );
    $sql .= ", IntroVocalVsInst = ". getNull( $introvocalvsinst );
    $sql .= ", OutroVocalVsInst = ". getNull( $OutroVocalVsInst );
    $sql .= ", OutroRecycled = ". getNull( $OutroRecycled );

    $sql .= ", GenreFusionType = ".getNull( $genreft );
    $sql .= ", Lyrics = ".getNull( $lyrics );
    $sql .= ", ElectricVsAcoustic = ".getNull( $electricva );
    $sql .= ", DominantInstrument = ".getNull( $dominst );
    $sql .= ", CleverVsGeneric = ".getNull( $clever );
    $sql .= ", VocalsGender = ".getNull( $lvg );
    $sql .= ", BackgroundVocals = ".getNull( $bv );
    //    $sql .= ", DuetGroupType = ".getNull( $dgt );
    //    $sql .= ", FirstSection = ".getNull( $firstsection );
    $sql .= ", IntroType = ".getNull( $introtype );
    $sql .= ", SongLength = ".getNullTime( "songlength" );
    $sql .= ", SongForm = ".getNull( $songform );
    $sql .= ", ChorusKickoffType = ".getNull( $ckt );
    $sql .= ", V1V2BackingComparison = " . getNull( $vbc ); 
    $sql .= ", V1V2MelodyComparison = " . getNull( $vmc ); 
    $sql .= ", PreChorusMTI = " . getNull( $pcmti ); 
    $sql .= ", SimpleRepetitiveChorus = " . getNull( $src ); 
    $sql .= ", VersePreChorusBackingMusic = " . getNull( $vpcbm ); 
    $sql .= ", BridgeSurroundingAreaMTI = " . getNull( $bsamti ); 
    $sql .= ", BridgePlacement = " . getNull( $bp ); 
    $sql .= ", InstrumentalBreakType = " . getNull( $ibt ); 
    $sql .= ", OutroType = " . getNull( $outrotype ); 
//    $sql .= ", EndingType = " . getSetNull( $endingtype );

    if( strlen( $sta ) == 0 ) $sta = "NULL";
    
    $sql .= ", SongTitleAppearances = " . $sta; 
    $sql .= ", SongTitleWordCount = " . getNull( $stwc ); 
    $sql .= ", V1V2BackingComments = " . getNull( $vbcomm ); 
    $sql .= ", PreChorusMTIComments = " . getNull( $pcmticomm ); 
    $sql .= ", VersePreChorusBackingMusicComments = " . getNull( $vpcbmcomm ); 
    $sql .= ", V1V2MelodyComments = " . getNull( $vmcomm ); 
    $sql .= ", OutroTypeComments = " . getNull( $otcomm ); 

    $sql .= " where id = $songid";
//    echo( $sql );
    db_query( $sql );

    if( $mybillboardartist && $mybillboardtitle )
	{
	    db_query( "update billboardinfo set songid = 0 where songid = $songid and (artist <> '" . escMe( $mybillboardartist ) . "' or title <> '" . escMe( $mybillboardtitle ) . "' )" );
	    //	    echo( "update billboardinfo set songid = 0 where songid = $songid and (artist <> '" . escMe( $mybillboardartist ) . "' or title <> '" . escMe( $mybillboardtitle ) . "' )<br>" );
	    db_query( "update billboardinfo set songid = $songid where artist = '" . escMe( $mybillboardartist ) . "' and title = '" . escMe( $mybillboardtitle ) . "'" );
	}


    $tablearr = array();
    $tablearr[] = "introtypes";
    $tablearr[] = "outrotypes";
    $tablearr[] = "songwriters";
//    $tablearr[] = "producers";
    $tablearr[] = "lyricalthemes";
    $tablearr[] = "placements";
    $tablearr[] = "endingtypes";
    $tablearr[] = "chorusstructures";

    foreach( $tablearr as $t )
      {
	$shorttablename = substr($t, 0, -1);
	db_query( "delete from song_to_$shorttablename where songid = $songid" );
	if( is_array( $_POST[$t] ) )
	  foreach( $_POST[$t] as $tid => $throwaway )
	    {
	      db_query( "insert into song_to_$shorttablename ( songid, {$shorttablename}id ) values ( '$songid', '$tid' )" );
	    }
      }

    
    db_query( "delete from song_to_chorustype where songid = $songid" );

    if( is_array( $_POST["chorustypes"] ) )
        foreach( $_POST["chorustypes"] as $i => $values )
            foreach( $values as $tid => $throwaway )
	    {
//            echo( "insert into song_to_chorustype ( songid, chorustypeid, type ) values ( '$songid', '$tid', '$i' )<br>" );
            db_query( "insert into song_to_chorustype ( songid, chorustypeid, type ) values ( '$songid', '$tid', '$i' )" );
	    }
    
    db_query( "delete from song_to_bridgecharacteristic where songid = $songid" );

    if( is_array( $_POST["bridgecharacteristics"] ) )
        foreach( $_POST["bridgecharacteristics"] as $i => $values )
            foreach( $values as $tid => $throwaway )
	    {
//            echo( "insert into song_to_bridgecharacteristic ( songid, bridgecharacteristicid, type ) values ( '$songid', '$tid', '$i' )<br>" );
            db_query( "insert into song_to_bridgecharacteristic ( songid, bridgecharacteristicid, type ) values ( '$songid', '$tid', '$i' )" );
	    }
    
    db_query( "delete from song_to_postchorustype where songid = $songid" );
    if( is_array( $_POST["postchorustypes"] ) )
        foreach( $_POST["postchorustypes"] as $i => $values )
            foreach( $values as $tid => $throwaway )
	    {
            db_query( "insert into song_to_postchorustype ( songid, postchorustypeid, type ) values ( '$songid', '$tid', '$i' )" );
	    }
    
    db_query( "delete from song_to_sampletype where songid = $songid" );
    // print_r( $_POST["sampletypes"] );
    // exit;
    if( is_array( $_POST["sampletypes"] ) )
        foreach( $_POST["sampletypes"] as $i => $values )
            foreach( $values as $tid => $throwaway )
	    {
//            echo( "insert into song_to_sampletype ( songid, sampletypeid, type ) values ( '$songid', '$tid', '$i' )<br>." );
            db_query( "insert into song_to_sampletype ( songid, sampletypeid, type ) values ( '$songid', '$tid', '$i' )" );
	    }
    
    db_query( "delete from song_to_vocaltype where songid = $songid" );
    if( is_array( $_POST["vocaltypes"] ) )
        foreach( $_POST["vocaltypes"] as $i => $values )
            foreach( $values as $tid => $throwaway )
	    {
            db_query( "insert into song_to_vocaltype ( songid, vocaltypeid, type ) values ( '$songid', '$tid', '$i' )" );
	    }
    
    db_query( "delete from song_to_backvocaltype where songid = $songid" );
    if( is_array( $_POST["backvocaltypes"] ) )
        foreach( $_POST["backvocaltypes"] as $i => $values )
            foreach( $values as $tid => $throwaway )
	    {
            db_query( "insert into song_to_backvocaltype ( songid, backvocaltypeid, type ) values ( '$songid', '$tid', '$i' )" );
	    }
    
    
    db_query( "delete from song_to_vocal where songid = $songid" );
    if( is_array( $_POST["vocals"] ) )
        foreach( $_POST["vocals"] as $i => $values )
            foreach( $values as $tid => $throwaway )
	    {
            db_query( "insert into song_to_vocal ( songid, vocalid, type ) values ( '$songid', '$tid', '$i' )" );
	    }
    
    db_query( "delete from song_to_backvocal where songid = $songid" );
    if( is_array( $_POST["backvocals"] ) )
        foreach( $_POST["backvocals"] as $i => $values )
            foreach( $values as $tid => $throwaway )
	    {
            db_query( "insert into song_to_backvocal ( songid, backvocalid, type ) values ( '$songid', '$tid', '$i' )" );
	    }
    

    $arr = array("subgenre"=>$subgenres);
    $arr["containssampled"] =$containssampleds;
    $arr["songkey"] = $songkeys;
    //    $arr["retroinfluence"] = $retroinfluences;
    $arr["instrument"] = $instruments;
    $arr["primaryinstrumentation"] = $primaryinstrumentations;
    /* $arr["rocksubgenre"] = $rocksubgenres; */
    /* $arr["worldsubgenre"] = $worldsubgenres; */
    // subgenres now has a bunch of areas, ugh
    foreach( $arr as $tname=>$thisarr )
      {
          db_query( "delete from song_to_{$tname} where songid = $songid" );
          if( is_array( $thisarr ) )
          {
              foreach( $thisarr as $i=>$vals )
              {
                  if( is_array( $vals ) )
                      foreach( $vals as $tid => $throwaway )
                      {
                          db_query( "insert into song_to_{$tname} ( songid, {$tname}id, type ) values ( '$songid', '$tid', '$i' )" );
                      }
              }
          }
      }
    // end subgenres
    
    db_query( "delete from song_to_songsection where songid = '$songid'" );
    //    print_r( $_POST );
    foreach( $songsections as $srow )
      {
	$startval = getNullTimeSSID( $srow[id], "start" );
	$endval = getNullTimeSSID( $srow[id], "end" );
	$bsurr = $bridgesurrogate[$srow[id]]?1:0;
	$pchor = $postchorus[$srow[id]]?1:0;
	$mybars = escMe( $bars[$srow[id]] );

	$toupd = array();
//	$toupd["Vocals"] = getSetNull( $vocals[$srow[id]] );
//	$toupd["BackgroundVocals"] = getSetNull( $bgvocals[$srow[id]] );
	$toupd["VocalsGender"] = getSetNull( $vocalsgender[$srow[id]] );
	$toupd["VMComparison"] = getSetNull( $VMComparison[$srow[id]] );
	$toupd["BMComparison"] = getSetNull( $BMComparison[$srow[id]] );
	$toupd["MTI"] = getNull( $MTI[$srow[id]] );
	$toupd["PSVMComparison"] = getSetNull( $PSVMComparison[$srow[id]] );
	$toupd["PSBMComparison"] = getSetNull( $PSBMComparison[$srow[id]] );
	$toupd["TransitionIntoChorus"] = getSetNull( $TransitionIntoChorus[$srow[id]] );
	$toupd["PrimaryNarrative"] = getSetNull( $lyricalpov[$srow[id]] );
	
	$toupd["Stanzas"] = "'" . escMe( $stanzas[$srow[id]] ) . "'";
	$toupd["PostChorusDetails"] = "'" . escMe( $pcdetails[$srow[id]] ) . "'";
	$toupd["PostChorusStanzas"] = "'" . escMe( $pcstanzas[$srow[id]] ) . "'";
	$toupd["VocalTypeDetails"] = "'" . escMe( $vtdetails[$srow[id]] ) . "'";
	$toupd["PrimaryInstrumentation"] = "'" . escMe( $pinstr[$srow[id]] ) . "'";
	$toupd["SubgenreDetails"] = "'" . escMe( $sgdetails[$srow[id]] ) . "'";
	$toupd["StanzaDetails"] = "'" . escMe( $StanzaDetails[$srow[id]] ) . "'";
	$toupd["TransitionDetails"] = "'" . escMe( $TransitionDetails[$srow[id]] ) . "'";
	$toupd["VMComparisonDescription"] = "'" . escMe( $VMComparisonDescription[$srow[id]] ) . "'";
	$toupd["BMComparisonDescription"] = "'" . escMe( $BMComparisonDescription[$srow[id]] ) . "'";
	$toupd["MTIDescription"] = "'" . escMe( $MTIDescription[$srow[id]] ) . "'";
	$toupd["PSVMComparisonDescription"] = "'" . escMe( $PSVMComparisonDescription[$srow[id]] ) . "'";
	$toupd["PSBMComparisonDescription"] = "'" . escMe( $PSBMComparisonDescription[$srow[id]] ) . "'";
    $toupd["WithoutNumberHard"] = "'" . getWithoutNumber( $srow[id] ) . "'" ;
    $tmpvt = db_query_array( "select Name from song_to_vocaltype, vocaltypes where songid = $songid and type = '$srow[id]' and vocaltypeid = vocaltypes.id", "Name", "Name" );
    $toupd["VocalTypesHard"] = "'" . escMe( implode( ", ", $tmpvt ) ) . "'" ;
    
    $tmpvt = db_query_array( "select Name from song_to_vocal, vocals where songid = $songid and type = '$srow[id]' and vocalid = vocals.id", "Name", "Name" );
    $toupd["VocalsHard"] = "'" . escMe( implode( ", ", $tmpvt ) ) . "'" ;
    
	if( $startval != "'00::'" )
	  {
	    db_query( "insert into song_to_songsection( songid, songsectionid, starttime, endtime, BridgeSurrogate, PostChorus, Bars ) values ( '$songid', '$srow[id]', $startval, $endval, '$bsurr', '$pchor', '$mybars' )" );

	    foreach( $toupd as $t=>$val )
	      {
		db_query( "update song_to_songsection set $t = $val where songsectionid = '$srow[id]' and songid = '$songid'" );
	      }

	  }
      }
    
    // vocal examples
    //    mysql> create table song_to_vocalexample ( id integer primary key auto_increment, songid integer, vocalexample text, exampletype varchar( 20 ) ) ;
    //      mysql> create table placement_to_vocalexample ( placementid integer, vocalexampleid integer ) ;
/* Repeat & Call/Resonse Vocals */
/* Creatively Sung Vocals */
/* Nonsense Vocals */
    foreach( $vts as $songsectionid=>$tmparr )
      {
	foreach( $tmparr as $id => $str )
	  {
	    $hiddenid = $hiddenveids[$songsectionid][$id];
	    if( !$str )
	      {
		if( $hiddenid )
		  {
		    db_query( "delete from song_to_vocalexample where id = $hiddenid" );
		    db_query( "delete from placement_to_vocalexample where vocalexampleid = $hiddenid" );
		  }
		continue;
	      }
	    else
	      {
		if( !$hiddenid )
		  {
		    $hiddenid = db_query_insert_id( "insert into song_to_vocalexample ( songid ) values ( '$songid' )" );
		  }
		$et = escMe( $ets[$songsectionid][$id] );
		$vt = escMe( $vts[$songsectionid][$id] );
		db_query( "update song_to_vocalexample set exampletype = '$et', vocalexample = '$vt' where id = $hiddenid" );
		
		db_query( "delete from placement_to_vocalexample where vocalexampleid = $id" );
		foreach( $vesections[$songsectionid][$id] as $ssid )
		  {
		    db_query( "insert into placement_to_vocalexample ( placementid, vocalexampleid ) values ( '$ssid', '$hiddenid')  " );
		  }
	      }
	  }
      }

    foreach( $wfs as $id=>$str )
      {
	$hiddenid = $hiddenwfids[$id];
	if( !$str )
	  {
	    if( $hiddenid )
	      {
		db_query( "delete from song_to_wowfactor where id = $hiddenid" );
		db_query( "delete from placement_to_wowfactor where wowfactorid = $hiddenid" );
	      }
	    continue;
	  }
	else
	  {
	    if( !$hiddenid )
	      {
		$hiddenid = db_query_insert_id( "insert into song_to_wowfactor ( songid ) values ( '$songid' )" );
	      }
	    $et = escMe( $wfs[$id] );
	    $vt = escMe( $wfes[$id] );
	    db_query( "update song_to_wowfactor set exampletype = '$et', wowfactor = '$vt' where id = $hiddenid" );

	    db_query( "delete from placement_to_wowfactor where wowfactorid = $id" );
	    foreach( $wfsections[$id] as $ssid )
	      {
		db_query( "insert into placement_to_wowfactor ( placementid, wowfactorid ) values ( '$ssid', '$hiddenid')  " );
	      }
	  }
      }

    //    print_r( $techniques );
    foreach( $techniques as $id=>$str )
      {
	$hiddenid = $hiddentechniqueids[$id];
	if( !$str )
	  {
	    if( $hiddenid )
	      {
		db_query( "delete from song_to_technique where id = $hiddenid" );
		db_query("delete from song_to_technique_to_songsection where sttid = '$hiddenid'" );
	      }
	    continue;
	  }
	else
	  {
	    if( !$hiddenid )
	      {
		$hiddenid = db_query_insert_id( "insert into song_to_technique ( songid ) values ( '$songid' )" );
	      }
	    $vt = escMe( $techniquedescriptions[$id] );
	    $tsc = escMe( $techniquesubcategories[$id] );
	    $tssc = escMe( $techniquesubsubcategories[$id] );
	    $tc = escMe( $techniquecategories[$id] );
	    $tspot = escMe( $techniquespot[$id] );
	    $ur = escMe( $techniqueurls[$id] );
	    $im = escMe( $techniqueimages[$id] );
	    $ina = escMe( $techniqueinactive[$id] );
	    $vim = escMe( $techniquevimeo[$id] );
	    //	    print_r( $_FILES );exit;
	    if( $_FILES["techniqueimageupload"]["tmp_name"][$id] )
		{
		    move_uploaded_file( $_FILES["techniqueimageupload"]["tmp_name"][$id], "../techniqueimages/{$hiddenid}.jpg" );
		    $im = "https://analytics.chartcipher.com/techniqueimages/{$hiddenid}.jpg";
		}

	    db_query( "update song_to_technique set techniqueid = '$str', inactive = '$ina', vimeourl = '$vim', spotify = '$tspot', techniquecategoryid = '$tc', techniquesubcategoryid = '$tsc', techniquesubsubcategoryid = '$tssc', description = '$vt', imageurl = '$im', url = '$ur' where id = $hiddenid" );
	  }
	db_query("delete from song_to_technique_to_songsection where sttid = '$hiddenid'" );
	
	//	print_r( $techniquesongsections );
	foreach( $techniquesongsections[$id] as $tmpval )
	    {
		$exp = explode( "_", $tmpval );
		$val = $exp[1];
		$tst = "'00:". $_POST["techniquedsmin"][$id][$val] . ":" . $_POST["techniquedssec"][$id][$val] . "'";
		$tet = "'00:". $_POST["techniquedemin"][$id][$val] . ":" . $_POST["techniquedesec"][$id][$val] . "'";
		db_query( "insert into song_to_technique_to_songsection ( sttid, songsectionid, starttime, endtime ) values ( '$hiddenid', '$val', $tst, $tet ) " );
	    }
      }



    if( is_array( $ssar ) )
        foreach( $ssar as $artistid=>$sssongid )
        {
            db_query( "update song_to_artist set songsampleid = '$sssongid' where artistid = $artistid and songid = '$songid' and type = 'samplesw'" );
        }

    if( is_array( $ssara ) )
        foreach( $ssara as $artistid=>$sssongid )
        {
            db_query( "update song_to_artist set songsampleid = '$sssongid' where artistid = $artistid and songid = '$songid' and type = 'sample'" );
        }

    if( is_array( $ssarg ) )
        foreach( $ssarg as $artistid=>$sssongid )
        {
            db_query( "update song_to_group set songsampleid = '$sssongid' where groupid = $artistid and songid = '$songid' and type = 'sample'" );
        }

    include "autocalc.php";

    $err .= "<font color='red'>Updated.</font>";
  }

$row = db_query_first( "select * from songs where id = $songid" );
$extratitle = $row[CleanUrl];
include "nav.php";


$currssvals = db_query_rows( "select * from song_to_songsection where songid = $row[id] order by starttime", "songsectionid" );

$splitupsongsections = array();
$anypostchoruses = false; 
foreach( $currssvals as $srow )
  {
    $without = $songsections[$srow[songsectionid]]["WithoutNumber"]; 
    if( trim( $without ) == "Other Section" ) continue;
    $splitupsongsections[$without][$srow[songsectionid]] = $srow;
    if( $srow["PostChorus"] ) $anypostchoruses = 1;
  }

$samples = db_query_rows( "select Name, sts.* from song_to_samplesong sts, samplesongs where songid = $row[id] and samplesongs.id = sts.samplesongid" );

?>

<form method='post' enctype='multipart/form-data'>
<?=$err?>
  <h3>Editing: <?=getSongname( $row["songnameid"] )?></h3>
    <? if( $row[CleanUrl] ) { ?>
<a href='/<?=$row[CleanUrl]?>'>View On Front End</a><br>
<? }?>
<input type='submit' name='update' value='Update'><br><br>
<div id="tabs">
<ul>
<li><a href='#tabs-songinfo'>Song Info</a> </li>
<li><a href='#tabs-credits'>Credits</a> </li>
<li><a href='#tabs-charting'>Charting</a> </li>
<li><a href='#tabs-subgenres'>Sub-Genres</a> </li>
<li><a href='#tabs-electronic'>Electronic Vs Acoustic</a> </li>
<li><a href='#tabs-instrumentation'>Prominent Instrumentation</a> </li>
<li><a href='#tabs-instruments'>Primary Instruments</a> </li>
<li><a href='#tabs-lyrics'>Lyrics</a> </li>
<li><a href='#tabs-songtitle'>Song Title</a> </li>
<li><a href='#tabs-vocals'>Vocals</a> </li>
<li><a href='#tabs-hooks'>Hooks, Clever Elements/Wow Factors</a> </li>
<li><a href='#tabs-form'>Form</a> </li>
<li><a href='#tabs-firstsection'>First Section</a> </li>
<? if( $anypostchoruses ) { ?>
<li><a href='#tabs-postchorus'>Post-Chorus</a> </li>
<? } ?>
<? if( count( $samples ) ) { ?>
<li><a href='#tabs-samples'>Samples</a> </li>
<? } ?>

  <? foreach( $splitupsongsections as $without=>$throwaway ) { 
  $shortname = strtolower( $without );
  $shortname = str_replace( " ", "", $shortname );
?>
<li><a href='#tabs-<?=$shortname?>'><?=$without?></a> </li>
						   <? } ?>
<li><a href='#tabs-sections'>Section Start and End Points</a> </li>
<li><a href='#tabs-techniques'>Techniques</a> </li>

<li><a href='#tabs-autocalc'>Auto Calc</a> </li>
<li><a href='#tabs-newdata'>New Data</a> </li>
<li><a href='#tabs-charts'>Charts</a> </li>
<li><a href='#tabs-notused'>Not Used</a> </li>
</ul>
<div id="tabs-songinfo">
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>Song Info </th></tr>
  <?=outputOtherTableAutofill( "Song Name", "songnameid", $row[songnameid] )?>
  <?=outputSelectRow( "Is Active?", 'IsActive', $row["IsActive"], $yesno0, 120 )?>
  <?=outputSelectRow( "Is A Remix?", 'IsRemix', $row["IsRemix"], $yesno0, 120 )?>
  <?=outputOtherTableSelect( "Genre", "genreid", $row[GenreID], "genres" )?>
  <?=outputOtherTableSelect( "Client", "clientid", $row[ClientID], "clients" )?>
  <?=outputOtherTableSelect( "Time Signature", "timesignatureid", $row[timesignatureid], "timesignatures" )?>
  <?=outputOtherTableSelect( "2nd Time Signature", "timesignatureid2", $row[timesignatureid2], "timesignatures" )?>
  <?=outputOtherTableSelect( "3rd Time Signature", "timesignatureid3", $row[timesignatureid3], "timesignatures" )?>
  <?=outputOtherTableCheckboxes( "Major Key(s)", "songkeys", $row[id], "songkeys", false, "Major" )?>
  <?=outputOtherTableCheckboxes( "Minor Key(s)", "songkeys", $row[id], "songkeys", false, "Minor" )?>
  <? // =outputOtherTableSelect( "Key Note", "songkeyid", $row[songkeyid], "songkeys" )?>
  <? // =outputSelectRow( "Major / Minor", 'majorminor', $row["majorminor"], getEnumValues( "majorminor" ) )?>
  <?=outputInputRow( "Tempo", "tempo", $row[Tempo], 5 )?>
  <?=outputTimeRow( "Song Length", "songlength", $row[SongLength] )?>
  <?=outputInputRow( "iTunes", "itunes", $row[iTunes], 100 )?>
  <?=outputInputRow( "Spotify", "spotify", $row[Spotify], 100 )?>
  <?=outputInputRow( "Official Video", "officialvideo", $row[OfficialVideo], 100 )?>
  <?=outputInputRow( "Official Video (Embed Link)", "officialvideoembed", $row[OfficialVideoEmbed], 100 )?>
  <?=outputInputRow( "Song Lyrics Link", "songlyrics", $row[SongLyricsLink], 100 )?>
  <?=outputInputRow( "HSD Report", "hsdreport", $row[HSDReport], 100 )?>
  <?=outputSelectRow( "Vocals", 'lvg', $row["VocalsGender"], getEnumValues( "VocalsGender" ) )?>
  <?=outputOtherTableCheckboxes( "Contains Sampled", "containssampleds", $row[id], "containssampleds", false, "Main" )?>
 <?=outputInputRow( "Sample Link", "SampledLink", $row[SampledLink], 100 )?>
<? 
    $downloads = db_query_first_cell( "select count(*) from songfiledownloads where type = 'LogicFilename' and pdfid = '$songid'" );
$extrastr = ( "<br>$downloads download(s)" );
?>
    <?=outputFileRow( "Logic Filename", "LogicFilename", $row[LogicFilename]?"../logicfiles/dl.php?key=$songid":"", $row[LogicFilename]?$extrastr:"" )?>

<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "songinfo" ); return false;'>Reset all values</a></td></tr>
</table>
</div>
<div id='tabs-credits'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>Credits  </th></tr>
<tr><td>Total Team Size (calculated)</td><td><?=$row[TotalCount]?></td></tr>
  <?=outputInputRow( "Display Artist/Band", "artistband", $row[ArtistBand] )?>
<?php
    $ch = getLiveChartsDbStr();
$arfirst = $row["ArtistBand"][0];
$possiblevalsarr = db_query_rows( "select distinct( artist ), title from billboardinfo where chart in ( $ch ) and (rank <= 10 and artist like '$arfirst%') or (artist = '" . escMe( $row[BillboardArtistName] ) . "' and title = '" . escMe( $row[BillboardName] ) . "' )  order by title, artist" );
$billboard = array();
foreach( $possiblevalsarr as $p )
{
    $billboard[trim( htmlentities( $p[title]. "^" . $p[artist] ) )] = trim( $p[title]. " - " . $p[artist] );
}
$bb = "";
if( $row[BillboardName] )
    {
	$bb = htmlentities($row[BillboardName])."^" . htmlentities($row[BillboardArtistName]);
    }
ksort( $billboard );
//print_r( $billboard );
//echo( "count: " . count( $billboard ) );
 ?>
  <?=outputSelectRow( "Billboard Song", "billboardname", $bb, $billboard )?> 
<? 
if( $row[BillboardName] ) { 
outputBackgroundColor();
?><tr <?=outputBackgroundColor()?>><td ></tD><td><a target=_blank href='refreshbillboarddatasingle.php?songid=<?=$songid?>'>Refresh Billboard Data (only after save)</a></td></tr> <? } ?>
  <?=outputOtherTableAutofillMultiple( "Primary Performing Artists", "primaryartistids", $row[id], "artists", "primary" )?>
  <?=outputOtherTableAutofillMultiple( "Primary Performing Group", "primarygroupids", $row[id], "groups", "primary" )?>
  <?=outputOtherTableAutofillMultiple( "Featured Performing Artists", "featuredartistids", $row[id], "artists", "featured" )?>
  <?=outputOtherTableAutofillMultiple( "Featured Performing Groups", "featuredgroupids", $row[id], "groups", "featured" )?>
  <?=outputOtherTableAutofillMultiple( "Uncredited Performing Artists", "uncreditedartistids", $row[id], "artists", "uncredited" )?>
  <?=outputOtherTableAutofillMultiple( "Uncredited Performing Groups", "uncreditedgroupids", $row[id], "groups", "uncredited" )?>
  <?=outputOtherTableAutofillMultiple( "Sample Artists", "sampleartistids", $row[id], "artists", "sample" )?>
  <?=outputOtherTableAutofillMultiple( "Sample Groups", "samplegroupids", $row[id], "groups", "sample" )?>
  <?=outputOtherTableAutofillMultiple( "Sample Songs", "samplesongs", $row[id], "samplesongs" )?>
  <?=outputOtherTableAutofillMultiple( "Sample Songwriters", "sampleswartistids", $row[id], "artists", "samplesw" )?>
  <?=outputOtherTableAutofillMultiple( "Credited Songwriters", "creditedswartistids", $row[id], "artists", "creditedsw" )?>
  <?=outputOtherTableAutofillMultiple( "Credited Producers/Production Group", "writingproduction", $row[id], "producers" )?>
  <?=outputOtherTableAutofillMultiple( "Record Label", "labelids", $row[id], "labels" )?>
  <?=outputOtherTableAutofillMultiple( "Imprint", "imprints", $row[id], "imprints" )?>
<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "credits" ); return false;'>Reset all values</a></td></tr>

</table>
</div>
<div id='tabs-charting'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>Charting Info </th></tr>
    <?=outputInputRow( "Release Date", "releasedate", $row[ReleaseDate], 8, " <i>YYYY-MM-DD</i>" )?>
  <? for( $i = 1; $i <= 10; $i ++ ) { ?>
  <?=outputOtherTableAutofillMultiple( "Weeks In Position $i", "position$i", $row[id], "weekdates", "position$i" )?>
				      <? } ?>
<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "charting" ); return false;'>Reset all values</a></td></tr>
</table>
</div>
<div id='tabs-subgenres'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>Sub-Genres</th></tr>
  <?=outputOtherTableCheckboxes( "Sub-Genres", "subgenres", $row[id], "subgenres", false, "Main" )?>
  <?=outputSelectRow( "Sub-genre Fusion Type", 'genreft', $row["GenreFusionType"], getEnumValues( "GenreFusionType" ) )?>
  <?=outputTextareaRow( "Description", "SubgenreFusionTypeDescription", $row[SubgenreFusionTypeDescription], 40, 5 )?>
  <?//=outputOtherTableCheckboxes( "Retro Influences", "retroinfluences", $row[id], "retroinfluences", false, "Main" )?>
  <? // =outputOtherTableCheckboxes( "World Sub-Genres", "worldsubgenres", $row[id], "worldsubgenres", false, "Main" )?>
  <? // =outputOtherTableCheckboxes( "Rock Sub-Genres", "rocksubgenres", $row[id], "rocksubgenres", false, "Main" )?>

<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "subgenres" ); return false;'>Reset all values</a></td>  
</tr>
</table>
</div>
<div id='tabs-electronic'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>Electronic Vs Acoustic</th></tr>
  <?=outputSelectRow( "Electronic Vs Acoustic", 'electricva', $row["ElectricVsAcoustic"], getEnumValues( "ElectricVsAcoustic" ) )?>
<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "electronic" ); return false;'>Reset all values</a></td></tr>
</table>
</div>
<div id='tabs-instrumentation'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>Instrumentation </th></tr>
  <?=outputOtherTableCheckboxes( "Primary Instrumentations", "primaryinstrumentations", $row[id], "primaryinstrumentations", false, "Main" )?>
<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "instrumentation" ); return false;'>Reset all values</a></td></tr>

</table>
</div>
<div id='tabs-instruments'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>Instruments </th></tr>
  <?=outputOtherTableCheckboxes( "Instruments", "instruments", $row[id], "instruments", false, "Main" )?>
<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "instruments" ); return false;'>Reset all values</a></td></tr>

</table>
</div>
<div id='tabs-lyrics'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>Lyrics </th></tr>
 <?=outputOtherTableCheckboxes( "Lyrical Themes", "lyricalthemes", $row[id], "lyricalthemes" )?>
 <?=outputSetMultipleRow( "POV", 'primnarr', $row["PrimaryNarrative"], getSetValues( "PrimaryNarrative" ) )?>

<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "lyrics" ); return false;'>Reset all values</a></td></tr>

</table>
</div>
<div id='tabs-songtitle'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>Song Title </th></tr>
  <?=outputSelectRow( "Clever/Generic?", 'clever', $row["CleverVsGeneric"], getEnumValues( "CleverVsGeneric" ) )?>
  <?=outputInputRow( "Song Title Word Count", "stwc", $row[SongTitleWordCount], 4 )?>
  <?=outputInputRow( "Song Title Appearances", "sta", $row[SongTitleAppearances], 4 )?>
  <?=outputOtherTableCheckboxes( "Placements", "placements", $row[id], "placements" )?>
  <?=outputTextareaRow( "Song Lyrics", "lyrics", $row[Lyrics], 40, 10 )?>
<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "songtitle" ); return false;'>Reset all values</a></td></tr>
</table>
</div>
<div id='tabs-vocals'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>Vocals </th></tr>
<tr><td colspan='2' bgcolor='#aaffff'>
<table border=1 cellpadding=2 cellspacing=0 bgcolor='#ffffff'>
  <tr><th>Vocal Example Type</th><th>Sample (CLEAR VALUE TO REMOVE)</th><th>Vocal Example Section(s)</th></tr>
<? 
  $vocalexamples = db_query_rows( "Select * from song_to_vocalexample where songid = '$songid' and songsectionid = 0" ); 
for( $i = 0; $i < 3; $i++ )
  {
    $vocalexamples[] = array();
  }
$num = 0;
foreach($vocalexamples as $verow ) 
  {
    outputVocalExampleRow( $num, $verow, 0 );
    $num++;
  }
?>
</table>
</td></tr>

<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "vocals" ); return false;'>Reset all values</a></td></tr>

</table>
</div>

<div id='tabs-hooks'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
  <tr><th colspan='2'>Hooks, Clever Elements/Wow Factors</th></tr>
<tr><td colspan='2' bgcolor='#aaffff'>
<table border=1 cellpadding=2 cellspacing=0 bgcolor='#ffffff'>
  <tr><th>Type</th><th>Example (CLEAR VALUE TO REMOVE)</th><th>Section(s)</th></tr>
<? 
  $vocalexamples = db_query_rows( "Select * from song_to_wowfactor where songid = '$songid'" ); 
for( $i = 0; $i < 5; $i++ )
  {
    $vocalexamples[] = array();
  }
$num = 0;
foreach($vocalexamples as $verow ) 
  {
    outputWowFactorRow( $num, $verow );
    $num++;
  }
?>
</table>
</td></tr>

<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "hooks" ); return false;'>Reset all values</a></td></tr>

</table>
</div>


<div id='tabs-form'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>Form </th></tr>
  <?=outputReadOnlyRow( "Full Form", $row["SongStructure"] )?>
  <?=outputReadOnlyRow( "Abbreviated Form", $row["AbbrevSongStructure"] )?>
  <?=outputTextareaRow( "Form Description", "formdescription", $row[FormDescription], 40, 10 )?>
<!-- inputs go here-->
<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "form" ); return false;'>Reset all values</a></td></tr>

</table>
</div>

<? if( $anypostchoruses ) { ?>
<div id='tabs-postchorus'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>Post-Chorus </th></tr>
                            <? 
                            $count = 0; 
                            foreach( $currssvals as $ssrow )
                            {
                                $songsectionid = $ssrow[songsectionid];
                                if( !$ssrow["PostChorus"] ) continue;
                                $songsect = $songsections[$songsectionid];
                                $sectiontime = $songsect[Name];
                                $count++;
                                echo( "<tr><td colspan='2'>Post-Chorus {$count}: $sectiontime</td></tr>" );
                                echo( "<tr><td>Stanza:</td><td>");
                                echo( "<select name='pcstanzas[$songsectionid]' >" );
                                for( $i = 0; $i <= 100; $i++ )
                                {
                                    echo( "<option value='$i' " . ($ssrow["PostChorusStanzas"]==$i?"SELECTED":""). ">" . ($i?"$i":"Choose" ). "</option>" );
                                }
                                echo( "</select>" );
                                echo( "&nbsp;</td></tr>");
                                outputOtherTableCheckboxes( "Post-Chorus Type", "postchorustypes", $row[id], "postchorustypes", false, "$songsectionid" );
                                
                                outputTextareaRow( "Post-Chorus {$count} Details ", "pcdetails[{$songsectionid}]", $ssrow["PostChorusDetails"], 20, 5 );
                                
                            }
                            ?>
<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "postchorus" ); return false;'>Reset all values</a></td></tr>

</table>
</div>
<? } ?>

<? if( count( $samples ) ) { ?>
<div id='tabs-samples'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>Samples </th></tr>
                            <? 
                            $count = 0; 
                            foreach( $samples as $ssrow )
                            {
                                $count++;
                                echo( "<tr><td colspan='2'>Sample Song: $ssrow[Name]</td></tr>" );
                                outputOtherTableCheckboxes( "Sample Type", "sampletypes", $row[id], "sampletypes", false, "$ssrow[samplesongid]" );
                                
                            }
                            echo( "<tr><td colspan='2'>&nbsp;</td></tr>" );
                            $sampleartists = db_query_rows( "select * from song_to_artist, artists where type = 'samplesw' and songid = $row[id] and artists.id = artistid" );
                            foreach( $sampleartists as $sam )
                            {
                                echo( "<tr><td>Sample Songwriter: $sam[Name]</td>" );
                                echo ("<td> &nbsp;&nbsp;&nbsp;Associated Song: &nbsp;&nbsp;" );
                                echo( "<select name='ssar[{$sam[artistid]}]'><option value=''></option>" );
                                foreach( $samples as $ssrow )
                                {
                                    $sel = $sam[songsampleid] == $ssrow[samplesongid]?"SELECTED":"";
                                    echo( "<option $sel value='$ssrow[samplesongid]'>$ssrow[Name]</option>" );
                                }
                                echo( "</select>" );
                                echo ("</td></tr>" );
                                
                            }
                            echo( "<tr><td colspan='2'>&nbsp;</td></tr>" );
                            $sampleartists = db_query_rows( "select * from song_to_artist, artists where type = 'sample' and songid = $row[id] and artists.id = artistid" );
                            foreach( $sampleartists as $sam )
                            {
                                echo( "<tr><td>Sample Artist: $sam[Name]</td>" );
                                echo ("<td> &nbsp;&nbsp;&nbsp;Associated Song: &nbsp;&nbsp;" );
                                echo( "<select name='ssara[{$sam[artistid]}]'><option value=''></option>" );
                                foreach( $samples as $ssrow )
                                {
                                    $sel = $sam[songsampleid] == $ssrow[samplesongid]?"SELECTED":"";
                                    echo( "<option $sel value='$ssrow[samplesongid]'>$ssrow[Name]</option>" );
                                }
                                echo( "</select>" );
                                echo ("</td></tr>" );
                                
                            }
                            
                            echo( "<tr><td colspan='2'>&nbsp;</td></tr>" );
                            $samplegroups = db_query_rows( "select * from song_to_group, groups where type = 'sample' and songid = $row[id] and groups.id = groupid" );
                            foreach( $samplegroups as $sam )
                            {
                                echo( "<tr><td>Sample Group: $sam[Name]</td>" );
                                echo ("<td> &nbsp;&nbsp;&nbsp;Associated Song: &nbsp;&nbsp;" );
                                echo( "<select name='ssarg[{$sam[groupid]}]'><option value=''></option>" );
                                foreach( $samples as $ssrow )
                                {
                                    $sel = $sam[songsampleid] == $ssrow[samplesongid]?"SELECTED":"";
                                    echo( "<option $sel value='$ssrow[samplesongid]'>$ssrow[Name]</option>" );
                                }
                                echo( "</select>" );
                                echo ("</td></tr>" );
                                
                            }
                            
                            ?>
<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "samples" ); return false;'>Reset all values</a></td></tr>

</table>
</div>
<? } ?>

<div id='tabs-firstsection'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>First Section </th></tr>
  <?=outputReadOnlyRow( "First Section", $songsections[$row["FirstSection"]][Name] )?>
  <?=outputTextareaRow( "First Section Description", "fsdescription", $row[FirstSectionDescription], 40, 10 )?>
<!-- inputs go here-->
<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "firstsection" ); return false;'>Reset all values</a></td></tr>

</table>
</div>

<div id='tabs-sections'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='10'>Section Start and End Points </th></tr>
<? 
foreach( $currssvals as $crow )
  {
    $srow = $songsections[$crow[songsectionid]];
?>    
    <?=outputSongSectionTimeRow( "$srow[Name]", "$srow[id]", $currssvals[$srow["id"]] )?>
<?    
      }
foreach( $songsections as $srow )
  {
    if( isset( $currssvals[$srow[id]] ))
      continue;
?>    
    <?=outputSongSectionTimeRow( "$srow[Name]", "$srow[id]", $currssvals[$srow["id"]] )?>
<?    
      }
?>
<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "sections" ); return false;'>Reset all values</a></td></tr>
</table>
</div>
<div id='tabs-techniques'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
  <tr><th colspan='2'>Techniques</th></tr>
<tr><td colspan='2' bgcolor='#aaffff'>
<table border=1 cellpadding=2 cellspacing=0 bgcolor='#ffffff'>
    <tr><th>Technique  (TO DELETE TECHNIQUE, CLEAR VALUE FROM DROP DOWN)</th><th>Inactive?</th><th>Category/Sub-Category/Sub-Sub-Category</th><th>Enter a Description of How the Technique Is Used</th><th>Sections</th><th>URLs</th></tr>
<? 
  $vocalexamples = db_query_rows( "Select * from song_to_technique where songid = '$songid'" ); 
for( $i = 0; $i < 1; $i++ )
  {
    $vocalexamples[] = array();
  }
$num = 0;
foreach($vocalexamples as $verow ) 
  {
    outputTechniqueRow( $num, $verow );
    $num++;
  }
?>
</table>
</td></tr>

<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "hooks" ); return false;'>Reset all values</a></td></tr>

</table>
</div>
<div id='tabs-newdata'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>New Data</th></tr>
  <?=outputReadOnlyRow( "Overall Repetitiveness", $row[OverallRepetitiveness] )?>
  <?=outputReadOnlyRow( "New Word Interval", $row[NewWordInterval] )?>
  <?=outputReadOnlyRow( "Consonance Alliteration Score", $row[ConsonanceAlliterationScore] )?>
  <?=outputReadOnlyRow( "Assonance Alliteration Score", $row[AssonanceAlliterationScore] )?>

<?=outputReadOnlyRow( "FirstChorusTimeIntoSong", $row["FirstChorusTimeIntoSong"] )?>
<?=outputReadOnlyRow( "MainMelodicRange", $row["MainMelodicRange"] )?>
<?=outputReadOnlyRow( "PercentDiatonicChords", $row["PercentDiatonicChords"] )?>
<?=outputReadOnlyRow( "UniqueChordRichness", $row["UniqueChordRichness"] )?>
<?=outputReadOnlyRow( "TriadChordRichness", $row["TriadChordRichness"] )?>
<?=outputReadOnlyRow( "IsModeMixture", $row["IsModeMixture"] )?>
<?=outputReadOnlyRow( "IsTonalParallelMixture", $row["IsTonalParallelMixture"] )?>
<?=outputReadOnlyRow( "VocalsPitchPrevalence", $row["VocalsPitchPrevalence"] )?>
<?=outputReadOnlyRow( "AmountOfDistinctParts", $row["AmountOfDistinctParts"] )?>
<?=outputReadOnlyRow( "InvertedChordPrevalance", $row["InvertedChordPrevalance"] )?>
<?=outputReadOnlyRow( "SeptachordPrevalance", $row["SeptachordPrevalance"] )?>
<?=outputReadOnlyRow( "Major7thPrevalance", $row["Major7thPrevalance"] )?>
<?=outputReadOnlyRow( "Timbre", $row["Timbre"] )?>
<?=outputReadOnlyRow( "WordsRepetitionPrevalence", $row["WordsRepetitionPrevalence"] )?>
<?=outputReadOnlyRow( "LineRepetitionPrevalence", $row["LineRepetitionPrevalence"] )?>
<?=outputReadOnlyRow( "SlangWords", $row["SlangWords"] )?>
<?=outputReadOnlyRow( "ThousandWordsPrevalence", $row["ThousandWordsPrevalence"] )?>
<?=outputReadOnlyRow( "TenThousandWordsPrevalence", $row["TenThousandWordsPrevalence"] )?>
<?=outputReadOnlyRow( "FiftyThousandWordsPrevalence", $row["FiftyThousandWordsPrevalence"] )?>
<?=outputReadOnlyRow( "PercentAbbreviations", $row["PercentAbbreviations"] )?>
<?=outputReadOnlyRow( "PercentNonDictionary", $row["PercentNonDictionary"] )?>
<?=outputReadOnlyRow( "PercentNonProfanity", $row["PercentNonProfanity"] )?>
<?=outputReadOnlyRow( "RhymeDensity", $row["RhymeDensity"] )?>
<?=outputReadOnlyRow( "RhymesPerSyllable", $row["RhymesPerSyllable"] )?>
<?=outputReadOnlyRow( "RhymesPerLine", $row["RhymesPerLine"] )?>
<?=outputReadOnlyRow( "NumberOfRhymeGroupsELR", $row["NumberOfRhymeGroupsELR"] )?>
<?=outputReadOnlyRow( "VocalsInstrumentsPrevalence", $row["VocalsInstrumentsPrevalence"] )?>
<?=outputReadOnlyRow( "AverageIntroLength", $row["AverageIntroLength"] )?>
<?=outputReadOnlyRow( "UseOfAPreChorus", $row["UseOfAPreChorus"] )?>
<?=outputReadOnlyRow( "UseOfAVocalPostChorus", $row["UseOfAVocalPostChorus"] )?>
<?=outputReadOnlyRow( "VocalPostChorusCount", $row["VocalPostChorusCount"] )?>
<?=outputReadOnlyRow( "UseOfABridge", $row["UseOfABridge"] )?>
<?=outputReadOnlyRow( "HarmonicRhythm", $row["HarmonicRhythm"] )?>
<?=outputReadOnlyRow( "PersonReferences", $row["PersonReferences"] )?>
<?=outputReadOnlyRow( "LocationReferences", $row["LocationReferences"] )?>
<?=outputReadOnlyRow( "OrganizationorBrandReferences", $row["OrganizationorBrandReferences"] )?>
<?=outputReadOnlyRow( "ConsumerGoodsReferences", $row["ConsumerGoodsReferences"] )?>
<?=outputReadOnlyRow( "CreativeWorksTitles", $row["CreativeWorksTitles"] )?>
<?=outputReadOnlyRow( "DetailedExperiencesvsAbstract", $row["DetailedExperiencesvsAbstract"] )?>
<?=outputReadOnlyRow( "EndLinePerfectRhymesPercentage", $row["EndLinePerfectRhymesPercentage"] )?>
<?=outputReadOnlyRow( "EndLineSecondaryPerfectRhymesPercentage", $row["EndLineSecondaryPerfectRhymesPercentage"] )?>
<?=outputReadOnlyRow( "EndLineAssonanceRhymePercentage", $row["EndLineAssonanceRhymePercentage"] )?>
<?=outputReadOnlyRow( "PerfectRhymesPercentage", $row["PerfectRhymesPercentage"] )?>
<?=outputReadOnlyRow( "AssonanceRhymePercentage", $row["AssonanceRhymePercentage"] )?>
<?=outputReadOnlyRow( "ConsonanceRhymePercentage", $row["ConsonanceRhymePercentage"] )?>
<?=outputReadOnlyRow( "EndOfLineRhymesPercentage", $row["EndOfLineRhymesPercentage"] )?>
<?=outputReadOnlyRow( "MidLineRhymesPercentage", $row["MidLineRhymesPercentage"] )?>
<?=outputReadOnlyRow( "InternalRhymesPercentage", $row["InternalRhymesPercentage"] )?>
<?=outputReadOnlyRow( "MidWordRhymes", $row["MidWordRhymes"] )?>
<?=outputReadOnlyRow( "AmountDividedByLength", $row["AmountDividedByLength"] )?>
<?=outputReadOnlyRow( "WordsPerLineAvg", $row["WordsPerLineAvg"] )?>
<?=outputReadOnlyRow( "ChordDegreePrevalence", $row["ChordDegreePrevalence"] )?>
<?=outputReadOnlyRow( "MelodicThemeRepetitions", $row["MelodicThemeRepetitions"] )?>


</table>
</div>
<div id='tabs-autocalc'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>AUTO CALC FIELDS</th></tr>
  <?=outputReadOnlyRow( "Quarter Entered The Top 10", $row[QuarterEnteredTheTop10] )?>
  <?=outputReadOnlyRow( "Year Entered The Top 10", $row[YearEnteredTheTop10] )?>
  <?=outputReadOnlyRow( "Entry Position", $row[EntryPosition] )?>
  <?=outputReadOnlyRow( "Number of Weeks Spent in the Top 10", $row[NumberOfWeeksSpentInTheTop10] )?>
  <?=outputReadOnlyRow( "Peak Position", $row[PeakPosition] )?>
  <?=outputReadOnlyRow( "Last Section", $songsections[$row["LastSectionID"]][Name] )?>
  <?=outputReadOnlyRow( "Song Length Range", $row["SongLengthRange"] )?>
  <?=outputReadOnlyRow( "Intro Length Range", $row["IntroLengthRange"] )?>
  <?=outputReadOnlyRow( "First Chorus Percent Into Song", $row["FirstChorusPercent"] )?>
  <?=outputReadOnlyRow( "First Chorus Percent Into Song Range", $row["FirstChorusPercentRange"] )?>
  <?=outputReadOnlyRow( "First Chorus Range", $row["FirstChorusDescr"] )?>
  <?=outputReadOnlyRow( "Outro Length Range", $row["OutroRange"] )?>
  <?=outputReadOnlyRow( "Chorus Precedes Verse?", $row["ChorusPrecedesVerse"]?"Yes":"No" )?>



</table>
</div>

<div id='tabs-charts'>
<table style='width: 400px'><tr><th>Chart</th><th>Peak Position</th></tr>
<? 
$thesecharts = db_query_rows( " select min( peakpos ) as peakpos, chart from billboardinfo where songid = $songid group by chart" ); 

foreach( $thesecharts as $trow )
{
echo( "<tr><td>$trow[chart]</td><td>$trow[peakpos]</td></tr>" );
}

?>
</table>
</div>
  <? foreach( $splitupsongsections as $without=>$ssrows ) { 
  $shortname = strtolower( $without );
  $shortname = str_replace( " ", "", $shortname );
?>

<div id='tabs-<?=$shortname?>'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'><?=$without?> </th></tr>
<!-- inputs go here-->
  <? if( $without == "Intro" ) { ?>
  <?=outputOtherTableCheckboxes( "Intro Type", "introtypes", $row[id], "introtypes" )?>
  <?=outputSelectRow( "Vocal Vs Instrumental", 'introvocalvsinst', $row["IntroVocalVsInst"], getEnumValues( "IntroVocalVsInst" ) )?>
  <?=outputTextareaRow( "Intro Characteristics", "introdescr", $row[IntroDescr], 40, 5 )?>
				 <? } ?>

  <? if( $without == "Outro" ) { ?>
  <?=outputSelectRow( "Vocal Vs Instrumental", 'OutroVocalVsInst', $row["OutroVocalVsInst"], getEnumValues( "OutroVocalVsInst" ) )?>
  <?=outputSelectRow( "Recycled Vs New Material", 'OutroRecycled', $row["OutroRecycled"], getEnumValues( "OutroRecycled" ) )?>
 <?=outputSetMultipleRow( "RecycledSections", 'RecycledSections', $row["RecycledSections"], getSetValues( "RecycledSections" ) ) ?>
  <?=outputOtherTableCheckboxes( "Outro Types", "outrotypes", $row[id], "outrotypes" )?>
  <?=outputTextareaRow( "Description", "OutroCharacteristicsDescr", $row[OutroCharacteristicsDescr], 40, 5 )?>
				 <? } ?>

  <? if( count( $ssrows ) > 1 ) { 
    foreach( $ssrows as $ssrow ) { 
      $songsectionid = $ssrow["songsectionid"];
      break; 
    }
    

?>
 <?=outputSetMultipleRow( "$without to $without Vocal Melody Comparison", "VMComparison[{$songsectionid}]", $ssrow["VMComparison"], getSetValues( "VMComparison", "song_to_songsection" ) ) ?>
 <?=outputTextareaRow( "Description ", "VMComparisonDescription[{$songsectionid}]", $ssrow["VMComparisonDescription"], 40, 5 )?>

 <?=outputSetMultipleRow( "$without to $without Backing Melody Comparison", "BMComparison[{$songsectionid}]", $ssrow["BMComparison"], getSetValues( "BMComparison", "song_to_songsection" ) ) ?>
 <?=outputTextareaRow( "Description ", "BMComparisonDescription[{$songsectionid}]", $ssrow["BMComparisonDescription"], 40, 5 )?>

								     <? } ?>


  <? $ten = array(); for( $i = 1; $i <= 10; $i++ ) { $ten[$i]= $i; } ?>
  <? 
  $curr = 0;
foreach( $ssrows as $ssrow ) { 
  $curr++;
    $songsectionid = $ssrow["songsectionid"];
    $sectionname = $songsections[$songsectionid]["Name"];
    $sectiontime = removeHours( $ssrow["starttime"] ). " - " . removeHours( $ssrow["endtime"] );
    ?>
    <? if( count( $ssrows ) > 1 ) { ?>
<tr><th colspan='2'><?=$sectionname?> <?=$sectiontime?></th></tr>
	   <? } ?>
           <? if( $without != "Intro" && $without != "Outro" && $without != "Bridge" ) { ?>           
  <?=outputOtherTableCheckboxes( "$sectionname Type", "chorustypes", $row[id], "chorustypes", false, "$songsectionid" )?>
                      <? } ?>
           <? if( $without == "Bridge" ) { ?>           
  <?=outputOtherTableCheckboxes( "$sectionname Characteristics", "bridgecharacteristics", $row[id], "bridgecharacteristics", false, "$songsectionid" )?>
                      <? } ?>
  <?=outputTextareaRow( "Stanzas: {$ssrow[Stanzas]}<br>Details", "StanzaDetails[{$songsectionid}]", $ssrow["StanzaDetails"], 40, 5 )?>
       <? $notrtd = true; ?>
<tr <?=outputBackgroundColor()?>><td colspan='2'><table border=1 cellpadding=1 cellspacing=0>
<tr><td>
    <?=outputSetMultipleRow( "Lead Vocal Gender", "vocalsgender[{$songsectionid}]", $ssrow["VocalsGender"], getSetValues( "VocalsGender", "song_to_songsection" ) )?>
</td><td>
    <?=outputSetMultipleRow( "Lyrical P.O.V.", "lyricalpov[{$songsectionid}]", $ssrow["PrimaryNarrative"], getSetValues( "PrimaryNarrative", "song_to_songsection" ) )?>
</td></tr>
<tR><td>
     <?=outputOtherTableCheckboxes( "Lead Vocals", "vocals", $row[id], "vocals", false, "$songsectionid" );    ?>
     <?//=outputSetMultipleRow( "Lead Vocals", "vocals[{$songsectionid}]", $ssrow["Vocals"], getSetValues( "Vocals", "song_to_songsection" ) )?>
</td><td>
     <?=outputOtherTableCheckboxes( "Lead Vocal Types", "vocaltypes", $row[id], "vocaltypes", false, "$songsectionid" );    ?>
</td></tr>
<tR><td>
      <?=outputOtherTableCheckboxes( "Background Vocals", "backvocals", $row[id], "backvocals", false, "$songsectionid" );    ?>
      <?//=outputSetMultipleRow( "Background Vocals", "bgvocals[{$songsectionid}]", $ssrow["BackgroundVocals"], getSetValues( "BackgroundVocals", "song_to_songsection" ) )?>
</td><td>
      <?=outputOtherTableCheckboxes( "Background Vocal Types", "backvocaltypes", $row[id], "backvocaltypes", false, "$songsectionid" );    ?>
</td></tr>
</table>
</td></tr>
       <? $notrtd = false; ?>
  <?=outputTextareaRow( "Vocal Type Details/Examples ", "vtdetails[{$songsectionid}]", $ssrow["VocalTypeDetails"], 20, 5 )?>

<?								     if( 1 == 0 ) {  ?>
<tr><td colspan='2'><br><b>Vocal Examples</b><br>
<table class="content" border=1 cellpadding=2 cellspacing=0 bgcolor='#ffffff'>
  <tr><th>Vocal Example Type</th><th>Sample (CLEAR VALUE TO REMOVE)</th><th>Vocal Example Section(s)</th></tr>
<? 
  $vocalexamples = db_query_rows( "Select * from song_to_vocalexample where songid = '$songid' and songsectionid = $songsectionid" ); 
for( $i = 0; $i < 3; $i++ )
  {
    $vocalexamples[] = array();
  }
$num = 0;
foreach($vocalexamples as $verow ) 
  {
    outputVocalExampleRow( $num, $verow, $songsectionid );
    $num++;
  }
?>
</table>
</tr></tr>
										     <? } ?>
				 <? if( $without == "Inst Break" ) { ?>
<!-- THIS IS INSTRUMENTAL BREAK-->
	<?=outputOtherTableCheckboxes( "Dominant Instrument", "instruments", $row[id], "instruments", false, $songsectionid )?>

										  <? } ?>

       <?=outputOtherTableCheckboxes( "Sub-Genres", "subgenres", $row[id], "subgenres", false, "$songsectionid" )?>
	    <? // =outputOtherTableCheckboxes( "World Sub-Genres", "worldsubgenres", $row[id], "worldsubgenres", false, $songsectionid )?>
	    <? //=outputOtherTableCheckboxes( "Rock Sub-Genres", "rocksubgenres", $row[id], "rocksubgenres", false, $songsectionid )?>
	    <?//=outputOtherTableCheckboxes( "Retro Influences", "retroinfluences", $row[id], "retroinfluences", false, $songsectionid  )?>
       <?=outputTextareaRow( "Sub-Genre Details ", "sgdetails[{$songsectionid}]", $ssrow["SubgenreDetails"], 40, 5 )?>

				 <? if( $without == "Chorus" ) { ?>
								 <?=outputSetMultipleRow( "Transition Method Into " . $songsections[$songsectionid]["Name"], 'TransitionIntoChorus[{$songsectionid}]', $ssrow["TransitionIntoChorus"], getSetValues( "TransitionIntoChorus", "song_to_songsection" ) )?>
       <?=outputTextareaRow( "Transition Details ", "TransitionDetails[{$songsectionid}]", $ssrow["TransitionDetails"], 40, 5 )?>

								 <? } ?>
	    <? if( $songsectionid != $row["FirstSection"] ) { ?>
<?=outputSelectRow( "MTI Relative to Preceding Section", "MTI[{$songsectionid}]", $ssrow["MTI"], getEnumValues( "MTI", "song_to_songsection" ) ) ?>
 <?=outputTextareaRow( "Description ", "MTIDescription[{$songsectionid}]", $ssrow["MTIDescription"], 20, 5 )?>
		   <? } ?>

				 <? if( $without != "Inst Break" && $songsectionid != $row["FirstSection"] ) { ?>
 <?=outputSetMultipleRow( "Vocal Melody - Relative to Preceding Section", "PSVMComparison[{$songsectionid}]", $ssrow["PSVMComparison"], getSetValues( "PSVMComparison", "song_to_songsection" ) ) ?>
 <?=outputTextareaRow( "Description ", "PSVMComparisonDescription[{$songsectionid}]", $ssrow["PSVMComparisonDescription"], 40, 5 )?>

<?=outputSetMultipleRow( "Backing Melody - Relative to Preceding Section", "PSBMComparison[{$songsectionid}]", $ssrow["PSBMComparison"], getSetValues( "PSBMComparison", "song_to_songsection" ) ) ?>
 <?=outputTextareaRow( "Description ", "PSBMComparisonDescription[{$songsectionid}]", $ssrow["PSBMComparisonDescription"], 40, 5 )?>
								     <? }?>
  <?=outputOtherTableCheckboxes( "Primary Instrumentations", "primaryinstrumentations", $row[id], "primaryinstrumentations", false, $songsectionid )?>
      <?=outputTextareaRow( "Instrumentation Details ", "pinstr[{$songsectionid}]", $ssrow["PrimaryInstrumentation"], 40, 5 )?>
     <? if( $songsectionid == $row["LastSectionID"] ) { ?>
<tr><th colspan='2'>Ending</th></tr>
  <?=outputOtherTableCheckboxes( "Ending Types", "endingtypes", $row[id], "endingtypes" )?>
 <?=outputTextareaRow( "Ending Details", "EndingDetails", $ssrow["EndingDetails"], 40, 5 )?>

						      <? } ?>

	 <tR><td colspan='2'><br></td></tr>

  <? } ?>

<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "<?=$shortname?>" ); return false;'>Reset all values</a></td></tr>

</table>
</div>

  <? } ?>

<div id='tabs-notused'>
<table class="content" border=1 cellpadding=2 cellspacing=0>
<tr><th colspan='2'>NOT USED </th></tr>
  <?=outputSelectRow( "Background Vocals?", 'bv', $row["BackgroundVocals"], $yesno, 120 )?>
  <?//=outputOtherTableCheckboxes( "Chorus Structures", "chorusstructures", $row[id], "chorusstructures", true )?>

  <?=outputSelectRow( "Dominant Instrument", 'dominst', $row["DominantInstrument"], getEnumValues( "DominantInstrument" ) )?>
  <?=outputSelectRow( "Mix Type", 'mixtype', $row["MixType"], getEnumValues( "MixType" ) )?>
  <?=outputInputRow( "Song Form", "songform", $row[SongForm], 40 )?>
  <?=outputSelectRow( "Intro Type", 'introtype', $row["IntroType"], getEnumValues( "IntroType" ) )?>
  <?=outputSelectRow( "Chorus Kickoff Type", 'ckt', $row["ChorusKickoffType"], getEnumValues( "ChorusKickoffType" ) )?>
  <?=outputSelectRow( "V1-V2 Backing Comparison", 'vbc', $row["V1V2BackingComparison"], getEnumValues( "V1V2BackingComparison" ) )?>
  <?=outputTextareaRow( "V1-V2 Backing Comments", 'vbcomm', $row["V1V2BackingComments"] )?>
  <?=outputSelectRow( "V1-V2 Melody Comparison", 'vmc', $row["V1V2MelodyComparison"], getEnumValues( "V1V2MelodyComparison" ) )?>
  <?=outputTextareaRow( "V1-V2 Melody Comments", 'vmcomm', $row["V1V2MelodyComments"] )?>
  <?=outputSelectRow( "Pre-Chorus MTI", 'pcmti', $row["PreChorusMTI"], getEnumValues( "PreChorusMTI" ) )?>
  <?=outputTextareaRow( "Pre-Chorus MTI Comments", 'pcmticomm', $row["PreChorusMTIComments"] )?>
  <?=outputSelectRow( "Verse Pre-Chorus Backing Music", 'vpcbm', $row["VersePreChorusBackingMusic"], getEnumValues( "VersePreChorusBackingMusic" ) )?>
  <?=outputTextareaRow( "Verse Pre-Chorus Backing Music Comments", 'vpcbmcomm', $row["VersePreChorusBackingMusicComments"] )?>
  <?=outputSelectRow( "Simple Repetitive Chorus?", 'src', $row["SimpleRepetitiveChorus"], $yesno, 120 )?>
  <?=outputSelectRow( "Bridge Surrounding Area MTI", 'bsamti', $row["BridgeSurroundingAreaMTI"], getEnumValues( "BridgeSurroundingAreaMTI" ) )?>
  <?=outputSelectRow( "Bridge Placement", 'bp', $row["BridgePlacement"], getEnumValues( "BridgePlacement" ) )?>
  <?=outputSelectRow( "Instrumental Break Type", 'ibt', $row["InstrumentalBreakType"], getEnumValues( "InstrumentalBreakType" ) )?>
  <?=outputSelectRow( "Outro Type", 'outrotype', $row["OutroType"], getEnumValues( "OutroType" ) )?>
  <?=outputTextareaRow( "Outro Type Comments", 'otcomm', $row["OutroTypeComments"] )?>
  <?=outputTextareaRow( "Composition", 'composition', $row["Composition"] )?>

<tr><td colspan='2'><a href='#' onClick='javascript:resetAll( "notused" ); return false;'>Reset all values</a></td></tr>
</table>
</div>
</div>
<input type='hidden' name='songid' value='<?=$row[id]?>' id="songid">
<input type='submit' name='update' value='Update'><br><br>


<script>

    var availableTagsArtist = [
                         <? $arr = db_query_rows( "select * from artists" );
                         foreach( $arr as $row ) { echo( "\"" . htmlentities( $row[Name] )."\", "); } ?>
			 ];

    var availableTagsLabel = [
                         <? $arr = db_query_rows( "select * from labels" );
                         foreach( $arr as $row ) { echo( "\"$row[Name]\", "); } ?>
			 ];

    var availableTagsImprint = [
                         <? $arr = db_query_rows( "select * from imprints" );
                         foreach( $arr as $row ) { echo( "\"$row[Name]\", "); } ?>
			 ];

    var availableTagsProducer = [
                         <? $arr = db_query_rows( "select * from producers" );
                         foreach( $arr as $row ) { echo( "\"$row[Name]\", "); } ?>
			 ];

    var availableTagsSongnames = [
                         <? $arr = db_query_rows( "select * from songnames" );
                         foreach( $arr as $row ) { echo( "\"$row[Name]\", "); } ?>
			 ];

    var availableTagsGroup = [
                         <? $arr = db_query_rows( "select * from groups" );
                         foreach( $arr as $row ) { echo( "\"$row[Name]\", "); } ?>
			 ];
    var availableTagsDates = [
                         <? $arr = db_query_rows( "select * from weekdates" );
                         foreach( $arr as $row ) { echo( "\"$row[Name]\", "); } ?>
			 ];
    var availableTagsSampleSongs = [
                         <? $arr = db_query_rows( "select * from samplesongs" );
                         foreach( $arr as $row ) { echo( "\"$row[Name]\", "); } ?>
			 ];
<? foreach( $refreshdivs as $r )
     {

?>
       refreshDiv( "<?=$r["table"]?>", "<?=$r["fieldname"]?>", "<?=$r["type"]?>" );
<?	 
     } 
?>



$( document ).ready(function() {
	$('.selectmultiple').multipleSelect({
		width: 240, 
		onClick: function( view )
		    {
			exp = view.value.split( "_" );
			updateTechniqueSongSections(document.getElementById( "techniquesongsections" + exp[0] ), exp[0] ); 
		    }
	    }
	    );
	if( typeof availableTagsArtist != "undefined" )
	    {
		$(function() {
			<? foreach( array( "creditedsongwriter1", "creditedsongwriter2", "creditedsongwriter3", "creditedsongwriter4", "creditedsongwriter5" ) as $sid ) { ?>
			$( "#autosuggest<?=$sid?>" ).autocomplete({
				source: availableTagsArtist
				    });
			<? } ?>
			    
		      <? foreach( array( "primary", "featured", "uncredited", "sample", "creditedsw", "samplesw" ) as $sid ) { ?>
			$( "#autosuggest<?=$sid?>artistids" ).autocomplete({
				source: availableTagsArtist
				    }).keydown(function(e){
					    if (e.keyCode === 13){
						addValue( "<?=$sid?>artistids", "artists", "<?=$sid?>" ); 
						return false;
					    }
					});
			<? } ?>
		    });
	    }
	if( typeof availableTagsProducer != "undefined" )
	    {
		$(function() {
			$( "#autosuggestwritingproduction" ).autocomplete({
				source: availableTagsProducer
				    }).keydown(function(e){
					    if (e.keyCode === 13){
						addValue( "writingproduction", "producers", "" ); 
					    }
					});
		    });
	    }
	if( typeof availableTagsSongnames != "undefined" )
	    {
		$(function() {
			<? foreach( array( "songnameid" ) as $sid ) { ?>
			$( "#autosuggest<?=$sid?>" ).autocomplete({
				source: availableTagsSongnames
				    });
			<? } ?>
			    
		    });
	    }
	if( typeof availableTagsLabel != "undefined" )
	    {
		$(function() {
			$( "#autosuggestlabelids" ).autocomplete({
				source: availableTagsLabel
				    }).keydown(function(e){
					    if (e.keyCode === 13){
						addValue( "labelids", "labels", "" ); 
					    }
					});
		    });
	    }
	if( typeof availableTagsImprint != "undefined" )
	    {
		$(function() {
			$( "#autosuggestimprints" ).autocomplete({
				source: availableTagsImprint
				    }).keydown(function(e){
					    if (e.keyCode === 13){
						addValue( "imprints", "imprints", "" ); 
					    }
					});
			    
		    });
	    }
	if( typeof availableTagsSampleSongs != "undefined" )
	    {
		$(function() {
			$( "#autosuggestsamplesongs" ).autocomplete({
				source: availableTagsSampleSongs
				    }).keydown(function(e){
					    if (e.keyCode === 13){
						addValue( "samplesongs", "samplesongs", "" ); 
					    }
					});
			    
		    });
	    }
	if( typeof availableTagsDates != "undefined" )
	    {
		$(function() {
		    <? for( $i = 1; $i <= 10; $i++   ) { ?>
			$( "#autosuggestposition<?=$i?>" ).autocomplete({
				source: availableTagsDates
				    });
			<? } ?>
			    
		    });
	    }
	if( typeof availableTagsGroup != "undefined" )
	    {
		$(function() {
			$( "#autosuggestprimarygroupids" ).autocomplete({
				source: availableTagsGroup
				    }).keydown(function(e){
					    if (e.keyCode === 13){
						addValue( "primarygroupids", "groups", "primary" ); 
					    }
					});
			$( "#autosuggestfeaturedgroupids" ).autocomplete({
				source: availableTagsGroup
				    }).keydown(function(e){
					    if (e.keyCode === 13){
						addValue( "featuredgroupids", "groups", "featured" ); 
					    }
					});
			$( "#autosuggestsamplegroupids" ).autocomplete({
				source: availableTagsGroup
				    }).keydown(function(e){
					    if (e.keyCode === 13){
						addValue( "samplegroupids", "groups", "sample" ); 
					    }
					});
			$( "#autosuggestuncreditedgroupids" ).autocomplete({
				source: availableTagsGroup
				    }).keydown(function(e){
					    if (e.keyCode === 13){
						addValue( "uncreditedgroupids", "groups", "uncredited" ); 
					    }
					});
		    });
	    }
	$(function() {
	    $( "#tabs" ).tabs();
	  });
    } );

function updateOtherT( num )
{
    val = $("#thetech" + num ).val();

//     ele = $("#ttype" + num );
//     $.ajax({
//     url : "filltechniquetypes.php",
//     type: "GET",
//     data : "techniqueid=" + val + "&num=" + num,
//     success: function(data, textStatus, jqXHR)
//     {
//             //data - response from server
// 	ele.html( data );

//     },
//     error: function (jqXHR, textStatus, errorThrown)
//     {
// //    alert( "error" ); 
//     }


// 	} );


    ele2 = $("#tcategory" + num );
    $.ajax({
    url : "filltechniquecategories.php",
    type: "GET",
    data : "techniqueid=" + val + "&num=" + num,
    success: function(data, textStatus, jqXHR)
    {
            //data - response from server
	ele2.html( data );

	    $("#techniquesubcategories" + num )
	    .find('option')
		.remove()
		.end()
		.append('<option value="">Please Choose</option>');
	    $("#techniquesubsubcategories" + num )
	    .find('option')
		.remove()
		.end()
		.append('<option value="">Please Choose</option>');


    },
    error: function (jqXHR, textStatus, errorThrown)
    {
//    alert( "error" ); 
    }


	} );


}

function updateOtherTSub( ele, num, subval )
{
    val = ele.options[ele.selectedIndex].value;
    subcatval = subval + "category";
    subval += "sub";
    
    ele2 = $("#t" + subval + "category" + num );
    $.ajax({
	    url : "filltechniquecategories.php",
		type: "GET",
		data : "techniqueid=" + val + "&num=" + num + "&sub=" + subval + "&subcat=" + subcatval,
		success: function(data, textStatus, jqXHR)
		{
		    //data - response from server
		    ele2.html( data );
		    
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
		    //    alert( "error" ); 
		}
	} );
    if( subval > "" )
	{
	    // do nothing
	}
    else
	{
	    $("#techniquesubcategories" + num )
	    .find('option')
		.remove()
		.end()
		.append('<option value="">Please Choose</option>');

	}
}

function updateTechniqueSongSections( ele, num )
{
    //    alert( "doing it" );
    $("#techniquesongsections" + num + " > option").each( function() { 
	    //	    alert( "hmm" + $(this).val()+ ": " + $(this).is( ":selected" ) );
	if( $(this).is( ":selected" ) )
	    {
		$("#techss_" + $(this).val() ).css( "display", "" );
	    }
	else
	    {
		$("#techss_" + $(this).val() ).css( "display", "none" );
	    }
	} );
    

}



</script>

</font><? include "footer.php"; ?>
