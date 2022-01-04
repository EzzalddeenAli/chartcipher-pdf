<? 
ini_set('auto_detect_line_endings',TRUE);
include "connect.php"; ?>
<? 

    if( $save )
	{
	foreach( $settings as $name => $value )
{
		db_query( "update settings set value = '$value' where name = '$name'" );
}
	db_query( "delete from dashcache" );
	    $err = "<font color='red'>Updated.</font>";
  }


$settings = db_query_array( "select * from settings", "name", "value" );

include "nav.php";
?>
<form method='post' enctype='multipart/form-data'>
<?=$err?>
<br><br><h3>Settings</h3>
<table style="width: 500px">
<? foreach( $settings as $name=> $value ) { 
if( $name == "homepageweek" )
{
?>
<tr><td>    <?=$name?>: </td><td><select name='settings[<?=$name?>]'> 
<? 
$weekdates = db_query_array( "select id, Name from weekdates order by OrderBy desc", "id", "Name" );
outputSelectValues( $weekdates, $value ); ?>
</select>
</td></tr>
<? } 
}?>
</table>
<input type='submit' name='save' value='Save'><br>
</form>
<? include "footer.php"; ?>
