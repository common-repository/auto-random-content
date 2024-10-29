<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 10/01/18
 * Time: 16.31
 */

class arc_ManageUser {
	public $users_list;

	public $number_of_users;

	public $users_id = null;

	public $min_users_number = 5;

	public $user_data;

	public $faker;

	public function __construct() {
		/* create faker obj */
		$this->faker = Faker\Factory::create( get_locale() );

		/* get list of user that current on wp */
		$this->getUsers();

		/* get number of user */
		$this->getNumberOfUsers();
	}

	public function getUsers() {
		$this->users_list = get_users();
	}

	public function getRandomUser() {

		if ( $this->number_of_users < $this->min_users_number ) {
			$this->create_user();
		}

		$index = rand( 0, $this->number_of_users - 1 );

		return $this->users_list[ $index ];
	}

	public function getNumberOfUsers() {
		$this->number_of_users = count( $this->users_list );
	}

	public function create_user() {

		for ( $i = 0; $i < $this->min_users_number; $i ++ ) {
			$this->prepare_data();
			$this->users_id[] = wp_insert_user( $this->user_data );
		}

		/* update users list */
		$this->getUsers();
		/* update number of users */
		$this->getNumberOfUsers();
	}

	public function prepare_data() {
		$this->user_data = [
			"user_pass"       => $this->faker->password,
			"user_login"      => $this->faker->userName,
			"user_nicename"   => $this->faker->realText( rand( 10, 20 ) ),
			"user_url"        => $this->faker->url,
			"user_email"      => $this->faker->email,
			"display_name"    => $this->faker->realText( rand( 10, 20 ) ),
			"nickname"        => $this->faker->realText( rand( 10, 20 ) ),
			"first_name"      => $this->faker->realText( rand( 10, 20 ) ),
			"last_name"       => $this->faker->realText( rand( 10, 20 ) ),
			"description"     => $this->faker->realText( rand( 200, 600 ) ),
			"user_registered" => $this->faker->date( "Y-m-d H:i:s" )
		];
	}

	public function getUsersIdInserted() {
		return $this->users_id;
	}
}