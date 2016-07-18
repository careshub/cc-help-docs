<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://www.communitycommons.org
 * @since      1.0.0
 *
 * @package    CC_Help
 * @subpackage CC_Help/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    CC_Help
 * @subpackage CC_Help/includes
 * @author     David Cavins
 */
class CC_Help {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The plugin's slug.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_slug    The string that is the plugin's slug.
	 */
	protected $plugin_slug;

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'cc-help';
		$this->plugin_slug = 'cchelp';
		$this->version = cc_help_get_version();

		$this->load_dependencies();
		// $this->set_locale();
		$this->define_public_hooks();
		$this->define_admin_hooks();

		// Register the custom post type
		// $cpt_tax_class = new CC_Group_Pages_CPT_Tax();
		// add_filter( 'bp_init', array( $cpt_tax_class, 'register_cpt') );
		// // Register the custom taxonomy
		// add_filter( 'bp_init', array( $cpt_tax_class, 'register_taxonomy') );

		// // Add our templates to BuddyPress' template stack.
		// add_filter( 'bp_get_template_stack', array( $this, 'add_template_stack'), 10, 1 );

		// // Remove the shortcode filter on post edit, otherwise, shortcodes are
		// // consumed as though this is a display context.
		// add_action( 'bp_init', array( $this, 'remove_shortcode_filter_on_settings_screen' ), 11 );

		// // Catch saves.
		// add_action( 'bp_init', array( $this, 'save_post' ) );
		// // Modify permalinks so that they point to the story shown in the origin group.
		// add_filter( 'post_type_link', array( $this, 'permalink_filter'), 10, 2);

		// // Filter "map_meta_caps" to let our users do things they normally can't, like upload media.
		// add_action( 'bp_init', array( $this, 'add_mmc_filter') );

		// Only allow users to see their own items in the media library uploader.
		// This functionality is shared between several plugins and has been moved to a standalone plugin "CC Manage Media and Permissions"



	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the dashboard.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * Globally accessible functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/cc-help-functions.php';

		/**
		 * The classes responsible for setting up the custom post type and taxonomy.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cc-help-cpt-tax.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cc-help-cpt.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cc-help-tax-groups.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cc-help-tax-targeted-roles.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cc-help-tax-topics.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cc-help-tax-types.php';

		/**
		 * The class responsible for defining all actions that occur in the public side.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cc-help-public.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cc-help-admin.php';

		/**
		 * Views/template tags are in this file.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/views/cc-help-display.php';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		// $plugin_i18n = new CC_Group_Pages_i18n();
		// $plugin_i18n->set_domain( $this->get_plugin_name() );

		// add_action( 'plugins_loaded', array( $plugin_i18n, 'load_plugin_textdomain' ) );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new CC_Help_Admin();

		// Add meta boxes on the 'add_meta_boxes' hook.
		add_action( 'add_meta_boxes', array( $plugin_admin, 'add_meta_boxes' ) );

		// Save post meta on the 'save_post' hook.
		add_action( 'save_post', array( $plugin_admin, 'save_post_meta' ), 10, 2 );

		// add_action( 'wp_enqueue_scripts', array( $plugin_admin, 'enqueue_styles') );
		// add_action( 'wp_enqueue_scripts', array( $plugin_admin, 'enqueue_scripts') );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		// Create the custom post type
		$class_cpt = new CC_Help_CPT();

		// Create the many taxonomies.
		$class_tax_groups = new CC_Help_Tax_Groups();
		$class_tax_targeted_roles = new CC_Help_Tax_Targeted_Roles();
		$class_tax_topics = new CC_Help_Tax_Topics();
		$class_tax_types = new CC_Help_Tax_Types();


		$plugin_public = new CC_Help_Public();
		// Handle templates for this post type.
		// @TODO: Enable this when making live.
		add_filter( 'archive_template', array( $plugin_public, 'filter_archive_template' ) );
		// @TODO: Not using the single template yet. The site single template seems OK.
		// add_filter( 'single_template', array( $plugin_public, 'filter_single_template' ) );

		// We may want to apply some GET params to the query on the DVT archive.
		// @TODO: Enable this when making live.
		add_action( 'pre_get_posts', array( $plugin_public, 'filter_archive_query' ) );

		// Cleanup GET params upon submission.
		// @TODO: Enable this when making live.
		add_action( 'template_redirect', array( $plugin_public, 'reformat_get_string' ), 11 );

		// We want this archive to be full-width.
		add_filter( 'body_class', array( $plugin_public, 'filter_body_class' ), 78 );

		// Change the REST API response so that it includes important meta for data vis tools.
		// @TODO: Do this REST stuff if we end up making this page update via AJAX.
		// add_action( 'rest_api_init', array( $plugin_public, 'rest_read_meta' ) );

		/*
		 * Add the contact modal to the footer of every page.
		 * If you want to trigger the contact modal, give your anchor a class of "open-contact-modal"
		 */
		// @TODO: Not using the modal currently. Not a fan because of bad mobile behavior.
		// add_action( 'wp_footer', 'cchelp_output_contact_modal' );

		// Enqueue archive specific CSS styles.
		// @TODO: Enable this when making live.
		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_styles') );
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The slug of the plugin is the portion of the uri after the group name.
	 *
	 * @since     1.0.0
	 * @return    string    The slug used.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Create or update the taxonomy term specific to group.
	 *
 	 * @since     1.0.0
	 * @return    integer
	 */
	public function update_group_term( $group_id = false ) {
		$group_id = $group_id ? $group_id : bp_get_current_group_id();

		// Create a group object, using BP Group Hierarchy or not.
		$group_object = class_exists( 'BP_Groups_Hierarchy' ) ? new BP_Groups_Hierarchy( $group_id ) : groups_get_group( array( 'group_id' => $group_id ) );

		$group_name = $group_object->name;
		$term_args['description'] = 'Group pages for ' . $group_name;

		// Check for a term for this group's parent group, set a value for the term's 'parent' arg
		// Depends on BP_Group_Hierarchy being active
		if  ( ( $parent_group_id = $group_object->vars['parent_id'] )  &&
				( $parent_group_term = get_term_by( 'slug', $this->create_taxonomy_slug( $parent_group_id ), 'ccgp_related_groups' ) )
			) {
			$term_args['parent'] = (int) $parent_group_term->term_id;
		}

		if ( $existing_term_id = $this->get_group_term_id( $group_id ) ) {
			$term_args['name'] = $group_name;
			$result = wp_update_term( $existing_term_id, 'ccgp_related_groups', $term_args );
		} else {
			$term_args['slug'] = $this->create_taxonomy_slug( $group_id );
			$result = wp_insert_term( $group_name, 'ccgp_related_groups', $term_args );
		}
		return $result;
	}

	/**
	 * Get the taxonomy term specific to the group.
	 *
	 * @since     1.0.0
	 * @return integer
	 */
	public function get_group_term_id( $group_id = false ) {
		$group_id = ( $group_id ) ? $group_id : bp_get_current_group_id();

		if ( $term = get_term_by( 'slug', $this->create_taxonomy_slug( $group_id ), 'ccgp_related_groups' ) ) {
			return $term->term_id;
		} else {
			return false;
		}

	}

	/**
	 * Build the taxonomy slug.
	 *
	 * @since     1.0.0
	 * @return string
	 */
	public function create_taxonomy_slug( $group_id = false ) {
		$group_id = ( $group_id ) ?  $group_id : bp_get_current_group_id();
		return 'ccgp_related_group_' . $group_id;
	}

	/** TEMPLATE LOADER ************************************************/

	/**
	* Get the location of the template directory.
	*
	* @since 1.0.0
	*
	* @uses apply_filters()
	* @return string
	*/
	public function get_template_directory() {
		return apply_filters( 'ccgp_get_template_directory', plugin_dir_path( __FILE__ ) . '../public/templates' );
	}

	/**
	 * Add our templates to BuddyPress' template stack.
	 *
	 * @since    1.1.0
	 */
	public function add_template_stack( $templates ) {
	    // If we're on a page of our plugin, then we add our path to the
	    // template path array. This allows bp_get_template_part to work.
	    if ( $this->is_component() ) {
	    	$template_directory = trailingslashit( $this->get_template_directory() );
	    	// Add the template directory avoiding dupes
	    	if ( ! in_array( $template_directory, $templates ) ) {
		        $templates[] = $template_directory;
			}
	    }

	    return $templates;
	}
}