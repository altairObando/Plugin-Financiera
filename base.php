<?php
/**
 * @package Plugin Financiera CR
 * @version 1
 */
/*
Plugin Name: Plugin Financiera CR
Plugin URI : https://github.com/altairObando/Plugin-Financiera.git
Description: Simple plugin que crea una tabla de base de datos en wordpress
Version 0.1
Author : Noel Antonio Obando Espinoza
Author URI: https://github.com/altairObando/
*/

defined('ABSPATH') or die('Algo salio mal :(');

include(plugin_dir_path(__FILE__).'includes/register.php');


register_activation_hook(__FILE__, 'register_tables');
register_deactivation_hook(__FILE__, 'delete_tables');

?>