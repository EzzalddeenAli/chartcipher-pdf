<?php
$logtype = "trend search results";
$istrend = false;
include 'header.php';
include 'genrefunctions.php';

$search[dates][toq] = $search[dates][fromq];
$search[dates][toy] = $search[dates][fromy];

$quarterstorun = getQuarters( $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy] );
$pos = $search[peakchart];
if( $pos && strpos( $pos, "client-" ) === false )
    $pos = "<" . $pos;

$allsongs = getSongIdsWithinQuarter( $newarrivalsonly, $search[dates][fromq], $search[dates][fromy], $search[dates][toq], $search[dates][toy], $pos );

$numsongs = count( $allsongs );
if( !$numsongs ) $numsongs = 1;
$allsongstr = implode( ",", $allsongs );

?>
<style type="text/css">
	.search-header h1{ float:none; }
	.search-header h2{
    margin-top: 15px;
    color: #7a7a7a;
    font-size: 14px;
        line-height:18px;
	}
  .search-body th
  {
        color: #fff;
    padding: 20px;
    text-align: center;
       word-wrap: break-word;
  }
  .search-body table
  {
    width: 100%;
  }
  .search-body thead tr
  {
    background: #32323a !important;
    color: #fff !important;
  }
  .search-body td
  {
    padding: 25px;
  }
  .search-results-bottom .search-body td
  {
    border: 1px solid #dddddd;
    width: 16%;
    text-align: center;
  }
  .search-results-bottom .search-body td a
  {
    text-align: center;
    color: inherit;
    text-decoration: none;
  }
  .search-results-bottom .search-body td a:hover
  {
    /*text-align: center;*/
    color: #ff6633;
    text-decoration: none;
  }
  #search-criteria-table td.search-column-1
  {
        width: 12%;
  }
  #search-criteria-table select[name="search[dates][fromq]"]
  {
        width: 25% !important;
  }
  #search-criteria-table select[name="search[dates][fromy]"]
  {
    width: 25% !important;
    margin-left: 1% !important;
  }
  #search-criteria-table select[name="search[peakchart]"]
  {
    width: 51.3% !important;
    /*margin-left: 1%;*/
  }
  section.search-results-bottom thead tr th
  {
        width: 11%;
  }
  section.search-results-bottom thead, section.search-results-bottom thead tr
  {
    /*display: block;*/
    width: 100%;
  }
  section.search-results-bottom table
  {
    table-layout: fixed;
    display: block;
    width: 100%;
  }

section.search-results-bottom tbody,
section.search-results-bottom thead
  {
    display: table;
    width: 100%;
    height: auto;
    overflow: auto;
  }

    table{
     width:100%;
        overflow:auto;
    }
  @media (max-width: 480px)
  {
    section.search-results-bottom table
    {
      overflow: auto;
         display: block;
    }
    section.search-results-bottom tbody tr td:first-of-type,
      section.search-results-bottom thead  tr td:first-of-type
    {
      display: block;
    }
  }

    table{
     table-layout: fixed
    }

    .search-body {
    padding: 25px 20px!important;
}

    #sticky {
        box-sizing: border-box;
    padding: 0;
    width: 100%;
    background-color: transparent;
    color: #fff;
    font-size: 2em;
}

#sticky.stick {
    margin-top: 120px !important;
    position: fixed;
    top: 0;
    z-index: 200;
    margin-left: 0px;
            right: 0px;
    padding-left: 0px;
}
.sticky-wrap{
  padding:0px 20px;
 }
/*
@media(min-width:1150px){
 .sticky-wrap{
  padding:0px 20px;
 }
}*/

    @media (min-width:767px){
        #sticky.stick {
             margin-top: 164px !important;
    padding-left: 240px;
}
    }

     @media (min-width:1150px){
        #sticky.stick {
             margin-top: 124px !important;
    padding-left: 240px;
}

    }



th:last-child {
    width: 11%!important;
}

    section.search-results-bottom tbody tr td:first-of-type, section.search-results-bottom thead tr td:first-of-type {
     display: table-cell!important;
}

    thead{
       background-color: #32323a !important;
    }


@media (max-width: 768px){
        section.search-results-bottom thead tr th,
    section.search-results-bottom tbody tr td {
    min-width: 185px!Important;
        box-sizing:border-box;
    }
}
    @media (min-width: 768px){
        section.search-results-bottom thead tr th,
          section.search-results-bottom tbody tr td{
    min-width: 175px!important;
               box-sizing:border-box;
    }
}

</style>

<script>
function sticky_relocate() {
    var window_top = $(window).scrollTop();
    var div_top = $('#sticky-anchor').offset().top;
    if (window_top > div_top) {
        $('#sticky').addClass('stick');
        $('#sticky').removeClass('hide');
        $('#sticky-anchor').height($('#sticky').outerHeight());
    } else {
        $('#sticky').removeClass('stick');
          $('#sticky').addClass('hide');
        $('#sticky-anchor').height(0);
    }
}

$(function() {
    $(window).scroll(sticky_relocate);
    sticky_relocate();
});

var dir = 1;
var MIN_TOP = 200;
var MAX_TOP = 350;

function autoscroll() {
    var window_top = $(window).scrollTop() + dir;
    if (window_top >= MAX_TOP) {
        window_top = MAX_TOP;
        dir = -1;
    } else if (window_top <= MIN_TOP) {
        window_top = MIN_TOP;
        dir = 1;
    }
    $(window).scrollTop(window_top);
    window.setTimeout(autoscroll, 100);
}
</script>


	<div class="site-body">
        <? include "searchcriteria-genre.php"; ?>
		<section class="search-results-bottom">
			<div class="element-container row">
				<div class="search-container">
					<div class="search-header">
						<h1><?=getOrCreateCustomTitle( "GENRE HIGHLIGHTS", "GENRE HIGHLIGHTS" )?></h1>
						<h2>This search depicts top characteristics by primary genre within songs that charted in the Billboard Hot 100 Top 10 during the selected quarter. To view the songs that correspond to the results in this report click on the data point. </h2>
						<a href="genre-search.php?<?=$_SERVER['QUERY_STRING']?>" class="search-header-back">BACK <span class="hide-text">TO SEARCH</span></a>
						<div class="cf"></div>
					</div><!-- /search-header -->
					<div class="search-body">

<script language='javascript'>
    function showAllGraph( val )
{
    for(i = 0; i <  chart.options.data.length ; i++ )
    {
        chart.options.data[i].visible = val;
    }
    chart.render();
}
</script>
<?php
$genres = db_query_array( "select id, Name from genres where 1 order by OrderBy", "id", "Name" );
$primarygenres = db_query_rows( "select * from genres where 1 order by OrderBy , Name", "id" );
foreach( $primarygenres as $prow )
  {
    $genresongs[$prow[id]] = db_query_array( "select id from songs where GenreID = '$prow[id]' and songs.id in ( $allsongstr )", "id", "id" );
    $num = count( $genresongs[$prow[id]] );
    $genresongsstr[$prow[id]] = implode( ", ", $genresongs[$prow[id]] );

    if( !$num )
      {
	unset( $primarygenres[$prow[id]] );
	unset( $genres[$prow[id]] );
	continue;
      }
    $numingenre[$prow[id]] = $num;
  }

?>

<!-- begin sticky -->
 <div id="sticky-anchor" style=""></div>
<div id="sticky">
    <div class="element-container row">
        <div class="sticky-wrap">
     <table id="">
    <thead class="linked" id="">
      <tr>
        <th>CATEGORY</th>
<? foreach( $genres as $gname ) { ?>
    <th><?=strtoupper( $gname )?></th>
         <? } ?>
      </tr>
    </thead>
         </table>
        </div>
    </div>
</div>
<!-- begin graph -->
 <table id="">
 </thead>
    <thead class="linked" id="">
      <tr>
        <th>CATEGORY</th>
<? foreach( $genres as $gname ) { ?>
    <th><?=strtoupper( $gname )?></th>
         <? } ?>
      </tr>
    </thead>
    <tbody class="linked">

      <? foreach( $cols as $c ) {
          $values = getGenreValues( $quarterstorun, $c );
          ?>
      <tr>
        <td style="color:#333333;"><?=$c?></td>
    <? foreach( $genres as $gid=>$gname ) {
              $valuerow = $values[$gid];
              if( $valuerow[1] )
              {
              ?>
                  <td><a href='<?=$valuerow[1]?>'><?=$valuerow[0]?></a></td>
                      <? } else { ?>
                  <td><?=$valuerow[0]?></td>
                                  <? } ?>
     <?} ?>
      </tr>
            <? } ?>
            </tbody>
  </table>
    <!-- end graph -->
                        <div class="search-footer">
							<div class="search-footer-left span-3">
								<a href="genre-search.php?<?=$_SERVER['QUERY_STRING']?>" style="float:left;" class="search-header-back">BACK <span class="hide-text">TO SEARCH</span></a>
								<div class="cf"></div>
							</div><!-- /search-footer-left -->
							<div class="search-footer-right span-4">
    <? if( !isStudent()  && !isEssentials() ) { ?>
    <a class="black-btn" href="#" data-featherlight="#searchlightbox">SAVE SEARCH</a>
                            <? } ?>
								<a class="orange-btn" href="/trend-search">NEW SEARCH</a>
								<div class="lightbox" id="searchlightbox">
									<div class="save-search-header">
										<h1>SAVE SEARCH</h2>
									</div><!-- /.save-search-header -->
									<div class="save-search-body">
										<label>Name:</label>
										<input type='text' name="searchname" id='searchname' onChange='javascript:document.getElementById( "searchnamehidden").value = this.value; '>
										<a class="black-btn" href="#" onClick='javascript:saveSearch( "saved", "Genre" ); return false'>SAVE</a>
										<div class="cf"></div>
									</div><!-- /.save-search-body -->
								</div><!-- #searchlightbox -->
							</div><!-- /search-footer-right -->
							<div class="cf"></div>
						</div><!-- /.search-footer -->
					</div><!-- /search-body -->
				</div><!-- /.search-container -->
			</div><!-- /.row -->
		</section><!-- /.search-results-bottom -->
	</div><!-- /.site-body -->
      <input type='hidden' name="searchnamehidden" id='searchnamehidden'>
    <script>
		var sessid = "<?=session_id()?>";
		var searchType = "<?=$searchtype?$searchtype:"Trend"?>";
	var searchName = "GENRES DECONSTRUCTED REPORT";
saveSearch( "recent" );

    $(document).ready(function(){
        $("a.expand-btn").click(function(){
            $("a.expand-btn").toggleClass("collapse-btn");
            $("#search-hidden").toggleClass("hide show");
        });
    });

    </script>
<script>
$(document).ready(function(){
 $('th, td a').contents().filter(function() {
    return this.nodeType == 3
}).each(function(){
    this.textContent = this.textContent.replace(/\//g, " \/ ")
});

$('.linked').scroll(function(){
$('.linked').scrollLeft($(this).scrollLeft());
});

});
</script>



<?php include 'footer.php';?>
