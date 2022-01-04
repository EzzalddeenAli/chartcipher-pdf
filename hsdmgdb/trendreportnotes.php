<? 
include "connect.php";

$tablename = "trendreportnotes";

$uppercasesingle = "Trend Report Notes";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );



if( $update )
  {
      db_query( "delete from trendreportnotes" );
      foreach( $values as $vid=>$varr )
      {
          foreach( $varr as $vkey=>$vvalue )
          {
              db_query( "insert into trendreportnotes ( quarter, sectionname, value ) values ( '$vid', '$vkey', '" . escMe( $vvalue ) . "' )" );
          }
      }
      
  }

include "../trendreportfunctions.php";

$allquarters = getQuarters( 1, 2012, 4, date( "Y" ) );
include "nav.php";
?>

<h3><?=$uppercase?></h3>
<form method='post' action='trendreportnotes.php'>
    <? foreach( $allquarters as $q ) { ?>
    <a href='#<?=$q?>'><?=$q?></a> |
                                       <? } ?>
    <table class="cmstable" border=1><tr><th>Location</th><th>Name</th><th>Value</th>
</tr>

			    <? foreach( $reportsarr as $rid=>$rval ) { ?>
<tr>
<td>Note Area</td>
<td><?=$rval?></td>
<td><textarea cols='100' rows='5'  name='values[0][<?=$rid?>]'><?=getTrendReportNote( 0, $rid )?></textarea></td>
</tr>
  <? }?>


<? foreach( $allquarters as $q ) { ?>
    <tr><th colspan='4'><a name='<?=$q?>'></a><b><?=$q?></b></th></tr>
			    <? foreach( $reportsarr as $rid=>$rval ) { ?>
<tr>
<td><?=$q?></td>
<td><?=$rval?></td>
<td><textarea cols='100' rows='5'  name='values[<?=$q?>][<?=$rid?>]'><?=getTrendReportNote( $q, $rid )?></textarea></td>
</tr>
  <? }?>
<? } ?>


</table>

<input type='submit' name='update' value='Update'><br><br>

<lyricabr><br>
<? include "footer.php"; ?>