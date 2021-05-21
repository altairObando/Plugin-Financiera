<?php
function get_tasa_cambio()
 {
    //url del servicio BCR
    $servicio = 'https://gee.bccr.fi.cr/Indicadores/Suscripciones/WS/wsindicadoreseconomicos.asmx?WSDL';
    $indicador = 317;
    $fecha = date("d/m/Y");
    $nombre = "Noel Obando";
    $email = "pxnfilo@gmail.com";
    $token = "DMN1SAO211";

    $request = '<?xml version="1.0" encoding="utf-8"?>
    <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
      <soap12:Body>
        <ObtenerIndicadoresEconomicos xmlns="http://ws.sdde.bccr.fi.cr">
          <Indicador>'.$indicador.'</Indicador>
          <FechaInicio>'.$fecha.'</FechaInicio>
          <FechaFinal>'.$fecha.'</FechaFinal>
          <Nombre>'.$fecha.'</Nombre>
          <SubNiveles>N</SubNiveles>
          <CorreoElectronico>'.$email.'</CorreoElectronico>
          <Token>'.$token.'</Token>
        </ObtenerIndicadoresEconomicos>
      </soap12:Body>
    </soap12:Envelope>';

    $headers = array(
      'Content-Type: application/soap+xml; charset=utf-8',
      'Content-Length: '.strlen($request)
    );

    $ch = curl_init($servicio);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $data = curl_exec ($ch);    
    $result = $data;

    if ($result === FALSE) {
        printf("CURL error (#%d): %s<br>\n", curl_errno($ch),
        htmlspecialchars(curl_error($ch)));
    }

    curl_close ($ch);
    $parser = new DOMDocument();
    $parser->loadXML($data);
    $ind_c = $parser->getElementsByTagName('INGC011_CAT_INDICADORECONOMIC')->item(0);
    $val_c = $ind_c->getElementsByTagName('NUM_VALOR')->item(0);
    return substr($val_c->nodeValue ,0,-6);
  }
    
?>
