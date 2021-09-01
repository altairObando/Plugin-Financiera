<?php
    require_once(ABSPATH.'wp-admin/includes/upgrade.php');

    public static class BaseHelper{
        global $wpdb;
        public static $configProducto = $wpdb->prefix."tasa_producto";
        public static $cotizacion = $wpdb->prefix."cotizacion";
        /**
         * Permite la interconexion del servicio de calculadora.
         */
        public static function EnableCors() {
            remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
            add_filter( 'rest_pre_serve_request', function($args){
                $origin_url = 'https://financialsolutionscr.com/Calculadora/';              
                header( 'Access-Control-Allow-Origin: ' . $origin_url );
                header( 'Access-Control-Allow-Methods: GET' );
                header( 'Access-Control-Allow-Credentials: true' );
                return $args;          
            });
        }        
    }
?>