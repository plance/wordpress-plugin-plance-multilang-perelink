<?php
/**
 * Base_Model class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

/**
 * Base_Model class.
 */
abstract class Base_Model {
	/**
	 * Return data.
	 *
	 * @param  int $id ID.
	 * @return array
	 */
	abstract public function get_linking( $id );

	/**
	 * Update data.
	 *
	 * @param  int   $id   ID.
	 * @param  array $data Data.
	 * @return void
	 */
	abstract public function update_linking( $id, $data );

	/**
	 * Return model data.
	 *
	 * @param  string $type Type.
	 * @return array
	 */
	abstract public function get_data( $type );

	/**
	 * Check exist data by id or not.
	 *
	 * @param  int    $id   ID.
	 * @param  string $type Type.
	 * @return bool
	 */
	abstract public function exist_data( $id, $type );
}
