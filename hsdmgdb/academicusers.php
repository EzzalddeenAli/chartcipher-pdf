<? 
include "connect.php";

 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

$whr = "";
if( $userid )
    $whr .= " and userid = '$userid'";

if( $go )
{
    $res = db_query_rows( "select * from proxylogins where 1 $whr order by id desc" );
}
$userarr = db_query_array( "select user_id, login from reports_amember.am_user", "user_id", "login" );
$userarr[0] = "Not Logged In";

$cols = array();
$cols[] = "email";
$cols[] = "userid";
$cols[] = "type";
$cols[] = "firstname";
$cols[] = "lastname";
$cols[] = "facultyorstudent";

if( $export )
{
    require_once "Spreadsheet/Excel/Writer.php";
    $xls = new Spreadsheet_Excel_Writer();
    $filename = "usage_report.xls";
    $xls->send( $filename );

	$sheet =& $xls->addWorksheet("Usage");

    foreach( $cols as $c )
        $sheet->write( $rownum, $colnum++, $c );

    $already = array();
    foreach( $res as $r )
    {
        if( $already[$r[sessionid]] ) continue;
        $already[$r[sessionid]] = 1;
        $rownum++; $colnum = 0;
        foreach( $cols as $c )
        {
            if( $c == "userid" && isset( $userarr[$r[$c]] ) )
            {
                $sheet->write( $rownum, $colnum++, $userarr[$r[$c]] );
            }
            else
            {
                $sheet->write( $rownum, $colnum++, $r[$c] );
            }
        }
    }

    $xls->close();

    exit;    
}


include "nav.php";
?>

<h3><?=$uppercase?></h3>
<form method='post' action='academicusers.php'>
Filter By: <br>
<table>
<tr><td>User ID:</td><td><select name='userid'>
<option></option>
<? 
$us = db_query_array( "select distinct( userid ) from proxylogins where userid > 0 order by userid", "userid", "userid" );
foreach( $us as $u )
{
    if( isset( $userarr[$u] ) )
        $us[$u] = $userarr[$u];
}
asort( $us );

outputSelectValues( $us, $userid );
?>
</select></td></tr>
<tR><td>Export as CSV? <input type='checkbox' name='export' value='1'></td></tr>
<tR><td><input type='submit' name='go' value='Go'></td></tr>
</table>
    <? if( $go ) { ?>
  <table border=1 cellpadding=2 cellspacing=0 class="cmstable"><tr>
<?    foreach( $cols as $k=>$display ) { ?>
<th><?=$display?></th>
<? } ?>
</tr>

  <? if( !count( $res ) ) { ?><tr><td colspan='4'>Nothing found found.</td></tr>
			    <? } ?>

			    <? foreach( $res as $r ) {
                ?>
<tr>
<? 
foreach( $cols as $k ) { 
?>
<td>
<? if( $k == "dateadded" ) { ?><nobr><? } ?>
<?             if( $k == "userid" && isset( $userarr[$r[$k]] ) )
            {
                echo( $userarr[$r[$k]] );
            }
else
    echo( $r[$k] );
?>
</nobr></td>

					       <? } ?>
</tr>
  <? }?>
</table>
                   <? } ?>
<br><br>
<? include "footer.php"; ?>