<?php

function calcTrendQSStart( $q )
{
    global $songid, $weekdatearrbyid;
    $qs = "";
    //    $hmm = db_query_first( "select id from weekdates where realdate = '$q'" );
    $hmm = $weekdatearrbyid[$q];
    $qs .= "search[dates][fromweekdate]={$hmm}&";
    return $qs;
}

$cachedtrenddata = array();


function getChartInfoForSong( $songid, $allweekdatestorun = "" )
{
    global $chartgenre, $chartmedium;
    $whr = "";
    if( $chartgenre ) $whr .= " and chart in ( select chartkey from charts where genre like '%$chartgenre%' )";
    if( $chartmedium ) $whr .= " and chart in ( select chartkey from charts where chartmedium like '%$chartmedium%' )";
    $retval = array();

    if( !$allweekdatestorun )
	{
	    $allweekdatestorun = db_query_array( "select distinct( thedate ) from billboardinfo where songid = $songid $whr order by thedate", "thedate", "thedate" );
	}
    $torun = $allweekdatestorun;
    // if( $doingyearlysearch ) print_r( $torun );
    foreach( $torun as $q )
    {
	//remember rachel
        $qs = calcTrendQSStart( $q );

	$labels = db_query_array( "select chart, rank from billboardinfo where songid = $songid and thedate = '$q' $whr", "chart", "rank" );
	foreach( $labels as $t=>$numforthis )
	    {
                    $retval[$q][$t][0] = 101-$numforthis;
                    $retval[$q][$t][1] = $numforthis;
                    $retval[$q][$t][2] = $t;
                    $retval[$q][$t][3] = "chartlist.php?chartkey=$t&thedate=$q&hirank={$numforthis}#rank{$numforthis}";
                    $retval[$q][$t][4] = $numforthis; 
	    }
    }
    return $retval;
}

function getRowsComparison( $songid )
{
    global $chartgenre, $chartmedium;
    $whr = "";
    if( $chartgenre ) $whr .= " and chart in ( select chartkey from charts where genre like '%$chartgenre%' )";
    if( $chartmedium ) $whr .= " and chart in ( select chartkey from charts where chartmedium like '%$chartmedium%' )";

    $mycharts = db_query_array( "select distinct( chart ) from billboardinfo, charts where songid = $songid and IsLive = 1 and chartkey = chart $whr ", "chart", "chart" );
    
    return $mycharts;    
}

function formatYAxis( $value )
{
    if( !$value ) return "0";
    return $value;
}


function chartsortByValue( $a, $b )
{
    if ($a[0] == $b[0]) {
         return ($a[3] > $b[3]) ? 1 : -1;;
    }
    return ($a[0] > $b[0]) ? -1 : 1;
    
}

?>
