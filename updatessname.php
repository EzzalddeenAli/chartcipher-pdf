<? 
$nologin = 1;
$nologinrequired = 1;
require_once "hsdmgdb/connect{$mybychart}.php";
require_once "functions{$mybychart}.php";


if( $toupdate )
    foreach( $toupdate as $t => $val )
    {   
        db_query( "update savedsearches set Name = '$val' where id = '$t'" );
    }

if( $toupdateob )
    foreach( $toupdateob as $t => $val )
    {
        if( $t && $val )
            db_query( "update savedsearches set OrderBy = '$val' where id = '$t'" );
    }

?>