<?php
$shownos = 1;
$graphname = str_replace( "-", "", $sectionid );
$graphname = str_replace( ":", "", $graphname );
$groupingkey = str_replace( array( " ", "/" ), "_", strtolower( $grouping ) );
$graphname = str_replace( "-", "", $groupingkey.$sectionid );
//echo( $graphname );

if( $extrgraphname )
    $graphname .= $extrgraphname;

$songstouse = array( "Top 10"=>array(), "#1"=>$allsongsnumber1 );

if( $doingthenandnow )
    {
	if( $search["dates"]["fromyearsecond"] )
	    {
		$songstouse = array( "{$yearrange}"=>$allsongs, "{$yearrange2}"=>$allsongssecond );
		$dateurlstouse = array( "{$yearrange}"=>$urldatestr, "{$yearrange2}"=>$urldatestrsecond );
		//		print_r( $dateurlstouse );
		if( $search["dates"]["fromyearthird"] )
		    {
			$songstouse["{$yearrange3}"] = $allsongsthird;
			$dateurlstouse["{$yearrange3}"] = $urldatestrthird;
		    }
	    }
	else
	    {
		$songstouse = array( "$fromweekdatedisplay - $toweekdatedisplay"=>$allsongs, "$fromweekdatedisplaysecond - $toweekdatedisplaysecond"=>$allsongssecond );
		$dateurlstouse = array( "$fromweekdatedisplay - $toweekdatedisplay"=>$urldatestr, "$fromweekdatedisplaysecond - $toweekdatedisplaysecond"=>$urldatestrsecond );
		if( $fromweekdatedisplaythird )
		    {
			$songstouse["$fromweekdatedisplaythird - $toweekdatedisplaythird"] = $allsongsthird;
			$dateurlstouse["$fromweekdatedisplaythird - $toweekdatedisplaythird"] = $urldatestrthird;
		    }
	    }
    }
//echo( $sectionname );
if( $sectionname == "Songwriters" )
{
    $searchsubtype = "songwriters";
}
//print_r( $dateurlstouse );
//echo( $sectionname . "<br>" );
$search[comparisonaspect] = getTrendGraphNameConverter( $sectionname );
//echo( $search["comparisonaspect"] . "<br>" );
$searchsubtype = "";


if( $search[comparisonaspect] ) 
{
//    echo( "in here" );
    if( $doingthenandnow )
	{
	    $rows = array();
	    foreach( $songstouse as $barname => $songs )
		{
		    $tmp = getRowsComparison( $search, $songs );
		    foreach( $tmp as $tid=>$tval )
			{
			    $rows[$tid] = $tval;
			}
		}
	}
    else
	{
	    $rows = getRowsComparison( $search, $allsongsallquarters );
	}
//if( $help )
//    print_r( $rows );
$colors = array( "#5b9bd5","#fa8564","#009900","#fdd752","#aec785","#9972b5","#91e1dd" );
    
//echo( "aspect: " . $search[comparisonaspect] );
$dataforrows = array();
if( !count( $songstouse  ) )
{
    $songstouse = array( array() );
}
// echo( "peak: " . $specificpeak );
// print_r( $songstouse );
foreach( $songstouse as $barname=>$tmpsongs )
{
	if( $barname === "#1" )
		$specificpeak = 1;
    else
		$specificpeak = "";
//    echo( "peak here?" . $specificpeak );
    $dataforrows[$barname] = getBarTrendDataForRows( $search[comparisonaspect], "", $tmpsongs );
}
$specificpeak = "";

if( $dataforrows["Top 10"] )
    krsort( $dataforrows );

// $dataforrows = getBarTrendDataForRows( $search[comparisonaspect] );
//print_r( $dataforrows );
$linedataforrows = getTrendDataForRows( $quarterstorun, $search[comparisonaspect] );
// echo( "allsongs: \n" );
//print_r( $allsongs );
// echo( "allsongsallquarters: \n" );
// print_r( $allsongsallquarters );
if( $_GET["help3"] )
    echo( nl2br( print_r( $dataforrows, true ) ) );
//print_r( $rows );
//exit;
//print_r( $songstouse );
$datestr = " ($rangedisplay)"; // " (Q" . $search[dates][fromq] . " " . $search[dates][fromy] . ")";

if( $search[comparisonaspect] == "Key" )
    {
    file_put_contents( "/tmp/hmm", print_r( $dataforrows, true ) );
    file_put_contents( "/tmp/hmm", print_r( $rows, true ), FILE_APPEND );
    }
$i = 0;
//print_r( $dataforrows );
if( 1 == 0 )
    {
	// this sorts by name
	foreach( $rows as $rid=>$rval )
	    {
		$any = false;
		foreach( $dataforrows as $tmp )
		    {
			if( $tmp[$rid][0] ) $any = true;
		    }
		if( !$any ) continue;
		$barkey[$rid] = $i++;
	    }

    }
else 
    {
	// this sorts by value, how convoluted
	$presortedbarkey = array();
	$cnt = 0;
	foreach( $dataforrows as $bardataforrows )
	    {
		uasort( $bardataforrows, "trendsortByValue" );                        
		foreach( $bardataforrows as $rid=>$tmparr )
		    {
			
			if( !isset( $presortedbarkey[$rid] ) )
			    {
				if( $cnt && !$doingthenandnow )
				    {
					// this is in the second segment so... i don't think we should get in here?
					
				    }
				else
				    {
					$presortedbarkey[$rid] = $tmparr[0];
				    }
			    }
		    }
		$cnt++;
	    }
	asort( $presortedbarkey );
	$cnt = 0;
	foreach( $presortedbarkey as $key=>$throwaway )
	    {
		$barkey[$key]= $cnt;
		$cnt++;
	    }
    }
//echo( "barkey: " ) ;
//print_r( $barkey );
?>

<div class="graph-head">                       

     <div class=" set" style="margin-bottom:20px;">  
         <div class="icon download">
        <a href="#" id="<?=$graphname?>exportjpg" onclick="return false"> Download</a>
             
             </div>
                 
                 
    </div>   
    
    
    
       <div class=" set" style="margin-bottom:20px;">  
    <span class="showall">   
        
        <div class="icon show-all ">
                                    <a href="#"  onClick='<?=$graphname?>_showAllGraph( true ); return false'>Show All</a></div>
        
        <div class="icon hide-all ">
                                 <a href="#" onClick='<?=$graphname?>_showAllGraph( false ); return false'>Hide All</a></div>
        
      </span>                   
              
    
    </div>
                        </div>

     <script language='javascript'>
    function <?=$graphname?>_showAllGraph( val )
{
    for(i = 0; i <  <?=$graphname?>chart.options.data.length ; i++ )
    {
        <?=$graphname?>chart.options.data[i].visible = val;
    }
    <?=$graphname?>chart.render();
}
</script>    

      <!-- begin graph -->
	<div id="<?=$graphname?>chartContainer" style="height:600px;">
	</div>
<? 
     $graphnote = getTrendReportNote( "0", $sectionid );
if( $graphnote ) 
{ 
    echo( "<i class='graphnote'>$graphnote</i><br>" );	   
}
$specificgraphnote = getTrendReportNote( $thisquarter, $sectionid );
if( $specificgraphnote ) 
{ 
    echo( "<font color='red'>$specificgraphnote</font><br>" );	    
}
?>
<!-- end graph -->    

    <? $gray = "#444444"; ?>
	<script type="text/javascript">
$(document).ready(function(){
<? if( !$alreadyaddedcolorset ) { 
   $alreadyaddedcolorset = true;
?>

			CanvasJS.addColorSet("hsdColors",
                [//colorSet Array

                "#5d97cc",
                "#fb833b",
                "#aeaeae"
                // "#3CB371",
                // "#90EE90"                
                ]);
<? } 

$allgraphnames[] = "{$graphname}chart";
?>

			<?=$graphname?>chart = new CanvasJS.Chart("<?=$graphname?>chartContainer", {
				colorSet: "hsdColors",
				exportEnabled: true,
				title: {
				text: "<?=str_replace( '"', '\"', $overtitle?$overtitle:$sectionname ) . $datestr?>",
                    fontColor: "#888888",
                    // fontColor: "#ffffff",
                    fontFamily: "Open Sans",
                    fontWeight: "bold",
					fontSize: 25
				},
				subtitles:[
<?php
$descr = getOrCreateGraphNote( "CTR (column): " . $sectionname, $extgraphnote );

if( $descr )
{
?>

            {
              text: "<?=str_replace( '"', '\"', $descr )?>",
              fontColor: "#ff6633",
              fontSize: 16,
              fontWeight: "normal",
              fontFamily: "Open Sans",
            }
            
<? 
}
?>

            
																     ],
				animationEnabled: false,
                backgroundColor: '#ffffff',
                // backgroundColor: '<?=$gray?>',
				axisX: { // this is the quarters
					gridColor: "#f0f0f0",
					// gridColor: "#525252",naaaa
					labelFontColor: "#7a7a7a",
					labelFontFamily: "Open Sans",
                    labelAngle: 50,
					labelFontSize: 14,
                    interval: 1,
					gridThickness:0,
					tickColor: '#dddddd',
					// tickColor: '<?=$gray?>',
					lineColor:"#dddddd",
					// lineColor:"#525252",
					tickLength: 5,
                    margin: 20,
                    labelFormatter: function ( e ) {
                if( e.label != null )
                    return e.label;
                return " ";
            }  
                   
				},
				toolTip: {
                      // backgroundColor: "<?=$gray?>",
                      shared: false,
                      fontColor: "#7a7a7a",
                      fontStyle: "normal",
                      // fontColor: "#FFFFFF",
                      contentFormatter: function(e){
                            var thiscolumn = e.entries[0].dataSeries.name;
                                // this is like Q4-2015
                            var thisq = e.entries[0].dataPoint.label;
                            var thislabel = e.entries[0].dataPoint.indexLabel;
                                // this is like 20%
                            var thisy = e.entries[0].dataPoint.y;
                            val = thislabel + "<br>";
                            var count = 0;
                            for(i = 0; i <  e.chart.options.data.length ; i++ )
                            {
                                    // this is like 1-5 times
                                var thiscolor = e.chart.options.data[i].color;
//                                alert( e.chart.options.data[i].name );

                                var dpoints = e.chart.options.data[i].dataPoints;
                                for( j = 0; j < dpoints.length; j++ )
                                {
                                    if( dpoints[j].label == thisq && dpoints[j].y == thisy )
                                    {
                                        var chartname = dpoints[j].numsongs;
                                        if( dpoints[j].url ) 
                                            val += ( "<a  href='" + dpoints[j].url + "'><font color='" + thiscolor + "'>" + chartname + "</font></a><Br>" ) ;
                                        else
                                            val += ( "<font color='" + thiscolor + "'>" + chartname + "</font><Br>" ) ;
                                    }
                                }
                            }
                            return val;
                        }
				},
				// theme: "theme2",
				axisY: { // this is the data
					gridColor: "#f0f0f0",
					// gridColor: "#3c3c3c",
					tickLength: 0,
        			lineThickness:0,
        			gridThickness:1,
					labelFontColor: "#7a7a7a",
					// labelFontColor: "<?=$gray?>",
					tickColor: "#dddddd",
					// tickColor: "<?=$gray?>",
                    valueFormatString: " "
                    
                    
				},
    dataPointMaxWidth: <?=count( $dataforrows ) > 1 ?"60":"120"?>,
				data: [
                    <?php
                    $count = 0;
                    $cnt = -1;
                    foreach( $dataforrows as $columnname => $bardataforrows )
                    {
                        $cnt++;
                       ?>
            {
					type: "<?=$_GET["graphtype"]?$_GET["graphtype"]:"line"?>",
                    markerType: "none",
					indexLabelFontFamily: "Open Sans",
					showInLegend: <?=!$nolegend && count( $dataforrows>1 )?"true":"false"?>,
					lineThickness: 3,
					name: "<?=$columnname?>",
					color: "<?=$colors[$cnt]?>",
					dataPoints: [
                        <?php
                        $qcount = 0;
			// if( strpos( $sectionname, "Primary Genres" ) !== false && !$cnt )
			//     {
			//     file_put_contents( "/tmp/keys", "keys: " . print_r( $bardataforrows, true ) );
			//     //			    exit;
			//     file_put_contents( "/tmp/keys", "keys after: " . print_r( $bardataforrows, true ), FILE_APPEND );

			//     }
			uasort( $bardataforrows, "trendsortByValue" );                        
                        $keys = array_keys( $bardataforrows );
                        // file_put_contents( "/tmp/keys", "rows: " . print_r( $rows, true ) );
                        // file_put_contents( "/tmp/keys", "\n\n AFTER keys: " . print_r( $keys, true ), FILE_APPEND );
                        // file_put_contents( "/tmp/keys", "\n\n AFTER data: " . print_r( $dataforrows, true ), FILE_APPEND );
                        foreach( $keys as $rname ) {
                            $r = $rname;
                            if( !isset( $barkey[$rname] ) ) { continue; }
                            $qcount++;
                            if( $count == count( $colors ) )
                            {
                                $count = 0;
                            }
                            $labelname = $rows[$rname];
                            if( !isset( $labelname ) ) { continue; };
                                // file_put_contents( "/tmp/rows", "for $rname, got $labelname\n", FILE_APPEND );
                                // file_put_contents( "/tmp/rows", "rowshere: " . print_r( $rows, true ), FILE_APPEND );
                            if( $search[comparisonaspect] == "Songwriter Team Size" )
                            {
                                if( !$labelname )
                                    $labelname = "5+"; 
                                $labelname .= ($labelname == "1"?" Songwriter":" Songwriters");
                            }
                            if( $search[comparisonaspect] == "Producer Team Size" )
                            {
                                if( !$labelname )
                                    $labelname = "5+"; 
                                $labelname .= ($labelname == "1"?" Producer/Production Team":" Producers/Production Teams");
                            }
                            if( $search[comparisonaspect] == "Performing Artist Team Size" )
                            {
                                if( !$labelname )
                                    $labelname = "5+"; 
                                $labelname .= ($labelname == "1"?" Artist/Group":" Artists/Groups");
                            }
                            if( $search[comparisonaspect] == "Genre/Influence Count" )
                            {
                                $labelname .= ($labelname == "1"?" Genre/Influence":" Sub-Genres/Influences");
                            }
                            else if( strpos( $search[comparisonaspect], "Count"  ) !== false  && 1 == 0 )
                            {
				$what = trim( str_replace( "Count", "", $search[comparisonaspect] ));
				if( !$labelname )
				    {
					$labelname = "No $what";
				    }
				else
				    {
					$labelname .= ($labelname == "1"?" {$what}":" {$what}s");
					$labelname = str_replace( "horuss", "horuses", $labelname );
				    }
				$labelname = str_replace( "horuss", "horuses", $labelname );
			    }

                            $y = formatYAxis( $bardataforrows[$r][0] );
                            if( !$y )
				{ 
                                continue;
				}
                            
                            ?>                         
				{ color: "<?=$colors[$cnt]?>", label: "<?=str_replace( '"', '\"', $labelname )?>", x: <?=100-$barkey[$rname]?>, y: <?=$y?>, indexLabel: "<?=$bardataforrows[$r][1]?>", numsongs: "<?=$bardataforrows[$r][4]?>", indexLabelFontColor: "#7a7a7a", indexLabelFontWeight: "lighter", indexLabelFontSize: "12", <? if( $bardataforrows[$r][3] ) { ?> click: function( e ) { window.open( "<?=$bardataforrows[$r][3]?>", "_self" );  }, cursor: "pointer", <? } ?> markerType: "circle", "url": "<?=$bardataforrows[$r][3]?>" },
                        <?  }
                        ?>                                
					]
				},
                <?php
                } ?>
                    ],
				legend: {
                      verticalAlign: "top",
                      fontSize: 14,
                      fontColor: "#7a7a7a",
                      // fontColor: "#ffffff",
                      fontFamily: "Open Sans",
                      horizontalAlign: "center",
                      cursor: "pointer",
                      itemclick: function (e) {
                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            }
                            else {
                                e.dataSeries.visible = true;
                            }
			    //			    <?=$graphname?>chart.options.data[0].dataPoints.sort(compareDataPointYDescend);
                            <?=$graphname?>chart.render();
                        }
                    }
                });
//                <?=$graphname?>chart.options.data[0].dataPoints.sort(compareDataPointYDescend);
		<?=$graphname?>chart.render();
		} );
	</script>
<!-- end chart code -->
<? //exit; ?>
    <? if( !$doingweeklysearch && !$doingyearlysearch && !in_array( $sectionid, $nogainers ) ) { ?>
<?=printGainersLosers( $linedataforrows, $rows ) ?>
<? } ?>

<? } ?>
