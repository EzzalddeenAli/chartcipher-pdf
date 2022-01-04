<? 
include "connect.php";
include "../functions.php";
 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

 $res = db_query_rows( "select * from songs where clientid = 4" );

if( $export )
{
    require_once "Spreadsheet/Excel/Writer.php";
    $xls = new Spreadsheet_Excel_Writer();
    $filename = "Muzology.xls";
    $xls->send( $filename );

    $songsections = db_query_rows( "select * from songsections", "id" );


foreach( $res as $songrow )
{
    $cu = getSongnameFromSongid( $songrow[id] );
    //    $cu = str_replace( "-", "_", $cu );
    $cu = str_replace( "_", "", $cu );
    $cu = substr( $cu, 0, 31 );
    $sheet =& $xls->addWorksheet($cu);
    //    echo( $sheet );

    $rownum = 0; $colnum = 0;

    $cols = array();
    $cols[] = array( "Song ID", ( $songrow[id]  ) );
    $cols[] = array( "Song Name", getSongnameFromSongid( $songrow[id]  ) );
    $cols[] = array( "Genre", getNameById( "genres", $songrow["GenreID"] ) );
    $cols[] = array( "Client", getNameById( "clients", $songrow["ClientID"] ) );
    $ts = array();
    foreach( array( "timesignatureid", "timesignatureid2", "timesignatureid3" ) as $colname )
	{
	    if( $songrow[$colname] )
		$ts[] = getNameById( "timesignatures", $songrow[$colname] );
	}

    $cols[] = array( "Time Signature", implode( "; ", $ts ) );
    $a = db_query_array( "select Name from songkeys, song_to_songkey where type = 'Major' and songid = '$songrow[id]' and songkeys.id = songkeyid", "Name", "Name" );
    $cols[] = array_merge( array( "Major Key(s)" ), $a );
    $a = db_query_array( "select Name from songkeys, song_to_songkey where type = 'Minor' and songid = '$songrow[id]' and songkeys.id = songkeyid", "Name", "Name" );
    $cols[] = array_merge( array( "Minor Key(s)" ), $a );
    $cols[] = array( "Tempo", $songrow["Tempo"]  );
    $cols[] = array( "Song Length", removeHours( $songrow["SongLength"] ) );
    $cols[] = array( "Vocals", $songrow["VocalsGender"] );
    $cols[] = array( "Full Form", $songrow["SongStructure"] );


    $a = db_query_array( "select Name from subgenres, song_to_subgenre where songid = '$songrow[id]' and subgenres.id = subgenreid", "Name", "Name" );
    $cols[] = array_merge( array( "Sub-Genres" ), $a );

    $cols[] = array( "Electronic Vs Acoustic", $songrow["ElectricVsAcoustic"]  );

    $a = db_query_array( "select Name from primaryinstrumentations, song_to_primaryinstrumentation where songid = '$songrow[id]' and primaryinstrumentations.id = primaryinstrumentationid", "Name", "Name" );
    $cols[] = array_merge( array( "Prominent Instrumentation" ), $a );

$cols[] = array("");

  $curr++;
  $ssrows = db_query_rows( "select * from song_to_songsection where songid = $songrow[id] order by starttime" );
  foreach( $ssrows as $ssrow )
      {
	  $songsectionid = $ssrow["songsectionid"];
	  $sectionname = $songsections[$songsectionid]["Name"];
	  $cols[] = array( $sectionname );
	  $cols[] = array( "Start and End Times", $ssrow["starttime"], $ssrow["endtime"] );
	  $cols[] = array( "Length" , $ssrow["length"] );
	  $cols[] = array( "Number Of Bars", $ssrow["Bars"] );
	  //	  $cols[] = array( "Stanzas", $ssrow["Stanzas"] );
	  //	  $cols[] = array( "Is Post-Chorus" , $ssrow["PostChorus"]?"Yes":"No" );
	  //	  $cols[] = array( "Is Bridge Surrogate?" , $ssrow["BridgeSurrogate"]?"Yes":"No" );
	  $cols[] = array_merge( array( "Vocal Gender" ), explode( ",", $ssrow["VocalsGender"] ) );
	  $cols[] = array_merge( array( "Lead Vocals" ), explode( ",", $ssrow["VocalsHard"] ) );
	  if( $ssrow["WithoutNumberHard"] == "Intro")
	      {
		  $a = db_query_array( "select Name from introtypes, song_to_introtype where songid = '$songrow[id]' and introtypes.id = introtypeid", "Name", "Name" );
		  $cols[] = array_merge( array( "Intro Characteristics" ), $a );
		  
		  $cols[] = array( "Intro Vocal Vs Instrumental", $songrow["IntroVocalVsInst"] );
	      }


	  if( $ssrow["WithoutNumberHard"] == "Inst Break")
	      {
		  $a = db_query_array( "select Name from instruments, song_to_instrument where songid = '$songrow[id]' and instruments.id = instrumentid and type = '$songsectionid'", "Name", "Name" );
		  $cols[] = array_merge( array( "Instruments" ), $a );
	      }
	  if( $ssrow["PostChorus"] )
	      {
		  $a = db_query_array( "select Name from postchorustypes, song_to_postchorustype where songid = '$songrow[id]' and postchorustypes.id = postchorustypeid and type = '$songsectionid'", "Name", "Name" );
		  $cols[] = array_merge( array( "Post-Chorus Types" ), $a );
	      }
	  if( $ssrow["WithoutNumberHard"] == "Outro" )
	      {
		  //		  $cols[] = array( "Ending Details" , $songrow["EndingDetails"] );
		  $cols[] = array_merge( array( "Recycled Vs New Material" ), explode( ",", $songrow["OutroRecycled"] ) );
		  $cols[] = array_merge( array( "Recycled Sections" ), explode( ",", $songrow["RecycledSections"] ) );

	      }
	  if( $songsectionid == $songrow["LastSectionID"] )
	      {
		  $a = db_query_array( "select Name from endingtypes, song_to_endingtype where songid = '$songrow[id]' and endingtypes.id = endingtypeid", "Name", "Name" );
		  $cols[] = array_merge( array( "Ending Types" ), $a );
	      }

	  $cols[] = array("");
      }



    foreach( $cols as $crow )
	{
	    $colnum = 0;
	    foreach( $crow as $c )
		$sheet->write( $rownum, $colnum++, $c );
	    $rownum++;
	}
}    

    $xls->close();
    exit;
}

include "nav.php";
?>

<form method='post'>
<input type='submit' name='export' value='Export'>
</form>

