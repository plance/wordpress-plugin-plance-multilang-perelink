<?php
/**
 * Admin_Settings class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

/**
 * Admin_Settings class.
 */
class Admin_Settings {
	use Singleton;

	const SLUG    = 'plance-multilang-perelink-settings';
	const GROUP   = 'plance-multilang-perelink-group-settings';
	const SECTION = 'plance-multilang-perelink-section-settings';

	/**
	 * Init.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_filter( 'plugin_action_links', array( $this, 'plugin_action_links' ), 10, 2 );
	}

	/**
	 * Settings tab general.
	 *
	 * @return void
	 */
	public function admin_init() {

		add_settings_section(
			self::SECTION,
			__( 'Settings', 'multilang-perelink' ),
			null,
			self::SLUG
		);

		register_setting(
			self::GROUP,
			Settings::FIELD_HOME_PAGE,
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		add_settings_field(
			Settings::FIELD_HOME_PAGE,
			__( 'Homepage', 'multilang-perelink' ),
			function() {
				load_template( PATH . '/templates/admin/settings/partial-home-page.php' );
			},
			self::SLUG,
			self::SECTION
		);

		register_setting(
			self::GROUP,
			Settings::FIELD_BLOG_PAGE,
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		add_settings_field(
			Settings::FIELD_BLOG_PAGE,
			__( 'Blog page', 'multilang-perelink' ),
			function() {
				load_template( PATH . '/templates/admin/settings/partial-blog-page.php' );
			},
			self::SLUG,
			self::SECTION
		);

		register_setting(
			self::GROUP,
			Settings::FIELD_POST_TYPES,
			array(
				'sanitize_callback' => array( $this, 'sanitize_string_array' ),
			)
		);
		add_settings_field(
			Settings::FIELD_POST_TYPES,
			__( 'Post types', 'multilang-perelink' ),
			function() {
				$post_types = get_post_types(
					array(
						'public' => true,
					),
					'objects'
				);

				if ( isset( $post_types['attachment'] ) ) {
					unset( $post_types['attachment'] );
				}

				load_template(
					PATH . '/templates/admin/settings/partial-post-types.php',
					false,
					array(
						'post_types'          => $post_types,
						'selected_post_types' => Settings::get_post_types(),
					)
				);
			},
			self::SLUG,
			self::SECTION
		);

		register_setting(
			self::GROUP,
			Settings::FIELD_TAXONOMIES,
			array(
				'sanitize_callback' => array( $this, 'sanitize_string_array' ),
			)
		);
		add_settings_field(
			Settings::FIELD_TAXONOMIES,
			__( 'Taxonomies', 'multilang-perelink' ),
			function() {
				$taxonomies = get_taxonomies(
					array(
						'public' => true,
					),
					'objects'
				);

				if ( isset( $taxonomies['post_format'] ) ) {
					unset( $taxonomies['post_format'] );
				}

				load_template(
					PATH . '/templates/admin/settings/partial-taxonomies.php',
					false,
					array(
						'taxonomies'          => $taxonomies,
						'selected_taxonomies' => Settings::get_taxonomies(),
					)
				);
			},
			self::SLUG,
			self::SECTION
		);
	}

	/**
	 * Add settings menu.
	 *
	 * @since    1.0.0
	 */
	public function admin_menu() {
		add_options_page(
			__( 'Multilang Perelink', 'multilang-perelink' ),
			__( 'Multilang Perelink', 'multilang-perelink' ),
			'manage_options',
			self::SLUG,
			function() {
				echo Helpers::template( '/admin/settings/page.php' ); //phpcs:ignore
			}
		);
	}

	/**
	 * Add plugin links.
	 *
	 * @param array  $links Links.
	 * @param string $file File.
	 *
	 * @return mixed
	 */
	public function plugin_action_links( $links, $file ) {
		if ( strpos( $file, '/multilang-perelink.php' ) === false ) {
			return $links;
		}

		$settings_link = '<a href="' . menu_page_url( self::SLUG, false ) . '">' . esc_html( __( 'Settings', 'multilang-perelink' ) ) . '</a>';

		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Sanitize string array.
	 *
	 * @param  array $input input data.
	 * @return array
	 */
	public function sanitize_string_array( $input ) {
		if ( ! is_array( $input ) ) {
			return array();
		}

		return array_map( 'sanitize_text_field', $input );
	}
}
