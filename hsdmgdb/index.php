<? 

include "connect.php";


if( $dlmissing )
{
    $chartkey = db_query_first_cell( "select chartkey from charts where id = $dlmissing" );
    $rows = db_query_rows( "select distinct( title ), artist from dbi360_admin.billboardinfo where chart = '$chartkey' and concat( title, '-', artist ) not in ( select concat( SongNameHard, '-', ArtistBand ) from songs  )" );
	require_once "Spreadsheet/Excel/Writer.php";
	$xls = new Spreadsheet_Excel_Writer();
	$filename = "missing_report.xls";
	$xls->send( $filename );
	$rownum = 0;
	$sheet =& $xls->addWorksheet("Missing");

	foreach( $rows as $r )
	    {
		$sheet->write( $rownum, $colnum++, $r[title] );
		$sheet->write( $rownum, $colnum++, $r[artist] );
		$rownum++; $colnum = 0;
	    }

    $xls->close();

    exit;    


}
if( $dlpresent )
{
	$rows = db_query_rows( "select SongNameHard as title, ArtistBand as artist from songs where find_in_set( $dlpresent, chartids )" );
	require_once "Spreadsheet/Excel/Writer.php";
	$xls = new Spreadsheet_Excel_Writer();
	$filename = "present_report.xls";
	$xls->send( $filename );
	
	$sheet =& $xls->addWorksheet("In CC DB");

	foreach( $rows as $r )
	    {
		$sheet->write( $rownum, $colnum++, $r[title] );
		$sheet->write( $rownum, $colnum++, $r[artist] );
		$rownum++; $colnum = 0;
	    }

    $xls->close();

    exit;    


}

include "nav.php";


?>
<h3>HSD Song Admin</h3>


Welcome!

<? 
$charts = db_query_rows( "select * from charts where UseOnDb = 1 order by OrderBy" );
foreach( $charts as $crow )
{
	$chartid = $crow[id];
	echo( "<h3>$crow[Name]</h3>" );
	$num = db_query_first_cell( "select count(*) from songs where find_in_set( $chartid, chartids )" );
	$numbill = db_query_first_cell( "select count(distinct( title ), artist ) from dbi360_admin.billboardinfo where chart = '$crow[chartkey]'" );
	echo( "<a href='index.php?dlpresent=$chartid'>Num Songs: $num</a><br>" );	
	echo( "<a href='index.php?dlmissing=$chartid'>Num In Billboard Data but not in CC: ". ( $numbill - $num ) . "</a><br>" );	
	echo( "<br>" );
}

?>


<? include "footer.php"; ?>
