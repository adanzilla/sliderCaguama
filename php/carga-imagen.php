<?php 
include_once('../../../../wp-load.php' );
include_once  '../../../../wp-admin/includes/media.php';
include_once '../../../../wp-admin/includes/file.php';
include_once '../../../../wp-admin/includes/image.php';

$overrides = array('test_form' => FALSE, 'album' => 'slider');

$upload = wp_handle_upload( $_FILES['imagen'], $overrides );

if ( $upload ) {

    $wp_filetype = $upload['type'];
    $nombre = (!empty($_POST['nombre'])) ? $_POST['nombre'] : preg_replace('/\.[^.]+$/', '', basename($upload['file'])) ;
    $descripcion = (!empty($_POST['descripcion'])) ? $_POST['descripcion'] : '' ;
    $wp_upload_dir = wp_upload_dir();
    $attachment = array(
        'guid' => $wp_upload_dir['url'] . '/' . basename( $upload['file'] ),
        'post_mime_type' => $wp_filetype,
        'post_title' => $nombre,
        'post_content' => $descripcion,
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $upload['file'], 500);
	$attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	wp_update_attachment_metadata( $attach_id, 'slider' );
	var_dump($nombre);
}


?>