<?php
/**
 * Partial.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

defined( 'ABSPATH' ) || exit;

use Plance\Plugin\Multilang_Perelink\Settings;
?>

<?php if ( ! empty( $args['post_types'] ) ) : ?>

	<?php foreach ( $args['post_types'] as $loop_post_type ) : ?>

		<div>
			<label>
				<input
					type="checkbox"
					name="<?php echo esc_attr( Settings::FIELD_POST_TYPES ); ?>[]"
					<?php echo esc_attr( in_array( $loop_post_type->name, $args['selected_post_types'], true ) ? 'checked' : '' ); ?>
					value="<?php echo esc_attr( $loop_post_type->name ); ?>">
				<?php echo esc_attr( $loop_post_type->label ); ?>
			</label>
		</div>

	<?php endforeach; ?>

	<p class="description">
		<?php esc_html_e( 'Select post types for perelinking.', 'multilang-perelink' ); ?>
	</p>

<?php else : ?>
	<p class="description">
		<?php esc_html_e( 'There are no post types.', 'multilang-perelink' ); ?>
	</p>
<?php endif; ?>
