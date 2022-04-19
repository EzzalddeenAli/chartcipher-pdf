<? 
//echo( "data?" ) ;
file_put_contents(  "/tmp/data", print_r( $dataforrows, true  ) );
file_put_contents(  "/tmp/data", "rows: " . print_r( $rows, true  ), FILE_APPEND );
//print_r( $dataforrows );

$songstouse = array( ""=>array() );

if( $doingthenandnow )
    {
	$songstouse = array( "$fromweekdatedisplay - $toweekdatedisplay"=>$allsongs, "$fromweekdatedisplaysecond - $toweekdatedisplaysecond"=>$allsongssecond );
	$dateurlstouse = array( "$fromweekdatedisplay - $toweekdatedisplay"=>$urldatestr, "$fromweekdatedisplaysecond - $toweekdatedisplaysecond"=>$urldatestrsecond );
	if( $fromweekdatedisplaythird )
	    {
		$songstouse["$fromweekdatedisplaythird - $toweekdatedisplaythird"] = $allsongsthird;
		$dateurlstouse["$fromweekdatedisplaythird - $toweekdatedisplaythird"] = $urldatestrthird;
	    }
    }
//print_r( $dateurlstouse );
$alldataforrows = array();
//echo( "about to start\n" );

if( $allsongsbench )
{
	$songstouse = $allsongsbench;
}

foreach( $songstouse as $barname=>$tmpsongs )
{
	if( $allsongsbench )
	    {
		// this is awful, but we need to see what we're also filtering by here
		$benchmarkpeak = $columns[$barname];
		$newcarryfilter = "";
		$minweeksfilter = "";
		$season = "";

		if( is_array( $benchmarkpeak ) )
		    {
			foreach( $benchmarkpeak as $type=>$val )
			    {
				if( $type == "newcarryfilter" )
				    $newcarryfilter = $val;
				if( $type == "minweeksfilter" )
				    $minweeksfilter = $val;
				if( $type == "season" )
				    {
					$season = $val;
				    }
				if( $type == "crosschartid" )
				    {
					$crosschartfilter = $val;
				    }
			    }
			$benchmarkpeak = "";
		    }
		if( $search["benchmarktype"] == "Genre Comparisons" )
		    {
//		    echo( "in here" );
			$subgenrefilter = $benchmarkpeak;
			$benchmarkpeak = "";
		    }		
	    }


    $alldataforrows[$barname] = getBarTrendDataForRows( $search[comparisonaspect], "", $tmpsongs );
    //    echo( "help:" . count( $tmpsongs ) . "<br>"); 
}



$font = "Poppins";
//$font = "Arial";

$sortingbyvalue = 1; 
if( isHighestToLowest( $search[comparisonaspect] ) ) 
{
include "trend-search-results-column-byvalue.php";
}
else
{


//print_r( $alldataforrows );
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

	// this sorts by value, how convoluted
	$presortedbarkey = array();
	$cnt = 0;
	foreach( $alldataforrows as $bardataforrows )
	    {
//	    echo( "slorting" );
//		uasort( $bardataforrows, "trendsortByValue" );                        
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
					$presortedbarkey[$rid] = $rid;
				    }
			    }
		    }
		$cnt++;
	    }

//print_r( $rows );
//print_r( $presortedbarkey );
//	asort( $presortedbarkey );


include "trend-toremove.php";
$barkey = array();
	$cnt = 0;
	foreach( $rows as $key=>$throwaway )
	    {
		$barkey[$key]= $cnt;
		$cnt++;
	    }

if( $_GET["help"] )
    {
	file_put_contents( "hmmrc", print_r( $alldataforrows, true ) );
	file_put_contents( "hmmrc", "rows:" . print_r( $rows, true ), FILE_APPEND );
	file_put_contents( "hmmrc", "barkey: " . print_r( $barkey, true ), FILE_APPEND );
    }

// new colors
$colors = array( "#eeac6f", "#f5ca7d", "#8475a2", "#ebac9a", "#faa33c", "#38226d", "#da857a", "#f9e3b7", "#e3ddf2", "#d7719f", "#bb0e2c", "#1fb5ad","#fa8564","#efb3e6","#fdd752","#aec785","#9972b5","#91e1dd", "#ed8a6b", "#2fcc71", "#689bd0", "#a38671", "#e74c3c", "#34495e", "#9b59b6", "#1abc9c", "#95a5a6", "#5e345e", "#a5c63b", "#b8c9f1", "#e67e22", "#ef717a", "#3a6f81", "#5065a1", "#345f41", "#d5c295", "#f47cc3", "#ffa800", "#ffcd02", "#c0392b", "#3498db", "#2980b9", "#5b48a2", "#98abd5", "#79302a", "#16a085", "#f0deb4", "#2b2b2b" );
	$numtotalbars = 0;
foreach( $alldataforrows as $vals )
{
	$numtotalbars += count( $vals ) ;
}
//echo( "num: " . $numtotalbars );

?>
	<script type="text/javascript">
		window.onload = function () {
			CanvasJS.addColorSet("hsdColors",
                [//colorSet Array

                "#fb833b",
                "#5d97cc",
                "#aeaeae"
                // "#3CB371",
                // "#90EE90"                
                ]);

			chart = new CanvasJS.Chart("chartContainer", {
				colorSet: "hsdColors",
				theme: "light1", // "light1", "light2", "dark1", "dark2"
				exportEnabled: true,
				animationEnabled: false,
				title: {
				 text: "<?=str_replace( '"', '\"', $possiblesearchfunctions[$search[comparisonaspect]]?$possiblesearchfunctions[$search[comparisonaspect]]:$search[comparisonaspect] )?><?=$datedisplay?": ".$datedisplay:""?> <?=$search[specificsubgenre]?"(".getNameById( "subgenres", $search[specificsubgenre] ) . ")":""?>",

                    fontColor: "#8b26b2",
                    // fontColor: "#ffffff",
                    fontFamily: "<?=$font?>",
                    fontWeight: "bold",
					fontSize: 20
				},
                backgroundColor: '#ffffff',
                // backgroundColor: '<?=$gray?>',
				axisX: { // this is the quarters
					gridColor: "#f0f0f0",
					// gridColor: "#525252",
					labelFontColor: "#7a7a7a",
					labelFontFamily: "<?=$font?>",
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
                    labelFormatter: function ( e ) { if( e.label ) return e.label; else return "";  }
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
                                // this is like 20%
                            var thisy = e.entries[0].dataPoint.y;
<? if( $labelextra ) { ?>			    
                            val = thisy + "<?=$labelextra?><br>";
<? } else { ?>			    
     	                    val = e.entries[0].dataPoint.indexLabel;
<? } ?>
//                            alert( thisval );
                            var count = 0;
<? if( $_SESSION["loggedin"] ) { ?>
                            for(i = 0; i <  e.chart.options.data.length ; i++ )
                            {
                                    // this is like 1-5 times

                                var chartname = e.chart.options.data[i].name;
//                                var thiscolor = e.chart.options.data[i].color;
//                                alert( e.chart.options.data[i].name );

                                var dpoints = e.chart.options.data[i].dataPoints;
                                for( j = 0; j < dpoints.length; j++ )
                                {
                                    if( dpoints[j].label == thisq && dpoints[j].y == thisy )
                                    {
                                        var chartname = dpoints[j].numsongs;
                                        var thiscolor = dpoints[j].color;
                                        if( dpoints[j].url ) 
                                            val += ( "<a href='" + dpoints[j].url + "'><font color='" + thiscolor + "'>" + chartname + "</font></a><Br>" ) ;
                                        else
                                            val += ( "<font color='" + thiscolor + "'>" + chartname + "</font><Br>" ) ;
                                    }
                                }
                            }
<? }?>
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
                    valueFormatString: " ",
                    
                    
				}, 
<? $max = $numtotalbars > 12?"90":"120";

if( $numtotalbars > 15 ) 
$max = "70";
if( $numtotalbars >= 20 ) 
$max = "50";
?>
           dataPointMaxWidth: <?=$max?>,
				data: [
                    <?php
                    $count = 0;
                    $cnt = -1;
                    foreach( $alldataforrows as $columnname => $dataforrows )
                    {

                        $cnt++;
                       ?>
            {
					type: "<?=$_GET["graphtype"]?$_GET["graphtype"]:"line"?>",
                    markerType: "none",
                   <? if( $cnt > 6 && 1 == 0  ) { ?>visible: false, <? }?>
					indexLabelFontFamily: "<?=$font?>",
					showInLegend: <?=$searchtype!= "Benchmark"?"false":"true"?>,
					lineThickness: 3,
					name: "<?=$columnname?>",
					color: "<?=$colors[$cnt]?>",
					dataPoints: [
                        <?php
                        $qcount = 0;
                        $keys = array_keys( $dataforrows );
                        foreach( $keys as $rname ) {
//echo( "rname: " . $rname . "\n" );
                            $r = $rname;
                            $labelname = $rows[$rname];
                            if( !isset( $labelname ) ) continue;
                            $qcount++;
                            if( $count == count( $colors ) )
                            {
                                $count = 0;
                            }
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
                            ?>                         
                                {
                                  color: "<?=$colors[$cnt]?>", label: "<?=$labelname?>", x: <?=$barkey[$rname]?>, y: <?=formatYAxis( $dataforrows[$r][0] )?>, numsongs: "<?=$dataforrows[$r][4]?>", indexLabel: "<?=$dataforrows[$r][1]?>", indexLabelFontColor: "#7a7a7a", indexLabelFontWeight: "bold", indexLabelFontSize: "14", <? if( $_SESSION["loggedin"] ) { ?>click: function( e ) { document.location.href="<?=$dataforrows[$r][3]?>";}, cursor: "pointer", <? } ?>markerType: "circle", "url": "<?=$_SESSION["loggedin"]?$dataforrows[$r][3]:""?>" },
                        <?  }
                        ?>                                
					]
				},
                    <?  }
                    ?>
				],
				legend: {
                      verticalAlign: "top",
                      fontSize: 14,
                      fontColor: "#7a7a7a",
                      // fontColor: "#ffffff",
                      fontFamily: "<?=$font?>",
                      horizontalAlign: "center",
                      cursor: "pointer",
                      itemclick: function (e) {
                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            }
                            else {
                                e.dataSeries.visible = true;
                            }
                            chart.render();
                        }
                    }
			    });



			chart.render();
		}
	</script>
<? } ?>
