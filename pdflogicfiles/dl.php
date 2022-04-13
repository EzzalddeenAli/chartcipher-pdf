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


$filename = $fullfile;

$wm = str_replace( " ", "_", $watermark );
$wm = str_replace( "/", "_", $wm );

header('Content-type: application/zip');
header('Content-Disposition: inline; filename="' . $file . '"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
@readfile($fullfile);

