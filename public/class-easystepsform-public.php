<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.blyd3d.com
 * @since      1.0.0
 *
 * @package    Easystepsform
 * @subpackage Easystepsform/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Easystepsform
 * @subpackage Easystepsform/public
 * @author     Ahime <info@blyd3d.com>
 */
class Easystepsform_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easystepsform-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_register_script( 'jquery-validate', plugin_dir_url( __FILE__ ) . 'js/jquery.validate.js', array( 'jquery' ), '1.0', true );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/easystepsform-public.js', array( 'jquery', 'jquery-validate' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name,
			'easyStepsForm',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	public function register_shortcodes() {
		add_shortcode( 'easy-steps-form', array( $this, 'get_form_content' ) );
	}

	public function get_form_content( $attr ) {
		ob_start();

		if ( is_array( $attr ) && isset( $attr['id'] ) ) {
			$builder = new Easy_Steps_Form_Content( $attr['id'] );
			echo wp_kses( $builder->get_content(), Easy_Steps_Form_Admin_Tools::get_allowed_tags() );
		}

		return ob_get_clean();
	}


	/**
	 * Stores form data in a meta post as a structured table.
	 *
	 * @param int $post_id The post ID to which the form data should be linked.
	 */
	public function save_post_meta() {
		$meta_data = array();
		$errors    = array();

		foreach ( $_POST as $field => $value ) {
			$clean_data     = sanitize_text_field( $value );
			$meta_data[ $field ] = $clean_data;
		}

		foreach ( $_FILES as $field => $file ) {
			if ( $file['error'] === UPLOAD_ERR_OK ) {
				$allowed_types = array( 'image/jpeg', 'image/png', 'application/pdf', 'text/plain' );
				$file_type     = mime_content_type( $file['tmp_name'] );

				if ( in_array( $file_type, $allowed_types ) ) {
					$upload_dir  = wp_upload_dir();
					$target_path = $upload_dir['path'] . '/' . basename( $file['name'] );

					if ( move_uploaded_file( $file['tmp_name'], $target_path ) ) {
						$meta_data[ $field ] = $upload_dir['url'] . '/' . basename( $file['name'] );
					} else {
						$errors[] = "Failed to save file : " . $file['name'];
					}
				} else {
					$errors[] = 'Unauthorized file type : ' . $file['name'];
				}
			}
		}

		$args = array(
			'post_type'      => 'easy-step-form-input',
			'meta_key'       => 'easy-step-form-input',
			'meta_value'     => 'unread',
			'posts_per_page' => -1,
		);

		$read_posts = count( get_posts( $args ) );


		$post_id = wp_insert_post(
			array(
				'post_status' => 'publish',
				'post_type'   => 'easy-step-form-input',
				'post_title'  => 'Requete ' . get_the_title( $_POST['form-id'] ),
			)
		);

		update_post_meta( $post_id, 'easy-step-form-input', $meta_data );
		update_post_meta( $post_id, 'easy-step-form-input-status', 'unread' );

		$added = WC()->cart->add_to_cart($_POST['link-product'], 1);

		$cart_url = wc_get_cart_url();

		return empty( $errors ) ? array( 'success' => 'The data has been recorded.', 'cart_url' => $cart_url ) : array( 'error' => $errors );
	}

	/**
	 * Process data received 
	 * @return void
	 */
	public function process_ajax_data() {
		check_ajax_referer( 'easy-steps-form-nonce', 'easy-steps-form-nonce' );

		$result = $this->save_post_meta();

		wp_send_json( $result );
	}
}
