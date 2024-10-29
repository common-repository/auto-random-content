<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 21/01/18
 * Time: 00:18
 */

class arc_Post {
	############### ATTR #################
	private $data = array(
		"post_title"     => null,
		"post_content"   => null,
		"post_type"      => null,
		"post_excerpt"   => null,
		"post_date"      => null,
		"post_status"    => null,
		"comment_status" => null,
	);

	private $faker = null;

	############## METHODS ###############
	public function insert( $post_type, $author ) {
		$this->prepare_data( $post_type, $author );

		return wp_insert_post( $this->data );
	}

	public function delete( $id ) {
		wp_delete_post( $id, true );
	}

	private function prepare_data( $post_type, $author ) {
		gc_collect_cycles();
		$this->faker                  = Faker\Factory::create( get_locale() );
		$this->data["post_title"]     = $this->faker->realText( rand( 10, 50 ) );
		$this->data["post_content"]   = $this->faker->realText( rand( 300, 2000 ) );
		$this->data["post_excerpt"]   = $this->faker->text( rand( 50, 300 ) );
		$this->data["post_date"]      = $this->faker->date( "Y-m-d H:i:s" );
		$this->data['post_type']      = $post_type;
		$this->data["post_status"]    = "publish";
		$this->data['post_author']    = $author->data->ID;
		$this->data['comment_status'] = $this->get_comment_status();
		$this->faker                  = null;
	}

	public static function get_post_taxonomies( $post_type ) {
		$taxs_objs = get_object_taxonomies( $post_type, 'objects' );
		$taxs      = [];
		if ( count( $taxs_objs ) > 0 ) {
			foreach ( $taxs_objs as $tax ) {
				if ( $tax->show_in_menu == true ) {
					array_push( $taxs, $tax->name );
				}
			}
		}

		return $taxs;
	}

	public function get_comment_status() {
		$element = [ "open", "closed" ];
		$index   = rand( 0, 1 );

		return $element[ $index ];

	}

	public function set_term( $post_id, $term_id, $tax ) {
		wp_set_post_terms( $post_id, array( $term_id ), $tax );
	}

	public function set_image( $post_id, $attach_id ) {
		set_post_thumbnail( $post_id, $attach_id );
	}

	public function get_post_type_support( $post_type, $support ) {
		return post_type_supports( $post_type, $support );
	}
}