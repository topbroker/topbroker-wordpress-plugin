<?php

if( class_exists( 'CSF' ) ) {

	//
	// Set a unique slug-like ID
	$prefix = 'tb_options';

	//
	// Create options
	CSF::createOptions( $prefix, array(
		'menu_title' => 'TopBroker',
		'menu_slug'  => 'tb_options',
		'theme' => 'light'
	) );

	//
	// Create a section
	CSF::createSection( $prefix, array(
		'title'  => 'TopBroker API',
		'fields' => [
			[
				'id'    => 'opt-api-key',
				'type'  => 'text',
				'title' => 'API key',
			],
			[
				'id'    => 'opt-api-pass',
				'type'  => 'text',
				'title' => 'API pass',
			],
		]
	) );

	//
	// Create a section
	CSF::createSection( $prefix, array(
		'title'  => 'Pages',
		'fields' => [
			[
				'id'    => 'opt-estates-title',
				'type'  => 'text',
				'title' => 'Estates page title',
				'default' => 'Estates'
			],
			[
				'id'    => 'opt-users-title',
				'type'  => 'text',
				'title' => 'Users page title',
				'default' => 'Users'
			],
		]
	) );

}