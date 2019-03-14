<?php

use TopBroker\TopBrokerApi;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ba329.com
 * @since      1.0.0
 *
 * @package    Top_Broker
 * @subpackage Top_Broker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Top_Broker
 * @subpackage Top_Broker/admin
 * @author     BA329 <hello@ba329.com>
 */
class Top_Broker_Admin {

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

	private $estate_template;

	private $users_template;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $estate_template, $users_template ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->estate_template = $estate_template;
		$this->users_template = $users_template;

		$this->templates = [
			$this->estate_template => __('TopBroker Estates list','tb'),
			$this->users_template => __('TopBroker Users list','tb'),
		];

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
		 * defined in Top_Broker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Top_Broker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/top-broker-admin.css', array(), $this->version, 'all' );

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
		 * defined in Top_Broker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Top_Broker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/top-broker-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function theme_page_templates( $posts_templates ) {

		return array_merge( $posts_templates, $this->templates );

	}

	public function wp_insert_post_data( $atts ) {

		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
		$templates = wp_get_theme()->get_page_templates();

		if ( empty( $templates ) ) {
			$templates = [];
		}

		wp_cache_delete( $cache_key , 'themes');

		$templates = array_merge( $templates, $this->templates );

		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;

	}

	public function template_include( $template ) {

		global $post;

		if ( ! $post ) {
			return $template;
		}

		if ( ! isset( $this->templates[get_post_meta(
				$post->ID, '_wp_page_template', true
			)] ) ) {
			return $template;
		}

		$plugin_file = plugin_dir_path( __DIR__ ) . 'templates' . DIRECTORY_SEPARATOR . get_post_meta(
				$post->ID, '_wp_page_template', true
			);

		$theme_override_file = get_template_directory() . DIRECTORY_SEPARATOR . $this->plugin_name . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . get_post_meta(
				$post->ID, '_wp_page_template', true );

		if ( file_exists( $theme_override_file ) ) {
			return $theme_override_file;
		} else if ( file_exists( $plugin_file ) ) {
			return $plugin_file;
		} else {
			wp_die('Error: template file not fount');
		}

		return $template;

	}

	public function generate_rewrite_rules($wp_rewrite) {

		global $wpdb;

		$estates_page_id = $wpdb->get_var("SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` = '_wp_page_template' AND `meta_value` = '{$this->estate_template}'");
		$brokers_page_id = $wpdb->get_var("SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` = '_wp_page_template' AND `meta_value` = '{$this->users_template}'");
		$page_estates_slug = get_post_field('post_name', $estates_page_id);
		$page_brokers_slug = get_post_field('post_name', $brokers_page_id);

		$wp_rewrite->rules = array_merge(
			[$page_estates_slug.'/[^/]*\D(\d+)/?$' => 'index.php?estate_id=$matches[1]'],
			$wp_rewrite->rules
		);

		$wp_rewrite->rules = array_merge(
			[$page_brokers_slug.'/[^/]*\D(\d+)/?$' => 'index.php?broker_id=$matches[1]'],
			$wp_rewrite->rules
		);

	}

	public function query_vars($query_vars) {
		$query_vars[] = 'estate_id';
		$query_vars[] = 'broker_id';
		return $query_vars;
	}

	public function activated_plugin_redirect() {
		exit( wp_redirect( admin_url( 'admin.php?page=tb_options' ) ) );
	}

	public function csf_tb_options_save_before( $options ) {

		if ( empty($options['opt-api-key']) || empty($options['opt-api-pass']) ) {

			wp_send_json_error( array( 'success' => false, 'error' => esc_html__( "Please fill up API credentials!", 'csf' ) ) );

		} else {

			try {

				$topbroker = new TopBrokerApi( $options['opt-api-key'], $options['opt-api-pass']);
				$topbroker->locations->getMunicipalities();

			} catch (\Exception $e) {

				wp_send_json_error( array( 'success' => false, 'error' => esc_html__( "Bad API credentials. Check username and/or password", 'csf' ) ) );

			}

		}

	}

}
