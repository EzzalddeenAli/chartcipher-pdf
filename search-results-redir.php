<? 
$nologin = 1;
$nologinrequired = 1;
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions{$mybychart}.php";

$row = db_query_first( "select CleanUrl from songs where IsActive = 1 and SongNameHard = '" . escMe( $fieldname ) . "'" );
if( $row[CleanUrl] )
{
    $fieldname = stripslashes( $fieldname );
    Header( "Location: /" . $row[CleanUrl] . "" );
    exit;
}
$fieldname = escMe( $fieldname );
$row = db_query_first( "select * from labels where Name = '$fieldname'" );
if( $row[id] )
{
    $fieldname = stripslashes( $fieldname );
    Header( "Location: /" . getArtistUrl( $fieldname ) );
    exit;
}
$row = db_query_first( "select * from artists where Name = '$fieldname'" );
if( $row[id] )
{
    $fieldname = stripslashes( $fieldname );
    Header( "Location: /" . getArtistUrl( $fieldname ) );
    exit;
}
$row = db_query_first( "select * from groups where Name = '$fieldname'" );
if( $row[id] )
{
    $fieldname = stripslashes( $fieldname );
    Header( "Location: /" . getArtistUrl( $fieldname ) );
    exit;
}
$row = db_query_first( "select * from producers where Name = '$fieldname'" );
if( $row[id] )
{
    $fieldname = stripslashes( $fieldname );
    Header( "Location: /" . getArtistUrl( $fieldname ) );
    exit;
}

Header( "Location: advanced-search" );
?>
