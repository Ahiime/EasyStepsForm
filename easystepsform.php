<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.blyd3d.com
 * @since             1.0.0
 * @package           Easystepsform
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Steps Form
 * Plugin URI:        https:// https://github.com/Ahiime/
 * Description:       This multistep form plugin simplifies the creation of multi-stage forms, providing users with a smooth and guided experience. Designed for easy integration and high customizability, it allows adding progressive form sections with clear steps, saving user responses at each step and validating input in real-time. Ideal for registration forms, surveys, payment processes, and any other multi-step workflows, this plugin is straightforward to set up and supports intuitive navigation with Next and Previous buttons, progress indicators, and customization options for each step.
 * Version:           1.0.0
 * Author:            Ahime
 * Author URI:        https://www.blyd3d.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       easystepsform
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EASYSTEPSFORM_VERSION', '1.0.0' );
define( 'EASYSTEPSFORM_URL', plugins_url( '/', __FILE__ ) );
define( 'EASYSTEPSFORM_DIR', dirname( __FILE__ ) );

$upload_dir      = wp_upload_dir();
$generation_path = $upload_dir['basedir'] . '/EASYSTEPSFORM/';
$generation_url  = $upload_dir['baseurl'] . '/EASYSTEPSFORM/';

define( 'EASYSTEPSFORM_IMAGE_PATH', $generation_path . 'image' );
define( 'EASYSTEPSFORM_IMAGE_URL', $generation_url . 'image' );

if ( ! defined( 'DIRECTORY_SEPARATOR' ) ) {
	define( 'DIRECTORY_SEPARATOR', '/' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-easystepsform-activator.php
 */
function activate_easystepsform() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-easystepsform-activator.php';
	Easystepsform_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-easystepsform-deactivator.php
 */
function deactivate_easystepsform() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-easystepsform-deactivator.php';
	Easystepsform_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_easystepsform' );
register_deactivation_hook( __FILE__, 'deactivate_easystepsform' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-easystepsform.php';

if ( ! class_exists( 'Easy_Steps_Form_Admin_Tools' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/kali-admin-tools/kali-admin-tools.php';
}

require_once plugin_dir_path( __FILE__ ) . 'public/partials/easystepsform-public-display.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_easystepsform() {

	$plugin = new Easystepsform();
	$plugin->run();

}
run_easystepsform();
