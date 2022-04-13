<?php
$nologin = 1;
$ispdf = 1;
require_once "../hsdmgdb/connect.php";
require_once "../functions.php";

//echo( "select filename from pdfuploads where keyname = '$key'" );
$file = db_query_first_cell( "select filename from pdfuploads where keyname = '$key'" );
$pdfrow = db_query_first( "select * from pdfuploads where keyname = '$key'" );
$fullfile = $file;
if( !$file )
    {
	echo( "no match" );
    exit;
    }

$watermark = "";

// update here
$watermark = $user[school_name];
if( !$watermark )
    $watermark = $user[company_name];
if( !$watermark )
    $watermark = trim( $user[name_f] . " " . $user[name_l] . " / " . $user[email] );
if( !$watermark  || $watermark == "/" )
    $watermark = $user[login];

$text = "This document is being provided for the exclusive use of " . $watermark . ".";
// end update text here

if( isset( $watermark ) && $watermark )
{
if( !file_exists( $file ) )
{
    echo( "File does not exist" );
exit;
}
 if( !$watermark )
 {
//     echo( "No Watermark" );
// exit;
 }

// your variables

db_query( "insert into pdfdownloads( pdfid, dateadded, filename, type, username, watermark ) values ( '$pdfrow[id]', now(), '" . escMe( $pdfrow[filename] ) . "', '" . escMe( $pdfrow[type] ) . "', '" . escMe( $user[email] ) . "', '" . escMe( $watermark ) . "' )" );

$fontColor = array(0,0,0);
if( $color == "charcoal" )
    $fontColor = array(51/255,51/255,51/255); // charcoal
if( $color == "orange" )
    $fontColor = array(255/255,102/255,51/255); // orange
//$fontColor = array(232/255, 232/255, 232/255);

$outlineColor = array(0,0,0);
$outlineColor = array(77/255, 77/255, 77/255);

$opacity = 1;

$encryption = false;

$permission = "";

$ownerPassword = "";

$userPassword = "";

$filename = $fullfile;

$wm = str_replace( " ", "_", $watermark );
$wm = str_replace( "/", "_", $wm );
$outfile = "out/" . $wm."_".$file;

if( 1|| !file_exists( $outfile ) )
    {

	//	echo( "starting $outfile" );
        require_once("../library/SetaPDF/Autoload.php");
	//	exit;
// create a file writer
        
        $writer = new SetaPDF_Core_Writer_File("$outfile");
        
// load document by filename
        
        $document = SetaPDF_Core_Document::loadByFilename($filename, $writer);
        
        
        
// create a stamper instance for the document
        
        $stamper = new SetaPDF_Stamper($document);
        
        
        
// create a font for this documetn
        
        $font = SetaPDF_Core_Font_Standard_Helvetica::create($document);
        
// create a stamp with the created font and font size 120
        
        $stamp = new SetaPDF_Stamper_Stamp_Text($font, 120);
        
        
        
// center the text to the text block
        
        $stamp->setAlign(SetaPDF_Core_Text::ALIGN_CENTER);
        
// set text for the stamp
        
        $stamp->setText($text);
        
        
        
// set text color to your chosen color
        
// all color definitions need to be between 0 and 1
        
        $stamp->setTextColor($fontColor);
        
        $fs = 30;
        $len = strlen( $text );
        if( $len <=15 )
            $fs = 90;
        else if( $len <=20 )
            $fs = 80;
        else if( $len <= 25 )
            $fs = 70;
        else if( $len <= 30 )
            $fs = 60;
        else if( $len <=40 )
            $fs = 50;

	$fs = 10;        
        $stamp->setFontSize( $fs );
        
// rendering mode on "Fill, then stroke text."
        
// for more rendering modes look pdf-reference PDF32000-1:2008 9.3.6
        
//        $stamp->setRenderingMode(2);
        
// set outline width to 0.5 (default is 1)
        
//        $stamp->setOutlineWidth(1);
        
// set color to your chosen color
        
//        $stamp->setOutlineColor($outlineColor);
        
        
        
// set the opacity, need to be between 0 and 1
        
//        $stamp->setOpacity($opacity);
        
        
        
// add the stamp to the stamper on every page
        
// at the position center_middle
        
// rotated by 60 degrees
        
        $stamper->addStamp($stamp, SetaPDF_Stamper::POSITION_CENTER_BOTTOM, SetaPDF_Stamper::PAGES_ALL, 0, 5, 0);
        
        
        
// stamp the document
        
        $stamper->stamp();
        
// save the file and finish the writer (e.g. file handler will closed)
        
        $document->save()->finish();
    }

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $file . '"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
@readfile($outfile);

}
else
{
    header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $file . '"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
@readfile($fullfile);

}
    
