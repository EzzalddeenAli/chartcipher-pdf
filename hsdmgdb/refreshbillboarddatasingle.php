<? include "connect.php"; 

if( $songid )
{
	$rows = db_query_rows( "select * from billboardinfo where songid = $songid and chart = 'hot-100' and rank <=10" );
	//	print_r( $rows );
	db_query( "delete from song_to_weekdate where songid = $songid" );
	$num = 0;
	foreach( $rows as $r )
	{
	    //	    echo( "insert into song_to_weekdate( songid, weekdateid, type ) values ( $songid, $r[weekdateid], 'position{$r[rank]}' )" );
	    db_query( "insert into song_to_weekdate( songid, weekdateid, type ) values ( $songid, $r[weekdateid], 'position{$r[rank]}' )" );
	    $num++;
	}
}

?>
<?=$num ?> rows added. Refresh the previous page to see results. <br><a href='#' onClick='window.close()'>Close window</a>

