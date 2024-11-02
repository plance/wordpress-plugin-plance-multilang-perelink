<?php
/**
 * Admin class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

use Plance\Plugin\Multilang_Perelink\Singleton;

/**
 * Admin class.
 */
class Admin {
	use Singleton;

	/**
	 * Init.
	 *
	 * @return void
	 */
	protected function init() {
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );
	}

	/**
	 * Hook: admin_head.
	 *
	 * @return void
	 */
	public function admin_head() {
		global $post_type;

		if ( ! empty( $post_type ) ) {
			?>
				<style type="text/css">
					.column-multilang_perelink {
						width: 60px;
					}
				</style>
			<?php
		}
	}

	/**
	 * Hook: admin_body_class.
	 *
	 * @param  mixed $classes classes.
	 * @return string
	 */
	public function admin_body_class( $classes ) {

		$classes .= ' plance-plugin-multilang-perelink';

		return $classes;
	}
}
