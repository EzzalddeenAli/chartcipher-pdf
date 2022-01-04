<? 

include "connect.php";

 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

$tm = time();
$typedir = strtolower( $type );
$typedir = str_replace( " ", "", $typedir );

if( $del )
    {
	db_query( "delete from pdfuploads where id = $del" );
    }

if( $submit )
{
	
    if( $_FILES["newPDF"]["tmp_name"] )
    {
        $filelocale = $_FILES["newPDF"]["tmp_name"];
        $filename = $tm . $_FILES["newPDF"]["name"];
	$key = md5( $filename );
	
        move_uploaded_file( $filelocale, "../pdf{$typedir}/{$filename}" );
        db_query( "insert into pdfuploads( keyname, filename, type, dateuploaded ) values ( '$key', '" . escMe( $filename )."', '" . escMe( $type )."', now() )" );
    }
}
$vals = db_query_rows( "select * from pdfuploads where type = '$type'" );


$typestr = "PDF";
if( $typedir == "logicfiles" ) $typestr = "ZIP";
include "nav.php";
?>
<h3>Homepage</h3>

<form method='post' enctype='multipart/form-data'>
<table>
<tr><td>Upload New <?=$typestr?>:</td><td> <input type='file' name='newPDF'>
</td></tr>
</table>
<input type='submit' name='submit' value='Upload'>
<Br><Br><h3>Existing Files</h3>
<table class='content' border=1 cellpadding=4 cellspacing=0 >
<tR><th>Filename</th><th>URL For Download</th><th>Link</th><th>Downloads</th><th>Delete?</th></tr>
<? 

foreach( $vals as $pdf )
{
	$dls = db_query_first_cell( "select count(*) from pdfdownloads where pdfid = $pdf[id]" );
    $filename = "/pdf{$typedir}/dl.php?key=$pdf[keyname]";
    echo( "<tr><td style=\"padding: 4px !important\">$pdf[filename]</td>
<td style=\"padding: 4px !important\">https://analytics.chartcipher.com{$filename}</td>
<td style=\"padding: 4px !important\"><a href='https://analytics.chartcipher.com{$filename}'>Download</a></td>
<td style=\"padding: 4px !important\"><a href='pdfdownloads.php?id=$pdf[id]'>View Downloads ({$dls})</a></td>
<td style=\"padding: 4px !important\"><a href='pdfuploads.php?type=$type&del=$pdf[id]' onClick='return confirm( \"Are you sure you want to delete this PDF? It cannot be recovered.\" )'>DELETE</a></td>
</tr>" );
}

?>
</table>
</form>
<? include "footer.php"; ?>
