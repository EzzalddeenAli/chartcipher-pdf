    <script>
$( document ).ready(function() {

<? if( $_GET["help"] || 1 ) { ?>
    var table = $('table <?=$extsortingtype?>');
    $('.sortablecol')
        .wrapInner('<span title="sort this column"/>')
        .each(function(){
            
            var th = $(this),
                thIndex = th.index(),
                inverse = false;
            
            th.click(function(){
//	    alert( "start sort" );
                table.find('td.sortablerow').filter(function(){
                    return $(this).index() === thIndex;
                    
                }).sortElements(function(a, b){
		    var atext = $.text([a]).trim().toLowerCase();
		    var btext = $.text([b]).trim().toLowerCase();

		    //                    alert("sorting" + atext );

		    if( (""+atext).indexOf( "%" ) > -1 && atext.indexOf( "(" ) > -1 )
		    {
			atext = atext.substring( 0, atext.indexOf( "(" ) ).trim();
		    }
		    if( (""+btext).indexOf( "%" ) > -1 && btext.indexOf( "(" ) > -1 )
		    {
			btext = atext.substring( 0, btext.indexOf( "(" ) ).trim();
		    }

		    atext = atext.replace(/<(?:.|\n)*?>/gm, '');
		    btext = btext.replace(/<(?:.|\n)*?>/gm, '');
		    atext = atext.replace( "%", "" );
		    btext = btext.replace( "%", "" );
            if( atext == "Kickoff" )
                atext = "0:00";
            if( btext == "Kickoff" )
                btext = "0:00";
		    if( isInteger( atext ) )
            {
                atext = parseInt( atext );
            }
		    if( isInteger( btext ) )
		    {
//                alert( "ye"+ btext );
                btext = parseInt( btext );
		    }

		    // alert( atext.indexOf( "/" ) );
		    // alert( atext.lastIndexOf( "/" ) != atext.indexOf( "/" ) );
		    if( (""+atext).indexOf( "/" ) > -1 && atext.lastIndexOf( "/" ) != atext.indexOf( "/" ) )
		    {
//			alert( "date thing" );
			atext = new Date( atext );
		    }

		    if( (""+btext).indexOf( "/" ) > -1 && btext.lastIndexOf( "/" ) != btext.indexOf( "/" ) )
		    {
//		    alert( "date thing 2" );
		    btext = new Date( btext );
		    //		    alert( btext );
		    }

                    return atext > btext ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    
                    // parentNode is the element we want to move
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
                    
            });
                
        });
    <? } ?>
});
function isInteger(x) {
    return (x % 1 === 0);
}
</script>    
