<?php
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    include(plugin_dir_path(__FILE__).'includes/BL/BaseHelper.php');

    public static class Cotizacion
    {
        private static $wpdb;
        private static $table = BaseHelper::$cotizacion;
        private static $baseQuery = "SELECT * FROM ".BaseHelper::$cotizacion;
        public static function GetCotizaciones(){
            return self::$wpdb->get_results(self::$baseQuery, ARRAY_A);
        }    
        public static function GetCotizacion($cedula){     
            $query = self::$baseQuery." WHERE cedula LIKE '%$cedula%' ORDER BY ID DESC";       
            return self::$wpdb->get_results($query, ARRAY_A);
        }    
        public static function SaveCotizacion($nueva_cotizacion){            
            return self::$wpdb->insert(self::$table, $nueva_cotizacion);
        }
        public static function UpdateCotizacion($updated_cotizacion,  $id){            
            return self::$wpdb->update(self::$table, $updated_cotizacion, $id);
        }    
        public static function DeleteCotizacion($id){            
            return self::$wpdb->delete(self::$table, $id);
        }
    }

?>