<?php include 'header.php';
include "comparisonfunctions.php";

$displvalues = array();

if( $type == "artists" )
{
	$displvalues["type"] = "Performing Artists";
	$displvalues["searchcrit"] = "primaryartist";
	if( !$artists )
	    $artists = $_GET["a"];
    $artists[] = -1;
    $artiststr = implode( ", ", $artists );
	if( !$groups )
	    $groups = $_GET["g"];
    $groups[] = -1;
    $groupstr = implode( ", ", $groups );
    $arr = db_query_array( "select * from artists, song_to_artist where artistid = artists.id and type in ( 'primary', 'featured' ) and artistid in ( $artiststr ) order by Name", "Name", "Name" );
    $arr2 = db_query_array( "select * from groups, song_to_group where groupid = groups.id  and type in ( 'primary', 'featured' ) and groupid in ( $groupstr ) order by Name", "Name", "Name" );
    $arr = array_merge( $arr, $arr2 );
    ksort( $arr );
    $displvalues["arr"] = $arr;
    $num = count( $arr );
}
if( $type == "producers" )
{
	$displvalues["type"] = "Producers / Production Teams";
	$displvalues["searchcrit"] = "producer";
    $producers[] = -1;
    $producerstr = implode( ", ", $producers );
    $arr = db_query_array( "select * from producers, song_to_producer where producerid = producers.id and producerid in ( $producerstr ) order by Name", "Name", "Name" );
    ksort( $arr );
    $displvalues["arr"] = $arr;
}
if( $type == "labels" )
{
	$displvalues["type"] = "Record Labels";
	$displvalues["searchcrit"] = "labelid";
    $labels[] = -1;
    $labelstr = implode( ", ", $labels );
    $arr = db_query_array( "select * from labels, song_to_label where labelid = labels.id and labelid in ( $labelstr ) order by Name", "Name", "Name" );
    ksort( $arr );
    $displvalues["arr"] = $arr;
}
if( $type == "songwriters" )
{
	$displvalues["type"] = "Songwriters";
	$displvalues["searchcrit"] = "writer";
	if( !$artists )
	    $artists = $_GET["a"];
    $artists[] = -1;
    $artiststr = implode( ", ", $artists );
    $arr = db_query_array( "select * from artists, song_to_artist where artistid = artists.id and type = 'creditedsw' and artistid in ( $artiststr ) order by Name", "Name", "Name" );
    ksort( $arr );
    $displvalues["arr"] = $arr;
}
if( $type == "songs" )
{
	$displvalues["type"] = "Songs";
    $arr = array(); 
    foreach( $songs as $cleanurl )
    {
        $songrow = db_query_first( "select id, CleanUrl from songs where IsActive = 1 and CleanURL = '$cleanurl'" );
	if( $songrow[id] )
	    $arr[] = $songrow;
    }
    ksort( $arr );
    $displvalues["arr"] = $arr;
}
    $num = count( $displvalues[arr] );

if($_GET["title"] )
		  $displvalues["type"] = $_GET["title"];
?>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
	<h1>LIST RESULTS (<?=$num?>)</h1>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
						<form class="search-form">
							<div class="form-row-full">
							</div><!-- /.form-row-left -->
							
							<div class="comp-hidden-browse comp-hidden-perform show" id="comp-perform">
    <? if( strpos( $numhits, "Hit" ) !== false ) { ?>
								<h3><a class="comp-icon "><?=$displvalues[type]?> <?=$numhits?" - " . $numhits:""?> <?=$timeperiod?" : $timeperiod":""?></a></h3>
                                                   <? } else if( $numhits ) { ?>
    <h3><a class="comp-icon "><?=$displvalues[type]?> - <?=number_format( $numhits )?> Hit(s) <?=$timeperiod?" : $timeperiod":""?></a></h3>
        <? } else { ?>
    <h3><a class="comp-icon "><?=$displvalues[type]?> <?=$timeperiod?" : $timeperiod":""?></a></h3>
<? } ?>
								<div id="comp-search-hidden" class="temp-hidden-browse">
      								<table width="100%" id="browse-table">
<?php
    foreach( $displvalues[arr] as $a )
{
 ?>
										<tr>
											<td class="search-column-2">
<? if( $type == "songs" ) { ?>
									<a class="appendid" href="/<?=$a[CleanUrl]?>">
										<?=getSongnameFromSongid( $a[id] )?> - 
        <?php
        $frontendfieldname = "primaryartist";
        $frontendlinks = true;	   
        $frontenduseid = false;
                                     $songid = $a[id];
                                     $any = false; 
                                     $artists = getArtists( $songid );
                                     if( $artists )
                                         $any = true;
                                     echo( $artists );
                                     $artists = getGroups( $songid );
                                     if( $any && $artists ) echo( ", " );
                                     if( $artists )
                                         $any = true;
                                     echo( $artists );
                                     $artists = getArtists( $songid, "featured" );
                                     if( $artists ) { ?> 
                                         featuring <?=$artists?>
                                             <? }
                                     $artists = getGroups( $songid, "featured" );
                                     if( $artists ) { ?> 
feat. <?=$artists?>
<? }
        $frontendlinks = false;	   
 ?>

									</a>
			    <? } else if( $type == "labels" ) { ?>
<a href='/<?=$a?>'><?=$a?></a>
			    <? } else { ?>
<?=$a?>
<? } ?>
											</td>
										</tr>
<? } ?>
									</table>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->
						</form><!-- /.search-form -->
					</div><!-- /search-body -->
				</div><!-- /.info-container -->
			</div>
		</section><!-- /.song-title-top -->
	</div><!-- /.site-body -->
<?php include 'footer.php';?>
