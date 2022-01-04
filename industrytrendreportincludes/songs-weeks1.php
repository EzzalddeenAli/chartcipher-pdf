<? 
   $tmpweeksarr = db_query_array( "select count(*) as cnt, songid from song_to_weekdate where songid in ( $allsongsnumber1str ) and type = 'position1'  and weekdateid in ( $weekdatesstr ) group by songid ", "songid", "cnt" );
   $tmpweeksallarr = db_query_array( "select count(*) as cnt, songid from song_to_weekdate where songid in ( $allsongsnumber1str ) and type = 'position1' group by songid ", "songid", "cnt" );
?>
            <div class="search-body">
    <h2 class="tabletitle"><?=$sectionname?>: <?=$rangedisplay?></h2>
            <table id="table2" class="sortable">
             <tbody>
            		<tr>
            			<th>Song <br><i>(click on column title to sort)</i></th>
                <th class="">Weeks at #1 <?=$displquarterstr?><br><i>(click on column title to sort)</i></th>
                <th class="">Weeks at #1 (all-time) <br><i>(click on column title to sort)</i></th>
            	  </tr>
<? foreach( $allsongssortedno1 as $songname=>$songid ) { 
       $weeks = $tmpweeksarr[$songid]; //db_query_first_cell( "select count(*) from song_to_weekdate where songid = $songid and type = 'position1'  and weekdateid in ( $weekdatesstr ) " );
       $weeksalltime = $tmpweeksallarr[$songid]; // db_query_first_cell( "select count(*) from song_to_weekdate where songid = $songid and type = 'position1'  " );
       if( !$weeks ) continue;
       $r = getSongRow( $songid );
       ?>
            	  <tr>
            	  	<td class="">									
			<a class="appendid"  href="/<?=$r[CleanUrl]?>">
			<?=$songname?>
			</a>

</td>
            	  	<td class=""><?=$weeks?></td>
            	  	<td class=""><?=$weeksalltime?></td>
            	  </tr>
<?} ?>
            	  </tbody>
            	</table>
            	</div>           
