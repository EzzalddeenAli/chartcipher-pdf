<? 
$nologin = 1;
ini_set('auto_detect_line_endings',TRUE);
ini_set('memory_limit','1024M');

include "connect.php";

include "nav.php";

db_query( "delete from song_to_influencegroup" );
$allinfluencegroups = db_query_array( "Select id from influencegroups", "id", "id" );
foreach( $allinfluencegroups as $aid )
{
	$res = db_query_array( "select songid from song_to_influence sti, influences i where i.id = influenceid and influencegroupid = $aid", "songid", "songid" );
	foreach( $res as $r )
	{
		db_query( "insert into song_to_influencegroup ( songid, influencegroupid ) values ( '$r', '$aid' )" );
	}
}

//     $des = db_query_rows( "describe songs" );
// foreach( $des as $srow )
// {
//     file_put_contents( "songtable", $srow[Field] . " -- $srow[Type]\n", FILE_APPEND );
// }
// exit;

    function addOtherTableToSong( $songid, $colname, $table, $type = "" )
{
    $subs = explode( ",", getRawData( $colname ) );
    db_query( "delete from song_to_{$table} where songid = $songid" );
    foreach( $subs as $s )
	{
	    if( !trim( $s ) ) continue;
	    if( strtolower( $s ) == "null" ) continue; 
	    $newid = getOrCreate( $table . "s", trim( $s ) );
	    if( !$newid ) 
		{
		    echo( "no $table matching $s<br>" );
		}
	    else
		{
		    if( $type )
			db_query( "insert into song_to_{$table} ( songid, {$table}id, type ) values ( $songid, $newid, '$type' )" );
		    else
			db_query( "insert into song_to_{$table} ( songid, {$table}id ) values ( $songid, $newid )" );
		}
	}
}


function getAutoCalcRange( $autocalcvalues, $songid, $newfield, $oldfield, $valuestring, $addpercent = "%", $replacements = array() )
{

    $fieldvalue = db_query_first_cell( "select $oldfield from songs where id = $songid" );
    $exp = explode( ",", $valuestring );
    foreach( $exp as $keynum=>$e )
	{
	    $e = trim( $e );
	    if( strpos( $e, "+" ) !== false )
		{
		    $lower = str_replace( "+", "", $e );
		    $upper = 10000000000;
		}
	    else
		{
		    $exp2 = explode( "-", $e );
		    if( !strlen( $exp2[1] )  )
			{
			    $lower = 0; 
			    $upper = $exp2[0];
			}
		    else
			{
			    $lower = $exp2[0];
			    $upper = $exp2[1];

			}
		}
	    //	    echo( "$lower ,  $upper  -- $fieldvalue<Br>" );
	    if( $fieldvalue < $upper && $fieldvalue >= $lower )
		{
		    $newfieldvalue = "";
		    if( $lower && $upper && $upper < 1000000000 )
			{
			    $newfieldvalue = "$lower{$addpercent} - $upper{$addpercent}" ;
			    if( count( $replacements ) && $replacements[$keynum] )
				{
				    $newfieldvalue = $replacements[$keynum];
				}
			}
		    else if( !$lower )
			{
			    $newfieldvalue = "Under $upper" . $addpercent ;
			    if( count( $replacements ) && $replacements[$keynum] )
				{
				    $newfieldvalue = $replacements[$keynum];
				}
			}
		    else
			{
			    $newfieldvalue = "Above $lower" . $addpercent;
			    if( count( $replacements ) && $replacements[$keynum] )
				{
				    $newfieldvalue = $replacements[$keynum];
				}
			}


		    //		    echo( "matched!<br>" );
		}
	}

    $autocalcvalues[$newfield] = $newfieldvalue;

    return $autocalcvalues;

}


function getData( $colname, $ispercent = 0 )
{
    global $headerrow, $data;
    $val = $data[$headerrow[$colname]];
    if( $ispercent )
	$val = $val * 100;
    if( $val > 100 && $ispercent )
	{
	    file_put_contents( "alllines.txt", "percent error for $colname : $val\n", FILE_APPEND );
	    $val = 100;
	}
    return getNull( $val );
}
function getYesNoData( $colname )
{
    global $headerrow, $data;
    $val = $data[$headerrow[$colname]];
    return getYesNoNull( $val );
}
function getTimeData( $colname )
{
    global $headerrow, $data;
    $val = getRawData($colname);

    if( strpos( $val, "o"  ) !== false )
	return "NULL";
    if( strpos( $val, "N" ) !== false )
	return "NULL";
    
    if( $val ) { 
	$exp = explode( ":", $val );
	if( count( $exp ) < 3 && $val )
	    {
		$val = "'00:{$val}'";
	    }
	else if( $val )
	    {
		$val = "'{$val}'";
	    }
    }
    else
	$val = "NULL";
    return $val;

}
    function getRawData( $colname )
{
    global $headerrow, $data;
    $val = $data[$headerrow[$colname]];
    return $val;
}

if( $gosongs )
    {
//ob_start();
	$started = false;
	$count = 0;
	if( $delexistingsongs )
	    {
	    db_query( "delete from songs" );
	    db_query( "delete from song_to_weekdate" );
	    db_query( "delete from song_to_subgenre" );
	    db_query( "delete from song_to_influence" );
	    db_query( "delete from song_to_lyricaltheme" );
	    db_query( "delete from song_to_lyricalsubtheme" );
	    db_query( "delete from song_to_lyricalmood" );
	    db_query( "delete from song_to_songkey" );
	    db_query( "delete from song_to_chart" );
	    db_query( "delete from song_to_primaryinstrumentation" );
	    }
	$path = "ccsongs.csv";
	$tmppath = $_FILES["uploadsongs"]["tmp_name"];
	file_put_contents( "alreadyexisted.txt", "" );
	file_put_contents( "nobillboardmatch.txt", "" );
	file_put_contents( "alllines.txt", "" );
	$alreadynum = 0;
	$billboardnum = 0;
	
	if( $tmppath )
	    {
		move_uploaded_file( $tmppath, $path );
	    }
	    if( $delexistingsongs )
	    	    $alreadysongs = array();
	    if (($handle = fopen($path, "r")) !== FALSE) 
		{
		$tmpnumsongs = 0;
		    while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
			echo("starting a line $data[0]<br>" );
			file_put_contents( "alllines.txt", "starting a line $data[0]\n" , FILE_APPEND );
			file_put_contents( "ccloaddata", "begin $data[0]\n" );
			if( $data[1] && !$started )
			    {
				$headerrow = array();
				foreach( $data as $did=>$dval )
				    {
					$headerrow[trim( $dval )] = $did;
				    }
				$started = true;
				//				file_put_contents( "ccloadheaders", print_r( $headerrow, true  ) );
				continue;
			    }
			$key = strtolower( $data[0] . "-" . $data[1] );
			file_put_contents( "alllines.txt", "starting a key $key\n" , FILE_APPEND );
			if( $alreadysongs[$key] )
			    {
				echo( "this song already existed $key" );
				file_put_contents( "alllines.txt", "this song already existed $key\n" , FILE_APPEND );
				file_put_contents( "alreadyexisted.txt", "this song already existed $key\n", FILE_APPEND );
				$alreadynum++;
				continue;
			    }
			$alreadysongs[$key] = 1;
			file_put_contents( "alllines.txt", "after already $key\n" , FILE_APPEND );
			file_put_contents( "ccloaddata", print_r( $data, true ), FILE_APPEND );
			include "loadermiddle.php";
			$tmpnumsongs++;
			// if( $data[1] == 10 )
			//     break;
		    }
		}

    db_query( "update songs set SongLengthRange = 'Under 3:00' where SongLength < '00:03:00' " );
    db_query( "update songs set SongLengthRange = '3:00 - 3:29' where SongLength >= '00:03:00' and SongLength < '00:03:30'  " );
    db_query( "update songs set SongLengthRange = '3:30 - 3:59' where SongLength >= '00:03:30' and SongLength < '00:04:00'  " );
    db_query( "update songs set SongLengthRange = '4:00 +' where SongLength >= '00:04:00'  " );

    db_query( "update songs set IntroLengthRange = 'No Intro' where IntroLength is null and   id = '$songid'");
    db_query( "update songs set IntroLengthRange = 'Short' where IntroLength >= '00:00:01' and IntroLength < '00:00:10'  " );
    db_query( "update songs set IntroLengthRange = 'Moderately Short' where IntroLength >= '00:00:10' and IntroLength < '00:00:20' " );
    db_query( "update songs set IntroLengthRange = 'Moderately Long' where IntroLength >= '00:00:20' and IntroLength < '00:00:30'  " );
    db_query( "update songs set IntroLengthRange = 'Long' where IntroLength >= '00:00:30' " );


// SongTitleAppearanceRange

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
    db_query( "update songs set SongTitleAppearanceRange = '$t' where SongTitleAppearances >= '$et[0]' and SongTitleAppearances <= '$et[1]' " );
  }


db_query( "update songs set IntroLengthRangeNums = '' where IntroLength is null ");

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
    db_query( "update songs set IntroLengthRangeNums = '$t' where IntroLength >= '$et[0]' and IntroLength < '$et[1]' " );
  }


db_query( "update songs set OutroLengthRangeNums = '' where OutroLength is null");

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
    db_query( "update songs set OutroLengthRangeNums = '$t' where OutroLength >= '$et[0]' and OutroLength < '$et[1]' " );
  }



// TempoRange
$i = 0; 
while( $i < 400 )
  {
    $endi = $i + 9;
    $t = "$i - $endi";
	db_query( "update songs set TempoRange = '$t' where Tempo >= '$i' and Tempo <= '$endi' " );
    $i+= 10;
  }

db_query( "update songs set TempoRangeGeneral = 'Under 79' where Tempo <= 79 and Tempo > 0 " );
db_query( "update songs set TempoRangeGeneral = '80-99' where Tempo >= 80 and Tempo < 100  " );

db_query( "update songs set TempoRangeGeneral = '100-119' where Tempo >= 100 and Tempo < 120  " );

db_query( "update songs set TempoRangeGeneral = '120-139' where Tempo >= 120  and Tempo < 140" );

db_query( "update songs set TempoRangeGeneral = '140+' where Tempo >= 140  " );

db_query( "update songs set TempoRangeGeneral = null where (Tempo = 0 or Tempo is null) " );
db_query( "update songs set MajorMinor = 'Major' where SpecificMajorMinor in ( 'Major', 'Lydian', 'Mixolydian', 'Pentatonic' ) " );
db_query( "update songs set MajorMinor = 'Minor' where SpecificMajorMinor not in ( 'Major', 'Lydian', 'Mixolydian', 'Pentatonic' ) " );


 $outrolength = db_query_first_cell( "update songs set OutroRange = 'No Outro' where time_to_sec( OutroLength ) = 0"  );
 $outrolength = db_query_first_cell( "update songs set OutroRange = 'Short' where time_to_sec( OutroLength ) > 0 "  );
 $outrolength = db_query_first_cell( "update songs set OutroRange = 'Moderately Short' where time_to_sec( OutroLength ) >= 10 "  );
 $outrolength = db_query_first_cell( "update songs set OutroRange = 'Moderately Long' where time_to_sec( OutroLength ) >= 20 "  );
 $outrolength = db_query_first_cell( "update songs set OutroRange = 'Long' where time_to_sec( OutroLength ) >= 30"  );


db_query( "delete from song_to_influencegroup" );
$allinfluencegroups = db_query_array( "Select id from influencegroups", "id", "id" );
foreach( $allinfluencegroups as $aid )
{
	$res = db_query_array( "select songid from song_to_influence sti, influences i where i.id = influenceid and influencegroupid = $aid", "songid", "songid" );
	foreach( $res as $r )
	{
		db_query( "insert into song_to_influencegroup ( songid, influencegroupid ) values ( '$r', '$aid' )" );
	}
}

		db_query( "update songs set ProfanityRange = 'None' where PercentProfanity = 0" );
		include "loadbillboardchartdata.php";
//$err =ob_get_contents(); 
//$err .= "<br> $tmpnumsongs " . ( $delexistingsongs?"added.":"updated." );
		$err .= "$tmpnumsongs added.<Br>";
		$err .= "$alreadynum duplicates.<Br>";
		$err .= "$billboardnum didn't match billboard.<Br>";
		$err .= "<a href='nobillboardmatch.txt' target='_blank'>billboard no matches</a><Br>";
		$err .= "<a href='alreadyexisted.txt' target='_blank'>dupes</a><Br>";
		$err .= "<a href='alllines.txt' target='_blank'>all lines (including data errors)</a><Br>";
		$err .= "<a href='loadbb1.txt' target='_blank'>latest billboard info</a><Br>";
//		mail( "rachelc@gmail.com", "Chart Cipher Import", $err, "From: info@analytics.chartcipher.com" );
//		mail( "yael@hitsongsdeconstructed.com", "Chart Cipher Import", $err, "From: info@analytics.chartcipher.com" );
		$headers = array();
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		$headers[] = "From: info@analytics.chartcipher.com";
		
		mail( "sivan@mypart.com, yael@hitsongsdeconstructed.com, rachelc@gmail.com", "Chart Cipher Import", $err, implode("\r\n", $headers));
//ob_end_clean();
    }


if( $gosongsshort )
    {
	$started = false;
	$count = 0;
	$path = "ccsongs.csv";
	    if (($handle = fopen($path, "r")) !== FALSE) 
		{
		    while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) {
			echo( "starting a line $data[0]<br>" );
			if( $data[1] && !$started )
			    {
				$headerrow = array();
				foreach( $data as $did=>$dval )
				    {
					$headerrow[trim( $dval )] = $did;
				    }
				$started = true;
				//				file_put_contents( "ccloadheaders", print_r( $headerrow, true  ) );
				continue;
			    }
			include "loadermiddleshort.php";
		    }
		}
    }



//include "nav.php";
?>
<form method='post' enctype='multipart/form-data'>

<br><br>                                                                                                                                                     <h3>Upload Songs</h3>
    File: (csv format ONLY) <input type='file' name='uploadsongs'> <br>
<br><br>
<table style="width:500px"><tr><td>
Update Data:</td><td> <input type='radio' name='delexistingsongs' value='0' <?=isset( $_POST["delexistingsongs"] ) && !$_POST["delexistingsongs"] ?"CHECKED":""?> style="width: 15px">	
</td></tr>
<tr><td>****OR****</td></tr>
<tr><td>   Delete Existing Data:</td><td> <input type='radio' name='delexistingsongs'  <?=!isset( $_POST["delexistingsongs"] ) || $_POST["delexistingsongs"]?"CHECKED":""?> value='1' style="width: 15px"></td></tr>
     <tr><td>
<input type='submit' name='gosongs' value='Go'>
</td></tr></table>
<br><Br>
<?=$err?>
<br>

<h3>From Last Import</h3>
<i>This is all songs that were imported</i><br>
<a href='alllines.txt' target='_blank'>all lines (including data errors)</a> -- last modified  <?=date ("m/d/Y H:i:s", filemtime("alllines.txt"))?><Br>
<br>
<b>Errors in Data</b><br>
<a href='nobillboardmatch.txt' target='_blank'>billboard no matches</a> -- last modified <?=date ("m/d/Y H:i:s", filemtime("nobillboardmatch.txt"))?><Br>
<a href='alreadyexisted.txt' target='_blank'>dupes</a> -- last modified  <?=date ("m/d/Y H:i:s", filemtime("alreadyexisted.txt"))?><Br>
<br><i>Songs are imported, then billboard data is pulled. This is the result of the billboard data pull</i><br>
<a href='loadbb1.txt' target='_blank'>latest billboard info</a> -- last modified  <?=date ("m/d/Y H:i:s", filemtime("loadbb1.txt"))?><Br>



<br><input type='submit' name='gosongsshort' value='TESTING'>


                                                                                                                                                     </form>
<? include "footer.php"; ?>
