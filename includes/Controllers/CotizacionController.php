<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
include(plugin_dir_path(__FILE__).'includes/BL/Cotizacion.php');
public static class CotizacionController
{
    public static function GET_COT($request){
        $cotizacion = self::parseRequest($request);        
        if(in_array("cedula", $cotizacion))
            return rest_ensure_response(Cotizacion::GetCotizacion($cotizacion->cedula));
        return rest_ensure_response(Cotizacion::GetCotizaciones());
    }
    
    public static function POST_COT($request){
        $cotizacion = self::parseRequest($request);
        return rest_ensure_response(Cotizacion::SaveCotizacion($cotizacion));
    }

    public static function PUT_COT($request){
        $cotizacion = self::parseRequest($request);
        return rest_ensure_response(Cotizacion::UpdateCotizacion($cotizacion));
    }

    public static function DELETE_COT($request){
        $cotizacion = self::parseRequest($request);
        return rest_ensure_response(Cotizacion::DeleteCotizacion($cotizacion));
    }
    
    private static function parseRequest($request){

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
}
?>