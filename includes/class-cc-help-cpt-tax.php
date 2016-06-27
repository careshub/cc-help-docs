<?php

/**
 * The file that defines the base CPT and Tax class.
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
class CC_Help_CPT_Tax {

	/**
	 * @var string Name of custom post type
	 */
	public $cpt_name = 'cchelp';

	/**
	 * @var string Name of taxonomy
	 */
	public $tax_name = '';

	/**
	 * @var string desired meta fields
	 * Correct structure is:
	 * array(
	 *	meta_key => array(
	 *		'labels' => array(
	 *			'singular'   => '',
	 *			'plural'     => '',
	 *			'description' => ''
	 *		),
	 *		'add_term_column' => false,
	 *		'add_term_field'  => false,
	 *		'term_field_type' => text,
	 *	)
	 * )
	 */
	public $meta_fields = array();

	/**
	 * @var string Whether we need to add term columns for this item.
	 */
	public $add_term_columns = false;

	/**
	 * @var string Whether we need to add term fields for this item.
	 */
	public $add_term_fields = false;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	public $version;

	/**
	 * Set up the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->version = cc_help_get_version();

		// Updating meta
		add_action( 'create_term', array( $this, 'save_meta' ), 10, 2 );
		add_action( 'edit_term',   array( $this, 'save_meta' ), 10, 2 );

	}

	/**
	 * Creates the needed post type.
	 *
	 * @since    1.0.0
	 */
	public function register_cpt() {
	}

	/**
	 * Creates the various taxonomies used with cchelp.
	 *
	 * @since    1.0.0
	 */
	public function register_taxonomy() {
	}

	public function get_cpt_name() {
		return $this->cpt_name;
	}

	public function get_tax_name() {
		return $this->tax_name;
	}

	/**
	 * Add term color picker for cc_help_topics taxonomy.
	 *
	 * @since    1.0.0
	 *
	 * @param int $post_id ID of the post being saved
	 * @param obj $post    $post object of post being saved
	 */
	public function enqueue_admin_colorpicker_scripts() {
		$screen = get_current_screen();
		if ( isset( $screen->taxonomy ) && $this->tax_name == $screen->taxonomy ) {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );

			// Enqueue fancy coloring; includes quick-edit
			wp_enqueue_script( 'cchelp-admin-colorpicker', cc_help_base_path(). 'admin/assets/admin.js', array( 'wp-color-picker', 'jquery', 'wp-util' ), $this->version, true );
		}
	}

	/**
	 * Align custom `color` column
	 *
	 * @since 1.0.0
	 */
	public function output_color_style() {
		?>

		<style type="text/css">
			.column-color {
				width: 74px;
			}
			.term-color {
				height: 25px;
				width: 25px;
				display: inline-block;
				border: 2px solid #eee;
				border-radius: 100%;
			}
		</style>

		<?php
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 * Override this in the extension class if you need different behavior.
	 *
	 * @since 1.0.0
	 */
	public function add_form_field() {

		foreach ( $this->meta_fields as $meta_key => $details ) {
			?>

			<div class="form-field term-<?php echo esc_attr( $meta_key ); ?>-wrap">
				<label for="term-<?php echo esc_attr( $meta_key ); ?>">
					<?php echo esc_html( $details->labels['singular'] ); ?>
				</label>

				<?php switch ( $details['term_field_type'] ) {
					case 'value':
						# code...
						break;

					default:
						$this->form_field_text( $meta_key );
						break;
				}
				?>

				<?php if ( ! empty( $details->labels['description'] ) ) : ?>

					<p class="description">
						<?php echo esc_html( $details->labels['description'] ); ?>
					</p>

				<?php endif; ?>

			</div>

			<?php
		}
	}

	/**
	 * Output the form field when editing an existing term
	 * Override this in the extension class if you need different behavior.
	 *
	 * @since 1.0.0
	 *
	 * @param object $term
	 */
	public function edit_form_field( $term = false ) {
		foreach ( $this->meta_fields as $meta_key => $details ) {
			?>

			<tr class="form-field term-<?php echo esc_attr( $meta_key ); ?>-wrap">
				<th scope="row" valign="top">
					<label for="term-<?php echo esc_attr( $meta_key ); ?>">
						<?php echo esc_html( $details->labels['singular'] ); ?>
					</label>
				</th>
				<td>
					<?php switch ( $details['term_field_type'] ) {
						case 'value':
							# code...
							break;

						default:
							$this->form_field_text( $meta_key, $term );
							break;
					}
					?>

					<?php if ( ! empty( $details->labels['description'] ) ) : ?>

						<p class="description">
							<?php echo esc_html( $details->labels['description'] ); ?>
						</p>

					<?php endif; ?>

				</td>
			</tr>

			<?php
		}
	}

	/**
	 * Output the form field
	 * Override this in the extension class if you need different behavior.
	 *
	 * @since 1.0.0
	 *
	 * @param  $term
	 */
	protected function form_field_text( $meta_key = '', $term = '' ) {
		// Get the meta value
		$value = isset( $term->term_id )
			? get_term_meta( $term->term_id, $meta_key, true )
			: ''; ?>

		<input type="text" name="term-<?php echo esc_attr( $meta_key ); ?>" id="term-<?php echo esc_attr( $meta_key ); ?>" value="<?php echo esc_attr( $value ); ?>">

		<?php
	}

	/**
	 * Add the "meta_key" column to taxonomy terms list-tables
	 * Override this in the extension class if you need different behavior.
	 *
	 * @since 1.0.0
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	public function add_column_header( $columns = array() ) {
		foreach ( $this->meta_fields as $meta_key => $details ) {
			$columns[ $meta_key ] = $details['labels']['singular'];
		}

		return $columns;
	}

	/**
	 * Output the value for the custom column.
	 * Override this in the extension class if you need different behavior.
	 *
	 * @since 1.0.0
	 *
	 * @param string $empty
	 * @param string $custom_column
	 * @param int    $term_id
	 *
	 * @return mixed
	 */
	public function add_column_value( $empty = '', $custom_column = '', $term_id = 0 ) {
		if ( empty( $_REQUEST['taxonomy'] ) || ! empty( $empty ) || empty( $this->meta_fields ) ) {
			return;
		}
		if ( ! array_key_exists( $custom_column, $this->meta_fields ) ) {
			return;
		}

		// Pick the right entry.
		$details = $this->meta_fields[$custom_column];
		$retval = '&#8212;';

		// Get the metadata
		$meta = get_term_meta( $term_id, $custom_column, true );

		// Output HTML element if not empty
		if ( ! empty( $meta ) ) {
			switch ( $custom_column ) {
				case 'value':
					# code...
					break;

				default:
					$retval = '<i class="term-color" data-color="' . esc_attr( $meta ) . '" style="background-color: ' . esc_attr( $meta ) . '"></i>';
					break;
			}
		}
		echo $retval;
	}

	/**
	 * Add `meta_key` to term when updating
	 *
	 * @since 1.0.0
	 *
	 * @param  int     $term_id
	 * @param  string  $taxonomy
	 */
	public function save_meta( $term_id = 0, $taxonomy = '' ) {
		foreach ( $this->meta_fields as $meta_key => $details ) {
			// Get the term being posted
			$term_key = 'term-' . $meta_key;

			// Bail if the meta_value hasn't been POSTed.
			if ( ! isset( $_POST[ $term_key ] ) ) {
				return;
			}

			// Parse the meta value.
			$meta = ! empty( $_POST[ $term_key ] )
				? $_POST[ $term_key ]
				: '';

			$this->set_meta( $term_id, $taxonomy, $meta_key, $meta );
		}
	}

	/**
	 * Set `meta_key` of a specific term
	 *
	 * @since 1.0.0
	 *
	 * @param  int     $term_id
	 * @param  string  $taxonomy
	 * @param  string  $meta
	 * @param  bool    $clean_cache
	 */
	public function set_meta( $term_id = 0, $taxonomy = '', $meta_key = '', $meta = ''  ) {

		// No meta_key, so delete
		if ( empty( $meta ) ) {
			delete_term_meta( $term_id, $meta_key );

		// Update meta_key value
		} else {
			// Make sure to add the proper sanitization callback.
			// See CC_Help_Tax_Topics::_construct for example.
			update_term_meta( $term_id, $meta_key, $meta );
		}
	}

	public function sanitize_hex_color( $color ) {
		if ( '' === $color )
			return '';

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		} else {
			return '';
		}
	}
}