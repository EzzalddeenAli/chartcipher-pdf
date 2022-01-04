<? 
include "connect.php";

if( $deltype ) 
    {
	db_query( "delete from techniquetypes where id = $deltype" );
    }
if( $delcat ) 
    {
	db_query( "delete from techniquecategories where id = $delcat" );
    }
if( $submit )
{
	foreach( $tnames as $tid=>$tname )
	{
	    $hiddenid = $hiddenids[$tid];
	    $def = $tdef[$tid];
	    if( $tname ) 
		{
		    if( !$hiddenid )
			{
			    $hiddenid = db_query_insert_id( "insert into techniquetypes ( techniqueid ) values ( '$id' ) " );
			}
		    db_query( "update techniquetypes set Definition = '$def', Name = '$tname' where id = $hiddenid" );
		}
	}
	foreach( $tcats as $tid=>$tname )
	{
	    $hiddenid = $hiddencatids[$tid];
	    $def = $tcatsdef[$tid];
	    if( $tname ) 
		{
		    if( !$hiddenid )
			{
			    $hiddenid = db_query_insert_id( "insert into techniquecategories ( techniqueid ) values ( '$id' ) " );
			}
		    db_query( "update techniquecategories set Definition = '$def', Name = '$tname' where id = $hiddenid" );
		}
	}
}
$techniquetypes = db_query_rows( "select * from techniquetypes where techniqueid = $id" );
for( $i = 0; $i < 4; $i++ )
    $techniquetypes[] = array();
include "nav.php";

$thisrow = db_query_first( "select * from techniques where id = $id" );
?>
<form method='post'>
<a href='techniques.php'>All Techniques</a><br>
    <h2>Edit Technique: <?=$thisrow[Name]?></h2>
<? if( 1 == 0 ) { ?>
<br>
<h3>Types</h3>
<table>
<? 
    $row = 0;
    foreach( $techniquetypes as $trow )
{
    $any = false;
    if($trow[id] )
	$any = db_query_first_cell( "select * from song_to_technique where techniquetypeid = '$trow[id]'" );
?>
<input type='hidden' name='hiddenids[<?=$row?>]' value='<?=$trow[id]?>'>
<tr><td><input type='text' name='tnames[<?=$row?>]' value="<?=$trow[Name]?>"></td>
<td><textarea name='tdef[<?=$row?>]'><?=$trow[Definition]?></textarea></td>
<td>
     <? if( $any ) { ?>
<?=$any?> techniques connected. 
		     <? } else if( $trow[id] ) { ?>
<A href='edittechnique.php?deltype=<?=$trow[id]?>&id=<?=$id?>'>Delete</a>
	<? } ?>
</td>
</tr>
	<? 
      $row++;
} ?>
</table>
<br>
<br>
<? } ?>
<h3>Categories</h3>
    <i>Clear to remove</i>
<table>
<tr><th>Name</th><th>Definition</th></tr>
<? 
$techniquecategories = db_query_rows( "select * from techniquecategories where techniqueid = $id" );
for( $i = 0; $i < 4; $i++ )
    $techniquecategories[] = array();


    $row = 0;
    foreach( $techniquecategories as $trow )
{
    $any = false;
    if($trow[id] )
	$any = db_query_first_cell( "select * from song_to_technique where techniquecategoryid = '$trow[id]'" );
?>
<input type='hidden' name='hiddencatids[<?=$row?>]' value='<?=$trow[id]?>'>
<tr><td><input type='text' name='tcats[<?=$row?>]' value="<?=$trow[Name]?>"></td>
<td><textarea name='tcatsdef[<?=$row?>]'><?=$trow[Definition]?></textarea></td>
<td><? if( $trow[id] ) { ?><A href='edittechniquesub.php?id=<?=$trow[id]?>'>Edit Subcategories</a><? } ?></td>
<td>
     <? if( $any ) { ?>
<?=$any?> techniques connected. 
		     <? } else if( $trow[id] ) { ?>
<A href='edittechnique.php?delcat=<?=$trow[id]?>&id=<?=$id?>'>Delete</a>
	<? } ?>
</td>
</tr>
	<? 
      $row++;
} ?>
</table>

<input type='submit' name='submit' value='Save'>
</form>
