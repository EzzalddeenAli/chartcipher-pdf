<? 
$nologin = 1;
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions{$mybychart}.php";


$filename = "homepage/" . $_GET["file"];
$basefilename = $_GET["file"];
header("Content-type:application/pdf");

// It will be called downloaded.pdf
header("Content-Disposition:attachment;filename={$basefilename}");

// The PDF source is in original.pdf
readfile($filename);
?>