<? 
include "connect.php";

$typestr = $type?" and type = '$type'":"";
$songs = db_query_rows( "select artists.* from artists, song_to_artist where artistid = artists.id $typestr order by Name ", "id" );

    require_once "Spreadsheet/Excel/Writer.php";
    $xls = new Spreadsheet_Excel_Writer();
    $filename = "artists_{$type}_report.xls";
    $xls->send( $filename );

    $percentformat =& $xls->addFormat();
    $percentformat->setNumFormat( "0%" );

    $timeformat =& $xls->addFormat();
    $timeformat->setNumFormat( "MM:SS" );
    $timeformathours =& $xls->addFormat();
    $timeformathours->setNumFormat( "HH:MM:SS" );

    $format_bold =& $xls->addFormat();
    $format_bold->setBold();

    $sheet =& $xls->addWorksheet("List");

    $rownum = 0;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, "Stage Name"  );
    $sheet->write( $rownum, $colnum++, "First Name"  );
    $sheet->write( $rownum, $colnum++, "Last Name"  );

foreach( $songs as $p )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $p[Name]  );
    $sheet->write( $rownum, $colnum++, $p[FirstName]  );
    $sheet->write( $rownum, $colnum++, $p[LastName]  );

}

    $xls->close();

?>