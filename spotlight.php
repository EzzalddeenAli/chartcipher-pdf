<?php 
include 'header.php'; 
$backurl = "chart-landing.php";
include "trendfunctions.php";
include "benchmarkreportfunctions.php";
include "trendreportfunctions.php";
if( !$_GET["graphtype"] ) $_GET["graphtype"] = "column";


if( date( "m" ) <= 3 )
    $fq = 1;
else if( date( "m" ) <= 6 )
    $fq = 2;
else if( date( "m" ) <= 9 )
    $fq = 3;
else
    $fq = 4;

$qarr = array( $fq . "/" . date( "Y" ) );
$tmpq = getPreviousQuarter( $fq . "/" . date( "Y" ) );
$qarr[] = $tmpq;
for( $i = 0; $i < 2; $i ++  )
    {
	$tmpq = getPreviousQuarter( $tmpq );
	$qarr[] = $tmpq;
    }
$exp = explode( "/", $tmpq );
$search["dates"]["fromq"] = $exp[0]; 
$search["dates"]["fromy"] = $exp[1];
$search["dates"]["toq"] = $fq; 
$search["dates"]["toy"] = date( "Y" );

$quarter = $fq;
$year = date( "Y" );
$oldestq = $exp[0];
$oldesty = $exp[1];
$quarterstorun = getQuarters( $oldestq, $oldesty, $quarter, $year );
$thisquarter = calculateQuarterNumber($search[dates][fromq], $search[dates][fromy] );

$doingweeklysearch = 1;
$wd = getSetting( "homepageweek" );
$dt = db_query_first_cell( "select Name from weekdates where id = $wd" );
$wdorderby = db_query_first_cell( "select OrderBy from weekdates where id = $wd" );

$twelveago = db_query_first_cell( "select Name from weekdates where OrderBy < $wdorderby order by OrderBy desc limit 11, 1 " );
$fiftytwoago = db_query_first_cell( "select Name from weekdates where OrderBy < $wdorderby order by OrderBy desc limit 51, 1 " );
$twelveagoid = db_query_first_cell( "select id from weekdates where OrderBy < $wdorderby order by OrderBy desc limit 11, 1 " );
$fiftytwoagoid = db_query_first_cell( "select id from weekdates where OrderBy < $wdorderby order by OrderBy desc limit 51, 1 " );
$twelveagoob = db_query_first_cell( "select OrderBy from weekdates where OrderBy < $wdorderby order by OrderBy desc limit 11, 1 " );
$fiftytwoagoob = db_query_first_cell( "select OrderBy from weekdates where OrderBy < $wdorderby order by OrderBy desc limit 51, 1 " );

if( !$search["benchmarksubtype"] ) $search["benchmarksubtype"] = "Compositional";

$origreportsarr = getMyPossibleSearchFunctions( strtolower( $search["benchmarksubtype"] ) );
$reportsarr = array( $origreportsarr );


//print_r( $reportsarr );
$search["dates"]["fromweekdate"] = $wdorderby;
$search["dates"]["toweekdate"] = $wdorderby;
    $allweekdatestorun = db_query_rows( "select * from weekdates where OrderBy >= '" . $search["dates"]["fromweekdate"]. "' and OrderBy <= '" . $search["dates"]["toweekdate"]. "' order by OrderBy" );
$characteristics = gatherCharacteristicsSingleQuarter( $thisquarter, "most");
$characteristicsstr = "&search[dates][fromweekdate]=".$search["dates"]["fromweekdate"]."&search[dates][toweekdate]=".$search["dates"]["toweekdate"];

$search["dates"]["fromweekdate"] = $twelveagoob;
$search["dates"]["toweekdate"] = $wdorderby;
    $allweekdatestorun = db_query_rows( "select * from weekdates where OrderBy >= '" . $search["dates"]["fromweekdate"]. "' and OrderBy <= '" . $search["dates"]["toweekdate"]. "' order by OrderBy" );
$twelvecharacteristics = gatherCharacteristicsSingleQuarter( $thisquarter, "most");
$twelvecharacteristicsstr = "&search[dates][fromweekdate]=".$search["dates"]["fromweekdate"]."&search[dates][toweekdate]=".$search["dates"]["toweekdate"];

$search["dates"]["fromweekdate"] = $fiftytwoagoob;
$search["dates"]["toweekdate"] = $wdorderby;
    $allweekdatestorun = db_query_rows( "select * from weekdates where OrderBy >= '" . $search["dates"]["fromweekdate"]. "' and OrderBy <= '" . $search["dates"]["toweekdate"]. "' order by OrderBy" );
$fiftytwocharacteristics = gatherCharacteristicsSingleQuarter( $thisquarter, "most");
$fiftytwocharacteristicsstr = "&search[dates][fromweekdate]=".$search["dates"]["fromweekdate"]."&search[dates][toweekdate]=".$search["dates"]["toweekdate"];

// file_put_contents( "/tmp/wh", print_r( $characteristics, true ) );
// file_put_contents( "/tmp/wh", print_r( $twelvecharacteristics, true ), FILE_APPEND );
// file_put_contents( "/tmp/wh", print_r( $fiftytwocharacteristics, true ), FILE_APPEND );

    $benchmarkurlwithoutsubtype = "spotlight.php?" . urldecode( $_SERVER['QUERY_STRING'] );
    $benchmarkurlwithoutsubtype = str_replace( "&search[benchmarksubtype]=". $search[benchmarksubtype] , "", $benchmarkurlwithoutsubtype );
//    $benchmarkurlwithoutsubtype = str_replace( "&search[comparisonaspect]=". $search[comparisonaspect] , "", $benchmarkurlwithoutsubtype );
?>
<?php require_once 'thumb/phpThumb.config.php';?>
  <link rel="stylesheet" type="text/css" href="../assets/css/grid.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/new-style.css" />
<!--<link rel="stylesheet" type="text/css" href="../assets/css/full-style.css" />-->
<!-- Master Slider Skin -->
<link href="masterslider/masterslider/skins/light-2/style.css" rel='stylesheet' type='text/css'>
       <!-- MasterSlider Template Style -->
<!--<link href='masterslider/masterslider/style/ms-autoheight.css' rel='stylesheet' type='text/css'>-->
<!-- google font Lato -->
<link href='//fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="masterslider/masterslider/style/masterslider.css" />
<script src="masterslider/masterslider/masterslider.min.js"></script>

	<div class="site-body index-pro ">
	<? include "chartchooser.php"; ?>                
        <section class="home-top">
			<div class="element-container row">
				
                

               
               
                       <div class="row inner row-equal row-padding link-alt">
                           <div class="col-12 ">
                               <div class="home-search-header flex2">
                                        <h2>Most Popular Characteristics</h2>

                         <div class="custom-select" >

								<select id="mysetbenchmarktype">
								<? outputSelectValues( $benchmarksubtypes, $search[benchmarksubtype] ); ?>
								</select>

</div>
                               
                                        <div class="cf"  style="display:none;"></div>
                                </div>
                                 <div class="inner-content ">
                                    <div class="display-list">
                                  <div class="header-inner " >
                                             <table role="table" class="table-insights">
                             <thead role="rowgroup">
                                 <tr role="row">
                                 <th role="columnheader"></th>
                                 <th role="columnheader">This Week (<?=$dt?>)</th>  
                                 <th role="columnheader">12 Weeks (<?=$twelveago?> - <?=$dt?>)</th>
                                 <th role="columnheader">12 Months (<?=$fiftytwoago?> - <?=$dt?>)</th>
                                 </tr>
                             </thead>
                            <tbody role="rowgroup">

<? foreach( $origreportsarr as $r=>$v )
{ 

$link = "trend-search-results.php?search[comparisonaspect]=$r&graphtype=column";
?>
                                <tr role="row">
                               <td role="cell"><?=$v?></td>
                                 <td role="cell"><a href="/<?=$link. $characteristicsstr?>"><?=$characteristics[$v . ":"]?></a></td>
                                       <td role="cell"><a href="/<?=$link. $twelvecharacteristicsstr?>" ><?=$twelvecharacteristics[$v . ":"]?></a></td>

                                        <td role="cell"><a href="/<?=$link. $fiftytwocharacteristicsstr?>" ><?=$fiftytwocharacteristics[$v . ":"]?></a></td>
                   
                            </tr>
<? } ?>
                        </tbody></table>
                                </div><!-- /.header-block-1B -->

                                     </div>
                                </div><!-- /.header-block-1B -->

                           </div>
                           
                     
                  
                   </div>
                
<? include "insightsreports.php"; ?>

                      </div>
                </div>
		</section><!-- /.home-top -->
	</div><!-- /.site-body -->


<?php include 'footer.php';?>
