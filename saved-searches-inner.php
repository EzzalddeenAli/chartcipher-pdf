               <div class="row  row-equal row-padding chart-section">
                            <div class="col-6">
                       <div class="home-search-header  flex-addon">
                                <h3>Saved Searches</h3>
                                 <a style="display:none;" class="search" href="/saved-searches"><img src="assets/images/home/search-view-icon.svg" /></a>
                            </div>
                         <div class="header-inner" >
                         <table class="table table-section">
<? 
$searches = getSavedSearches(); 
$i = 0;
foreach( $searches as $s )
{
$i++; 
if( $i > 3 ) continue;
	 $url = $s[url] . "&savedid={$s[id]}";
?>
                                    <tr data-href="<?=$url?>">
                                        <td class="home-search-column-1">
<a class='rowlink' href='<?=$url?>'><?=$s[Name]?></a>
                                        </td>
                                    <td></td>
                                    <td></td>
                                    </tr>
<? } ?>
                        </table>
                        </div><!-- /.header-block-1B -->
                      </div>
                             <div class="col-6">
                   <div class="home-search-header flex-addon">
                                <h3>Recent Searches</h3>
                                 <a style="display:none;" class="search" href="/saved-searches"><img src="assets/images/home/search-view-icon.svg" /></a>
                            </div>
                         <div class="header-inner " >
                         <table class="table table-section">
<? $searches = getRecentSearches( 40 ); 
$already = array();
foreach( $searches as $s ) { 
	 if( isset( $already[$s[url]] ) ) continue;
$already[$s[url]] = 1;
if( count( $already ) > 3 ) continue;
$name = $s[Name]?$s[Name]:"Advanced Search" ;
$name = str_replace( "Trend Search: ", "", $name );

?>
                                                    <tr data-href="<?=$s[url]?>">
<td>
<a class='rowlink' href='<?=$url?>'><?=$name?></a>            </td>
                                    <td></td>
                                    <td></td>
                                                    </tr>
<? } ?>
                        </table>
                        </div><!-- /.header-block-1B -->
                      </div>
                      </div>
   
                
                
                
                
                  
                </div>

