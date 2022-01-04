<? 
include "connect.php";


$r = db_query_rows(" select count(*) as cnt, fieldname, fieldvalue, guid from xmlelements group by fieldname, fieldvalue, guid having count(*) > 1 " );
foreach( $r as $tmpr )
{
    echo( "delete from xmlelements where fieldname = '" . escMe( $tmpr[fieldname] ) . "' and fieldvalue = '" . escMe( $tmpr[fieldvalue] ) . "' and guid = '" . escMe( $tmpr[guid] ) . "' limit " . ($tmpr["cnt"]-1). "<br>" );
    db_query( "delete from xmlelements where fieldname = '" . escMe( $tmpr[fieldname] ) . "' and fieldvalue = '" . escMe( $tmpr[fieldvalue] ) . "' and guid = '" . escMe( $tmpr[guid] ) . "' limit " . ($tmpr["cnt"]-1) );
}
exit;

$vs = db_query_array( "select * from vocals", "Name", "id" );
$bvs = db_query_array( "select * from backvocals", "Name", "id" );

$res = db_query_rows( "select * from song_to_songsection where songid = 2821" );
foreach( $res as $r )
{
    $s = explode( ",", $r[Vocals] );
    foreach( $s as $tmp )
    {
        $val = $vs[$tmp];
        if( isset( $val ) )
        {
            db_query( "insert into song_to_vocal ( songid, vocalid, type ) values ( '$r[songid]', '$val', '$r[songsectionid]' )" ); 
        }
        else
        {
            echo( "no match for $tmp<br>" );
        }
          
    }
    $s = explode( ",", $r[BackgroundVocals] );
    foreach( $s as $tmp )
    {
        if( !$tmp )  continue;
        $val = $bvs[$tmp];
        if( isset( $val ) )
        {
            db_query( "insert into song_to_backvocal ( songid, backvocalid, type ) values ( '$r[songid]', '$val', '$r[songsectionid]' )" ); 
        }
        else
        {
            echo( "no bmatch for $tmp<br>" );
        }
          
    }
    
}

//$songs = db_query_rows( "select * from vocaltypes where Name in (  'Humming', 'Laugh', 'Scream', 'Shout', 'Whisper', 'Whistle' ) ", "id" );
// foreach( $songs as $songid=> $tmprow )
// {
//     $res = db_query_rows( "select * from song_to_vocaltype where vocaltypeid = $songid" );
//     $otherid = db_query_first_cell( "select id from vocals where Name = '$tmprow[Name]'" );
//     foreach( $res as $rrow )
//     {
//         db_query( "insert into song_to_vocal( songid, vocalid, type ) values ( '$rrow[songid]', '$otherid', '$rrow[type]' ) " );
//     }
// }

// $songs = db_query_rows( "select * from backvocaltypes where Name in (  'Humming', 'Laugh', 'Scream', 'Shout', 'Whisper', 'Whistle' ) ", "id" );
// foreach( $songs as $songid=> $tmprow )
// {
//     $res = db_query_rows( "select * from song_to_backvocaltype where backvocaltypeid = $songid" );
//     $otherid = db_query_first_cell( "select id from backvocals where Name = '$tmprow[Name]'" );
//     foreach( $res as $rrow )
//     {
//         db_query( "insert into song_to_backvocal( songid, backvocalid, type ) values ( '$rrow[songid]', '$otherid', '$rrow[type]' ) " );
//     }
// }

?>
