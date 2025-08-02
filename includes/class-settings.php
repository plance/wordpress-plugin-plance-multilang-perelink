<?php
/**
 * Settings class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

/**
 * Settings class.
 */
final class Settings {
	const FIELD_BLOG_PAGE  = '_plance_multilang_perelink__blogpage';
	const FIELD_HOME_PAGE  = '_plance_multilang_perelink__homepage';
	const FIELD_POST_TYPES = '_plance_multilang_perelink__post_types';
	const FIELD_TAXONOMIES = '_plance_multilang_perelink__taxonomies';

	const VALUE_YES = 'yes';

	/**
	 * Get attr option.
	 *
	 * @param string $option The option ID.
	 *
	 * @return string|bool
	 */
	public static function get_option( $option ) {
		return get_option( $option, false );
	}

	/**
	 * Enable home page for perelink.
	 *
	 * @return bool
	 */
	public static function is_enable_home_page() {
		return self::VALUE_YES === self::get_option( self::FIELD_HOME_PAGE );
	}

	/**
	 * Enable blog page for perelink.
	 *
	 * @return bool
	 */
	public static function is_enable_blog_page() {
		return self::VALUE_YES === self::get_option( self::FIELD_BLOG_PAGE );
	}

	/**
	 * Return allow post types.
	 *
	 * @return array
	 */
	public static function get_post_types() {
		return array_filter( (array) self::get_option( self::FIELD_POST_TYPES ) );
	}

	/**
	 * Return allow taxonomies.
	 *
	 * @return array
	 */
	public static function get_taxonomies() {
		return array_filter( (array) self::get_option( self::FIELD_TAXONOMIES ) );
	}
}
