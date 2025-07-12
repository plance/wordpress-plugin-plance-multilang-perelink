<?php
/**
 * Assets class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

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
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Hook: wp_enqueue_scripts.
	 *
	 * @return void
	 */
	public function wp_enqueue_scripts() {
		wp_register_script(
			'multilang-perelink',
			PLANCE_PLUGIN_MULTILANG_PERELINK_URL . '/assets/js/javascript.js',
			array(),
			Helpers::get_version(),
			true
		);
	}

	/**
	 * Hook: admin_enqueue_scripts.
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts() {
		/** Project Style */
		wp_enqueue_style(
			'multilang-perelink',
			PLANCE_PLUGIN_MULTILANG_PERELINK_URL . '/assets/css/admin-style.css',
			array(),
			Helpers::get_version()
		);
		wp_register_script(
			'multilang-perelink',
			PLANCE_PLUGIN_MULTILANG_PERELINK_URL . '/assets/js/admin-javascript.js',
			array(
				'vendor-select2',
			),
			Helpers::get_version(),
			true
		);

		/** Vendors */
		wp_register_style(
			'vendor-select2',
			PLANCE_PLUGIN_MULTILANG_PERELINK_URL . '/assets/vendors/select2/select2.min.css',
			array(),
			Helpers::get_version()
		);

		wp_register_script(
			'vendor-select2',
			PLANCE_PLUGIN_MULTILANG_PERELINK_URL . '/assets/vendors/select2/select2.min.js',
			array(
				'jquery',
			),
			Helpers::get_version(),
			true
		);
	}
}
