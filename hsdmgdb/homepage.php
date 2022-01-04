<? 

include "connect.php";


$tm = time();

if( $submit )
{
	
	$newvals = array();
	$newvals[blurb] = $newBlurb;
	$newvals[title] = $newTitle;
	$newvals[workurl] = $newWorkURL;
	for( $i = 2; $i <= 5; $i++ )
	{
        $newvals["workurl{$i}"] = $_POST["newWorkURL{$i}"];
	}

    if( $_FILES["newPDF"]["tmp_name"] )
    {
        $filelocale = $_FILES["newPDF"]["tmp_name"];
        $filename = $tm . $_FILES["newPDF"]["name"];
        $newvals["pdf"] = $filename;

        move_uploaded_file( $filelocale, "../homepage/{$filename}" );
    }
    if( $_FILES["newImage"]["tmp_name"] )
    {
        $filelocale = $_FILES["newImage"]["tmp_name"];
        $filename = $tm . $_FILES["newImage"]["name"];
        $newvals["image"] = $filename;

        move_uploaded_file( $filelocale, "../homepage/{$filename}" );
    }
    if( $_FILES["newWork"]["tmp_name"] )
    {
        $filelocale = $_FILES["newWork"]["tmp_name"];
        $filename = $tm . $_FILES["newWork"]["name"];
        $newvals["workshop"] = $filename;

        move_uploaded_file( $filelocale, "../homepage/{$filename}" );
    }
    for( $i = 2; $i <= 5; $i++ )
    {
        if( $_FILES["newWork{$i}"]["tmp_name"] )
        {
            $filelocale = $_FILES["newWork{$i}"]["tmp_name"];
            $filename = $tm . $_FILES["newWork{$i}"]["name"];
            $newvals["workshop{$i}"] = $filename;
            
            move_uploaded_file( $filelocale, "../homepage/{$filename}" );
        }
    }
    foreach( $newvals as $key=>$val )
    {
        db_query( "delete from homepage where name = '$key'" );
        db_query( "insert into homepage( name, value ) values ( '$key', '" . escMe( $val )."' )" );
    }
}
$vals = db_query_array( "select name, value from homepage", "name", "value" );

include "nav.php";
?>
<h3>Homepage</h3>

<form method='post' enctype='multipart/form-data'>
<table>
<tr><td>PDF:</td><td> <input type='file' name='newPDF'>
<? if( $vals["pdf"] ) { ?><a  href='../homepage/<?=$vals[pdf]?>'>View Current</a><? } ?>

</td></tr>
<tr><td>Image:</td><td> <input type='file' name='newImage'>
<? if( $vals["image"] ) { ?><a  href='../homepage/<?=$vals[image]?>'>View Current</a><? } ?>

</td></tr>
<tr><td>Bottom Right Image:</td><td> <input type='file' name='newWork'>
<? if( $vals["workshop"] ) { ?><a  href='../homepage/<?=$vals[workshop]?>'>View Current</a><? } ?>
<? for( $i = 2; $i <= 5; $i++ ) { ?>
    <tr><td>Bottom Right Image (<?=$i?>):</td><td> <input type='file' name='newWork<?=$i?>'>
<? if( $vals["workshop{$i}"] ) { ?><a  href='../homepage/<?=$vals["workshop{$i}"]?>'>View Current</a><? } ?>
</td></tr>
           <? } ?>
<tr><td>Bottom Right URL:</td><td> <input type='text' name='newWorkURL' size="100" value="<?=$vals["workurl"]?>">
<? for( $i = 2; $i <= 5; $i++ ) { ?>
<tr><td>Bottom Right URL:</td><td> <input type='text' name='newWorkURL<?=$i?>' size="100" value="<?=$vals["workurl$i"]?>">
<? } ?>
    </td></tr>
<tr><td>Title:</td><td> <textarea name='newTitle' cols='100'><?=$vals["title"]?></textarea>
    <br><i>Use:     &lt;span class="orangeTitle"&gt;WORDS GO HERE&lt;/span&gt; to make orange</i><br><br>
    </td></tr>
<tr><td>Blurb:</td><td> <textarea cols='100' rows='10' name='newBlurb'><?=$vals[blurb]?></textarea></td></tr>
</table>
<input type='submit' name='submit' value='Update'>
<Br><Br><h3>Existing Files</h3>
<? 
$s = scandir( "../homepage" );
foreach( $s as $pdf )
{
	if( strpos( "$pdf", "htaccess" ) !== false ) continue;
	if( strpos( "$pdf", "php" ) !== false ) continue;
$filename = "../homepage/$pdf";
if( is_file( $filename ) )
echo( "<a href='$filename'>$filename</a><br>" );
}

?>
</form>
<? include "footer.php"; ?>
