<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 08/01/18
 * Time: 16.10
 */

class arc_TermCreator {
	public $number_of_term = null;

	public $taxonomy = null;

	public $faker;

	public $term_data = array(
		'cat_name'             => null,
		'category_description' => null,
		'category_nicename'    => null,
		'taxonomy'             => null,
	);

	public function __construct( $numberterm, $taxonomy ) {
		$this->setNumberofterm( $numberterm );
		$this->setGenericTax( $taxonomy );
	}

	public function setNumberofterm( $numberterm ) {
		$this->number_of_term = $numberterm;
	}

	public function setGenericTax( $taxonomy ) {
		$this->taxonomy = $taxonomy;
	}

	public function boot() {
		for ( $i = 0; $i < $this->number_of_term; $i ++ ) {
			$this->setTaxonomy( $this->taxonomy );
			$this->setFaker();
			$this->setData();
			$term       = $this->generateTerm();
			$managelogs = new arc_ManageLogs();
			$managelogs->registerID( $term, false, true );
		}
	}

	public function setTaxonomy( $tax ) {
		$this->term_data['taxonomy'] = $tax;
	}

	private function setFaker() {
		$this->faker = Faker\Factory::create( get_locale() );
	}

	public function setData() {
		$this->term_data = array(
			'cat_name'             => $this->faker->realText( 25 ),
			'category_description' => $this->faker->realText( 150 ),
			'category_nicename'    => $this->faker->realText( 25 ),
			'taxonomy'             => $this->taxonomy
		);
	}

	public function generateTerm() {
		return $term = wp_insert_category( $this->term_data );
	}
}