<? 
// file_put_contents( "/tmp/char", print_r( $rows, true ) . "\n\n" ); 
// file_put_contents( "/tmp/char", print_r( $dataforrows, true ) . "\n\n", FILE_APPEND ); 
?>

	<script type="text/javascript">
		window.onload = function () {
			CanvasJS.addColorSet("hsdColors",
                [//colorSet Array

                "#5d97cc",
                "#fb833b",
                "#aeaeae"
                // "#3CB371",
                // "#90EE90"                
                ]);

			chart = new CanvasJS.Chart("chartContainer", {
				colorSet: "hsdColors",
				exportEnabled: true,
				title: {
				text: "Charting for <?=$songtitlestr?>",
                    fontColor: "#888888",
                    // fontColor: "#ffffff",
                    fontFamily: "Open Sans",
                    fontWeight: "bold",
					fontSize: 25
				},
				animationEnabled: false,
                backgroundColor: '#ffffff',
                // backgroundColor: '<?=$gray?>',
				axisX: { // this is the quarters
					gridColor: "#f0f0f0",
					// gridColor: "#525252",
					labelFontColor: "#7a7a7a",
					labelFontFamily: "Open Sans",
					labelFontSize: "14",
					interval: 1, 
<? 
echo( "                    labelAngle: 40," );
?>
					gridThickness:0,
					tickColor: '#dddddd',
					// tickColor: '<?=$gray?>',
					lineColor:"#dddddd",
					// lineColor:"#525252",
					tickLength: 5,
                    margin: 20
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
     	                    val = e.entries[0].dataPoint.indexLabel + " ";
<? } ?>
//                            alert( thisval );
                            var count = 0;
                            for(i = 0; i <  e.chart.options.data.length ; i++ )
                            {
                                    // this is like 1-5 times
                                var chartname = e.chart.options.data[i].name;
                                var thiscolor = e.chart.options.data[i].color;
//                                alert( e.chart.options.data[i].name );

                                var dpoints = e.chart.options.data[i].dataPoints;
                                for( j = 0; j < dpoints.length; j++ )
                                {
                                    if( dpoints[j].label == thisq && dpoints[j].y == thisy ) 
                                        val += ( "<a href='" + dpoints[j].url + "'><font color='" + thiscolor + "'>" + chartname + "</font></a><Br>" ) ;
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
				data: [
                    <?php
                    $count = 0;
                    $cnt = 0;
                    foreach( $rows as $r=>$rname ) {
			$labelname = "";
                        $cnt++;
                       ?>
            {
					type: "<?=$_GET["graphtype"]?$_GET["graphtype"]:"line"?>",
                    markerType: "none",
                   <? if( $cnt > 6 && 1 == 0  ) { ?>visible: false, <? }?>
					indexLabelFontFamily: "Open Sans",
					showInLegend: true,
					lineThickness: 3,
					name: "<?=$allcharts[$rname]?$allcharts[$rname]:$rname?>",
					color: "<?=$colors[$count++]?>",
					dataPoints: [
                        <?php
                        if( $count == count( $colors ) )
                        {
                            $count = 0;
                        }
                        $qcount = 0;
			$torun = $allweekdatestorun;
                        foreach( $torun as $q ) {
                            $qcount++;
                            list( $m, $y ) = explode( "/", $q );
                            $m = ($m-1)*3 + 1;

			    //			    $wd = db_query_first( "select * from weekdates where realdate = '$q'" );
			    // file_put_contents( "/tmp/char", "torun: (first) $q\n", FILE_APPEND );
			    // file_put_contents( "/tmp/char", "row: (second) $r\n", FILE_APPEND );
			    // file_put_contents( "/tmp/char", "found: first" . print_r( $dataforrows[$q], true )."\n", FILE_APPEND );
			    // file_put_contents( "/tmp/char", "found: whole" . print_r( $dataforrows[$q][$r], true )."\n", FILE_APPEND );
			    // file_put_contents( "/tmp/char", "found: wd ($q)" . print_r( $wd, true )."\n", FILE_APPEND );
//			    if( $doingweeklysearch )
//				{
				    $label = $weekdatearr[$q];
				    //				    $q = $wd[OrderBy];
//				}

                            ?>                         
                                { label: "<?=$label?>", y: <?=formatYAxis( $dataforrows[$q][$r][0] )?>, indexLabel: "<?=$dataforrows[$q][$r][1]?$dataforrows[$q][$r][1]:"0"?>", indexLabelFontColor: "#7a7a7a", indexLabelFontWeight: "lighter", indexLabelFontSize: "12", click: function( e ) { document.location.href="<?=$dataforrows[$q][$r][3]?>"; }, cursor: "pointer", markerType: "circle", "url": "<?=$dataforrows[$q][$r][3]?>" },
                                    <? }?>                                
					]
				},
                <? } ?>
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
