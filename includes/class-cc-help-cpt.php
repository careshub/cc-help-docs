<?php

/**
 * The file that defines the custom post type we'll need for this plugin.
 *
 *
 * @link       http://www.communitycommons.org
 * @since      1.0.0
 *
 * @package    CC_Help
 * @subpackage CC_Help/includes
 */

/**
 * Define the custom post type and taxonomy we'll need for this plugin.
 *
 *
 * @since      1.0.0
 * @package    CC_Help
 * @subpackage CC_Help/includes
 * @author     David Cavins
 */
class CC_Help_CPT extends CC_Help_CPT_Tax {

	/**
	 * Set up the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'register_cpt' ), 11 );

		// Call the parent and pass the file
		// parent::__construct( $file );
	}

	/**
	 * Creates the needed post type.
	 *
	 * @since    1.0.0
	 */
	public function register_cpt() {

		$labels = array(
			'name' => _x( 'Help Content', 'cchelp' ),
			'singular_name' => _x( 'Help Content', 'cchelp' ),
			'add_new' => _x( 'Add New', 'cchelp' ),
			'all_items' => _x( 'Help Content', 'cchelp' ),
			'add_new_item' => _x( 'Add New Help Content', 'cchelp' ),
			'edit_item' => _x( 'Edit Help Content', 'cchelp' ),
			'new_item' => _x( 'New Help Content', 'cchelp' ),
			'view_item' => _x( 'View Help Content', 'cchelp' ),
			'search_items' => _x( 'Search Help Content', 'cchelp' ),
			'not_found' => _x( 'No Help Content found', 'cchelp' ),
			'not_found_in_trash' => _x( 'No Help Content found in Trash', 'cchelp' ),
			'parent_item_colon' => _x( 'Parent Help Content:', 'cchelp' ),
			'menu_name' => _x( 'Help Content', 'cchelp' ),
		);

	    $args = array(
	        'labels' => $labels,
	        'hierarchical' => false,
	        'description' => 'Support documents',
	        // 'supports' => array( 'title', 'editor', 'comments', 'revisions', 'thumbnail' ),
	        'taxonomies' => array( 'cc_help_types', 'cc_help_topics', 'cc_help_groups', 'cchelp_targeted_roles' ),
	        'public' => false,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'menu_position' => 81,
	        'menu_icon' => 'dashicons-sos',
	        'show_in_nav_menus' => false,
	        'publicly_queryable' => true,
	        // 'exclude_from_search' => true,
	        'has_archive' => true,
	        // Enable this and flush permalinks to change the archive slug
   	        // 'rewrite' => array( 'slug' => 'support' ),
   	        'rewrite' => true,
	        'query_var' => true,
	        'can_export' => true,
	        'capability_type' => 'post'
	    );

		register_post_type( $this->cpt_name, $args );
	}
}