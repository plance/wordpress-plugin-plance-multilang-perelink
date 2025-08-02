<?php
/**
 * Languages class.
 *
 * @package Plance\Plugin\Multilang_Perelink
 */

namespace Plance\Plugin\Multilang_Perelink;

defined( 'ABSPATH' ) || exit;

use WP_Post;
use WP_Term;

/**
 * Languages class.
 */
class Languages {
	use Singleton;

	/**
	 * Languages.
	 *
	 * @var array
	 */
	private $languages;

	/**
	 * Return page languages.
	 *
	 * @return array
	 */
	public function get_page_languages() {
		if ( null !== $this->languages ) {
			return $this->languages;
		}

		if ( is_front_page() ) {

			if ( ! Settings::is_enable_home_page() ) {
				return;
			}

			$languages = Helpers::get_languages();
			$sites_ids = Helpers::get_sites(
				array(
					'fields' => 'ids',
					'public' => 1,
				)
			);

			foreach ( $sites_ids as $site_id ) {
				$this->add_language( $languages[ $site_id ], user_trailingslashit( get_blog_option( $site_id, 'siteurl' ) ) );
			}
		} elseif ( is_home() && ! is_front_page() ) {

			if ( ! Settings::is_enable_blog_page() ) {
				return;
			}

			$instance  = $this;
			$languages = Helpers::get_languages();

			$this->add_blog_page_to_language( $languages, get_current_blog_id() );

			Helpers::walk_sites(
				function( $site ) use ( $instance, $languages ) {
					$instance->add_blog_page_to_language( $languages, $site->blog_id );
				}
			);

		} elseif ( is_singular() ) {

			/** @var WP_Post $post */ // phpcs:ignore
			$post = get_queried_object();
			if ( ! $post instanceof WP_Post ) {
				return;
			}

			if ( ! in_array( $post->post_type, Settings::get_post_types(), true ) ) {
				return;
			}

			$sites_ids_posts_ids = Model_Post::instance()->get_linking( $post->ID );
			if ( empty( $sites_ids_posts_ids ) ) {
				return;
			}

			$instance  = $this;
			$languages = Helpers::get_languages();

			if ( ! empty( $languages[ get_current_blog_id() ] ) ) {
				$this->add_language( $languages[ get_current_blog_id() ], get_permalink( $post->ID ) );
			}

			Helpers::walk_sites(
				function( $site ) use ( $instance, $languages, $sites_ids_posts_ids ) {

					// Check lang for site.
					if ( empty( $languages[ $site->blog_id ] ) ) {
						return;
					}
					$language = $languages[ $site->blog_id ];

					// Check post for site.
					if ( empty( $sites_ids_posts_ids[ $site->blog_id ] ) ) {
						return;
					}
					$post_id = $sites_ids_posts_ids[ $site->blog_id ];

					$post_loop = get_post( $post_id );
					if ( ! $post_loop instanceof WP_Post ) {
						return;
					}

					if ( 'publish' !== $post_loop->post_status ) {
						return;
					}

					$url = get_permalink( $post_id );
					if ( empty( $url ) ) {
						return;
					}

					$instance->add_language( $language, $url );
				},
				array(
					'site__in' => array_keys( $sites_ids_posts_ids ),
				)
			);

		} elseif ( is_archive() ) {

			$term = get_queried_object();
			if ( ! $term instanceof WP_Term ) {
				return;
			}

			if ( ! in_array( $term->taxonomy, Settings::get_taxonomies(), true ) ) {
				return;
			}

			$sites_ids_terms_ids = Model_Term::instance()->get_linking( $term->term_id );
			if ( empty( $sites_ids_terms_ids ) ) {
				return;
			}

			$instance  = $this;
			$taxonomy  = $term->taxonomy;
			$languages = Helpers::get_languages();

			if ( ! empty( $languages[ get_current_blog_id() ] ) ) {
				$this->add_language( $languages[ get_current_blog_id() ], get_term_link( $term->term_id, $taxonomy ) );
			}

			Helpers::walk_sites(
				function( $site ) use ( $instance, $languages, $sites_ids_terms_ids, $taxonomy ) {

					// Check lang for site.
					if ( empty( $languages[ $site->blog_id ] ) ) {
						return;
					}
					$language = $languages[ $site->blog_id ];

					// Check post for site.
					if ( empty( $sites_ids_terms_ids[ $site->blog_id ] ) ) {
						return;
					}
					$term_id = $sites_ids_terms_ids[ $site->blog_id ];

					$term_loop = get_term_by( 'id', $term_id, $taxonomy );
					if ( ! $term_loop instanceof WP_Term ) {
						return;
					}

					$url = get_term_link( $term_loop->term_id, $term_loop->taxonomy );
					if ( empty( $url ) ) {
						return;
					}

					$instance->add_language( $language, $url );
				},
				array(
					'site__in' => array_keys( $sites_ids_terms_ids ),
				)
			);
		}

		$this->languages = Helpers::sorting_languages( $this->languages );

		return $this->languages;
	}

	/**
	 * Prin alternate link.
	 *
	 * @param  array  $data Data.
	 * @param  string $url  URL.
	 * @return self
	 */
	private function add_language( $data, $url ) {

		$data['url']                      = $url;
		$this->languages[ $data['code'] ] = $data;

		return $this;
	}

	/**
	 * Add Blog page to language.
	 *
	 * @param  array $languages Languages.
	 * @param  int   $blog_id Blog Id.
	 * @return void
	 */
	private function add_blog_page_to_language( $languages, $blog_id ) {
		// Check lang for site.
		if ( empty( $languages[ $blog_id ] ) ) {
			return;
		}

		$blog_page_id = get_blog_option( $blog_id, 'page_for_posts' );
		if ( empty( $blog_page_id ) ) {
			return;
		}

		$page = get_post( $blog_page_id );
		if ( ! $page instanceof WP_Post ) {
			return;
		}

		if ( 'publish' !== $page->post_status ) {
			return;
		}

		$url = get_permalink( $page->ID );
		if ( empty( $url ) ) {
			return;
		}

		$this->add_language( $languages[ $blog_id ], $url );
	}
}
