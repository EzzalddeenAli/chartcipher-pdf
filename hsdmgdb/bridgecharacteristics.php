<? 
include "connect.php";


// $res = db_query_rows( "select count(*) c, songid, chorustypeid, type from song_to_chorustype group by songid, chorustypeid, type having count(*) > 1" );

// foreach( $res as $r )
// {
//     $num = $r["c"] - 1;
//     $sql = "delete from song_to_chorustype where songid = '$r[songid]' and type = '$r[type]' and chorustypeid = '$r[chorustypeid]' limit $num";
//     echo( $sql . "<br>" );
// //    db_query( $sql );
    
// }

// $res = db_query_rows( "select stc.* from song_to_chorustype stc, song_to_songsection where WithoutNumberHard = 'Bridge' and stc.type = song_to_songsection.songsectionid and stc.songid = song_to_songsection.songid " );
// foreach( $res as $row )
// {
// 	db_query( "insert into song_to_bridgecharacteristic ( songid, bridgecharacteristicid, type ) values ( '{$row[songid]}', '{$row[chorustypeid]}', '{$row[type]}' ) " );
// }

$tablename = "bridgecharacteristics";

$uppercasesingle = "Bridge Characteristics";
$lowercasesingle = strtolower( $uppercasesingle );
$uppercase = $uppercasesingle . "s"; 
$lowercase = strtolower( $uppercase );
$extracolumnsizes = array( "OrderBy" => 4, "InfoDescr" => 40 );
$extracolumns = array( "OrderBy"=>"Order By", "InfoDescr"=> "? Info"  );

include "generic.php";
?>