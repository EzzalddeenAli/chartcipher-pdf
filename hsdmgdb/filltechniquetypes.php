<? 
$nologinrequired = true;
include "connect.php";

$rows = db_query_array( "select * from techniquetypes where techniqueid = '$techniqueid' ", "id", "Name" );


?>
<select name='techniquetypes[<?=$num?>]'><option value=''>Please Choose</option>
<? 
outputSelectValues( $rows );
?>
</select>