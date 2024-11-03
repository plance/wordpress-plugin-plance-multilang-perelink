<?php
/**
 * Main plugin file.
 *
 * @package Plance\Plugin\Multilang_Perelink
 *
 * Plugin Name: Multilang Perelink
 * Plugin URI:  https://wordpress.org/plugins/plance-multilang-perelink/
 * Description: Perelinking for a multilingual site
 * Version:     1.0.0
 * Author:      Pavel
 * Author       URI: https://plance.top/
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: plance-multilang-perelink
 * Domain Path: /languages/
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;


/**
 * Bootstrap.
 */
require __DIR__ . '/bootstrap.php';

/**
 * Actions.
 */
require __DIR__ . '/actions.php';
