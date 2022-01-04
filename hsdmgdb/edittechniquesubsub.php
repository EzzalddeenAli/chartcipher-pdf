<? 
include "connect.php";

if( $deltype ) 
    {
	db_query( "delete from techniquesubsubcategories where id = $deltype" );
    }
if( $submit )
{
	foreach( $tcats as $tid=>$tname )
	{
	    $hiddenid = $hiddencatids[$tid];
	    if( $tname ) 
		{
		    if( !$hiddenid )
			{
			    $hiddenid = db_query_insert_id( "insert into techniquesubsubcategories ( techniquesubcategoryid ) values ( '$id' ) " );
			}
		    db_query( "update techniquesubsubcategories set Definition = '$def', Name = '$tname' where id = $hiddenid" );
		}
	}
}
include "nav.php";

$thisrow = db_query_first( "select * from techniquesubcategories where id = $id" );
$thiscat = db_query_first( "select * from techniquecategories where id = $thisrow[techniquecategoryid]" );
$thistech = db_query_first( "select * from techniques where id = $thiscat[techniqueid]" );
?>
<form method='post'>
<a href='techniques.php'>All Techniques</a><br>
    <h2><a href='edittechnique.php?id=<?=$thistech[id]?>'><?=$thistech[Name]?></a> > <a href='edittechniquesub.php?id=<?=$thiscat[id]?>'><?=$thiscat[Name]?></a> > Edit Technique Sub Category: <?=$thisrow[Name]?></h2>
<br><h3>Subsubcategories</h3>
<table>
<tr><th>Name</th><th>Definition</th></tr>
<? 
$techniquesubsubcategories = db_query_rows( "select * from techniquesubsubcategories where techniquesubcategoryid = $id" );
for( $i = 0; $i < 4; $i++ )
    $techniquesubsubcategories[] = array();


    $row = 0;
    foreach( $techniquesubsubcategories as $trow )
{
    $any = false;
    if($trow[id] )
	$any = db_query_first_cell( "select * from song_to_technique where techniquesubsubcategoryid = '$trow[id]'" );
?>
<input type='hidden' name='hiddencatids[<?=$row?>]' value='<?=$trow[id]?>'>
<tr><td><input type='text' name='tcats[<?=$row?>]' value="<?=$trow[Name]?>"></td>
<td><textarea name='tdef[<?=$row?>]'><?=$trow[Definition]?></textarea></td>
<td>
     <? if( $any ) { ?>
<?=$any?> techniques connected. 
		     <? } else if( $trow[id] ) { ?>
<A href='edittechniquesubsub.php?deltype=<?=$trow[id]?>&id=<?=$id?>'>Delete</a>
	<? } ?>
</td>
</tr>
	<? 
      $row++;
} ?>
</table>

<input type='submit' name='submit' value='Save'>
</form>
