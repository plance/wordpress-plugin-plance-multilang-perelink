<?php
/**
 * Dependesy class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

/**
 * Dependesy class.
 */
class Dependency {
	use Singleton;

	/**
	 * Init.
	 *
	 * @return void
	 */
	protected function init() {
		if ( is_multisite() ) {
			return;
		}

		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Hook: admin_notices.
	 *
	 * @return void
	 */
	public function admin_notices() {
		?>
			<div class="notice notice-error">
				<p><?php esc_html_e( 'Plugin "Multilang Perelink" works only in multisite mode!', 'multilang-perelink' ); ?></p>
			</div>
		<?php
	}
}
