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
class CC_Help_Tax_Groups extends CC_Help_CPT_Tax {

	/**
	 * Set up the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->tax_name = cchelp_get_groups_tax_name();

		add_action( 'init', array( $this, 'register_taxonomy' ), 11 );

		// Add group taxonomy term when a group is created.
		add_action( 'groups_group_create_complete', array( $this, 'add_term' ) );
		// Remove group taxonomy term when a group is deleted.
		add_action( 'groups_delete_group', array( $this, 'delete_term' ) );

		// Add a note to the add screen.
		add_action( "{$this->tax_name}_add_form_fields",  array( $this, 'add_form_field'  ) );

		// Call the parent and pass the file
		// parent::__construct( $file );
	}

	/**
	 * Creates the needed post type.
	 *
	 * @since    1.0.0
	 */
	public function register_taxonomy() {

		// Help Groups
		$labels = array(
			'name' => _x( 'Groups', 'cc_help_groups' ),
			'singular_name' => _x( 'Group', 'cc_help_groups' ),
			'search_items' => _x( 'Search Groups', 'cc_help_groups' ),
			'popular_items' => _x( 'Popular Groups', 'cc_help_groups' ),
			'all_items' => _x( 'All Groups', 'cc_help_groups' ),
			'parent_item' => _x( 'Parent Group', 'cc_help_groups' ),
			'parent_item_colon' => _x( 'Parent Group:', 'cc_help_groups' ),
			'edit_item' => _x( 'Edit Group', 'cc_help_groups' ),
			'update_item' => _x( 'Update Group', 'cc_help_groups' ),
			'add_new_item' => _x( 'Add New Group', 'cc_help_groups' ),
			'new_item_name' => _x( 'New Group', 'cc_help_groups' ),
			'separate_items_with_commas' => _x( 'Separate groups with commas', 'cc_help_groups' ),
			'add_or_remove_items' => _x( 'Add or remove groups', 'cc_help_groups' ),
			'choose_from_most_used' => _x( 'Choose from the most used groups', 'cc_help_groups' ),
			'menu_name' => _x( 'Groups', 'cc_help_groups' ),
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
	 * Output the form field for this metadata when adding a new term
	 * Override this in the extension class if you need different behavior.
	 *
	 * @since 1.0.0
	 */
	public function add_form_field() {
		?>

		<p class="info">"Missing" terms are generated when the CC Help plugin is activated. If this list has gotten out of sync with the active hubs list, deactivate &amp; reactivate the plugin to fill out the list.</div>

		<?php
	}

	/**
	 * Add group taxonomy term when a group is created.
	 *
	 * @since 1.0.0
	 *
	 * @param int $group_id ID of new group.
	 */
	public function add_term( $group_id ) {
	    $group = groups_get_group( array( 'group_id' => $group_id ) );

	    if ( class_exists( 'BP_Groups_Hierarchy' ) ) {
	        $hierarchy_group = new BP_Groups_Hierarchy( $group_id );
	        if ( $hierarchy_group->parent_id == 0 ) {
	            $retval = wp_insert_term( $group->name, $this->tax_name, array( 'slug' => cchelp_get_group_tax_slug( $group_id ) ) );
	        }
	    } else {
	        // If no hierarchy, all are top level
	       $retval = wp_insert_term( $group->name, $this->tax_name, array( 'slug' => cchelp_get_group_tax_slug( $group_id ) ) );
	    }

	    return $retval;
	}

	/**
	 * Remove group taxonomy term when a group is deleted.
	 *
	 * @since 1.0.0
	 *
	 * @param int $group_id ID of deleted group.
	 */
	public function delete_term( $group_id ) {
		$term = get_term_by( 'slug', cchelp_get_group_tax_slug( $group_id ), $this->tax_name );
		return wp_delete_term( $term->term_id, $this->tax_name );
	}
}