<?php
/**
 * Shortcode.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $args['languages'] ) ) :
	return;
endif;

?>
<script>
document.addEventListener( 'DOMContentLoaded', function() {
	document.querySelectorAll( '.js-plugin-multilang-perelink-field-select' ).forEach( ( $el ) => {
		$el.addEventListener( 'change', ( e ) => {
			e.preventDefault();

			location.href = e.currentTarget.value;
		} );
	} );
} );
</script>


<select class="plugin-multilang-perelink-field-select | js-plugin-multilang-perelink-field-select">
	<?php foreach ( $args['languages'] as $language ) : ?>
		<option value="<?php echo esc_attr( $language['url'] ); ?>"<?php echo selected( $language['locale'], $args['current_locale'] ); ?>><?php echo esc_attr( $language['language'] ); ?></option>
	<?php endforeach; ?>
</select>
