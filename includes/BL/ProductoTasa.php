<?php
require_once(ABSPATH.'wp-admin/includes/upgrade.php');
include(plugin_dir_path(__FILE__).'includes/BL/BaseHelper.php');

public static class ProductoTasa
{
    private static $wpdb;
    private static $table = BaseHelper::$configProducto;
    private static $productosTable =  $wpdb->prefix."posts";
    private static $baseQuery = "SELECT * FROM $table  ";

    public static function GetTasas(){
        return self::$wpdb->get_results(self::$baseQuery, ARRAY_A);
    }    
    public static function GetTasaById($id){     
        $query = self::$baseQuery." WHERE `id` = $id";       
        return self::$wpdb->get_results($query, ARRAY_A);
    }    
    public static function GetTasaByProductoId($productoId){     
        $query = self::$baseQuery." WHERE `productoId` = $productoId";       
        return self::$wpdb->get_results($query, ARRAY_A);
    }    
    public static function SaveTasa($nueva){            
        return self::$wpdb->insert(self::$table, $nueva);
    }
    public static function UpdateTasa($actualizada,  $id){            
        return self::$wpdb->update(self::$table, $actualizada, $id);
    }    
    public static function DeleteTasa($id){            
        return self::$wpdb->delete(self::$table, $id);
    }
}
?>