<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ba329.com
 * @since      1.0.0
 *
 * @package    Top_Broker
 * @subpackage Top_Broker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Top_Broker
 * @subpackage Top_Broker/public
 * @author     BA329 <hello@ba329.com>
 */
class Top_Broker_Public {

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
		 * defined in Top_Broker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Top_Broker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/topbroker.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/topbroker.js', array( 'jquery' ), $this->version, false );

	}

	private static function format_estate_slug($object) {
		$segment_1 = '';
		$street_title = '';
		$city_title = '';

		if ( $object->for_sale ) {
			$segment_1 = __('for-sale','tb');
		}

		if ( $object->for_rent ) {
			$segment_1 = __('for-rent','tb');
		}

		switch ($object->estate_type)
		{
			case 'house':
				$segment_2 = __('house','tb');
				break;

			case 'flat':
				$segment_2 = __('flat','tb');
				break;

			default:
				$segment_2 = $object->estate_type;
		}

		if ( !empty($object->street_title) ) {
			$street_title = $object->street_title;
		}

		if ( !empty($object->city_title) ) {
			$city_title = $object->city_title;
		}

		$segment_3 = $street_title . ' ' . $city_title;

		return sanitize_title( $segment_1 . ' ' . $segment_2 . ' ' . $segment_3 . ' ' . $object->id );
	}

	private static function format_broker_slug($estate) {
		return sanitize_title( $estate->name . '-' . $estate->id );
	}

	public function template_redirect($template) {

		$estate_id = intval( get_query_var( 'estate_id' ) );
		$broker_id = intval( get_query_var( 'broker_id' ) );
		$template_file = false;

		if ( $estate_id ) {
			$template_file = 'single-estate.php';
		}

		if ( $broker_id ) {
			$template_file = 'single-broker.php';
		}

		if ( empty($estate_id) && empty($broker_id) ) {
			return $template;
		}

		$plugin_file = plugin_dir_path( __DIR__ ) . 'templates' . DIRECTORY_SEPARATOR . $template_file;

		$theme_override_file = get_template_directory() . DIRECTORY_SEPARATOR . $this->plugin_name . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $template_file;

		if ( file_exists( $theme_override_file ) ) {
			return $theme_override_file;
		} else if ( file_exists( $plugin_file ) ) {
			return $plugin_file;
		}

		return $template;

	}

	public static function get_permalink( $estate, $type ) {

		$url = '';

		switch ($type)
		{
			case 'estate':
				$url = self::format_estate_slug($estate);
				break;

			case 'user':
				$url = self::format_broker_slug($estate);
				break;
		}

		return $url;
	}

	public static function get_pagination($params) {
		$estates_count = TB()->estates->getCount($params)->records;
		$pages_count = (int) ceil($estates_count / $params['per_page']);
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$base_url = $protocol . $_SERVER["HTTP_HOST"].explode('?', $_SERVER["REQUEST_URI"], 2)[0];
		$output = '';

		for($i = 1; $i <= $pages_count; $i++) {
			$page  = $base_url . '?action=search_estate&pg=' . $i;
			$output .= "<a href='$page'>$i</a>";
		}

		echo $output;
	}

}
