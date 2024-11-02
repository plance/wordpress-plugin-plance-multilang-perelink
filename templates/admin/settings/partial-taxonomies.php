<?php
/**
 * Partial.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

defined( 'ABSPATH' ) || exit;

use Plance\Plugin\Multilang_Perelink\Settings;
?>

<?php foreach ( $args['taxonomies'] as $loop_taxonomy ) : ?>

	<div>
		<label>
			<input
				type="checkbox"
				name="<?php echo esc_attr( Settings::FIELD_TAXONOMIES ); ?>[]"
				<?php echo ( in_array( $loop_taxonomy->name, $args['selected_taxonomies'], true ) ? 'checked' : '' ); ?>
				value="<?php echo esc_attr( $loop_taxonomy->name ); ?>">
			<?php echo esc_attr( $loop_taxonomy->label ); ?>
		</label>
	</div>

<?php endforeach; ?>

<p class="description">
	<?php esc_html_e( 'Select taxonomies for perelinking.', 'plance-multilang-perelink' ); ?>
</p>
