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
class CC_Help_Tax_Targeted_Roles extends CC_Help_CPT_Tax {

	/**
	 * Set up the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->tax_name = cchelp_get_targeted_roles_tax_name();

		add_action( 'init', array( $this, 'register_taxonomy' ), 11 );

		// Call the parent and pass the file
		// parent::__construct( $file );
	}

	/**
	 * Creates the needed post type.
	 *
	 * @since    1.0.0
	 */
	public function register_taxonomy() {

		// Targeted Roles
		$labels = array(
			'name' => _x( 'Targeted Roles', 'cchelp_targeted_roles' ),
			'singular_name' => _x( 'Targeted Role', 'cchelp_targeted_roles' ),
			'search_items' => _x( 'Search Targeted Roles', 'cchelp_targeted_roles' ),
			'popular_items' => _x( 'Popular Targeted Roles', 'cchelp_targeted_roles' ),
			'all_items' => _x( 'All Targeted Roles', 'cchelp_targeted_roles' ),
			'parent_item' => _x( 'Parent Targeted Role', 'cchelp_targeted_roles' ),
			'parent_item_colon' => _x( 'Parent Targeted Role:', 'cchelp_targeted_roles' ),
			'edit_item' => _x( 'Edit Targeted Role', 'cchelp_targeted_roles' ),
			'update_item' => _x( 'Update Targeted Role', 'cchelp_targeted_roles' ),
			'add_new_item' => _x( 'Add New Targeted Role', 'cchelp_targeted_roles' ),
			'new_item_name' => _x( 'New Targeted Role', 'cchelp_targeted_roles' ),
			'separate_items_with_commas' => _x( 'Separate targeted roles with commas', 'cchelp_targeted_roles' ),
			'add_or_remove_items' => _x( 'Add or remove targeted roles', 'cchelp_targeted_roles' ),
			'choose_from_most_used' => _x( 'Choose from the most used targeted roles', 'cchelp_targeted_roles' ),
			'menu_name' => _x( 'Targeted Roles', 'cchelp_targeted_roles' ),
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_tagcloud' => true,
			'show_admin_column' => false,
			'hierarchical' => true,
			'rewrite' => true,
			'query_var' => true
		);

		register_taxonomy( $this->tax_name, array( $this->cpt_name ), $args );
	}
}