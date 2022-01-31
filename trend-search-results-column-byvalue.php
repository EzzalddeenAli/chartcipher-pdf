<? 


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
					$presortedbarkey[$rid] = $tmparr[0]; // this is one thign for the sort
				    }
			    }
		    }
		$cnt++;
	    }

function cdp_sort( $a, $b )
{
$sorter["%I"] = 7;
$sorter["%II"] = 6;
$sorter["%III"] = 5;
$sorter["%IV"] = 4;
$sorter["%V"] = 3;
$sorter["%VI"] = 2;
$sorter["%VII"] = 1;
return $sorter[$a] > $sorter[$b];


}
function cr_sort( $a, $b )
{
$sorter["Not Repetitive"] = 7;
$sorter["Somewhat Repetitive"] = 6;
$sorter["Very Repetitive"] = 5;
$sorter["Highly Repetitive"] = 4;
return $sorter[$a] > $sorter[$b];


}
function yesno_sort( $a, $b )
{
$sorter["Yes"] = 7;
$sorter["No"] = 6;

return $sorter[$a] > $sorter[$b];


}


//print_r( $rows );
//print_r( $presortedbarkey );
//echo( $search["comparisonaspect"] );
	   if( $search["comparisonaspect"] == "ChordDegreePrevalence" )
	   {
	   	uksort( $presortedbarkey, 'cdp_sort' );
		
	   }
	   elseif( $search["comparisonaspect"] == "ChordRepetitionRange" )
	   {
	   	uksort( $presortedbarkey, 'cr_sort' );
		
	   }
	   elseif( $search["comparisonaspect"] == "Departure Section" )
	   {
	   	uksort( $presortedbarkey, 'yesno_sort' );
		
	   }
	   else
	   	asort( $presortedbarkey );
	$cnt = 0;
	foreach( $presortedbarkey as $key=>$throwaway )
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
$colors = array( "#5b9bd5","#fa8564","#009900","#fdd752","#aec785","#9972b5","#91e1dd" );
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
				text: "<?=str_replace( '"', '\"', $possiblesearchfunctions[$search[comparisonaspect]] )?>",
                    fontColor: "#888888",
                    // fontColor: "#ffffff",
                    fontFamily: "Open Sans",
                    fontWeight: "bold",
					fontSize: 25
				},
                backgroundColor: '#ffffff',
                // backgroundColor: '<?=$gray?>',
				axisX: { // this is the quarters
					gridColor: "#f0f0f0",
					// gridColor: "#525252",
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
           dataPointMaxWidth: 120,
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
					indexLabelFontFamily: "Open Sans",
					showInLegend: <?=$search[benchmarktype]||$doingthenandnow?"true":"false"?>,
					lineThickness: 3,
					name: "<?=$columnname?>",
					color: "<?=$colors[$cnt]?>",
					dataPoints: [
                        <?php
                        $qcount = 0;
//                        uasort( $dataforrows, "trendsortByValue" );                        
                        $keys = array_keys( $dataforrows );
                        foreach( $keys as $rname ) { // this is one thign for the sort
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
                                  color: "<?=$colors[$cnt]?>", label: "<?=$labelname?>", x: <?=100-$barkey[$rname]?>, y: <?=formatYAxis( $dataforrows[$r][0] )?>, numsongs: "<?=$dataforrows[$r][4]?>", indexLabel: "<?=$dataforrows[$r][1]?>", indexLabelFontColor: "#7a7a7a", indexLabelFontWeight: "bold", indexLabelFontSize: "14", click: function( e ) { document.location.href="<?=$dataforrows[$r][3]?>"; }, cursor: "pointer", markerType: "circle", "url": "<?=$dataforrows[$r][3]?>" },
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
                            chart.render();
                        }
                    }
                });



			chart.render();
		}
	</script>
