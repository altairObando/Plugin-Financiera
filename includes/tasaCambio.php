<?php
function get_tasa_cambio()
 {
    //url del servicio BCR
    $servicio = "https://gee.bccr.fi.cr/Indicadores/Suscripciones/WS/wsindicadoreseconomicos.asmx?WSDL"; 
    $indicador = 317;
    $fecha = date("d/m/Y", strtotime($str));
    $nombre = "Noel Obando";
    $email = "pxnfilo@gmail.com";
    $token = "DMN1SAO211";
    $subNiveles = "N";
    
    $request_param = '<?xml version="1.0" encoding="utf-8"?>
    <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
      <soap12:Body>
        <ObtenerIndicadoresEconomicos xmlns="http://ws.sdde.bccr.fi.cr">
          <Indicador>'.$indicador.'</Indicador>
          <FechaInicio>'.$fecha.'</FechaInicio>
          <FechaFinal>'.$fecha.'</FechaFinal>
          <Nombre>'.$nombre.'</Nombre>
          <SubNiveles>'.$subNiveles.'</SubNiveles>
          <CorreoElectronico>'.$email.'</CorreoElectronico>
          <Token>'.$token.'</Token>
        </ObtenerIndicadoresEconomicos>
      </soap12:Body>
    </soap12:Envelope>';

    $headers = array(
        'Content-Type: text/xml; charset=utf-8',
        'Content-Length: '.strlen($request_param)
    );
    
    $ch = curl_init($servicio);
    curl_setopt ($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $request_param);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $result = curl_exec ($ch);    
    

    if ($result === FALSE) {
        printf("CURL error (#%d): %s<br>\n", curl_errno($ch),
        htmlspecialchars(curl_error($ch)));
    }
    $xmlResult = loadXML($result);
    curl_close ($ch);
    if($result)
      return $result;
    return 1;
  }
    
?>
