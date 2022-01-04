<? 
include "connect.php";

$tablename = "graphnotes";

$uppercasesingle = "Graph Notes";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );



if( $addnew && $newname )
  {
      $ins = db_query_insert_id( "insert into $tablename ( Name, Value, WhereGoes ) values ( '". escMe( $newname ) ."', '". escMe( $newvalue ) ."', '". escMe( $newwg ) ."' )" );
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

$res = db_query_rows( "select * from $tablename order by Name" );

include "nav.php";
?>

<h3><?=$uppercase?></h3>
<form method='post' action='<?=$tablename?>.php'>
    <table class="cmstable"><tr><th>Name</th><th>Value</th>
<th>Del?</th></tr>

  <? if( !count( $res ) ) { ?><tr><td colspan='4'>No <?=$lowercase?> found.</td></tr>
			    <? } ?>

			    <? foreach( $res as $r ) { ?>
<tr><td>
<a name='<?=$r[Name]?>'></a>
<input type='text' size='40' name="names[<?=$r[id]?>]" value='<?=$r[Name]?>'></td>
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
<?=$altname?$altname:"Name"?>:</td><td> <input type='text' size='40' name='newname' value=''></td></tr>

      <tr><Td>Value:</tD><td><textarea name='newvalue'></textarea></td></tr>
</table> <br><input type='submit' name='addnew' value='Add'>
<br><br>
<? include "footer.php"; ?>