<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 21/01/18
 * Time: 00:19
 */

class arc_User {
	############### ATTR ##############
	private $data = [
		"user_pass"       => null,
		"user_login"      => null,
		"user_nicename"   => null,
		"user_url"        => null,
		"user_email"      => null,
		"display_name"    => null,
		"nickname"        => null,
		"first_name"      => null,
		"last_name"       => null,
		"description"     => null,
		"user_registered" => null
	];
	private $faker = null;

	########### METHODS ###########
	public function delete( $id ) {
		wp_delete_user( $id );
	}

	public function insert() {
		$this->prepare_data();

		return wp_insert_user( $this->data );
	}

	private function prepare_data() {
		gc_collect_cycles();
		$this->faker = Faker\Factory::create( get_locale() );
		$this->data  = [
			"user_pass"       => $this->faker->password,
			"user_login"      => $this->faker->userName,
			"user_nicename"   => $this->faker->name,
			"user_url"        => $this->faker->url,
			"user_email"      => $this->faker->email,
			"display_name"    => $this->faker->name,
			"nickname"        => $this->faker->name,
			"first_name"      => $this->faker->firstName,
			"last_name"       => $this->faker->lastName,
			"description"     => $this->faker->realText( rand( 200, 600 ) ),
			"user_registered" => $this->faker->date( "Y-m-d H:i:s" )
		];
		$this->faker = null;
	}

	public static function get_users_list() {
		return get_users();
	}
}