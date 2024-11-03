<?php
/**
 * Actions.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;


use Plance\Plugin\Multilang_Perelink\Admin;
use Plance\Plugin\Multilang_Perelink\Assets;
use Plance\Plugin\Multilang_Perelink\Taxonomy;
use Plance\Plugin\Multilang_Perelink\Frontend;
use Plance\Plugin\Multilang_Perelink\Post_Type;
use Plance\Plugin\Multilang_Perelink\Shortcode;
use Plance\Plugin\Multilang_Perelink\Textdomain;
use Plance\Plugin\Multilang_Perelink\Dependency;
use Plance\Plugin\Multilang_Perelink\Admin_Settings;


add_action( 'plugins_loaded', array( Textdomain::class, 'instance' ) );
add_action( 'plugins_loaded', array( Frontend::class, 'instance' ) );
add_action( 'plugins_loaded', array( Shortcode::class, 'instance' ) );
add_action( 'plance_plugin_multilang_perelink_admin', array( Admin::class, 'instance' ) );
add_action( 'plance_plugin_multilang_perelink_admin', array( Assets::class, 'instance' ) );
add_action( 'plance_plugin_multilang_perelink_admin', array( Taxonomy::class, 'instance' ) );
add_action( 'plance_plugin_multilang_perelink_admin', array( Dependency::class, 'instance' ) );
add_action( 'plance_plugin_multilang_perelink_admin', array( Post_Type::class, 'instance' ) );
add_action( 'plance_plugin_multilang_perelink_admin', array( Admin_Settings::class, 'instance' ) );
