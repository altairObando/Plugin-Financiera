<?php
    function renderForm(){
        echo '    <!DOCTYPE html>';
        echo '    <html lang="es">';
        echo '    <head>';
        echo '        <meta charset="UTF-8">';
        echo '        <meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '        <title>Calculadora de creditos</title>';
        echo '        <style>';
        echo '            form input{';
        echo '                width: 15em;';
        echo '            }';
        echo '            form select{';
        echo '                width: 15em;';
        echo '            }';
        echo '            form label {';
        echo '                margin-right: 1em;';
        echo '            }';
        echo '            .tablaCalculo, th, td {';
        echo '                border: solid black 0.05em;';
        echo '                padding: .5em;';
        echo '                border-collapse: collapse;';
        echo '                border-bottom: 1em;';
        echo '            }';
        echo '            .title  {';
        echo '                color: black;';
        echo '                background-color: rgb(117, 183, 221);';
        echo '            }';
        echo '            .titleBig {';
        echo '                color: white;';
        echo '                background-color: #0078bf;';
        echo '                font-weight: bold;';
        echo '                font-size: larger;';
        echo '            }';
        echo '        </style>';
        echo '    </head>';
        echo '    <body>';
        echo '    <h3>MODELO DE CÁLCULO DE CUPO DE CRÉDITO PERSONAL SIN FIADOR</h3>';
        echo '    <form onsubmit="onFormSubmit(this)">';
        echo '        <div style="overflow-y: auto; max-height: 50em;" >';
        echo '            <table class="tablaCalculo">';
        echo '                <tr class="title">';
        echo '                    <td><label for="ingresoBruto"> Ingreso Bruto en colones: </label></td>';
        echo '                    <td><input id="ingresoBruto" name="ingresoBruto" placeholder="Monto en colones" value="0" type="number" min=0 onchange="setCupoCredito()"/></td>';
        echo '                </tr>';
        echo '                <tr class="title">';
        echo '                    <td><label for="totalDeudas">Total de Deudas SUGEF</label></td>';
        echo '                    <td><input name="totalDeudas" id="totalDeudas" placeholder="Monto en colones" value="0" type="number" min=0 onchange="setCupoCredito()"/></td>';
        echo '                </tr>';
        echo '                <tr class="titleBig">';
        echo '                    <td><label for="cupoCredito">CUPO DE CRÉDITO NETO (cuota)</label></td>';
        echo '                    <td><input name="cupoCredito" id="cupoCredito" readonly type="number" min=0/></td>';
        echo '                </tr>';
        echo '                <tr>';
        echo '                    <td><label for="tipoCambio">Tipo de cambio compra</label></td>';
        echo '                    <td><input name="tipoCambio" id="tipoCambio" type="number" min=0 onchange="setIngresoDolares(this)"></td>';
        echo '                </tr>';
        echo '                <tr class="title">';
        echo '                    <td><label for="ingresoDolares">Ingreso Neto en dólares</label></td>';
        echo '                    <td><input name="ingresoDolares" id="ingresoDolares" readonly type="number" min=0 onchange="obtieneDac(this)" /></td>';
        echo '                </tr>';
        echo '                <tr>';
        echo '                    <td><label for="selectAsalariado">Asalariado con depósito en la entidad financiera</label></td>';
        echo '                    <td>';
        echo '                        <select name="selectAsalariado" id="selectAsalariado">';
        echo '                            <option value="1">SI</option>';
        echo '                            <option value="2">NO</option>';
        echo '                        </select>';
        echo '                    </td>';
        echo '                </tr>';
        echo '                <tr>';
        echo '                    <td><label for="selectRebajo">Rebajo automático</label></td>';
        echo '                    <td>';
        echo '                        <select name="selectRebajo" id="selectRebajo">';
        echo '                            <option value="1">SI</option>';
        echo '                            <option value="2">NO</option>';
        echo '                        </select>';
        echo '                    </td>';
        echo '                </tr>';
        echo '                <tr>';
        echo '                    <td><label for="selectNivel">Nivel SUGEF (1 a 4)</label></td>';
        echo '                    <td>';
        echo '                        <select name="selectNivel" id="selectNivel">';
        echo '                            <option value="1">1</option>';
        echo '                            <option value="2">2</option>';
        echo '                            <option value="3">3</option>';
        echo '                            <option value="4">4</option>';
        echo '                        </select>';
        echo '                    </td>';
        echo '                </tr>';
        echo '                <tr >';
        echo '                    <td><label for="promedioAtraso">Promedio de atraso de pagos (en días)</label></td>';
        echo '                    <td><input name="promedioAtraso" id="promedioAtraso" placeholder="valor porcentual %" value=0 type="number" min=0/></td>';
        echo '                </tr>';
        echo '                <tr class="title">';
        echo '                    <td><label for="porcentajeEndeudamiento">% De endeudamiento según DAC</label></td>';
        echo '                    <td><input name="porcentajeEndeudamiento" id="porcentajeEndeudamiento" readonly value=0 type="number" min=0 onchange="actualizaValoresNetos(this)"/></td>';
        echo '                </tr>';
        echo '                <tr>';
        echo '                    <td><label for="cupoCreditoNeto">Cupo Credito Neto Colones</label></td>';
        echo '                    <td><input name="cupoCreditoNeto" id="cupoCreditoNeto" readonly type="number" min=0/></td>';
        echo '                </tr>';
        echo '                <tr>';
        echo '                    <td><label for="cupoCreditoNetoEx">Cupo Credito Neto Dolares</label></td>';
        echo '                    <td><input name="cupoCreditoNetoEx" id="cupoCreditoNetoEx" readonly type="number" min=0/></td>';
        echo '                </tr>';
        echo '                <tr style="color: white; font-size: larger; background-color: rgb(117, 183, 221);">';
        echo '                    <td style="width: 550px;" colspan="2">CONDICIONES DE CRÉDITO OFRECER</td>';
        echo '                </tr>';
        echo '                <tr>';
        echo '                    <td><label for="tasaInteres">Tasa de interés</label></td>';
        echo '                    <td><input name="tasaInteres" id="tasaInteres" value=0 type="number" min=0/></td>';
        echo '                </tr>';
        echo '                <tr>';
        echo '                    <td><label for="plazo">Plazo</label></td>';
        echo '                    <td><input name="plazo" id="plazo" value=0 type="number" min=0/></td>';
        echo '                </tr>';
        echo '                <tr>';
        echo '                    <td><label for="tasa">Tasa de interés</label></td>';
        echo '                    <td><input name="tasa" id="tasa" value=0 type="number" min=0/></td>';
        echo '                </tr>';
        echo '                <tr class="titleBig">';
        echo '                    <td><label for="montoOfrecerColones">Monto a ofrecer colones</label></td>';
        echo '                    <td><input name="montoOfrecerColones" id="montoOfrecerColones" readonly value=0 /></td>';
        echo '                </tr>';
        echo '                <tr class="titleBig">';
        echo '                    <td><label for="montoOfrecerDolares">Monto a ofrecer dólares</label></td>';
        echo '                    <td><input name="montoOfrecerDolares" id="montoOfrecerDolares" readonly value=0 /></td>';
        echo '                </tr>';
        echo '                <tr>';
        echo '                    <td><label for="moneda">MONEDA DESEADA POR EL CLIENTE</label></td>';
        echo '                    <td>';
        echo '                        <select name="moneda" id="moneda">';
        echo '                            <option value="1">Colones</option>';
        echo '                            <option value="2">Dólares</option>';
        echo '                        </select>';
        echo '                    </td>';
        echo '                </tr>';
        echo '                <tr>';
        echo '                    <td><label for="montoSolicitado">Monto solicitado</label></td>';
        echo '                    <td><input name="montoSolicitado" id="montoSolicitado" placeholder="Monto solicitado por el cliente" type="number" min=0/></td>';
        echo '                </tr>';
        echo '                <tr>';
        echo '                    <td><label for="tasa">Tasa de interés %</label></td>';
        echo '                    <td><input name="tasa" id="tasa" value=0 type="number" min=0/></td>';
        echo '                </tr>';
        echo '                <tr>';
        echo '                    <td><label for="plazo">Plazo</label></td>';
        echo '                    <td><input name="plazo" id="plazo" value=0 type="number" min=0/></td>';
        echo '                </tr>';
        echo '                <tr class="title">';
        echo '                    <td><label for="cuotaFinal">Cuota crédito solicitado</label></td>';
        echo '                    <td><input name="cuotaFinal" id="cuotaFinal" value=0 type="number" min=0/></td>';
        echo '                </tr>';
        echo '            </table>';
        echo '        </div>';
        echo '    </form>';
        echo '</body>';
        echo '</html>';
    }

    function wpb_hook_javascript() {
        ?>
            <script>
              const onFormSubmit = (event)=> {
                event.preventDefault();
                alert(event);
            }

            /*// var data = <?php //echo json_encode(tasaCambio(), JSON_HEX_TAG); ?>; */
            const setCupoCredito = (event)=> {
                const ingreso = document.getElementById("ingresoBruto");
                const deudas  = document.getElementById("totalDeudas");
                const credito = document.getElementById("cupoCredito");
                if(ingreso.checkValidity() && deudas.checkValidity())
                    credito.value = ingreso.value - deudas.value;
                else 
                    credito.value = 0;
            }

            const setIngresoDolares = (element) => {
                const credito = document.getElementById("cupoCredito");
                const tasa    = document.getElementById("tipoCambio");
                const dolares = document.getElementById("ingresoDolares");

                dolares.value = credito.value && credito.value > 0 && tasa.value ? 
                                (credito.value / tasa.value).toFixed(2) : 0;

                obtieneDac({value: dolares.value })
            } 
            // Tarificador en base a edades
            const DAC = [
                {id: 1, desde: 0,    hasta: 2500,    relacion: 0.35, valorDeposito: 0.1, endeudamiento: 0.45 },
                {id: 2, desde: 2501, hasta: 5000,    relacion: 0.40, valorDeposito: 0.1, endeudamiento: 0.50 },
                {id: 3, desde: 5001, hasta: 1000000, relacion: 0.45, valorDeposito: 0.1, endeudamiento: 0.55 }]
            
            const obtieneDac = (element) => {
                if(DAC.length == 0) return;
                const porcentajeEndeudamiento = document.getElementById("porcentajeEndeudamiento");
                var first = null;

                if(DAC.length == 1){
                    porcentajeEndeudamiento = DAC[0].desde >= element.value && DAC[0].hasta <= element.value ? DAC[0].endeudamiento : 0;
                    actualizaValoresNetos(porcentajeEndeudamiento);
                    return;    
                }
                first = DAC[0];
                var current = DAC.filter( tasa => {
                    if(tasa.id === first.id ) return first.hasta >= element.value;
                    else return tasa.desde <= element.value;                
                });


                if(current.length != 0)
                    porcentajeEndeudamiento.value = current.length > 1 ? current[current.length - 1].endeudamiento : current[0].endeudamiento;
                else
                    porcentajeEndeudamiento.value = 0;
                
                actualizaValoresNetos(porcentajeEndeudamiento);
            }

            const actualizaValoresNetos = (element) => {
                // Porcentaje
                const porcentaje = element.value || 0;
                const cupo = document.getElementById("cupoCredito")
                const neto = document.getElementById("cupoCreditoNeto")
                const netoEx = document.getElementById("cupoCreditoNetoEx")
                const tipoCambio = document.getElementById("tipoCambio");

                neto.value = (cupo.value * porcentaje).toFixed(2);
                netoEx.value = (neto.value / tipoCambio.value).toFixed(2);
            }

            </script>
        <?php
    }

    function deliver_mail(){

    }

    function cf_shortcode() {
        ob_start();
        deliver_mail();
        renderForm();    
        return ob_get_clean();
    }
    
?>