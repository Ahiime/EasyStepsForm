<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.blyd3d.com
 * @since      1.0.0
 *
 * @package    Easystepsform
 * @subpackage Easystepsform/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Easystepsform
 * @subpackage Easystepsform/admin
 * @author     Ahime <info@blyd3d.com>
 */
class Easystepsform_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Easystepsform_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Easystepsform_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easystepsform-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style(
			'kali-admin-ui',
			EASYSTEPSFORM_URL . 'includes/kali-admin-tools/css/kali-admin-ui.css',
			array(),
			'1.0.0',
			'all'
		);

		wp_enqueue_style(
			'kali-select2',
			EASYSTEPSFORM_URL . 'includes/kali-admin-tools/css/select2.min.css',
			array(),
			'1.0.0',
			'all'
		);

		wp_enqueue_style(
			'kali-modal',
			EASYSTEPSFORM_URL . 'includes/kali-admin-tools/js/modal/modal.min.css',
			array(),
			'1.0.0',
			'all'
		);
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Easystepsform_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Easystepsform_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/easystepsform-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_media();

		wp_enqueue_script(
			'iris',
			admin_url( 'js/iris.min.js' ),
			array(
				'jquery-ui-draggable',
				'jquery-ui-slider',
				'jquery-touch-punch',
			),
			$this->version,
			1
		);

		wp_enqueue_script(
			'select2',
			EASYSTEPSFORM_URL . 'includes/kali-admin-tools/js/select2.min.js',
			array( 'jquery' ),
			$this->version,
			false
		);

		wp_enqueue_script(
			'SpryTabbedPanels',
			EASYSTEPSFORM_URL . 'includes/kali-admin-tools/js/SpryTabbedPanels.min.js',
			array( 'jquery' ),
			$this->version,
			false
		);

		wp_localize_script(
			'kali-admin-tools',
			'home_url',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);

		wp_enqueue_script(
			'kali-admin-tools',
			EASYSTEPSFORM_URL . 'includes/kali-admin-tools/js/kali-admin-tools-scripts.js',
			array( 'jquery' ),
			'1.0.0',
			false
		);

		wp_enqueue_script(
			'kali-modal',
			EASYSTEPSFORM_URL . 'includes/kali-admin-tools/js/modal/modal.min.js',
			array( 'jquery' ),
			'1.0.0',
			false
		);
	}

		/**
		 * Builds all the plugin menu and submenu
		 */
	public function add_submenu() {
		if ( class_exists( 'WooCommerce' ) ) {
			global $submenu, $menu;
			$icon = EASYSTEPSFORM_URL . 'includes/images/icon.png';

			add_menu_page(
				'Easy Step Form',
				'Easy Step Form',
				'manage_product_terms',
				'easy-step-form-manage',
				array( $this, 'get_dashboard_page' ),
				$icon,
				10
			);

			add_submenu_page(
				'easy-step-form-manage',
				__( 'Add Form', 'easystepsform' ),
				__( 'Add Form', 'easystepsform' ),
				'manage_product_terms',
				'edit.php?post_type=easy-step-form-add',
				false
			);

			add_submenu_page(
				'easy-step-form-manage',
				__( 'Add Step', 'easystepsform' ),
				__( 'Add Step', 'easystepsform' ),
				'manage_product_terms',
				'edit.php?post_type=easy-step-form-step',
				false
			);

			add_submenu_page(
				'easy-step-form-manage',
				__( 'Input', 'easystepsform' ),
				__( 'Input', 'easystepsform' ),
				'manage_product_terms',
				'edit.php?post_type=easy-step-form-input',
				false
			);

			$args = array(
				'post_type'      => 'easy-step-form-input',
				'meta_key'       => 'easy-step-form-input-status',
				'meta_value'     => 'unread',
				'posts_per_page' => -1,
			);

			$read_posts = count( get_posts( $args ) );

			$submenu = $GLOBALS['submenu'];

			foreach ( $submenu['easy-step-form-manage'] as &$subitem ) {
				if ( isset( $subitem[2] ) && $subitem[2] == 'edit.php?post_type=easy-step-form-input' ) {
					$subitem[0] .= '<span class="update-plugins count-' . $read_posts . '"><span class="plugin-count">' . $read_posts . '</span></span>';
					break;
				}
			}

			$GLOBALS['submenu']['easy-step-form-manage'] = $submenu['easy-step-form-manage'];
		}
	}

	public function get_dashboard_page() {
	}

	/**
	 * Register custom post type.
	 *
	 * @return void
	 */
	public function register_post_type() {
		$this->register_post_type_arg( 'Form', 'easy-step-form-add' );
		$this->register_post_type_arg( 'Step', 'easy-step-form-step' );
		$this->register_post_type_arg( 'Input', 'easy-step-form-input' );
	}

	public function register_post_type_arg( $name, $custom_post_type ) {
		$labels = array(
			'name'               => $name,
			'singular_name'      => $name,
			'add_new'            => 'New ' . $name,
			'add_new_item'       => 'New ' . $name,
			'edit_item'          => 'Edit ' . $name,
			'new_item'           => 'New ' . $name,
			'view_item'          => 'View ' . $name,
			'not_found'          => 'No ' . $name . ' found',
			'not_found_in_trash' => 'No ' . $name . ' in the trash',
			'menu_name'          => $name,
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => '',
			'supports'            => array( 'title' ),
			'public'              => false,
			'menu_icon'           => 'dashicons-images-alt',
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => false,
			'can_export'          => true,
		);

		register_post_type( $custom_post_type, $args );
	}

	public function add_metaboxes() {
		// Add form meta box.
		add_meta_box(
			'easy-step-form-add',
			__( 'Add details', 'easystepsform' ),
			array( $this, 'add_detail' ),
			'easy-step-form-add'
		);

		add_meta_box(
			'easy-step-form-detail-step',
			__( 'Step', 'easystepsform' ),
			array( $this, 'add_step_detail' ),
			'easy-step-form-add'
		);

		add_meta_box(
			'easy-step-form-pricing',
			__( 'Pricing details', 'easystepsform' ),
			array( $this, 'add_pricing_detail' ),
			'easy-step-form-add'
		);

		// Add step meta box.

		add_meta_box(
			'easy-step-form-stepper',
			__( 'Header details', 'easystepsform' ),
			array( $this, 'add_stepper' ),
			'easy-step-form-step'
		);

		add_meta_box(
			'easy-step-form-stepper-field',
			__( 'Add fields', 'easystepsform' ),
			array( $this, 'add_stepper_fields' ),
			'easy-step-form-step'
		);

		// Form input meta box.

		add_meta_box(
			'easy-step-form-input-field',
			__( 'Input data', 'easystepsform' ),
			array( $this, 'add_stepper_input_fields' ),
			'easy-step-form-input'
		);
	}

	public function add_stepper_input_fields( $post ) {
		$form_data = get_post_meta( $post->ID, 'easy-step-form-input', true );

		if ( ! empty( $form_data ) ) {
			echo '<table style="width: 100%; border-collapse: collapse;">';
			echo '<thead>';
			echo '<tr>';
			echo '<th style="border: 1px solid #ddd; padding: 8px;">Champ</th>';
			echo '<th style="border: 1px solid #ddd; padding: 8px;">Valeur</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';

			foreach ( $form_data as $field => $value ) {
				echo '<tr>';
				echo '<td style="border: 1px solid #ddd; padding: 8px; font-weight: bold;">' . esc_html( wp_unslash($field) ) . '</td>';

				if ( filter_var( $value, FILTER_VALIDATE_URL ) ) {
					echo '<td style="border: 1px solid #ddd; padding: 8px;"><a href="' . esc_url( $value ) . '" target="_blank">' . esc_html( basename( $value ) ) . '</a></td>';
				} else {
					echo '<td style="border: 1px solid #ddd; padding: 8px;">' . esc_html( $value ) . '</td>';
				}

				echo '</tr>';
			}

			echo '</tbody>';
			echo '</table>';
		} else {
			echo '<p>Aucune donnée disponible pour ce post.</p>';
		}
	}

	public function add_detail() {
		wp_enqueue_media();
		?>
		<div class='block-form'>
			<?php
			$begin = array(
				'type' => 'sectionbegin',
				'id'   => 'easy-form-detail-container',
			);

			$form_title = array(
				'title'             => __( 'The Form title', 'easystepsform' ),
				'name'              => 'easy-form-adding[title]',
				'type'              => 'text',
				'custom_attributes' => array(
					'placeholder' => 'The title',
				),
				'desc'              => __( 'This is the main title of your form.', 'easystepsform' ),
			);

			$form_sub_title = array(
				'title'             => __( 'The form sub title', 'easystepsform' ),
				'name'              => 'easy-form-adding[sub-title]',
				'type'              => 'text',
				'custom_attributes' => array(
					'placeholder' => 'The sub title',
				),
				'desc'              => __( 'This is the secondary title of your form.', 'easystepsform' ),
			);

			$form_description = array(
				'title'             => __( 'The form description', 'easystepsform' ),
				'name'              => 'easy-form-adding[description]',
				'type'              => 'textarea',
				'custom_attributes' => array(
					'placeholder' => 'Description',
				),
				'desc'              => __( 'This is the main description of your form.', 'easystepsform' ),
			);

			$end = array( 'type' => 'sectionend' );

			$settings = apply_filters(
				'easystepsform_scenes_settings',
				array(
					$begin,
					$form_title,
					$form_sub_title,
					$form_description,
					$end,
				)
			);

			echo wp_kses(
				Easy_Steps_Form_Admin_Tools::get_fields( $settings ),
				Easy_Steps_Form_Admin_Tools::get_allowed_tags()
			);

			global $easy_steps_form_tpl;
			?>
			<input type="hidden" name="easy-steps-form-nonce" value="<?php echo esc_attr( wp_create_nonce( 'easy-steps-form-nonce' ) ); ?>"/>
		</div>
		<script>
			var easy_steps_form_tpl =<?php echo json_encode( $easy_steps_form_tpl ); ?>;
		</script>
		<?php
	}

	public function add_pricing_detail() {
		?>
			<div class='block-form'>
				<?php
				$begin = array(
					'type' => 'sectionbegin',
					'id'   => 'easy-form-price-detail-container',
				);

				$wc_product = get_posts(
					array(
						'post_status' => 'publish',
						'post_type'   => 'product',
						'nopaging'    => true,
					)
				);

				$linked_product = array();
				foreach ( $wc_product as $product ) {
					$linked_product[ $product->ID ] = $product->post_title;
				}

				$linked_products = array(
					'title'   => __( 'Link product', 'easystepsform' ),
					'name'    => 'easy-form-adding[link-product]',
					'type'    => 'select',
					'id'      => 'select-stepper-link-product',
					'desc'    => __( 'Select linked product', 'easystepsform' ),
					'options' => $linked_product,
				);

				$pricing_option_title = array(
					'title' => __( 'Pricing option title', 'easystepsform' ),
					'name'  => 'easy-form-adding[pricing-title]',
					'type'  => 'text',
					'desc'  => __( 'This is the pricing option title', 'easystepsform' ),
				);

				$name = array(
					'title'             => __( 'Name', 'easystepsform' ),
					'name'              => 'name',
					'type'              => 'text',
					'custom_attributes' => array(
						'placeholder' => 'The title',
					),
					'desc'              => '',
				);

				$note_name = array(
					'title'             => __( 'Title', 'easystepsform' ),
					'name'              => 'note-name',
					'type'              => 'text',
					'custom_attributes' => array(
						'placeholder' => 'The title',
					),
					'desc'              => '',
				);

				$additional_note = array(
					'title'             => __( 'Additional note', 'easystepsform' ),
					'name'              => 'easy-form-adding[additional-note]',
					'type'              => 'text',
					'custom_attributes' => array(
						'placeholder' => 'The title',
					),
					'desc'              => '',
				);

				$price = array(
					'title'             => __( 'Price (% of linked product price)', 'easystepsform' ),
					'name'              => 'price',
					'type'              => 'number',
					'custom_attributes' => array(
						'placeholder' => 'The title',
						'step'        => 'any',
					),
					'desc'              => '',
				);

				$stepper_options = array(
					'title'           => __( 'Payment type Step', 'easystepsform' ),
					'name'            => 'easy-form-adding[price-step]',
					'type'            => 'repeatable-fields',
					'fields'          => array( $name, $price ),
					'desc'            => '',
					'ignore_desc_col' => true,
					'add_btn_label'   => __( 'Add pricing options', 'easystepsform' ),
				);

				$stepper_note = array(
					'title'           => __( 'Additional Radio note', 'easystepsform' ),
					'name'            => 'easy-form-adding[radio-note]',
					'type'            => 'repeatable-fields',
					'fields'          => array( $note_name ),
					'desc'            => '',
					'ignore_desc_col' => true,
					'add_btn_label'   => __( 'Add radio note', 'easystepsform' ),
				);

				$end = array( 'type' => 'sectionend' );

				$settings = apply_filters(
					'easy-steps-form-pricing-detail-repeatable-fields',
					array(
						$begin,
						$linked_products,
						$pricing_option_title,
						$additional_note,
						$end,
						$begin,
						$stepper_note,
						$end,
						$begin,
						$stepper_options,
						$end,
					)
				);

				echo wp_kses(
					Easy_Steps_Form_Admin_Tools::get_fields( $settings ),
					Easy_Steps_Form_Admin_Tools::get_allowed_tags()
				);

				global $easy_steps_form_tpl;

				?>
				<script>
					var easy_steps_form_tpl =<?php echo json_encode( $easy_steps_form_tpl ); ?>;
				</script>
			</div>
		<?php
	}

	public function add_step_detail() {
		?>
			<div class='block-form'>
				<?php
				$begin = array(
					'type' => 'sectionbegin',
					'id'   => 'easy-form-step-detail-container',
				);

				$step_groups = get_posts(
					array(
						'post_status' => 'publish',
						'post_type'   => 'easy-step-form-step',
						'nopaging'    => true,
					)
				);

				$step_options = array();
				foreach ( $step_groups as $step_group ) {
					$step_options[ $step_group->ID ] = $step_group->post_title;
				}

				$stepper_select = array(
					'title'   => __( 'Select step', 'easystepsform' ),
					'name'    => 'stepper',
					'type'    => 'select',
					'id'      => 'select-stepper',
					'desc'    => __( 'Select step group on this configuration', 'easystepsform' ),
					'options' => $step_options,
				);

				$stepper_options = array(
					'title'           => __( 'Step', 'easystepsform' ),
					'name'            => 'easy-form-adding[steps]',
					'type'            => 'repeatable-fields',
					'fields'          => array( $stepper_select ),
					'desc'            => '',
					'ignore_desc_col' => true,
					'add_btn_label'   => __( 'Add step', 'easystepsform' ),
				);

				$end = array( 'type' => 'sectionend' );

				$settings = apply_filters(
					'easy-steps-form-add-repeatable-fields',
					array(
						$begin,
						$stepper_options,
						$end,
					)
				);

				echo wp_kses(
					Easy_Steps_Form_Admin_Tools::get_fields( $settings ),
					Easy_Steps_Form_Admin_Tools::get_allowed_tags()
				);

				global $easy_steps_form_tpl;

				?>

				<script>
					var easy_steps_form_tpl =<?php echo json_encode( $easy_steps_form_tpl ); ?>;
				</script>
			</div>
		<?php
	}

	/**
	 * Add meta box stepper field detail content.
	 *
	 * @return void
	 */
	public function add_stepper() {
		wp_enqueue_media();
		?>
		<div class='block-form'>
			<?php
			$begin = array(
				'type' => 'sectionbegin',
				'id'   => 'easy-form-stepper-container',
			);

			$stepper_panel_title = array(
				'title' => __( 'Panel title', 'easystepsform' ),
				'name'  => 'easy-form-stepper[panel-title]',
				'type'  => 'text',
				'desc'  => __( 'This is the title of the panel.', 'easystepsform' ),
			);

			$stepper_title = array(
				'title' => __( 'Title', 'easystepsform' ),
				'name'  => 'easy-form-stepper[title]',
				'type'  => 'text',
				'desc'  => __( 'This is the main title of the step.', 'easystepsform' ),
			);

			$stepper_desc = array(
				'title' => __( 'Description', 'easystepsform' ),
				'name'  => 'easy-form-stepper[description]',
				'type'  => 'text',
				'desc'  => __( 'This is the main description of the step.', 'easystepsform' ),
			);

			$stepper_footer_desc = array(
				'title' => __( 'Footer Description', 'easystepsform' ),
				'name'  => 'easy-form-stepper[footer-description]',
				'type'  => 'text',
				'desc'  => __( 'This is the main footer description of the step.', 'easystepsform' ),
			);

			$end = array( 'type' => 'sectionend' );

			$settings = apply_filters(
				'easy-steps-form-stepper-details-fields',
				array(
					$begin,
					$stepper_panel_title,
					$stepper_title,
					$stepper_desc,
					$stepper_footer_desc,
					$end,
				)
			);

			echo wp_kses(
				Easy_Steps_Form_Admin_Tools::get_fields( $settings ),
				Easy_Steps_Form_Admin_Tools::get_allowed_tags()
			);

			?>
			<input type="hidden" name="easy-steps-form-nonce" value="<?php echo esc_attr( wp_create_nonce( 'easy-steps-form-nonce' ) ); ?>"/>
		</div>
		<?php
	}

	/**
	 * Add stepper metabox repeatable field content.
	 *
	 * @return void
	 */
	public function add_stepper_fields() {
		wp_enqueue_media();
		?>
		<div class='block-form'>
			<?php
			$begin = array(
				'type' => 'sectionbegin',
				'id'   => 'easy-form-stepper-field-container',
			);

			$stepper_label = array(
				'title' => __( 'Label', 'easystepsform' ),
				'name'  => 'title',
				'type'  => 'text',
				'desc'  => __( 'This is the label of your field.', 'easystepsform' ),
			);

			$stepper_type = array(
				'title'   => __( 'Type', 'easystepsform' ),
				'name'    => 'type',
				'type'    => 'select',
				'options' => array(
					'text'           => 'Text',
					'number'         => 'Number',
					'textarea'       => 'TextArea',
					'step'           => 'Step',
					'select'         => 'Select',
					'radio'          => 'Radio',
					'checkbox'       => 'Checkbox',
					'date'           => 'Date',
					'datetime'       => 'Datetime',
					'datetime-local' => 'Datetime Local',
					'email'          => 'Email',
					'file'           => 'File',
					'hidden'         => 'Hidden',
					'image'          => 'Image',
					'month'          => 'Month',
					'password'       => 'Password',
					'range'          => 'Range',
					'tel'            => 'Telephone',
					'time'           => 'Time',
					'url'            => 'URL',
					'week'           => 'Week',
				),
				'desc'    => __( 'This is field type.', 'easystepsform' ),
			);

			$stepper_required = array(
				'title'   => __( 'Required', 'easystepsform' ),
				'name'    => 'required',
				'type'    => 'radio',
				'options' => array(
					'yes' => 'yes',
					'no'  => 'no',
				),
				'default' => 'no',
				'desc'    => __( 'This is the label of your field.', 'easystepsform' ),
			);

			$stepper_default = array(
				'title' => __( 'Default Value', 'easystepsform' ),
				'name'  => 'default',
				'type'  => 'text',
				'desc'  => __( 'This is the label of your field.', 'easystepsform' ),
			);

			$stepper_placeholder = array(
				'title' => __( 'Placeholder', 'easystepsform' ),
				'name'  => 'placeholder',
				'type'  => 'text',
				'desc'  => __( 'This is the label of your field.', 'easystepsform' ),
			);

			$radio_label = array(
				'title' => __( 'Label', 'easystepsform' ),
				'name'  => 'label',
				'type'  => 'text',
				'desc'  => __( 'This is the label of your field.', 'easystepsform' ),
			);

			$radio_value = array(
				'title' => __( 'Value', 'easystepsform' ),
				'name'  => 'radio',
				'type'  => 'text',
				'desc'  => __( 'This is the value of your field.', 'easystepsform' ),
			);

			$radio_options = array(
				'title'           => __( 'Options', 'easystepsform' ),
				'name'            => 'radio',
				'type'            => 'repeatable-fields',
				'popup'           => 'popup',
				'popup_button'    => 'Add Options',
				'popup_title'     => 'Add field Options (radio, checkbox, select, file)',
				'fields'          => array( $radio_label, $radio_value ),
				'desc'            => '',
				'ignore_desc_col' => true,
				'add_btn_label'   => __( 'Add options', 'easystepsform' ),
			);

			$stepper_repeatable_group = array(
				'title'           => __( 'Fields', 'easystepsform' ),
				'name'            => 'easy-form-stepper[field]',
				'type'            => 'repeatable-fields',
				'fields'          => array( $stepper_label, $stepper_type, $stepper_required, $stepper_default, $stepper_placeholder, $radio_options ),
				'desc'            => '',
				'ignore_desc_col' => true,
				'add_btn_label'   => __( 'Add field', 'easystepsform' ),
			);

			$end = array( 'type' => 'sectionend' );

			$settings = apply_filters(
				'easy-steps-form-stepper-repeatable-fields',
				array(
					$begin,
					$stepper_repeatable_group,
					$end,
				)
			);

			echo wp_kses(
				Easy_Steps_Form_Admin_Tools::get_fields( $settings ),
				Easy_Steps_Form_Admin_Tools::get_allowed_tags()
			);

			global $easy_steps_form_tpl;
			?>
		</div>
		<script>
			var easy_steps_form_tpl =<?php echo json_encode( $easy_steps_form_tpl ); ?>;
		</script>
		<?php
	}

	/**
	 * Save Stepper post meta.
	 *
	 * @param mixed $post_id The post id.
	 * @return void
	 */
	public function save_stepper( $post_id ) {
		if ( isset( $_POST['easy-steps-form-nonce'] ) ) {
			if ( wp_verify_nonce( wp_unslash( sanitize_key( $_POST['easy-steps-form-nonce'] ) ), 'easy-steps-form-nonce' ) ) {
				if ( isset( $_POST['easy-form-stepper'] ) ) {
					update_post_meta( $post_id, 'easy-form-stepper', $_POST['easy-form-stepper'] );
				}
			}
		}
	}


	/**
	 * Save Stepper post meta.
	 *
	 * @param mixed $post_id The post id.
	 * @return void
	 */
	public function save_add_form( $post_id ) {
		if ( isset( $_POST['easy-steps-form-nonce'] ) ) {
			if ( wp_verify_nonce( wp_unslash( sanitize_key( $_POST['easy-steps-form-nonce'] ) ), 'easy-steps-form-nonce' ) ) {
				if ( isset( $_POST['easy-form-adding'] ) ) {
					update_post_meta( $post_id, 'easy-form-adding', $_POST['easy-form-adding'] );
				}
			}
		}
	}

	/**
	 * Add custom column
	 *
	 * @param mixed $columns
	 * @return mixed
	 */
	public function add_custom_column( $columns ) {
		$columns['easy-form-adding-short-code'] = 'ShortCode';
		return $columns;
	}

		/**
		 * Display custom column.
		 *
		 * @param mixed $column The column name
		 * @param mixed $post_id The post id
		 * @return void
		 */
	public function display_custom_column( $column, $post_id ) {
		if ( 'easy-form-adding-short-code' === $column ) {
			echo '[easy-steps-form id="' . $post_id . '"]';
		}
	}
}
