<?php
     /** Dependencias */
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    include(plugin_dir_path(__FILE__).'includes/Controllers/ProductosController.php');
    include(plugin_dir_path(__FILE__).'includes/Controllers/CotizacionController.php');
    include(plugin_dir_path(__FILE__).'includes/Controllers/ProductoTasaController.php');
    
    function EnableRoutes(){
        ProductoRoute();
        CotizacionRoute();
        TasaRoute();
        TasaCambio();
    }

    function ProductoRoute(){
        register_rest_route('calculadora/v1', 'productos/',[
            'methods' => 'GET',
            'callback' => ProductoController::GetProductos,
            'args' => [
                'id' => ['required' => false, 'type' => 'number']
            ]
        ]);
    }

    function CotizacionRoute(){
        /** CRUD ROUTES */
        register_rest_route('calculadora/v1', 'cotizacion/',
            array(
                // GET
                array(
                    "methods" => "GET",
                    "callback" => "GET_COT",
                    "args" => [
                        'cedula' => ['required' => false]
                    ]
                    ),
                // POST
                array(
                    "methods" => "POST",
                    "callback" => "POST_COT",
                    "args" => [
                        'cedula' => ['required' => true]
                    ]
                    ),
                // DELETE
                array(
                    "methods" => "DELETE",
                    "callback" => "DELETE_COT",
                    "args" => [
                        'id' => ['required' => true]
                    ]
                    ),
                // UPDATE
                array(
                    "methods" => "PUT",
                    "callback" => "PUT_COT",
                    "args" => [
                        'id' => ['required' => true]
                    ]
                ))
        );
        /** End Routes */
        register_rest_route('calculadora/v1', )
    }
    function TasaRoute(){
        register_rest_route('calculadora/v1', 'tasas/',[
            'methods' => 'GET',
            'callback' => 'getTasaByProductoId',
            'args' => [
                'productoId' => ['required' => true, 'type' => 'number']
            ]
        ]);
    }

    function TasaCambio()
    {
        register_rest_route('calculadora/v1', 'tasaCambio/',[
            'methods' => 'GET',
            'callback' => 'get_tasa_cambio'
        ]);
    }
?>