<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ba329.com
 * @since             1.0.0
 * @package           Top_Broker
 *
 * @wordpress-plugin
 * Plugin Name:       TopBroker
 * Plugin URI:        https://ba329.com
 * Description:       Plugin boilerplate to demonstrate for Topbroker API
 * Version:           1.0.0
 * Author:            BA329
 * Author URI:        https://ba329.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       top-broker
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

define('TB_ESTATE_TEMPLATE', 'list-estates.php');

define('TB_USERS_TEMPLATE', 'list-brokers.php');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-top-broker-activator.php
 */
function activate_top_broker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-top-broker-activator.php';
	Top_Broker_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-top-broker-deactivator.php
 */
function deactivate_top_broker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-top-broker-deactivator.php';
	Top_Broker_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_top_broker' );
register_deactivation_hook( __FILE__, 'deactivate_top_broker' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-top-broker.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_top_broker() {

	$plugin = new Top_Broker();
	$plugin->run();

}
run_top_broker();
