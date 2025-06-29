<?php
/**
 * Taxonomy class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

use WP_Term;

/**
 * Taxonomy class.
 */
class Taxonomy {
	use Singleton;

	/**
	 * Taxonomies.
	 *
	 * @var array
	 */
	private $taxonomies = array();

	/**
	 * Entity_Interface.
	 *
	 * @var Entity_Interface
	 */
	private $entity_interface;

	/**
	 * Init.
	 *
	 * @return void
	 */
	protected function init() {
		$this->taxonomies       = Settings::get_taxonomies();
		$this->entity_interface = new Entity_Interface( Model_Term::instance() );

		add_action( 'pre_delete_term', array( $this, 'pre_delete_term' ), 10, 2 );

		foreach ( $this->taxonomies as $taxonomy ) {
			add_action( $taxonomy . '_add_form_fields', array( $this, 'add_form_fields' ) );
			add_action( $taxonomy . '_edit_form_fields', array( $this, 'edit_form_fields' ) );

			add_action( 'edited_' . $taxonomy, array( $this, 'edited_term' ) );

			add_filter( 'manage_edit-' . $taxonomy . '_columns', array( $this->entity_interface, 'manage_columns' ) );
			add_filter( 'manage_' . $taxonomy . '_custom_column', array( $this, 'manage_custom_column' ), 10, 3 );
		}
	}

	/**
	 * Hook: add_form_fields.
	 *
	 * @return void
	 */
	public function add_form_fields() {
		if ( ! Helpers::is_current_site_public() ) {
			return;
		}

		echo Helpers::template( '/admin/taxonomy-create.php' ); // phpcs:ignore
	}

	/**
	 * Hook: edit_form_fields.
	 *
	 * @param  WP_Term $term Term.
	 * @return void
	 */
	public function edit_form_fields( $term ) {
		global $taxonomy;

		if ( ! Helpers::is_current_site_public() ) {
			return;
		}

		echo $this->entity_interface->print_form( PATH . '/templates/admin/taxonomy-edit.php', $term->term_id, $taxonomy ); // phpcs:ignore
	}

	/**
	 * Hook: edited_term.
	 *
	 * @param  int $term_id Term ID.
	 * @return void
	 */
	public function edited_term( $term_id ) {
		if ( ! isset( $_POST['multilang_perelink_terms_ids'] ) ) { // phpcs:ignore
			return;
		}

		$input_perelink_new = Helpers::filter_input_list( 'multilang_perelink_terms_ids' );
		$input_perelink_old = Helpers::filter_input_list( '_multilang_perelink_terms_ids' );

		$this->entity_interface->save( $term_id, $input_perelink_new, $input_perelink_old );
	}

	/**
	 * Hook: pre_delete_term.
	 *
	 * @param  int    $term_id  Term ID.
	 * @param  string $taxonomy Taxonomy.
	 * @return void
	 */
	public function pre_delete_term( $term_id, $taxonomy ) {
		if ( ! in_array( $taxonomy, $this->taxonomies, true ) ) {
			return;
		}

		$this->entity_interface->before_delete( $term_id );
	}

	/**
	 * Manage custom column.
	 *
	 * @param  string $content     Content.
	 * @param  string $column_name Column name.
	 * @param  int    $term_id     Term ID.
	 * @return string
	 */
	public function manage_custom_column( $content, $column_name, $term_id ) {
		return $this->entity_interface->manage_custom_column( $column_name, $term_id );
	}
}
