<? 
include "connect.php";

 if( !$_SESSION["isadminlogin"] ) {
     Header( "Location: index.php" );
     exit;
 }

if( $go )
{
	if( !$toq ) $toq = $fromq; 
	if( !$toy ) $toy = $fromy; 
	//	echo( $peak );exit;
	$songids = getSongIdsWithinQuarter( true, $fromq, $fromy, $toq, $toy, $peak );
    $allsongsstr = implode( ", ", $songids );
    $fromstr =  "$fromq/$fromy - $toq/$toy but not in ";

     $q = getPreviousQuarter( "{$fromq}/{$fromy}" );
     $exp = explode( "/", $q );
    $prevsongids = getSongIdsWithinQuarter( false, $exp[0], $exp[1] - 5, $exp[0], $exp[1] );
    $prevsongidstr = implode( ", ", $prevsongids );
    $fromstr .=  "$exp[0]/" . ($exp[1] - 5). "- $exp[0]/$exp[1]";
    //    exit;
    require_once "Spreadsheet/Excel/Writer.php";
    $xls = new Spreadsheet_Excel_Writer();
    $filename = "newcomers.xls";
    $xls->send( $filename );
    $sheet =& $xls->addWorksheet("Songs Included");

    $rownum = 0 ; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "Songs $fromstr" );
    $rownum++; $colnum = 0;
    foreach( $songids as $u )
	{
	    $s = db_query_first_cell( "select SongNameHard from songs where id = $u" ); 
	    $a = db_query_first_cell( "select ArtistBand from songs where id = $u" ); 
	    $displ[$s] = $a;
	}
    ksort( $displ );
    foreach( $displ as $d=>$a )
	{
	    $rownum++; $colnum = 0;
	    $sheet->write( $rownum, $colnum++, $d );
	    $sheet->write( $rownum, $colnum++, $a );
	}


    $sheet =& $xls->addWorksheet("Songwriters");

    $thesesongwriters = db_query_array( "select artistid from song_to_artist where type in ( 'creditedsw' ) and songid in ( $allsongsstr )", "artistid", "artistid" ); 
    $prevsongwriters = db_query_array( "select artistid from song_to_artist where type in ( 'creditedsw' ) and songid in ( $prevsongidstr )", "artistid", "artistid" ); 
    $unique = array_diff( $thesesongwriters, $prevsongwriters );
    $displ = array();

    $rownum = 0 ; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "Songwriters $fromstr" );
    $rownum++; $colnum = 0;
    foreach( $unique as $u )
	{
	    $displname = getNameById( "artists", $u );
	    $thesesongs = db_query_array( "select SongNameHard from song_to_artist, songs where artistid = $u and songs.id = songid and  type in ( 'creditedsw' ) and songid in ( $allsongsstr )", "SongNameHard", "SongNameHard" ); 
		
	    $displ[$displname] = array( count( $thesesongs ), implode( ", " , $thesesongs ) );
	}
    ksort( $displ );
    foreach( $displ as $d=>$tmparr )
	{
	    $rownum++; $colnum = 0;
	    $sheet->write( $rownum, $colnum++, $d );
	    $sheet->write( $rownum, $colnum++, $tmparr[0] );
	    $sheet->write( $rownum, $colnum++, $tmparr[1] );
	}

    $sheet =& $xls->addWorksheet("Producers");

    $thesesongwriters = db_query_array( "select producerid from song_to_producer where songid in ( $allsongsstr )", "producerid", "producerid" ); 
    $prevsongwriters = db_query_array( "select producerid from song_to_producer where songid in ( $prevsongidstr )", "producerid", "producerid" ); 
    $unique = array_diff( $thesesongwriters, $prevsongwriters );
    $displ = array();

    $rownum = 0 ; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "Producers $fromstr" );
    $rownum++; $colnum = 0;
    foreach( $unique as $u )
	{
	    $displname = getNameById( "producers", $u );
	    $thesesongs = db_query_array( "select SongNameHard from song_to_producer, songs where producerid = $u and songs.id = songid and songid in ( $allsongsstr )", "SongNameHard", "SongNameHard" ); 
		
	    $displ[$displname] = array( count( $thesesongs ), implode( ", " , $thesesongs ) );
	}
    ksort( $displ );
    foreach( $displ as $d=>$tmparr )
	{
	    $rownum++; $colnum = 0;
	    $sheet->write( $rownum, $colnum++, $d );
	    $sheet->write( $rownum, $colnum++, $tmparr[0] );
	    $sheet->write( $rownum, $colnum++, $tmparr[1] );
	}

    $sheet =& $xls->addWorksheet("Artists");


    $thesesongwriters = db_query_array( "select artistid from song_to_artist where type in ( 'primary', 'featured' ) and songid in ( $allsongsstr )", "artistid", "artistid" ); 
    $prevsongwriters = db_query_array( "select artistid from song_to_artist where type in ( 'primary', 'featured' ) and songid in ( $prevsongidstr )", "artistid", "artistid" ); 
    $unique = array_diff( $thesesongwriters, $prevsongwriters );
    $displ = array();

    foreach( $unique as $u )
	{
	    $displname = getNameById( "artists", $u );
	    $thesesongs = db_query_array( "select SongNameHard from song_to_artist, songs where type in ( 'primary', 'featured' ) and artistid = $u and songs.id = songid and songid in ( $allsongsstr )", "SongNameHard", "SongNameHard" ); 
		
	    $displ[$displname] = array( count( $thesesongs ), implode( ", " , $thesesongs ) );
	}

    $thesesongwriters = db_query_array( "select groupid from song_to_group where type in ( 'primary', 'featured' ) and songid in ( $allsongsstr )", "groupid", "groupid" ); 
    $prevsongwriters = db_query_array( "select groupid from song_to_group where type in ( 'primary', 'featured' ) and songid in ( $prevsongidstr )", "groupid", "groupid" ); 
    $unique = array_diff( $thesesongwriters, $prevsongwriters );

    foreach( $unique as $u )
	{
	    $displname = getNameById( "groups", $u );
	    $thesesongs = db_query_array( "select SongNameHard from song_to_group, songs where type in ( 'primary', 'featured' ) and groupid = $u and songs.id = songid and songid in ( $allsongsstr )", "SongNameHard", "SongNameHard" ); 
		
	    $displ[$displname] = array( count( $thesesongs ), implode( ", " , $thesesongs ) );
	}



    $rownum = 0 ; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "Artists and Groups $fromstr" );
    $rownum++; $colnum = 0;
    ksort( $displ );
    foreach( $displ as $d=>$tmparr )
	{
	    $rownum++; $colnum = 0;
	    $sheet->write( $rownum, $colnum++, $d );
	    $sheet->write( $rownum, $colnum++, $tmparr[0] );
	    $sheet->write( $rownum, $colnum++, $tmparr[1] );
	}


    $xls->close();

    exit;    

}

include "../functions.php";
include "nav.php";
?>
<h3>Top 10 Newcomers</h3>
<form method='post'>
								<label>Date Range:</label><br/>
								<div id="modified" class="form-row-left-inner">
									<select id="fromq" data-control="datesmustbevalid" style="width: 100px" name="fromq">
										<option value="">Any</option>
<? outputSelectValues( $quarters, $fromq ); ?>
									</select>
									<select data-control="datesmustbevalid" style="width: 100px" name="fromy">
										<option value="">Any</option>
<? outputSelectValues( $years, $fromy ); ?>
									</select>
								</div>
								<label class="inner-label">- to -</label>
								<div class="form-row-left-inner">
									<select data-control="datesmustbevalid" style="width: 100px" name="toq">
										<option value="">Any</option>
<? outputSelectValues( $quarters, $toq ); ?>
									</select>
									<select data-control="datesmustbevalid" style="width: 100px" name="toy">
										<option value="">Any</option>
<? outputSelectValues( $years, $toy ); ?>
									</select>
								</div>
    								<label>Peak Chart Position:</label>
    								<select name="peak">
    									<option value="">Top 10</option>
    									<?
    $tmpvalues = array( "1"=> "#1", "3"=>"Top 3", "5"=>"Top 5");
    outputSelectValues( $tmpvalues, $peak );
    ?>
    								</select>

							<input type="submit" id="submitbutton" name="go" value="Run Report" />
								<div class="cf"></div>
							</div><!-- /.form-row-right -->
</form>

<? include "footer.php"; ?>
