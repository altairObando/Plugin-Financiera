<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
include(plugin_dir_path(__FILE__).'includes/BL/ProductoTasa.php');

public static class ProductoTasaController
{
    public static function Get($request){
        $config = self::parseRequest($request); 

        if(in_array("id", $config) && $config->id > 0){
            $id = $config->id;
            return rest_ensure_response(ProductoTasa::GetTasaById($id));
        }

        if(in_array("productoId", $config)){
            $productoId = $config->productoId;
            return rest_ensure_response(ProductoTasa::GetTasaByProductoId($productoId));
        } 

        return rest_ensure_response(ProductoTasa::GetTasas());
    }
    public static function Post($request){
        $config = self::parseRequest($request); 
        return rest_ensure_response(ProductoTasa::SaveTasa($config))
    }
    public static function Put($request){
        $config = self::parseRequest($request); 
        return rest_ensure_response(ProductoTasa::UpdateTasa($config, $config->id))
    }
    public static function Delete($request){
        $config = self::parseRequest($request); 
        return rest_ensure_response(ProductoTasa::DeleteTasa($config->id))
    }

    private static function ParseRequest($request)
    {
        return array(
        id => $request->get_param('id'),
        productoId => $request->get_param('productoId'),
        montoDesde => $request->get_param('montoDesde'),
        montoHasta  => $request->get_param('montoHasta '),
        relacionCuota => $request->get_param('relacionCuota'),
        rebajoAutomatico => $request->get_param('rebajoAutomatico'),
        valor => $request->get_param('valor')
        );
    }
}
?>