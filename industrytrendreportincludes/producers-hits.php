<? 
if( !$rangesongsstr )
{
    $rangesongs = getSongIdsWithinQuarter( false, $earliestq, $earliesty, $search[dates][fromq], $search[dates][fromy] );
    $rangesongsstr = implode( ", ", $rangesongs );
}

if( $doingweeklysearch ) $rangesongsstr = "-1";


$allproducers = db_query_array( "select producerid, count(*) as cnt from song_to_producer where songid in ( $rangesongsstr ) group by producerid", "producerid", "cnt" );

$counter = array();
$producersfornum = array();
foreach( $allproducers as $a=>$cnt )
{
	$cnt = str_pad( $cnt, 3, "0", STR_PAD_LEFT );
	$counter[$cnt]++;
    $name = db_query_first_cell( "Select Name from producers where id = $a" );
    if( $name )
        $producersfornum[$cnt][$a] = $name;
}

krsort( $counter );

?>
                    <div class="search-body">
    <h2 class="tabletitle"><?=$sectionname?>: Q<?=$earliestq?> <?=$earliesty?> - Q<?=$quarter?> <?=$year?></h2>
                    <table id="table1" class="sortable">
                     <tbody>
                    		<tr>
        	            	  <th  class="sorttable_numeric">Number of Producers/Production Teams <br><i>(click on column title to sort)</i></th>
    <th id="swhits" class="sorttable_numeric" >Number of Top 10 and #1 Hits (since Q<?=$earliestq?> <?=$earliesty?>) <br><i>(click on column title to sort)</i></th>
                    	  </tr>
<? foreach( $counter as $numhits=>$num ) { 
?>
                    	  <tr>
                    	  	<td class="" >
<?     $producersstr = "";
    foreach( array_keys( $producersfornum[$numhits] ) as $pid )
    {
        $producersstr .= "producers[]=$pid&";
    }
    echo( "<a  href='list-values.php?numhits=$numhits&type=producers&$producersstr'>$num</a>" );

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
    $producerslist = $producersfornum[$numhits];
    natcasesort( $producerslist );

?><div class='col-4'>
<h3><?=number_format( $numhits )?> hit<?=number_format( $numhits )>1?"s":""?></h3>
<?php
echo( '<ul class="listB">' );

foreach( $producerslist as $n )
{
echo( "<li><span>$n</span></li>" );
}
    ?>


</ul>
</div>
    <? } ?>
    </div>
    <? } ?>
