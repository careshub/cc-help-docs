<?php
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


