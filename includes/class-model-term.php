<?php
/**
 * Model_Term class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

use const Plance\Plugin\Multilang_Perelink\FIELD_LINKING;
use Plance\Plugin\Multilang_Perelink\Singleton;

/**
 * Model_Term class.
 */
class Model_Term extends Base_Model {
	use Singleton;

	/**
	 * Return data.
	 *
	 * @param  int $id ID.
	 * @return array
	 */
	public function get_linking( $id ) {
		return array_filter( (array) get_term_meta( $id, FIELD_LINKING, true ) );
	}

	/**
	 * Update data.
	 *
	 * @param  int   $id   ID.
	 * @param  array $data Data.
	 * @return void
	 */
	public function update_linking( $id, $data ) {
		update_term_meta( $id, FIELD_LINKING, $data );
	}

	/**
	 * Return model data.
	 *
	 * @param  string $taxonomy Type.
	 * @return array
	 */
	public function get_data( $taxonomy ) {
		if ( empty( $taxonomy ) ) {
			return array();
		}

		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
				'number'     => 'all',
				'orderby'    => 'name',
				'order'      => 'ASC',
			)
		);

		if ( empty( $terms ) ) {
			return array();
		}

		$result = array();
		foreach ( $terms as $term ) {
			$result[ $term->term_id ] = array(
				'id'        => $term->term_id,
				'title'     => sprintf( '#%s %s', $term->term_id, $term->name ),
				'edit_link' => get_edit_term_link( $term->term_id, $taxonomy ),
			);
		}

		return $result;
	}

	/**
	 * Check exist data by id or not.
	 *
	 * @param  int    $id       ID.
	 * @param  string $taxonomy Type.
	 * @return bool
	 */
	public function exist_data( $id, $taxonomy ) {
		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
				'include'    => $id,
				'number'     => 1,
			)
		);

		if ( is_wp_error( $terms ) ) {
			return false;
		}

		return ! empty( $terms );
	}
}
