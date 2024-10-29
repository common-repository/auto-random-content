<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 21/01/18
 * Time: 11:47
 */

class arc_Taxonomy {
	############## METHODS ###############
	public static function get_terms( $taxonomy ) {
		return get_terms(
			$taxonomy,
			array(
				'hide_empty' => false,
			)
		);
	}
}