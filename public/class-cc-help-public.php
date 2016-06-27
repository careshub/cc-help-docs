<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://www.communitycommons.org
 * @since      1.0.0
 *
 * @package    CC_Help
 * @subpackage CC_Help/public
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 *
 * @package    CC_Help
 * @subpackage CC_Help/public
 * @author     David Cavins
 */
class CC_Help_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name = 'cc-help';

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 *
	 * Name of the CPT we're using.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $post_type_name = 'cchelp';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->version = cc_help_get_version();

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		if ( is_post_type_archive( $this->post_type_name ) ) {
			wp_enqueue_style( 'public-' . $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/public.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cc-group-pages-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Filter the archive template used to output the cchelp archive.
	 *
	 * @since    1.0.0
	 */
	public function filter_archive_template( $archive_template ) {
		 if ( is_post_type_archive( $this->post_type_name ) ) {
			  $archive_template = dirname( __FILE__ ) . '/templates/archive-template.php';
		 }
		 return $archive_template;
	}

	/**
	 * Filter the single template used to output the cchelp single item view.
	 *
	 * @since    1.0.0
	 */
	public function filter_single_template( $single_template ) {
		 if ( $this->post_type_name == get_post_type() ) {
			  $single_template = dirname( __FILE__ ) . '/templates/single-template.php';
		 }
		 return $single_template;
	}

	/**
	 * Use GET params to modify the archive query.
	 *
	 * @since    1.0.0
	 */
	public function filter_archive_query( $wp_query_obj ) {
		if ( ! is_admin() && $wp_query_obj->is_post_type_archive( $this->post_type_name ) && $wp_query_obj->is_main_query() ) {

			$cchelp_tax_queries = array();
			$cchelp_meta_query = array();
			$topics_to_include = array();

			// Check for topic filter.
			if ( isset( $_REQUEST['guidebook'] ) ) {
			   $topics_to_include = cchelp_get_archive_topic_param();

			   if ( ! empty( $topics_to_include ) ) {
					$cchelp_tax_queries[] = array(
						'taxonomy' => cchelp_get_topic_tax_name(),
						'field'    => 'id',
						'terms'    => $topics_to_include,
						'operator' => 'IN',
					);
			   }
			}

			// If no topic has been selected, let's get the highlighted items.
			if ( ! $topics_to_include ) {
				$meta_query = $wp_query_obj->get('meta_query');
				if ( ! $meta_query ) {
					$meta_query = array();
				}
				$custom_meta_query = array(
					array(
						'key' => 'cchelp_sticky',
				) );
				$wp_query_obj->set( 'meta_query', array_merge( $meta_query, $custom_meta_query ) );
			}

			// Exclude some posts that are group specific or targeted at group admins/mods.
			// Skip these checks if this is a site admin user.
			if ( ! bp_current_user_can( 'bp_moderate' ) ) {
				/**
				 * We want to find posts hich are not group-related
				 * or posts associated with a group the user belongs to.
				 */

				// Find posts not related to any group.
				$cchelp_tax_not_group_related_query = array(
					'taxonomy' => cchelp_get_groups_tax_name(),
					'operator' => 'NOT EXISTS',
				);

				// Which groups does the user belong to?
				$user_id = bp_loggedin_user_id();
				$user_groups = bp_get_user_groups( $user_id, array(
					'is_admin' => null,
					'is_mod' => null,
				) );

				$user_group_ids = array_keys( $user_groups );
				if ( ! empty( $user_group_ids ) ) {
					$in_group_term_slugs = array_map( 'cchelp_get_group_tax_slug', $user_group_ids );
					// We have to exclude the posts in these terms
					$cchelp_tax_queries[] = array(
						'relation'     => 'OR',
						array(
							'taxonomy' => cchelp_get_groups_tax_name(),
							'field'    => 'slug',
							'terms'    => $in_group_term_slugs,
							'operator' => 'IN',
						),
						$cchelp_tax_not_group_related_query,
					);
				} else {
					// The user belongs to no groups.
					$cchelp_tax_queries[] = $cchelp_tax_not_group_related_query;
				}

				// Should this user see admin/mod targeted items?
				$exclude_role_terms = array();
				$admin_of_groups = bp_get_user_groups( $user_id, $args = array( 'is_admin' => true ) );
				if ( empty( $admin_of_groups ) ) {
					$exclude_role_terms[] = 'administrators';
				}
				$mod_of_groups = bp_get_user_groups( $user_id, $args = array( 'is_mod' => true ) );
				if ( empty( $mod_of_groups ) ) {
					$exclude_role_terms[] = 'moderators';
				}
				if ( $exclude_role_terms ) {
					// We have to exclude the posts in these terms
					$cchelp_tax_queries[] = array(
						'taxonomy' => cchelp_get_targeted_roles_tax_name(),
						'field'    => 'slug',
						'terms'    => $exclude_role_terms,
						'operator' => 'NOT IN',
					);
				}
			}

			// If there's something to do, tack 'em on to the existing tax_query.
			if ( $cchelp_tax_queries ) {
				$tax_query = $wp_query_obj->get( 'tax_query' );
				if ( ! $tax_query ) {
					$tax_query = array();
				}
				$wp_query_obj->set( 'tax_query', array_merge( $tax_query, $cchelp_tax_queries ) );
			}

		}
	}

	/**
	 * Cleanup GET params upon submission.
	 *
	 * @since    1.0.0
	 */
	public function reformat_get_string() {
		if ( is_post_type_archive( $this->post_type_name ) ) {
			if ( isset( $_GET ) && ! empty( $_GET ) ) {
				$cleaned = array();
				$params = '?';
				// We only want to redirect if there was cleanup to do.
				$redirect = false;
				$i = 0;
				foreach ( $_GET as $key => $value ) {
					if ( $i > 0 ) {
						$params .= '&';
					}
					if ( is_array( $value ) ) {
						foreach ( $value as $k => $v ) {
							$value[$k] = urlencode( $v );
						}
						$params .= $key . '=' . implode(',', $value );
						$redirect = true;
					} else {
						$params .= $key . '=' . urlencode( $value );
					}
					$i++;
				}

				if ( $redirect ) {
					wp_safe_redirect( get_post_type_archive_link( $this->post_type_name ) . $params );
					exit;
				}
			}
		}
	}

	/**
	 * We want this archive to be full-width.
	 *
	 * @since    1.0.0
	 */
	public function filter_body_class( $classes ) {
		if ( is_post_type_archive( $this->post_type_name ) ) {
			if ( ! in_array( 'full-width', $classes ) ) {
				$classes[] = 'full-width';
			}
		}
		return $classes;
	}

	/**
	 * Change the REST API response so that it includes important meta for ticker items.
	 *
	 * @since    1.6.0
	 *
	 * @return   void
	 */
	public function rest_read_meta() {
		// register_rest_field( $this->post_type_name,
		// 	'ccdvt_link',
		// 	array(
		// 		'get_callback'    => array( $this, 'get_meta_for_rest_api' ),
		// 		'update_callback' => null,
		// 		'schema'          => null,
		// 	)
		// );
		// register_rest_field( $this->post_type_name,
		// 	'tool_type',
		// 	array(
		// 		'get_callback'    => array( $this, 'get_item_type_rest_api' ),
		// 		'update_callback' => null,
		// 		'schema'          => null,
		// 	)
		// );
		// register_rest_field( $this->post_type_name,
		// 	'ccdvt_thumbnail',
		// 	array(
		// 		'get_callback'    => array( $this, 'get_thumbnail_rest_api' ),
		// 		'update_callback' => null,
		// 		'schema'          => null,
		// 	)
		// );
		// register_rest_field( $this->post_type_name,
		// 	'post_classes',
		// 	array(
		// 		'get_callback'    => array( $this, 'get_post_classes_rest_api' ),
		// 		'update_callback' => null,
		// 		'schema'          => null,
		// 	)
		// );
	}

	/**
	 * Get the value of the requested meta field.
	 *
	 * @param array $object Details of current post.
	 * @param string $field_name Name of field.
	 * @param WP_REST_Request $request Current request
	 *
	 * @return mixed
	 */
	public function get_meta_for_rest_api( $object, $field_name, $request ) {
	   // $towrite = PHP_EOL . 'get_meta_for_rest_api, $object: ' . print_r( $object, TRUE );
	   // $towrite .= PHP_EOL . 'field_name: ' . print_r( $field_name, TRUE );
	   // $towrite .= PHP_EOL . 'request: ' . print_r( $request, TRUE );
	   // $fp = fopen('dvt_rest.txt', 'a');
	   // fwrite($fp, $towrite);
	   // fclose($fp);
		return get_post_meta( $object[ 'id' ], $field_name, true );
	}

	/**
	 * Get the value of the requested meta field.
	 *
	 * @param array $object Details of current post.
	 * @param string $field_name Name of field.
	 * @param WP_REST_Request $request Current request
	 *
	 * @return mixed
	 */
	public function get_item_type_rest_api( $object, $field_name, $request ) {
		// Set a default value.
		$value = array(
				'term_id' => 0,
				'name' => 'Map',
				'slug' => 'map',
			);
		$terms = get_the_terms( $object[ 'id' ], 'data_vis_tool_type' );
		if ( is_array( $terms ) ) {
			$term = current( $terms );
			$value = array(
				'term_id' => $term->term_id,
				'name' => $term->name,
				'slug' => $term->slug,
			);
		}
		return $value;
	}

	/**
	 * Get the thumbnail markup for an item.
	 *
	 * @param array $object Details of current post.
	 * @param string $field_name Name of field.
	 * @param WP_REST_Request $request Current request
	 *
	 * @return mixed
	 */
	public function get_thumbnail_rest_api( $object, $field_name, $request ) {
		return ccdvt_get_the_thumbnail( $object[ 'id' ] ) ;
	}

	/**
	 * Get the post classes for an item.
	 *
	 * @param array $object Details of current post.
	 * @param string $field_name Name of field.
	 * @param WP_REST_Request $request Current request
	 *
	 * @return mixed
	 */
	public function get_post_classes_rest_api( $object, $field_name, $request ) {
		return join( ' ', get_post_class( array( 'data-vis-tool', 'clear' ), $object[ 'id' ] ) );
	}

}