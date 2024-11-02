/**
 * Admin javascript file.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

jQuery( document ).ready(
	function() {
		jQuery( '.js-plc-field__select' ).select2(
			{
				placeholder: '',
				allowClear:  true,
				width:      '100%',
			}
		);

		jQuery( '.js-plc-field__select' ).on(
			'select2:select',
			function ( e ) {
				let $option = jQuery( e.params.data.element );
				let $link   = $option
								.parents( '.js-plc-block-fields' )
								.find( '.js-plc-field__link' );
				if ( $link.length ) {
					$link
						.attr( 'href', $option.data( 'edit-link' ) )
						.show();
				}
			}
		);

		jQuery( '.js-plc-field__select' ).on(
			'select2:clearing',
			function ( e ) {
				let $select = jQuery( e.target );
				let $link   = $select
								.parents( '.js-plc-block-fields' )
								.find( '.js-plc-field__link' );

				if ( $link.length ) {
					$link
						.attr( 'href', '#' )
						.hide();
				}
			}
		);
	}
);
