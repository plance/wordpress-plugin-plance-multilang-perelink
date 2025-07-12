<?php
/**
 * Helpers class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

use WP_Site;
use Exception;

/**
 * Helpers class.
 */
final class Helpers {
	/**
	 * Return template.
	 *
	 * @param  string $path Path.
	 * @param  array  $args Args.
	 * @return string
	 */
	public static function template( $path, $args = array() ) {
		ob_start();

		load_template( PATH . '/templates' . $path, false, $args );

		return ob_get_clean();
	}

	/**
	 * Return theme template.
	 *
	 * @param  string $path Path.
	 * @param  array  $args Args.
	 * @return string
	 */
	public static function template_theme( $path, $args = array() ) {
		$template = locate_template(
			array(
				'plugins/plance-multilang-perelink' . $path,
			)
		);

		if ( ! $template ) {
			$template = PATH . '/templates' . $path;
		}

		ob_start();

		load_template( $template, false, $args );

		return ob_get_clean();
	}

	/**
	 * Return plugin version.
	 *
	 * @return string
	 */
	public static function get_version() {
		return VERSION . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '-' . time() : '' );
	}

	/**
	 * Walk by sites.
	 *
	 * @param  callable $callback Callback.
	 * @param  array    $args     Args.
	 * @throws Exception Throw exception.
	 * @return void
	 */
	public static function walk_sites( $callback, $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'site__in'             => array(),
				'exclude_current_site' => true,
			)
		);

		$current_blog_id = get_current_blog_id();
		$sites_args      = array(
			'fields' => 'ids',
			'public' => 1,
		);

		if ( true === $args['exclude_current_site'] ) {
			$sites_args['site__not_in'] = $current_blog_id;
		}

		if ( ! empty( $args['site__in'] ) ) {
			$sites_args['site__in'] = $args['site__in'];
		}

		$sites_ids = self::get_sites( $sites_args );

		try {

			foreach ( $sites_ids as $site_id ) {
				$site = get_blog_details( $site_id );
				if ( ! $site instanceof WP_Site ) {
					continue;
				}

				switch_to_blog( $site_id );

				call_user_func( $callback, $site );

				restore_current_blog();
			}
		} catch ( Exception $ex ) {
			switch_to_blog( $current_blog_id );

			throw $ex;
		}
	}

	/**
	 * Return languages.
	 *
	 * @return array
	 */
	public static function get_languages() {
		static $languages;

		if ( null !== $languages ) {
			return $languages;
		}

		$sites_ids = self::get_sites(
			array(
				'fields' => 'ids',
			)
		);

		$languages = array();
		foreach ( $sites_ids as $site_id ) {
			$locale = get_blog_option( $site_id, 'WPLANG' );
			if ( empty( $locale ) ) {
				$locale = 'en_US';
			}

			$slices = explode( '_', $locale, 2 );
			$code   = ! empty( $slices[0] ) ? $slices[0] : $locale;

			$full = $locale;
			if ( function_exists( 'locale_get_display_language' ) ) {
				$full = self::mb_ucfirst( locale_get_display_language( $locale, $locale ) );
			}

			$languages[ $site_id ] = array(
				'code'     => $code,
				'locale'   => $locale,
				'language' => $full,
			);
		}

		return self::sorting_languages( $languages );
	}

	/**
	 * Return current site locale.
	 *
	 * @return string
	 */
	public static function get_current_site_locale() {
		return get_blog_option( get_current_blog_id(), 'WPLANG' );
	}

	/**
	 * Return languages by sites ids.
	 *
	 * @param  int[] $sites_ids Sites ids.
	 * @return array
	 */
	public static function get_languages_by_sites_ids( $sites_ids ) {
		$languages = self::get_languages();

		$restul = array();
		foreach ( $sites_ids as $site_id ) {
			if ( ! empty( $languages[ $site_id ] ) ) {
				$restul[] = $languages[ $site_id ]['code'];
			} else {
				$restul[] = __( 'undefined', 'multilang-perelink' );
			}
		}

		return $restul;
	}

	/**
	 * Check current site public or not.
	 *
	 * @return bool
	 */
	public static function is_current_site_public() {
		if ( ! function_exists( 'get_site' ) ) {
			return false;
		}

		$site = get_site();

		if ( ! $site instanceof WP_Site ) {
			return false;
		}

		if ( '0' === $site->public ) {
			return false;
		}

		return true;
	}

	/**
	 * Ucfirst.
	 *
	 * @param  mixed $string String.
	 * @param  mixed $encoding Encoding.
	 * @return string
	 */
	public static function mb_ucfirst( $string, $encoding = 'UTF-8' ) {

		if ( ! function_exists( 'mb_strtoupper' ) ) {
			return $string;
		}

		$first_char     = mb_strtoupper( mb_substr( $string, 0, 1, $encoding ), $encoding );
		$rest_of_string = mb_substr( $string, 1, null, $encoding );

		return $first_char . $rest_of_string;
	}

	/**
	 * Sorting languages.
	 *
	 * @param  array $languages Languages.
	 * @return array
	 */
	public static function sorting_languages( $languages ) {
		if ( empty( $languages ) ) {
			return array();
		}

		uasort(
			$languages,
			function( $a, $b ) {
				return strcmp( $a['language'], $b['language'] );
			}
		);

		return $languages;
	}

	/**
	 * Retrieves a list of sites matching requested arguments.
	 *
	 * @param string|array $args Optional.
	 * @return WP_Site[]|int[]|int List of WP_Site objects.
	 */
	public static function get_sites( $args = array() ) {
		if ( ! function_exists( 'get_sites' ) ) {
			return array();
		}

		return get_sites( $args );
	}
}
