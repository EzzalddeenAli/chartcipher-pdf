<? //                 | Songwriter Count                                               | 

$times = array();
$times[] = "1";
$times[] = "2";
$times[] = "3";
$times[] = "4";
$times[] = "5";

$etimes = array();
$etimes["1"] = " Writer";
$etimes["2"] = " Writers";
$etimes["3"] = " Writers";
$etimes["4"] = " Writers";
$etimes["5"] = "+ Writers";

foreach( $times as $t )
  {
    $fields[] = $t;
  }
    $fields[] = "Total";

foreach( $fields as $fname ) {
  $sheet->write( $rownum, $colnum++, $fname . (isset( $etimes[$fname])?" " . $etimes[$fname]:""), $format_bold );
}

foreach( $quarterstorun as $q )
  {
    $rownum++;
    $colnum = 1;
    $sheet->write( $rownum, $colnum++, formatQuarterForDisplay( $q ) );
    $qspl = explode( "/", $q );
    $songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
    $numsongs = count( $songs );
    // we need to add this in case there were none
    $songs[] = -1;
    
    $songidstr = implode( ", ", $songs );
    $total = 0;
    foreach( $times as $t )
      {
	$sign = $t == 5?" >= ":" = ";
	$numforthis = db_query_first_cell( "select count(*) from songs where id in ( $songidstr ) and SongwriterCount {$sign} $t " );
	
	$numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
	$sheet->write( $rownum, $colnum++, $numforthis/100, $percentformat);

	if( $addnote )
	  {
	    $songs = db_query_array( "select id from songs where id in ( $songidstr ) and SongwriterCount {$sign} $t " );
	    $sheet->writeNote( $rownum, $colnum-1, getSongNames( $songs ) );
	  }
	

	$total += $numforthis;
      }
    $sheet->write( $rownum, $colnum++, $total/100, $percentformat);

  }


$rownum++;$colnum = 0;
$rownum++;$colnum = 0;

$sheet->write( $rownum, $colnum++, "SONGWRITER #1 HITS", $format_bold );
$rownum++;$colnum = 0;

$fields = array();
$fields[] = "Songwriter Name";
foreach( $quarterstorun as $q )
$fields[] = formatQuarterForDisplay( $q );

foreach( $fields as $fname ) {
  $sheet->write( $rownum, $colnum++, $fname, $format_bold );
}


$numberonesongs = getSongIdsWithinQuarter( $newarrivalsonly, $sdateq, $sdatey, $edateq, $edatey, 1 );
if( !count( $numberonesongs ) ) $numberonesongs[] = -1;
$songwriters = db_query_array( "select * from song_to_artist, artists where type ='creditedsw' and artistid = artists.id and songid in ( ". implode( ", ", $numberonesongs ). " ) order by Name", "artistid", "Name" );

foreach( $songwriters as $sid=>$s )
{
    $rownum++;$colnum = 0;
    $sheet->write( $rownum, $colnum++, $s );

    foreach( $quarterstorun as $q )
    {
        $qspl = explode( "/", $q );
        $songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1], "", "", 1 );
        $songs[] = -1;
        $thissongs = db_query_array( "select songid from song_to_artist where artistid = $sid and type = 'creditedsw' and songid in ( ". implode( ", ", $songs ) . " )", "songid", "songid" );
        $sheet->write( $rownum, $colnum++, count( $thissongs ) );
        if( $addnote )
        {
            $sheet->writeNote( $rownum, $colnum-1, getSongNames( $thissongs ) );
        }
        
    }
}

$rownum++;$colnum = 0;
$rownum++;$colnum = 0;

$sheet->write( $rownum, $colnum++, "SONGWRITER TOP 10 HITS", $format_bold );
$rownum++;$colnum = 0;

$fields = array();
$fields[] = "Songwriter Name";
foreach( $quarterstorun as $q )
$fields[] = formatQuarterForDisplay( $q );

foreach( $fields as $fname ) {
  $sheet->write( $rownum, $colnum++, $fname, $format_bold );
}

$songwriters = db_query_array( "select * from song_to_artist, artists where type ='creditedsw' and artistid = artists.id and songid in ( $allsongsstr ) order by Name", "artistid", "Name" );

foreach( $songwriters as $sid=>$s )
{
    $rownum++;$colnum = 0;
    $sheet->write( $rownum, $colnum++, $s );

    foreach( $quarterstorun as $q )
    {
        $qspl = explode( "/", $q );
        $songs = getSongIdsWithinQuarter( $newarrivalsonly, $qspl[0], $qspl[1] );
        $songs[] = -1;
        $thissongs = db_query_array( "select songid from song_to_artist where artistid = $sid and type = 'creditedsw' and songid in ( ". implode( ", ", $songs ) . " )", "songid", "songid" );
        $sheet->write( $rownum, $colnum++, count( $thissongs ) );
        if( $addnote )
        {
            $sheet->writeNote( $rownum, $colnum-1, getSongNames( $thissongs ) );
        }
        
    }
}


?>