export const VA = (tasa, periodos, pago) => {
    var f1 = tasa / 100 / 12;
    var f2 = Math.pow(1 + f1, periodos);
    return pago /( (f1 * f2) / (f2 -1));
    }
/**
 * Funcion de pago basada en calculo financiero.
 * @param {double} tasa Valor de la tasa al invocar indicar el tipo de evaluacion anual: 12, bimensual: 6, mensual: 1 etc
 * @param {int} periodos Indica la cantidad de cuotas que se deben
 * @param {double} montoPrestamo valor del prestamo solicitado
 * @param {double} valorFuturo Valor a futuro
 * @param {int} tipo Utilizado para indicar cuando vencen los pagos, 0 a fin de periodo 1 a comienzo del periodo.
 */
export const PAGO = (tasa, periodos, montoPrestamo, valorFuturo, tipo) => {
    if (!valorFuturo) valorFuturo = 0;
    if (!tipo) tipo = 0;

    if (tasa === 0) return -(montoPrestamo + valorFuturo)/periodos;

    var pvif = Math.pow(1 + tasa, periodos);
    var pmt = tasa / (pvif - 1) * -(montoPrestamo * pvif + valorFuturo);

    if (tipo === 1) {
        pmt /= (1 + tasa);
    };

    return pmt;
}
export const FormatNumber = (valor, claveMoneda) =>{
    claveMoneda = claveMoneda || '¢ ';
    return claveMoneda + new Intl.NumberFormat("es-US").format(valor);
}
