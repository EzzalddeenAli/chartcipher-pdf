<? 
$nologin = 1;
ini_set('auto_detect_line_endings',TRUE);
ini_set('memory_limit','1024M');
include "../header.php"; 


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
	    echo( "percent error for $colname : $val<br>" );
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

    if( strlen( $val ) )
	{
	    $val = "'00:{$val}'";
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
ob_start();
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
	if( $tmppath )
	    {
		move_uploaded_file( $tmppath, $path );
	    }

	    if (($handle = fopen($path, "r")) !== FALSE) 
		{
		$tmpnumsongs = 0;
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
						file_put_contents( "ccloaddata", print_r( $data, true ) );
			include "loadermiddle.php";
			$tmpnumsongs++;
			// if( $data[1] == 10 )
			//     break;
		    }
		}
		include "loadbillboardchartdata.php";
$err =ob_get_contents(); 
$err .= "<br> $tmpnumsongs " . ( $delexistingsongs?"added.":"updated." );
ob_end_clean();
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
	<div class="site-body index-pro ">
        <section class="home-top">
			<div class="element-container row">
<form method='post' enctype='multipart/form-data'>

<br><br>                                                                                                                                                     <h3>Upload Songs</h3>
    File: (csv format ONLY) <input type='file' name='uploadsongs'> <br>
<br><br>
Update Data: <input type='radio' name='delexistingsongs' value='0' <?=isset( $_POST["delexistingsongs"] ) && !$_POST["delexistingsongs"] ?"CHECKED":""?> style="display: inline">	
<br>****OR****
<br>   Delete Existing Data: <input type='radio' name='delexistingsongs'  <?=!isset( $_POST["delexistingsongs"] ) || $_POST["delexistingsongs"]?"CHECKED":""?> value='1' style="display: inline">
<br>
<br><input type='submit' name='gosongs' value='Go'>
<br><Br>
<?=$err?>

<br><input type='submit' name='gosongsshort' value='TESTING'>


                                                                                                                                                     </form>
</div>
</section></div>
<? include "../footer.php"; ?>
