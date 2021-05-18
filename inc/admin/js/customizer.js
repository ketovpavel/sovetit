/* global wp, jQuery */
( function( $ ) {

	wp.customize( 'header-text-button', function( value ) {
		value.bind( function( to ) {
			$( '.get-header a' ).text( to );
		} );
	} );
	wp.customize( 'footer-text-button', function( value ) {
		value.bind( function( to ) {
			$( '.get-footer a' ).text( to );
		} );
	} );

}( jQuery ) );
