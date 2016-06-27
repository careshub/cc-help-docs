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
class CC_Help_Tax_Types extends CC_Help_CPT_Tax {

	/**
	 * Set up the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->tax_name = cchelp_get_types_tax_name();

		add_action( 'init', array( $this, 'register_taxonomy' ), 11 );

		// Add a filter dropdown to the help docs list table.
		add_action( 'restrict_manage_posts', array( $this, 'add_taxonomy_filter' ) );

		// Call the parent and pass the file
		// parent::__construct( $file );
	}

	/**
	 * Creates the needed post type.
	 *
	 * @since    1.0.0
	 */
	public function register_taxonomy() {

		// Help Types
		$labels = array(
			'name' => _x( 'Types', 'cc_help_types' ),
			'singular_name' => _x( 'Type', 'cc_help_types' ),
			'search_items' => _x( 'Search Types', 'cc_help_types' ),
			'popular_items' => _x( 'Popular Types', 'cc_help_types' ),
			'all_items' => _x( 'All Types', 'cc_help_types' ),
			'parent_item' => _x( 'Parent Type', 'cc_help_types' ),
			'parent_item_colon' => _x( 'Parent Type:', 'cc_help_types' ),
			'edit_item' => _x( 'Edit Type', 'cc_help_types' ),
			'update_item' => _x( 'Update Type', 'cc_help_types' ),
			'add_new_item' => _x( 'Add New Type', 'cc_help_types' ),
			'new_item_name' => _x( 'New Type', 'cc_help_types' ),
			'separate_items_with_commas' => _x( 'Separate types with commas', 'cc_help_types' ),
			'add_or_remove_items' => _x( 'Add or remove types', 'cc_help_types' ),
			'choose_from_most_used' => _x( 'Choose from the most used types', 'cc_help_types' ),
			'menu_name' => _x( 'Types', 'cc_help_types' ),
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_tagcloud' => true,
			'show_admin_column' => true,
			'hierarchical' => true,

			'rewrite' => true,
			'query_var' => true
		);

		register_taxonomy( $this->tax_name, array( $this->cpt_name ), $args );
	}

	/**
	 * Add a filter dropdown to the help docs list table.
	 *
	 * @since    1.0.0
	 */
	public function add_taxonomy_filter() {
		global $typenow;

		// Only show this filter on the cchelp post type.
		if ( $this->cpt_name == $typenow ) {

				$tax_obj = get_taxonomy( $this->tax_name );
				$tax_label = $tax_obj->labels->name;
				$terms = get_terms( $this->tax_name );
				if( $terms ) {
					echo "<select name='$this->tax_name' id='$this->tax_name' class='postform'>";
					echo "<option value=''>All $tax_label</option>";
					foreach ($terms as $term) {
						echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}
					echo "</select>";
			}
		}
	}
}