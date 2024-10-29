<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 04/01/18
 * Time: 12.02
 */

class arc_MediaCreator {
	public $image_url;

	public function __construct() {
		$faker           = Faker\Factory::create( get_locale() );
		$this->image_url = $faker->imageUrl();
	}

	public function createImage( $post_id ) {

		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents( $this->image_url );
		$filename   = preg_replace( "/[^A-Za-z0-9]/", '', basename( $this->image_url ) );
		if ( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename . ".jpg";
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename . ".jpg";
		}

		file_put_contents( $file, $image_data );
		$wp_filetype = wp_check_filetype( $filename, null );

		$attachment = array(
			'post_mime_type' => 'image/jpeg',
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
		$attach_id  = wp_insert_attachment( $attachment, $file, $post_id );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		return $attach_id;
	}

	public function setImagetoPost( $post_id, $attach_id ) {
		set_post_thumbnail( $post_id, $attach_id );
	}
}