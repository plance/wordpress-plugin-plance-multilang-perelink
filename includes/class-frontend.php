<?php
/**
 * Frontend class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

/**
 * Frontend class.
 */
class Frontend {
	use Singleton;

	/**
	 * Init.
	 *
	 * @return void
	 */
	protected function init() {
		add_action( 'wp_head', array( $this, 'wp_head' ) );
	}

	/**
	 * Hook: wp_head.
	 *
	 * @return void
	 */
	public function wp_head() {
		$languages = Languages::instance()->get_page_languages();
		if ( ! empty( $languages ) ) {
			foreach ( $languages as $language ) {
				$this->print_alternate( $language );
			}
		}
	}

	/**
	 * Print alternate link.
	 *
	 * @param  array $data Data.
	 * @return void
	 */
	private function print_alternate( $data ) {
		echo "\n";
		echo sprintf( '<link rel="alternate" hreflang="%s" href="%s" title="%s" />', esc_attr( $data['code'] ), esc_url( $data['url'] ), esc_attr( $data['code'] ) ); // phpcs:ignore
	}
}
