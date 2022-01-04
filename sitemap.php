<?php 
$nologin = 1;
$nouserrequired = 1;
if( isset( $_GET["search"]["chartid"] ) && $_GET["search"][chartid] ) $mybychart = "_bychart";
require_once "hsdmgdb/connect{$mybychart}.php";

header("Content-type: text/xml");

echo '<?xml version="1.0" encoding="UTF-8" ?>';

$allsongs = db_query_rows( "select * from songs where {$GLOBALS[clientwhere]} " );
//print_r( $_SERVER );
?>

<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
<? foreach( $allsongs as $a ) { ?>
    <url>
        <loc>https://<?=$_SERVER["SERVER_NAME"]?>/<?=$a[CleanUrl]?></loc>
        <lastmod><?=date( "Y-m-d" )?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.00</priority>
    </url>
<? } ?>
</urlset>