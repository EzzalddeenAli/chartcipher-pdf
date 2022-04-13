<? 
$nologin = 1;
ini_set('auto_detect_line_endings',TRUE);
ini_set('memory_limit','1024M');

include "connect.php";
include "../functions.php";

include "nav.php";


?>
<form method='get' enctype='multipart/form-data'>

<br><br>
     Billboard Lookup: 
    <input type='text' name='matcher' value="<?=$matcher?>"> <input type='submit' name='gomatcher' value="Match Songs"><Br>
<table border=1>

     <?      if( $matcher && $gomatcher ) {
    $rows = db_query_rows( "select distinct( artist ), title from dbi360_admin.billboardinfo where artist like '%".escMe( $matcher )."%' or title like '%".$matcher."%'" );
    foreach( $rows as $r )
    echo( "<tr><td>$r[artist]</td><td>$r[title]</td></tr>" );

    }?>
</table>

<Br>

    <h3> View weekly stats for chart:</h3>
<select name='selectchartid'>
								<? outputSelectValuesForOtherTable( "charts", $selectchartid, false, " and UseOnDb = 1" ); ?>
</select>
<input type='submit' name='viewstats' value='View # Songs By Week'>

<? if( $viewstats ) { 
$weekdates = db_query_array( "select * from weekdates where OrderBy < " . time() . " order by OrderBy desc", "id", "Name" );
echo( "<table style='width:300px' border=1><tr><td>Week</td><td># Songs</td></tr>" );
foreach( $weekdates as $wid=>$wname )
{
	$num = db_query_first_cell( "select count(*) from song_to_weekdate where chartid = $selectchartid and weekdateid = $wid" );
	echo( "<tr><td>$wname</td><td>$num</td></tr>" );
}
echo( "</table>" );
}
?>
                                                                                                                                                     </form>
<? include "footer.php"; ?>
