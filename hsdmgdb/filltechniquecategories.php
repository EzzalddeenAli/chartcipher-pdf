<? 
$nologinrequired = true;
include "connect.php";

$rows = db_query_array( "select * from technique{$sub}categories where technique{$subcat}id = '$techniqueid' ", "id", "Name" );

// if( $sub )
// {
    $oc = "onChange='javascript:updateOtherTSub( this, $num, \"$sub\" )'";
// }
// else
//     {

//     }
?>
<select style='width: 300px' name='technique<?=$sub?>categories[<?=$num?>]' id='technique<?=$sub?>categories<?=$num?>' <?=$oc?>><option value=''>Please Choose</option>
<? 
outputSelectValues( $rows );
?>
</select>
