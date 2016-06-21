<?php
get_header();

//Which term is this page showing?
if ( isset( $wp_query->query_vars['term'] ) ) {
	$tax_term = get_term_by( 'slug', $wp_query->query_vars['term'], $wp_query->query_vars['taxonomy'] );
}

$gids = groups_get_user_groups( bp_loggedin_user_id() );
$gidarr = array_map( 'cchelp_get_group_tax_slug', $gids['groups'] );
$args = array(
		'post_type' => 'cchelp',
		'tax_query' =>
			array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'cc_help_groups',
				'field' => 'slug',
				'terms' => $gidarr
			),
			array(
				'taxonomy' => 'cc_help_groups',
				'field' => 'slug',
				'terms' => 'all'
			),
		)
		);
$group_posts = new WP_Query($args);

?>
	<style type="text/css">
		.shadow:hover {
			-webkit-box-shadow: 0px 0px 18px 0px rgba(50, 50, 50, 0.79);
			-moz-box-shadow:    0px 0px 18px 0px rgba(50, 50, 50, 0.79);
			box-shadow:         0px 0px 18px 0px rgba(50, 50, 50, 0.79);
		}
	</style>
	<section id="primary" class="site-content">
		<div id="content" role="main">
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
<!-- 		<h1 class="archive-title"><a href="/cchelp/">Support | Community Commons</a></h1>
 -->
		<div class="clear" id="screamer" style="background-color: #889c3b;width:800px;">
		<h1><span style="color: #ffffff;">We're glad you're here to use the latest technology and tools to make lasting community change. We'd like to offer some support.</span></h1>
		</div>
<?php
		$topicarray = array(
						'Getting Started' => array(
												'slug' => 'getting-started',
												'color' => '#879c3c',
												'text' => 'Getting Started'
												),
						'Maps' => array(
										'slug' => 'maps-3',
										'color' => '#008eaa',
										'text' => 'Mapping'
										),
						'Reports' => array(
										'slug' => 'reports',
										'color' => '#f9b715',
										'text' => 'Reporting and the CHNA'
										),
						'Data' => array(
										'slug' => 'data-3',
										'color' => '#df5827',
										'text' => 'Commons Data'
										),
						'Uploading Local Data' => array(
										'slug' => 'uploadlocaldata',
										'color' => '#f9b715',
										'text' => 'Uploading Local Data'
										),
						'Hubs' => array(
										'slug' => 'hubs-3',
										'color' => '#df5827',
										'text' => 'Hubs on the Commons'
										),
						'Administrators' => array(
										'slug' => 'administrators',
										'color' => '#008eaa',
										'text' => 'Being an Administrator'
										)
						);
		$typearray = array(
						'Videos' => 'videos',
						'Resources' => 'how-to-exercises',
						'FAQs' => 'faqs',
						'Webinars' => 'webinars'
						);

		if ( !empty( $tax_term ) && $tax_term->taxonomy == 'cchelp_personas' ) {
			$persona = $tax_term->name;
			$persona_slug = $tax_term->slug;
			$array = array(
				'Daniel' => array(
							'color' => '#008EAA',
							'text' => 'Daniel is a researcher who often serves as evaluation support for community health initiatives. He is an invited or contracted team member of the community coalition who holds a commitment to letting the data inform the work.',
							'image' => 'http://www.communitycommons.org/wp-content/uploads/2014/04/Daniel_Avatar.jpg',
							'video' => '<iframe src="//player.vimeo.com/video/91453831?title=0&amp;byline=0&amp;portrait=0" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'
							),
				'Tonya' => array(
							'color' => '#df5827',
							'text' => 'Tonya is a community organizer and advocate. She is a member of the healthy community coalition who has a deep understanding of the community’s history, desires and needs.',
							'image' => 'http://www.communitycommons.org/wp-content/uploads/2014/04/Tonya_Avatar.jpg',
							'video' => '<iframe src="//player.vimeo.com/video/91451815?title=0&amp;byline=0&amp;portrait=0" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'
							),
				'Sara' => array(
							'color' => '#f9b715',
							'text' => 'Sara provides leadership for a local agency focused on serving a wide range of community needs. She often convenes local stakeholders to create conditions that help advance strategy implementation of local coalitions.',
							'image' => 'http://www.communitycommons.org/wp-content/uploads/2014/04/Sara_Avatar.jpg',
							'video' => '<iframe src="//player.vimeo.com/video/90975840" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'
							),
				'Maria' => array(
							'color' => '#879c3c',
							'text' => 'Maria works for a local agency focused on improving health outcomes across communities in need. She serves as co-chair of the healthy community coalition providing coordination support and community health strategy expertise.',
							'image' => 'http://www.communitycommons.org/wp-content/uploads/2014/04/Maria_Avatar.jpg',
							'video' => '<iframe src="//player.vimeo.com/video/91557344" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'
							)
				);


				?>
				<div style="width:100%;padding:10px;margin-bottom:25px;background-color:<?php echo $array[$persona]['color']; ?>">
					<div>
						<div style="float:left;width:20%;vertical-align:middle;">
							<img src="<?php echo $array[$persona]['image']; ?>" width="75px" />
						</div>
						<div style="float:right;width:80%;">
							<div>
								<h1><span style="color:#ffffff;font-weight:bold;font-size:21pt;"><?php echo $persona; ?></span></h1>
							</div>
							<div>
								<?php echo $array[$persona]['text']; ?>
								<br /><br />
							</div>
						</div>
					</div>
					<div style="width:100%;text-align:center;">
						<?php echo $array[$persona]['video']; ?>
					</div>
				</div>
				<?php
					foreach ($topicarray as $topickey => $topicvalue) {
						foreach ($typearray as $typekey => $typevalue) {
								$args = array(
								'post_type' => 'cchelp',
								'tax_query' => array(
										'relation' => 'AND',
										array(
											'taxonomy' => 'cchelp_personas',
											'field' => 'slug',
											'terms' => $persona_slug
										),
										array(
											'taxonomy' => 'cc_help_topics',
											'field' => 'slug',
											'terms' => $topicvalue
										),
										array(
											'taxonomy' => 'cc_help_types',
											'field' => 'slug',
											'terms' => $typevalue
										)
									)
								);
								$loop = new WP_Query( $args );

								if ($loop->have_posts()) {

									echo "<div id='" . $topicvalue . "-" . $typevalue . "' style='padding:10px;margin-bottom:25px;width:100%;'>";
										echo "<p style='font-weight:bold;font-size:15pt;border-bottom: solid 1px #000000;'>" . $topickey . " [" . $typekey . "]</p>";
										while ( $loop->have_posts() ) : $loop->the_post();

										if ($typevalue == "faqs") {
												echo "<p>";
													echo "<a id='click-";
														the_ID();
														echo "' href='#' onclick='javascript:toggle(";
														the_ID();
														echo "); return false;' style='cursor:pointer;'>[+] ";
														the_title();
														echo "</a>";
												echo "</p>";
												echo "<div id='cchelp-";
													the_ID();
												echo "' class='entry-content' style='margin-left:15px;display:none;'>";
													the_content();
												echo '</div>';
											} elseif ($typevalue == "videos") {
												echo "<p style='font-weight:bold;'>";
													the_title();
												echo "</p>";
												echo "<div id='cchelp-";
													the_ID();
												echo "' class='entry-content' style='margin-left:15px;'>";
													the_content();
												echo '</div>';
											}
											else {
												echo "<p style='font-weight:bold;'>";
													the_title();
												echo "</p>";
												echo "<div id='cchelp-";
													the_ID();
												echo "' class='entry-content' style='margin-left:15px;'>";
													the_content();
												echo '</div>';
											}
										endwhile;
									echo "</div>";


							}

						}
					}
		}
		elseif (!empty( $tax_term ) && $tax_term->taxonomy == 'cc_help_topics')
		{
			$topic = $tax_term->name;
			$topic_slug = $tax_term->slug;
			?>
				<div style="width:795px;padding:10px;background-color:<?php echo $topicarray[$topic]['color']; ?>">
					<div style="width:100%;text-align:center;">
						<h1 id="guidebook-topic-title"><span style="color:#ffffff;font-weight:bold;font-size:21pt;"><?php echo $topicarray[$topic]['text']; ?></span></h1>
					</div>
				</div>
			<?php
				// IF QUERY STRING EXISTS THEN SHOW ALL POSTS OF THAT CATEGORY, ELSE JUST SHOW 3 POSTS
					if (isset($_GET["type"])) {

								$args = array(
								'post_type' => 'cchelp',
								'posts_per_page' => -1,
								'tax_query' => array(
										'relation' => 'AND',
										array(
											'taxonomy' => 'cc_help_topics',
											'field' => 'slug',
											'terms' => $topicarray[$topic]['slug']
										),
										array(
											'taxonomy' => 'cc_help_types',
											'field' => 'slug',
											'terms' => $_GET["type"]
										)
									)
								);

								$loop = new WP_Query( $args );

								if ($loop->have_posts()) {
									if ($_GET["type"] == "faqs") {
										$cchelptype = "FAQs";
									} else {
										$cchelptype = ucwords($_GET["type"]);
									}

										echo "<div id='" . $topicarray[$topic]['text'] . "-" . $_GET["type"] . "' style='padding:10px;width:795px;'>";
										echo "<p style='font-weight:bold;font-size:15pt;border-bottom: solid 1px #000000;'>" . $cchelptype . "</p>";
										if ($_GET["type"] == "videos" || $_GET["type"] == "how-to-exercises") {
											echo "<div style='width:100%;'>";
										}
										$cellcount = 0;

										while ( $loop->have_posts() ) : $loop->the_post();
										$cellcount = $cellcount + 1;
										if ($_GET["type"] == "faqs") {
												echo "<p>";
													echo "<a id='click-";
														the_ID();
														echo "' href='#' onclick='javascript:toggle(";
														the_ID();
														echo "); return false;' style='cursor:pointer;'>[+] ";
														the_title();
														echo "</a>";
												echo "</p>";
												echo "<div id='cchelp-";
													the_ID();
												echo "' class='entry-content' style='margin-left:15px;display:none;'>";
													the_content();
												echo '</div>';
											} elseif ($_GET["type"] == "videos" || $_GET["type"] == "how-to-exercises") {
													if ($cellcount %3 == 0) {
														//echo "<br />";
													}
													echo "<div style='float:left;text-align:center;font-weight:bold;width:33%;vertical-align:bottom;'>";
														the_title();
													echo "<br /><br />";
														the_content();
													echo "</div>";

											} else {
												echo "<p style='font-weight:bold;'>";
													the_title();
												echo "</p>";
												echo "<div id='cchelp-";
													the_ID();
												echo "' class='entry-content' style='margin-left:15px;'>";
													the_content();
												echo '</div>';
											}
										endwhile;
										if ($_GET["type"] == "videos" || $_GET["type"] == "how-to-exercises") {
											echo "</div>";
										}
									echo "</div>";

							}

					} else {

						foreach ($typearray as $typekey => $typevalue) {
								//GET THE COUNT OF POSTS IN EACH CATEGORY IN ORDER TO DISPLAY VIEW ALL BUTTON
								$argsall = array(
								'post_type' => 'cchelp',
								'tax_query' => array(
										'relation' => 'AND',
										array(
											'taxonomy' => 'cc_help_topics',
											'field' => 'slug',
											'terms' => $topicarray[$topic]['slug']
										),
										array(
											'taxonomy' => 'cc_help_types',
											'field' => 'slug',
											'terms' => $typevalue
										)
									)
								);
								$loopall = new WP_Query( $argsall );
								$allcount = $loopall->post_count;

								$args = array(
								'post_type' => 'cchelp',
								'posts_per_page' => 6,
								'meta_key' => 'cchelp_sticky',
								'meta_value' => 'sticky',
								'tax_query' => array(
										'relation' => 'AND',
										array(
											'taxonomy' => 'cc_help_topics',
											'field' => 'slug',
											'terms' => $topicarray[$topic]['slug']
										),
										array(
											'taxonomy' => 'cc_help_types',
											'field' => 'slug',
											'terms' => $typevalue
										)
									)
								);
								$loop = new WP_Query( $args );

								if ($loop->have_posts()) {

									echo "<div class='content-row clear' id='" . $topicarray[$topic]['text'] . "-" . $typevalue . "' style='padding:10px;width:795px;'>";
										echo "<p style='font-weight:bold;font-size:15pt;border-bottom: solid 1px #000000;'>" . $typekey . "</p>";
										if ($typevalue == "videos" || $typevalue == "how-to-exercises") {
											echo "<div style='width:100%;'>";
										}
										$cellcount = 0;
										while ( $loop->have_posts() ) : $loop->the_post();
											$cellcount = $cellcount + 1;
											if ($typevalue == "faqs") {
												echo "<p>";
													echo "<a id='click-";
														the_ID();
														echo "' href='#' onclick='javascript:toggle(";
														the_ID();
														echo "); return false;' style='cursor:pointer;'>[+] ";
														the_title();
														echo "</a>";
												echo "</p>";
												echo "<div id='cchelp-";
													the_ID();
												echo "' class='entry-content' style='margin-left:15px;display:none;'>";
													the_content();
												echo '</div>';
											} elseif ($typevalue == "videos" || $typevalue == "how-to-exercises") {
													if ($cellcount %3 == 0) {
														//echo "<br />";
													}
													?>
													<div class='third-block compact'>
														<h4 class="cchelp-item-title"><?php the_title(); ?></h4>
														<?php the_content(); ?>
													</div>
													<?php
											} else {
												echo "<p style='font-weight:bold;'>";
													the_title();
												echo "</p>";
												echo "<div id='cchelp-";
													the_ID();
												echo "' class='entry-content' style='margin-left:15px;'>";
													the_content();
												echo '</div>';
											}
										endwhile;
										if ($typevalue == "videos" || $typevalue == "how-to-exercises") {
												echo "</div>";
										}
									echo "</div>";
									if ( $allcount > 6 ) {
										?>
										<div style="width:795px;height:50px;">
											<input type="button" value="View All" style="float:left;" onclick="javascript:viewAll('<?php echo $topicarray[$topic]['slug']; ?>','<?php echo $typevalue; ?>');">
										</div>
										<?php
									}
							}
						}
					}


			cchelp_footer_buttons();
		} else {
			cchelp_search();
			echo "<br /><br />";
			$COGIScount = 0;
			$PRIMEcount = 0;
			$CAPcount = 0;
			foreach ($group_posts->posts as $post) :
				$term_list = wp_get_post_terms( $post->ID, 'cc_help_groups');
				foreach ($term_list as $term) {
					if($term->description == "PRIME")
					{
						if($PRIMEcount < 1) {
							//echo "<h1>PRIME POSTS:</h1><br /><br />";
							$PRIMEcount = 1;
						}
						if($term->slug == "ccgroup-association-54" && $COGIScount < 1) {
							$COGIScount = 1;
						?>
							<div style="width:895px;height:400px;background-color:#ffffff;border:solid 1px #008eaa;padding:25px;">
								<div style="float:left;width:50%;height:100%;vertical-align:top;text-align:left;font-size:13pt;">
									<img src="http://dev.communitycommons.org/wp-content/uploads/2014/04/cogistitle.jpg" /><br /><br />
									<p>The Childhood Obesity GIS collaboration space on the Commons has a variety of tools and applications to turn complex data into maps and other easy-to-understand visualizations, revealing the relationships, patterns, and trends that help tell a story.</p><p>The four personas on the right represent different ways people use the Commons to make a positive change in their community. Click on the ones that resonate with you to learn more.</p>
								</div>
								<div style="float:right;width:50%;background-color:#888888;height:100%;" >
									<div style="height:50%;">
										<div class="shadow" id="divTonya" style="cursor:pointer;width:50%;height:100%;float:left;background-color:#df5827;" title="Go to Tonya's help page">
											<div style="padding:12px;">
												<div>
													<div style="width:50%;float:left;vertical-align:middle;">
														<img style="float:left;" src="http://www.communitycommons.org/wp-content/uploads/2014/04/Tonya_Avatar.jpg" width="60px;" />
													</div>
													<div style="width:50%;float:right;color:#ffffff;font-weight:bold;font-size:18pt;">
														Tonya
													</div>
													<div style="width:100%;float:left;font-size:9pt;margin-top:15px;">
														Tonya is a community organizer and advocate. She is a member of the healthy community coalition who has a deep understanding of the community’s history, desires and needs.
													</div>
												</div>
											</div>
										</div>
										<div class="shadow" id="divSara" style="cursor:pointer;width:50%;height:100%;float:right;background-color:#f9b715;" title="Go to Sara's help page">
											<div style="padding:12px;">
												<div>
													<div style="width:50%;float:left;color:#ffffff;font-weight:bold;font-size:18pt;">
														Sara
													</div>
													<div style="width:50%;float:left;vertical-align:middle;">
														<img style="float:right;" src="http://www.communitycommons.org/wp-content/uploads/2014/04/Sara_Avatar.jpg" width="60px;" />
													</div>
													<div style="width:100%;float:left;font-size:9pt;margin-top:15px;">
														Sara provides leadership for a local agency focused on serving a wide range of community needs. She often convenes local stakeholders to create conditions that help advance strategy implementation of local coalitions.
													</div>
												</div>
											</div>
										</div>
									</div>
									<div style="height:50%;">
										<div class="shadow" id="divDaniel" style="cursor:pointer;width:50%;height:100%;float:left;background-color:#008eaa;" title="Go to Daniel's help page">
											<div style="padding:12px;">
												<div>
													<div style="width:50%;float:left;vertical-align:middle;">
														<img style="float:left;" src="http://www.communitycommons.org/wp-content/uploads/2014/04/Daniel_Avatar.jpg" width="60px;" />
													</div>
													<div style="width:50%;float:right;color:#ffffff;font-weight:bold;font-size:18pt;">
														Daniel
													</div>
													<div style="width:100%;float:left;font-size:9pt;margin-top:15px;">
														Daniel is a researcher who often serves as evaluation support for community health initiatives. He is an invited or contracted team member of the community coalition who holds a commitment to letting the data inform the work.
													</div>
												</div>
											</div>
										</div>
										<div class="shadow" id="divMaria" style="cursor:pointer;width:50%;height:100%;float:right;background-color:#879c3c;" title="Go to Maria's help page">
											<div style="padding:12px;">
												<div>
													<div style="width:50%;float:left;color:#ffffff;font-weight:bold;font-size:18pt;">
														Maria
													</div>
													<div style="width:50%;float:left;vertical-align:middle;">
														<img style="float:right;" src="http://www.communitycommons.org/wp-content/uploads/2014/04/Maria_Avatar.jpg" width="60px;" />
													</div>
													<div style="width:100%;float:left;font-size:9pt;margin-top:15px;">
														Maria works for a local agency focused on improving health outcomes across communities in need. She serves as co-chair of the healthy community coalition providing coordination support and community health strategy expertise.
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<script type="text/javascript">
							jQuery( document ).ready(function($) {
								$( "#divTonya" ).click(function() {
									window.location.href = '/cchelp/cchelp_personas/tonya-cogis-2/';
								});
								$( "#divSara" ).click(function() {
									window.location.href = '/cchelp/cchelp_personas/sara-cogis-2/';
								});
								$( "#divDaniel" ).click(function() {
									window.location.href = '/cchelp/cchelp_personas/daniel-cogis-2/';
								});
								$( "#divMaria" ).click(function() {
									window.location.href = '/cchelp/cchelp_personas/maria-cogis-2/';
								});
							});
							</script>

						<?php
						} elseif($term->slug != "ccgroup-association-54") {
						?>

							 <h1><?php echo get_the_title($post->ID); ?></h1>
							 <div class='post-content'><?php echo $post->post_content; ?></div>
						 <?php
						}
					} else if ($term->slug == "ccgroup-association-614") {
						if ($CAPcount == 0) {
						?>
						<div class="clear" id="screamer" style="background-color: #008eaa;width:800px;">
							<h1><span style="color: #ffffff;">Community Action Partnership Support</span></h1>
						</div>
						<?php
						}
						?>
						<h1><?php echo get_the_title($post->ID); ?></h1>
						<div class='post-content'><?php echo $post->post_content; ?></div>
						<?php
						$CAPcount = $CAPcount + 1;
					}
				}
			endforeach;
			wp_reset_postdata();

			//Get current logged-in user's BuddyPress role
			$uid = bp_loggedin_user_id();
			$bp_user_role = cchelp_get_user_role($uid);

			?>

			<br /><br />


			<br /><span id="publictools"><h1>Guidebooks</h1></span><br />
			<div style="width:895px;">
				<div id="guideStart" class="guidebook" style="background-color:#879c3c;cursor:pointer;border:solid 2px #879c3c;" title="Go to the Getting Started Guidebook">
					<span class="guidebook-text">Getting Started</span>
				</div>
				<div id="guideMaps" class="guidebook" style="background-color:#008eaa;cursor:pointer;border:solid 2px #008eaa;" title="Go to the Mapping Guidebook">
					<span class="guidebook-text">Mapping</span>
				</div>
				<div id="guideReports" class="guidebook" style="background-color:#f9b715;cursor:pointer;border:solid 2px #f9b715;" title="Go to the Reporting Guidebook">
					<span class="guidebook-text">Reporting and the CHNA</span>
				</div>
			</div>

			<div style="width:895px;">
				<div id="guideData" class="guidebook" style="background-color:#df5827;cursor:pointer;border:solid 2px #df5827;" title="Go to the Data Guidebook">
					<span class="guidebook-text">Commons Data</span>
				</div>
				<div id="guideWebinars" class="guidebook" style="background-color:#008eaa;cursor:pointer;border:solid 2px #008eaa;" title="Go to Webinars">
					<span class="guidebook-text">Webinars</span>
				</div>
				<div id="guideGroups" class="guidebook" style="background-color:#df5827;cursor:pointer;border:solid 2px #df5827;" title="Go to Hubs on the Commons">
					<span class="guidebook-text">Hubs on the Commons</span>
				</div>
			</div>



			<?php
			//var_dump($bp_user_role);
			if ($bp_user_role > 0) {

			?>


			<div style="width:895px;">

				<div id="guideAdmin" class="guidebook" style="background-color:#008eaa;cursor:pointer;border:solid 2px #008eaa;" title="Go to the Administrator Guidebook">
					<span class="guidebook-text">Being an Administrator</span>
				</div>
				<div id="guideUploadingData" class="guidebook" style="background-color:#f9b715;cursor:pointer;border:solid 2px #f9b715;" title="Go to the Data Guidebook">
					<span class="guidebook-text">Uploading Local Data</span>
				</div>
			</div>
			<?php
				cchelp_footer_buttons();
			}
			?>







			<style type="text/css">
				.guidebook
				{
					width:225px;
					height:300px;
					text-align:center;
					padding:10px;
					margin-right:35px;
					margin-bottom:35px;
					float:left;
				}
				.guidebook-text
				{
					position:relative;
					top:113px;
					color:#ffffff;
					font-size:22pt;
					line-height:30px;
				}
				.guidebook:hover {
					-webkit-box-shadow: 0px 0px 18px 0px rgba(50, 50, 50, 0.79);
					-moz-box-shadow:    0px 0px 18px 0px rgba(50, 50, 50, 0.79);
					box-shadow:         0px 0px 18px 0px rgba(50, 50, 50, 0.79);
					font-weight:bold;
				}

			</style>

			<script type="text/javascript">
				jQuery( document ).ready(function($) {
					$( "#guideStart" ).click(function() {
						window.location.href = '/cchelp/cc_help_topics/getting-started/';
					});
					$( "#guideMaps" ).click(function() {
						window.location.href = '/cchelp/cc_help_topics/maps-3/';
					});
					$( "#guideData" ).click(function() {
						window.location.href = '/cchelp/cc_help_topics/data-3/';
					});
					$( "#guideUploadingData" ).click(function() {
						window.location.href = '/cchelp/cc_help_topics/uploadlocaldata/';
					});
					$( "#guideReports" ).click(function() {
						window.location.href = '/cchelp/cc_help_topics/reports/';
					});
					$( "#guideGroups" ).click(function() {
						window.location.href = '/cchelp/cc_help_topics/hubs-3/';
					});
					$( "#guideAdmin" ).click(function() {
						window.location.href = '/cchelp/cc_help_topics/administrators/';
					});
					$( "#guideCHI" ).click(function() {
						window.location.href = '/cchelp/cc_help_topics/chi-grant-planning/';
					});
					$( "#guideWebinars" ).click(function() {
						window.location.href = '/archived-webinars/';
					});
				});
			</script>

		<?php

			//echo "<br /><h1>GENERIC POSTS:</h1><br />";

			// if(have_posts()) : while(have_posts()) : the_post();
				// the_title();
				// echo '<div class="entry-content">';
				// the_content();
				// echo '</div>';
			// endwhile; endif;

		}
		?>
		</div><!-- #content -->
	</section><!-- #primary -->
	<?php
		if ( !empty( $tax_term ) && $tax_term->taxonomy == 'cchelp_personas' ) {
	?>
		<section style="float:right;width:275px;margin-top:100px;">
	<?php
					foreach ($topicarray as $topickey => $topicvalue) {
						foreach ($typearray as $typekey => $typevalue) {
								$args = array(
								'post_type' => 'cchelp',
								'tax_query' => array(
										'relation' => 'AND',
										array(
											'taxonomy' => 'cchelp_personas',
											'field' => 'slug',
											'terms' => $persona_slug
										),
										array(
											'taxonomy' => 'cc_help_topics',
											'field' => 'slug',
											'terms' => $topicvalue
										),
										array(
											'taxonomy' => 'cc_help_types',
											'field' => 'slug',
											'terms' => $typevalue
										)
									)
								);
						$loop = new WP_Query( $args );

						if ($loop->have_posts()) {
							echo "<p><a href='#" . $topicvalue . "-" . $typevalue . "'>" . $topickey . " [" . $typekey . "]</a></p><br />";
						}
				}
		}
	?>
		</section>

	<?php
		}



?>
			<script type="text/javascript">
			function toggle(postid) {
				//alert(postid);
				var ele = document.getElementById("cchelp-" + postid);
				var text = document.getElementById("click-" + postid);
				if(ele.style.display == "block") {
						ele.style.display = "none";
						var currtext = text.innerHTML;
						var clickstr = currtext.replace("[-] ","[+] ");
						text.innerHTML = clickstr;
						//text.innerHTML = "show";
				}
				else {
						ele.style.display = "block";
						var currtext = text.innerHTML;
						var clickstr = currtext.replace("[+] ","[-] ");
						text.innerHTML = clickstr;
						//text.innerHTML = "hide";
				}

			}
			function viewAll(topic,type) {
				document.location.href='/cchelp/cc_help_topics/' + topic + '/?type=' + type;
			}
			</script>


<?php
	get_footer();

function cchelp_search() {
?>
			<div>
				<br /><br />
				<h3>Search Support</h3>

				<form action="#searchresults" method="post" name="cchelpsearch">
								<input id="s" class="text" type="text" name="s" value="" />
								<input type="hidden" name="post_type" value="cchelp" /> <!-- // hidden 'your_custom_post_type' value -->
								<input class="submit button" type="submit" name="submit" value="Search" />
				</form>
			</div>
			<div id="searchresults">
			<?php
			if (isset($_POST['cchelpterms'])) {
				if ( have_posts() ) :
					/* Start the Loop */
					while ( have_posts() ) : the_post();
						get_template_part( 'content', get_post_format() );
					endwhile;
				 else :
					get_template_part( 'content', 'none' );
				 endif;
			}
			?>
			</div>
			<?php
}

function cchelp_footer_buttons() {
?>
		<br />
		<div id="search_box">
		<?php
			cchelp_search();
		?>
		</div>
		<br />
			<div style="width:895px;">
				<!--<div id="guideTraining" class="guidebook2" title="Training">
					<span class="guidebook2-text">View a recorded training webinar, sign up for our next one<br />-OR-<br />Contact us for customized training solutions</span>
				</div>-->
				<a href="https://ip3.zendesk.com/account/dropboxes/20111391" target="_blank"><div id="guideContact" class="guidebook2" style="height:40px;" title="Contact Us">
					<span class="guidebook2-text" style="top:10px;"><strong>Still stuck? Contact us here</strong></span>
				</div></a>
				<!--<div id="guideInspiration" class="guidebook2" title="Inspiration">
					<span class="guidebook2-text">Need some inspiration?<br />How to use the Commons to create real change in your community</span>
				</div>-->
			</div>
	<style type="text/css">
				.guidebook2
				{
					//width:225px;
					//height:300px;
					width:795px;
					height:100px;
					text-align:center;
					padding:10px;
					margin-right:35px;
					margin-bottom:35px;
					//background-color:#ffffff;
					background-color:#008eaa;
					cursor:pointer;
					border:solid 2px #008eaa;
					float:left;
				}
				.guidebook2-text
				{
					position:relative;
					//top:50px;
					top:20px;
					//color:#008eaa;
					color:#ffffff;
					font-size:16pt;
					//line-height:30px;
				}
				.guidebook2:hover {
					-webkit-box-shadow: 0px 0px 18px 0px rgba(50, 50, 50, 0.79);
					-moz-box-shadow:    0px 0px 18px 0px rgba(50, 50, 50, 0.79);
					box-shadow:         0px 0px 18px 0px rgba(50, 50, 50, 0.79);
					//background-color:#ebebeb;
				}
	</style>
	<script type="text/javascript">
				jQuery( document ).ready(function($) {
					$( "#guideTraining" ).click(function() {
						window.location.href = '/cchelp/cc_help_topics/getting-started/';
					});
					// $( "#guideContact" ).click(function() {
						// window.location.href = 'https://ip3.zendesk.com/account/dropboxes/20111391';
					// });
					$( "#guideInspiration" ).click(function() {
						window.location.href = '/cchelp/cc_help_topics/data-2/';
					});
					var pathname = window.location.pathname;
					if (pathname == '/cchelp/') {
						$("#search_box").hide();
					}

				});

	</script>
<?php
}

function cchelp_get_user_role($user_id){
    global $wpdb;
    $user = get_userdata( $user_id );
    $capabilities = $user->{$wpdb->prefix . 'capabilities'};
    if ( !isset( $wp_roles ) ){
        $wp_roles = new WP_Roles();
    }
	$admincount=0;
    foreach ( $wp_roles->role_names as $role => $name ) {
		if ($name == "Administrator") {
			$admincount = $admincount + 1;
		}

        // if ( array_key_exists( $role, $capabilities ) ) {
            // return $role;
        // }
    }
    //return false;
	return $admincount;
}

	?>