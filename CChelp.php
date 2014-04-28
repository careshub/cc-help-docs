<?php
/*
Plugin Name: Community Commons Help Content
Version: Current Version
Author: Michael Barbaro
Description: This plugin creates a custom post type and taxonomies for CC Help content creation.
*/


add_action( 'init', 'register_cpt_cchelp' );

function register_cpt_cchelp() {

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
        'public' => true,
		'has_archive' => true,
        'show_ui' => true,
        'show_in_menu' => true
    );

    register_post_type( 'cchelp', $args );
}

add_action( 'init', 'register_taxonomy_cc_help_types' );

function register_taxonomy_cc_help_types() {

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
        'show_admin_column' => false,
        'hierarchical' => true,

        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'cc_help_types', array('cchelp'), $args );
}

add_action( 'init', 'register_taxonomy_cc_help_topics' );

function register_taxonomy_cc_help_topics() {

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

    register_taxonomy( 'cc_help_topics', array('cchelp'), $args );
}

add_action( 'init', 'register_taxonomy_cc_help_groups' );

function register_taxonomy_cc_help_groups() {

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
        'show_admin_column' => false,
        'hierarchical' => true,
        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'cc_help_groups', array('cchelp'), $args );	
	
}

add_action( 'init', 'register_taxonomy_cchelp_personas' );

function register_taxonomy_cchelp_personas() {

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

    register_taxonomy( 'cchelp_personas', array('cchelp'), $args );
}


add_action( 'init', 'register_taxonomy_cchelp_targeted_roles' );

function register_taxonomy_cchelp_targeted_roles() {

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

    register_taxonomy( 'cchelp_targeted_roles', array('cchelp'), $args );
}
	



//This action/function creates the initial list of groups in the taxonomy with parent-id = 0 (top-level only). Only should be run once.
// add_action( 'init', 'cchelp_add_initial_groups' );
// function cchelp_add_initial_groups()
// {	
    // if ( bp_has_groups( 'per_page=1000' ) ) :
    //         while ( bp_groups() ) : bp_the_group();             
    //             $group = new BP_Groups_Hierarchy( bp_get_group_id() );
    //             if ( (int) $group->vars['parent_id'] == 0 ) {
    //                 wp_insert_term( bp_get_group_name(), 'cc_help_groups', array('slug' => 'ccgroup-association-' . bp_get_group_id()) );
    //             }        
    //         endwhile; 
    // else :
    //     echo "There are no groups available.";
    // endif;
// }


// function cc_help_custom_post_type_archive( $query ) {

	// $gids = groups_get_user_groups( bp_loggedin_user_id() );
    // $gidarr = array_map( 'cchelp_get_group_tax_slug', $gids['groups'] );

	// if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'cchelp' ) ) {
			// $query->set( 'orderby', 'title' );
			// $query->set( 'order', 'DESC' );
			// $taxquery = array(
				// 'relation' => 'OR',
				// array(
					// 'taxonomy' => 'cc_help_groups',
					// 'field' => 'slug',
					// 'terms' => $gidarr					
				// ), 
				// array(
					// 'taxonomy' => 'cc_help_groups',
					// 'field' => 'slug',
					// 'terms' => 'all'
				// ),
			// );
			// $query->set( 'tax_query', $taxquery );
	// }
	
// } 
	
// add_action( 'pre_get_posts', 'cc_help_custom_post_type_archive' );


//This function adds a group taxonomy at time of group creation if top-level group
function cchelp_add_group_taxonomy($groupid) {
	$group = groups_get_group( array( 'group_id' => $groupid) );
	$groupname = $group->name;
	$hierarchy_group = new BP_Groups_Hierarchy($groupid);
	$parentid = $hierarchy_group->parent_id;
	if ($parentid == 0) {
		wp_insert_term( $groupname, 'cc_help_groups', array( 'slug' => cchelp_get_group_tax_slug( $groupid ) ) );
	}
}
add_action( 'groups_group_create_complete', 'cchelp_add_group_taxonomy' );

//This function removes a group taxonomy at time of group deletion
function cchelp_delete_group_taxonomy($groupid) {
	$term = get_term_by( 'slug', cchelp_get_group_tax_slug( $groupid ), 'cc_help_groups' );
	wp_delete_term( $term->term_id, 'cc_help_groups');
}
add_action( 'groups_delete_group', 'cchelp_delete_group_taxonomy' );

//Helper function
function cchelp_get_group_tax_slug( $groupid ) {
    return 'ccgroup-association-' . $groupid;
}

//Building the input form in the WordPress admin area
add_action( 'admin_init', 'cc_help_meta_box_add' );
function cc_help_meta_box_add()
{
	 add_meta_box( 'cc_help_meta_box', 'Highlight', 'cc_help_meta_box', 'cchelp', 'normal', 'high');         
}
       
function cc_help_meta_box()
{
    global $post;
    $custom = get_post_custom($post->ID);
    $cchelp_sticky = $custom["cchelp_sticky"][0];	
	?>
	<input type="checkbox" id="cchelp_sticky" name="cchelp_sticky" value="sticky" <?php checked( $cchelp_sticky, 'sticky' ); ?>> Highlight on help page?
	
	<?php
}

add_action( 'save_post', 'cchelp_save' );
function cchelp_save() { 
 
   global $post;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;

    if ($post->post_type == 'cchelp') {
       cchelp_save_event_field("cchelp_sticky");
    }
}

function cchelp_save_event_field($event_field) {
    global $post;
    //Don't save empty metas
    if(!empty($_POST[$event_field])) {
        update_post_meta($post->ID, $event_field, $_POST[$event_field]);
    } else {
        //Also note that disabled fields are not saved. e.g. if "National" is selected, state, finalgeo and lat/lon will all be deleted. If "State" is selected, finalgeo and lat/lon will all be deleted.
        delete_post_meta($post->ID, $event_field);
    }
}











// function cchelp_getuser_group_ids($query) {
	// if ( !is_admin() && $query->is_main_query() ) {
		// $gids = groups_get_user_groups( bp_loggedin_user_id() );
		
		// $gidarr = array_map( 'cchelp_get_group_tax_slug', $gids['groups'] );
		
		// $query->set('post_type', 'cchelp');
		// $taxquery = array(
					// 'relation' => 'OR',
						// array(
						// 'taxonomy' => 'cc_help_groups',
						// 'field' => 'slug',
						// 'terms' => $gidarr					
						// ), 
						// array(
						// 'taxonomy' => 'cc_help_groups',
						// 'field' => 'slug',
						// 'terms' => 'all'
						// ),
					// );
		// $query->set( 'tax_query', $taxquery );


	// }
// }
// add_action('pre_get_posts','cchelp_getuser_group_ids');


