<?php 
include_once('../../../../wp-load.php' );
include_once  '../../../../wp-admin/includes/media.php';
include_once '../../../../wp-admin/includes/file.php';
include_once '../../../../wp-admin/includes/image.php';

$overrides = array('test_form' => FALSE, 'album' => 'slider');

$upload = wp_handle_upload( $_FILES['imagen'], $overrides );

if ( $upload ) {
    $wp_filetype = $upload['type'];
    $nombre = $upload['file'];
    $wp_upload_dir = wp_upload_dir();
    $attachment = array(
        'guid' => $wp_upload_dir['url'] . '/' . basename( $nombre ),
        'post_mime_type' => $wp_filetype,
        'post_title' => preg_replace('/\.[^.]+$/', '', basename($nombre)),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $nombre, 500);
	$attach_data = wp_generate_attachment_metadata( $attach_id, $nombre );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	wp_update_attachment_metadata( $attach_id, 'slider' );
	var_dump($nombre);

}


?>