<? 
if( !$rangesongsstr )
{
    $rangesongs = getSongIdsWithinQuarter( false, $earliestq, $earliesty, $search[dates][fromq], $search[dates][fromy] );
    $rangesongsstr = implode( ", ", $rangesongs );
}

$allartists = db_query_array( "select artistid, count(*) as cnt from song_to_artist where type in ( 'creditedsw' )  and songid in ( $rangesongsstr ) group by artistid", "artistid", "cnt" );

$counter = array();
$artistsfornum = array();
foreach( $allartists as $a=>$cnt )
{
	$cnt = str_pad( $cnt, 3, "0", STR_PAD_LEFT );
	$counter[$cnt]++;
    $name = db_query_first_cell( "Select Name from artists where id = $a" );
    if( $name )
        $artistsfornum[$cnt][$a] = $name;
}

krsort( $counter );

?>
                    <div class="search-body">
    <h2 class="tabletitle"><?=$sectionname?>: Q<?=$earliestq?> <?=$earliesty?> - Q<?=$quarter?> <?=$year?></h2>
                    <table id="table1" class="sortable">
                     <tbody>
                    		<tr>
        	            	  <th  class="sorttable_numeric">Number of Songwriters <br><i>(click on column title to sort)</i></th>
    <th id="swhits" class="sorttable_numeric" >Number of Top 10 and #1 Hits (since Q<?=$earliestq?> <?=$earliesty?>) <br><i>(click on column title to sort)</i></th>
                    	  </tr>
<? foreach( $counter as $numhits=>$num ) { 
    $artistslist = $artistsfornum[$numhits];
    ksort( $artistslist );
    $names = htmlentities( implode( ", ", $artistslist ) );
?>
                    	  <tr>
    <td>
<?     $artistsstr = "";
    foreach( array_keys( $artistsfornum[$numhits] ) as $pid )
    {
        $artistsstr .= "artists[]=$pid&";
    }
    echo( "<a  href='list-values.php?numhits=$numhits&type=songwriters&$artistsstr'>$num</a>" );

?>
    </td>
                    	  	<td class=""><?=number_format( $numhits )?> hit<?=number_format( $numhits )>1?"s":""?></td>
                    	  </tr>
<? } ?>
                    	  </tbody>
                    	</table>
                          <div id='extranote'> Note : Immersion data goes back to Q1 2013 </div>
                          <? if( 1 == 0 ) {  ?>
                          <div class='row'>
<? foreach( $counter as $numhits=>$num ) {
    $artistslist = $artistsfornum[$numhits];
    ksort( $artistslist );
//    $names = htmlentities( implode( ", ", $artistslist ) );

?><div class='col-4'>
<h3><?=number_format( $numhits )?> hit<?=number_format( $numhits )>1?"s":""?></h3>
<?php
echo( '<ul class="listB">' );

foreach( $artistslist as $n )
{
echo( "<li><span>$n</span></li>" );
}
    ?>


</ul>
</div>
    <? } ?>
    </div>
    <? } ?>
