<?php

/**
 * Fired during plugin activation
 *
 * @link       https://ba329.com
 * @since      1.0.0
 *
 * @package    Top_Broker
 * @subpackage Top_Broker/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Top_Broker
 * @subpackage Top_Broker/includes
 * @author     BA329 <hello@ba329.com>
 */
class Top_Broker_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $wpdb;

		// TODO: norint post_title gauti is options reikalingas papildomas workaround'as
		// su laikinu options (topbroker_plugin_activated) ar pns.
		// Aktivacijos metu kuriame laikina options, tada velesniame WP gyvavimo cikle tikrinam ar yra tas options ir
		// jei jis yra atliekame veiksmus pvz. galime pasiekti get_option( 'tb_options' ). Po to butinai istriname kaikina options.

		$ESTATES_TEMPLATE = TB_ESTATE_TEMPLATE;
		$USERS_TEMPLATE = TB_USERS_TEMPLATE;

		$page_estates_id = $wpdb->get_var("SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` = '_wp_page_template' AND `meta_value` = '{$ESTATES_TEMPLATE}'");
		$page_brokers_id = $wpdb->get_var("SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` = '_wp_page_template' AND `meta_value` = '{$USERS_TEMPLATE}'");

		if ( empty($page_estates_id) ) {
			$page_estates_id = wp_insert_post([
				'post_title' => 'Estates',
				'post_type' => 'page',
				'post_status' => 'publish',
				'post_author' => 1,
			]);
		}

		if ( empty($page_brokers_id) ) {
			$page_brokers_id = wp_insert_post([
				'post_title' => 'Brokers',
				'post_type' => 'page',
				'post_status' => 'publish',
				'post_author' => 1,
			]);
		}

		if ( $page_estates_id ) {
			update_post_meta( $page_estates_id, '_wp_page_template', $ESTATES_TEMPLATE );
		}

		if ( $page_brokers_id ) {
			update_post_meta( $page_brokers_id, '_wp_page_template', $USERS_TEMPLATE );
		}

		flush_rewrite_rules();

	}

}
