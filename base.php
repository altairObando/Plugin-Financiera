<?php
/**
 * @package Plugin Financiera CR
 * @version 1
 */
/*
Plugin Name: Plugin Financiera CR
Plugin URI : https://github.com/altairObando/Plugin-Financiera.git
Description: Simple plugin que crea una tabla de base de datos en wordpress
Version: 1
Author : Noel Antonio Obando Espinoza
Author URI: https://github.com/altairObando/
*/

defined('ABSPATH') or die('Algo salio mal :(');

include(plugin_dir_path(__FILE__).'includes/register.php');
include(plugin_dir_path(__FILE__).'includes/financieraController.php');
include(plugin_dir_path(__FILE__).'includes/calculoForm.php');
include(plugin_dir_path(__FILE__).'includes/admin.php');
register_activation_hook(__FILE__, 'register_tables');
register_deactivation_hook(__FILE__, 'delete_tables');


add_action('rest_api_init', 'financiera');
// add_action('wp_head', 'wpb_hook_javascript');    
// add_shortcode( 'codesign_calculadora_form', 'cf_shortcode' );


function initCors( $value ) {
    $origin_url = '*';
      
    header( 'Access-Control-Allow-Origin: ' . $origin_url );
    header( 'Access-Control-Allow-Methods: GET' );
    header( 'Access-Control-Allow-Credentials: true' );
    return $value;
  }

add_action( 'rest_api_init', function() {

	remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

	add_filter( 'rest_pre_serve_request', initCors);
}, 15 );

?>