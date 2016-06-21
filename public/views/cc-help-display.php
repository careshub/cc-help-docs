<?php

/**
 * Generates output.
 *
 * @link       http://www.communitycommons.org
 * @since      1.0.0
 *
 * @package    CC_Help
 * @subpackage CC_Help/public
 */

/**
 * Create the list of support guidebooks (archive by topic links).
 *
 * @since
 *
 * @param array term slug(s) for selected guidebook(s)
 * @return string html for the section.
 */
function cchelp_output_guidebook_grid( $selected_topics = array() ) {
	// @TODO: Make the guidebooks smaller, but keep them on the page, if one is selected. Maybe sort the selected to the front?
	$tax_name = cchelp_get_topic_tax_name();
	$topics = get_terms( array(
	    'taxonomy' => $tax_name,
	    'hide_empty' => false
	) );

	if ( empty( $topics ) ) {
		return; // There's nothing to do.
	}

	// Show the topics a bit differently if one is selected
	$filtered = ' no-topic-selected';
	$grid_size = 'large-Grid--1of4';
	if ( $selected_topics ) {
		$filtered = '';
		// $grid_size = 'med-Grid--1of4';
	}
	$archive_base_link = get_post_type_archive_link( cchelp_get_cpt_name() );
	?>
	<section id="help-guidebooks" class="guidebooks-container Grid Grid--full Grid--gutters Grid--center <?php echo $grid_size; ?>" >
		<?php
		foreach ( $topics as $term ) :
			$style_statement = '';
			if ( $term_color = get_term_meta( $term->term_id, 'color', true ) ) {
				$style_statement = ' style="background-color:' . $term_color . '"';
			}
			$selected = in_array( $term->slug, $selected_topics ) ? ' selected' : '';

		?>
		<div class="Grid-cell guidebook-block<?php echo $selected . $filtered; ?>">
			<a href="<?php echo $archive_base_link . '?' . cchelp_get_friendly_url_arg( $term->taxonomy ) . '=' . $term->slug; ?>" class="inset-contents aligncenter Grid Grid--center Grid-justifyContent"<?php echo $style_statement; ?>>
				<span class="guidebook-title Grid-cell"><?php echo $term->name; ?></span>
			</a>
		</div>
	<?php endforeach; ?>
	</section>
	<?php
}

function cchelp_output_contact_modal() {
	?>
	<div id="contact-form-modal-container" class="modal-content" style="">
		<p>Modal thing goes here.</p>
		<form>
		<label for="name">Name</label><br />
		<input type="text" id="name" name="name" /><br />
		<label for="email">Email</label><br />
		<input type="email" id="email" name="email" /><br />
		<label for="message">Message</label><br />
		<textarea id="message" name="message" ></textarea><br />
		<input type="submit" value="Hit us up!" /><br />
		</form>
		<?php //echo do_shortcode( '[gravityform id="' . $id_kids . '" title="false" description="false" name="Weight of the Nation for Kids Quickstart Guide Support"]' ); ?>
	</div>
	<script type="text/javascript">
	jQuery(function () {
		  // Load modal dialog on click
		  jQuery( ".open-contact-modal" ).click(function (e) {
		    e.preventDefault();
		    jQuery( "#contact-form-modal-container" ).modal({
		    	overlayClose:true,
		    	// minHeight:500,
		    	// autoResize:true
		    });
		  });
		});
	</script>
	<?php
}





