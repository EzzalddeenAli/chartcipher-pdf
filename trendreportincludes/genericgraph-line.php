<? 
$graphname = str_replace( "-", "", $sectionid );
$graphname = str_replace( ":", "", $graphname );
$graphname = strtolower( $graphname );

if( $extrgraphname )
    $graphname .= $extrgraphname;
$search[comparisonaspect] = getTrendGraphNameConverter( $sectionname );
if( $search[comparisonaspect] ) 
{
$rows = getRowsComparison( $search, $allsongsallquarters );
if( $help )
    print_r( $rows );
$colors = array( "#1fb5ad","#fa8564","#efb3e6","#fdd752","#aec785","#9972b5","#91e1dd", "#ed8a6b", "#2fcc71", "#689bd0", "#a38671", "#e74c3c", "#34495e", "#9b59b6", "#1abc9c", "#95a5a6", "#5e345e", "#a5c63b", "#b8c9f1", "#e67e22", "#ef717a", "#3a6f81", "#5065a1", "#345f41", "#d5c295", "#f47cc3", "#ffa800", "#ffcd02", "#c0392b", "#3498db", "#2980b9", "#5b48a2", "#98abd5", "#79302a", "#16a085", "#f0deb4", "#2b2b2b" );



$dataforrows = getTrendDataForRows( $quarterstorun, $search[comparisonaspect], $search["peakchart"] );
//$dataforrows = getTrendDataForRows( $quarterstorun, $search[comparisonaspect] );

//print_r( $quarterstorun );exit;
$q1 = "Q" . $quarterstorun[0] . " - Q" . $quarterstorun[3];
$q1 = str_replace( "/" , " ", $q1 );
$datestr = " ($q1)";

if( $doingweeklysearch )
    {
	$datestr = " (".$rangedisplay . ")";
	$q1 = $fromweekdatedisplay;
    }


if( $doingyearlysearch )
    {
	$datestr = " (".$rangedisplay . ")";
	$q1 = $search[dates][fromy];
    }



?>
    <? if( !$doinghomepage ) { ?>
<div class="graph-head">                       

     <div class=" set" style="margin-bottom:20px;">  
         <div class="icon download">
        <a href="#" id="<?=$graphname?>exportjpg" onclick="return false"> Download</a>
             
             </div>
                 
                 
    </div>   
    
    
    
       <div class=" set" style="margin-bottom:20px;">  
    <span class="showall">   
        
        <div class="icon show-all ">
                                    <a href="#" onClick='<?=$graphname?>_showAllGraph( true ); return false'>Show All</a></div>
        
        <div class="icon hide-all ">
                                 <a href="#"  onClick='<?=$graphname?>_showAllGraph( false ); return false'>Hide All</a></div>
        
      </span>                   
              
    
    </div>
                        </div>
	       <? } ?>
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
      <div id="<?=$graphname?>chartContainer" style="height:600px;<? if($doinghomepage)echo( "width: 100%" ); ?>" >
	</div>
<? 
     $graphnote = getTrendReportNote( "0", $sectionid );
if( $graphnote ) 
{ 
    echo( "<i>$graphnote</i><br>" );	   
}
$specificgraphnote = getTrendReportNote( $thisquarter, $sectionid );
if( $specificgraphnote && !$doinghomepage ) 
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
				    text: "<?=fixTitleText($sectionname) . $datestr ?>",
                    fontColor: "#888888",
                    // fontColor: "#ffffff",
                    fontFamily: "Open Sans",
                    fontWeight: "bold",
					fontSize: 25
				},
				subtitles:[
<?php
$descr = getOrCreateGraphNote( "CTR (line): " . $sectionname, $extgraphnote )
;
if( $descr )
{
?>

            {
		text: "<?=fixTitleText($descr)  ?>",
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
					// gridColor: "#525252",
					labelFontColor: "#7a7a7a",
					labelFontFamily: "Open Sans",
					labelFontSize: "14",
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
                            var thislabel = e.entries[0].dataPoint.indexLabel;
                                // this is like 20%
                            var thisy = e.entries[0].dataPoint.y;
                            val = thislabel + "<br>";
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
                                        var ext = "";
                                        if( dpoints[j].numsongs == "1" )
                                        {
                                            ext = " - " + dpoints[j].numsongs + " Song";
                                        }
                                        else if( dpoints[j].numsongs )
                                        {
                                            ext = " - " + dpoints[j].numsongs + " Songs";
                                        }
                                        if( dpoints[j].url ) 
                                            val += ( "<a  href='" + dpoints[j].url + "'><font color='" + thiscolor + "'>" + chartname + ext + "</font></a><Br>" ) ;
                                        else
                                            val += ( "<font color='" + thiscolor + "'>" + chartname + ext + "</font><Br>" ) ;
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
                        $cnt++;
                       ?>
            {
					type: "line",
                    markerType: "none",
                   <? if( $cnt > 6 && 1 == 0  ) { ?>visible: false, <? }?>
					indexLabelFontFamily: "Open Sans",
					showInLegend: true,
					lineThickness: 3,
					name: "<?=str_replace( '"', '\"', $rname )?>",
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

			    if( $tmpseason )
				{
				    if( isQuarterInFuture( getFirstSeason( $tmpseason ), $q ) ) continue;
				}
			    
				$thiskey = $q;
				if( $tmpseason ) $thiskey .= " (" . $seasonswithall[$tmpseason] . ")";
				if( $tmpseason ) $label .= " (" . $seasonswithall[$tmpseason] . ")";

                            ?>                         
                                { label: "<?=str_replace( '"', '\"', $label )?>", y: <?=formatYAxis( $dataforrows[$thiskey][$r][0] )?>, numsongs: "<?=$dataforrows[$thiskey][$r][4]?>", indexLabel: "<?=$dataforrows[$thiskey][$r][1]?>", indexLabelFontColor: "#7a7a7a", indexLabelFontWeight: "lighter", indexLabelFontSize: "12", click: function( e ) { <? if( $dataforrows[$q][$r][3] ) { ?> window.open( "<?=$dataforrows[$thiskey][$r][3]?>", "_self" ); <? } ?> }, <? if( $dataforrows[$q][$r][3] ) { ?>cursor: "pointer", <? } ?> markerType: "circle", "url": "<?=$dataforrows[$thiskey][$r][3]?>" },
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
                      cursor: "pointer",
                      itemclick: function (e) {
                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            }
                            else {
                                e.dataSeries.visible = true;
                            }
                             <?=$graphname?>chart.render();
                        }
                    }
                });
			<?=$graphname?>chart.render();
		} );
	</script>
<!-- end chart code -->

	    <? if( 1 == 0 ) { ?>
    <? if( !in_array( $sectionid, $nogainers ) ) { ?>
<?=printGainersLosers( $dataforrows, $rows ) ?>
<? } ?>
<? } ?>

<? } ?>
