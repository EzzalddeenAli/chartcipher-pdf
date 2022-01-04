<?php
require_once "trendfunctions.php"; 
$thisweek = db_query_first( "select weekdates.*, weekdateid from song_to_weekdate, weekdates where weekdateid = weekdates.id order by weekdates.OrderBy desc limit 1" );
$allsongs = db_query_array( "select songid from song_to_weekdate where weekdateid = $thisweek[weekdateid]","songid", "songid" );
$allsongsstr = implode( ",", $allsongs );
$numsongs = count( $allsongs );
$subgenrerows = db_query_rows( "select count(*) as cnt, Name, subgenreid from song_to_subgenre, subgenres where HideFromAdvancedSearch = 0 and subgenreid = subgenres.id and songid in ( $allsongsstr ) group by Name, subgenreid order by cnt desc, OrderBy, Name", "subgenreid" );


$colors = array( "#1fb5ad","#fa8564","#efb3e6","#fdd752","#aec785","#9972b5","#91e1dd" ); 
$dataforrows = array();
$rows = array();

foreach( $subgenrerows as $t=>$s )
{
    $rows[$t] = $s[Name];
    $numforthis = $s[cnt];
    $numforthis = number_format( $numforthis * 100 / ($numsongs?$numsongs:1) );
    $dataforrows[$t][0] = $numforthis;
    $dataforrows[$t][1] = $numforthis . "%";
    $dataforrows[$t][2] = $t;
    $dataforrows[$t][3] = "search-results?search[weekdateid]={$thisweek[weekdateid]}&search[subgenres][" . urlencode( $t ) . "]=1"; 
}

if( $help )
    print_r( $dataforrows );
if( $help ) echo( "<br><br>" );
if( $help )
    print_r( $rows );
?>
<style type="text/css">
	.search-header h1{ float:none; }
	.search-header h2{
    margin-top: 15px;
    color: #7a7a7a;
    font-size: 14px;
	}
    
    ul.instructions li{
         list-style-type: initial!important;
        margin-left:15px!important;
        padding-bottom:6px;
       font-weight: 500;
    }
    
    #chartContainer h2 {
   padding-bottom:20px;
    }
</style>
<!-- begin graph -->
	<div id="chartContainer" style="height:600px;">
	</div>

    <? $gray = "#444444"; ?>
    <? $labelextra = "%";

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
				title: {
                      text: "Week of <?=$thisweek["Name"]?>",
                    fontColor: "#888888",
                    // fontColor: "#ffffff",
                    fontFamily: "Open Sans",
                    fontWeight: "bold",
					fontSize: 20
				},
				subtitles:[
<? $descr = "To view the songs that possess each influence, click on the bar graph.";
$descr = nl2br( trim( $descr ) );
if( $descr )
{
?>

            {
              text: "<?=$descr?>",
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
				toolTip: {
                      enabled: false,
				},

                axisX: { labelFontSize: 14, gridThickness: 0, labelAngle: 50, interval: 1 }, 
                axisY: { gridThickness: 0, maximum: 200, labelFormatter: function ( e ) { return "" }, tickLength: 0  }, 
                
				data: [
            {
					type: "column",
					name: "<?=$rname?>",
					color: "<?=$colors[$count++]?>",
					dataPoints: [
                    <?php
                    $count = 0;
                    $cnt = 0;
                    foreach( $rows as $r=>$rname ) {
                        $cnt++;
                        if( $count == count( $colors ) )
                        {
                            $count = 0;
                        }

                            ?>                         
                        { label: "<?=$dataforrows[$r][1]?>", y: <?=formatYAxis( $dataforrows[$r][0] )?>, click: function( e ) { document.location.href="<?=$dataforrows[$r][3]?>"; }, cursor: "pointer",  "url": "<?=$dataforrows[$r][3]?>",  indexLabelOrientation: "horizontal", indexLabel: "<?=$rname?>", indexLabelFontColor: "#7a7a7a", indexLabelFontWeight: "lighter", indexLabelFontSize: "12", color: "<?=$colors[$count++]?>",                     indexLabelOrientation: "vertical"
 },
                    <? } ?>
					]
            }
                    ],
                });
			chart.render();
		}
	</script>
<!-- end chart code -->
    
