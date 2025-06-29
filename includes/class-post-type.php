<?php
/**
 * Post_Type class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

use WP_Post;

/**
 * Post_Type class.
 */
class Post_Type {
	use Singleton;

	/**
	 * Post types.
	 *
	 * @var array
	 */
	private $post_types = array();

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
		$this->post_types       = Settings::get_post_types();
		$this->entity_interface = new Entity_Interface( Model_Post::instance() );

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'before_delete_post', array( $this, 'before_delete_post' ), 10, 2 );

		foreach ( $this->post_types as $post_type ) {
			add_action( 'save_post_' . $post_type, array( $this, 'save_post' ) );

			add_filter( 'manage_' . $post_type . '_posts_columns', array( $this->entity_interface, 'manage_columns' ) );
			add_action( 'manage_' . $post_type . '_posts_custom_column', array( $this, 'manage_custom_column' ), 10, 2 );
		}
	}

	/**
	 * Hook: add_meta_boxes.
	 *
	 * @return void
	 */
	public function add_meta_boxes() {
		global $post_type;

		if ( ! Helpers::is_current_site_public() ) {
			return;
		}

		if ( ! in_array( $post_type, $this->post_types, true ) ) {
			return;
		}

		add_meta_box(
			'plance-plugin-multilang_perelink',
			__( 'Perelinks', 'multilang-perelink' ),
			array( $this, 'meta_boxes_callback' ),
			$this->post_types,
			'normal',
			'default'
		);
	}

	/**
	 * Hook: meta_boxes_callback.
	 *
	 * @return void
	 */
	public function meta_boxes_callback() {
		global $post, $post_type;

		echo $this->entity_interface->print_form( PATH . '/templates/admin/post-type.php', $post->ID, $post_type ); // phpcs:ignore
	}

	/**
	 * Hook: save_post.
	 *
	 * @param  int $post_id Post id.
	 * @return void
	 */
	public function save_post( $post_id ) {
		if (
			'list' === filter_input( INPUT_POST, 'post_view', FILTER_SANITIZE_FULL_SPECIAL_CHARS ) ||
			'list' === filter_input( INPUT_GET, 'post_view', FILTER_SANITIZE_FULL_SPECIAL_CHARS )
			) {
			return;
		}

		if ( ! isset( $_POST['multilang_perelink_posts_ids'] ) ) { // phpcs:ignore
			return;
		}

		$input_perelink_new = Helpers::filter_input_list( 'multilang_perelink_posts_ids' );
		$input_perelink_old = Helpers::filter_input_list( '_multilang_perelink_posts_ids' );

		$this->entity_interface->save( $post_id, $input_perelink_new, $input_perelink_old );
	}

	/**
	 * Hook: before_delete_post.
	 *
	 * @param  int     $post_id Post ID.
	 * @param  WP_Post $post    Post.
	 * @return void
	 */
	public function before_delete_post( $post_id, $post ) {

		if ( ! $post instanceof WP_Post ) {
			return;
		}

		if ( ! in_array( $post->post_type, $this->post_types, true ) ) {
			return;
		}

		$this->entity_interface->before_delete( $post_id );
	}

	/**
	 * Hook: manage_custom_column..
	 *
	 * @param  string $column_name Column name.
	 * @param  int    $post_id     Post ID.
	 * @return void
	 */
	public function manage_custom_column( $column_name, $post_id ) {
		echo $this->entity_interface->manage_custom_column( $column_name, $post_id ); // phpcs:ignore
	}
}
