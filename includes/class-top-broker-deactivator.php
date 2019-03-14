<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://ba329.com
 * @since      1.0.0
 *
 * @package    Top_Broker
 * @subpackage Top_Broker/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Top_Broker
 * @subpackage Top_Broker/includes
 * @author     BA329 <hello@ba329.com>
 */
class Top_Broker_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

}
