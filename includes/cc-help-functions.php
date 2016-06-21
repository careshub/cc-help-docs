<?php

/**
 * Globally accessible functions.
 *
 * @link       http://www.communitycommons.org
 * @since      1.0.0
 *
 * @package    CC_Help
 * @subpackage CC_Help/includes
 */

/**
 * Calculate taxonomy term slug.
 *
 * @since
 *
 * @param int $group_id ID of new group.
 */
function cchelp_get_group_tax_slug( $group_id ) {
    return 'ccgroup-association-' . $group_id;
}

function cchelp_get_contact_form_id() {
	switch ( get_home_url() ) {
		case 'http://commonsdev.local':
			$id = 6;
			break;
		case 'http://staging.communitycommons.org':
			$id = 38;
			break;
		case 'http://www.communitycommons.org':
		default:
			$id = 8;
			break;
		}
	return $id;
}

// Help parsing the GET strings so we can use prettier strings.
function cchelp_get_archive_topic_param() {
	$terms_to_include = array();
	$tax_name = cchelp_get_topic_tax_name();
	$url_arg = cchelp_get_friendly_url_arg( $tax_name );

	if ( isset( $_REQUEST[$url_arg] ) ) {
		// We use the taxonomy term slugs to filter.
		// Get all slugs so we can check for bad terms.
		$all_terms = get_terms( array(
		    'taxonomy' => $tax_name,
		    'hide_empty' => false,
		) );
		$all_term_slugs = wp_list_pluck( $all_terms, 'slug', 'term_id' );

		if ( ! is_array( $_REQUEST[$url_arg] ) ) {
			$term_array = explode( ',', $_REQUEST[$url_arg] );
		} else {
			$term_array = $_REQUEST[$url_arg];
		}
		foreach ( $term_array as $term ) {
			$found = array_search( $term, $all_term_slugs );
			// Array search could return 0 as a valid key, so strict check it.
			if ( $found !== false ) {
				$terms_to_include[] = $found;
			}
		}
	}
    $towrite = PHP_EOL . 'cchelp_get_archive_topic_param: ' . print_r( $terms_to_include, TRUE );
    $fp = fopen('cchelp-troubleshooting.txt', 'a');
    fwrite($fp, $towrite);
    fclose($fp);
	return $terms_to_include;
}

function cchelp_get_cpt_name() {
	return 'cchelp';
}
function cchelp_get_topic_tax_name() {
	return 'cc_help_topics';
}

function cchelp_get_groups_tax_name() {
	return 'cc_help_groups';
}

function cchelp_get_types_tax_name() {
	return 'cc_help_types';
}

function cchelp_get_targeted_roles_tax_name() {
	return 'cchelp_targeted_roles';
}

function cchelp_get_friendly_url_arg( $tax_name = '' ) {
	switch ( $tax_name ) {
		case cchelp_get_topic_tax_name():
		default:
			$arg = 'guidebook';
			break;
	}
	return $arg;
}