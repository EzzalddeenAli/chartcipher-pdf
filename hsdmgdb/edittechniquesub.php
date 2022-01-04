<? 
include "connect.php";

if( $deltype ) 
    {
	db_query( "delete from techniquesubcategories where id = $deltype" );
    }
if( $submit )
{
	foreach( $tcats as $tid=>$tname )
	{
	    $hiddenid = $hiddencatids[$tid];
	    $def = $tdef[$tid];
	    if( $tname ) 
		{
		    if( !$hiddenid )
			{
			    $hiddenid = db_query_insert_id( "insert into techniquesubcategories ( techniquecategoryid ) values ( '$id' ) " );
			}
		    db_query( "update techniquesubcategories set Definition = '$def', Name = '$tname' where id = $hiddenid" );
		}
	}
}
include "nav.php";

$thisrow = db_query_first( "select * from techniquecategories where id = $id" );
$thistech = db_query_first( "select * from techniques where id = $thisrow[techniqueid]" );
?>
<form method='post'>
<a href='techniques.php'>All Techniques</a><br>
    <h2><a href='edittechnique.php?id=<?=$thistech[id]?>'><?=$thistech[Name]?></a> > Edit Technique Category: <?=$thisrow[Name]?></h2>
<br><h3>Subcategories</h3>
<table>
<tr><th>Name</th><th>Definition</th></tr>
<? 
$techniquesubcategories = db_query_rows( "select * from techniquesubcategories where techniquecategoryid = $id" );
for( $i = 0; $i < 4; $i++ )
    $techniquesubcategories[] = array();


    $row = 0;
    foreach( $techniquesubcategories as $trow )
{
    $any = false;
    if($trow[id] )
	$any = db_query_first_cell( "select * from song_to_technique where techniquesubcategoryid = '$trow[id]'" );
?>
<input type='hidden' name='hiddencatids[<?=$row?>]' value='<?=$trow[id]?>'>
<tr><td><input type='text' name='tcats[<?=$row?>]' value="<?=$trow[Name]?>"></td>
<td><textarea name='tdef[<?=$row?>]'><?=$trow[Definition]?></textarea></td>
     <td><? if( $trow[id] ) { ?><A href='edittechniquesubsub.php?id=<?=$trow[id]?>'>Edit Sub-subcategories</a><? } ?></td>
<td>
     <? if( $any ) { ?>
<?=$any?> techniques connected. 
		     <? } else if( $trow[id] ) { ?>
<A href='edittechniquesub.php?deltype=<?=$trow[id]?>&id=<?=$id?>'>Delete</a>
	<? } ?>
</td>
</tr>
	<? 
      $row++;
} ?>
</table>

<input type='submit' name='submit' value='Save'>
</form>
