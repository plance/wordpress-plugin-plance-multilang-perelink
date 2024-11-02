<?php
/**
 * Assets class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

use const Plance\Plugin\Multilang_Perelink\URL;
use Plance\Plugin\Multilang_Perelink\Helpers;
use Plance\Plugin\Multilang_Perelink\Singleton;

/**
 * Assets class.
 */
class Assets {
	use Singleton;

	/**
	 * Init.
	 *
	 * @return void
	 */
	protected function init() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Hook: admin_enqueue_scripts.
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts() {
		/** Project Style */
		wp_register_style(
			'plance-multilang-perelink',
			URL . '/assets/css/admin-style.css',
			array(),
			Helpers::get_version()
		);
		wp_register_script(
			'plance-multilang-perelink',
			URL . '/assets/js/admin-javascript.js',
			array(
				'vendor-select2',
			),
			Helpers::get_version(),
			true
		);

		/** Vendors */
		wp_register_style(
			'vendor-select2',
			URL . '/assets/vendors/select2/select2.min.css',
			array(),
			Helpers::get_version()
		);

		wp_register_script(
			'vendor-select2',
			URL . '/assets/vendors/select2/select2.min.js',
			array(
				'jquery',
			),
			Helpers::get_version(),
			true
		);
	}
}
