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
		name="<?php echo esc_attr( Settings::FIELD_HOMEPAGE ); ?>"
		<?php checked( Settings::get_option( Settings::FIELD_HOMEPAGE ), 'yes' ); ?>
		value="yes">
	<?php esc_html_e( 'Perelinking homepages.', 'plance-multilang-perelink' ); ?>
</label>
