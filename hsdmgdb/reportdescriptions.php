<? 
include "connect.php";

$tablename = "subreports";

$uppercasesingle = "Report";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );

$extracolumns = array( "type"=>"Type", "description"=>"Description", "OrderBy"=>"OrderBy", "onequarter"=>"Only One Quarter? (1 for \"yes\" or 0 for \"no\")", "sheetname"=>"Sheet Name" );
$extracolumnsizes = array( "description"=>"100", "sheetname"=>"20", "OrderBy"=>"3", "onequarter"=>"2", "type"=>10 );

if( $addnew && $newname )
  {
    $ins = db_query_insert_id( "insert into $tablename ( name ) values ( '$newname' )" );
    if( isset( $extracolumns ) )
      {
	foreach( $extracolumns as $k=>$throwaway )
	  {
	    db_query( "update $tablename set $k = '" . $_POST["new". $k] . "' where id = $ins" );
	  }
      }
  }
if( $del )
  {
    db_query( "delete from $tablename where id = $del" );
  }

if( $update )
  {
    foreach( $names as $id=>$name )
      {
	db_query( "update $tablename set name = '$name' where id = $id" );
	if( isset( $extracolumns ) )
	  {
	    foreach( $extracolumns as $k=>$throwaway )
	      {
		db_query( "update $tablename set $k = '" . $_POST[$k][$id] . "' where id = $id" );
	      }
	  }
	
      }
  }

$res = db_query_rows( "select * from $tablename order by type, OrderBy , name" );


include "nav.php";
?>

<h3><?=$uppercase?></h3>
<form method='post' action='reportdescriptions.php'>
  <table class="cmstable"><tr><th><?=$altname?$altname:"Name"?></th>
<? if( isset( $extracolumns ) ) { 
    foreach( $extracolumns as $k=>$display ) { ?>
<th><?=$display?></th>
					       <? } } ?>
<th>Del?</th></tr>

  <? if( !count( $res ) ) { ?><tr><td colspan='4'>No <?=$lowercase?> found.</td></tr>
			    <? } ?>

			    <? foreach( $res as $r ) { ?>
<tr><td><input type='text' name="names[<?=$r[id]?>]" value="<?=$r[name]?>"></td>
<? if( isset( $extracolumns ) ) { 

    foreach( $extracolumns as $k=>$display ) { 
      $sz = "size='20'";
      if( isset( $extracolumnsizes ) && $extracolumnsizes[$k] )
	{
	  $sz = "size='{$extracolumnsizes[$k]}' ";
	}

?>
<td><input type='text'  <?=$sz?> name='<?=$k?>[<?=$r[id]?>]' value="<?=$r[$k]?>"></td>
					       <? } } ?>
<td>
<A onClick='return confirm( "Are you sure you want to delete this?" )' href='<?=$tablename?>.php?del=<?=$r[id]?>'>Del?</a>
</td></tr>
  <? }?>
</table>

<input type='submit' name='update' value='Update'><br><br>
<!--
<b>  Add New:</b><br>
<table><tr><td>
<?=$altname?$altname:"name"?>:</td><td> <input type='text' name='newname' size='40' value=''></td></tr>
<? if( isset( $extracolumns ) ) { 
    foreach( $extracolumns as $k=>$display ) { 
      $sz = "";
      if( isset( $extracolumnsizes ) && $extracolumnsizes[$k] )
	{
	  $sz = "size='{$extracolumnsizes[$k]}' ";
	}

?>
<tr><td><?=$display?>:</td><td><input type='text' <?=$sz?> name='new<?=$k?>' value=""></td></tr>
					       <? } } ?>
</table> <br><input type='submit' name='addnew' value='Add'>
-->
<br><br>
<? include "footer.php"; ?>