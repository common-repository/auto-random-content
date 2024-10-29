<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 04/01/18
 * Time: 17.01
 */

class arc_ManageDeletion {
	private $table_name = "random_content";

	public function getlistofelement() {
		global $wpdb, $table_prefix;
		$list = $wpdb->get_results( " SELECT * FROM " . $table_prefix . $this->table_name );

		return $list;
	}

	public function deleteMedia( $id ) {

		wp_delete_attachment( $id, true );
	}

	public function deletePost( $id ) {
		wp_delete_post( $id, true );
	}

	public function cleartable() {
		global $wpdb;
		$table  = $wpdb->prefix . $this->table_name;
		$delete = $wpdb->query( "TRUNCATE TABLE `" . $table . "`" );
	}

	public function deleteTerm( $id ) {
		$term = get_term( $id );
		wp_delete_term( $id, $term->taxonomy );
	}

	public function deleteComment( $id ) {
		wp_delete_comment( $id );
	}

	public function deleteUser( $id ) {
		wp_delete_user( $id );
	}
}