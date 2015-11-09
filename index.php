<?php 
/*
Plugin Name: Slider Caguama

Plugin URI: http://www.adanzilla.com/plugins/sliderCaguama
Version: 1.0
Author: Adanzilla
Description: Slider responsive con imagenes DESDE MEDIA WORDPRESS
*/


function necesarios() {
    
}

function necesarios_front() {
    wp_register_script( 'slider-caguama', plugins_url('/js/sliderCaguama.js',__FILE__ ));
    wp_enqueue_script('slider-caguama');
    wp_register_style( 'slider_caguama_css', plugins_url('sliderCaguama/css/sliderCaguama.css' ));
    wp_enqueue_style('slider_caguama_css');
}

add_action('wp_head','necesarios_front' );
add_action('admin_init','necesarios');
add_action('admin_head', 'mensaje_error');
add_action('admin_menu','menu_slider_caguama');

/**
 * Administra el menú del plugin
 */
function menu_slider_caguama(){
	add_menu_page('Slider','Slider Caguama','manage_options','slider_caguama','dashboard_caguama',plugins_url().'/sliderCaguama/images/icono.png');    
    add_submenu_page('slider_caguama','Administrar','Administrar slider','manage_options','slider_caguama_sub1','administrar_slider_caguama');
}

/**
 * Genera el html necesario para desplegar el SLIDER
 * @param array $atts 
 * @param string $content 
 * @return string
 */
function slider($atts, $content = null){
    return '
            <div class="slider">
                <span class="atras"></span>
                <span class="adelante"></span>
                <ul class="slider-contenedor">
                    '.slides().'
                </ul>
            </div>';
}

add_shortcode( 'slider', 'slider' );    

/**
 * Genera el HTML de las slides requeridas por slider()
 * @return string
 */
function slides(){
    $args = array(
        'post_type'        => 'attachment',
        'meta_key'       => '_wp_attachment_metadata',
        'meta_value' => 'slider'
        );
    $posts_array = get_posts( $args );
    $i=1;
    
    foreach ($posts_array as $post) {
        $html .= '<li data-id="'.$i.'" class="slide"><img src="'.$post->guid.'"></li>';
        $i++;
    }
    return $html;
}

/**
 * Genera al dashboard para la administración del slider
 * @return string
 */
function dashboard_caguama(){
    $html = '<form name="form" id="form_id" action="'.plugins_url( '/sliderCaguama/php/', 'sliderCaguama' ).'carga-imagen.php" method="post" enctype="multipart/form-data">
        <input type="file" name="imagen">
        <input type="submit" value="Cargar">
    </form>';
    echo $html;
}


function administrar_slider_caguama(){

}

?>