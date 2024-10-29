<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 24/01/18
 * Time: 18:47
 */

class arc_ManageAjaxRequest {
############### ATTR ##################
	private $plugin_option_data = null;

############## METHODS #################
	public function __construct() {
		$this->get_plugin_data();
		$this->setAction();
	}

	private function get_plugin_data() {
		/* READ INFORMATION ABOUT OPTION PAGE [ NUMBER OF POSTS THAT MUST CREATED AND THE POST TYPE ]  */
		$this->plugin_option_data = get_option( 'random_content_option_name' );
	}

	public function setAction() {
		add_action( 'wp_ajax_get_taxs', [ $this, 'get_taxs' ] );
		add_action( 'wp_ajax_get_post_support', [ $this, 'get_post_support' ] );
	}

	public function get_taxs() {
		if ( ! empty( $_POST['post_type'] ) ) {
			$taxs_objs = get_object_taxonomies( $_POST['post_type'], 'objects' );
			if ( count( $taxs_objs ) > 0 ) {
				$taxs['taxs'] = [];
				foreach ( $taxs_objs as $tax ) {
					if ( $tax->show_in_menu == true ) {
						$tax_to_send = [
							"text_option"  => $tax->label,
							"value_option" => $tax->name
						];
						array_push( $taxs['taxs'], $tax_to_send );
					}
				}
			}
			$taxs['selected'] = $this->plugin_option_data['post_taxonomy'] ?? null;
			echo json_encode( $taxs );
		} else {
			echo json_encode( false );
		}
		wp_die();
	}

	public function get_post_support() {
		if ( ! empty( $_POST['post_type'] ) && ! empty( $_POST['support'] ) ) {
			echo json_encode( post_type_supports( $_POST['post_type'], $_POST['support'] ) );
		} else {
			echo json_encode( false );
		}
		wp_die();
	}
}