<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 04/01/18
 * Time: 16.00
 */

class arc_ManageLogs {
	############### ATTR ###################
	private $table_name = "random_content";

	############## METHODS #################
	public function registerID( $id, $is_media, $is_term, $is_comment, $is_user ) {
		global $wpdb, $table_prefix;

		$wpdb->insert(
			$table_prefix . $this->table_name,
			array(
				'id_post'    => $id,
				'is_media'   => $is_media,
				'is_term'    => $is_term,
				'is_comment' => $is_comment,
				'is_user'    => $is_user
			)
		);
	}

}