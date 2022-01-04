<? 
include "connect.php";

$tablename = "customtitles";

$uppercasesingle = "Custom Title";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );


if( $addnew && $newname )
  {
      $ins = db_query_insert_id( "insert into $tablename ( Name, Value ) values ( '". escMe( trim( $newname ) ) ."', '". escMe( trim( $newvalue ) ) ."' )" );
  }
if( $del )
  {
    db_query( "delete from $tablename where id = $del" );
  }

if( $update )
  {
    foreach( $names as $id=>$name )
      {
          db_query( "update $tablename set Name = '". escMe( $name ) ."' where id = $id" );
          $value = $values[$id];
          db_query( "update $tablename set Value = '". escMe( $value ) ."' where id = $id" );
      }
  }

$res = db_query_rows( "select * from $tablename order by lower( Name )" );

include "nav.php";


?>
<a href='#A'>A</a>
<a href='#B'>B</a> | <a href='#C'>C</a> | <a href='#D'>D</a> | <a href='#E'>E</a> | <a href='#F'>F</a> | <a href='#G'>G</a> | <a href='#H'>H</a> | <a href='#I'>I</a> | <a href='#J'>J</a> | <a href='#K'>K</a> | <a href='#L'>L</a> | <a href='#M'>M</a> | <a href='#N'>N</a> | <a href='#O'>O</a> | <a href='#P'>P</a> | <a href='#Q'>Q</a> | <a href='#R'>R</a> | <a href='#S'>S</a> | <a href='#T'>T</a> | <a href='#U'>U</a> | <a href='#V'>V</a> | <a href='#W'>W</a> | <a href='#X'>X</a> | <a href='#Y'>Y</a> | <a href='#Z'>Z</a> | 
<h3><?=$uppercase?></h3>
<form method='post' action='<?=$tablename?>.php'>
<font color='red'>TO SEE TITLES ON A PAGE, ADD THIS TO THE URL: ?showtitles=1 (or &showtitles=1 if there is already a question mark in the url)</font><br>
    STYLING NOTE: To put this in the code, use this:
<br>
    <textarea cols=40 rows='2'>
<?     echo( '<?=getOrCreateCustomTitle( "Name Goes Here" )?>' );?>
</textarea><Br><br>
    <table class="cmstable"><tr><th>Name</th><th>Value</th>
<th>Del?</th></tr>

  <? if( !count( $res ) ) { ?><tr><td colspan='4'>No <?=$lowercase?> found.</td></tr>
			    <? } ?>

			    <? foreach( $res as $r ) { 
if( strtoupper( $r[Name][0] ) != $lastletter )
{
	$lastletter = strtoupper( $r[Name][0] );
	echo( "<tr><td><a name='$lastletter'></a> $lastletter </td></tr>" );
}
?>
<tr><td><a name="<?=$r[Name]?>"></a><input type='text' name="names[<?=$r[id]?>]" size='40' value="<?=$r[Name]?>"></td>
<td><textarea cols='40' rows='5'  name='values[<?=$r[id]?>]'><?=$r[Value]?></textarea></td>
<td>                           <A onClick='return confirm( "Are you sure you want to delete this?" )' href='<?=$tablename?>.php?del=<?=$r[id]?>'>Del?</a>
</a>
</tr>
  <? }?>
</table>

<input type='submit' name='update' value='Update'><br><br>

<b>  Add New:</b><br>
<table>
    <tr><td>
<?=$altname?$altname:"Name"?>:</td><td> <input type='text' name='newname' size='50' value=''></td></tr>

      <tr><Td>Value:</tD><td><textarea cols='100' rows='5' name='newvalue'></textarea></td></tr>
</table> <br><input type='submit' name='addnew' value='Add'>
<br><br>
<? include "footer.php"; ?>