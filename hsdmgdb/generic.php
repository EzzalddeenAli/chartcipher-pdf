<? 
$namestr = $specialname?$specialname:"Name";
if( $admin_hasadvsearch )
{
    $extracolumns["HideFromAdvancedSearch"] = "Hide<br> From<br> Advanced<br> Search";      	    
}	    		    

$shorttablename = substr($tablename, 0, -1);
if( $shorttablename != "songname" && $shorttablename != "genre" && $shorttablename != "chart" && $shorttablename != "client" && !function_exists( 'anySongsWith' ) )
    db_query( "delete from song_to_{$shorttablename} where songid not in ( select id from songs)" );

if( !function_exists( 'anySongsWith' ) ) 
  {

    function anySongsWith( $tablename, $songid ) 
    {
      global $issinglecolumn;
      $shorttablename = substr($tablename, 0, -1);
      $idcol = $shorttablename . "id";
      
      if( isset( $issinglecolumn ) && $issinglecolumn )
	{
	  $res = db_query_first_cell( "select count(distinct( id )) from songs where $idcol = '$songid'" );
	}
      else
	{
	  $res = db_query_first_cell( "select count(distinct( songid)) from song_to_$shorttablename where $idcol = '$songid'" );
	}
      return $res;
    }
  }

if( $addnew && $newname )
  {
      $ins = db_query_insert_id( "insert into $tablename ( {$namestr} ) values ( '". escMe( $newname ) ."' )" );
      if( isset( $extracolumns ) )
      {
          foreach( $extracolumns as $k=>$throwaway )
          {
              db_query( "update $tablename set $k = '" . escMe( $_POST["new". $k] ) . "' where id = $ins" );
          }
      }
      if( $tablename == "artists" || $tablename == "groups" )
          db_query( "update $tablename set datecreated = now() where id = $ins" );
      doMembersUpdate( $tablename );

  }
if( $del )
  {
    db_query( "delete from $tablename where id = $del" );
  }

if( $update )
  {
    foreach( $names as $id=>$name )
      {
	db_query( "update $tablename set {$namestr} = '". escMe( $name ) ."' where id = $id" );
	if( isset( $extracolumns ) )
	  {
	    foreach( $extracolumns as $k=>$throwaway )
	      {
		db_query( "update $tablename set $k = '" . escMe( $_POST[$k][$id] ) . "' where id = $id" );
	      }
	  }
	
      }
    doMembersUpdate( $tablename );


      fixTotalCountForAllSongs();

  }

if( !$obdesc ) $obdesc = "desc";

$res = db_query_rows( "select * from $tablename order by {$extob} OrderBy {$obdesc}, {$namestr}" );


include "nav.php";
?>

<h3><?=$uppercase?></h3>
<? if( $tablename == "artists" ) { ?>
<A href='artistexport.php'>Artist Export</a><br>
<A href='artistexport.php?type=creditedsw'>Credited Songwriters Export</a><br>
<A href='songtitleexport.php'>Song Title Export</a>
<? } ?>

<form method='post' action='<?=$tablename?>.php'>
<b>  Add New:</b><br>
<table><tr><td>
<?=$altname?$altname:"Name"?>:</td><td> <input type='text' name='newname' value=''></td></tr>
<? if( isset( $extracolumns ) ) { 
    foreach( $extracolumns as $k=>$display ) {
        if( $k == "datecreated" ) continue;
        if( $k == "producerid" ) continue;
      $sz = "";
      if( isset( $extracolumnsizes ) && $extracolumnsizes[$k] )
	{
	    $sz = "style='width: " . ($extracolumnsizes[$k] * 8). "px; max-width: " . ($extracolumnsizes[$k] * 8). "px; ' ";
	}
      $type = "text";
      $value = "";
      if( $k == "HideFromAdvancedSearch" || $k == "HideFromHSDCharts" || $k == "IsLive" || $k == "isadmin" || $k == "inactive" || $k == "ishook")
      {
          $type = "checkbox";
          $value = 1;
      }
 if( isset( $selectoptions ) && $selectoptions[$k] )
{
$notrtd = true;
?>
<tr><td><?=$display?>:</td><td><select name='new<?=$k?>'>
<option value=''></option>
<?  
foreach( $selectoptions[$k] as $key=>$v )
    {
    $sel = "";
      echo( "<option value=\"$key\" $sel>$v</option>\n" );
    }
?>
</select></td></tr>
<?php

}
else
{ 
?>
<tr><td><?=$display?>:</td><td><input type='<?=$type?>' <?=$sz?> name='new<?=$k?>' value="<?=$value?>"></td></tr>
					       <? } } } ?>
</table> <br><input type='submit' name='addnew' value='Add'>
<br><br>

<input type='submit' name='update' value='Update'>
  <table class="cmstable"><tr><th><?=$altname?$altname:"Name"?></th>
<? if( isset( $extracolumns ) ) { 
    foreach( $extracolumns as $k=>$display ) { 

    if( $display == "Producer" ) $producers = db_query_array( "select id, Name from producers order by Name", "id", "Name" );
?>
<?  if( $display == "Date Created" ){  ?>
<th><a href="<?=$tablename?>.php?extob=datecreated+desc,"><?=$display?></a></th>
<? } else { ?>
<th><?=$display?></th>
<? } ?>
					       <? } } ?>
<th>Del?</th></tr>

  <? if( !count( $res ) ) { ?><tr><td colspan='4'>No <?=$lowercase?> found.</td></tr>
			    <? } ?>

			    <? foreach( $res as $r ) { ?>
<tr><td><input type='text' size='30' name="names[<?=$r[id]?>]" value="<?=htmlspecialchars( $r[$namestr] )?>"></td>
<? if( isset( $extracolumns ) ) { 

    foreach( $extracolumns as $k=>$display ) { 
      $sz = "size='20'";
      if( isset( $extracolumnsizes ) && $extracolumnsizes[$k] )
	{
	    $sz = "style='width: " . ($extracolumnsizes[$k] * 8). "px; max-width: " . ($extracolumnsizes[$k] * 8). "px; ' ";
	}
      $type = "text";
      $value = $r[$k];
      if( $k == "HideFromAdvancedSearch" || $k == "HideFromHSDCharts" || $k == "IsLive" || $k == "isadmin" || $k == "inactive" || $k == "ishook")
      {
          $type = "checkbox";
          $value = 1;
          $sz = $r[$k]?"CHECKED":"";
      }

if( $k == "producerid" )
{
$notrtd = true;
?>
<td><select name='<?=$k?>[<?=$r[id]?>]'>
<option value=''></option>
<?  
foreach( $producers as $key=>$v )
    {
      $sel = $key==$value?"SELECTED":""; 
      echo( "<option value=\"$key\" $sel>$v</option>\n" );
    }
?>
</select></td>
<?php
}
else if( isset( $selectoptions ) && $selectoptions[$k] )
{
$notrtd = true;
?>
<td><select name='<?=$k?>[<?=$r[id]?>]'>
<option value=''></option>
<?  
foreach( $selectoptions[$k] as $key=>$v )
    {
      $sel = $key==$value?"SELECTED":""; 
      echo( "<option value=\"$key\" $sel>$v</option>\n" );
    }
?>
</select></td>
<?php

}
else
{      
?>
<td><input type='<?=$type?>'  <?=$sz?> name='<?=$k?>[<?=$r[id]?>]' value="<?=$value?>"></td>
<? } ?>
					       <? } } ?>
<td>
				   <? 
$word = "songs";
if( $shorttablename == "member" )
    $word = "artists/groups/producers";

if( $shorttablename != "chart" ) { 
				   $any = anySongsWith( $tablename, $r[id] );
if( !$any ) { ?>
<A onClick='return confirm( "Are you sure you want to delete this?" )' href='<?=$tablename?>.php?del=<?=$r[id]?>'>Del?</a>
										  <? } else if( $shorttablename == "member" ) { ?>
<nobr><?=implode( "; ", $any )?> linked  (<?=$r[id]?>)</nobr>
<? } else { ?>
<a href='songs.php?col=<?=$tablename?>&val=<?=urlencode( $r[id] )?>'><nobr><?=$any?> <?=$word?>   linked</nobr></a>
    <? } ?>
</td>
  <? }?>
<? if( $shorttablename == "technique" ) { 
echo( "<td>&nbsp;&nbsp;&nbsp;<a href='edit{$shorttablename}.php?id=$r[id]'>Edit Details</a></td>" );
}
?>


</tr>
  <? }?>
</table>

<input type='submit' name='update' value='Update'><br><br>

<? include "footer.php"; ?>
