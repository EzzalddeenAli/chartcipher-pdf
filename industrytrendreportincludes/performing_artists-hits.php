<?php
if( !$rangesongsstr )
{
    $rangesongs = getSongIdsWithinQuarter( false, $earliestq, $earliesty, $search[dates][fromq], $search[dates][fromy] );
    $rangesongsstr = implode( ", ", $rangesongs );
}

if( $doingweeklysearch)
    $rangesongsstr = "-1";


$allartists = db_query_array( "select artistid, count(*) as cnt from song_to_artist where type in ( 'featured', 'primary' ) and songid in ( $rangesongsstr ) group by artistid", "artistid", "cnt" );
$allgroups = db_query_array( "select groupid, count(*) as cnt from song_to_group where type in ( 'featured', 'primary' ) and songid in ( $rangesongsstr ) group by groupid", "groupid", "cnt" );

$counter = array();
$artistsfornum = array();
foreach( $allgroups as $a=>$cnt )
{
	$cnt = str_pad( $cnt, 3, "0", STR_PAD_LEFT );
	$counter[$cnt]++;
    $name = db_query_first_cell( "Select Name from groups where id = $a" );
    $artistsfornum[$cnt]["group"][$a] = $name;
}
foreach( $allartists as $a=>$cnt )
{
	$cnt = str_pad( $cnt, 3, "0", STR_PAD_LEFT );
	$counter[$cnt]++;
    $name = db_query_first_cell( "Select Name from artists where id = $a" );
    if( $name )
    $artistsfornum[$cnt]["artist"][$a] = $name;
}

krsort( $counter );
//print_r( $artistsfornum );
?>
                    <div class="search-body">
    <h2 class="tabletitle"><?=$sectionname?>: Q<?=$earliestq?> <?=$earliesty?> - Q<?=$quarter?> <?=$year?></h2>
                    <table id="table1" class="sortable">
                     <tbody>
                    		<tr>
    <th class="sorttable_numeric">Number of Artists<br><i>(click on column title to sort)</i></th>
    <th class="sorttable_numeric" >Number of Top 10 and #1 Hits (since Q<?=$earliestq?> <?=$earliesty?>) <br><i>(click on column title to sort)</i></th>
                    	  </tr>
<? foreach( $counter as $numhits=>$num ) {
    $artistslist = $artistsfornum[$numhits];
    ksort( $artistslist );
    $names = htmlentities( implode( ", ", $artistslist ) );
    ?>
                    	  <tr>
    <td>
<?     $artistsstr = "";
    if( isset( $artistsfornum[$numhits]["artist"] ) )
        foreach( array_keys( $artistsfornum[$numhits]["artist"] ) as $pid )
        {
            $artistsstr .= "artists[]=$pid&";
        }
    if( isset( $artistsfornum[$numhits]["group"] ) )
        foreach( array_keys( $artistsfornum[$numhits]["group"] ) as $pid )
        {
            $artistsstr .= "groups[]=$pid&";
        }
    
    echo( "<a  href='list-values.php?numhits=$numhits&type=artists&$artistsstr'>$num</a>" );

?>
    </td>
                    	  	<td class=""><?=number_format( $numhits )?> hit<?=number_format( $numhits )>1?"s":""?></td>

                    	  </tr>
<? } ?>
                    	  </tbody>
                    	</table>
                          <div id='extranote'> Note : Immersion data goes back to Q1 2013 </div>
                          <? if( 1 == 0 ) { ?>
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
                    	</div>    
      <? } ?>                    	
