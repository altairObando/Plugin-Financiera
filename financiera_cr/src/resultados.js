import React from 'react'
import { Button, Columns, Form, Icon } from 'react-bulma-components';
import { FormatNumber, PAGO } from './functions';

 
const styles = {
    title: {
        textAlign: "center",
        fontWeight: "bold"
    }
}

const Resultados =(props) => {
   const {data, setData} = props.data || {};
   const _handleOnChange = (event) => {
       var montoSolicitado = event.target.value || 0;
       var result = FormatNumber(PAGO(data.tasa/100/12, data.plazo, -montoSolicitado).toFixed(2))
       setData({...data, montoCuotaFinal: result, montoSolicitado: montoSolicitado })
   }
   return(
       <Columns>
          <Columns.Column>
            <p style={styles.title}>CONDICIONES CRÉDITO OFRECER</p>
            <Form.Field>
                <Form.Label>Tasa de Interés</Form.Label>
                <Form.Control>
                    <Form.Input name="tasa" id="tasa" value={data.tasa} isStatic={true}/>
                    <Icon align="left" size="small">
                        <i className="fa fa-percent"></i>
                    </Icon>
                </Form.Control>
            </Form.Field>
            <Form.Field>
                <Form.Label>Plazo Producto</Form.Label>
                <Form.Control>
                    <Form.Input name="plazo" id="plazo" value={data.plazo} isStatic={true}/>
                    <Icon align="left" size="small">
                        <i className="fa fa-calendar-alt"></i>
                    </Icon>
                </Form.Control>
            </Form.Field>
            
            <Form.Field>
                <Form.Label>Monto en Colones</Form.Label>
                <Form.Control>
                    <Form.Input name="sugerenciaColones" value={data.sugerenciaColones} isStatic={true} />
                    <Icon align="left" size="small">
                        <i className="fa fa-money-check"></i>
                    </Icon>
                </Form.Control>
            </Form.Field>
            <Form.Field>
                <Form.Label>Monto en Dlares</Form.Label>
                <Form.Control>
                    <Form.Input name="sugerenciaDolares" value={data.sugerenciaDolares} isStatic={true} />
                    <Icon align="left" size="small">
                        <i className="fa fa-money-check-alt"></i>
                    </Icon>
                </Form.Control>
            </Form.Field>
          </Columns.Column>
          <Columns.Column>
            <p style={styles.title}>Credito Solicitado Cliente</p>
            <Form.Field>
                <Form.Label>Moneda deseada por el cliente</Form.Label>
                <Form.Control>
                    <div className="field">
                        <p className="control">
                        <span className="select is-fullwidth">
                            <select name="moneda">
                            <option value="0">COLONES</option>
                            <option value="1">DÓLARES</option>
                            </select>
                        </span>
                        </p>
                    </div>
                    <Icon align="left" size="small">
                        <i className="fa fa-balance-scale-right"></i>
                    </Icon>
                </Form.Control>
            </Form.Field>
            <Form.Field>
                <Form.Label>Monto Solicitado</Form.Label>
                <Form.Control>
                    <Form.Input value={data.montoSolicitado} name="montoSolicitado" onChange={_handleOnChange}/>
                    <Icon align="left" size="small">
                        <i className="fa fa-money-bill"></i>
                    </Icon>
                </Form.Control>
            </Form.Field>
            <Form.Field>
                <Form.Label>Cuota Credito</Form.Label>
                <Form.Control>
                    <Form.Input value={data.montoCuotaFinal} isStatic={true} />
                    <Icon align="left" size="small">
                        <i className="fa fa-money-bill"></i>
                    </Icon>
                </Form.Control>
            </Form.Field>
            <br></br>
            <Columns>
                <Columns.Column size="four-fifths">
                    <Form.Field>
                        <Form.Label>Correo Electronico</Form.Label>
                            <Form.Control>
                                <Form.Input value={data.emailClient} name="emailClient"  onChange={_handleOnChange} />
                                <Icon align="left" size="small">
                                    <i className="fa fa-at"></i>
                                </Icon>
                            </Form.Control>
                    </Form.Field>
                </Columns.Column>
                <Columns.Column>
                    <Button color="info" style={{marginTop:"2em"}}>
                        <Icon>
                            <i className="fa fa-envelope"></i>
                        </Icon>
                    </Button>
                </Columns.Column>
            </Columns>
            
            </Columns.Column>
       </Columns>
   )
}


export default Resultados;