<?php
/**
 * Entity_Interface class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

use WP_Site;
use Exception;
use Plance\Plugin\Multilang_Perelink\Helpers;
use Plance\Plugin\Multilang_Perelink\Base_Model;

/**
 * Entity_Interface class.
 */
class Entity_Interface {

	/**
	 * Base Model.
	 *
	 * @var Base_Model
	 */
	private $model;

	/**
	 * Construct object.
	 *
	 * @param  Base_Model $model Model.
	 * @return void
	 */
	public function __construct( Base_Model $model ) {
		$this->model = $model;
	}

	/**
	 * Print form.
	 *
	 * @param  string $template Template.
	 * @param  int    $id       ID.
	 * @param  string $type     Type.
	 * @return void
	 */
	public function print_form( $template, $id, $type ) {
		$sites_data = array();
		Helpers::walk_sites(
			function( $site ) use ( $type, &$sites_data ) {
				$sites_data[ $site->blog_id ] = array(
					'site_id'   => $site->blog_id,
					'site_name' => $site->blogname,
					'items'     => $this->model->get_data( $type ),
				);
			}
		);

		wp_enqueue_style( 'vendor-select2' );
		wp_enqueue_style( 'plance-multilang-perelink' );
		wp_enqueue_script( 'plance-multilang-perelink' );

		echo Helpers::template( // phpcs:ignore
			$template,
			array(
				'sites_data'            => $sites_data,
				'sites_ids_objects_ids' => $this->model->get_linking( $id ),
			)
		);
	}

	/**
	 * Save linking.
	 *
	 * @param  int   $id                 ID.
	 * @param  array $input_perelink_new New.
	 * @param  array $input_perelink_old Old.
	 * @throws Exception Throw exception.
	 * @return void
	 */
	public function save( $id, $input_perelink_new, $input_perelink_old ) {
		global $wpdb;

		try {
			$wpdb->query( $wpdb->prepare( 'START TRANSACTION' ) ); // phpcs:ignore

			$this->model->update_linking( $id, $input_perelink_new );

			$input_perelink_new[ get_current_blog_id() ] = $id;

			if ( ! empty( $input_perelink_old ) ) {
				foreach ( $input_perelink_new as $site_id => $object_id ) {
					if ( isset( $input_perelink_old[ $site_id ] ) && $input_perelink_old[ $site_id ] == $object_id ) { // phpcs:ignore
						unset( $input_perelink_old[ $site_id ] );
					}
				}
			}

			Helpers::walk_sites(
				function( $site ) use ( $input_perelink_new, $input_perelink_old ) {
					/** @var WP_Site $site. */ // phpcs:ignore
					$site_id        = $site->blog_id;
					$clone_perelink = $input_perelink_new;

					// Add or Update perelink posts.
					if ( ! empty( $input_perelink_new[ $site_id ] ) ) {
						$update_object_id = $clone_perelink[ $site_id ];
						unset( $clone_perelink[ $site_id ] );
						$this->model->update_linking( $update_object_id, $clone_perelink );
					}

					// Delete perelined posts.
					if ( ! empty( $input_perelink_old[ $site_id ] ) ) {
						$delete_object_id = $input_perelink_old[ $site_id ];
						$this->model->update_linking( $delete_object_id, array() );
					}
				}
			);

			$wpdb->query( 'COMMIT' ); // phpcs:ignore
		} catch ( Exception $ex ) {
			$wpdb->query( 'ROLLBACK' ); // phpcs:ignore

			throw $ex;
		}
	}

	/**
	 * Delete linking before delete object.
	 *
	 * @param  int $id ID.
	 * @return void
	 */
	public function before_delete( $id ) {

		$current_site_id               = get_current_blog_id();
		$current_sites_ids_objects_ids = $this->model->get_linking( $id );

		Helpers::walk_sites(
			function( $site ) use ( $current_sites_ids_objects_ids, $current_site_id ) {
				/** @var WP_Site $site */ // phpcs:ignore
				$site_id = $site->blog_id;

				if ( ! empty( $current_sites_ids_objects_ids[ $site_id ] ) ) {
					$loop_object_id             = $current_sites_ids_objects_ids[ $site_id ];
					$loop_sites_ids_objects_ids = $this->model->get_linking( $loop_object_id );

					if ( array_key_exists( $current_site_id, $loop_sites_ids_objects_ids ) ) {
						unset( $loop_sites_ids_objects_ids[ $current_site_id ] );
						$this->model->update_linking( $loop_object_id, $loop_sites_ids_objects_ids );
					}
				}
			}
		);
	}

	/**
	 * Manage columns.
	 *
	 * @param  array $columns Columns.
	 * @return array
	 */
	public function manage_columns( $columns ) {
		$columns['multilang_perelink'] = 'Linking';

		return $columns;
	}

	/**
	 * Manage custom column.
	 *
	 * @param  string $column_name Column name.
	 * @param  int    $id          ID.
	 * @return string
	 */
	public function manage_custom_column( $column_name, $id ) {
		if ( 'multilang_perelink' === $column_name ) {
			$sites_ids_objects_ids = $this->model->get_linking( $id );
			if ( ! empty( $sites_ids_objects_ids ) ) {
				$sites_ids = array_keys( $sites_ids_objects_ids );
				$languages = Helpers::get_languages_by_sites_ids( $sites_ids );

				$content  = '';
				$content .= '<span title="' . sprintf( esc_attr( 'Connection established for sites ID: %s' ), join( ', ', $sites_ids ) ) . '">';
				$content .= join( ', ', $languages );
				$content .= '</span>';

				return $content;
			}

			return '—';
		}
	}
}
