<? 
include "connect.php";

$songs = db_query_rows( "select songnames.Name as SongName, songs.* from songs, songnames where   songnameid = songnames.id $ext order by SongName" );

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
    $sheet->write( $rownum, $colnum++, "Song Title"  );
    $sheet->write( $rownum, $colnum++, "Display Artist"  );
    $sheet->write( $rownum, $colnum++, "Label"  );

foreach( $songs as $p )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $p[SongName]  );
    $sheet->write( $rownum, $colnum++, $p[ArtistBand]  );
    $sheet->write( $rownum, $colnum++, getCommaValues( $p[id], "label", "" )  );

}

    $xls->close();

?>