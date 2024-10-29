<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 04/01/18
 * Time: 11.18
 */

class arc_PostCreator {
	public $post_number;

	public $post_type;

	public $post_taxs = null;

	public $term_id = null;

	public $post_data = array(
		"post_title"     => null,
		"post_content"   => null,
		"post_type"      => null,
		"post_excerpt"   => null,
		"post_date"      => null,
		"post_status"    => null,
		"comment_status" => null,
	);

	public $comments_ids;

	public $faker;

	public $post_id;

	public $mediaCreator;

	public $user;

	public $users_id = null;

	public function boot( $post_number, $post_type ) {

		$this->setPostnumber( $post_number );
		$this->setPosttype( $post_type );
		$this->setTaxonomy();
		$this->setFaker();
		$this->start_procedure();
	}

	private function start_procedure() {
		for ( $i = 0; $i < $this->post_number; $i ++ ) {

			/* get random user for author */
			$manageUser     = new arc_ManageUser();
			$this->user     = $manageUser->getRandomUser();
			$this->users_id = $manageUser->getUsersIdInserted();

			/* create post */
			$this->prepare_data();
			$this->insert_post();

			/* if the post selected have taxonomy so i need to associate the post to term taxonomy */
			if ( count( $this->post_taxs ) > 0 ) {
				/* i need to know how many term have the first taxonomy's post */
				$terms = get_terms(
					$this->post_taxs[0],
					array(
						'hide_empty' => false,
					)
				);

				/* if the number of terms is <= 1 so i need to generate create taxonomy */
				if ( count( $terms ) <= 2 ) {
					$termcreator = new arc_TermCreator( 5, $this->post_taxs[0] );
					$termcreator->boot();
				}

				$this->set_term_to_post();
			}

			/* create image thumb */
			$this->mediaCreator = new arc_MediaCreator();
			$attach_id          = $this->mediaCreator->createImage( $this->post_id );

			/* set image to post */
			$this->mediaCreator->setImagetoPost( $this->post_id, $attach_id );


			###################################### REGISTER INTO CUSTOM TABLE ####################################
			$managelogs = new arc_ManageLogs();
			if ( comments_open( $this->post_id ) ) {
				$comment_creator    = new arc_CommentsCreator( $this->post_id );
				$this->comments_ids = $comment_creator->generateComments( 0, 10 );
				if ( ! empty( $this->comments_ids ) ) {
					foreach ( $this->comments_ids as $comments_id ) {
						$managelogs->registerID( $comments_id, false, false, true, false );
					}
				}
			}

			if ( ! empty( $this->users_id ) ) {
				foreach ( $this->users_id as $user_id ) {
					$managelogs->registerID( $user_id, false, false, false, true );
				}
			}

			$managelogs->registerID( $this->post_id, false, false, false, false );
			$managelogs->registerID( $attach_id, true, false, false, false );
			#################################### END REGISTER INTO CUSTOM TABLE ###################################
		}


	}


	private function prepare_data() {
		$this->post_data["post_title"]     = $this->faker->realText( rand( 10, 50 ) );
		$this->post_data["post_content"]   = $this->faker->realText( rand( 300, 2000 ) );
		$this->post_data["post_excerpt"]   = $this->faker->text( rand( 50, 300 ) );
		$this->post_data["post_date"]      = $this->faker->date( "Y-m-d H:i:s" );
		$this->post_data['post_type']      = $this->post_type;
		$this->post_data["post_status"]    = "publish";
		$this->post_data['post_author']    = $this->user->data->ID;
		$this->post_data['comment_status'] = $this->setCommentStatus();
	}

	private function insert_post() {
		$this->post_id = wp_insert_post( $this->post_data );
	}

	private function setPostnumber( $post_number ) {
		$this->post_number = $post_number;
	}

	private function setPosttype( $post_type ) {
		$this->post_type = $post_type;
	}

	private function setFaker() {
		$this->faker = Faker\Factory::create( get_locale() );
	}

	private function set_term_to_post() {
		$category = get_terms(
			$this->post_taxs[0],
			array(
				'hide_empty' => false,
			)
		);

		$number_of_cat = count( $category );
		$index         = rand( 0, ( $number_of_cat - 1 ) );
		wp_set_post_terms( $this->post_id, array( $category[ $index ]->term_id ), $this->post_taxs[0] );

	}

	private function setTaxonomy() {
		$this->post_taxs = get_object_taxonomies( $this->post_type );
	}

	public function setCommentStatus() {
		$element = [ "open", "closed" ];
		$index   = rand( 0, 1 );

		return $element[ $index ];

	}
}