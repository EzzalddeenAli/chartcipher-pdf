<? 
ini_set('auto_detect_line_endings',TRUE);
include "connect.php"; ?>
<? 

// +----+----------------------------------------+---------+-----------+------------------------+
// | id | Name                                   | OrderBy | InfoDescr | HideFromAdvancedSearch |
// +----+----------------------------------------+---------+-----------+------------------------+
// | 36 | No Drums                               |    NULL | NULL      |                      1 |
// | 35 | 808                                    |    NULL | NULL      |                      1 |
// | 34 | Drums/Perc (Acoustic/Electronic Combo) |    NULL | NULL      |                      1 |
// | 33 | Drums/Perc (Primarily Acoustic)        |    NULL | NULL      |                      1 |
// +----+----------------------------------------+---------+-----------+------------------------+
$arr = array();
// $arr[2] = 54;
// $arr[3] = 55;
// $arr[4] = 56;
// $arr[5] = 57;
// $arr[6] = 58;


// | 15 | Hook Based Intro (All)                |    NULL |                                                                                           |                      0 |
//     | 16 | Instrumental Hook (All)               |    NULL |                                                                                           |                      1 |
//     | 17 | Instrumental Hook (Foundational)      |    NULL |                                                                                           |                      1 |
//     | 18 | Instrumental Hook (Melodic)           |    NULL |                                                                                           |                      1 |
//     | 19 | Instrumental Hook (Hip Hop Beat)      |    NULL |                                                                                           |                      1 |
//     | 20 | Vocal Hook (All)                      |    NULL |                                                                                           |                      1 |
//     | 21 | Vocal Hook (Lead Vocal)               |    NULL |                                                                                           |                      1 |
//     | 22 | Vocal Hook (Background/Embellishment) |    NULL |                                                                                           |                      1 |
//     | 23 | Vocal Hook (Hip Hop Beat)             |    NULL |                                                                                           |                      1 |


$arr[2] = "15";
$arr[3] = "16";
$arr[4] = "17";
$arr[5] = "18";
$arr[6] = "19";
$arr[7] = "20";
$arr[8] = "21";
$arr[9] = "22";
$arr[10] = "23";

$handle = fopen("intros.csv", "r");
while (($data = fgetcsv($handle, 99999, ",")) !== FALSE) 
    {
	// $clean = findClean( $data[1] . "-" . $data[0] );
	if( $data[0] == "SONG" ) continue;
	$pid = db_query_first_cell( "select id from songs where SongNameHard = '". escMe( $data[0] ) . "'" );
	if( !$pid ) { 
	    echo( "no match for $data[0]<br>" );
	    continue;
	}
	//	if( !count( $pid ) || count( $pid ) > 1 )
	//     {
	// 	echo( count( $pid ) . " matches found for $clean, $data[0], $data[1] <br>" );
	// 	continue;
	//     }
	// continue;
    foreach( $arr as $a => $newid )
	{
	    if( trim( $data[$a] ) )
		{
		    echo( "insert into song_to_introtype ( songid, introtypeid ) values ( '$pid', '$newid' )<br>" );
		    db_query( "insert into song_to_introtype ( songid, introtypeid ) values ( '$pid', '$newid' )" );
		}
	}
		    
    }

?>
