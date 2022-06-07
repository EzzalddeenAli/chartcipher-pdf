        <section class="home-top">
			<div class="element-container row">
                
                
                
       
                <div class="row inner row-equal element-container">
                           <div class="col-12 flex">
                               
                               <div class="home-search-header  chart-header desktop-alt variant2 flex-addon ">
      
                         <div class="custom-select"  <?=$search["benchmarktype"] == "Cross Chart Comparisons"?"style='display:none'":""?>>
								<select id="mysetchart">
								<? outputSelectValuesForOtherTable( "charts", $chartid, false, " and UseOnDb = 1" ); ?>
								</select>
                            </div>
                                   
                                <span>
                                    <ul class="icon-list">
                                        <li><a href='#' onClick="javascript: maillink('Subject goes here'); return false;" class="email-link">Email Link</a></li>
                                        <li><a href='#' id="copylink" onClick="javascript: shorturl2(); return false;" class="copy-link">Copy Link</a></li>
                                        <li><a href="<?=$backurl?$backurl:"#"?>" <?=$backurl?"":"onClick='javascript.history( -1 )'"?> class="back-link">Back</a></li>
<? if( isset( $newsearchlink ) && $newsearchlink ) { ?>
                                        <li><a href="<?=$newsearchlink?>" class="search-link">New Search </a></li>
<? } ?>
                                    </ul> 
                                    </span>
                                   
                                   
                                    <div class="custom-select flip"  >
                                 	<select id="mysetreport">
                                     <option value="#">Switch To:</option>
                                  <option value="/insights.php">Trend Reports</option>
                                 <option value="/benchmark.php">Benchmark Reports</option>
                                  <option value="/song-landing.php">Interactive Trend Searches</option>
                                </select>
                                   </div>
                             
                                   
                            </div>
                               
                           </div>
                           
                     
                   </div>
                
                       
                <div class="row inner row-equal row-padding element-container mobile-alt">
                           <div class="col-12 flex">
                               
                               <div class="home-search-header  chart-header variant2 flex-addon ">
                                <span>
                                      <ul class="icon-list">
                                        <li><a onClick="javascript: maillink('Subject goes here'); return false;" class="email-link">Email </a></li>
                                        <li><a href='#'   id="copylink" onClick="javascript: shorturl2(); return false;" class="copy-link">Copy Link</a></li>
                                        <li><a href="<?=$backurl?$backurl:"#"?>" <?=$backurl?"":"onClick='javascript.history( -1 )'"?> class="back-link">Back </a></li>
<? if( isset( $newsearchlink ) && $newsearchlink ) { ?>
                                        <li><a href="<?=$newsearchlink?>" class="search-link">New Search </a></li>
<? } ?>
                                    </ul> 
                                    </span>
                            </div>
                               
                           </div>
                           
                     
                   </div>
                
