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
const FIELD_LINKING = '_plance_plugin_multilang_perelink';

define( __NAMESPACE__ . '\URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );


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

		$class     = str_replace( __NAMESPACE__ . '\\', '', $class );
		$class     = str_replace( '_', '-', strtolower( $class ) );
		$folders   = explode( '\\', $class );
		$classname = array_pop( $folders );

		$path = '';
		if ( ! empty( $folders ) ) {
			$path = join( DIRECTORY_SEPARATOR, $folders ) . DIRECTORY_SEPARATOR;
		}

		$prefixes = array( 'class' );
		foreach ( $prefixes as $prefix ) {
			$file_name = PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $path . $prefix . '-' . $classname . '.php';
			if ( file_exists( $file_name ) ) {
				require_once $file_name;
				return;
			}
		}
	}
);
