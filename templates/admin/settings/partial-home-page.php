<?php
/**
 * Partial.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

defined( 'ABSPATH' ) || exit;

use Plance\Plugin\Multilang_Perelink\Settings;
?>

<label>
	<input
		type="checkbox"
		name="<?php echo esc_attr( Settings::FIELD_HOME_PAGE ); ?>"
		<?php checked( Settings::get_option( Settings::FIELD_HOME_PAGE ), Settings::VALUE_YES ); ?>
		value="yes">
	<?php esc_html_e( 'Perelinking home pages.', 'multilang-perelink' ); ?>
</label>
