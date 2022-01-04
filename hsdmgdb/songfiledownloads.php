<? 

include "connect.php";

 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

$songs = db_query_array( "select distinct( pdfid ) , CleanUrl from songfiledownloads, songs where pdfid = songs.id order by LogicFilenameDate desc, dateadded desc", "pdfid", "CleanUrl" ); 
include "nav.php";
?>
<br><h3>Downloads</h3>
<Br><br>
<? 
$ids = array();
foreach( $songs as $sid=>$songname )
{
	$ids[] = $sid;
echo( "<a href='editsong.php?songid=$sid'><h3>$songname</h3></a>

" );
echo( " <a class=\"expand-btn expand-btn-{$sid}\"></a> <div id=\"search-hidden-{$sid}\" class=\"hide\"><table class='content' border=1 cellpadding=4 cellspacing=0 >
<tR><th>Username</th><th>Date</th></tr>" );
$vals  = db_query_rows( "Select * from songfiledownloads where pdfid = '$sid'" );
foreach( $vals as $pdf )
{
    echo( "<tr><td style=\"padding: 4px !important\">$pdf[username] </td>
<td style=\"padding: 4px !important\">$pdf[dateadded]</td>
</tr>" );
}
echo( "</table></div><br><br>" );
}
?>
</table>
</div>
</form>
	<script>
		$(document).ready(function(){
<? foreach( $ids as $id ) { ?>
		    $("a.expand-btn-<?=$id?>").click(function(){
		        $("a.expand-btn-<?=$id?>").toggleClass("collapse-btn");
		        $("#search-hidden-<?=$id?>").toggleClass("hide show");
		    });
<? } ?>
} );
</script>
<? include "footer.php"; ?>
