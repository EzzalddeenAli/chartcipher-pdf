<?php
$shownos = 1;

$groupingkey = str_replace( array( " ", "/" ), "_", strtolower( $grouping ) );
$graphname = str_replace( "-", "", $groupingkey.$sectionid );
$graphname = str_replace( ":", "", $graphname );
$graphname = strtolower( $graphname );
if( $extrgraphname )
    $graphname .= $extrgraphname;


$graphname .= $graphcount;
$graphcount++;

if( $sectionname == "Songwriters" )
{
    $searchsubtype = "songwriters";
}
//echo( "section name is $sectionname" );
$search[comparisonaspect] = getTrendGraphNameConverter( $sectionname );
//print_r( $search );
$searchsubtype = "";
if( $search[comparisonaspect] ) 
{
    $rows = getRowsComparison( $search, $allsongsallquarters );
//    if( $help3 )
//        print_r( $rows );
    
    $colors = array( "#5b9bd5","#fa8564","#efb3e6","#fdd752","#aec785","#9972b5","#91e1dd" );
    $dataforrows = array();

if( !count( $songstouse  ) )
{
    $songstouse = array( array() );
}
// echo( "peak: " . $specificpeak );
foreach( $songstouse as $barname=>$tmpsongs )
{
	if( $barname === "#1" )
		$specificpeak = 1;
    else
		$specificpeak = "";

    $dataforrows[$barname] = getBarTrendDataForRows( $search[comparisonaspect], "", $tmpsongs );
}
//print_r( $dataforrows );
if( in_array( "Carryovers", array_keys( $songstouse ) ) )
{
//    $colors = array( "#fab09e","#c3daef" );
}


$specificpeak = "";
    // echo( "\n\songs:\n "); 
    // print_r( $songstouse );
    // echo( "\n\rows:\n "); 
    // print_r( $rows );
    // echo( "\n\ndata:\n "); 
    // print_r( $dataforrows );
if( $extratext == " Note: Some songs are affiliated with more than one label"  )
{
    //    print_r( $songstouse );
    //    print_r( $rows );
    //    print_r( $dataforrows );
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
	//	print_r( $dataforrows );

	foreach( $dataforrows as $bardataforrows )
	    {
		uasort( $bardataforrows, "trendsortByValue" );                        
		//		print_r( $bardataforrows );
		foreach( $bardataforrows as $rid=>$tmparr )
		    {
			
			if( !isset( $presortedbarkey[$rid] ) )
			    {
				if( $cnt )
				    {
					// this is in the second segment so... i don't think we should get in here?
					//					echo( "not usre? $rid<br>\n" );
					
				    }
				else
				    {
					//					echo( "adding $rid ($tmparr[0])<br>" );
					$presortedbarkey[$rid] = $tmparr[0];
									    }
			    }
		    }
		$cnt++;
	    }
	//	print_r( $presortedbarkey );
	arsort( $presortedbarkey );
	//	print_r( $presortedbarkey );
	$cnt = 0;
	foreach( $presortedbarkey as $key=>$throwaway )
	    {
		$barkey[$key]= $cnt;
		$cnt++;
	    }
}
//print_r( $barkey );

?>











<div class="graph-head">                       

     <div class=" set" style="margin-bottom:20px;">  
         <div class="icon download">
        <a href="#" id="<?=$graphname?>exportjpg" onClick='return false'> Download</a>
             
             </div>
                 
                 
    </div>   
    
    
    
       <div class=" set" style="margin-bottom:20px;">  
    <span class="showall">   
        
        <div class="icon show-all ">
                                    <a href='#' onClick='<?=$graphname?>_showAllGraph( true ); return false' >Show All</a></div>
        
        <div class="icon hide-all ">
                                 <a href='#' onClick='<?=$graphname?>_showAllGraph( false ); return false' >Hide All</a></div>
        
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
<? } ?>

			<?=$graphname?>chart = new CanvasJS.Chart("<?=$graphname?>chartContainer", {
				colorSet: "hsdColors",
				exportEnabled: true,
				title: {
				text: "<?=str_replace( '"', '\"', $overtitle?$overtitle:$sectionname )?>",
                    fontColor: "#888888",
                    fontFamily: "Open Sans",
                    fontWeight: "bold",
					fontSize: <?=$fromtrend?"25":"18"?>
				},
<? if( 1 == 1 ) { ?>
				subtitles:[
<? $descr = getOrCreateGraphNote( "ITR (column): " . $sectionname, $extgraphnote );

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
					type: "<?=$specificgraphtype?>",
                    markerType: "none",
					indexLabelFontFamily: "Open Sans",
					showInLegend: <?=!$nolegend && count( $dataforrows>1 )?"true":"false"?>,
					lineThickness: 3,
					name: "<?=$columnname?>",
					color: "<?=$colors[$cnt]?>",
					dataPoints: [
                        <?php
                        $qcount = 0;
                            // not sure we can sort anymore
//                        uasort( $tmpdataforrows, "trendsortByValue" );                        
                        $keys = array_keys( $bardataforrows );
                        foreach( $keys as $rname )
                        {
                            $r = $rname;
                            $qcount++;
                            $labelname = $rows[$rname];
                            if( !$labelname ) { echo( "// skipping $rname \n 
" ); continue; }
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
                            $y = formatYAxis( $bardataforrows[$r][0] );
			    // echo( "// me: ($r) $y\n" );
			    // print_r( $bardataforrows );
                            if( !$y )
                                continue;
			    if( !isset( $barkey[$rname] ) ) 
{
    //	file_put_contents( "/tmp/skip", "skipping $rname, $r \n", FILE_APPEND );
	continue;
}
                            ?>                         
				{ color: "<?=$colors[$cnt]?>", label: "<?=$labelname?>", x: <?=$barkey[$rname]?>, y: <?=$y?>, indexLabel: "<?=$bardataforrows[$r][1]?>", numsongs: "<?=$bardataforrows[$r][4]?>", indexLabelFontColor: "#7a7a7a", indexLabelFontWeight: "lighter", indexLabelFontSize: "12", <? if( $bardataforrows[$r][3] ) { ?> click: function( e ) { window.open( "<?=$bardataforrows[$r][3]?>", "_self");  }, cursor: "pointer", <? } ?> markerType: "circle", "url": "<?=$bardataforrows[$r][3]?>" },
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
                            <?=$graphname?>chart.render();
                        }
                    }
                });
			<?=$graphname?>chart.render();
		} );
	</script>
<!-- end chart code -->
<? //exit; ?>
<? if( $extratext ) { ?>
<div id='extranote'><?=$extratext?></div><br><br>
<? 
$extratext = "";
} ?>

<? } ?>
