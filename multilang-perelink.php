<?php
/**
 * Main plugin file.
 *
 * @package Plance\Plugin\Multilang_Perelink
 *
 * Plugin Name: Multilang Perelink
 * Description: Perelinking for a multilingual site
 * Plugin URI:  https://plance.top/
 * Version:     1.0.0
 * Author:      plance
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: multilang-perelink
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
