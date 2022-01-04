<? 

include "connect.php";

$row = db_query_first( "select * from pdfuploads where id = $id" );

$vals = db_query_rows( "select * from pdfdownloads where pdfid = '$id' order by dateadded desc" );

include "nav.php";
?>
<br><h3>Downloads for <?=$row[filename]?></h3>
<Br><br>
<table border=1 cellpadding=4 cellspacing=0 >
<tR><th>Username</th><th>Date</th></tr>
<? 

foreach( $vals as $pdf )
{
    echo( "<tr><td style=\"padding: 4px !important\">$pdf[username]</td>
<td style=\"padding: 4px !important\">$pdf[dateadded]</td>
</tr>" );
}

?>
</table>
</form>
<? include "footer.php"; ?>
