import React, { useEffect } from 'react';
import { Box, Container, Form,  Section,  Tabs, Level, Button, Icon } from 'react-bulma-components'
import Resultados from './resultados';
import SelectProducto from './selectProducto';

var template = { 
  ingresoBruto: 0, 
  deudaSugef: 0, 
  cupoCredito: '¢ 0.00', 
  tipoCambio: 0,
  ingresoNeto: 0, 
  esAsalariado: false, 
  rebajoAutomatico: false, 
  nivelSugef: 1, 
  promedioCuotas: 0, 
  porcentajeDeuda: 0,
  creditoColones: 0, 
  creditoDolares: 0,
  tasa: 0, 
  plazo: 0,
  sugerenciaColones: 0,
  sugerenciaDolares: 0,
  montoSolicitado: 0,
  montoCuotaFinal: 0
}

const Calculadora = (any) =>{
    const [data, setData] = React.useState(template)
    const [activeTab, setActiveTab] = React.useState({
     grupo1: true,
     grupo2: false,
     grupo3: false,
     grupo4: false
    });
    const [loading, setLoading] = React.useState(true);
    
    const _updateCupoCredito = () => {
      const value = 
        new Intl.NumberFormat("es-NI").format((data.ingresoBruto - data.deudaSugef).toFixed(2));
      var newIngresoNeto = data.tipoCambio !== 0 ? (data.ingresoBruto - data.deudaSugef) / data.tipoCambio : 0;
      newIngresoNeto = '$ '+ new Intl.NumberFormat("es-NI").format((newIngresoNeto).toFixed(2));

      setData({...data, cupoCredito: '¢ ' + value, ingresoNeto: newIngresoNeto })
    }

    
    const _getTasaCambio = () =>{
      fetch("http://localhost/wordpress/wp-json/financiera/v1/tasaCambio")
      .then(response => { setLoading(false); return response.json() })
      .then(value => {
        setData({...data, tipoCambio: new Intl.NumberFormat("es-NI").format(value)})
      })
    }

    const _handleChange = (event) =>{
      setData({...data, [event.target.name]: event.target.value})
    }

    // Actualiza los valores en base a cambios predefinidos.
    useEffect(() => {
      _updateCupoCredito()
    // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [data.ingresoBruto, data.deudaSugef, data.tipoCambio])
    
    useEffect(() => {
      _getTasaCambio();
    // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    const _changeTab = (tab) => {
      var newState = {};
      Object.keys(activeTab).filter( i => (i !== tab.currentTarget.name)).map(n => newState[n] = false)
      newState[tab.currentTarget.name] = true;
      setActiveTab(newState);
    }

    const visibility = (tabname) => {
      return activeTab[tabname] ? {
        display: 'block'
      } : {
        display: 'none'
      }
    }

  return (
    <Container>
      <Box >
      { loading ? <progress className="progress is-small is-primary" max="100"></progress> : <></>  }
        <Tabs type="boxed" >
          
          <Tabs.Tab active={activeTab.grupo1} onClick={_changeTab} name="grupo1">
            <span className="icon is-small"><i className="far fa-address-book"></i></span>
            <span>Riesgo Técnico</span>
          </Tabs.Tab>
          <Tabs.Tab active={activeTab.grupo2} onClick={_changeTab} name="grupo2" >
            <span className="icon is-small"><i className="far fa-check-circle"></i></span>
            <span>Condiciones </span>
          </Tabs.Tab>
          <Tabs.Tab active={activeTab.grupo3} onClick={_changeTab} name="grupo3" >
            <span className="icon is-small"><i className="far fa-calculator"></i></span>
            <span>Producto</span>
          </Tabs.Tab>
          <Tabs.Tab active={activeTab.grupo4} onClick={_changeTab} name="grupo4" >
            <span className="icon is-small"><i className="far fa-hand-holding-usd"></i></span>
            <span>Resultados</span>
          </Tabs.Tab>
        </Tabs>
        <form>
          <div style={visibility("grupo1")} >
            <Form.Field>
              <Form.Label>Ingreso Bruto en Colones</Form.Label>
              <Form.Control>
                <Form.Input 
                  name="ingresoBruto" 
                  placeholder="Ingrese un monto en colones"
                  type="number"
                  value={data.ingresoBruto}
                  onChange={_handleChange}
                  />
                <Icon align="left" size="small">
                  <i className="far fa-money-bill-alt"></i>
                </Icon>
              </Form.Control>
            </Form.Field>
            <Form.Field>
              <Form.Label>Total Deudas SUGEF</Form.Label>
              <Form.Control>
                <Form.Input 
                  name="deudaSugef" 
                  placeholder="Ingrese un monto en colones"
                  type="number"
                  value={data.deudaSugef}
                  onChange={_handleChange}
                  />
                <Icon align="left" size="small">
                  <i className="far fa-money-bill-alt"></i>
                </Icon>
              </Form.Control>
            </Form.Field>
            <Form.Field>
              <Form.Label>CUPO DE CRÉDITO NETO (cuota)</Form.Label>
              <Form.Control>
                <Form.Input 
                  name="cupoCredito"
                  value={data.cupoCredito}
                  onChange={_handleChange}
                  isStatic={true}
                />
              <Icon align="left" size="small">
                <i className="far fa-piggy-bank"></i>
              </Icon>
              </Form.Control>
            </Form.Field>
            <Form.Field>
                <Form.Label>Tipo de Cambio Compra</Form.Label>
                <Form.Control>
                  <Form.Input 
                    name="tipoCambio"
                    value={data.tipoCambio}
                    onChange={_handleChange}
                  />
                  <Icon align="left" size="small">
                    <i className="far fa-money-bill-alt"></i>
                  </Icon>
                </Form.Control>
            </Form.Field>
            <Form.Field>
                <Form.Label>Ingreso Neto en dólares</Form.Label>
                <Form.Control>
                  <Form.Input 
                    name="ingresoNeto"
                    value={data.ingresoNeto}
                    onChange={_handleChange}
                    isStatic={true}
                  />
                  <Icon align="left" size="small">
                    <i className="far fa-dollar-sign"></i>
                  </Icon>
                </Form.Control>
            </Form.Field>
          </div>
          {/* Condiciones */}
          <div style={visibility("grupo2")}>
            <Form.Field>
              <Form.Label>Asalariado con depósito en la entidad financiera</Form.Label>
              <Form.Control>
                <div className="columns">
                  <div className="column is-half">
                    <div className="field">
                      <p className="control">
                        <span className="select is-fullwidth">
                          <select name="esAsalariado" value={data.esAsalariado} onChange={_handleChange}>
                            <option value="true">SI</option>
                            <option value="false">NO</option>
                          </select>
                        </span>
                      </p>
                    </div>
                  </div>
                </div>
              </Form.Control>
            </Form.Field>
            <Form.Field>
              <Form.Label>
                Rebajo automático
              </Form.Label>
              <Form.Control>
                <div className="columns">
                  <div className="column is-half">
                    <div className="field">
                      <p className="control">
                        <span className="select is-fullwidth">
                          <select name="rebajoAutomatico" value={data.rebajoAutomatico} onChange={_handleChange}>
                            <option value="true">SI</option>
                            <option value="false">NO</option>
                          </select>
                        </span>
                      </p>
                    </div>
                  </div>
                </div>
              </Form.Control>
            </Form.Field>
            
            <Form.Field>
              <Form.Label>Nivel SUGEF (1 a 4)</Form.Label>
              <Form.Control>
                <div className="columns">
                  <div className="column is-half">
                    <div className="field">
                      <p className="control">
                        <span className="select is-fullwidth">
                          <select name="nivelSugef" value={data.nivelSugef} onChange={_handleChange}>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                          </select>
                        </span>
                      </p>
                    </div>
                  </div>
                </div>
              </Form.Control>
            </Form.Field>
            
            <Form.Field>
              <Form.Label>Promedio de atraso de pagos (en días)</Form.Label>
              <Form.Control>
                <Form.Input
                name="promedioCuotas"
                value={data.promedioCuotas}
                onChange={_handleChange} />
                <Icon align="left" size="small">
                  <i className="fa fa-hand-holding-usd"></i>
                </Icon>
              </Form.Control>
            </Form.Field>
          </div>
          {/* Muestra Resultados */}
          <div style={visibility("grupo3")}>
            <p className="subtitle"> Tarificación Configurada Por Producto (Valor actual: {data.ingresoNeto}) </p>
            <SelectProducto loader={{loading, setLoading}} data={{data, setData}}/>
          </div>  
          <div style={visibility("grupo4")}>
            <Resultados data={{data, setData}}/>        
          </div>       
          {/* Botones de Navegación */}
          <Section >
            <Level>
              <Level.Side align="left">
                <Level.Item>
                  <Button color="info" size="small" type="button" isStatic={activeTab.grupo1}>
                    Regresar
                  </Button>
                </Level.Item>
              </Level.Side>
              <Level.Side align="right">
                <Level.Item>
                  <Button color="info" size="small" type="button" >
                    Siguiente
                  </Button>
                </Level.Item>
              </Level.Side>
            </Level>
          </Section>
          </form>
      </Box>
    </Container>
  );
}
export default Calculadora;