<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 05/01/18
 * Time: 9.09
 */

class arc_ManageAdminBarButton {
	############## METHODS #################
	public function __construct() {
		add_action( 'admin_bar_menu', [ $this, 'add_admin_bar_items' ], 100 );
	}

	public function add_admin_bar_items( $admin_bar ) {
		$admin_bar->add_menu( array(
			'id'    => 'random-content',
			'title' => __( 'Random Content', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME ),
			'href'  => '#',
			'meta'  => array(
				'title' => __( 'Random Content', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME ),
			),
		) );
		$admin_bar->add_menu( array(
			'id'     => 'random-content-create',
			'parent' => 'random-content',
			'title'  => __( 'Create Random Content', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME ),
			'href'   => '#',
			'meta'   => array(
				'title'  => __( 'Create Random Content', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME ),
				'target' => '_blank',
				'class'  => 'my_menu_item_class'
			),
		) );
		$admin_bar->add_menu( array(
			'id'     => 'random-content-delete',
			'parent' => 'random-content',
			'title'  => __( 'Delete Random Content Created!', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME ),
			'href'   => '#',
			'meta'   => array(
				'title'  => __( 'Delete Random Content Created!', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME ),
				'target' => '_blank',
				'class'  => 'my_menu_item_class'
			),
		) );
	}
}