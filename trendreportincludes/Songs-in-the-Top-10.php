
        <h3>Songs  (<?=$rangedisplay?>)</h3>
    <ul class="listB">

<?php
if( $allsongssecond )
{
	$merged = array_merge( $allsongs, $allsongssecond );
	$merged = implode( ", ", $merged );
//	$merged = $allsongsstr;
    $orderedsongs = db_query_rows( "select songnames.Name, CleanUrl, songs.id, ArtistBand from songs, songnames where {$GLOBALS[clientwhere]} and songnameid = songnames.id  and songs.id in ( $merged ) order by Name", "id" );
}
else
{    
     $orderedsongs = db_query_rows( "select songnames.Name, CleanUrl, songs.id, ArtistBand from songs, songnames where {$GLOBALS[clientwhere]} and songnameid = songnames.id  and songs.id in ( $allsongsstr ) order by Name", "id" );

}

//echo( "count: " . count( $orderedsongs ) ); 
foreach( $orderedsongs as $orow ) { 
    ?>
    <li><span>&nbsp;<span><a  href='/<?=$orow[CleanUrl]?>'><?=$orow[Name]?></a>:&nbsp;</span>
        <?php
        $frontendfieldname = "primaryartist";
        $frontendlinks = false;	   
        $frontenduseid = false;
                                     $songid = $orow[id];
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
</span></li>
   <? } ?>
    </ul>

