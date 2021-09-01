<?php
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    include(plugin_dir_path(__FILE__).'includes/BL/Productos.php');

    public static class ProductoController
    {       
        public static function GetProductos($request)
        {
            if(property_exists($request, "id") && $request->get_param('id') > 0)
                return Productos::Get($request->get_param('id'));
            return Productos::GetAll();            
        }
        //TODO: Pendiente analizar si se requieren mas metodos, ya que todo es por woocommerce
    }
?>