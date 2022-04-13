<? 
$nologin = 1;
require_once "../hsdmgdb/connect.php";
require_once "../functions.php";

if( !$userid )
{
	Header( "Location: /index.php" );
	exit;
}

$filename = urldecode( basename( $_SERVER[REQUEST_URI] ) );
db_query( "insert into downloads ( dateadded, pdfname ) values( now(), '" . escMe( $filename ) . "' )" );

// We'll be outputting a PDF
header('Content-type: application/pdf');

// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="' . $filename . '"');

// The PDF source is in original.pdf
readfile($filename);
exit;

?>