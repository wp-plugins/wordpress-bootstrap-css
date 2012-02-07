jQuery( document ).ready(
	function () {
		jQuery( '*[rel=tooltip],*[data-tooltip=tooltip]' ).tooltip();
		jQuery( '*[rel=popover]')
			.popover( { offset: 10 } )
			.click( function(e) { e.preventDefault() } ); 
		
		jQuery( '*[data-popover=popover]')
			.popover( { offset: 10 } );
	}
); 