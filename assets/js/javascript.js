/**
 * Front-end javascript file.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

document.addEventListener(
	'DOMContentLoaded',
	function() {
		document.querySelectorAll( '.js-plugin-multilang-perelink-field-select' )
			.forEach(
				function( $el ) {
					$el.addEventListener(
						'change',
						function( e ) {
							e.preventDefault();
							location.href = e.currentTarget.value;
						}
					);
				}
			);
	}
);
