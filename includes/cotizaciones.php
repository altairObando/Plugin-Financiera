<?php
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    function GET_COT($request){
        $cotizacion = parseRequest($request);
        
        if(in_array("cedula", $cotizacion))
            return rest_ensure_response(GetCotizacion($cotizacion->cedula));
        return rest_ensure_response(GetCotizaciones());
    }
    
    function POST_COT($request){
        $cotizacion = parseRequest($request);
        return rest_ensure_response(SaveCotizacion($cotizacion));
    }

    function PUT_COT($request){
        $cotizacion = parseRequest($request);
        return rest_ensure_response(UpdateCotizacion($cotizacion));
    }

    function DELETE_COT($request){
        $cotizacion = parseRequest($request);
        return rest_ensure_response(DeleteCotizacion($cotizacion));
    }


    function parseRequest($request){

        $cotiza = array(
                'id' => $request->get_param('id'),
                'cedula' => $request->get_param('cedula'),
                'contacto' => $request->get_param('contacto'),
                'ingresoBruto' => $request->get_param('ingresoBruto'),
                'deudaSugef' => $request->get_param('deudaSugef'),
                'cupoCredito' => $request->get_param('cupoCredito'),
                'tipoCambio' => $request->get_param('tipoCambio'),
                'ingresoNeto' => $request->get_param('ngresoNeto'),
                'esAsalariado' => $request->get_param('esAsalariado'),
                'rebajoAutomatico' => $request->get_param('rebajoAutomatico'),
                'nivelSugef'  => $request->get_param('nivelSugef '),
                'promedioCuotas' => $request->get_param('promedioCuotas'),
                'porcentajeDeuda' => $request->get_param('porcentajeDeuda'),
                'creditoColones'  => $request->get_param('creditoColones '),
                'creditoDolares' => $request->get_param('creditoDolares'),
                'tasa' => $request->get_param('tasa'),
                'plazo' => $request->get_param('plazo'),
                'sugerenciaColones' => $request->get_param('sugerenciaColones'),
                'sugerenciaDolares' => $request->get_param('sugerenciaDolares'),
                'montoSolicitado' => $request->get_param('montoSolicitado'),
                'montoCuotaFinal' => $request->get_param('montoCuotaFinal'),
                'emailClient' => $request->get_param('emailClient'),
                'productoId' => $request->get_param('productoId'),
                'moneda' => $request->get_param('moneda'),
                'Contacto' => $request->get_param('Contacto')
        );
        return $cotiza;
    }

    function GetCotizaciones(){
        global $wpdb;
        $cotizacion = $wpdb->prefix."cotizacion";
        return $wpdb->get_results("SELECT * FROM $cotizacion", ARRAY_A);
    }

    function GetCotizacion($cedula){
        global $wpdb;
        $cotizacion = $wpdb->prefix."cotizacion";
        return $wpdb->get_results("SELECT * FROM $cotizacion where cedula LIKE '%$cedula%' ORDER BY ID DESC", ARRAY_A);
    }

    function SaveCotizacion($nueva_cotizacion){
        global $wpdb;
        return $wpdb->insert($cotizacion, $nueva_cotizacion);
    }
    function UpdateCotizacion($updated_cotizacion,  $id){
        global $wpdb;
        return $wpdb->update($cotizacion, $updated_cotizacion, $id);
    }

    function DeleteCotizacion($updated_cotizacion,  $id){
        global $wpdb;
        return $wpdb->delete($cotizacion, $updated_cotizacion, $id);
    }

?>