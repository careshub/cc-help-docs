<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.communitycommons.org
 * @since      1.0.0
 *
 * @package    CC_Help
 * @subpackage CC_Help/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    CC_Help
 * @subpackage CC_Help/includes
 * @author     David Cavins
 */
class CC_Help_Activator {

	/**
	 * Generate missing group taxonomy terms upon activation.
	 *
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		if ( ! function_exists( 'buddypress' ) ) {
			return;
		}

		// Get all group IDs and create new terms if one doesn't exist.
		$groups = groups_get_groups( array(
			'show_hidden'        => true,          // Show hidden groups to non-admins.
			'per_page'           => null,             // The number of results to return per page.
			'page'               => null,              // The page to return if limiting per page.
			'populate_extras'    => false,           // Fetch meta such as is_banned and is_member.
			'update_meta_cache'  => false,           // Pre-fetch groupmeta for queried groups.
		) );
		$tax_class = new CC_Help_Tax_Groups();
		$tax_name = $tax_class->get_tax_name();

		foreach ( $groups['groups'] as $group ) {
			$group_id = (int) $group->id;
			// Does a term already exist?
			$term = get_term_by( 'slug', cchelp_get_group_tax_slug( $group_id ), $tax_name );
			if ( false === $term ) {
				// Nope? Add the term.
				$tax_class->add_term( $group_id );
			}
		}
	}
}
