jQuery( document ).ready(
	function () {
		jQuery( 'a[rel=twipsy],*[data-twipsy=twipsy]' ).twipsy( { live: true } );
		jQuery( 'a[rel=popover]')
			.popover( { offset: 10 } )
			.click( function(e) { e.preventDefault() } ); 
		
		jQuery( '*[data-popover=popover]')
			.popover( { offset: 10 } );
	}
); 