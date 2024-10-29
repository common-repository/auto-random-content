<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 17/06/18
 * Time: 14:31
 */

class arc_DashBoardWidget {

	public function __construct() {
		add_action( 'wp_dashboard_setup', [ $this, 'set_new_dashboard_widget' ] );
	}

	public function set_new_dashboard_widget() {
		wp_add_dashboard_widget( RANDOM_CONTENT_PLUGIN_DOMAIN_NAME, 'Auto Random Content', [
			$this,
			'dashboard_widget_function'
		] );

	}

	public function dashboard_widget_function() {
		// Display whatever it is you want to show.
		echo "<strong>This plugin use the external web service of <a target='_blank' href='https://lorempixel.com/'>Lorem Pixel</a></strong>";
		echo "<p>Below you can see the state of service :<br></p>";

		if ( $this->isDomainAvailable( "https://lorempixel.com/" ) ) {
			echo "<p style='color:green'>The service is up</p>";
		} else {
			echo "<p style='color:red'>The service is down</p>";
		}

	}

	public function isDomainAvailable( $domain ) {
		//check, if a valid url is provided
		if ( ! filter_var( $domain, FILTER_VALIDATE_URL ) ) {
			return false;
		}

		//initialize curl
		$curlInit = curl_init( $domain );
		curl_setopt( $curlInit, CURLOPT_CONNECTTIMEOUT, 5 );
		curl_setopt( $curlInit, CURLOPT_HEADER, true );
		curl_setopt( $curlInit, CURLOPT_NOBODY, true );
		curl_setopt( $curlInit, CURLOPT_RETURNTRANSFER, true );

		$response = curl_exec( $curlInit );

		curl_close( $curlInit );

		if ( $response ) {
			return true;
		}

		return false;
	}

}