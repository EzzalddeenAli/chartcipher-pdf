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
				    text: "<?=fixTitleText($possiblesearchfunctions[$search[comparisonaspect]]) ?>",
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
//echo( "                    labelAngle: 70," );
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
				    {
                                        var numsongs = dpoints[j].numsongs;
					if( numsongs == 1 ) numsongs += " Song";
					else numsongs += " Songs";
					numsongs = " (" + numsongs + ")"
<? if( $_SESSION["loggedin"] || 1 ) { ?>
					if( thisy > 0 )
{
	if( dpoints[j].url> "")
	    val += ( "<a href='" + dpoints[j].url + "'><font color='" + thiscolor + "'>" + chartname + numsongs +"</font></a><Br>" ) ;
else
	    val += ( "<font color='" + thiscolor + "'>" + chartname + numsongs +"</font><Br>" ) ;
}
					else
<? } ?>
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
				data: [
                    <?php
                    $count = 0;
                    $cnt = 0;
                    foreach( $rows as $r=>$rname ) {
$labelname = "";
                            if( $search[comparisonaspect] == "Songwriter Team Size" )
                            {
                                $labelname = ($rname == "1"?" Songwriter":" Songwriters");
                            }
                            if( $search[comparisonaspect] == "Producer Team Size" )
                            {
                                $labelname = ($rname == "1"?" Producer/Production Team":" Producers/Production Teams");
                            }
                            if( $search[comparisonaspect] == "Performing Artist Team Size" )
                            {
                                $labelname = ($rname == "1"?" Artist/Group":" Artists/Groups");
                            }
                            if( $search[comparisonaspect] == "Sub-Genre/Influence Count" )
                            {
                                $labelname = ($rname == "1"?" Sub-Genre/Influence":" Sub-Genres/Influences");
                            }

                        $cnt++;
                       ?>
            {
					type: "<?=$_GET["graphtype"]?$_GET["graphtype"]:"line"?>",
                    markerType: "none",
                   <? if( $cnt > 6 && 1 == 0  ) { ?>visible: false, <? }?>
					indexLabelFontFamily: "Open Sans",
					showInLegend: true,
					lineThickness: 3,
					name: "<?=$rname?><?=$labelname?>",
					color: "<?=$colors[$count++]?>",
					dataPoints: [
                        <?php
                        if( $count == count( $colors ) )
                        {
                            $count = 0;
                        }
                        $qcount = 0;
			if( $doingweeklysearch )
			    $torun = $allweekdatestorun;
			else if( $doingyearlysearch )
			    $torun = $allyearstorun;
			else
			    $torun = $quarterstorun;
                        $theseseasons = calcSeasonsToLoop( $_GET["search"]["dates"]["season"] );
// 			echo( "theseseasons: " );
// print_r( $theseseasons );
			foreach( $torun as $q ) {
			    foreach( $theseseasons as $tmpseason ) // i hate this so much
				{
				    
				    $qcount++;
				    list( $m, $y ) = explode( "/", $q );
				    $m = ($m-1)*3 + 1;
				    
				    if( $doingweeklysearch )
					{
					    $label = $q[Name];
					    $q = $q[OrderBy];
					}
				    else if( $doingyearlysearch )
					{
					    $label = "Y". $q;
					}
				    else
					{
					    $label = "Q" . str_replace( "/", "-", $q );
					    list( $m, $y ) = explode( "/", $q );
					    $m = ($m-1)*3 + 1;
					}
				    $thiskey = $q;
				    if( $tmpseason ) $thiskey .= " (" . $seasonswithall[$tmpseason] . ")";
				    if( $tmpseason ) $label .= " (" . $seasonswithall[$tmpseason] . ")";
				    if( $tmpseason )
					{
					    if( isQuarterInFuture( getFirstSeason( $tmpseason ), $q ) ) continue;
					}
				    //				if( $dataforrows[$q][$r]["season"] ) $label .= " - " . $seasons[$dataforrows[$q][$r]["season"]];
				    //$label .= print_r( $dataforrows[$q][$r], true );
				    
                            ?>                         
                                { label: "<?=$label?>", y: <?=formatYAxis( $dataforrows[$thiskey][$r][0] )?>, indexLabel: "<?=$dataforrows[$thiskey][$r][1]?>", numsongs: "<?=$dataforrows[$thiskey][$r][4]?>", indexLabelFontColor: "#7a7a7a", indexLabelFontWeight: "lighter", indexLabelFontSize: "12", <? if( $dataforrows[$thiskey][$r][3] &&(1|| $_SESSION["loggedin"]) ) { ?> click: function( e ) { document.location.href="<?=$dataforrows[$thiskey][$r][3]?>"; }, cursor: "pointer",  <? } else { ?> click: function( e ) { return false }, <? } ?> markerType: "circle", <? if( $dataforrows[$thiskey][$r][3] && (1||$_SESSION["loggedin"]) ) { ?> "url": "<?=$dataforrows[$thiskey][$r][3]?>"<? } ?> },
                                    <? } 
			}?>                                
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
<? if( $_SESSION["loggedin"] ) { ?>
                      cursor: "pointer",
<? } ?>
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
