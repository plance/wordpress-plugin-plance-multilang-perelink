<?php
/**
 * Page.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $args['sites_data'] ) ) :
	return;
endif;

$sites_data            = $args['sites_data'];
$sites_ids_objects_ids = $args['sites_ids_objects_ids'] ?? array();
?>

<?php foreach ( $sites_data as $site ) : ?>
	<div class="plc-block">
		<div>
			<strong><?php echo esc_attr( $site['site_name'] ); ?>:</strong>
		</div>
		<div class="plc-block-fields | js-plc-block-fields">
			<?php if ( ! empty( $site['items'] ) ) : ?>

				<div class="plc-field-select">
					<select name="multilang_perelink_posts_ids[<?php echo esc_attr( $site['site_id'] ); ?>]" class="plc-field__select | js-plc-field__select">
						<option></option>
						<?php foreach ( $site['items'] as $post_loop ) : ?>
							<option
								value="<?php echo esc_attr( $post_loop['id'] ); ?>"
								data-edit-link="<?php echo esc_attr( $post_loop['edit_link'] ); ?>"
								<?php if ( ! empty( $sites_ids_objects_ids[ $site['site_id'] ] ) && $sites_ids_objects_ids[ $site['site_id'] ] == $post_loop['id'] ) : // phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison ?>
									selected
								<?php endif; ?>
								>
								<?php echo esc_attr( $post_loop['title'] ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="plc-field-link">
					<a
						class="js-plc-field__link"
						target="_blank"
						<?php
						if ( ! empty( $sites_ids_objects_ids[ $site['site_id'] ] ) ) :
							$site_post_id = $sites_ids_objects_ids[ $site['site_id'] ];

							if ( ! empty( $site['items'][ $site_post_id ]['edit_link'] ) ) :
								?>
								href="<?php echo esc_url( $site['items'][ $site_post_id ]['edit_link'] ); ?>"
							<?php else : ?>
								style="display: none;"
							<?php endif; ?>
						<?php else : ?>
							href="#"
							style="display: none;"
						<?php endif; ?>
						>
						✎
					</a>
				</div>
			<?php else : ?>
				<?php esc_html_e( 'Posts not found', 'plance-multilang-perelink' ); ?>
			<?php endif; ?>
		</div>
	</div>

<?php endforeach; ?>

<div class="plc-description">
	<p class="description">* <?php esc_html_e( 'Only posts with the status Published or Draft are displayed.', 'plance-multilang-perelink' ); ?></p>
</div>

<?php foreach ( $sites_ids_objects_ids as $site_id => $loop_post_id ) : ?>
	<input type="hidden" name="_multilang_perelink_posts_ids[<?php echo esc_attr( $site_id ); ?>]" value="<?php echo esc_attr( $loop_post_id ); ?>">
<?php endforeach; ?>
