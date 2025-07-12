<?php
/**
 * Shortcode.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $args['languages'] ) || ! is_array( $args['languages'] ) ) :
	return;
endif;

wp_enqueue_script( 'multilang-perelink' );
?>
<select class="plugin-multilang-perelink-field-select | js-plugin-multilang-perelink-field-select">
	<?php foreach ( $args['languages'] as $language ) : ?>
		<option value="<?php echo esc_url( $language['url'] ); ?>"<?php echo selected( $language['locale'], $args['current_locale'] ); ?>><?php echo esc_attr( $language['language'] ); ?></option>
	<?php endforeach; ?>
</select>
