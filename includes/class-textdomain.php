<?php
/**
 * Textdomain class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

use Plance\Plugin\Portfolio_Light\Singleton;

/**
 * Textdomain class.
 */
class Textdomain {
	use Singleton;

	/**
	 * Init.
	 *
	 * @return void
	 */
	protected function init() {
		load_plugin_textdomain( 'plance-multilang-perelink', false, '/plance-multilang-perelink/languages' );
	}
}
