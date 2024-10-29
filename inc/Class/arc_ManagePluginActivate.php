<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 04/01/18
 * Time: 14.19
 */

class arc_ManagePluginActivate {
	############### ATTR ###################
	private $table_name = "random_content";

	############## METHODS #################
	public function __construct() {
		register_activation_hook( RANDOM_CONTENT_DIR_FOR_ACTIVATE_PLUGIN, [ $this, 'create_log_table' ] );
	}

	public function create_log_table() {
		global $table_prefix, $wpdb;
		$wpdb_collate = $wpdb->collate;
		$table_name =$table_prefix . $this->table_name;
		$sql = "CREATE TABLE IF NOT EXISTS  {$table_name} (
              id INT(128) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              id_post INT (128),
              is_media boolean not null,
              is_term boolean not null,
              is_comment boolean not null,
			  is_user boolean not null
            )
             COLLATE {$wpdb_collate}";

		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}