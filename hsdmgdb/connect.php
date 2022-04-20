<?php
session_start();
ini_set( 'error_reporting', E_ALL & ~E_DEPRECATED & ~E_WARNING & ~E_NOTICE );
//print_r( $_SESSION );
// start trying session timeout
$time = $_SERVER['REQUEST_TIME'];

/**
 * for a 30 minute timeout, specified in seconds
 */
$timeout_duration = 60*12*60; // seconds * minutes * hours

/**
 * Here we look for the user's LAST_ACTIVITY timestamp. If
 * it's set and indicates our $timeout_duration has passed,
 * blow away any previous $_SESSION data and start a new one.
 */
if (isset($_SESSION['LAST_ACTIVITY']) && 
    ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    session_start();
}

/**
 * Finally, update LAST_ACTIVITY so that our timeout
 * is based on it and not the user's login time.
 */
$_SESSION['LAST_ACTIVITY'] = $time;
// start trying session timeout


//print_r( $_SERVER );exit;
function isDev() { 
    if( $_SERVER["SERVER_NAME"] == "devanalytics.chartcipher.com"  )
	return true;
    return false;
}
$earliestq = "1";


if( $_SESSION["isadminlogin"] )
{
	$earliesty = "2010";
} 

$reportsdbname = "eccipher_wp";

$clientwhere = "1 = 1";

if( !$_SESSION["chartid"] )
{
	$_SESSION["chartid"] = 37; // hot-100
}

if( $_GET["setchart"] && intval( $_GET["setchart"] ) )
{
	$chartid = $_GET["setchart"] ;
	$_SESSION["chartid"] = $chartid;
	$setchart = $chartid;
}


$chartid = intval( $_SESSION["chartid"] );

if( !$chartid ) 
    $chartid = 37; 
$_SESSION["chartid"] = $chartid;

$setchart = $chartid;

// pop-songs
if( $setchart == 3 )
{
	$maxnumperchart = 40;
	$topmiddle = 20;
	$bottommiddle = 21;
}
else if( $setchart == 37 )
{
$maxnumperchart = 100;
$topmiddle = 25;
$bottommiddle = 75;
}
else // everything else
{
	$maxnumperchart = 50;
	$topmiddle = 25;
	$bottommiddle = 26;
}


$clientwhere .= " and find_in_set( $chartid, chartids )";

$GLOBALS["clientwhere"] = $clientwhere;

$mainsections = array();
$mainsections["Intro"] = "Intro";
$mainsections["Verse"] = "Verse";
$mainsections["Pre-Chorus"] = "Pre-Chorus";
$mainsections["Chorus"] = "Chorus";
$mainsections["Bridge"] = "Bridge";
$mainsections["Vocal Break"] = "Vocal Break";
$mainsections["Inst Break"] = "Instrumental Break";
$mainsections["Outro"] = "Outro";

$yesno = array( "1"=>"Yes", "-1"=>"No" );
$yesno0 = array( "1"=>"Yes", "0"=>"No" );



// good stuff here
extract( $_POST );
extract( $_GET );


$GLOBALS["isclientsearch"] = false;
$tmp = $search[peakchart];
if( strpos( $tmp, "client-" ) !== false  || $clientfilter )
{
    $GLOBALS["isclientsearch"] = true;
}

// mysql> grant all privileges on hsdsongs_admin.* to hsdsongs_admin@localhost identified by 'jd239jd32fs';
@include_once "dbconfig.php";
@include_once "../dbconfig.php";

//echo( isRachel() );
if( !$nologin ) 
  {
    //if( $password == "hsdmg@DBP@$$w0rd"|| isRachel() )
      if( $username || isRachel() )
	  {
	      $res = db_query_first( "select id, isadmin from users where username = '$username' and password = '$password'" ); 
	      if( isRachel() ) 
	      	      $res = db_query_first( "select id, isadmin from users where username = 'ypenn'" ); 

	      if( $res[id])
		  {
		      $_SESSION["loggedin"] = $res[id];
		      $_SESSION["isadminlogin"] = $res[isadmin];
		  }
	      else
		  {
		      $err = "Invalid Login.";
		  }
	  }
      if( !$_SESSION["loggedin"] )
	  {
?>
<form method='post'>
<font color='red'><?=$err?></font>
<table>
      <tr><td>Username:</td><td><input type='username' name='username'></td></tr>
      <tr><td>Password:</td><td><input type='password' name='password'></td></tr>
      <tr><td></td><td><input type='submit' value='Log In'></td></tr>
</table>
</form>
<?  
      exit;
  }
  }
$earliesty = db_query_first_cell( "select min( YearEnteredTheTop10 ) from song_to_chart where chartid = $chartid" );

if( $earliesty < 2010 ) $earliesty = "2010";


if( $_GET["logqueries"] )
    file_put_contents( "/tmp/querylog", "" );
$startlogtime = time();
$mysql_count = 0;
$numlogqueries= 0 ;
function db_query( $sql )
{
    global $mysql_count, $startlogtime,  $dblink,$numlogqueries ;
  $mysql_count++;
  if($_GET["logqueries"] )
  {
      $tm = time() - $startlogtime;
      $numlogqueries ++ ; 
      file_put_contents( "/tmp/querylog", $numlogqueries . ". " . $tm . ": " . $sql . "\n" , FILE_APPEND );
  }
  $qstr = "";
  $exp = explode( " ", $sql );
  if( $exp[0] == "update" )
  {
      $qstr .= "<br><br>alter table songs add $exp[3] decimal( 12, 10 ); <br>";
      $qstr .= "<br>alter table songs add $exp[3] varchar( 255 ); <br>";
      $qstr .= "<br>alter table songs add $exp[3] tinyint; <br>";
  }
  
  $result = mysqli_query( $dblink, $sql ) or killme( $dblink, $sql . $qstr );
  return $result;
}



function killme( $dblink, $sql )
{
	file_put_contents( "killme", $sql );
	file_put_contents( "killme", mysqli_error( $dblink ) . " is the err", FILE_APPEND );
	die( $sql );
}


function db_query_first( $sql )
{   
  global $fetchtype;
  $result = db_query( $sql );
  return mysqli_fetch_array( $result );
}

function db_query_first_cell( $sql )
{
  $arr = db_query_first( $sql );
  if( is_array( $arr ) )
    return array_pop( $arr );
}

function db_query_insert_id( $sql )
{   
global $dblink;
  $result = db_query( $sql );
  return mysqli_insert_id( $dblink);
}

function db_query_rows( $sql, $column = "")
{   
  $result = db_query( $sql );
  $arr = array();
  while( $row = mysqli_fetch_array( $result ) )
    {   
      if( $column )
	$arr[ $row[$column] ] = $row;
            else
	      $arr[] = $row;
    }
  return $arr;
}

function db_query_array( $sql, $column = "0", $column2 = "1" )
{   
  $result = db_query( $sql );
  $arr = array();
  while( $row = mysqli_fetch_array( $result ) )
    {   
      $arr[ $row[$column] ] = $row[$column2];
    }
  return $arr;
}

function outputSelectValues( $values, $chosen = "" )
{
	foreach( $values as $id=>$val )
    {
        if( is_array( $chosen ) )
        {
            $sel = in_array( $id, $chosen )?"SELECTED":"  ";
        }
        else
        {
            $sel = $chosen == $id?"SELECTED":" ";
        }
        echo( "<option value='$id' $sel>$val</option>\n" );
    }
}

function getLiveCharts() 
{
return db_query_array( "select chartkey, chartname from charts where IsLive = 1", "chartkey", "chartname" );
}

function getClients() 
{
return db_query_array( "select Name, id from clients", "id", "Name" );
}

function getSetting( $name ) 
{
return db_query_first_cell( "select value from settings where name = '$name'" );
}

function getLiveChartsDbStr() 
{
return implode( ", " , array_values( db_query_array( "select concat( \"'\", chartkey, \"'\" ) as chartkey from charts where IsLive = 1", "chartkey", "chartkey" ) ) );
}


function outputInputRow( $title, $name, $val, $size=40, $ext="" )
{

  echo( "  <tr " . outputBackgroundColor() . "><td>$title: </td><td><input type='text' size='$size' name='$name' value=\"$val\">{$ext}</td></tr>" );

}
function outputFileRow( $title, $name, $val, $extrastr = "" )
{

  echo( "  <tr " . outputBackgroundColor() . "><td>$title: </td><td><input type='file' name='$name' >" );
  if( $val )
  {
      echo( "<br><a a href='$val'>$val</a><br> <input type='checkbox' name='clear{$name}' value='1'> Clear Value</a>" );
  }
  echo( $extrastr );
  echo( "</td></tr>" );

}

function outputTextareaRow( $title, $name, $val, $cols = 40, $rows = 10 )
{

  echo( "  <tr " . outputBackgroundColor() . "><td>$title:</td><td><textarea cols='$cols' rows='$rows' name='$name'>$val</textarea></td></tr>" );

}

function escMe( $str )
{
global $dblink;
return mysqli_real_escape_string( $dblink, $str );
}

function getNull( $val )
{
    if( strlen( $val ) ) 
      return "'". escMe( $val )."'";
  return "NULL";
}

function getYesNoNull( $val )
{
    if( strlen( $val ) ) 
	{
	    if( $val == "Yes" ) $val = 1;
	    if( $val == "No" ) $val = 0;

	    return "'". escMe( $val )."'";
	}
  return "NULL";
}

function getSetNull( $val )
{
  //  print_r( $val );
  if( is_array( $val ) && count( $val ) )
  {
      return "'" . escMe( implode( ",",  $val ) ). "'";
  }
  return "NULL";
}

$cachedenumvalues = array();
function getEnumValues( $field, $table = 'songs' )
  {
      global $cachedenumvalues;
      if( $cachedenumvalues[$field] ) return $cachedenumvalues[$field] ;
    $type = db_query_first( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" );
    $type = $type["Type"];
    preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
    $enum = explode("','", $matches[1]);
    $arr = array();
    foreach( $enum as $e )
      {
	  if( $e )
	      $arr[$e] = $e; 
      }
    $cachedenumvalues[$field] = $arr;
    return $arr;
  }
function getSetValues( $field, $table = 'songs' )
  {
    $type = db_query_first( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" );
    $type = $type["Type"];
    preg_match("/^set\(\'(.*)\'\)$/", $type, $matches);
    $enum = explode("','", $matches[1]);
    $arr = array();
    foreach( $enum as $e )
      {
	  if( $e )
	      $arr[$e] = $e; 
      }
    return $arr;
  }

function outputOtherTableSelect( $title, $name, $val, $othertablename )
{
  $possiblevals = db_query_array( "select id, Name from $othertablename order by OrderBy desc, Name", "id", "Name" );

  
  outputSelectRow( $title, $name, $val, $possiblevals );
}

$bgc = "";
function outputBackgroundColor() 
{
    global $bgc, $overbgc;
    if( $overbgc ) return $overbgc;
  if( !$bgc )
    {
      $bgc = "bgcolor='#dddddd'";
    }
else
  $bgc = "";

  return( $bgc );   
}

function outputOtherTableCheckboxes( $title, $name, $entryid, $othertablename, $addnew = false, $type = "", $fromtype = "song" )
{
  global $notrtd; 
  $possiblevals = db_query_array( "select id, Name from $othertablename order by OrderBy desc, Name", "id", "Name" );
if( !$notrtd )
      echo( "  <tr " . outputBackgroundColor(). "><td>$title: </td><td>" ); 
      else
      echo( $title . ": " );

      $shorttablename = substr($othertablename, 0, -1);
      if( $type ) $typestr = " and type = '$type'";
      $myvals = db_query_array( "select {$shorttablename}id from {$fromtype}_to_{$shorttablename} where {$fromtype}id = $entryid $typestr", "{$shorttablename}id", "{$shorttablename}id" );
      
      $count = 0;
      $onethird = ceil( count($possiblevals)/3 ) ;
      $twothird = ceil( 2*count($possiblevals)/3 );
      echo( "<table id=\"table_$name\"><tr><td valign='top'>\n" );
      if( $type ) $typeext = "[{$type}]";
      foreach( $possiblevals as $id=> $val )
	{
	  $checked = in_array( $id, $myvals )?"CHECKED":"";
	  echo( "<input type='checkbox' name='{$name}{$typeext}[{$id}]' value='1' $checked> $val &nbsp; &nbsp; &nbsp;<br>" );
	  $count++;
	  if( $count == $onethird || $count == $twothird )
	    {
	      $t = $count == $onethird?"middle":"second";
	    echo( "</td>\n<td valign='top' id=\"{$t}_$name\">" );
	    }
	}
      if( count( $possiblevals ) < 2 )
	{
	  echo( "</td><td valign='top' id=\"middle_$name\">" );
	}
      else if( count( $possiblevals ) < 3 )
	{
	  echo( "</td>\n<td valign='top' id=\"second_$name\">" );
	}
      echo( "</td>\n</tr></table>" ); 
      if( $addnew )
	{
	  echo("<a href='#' onClick='javascript:doAddNew(\"$name\", \"{$title}\"); return false;'>add new</a>" );
	}
if( !$notrtd )
      echo( "</td></tr>\n" );
}

function outputSetMultipleRow( $title, $name, $val, $possiblevals )
{
  global $notrtd; 

  if( $notrtd ) { echo( "<table>" );  }
  echo( "  <tr " ); 
  if( !$notrtd ) echo outputBackgroundColor(); 
  echo( "><td>$title: </td>" );
  if( $notrtd )
    echo( "</tr><tr>" );

  echo( "<td>" ); 

  $myvals = explode( ",", $val );
      
      $count = 0;
      $onethird = ceil( count($possiblevals)/3 ) ;
      $twothird = ceil( 2*count($possiblevals)/3 );
      echo( "<table><tr><td valign='top'>\n" );
      foreach( $possiblevals as $id=> $val )
	{
	  $checked = in_array( $id, $myvals )?"CHECKED":"";
	  echo( "<input type='checkbox' name='{$name}[]' value=\"$val\" $checked> $val&nbsp;&nbsp;&nbsp;<br>\n" );
	  $count++;
	  if( $count == $onethird || $count == $twothird )
	    echo( "</td><td valign='top'>\n" );
	}
      echo( "</td></tr></table></td></tr>\n" );
  if( $notrtd )
    echo( "</table>" );
}

function outputSelectRow( $title, $name, $val, $possiblevals, $size="300px", $pleasechoose=true )
{
  global $notrtd; 

  // if not, let's put these on top of each other
  if( $notrtd ) { echo( "<table>" );  }

  echo( "  <tr " ); 
  if( !$notrtd ) echo outputBackgroundColor(); 
  echo( "><td>$title: </td>" );

  if( $notrtd )
    echo( "</tr><tr>" );
  echo( "<td>" );
  echo( "<select style=\"width:$size\" name='$name'>\n" ); 
  if( $pleasechoose )
    {
      echo( "<option value=''>Please Choose</option>\n" );
    }
  foreach( $possiblevals as $key=>$v )
    {
      $sel = $key==$val?"SELECTED":""; 
      echo( "<option value=\"$key\" $sel>$v</option>\n" );
    }

  echo( "</select> " );
  echo( "</td></tr>" );

  if( $notrtd )
    echo( "</table>" );

}

function getNullTime( $colname )
{
  //  print_r( $_POST );
  return "'00:". $_POST[$colname. "min"] . ":" . $_POST[$colname. "sec"] . "'";
}
function getNullTimeSSID( $ssid, $colname )
{
  //  print_r( $_POST );
  return "'00:". $_POST["songsect"][$ssid][$colname]["min"] . ":" . $_POST["songsect"][$ssid][$colname]["sec"] . "'";
}

function outputTimeRow( $title, $name, $val, $inputsonly = false, $extname = "" )
{
    if( !$inputsonly )
	echo( "  <tr " . outputBackgroundColor(). "><td>$title: </td><td>" );
    echo( "<select style=\"width:$size\" name='".$name."min{$extname}'>\n" ); 
  $possiblevals = array();
  for( $i = 0; $i < 30; $i++ )$possiblevals[str_pad($i, 2, "0", STR_PAD_LEFT)] = str_pad($i, 2, "0", STR_PAD_LEFT);
  if( $val )
    $val = strtotime( $val );
  else
    $val = strtotime( "1/1/2001 12:00:00" );
  foreach( $possiblevals as $key=>$v )
    {
      $sel = $key==date( "i", $val )?"SELECTED":""; 
      echo( "<option value=\"$key\" $sel>$v</option>\n" );
    }

  echo( "</select>: <select style=\"width:$size\" name='".$name."sec{$extname}'>\n" ); 
  $possiblevals = array();
  for( $i = 0; $i < 60; $i++ ) $possiblevals[str_pad($i, 2, "0", STR_PAD_LEFT)] = str_pad($i, 2, "0", STR_PAD_LEFT);

  foreach( $possiblevals as $key=>$v )
    {
      $sel = $key==date( "s", $val )?"SELECTED":""; 
      echo( "<option value=\"$key\" $sel>$v</option>\n" );
    }

  echo( "</select>" );
  if( !$inputsonly )
      echo( "</td></tr>" );

}
function outputSongSectionTimeRow( $title, $name, $val )
{
  echo( "  <tr " . outputBackgroundColor(). "><td>$title: </td><td>" );
  // start start section
  echo( "<select style=\"width:$size\" name='songsect[".$name."][start][min]'>\n" ); 
  echo( "<option value=''></option>" );
  $possiblevals = array();
  for( $i = 0; $i < 30; $i++ )$possiblevals[str_pad($i, 2, "0", STR_PAD_LEFT)] = str_pad($i, 2, "0", STR_PAD_LEFT);

  if( $val )
    $matchval = strtotime( $val["starttime"] );

  foreach( $possiblevals as $key=>$v )
    {
      $sel = $matchval && $key==date( "i", $matchval )?"SELECTED":""; 
      echo( "<option value=\"$key\" $sel>$v</option>\n" );
    }

  echo( "</select>: " );
  echo( "<select style=\"width:$size\" name='songsect[".$name."][start][sec]'>\n" ); 
  echo( "<option value=''></option>" );
  $possiblevals = array();
  for( $i = 0; $i < 60; $i++ ) $possiblevals[str_pad($i, 2, "0", STR_PAD_LEFT)] = str_pad($i, 2, "0", STR_PAD_LEFT);

  foreach( $possiblevals as $key=>$v )
    {
      $sel = $matchval && $key==date( "s", $matchval )?"SELECTED":""; 
      echo( "<option value=\"$key\" $sel>$v</option>\n" );
    }

  echo( "</select>" );
  // end start section
  // start end section
  echo( " to " );
  echo( "<select style=\"width:$size\" name='songsect[".$name."][end][min]'>\n" ); 
  echo( "<option value=''></option>" );
  $possiblevals = array();
  for( $i = 0; $i < 30; $i++ )$possiblevals[str_pad($i, 2, "0", STR_PAD_LEFT)] = str_pad($i, 2, "0", STR_PAD_LEFT);

  if( $val )
    $matchval = strtotime( $val["endtime"] );

  foreach( $possiblevals as $key=>$v )
    {
      $sel = $matchval && $key==date( "i", $matchval )?"SELECTED":""; 
      echo( "<option value=\"$key\" $sel>$v</option>\n" );
    }

  echo( "</select>: " );
  echo( "<select style=\"width:$size\" name='songsect[".$name."][end][sec]'>\n" ); 
  echo( "<option value=''></option>" );
  $possiblevals = array();
  for( $i = 0; $i < 60; $i++ ) $possiblevals[str_pad($i, 2, "0", STR_PAD_LEFT)] = str_pad($i, 2, "0", STR_PAD_LEFT);

  foreach( $possiblevals as $key=>$v )
    {
      $sel = $matchval && $key==date( "s", $matchval )?"SELECTED":""; 
      echo( "<option value=\"$key\" $sel>$v</option>\n" );
    }

  echo( "</select>\n" );
  // end end section

  if( $val )
    {
      echo( "<i>Current Section Length: $val[length]</i> ; " );
      echo( "<i>Current Section Percent: $val[sectionpercent]</i> ; " );
      echo( "<i>Current Section Count: $val[sectioncount]</i>" );
    }
  echo( "</td>" );
  echo( "<td>&nbsp;");
  echo( "<select name='stanzas[$name]' value='1'>" );
  for( $i = 0; $i <= 100; $i++ )
    {
      echo( "<option value='$i' " . ($val["Stanzas"]==$i?"SELECTED":""). ">" . ($i?"$i":"Choose" ). "</option>" );
    }
  echo( "</select>&nbsp; Stanzas" );
  echo( "&nbsp;</td>");
  echo( "<td>&nbsp;");
  echo( "<select name='bars[$name]' value='1'>" );
  for( $i = 0; $i <= 64; $i++ )
    {
      echo( "<option value='$i' " . ($val["Bars"]==$i?"SELECTED":""). ">" . ($i?"$i":"Choose" ). "</option>" );
    }
  echo( "</select>&nbsp; Number of Bars" );
  echo( "&nbsp;</td>");
  echo( "<td>&nbsp;");
  if( $name != INTRO )
    {
      echo( "<input type='checkbox' name='postchorus[$name]' value='1' ". ($val[PostChorus]?"CHECKED":"").">&nbsp; Post-Chorus?" );
    }
  echo( "&nbsp;</td>");
  echo( "<td>&nbsp;");
  if($name != OUTRO &&  $name != INTRO && strpos( $title, "Bridge" ) === false )
    {
      echo( "<input type='checkbox' name='bridgesurrogate[$name]' value='1' ". ($val[BridgeSurrogate]?"CHECKED":"").">&nbsp; Bridge Surrogate?" );
    }
  echo( "&nbsp;</td>");
  echo( "</tr>\n" );

}

function outputOtherTableAutofill( $title, $name, $entryid )
{
  global $refreshdivs, $singleautofillfields;
  $othertablename = $singleautofillfields[$name];

  $possiblevals = db_query_array( "select id, Name from $othertablename order by OrderBy desc, Name", "id", "Name" );
  echo( "  <tr " . outputBackgroundColor(). "><td>$title: </td><td>" ); 

  //  echo( "$title" );
  $displayvalue = $possiblevals[$entryid];
  /* if( !$displayvalue ) */
  /*   $displayvalue = $entryid; */
  echo( "<input type='text' name='$name' id='autosuggest$name' value=\"$displayvalue\" > " );
  echo( "</td></tr>" );
  //  echo( "<div id=\"{$name}_div\"></div>" );
}


function outputOtherTableAutofillMultiple( $title, $name, $entryid, $othertablename, $type = "" )
{
  global $refreshdivs;
  //  $possiblevals = db_query_array( "select id, Name from $othertablename order by OrderBy desc, Name", "id", "Name" );
  echo( "  <tr " . outputBackgroundColor(). "><td>$title: </td><td>" ); 

  //  $displayvalue = $possiblevals[$entryid];
  echo( "<input type='text' name='$name' id='autosuggest$name' value=\"$displayvalue\" > <input type='submit' name='go$name' onClick='addValue( \"{$name}\", \"{$othertablename}\", \"{$type}\" ); return false' value='Add'><br>" );

  $refreshdivs[]= array( "type"=>$type, "fieldname"=>$name, "table"=>$othertablename );
  echo( "<div id=\"{$name}_div\"></div>" );
  echo( "</td></tr>" );
}

function outputReadOnlyRow( $title, $val )
{
  echo( "  <tr " . outputBackgroundColor(). "><td>$title: </td><td> $val </td></tr>" ); 

}
$cache_songnames = array();

function getSongnameFromSongid( $songid )
{
  global $cache_songnames;
  if( !isset( $cache_songnames[$songid] ) ) 
    {
      $songrow = getSongRow( $songid );
      $cache_songnames[$songid] = $songrow[SongNameHard];
    }
  return $cache_songnames[$songid];
}

function getSongname( $songnameid )
{
  return db_query_first_cell( "select Name from songnames where id = $songnameid" );
}

$cachetv = array();
function getTableValue( $val, $table, $column = "Name" )
{
    global $cachetv;
    if( isset( $cachetv[$table][$val] ) ) return $cachetv[$table][$val];
    if( !$val ) return;
    $val = db_query_first_cell( "select $column from $table where id = $val" );
    $cachetv[$table][$val] = $val;
    return $val;
}

function findClean( $val )
{
    $val = str_replace( " ", "_", $val );
    $val = str_replace( "'", "", $val );
    $val = str_replace( "!", "", $val );
    $val = str_replace( "?", "", $val );
    $val = str_replace( "/", " ", $val );
    $val = str_replace( ",", "", $val );
    $val = str_replace( "&", "and", $val );
    $val = str_replace( "\"", "", $val );
    
    return $val;
}
function getGroups( $songid, $type = "primary" )
{
	return getCommaValues( $songid, "group", $type );
}


function getOrCreate( $tablename, $name, $namecolumn = "Name" )
{
    if( !$name )
        return 0;
  $res = db_query_first_cell( "select id from $tablename where {$namecolumn} = '". escMe( $name ). "'" );
  if( !$res )
    {
      $res = db_query_insert_id( "insert into $tablename ( {$namecolumn} ) values ( '". escMe( $name ). "' )" );
      if( $tablename == "artists"||$tablename == "groups"||$tablename == "members" )
          db_query( "update $tablename set datecreated = now() where id = $res" );
    }
  return $res; 
}

function getIdByName( $tablename, $name, $namecolumn = "Name", $secondcolumn = "", $secondvalue = "" )
{
  $ext = "";
  if( $secondcolumn )
    { 
      $ext = " and $secondcolumn = '" . escMe( $secondvalue ). "' ";
    }
//   echo( "select id from $tablename where $namecolumn = '". escMe( $name ). "' $ext" );
  $res = db_query_first_cell( "select id from $tablename where $namecolumn = '". escMe( $name ). "' $ext" );
  return $res; 
}

function getNameById( $tablename, $id, $namecolumn = "Name", $secondcolumn = "", $secondvalue = "" )
{
    global $frontendlinks, $frontendfieldname, $frontenduseid; 
    
  $ext = "";
  if( $secondcolumn )
    { 
      $ext = " and $secondcolumn = '" . escMe( $secondvalue ). "' ";
    }
  $res = db_query_first_cell( "select $namecolumn from $tablename where id = '". escMe( $id ). "' $ext" );

  if( $frontendlinks )
  {
      $key = $frontenduseid?$id:$res;
      $res = "<a href='" . getBaseAdvancedSearchUrl() . "&search[{$frontendfieldname}]=$key'>$res</a>";
  }
  return $res; 
}

function getBaseAdvancedSearchUrl()
{
    return "search-results.php?searchtype=Advanced";
}

function clearRelated( $table, $songid, $type = "" )
{
  $typestr = $type?" and type = '" . escMe( $type ). "'":"";
  db_query( "delete from song_to_{$table} where songid = $songid $typestr" );
}

function addAllRelated( $songid, $headerrow, $data, $lookfor, $table, $type = "" )
{
      foreach( $headerrow as $columnnumber=>$title )
	{
	  if( $title == $lookfor && $data[$columnnumber])
	    {
	      $aid = getOrCreate( "{$table}s", $data[$columnnumber] );
	      addRelatedToSong( "{$table}", $aid, $songid, $type );
	    }
	}
}

function addRelatedToSong( $table, $value, $songid, $type = "" )
{
  if( $type )
    {
      $typecol = ", type";
      $typestr = ", '". escMe( $type )."'";
    }
  $newid = db_query_insert_id( "insert into song_to_{$table} ( songid, {$table}id $typecol ) values ( '$songid', '$value' $typestr )" );
  return $newid;
}

function getImportValuesFromGroup( $twocolsname )
{
  global $data, $tworowsago, $headerrow; 
  $startcol = -1;
  $endcol = -1; 
  foreach( $tworowsago as $colid=>$coldispl )
    {
      if( $startcol > -1 && $endcol > -1 )
	break;
      if( $startcol > 0 && $coldispl )
	{
	  $endcol = $colid -1;
	}
      else if( $startcol == -1 && $coldispl == $twocolsname )
	{
	  $startcol = $colid;
	}
    }
  $retval = array();
  /* if( $twocolsname == "DUET/GROUP TYPE" ) */
  /*   echo( "cols to check: $startcol, $endcol<Br>" ); */
  for($i = $startcol; $i <= $endcol; $i++ )
    {
      if( $data[$i] )
	{
	  $retval[] = $headerrow[$i];
	}
    }
  return $retval;

}

function addSection( $songid, $data, $name, $ssname )
{
  global $cols; 
  // this was a column we have in the db but it's not in the spreadsheet
  if( !$cols[$ssname . " Start"] ) 
    {
//      echo( "didn't find any columns matching $ssname<br>" );
return;
    }
  $start = $data[$cols[$ssname . " Start"]];
  $end = $data[$cols[$ssname . " End"]];
  if( $start && $end )
    {
      $start = formatUploadTime( $start );
      $end = formatUploadTime( $end );
      $sectionid = db_query_first_cell( "select id from songsections where Name = '$name'" );
      $sql = "insert into song_to_songsection( songid, songsectionid, starttime, endtime ) values ( '$songid', '$sectionid', '$start', '$end' ) ";
      /* if( $songid == 2365 ) */
      /* 	echo( $sql . "<br>"); */
      db_query( $sql );
    }

}

function getWithoutNumber( $songsectionid )
{
    return db_query_first_cell( "select WithoutNumber from songsections where id = '$songsectionid'" );
}

function formatUploadTime( $sl )
{
  if( strlen( $sl ) == 4 )
    $sl = "00:0{$sl}";
  else 
    $sl = "00:{$sl}";
  return $sl;
}

$cachesongids = array();

function getQuarterTimes( $quarter, $year )
{
    if( !$quarter )
    {
        $startdate = strtotime( "01/01/$year 00:00:00" );
        $enddate = strtotime( "12/31/$year 23:59:59" );
    }
    if( $quarter == 1 )
    {
        $startdate = strtotime( "01/01/$year 00:00:00" );
        $enddate = strtotime( "04/01/$year 00:00:00" );
    }
    if( $quarter == 2 )
    {
        $startdate = strtotime( "04/01/$year 00:00:00" );
        $enddate = strtotime( "07/01/$year 00:00:00" );
    }
    if( $quarter == 3 )
    {
        $startdate = strtotime( "07/01/$year 00:00:00" );
        $enddate = strtotime( "10/01/$year 00:00:00" );
    }
    if( $quarter == 4 )
    {
        $startdate = strtotime( "10/01/$year  00:00:00" );
        $enddate = strtotime( "12/31/$year 23:59:59" );
    }
    return array( $startdate, $enddate );
}

function getQuarterEnteredTheTopTenString( $str , $season, $not = "" )
{
    if( strpos( $season, "," ) !== false )
	{
	    $exp = explode( "/", $str );
	    $quarters = $exp[0];
	    $year = $exp[1];
	    
	    $exp = explode( ",", $season );
	    $str = "( 1 = 0 "; 
	    foreach( $exp as $e )
		{
		    $tmpyr = $year; // $e==1?($year+1):$year; we used to do this but now i dont' think we need to? 
		    $str .= " or QuarterEnteredTheTop10 {$not} like '{$e}/{$tmpyr}' ";
		}
	    
	    $str .= " ) ";
	    return $str; 
	}
    else
	{
	    return "QuarterEnteredTheTop10 {$not} like '%$str'";
	}
}

function getSongIdsWithinQuarter( $newarrivalsonly, $quarter, $year, $endquarter = "", $endyear = "", $positiononly = "", $orderbysongtitle = false, $seasontouse = "" )
{
    global $cachesongids, $numberoneonly, $nodates, $clientfilter, $genrefilter, $lyricalthemefilter, $lyricalsubthemefilter, $lyricalmoodfilter, $minweeksfilter, $bpmfilter, $majorminorfilter, $newcarryfilter, $subgenrefilter, $season, $withimprint, $chartid, $crosschartfilter; // ughhhhhh

    if( $crosschartfilter )
        $chartid = $crosschartfilter;
//echo( "chat: " . $chartid );
    $seasontouse = $seasontouse?$seasontouse:$season;
    if( $numberoneonly ) $positiononly = 1;
  if( $_GET["help"] )
      echo( "<br>\nDATES: $quarter,$year,$endquarter,$endyear, genre: $genrefilter, season: $seasontouse\n<br>" );

  $ext = "";
  if( $newarrivalsonly || $newcarryfilter == "new" )
    {
      //      $q = getPreviousQuarter( "{$quarter}/{$year}" );
	$quarters = getQuarters( $quarter, $year, $endquarter, $endyear, $seasontouse );
	if( $_GET["help"] )
	    {
		echo( "($newarrivalsonly) ($newcarryfilter) quarters: ($seasontouse)<br>\n" ) ;
		print_r( $quarters );
		echo( "<br>\n" );
	    }
      if( $endquarter )
      {
          $ext .= " and  songs.id in ( select songid from song_to_chart where chartid = $chartid and ( 1 = 0 "; 
          foreach( $quarters as $q )
          {
              $ext .= " or " . getQuarterEnteredTheTopTenString( $q, $seasontouse );
          }
          $ext .= " ) )";
          logquery( "this is the one: " . $ext );
      }
      else
      {
          $q = ( "{$quarter}/{$year}" );
          $ext .= " and songs.id in ( select songid from song_to_chart where  chartid = $chartid and (" . getQuarterEnteredTheTopTenString( $q, $seasontouse ) . " ))" ;
          
      }
    }

    if( $newcarryfilter == "carryover" )
    {
      $quarters = getQuarters( $quarter, $year, $endquarter, $endyear );
      if( $endquarter )
      {
          $ext .= " and ( 1 = 1 "; 
          foreach( $quarters as $q )
          {
              $ext .= " and  songs.id not in ( select songid from song_to_chart where  chartid = $chartid and (" . getQuarterEnteredTheTopTenString( $q, $seasontouse ) . " ))";
          }
          $ext .= " )";
          logquery( "this is the one: " . $ext );
      }
      else
      {
          $q = ( "{$quarter}/{$year}" );
          $ext .= " and  songs.id not in ( select songid from song_to_chart where chartid = $chartid and  (" . getQuarterEnteredTheTopTenString( $q, $seasontouse ) . " ))";
          
      }
    }

    $weekdateext = "";
  if( $positiononly )
  {
      if( strpos( $positiononly, "client-" ) !== false )
      {
          $clientid = str_replace( "client-", "", $positiononly );
          $ext .= " and ClientID = '$clientid'";
      }
      else if( strpos( $positiononly, "<" ) !== false )
      {
          $positiononly = str_replace( "<", "", $positiononly );
          $tmp = array();
          for( $i = 1; $i <= $positiononly; $i++ )
          {
              $tmp[] = "'position{$i}'";
          }
          $tmp = implode( ", ", $tmp );
          $ext .= " and type in ( $tmp )";
      }
      else if( strpos( $positiononly, ":" ) !== false )
      {
	  $exp = explode( ":", $positiononly );
	  //	  $gbext = " group by songid having ( max( actualposition ) >= $exp[0] and max( actualposition ) <= $exp[1] ) ";
	  $ext = " and songs.id in ( select songid from song_to_chart where PeakPosition >= $exp[0] and PeakPosition <= $exp[1] and chartid = $chartid ) ";
      }
      else
      {
	  if( !$quarter )
	      {
		  $ext .= " and songs.id in ( select songid from song_to_weekdate where actualposition = '{$positiononly}' )";
	      }
	      else
	      {
		  $weekdateext = " and actualposition = '{$positiononly}'";
		  $ext .= " and songs.id in ( select songid from song_to_weekdate where actualposition = '{$positiononly}' )";
	      }
      }
  }
  if( $songwriterfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_artist where artistid = '$songwriterfilter' and type = 'creditedsw' )"; 
  }
  if( $bpmfilter )
  {
      $ext .= " and songs.TempoRange = '$bpmfilter'"; 
  }
  if( $majorminorfilter	 )
  {
      $ext .= " and songs.majorminor = '$majorminorfilter'"; 
  }
  if( $producerfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_producer where producerid = '$producerfilter' )"; 
  }
  if( $lyricalmoodfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_lyricalmood where lyricalmoodid = '$lyricalmoodfilter' )"; 
  }
  if( $minweeksfilter )
  {
      $valuearr = explode( "-", $minweeksfilter );
      if( count( $valuearr ) > 1 )
	  $ext .= " and songs.id in ( select songid from song_to_chart where chartid = '". ($crosschartfilter?$crosschartfilter:$_SESSION["chartid"]) . "' and song_to_chart.NumberOfWeeksSpentInTheTop10 >= $valuearr[0] and song_to_chart.NumberOfWeeksSpentInTheTop10 <= $valuearr[1] )"; 
      else
	  $ext .= " and songs.id in ( select songid from song_to_chart where chartid = '".  ($crosschartfilter?$crosschartfilter:$_SESSION["chartid"]) . "' and NumberOfWeeksSpentInTheTop10 >= $minweeksfilter )"; 
      
  }
  if( $lyricalsubthemefilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_lyricalsubtheme where lyricalsubthemeid = '$lyricalsubthemefilter' )"; 
  }
  if( $lyricalthemefilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_lyricaltheme where lyricalthemeid = '$lyricalthemefilter' )"; 
  }
  if( $withimprint )
  {
      $ext .= " and songs.id in ( select songid from song_to_imprint )"; 
  }
  if( $subgenrefilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_subgenre where subgenreid = '$subgenrefilter' )"; 
  }
  if( $groupfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_group where groupid = '$groupfilter' and type in ( 'featured', 'primary' ) )"; 
  }
  if( $artistfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_artist where artistid = '$artistfilter' and type in ( 'featured', 'primary' ) )"; 
  }
  if( $groupfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_group where groupid = '$groupfilter' and type in ( 'featured', 'primary' ) )"; 
  }
  if( $labelfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_label where labelid = '$labelfilter' )"; 
  }
  if( $clientfilter )
  {
      $ext .= " and songs.ClientID = $clientfilter"; 
  }
  if( $genrefilter )
  {
      if( $genrefilter > 0 )
	  $ext .= " and songs.GenreID = $genrefilter"; 
      else
	  $ext .= " and songs.GenreID <> " . abs( $genrefilter ) . ""; 
  }
  if( $_GET["help"] )
      echo( "<br>\n getsongidswithinquarter : " . $ext . "\n<br>\n" );
  
    $theclientwhere = $GLOBALS["clientwhere"]; 
    if( $crosschartfilter )
    	$theclientwhere = " 1 ";

//	echo( "the: " . $theclientwhere );

  $key = "$quarter, $year, $endquarter, $endyear, $positiononly, $newarrivalsonly, $songwriterfilter, $clientfilter, $labelfilter, $artistfilter, $genrefilter, $artistid, $artisttype, $withimprint, $newcarryfilter, $minweeksfilter, $subgenrefilter, $seasontouse, $chartid, $crosschartfilter";
  if( $endyear && !$endquarter )
  {
      $endquarter = 4;
  }
  if( $year && !$quarter )
  {
          // just searching for the whole year
      $quarter = 1;
      if( !$endquarter )
      {
          $endquarter = 4;
      }
      if( !$endyear )
      {
          $endyear = $year;
      }
  }
//  logquery( "querying for key: $key" );
  if( isset( $cachesongids[$key] ) )
    {
//        logquery( "cache hit! " . count( $cachesongids[$key] ) );
	if( $_GET["help"] )
	    echo( "cache hit $key<br>" );
    return $cachesongids[$key];
    }
  if( !$endquarter )
    $endquarter = $quarter; 
  if( !$endyear )
    $endyear = $year; 


  
  
  if( $quarter == 1 )
    {
      $startdate = strtotime( "01/01/$year 00:00:00" );
    }
  if( $endquarter == 1 )
    {
      $enddate = strtotime( "04/01/$endyear 00:00:00" );
    }
  if( $quarter == 2 )
    {
      $startdate = strtotime( "04/01/$year 00:00:00" );
    }
  if( $endquarter == 2 )
    {
      $enddate = strtotime( "07/01/$endyear 00:00:00" );
    }
  if( $quarter == 3 )
    {
      $startdate = strtotime( "07/01/$year 00:00:00" );
    }
  if( $endquarter == 3 )
    {
      $enddate = strtotime( "10/01/$endyear 00:00:00" );
    }
  if( $quarter == 4 )
    {
      $startdate = strtotime( "10/01/$year  00:00:00" );
    }
  if( $endquarter == 4 )
    {
      $enddate = strtotime( "12/31/$endyear 23:59:59" );
    }

    if( strpos( $ext, " and type in" ) !== false )
    {
        $nodates = false;
    }


  if( $nodates ) //  || $GLOBALS["isclientsearch"]
  {
      if( $orderbysongtitle )
          $sql = ( "select distinct( songs.id ) as songid from songs where $theclientwhere $ext and songs.id = songid $gbext order by SongNameHard" );
      else
          $sql = ( "select distinct( songs.id ) as songid from songs where $theclientwhere $ext $gbext " );
  }
  else
  {
//  file_put_contents( "/tmp/rc", $ext . "\n" );
//      print_r( $seasontouse );      
      if( is_array( $seasontouse ) )
      {	  
      	  $seasontouse = implode( ",", $seasontouse );
      }
      $s = str_replace( "4", "0", $seasontouse );
      $chartstr = " and song_to_weekdate.chartid = ". ($crosschartfilter?$crosschartfilter:$_SESSION["chartid"]);
      $quarternumber = $seasontouse?" and QuarterNumber % 4 in ($s)" :""; 

 if( strpos( $positiononly, ":" ) !== false )
      {
	  // $exp = explode( ":", $positiononly );
          // $tmp = array();
          // for( $i = $exp[0]; $i <= $exp[1]; $i++ )
	  //     {
          //     $tmp[] = "'position{$i}'";
          // }
          // $tmp = implode( ", ", $tmp );
          // $ext .= " and type in ( $tmp )";
	  if( $exp[0] > 1 )
	      {
		  $weekdates = db_query_array( "select id from weekdates where OrderBy >= '$startdate' and OrderBy < '$enddate' $quarternumber $weekdateext", "id", "id" );
		  $ext = " and songid not in ( select songid from song_to_weekdate where actualposition < $exp[0] $chartstr and weekdateid in ( " . implode( ", " , $weekdates ) . " ) ) ";
	      }
      }

      if( $orderbysongtitle )
          $sql = ( "select distinct( songid ) as songid from song_to_weekdate, songs where $theclientwhere and weekdateid in ( select id from weekdates where OrderBy >= '$startdate' and OrderBy < '$enddate' $quarternumber $weekdateext ) $ext $chartstr  and songs.id = songid $gbext order by SongNameHard" );
      else
          $sql = ( "select distinct( songid ) as songid from song_to_weekdate, songs where $theclientwhere and songid = songs.id $chartstr and  weekdateid in ( select id from weekdates where OrderBy >= '$startdate' and OrderBy < '$enddate' $quarternumber $weekdateext ) $ext $gbstr " );

  }

  if( $_GET["help"] )
      {
      echo( $sql. "<br>" );
      }
  logquery( $sql );
  
  file_put_contents( "/tmp/songids", print_r( $_GET["search"], true ), FILE_APPEND );
  file_put_contents( "/tmp/songids", $sql . "\n\n", FILE_APPEND );
  $songids = db_query_array( $sql, "songid", "songid" );
  if( is_array( $myartistsongs ) && count( $myartistsongs ) )
  {
      $songids = array_intersect( $myartistsongs, $songids );
  }
      
  $cachesongids[$key] = $songids;
  return $songids;

}

function getSongIdsWithinWeekdates( $newarrivalsonly, $fromweekdateob, $toweekdateob, $positiononly = "", $orderbysongtitle = false )
{
    global $cachesongids, $numberoneonly, $songwriterfilter, $nodates, $clientfilter, $artistfilter, $genrefilter, $myartistsongs, $artistid, $artisttype, $labelfilter, $newcarryfilter, $subgenrefilter, $producerfilter, $lyricalthemefilter, $lyricalsubthemefilter, $lyricalmoodfilter, $withimprint, $season, $bpmfilter, $majorminorfilter;
    if( $numberoneonly ) $positiononly = 1;
  if( $_GET["help"] )
      echo( "<br>\nDATES: $fromweekdateob,$toweekdateob\n<br>" );

  $ext = "";
  $allweeks = db_query_array("select OrderBy, id from weekdates where OrderBy >= $fromweekdateob and OrderBy <= $toweekdateob", "OrderBy", "id" );
  
  if( !count( $allweeks ) )
      $allweeks[] = -1;

  if( $newarrivalsonly || $newcarryfilter == "new" )
    {
	$ext .= " and WeekEnteredTheTop10 in ( " . implode( ", " , $allweeks ) . " )";
    }

    if( $newcarryfilter == "carryover" )
    {
	$ext .= " and WeekEnteredTheTop10 not in ( " . implode( ", " , $allweeks ) . " )";
    }




  if( $positiononly )
  {
      if( strpos( $positiononly, "client-" ) !== false )
      {
          $clientid = str_replace( "client-", "", $positiononly );
          $ext .= " and ClientID = '$clientid'";
      }
      else if( strpos( $positiononly, "<" ) !== false )
      {
          $positiononly = str_replace( "<", "", $positiononly );
          $tmp = array();
          for( $i = 1; $i <= $positiononly; $i++ )
          {
              $tmp[] = "'position{$i}'";
          }
          $tmp = implode( ", ", $tmp );
          $ext .= " and type in ( $tmp )";
      }
      else
      {
          $ext .= " and type = 'position{$positiononly}'";
      }
  }
  if( $songwriterfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_artist where artistid = '$songwriterfilter' and type = 'creditedsw' )"; 
  }
  if( $lyricalmoodfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_lyricalmood where lyricalmoodid = '$lyricalmoodfilter' )"; 
  }
  if( $lyricalsubthemefilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_lyricalsubtheme where lyricalsubthemeid = '$lyricalsubthemefilter' )"; 
  }
  if( $lyricalthemefilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_lyricaltheme where lyricalthemeid = '$lyricalthemefilter' )"; 
  }
  if( $producerfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_producer where producerid = '$producerfilter' )"; 
  }
  if( $majorminorfilter	 )
  {
      $ext .= " and songs.majorminor = '$majorminorfilter'"; 
  }
  if( $bpmfilter )
  {
      $ext .= " and songs.TempoRange = '$bpmfilter'"; 
  }
  if( $withimprint )
  {
      $ext .= " and songs.id in ( select songid from song_to_imprint )"; 
  }
  if( $subgenrefilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_subgenre where subgenreid = '$subgenrefilter' )"; 
  }
  if( $groupfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_group where groupid = '$groupfilter' and type in ( 'featured', 'primary' ) )"; 
  }
  if( $artistfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_artist where artistid = '$artistfilter' and type in ( 'featured', 'primary' ) )"; 
  }
  if( $groupfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_group where groupid = '$groupfilter' and type in ( 'featured', 'primary' ) )"; 
  }
  if( $labelfilter )
  {
      $ext .= " and songs.id in ( select songid from song_to_label where labelid = '$labelfilter' )"; 
  }
  if( $clientfilter )
  {
      $ext .= " and songs.ClientID = $clientfilter"; 
  }
  if( $genrefilter )
  {
      if( $genrefilter > 0 )
	  $ext .= " and songs.GenreID = $genrefilter"; 
      else
	  $ext .= " and songs.GenreID <> " . abs( $genrefilter ) . ""; 
  }

  if( $_GET["help"] )
      echo( "<br>\nEXT: " . $ext . "\n<br>" );
  
  $key = "$fromweekdateob, $toweekdateob, $positiononly, $newarrivalsonly, $songwriterfilter, $clientfilter, $labelfilter, $artistfilter, $genrefilter, $artistid, $artisttype, $withimprint, $subgenrefilter";
//  logquery( "querying for key: $key" );
  if( isset( $cachesongids[$key] ) )
    {
//        logquery( "cache hit! " . count( $cachesongids[$key] ) );

    return $cachesongids[$key];
    }

    if( strpos( $ext, " and type in" ) !== false )
    {
        $nodates = false;
    }
  if( $nodates ) // || $GLOBALS["isclientsearch"]
  {
      if( $orderbysongtitle )
          $sql = ( "select distinct( songs.id ) as songid from songs where {$GLOBALS[clientwhere]} $ext and songs.id = songid order by SongNameHard" );
      else
          $sql = ( "select distinct( songs.id ) as songid from songs where {$GLOBALS[clientwhere]} $ext" );
  }
  else
  {
//  file_put_contents( "/tmp/rc", $ext . "\n" );
      if( $orderbysongtitle )
          $sql = ( "select distinct( songid ) as songid from song_to_weekdate, songs where {$GLOBALS[clientwhere]} and weekdateid in ( ". implode( ", ", $allweeks ) . " ) $ext and songs.id = songid order by SongNameHard" );
      else
          $sql = ( "select distinct( songid ) as songid from song_to_weekdate, songs where {$GLOBALS[clientwhere]} and songid = songs.id and weekdateid in ( ". implode( ", ", $allweeks ) . " ) $ext" );

  }

  logquery( $sql );
  
//  echo( $sql );
  $songids = db_query_array( $sql, "songid", "songid" );
  if( is_array( $myartistsongs ) && count( $myartistsongs ) )
  {
      $songids = array_intersect( $myartistsongs, $songids );
  }
      
  $cachesongids[$key] = $songids;
  return $songids;

}


$weekdatecache = array();
function getWeekdatesForQuarters( $quarter, $year, $endquarter="", $endyear="", $seasontouse = "" )
{
    global $weekdatecache, $season;
    $seasontouse = $seasontouse?$seasontouse:$season;
    $key = "$quarter-$year-$endquarter-$endyear-$seasontouse";
    if( isset( $weekdatecache[$key] ) ) return $weekdatecache[$key] ;
  if( $endyear && !$endquarter )
  {
      $endquarter = 4;
  }
  if( $year && !$quarter )
  {
          // just searching for the whole year
      $quarter = 1;
      if( !$endquarter )
      {
          $endquarter = 4;
      }
      if( !$endyear )
      {
          $endyear = $year;
      }
  }
  if( !$endquarter )
    $endquarter = $quarter; 
  if( !$endyear )
    $endyear = $year; 

  if( $quarter == 1 )
    {
      $startdate = strtotime( "01/01/$year 00:00:00" );
    }
  if( $endquarter == 1 )
    {
      $enddate = strtotime( "04/01/$endyear 00:00:00" );
    }
  if( $quarter == 2 )
    {
      $startdate = strtotime( "04/01/$year 00:00:00" );
    }
  if( $endquarter == 2 )
    {
      $enddate = strtotime( "07/01/$endyear 00:00:00" );
    }
  if( $quarter == 3 )
    {
      $startdate = strtotime( "07/01/$year 00:00:00" );
    }
  if( $endquarter == 3 )
    {
      $enddate = strtotime( "10/01/$endyear 00:00:00" );
    }
  if( $quarter == 4 )
    {
      $startdate = strtotime( "10/01/$year  00:00:00" );
    }
  if( $endquarter == 4 )
    {
      $enddate = strtotime( "12/31/$endyear 23:59:59" );
    }
  if( $_GET["help"] )
      echo( "looking up $quarter, $endquarter weekdates for " . date( "Y-m-d", $startdate ) . " and " . date( "Y-m-d", $enddate ) . "<br>");

  $s = str_replace( "4", "0", $seasontouse );
  $quarternumber = $seasontouse?" and QuarterNumber % 4 in ($s)" :""; 

    $sql = ( "select id from weekdates where OrderBy >= '$startdate' and OrderBy < '$enddate' $quarternumber " );
  if( $_GET["help"] )
      echo( $sql . "<br>" );
    $retval = db_query_array( $sql, "id", "id" );
    $weekdatecache[$key] = $retval;
    return $retval;
}


function calculateQuarterNumber( $myquarter, $myyear )
{
    $initquarternumber = 1;
    for( $year = 2000; $year < date( "Y" ) + 1; $year++ )
    {
        for( $quarter = 1; $quarter <= 4; $quarter++ )
        {
            if( $quarter == $myquarter && $year == $myyear )
                return $initquarternumber;
            $initquarternumber++; 
        }
    }
}

function calculateQuarterDisplay( $quarternumber )
{
	
    $numyears = floor( $quarternumber / 4 );
    $year = 2000 + $numyears;
    $quarter = $quarternumber - (4*$numyears);
    if( !$quarter )
	{
	    return "4/" . ($year-1); 
	}
    return $quarter . "/" . $year; 
}

function logquery( $sql, $ignore="", $ignore2="", $ignore3="" )
{
    global $reportrow, $logtype;
    //     // not doing this because HUGE
    // if( $reportrow[type] )
    //     file_put_contents( "querylog", $reportrow[type] . "_ " . $reportrow[id] . ": " . $sql . "\n", FILE_APPEND );
    // else
    //     file_put_contents( "querylog", $logtype . ": " . $sql . "\n", FILE_APPEND );
}

function getPreviousQuarter( $q )
{
  $qspl = explode( "/", $q );
  $y = $qspl[1];
  $mon = $qspl[0];

  if( !$mon )
  {
      return "/" . ($y-1);
  }
  
  $mon--;
  if( !$mon )
    {
      $mon = 4;
      $y = intval( $y ) -1 ;
    }
  return "{$mon}/{$y}";
}


function getQuarterDateRange( $q )
{
  $qspl = explode( "/", $q );
  $y = $qspl[1];
  $mon = $qspl[0];
  $mon = (($mon-1)*3) + 1;
  $startingdate = strtotime( "$y-{$mon}-01" );
  $mon = (($edateq-1)*3) + 1;

  $endingdate = mktime( 0,0,0, date( "m", $startingdate ) + 3, date( "d", $startingdate ), date( "Y", $startingdate ) );
  
  return array( date( "Y-m-d", $startingdate ), date( "Y-m-d", $endingdate ) );
}


function getYears( $sdatey, $edatey )
{
    $retval = array();
    if( !$edatey )
        $retval[] = "/" . $sdatey;
    else
    {
        while( $sdatey <= $edatey )
        {
            $retval[] = "/" . $sdatey;
            $sdatey++;
        }
    }
    return $retval;         
    
}
function getFirstSeason( $mys )
{
    return array_shift( explode( ",", $mys ) );
}
function getLastSeason( $mys )
{
    return array_pop( explode( ",", $mys ) );
}
function getQuarters( $sdateq, $sdatey, $edateq, $edatey, $seasontouse = "" )
{
	global $season;
	$seasontouse = $seasontouse?$seasontouse:$season;
	if( !$edateq ) $edateq = $sdateq;
	if( !$edatey ) $edatey = $sdatey;
  $mon = (($sdateq-1)*3) + 1;
//  echo( "hmm1: $sdatey-{$mon}-01, " );
  $startingdate = strtotime( "$sdatey-{$mon}-01" );
  $mon = (($edateq-1)*3) + 1;
//  echo( "hmm2: $edatey-{$mon}-01, " );
  $endingdate = strtotime( "$edatey-{$mon}-01" );

  if( $_GET["help"] )
      echo( "qaqqqq: $sdateq, $sdatey " . date( "Y-m-d", $startingdate ). ", $edateq, $edatey " . date( "Y-m-d", $endingdate ). "<br>\n" ); 
  $retval = array();
  $startyear = $sdatey;
$startq = 1;
$endq = 4;

// if( $sdatey == $edatey && $seasontouse == FALLWINTER )
//     {
// 	$edatey ++;
//     }

// // this is the new "comparing seasons"
// if( $sdatey == $edatey && $seasontouse == FALLWINTERCOMPARISON )
//     {
// 	$edatey ++;
//     }

if( $seasontouse != ALLSEASONS && $seasontouse != ALLSEASONS24 && $seasontouse )
    {
	if( $seasontouse ) $startq = getFirstSeason( $seasontouse );
	if( $seasontouse ) $endq = getLastSeason( $seasontouse );
    }

// if( $seasontouse == FALLWINTER )
//     {
// 	// these are backwards 
// 	if( $seasontouse ) $startq = getLastSeason( $seasontouse );
// 	if( $seasontouse ) $endq = getFirstSeason( $seasontouse );
//     }
// if( $seasontouse == FALLWINTERCOMPARISON )
//     {
// 	// these are the same but whatever
// 	if( $seasontouse ) $startq = getLastSeason( $seasontouse );
// 	if( $seasontouse ) $endq = getFirstSeason( $seasontouse );
//     }


  while( $startyear <= $edatey )
    {
      for( $i = $startq; $i <= $endq; $i++ )
	{
	    //	    if( ($seasontouse == FALLWINTER) && ( $i  == 3 || $i == 2 ) ) continue; // couldn't figure out how to skip those quarters otherwise
	    $mon = (($i-1)*3) + 1;
	    if( ( strtotime( "$startyear-{$mon}-01" ) <= $endingdate ) && 
		( strtotime( "$startyear-{$mon}-01" ) >= $startingdate ) &&
		strtotime( "$startyear-{$mon}-01" ) <= time() )
		{
		    $retval[] = "$i/{$startyear}";
		}
	}
      $startyear++;
    }
  if( $_GET["help"] )
      echo( "\n<br> $startq, $endq, " . date( "Y-m-d", $startingdate ) . "," . date( "Y-m-d",  $endingdate ) . ",  the quarters are : " . print_r( $retval, true ) . "\n<br>" );

  return $retval; 
}

function formatQuarterForDisplay( $q )
{
    if( strpos( $q, "/" ) > 0 )
        return "Q" . str_replace( "/", "-", $q );
    else
    {
        return "Y" . str_replace( "/", "", $q );
    }
}

//db_query( "update songs set lyrics = replace( lyrics, 'Õ', '\'' ) where lyrics like '%california%'" );

define( 'OUTRO', 6 );
define( 'CHORUS1', 4 );
define( 'PRECHORUS1', 3 );
define( 'BRIDGE1', 5 );
define( 'INTRO', 1 );
define( 'VERSE1', 2 );

define( 'RAPPED', 22 );
define( 'SPOKEN', 25 );
define( 'SUNG', 23 );

function populateSongRows( $songids )
{
    global $cachesongrows, $cache_songnames;
    $arr = db_query_rows( "select songs.* from songs where songs.id in ( $songids )", "id" );
    foreach( $arr as $id=>$songrow )
	{
	    $cache_songnames["".$id] = $songrow[SongNameHard];
	    $cachesongrows["".$id] = $songrow;
	}
}

$cachesongrows = array();
function getSongRow( $songid )
{
  global $cachesongrows;

  // file_put_contents( "/tmp/querylog", "num in cached: '$songid'" . count( $cachesongrows ) . "\n" , FILE_APPEND );
  // file_put_contents( "/tmp/querylog", "keys in cached: " . $cachesongrows[$songid] . "\n" , FILE_APPEND );
  // file_put_contents( "/tmp/querylog", "ake in cached: " . array_key_exists( $songid, $cachesongrows ) . "\n" , FILE_APPEND );
  // file_put_contents( "/tmp/querylog", "ake in cached2: " . array_key_exists( "".$songid, $cachesongrows  ) . "\n" , FILE_APPEND );
  if( !array_key_exists( $songid , $cachesongrows ) )
      $cachesongrows["".$songid] = db_query_first( "select * from songs where id = '$songid'" );
  return $cachesongrows["".$songid];

}


function writeSongArtistRow( $sheet, $srow )
{
  global $colnum, $rownum; 
  $rownum++;
  $colnum = 0;
  $sheet->write( $rownum, $colnum++, getSongname( $srow[songnameid] ) );
  // $artists = getArtists( $srow[id] );
  // $groups = getGroups( $srow[id] );
  // if( $artists && $groups )
  //     $artists .= ", ";
//  $artists . $groups

  $sheet->write( $rownum, $colnum++, $srow["ArtistBand"] );

}

function reportlog( $st )
{
  file_put_contents( "reportlog", $st . "\n", FILE_APPEND );
}

function writeGenreCompReportLines( $sheet, $allvalues, $notesarr )
{
    global $colnum, $rownum, $addnote;
  // this is assuming you've already written thename of the report in the first column of the first line 

  //  reportlog( print_r( $allvalues, true ) );

    $maxnum = 0;
    foreach( $allvalues as $v )
    {
        if( count($v) > $maxnum ) $maxnum = count( $v );
    }
    
    for( $i = 0; $i < $maxnum; $i++ )
    {
        
            //      reportlog( "working on $i" );
        
        if( $i )
        {
            $rownum++;
            $colnum = 0;
            $sheet->write( $rownum, $colnum++, "" );
        }
        foreach( $allvalues as $col=>$v )
        {
                //	  reportlog( "$rownum, $colnum: {$v[$i]}" );
            if( isset( $v[$i] ) )
            {
                $sheet->write( $rownum, $colnum++, $v[$i] );
                if( $addnote )
                {
                    $sheet->writeNote( $rownum, $colnum-1, getSongnames( $notesarr[$col][$i] ) );
                }
            }
            else
            {
                $sheet->write( $rownum, $colnum++, "" );
            }
            
        }
    }
}

function getNextSectionName( $ssid, $ssrows )
{
  global $songsections;
  $found = false;
  foreach( $ssrows as $srow )
    {
      if( $found ) return $songsections[$srow[songsectionid]]["Name"];
      if( $srow[songsectionid] == $ssid )
	$found = true;
    }
}

function getSongNames( $songarray )
{
//    reportlog( "about to: " . print_r( $songarray, true ) );
    if( !is_array( $songarray ) && strlen( $songarray ) )
    {
        $songarray = explode( ",", $songarray );
    }
    
  $retval = array();
  if( is_array( $songarray ) )
      foreach( $songarray as $s )
      {
          if( $s == -1 ) continue;
          if( !trim( $s ) ) continue;
          $retval[ $s ] = getSongnameFromSongid( $s );
      }
//  reportlog( "done with it" );
  return implode( ", ", $retval );
}

function removeHours( $time )
{
	$tm = strtotime( "Jan 1, 2001 $time" );
	$dt =  date( "i:s", $tm );
	if( substr( $dt, 0, 1 ) == "0" )
        $dt =  substr( $dt, 1 );
    return $dt; 
	
}

function excelSeconds( $now )
{
    $now = round( $now );
// number of seconds in a day
    $seconds_in_a_day = 86400;
// Unix timestamp to Excel date difference in seconds
    $ut_to_ed_diff = $seconds_in_a_day * 25569;
    return ($now + $ut_to_ed_diff) / $seconds_in_a_day;

}

function makeTime( $seconds )
{
    return ltrim( date( "i:s", $seconds ), '0' );
}

function makeTimeSeconds( $seconds )
{
    if( $seconds < 60 )
        return "0:" . date( "s", $seconds );
    else
        return "1:" . date( "s", $seconds );
}

function convertToSeconds( $date )
{
    return (date( "i", strtotime( $date ) ) * 60) + date( "s", strtotime( $date ) ) ;
}

function convertBadChars( $input )
{
    $output = fixMSWord($input);
    return $output;
}

function fixMSWord($string) {
    $map = Array(
        '33' => '!', '34' => '"', '35' => '#', '36' => '$', '37' => '%', '38' => '&', '39' => "'", '40' => '(', '41' => ')', '42' => '*',
        '43' => '+', '44' => ',', '45' => '-', '46' => '.', '47' => '/', '48' => '0', '49' => '1', '50' => '2', '51' => '3', '52' => '4',
        '53' => '5', '54' => '6', '55' => '7', '56' => '8', '57' => '9', '58' => ':', '59' => ';', '60' => '<', '61' => '=', '62' => '>',
        '63' => '?', '64' => '@', '65' => 'A', '66' => 'B', '67' => 'C', '68' => 'D', '69' => 'E', '70' => 'F', '71' => 'G', '72' => 'H',
        '73' => 'I', '74' => 'J', '75' => 'K', '76' => 'L', '77' => 'M', '78' => 'N', '79' => 'O', '80' => 'P', '81' => 'Q', '82' => 'R',
        '83' => 'S', '84' => 'T', '85' => 'U', '86' => 'V', '87' => 'W', '88' => 'X', '89' => 'Y', '90' => 'Z', '91' => '[', '92' => '\\',
        '93' => ']', '94' => '^', '95' => '_', '96' => '`', '97' => 'a', '98' => 'b', '99' => 'c', '100'=> 'd', '101'=> 'e', '102'=> 'f',
        '103'=> 'g', '104'=> 'h', '105'=> 'i', '106'=> 'j', '107'=> 'k', '108'=> 'l', '109'=> 'm', '110'=> 'n', '111'=> 'o', '112'=> 'p',
        '113'=> 'q', '114'=> 'r', '115'=> 's', '116'=> 't', '117'=> 'u', '118'=> 'v', '119'=> 'w', '120'=> 'x', '121'=> 'y', '122'=> 'z',
        '123'=> '{', '124'=> '|', '125'=> '}', '126'=> '~', '127'=> ' ', '128'=> '&#8364;', '129'=> ' ', '130'=> ',', '131'=> ' ', '132'=> '"',
        '133'=> '.', '134'=> ' ', '135'=> ' ', '136'=> '^', '137'=> ' ', '138'=> ' ', '139'=> '<', '140'=> ' ', '141'=> ' ', '142'=> ' ',
        '143'=> ' ', '144'=> ' ', '145'=> "'", '146'=> "'", '147'=> '"', '148'=> '"', '149'=> '.', '150'=> '-', '151'=> '-', '152'=> '~',
        '153'=> ' ', '154'=> ' ', '155'=> '>', '156'=> ' ', '157'=> ' ', '158'=> ' ', '159'=> ' ', '160'=> ' ', '161'=> '¡', '162'=> '¢',
        '163'=> '£', '164'=> '¤', '165'=> '¥', '166'=> '¦', '167'=> '§', '168'=> '¨', '169'=> '©', '170'=> 'ª', '171'=> '«', '172'=> '¬',
        '173'=> '­', '174'=> '®', '175'=> '¯', '176'=> '°', '177'=> '±', '178'=> '²', '179'=> '³', '180'=> '´', '181'=> 'µ', '182'=> '¶',
        '183'=> '·', '184'=> '¸', '185'=> '¹', '186'=> 'º', '187'=> '»', '188'=> '¼', '189'=> '½', '190'=> '¾', '191'=> '¿', '192'=> 'À',
        '193'=> 'Á', '194'=> 'Â', '195'=> 'Ã', '196'=> 'Ä', '197'=> 'Å', '198'=> 'Æ', '199'=> 'Ç', '200'=> 'È', '201'=> 'É', '202'=> 'Ê',
        '203'=> 'Ë', '204'=> 'Ì', '205'=> 'Í', '206'=> 'Î', '207'=> 'Ï', '208'=> 'Ð', '209'=> 'Ñ', '210'=> 'Ò', '211'=> 'Ó', '212'=> 'Ô',
        '213'=> 'Õ', '214'=> 'Ö', '215'=> '×', '216'=> 'Ø', '217'=> 'Ù', '218'=> 'Ú', '219'=> 'Û', '220'=> 'Ü', '221'=> 'Ý', '222'=> 'Þ',
        '223'=> 'ß', '224'=> 'à', '225'=> 'á', '226'=> 'â', '227'=> 'ã', '228'=> 'ä', '229'=> 'å', '230'=> 'æ', '231'=> 'ç', '232'=> 'è',
        '233'=> 'é', '234'=> 'ê', '235'=> 'ë', '236'=> 'ì', '237'=> 'í', '238'=> 'î', '239'=> 'ï', '240'=> 'ð', '241'=> 'ñ', '242'=> 'ò',
        '243'=> 'ó', '244'=> 'ô', '245'=> 'õ', '246'=> 'ö', '247'=> '÷', '248'=> 'ø', '249'=> 'ù', '250'=> 'ú', '251'=> 'û', '252'=> 'ü',
        '253'=> 'ý', '254'=> 'þ', '255'=> 'ÿ'
                 );

    $search = Array();
    $replace = Array();

    foreach ($map as $s => $r) {
        $search[] = chr((int)$s);
        $replace[] = $r;
    }

    return str_replace($search, $replace, $string);
}

function calculateTempoString( $songrow )
{
    if( $songrow[Tempo]>0 )
    {
        $tempodiv = floor( $songrow[Tempo] / 10 );
        $end = (($tempodiv+1)*10);
        $end -= 1;
        $tmp = ($tempodiv * 10) . " - " . $end;
        return $tmp;
    }
    return "";
}

function genreReportWriteTotals( $totals, $numsongsfortotal, $noartist = false )
{
    global $sheet, $colnum, $rownum, $format_bold, $percentformat;

    ksort( $totals );
    $colnum = 0;
    $rownum++;
    $sheet->write( $rownum, $colnum++, "TOTAL", $format_bold);
    addArtistGenreBlank();
    foreach( $totals as $t )
    {
        $sheet->write( $rownum, $colnum++, $t);
    }
    
    $colnum = 0;
    $rownum++;
    $sheet->write( $rownum, $colnum++, "PERCENT OF TOTAL SONGS", $format_bold);
    if( !$noartist )
        addArtistGenreBlank();
    if( !$numsongsfortotal ) $numsongsfortotal = 1;
    foreach( $totals as $t )
    {
        if( $t )
            $sheet->write( $rownum, $colnum++, $t / $numsongsfortotal, $percentformat);
        else
            $sheet->write( $rownum, $colnum++, $t);
    }
    
    $rownum++;
}


function genreReportSongMulti( $sectiontitle, $thistype, $thesesongs, $thesesongids, $doksort = true, $aftercoltitle = "", $subtabletype = "" )
{
    global $sheet, $colnum, $rownum, $format_bold, $percentformat, $numsongs, $displayinstead;

    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, $sectiontitle, $format_bold );
    $rownum++; $colnum = 0;
    
    $colheaders = array();
    $ext = $subtabletype?" and type = '$subtabletype'":"";
    $colheaders = db_query_array( "select distinct( Name ) from song_to_{$thistype}, {$thistype}s where songid in ( " . implode( ", " , $thesesongids ) . " )  and {$thistype}id = {$thistype}s.id and Name <> 'Lyrical Fusion Songs' $ext", "Name", "Name" );

    if( $doksort )
        ksort( $colheaders );
    $colheaders = array_values( $colheaders );
    
    $sheet->write( $rownum, $colnum++, "Song", $format_bold );
    addArtistGenreTitles();
    foreach( $colheaders as $c )
    {
        if( isset( $displayinstead[$c] ) ) $c = $displayinstead[$c];
        $sheet->write( $rownum, $colnum++, $c . $aftercoltitle, $format_bold );
    }
    
    $totals = array( "" );
    foreach( $thesesongs as $songrow )
    {
        $rownum++;
        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $songrow[SongName] );
        addArtistGenre( $songrow );
        
        $poss = db_query_array( "select distinct( Name ) from song_to_{$thistype}, {$thistype}s where songid = '$songrow[id]' and {$thistype}id = {$thistype}s.id", "Name", "Name" );
        foreach( $colheaders as $colid=>$c )
        {
            $val = 0;
            if( in_array( $c, $poss ) )
            {
                $val = 1;
                if( !isset( $totals[$colid] ) ) $totals[$colid] = 0;
                $totals[$colid]++;
            }
            $sheet->write( $rownum, $colnum++, $val );
            
        }
    
    }
    // if( $thistype == "primaryinstrumentation" )
    //     logquery( print_r( $totals, true ) );
    genreReportWriteTotals( $totals, $numsongs );

}



function genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids, $doksort = false, $aftercoltitle = ""  )
{
    global $sheet, $colnum, $rownum, $format_bold, $percentformat, $displayinstead;

    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, $sectiontitle, $format_bold );
    $rownum++; $colnum = 0;

    $numsongs = 0;
    $colheaders = array();
    $colheaders = db_query_array( "select distinct( {$currcolname} ) from songs where id in ( " . implode( ", " , $thesesongids ) . " ) and {$currcolname} <> '' and {$currcolname} is not null order by $orderbycolname", "{$currcolname}", "{$currcolname}" );

    if( $doksort )
        ksort( $colheaders );
    $colheaders = array_values( $colheaders );
    
    $sheet->write( $rownum, $colnum++, "Song title", $format_bold );
    addArtistGenreTitles();
    foreach( $colheaders as $c )
    {
        if( isset( $displayinstead[$c] ) ) $c = $displayinstead[$c];
        $sheet->write( $rownum, $colnum++, $c . $aftercoltitle, $format_bold );
    }
    
    $totals = array( "" );
    foreach( $thesesongs as $songrow )
    {
        $poss = $songrow[$currcolname];
        if( $poss === "" || $poss === NULL ) continue;
        $numsongs++;
        $rownum++;
        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $songrow[SongName] );
        addArtistGenre($songrow);
        
        foreach( $colheaders as $colid=>$c )
        {
            $val = 0;
            if( $c == $poss )
            {
                $val = 1;
                if( !isset( $totals[$colid] ) ) $totals[$colid] = 0;
                $totals[$colid]++;
            }
            $sheet->write( $rownum, $colnum++, $val );
            
        }
    }
    
    genreReportWriteTotals( $totals, $numsongs );
}



function genreReportSongColumnSet( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids, $doksort = false, $aftercoltitle = ""  )
{
    global $sheet, $colnum, $rownum, $format_bold, $percentformat, $displayinstead;

    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, $sectiontitle, $format_bold );
    $rownum++; $colnum = 0;

    $numsongs = 0;
    $colheaders = array();
    $tmpcolheaders = db_query_array( "select distinct( {$currcolname} ) from songs where id in ( " . implode( ", " , $thesesongids ) . " ) and {$currcolname} <> '' and {$currcolname} is not null order by $orderbycolname", "{$currcolname}", "{$currcolname}" );

    foreach( $tmpcolheaders as $t )
    {
        $exp = explode( ",", $t );
        foreach( $exp as $e )
        {
            $colheaders[$e] = $e;
        }
    }
    
    if( $doksort )
        ksort( $colheaders );
    $colheaders = array_values( $colheaders );
    
    $sheet->write( $rownum, $colnum++, "Song", $format_bold );
    addArtistGenreTitles();
    foreach( $colheaders as $c )
    {
        if( isset( $displayinstead[$c] ) ) $c = $displayinstead[$c];
        $sheet->write( $rownum, $colnum++, $c . $aftercoltitle, $format_bold );
    }
    
    $totals = array( "" );
    foreach( $thesesongs as $songrow )
    {
        $poss = $songrow[$currcolname];
        if( $poss === "" || $poss === NULL ) continue;
        $poss = explode( ",", $poss );
        $numsongs++;
        $rownum++;
        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $songrow[SongName] );
        addArtistGenre($songrow);
        
        foreach( $colheaders as $colid=>$c )
        {
            $val = 0;
            if( in_array( $c, $poss ) )
            {
                $val = 1;
                if( !isset( $totals[$colid] ) ) $totals[$colid] = 0;
                $totals[$colid]++;
            }
            $sheet->write( $rownum, $colnum++, $val );
            
        }
    }
    
    genreReportWriteTotals( $totals, $numsongs );
}



function genreReportSongColumnOtherTable( $sectiontitle, $table, $orderbycolname, $thesesongs, $thesesongids, $aftercoltitle = "" )
{
    global $sheet, $colnum, $rownum, $format_bold, $percentformat, $displayinstead;

    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, $sectiontitle, $format_bold );
    $rownum++; $colnum = 0;

    $numsongs = 0;
    $colheaders = array();
    $colheaders = db_query_array( "select {$table}s.id, {$table}s.Name from song_to_{$table}, {$table}s  where songid in ( " . implode( ", " , $thesesongids ) . " ) and {$table}id = {$table}s.id order by $orderbycolname", "id", "Name" );

    $sheet->write( $rownum, $colnum++, "Song title", $format_bold );
    addArtistGenreTitles();
    foreach( $colheaders as $c )
    {
        if( isset( $displayinstead[$c] ) ) $c = $displayinstead[$c];
        $sheet->write( $rownum, $colnum++, $c . $aftercoltitle, $format_bold );
    }
    
    $totals = array( "" );
    foreach( $thesesongs as $songrow )
    {
        $poss = $songrow[$currcolname];
        $vals = db_query_array( "select {$table}id from song_to_{$table} where songid = $songrow[id]", "{$table}id", "{$table}id" );
// logquery( "select {$table}id from song_to_{$table} where songid = $songrow[id]" );
// logquery( print_r( $vals, true ) );
        if( !count( $vals) && $table != "introtype" ) continue;
        $numsongs++;
        $rownum++;
        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $songrow[SongName] );
        addArtistGenre($songrow);


        $counter = 0;
        foreach( $colheaders as $colid=>$c )
        {
            $val = 0;
//            logquery( "checking for $colid among " . print_r( $vals, true ) );
            if( $vals[$colid] )
            {
//                logquery( "got one!" );
                $val = 1;
                if( !isset( $totals[$counter] ) ) $totals[$counter] = 0;
                $totals[$counter]++;
            }
            $sheet->write( $rownum, $colnum++, $val );
            $counter++;
        }
    }
    
    genreReportWriteTotals( $totals, $numsongs );
}



function genreReportSection( $sectiontype, $sectiontypeplural, $thesesongs, $thesesongids, $lengthonly = false  )
{
    global $sheet, $colnum, $rownum, $format_bold, $percentformat, $numsongs, $timeformat;


    if( !$lengthonly )
    {
        $rownum++; $colnum = 0;
        $sheet->write( $rownum, $colnum++, "$sectiontype - Section Count", $format_bold );
        $rownum++; $colnum = 0;
        
        $sheet->write( $rownum, $colnum++, "Song title", $format_bold );
        $sheet->write( $rownum, $colnum++, "Artist", $format_bold );
        $sheet->write( $rownum, $colnum++, "Genre", $format_bold );
        $sheet->write( $rownum, $colnum++, "Number of $sectiontypeplural", $format_bold );
        
        foreach( $thesesongs as $songrow )
        {
            $rownum++;
            $colnum = 0;
            $sheet->write( $rownum, $colnum++, $songrow[SongName] );
            $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
            $sheet->write( $rownum, $colnum++, getTableValue( $songrow[GenreID], "genres" ) );
            $numverses = db_query_first_cell( "select NumSections from SectionShorthand where songid = '$songrow[id]' and section = '$sectiontype'" );
            $sheet->write( $rownum, $colnum++, $numverses );
        }
        
        $rownum++; $colnum = 0;
    }
    $rownum++; $colnum = 0;
    
    $sheet->write( $rownum, $colnum++, "$sectiontype - Section Length", $format_bold );
    $rownum++; $colnum = 0;
    
    $sections = db_query_array( "select id, Name from songsections where WithoutNumber = '$sectiontype' order by OrderBy desc", "id", "Name" );
    
    $sheet->write( $rownum, $colnum++, "Song title", $format_bold );
    addArtistGenreTitles();
    foreach( $sections as $name )
    {
        $sheet->write( $rownum, $colnum++, $name, $format_bold );
    }

    $totsforsection = array();
    foreach( $thesesongs as $songrow )
    {
        $rownum++;
        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $songrow[SongName] );
        addArtistGenre($songrow);
        foreach( $sections as $sid=>$sname )
        {
            $sectionlength = db_query_first_cell( "Select time_to_sec( length ) as length from song_to_songsection where songsectionid = '$sid' and songid = '$songrow[id]'" );
            $sheet->write( $rownum, $colnum++, excelSeconds( $sectionlength?$sectionlength:"0" ), $timeformat );
            if( $sectionlength )
            {
                $totsforsection[$sid]["Num"]++;
                $totsforsection[$sid]["Amount"]+= $sectionlength;
            }
        }

    }
    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "AVERAGE", $format_bold );
    addArtistGenreBlank();
    foreach( $sections as $sid=>$sname )
    {
        $num = $totsforsection[$sid]["Num"];
        if( !$num ) $num = 1;
        $sectionlength = number_format( $totsforsection[$sid]["Amount"]/ $num );
        $sheet->write( $rownum, $colnum++, excelSeconds( $sectionlength?$sectionlength:"0" ), $timeformat );
    }
    
    $rownum++; $colnum = 0;


    $rownum++; $colnum = 0;
    
    $sheet->write( $rownum, $colnum++, "$sectiontype - Section Length - Bars", $format_bold );
    $rownum++; $colnum = 0;
    
    $sections = db_query_array( "select id, Name from songsections where WithoutNumber = '$sectiontype' order by OrderBy desc", "id", "Name" );
    
    $sheet->write( $rownum, $colnum++, "Song title", $format_bold );
    addArtistGenreTitles();

    foreach( $sections as $name )
    {
        $sheet->write( $rownum, $colnum++, $name, $format_bold );
    }

    $totsforsection = array();
    foreach( $thesesongs as $songrow )
    {
        $rownum++;
        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $songrow[SongName] );
        addArtistGenre($songrow);
        foreach( $sections as $sid=>$sname )
        {
            $sectionlength = db_query_first_cell( "Select Bars from song_to_songsection where songsectionid = '$sid' and songid = '$songrow[id]'" );
            $sheet->write( $rownum, $colnum++, $sectionlength );
            if( $sectionlength )
            {
                $totsforsection[$sid]["Num"]++;
                $totsforsection[$sid]["Amount"]+= $sectionlength;
            }
        }

    }
    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "AVERAGE", $format_bold );
    addArtistGenreBlank();
    foreach( $sections as $sid=>$sname )
    {
        $num = $totsforsection[$sid]["Num"];
        if( !$num )
        {
            $colnum++; continue;
        }
        $sectionlength = number_format( $totsforsection[$sid]["Amount"]/ $num );
        $sheet->write( $rownum, $colnum++, $sectionlength?$sectionlength:"0" );
    }
    
    $rownum++; $colnum = 0;

    
}

                                
function stanzasReportSection( $sectiontype, $thesesongs, $thesesongids  )
{
    global $sheet, $colnum, $rownum, $format_bold, $percentformat, $numsongs, $timeformat;

    $sheet->write( $rownum, $colnum++, "$sectiontype Stanzas", $format_bold );
    $rownum++; $colnum = 0;
    
    $sections = db_query_array( "select id, Name from songsections where WithoutNumber = '$sectiontype' order by OrderBy desc", "id", "Name" );
    
    $sheet->write( $rownum, $colnum++, "Song title", $format_bold );
    addArtistGenreTitles();
    foreach( $sections as $name )
    {
        $sheet->write( $rownum, $colnum++, $name, $format_bold );
    }

    $totsforsection = array();
    foreach( $thesesongs as $songrow )
    {
        $rownum++;
        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $songrow[SongName] );
        addArtistGenre($songrow);
        foreach( $sections as $sid=>$sname )
        {
            $sectionlength = db_query_first_cell( "Select Stanzas from song_to_songsection where songsectionid = '$sid' and songid = '$songrow[id]'" );
            $sheet->write( $rownum, $colnum++, $sectionlength );
            if( $sectionlength )
            {
                $totsforsection[$sid]["Num"]++;
                $totsforsection[$sid]["Amount"]+= $sectionlength;
            }
        }

    }
    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "AVERAGE", $format_bold );
    addArtistGenreBlank();
    foreach( $sections as $sid=>$sname )
    {
        $num = $totsforsection[$sid]["Num"];
        if( !$num )
        {
            $colnum++; continue;
        }
        $sectionlength = number_format( $totsforsection[$sid]["Amount"]/ $num );
        $sheet->write( $rownum, $colnum++, $sectionlength?$sectionlength:"0" );
    }
    
    $rownum++; $colnum = 0;

    
}

                                
function chorusTypeReportSection( $sectiontype, $thesesongs, $thesesongids, $ctypeid  )
{
    global $sheet, $colnum, $rownum, $format_bold, $percentformat, $timeformat;

    $ctypename = db_query_first_cell( "select Name from chorustypes where id = $ctypeid" );
    $sheet->write( $rownum, $colnum++, "$ctypename $sectiontype", $format_bold );
    $rownum++; $colnum = 0;

    $ext = "";
    if( $sectiontype )
        $ext = " and WithoutNumber = '$sectiontype'";
    
    $sections = db_query_array( "select id, Name from songsections where 1 $ext order by OrderBy desc", "id", "Name" );
    
    $sheet->write( $rownum, $colnum++, "Song title", $format_bold );
    addArtistGenreTitles();
    foreach( $sections as $name )
    {
        $sheet->write( $rownum, $colnum++, $name, $format_bold );
    }

    $totsforsection = array();
    foreach( $thesesongs as $songrow )
    {
        $rownum++;
        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $songrow[SongName] );
        addArtistGenre($songrow);
        foreach( $sections as $sid=>$sname )
        {
            $exists = db_query_first_cell( "Select chorustypeid from song_to_chorustype where chorustypeid = '$ctypeid' and type = '$sid' and songid = '$songrow[id]'" );
            $sheet->write( $rownum, $colnum++, $exists?1:0 );
            if( $exists )
            {
                $totsforsection[$sid]["Num"]++;
            }
        }

    }
    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "TOTAL", $format_bold );
    addArtistGenreBlank();
    foreach( $sections as $sid=>$sname )
    {
        $num = $totsforsection[$sid]["Num"];
        if( !$num )
        {
            $colnum++; continue;
        }
        $sheet->write( $rownum, $colnum++, $num );
    }
    
    $rownum++; $colnum = 0;

    
}

                                
function postChorusReportSection( $sectiontype, $thesesongs, $thesesongids  )
{
    global $sheet, $colnum, $rownum, $format_bold, $percentformat, $timeformat;

    $sheet->write( $rownum, $colnum++, "$sectiontype is a Post-Chorus", $format_bold );
    $rownum++; $colnum = 0;
    
    $sections = db_query_array( "select id, Name from songsections where WithoutNumber = '$sectiontype' order by OrderBy desc", "id", "Name" );
    
    $sheet->write( $rownum, $colnum++, "Song title", $format_bold );
    addArtistGenreTitles();
    foreach( $sections as $name )
    {
        $sheet->write( $rownum, $colnum++, $name, $format_bold );
    }

    $totsforsection = array();
    foreach( $thesesongs as $songrow )
    {
        $rownum++;
        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $songrow[SongName] );
        addArtistGenre($songrow);
        foreach( $sections as $sid=>$sname )
        {
            $sectionlength = db_query_first_cell( "Select PostChorus from song_to_songsection where songsectionid = '$sid' and songid = '$songrow[id]'" );
            $sheet->write( $rownum, $colnum++, $sectionlength );
            if( $sectionlength )
            {
                $totsforsection[$sid]["Num"]++;
                $totsforsection[$sid]["Amount"]+= $sectionlength;
            }
        }

    }
    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "TOTAL", $format_bold );
    addArtistGenreBlank();
    foreach( $sections as $sid=>$sname )
    {
        $num = $totsforsection[$sid]["Num"];
        $sheet->write( $rownum, $colnum++, $num );
    }
    
    $rownum++; $colnum = 0;

    
}

function addArtistGenre( $songrow )
{
    global $sheet, $rownum, $colnum, $addartistgenre, $format_bold; 
    if( $addartistgenre )
    {
        $genre = getTableValue( $songrow["GenreID"], "genres" );
        $artist = $songrow[ArtistBand];
        $sheet->write( $rownum, $colnum++, $artist );
        $sheet->write( $rownum, $colnum++, $genre );
    }
    
}
function addArtistGenreTitles()
{
    global $sheet, $rownum, $colnum, $addartistgenre, $format_bold;
    if( $addartistgenre )
    {
        $sheet->write( $rownum, $colnum++, "Artist", $format_bold );
        $sheet->write( $rownum, $colnum++, "Genre", $format_bold );
    }
    
}

function addArtistGenreBlank()
{
    global $sheet, $rownum, $colnum, $addartistgenre, $format_bold;
    if( $addartistgenre )
    {
        $sheet->write( $rownum, $colnum++, "" );
        $sheet->write( $rownum, $colnum++, "" );
    }
    
}

function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}


function isYearString( $str )
{
    if( startsWith( $str, "/" ) )
        return true;
    return false;
}

function getQuartersForString( $str )
{
    if( isYearString( $str ) )
        return array(  "'1/" . $str . "'",  "'2/" . $str . "'",  "'3/" . $str . "'",  "'4/" . $str . "'" );
    else
        return array(  "'" . $str . "'" );
}

function hasColumn( $table, $columnname )
{
	global $dblink;
    $q = mysqli_query( $dblink, 'DESCRIBE ' . $table);
    while($row = mysqli_fetch_array($q)) {
        if( "{$row['Field']}" == $columnname )
            return true;
    }
    return false;
}

$cachedtrendreportnotarr = array();
function getTrendReportNoteFromArr( $quarter, $graph )
{
    global $cachedtrendreportnotarr;
    if( !$cachedtrendreportnotarr )
	{
	    $cachedtrendreportnotarr = db_query_rows( "select concat( quarter, '-', sectionname ) as Name, trendreportnotes.* from trendreportnotes", "Name" );
	}
    return $cachedtrendreportnotarr[$quarter ."-" . $graph];
}

function getTrendReportNote( $quarter, $graph )
{
    global $replacetotimeperiod;
    $trnote =  getTrendReportNoteFromArr( $quarter, $graph ); //db_query_first_cell( "select value from trendreportnotes where quarter = '$quarter' and sectionname = '$graph'" );
    $trnote = $trnote[value];
    if( $replacetotimeperiod )
    	$trnote = str_replace( "the quarter", "the selected time period", $trnote );
    return $trnote;
}

function formatTypeStr( $str )
{
	$str = "($str)";
	$str = str_replace( "featured", "Featured Artist", $str );
	$str = str_replace( "primary", "", $str );
	$str = str_replace( "creditedsw", "", $str );
	$str = str_replace( "samplesw", "Sample Songwriter", $str );
	$str = str_replace( "(,", "(", $str );
	$str = str_replace( ",)", ")", $str );
	$str = str_replace( "()", "", $str );
	$str = str_replace( "( )", "", $str );
	return $str;
}

$allgenresfordropdown = db_query_array( "select id, Name from genres order by OrderBy, Name", "id", "Name" );
$allgenresfordropdown["-2"] = "All Genres Except Hip Hop/Rap";

function getGenresForArtist( $artistid )
{
    return db_query_array( "select genreid from artist_to_genre where artistid = '$artistid'", "genreid", "genreid" );
}

function getCharts( $activeonly = true )
{
	$ext = $activeonly?"UseOnDb = 1":"1 = 1";
	$charts = db_query_array( "select chartname, chartkey from charts where $ext", "chartkey", "chartname" );
	return $charts; 

}
function isRachel()
{
    return $_SERVER["REMOTE_ADDR"] == "24.23.212.234" || $_SERVER["REMOTE_ADDR"] == "104.10.249.211";
	
}
function fixTotalCountForAllSongs()
{
$songs = db_query_rows( "select * from songs where IsActive = 1 ", "id" );
foreach( $songs as $songid=>$srow )
{
    $tmpp = db_query_array( "select distinct(producerid) from song_to_producer s where songid = '$songid' ", "producerid", "producerid" );
    $producers = count( $tmpp );
    $autocalcvalues["ProducerCount"] = $producers;


    $tmpp = db_query_array( "select distinct(memberid) from song_to_producer s, producer_to_member p where songid = '$songid' and p.producerid = s.producerid ", "memberid", "memberid" );
    $tmpa = db_query_array( "select distinct(memberid) from song_to_artist s, artist_to_member p where songid = '$songid' and s.artistid = p.artistid and type in ( 'creditedsw', 'featured', 'primary' ) ", "memberid", "memberid" );
    $tmpg = db_query_array( "select distinct(memberid) from song_to_group s, group_to_member p where songid = '$songid' and s.groupid = p.groupid", "memberid", "memberid" );

    $merged = array_merge( $tmpa, $tmpp, $tmpg );
    $unique = array_unique( $merged );

    // print_r( $merged );
    // echo( "<br><br>" );
    // print_r( $unique );
    // echo( "<br><br>" );
    $autocalcvalues["TotalCount"] = count( $unique );


    $anyfemale = db_query_first_cell( "select count(*) from song_to_artist a, artist_to_member b, members c where c.id = b.memberid and type = 'primary' and MemberGender = 'Female' and songid = $songid and a.artistid = b.artistid" );    
    
    $anyfemalegroup = db_query_first_cell( "select count(*) from song_to_group a, group_to_member b, members c where c.id = b.memberid and type = 'primary' and MemberGender = 'Female' and songid = $songid and a.groupid = b.groupid" ); 
    
    
    $anyfemalefeat = db_query_first_cell( "select count(*) from song_to_artist a, artist_to_member b, members c where c.id = b.memberid and type = 'featured' and MemberGender = 'Female' and songid = $songid and a.artistid = b.artistid" );    
    
    $anyfemalefeat += db_query_first_cell( "select count(*) from song_to_group a, group_to_member b, members c where c.id = b.memberid and type = 'featured' and MemberGender = 'Female' and songid = $songid and a.groupid = b.groupid" ); 
    
    $anymalefeat = db_query_first_cell( "select count(*) from song_to_artist a, artist_to_member b, members c where c.id = b.memberid and type = 'featured' and MemberGender = 'Male'  and songid = $songid and a.artistid = b.artistid" );    
    
    $anymalefeat += db_query_first_cell( "select count(*) from song_to_group a, group_to_member b, members c where c.id = b.memberid and type = 'featured' and MemberGender = 'Male' and songid = $songid and a.groupid = b.groupid" ); 
    
    
    
    $autocalcvalues["PrimaryGender"] = $anyfemale || $anyfemalegroup ? "Female":"Male";
    $autocalcvalues["FeatGender"] = "";
    
    if( $anyfemalefeat || $anymalefeat )
	{
	    if( $anymalefeat && $anyfemalefeat )
		$autocalcvalues["FeatGender"] = "Both";
	    else if ( $anymalefeat )
		$autocalcvalues["FeatGender"] = "Male";
	    else
		$autocalcvalues["FeatGender"] = "Female";
	    
	}
    


    
    foreach( $autocalcvalues as $aid=>$val )
    {
	//	echo( "$srow[CleanUrl] - update songs set $aid = '$val' where id = $songid<br>" );
	db_query( "update songs set $aid = '$val' where id = $songid" );
    }
    
}

}

function doMembersUpdate( $tablename )
{
      if( $tablename == "groups" )
      {
          $groups  = db_query_rows( "select * from groups" );
	  foreach( $groups as $g )
	      {
		  db_query( "delete from group_to_member where groupid = $g[id]" );
		  $exp = explode( ";", $g["artists"] );
		  //    print_r( $exp );exit;
		  foreach( $exp as $v )
		      {
			  $v = trim( $v );
			  if( $v )
			      {
				  $newid = getOrCreate( "members", $v, "StageName" );
				  db_query( "insert into group_to_member ( groupid, memberid ) values ( '$g[id]', '$newid' )" );
			      }
			  
		      }
	      }
      }
      if( $tablename == "producers" )
      {
          $groups  = db_query_rows( "select * from producers" );
	  foreach( $groups as $g )
	      {
		  $pid = $g[id];
		  db_query( "delete from producer_to_member where producerid = $pid" );
		  for( $i = 1; $i <=6; $i++ )
		      {
			  if( trim( $g["member". $i] ))
			      {
				  $v = trim(  $g["member". $i] );
				  $newid = getOrCreate( "members", $v, "StageName" );
				  db_query( "insert into producer_to_member ( producerid, memberid ) values ( '$pid', '$newid' )" );
				  
			      }
		      }
	  
	      }
      }
      if( $tablename == "artists" )
      {
	  $artists = db_query_rows( "select * from artists" );
	  foreach( $artists as $arow )
	      {
		  $newid = getOrCreate( "members", $arow["Name"], "StageName" );


		  foreach( array( "City", "Wikipedia", "ArtistURL", "FullBirthName", "YearBorn", "WhereBorn", "FirstName", "LastName", "MiddleName" ) as $field )
		      {
			  db_query( "update members set {$field} = '" . escMe( $arow[$field] ) . "' where id = $newid" );
		      }
		  db_query( "delete from artist_to_member where artistid = $arow[id]" );
		  db_query( "insert into artist_to_member ( artistid, memberid ) values ( '$arow[id]', '$newid' )" );
	      }
	  
      }
      db_query( "delete from members where id not in ( select memberid from artist_to_member ) and id not in ( select memberid from producer_to_member ) and id not in ( select memberid from group_to_member );" );

}

$resources = array(); 

$resources["pitchfork"] = "https://pitchfork.com/rss/news/";

$resources["billboard"] = "https://www.billboard.com/articles/rss.xml";

$resources["feedburner"] = "https://feeds.feedburner.com/fuse/latest";

$resources["nme"] = "https://www.nme.com/news/music/feed";

$resources["spin"] = "https://www.spin.com/feed/";

$resources["digitalmusicnews"] = "https://www.digitalmusicnews.com/feed/";

$resources["musicbusinessworldwide"] = "https://www.musicbusinessworldwide.com/feed";

//$resources["wired"] = "https://www.wired.com/about/rss_feeds/";

$resources["nytimes"] = "https://rss.nytimes.com/services/xml/rss/nyt/Music.xml";

$resources["rollingstone"] = "https://www.rollingstone.de/feed/";

$resources["rollingstonereviews"] = "https://www.rollingstone.de/reviews/feed/";

$resources["hypebot"] = "https://www.hypebot.com/feed";

$resources["drownedinsound"] = "http://dis11.herokuapp.com/feed/index";

$resources["popjustice"] = "https://www.popjustice.com/feed/";

$resources["rsssearchhub"] = "https://hiphopwired.com/category/news/feed/";

$resources["stereogum"] = "https://www.stereogum.com/feed/";

$resources["npr"] = "https://www.npr.org/rss/rss.php?id=1039";

$resources["bbc"] = "http://www.bbc.co.uk/feeds/rss/music/latest_releases.xml";

$resources["relix"] = "https://relix.com/feed/";


$admin_hasadvsearch = false;
?>
