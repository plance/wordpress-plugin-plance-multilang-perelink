<?php
/**
 * Page.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

defined( 'ABSPATH' ) || exit;

use Plance\Plugin\Multilang_Perelink\Admin_Settings;
?>

<div class="wrap">
	<h2><?php esc_html_e( 'Multilang Perelink', 'multilang-perelink' ); ?></h2>

	<form action="options.php" method="post">
		<?php settings_fields( Admin_Settings::GROUP ); ?>
		<?php do_settings_sections( Admin_Settings::SLUG ); ?>

		<?php submit_button(); ?>
	</form>
</div>
