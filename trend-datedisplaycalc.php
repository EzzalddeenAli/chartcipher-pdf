<? ob_start();?>
<? if( $doingyearlysearch ) { ?>

                               <?=$search[dates][fromyear]?><? if( $search[dates][toyear] ) { ?> to <?=$search["dates"]["specialendq"]?"Q" . $search["dates"]["specialendq"]:""?><?=$search[dates][toyear]?>
                                                        <? } ?>
<? } else if( $doingweeklysearch ) { ?>
<?=$rangedisplay?>
<? } else { ?>
                               Q<?=$search[dates][fromq]?>/<?=$search[dates][fromy]?><? if( $search[dates][toq] ) { ?> to Q<?=$search[dates][toq]?>/<?=$search[dates][toy]?>          <? } ?>
<? } ?>
<? 
$datedisplay = trim( ob_get_contents() );
ob_end_clean();
?>
