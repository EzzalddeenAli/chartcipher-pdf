<? 
$primarygenres = db_query_rows( "select * from genres order by OrderBy , Name", "id" ); 
$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $sdateq, $sdatey, $edateq, $edatey );
$numsongstotal = count( $allsongs );
if( !$numsongstotal ) $numsongstotal = 1;
$allsongstr = implode( ",", $allsongs );

$songsinthisgenre = array();
foreach( $allsongs as $songid )
  {
    $songrow = getSongRow( $songid );
    if( $songrow[GenreID]!= $genreid && $genreid != -1 )
      continue;
    $songsinthisgenre[$songid] = $songrow;
  }
$numsongs = count( $songsinthisgenre );

list( $startdate, $enddate ) = getQuarterTimes( $sdateq, $sdatey );

$gname = db_query_first_cell( "select Name from genres where id = $genreid" );
if( $genreid == -1 )
    $gname = "All";
$sheet->write( $rownum, $colnum++, "$gname", $format_bold );

$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Peak Position", $format_bold );
$sheet->write( $rownum, $colnum++, "Song", $format_bold );


$peaks = array();
foreach( $songsinthisgenre as $songrow )
  {
    $songid = $songrow[id];
    $peak = db_query_first_cell( "select cast( replace( type, 'position', '' ) as signed ) from weekdates, song_to_weekdate where songid = $songid and weekdateid = weekdates.id and weekdates.OrderBy >= $startdate and weekdates.OrderBy < $enddate order by cast( replace( type, 'position', '' ) as signed ) limit 1" ); 
    $peak = str_pad($peak, 2, "0", STR_PAD_LEFT );
    $peaks[$peak][] = $songid;
  }
ksort( $peaks );


foreach( $peaks as $peakid=>$songswith )
  {
    foreach( $songswith as $s )
      {
          $rownum++; $colnum = 0;
          $sheet->write( $rownum, $colnum++, $peakid );
          $srow = getSongRow( $s );
          $sheet->write( $rownum, $colnum++, getSongname( $srow[songnameid] ) );
          $sheet->write( $rownum, $colnum++, $srow[ArtistBand] );
      }    
  }


$rownum++; $colnum = 0;
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Rank as a Primary Genre", $format_bold );
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "$gname" );
$sheet->write( $rownum, $colnum++,$numsongs / $numsongstotal, $percentformat );

if( $genreid != -1  )
{
    $rownum++; $colnum = 0;
    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "Rank as a Secondary Influence/Sub-Genre", $format_bold );
    
    foreach( $primarygenres as $pid=> $prow )
    {
        
        if( $pid == $genreid && $genreid != -1  ) continue; 
        
        $songsinsub = db_query_rows( "select songs.* from songs, song_to_subgenre where songid = songs.id and subgenreid = $subgenreid and type = 'Main' and GenreID = $pid and songid in ( $allsongstr )" );
        
        if( !count( $songsinsub ) ) continue;
        
        $rownum++; $colnum = 0;
        $sheet->write( $rownum, $colnum++, $prow["Name"], $format_bold );
        
        foreach( $songsinsub as $songrow )
        {
            writeSongArtistRow( $sheet, $songrow );
        }
    }
    
    
    $allsongsinsub = db_query_first_cell( "select count( * ) from songs, song_to_subgenre where songid = songs.id and type = 'Main' and  subgenreid = $subgenreid and songid in ( $allsongstr )" );
    
    $rownum++; $colnum = 0;
    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "Rank as a sub-genre genre", $format_bold );
    $rownum++; $colnum = 0;
    $sheet->write( $rownum, $colnum++, "$gname" );
    $sheet->write( $rownum, $colnum++, $allsongsinsub / $numsongstotal, $percentformat );
    
}

if( $genreid != -1 )
{
$thesesongs = db_query_rows( "select songnames.Name as SongName, songs.* from songs, songnames where songnameid = songnames.id and GenreID = $genreid and songs.id in ( $allsongstr ) order by SongName", "id" );
}
else
{
    $thesesongs = db_query_rows( "select songnames.Name as SongName, songs.* from songs, songnames where songnameid = songnames.id and songs.id in ( $allsongstr ) order by SongName", "id" );
}
$thesesongids = array_keys( $thesesongs );
$numsongs = count( $thesesongs );
$thesesongids[] = -1;


$rownum++; $colnum = 0;

$sectiontitle = "Sub-Genres & Influencers";
$thistype = "subgenre";
genreReportSongMulti( $sectiontitle, $thistype, $thesesongs, $thesesongids );


$sectiontitle = "Electronic Vs Acoustic";
$currcolname = "ElectricVsAcoustic";
$orderbycolname = "ElectricVsAcoustic";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );

$sectiontitle = "Song Title Words Count";
$currcolname = "SongTitleWordCount";
$orderbycolname = "SongTitleWordCount";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids, true, " Word(s)");


$sectiontitle = "Song Title Appearances";
$currcolname = "SongTitleAppearanceRange";
$orderbycolname = "SongTitleAppearances";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );



// start SongTitleAppearances actual 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Song Title Appearances - Actual", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Song Title Appearances", $format_bold );

foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $sheet->write( $rownum, $colnum++, $songrow[SongTitleAppearances] );
}
// end song title appearances actual
$rownum++; $colnum = 0;



$sectiontitle = "Song Title Placements";
$thistype = "placement";
genreReportSongMulti( $sectiontitle, $thistype, $thesesongs, $thesesongids );


$sectiontitle = "Lyrical Themes";
$thistype = "lyricaltheme";
genreReportSongMulti( $sectiontitle, $thistype, $thesesongs, $thesesongids );


$sectiontitle = "Instrumentation";
$thistype = "primaryinstrumentation";
genreReportSongMulti( $sectiontitle, $thistype, $thesesongs, $thesesongids, true, "", "Main" );


// tempo has to stay the same because it's crazy
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Tempo", $format_bold );
$rownum++; $colnum = 0;

$colheaders = array();
foreach( $thesesongs as $songrow )
{
    $poss = calculateTempoString( $songrow );
    if( $poss )
    {
        $tempodiv = floor( $songrow[Tempo] / 10 );
        $colheaders[str_pad( $tempodiv, 10, "0", STR_PAD_LEFT)] = $poss;
    }
}

ksort( $colheaders );
$colheaders = array_values( $colheaders );

$sheet->write( $rownum, $colnum++, "Song", $format_bold );
foreach( $colheaders as $c )
{
    $sheet->write( $rownum, $colnum++, $c, $format_bold );
}

$totals = array( "" );
foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );

    $poss = calculateTempoString( $songrow );
    foreach( $colheaders as $colid=>$c )
    {
        $val = 0;
        if( $poss == $c )
        {
            $val = 1;
            if( !isset( $totals[$colid] ) ) $totals[$colid] = 0;
            $totals[$colid]++;
        }
        $sheet->write( $rownum, $colnum++, $val );
        
    }
    
}

genreReportWriteTotals( $totals, $numsongs );

// start tempo actual 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Tempo - Actual", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Tempo", $format_bold );

foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $sheet->write( $rownum, $colnum++, $songrow[Tempo] );
}
// end tempo actual
$rownum++; $colnum = 0;



// start form 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Form/Structure", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Abbreviated Form", $format_bold );
$sheet->write( $rownum, $colnum++, "Full Form", $format_bold );

foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $sheet->write( $rownum, $colnum++, $songrow[AbbrevSongStructure] );
    $sheet->write( $rownum, $colnum++, $songrow[SongStructure] );
}
// start form end form
$rownum++; $colnum = 0;


$sectiontitle = "Song Length";
$currcolname = "SongLengthRange";
$orderbycolname = "SongLength";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );




// start Song Length actual 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Song Length - Actual", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Song Length", $format_bold );

foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $val = db_query_first_cell( "select time_to_sec( SongLength ) from songs where id = $songrow[id]" ) ;
    $sheet->write( $rownum, $colnum++, excelSeconds( $val ), $timeformat );
}
// end song title appearances actual
$rownum++; $colnum = 0;



// DO TOTAL SECTION BREAKDOWN
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Total Section Breakdown", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$tmpsections = db_query_array( "select WithoutNumber from songsections order by OrderBy desc", "WithoutNumber", "WithoutNumber" );
foreach( $tmpsections as $s )
{
    $sheet->write( $rownum, $colnum++, $s, $format_bold );
}
    $sheet->write( $rownum, $colnum++, "Post-Chorus", $format_bold );


foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    foreach( $tmpsections as $s )
    {
        $sval = db_query_first_cell( "select sum( sectionpercent ) from song_to_songsection where WithoutNumberHard = '$s' and songid = '$songrow[id]'" );
        $sval = ( $sval / 100  );
        $sheet->write( $rownum, $colnum++, $sval, $percentformat );
    }
logquery( "select sum( sectionpercent ) from song_to_songsection where PostChorus = 1 and songid = '$songrow[id]'" );
    $sval = db_query_first_cell( "select sum( sectionpercent ) from song_to_songsection where PostChorus = 1 and songid = '$songrow[id]'" );
    $sval = ( $sval / 100  );
    $sheet->write( $rownum, $colnum++, $sval, $percentformat );
    
}
// end total section breakdown


// DO Average section length
$rownum++; $colnum = 0;
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Average Section Length", $format_bold );
$rownum++; $colnum = 0;

$tmpsections = db_query_array( "select WithoutNumber from songsections order by OrderBy desc", "WithoutNumber", "WithoutNumber" );
foreach( $tmpsections as $s )
{
    $sheet->write( $rownum, $colnum++, $s, $format_bold );
}


$rownum++;
$colnum = 0;
foreach( $tmpsections as $s )
{
    $sval = db_query_first_cell( "select avg( time_to_sec( length ) ) from song_to_songsection where WithoutNumberHard = '$s' and songid in ( " . implode( ", ", $thesesongids ). " ) " );
    $sheet->write( $rownum, $colnum++, excelSeconds( $sval ) , $timeformat );
}
// end average section length

// DO Average # bars
$rownum++; $colnum = 0;
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Average Number of Bars", $format_bold );
$rownum++; $colnum = 0;

$tmpsections = db_query_array( "select WithoutNumber from songsections order by OrderBy desc", "WithoutNumber", "WithoutNumber" );
foreach( $tmpsections as $s )
{
    $sheet->write( $rownum, $colnum++, $s, $format_bold );
}


$rownum++;
$colnum = 0;
foreach( $tmpsections as $s )
{
    $sval = db_query_first_cell( "select avg( Bars ) from song_to_songsection where WithoutNumberHard = '$s' and songid in ( " . implode( ", ", $thesesongids ). " ) " );
    $sheet->write( $rownum, $colnum++, number_format( $sval ) );
}
// end average # bars



$tmpsections = db_query_array( "select id, Name from songsections, song_to_songsection where songsectionid = songsections.id and songid  in ( " . implode( ", ", $thesesongids ). " )  order by OrderBy desc", "id", "Name" );

// DO actual length - time
$rownum++; $colnum = 0;
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Actual Length - Time", $format_bold );
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Song", $format_bold );
foreach( $tmpsections as $s )
{
    $sheet->write( $rownum, $colnum++, $s, $format_bold );
}



$tmptotals = array(); $tmpnums = array();
foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );

    foreach( $tmpsections as $s=>$throwaway )
    {
        $sval = db_query_first_cell( "select time_to_sec( length ) from song_to_songsection where songsectionid = '$s' and songid = $songrow[id] " );
        if( $sval )
        {
            $sheet->write( $rownum, $colnum++, excelSeconds( $sval ), $timeformat );
            if( !isset( $tmpnums[$s] ) )
            {
                $tmpnums[$s]=0;
                $tmptotals[$s]=0;
            }
            $tmpnums[$s]++;
            $tmptotals[$s] += $sval;
            
        }
        else
        {
            $colnum++;
        }
    }
}

$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Average", $format_bold );
foreach( $tmpsections as $s=>$throwaway )
{
    $tval = $tmptotals[$s];
    $tval = number_format( $tval / $tmpnums[$s] );
    $sheet->write( $rownum, $colnum++, excelSeconds( $tval ), $timeformat );
    
}
$rownum++; $colnum = 0;


// end actual length - time

// DO actual length - bars
$rownum++; $colnum = 0;
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Actual Length - Bars", $format_bold );
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Song", $format_bold );
foreach( $tmpsections as $s )
{
    $sheet->write( $rownum, $colnum++, $s, $format_bold );
}
$tmptotals = array(); $tmpnums = array();
foreach( $thesesongs as $songrow )
{
    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );

    foreach( $tmpsections as $s=>$throwaway )
    {
        $sval = db_query_first_cell( "select Bars from song_to_songsection where songsectionid = '$s' and songid = $songrow[id] " );
        $sheet->write( $rownum, $colnum++, $sval);
        if( !$sval )
            continue;
        if( !isset( $tmpnums[$s] ) )
        {
            $tmpnums[$s]=0;
            $tmptotals[$s]=0;
        }
        $tmpnums[$s]++;
        $tmptotals[$s] += $sval;
    }
}
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Average", $format_bold );
foreach( $tmpsections as $s=>$throwaway )
{
    $tval = $tmptotals[$s];
    if( !$tmpnums[$s] ) $tmpnums[$s] = 1;
    $tval = number_format( $tval / $tmpnums[$s] );
    $sheet->write( $rownum, $colnum++, $tval, $format_bold );
    
}

$rownum++; $colnum = 0;
// end actual length - bars



$rownum++; $colnum = 0;
$sectiontitle = "First Section Type";
$currcolname = "FirstSection";
$orderbycolname = "FirstSection";
$displayinstead = db_query_array( "select ID, WithoutNumber from songsections", "ID", "WithoutNumber" );
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );
$displayinstead = array();

$sectiontitle = "Intro Length Range";
$currcolname = "IntroLengthRangeNums";
$orderbycolname = "IntroLengthRangeNums";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );

// start intro length actual 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Intro Length - Actual", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Intro Length", $format_bold );

foreach( $thesesongs as $songrow )
{
    $exists = db_query_first_cell( "select songsectionid from song_to_songsection where WithoutNumberHard = 'Intro' and songid = '$songrow[id]'" );
    if( !$exists )
        continue;
    $val = db_query_first_cell( "select time_to_sec( length ) from song_to_songsection where WithoutNumberHard = 'Intro' and songid = '$songrow[id]'" );

    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $sheet->write( $rownum, $colnum++, excelSeconds( $val ), $timeformat );
}
// end intro length actual
$rownum++; $colnum = 0;

// start intro length actual  - bars
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Intro Length - Actual - Bars", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Intro Length", $format_bold );

foreach( $thesesongs as $songrow )
{
    $exists = db_query_first_cell( "select songsectionid from song_to_songsection where WithoutNumberHard = 'Intro' and songid = '$songrow[id]'" );
    if( !$exists )
        continue;
    $val = db_query_first_cell( "select Bars from song_to_songsection where WithoutNumberHard = 'Intro' and songid = '$songrow[id]'" );

    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $sheet->write( $rownum, $colnum++, $val );
}
// end intro length actual - bars
$rownum++; $colnum = 0;

$sectiontype = "Verse";
$sectiontypeplural = "Verses";
genreReportSection( $sectiontype, $sectiontypeplural, $thesesongs, $thesesongids  );

$sectiontype = "Pre-Chorus";
$sectiontypeplural = "Pre-Choruses";
genreReportSection( $sectiontype, $sectiontypeplural, $thesesongs, $thesesongids  );

$sectiontype = "Chorus";
$sectiontypeplural = "Choruses";
genreReportSection( $sectiontype, $sectiontypeplural, $thesesongs, $thesesongids  );

$sectiontitle = "First Chorus Occurance - Range";
$currcolname = "FirstChorusRange";
$orderbycolname = "case when FirstChorusRange = 'Kickoff' then 0 else FirstChorusRange end";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );

// start first chorus occurence actual 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "First Chorus Occurrence - Actual", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "First Chorus Time", $format_bold );

foreach( $thesesongs as $songrow )
{
    $exists = db_query_first_cell( "select songsectionid from song_to_songsection where WithoutNumberHard = 'Chorus'  and songid = '$songrow[id]'" );
    if( !$exists )
        continue;
    $val = db_query_first_cell( "select min( time_to_sec( starttime ) ) from song_to_songsection where WithoutNumberHard = 'Chorus' and songid = '$songrow[id]'" );

    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $sheet->write( $rownum, $colnum++, excelSeconds( $val ), $timeformat );
}
// end first chorus occurence actual



$rownum++; 
$colnum = 0;
$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Percentage Of Songs That Contain A Bridge", $format_bold );
// this is a SPECIAL ONE
$allvalues = array();
$notesarr = array();

$tmpsongids = db_query_array( "select id from songs where songs.id in ( " . implode( ", ", $thesesongids ). " ) and BridgeCount > 0 ", "id", "id" );
$max = count( $tmpsongids );
if( count( $tmpsongids ) )
    $notesarr[][] = implode( ",", $tmpsongids );
else
    $notesarr[][] = array();
$labels = array();
$labels[] = number_format( $max / ($numsongs?$numsongs:1) * 100 ). "%"; 
$allvalues[] = array_values( $labels );

writeGenreCompReportLines( $sheet, $allvalues, $notesarr );

$rownum++; 
$colnum = 0;
$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Percentage Of Songs That Contain A Bridge Surrogate", $format_bold );
// this is a SPECIAL ONE
$allvalues = array();
$notesarr = array();

$tmpsongids = db_query_array( "select id from songs where songs.id in ( " . implode( ", ", $thesesongids ). " ) and songs.id in ( select songid from song_to_songsection where BridgeSurrogate = 1 ) ", "id", "id" );
$max = count( $tmpsongids );
if( count( $tmpsongids ) )
    $notesarr[][] = implode( ",", $tmpsongids );
else
    $notesarr[][] = array();
$labels = array();
$labels[] = number_format( $max / ($numsongs?$numsongs:1) * 100 ). "%"; 
$allvalues[] = array_values( $labels );

writeGenreCompReportLines( $sheet, $allvalues, $notesarr );



$rownum++; $colnum = 0;

$sectiontype = "Bridge";
$sectiontypeplural = "Bridges";
genreReportSection( $sectiontype, $sectiontypeplural, $thesesongs, $thesesongids, true  );


// start bridge surrogate section 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Bridge Surrogate Section", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );

$cols = db_query_array( "select id, Name from song_to_songsection, songsections where songsectionid = songsections.id and songid in ( " . implode( ",", $thesesongids ) . " ) and BridgeSurrogate = 1 order by OrderBy desc ", "id", "Name" );
foreach( $cols as $cid=>$cval )
{
$sheet->write( $rownum, $colnum++, "$cval", $format_bold );
}

foreach( $thesesongs as $songrow )
{
    $mine = db_query_array( "select songsectionid from song_to_songsection where BridgeSurrogate = 1 and songid = '$songrow[id]'", "songsectionid", "songsectionid" );
    if( !count( $mine ) )
        continue;

    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    foreach( $cols as $cid=>$cval )
    {
        $sheet->write( $rownum, $colnum++, $mine[$cid]?1:0 );
    }
}
// end bridge surrogate section
$rownum++; $colnum = 0;




$sectiontype = "Inst Break";
$sectiontypeplural = "Inst Breaks";
genreReportSection( $sectiontype, $sectiontypeplural, $thesesongs, $thesesongids, true  );

$sectiontype = "Vocal Break";
$sectiontypeplural = "Vocal Breaks";
genreReportSection( $sectiontype, $sectiontypeplural, $thesesongs, $thesesongids, true  );


$sectiontitle = "Last Section Type";
$currcolname = "LastSectionID";
$orderbycolname = "LastSectionID";
$displayinstead = db_query_array( "select ID, WithoutNumber from songsections", "ID", "WithoutNumber" );
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );
$displayinstead = array();

$sectiontitle = "Vocals";
$currcolname = "VocalsGender";
$orderbycolname = "VocalsGender";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );

$sectiontitle = "Outro Length Range";
$currcolname = "OutroLengthRangeNums";
$orderbycolname = "OutroLengthRangeNums";
genreReportSongColumn( $sectiontitle, $currcolname, $orderbycolname, $thesesongs, $thesesongids );

// start outro length actual 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Outro Length - Actual", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Outro Length", $format_bold );

foreach( $thesesongs as $songrow )
{
    $exists = db_query_first_cell( "select songsectionid from song_to_songsection where WithoutNumberHard = 'Outro' and songid = '$songrow[id]'" );
    if( !$exists )
        continue;
    $val = db_query_first_cell( "select time_to_sec( length ) from song_to_songsection where WithoutNumberHard = 'Outro' and songid = '$songrow[id]'" );

    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $sheet->write( $rownum, $colnum++, excelSeconds( $val ), $timeformat );
}
// end outro length actual

// start outro length actual - bars 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Outro Length - Actual - Bars", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Outro Length", $format_bold );

foreach( $thesesongs as $songrow )
{
    $exists = db_query_first_cell( "select songsectionid from song_to_songsection where WithoutNumberHard = 'Outro' and songid = '$songrow[id]'" );
    if( !$exists )
        continue;
    $val = db_query_first_cell( "select Bars from song_to_songsection where WithoutNumberHard = 'Outro' and songid = '$songrow[id]'" );

    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    $sheet->write( $rownum, $colnum++, $val );
}
// end outro length actual - bars

$rownum++; 
$colnum = 0;
$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Percentage Of Songs That Contain A Post-Chorus", $format_bold );
// this is a SPECIAL ONE
$allvalues = array();
$notesarr = array();

$tmpsongids = db_query_array( "select distinct( id ) from songs where songs.id in ( " . implode( ", ", $thesesongids ). " ) and songs.id in ( select songid from song_to_songsection where PostChorus = 1 ) ", "id", "id" );
$max = count( $tmpsongids );
if( count( $tmpsongids ) )
    $notesarr[][] = implode( ",", $tmpsongids );
else
    $notesarr[][] = array();
$labels = array();
$labels[] = number_format( $max / ($numsongs?$numsongs:1) * 100 ). "%"; 
$allvalues[] = array_values( $labels );

writeGenreCompReportLines( $sheet, $allvalues, $notesarr );


// start post chorus type 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Post-Chorus Section", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );
$sheet->write( $rownum, $colnum++, "Song Section", $format_bold );

$cols = db_query_array( "select postchorustypes.id, Name from song_to_postchorustype, postchorustypes where postchorustypeid = postchorustypes.id and songid in ( " . implode( ",", $thesesongids ) . " ) order by OrderBy ", "id", "Name" );
foreach( $cols as $cid=>$cval )
{
$sheet->write( $rownum, $colnum++, "$cval", $format_bold );
}

foreach( $thesesongs as $songrow )
{
    $dist = db_query_array( "select distinct( type ) from song_to_postchorustype where songid = '$songrow[id]'", "type", "type" );
    foreach( $dist as $d )
    {
    
        $mine = db_query_array( "select postchorustypeid from song_to_postchorustype where type = '$d' and songid = '$songrow[id]'", "postchorustypeid", "postchorustypeid" );
        
        $rownum++;
        $colnum = 0;
        $sheet->write( $rownum, $colnum++, $songrow[SongName] );
        $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
        $sheet->write( $rownum, $colnum++, getTableValue( $d, "songsections" ) );
        
        foreach( $cols as $cid=>$cval )
        {
            $sheet->write( $rownum, $colnum++, $mine[$cid]?1:0 );
        }
    }
}
// end post chorus type
$rownum++; $colnum = 0;



// start post chorus section 
$rownum++; $colnum = 0;
$sheet->write( $rownum, $colnum++, "Post-Chorus Section", $format_bold );
$rownum++; $colnum = 0;

$sheet->write( $rownum, $colnum++, "Song title", $format_bold );
$sheet->write( $rownum, $colnum++, "Artist", $format_bold );

$cols = db_query_array( "select id, Name from song_to_songsection, songsections where songsectionid = songsections.id and songid in ( " . implode( ",", $thesesongids ) . " ) and PostChorus = 1 order by OrderBy desc ", "id", "Name" );
foreach( $cols as $cid=>$cval )
{
$sheet->write( $rownum, $colnum++, "$cval", $format_bold );
}

foreach( $thesesongs as $songrow )
{
    $mine = db_query_array( "select songsectionid from song_to_songsection where PostChorus = 1 and songid = '$songrow[id]'", "songsectionid", "songsectionid" );
    if( !count( $mine ) )
        continue;

    $rownum++;
    $colnum = 0;
    $sheet->write( $rownum, $colnum++, $songrow[SongName] );
    $sheet->write( $rownum, $colnum++, $songrow[ArtistBand] );
    foreach( $cols as $cid=>$cval )
    {
        $sheet->write( $rownum, $colnum++, $mine[$cid]?1:0 );
    }
}
// end post chorus section
$rownum++; $colnum = 0;


?>