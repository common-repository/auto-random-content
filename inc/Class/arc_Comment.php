<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 21/01/18
 * Time: 00:19
 */

class arc_Comment {
	############### ATTR ###################
	private $data = array(
		'comment_post_ID'      => null,
		'comment_author'       => null,
		'comment_author_email' => null,
		'comment_author_url'   => null,
		'comment_content'      => null,
		'comment_type'         => null,
		'comment_parent'       => null,
		'user_id'              => null,
		'comment_author_IP'    => null,
		'comment_agent'        => null,
		'comment_date'         => null,
		'comment_approved'     => null,
	);
	private $faker = null;

	############## METHODS #################
	public function insert( $post_id, $author_id ) {
		$this->prepare_data( $post_id, $author_id );

		return wp_insert_comment( $this->data );
	}

	private function prepare_data( $post_id, $author ) {
		gc_collect_cycles();
		$this->faker = Faker\Factory::create( get_locale() );
		$this->data  = array(
			'comment_post_ID'      => $post_id,
			'comment_author'       => $author->data->user_nicename,
			'comment_author_email' => $author->data->user_email,
			'comment_author_url'   => '',
			'comment_content'      => $this->faker->realText( rand( 100, 600 ) ),
			'comment_type'         => '',
			'comment_parent'       => 0,
			'user_id'              => $author->data->ID,
			'comment_author_IP'    => $this->faker->ipv4,
			'comment_agent'        => $this->faker->userAgent,
			'comment_date'         => $this->faker->date( "Y-m-d H:i:s" ),
			'comment_approved'     => 1,
		);
		$this->faker = null;
	}

	public function delete( $id ) {
		wp_delete_comment( $id );
	}
}