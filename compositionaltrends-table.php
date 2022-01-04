						

<table width="100%" id="comp-search-table">
                                       <tr><td colspan='4'>
<?=$period?>

                                </td></tr>
							<tr>
								<th class="comp-search-header-1 sortablecol">
<?=getCompositionalColumnName( $possiblecompositionalaspects[$search[compositionalaspect]] )?>
								</th>
<? foreach( $acrossthetop as $aid=>$aval ){ ?>
								<th class="sortablecol">
                                            <?=$aval?><br>
<?// $num = count( $allsongsnumweeks[$aid] ); 
//$percent = number_format( $num / count( $allsongs ) * 100  );
//	 $countall = count( $allsongs );
//echo( $num>1?"$num Songs out of $countall ($percent%)":"$num Song out of $countall ($percent%)" );
?>
								</th>
                                            <? } ?>
							</tr>
                            <?php
                            $sortedrows = array();
                            foreach( $rows as $rid=> $rowval ) {

                                $calcedrow = array();
                                $anynonzero = false;
                                $key = "";
                                foreach( $acrossthetop as $aid=>$aval ){
                                    list( $val, $numsongs, $tot ) = getCompositionalPercentage( $search[outputformat], $search["compositionalaspect"], $rid, $allsongs );

                                    $calcedrow[$aid] = array( $val, $numsongs );
                                    if( $numsongs > 0 ) $anynonzero = true;
                                    if( !$key )
                                        $key = str_pad( 1000 - str_replace( "%", "", $val ), 3, "0", STR_PAD_LEFT ) . "_" . $rowval;
                                }
				//				echo( $key . "<br>");
				//				echo( "$rid, " . print_r( $calcedrow, true ) . "\n\n" );
                                if( !$anynonzero )
                                {
                                    continue;
                                }
                                $sortedrows[ $key ] = array( $rid, $rowval, $calcedrow );
                              }

$namegetslinked = false;
ksort( $sortedrows );
foreach( $sortedrows as $rid=> list( $rid, $rowval, $calcedrow ) )
{
    $first = true;
                                ?>
							<tr>
<? foreach( $acrossthetop as $aid=>$aval )

{
							     $numsongs = $calcedrow[$aid][1];
							     $thisnum = $calcedrow[$aid][0];
							     
							     $numsongs .= ( $numsongs == 1 )?" Song":" Songs";
							     // $thisnum .= " out of $thistot";

        if( $first ) {
                                    ?>
								<td data-label="Song" class="comp-search-column-1 sortablerow">
                <? if( $thispercentage != "&nbsp;" && $namegetslinked && ( strpos( $thispercentage, "0%" ) || strpos( $thispercentage, "0%" ) === false ) ) { ?>
                                            <A href='<?=getCompositionalURL( $search, $aid, $rowval )?>'>
                                            <?=getCompositionalDisplayValue( $rowval, $search[compositionalaspect] )?></a>
                                          <?  } else { ?>
                <?=getCompositionalDisplayValue( $rowval, $search[compositionalaspect] )?></a>
                    <? } ?>
								</td>
                                    <? }
        $first = false;
        ?>
								<td class=" sortablerow">
                <? if( !$namegetslinked && $thisnum ) { ?>
																<A href='<?=getCompositionalURL( $search, $aid, $rowval )?>'><?=$thisnum?> <?=$thisnum==1?"Week":"Weeks"?> (<?=$numsongs?>)</a>
                            <? } else { ?>
	    <?=$thisnum?> <?=$thisnum==1?"Week":"Weeks"?> (<?=$numsongs?>)
                <? } ?>
								</td>
<? } ?>
							</tr>
                                  <? } ?>
                               <tr ><td colspan='400' class="foot" >&copy; <?=date( "Y")?> Chart Cipher. All rights reserved.</td></tr>
						</table>
