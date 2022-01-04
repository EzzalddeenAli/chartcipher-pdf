<? 
$nologin = 1;
include "connect.php";

$wdid = db_query_first_cell( "select id from weekdates where Orderby < " . time() . " order by OrderBy desc limit 1" );

if( $wdid )
    {
	$cnt = db_query_first_cell( "select count(*) from song_to_weekdate where weekdateid = $wdid " );
	if( $cnt != 10 )
	    {
		mail( "rachelc@gmail.com", "not enough songs for this week on HSD", "check on this
https://analytics.chartcipher.com/hsdmgdb/weekdates.php", "From: info@emergencyskills.com" );
		mail( "dave@hitsongsdeconstructed.com", "not enough songs for this week on HSD", "check on this
https://analytics.chartcipher.com/hsdmgdb/weekdates.php", "From: info@emergencyskills.com" );
	    }
    }
else
    {
		mail( "rachelc@gmail.com", "no weekdate found on HSD", "check on this
https://analytics.chartcipher.com/hsdmgdb/weekdates.php", "From: info@emergencyskills.com" );

	
    }




?>
