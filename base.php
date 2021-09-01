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

include(plugin_dir_path(__FILE__).'includes/routes.php');
include(plugin_dir_path(__FILE__).'includes/admin.php');
include(plugin_dir_path(__FILE__).'includes/BL/RegisterTables.php');
register_activation_hook(__FILE__, 'register_tables');
register_deactivation_hook(__FILE__, 'delete_tables');


add_action('rest_api_init', 'EnableRoutes', 15);

?>