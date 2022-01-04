<? 
include "connect.php";

$tablename = "customhovers";

$uppercasesingle = "Custom Hover";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );


if( $addnew && $newname )
  {
      $ins = db_query_insert_id( "insert into $tablename ( Name, Value, WhereGoes ) values ( '". escMe( trim( $newname ) ) ."', '". escMe( trim( $newvalue ) ) ."', '". escMe( trim( $newwg ) ) ."' )" );
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
          $value = $wheregoes[$id];
          db_query( "update $tablename set WhereGoes = '". escMe( $value ) ."' where id = $id" );
          $value = $hovercategory[$id];
          db_query( "update $tablename set hovercategory = '". escMe( $value ) ."' where id = $id" );
      }
  }

if( $cat ) 
    $whr = "where hovercategory = '$cat'";
$res = db_query_rows( "select * from $tablename $whr order by lower( Name )" );

include "nav.php";

$cats = db_query_array( "select distinct( hovercategory ) from customhovers order by hovercategory", "hovercategory", "hovercategory" );
$any = false;
foreach( $cats as $c )
{
	if( $any ) echo( " | " );
	echo( "<a href='customhovers.php?cat={$c}'>{$c}</a>" );
	$any = true;
}
?>
<br><br>
<a href='#A'>A</a>
<a href='#B'>B</a> | <a href='#C'>C</a> | <a href='#D'>D</a> | <a href='#E'>E</a> | <a href='#F'>F</a> | <a href='#G'>G</a> | <a href='#H'>H</a> | <a href='#I'>I</a> | <a href='#J'>J</a> | <a href='#K'>K</a> | <a href='#L'>L</a> | <a href='#M'>M</a> | <a href='#N'>N</a> | <a href='#O'>O</a> | <a href='#P'>P</a> | <a href='#Q'>Q</a> | <a href='#R'>R</a> | <a href='#S'>S</a> | <a href='#T'>T</a> | <a href='#U'>U</a> | <a href='#V'>V</a> | <a href='#W'>W</a> | <a href='#X'>X</a> | <a href='#Y'>Y</a> | <a href='#Z'>Z</a> | 
<h3><?=$uppercase?></h3>
<form method='post' action='<?=$tablename?>.php'>
<font color='red'>TO SEE HOVERS ON A PAGE, ADD THIS TO THE URL: ?showhovers=1 (or &showhovers=1 if there is already a question mark in the url)</font><br>
    STYLING NOTE: To put this in the code, use this:
<br>
    <textarea cols=40 rows='2'>
<?     echo( '<?=getCustomHover( "Name Goes Here" )?>' );?>
</textarea><Br><br>
    <table class="cmstable"><tr><th>Name</th><th>Value</th><th>Where This Goes?</th>
<th>Category</th>
<th>Use Count</th>
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
<td><input type='text' size='40' name="wheregoes[<?=$r[id]?>]" value="<?=$r[WhereGoes]?>"></td>
<td><input type='text' size='40' name="hovercategory[<?=$r[id]?>]" value="<?=$r[hovercategory]?>"></td>
<td><?=$r[usecount]?></td>
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
    <tr><td>Where This Goes?</td><td> <input type='text' name='newwg' value=''></td></tr>
</table> <br><input type='submit' name='addnew' value='Add'>
<br><br>
<? include "footer.php"; ?>
