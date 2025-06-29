<?php
/**
 * Model_Post class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

/**
 * Model_Post class.
 */
class Model_Post extends Base_Model {
	use Singleton;

	/**
	 * Return data.
	 *
	 * @param  int $id ID.
	 * @return array
	 */
	public function get_linking( $id ) {
		return array_filter( (array) get_post_meta( $id, FIELD_LINKING, true ) );
	}

	/**
	 * Update data.
	 *
	 * @param  int   $id   ID.
	 * @param  array $data Data.
	 * @return void
	 */
	public function update_linking( $id, $data ) {
		update_post_meta( $id, FIELD_LINKING, $data );
	}

	/**
	 * Return model data.
	 *
	 * @param  string $post_type Type.
	 * @return array
	 */
	public function get_data( $post_type ) {
		if ( empty( $post_type ) ) {
			return array();
		}

		$posts = get_posts(
			array(
				'post_type'   => $post_type,
				'post_status' => array( 'publish', 'draft' ),
				'numberposts' => -1,
				'orderby'     => 'title',
				'order'       => 'ASC',
			)
		);

		if ( empty( $posts ) ) {
			return array();
		}

		$result = array();
		foreach ( $posts as $post ) {
			$result[ $post->ID ] = array(
				'id'        => $post->ID,
				'title'     => sprintf( '#%s %s', $post->ID, $post->post_title ),
				'edit_link' => get_edit_post_link( $post->ID ),
			);
		}

		return $result;
	}

	/**
	 * Check exist data by id or not.
	 *
	 * @param  int    $id        ID.
	 * @param  string $post_type Type.
	 * @return bool
	 */
	public function exist_data( $id, $post_type ) {
		$posts = get_posts(
			array(
				'post_type'   => $post_type,
				'post_status' => 'any',
				'include'     => $id,
				'numberposts' => 1,
			)
		);

		return ! empty( $posts );
	}
}
