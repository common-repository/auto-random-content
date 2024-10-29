<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 19/01/18
 * Time: 19:52
 */

class arc_CommentsCreator {

	private $post_id;
	private $faker;
	private $comments_id = [];

	private $users = null;

	public function __construct( $post_id ) {
		$this->set_post_id( $post_id );
		$this->set_faker();
	}

	public function generateComments( $min, $max ) {
		$this->start_procedure( $this->set_number_of_comments( $min, $max ) );

		return $this->comments_id;
	}

	public function set_post_id( $post_id ) {
		$this->post_id = $post_id;
	}

	public function set_number_of_comments( $min, $max ) {
		$number_of_comments = rand( $min, $max );

		return $number_of_comments;
	}

	public function start_procedure( $number_of_post ) {
		/* get users list */
		$this->users = get_users();
		for ( $i = 0; $i < $number_of_post; $i ++ ) {
			$this->comments_id[] = wp_insert_comment( $this->prepare_data_comment() );
		}
	}

	public function prepare_data_comment() {

		$index = rand( 0, count( $this->users ) - 1 );

		$data = array(
			'comment_post_ID'      => $this->post_id,
			'comment_author'       => $this->users[ $index ]->data->user_nicename,
			'comment_author_email' => $this->users[ $index ]->data->user_email,
			'comment_author_url'   => '',
			'comment_content'      => $this->faker->realText( rand( 300, 2000 ) ),
			'comment_type'         => '',
			'comment_parent'       => 0,
			'user_id'              => $this->users[ $index ]->data->ID,
			'comment_author_IP'    => $this->faker->ipv4,
			'comment_agent'        => $this->faker->userAgent,
			'comment_date'         => $this->faker->date( "Y-m-d H:i:s" ),
			'comment_approved'     => 1,
		);

		return $data;

	}

	public function set_faker() {
		$this->faker = Faker\Factory::create( get_locale() );
	}


}