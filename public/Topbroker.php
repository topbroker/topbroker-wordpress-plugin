<?php

use TopBroker\TopBrokerApi;

class Topbroker
{
	public $topbroker;

	/**
	 * Topbroker constructor.
	 * @throws Exception
	 */
	public function __construct() {

		$options = get_option( 'tb_options' );

		if ( empty($options['opt-api-key']) || empty($options['opt-api-pass']) ) {
			throw new Exception('Check API credentials.');
		}

		$this->topbroker = new TopBrokerApi( $options['opt-api-key'], $options['opt-api-pass']);

	}
}

if ( ! function_exists( 'TB' ) ) {
	function TB() {

		try {
			$topbroker = new Topbroker();
			return $topbroker->topbroker;
		} catch (Exception $e) {
			echo 'Message: ' .$e->getMessage();
			exit();
		}

	}
}
