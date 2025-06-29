<?php
/**
 * Shortcode class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

/**
 * Shortcode class.
 */
class Shortcode {
	use Singleton;

	/**
	 * Init.
	 *
	 * @return void
	 */
	protected function init() {
		add_shortcode( 'multilang_perelink_languages', array( $this, 'shortcode' ) );
	}

	/**
	 * Shortcode.
	 *
	 * @return void
	 */
	public function shortcode() {
		load_template(
			PATH . '/templates/shortcodes/default.php',
			false,
			array(
				'languages'      => Languages::instance()->get_page_languages(),
				'current_locale' => Helpers::get_current_site_locale(),
			)
		);
	}
}
