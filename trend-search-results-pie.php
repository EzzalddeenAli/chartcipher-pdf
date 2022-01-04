<? 
//echo( "data?" ) ;
//print_r( $dataforrows );
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
				exportEnabled: true,
				title: {
				text: "<?=str_replace( '"', '\"', $possiblesearchfunctions[$search[comparisonaspect]] )?>",
                    fontColor: "#888888",
                    // fontColor: "#ffffff",
                    fontFamily: "Open Sans",
                    fontWeight: "bold",
					fontSize: 25
				},
<? if( 1 == 0 ) { ?>
				subtitles:[
<? $descr = db_query_first_cell( "select Value from graphnotes where Name = '" . escMe( $possiblesearchfunctions[$search[comparisonaspect]] ). "' " );

$descr = nl2br( trim( $descr ) );

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
<? } ?>
				animationEnabled: false,
                backgroundColor: '#ffffff',
                // backgroundColor: '<?=$gray?>',
				axisX: { // this is the quarters
					gridColor: "#f0f0f0",
					// gridColor: "#525252",n
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
                            val = thisy + "<?=$labelextra?><br>";
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
                    valueFormatString: " ",
                    
                    
				},
            dataPointMaxWidth: 60,
				data: [
                    <?php
                    $count = 0;
                    $cnt = 0;
                       ?>
            {
					type: "<?=$_GET["graphtype"]?$_GET["graphtype"]:"line"?>",
                    markerType: "none",
                   <? if( $cnt > 6 && 1 == 0  ) { ?>visible: false, <? }?>
					indexLabelFontFamily: "Open Sans",
					showInLegend: true,
					lineThickness: 3,
					name: "<?=$rname?>",
					dataPoints: [
                        <?php
                        $qcount = 0;
                        uasort( $dataforrows, "trendsortByValue" );                        
                        $keys = array_keys( $dataforrows );
			    file_put_contents( "/tmp/pie", print_r( $dataforrows, true ) );
			    file_put_contents( "/tmp/pie", print_r( $rows, true ), FILE_APPEND );
                        foreach( $keys as $rname ) {
                            $r = $rname;
                            $cnt++;
                            $qcount++;
                            if( $count == count( $colors ) )
                            {
                                $count = 0;
                            }
                            $labelname = $rows[$rname];
                            if( $search[comparisonaspect] == "Songwriter Team Size" )
                            {
                                if( !$labelname )
                                    $labelname = "5+"; 
                                $labelname .= ($labelname == "1"?" Songwriter":" Songwriters");
                            }
                            ?>                         
                                {
                                  color: "<?=$colors[$count++]?>", name: "<?=$dataforrows[$r][2]?>", y: <?=formatYAxis( $dataforrows[$r][0] )?>, indexLabel: "<?=$dataforrows[$r][1]?>", indexLabelFontColor: "#7a7a7a", indexLabelFontWeight: "lighter", indexLabelFontSize: "12", click: function( e ) { document.location.href="<?=$dataforrows[$r][3]?>"; }, cursor: "pointer", markerType: "circle", "url": "<?=$dataforrows[$r][3]?>" },
                        <?  }
                        ?>                                
					]
				},
                    <? // }
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
