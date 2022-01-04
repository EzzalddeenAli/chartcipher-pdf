<? 
include "connect.php";
if( $doit )
{
    require_once "Spreadsheet/Excel/Writer.php";
    $xls = new Spreadsheet_Excel_Writer();
    $filename = "items.xls";
    $xls->send( $filename );
    $cols = array( "Name"=>"Name", "Twitter Handle"=>"TwitterHandle", "Twitter URL"=>"TwitterURL", "Instagram Handle"=>"InstagramHandle", "Instagram URL"=>"InstagramURL" );
    
    $rows = db_query_rows("select * from labels" );
    $sheet =& $xls->addWorksheet("Labels");
    
    $rownum = 0; $colnum = 0;
    foreach( $cols as $c=>$dbname )
	{
	    $sheet->write( $rownum, $colnum++, $c );
	}
    $rownum++; 
    foreach( $rows as $myrow )
	{
	    $colnum = 0;
	    foreach( $cols as $c=>$dbname )
		{
		    $sheet->write( $rownum, $colnum++, $myrow[$dbname] );
		}
	    $rownum++; 
	}
    
    // begin groups
    
    $rows = db_query_rows("select * from groups" );
    $sheet =& $xls->addWorksheet("Groups");
    
    $rownum = 0; $colnum = 0;
    foreach( $cols as $c=>$dbname )
	{
	    $sheet->write( $rownum, $colnum++, $c );
	}
    $rownum++; 
    foreach( $rows as $myrow )
	{
	    $colnum = 0;
	    foreach( $cols as $c=>$dbname )
		{
		    $sheet->write( $rownum, $colnum++, $myrow[$dbname] );
		}
	    $rownum++; 
	}

    // begin producers
    
    $rows = db_query_rows("select * from producers where id in ( select producerid from producer_to_member group by producerid having count(*) > 1 )" );
    $sheet =& $xls->addWorksheet("Production Groups");
    
    $rownum = 0; $colnum = 0;
    foreach( $cols as $c=>$dbname )
	{
	    $sheet->write( $rownum, $colnum++, $c );
	}
    $rownum++; 
    foreach( $rows as $myrow )
	{
	    $colnum = 0;
	    foreach( $cols as $c=>$dbname )
		{
		    $sheet->write( $rownum, $colnum++, $myrow[$dbname] );
		}
	    $rownum++; 
	}
    // begin members
    
    $rows = db_query_rows("select * from members" );
    $sheet =& $xls->addWorksheet("Members");
    
    $rownum = 0; $colnum = 0;
    foreach( $cols as $c=>$dbname )
	{
	    $sheet->write( $rownum, $colnum++, $c );
	}
    $rownum++; 
    foreach( $rows as $myrow )
	{
	    $colnum = 0;
	    foreach( $cols as $c=>$dbname )
		{
		    if( $dbname == "Name" ) $dbname = "StageName";
		    $sheet->write( $rownum, $colnum++, $myrow[$dbname] );
		}
	    $rownum++; 
	}
    


    $xls->close();
    
	exit;
}
include "nav.php";
?>
<h3>Export Twitter/Instagram </h3>
<form method='post'>
<input type='submit' name='doit' value='Export All'>
</form>
