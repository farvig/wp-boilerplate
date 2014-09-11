(function( $ ){
	$(function(){
		
		wp.customize( 'ivp_logo_file', function( value ) {
			value.bind( function( to ) {
				$( '.site-logo img' ).attr('src', to );
			});
		});

		wp.customize( 'ivp_page_title_bg', function( value ) {
			value.bind( function( to ) {
				$( '.page-header' ).css('background', 'url(' + to + ')' );
			});
		});
	});
} )( jQuery );