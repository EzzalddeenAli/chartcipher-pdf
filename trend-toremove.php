<?
if( $search["comparisonaspect"] == "PersonReferences" || $search["comparisonaspect"] == "LocationReferences" )
{
    foreach( $rows as $rowkey=>$rowval )
	{
	    if( $rowkey == "No" || $rowval == "No" ){
		unset( $rows[$rowkey] );
			foreach( $alldataforrows as $key=>$vals )
			    {
				unset( $alldataforrows[$key][$rowkey] );
			    }

	    }
	}

}
if( $search["comparisonaspect"] == "Chorus Count" || $search["comparisonaspect"] == "Song Title Word Count" || $search["comparisonaspect"] == "Genres" )
{
    foreach( $rows as $rowkey=>$rowval )
	{
	    $anyabove = 0;
	    foreach( $alldataforrows as $d )
		{
		    $tocheck = $d[$rowkey];
		    if( $tocheck[0] >= 1 )
			$anyabove = 1;
		}
	    if( !$anyabove )
		{
			unset( $rows[$rowkey] );
			foreach( $alldataforrows as $key=>$vals )
			    {
				unset( $alldataforrows[$key][$rowkey] );
			    }
		}
	}
}

    foreach( $alldataforrows as $key=>$vals )
	{
	    $anyabovezero = false;
	    foreach( $vals as $linekey=>$linevals )
		{
		    if( $linevals[0] > 0 )
			$anyabovezero = 1;
		}
	    if( !$anyabovezero )
		{
		unset( $alldataforrows[$key] );
		}
	    
	}
// remove anything with no value
    foreach( $rows as $rowkey=>$rowval )
	{
	    $anyabove = 0;
	    foreach( $alldataforrows as $d )
		{
		    $tocheck = $d[$rowkey];
		    if( $tocheck[0] > 0.1 )
			$anyabove = 1;
		}
	    //	    echo( "chekcing:  $rowkey<br>" );
	    if( !$anyabove )
		{
		    unset( $rows[$rowkey] );
		    foreach( $alldataforrows as $key=>$vals )
			{
			    unset( $alldataforrows[$key][$rowkey] );
			}
		}
	}


?>
