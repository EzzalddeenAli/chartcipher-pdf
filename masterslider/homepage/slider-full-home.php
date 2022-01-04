<!-- begin copied from trend-search -->
<style type="text/css">
	.search-header h1{ float:none; }
	.search-header h2{
    margin-top: 15px;
    color: #7a7a7a;
    font-size: 14px;
	}
    
    table tr:first-child td:last-child{
    display:none;
    }
    
section {
     background-color: transparent!important; 
    
}

    .search-body td {
    padding: 25px;
}
.temp-hidden {
    padding: 0px 0px 0px 0px;
}

.search-hidden-container {
    padding: 35px 0 35px 0px;
}

ul.listA li.head-label a{
font-size: 15px;
font-weight: 700;
color: #7a7a7a;
}
ul.listA li.head-label {
margin-top: 15px;
}

ul.listA li.head-label:first-child {
    margin-top: 0px;
}



ul.listA li.head-label:after{
content: ''!important;
}


.search-body {
    padding: 25px 0px;
}
.graph-wrap, .graph-wrap > div {
    margin: 60px 0;
}

#search-hidden-2 hr{
	
	margin-bottom: 40px;
}

.canvasjs-chart-container{
	margin-bottom: 25px;
}
</style>

<script language='javascript'>
    function showAllGraph( mychart, val )
{
    for(i = 0; i <  mychart.options.data.length ; i++ )
    {
        mychart.options.data[i].visible = val;
    }
    mychart.render();
}



</script>    

<!-- end copied from trend-search -->
<? 
include "trenddoingquartermiddle.php";    
$_GET["graphtype"] = "line";
$tmpreportsarr["Key"] = "Key";
$tmpreportsarr["Major-Vs-Minor"] = "Major vs. Minor";
$tmpreportsarr["Average-Tempo"] = "Average Tempo";
$tmpreportsarr["Tempo-Range"] = "Tempo Range";

?>
<div class="ms-autoheight-template">
					<!-- masterslider -->
					<div class="master-slider ms-skin-light-2" id="masterslider">
<? 
    foreach( $tmpreportsarr as $sectionid=>$sectionname ) { 
?>
  <div class="ms-slide">
                 <div class="home-search-header new">
                               <h1><?=$sectionid?></h1>
                            </div>
             <? include "trendreportincludes/{$sectionid}.php"; ?>
					    </div>
	<? } ?>
    </div>
    <!-- end of masterslider -->
    <div class="ms-staff-info" id="staff-info"> </div>
</div>
<!-- end of template -->
