<?php include 'header.php';
include "comparisonfunctions.php";

?>
	<div class="site-body">
		<section class="song-title-top">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1><?=getOrCreateCustomTitle( "BROWSE", "BROWSE" )?></h1>
<!--						<a class="search-header-clear">CLEAR ALL</a>-->
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">
                        
                        <div class="graph-head">                       

     <div class="left set" style="margin-bottom:20px;">  
     
                       
                                          
    </div>   
    
    
    
       <div class="right set" style="margin-bottom:20px;">  
                  
               <div class="icon back-search ">
                   <a class=" desktop" href="/browse-database">Back</a></div>
                        
                       <div class="icon new-search ">
           
              <a href="/browse-database">New Search</a> </div>

    
    </div>
                        </div>
                        
						<form class="search-form">
							<div class="form-row-full">
								<select id="comp-select">
									<option value="">(Select One)</option>
        <option <?=$val=="artists"?"SELECTED":""?> value="Performing Artists">Performing Artists</option>
									<option <?=$val=="songwriters"?"SELECTED":""?> value="Songwriters">Songwriters</option>
									<option <?=$val=="labels"?"SELECTED":""?> value="Record Labels">Record Labels</option>
									<option <?=$val=="producers"?"SELECTED":""?> value="Producers">Producers and Production Teams</option>
									<option <?=$val=="songs"?"SELECTED":""?> value="Songs">Songs</option>
									<option <?=$val=="logicfiles"?"SELECTED":""?> value="Logic Files">Logic Files</option>
								</select>
							</div><!-- /.form-row-left -->
							
							<div class="comp-hidden-browse comp-hidden-perform hide" id="comp-perform">
								<h3><a class="comp-icon comp-icon-perform">Performing Artists</a></h3>
								<div id="comp-search-hidden" class="temp-hidden-browse">
      								<table width="100%" id="browse-table" class="sortable">
<?php
    $arr = db_query_array( "select * from artists, song_to_artist, songs where artistid = artists.id and type in ( 'primary', 'featured' ) and songs.id = songid and IsActive = 1 order by Name", "Name", "Name" );
    $arr2 = db_query_array( "select * from groups, song_to_group, songs where groupid = groups.id and type in  ( 'primary', 'featured' ) and songs.id = songid and IsActive = 1 order by Name", "Name", "Name" );
    $arr = array_merge( $arr, $arr2 );
    ksort( $arr );
    foreach( $arr as $a )
{

	$url = getArtistUrl( $a );
 ?>
										<tr>
											<td class="search-column-2">
												<a href="<?=$url?>"><?=$a?></a>
											</td>
											
											<td class="search-column-4">
												<a href="<?=$url?>"><img src="assets/images/home/search-arrow-icon.svg" /></a>
												<div class="cf">
											</td>
										</tr>
<? } ?>
									</table>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->
							<div class="comp-hidden-browse comp-hidden-songwriters hide" id="comp-songwriters">
								<h3><a class="comp-icon comp-icon-songwriters">Songwriters</a></h3>
								<div id="comp-search-hidden" class="temp-hidden-browse">
									<table width="100%" id="browse-table">
<?php
    $arr = db_query_array( "select * from artists, song_to_artist where artistid = artists.id and type = 'creditedsw' order by Name", "Name", "Name" );
    ksort( $arr );
    foreach( $arr as $a )
{
	$url = getArtistUrl( $a );
 ?>
										<tr>
											<td class="search-column-2">
												<a href="/<?=$url?>"><?=$a?></a>
											</td>
											
											<td class="search-column-4">
												<a href="search-results.php?searchtype=Browse&search[writer]=<?=urlencode( $a )?>"><img src="assets/images/home/search-arrow-icon.svg" /></a>
												<div class="cf">
											</td>
										</tr>
<? } ?>
									</table>	
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->

							<div class="comp-hidden-browse comp-hidden-record hide" id="comp-record">
								<h3><a class="comp-icon comp-icon-record">Record Labels</a></h3>
								<div id="comp-search-hidden" class="temp-hidden-browse">
									<table width="100%" id="browse-table">
<?php
    $arr = db_query_array( "select * from labels, song_to_label where labelid = labels.id order by Name", "Name", "Name" );
    ksort( $arr );
    foreach( $arr as $a )
{
	$url = getArtistUrl( $a );
 ?>
										<tr>
											<td class="search-column-2">
												<a href="/<?=$url?>"><?=$a?></a>
											</td>
											
											<td class="search-column-4">
												<a href="search-results.php?searchtype=Browse&search[label]=<?=urlencode( $a )?>"><img src="assets/images/home/search-arrow-icon.svg" /></a>
												<div class="cf"></div>
											</td>
										</tr>
<? } ?>
									</table>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->

							<div class="comp-hidden-browse comp-hidden-producers hide" id="comp-producers">
								<h3><a class="comp-icon comp-icon-producers">Producers and Production Teams</a></h3>
								<div id="comp-search-hidden" class="temp-hidden-browse">
									<table width="100%" id="browse-table">
<?php
    $arr = db_query_array( "select * from producers, song_to_producer where producerid = producers.id order by Name", "Name", "Name" );
    ksort( $arr );
    foreach( $arr as $a )
{
	$url = getArtistUrl( $a );

 ?>
										<tr>
											<td class="search-column-2">
												<a href="/<?=$url?>"><?=$a?></a>
											</td>
											
											<td class="search-column-4">
												<a href="search-results.php?searchtype=Browse&search[producer]=<?=urlencode( $a )?>"><img src="assets/images/home/search-arrow-icon.svg" /></a>
												<div class="cf"></div>
											</td>
										</tr>
<? } ?>
									</table>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->

							<div class="comp-hidden-browse comp-hidden-songs hide" id="comp-songs">
								<h3><a class="comp-icon comp-icon-songs">Songs</a></h3>
								<div id="comp-search-hidden" class="temp-hidden-browse">
									<table width="100%" id="browse-table" >
<tr><th class="sortablecol">Song</th><th class="adj sortablecol">Peak Chart Position</th><th class="adj sortablecol">Week Entered The Top 10</th></tr>
<?php
    $arr = db_query_rows( "select * from songs, songnames where {$GLOBALS[clientwhere]} and songnameid = songnames.id order by Name", "id" );
    foreach( $arr as $a )
{
 ?>
										<tr>
											<td class="search-column-2 sortablerow">
												<a href="/<?=$a[CleanUrl]?>"><?=$a[Name]?></a>
											</td>
											<td class="search-column-2 sortablerow adj">
												<a href="/search-results?search[PeakPosition]=<?=$a[PeakPosition]?>"><?=$a[PeakPosition]?></a>
											</td>
											<td class="search-column-2  sortablerow adj">
												<a href="/search-results?search[WeekEnteredTheTop10]=<?=$a[WeekEnteredTheTop10]?>"><?=db_query_first_cell( "select Name from weekdates where id = '$a[WeekEnteredTheTop10]'" )?></a>
											</td>
											
											<td class="search-column-4 sortablerow">
												<a href="/<?=$a[CleanUrl]?>"><img src="assets/images/home/search-arrow-icon.svg" /></a>
												<div class="cf"></div>
											</td>
										</tr>
<? } ?>
									</table>
								</div><!-- /.temp-hidden -->
							</div><!-- /.search-hidden-container -->

							<div class="comp-hidden-browse comp-hidden-logicfiles hide" id="comp-logicfiles">
								<h3><a class="comp-icon comp-icon-logicfiles">Logic Projects</a></h3>
								<div id="comp-search-hidden" class="temp-hidden-browse">
									<table width="100%" id="browse-table">
<tr><th>Song</th><th >Artist</th><th class="adj">Link To Logic File</th></tr>
<?php
    $arr = db_query_rows( "select songs.*, songnames.Name from songs, songnames where {$GLOBALS[clientwhere]} and songnameid = songnames.id and LogicFilename > '' order by LogicFilenameDate desc, Name", "id" );
    foreach( $arr as $a )
{
 ?>
										<tr>
											<td class="search-column-2">
												<a href="/<?=$a[CleanUrl]?>"><?=$a[Name]?></a>
											</td>
											<td class="search-column-2">
        <?php
	$songid = $a["id"];
        $frontendfieldname = "primaryartist";
        $frontendlinks = true;	   
        $frontenduseid = false;
	$useindividual = true;
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
											</td>
											<td class="search-column-2 adj">
<a href="/logicfiles/dl.php?key=<?=$a[id]?>" >Download Logic Project >> </a>
											</td>
											
											<td class="search-column-4">
												<div class="cf"></div>
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
	<script>

		$("#comp-select").change(function(){
			if ($("#comp-select").val() == "") {
		       $('.comp-hidden-browse').removeClass('show').addClass('hide');
		    } 
		    if ($("#comp-select").val() == "Performing Artists") {
		       $('.comp-hidden-perform').removeClass('hide').addClass('show');
		    } 
		    else {
		       $('.comp-hidden-perform').removeClass('show').addClass('hide');
		    }
		    if ($("#comp-select").val() == "Songwriters") {
		       $('.comp-hidden-songwriters').removeClass('hide').addClass('show');
		    } 
		    else {
		       $('.comp-hidden-songwriters').removeClass('show').addClass('hide');
		    }
		    if ($("#comp-select").val() == "Record Labels") {
		       $('.comp-hidden-record').removeClass('hide').addClass('show');
		    } 
		    else {
		       $('.comp-hidden-record').removeClass('show').addClass('hide');
		    }
		    if ($("#comp-select").val() == "Producers") {
		       $('.comp-hidden-producers').removeClass('hide').addClass('show');
		    } 
		    else {
		       $('.comp-hidden-producers').removeClass('show').addClass('hide');
		    }
		    if ($("#comp-select").val() == "Logic Files") {
		       $('.comp-hidden-logicfiles').removeClass('hide').addClass('show');
		    } 
		    else {
		       $('.comp-hidden-logicfiles').removeClass('show').addClass('hide');
		    }
		    if ($("#comp-select").val() == "Songs") {
		       $('.comp-hidden-songs').removeClass('hide').addClass('show');
		    } 
		    else {
		       $('.comp-hidden-songs').removeClass('show').addClass('hide');
		    }
		});

// to refill existing choices
$( document ).ready(function() {
        $("#comp-select").change();
    });

	</script>
<?php include 'sortingjavascript.php';?>    
<?php include 'footer.php';?>