<? 
$reporttypes = db_query_rows( "select * from subreports where type = '$overalltype' order by OrderBy", "id" );


if( $go )
  {
    require_once "Spreadsheet/Excel/Writer.php";
    $xls = new Spreadsheet_Excel_Writer();
    $filename = "{$overalltype}_report.xls";
    if( !count( $addnotes ) )
        $xls->setVersion(8);
    $xls->send( $filename );

    $percentformat =& $xls->addFormat();
    $percentformat->setNumFormat( "0%" );

    $timeformat =& $xls->addFormat();
    $timeformat->setNumFormat( "MM:SS" );
    $timeformathours =& $xls->addFormat();
    $timeformathours->setNumFormat( "HH:MM:SS" );

    $format_bold =& $xls->addFormat();
    $format_bold->setBold();

    foreach( $include as $reportid=>$throwaway ) 
      {
	$reportrow = $reporttypes[$reportid];
	$sdateq = $startquarter[$reportid];
	$sdatey = $startyear[$reportid];

	$edateq = $endquarter[$reportid]?$endquarter[$reportid]:$startquarter[$reportid];
	$edatey = $endyear[$reportid]?$endyear[$reportid]:$startyear[$reportid];

    if( $sdateq )
    {
        $str_quarter = "Quarter";
        $quarterstorun = getQuarters( $sdateq, $sdatey, $edateq, $edatey );
    }
    else
    {
        $str_quarter = "Year";
        $quarterstorun = getYears( $sdatey, $edatey );
    }
    
//    print_r( $quarterstorun );
//    exit;
//	exit;	
	$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $sdateq, $sdatey, $edateq, $edatey );
	$allsongs[] = -1;

	// just in case there were none
	$tmp = $allsongs;
//	$tmp[] = -1;
	// add a -1 

	$allsongsstr = implode( ", ", $tmp );
    
	$fields = array( $reportrow["name"], $str_quarter );
	$rownum = 0;
	$colnum = 0;
	$sheet =& $xls->addWorksheet($reportrow["sheetname"]);

	$sheet->setColumn( 0, 0, 30 );
	$sheet->setColumn( 1, 1, 10 );
	$sheet->setColumn( 2, 40, 20 );
	$addnote = $addnotes[$reportrow[id]];
	include "subreports/" . $reportrow["type"] . "_" . $reportrow["id"]. ".php";
      }
    $xls->close();
  }

include "nav.php";
?>

<h3> <?=$overalltypedisplay?> Report</h3>
<form method='post'>
<a href='#' onClick='return checkAllReports( true )'>Check All</a> | <a href='#' onClick='return checkAllReports( false )'>Uncheck All</a> <br>
<input type='checkbox' name='numberoneonly' value='1'> #1 Hits Only?<br>
    Filter by songwriter: <select name='songwriterfilter'>
    <option value=''></option>
    <?php
    $writers = db_query_rows( "select distinct( artists.id ), LastName, FirstName, Name from artists, song_to_artist where artistid = artists.id and type = 'creditedsw' and LastName > '' order by Name, LastName, FirstName", "id" );
    foreach( $writers as $wrow ) {
    echo( "<option value='$wrow[id]'>$wrow[Name] ($wrow[LastName], $wrow[FirstName])</option>" );
}
?>
    </select><br>
  <? if( $overalltype == "topten" ) { ?>
    Filter by Client: <select name='clientfilter' id='clientfilter'>
    <option value=''></option>
    <?php
    $writers = db_query_rows( "select distinct( clients.id ), Name from clients, songs where ClientID = clients.id order by Name", "id" );
    foreach( $writers as $wrow ) {
    echo( "<option value='$wrow[id]'>$wrow[Name]</option>" );
}
?>
    </select><br>
<?} ?>

  <? if( $overalltype == "trend" || $overalltype == "topten" ) { ?>
    Filter by Genre: <select name='genrefilter' id='genrefilter'>
    <option value=''></option>
    <?php
    $writers = db_query_rows( "select distinct( genres.id ), Name from genres, songs where GenreID = genres.id order by Name", "id" );
    $writers["-2"] = array( "id"=>"-2", "Name"=>"All Genres Except Hip Hop/Rap" );
    foreach( $writers as $wrow ) {
    echo( "<option value='$wrow[id]'>$wrow[Name]</option>" );
}
?>
    </select><br>

    Filter by Artist: <select name='artistfilter' id='artistfilter'>
    <option value=''></option>
    <?php
    $writers = db_query_rows( "select distinct( artists.id ), Name from artists, song_to_artist where artistid = artists.id and  type in ( 'primary', 'featured' ) order by Name", "id" );
    foreach( $writers as $wrow ) {
    echo( "<option value='$wrow[id]'>$wrow[Name]</option>" );
}
?>
    </select><br>


<?} ?>


  <? if( $overalltype == "trend" || $overalltype == "genre" ) { ?>
<input type='checkbox' name='newarrivalsonly' value='1'> New Songs Only?<br>
			      <? } ?>
<input type='submit' name='go' value='Go' onClick='return confirmCheckboxes()'>
<table border=1 class="cmstable"><tr><th>Include?</th><th>Add Song Notes?</th><th>Name</th><th>Quarter Range</th></tr>
<? 
  $first = true;
foreach( $reporttypes as $rid=>$rrow )
{
  echo ("<tr><td>&nbsp;&nbsp;<input type='checkbox' name='include[$rid]' id='{$rid}' value='1'></td>" );
 echo ("<td>&nbsp;&nbsp;&nbsp;<input type='checkbox' name='addnotes[$rid]' value='1'></td>" );
  echo( "<td>$rrow[name] ($rid)</td>" );
  echo( "<td>" );
  $ext = "";
  $extyear = "";
  if( $first ) 
    {
      $extyear = "onChange='javascript: fillEnds( this ); fillBelow( this )'";
      $ext = "onChange='javascript: fillBelow( this )'";
    }

  echo( "<select id='startm{$rid}'  $ext name='startquarter[$rid]'>" );
  echo( "<option></option>" );
  for( $i = 1; $i <= 4; $i++ )
    {
      $sel = $startquarter[$rid]==$i?"SELECTED":"";
      echo( "<option value='$i'>$i</option>" );
    }
  echo( "</select>" );

  echo( "<select $extyear id='starty{$rid}' name='startyear[$rid]'>" );
  echo( "<option></option>" );
  for( $i = date( "Y" ); $i >= 2010; $i-- )
    {
      $sel = $startyear[$rid]==$i?"SELECTED":"";
      echo( "<option value='$i'>$i</option>" );
    }
  echo( "</select>" );

  if( !$rrow["onequarter"] )
    {
  echo( " to ");

  echo( "<select $ext name='endquarter[$rid]'>" );
  echo( "<option></option>" );
  for( $i = 1; $i <= 4; $i++ )
    {
      $sel = $endquarter[$rid]==$i?"SELECTED":"";
      echo( "<option value='$i'>$i</option>" );
    }
  echo( "</select>" );
  echo( "<select $ext name='endyear[$rid]'>" );
  echo( "<option></option>" );
  for( $i = date( "Y" ); $i >= 2010; $i-- )
    {
      $sel = $endyear[$rid]==$i?"SELECTED":"";
      echo( "<option $sel value='$i'>$i</option>" );
    }
  echo( "</select>" );

    }
  echo( "</td>" );
  echo( "</tr>" );
  echo( "<tr><td colspan='4' style='padding:10px' >$rrow[description]</td></tr>" );
  $first = false;
}
?>
</table>
<input type='submit' name='go' value='Go' onClick='return confirmCheckboxes()'>
<script language='javascript'>
  function confirmCheckboxes()
{
  frm = document.forms[0].elements;
  //  alert( frm.length );	
var clientfilter = 0;
  <? if( $overalltype == "topten" ) { ?>
  clientfilter = document.getElementById( "clientfilter" ).selectedIndex;
  <? } ?>

  for( i = 0 ; i < frm.length; i++ )
    {
      ele = frm[i];
      //  alert( ele.type );
      if( ele.type == "checkbox" && ele.checked )
	{
	  //	  alert( ele.id );
	  mon = document.getElementById( "startm" + ele.id );
	  year = document.getElementById( "starty" + ele.id );
	  if( year.selectedIndex == 0 && clientfilter == 0  )
	    {
	      alert( "Month and Year must be selected for each checked report." );
	      return false;
	    }
	}
    }
  return true;

}
</script>
</form>
<? include "footer.php"; ?>