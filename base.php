<?php
/**
 * @package Calculadora Financiera
 * @version 1
 */
/*
Plugin Name: FinancialSolutions API REST
Plugin URI : https://github.com/altairObando/Plugin-Financiera.git
Description: Configuración de base de datos y api rest para calculado de cotizaciones
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

function initCors( $value ) {
    $origin_url = 'https://financialsolutionscr.com/Calculadora/';
      
    header( 'Access-Control-Allow-Origin: ' . $origin_url );
    header( 'Access-Control-Allow-Methods: GET' );
    header( 'Access-Control-Allow-Credentials: true' );
    return $value;
  }

  add_action( 'rest_api_init', function() {

	remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

	add_filter( 'rest_pre_serve_request', function($args){
    $origin_url = 'https://financialsolutionscr.com/Calculadora/';
      
    header( 'Access-Control-Allow-Origin: ' . $origin_url );
    header( 'Access-Control-Allow-Methods: GET' );
    header( 'Access-Control-Allow-Credentials: true' );
    return $args;
  });
  
}, 15 );

?>