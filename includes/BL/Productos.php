<?php
public static class Productos
{
    private static $wpdb;
    private static $productosTable =  $wpdb->prefix."posts";
    private static $productosDataTable =  $wpdb->prefix."wc_product_meta_lookup";
    private static $ordenesTable =  $wpdb->prefix."wc_order_product_lookup";
    private static $baseGetQuery = "SELECT `ID`,`post_title`,`post_date` FROM self::$productosTable WHERE `post_type` LIKE \'product\' "
    /**
     * Obtiene un producto mediante PK
     */
    public static function Get($id)
    {
        $query = self::$baseGetQuery." and `ID` = $id";
        return self::$wpdb->get_results($query, ARRAY_A);
    }
    /**
     * Obtiene todos los productos.
     */
    public static function GetAll()
    {
        return self::$wpdb->get_results(self::$baseGetQuery, ARRAY_A);
    }
}
?>