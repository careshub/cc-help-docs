<?php
get_header();

// These are the various taxonomies
// Topic filters
// These are applied because of the format of the urls we're using.
// 'cc_help_topics' -- topics, used in "guidebooks"

// Exclusions- who should (not) see certain content.
// We're doing the exclusionary taxonomy term work on the _pre_get_posts filter for all loops on this page.
// 'cc_help_groups' -- if the content is aimed at a particular group
// 'cchelp_targeted_roles' -- content aimed at group admins and mods.

// Content formats - which loop to put these things in.
// 'cc_help_types' -- like video or FAQ

//Which term is this page showing?
if ( isset( $wp_query->query_vars['term'] ) ) {
	$tax_term = get_term_by( 'slug', $wp_query->query_vars['term'], $wp_query->query_vars['taxonomy'] );
}

$topic_arg = cchelp_get_friendly_url_arg( cchelp_get_topic_tax_name() );
$selected_topics = array();
$selected_topics_statement = '';
if ( isset( $_REQUEST[$topic_arg] ) ) {
	$selected_topics = explode( ',', $_REQUEST[$topic_arg] );
	$selected_topics_statement = ucwords( implode( ', ', $selected_topics ) );
}
// echo '<pre>';
// echo 'requested tax term: '; var_dump( $tax_term );
// echo 'selected topics: '; var_dump( $selected_topics );

// var_dump( $wp_query );
// var_dump( $wp_query->posts );
// echo '</pre>';

$types_tax_name = cchelp_get_types_tax_name();

?>
	<section id="primary" class="site-content">
		<div id="content" role="main">
			<header class="entry-header">
				<h1 class="entry-title"><a href="<?php get_post_type_archive_link( cchelp_get_cpt_name() ); ?>">Support</a></h1>
				<p>We&rsquo;re glad you&rsquo;re here to use the latest technology and tools to make lasting community change. We&rsquo;d like to offer some support.</p>
			</header>

			<h2 class="entry-title">Guidebooks</h2>
			<?php cchelp_output_guidebook_grid( $selected_topics ); ?>

			<?php
			// Run the loop. The loop's args are updated at `pre_get_posts`
			// in CC_Help_Public::filter_archive_query()
			if ( have_posts() ) :
				if ( $selected_topics ) :
				?>
					<h2>Help Articles in the <?php echo $selected_topics_statement; ?> Topic</h2>
				<?php else : ?>
					<h2>Highlighted Help Articles</h2>
				<?php endif; ?>
				<section id="help-found-videos">
					<h3 class="screamer section-header">Videos</h3>
					<div class="Grid Grid--full med-Grid--1of3 Grid--gutters Grid--center">
						<?php
						// loop through videos, then resources, then FAQs.
						$displayed_post = false;
						while (have_posts()) : the_post();
							// Only display videos in this loop.
							$types = get_the_terms( get_the_id(), $types_tax_name );
							if ( ! $types || current( $types )->slug != 'videos' ) {
								continue;
							} else {
								// We've got one!
								$displayed_post = true;
							}
							?>

						<div id="cchelp-item-<?php the_ID(); ?>" class="Grid-cell cchelp-video-container">
							<h4><a href="<?php echo get_the_permalink(); ?>" class=""><?php the_title(); ?></a></h4>
							<p class="related-content entry-content"><?php the_content(); ?></p>
						</div>

						<?php
						endwhile;

						if ( ! $displayed_post ) {
							?>
							<div class="Grid-cell">
								<p class="cchelp-nothing-found">No videos were found.</p>
							</div>
							<?php
						}

						rewind_posts();
						?>
					</div>
				</section>
				<section id="help-found-resources">
					<h3 class="screamer section-header">Resources</h3>
					<div class="Grid Grid--full med-Grid--1of3 Grid--gutters Grid--center">
						<?php
						$displayed_post = false;
						while (have_posts()) : the_post();
						// Only display resources in this loop.
						$types = get_the_terms( get_the_id(), $types_tax_name );
						if ( ! $types || current( $types )->slug != 'resources' ) {
							continue;
						} else {
							// We've got one!
							$displayed_post = true;
						}
						?>

						<div id="cchelp-item-<?php the_ID(); ?>" class="Grid-cell cchelp-faq-container">
							<h4><a href="<?php echo get_the_permalink(); ?>" class=""><?php the_title(); ?></a></h4>
							<p class="related-content entry-content"><?php the_content(); ?></p>
						</div>
						<?php
						endwhile;

						if ( ! $displayed_post ) {
							?>
							<div class="Grid-cell">
								<p class="cchelp-nothing-found message error">No resources were found.</p>
							</div>
							<?php
						}

						rewind_posts();
						?>
					</div>
				</section>
				<section id="help-found-faqs" class="">
					<h3 class="screamer section-header">Frequently Asked Questions</h3>
					<div>
						<?php
						$displayed_post = false;
						while (have_posts()) : the_post();
						// Only display FAQs in this loop.
						$types = get_the_terms( get_the_id(), $types_tax_name );
						if ( ! $types || current( $types )->slug != 'faqs' ) {
							continue;
						}  else {
							// We've got one!
							$displayed_post = true;
						}
						?>

						<div id="cchelp-item-<?php the_ID(); ?>" class="toggleable toggle-closed Grid-cell cchelp-faq-container">
							<h4><span class="arrow arrow-right"></span><a href="<?php echo get_the_permalink(); ?>" class="toggle-trigger"><?php the_title(); ?></a></h4>
							<div class="toggle-content entry-content">
								<?php the_content(); ?>
							</div>
						</div>

						<?php
						endwhile;

						if ( ! $displayed_post ) {
							?>
							<div class="Grid-cell">
								<p class="cchelp-nothing-found message error">No FAQs were found.</p>
							</div>
							<?php
						}

						rewind_posts();
						?>
					</div>
				</section>

				<?php
			endif;
				?>
				<a href="/contact" id="guideContact" class="contact-link screamer ccgreen" title="Contact Us" target="_blank">Still stuck? Contact us here</a>
		</div>
	</section>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$( ".toggle-trigger" ).on( "click", function(e){
				e.preventDefault();
				var toggleable = $( this ).parents( '.toggleable' );

				if ( toggleable.hasClass( 'toggle-open' ) ) {
					toggleable.removeClass( 'toggle-open' ).addClass( 'toggle-closed' );
					$( this ).siblings( ".arrow" ).removeClass( "arrow-down" ).addClass( "arrow-right" );
				} else {
					toggleable.removeClass( 'toggle-closed' ).addClass( 'toggle-open' );
					$( this ).siblings( ".arrow" ).removeClass( "arrow-right" ).addClass( "arrow-down" );
				}
			});
		});
	</script>
<?php
get_footer();
