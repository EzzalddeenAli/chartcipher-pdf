<? 
$nologin = 1;
ini_set('auto_detect_line_endings',TRUE);
ini_set('memory_limit','1024M');

include "connect.php";

include "nav.php";

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
