<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 05/01/18
 * Time: 9.16
 */

class arc_ManageAssets {
	############## METHODS #################
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'load_random_content_assets' ] );
		add_action( 'in_admin_footer', [ $this, 'html_on_footer' ] );
	}

	public function load_random_content_assets() {
		/* STYLE */
		wp_register_style( 'random_content_css', RANDOM_CONTENT_PLUGIN_URL . 'assets/random_content.css', false, '1.6.1' );
		wp_enqueue_style( 'random_content_css' );

		/* SCRIPT */
		wp_enqueue_script( 'random_content_js', RANDOM_CONTENT_PLUGIN_URL . 'assets/random_content.js', false, '2.1.0' );
		wp_localize_script( 'random_content_js', 'random_content_ajax_object', [ 'ajax_url' => admin_url( 'admin-ajax.php' ) ] );
	}

	public function html_on_footer() {
		echo '<div id="container_loader" style="display:none;">
				<h1>Auto Random Content</h1>
				<div id="loading_container">
	                <div id="loader">
	                    <div class="item item-1"></div>
	                    <div class="item item-2"></div>
	                    <div class="item item-3"></div>
	                    <div class="item item-4"></div>
	                </div>
                	<p style="display:none;" id="on_waiting_create">'.__('Generating content ...',RANDOM_CONTENT_PLUGIN_DOMAIN_NAME).'</p>
                	<p style="display:none;" id="on_waiting_delete">'.__('Deleting content ...',RANDOM_CONTENT_PLUGIN_DOMAIN_NAME).'</p>
                	<p style="display:none;" id="create_success">'.__('Content generation completed!',RANDOM_CONTENT_PLUGIN_DOMAIN_NAME).'</p>
                	<p style="display:none;" id="delete_success">'.__('Content cancellation completed!',RANDOM_CONTENT_PLUGIN_DOMAIN_NAME).'</p>
                	<p style="display:none;" id="error_message">'.__('Something went wrong.',RANDOM_CONTENT_PLUGIN_DOMAIN_NAME).'</p>
                </div>
                <span style="display:none;" id="close_modal_random_content">'.__('Close',RANDOM_CONTENT_PLUGIN_DOMAIN_NAME).'</span>
            </div>';
	}
}