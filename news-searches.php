
                        <div class="row row-equal row-padding">
                    
                   <div class="col-4 "> 
                        <div class="home-search home-search-2">
                            <div class="home-search-header">
                                <h1>RECENT ARTICLES</h1>
                                <a class="search-view" href="https://editorial.chartcipher.com/articles/">View All</a>
                                <!-- <a class="search-manage" href="#">Manage</a> -->
                                <div class="cf"></div>
                            </div><!-- /.home-search-header -->
                            <div class="home-search-body">
                                <table width="100%">
<? 
    $limit = 3;
$res = db_query_rows( "select post_name, post_title, ID from {$reportsdbname}.wp_posts where  post_status = 'publish' and post_type = 'articles' order by post_date desc limit $limit" );

foreach( $res as $r ) { 
$img = db_query_first_cell( "SELECT guid      FROM hsd_wp.wp_postmeta AS pm      INNER JOIN hsd_wp.wp_posts AS p ON pm.meta_value=p.ID       WHERE pm.post_id = '$r[ID]'        AND pm.meta_key = '_thumbnail_id'       ORDER BY p.post_date DESC" );
?>                                                    <tr data-href="https://editorial.chartcipher.com/articles/<?=$r[post_name]?>">
                                                        <td class="home-search-column-1">
                                                             <?=$r[post_title]?>
                                                        </td>
                                                        <td class="home-search-column-3">
                                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                                        </td>
                                                    </tr>
<? } ?>
                                </table>
                            </div>
                        </div><!-- /.home-search-2 -->
                   </div>

                                <? if( isEssentials() || isStudent() ) { ?>
                                  <div class="col-4 "> 
                                         <div class="home-search home-search-2">
                                            <div class="home-search-header">
                                                <h1>RECENT SEARCHES</h1>
                                                <!-- <a class="search-manage" href="#">Manage</a> -->
                                                <div class="cf"></div>
                                            </div><!-- /.home-search-header -->
                                            <div class="home-search-body">
                                                <table width="100%">
<? $searches = getRecentSearches( 40 ); 
$already = array();
foreach( $searches as $s ) { 
	 if( isset( $already[$s[url]] ) ) continue;
$already[$s[url]] = 1;
if( count( $already ) > 3 ) continue;
?>
                                                    <tr data-href="<?=$s[url]?>">
                                                        <td class="home-search-column-1">
                                                            <?=$s[Name]?$s[Name]:"Advanced Search"?>
                                                        </td>
                                                        <td class="home-search-column-3">
                                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                                        </td>
                                                    </tr>
<? } ?>
                                                </table>
                                            </div>
                                        </div><!-- /.home-search-2 -->
                                   </div>

                                                      <? } else { ?>                                                      
                  <div class="col-4 "> 
                         <div class="home-search home-search-2">
                            <div class="home-search-header">
                                <h1>SAVED SEARCHES</h1>
                                <a class="search-view" href="/saved-searches">View All</a>
                                <!-- <a class="search-manage" href="#">Manage</a> -->
                                <div class="cf"></div>
                            </div><!-- /.home-search-header -->
                            <div class="home-search-body">
                                <table width="100%">
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
                                            <?=$s[Name]?>
                                        </td>
                                        <td class="home-search-column-3">
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        </td>
                                    </tr>
<? } ?>
                                </table>
                            </div>
                        </div><!-- /.home-search-2 -->
                   </div>
                                      <? } ?>
                                      
                   <div class="col-4 "> 
                          <div class="home-search home-search-2">
                            <div class="home-search-header">
                                <h1>NEW FEATURE RELEASES</h1>
                                <a class="search-view" href="https://editorial.chartcipher.com/video_categories/feature-releases/">View All</a>
                                <!-- <a class="search-manage" href="#">Manage</a> -->
                                <div class="cf"></div>
                            </div><!-- /.home-search-header -->
                            <div class="home-search-body">
                                <table width="100%">
<? $dbname = $reportsdbname;
//$dbname = "devreports_wpmain";

//echo( "select post_name, post_title, ID from {$dbname}.wp_posts where  post_status = 'publish' and post_type = 'video' and ID in ( select object_id from {$dbname}.wp_term_relationships where term_taxonomy_id = 186 ) order by post_date desc limit 3" );
$res = db_query_rows( "select post_name, post_title, ID from {$dbname}.wp_posts where  post_status = 'publish' and post_type = 'video' and ID in ( select object_id from {$dbname}.wp_term_relationships where term_taxonomy_id = 186 ) order by post_date desc limit 3" );

foreach( $res as $r ) { 
$vidurl = db_query_first_cell( "select meta_value from {$dbname}.wp_postmeta where meta_key = 'video_tutorial' and post_id = '$r[ID]'" );
$img = db_query_first_cell( "SELECT guid      FROM {$dbname}.wp_postmeta AS pm      INNER JOIN {$dbname}.wp_posts AS p ON pm.meta_value=p.ID       WHERE pm.post_id = '$r[ID]'        AND pm.meta_key = '_thumbnail_id'       ORDER BY p.post_date DESC" );
$vidurl = "https://editorial.chartcipher.com/video_categories/feature-releases/";
?>
                                    <tr data-href="<?=$vidurl?>">
                                        <td class="home-search-column-1">
                                             <?=$r[post_title]?>
                                        </td>
                                        <td class="home-search-column-3">
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        </td>
                                    </tr>
<? } ?>
                                </table>
                            </div>
                        </div><!-- /.home-search-2 -->
                   </div>
                    
                
                    </div>
                