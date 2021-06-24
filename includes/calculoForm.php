<?php
    function get_template(){
        return '<!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Calculadora de creditos</title>
                <style>
                    form input{
                        width: 15em
                    }
                    form select{
                        width: 15em
                    }
                    form label {
                        margin-right: 1em
                    }
                    .tablaCalculo, th, td {
                        border: solid black 0.05em
                        padding: .5em
                        border-collapse: collapse
                        border-bottom: 1em
                    }
                    .title  {
                        color: black
                        background-color: rgb(117, 183, 221)
                    }
                    .titleBig {
                        color: white
                        background-color: #0078bf
                        font-weight: bold
                        font-size: larger
                    }
                </style>
            </head>
            <body>
            <h3>MODELO DE CÁLCULO DE CUPO DE CRÉDITO PERSONAL SIN FIADOR</h3>
            <form onsubmit="onFormSubmit(this)">
                <div style="overflow-y: auto max-height: 50em" >
                    <table class="tablaCalculo">
                        <tr class="title">
                            <td><label for="ingresoBruto"> Ingreso Bruto en colones: </label></td>
                            <td><input id="ingresoBruto" name="ingresoBruto" placeholder="Monto en colones" value="0" type="number" min=0 onchange="setCupoCredito()"/></td>
                        </tr>
                        <tr class="title">
                            <td><label for="totalDeudas">Total de Deudas SUGEF</label></td>
                            <td><input name="totalDeudas" id="totalDeudas" placeholder="Monto en colones" value="0" type="number" min=0 onchange="setCupoCredito()"/></td>
                        </tr>
                        <tr class="titleBig">
                            <td><label for="cupoCredito">CUPO DE CRÉDITO NETO (cuota)</label></td>
                            <td><input name="cupoCredito" id="cupoCredito" readonly type="number" min=0/></td>
                        </tr>
                        <tr>
                            <td><label for="tipoCambio">Tipo de cambio compra</label></td>
                            <td><input name="tipoCambio" id="tipoCambio" type="number" min=0 onchange="setIngresoDolares(this)"></td>
                        </tr>
                        <tr class="title">
                            <td><label for="ingresoDolares">Ingreso Neto en dólares</label></td>
                            <td><input name="ingresoDolares" id="ingresoDolares" readonly type="number" min=0 onchange="obtieneDac(this)" /></td>
                        </tr>
                        <tr>
                            <td><label for="selectAsalariado">Asalariado con depósito en la entidad financiera</label></td>
                            <td>
                                <select name="selectAsalariado" id="selectAsalariado">
                                    <option value="1">SI</option>
                                    <option value="2">NO</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="selectRebajo">Rebajo automático</label></td>
                            <td>
                                <select name="selectRebajo" id="selectRebajo">
                                    <option value="1">SI</option>
                                    <option value="2">NO</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="selectNivel">Nivel SUGEF (1 a 4)</label></td>
                            <td>
                                <select name="selectNivel" id="selectNivel">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </td>
                        </tr>
                        <tr >
                            <td><label for="promedioAtraso">Promedio de atraso de pagos (en días)</label></td>
                            <td><input name="promedioAtraso" id="promedioAtraso" placeholder="valor porcentual %" value=0 type="number" min=0/></td>
                        </tr>
                        <tr class="title">
                            <td><label for="porcentajeEndeudamiento">% De endeudamiento según DAC</label></td>
                            <td><input name="porcentajeEndeudamiento" id="porcentajeEndeudamiento" readonly value=0 type="number" min=0 onchange="actualizaValoresNetos(this)"/></td>
                        </tr>
                        <tr>
                            <td><label for="cupoCreditoNeto">Cupo Credito Neto Colones</label></td>
                            <td><input name="cupoCreditoNeto" id="cupoCreditoNeto" readonly type="number" min=0/></td>
                        </tr>
                        <tr>
                            <td><label for="cupoCreditoNetoEx">Cupo Credito Neto Dolares</label></td>
                            <td><input name="cupoCreditoNetoEx" id="cupoCreditoNetoEx" readonly type="number" min=0/></td>
                        </tr>
                        <tr style="color: white font-size: larger background-color: rgb(117, 183, 221)">
                            <td style="width: 550px" colspan="2">CONDICIONES DE CRÉDITO OFRECER</td>
                        </tr>
                        <tr>
                            <td><label for="tasaInteres">Tasa de interés</label></td>
                            <td><input name="tasaInteres" id="tasaInteres" value=0 type="number" min=0/></td>
                        </tr>
                        <tr>
                            <td><label for="plazo">Plazo</label></td>
                            <td><input name="plazo" id="plazo" value=0 type="number" min=0/></td>
                        </tr>
                        <tr>
                            <td><label for="tasa">Tasa de interés</label></td>
                            <td><input name="tasa" id="tasa" value=0 type="number" min=0/></td>
                        </tr>
                        <tr class="titleBig">
                            <td><label for="montoOfrecerColones">Monto a ofrecer colones</label></td>
                            <td><input name="montoOfrecerColones" id="montoOfrecerColones" readonly value=0 /></td>
                        </tr>
                        <tr class="titleBig">
                            <td><label for="montoOfrecerDolares">Monto a ofrecer dólares</label></td>
                            <td><input name="montoOfrecerDolares" id="montoOfrecerDolares" readonly value=0 /></td>
                        </tr>
                        <tr>
                            <td><label for="moneda">MONEDA DESEADA POR EL CLIENTE</label></td>
                            <td>
                                <td><input name="tasa" id="tasa" value=0 type="number" min=0/></td>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="montoSolicitado">Monto solicitado</label></td>
                            <td><input name="montoSolicitado" id="montoSolicitado" placeholder="Monto solicitado por el cliente" type="number" min=0/></td>
                        </tr>
                        <tr>
                            <td><label for="tasa">Tasa de interés %</label></td>
                            <td><input name="tasa" id="tasa" value=0 type="number" min=0/></td>
                        </tr>
                        <tr>
                            <td><label for="plazo">Plazo</label></td>
                            <td><input name="plazo" id="plazo" value=0 type="number" min=0/></td>
                        </tr>
                        <tr class="title">
                            <td><label for="cuotaFinal">Cuota crédito solicitado</label></td>
                            <td><input name="cuotaFinal" id="cuotaFinal" value=0 type="number" min=0/></td>
                        </tr>
                    </table>
                </div>
            </form>
        </body>
        </html>';
    }
?>