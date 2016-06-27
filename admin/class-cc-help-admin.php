<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://www.communitycommons.org
 * @since      1.0.0
 *
 * @package    CC_Help
 * @subpackage CC_Help/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 *
 * @package    CC_Help
 * @subpackage CC_Help/admin
 * @author     David Cavins
 */
class CC_Help_Admin {

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

		add_filter( "manage_edit-{$this->post_type_name}_columns", array( $this, 'edit_admin_columns') );
		add_filter( "manage_{$this->post_type_name}_posts_custom_column", array( $this, 'manage_admin_columns'), 18, 2 );
		add_filter( "manage_edit-{$this->post_type_name}_sortable_columns", array( $this, 'register_sortable_columns' ) );
		add_action( 'pre_get_posts', array( $this, 'sortable_columns_orderby' ) );

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cc-group-pages-admin.css', array(), $this->version, 'all' );

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
	 * Add meta box to cchelp custom post type.
	 *
	 * @since    1.0.0
	 */
	public function add_meta_boxes() {
		add_meta_box(
			'cc_help_meta_box',                  // Unique ID
			esc_html__( 'Highlight', 'cc-help'), // Title
			array( $this, 'output_meta_box' ),   // Output callback
			'cchelp',                            // Post type to include on
			'normal',                            // Context
			'high'                               // Priority
		);
	}

	/**
	 * Display the meta box on the post type edit page in wp-admin.
	 *
	 * @since    1.0.0
	 */
	public function output_meta_box( $object, $box ) {
		global $post;
		$custom = get_post_custom( $post->ID );
		$cchelp_sticky = isset( $custom["cchelp_sticky"][0] ) ? $custom["cchelp_sticky"][0] : '';
		wp_nonce_field( basename( __FILE__ ), 'cchelp_sticky_nonce' );
		?>

		<label><input type="checkbox" id="cchelp_sticky" name="cchelp_sticky" value="sticky" <?php checked( $cchelp_sticky, 'sticky' ); ?>> Highlight on help page?</label>

		<?php
	}

	/**
	 * Save the meta box's post metadata.
	 *
	 * @since    1.0.0
	 *
	 * @param int $post_id ID of the post being saved
	 * @param obj $post    $post object of post being saved
	 */
	public function save_post_meta( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( $post->post_type != 'cchelp' ) {
			return;
		}

		// Verify the nonce before proceeding.
		if ( ! wp_verify_nonce( $_POST['cchelp_sticky_nonce'], basename( __FILE__ ) ) ) {
			return;
		}

		$metas = array( 'cchelp_sticky' );
		foreach ( $metas as $meta ) {
			if ( ! empty( $_POST[$meta] ) ) {
				update_post_meta($post->ID, $meta, sanitize_text_field( $_POST[$meta] ) );
			} else {
				delete_post_meta( $post->ID, $meta );
			}
		}
	}

	/**
	 * Change behavior of the Help Docs overview table by adding custom columns.
	 * - Handle output for "Highlighted" column.
	 *
	 * @since    1.0.0
	 *
	 * @return   array of columns to display
	 */
	public function edit_admin_columns( $columns ) {
		// Last column is Date.
		// We want to insert our new columns just before that.
		$entries = count( $columns );
		$opening_set = array_slice( $columns, 0, $entries - 1 );
		$closing_set = array_slice( $columns, - 1 );

		$insert_set = array(
			'cchelp_sticky' => __( 'Highlighted' ),
			);

		$columns = array_merge( $opening_set, $insert_set, $closing_set );

		return $columns;
	}

	/**
	 * Change behavior of the Help Docs overview table by adding custom columns.
	 * - Handle output for "Highlighted" column.
	 *
	 * @since    1.0.0
	 *
	 * @return   string content of custom columns
	 */
	public function manage_admin_columns( $column, $post_id ) {
		if ( $column == 'cchelp_sticky' ) {
			$sticky = get_post_meta( $post_id, 'cchelp_sticky', true );
			echo $sticky ? 'Yes' : '';
		}
	}

	/**
	 * Change behavior of the Help Docs overview table by adding custom columns.
	 * - Add sortability to "Highlighted" column.
	 *
	 * @since    1.0.0
	 *
	 * @return   array of columns to display
	 */
	public function register_sortable_columns( $columns ) {
		$columns['cchelp_sticky'] = 'cchelp_sticky';
		return $columns;
	}
	/**
	 * Change behavior of the Help Docs overview table by adding custom columns.
	 * - Define sorting query for "Highlighted" column.
	 *
	 * @since    1.0.0
	 *
	 * @return   alters $query variable by reference
	 */
	function sortable_columns_orderby( $query ) {
		if ( ! is_admin() ) {
			return;
		}

		$orderby = $query->get( 'orderby');
		if ( 'cchelp_sticky' == $orderby ) {
			$meta_query = array(
			    'relation' => 'OR',
			    array(
			        'key'=>'cchelp_sticky',
			        'compare' => 'EXISTS'
			    ),
			    array(
			        'key'=>'cchelp_sticky',
			        'compare' => 'NOT EXISTS'
			    )
			);
			$query->set( 'meta_query', $meta_query );
			$query->set( 'orderby', 'meta_value' );
		}
	}
}