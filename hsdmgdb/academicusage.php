<? 
include "connect.php";
include "../functions.php";
 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

$academic = implode( ", ", getAcademicLogins() );

$whr = "";
if( $suserid )
    $whr .= " and userid = '$suserid'";
if( $ipaddress )
    $whr .= " and ipaddress = '$ipaddress'";
if( $email )
    $whr .= " and email = '$email'";
if( $page )
    $whr .= " and pagehit like '%$page%'";
if( $datefrom )
{
    $datefrom = date( "Y-m-d", strtotime( $datefrom ) );
    $whr .= " and dateadded >= '$datefrom'";
}
if( $dateto )
{
    $dateto = date( "Y-m-d", strtotime( $dateto ) );
    $whr .= " and dateadded <= '$dateto'";
}
if( $suserid )
    $whr .= " and userid = '$suserid'";

if( $go )
{
    $res = db_query_rows( "select * from immersionusage where userid in ( $academic ) $whr order by dateadded desc" );
}
$userarr = db_query_array( "select user_id, login from reports_amember.am_user", "user_id", "login" );
$userarr[0] = "Not Logged In";

$cols = array();
$cols[] = "dateadded";
$cols[] = "email";
$cols[] = "userid";
//$cols[] = "pagehit";
$cols[] = "ipaddress";
$cols[] = "sessionid";
$cols[] = "first page";


$montharr = array();

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
	    else if( $c == "email" && isset( $userarr[$r[$c]] ) )
            {
                $sheet->write( $rownum, $colnum++, $emails[$r[$c]] );
            }
	    else if( $c == "dateadded"  )
            {
                $sheet->write( $rownum, $colnum++, date( "m/d/y, h:i A", strtotime(  $r[$c] ) ) );
		$key = date( "Y-m", strtotime(  $r[$c] ) );
		$montharr[$key]++;
	    }
	    else if( $c == "first page"  )
            {
		$lowest = db_query_first( "select * from immersionusage where sessionid = '$r[sessionid]' order by dateadded limit 1" );
		$sheet->write( $rownum, $colnum++, $lowest["domain"] . $lowest["pagehit"] );
	    }
            else
            {
                $sheet->write( $rownum, $colnum++, $r[$c] );
            }
        }
    }

    $rownum++;
    $rownum++;
    $rownum++;
    $colnum = 0;
    ksort( $montharr );
    foreach( $montharr as $key=>$val )
    {
                    $sheet->write( $rownum, $colnum++, $key );
    }
    $rownum++;
    $colnum = 0;
    foreach( $montharr as $key=>$val )
    {
                    $sheet->write( $rownum, $colnum++, $val );
    }

    $xls->close();

    exit;    
}


include "nav.php";
?>

<h3>Academic Usage</h3>
<form method='post' action='academicusage.php'>
Filter By: <br>
<table>
<tr><td>User ID:</td><td><select name='suserid'>
<option></option>
<? 
$us = db_query_array( "select distinct( userid ) from immersionusage where userid > 0 and userid in ( $academic )  order by lower( userid )", "userid", "userid" );
foreach( $us as $u )
{
    if( isset( $userarr[$u] ) )
        $us[$u] = $userarr[$u];
}
natcasesort( $us );

outputSelectValues( $us, $suserid );
?>
</select></td></tr>
<tr><td>IP Address:</td><td><select name='ipaddress'>
<option></option>
<? 
$us = db_query_array( "select distinct( ipaddress ) from immersionusage where userid in ( $academic ) order by ipaddress", "ipaddress", "ipaddress" );
outputSelectValues( $us, $ipaddress );
?>
</select></td></tr>
<tr><td>Email:</td><td><select name='email'>
<option></option>
<? 
$emails = db_query_array( "select distinct( p.email ), p.id from immersionusage i, proxylogins p where p.userid in ( $academic )  and i.email = p.id order by p.email", "id", "email" );
outputSelectValues( $emails, $ipaddress );
?>
</select></td></tr>
<tr><td>Date Range:</td><td>from <input name='datefrom' size='10' value='<?=$datefrom?>'> to <input name='dateto' size='10' value='<?=$dateto?>'> 
</td></tr>
<tr><td>Page Matches:</td><td><input name='page' size='30' value='<?=$page?>'>
</td></tr>
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
                if( $already[$r[sessionid]] ) continue;
        $already[$r[sessionid]] = 1;

                ?>
<tr>
<? 
foreach( $cols as $k ) { 
?>
<td>
<? if( $k == "dateadded" ) { ?><nobr><? } ?>
<?php
             if( $k == "userid" && isset( $userarr[$r[$k]] ) )
            {
                echo( $userarr[$r[$k]] );
            }
	    else             if( $k == "email" && isset( $emails[$r[$k]] ) )
            {
                echo( $emails[$r[$k]] );
            }
	    else if( $k == "first page" )
		{
		$lowest = db_query_first( "select * from immersionusage where sessionid = '$r[sessionid]' order by dateadded limit 1" );

		echo( $lowest["domain"] . $lowest["pagehit"] );
		}
	    else if( $k == "sessionid" && $help )
		{
		    echo( "<a target=_blank href='viewindividualusage.php?thesessionid=$r[sessionid]'>$r[sessionid]</a>" );
		}
	    else if( $k == "dateadded" )
            echo( date( "m/d/y, h:i A", strtotime(  $r[$k] ) ) );  
             
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
