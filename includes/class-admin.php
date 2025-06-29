<?php
/**
 * Admin class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

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
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );
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
