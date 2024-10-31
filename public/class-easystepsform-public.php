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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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

	}

	public function register_shortcodes() {
		add_shortcode( 'easy-steps-form', array( $this, 'get_form_content' ) );
	}

	public function get_form_content( $attr ) {
		ob_start();

		if ( is_array( $attr ) && isset( $attr['id'] ) ) {
			$builder = new Easy_Steps_Form_Content( $attr['id'] );
			echo wp_kses($builder->get_content(), Easy_Steps_Form_Admin_Tools::get_allowed_tags());
		}

		return ob_get_clean();
	}

}
