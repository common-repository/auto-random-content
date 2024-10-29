<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 21/01/18
 * Time: 00:19
 */

class arc_Term {
	############ ATTR #############
	private $data = [
		'cat_name'             => null,
		'category_description' => null,
		'category_nicename'    => null,
		'taxonomy'             => null
	];
	private $faker = null;

	########### METHODS ###########
	public function delete( $id ) {
		$term = get_term( $id );
		wp_delete_term( $id, $term->taxonomy );
	}

	public function insert( $tax ) {
		$this->prepare_data( $tax );

		return $term = wp_insert_category( $this->data );
	}

	private function prepare_data( $tax ) {
		gc_collect_cycles();
		$this->faker = Faker\Factory::create( get_locale() );
		$this->data  = array(
			'cat_name'             => $this->faker->realText( 25 ),
			'category_description' => $this->faker->realText( 150 ),
			'category_nicename'    => $this->faker->realText( 25 ),
			'taxonomy'             => $tax
		);
		$this->faker = null;
	}
}