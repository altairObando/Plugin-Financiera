<?php
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
                'nombre' => ['required' => true]
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
        
        $nombre = $request->get_param('nombre');
        $rangoDeudorId = $request['rangoDeudorId'];
        $newFinanciera = array(
            'nombre' => $nombre,
            'rangoDeudorId' => $rangoDeudorId
        );

        $wpdb->insert($tablaFinanciera, $newFinanciera);

        return rest_ensure_response($newFinanciera);
    }
    function put($request){
		global $wpdb;
        $tablaFinanciera = $wpdb->prefix."financiera";
		$id = $request->get_param('id');
		$nombre = $request->get_param('nombre');
        $rangoDeudorId = $request->get_param('rangoDeudorId');
        $updateFinanciera = array(
            'nombre' => $nombre,
            'rangoDeudorId' => $rangoDeudorId
        );
		$wpdb->update($tablaFinanciera,$updateFinanciera, array('id' => $id));
		return rest_ensure_response(array('ok' => true,'mensaje' => 'Financiera Actualizada.'));
    }
    function delete($request){
        
    }
?>