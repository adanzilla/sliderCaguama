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

function mensaje_error($mensaje){
    $error = '<script type="text/javascript">
                    jQuery(document).ready(function(){
                        var mensaje_error = "<div class=\"mensaje_error\"><p>'.$mensaje.'</p><br class=\"clear\"></div>";
                        jQuery("body").prepend(mensaje_error);
                        jQuery(".mensaje_error").animate({"top":"0px"},1000).delay(5000).animate({"top":"-25px"});
                    });

                </script>';
    return $error;
}

add_action('wp_head','necesarios_front' );
add_action('admin_init','necesarios');
add_action('admin_menu','menu_slider_caguama');

/**
 * Administra el menú del plugin
 */
function menu_slider_caguama(){
	add_menu_page('Slider Caguama','Slider Caguama','manage_options','slider_caguama','dashboard_caguama',plugins_url().'/sliderCaguama/images/icono.png');    
    add_submenu_page('slider_caguama','Administrar','Administrar slider','manage_options','slider_caguama_sub1','administrar_slider_caguama');
}

/**
 * Genera el html necesario para desplegar el SLIDER
 * @param array $atts 
 * @param string $content 
 * @return string
 */
function slider($atts, $content = null){

    extract( shortcode_atts( array(
        'modo' => 'normal'
        ), $atts, 'slider' ) );

    if ( slides( 'cantidad' ) ) {

        if ( $modo == 'normal' ){
           $slides = slides( 'li-fondo-imagen' ); 
        }
        else{
            $slides = slides( 'li-imagen' );
        }

        $html = '<div class="slider '.$modo.'">
                    <span class="atras"></span>
                    <span class="adelante"></span>
                    <ul class="slider-contenedor">
                        '.$slides.'
                    </ul>
                </div>';
        
    }
    else{
        $html = mensaje_error('Además de agregar el shortcode, agrega imágenes desde el administrador');
    }

    return $html;
}

add_shortcode( 'slider', 'slider' );    

function slides($modo){
    switch ($modo) {
        case 'cantidad':
            $args = array(
                'post_type'  => 'attachment',
                'meta_key'   => '_wp_attachment_metadata',
                'meta_value' => 'slider'
                );
            $posts_array = get_posts( $args );

            if ( count($posts_array) >= 3 ){
                return true;
            }
            else{
                return false;
            }

        break;

        case 'li-imagen':
            $args = array(
                'post_type'        => 'attachment',
                'meta_key'       => '_wp_attachment_metadata',
                'meta_value' => 'slider'
                );
            $posts_array = get_posts( $args );
            $i=1;

            if (!empty($posts_array)) {
                foreach ($posts_array as $post) {
                    $slides .= '<li data-id="'.$i.'" class="slide">
                                    <img src="'.$post->guid.'">
                                    <div class="detalle">
                                        <span class="nombre">'.$post->post_title.'</span>
                                        <span class="descripcion">'.$post->post_content.'</span>
                                    </div>
                                    <br class="clear">
                                </li>';
                    $i++;
                }
            } 
            else {
                $html = '';
            }

            return $slides;
            break;

        case 'li-fondo-imagen':
            $args = array(
                'post_type'        => 'attachment',
                'meta_key'       => '_wp_attachment_metadata',
                'meta_value' => 'slider'
                );
            $posts_array = get_posts( $args );
            $i=1;

            if (!empty($posts_array)) {
                foreach ($posts_array as $post) {
                    $slides .= '<li data-id="'.$i.'" class="slide" style="background-image: url('.$post->guid.');">
                                    <div class="detalle">
                                        <span class="nombre">'.$post->post_title.'</span>
                                        <span class="descripcion">'.$post->post_content.'</span>
                                    </div>
                                    <br class="clear">
                                </li>';
                    $i++;
                }
            } 
            else {
                $html = '';
            }

            return $slides;

        break;

        default:
            # code...
        break;
    }
}


/**
 * Genera al dashboard para la administración del slider
 * @return string
 */
function dashboard_caguama(){
    $html = '<form name="form" id="form_id" action="'.plugins_url( '/sliderCaguama/php/', 'sliderCaguama' ).'carga-imagen.php" method="post" enctype="multipart/form-data">
    <input type="text" name="nombre">
    <input type="text" name="descripcion">
    <input type="file" name="imagen">
    <input type="submit" value="Cargar">
</form>';
echo $html;
}

function administrar_slider_caguama(){

}

?>