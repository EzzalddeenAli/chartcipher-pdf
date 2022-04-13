<?
$url = $_SERVER["REQUEST_URI"];

$parsed = parse_url( $url );

$file = basename( $parsed["path"] );
$watermark = urldecode( $parsed["query"] );
$watermark = str_replace( "watermark=", "", $watermark );
//echo("$watermark, $file" );
//exit;
if( !file_exists( $file ) )
exit;
if( !$watermark )
exit;

$size = 50;
$outfilename = str_replace( "'", "", $watermark ) . "_" . $file;
$outfilename = str_replace( "\"", "", $outfilename );
$outfilename = str_replace( ";", "", $outfilename );
$outfilename = str_replace( ":", "", $outfilename );
$outfilename = str_replace( " ", "", $outfilename );

$stampname = str_replace( "'", "", $watermark );
$stampname = str_replace( "\"", "", $stampname );
$stampname = str_replace( ";", "", $stampname );
$stampname = str_replace( ":", "", $stampname );
$stampname = str_replace( " ", "", $stampname );

$watermark = str_replace( "\"", "\\\"", $watermark);

//echo( "sh createwmark.sh  \"$watermark\" 15 $stampname; sh ./dowatermark.sh $outfilename $stampname");
$hmm = array();

if( strlen( $watermark ) < 20 ) $size = 80;
else if( strlen( $watermark ) < 30 ) $size = 70;
else if( strlen( $watermark ) < 40 ) $size = 60;

$output = exec( "/bin/sh ~/public_html/pdfmarker/createwmark.sh  \"$watermark\" $size $stampname; /bin/sh ~/public_html/pdfmarker/dowatermark.sh $outfilename $stampname $file", $hmm, $retval);
file_put_contents( "rc", "/bin/sh ~/public_html/pdfmarker/createwmark.sh  \"$watermark\" $size $stampname; /bin/sh ~/public_html/pdfmarker/dowatermark.sh $outfilename $stampname $file\n", FILE_APPEND);

  header('Content-type: application/pdf');
  header('Content-Disposition: inline; filename="' . $file . '"');
  header('Content-Transfer-Encoding: binary');
  header('Accept-Ranges: bytes');
  @readfile($outfilename);

?>
