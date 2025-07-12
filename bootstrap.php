<?php
/**
 * Bootstrap.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;


const PATH          = __DIR__;
const VERSION       = '1.0.0';
const SECURITY      = 'plance_plugin_multilang_perelink__xyz';
const SECURITY_NAME = '_plance_plugin_multilang_perelink_nonce';
const FIELD_LINKING = '_plance_plugin_multilang_perelink';

define( 'PLANCE_PLUGIN_MULTILANG_PERELINK_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );


add_action(
	'plugins_loaded',
	function() {
		if ( is_admin() ) {
			do_action( 'plance_plugin_multilang_perelink_admin' );
		}
	},
	-1
);


/**
 * Autoload plugin classes.
 */
spl_autoload_register(
	function ( $class ) {
		if ( strpos( $class, __NAMESPACE__ . '\\' ) !== 0 ) {
			return;
		}

		$pieces    = explode( '\\', $class );
		$classname = array_pop( $pieces );
		$file_name = 'class-' . str_replace( '_', '-', strtolower( $classname ) );
		include_once PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $file_name . '.php';
	}
);
