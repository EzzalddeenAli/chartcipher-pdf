<? 

require_once "Spreadsheet/Excel/Writer.php";
$xls = new Spreadsheet_Excel_Writer();
$filename = "test_report.xls";
$xls->send( $filename );

$sheet =& $xls->addWorksheet("aaaa");

$sheet->write( 0,0, "aaaaaaaa" );
$sheet->writeNote( 0,0, "bbb" );

    $xls->close();
?>