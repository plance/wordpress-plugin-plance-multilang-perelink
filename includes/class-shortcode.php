<?php
/**
 * Shortcode class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

use Plance\Plugin\Multilang_Perelink\Helpers;
use Plance\Plugin\Multilang_Perelink\Languages;
use Plance\Plugin\Multilang_Perelink\Singleton;

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

		echo Helpers::template_theme( //phpcs:ignore
			'/shortcodes/default.php',
			array(
				'languages'      => Languages::instance()->get_page_languages(),
				'current_locale' => Helpers::get_current_site_locale(),
			)
		);
	}
}
