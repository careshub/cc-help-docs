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
class CC_Help_Tax_Topics extends CC_Help_CPT_Tax {

	/**
	 * @var array Info about meta fields to be created.
	 */
	public $meta_fields = array(
		'color' => array(
			'labels' => array(
				'singular'    => 'Color',
				'plural'      => 'Colors',
				'description' => 'Assign terms a custom color.',
			),
			'add_term_column' => true,
			'add_term_field'  => true,
			'term_field_type' => 'text',
		)
	);

	/**
	 * Set up the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->tax_name = cchelp_get_topic_tax_name();

		add_action( 'init', array( $this, 'register_taxonomy' ), 11 );

		// Add the styles and scripts for the color picker.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_colorpicker_scripts' ) );
		add_action( 'admin_head',            array( $this, 'output_color_style' ) );

		// Add columns to the term list table
		add_filter( "manage_edit-{$this->tax_name}_columns",  array( $this, 'add_column_header' ) );
		add_filter( "manage_{$this->tax_name}_custom_column", array( $this, 'add_column_value'  ), 10, 3 );

		// Add the form fields to the term screen.
		add_action( "{$this->tax_name}_add_form_fields",  array( $this, 'add_form_field'  ) );
		add_action( "{$this->tax_name}_edit_form_fields", array( $this, 'edit_form_field' ) );

		// Call the parent.
		parent::__construct();
	}

	/**
	 * Creates the needed post type.
	 *
	 * @since    1.0.0
	 */
	public function register_taxonomy() {

		// Help Topics
		$labels = array(
			'name' => _x( 'Topics', 'cc_help_topics' ),
			'singular_name' => _x( 'Topic', 'cc_help_topics' ),
			'search_items' => _x( 'Search Topics', 'cc_help_topics' ),
			'popular_items' => _x( 'Popular Topics', 'cc_help_topics' ),
			'all_items' => _x( 'All Topics', 'cc_help_topics' ),
			'parent_item' => _x( 'Parent Topic', 'cc_help_topics' ),
			'parent_item_colon' => _x( 'Parent Topic:', 'cc_help_topics' ),
			'edit_item' => _x( 'Edit Topic', 'cc_help_topics' ),
			'update_item' => _x( 'Update Topic', 'cc_help_topics' ),
			'add_new_item' => _x( 'Add New Topic', 'cc_help_topics' ),
			'new_item_name' => _x( 'New Topic', 'cc_help_topics' ),
			'separate_items_with_commas' => _x( 'Separate topics with commas', 'cc_help_topics' ),
			'add_or_remove_items' => _x( 'Add or remove topics', 'cc_help_topics' ),
			'choose_from_most_used' => _x( 'Choose from the most used topics', 'cc_help_topics' ),
			'menu_name' => _x( 'Topics', 'cc_help_topics' ),
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