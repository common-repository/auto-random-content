<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 21/01/18
 * Time: 00:05
 */

class arc_AutoRandomContentTable {
	############### ATTR ###################
	private $table_name = "random_content";
	public $elements_of_custom_table = null;

	############## METHODS #################
	public function get_elements_of_custom_table() {
		global $wpdb, $table_prefix;

		return $wpdb->get_results( " SELECT * FROM " . $table_prefix . $this->table_name );
	}

	public function clear_table() {
		global $wpdb;
		$table  = $wpdb->prefix . $this->table_name;
		$delete = $wpdb->query( "TRUNCATE TABLE `" . $table . "`" );

		return $delete;
	}
}
