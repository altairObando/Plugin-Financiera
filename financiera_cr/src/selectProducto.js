import React, { useEffect, useState } from 'react'
import { Columns, Form, Table, Icon } from 'react-bulma-components';
import { VA, FormatNumber } from './functions'

const SelectProducto = (props) => {
    const [producto, setProductos] = useState([]);
    const [configuracion, setConfigurarion] = useState({nivelesDeEndeudamiento: []});
    const {setLoading} = props.loader;
    const {data, setData } = props.data;

    // Obtener los productos configurados
    useEffect(() => {
        setLoading(true)
        fetch('https://financialsolutionscr.com/wp-json/financiera/v1/financieras')
        .then(response => {
            setLoading(false);
            return response.json()
        })
        .then(productos => setProductos(productos));
    }, [setLoading])

    // Actualizo las tasas y plazos de pago
    useEffect(() => {
        var pago = (data.creditoColones || '').replaceAll("¢","").replaceAll("$","").replaceAll(",","").trim();
        const result = (VA(data.tasa, data.plazo, pago)).toFixed(2);
        const resultDolares = (result / data.tipoCambio).toFixed(2);

        const printColones = FormatNumber(result);
        const printDolares = FormatNumber(resultDolares, "$ ");

        setData({...data, sugerenciaColones: printColones, sugerenciaDolares: printDolares})

    // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [data.tasa, data.plazo, data.creditoColones, data.tipoCambio] )

    /*
    * Obtener los niveles por producto al seleccionar.
    */
    useEffect(() => {
        ObtenerNivelesEndeudamiento();
        if(props.onProductoSelect && typeof(props.onProductoSelect) == "function"){
            props.onProductoSelect()
        }
    // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [data.productoId])

    async function ObtenerNivelesEndeudamiento(){
        if(data.productoId !== 0){
            const request = await fetch(`https://financialsolutionscr.com/wp-json/financiera/v1/niveles?productoId=${data.productoId}`);
            const result = await request.json();
            if(result.success){
                setConfigurarion({ ...configuracion, "nivelesDeEndeudamiento" : result.response });
                SetProductoConfig(result.response);
            }else
            alert("Error al obtener configuracion")
        }
    }
    const SetProductoConfig = (config) => {
        if(data.productoId === 0) return;
        // Set Configuracion producto
        const prod        = producto.filter(item => (item.id === data.productoId))[0];
        const porcentaje  = ObtenerValorDAC(config);
        const cupo        = data.cupoCredito.replaceAll("¢","").replaceAll("$","").replaceAll(",","").trim();
        const cupoColones = (cupo * porcentaje / 100).toFixed(2);
        const cupoDolares = (cupoColones / data.tipoCambio).toFixed(2);
        // Actualizo tasas
        setData({...data, 
                    tasa: prod.tasa, 
                    plazo: prod.cuotas, 
                    porcentajeDeuda: porcentaje+'%',
                    creditoColones:  FormatNumber(cupoColones),
                    creditoDolares:  FormatNumber(cupoDolares, "$")
                });
      
    }
    const ObtenerValorDAC = (config) => {
        if(config.length === 0) return;
        var ingreso = data.ingresoNeto.replaceAll("¢","").replaceAll("$","").replaceAll(",","").trim();
        if(ingreso <= 0)
            return ingreso;
        var porcentajeEndeudamiento = 0;
        var first = null;

        if(config.length === 1){
            porcentajeEndeudamiento = config[0].montoDesde >= ingreso && 
                                      config[0].montoHasta <= ingreso ? 
                                      config[0].valor : 0;
            return porcentajeEndeudamiento; 
        }
        first = config[0];
        var current = config.filter( tasa => {
            if(tasa.valor === first.valor ) return first.montoHasta >= ingreso;
            else return tasa.montoDesde <= ingreso;                
        });

        if(current.length !== 0)
            porcentajeEndeudamiento = current.length > 1 ? current[current.length - 1].valor : current[0].valor;
        else
            porcentajeEndeudamiento = 0;        
        return porcentajeEndeudamiento;
    }
    const _handleInputChange= (event) => {
        setData({...data, [event.target.name]: event.target.value})
    }
    
const pStyle = {
    textAlign: "center"
}
    return(<div>
        <Columns>
            <Columns.Column className="is-one-third">
                <Form.Field>
                    <Form.Label>Seleccione un producto</Form.Label>
                    <Form.Control>
                    <div className="field">
                        <p className="control">
                            <span className="select is-fullwidth">
                                <select name="productoId" value={data.productoId} onChange={_handleInputChange} id="productoSelect">
                                    <option value="">Seleccione un producto de la lista*</option>
                                {
                                    producto.map( p => {
                                        return <option value={p.id} key={p.id} >{p.nombre}</option>
                                })}
                                </select>
                            </span>
                        </p>
                    </div>
                    <Icon align="left" size="small">
                        <i className="fa fa-toolbox"></i>
                    </Icon>
                </Form.Control>
                </Form.Field>
                <Form.Field>
                    <Form.Label>Tasa de Interés</Form.Label>
                    <Form.Control>
                        <Form.Input name="tasa" id="tasa" value={data.tasa} onChange={_handleInputChange} />
                        <Icon align="left" size="small">
                            <i className="fa fa-percent"></i>
                        </Icon>
                    </Form.Control>
                </Form.Field>
                <Form.Field>
                    <Form.Label>Plazo Producto</Form.Label>
                    <Form.Control>
                        <Form.Input name="plazo" id="plazo" value={data.plazo} onChange={_handleInputChange} />
                        <Icon align="left" size="small">
                            <i className="fa fa-calendar-alt"></i>
                        </Icon>
                    </Form.Control>
                </Form.Field>
            {/* Resultados de cupo neto */}
                <Form.Field>
                    <Form.Label>% de endeudamiento según DAC</Form.Label>
                    <Form.Control>
                        <Form.Input name="porcenjateDeuda" value={data.porcentajeDeuda} onChange={_handleInputChange} isStatic={true}/>
                        <Icon align="left">
                            <i className="fa fa-money-bill"></i>
                        </Icon>
                    </Form.Control>
                </Form.Field>
                <Form.Field>
                    <Form.Label>Cupo de crédito Neto Colones</Form.Label>
                    <Form.Control>
                        <Form.Input name="creditoColones" value={data.creditoColones} onChange={_handleInputChange} isStatic={true}/>
                        <Icon align="left">
                            <i className="fa fa-money-bill"></i>
                        </Icon>
                    </Form.Control>
                </Form.Field>
                <Form.Field>
                    <Form.Label>Cupo de crédito Neto Dólares</Form.Label>
                    <Form.Control>
                        <Form.Input name="creditoDolares" value={data.creditoDolares} onChange={_handleInputChange} isStatic={true} />
                        <Icon align="left">
                            <i className="fa fa-money-bill"></i>
                        </Icon>
                    </Form.Control>
                </Form.Field>
            </Columns.Column>
            <Columns.Column>
                <Table className="is-fullwidth" >
                    <thead style={pStyle}>
                        <tr>
                            <th colSpan="7">Regla de nivel de endeudamiento</th>
                        </tr>
                        <tr>
                            <th rowSpan="4" colSpan="2">Ingreso neto mensual o su equivalente en colones</th>
                            <th colSpan="2">Asalariados</th>
                            <th rowSpan="4">ENDEUDAMIENTO</th>
                        </tr>
                        <tr>
                            <th>Relación Cuotas totales/Ingreso neto</th>
                            <th>Asalariado con depósito en el BCR y rebajo automático</th>
                        </tr>
                        <tr>
                            <th>Colones -Dólares</th>
                            <th>'4</th>
                        </tr>
                    </thead>
                    <tbody style={pStyle}>
                        { configuracion && configuracion.nivelesDeEndeudamiento.length > 0 ? 
                            configuracion.nivelesDeEndeudamiento.map(nivel => {
                                return <tr key={nivel.valor}>
                                    <td>$ {nivel.montoDesde}</td>
                                    <td>$ {nivel.montoHasta}</td>
                                    <td>{nivel.relacionCuota}%</td>
                                    <td>{nivel.rebajoAutomatico}%</td>
                                    <td>{nivel.valor}%</td>
                                </tr>
                            }) : <tr></tr>
                        }
                    </tbody>
                </Table>
            </Columns.Column>
        </Columns>
    </div>)
}

export default SelectProducto;