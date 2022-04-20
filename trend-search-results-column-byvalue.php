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
//"None", "Low Repetition", "Moderate Repetition", "High Repetition"
$sorter["None"] = 7;
$sorter["Low Repetition"] = 6;
$sorter["Moderate Repetition"] = 5;
$sorter["High Repetition"] = 4;
return $sorter[$a] > $sorter[$b];


}
function yesno_sort( $a, $b )
{
$sorter["Yes"] = 7;
$sorter["No"] = 6;

return $sorter[$a] > $sorter[$b];


}

function profanity_sort( $a, $b )
{
$sorter["None"] = 8;
$sorter["Sporadic Use"] = 7;
$sorter["Heavy Use"] = 6;



return $sorter[$a] > $sorter[$b];


}
function timbre_sort( $a, $b )
{
$sorter["Primarily Bright"] = 8;
$sorter["Primarily Dark"] = 7;
$sorter["Mixed"] = 6;



return $sorter[$a] > $sorter[$b];


}

function danceability_sort( $a, $b )
{
$sorter["Low"] = 8;
$sorter["Moderate"] = 7;
$sorter["High"] = 6;

return $sorter[$a] > $sorter[$b];


}
function melodicrange_sort( $a, $b )
{
$sorter["Horizontal"] = 8;
$sorter["Mixed-Horizontal"] = 7;
$sorter["Mixed-Vertical"] = 6;
$sorter["Vertical"] = 5;

return $sorter[$a] > $sorter[$b];


}

function frequency_sort( $a, $b )
{
$sorter["Very Frequent"] = 9;
$sorter["High Use"] = 9;
$sorter["Frequent"] = 8;
$sorter["Mid-High Use"] = 8;
$sorter["Moderate"] = 7;
$sorter["Occasional"] = 6;
$sorter["Low-Mid Use"] = 6;
$sorter["Little to None"] = 5;
$sorter["Low Use"] = 5;

$sorter["Entirely Diatonic"] = 9;
$sorter["Primarily Diatonic"] = 8;
$sorter["Somewhat Diatonic"] = 7;
$sorter["Chromatic Influence / Multiple Keys"] = 6;

return $sorter[$a] > $sorter[$b];


}
function frequency_sort_lowestfirst( $a, $b )
{
$sorter["None"] = 10;
$sorter["Low"] = 9;
$sorter["Few"] = 9;
$sorter["Little Use"] = 9;
$sorter["Sporadic Use"] = 9;
$sorter["Little to None"] = 9;
$sorter["Occasional"] = 8;
$sorter["Low-Mid"] = 8;
$sorter["Some"] = 8;
$sorter["Moderate"] = 7;
$sorter["Moderate Use"] = 7;
$sorter["High-Mid"] = 7;
$sorter["Frequent"] = 6;
$sorter["Very Frequent"] = 5;
$sorter["Frequent Use"] = 5;
$sorter["High"] = 5;

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
	   elseif( $search["comparisonaspect"] == "ProfanityRange" )
	   {
	   	uksort( $presortedbarkey, 'profanity_sort' );
		
	   }
	   elseif( $search["comparisonaspect"] == "Timbre" )
	   {
	   	uksort( $presortedbarkey, 'timbre_sort' );
		
	   }
	   elseif( $search["comparisonaspect"] == "MainMelodicRange" )
	   {
	   	uksort( $presortedbarkey, 'melodicrange_sort' );
	   }
	   elseif( $search["comparisonaspect"] == "OverallRepetitivenessRange" 
	   ||    $search["comparisonaspect"] == "SlangWordsRange" 
	   ||    $search["comparisonaspect"] == "GeneralLocationReferencesRange" 
	   ||    $search["comparisonaspect"] == "UseOf7thChordsRange" 
	   ||    $search["comparisonaspect"] == "EndOfLineRhymesPercentageRange" 
	   ||    $search["comparisonaspect"] == "EndLinePerfectRhymesPercentageRange" 
	   ||    $search["comparisonaspect"] == "OverallRepetitivenessRange" 
	   ||    $search["comparisonaspect"] == "ThousandWordsPrevalenceRange" 
	   ||    $search["comparisonaspect"] == "UseOfInvertedChordsRange" 
	   ||    $search["comparisonaspect"] == "MidLineRhymesPercentageRange" 
	   ||    $search["comparisonaspect"] == "RhymeDensityRange" 
	   ||    $search["comparisonaspect"] == "LocationReferencesRange" 
	   ||    $search["comparisonaspect"] == "PersonReferencesRange" 
	   ||    $search["comparisonaspect"] == "TotalAlliterationRange" 
	   ||    $search["comparisonaspect"] == "GeneralPersonReferencesRange" 
)
	   {
	   	uksort( $presortedbarkey, 'frequency_sort_lowestfirst' );
		
	   }
	   elseif( $search["comparisonaspect"] == "MidLineRhymesPercentageRange"
	   ||    $search["comparisonaspect"] == "PercentDiatonicChordsRange" 
	   ||    $search["comparisonaspect"] == "NumMelodicThemesRange" 
	    || $search["comparisonaspect"] == "InternalRhymesPercentageRange" )
	   {
	   	uksort( $presortedbarkey, 'frequency_sort' );
		
	   }
	   elseif( $search["comparisonaspect"] == "DanceabilityRange" )
	   {
	   	uksort( $presortedbarkey, 'danceability_sort' );
		
	   }
	   elseif( $search["comparisonaspect"] == "Departure Section" )
	   {
	   	uksort( $presortedbarkey, 'yesno_sort' );
		
	   }
	   else
	   	asort( $presortedbarkey );


include "trend-toremove.php";
	$cnt = 0;


	foreach( $presortedbarkey as $key=>$throwaway )
	    {
		if( !$rows[$key] ) continue;

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
$colors = array( "#faa33c", "#8475a2", "#ebac9a", "#7197b4", "#f9e3b7", "#38226d", "#bd685d", "#d7719f", "#71b49f", "#e3ddf2", "#bb0e2c", "#42606e", "#eeac6f", "#f5ca7d", "#8475a2", "#ebac9a", "#faa33c", "#38226d", "#da857a", "#f9e3b7", "#e3ddf2", "#d7719f", "#bb0e2c", "#1fb5ad","#fa8564","#efb3e6","#fdd752","#aec785","#9972b5","#91e1dd", "#ed8a6b", "#2fcc71", "#689bd0", "#a38671", "#e74c3c", "#34495e", "#9b59b6", "#1abc9c", "#95a5a6", "#5e345e", "#a5c63b", "#b8c9f1", "#e67e22", "#ef717a", "#3a6f81", "#5065a1", "#345f41", "#d5c295", "#f47cc3", "#ffa800", "#ffcd02", "#c0392b", "#3498db", "#2980b9", "#5b48a2", "#98abd5", "#79302a", "#16a085", "#f0deb4", "#2b2b2b" );
	$numtotalbars = 0;
foreach( $alldataforrows as $key=>$vals )
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
				text: "<?=str_replace( '"', '\"', $possiblesearchfunctions[$search[comparisonaspect]] )?><?=$datedisplay?": ".$datedisplay:""?> <?=$search[specificsubgenre]?"(".getNameById( "subgenres", $search[specificsubgenre] ) . ")":""?> ",
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
<? if( $_SESSION["loggedin"] ) {?>
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
<? } ?>
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
                                  color: "<?=$colors[$cnt]?>", label: "<?=$labelname?>", x: <?=100-$barkey[$rname]?>, y: <?=formatYAxis( $dataforrows[$r][0] )?>, numsongs: "<?=$dataforrows[$r][4]?>", indexLabel: "<?=$dataforrows[$r][1]?>", indexLabelFontColor: "#7a7a7a", indexLabelFontWeight: "bold", indexLabelFontSize: "14", <? if( $_SESSION["loggedin"] ) { ?>click: function( e ) { document.location.href="<?=$dataforrows[$r][3]?>"; }, cursor: "pointer", <? } ?>markerType: "circle", "url": "<?=$_SESSION["loggedin"]?$dataforrows[$r][3]:""?>" },
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
