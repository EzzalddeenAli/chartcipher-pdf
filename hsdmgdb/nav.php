<html><head><title>Song Admin> <?=$extratitle?></title>

<script language="javascript" src="jquery-1.11.3.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="mult/multiple-select.css" rel="stylesheet"/>
  <link rel="stylesheet" href="nav2.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<script language="javascript" src="common.js"></script>
<script language="javascript" src="mult/multiple-select.js"></script>
  <script>
   $(function() {
       $( "#menu" ).menu();
     });
  </script>
  <style>

h3 {
  margin-bottom:20px;
}
body > table > tbody > tr > td:first-child{
  width: 40px;
}


.ui-menu { width: 150px; }
body, #menu, .fallback, .ui-widget, .ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button{
 font-family: 'Open Sans', sans-serif!important;
}  

input {
font-family: 'Open Sans', sans-serif!important;
}
select {
/*  width: 100%;*/
            max-width: 300px;
border: solid 1px #e2e2e4;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
height: 40px;
color: #7a7a7a!important;
text-indent: 5px;
background-color: #ffffff;
font-family: 'Open Sans', Helvetica, sans-serif;
padding: 8px 0;
   font-size: 16px!important;

}

   input[type=file] {

border: solid 0px #e2e2e4;

z-index: 1000;
cursor: pointer;
font-size: 24px;
width: 100%;

}

input, input[type=text], input[type=password], textarea {
width: 100%;
     font-size: 16px!important;
            max-width: 300px;
border: solid 1px #e2e2e4;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
height: 40px;
color: #7a7a7a!important;
text-indent: 10px;
font-family: 'Open Sans', Helvetica, sans-serif;

}


      input[type=checkbox] {
height: auto!important;

             width: auto!important;
              text-indent: 0px!important;

}


textarea {
height: 96px;
}


table.cmstable, table.content {
border-collapse: collapse;
border-spacing: 0;
    margin: 35px 0 15px;
}
table.cmstable th, table.content th{
                font-size: 14px;
      height: 65px;
padding: 5px 10px;
}

table.cmstable th,  table.content > tbody > tr > th,
table.cmstable td, table.content > tbody > tr > td
{
         border: solid 1px #d0d0d0;

}

table.cmstable th,  table.content > tbody > tr > th, table.content > th,
table.cmstable td, table.content > tbody > tr > td, table.content > td{
padding: 10px;
}


table{
  width: 100%;
}

table td{
  padding:5px;
}
table.cmstable > tbody > tr > td:nth-child(2) table td{
     border: solid 0px #eeeeee;
}




a {
color: #ff6633!important;
font-weight: 600;
text-decoration: none;
}

.orange-btn, input[type=submit] {
background-color: #ff6633;
display: inline-block;
-webkit-border-radius: 3px;
-moz-border-radius: 3px;
border-radius: 3px;
text-align: center;
  height: auto!important;
font-size: 16px;
color: #ffffff!important;
text-decoration: none;
padding: 12px 0;
-webkit-transition: all .2s ease-in-out;
-moz-transition: all .2s ease-in-out;
-o-transition: all .2s ease-in-out;
transition: all .2s ease-in-out;
  width: 48%;
  max-width: 300px;
  margin-top: 20px;
      display: block;
}

table.add,     table.filter{
  width: 900px;
}

table.add td:first-child,     table.filter td:first-child{
  width: 15%;
}
      table.add th, table.add td, table.filter th, table.filter td{
       padding: 10px;
}



.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited, .ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited {
color: #ff6633!important;
text-decoration: none;
      background: #ffffff!important;
}

select.multiple{
  height: 100px;
}

    .ms-parent.selectmultiple li input{
          margin-right: 10px;
      }
      
      #tabs-credits input{
       display: inline-block;
      }
  </style>
</head>
<body><table><tr><td valign='top'>
<ul id="menu"><li>
<a href='songs.php'><b>Songs</b></a>
</li>
   <li><a href='customhovers.php'>Custom Hovers</a>
<ul class="fallback">
<? $hcats = db_query_array( "select distinct( hovercategory ) from customhovers order by hovercategory", "hovercategory", "hovercategory" );
foreach( $hcats as $c )
{
	echo( "<li><a style=\"font-size:12px\" href='customhovers.php?cat={$c}'>{$c}</a></li>\n" );
}
?>
</ul>
</li>

   <li><a href='#'>Content (A-M)</a>
<ul class="fallback">
<li><a style="font-size:12px" href='artists.php'>Artists</a></li>
<li><a style="font-size:12px" href='artistgenres.php'>Artist Genres</a></li>
<li><a style="font-size:12px" href='backvocaltypes.php'>Background Vocal Types</a></li>
<li><a style="font-size:12px" href='backvocals.php'>Background Vocals</a></li>
<li><a style="font-size:12px" href='bridgecharacteristics.php'>Bridge Characteristics</a> </li>
<li><a style="font-size:12px" href='charts.php'>Charts</a></li>
<li><a style="font-size:12px" href='chorusstructures.php'>Chorus Structures</a></li>
<li><a style="font-size:12px" href='chorustypes.php'>Chorus Types</a> </li>
<li><a style="font-size:12px" href='clients.php'>Clients</a> </li>
<li><a style="font-size:12px" href='customtitles.php'><b>Custom Titles</b></a> </li>
<li><a style="font-size:12px" href='endingtypes.php'>Ending Types</a> </li>
<li><a style="font-size:12px" href='genres.php'>Genres</a> </li>
<li><a style="font-size:12px" href='graphnotes.php'>Graph Notes</a> </li>
<li><a style="font-size:12px" href='groups.php'>Groups</a> </li>
<li><a style="font-size:12px" href='groupgenres.php'>Group Genres</a> </li>
<li><a style="font-size:12px" href='homepage.php'>Homepage</a> </li>
<li><a style="font-size:12px" href='imprints.php'>Imprints</a> </li>
<li><a style="font-size:12px" href='instruments.php'>Instruments</a> </li>
<li><a style="font-size:12px" href='subgenres.php'>Sub-Genres/Influences</a> </li>
<li><a style="font-size:12px" href='introtypes.php'>Intro Types</a> </li>
<li><a style="font-size:12px" href='songkeys.php'>Keys</a> </li>
<li><a style="font-size:12px" href='labels.php'>Labels</a> </li>
<li><a style="font-size:12px" href='lyricalthemes.php'>Lyrical Themes</a> </li>
<li><a style="font-size:12px" href='members.php'>Members</a> </li>
</ul>
</li>
   <li><a href='#'>Content (N-Z)</a>
<ul class="fallback">
<li><a style="font-size:12px" href='outrotypes.php'>Outro Types</a> </li>
<li><a style="font-size:12px" href='placements.php'>Placements</a> </li>
<li><a style="font-size:12px" href='postchorustypes.php'>Post-Chorus Types</a> </li>
<li><a style="font-size:12px" href='primaryinstrumentations.php'>Prominent Instrumentations</a> </li>
<li><a style="font-size:12px" href='producers.php'>Production Groups</a> </li>
<li><a style="font-size:12px" href='reportdescriptions.php'>Report Descriptions</a> </li>
<li><a style="font-size:12px" href='retroinfluences.php'>Retro Influences</a> </li>
<li><a style="font-size:12px" href='rocksubgenres.php'>Rock Influences</a> </li>
<li><a style="font-size:12px" href='samplesongs.php'>Sample Songs</a> </li>
<li><a style="font-size:12px" href='sampletypes.php'>Sample Types</a> </li>
<li><a style="font-size:12px" href='containssampleds.php'>Contains Samples</a> </li>
<li><a style="font-size:12px" href='songsections.php'>Song Sections</a> </li>
<li><a style="font-size:12px" href='songnames.php'>Song Titles</a> </li>
<!--<li><a style="font-size:12px" href='songwriters.php'>Songwriters</a> </li>-->
<li><a style="font-size:12px" href='techniques.php'>Techniques</a> </li>
<li><a style="font-size:12px" href='trendreportnotes.php'>Trend Report Notes</a> </li>
<li><a style="font-size:12px" href='timesignatures.php'>Time Signatures</a> </li>
<li><a style="font-size:12px" href='vocaltypes.php'>Vocal Types</a></li>
<li><a style="font-size:12px" href='vocals.php'>Vocals</a></li>
<li><a style="font-size:12px" href='weekdates.php'>Week Dates</a></li>
<li><a style="font-size:12px" href='worldsubgenres.php'>World Influences</a> </li>
</ul>
</li>
<? if( $_SESSION["isadminlogin"] ) { ?>
<li>
<a href='users.php'>Users</a>
</li>
<li>
<a href='settings.php'>Settings</a>
</li>
<? } ?>
<li>
<a href='loader.php'>Upload</a>
</li>
<? if( $_SESSION["isadminlogin"] || isRachel()  ) { ?>
<li>
<a href='#'>Usage</a>
<ul class="fallback">
<li><a href='academicusage.php'>Academic Usage</a></li>
<li><a href='usage.php'>Usage</a></li>
<li><a href='academicusers.php'>Academic Users</a></li>
<li><a href='ascapusage.php'>ASCAP Usage</a></li>
<li><a href='prousage.php'>Pro Usage</a></li>
<li><a href='premiereusage.php'>Premiere Usage</a></li>
</ul>
</li>
<li>
<a href='#'>Uploads</a>
<ul class="fallback">
<li><a href='pdfuploads.php?type=Essentials'>Essentials</a></li>
<li><a href='pdfuploads.php?type=Trend+Brief'>Trend Brief</a></li>
<li><a href='pdfuploads.php?type=Mastery+Workshop'>Mastery Workshop</a></li>
<li><a href='pdfuploads.php?type=On+Demand'>On Demand Videos</a></li>
<li><a href='pdfuploads.php?type=Song+Reports'>Song Reports</a></li>
<li><a href='pdfuploads.php?type=Trend+Reports'>Trend Reports</a></li>
</ul>
</li>
<li>
<a href='#'>Billboard Data</a>
<ul class="fallback">
<li><a href='pullbillboard.php'>Pull Data</a></li>
<li><a href='billboardexport.php'>Billboard Export</a></li>
</ul>
</li>
<li>
<a href='#'>Reports</a>
<ul style="width:500px; padding-top: 20px; margin-top: 20px" class="fallback">
<li><a href='trendreport.php'>Trend Report Master</a></li>
<li><a href='genrereport.php'>Genre Report</a></li>
<li><a href='yearbyyearreport.php'>Team Size Report</a></li>
<li><a href='genderreport.php'>Gender Report</a></li>
<li><a href='toptenreport.php'>Top 10 Deconstructed</a></li>
<li><a href='hsdweekly.php'>HSD Weekly Charts</a></li>
<li><a href='producerqa.php'>Producer QA</a></li>
<li><a href='songfiledownloads.php'>Logic File Downloads</a></li>
<li><a href='hsdchartinfo.php'>HSD DB Songs Chart Info</a></li>
<li><a href='../trend-csv.php'>Trends by Staying Power (Weeks)</a></li>
<li><a href='../trend-csv-quarterly.php'><nobr>Trends by Staying Power (Quarter/Year Range)</nobr></a></li>
<li><a href='../trend-csv-report.php'>Quarterly Trend Report</a></li>
<li><a href='../trend-csv-quarterly-yearly.php'><nobr>Quarterly Trend Report - Quarterly and Yearly</nobr></a></li>
<li><a href='../collaborations-report-search.php'><nobr>Collaborations Report</nobr></a></li>
<li><a href='toptennewcomers.php'>Top 10 Newcomers</a></li>
</ul>
</li>
<? } ?>
<li><a href='logout.php'>Logout</a></li>
</ul>
</nav>
</td><td>
   <div id='mainbody'>
