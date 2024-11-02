<?php
/**
 * Main.
 *
 * @package Plance\Plugin\Multilang_Perelink
 *
 * Plugin Name: Multilang Perelink
 * Description: Perelinking for a multilingual site
 * Version: 1.0.0
 * Author: Pavel
 * Author URI: https://plance.top/
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
