<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<!-- Base MasterSlider style sheet -->
<link rel="stylesheet" href="masterslider/masterslider/style/masterslider.css" />

<!-- MasterSlider Template Style -->
<link href='masterslider/homepage/style/ms-staff-style.css' rel='stylesheet' type='text/css'>

<!-- google font Lato -->
<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>

<!-- jQuery -->
<!--<script src="masterslider/masterslider/jquery.min.js"></script>
<script src="masterslider/masterslider/jquery.easing.min.js"></script>-->

<!-- Master Slider -->
<script src="masterslider/masterslider/masterslider.min.js"></script>
	</head>

	<body>

<!-- template -->
<div class="ms-staff-carousel">
    <!-- masterslider -->
    <div class="master-slider" id="masterslider">

<?php
$dbname = $reportsdbname;
//$dbname = "devreports_wpmain";
$ext = "";
if( isEssentials() )
{
	$ext = " and ID in ( select post_id from {$dbname}.wp_postmeta where meta_key = 'report_pdf' ) ";
}
$res = db_query_rows( "select post_name, post_title, ID from {$dbname}.wp_posts where  post_status = 'publish' and (( post_type = 'post' and ID in ( select object_id from {$dbname}.wp_term_relationships where term_taxonomy_id = 39 ) ) or ( post_type = 'treports' )) $ext order by post_date desc limit 12" );

foreach( $res as $r ) {
$img = db_query_first_cell( "SELECT guid      FROM {$dbname}.wp_postmeta AS pm      INNER JOIN {$dbname}.wp_posts AS p ON pm.meta_value=p.ID       WHERE pm.post_id = '$r[ID]'        AND pm.meta_key = '_thumbnail_id'       ORDER BY p.post_date DESC" );

if( isEssentials() )
    $r[post_name] = "";
?>

        <div class="ms-slide">
            <img src="../masterslider/style/blank.gif" data-src="<?=$img?>" alt=""/>
              <a href="https://editorial.chartcipher.com/<?=$r[post_name]?>"></a><div class="ms-info2">
                <a href="https://editorial.chartcipher.com/<?=$r[post_name]?>"><?=$r["post_title"]?> </a>
            </div>
            <div class="ms-info">
            </div>
        </div>
<? } ?>
    </div>
    <!-- end of masterslider -->
    <div class="ms-staff-info" id="staff-info"> </div>
</div>
<!-- end of template -->

	</body>


<script type="text/javascript">

    var slider = new MasterSlider();
    slider.setup('masterslider' , {
        loop:true,
        width:406,
        height:283,
        speed:20,
        view:'fadeBasic',
        preload:0,
        space:0,
        wheel:false,
       fillwidth:true

    });
    slider.control('arrows' , {autohide:false});
    slider.control('slideinfo',{insertTo:'#staff-info'});

</script>
</html>
