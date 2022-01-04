<? 
include "connect.php";
include "../functions.php";
 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

    $res = db_query_rows( "select * from immersionusage where sessionid = '$thesessionid'  order by dateadded desc" );

include "nav.php";
$cols = array();
$cols[] = "dateadded";
$cols[] = "email";
$cols[] = "userid";
//$cols[] = "pagehit";
$cols[] = "ipaddress";
$cols[] = "sessionid";
$cols[] = "first page";


?>

<h3>Academic Usage for session <?=$thesessionid?> </h3>

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
<br><br>
<? include "footer.php"; ?>
