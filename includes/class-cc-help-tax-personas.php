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
class CC_Help_Tax_Personas extends CC_Help_CPT_Tax {

	/**
	 * @var string Name of taxonomy
	 */
	public $tax_name = 'cchelp_personas';

	/**
	 * Set up the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

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

		// Personas
		$labels = array(
			'name' => _x( 'Personas', 'cchelp_personas' ),
			'singular_name' => _x( 'Persona', 'cchelp_personas' ),
			'search_items' => _x( 'Search Personas', 'cchelp_personas' ),
			'popular_items' => _x( 'Popular Personas', 'cchelp_personas' ),
			'all_items' => _x( 'All Personas', 'cchelp_personas' ),
			'parent_item' => _x( 'Parent Persona', 'cchelp_personas' ),
			'parent_item_colon' => _x( 'Parent Persona:', 'cchelp_personas' ),
			'edit_item' => _x( 'Edit Persona', 'cchelp_personas' ),
			'update_item' => _x( 'Update Persona', 'cchelp_personas' ),
			'add_new_item' => _x( 'Add New Persona', 'cchelp_personas' ),
			'new_item_name' => _x( 'New Persona', 'cchelp_personas' ),
			'separate_items_with_commas' => _x( 'Separate personas with commas', 'cchelp_personas' ),
			'add_or_remove_items' => _x( 'Add or remove personas', 'cchelp_personas' ),
			'choose_from_most_used' => _x( 'Choose from the most used personas', 'cchelp_personas' ),
			'menu_name' => _x( 'Personas', 'cchelp_personas' ),
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