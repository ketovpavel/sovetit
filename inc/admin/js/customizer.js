/* global wp, jQuery */
( function( $ ) {

	wp.customize( 'header_text_button', function( value ) {
		value.bind( function( to ) {
			$( '.get-header a' ).text( to );
		} );
	} );
	wp.customize( 'footer_text_button', function( value ) {
		value.bind( function( to ) {
			$( '.get-footer a' ).text( to );
		} );
	} );

}( jQuery ) );
