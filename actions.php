<?php
/**
 * Actions.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;


add_action( 'plugins_loaded', array( Frontend::class, 'instance' ) );
add_action( 'plugins_loaded', array( Shortcode::class, 'instance' ) );
add_action( 'plance_plugin_multilang_perelink_admin', array( Admin::class, 'instance' ) );
add_action( 'plance_plugin_multilang_perelink_admin', array( Assets::class, 'instance' ) );
add_action( 'plance_plugin_multilang_perelink_admin', array( Taxonomy::class, 'instance' ) );
add_action( 'plance_plugin_multilang_perelink_admin', array( Dependency::class, 'instance' ) );
add_action( 'plance_plugin_multilang_perelink_admin', array( Post_Type::class, 'instance' ) );
add_action( 'plance_plugin_multilang_perelink_admin', array( Admin_Settings::class, 'instance' ) );
