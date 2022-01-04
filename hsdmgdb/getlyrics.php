<? 
include "connect.php";

if( $id )
    $str = " and id in ( $id )";
$idrows = db_query_rows( "select * from songs where SongLyricsLink > '' $str ", "id" );

foreach( $idrows as $id=>$r )
{
    // if( $id )
    // 	{
    // 	    $r = db_query_first( "select * from songs where id = $id" );
    // 	    $artist = $r["ArtistBand"];
    // 	    $song = $r["SongNameHard"];
    // 	    //if( $id == 2959 ) $artist = "Logic";
    // 	}
    
    if( $r[SongLyricsLink] )
	{
	    $fullfilename = "lyrics/{$id}.txt";
	    $lyricshtml = file_get_contents( $r[SongLyricsLink] );
	    if( !file_exists( $fullfilename ) || !strlen( $lyricshtml ) )
		{
		    $lyricshtml = file_get_contents( $r[SongLyricsLink] );
		    file_put_contents( $fullfilename, $lyricshtml );
		    sleep( 2 );
		}
	    else
		{
		    $lyricshtml = file_get_contents( $fullfilename );
		}
	    
	    echo( "<a href='$r[SongLyricsLink]'>$r[SongLyricsLink]</a><br>" );
	    echo( "<a href='$fullfilename'>$fullfilename</a><br>" );
	    if( strpos( $r[SongLyricsLink], "azlyrics" ) !== false )
		{
		    $tmp = explode( '<div class="ringtone">', $lyricshtml );
		    $lyricshtml = $tmp[1];
		    $tmp = explode( '</div>', $lyricshtml );
		    array_shift( $tmp );
		    $lyricshtml = implode( "</div>", $tmp );
		    $tmp = explode( '<div>', $lyricshtml );
		    array_shift( $tmp );
		    $lyricshtml = implode( "<div>", $tmp );
		    //	    file_put_contents( "lyrics/{$id}_short.txt", $lyricshtml );
		    
		    $tmp = explode( '</div>', $lyricshtml );
		    $lyricshtml = $tmp[0];
		    $lyricshtml = trim( strip_tags( $lyricshtml ) );
		    file_put_contents( "lyrics/{$id}_short.txt", $lyricshtml );
		    echo( "<a href='lyrics/{$id}_short.txt'>lyrics/{$id}_short.txt</a>" );
		}
	    else
		{
		    $tmp = explode( '<div class="title">Lyrics</div>', $lyricshtml );
		    $lyricshtml = $tmp[1];
		    $tmp = explode( '</p><div', $lyricshtml );
		    $lyricshtml = $tmp[0];
		    $lyricshtml = str_replace( "<br/>", "\n", $lyricshtml );
		    $lyricshtml = str_replace( "</p><p>", "\n\n", $lyricshtml );
		    $lyricshtml = str_replace( '‘', "'", $lyricshtml );
		    $lyricshtml = str_replace( "&#39;", "'", $lyricshtml );
		    $lyricshtml = str_replace( "’", "'", $lyricshtml );
		    $lyricshtml = trim( htmlspecialchars_decode( $lyricshtml ) );
		    $lyricshtml = trim( strip_tags( $lyricshtml ));
		    file_put_contents( "lyrics/{$id}_short.txt", $lyricshtml );
		    echo( "<a href='lyrics/{$id}_short.txt'>lyrics/{$id}_short.txt</a>" );
		    
		}
	}
    else
	{
	    echo( "no lyrics link" );
	}
}


foreach( $idrows as $id=>$r ) 
{
	    $fullfilename = "lyrics/{$id}_short.txt";
	    if( !strlen( file_get_contents( $fullfilename ) ) )
		{
		    echo( "no match for lyrics for <a href='editsong.php?id=$r[id]'>$r[CleanURL]</a> (<a target=_blank href='$r[SongLyricsLink]'>$r[SongLyricsLink]</a>)<br>" );
		}

}

    ?>
