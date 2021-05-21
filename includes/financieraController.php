<?php

    include(plugin_dir_path(__FILE__).'tasaCambio.php');
    
    function financiera(){
        register_rest_route('financiera/v1','financieras/', [
            'methods' => 'GET',
            'callback' => 'get',
            'args' => [ 'id' => ['required' => false, 'type' => 'number']]
        ]);
        register_rest_route('financiera/v1', 'financieras/',[
            'methods' => 'POST',
            'callback' => 'post',
            'args' => [
                'nombre' => ['required' => true],
                'tasa' => ['required' => true],
                'cuotas' => ['required' => true],
                'dac' => ['required' => true]
            ]
        ]);
        register_rest_route('financiera/v1', 'financieras/(?P<id>\d+)',[
            'methods' => 'PUT',
            'callback' => 'put',
            'args' => [
                'id' => ['required' => true, 'type' => 'number'],
                'nombre' => ['required' => false],
                'rangoDeudorId' => ['required' => false]

            ]
        ]);
        register_rest_route('financiera/v1', 'financieras/(?P<id>\d+)',[
            'methods' => 'DELETE',
            'callback' => 'delete',
            'args' => [
                'id' => ['required' => true, 'type' => 'number'],
            ]
        ]);
        register_rest_route('financiera/v1', 'tasaCambio/',[
            'methods' => 'GET',
            'callback' => 'get_tasa_cambio'
        ]);
    };

    function get($request){
        global $wpdb;
		$tablaFinanciera = $wpdb->prefix."financiera";
        $id = $request->get_param('id');
        
        $query = "SELECT * FROM $tablaFinanciera ";

        if($id !== NULL && $id > 0 )
            $query = $query." WHERE id = $id";

        $response = $wpdb->get_results($query, ARRAY_A);
        return rest_ensure_response($response);
    }
    function post($request){
        global $wpdb;
        $tablaFinanciera = $wpdb->prefix."financiera";
        // Get Values
        $nombre = $request->get_param('nombre');
        $descripcion = $request->get_param('descripcion');
        $tasa = $request->get_param('tasa');
        $cuotas = $request->get_param('cuotas');
        $dac = $request->get_param('dac');

        $newFinanciera = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'tasa' => $tasa,
            'cuotas' => $cuotas,
            'dac' => $dac,
        );

        $wpdb->insert($tablaFinanciera, $newFinanciera);

        return rest_ensure_response($newFinanciera);
    }
    function put($request){
		global $wpdb;
        $tablaFinanciera = $wpdb->prefix."financiera";
		$id = $request->get_param('id');
        $nombre = $request->get_param('nombre');
        $descripcion = $request->get_param('descripcion');
        $tasa = $request->get_param('tasa');
        $cuotas = $request->get_param('cuotas');
        $dac = $request->get_param('dac');

        $updateFinanciera = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'tasa' => $tasa,
            'cuotas' => $cuotas,
            'dac' => $dac,
        );
		$wpdb->update($tablaFinanciera,$updateFinanciera, array('id' => $id));
		return rest_ensure_response(array('ok' => true,'mensaje' => 'Financiera Actualizada.'));
    }
    function delete($request){
        global $wpdb;
        $tablaFinanciera = $wpdb->prefix."financiera";
        $id = $request->get_param('id');
        $wpdb->delete($tablaFinanciera, array("id" => $id));
    }
?>