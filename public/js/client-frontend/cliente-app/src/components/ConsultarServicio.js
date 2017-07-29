import React from 'react'
import Navigator from './navbar.js'

import{
	Grid,
	Row,
	Col,
	Button
} from 'react-bootstrap'

import storeConsulta from '../stores/ReducerConsulta.js'
import $ from 'jquery'

export default class ConsultarServicio extends React.Component{

	constructor(props){
		super(props)
		this.state = {
			cliente: "",
			solicitud: "",
			estatus: "",
			datos_solicitud: ""

		}

		storeConsulta.subscribe(()=>{
			this.setState({
				cliente:storeConsulta.getState().cliente,
				solicitud: storeConsulta.getState().solicitud,
				estatus: storeConsulta.getState().estatus,
				datos_solicitud: storeConsulta.getState().datos_solicitud
			})
			console.log(this.state.datos_solicitud)
		})

	}

 	buscarCodigo = () =>{
		let codigo = $("#codigo_solicitud").val()
		if(codigo == "")
			alert("USTED NO HA ESCRITO UN CODIGO VALIDO")
		else{
			$.get("http://localhost:8000/solicitudes/consultar-estatus/"+codigo, (res)=>{
				if(res.error){
					alert(res.mensaje)
				}
				else{
					storeConsulta.dispatch({
						type: "CONSULTAR_SERVICIO",
						datos: res
					})
				}
			})
		}
	}

	render(){
		return(
			<div>
				<Navigator />
				<Grid>
					<Row>
						<Col xs={12} sm={12} md={8} lg={8}>
							<div className="input-group">
							

								<input type="text" name="codigo_solicitud" id="codigo_solicitud" className="form-control" placeholder="Codigo de la solicitud" /> 
								<span className="input-group-btn">
								<button id="buscar" onClick={ ()=>{this.buscarCodigo()} } className="btn btn-success">Consultar</button>
								</span>
							</div>
						</Col>
					</Row>
					<Row>
						<div >
							<table className="table table-responsive">
								<thead>
									<td>Cliente</td>
									<td>Cedula</td>
									<td>Nro. Solicitud</td>
									<td>Estatus</td>
								</thead>
								<tbody>
									<tr>
										<td>{this.state.cliente.nombres}</td>
										<td>{this.state.cliente.cedula}</td>
										<td>{this.state.datos_solicitud.codigo_solicitud}</td>
										<td>{this.state.estatus.nombre_estatus}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</Row>
				</Grid>
			</div>
		);
	}

}