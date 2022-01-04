<? // | TOP COMPOSITIONAL COMPARISON CHART         

$primarygenres = db_query_rows( "select * from genres order by OrderBy , Name", "id" );
$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $sdateq, $sdatey, $edateq, $edatey );
$numsongs = count( $allsongs );
if( !$numsongs ) $numsongs = 1;
$allsongstr = implode( ",", $allsongs );

$numingenre = array();
$genresongs = array();
$genresongsstr = array();
$sheet->write( $rownum, $colnum++, "CATEGORY", $format_bold );
foreach( $primarygenres as $prow )
  {
    $genresongs[$prow[id]] = db_query_array( "select id from songs where GenreID = '$prow[id]' and songs.id in ( $allsongstr )", "id", "id" );
    $num = count( $genresongs[$prow[id]] );
    $genresongsstr[$prow[id]] = implode( ", ", $genresongs[$prow[id]] );
    
    //    reportlog( "select count(*) from songs where GenreID = '$prow[id]' and songs.id in ( $allsongstr )" );

    if( !$num )
      {
	//	reportlog( "removing: " . $prow[Name] . " from report because no songs" );
	unset( $primarygenres[$prow[id]] );
	continue;
      }
    $numingenre[$prow[id]] = $num;

    $sheet->write( $rownum, $colnum++, strtoupper( $prow[Name] ) );
  }

$colnum = 0;
$rownum++;
$sheet->write( $rownum, $colnum++, "Number of Songs Within The Top 10", $format_bold );
foreach( $primarygenres as $p )
  {
    $sheet->write( $rownum, $colnum++, $numingenre[$p[id]] );
    if( $addnote )
        $sheet->writeNote( $rownum, $colnum-1, getSongNames( $genresongs[$p[id]] ) );
  }


$colnum = 0;
$rownum++;
$sheet->write( $rownum, $colnum++, "Percentage Of Songs Within The Top 10", $format_bold );
foreach( $primarygenres as $p )
  {
    $num = db_query_first_cell( "select count(*) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr )" );
    $sheet->write( $rownum, $colnum++, $num / $numsongs, $percentformat );
    if( $addnote )
    {
        $sheet->writeNote( $rownum, $colnum-1, getSongNames( db_query_array( "select id from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr )", "id", "id" ) ) );
    }
  }


$colnum = 0;
$rownum++;
$sheet->write( $rownum, $colnum++, "Top Label(s)", $format_bold );

// this is a percent one that is for a value IN the songs table and another table (LabelID)
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
{
    $tmpgenresongs = $genresongsstr[$p[id]];
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( songid ) from songs, song_to_label, labels where GenreID = '$p[id]' and labelid = labels.id and songid = songs.id and songs.id in ( $tmpgenresongs ) group by Name order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, Name from songs, labels, song_to_label where songid = songs.id and GenreID = '$p[id]' and labelid = labels.id and songs.id in ( $tmpgenresongs ) group by Name having count(*) = $max order by OrderBy ", "sids", "Name"  );
    
    $each = count( $labels ) > 1 ?" each":"";
    $notesarr[] = array_keys( $labels );
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
}
//reportlog( print_r( $notesarr, true ) );
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );


$colnum = 0;
$rownum++;
$sheet->write( $rownum, $colnum++, "Top Songwriter Team Count", $format_bold );

// this is a percent one that is for a value IN the songs table (SongwriterCount) and no other table
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) group by SongwriterCount order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, SongwriterCount from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) group by SongwriterCount having count(*) = $max order by SongwriterCount", "sids", "SongwriterCount"  );
    foreach( $labels as $key => $val )
      {
	if( $key == 1 )
	  $labels[$key] = $val . " Writer";
	else
	  $labels[$key] = $val . " Writers";
      }
    $each = count( $labels ) > 1 ?" each":"";
    $notesarr[] = array_keys( $labels );
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );




$colnum = 0;
$rownum++;
$sheet->write( $rownum, $colnum++, "Top Lead Vocal", $format_bold );

// this is a percent one that is for a value IN the songs table (VocalsGender) and no other table
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and VocalsGender > '' group by VocalsGender order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, VocalsGender from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and VocalsGender > '' group by VocalsGender having count(*) = $max order by VocalsGender", "sids", "VocalsGender"  );
    $notesarr[] = array_keys( $labels );
    $each = count( $labels ) > 1 ?" each":"";
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );



$colnum = 0;
$rownum++; 
$sheet->write( $rownum, $colnum++, "Top Sub-Genre(s) & Influencers", $format_bold );

// this is a percent one that is for a value IN the songs table and another table MULTIPLE (subgenreid)
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $max = db_query_first_cell( "select count(*) as cnt from songs, subgenres, song_to_subgenre sts where GenreID = '$p[id]' and subgenreid = subgenres.id and songs.id = sts.songid and songs.id in ( $allsongstr ) and sts.type = 'Main' and subgenres.Name <> '$p[Name]'  and HideFromAdvancedSearch = 0 group by Name order by cnt desc limit 1" );
    if( !$max ) $max = "0";
    $subgenres = db_query_array( "select group_concat( songs.id ) as sids, Name from songs, subgenres, song_to_subgenre sts where GenreID = '$p[id]' and sts.type = 'Main'  and subgenreid = subgenres.id and songs.id in ( $allsongstr ) and songs.id = sts.songid  and subgenres.Name <> '$p[Name]' and HideFromAdvancedSearch = 0 group by Name having count(*) = $max order by OrderBy ", "sids", "Name"  );
    $notesarr[] = array_keys( $subgenres );
    $each = count( $subgenres ) > 1 ?" each":"";
    $subgenres[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $subgenres );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );



$colnum = 0;
$rownum++; 
$sheet->write( $rownum, $colnum++, "Electric Vs. Acoustic Songs", $format_bold );
// this is a percent one that is for a value IN the songs table (ElectricVsAcoustic) and no other table
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and ElectricVsAcoustic > '' group by ElectricVsAcoustic order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, ElectricVsAcoustic from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and ElectricVsAcoustic > '' group by ElectricVsAcoustic having count(*) = $max order by ElectricVsAcoustic", "sids", "ElectricVsAcoustic"  );
    $notesarr[] = array_keys( $labels );
    $each = count( $labels ) > 1 ?" each":"";
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );



$colnum = 0;
$rownum++; 
$sheet->write( $rownum, $colnum++, "Top Instrumentation", $format_bold );
// this is a percent one that is for a value IN the songs table and another table MULTIPLE (primaryinstrumentationid)
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $tmpgenresongs = $genresongsstr[$p[id]];
    $max = db_query_first_cell( "select count(*) as cnt from songs, primaryinstrumentations, song_to_primaryinstrumentation sts where GenreID = '$p[id]' and primaryinstrumentationid = primaryinstrumentations.id and songs.id = sts.songid and songs.id in ( $tmpgenresongs ) and type = 'Main' group by Name order by cnt desc limit 1" );
//reportlog( "select count(*) as cnt from songs, primaryinstrumentations, song_to_primaryinstrumentation sts where GenreID = '$p[id]' and primaryinstrumentationid = primaryinstrumentations.id and songs.id = sts.songid and songs.id in ( $tmpgenresongs )  and type = 'Main'  group by Name order by cnt desc limit 1" );
    if( !$max ) $max = "0";
    $primaryinstrumentations = db_query_array( "select group_concat( songs.id ) as sids, Name from songs, primaryinstrumentations, song_to_primaryinstrumentation sts where GenreID = '$p[id]' and primaryinstrumentationid = primaryinstrumentations.id and songs.id in ( $tmpgenresongs ) and songs.id = sts.songid  and type = 'Main' group by Name having count(*) = $max order by OrderBy ", "sids", "Name"  );
//reportlog( "select group_concat( songs.id ) as sids, Name from songs, primaryinstrumentations, song_to_primaryinstrumentation sts where GenreID = '$p[id]' and primaryinstrumentationid = primaryinstrumentations.id and songs.id in ( $tmpgenresongs ) and songs.id = sts.songid  and type = 'Main' group by Name having count(*) = $max order by OrderBy"  );
    $notesarr[] = array_keys( $primaryinstrumentations );
    $each = count( $primaryinstrumentations ) > 1 ?" each":"";
    $primaryinstrumentations[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $primaryinstrumentations );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );



$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Top Lyrical Theme(s)", $format_bold );
// this is a percent one that is for a value IN the songs table and another table MULTIPLE (lyricalthemeid)
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
{
    $tmpgenresongs = $genresongsstr[$p[id]];
//    reportlog( "select count(*) as cnt from lyricalthemes, song_to_lyricaltheme sts, songs where lyricalthemeid = lyricalthemes.id and songs.id = sts.songid and songs.id in ( $tmpgenresongs ) and Name <> 'Lyrical Fusion Songs' group by Name order by cnt desc limit 1" );
    $max = db_query_first_cell( "select count(*) as cnt from lyricalthemes, song_to_lyricaltheme sts, songs where GenreID = '$p[id]' and lyricalthemeid = lyricalthemes.id and songs.id = sts.songid and songs.id in ( $tmpgenresongs ) and Name <> 'Lyrical Fusion Songs' group by Name order by cnt desc limit 1" );
    if( !$max ) $max = "0";
    $lyricalthemes = db_query_array( "select group_concat( songs.id ) as sids, Name from songs, lyricalthemes, song_to_lyricaltheme sts where GenreID = '$p[id]' and Name <> 'Lyrical Fusion Songs' and lyricalthemeid = lyricalthemes.id and songs.id in ( $tmpgenresongs ) and songs.id = sts.songid group by Name having count(*) = $max order by OrderBy ", "sids", "Name"  );
//reportlog( "select group_concat( songs.id ) as sids, Name from songs, lyricalthemes, song_to_lyricaltheme sts where GenreID = '$p[id]' and Name <> 'Lyrical Fusion Songs' and lyricalthemeid = lyricalthemes.id and songs.id in ( $tmpgenresongs ) and songs.id = sts.songid group by Name having count(*) = $max order by OrderBy"  );
    $notesarr[] = array_keys( $lyricalthemes );
    $each = count( $lyricalthemes ) > 1 ?" each":"";
    $lyricalthemes[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $lyricalthemes );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );


$colnum = 0;
$rownum++; 
$sheet->write( $rownum, $colnum++, "Top Title Word Count", $format_bold );

// this is a percent one that is for a value IN the songs table (SongTitleWordCount) and no other table
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) group by SongTitleWordCount order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, SongTitleWordCount from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) group by SongTitleWordCount having count(*) = $max order by SongTitleWordCount", "sids", "SongTitleWordCount"  );
    $notesarr[] = array_keys( $labels );
    foreach( $labels as $key => $val )
      {
	if( $key == 1 )
	  $labels[$key] = $val . " Word";
	else
	  $labels[$key] = $val . " Words";
      }
    $each = count( $labels ) > 1 ?" each":"";
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );


$colnum = 0;
$rownum++; 
$sheet->write( $rownum, $colnum++, "Top Title Appearance Range", $format_bold );
// this is a percent one that is for a value IN the songs table (SongTitleAppearanceRange) and no other table
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and SongTitleAppearanceRange > '' group by SongTitleAppearanceRange order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, SongTitleAppearanceRange from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and SongTitleAppearanceRange > ''  group by SongTitleAppearanceRange having count(*) = $max order by SongTitleAppearanceRange", "sids", "SongTitleAppearanceRange"  );
    $notesarr[] = array_keys( $labels );
    $each = count( $labels ) > 1 ?" each":"";
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );

$colnum = 0;
$rownum++; 
$sheet->write( $rownum, $colnum++, "Top Tempo Range", $format_bold );
// this is a percent one that is for a value IN the songs table (TempoRange) and no other table
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and TempoRange > '' and TempoRange <> 'N/A' group by TempoRange order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    $labels = array();
    if( $max )
      {
	$labels = db_query_array( "select group_concat( songs.id ) as sids, TempoRange from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and TempoRange > ''  group by TempoRange having count(*) = $max order by TempoRange", "sids", "TempoRange"  );
    $notesarr[] = array_keys( $labels );
	$each = count( $labels ) > 1 ?" each":"";
	$labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
      }
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );



$colnum = 0;
$rownum++; 
$sheet->write( $rownum, $colnum++, "Most Popular Form", $format_bold );
// this is a percent one that is for a value IN the songs table (AbbrevSongStructure) and no other table
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and AbbrevSongStructure > '' group by AbbrevSongStructure order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, AbbrevSongStructure from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and AbbrevSongStructure > ''  group by AbbrevSongStructure having count(*) = $max order by AbbrevSongStructure", "sids", "AbbrevSongStructure"  );
    $notesarr[] = array_keys( $labels );
    $each = count( $labels ) > 1 ?" each":"";
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );


$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Top Song Length Range", $format_bold );
// this is a percent one that is for a value IN the songs table (SongLengthRange) and no other table
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and SongLengthRange > '' group by SongLengthRange order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, SongLengthRange from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and SongLengthRange > ''  group by SongLengthRange having count(*) = $max order by SongLengthRange", "sids", "SongLengthRange"  );
    $notesarr[] = array_keys( $labels );
    $each = count( $labels ) > 1 ?" each":"";
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );

$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Top First Section Type", $format_bold );
// this is a percent one that is for a value IN the songs table and another table (FirstSection)
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and FirstSectionType > '' group by FirstSectionType order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, FirstSectionType from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and FirstSectionType > ''  group by FirstSectionType having count(*) = $max order by FirstSectionType", "sids", "FirstSectionType"  );
    $notesarr[] = array_keys( $labels );
    $each = count( $labels ) > 1 ?" each":"";
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );


$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Top Intro Length Range", $format_bold );
// this is a percent one that is for a value IN the songs table (IntroLengthRangeNums) and no other table
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and IntroLengthRangeNums > '' group by IntroLengthRangeNums order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, IntroLengthRangeNums from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and IntroLengthRangeNums > ''  group by IntroLengthRangeNums having count(*) = $max order by IntroLengthRangeNums", "sids", "IntroLengthRangeNums"  );
    $notesarr[] = array_keys( $labels );
    $each = count( $labels ) > 1 ?" each":"";
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );

$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Top Verse Section Count", $format_bold );
// this is a percent one that is for a value IN the songs table (VerseCount) and no other table
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and VerseCount > '' group by VerseCount order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, VerseCount from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and VerseCount > ''  group by VerseCount having count(*) = $max order by VerseCount", "sids", "VerseCount"  );
    $notesarr[] = array_keys( $labels );
    $each = count( $labels ) > 1 ?" each":"";
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );


$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Percentage Of Songs That Contain A Pre-Chorus", $format_bold );
reportlog( "hmm prechorus" );
// this is a SPECIAL ONE
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
      $tmpsongids = db_query_array( "select id from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and PrechorusCount > 0 ", "id", "id" );
      $max = count( $tmpsongids );
      if( count( $tmpsongids ) )
          $notesarr[][] = implode( ",", $tmpsongids );
      else
          $notesarr[][] = array();
      if( !$max ) $max = "0";
      $labels = array();
      $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%"; 
      $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );


$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Percentage Of Songs That Contain A Post-Chorus", $format_bold );
// this is a SPECIAL ONE
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
      $tmpsongids = db_query_array( "select id from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and songs.id in ( select songid from song_to_songsection where PostChorus = 1 ) ", "id", "id" );
      $max = count( $tmpsongids );
      if( count( $tmpsongids ) )
          $notesarr[][] = implode( ",", $tmpsongids );
      else
          $notesarr[][] = array();
      $labels = array();
      $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%"; 
      $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );



$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Top Chorus Section Count", $format_bold );
// this is a percent one that is for a value IN the songs table (ChorusCount) and no other table
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and ChorusCount > '' group by ChorusCount order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, ChorusCount from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and ChorusCount > ''  group by ChorusCount having count(*) = $max order by ChorusCount", "sids", "ChorusCount"  );
    $notesarr[] = array_keys( $labels );
    $each = count( $labels ) > 1 ?" each":"";
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );

$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Top First Chorus Hit Range (Time)", $format_bold );

// this is a percent one that is for a value IN the songs table (FirstChorusRange) and no other table
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and FirstChorusRange > '' group by FirstChorusRange order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, FirstChorusRange from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and FirstChorusRange > ''  group by FirstChorusRange having count(*) = $max order by FirstChorusRange", "sids", "FirstChorusRange"  );
    $notesarr[] = array_keys( $labels );
    $each = count( $labels ) > 1 ?" each":"";
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );


$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Percentage Of Songs That Contain A Bridge", $format_bold );
// this is a SPECIAL ONE
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
      $tmpsongids = db_query_array( "select id from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and BridgeCount > 0 ", "id", "id" );
      $max = count( $tmpsongids );
      if( count( $tmpsongids ) )
          $notesarr[][] = implode( ",", $tmpsongids );
      else
          $notesarr[][] = array();
      $labels = array();
      $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%"; 
      $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );


$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Percentage Of Songs That Contain A Bridge Surrogate", $format_bold );
// this is a SPECIAL ONE
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
      $tmpsongids = db_query_array( "select id from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and songs.id in ( select songid from song_to_songsection where BridgeSurrogate = 1 ) ", "id", "id" );
      $max = count( $tmpsongids );
      if( count( $tmpsongids ) )
          $notesarr[][] = implode( ",", $tmpsongids );
      else
          $notesarr[][] = array();
      $labels = array();
      $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%"; 
      $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );


$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Percentage Of Songs That Contain An Instrumental Or Vocal Break", $format_bold );
// this is a SPECIAL ONE
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $tmpsongids = db_query_array( "select id from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and BreakCount > 0 ", "id", "id" );
    // reportlog( "hmm" . print_r( $tmpsongids, true ) );
    // reportlog( "hmm count" . count( $tmpsongids ) );
    if( count( $tmpsongids ) )
        $notesarr[][] = implode( ",", $tmpsongids );
    else
        $notesarr[][] = array();
    $max = count( $tmpsongids );
    if( !$max ) $max = "0";
    $labels = array();
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%"; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );

$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Top Last Section Type", $format_bold );
// this is a percent one that is for a value IN the songs table and another table (LastSectionID)
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and LastSectionType > '' group by LastSectionType order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, LastSectionType from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and LastSectionType > ''  group by LastSectionType having count(*) = $max order by LastSectionType", "sids", "LastSectionType"  );
    $notesarr[] = array_keys( $labels );
    $each = count( $labels ) > 1 ?" each":"";
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );


$rownum++; 
$colnum = 0;
$sheet->write( $rownum, $colnum++, "Top Outro Length Range", $format_bold );
// this is a percent one that is for a value IN the songs table and another table (LastSectionID)
$allvalues = array();
$notesarr = array();
foreach( $primarygenres as $p )
  {
    $maxarr = db_query_first( "select count(*) as cnt, group_concat( id ) from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and OutroLengthRangeNums > '' group by OutroLengthRangeNums order by cnt desc limit 1" );
    $max = $maxarr[0];
    $tmpsongids = explode( ",", $maxarr[1] );
    if( !$max ) $max = "0";
    $labels = db_query_array( "select group_concat( songs.id ) as sids, OutroLengthRangeNums from songs where GenreID = '$p[id]' and songs.id in ( $allsongstr ) and OutroLengthRangeNums > ''  group by OutroLengthRangeNums having count(*) = $max order by OutroLengthRangeNums", "sids", "OutroLengthRangeNums"  );
    $notesarr[] = array_keys( $labels );
    $each = count( $labels ) > 1 ?" each":"";
    $labels[] = number_format( $max / $numingenre[$p[id]] * 100 ). "%" . $each; 
    $allvalues[] = array_values( $labels );
  }
writeGenreCompReportLines( $sheet, $allvalues, $notesarr );



?>