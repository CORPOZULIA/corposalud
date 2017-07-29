import React, { Component } from 'react';
import logo from '../logo.svg';
import '../App.css';
import Navigation from '../components/navbar.js';
import Card from '../components/Cards.js'
import axios from 'axios';
import Carrito from './Carrito.js'

import {Button, Row, Col, Grid, Glyphicon} from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.css'
import store from '../stores/ReducerCarrito.js'
import $ from 'jquery'

import {reactLocalStorage} from 'reactjs-localstorage';

export default class Pedir extends Component{

	constructor(props){
		super(props)
		this.state = {
			carrito: reactLocalStorage.getObject('carrito'),
			nombres: "",
			apellidos: "",
			cedula: "",
			email: "",
			direccion: "",
			fecha_vencimiento: "",
			numero_tarjeta: ""

		}
		store.subscribe(()=>{
			this.setState({
				carrito: store.getState().carrito,
				pagando: false
			})
		});
	}

	realizarPago = () =>{
		this.setState({
			pagando: false
		})

		let formulario = $("#guardar").serialize()
		let productos = reactLocalStorage.getObject('carrito')

		var articulos = [];
		var long = productos.length

		for(var i = 0 ;i<long; i++){
			articulos[i] = productos[i].codigo_hardware 
		}

		console.log(articulos);
		$.post('http://localhost:8000/solicitudes/pagar?articulos='+articulos, formulario, function(e){
			alert(e.mensaje)
			if(! e.error){
				reactLocalStorage.setObject('carrito', { carrito: [] })
				window.location.href = e.consultar
			}
		})
	}

	render(){
		return(
			<div>
				<Navigation />
				<Grid>
					<Row>
						<Col xs={12} sm={12} lg={10}>
							<form method="post" action="#" id="guardar">
								<Carrito />
								<Row>
									<Col xs={12} sm={12} md={4} lg={4}>
										<label>Nombres</label>
										<input type="text" className="form-control" name="nombres" placeholder="Nombres del cliente" />
									</Col>
									<Col xs={12} sm={12} md={4} lg={4}>
										<label>Apellidos </label>
										<input type="text" className="form-control" name="apellidos" placeholder="Apellidos del cliente" />
									</Col>
									<Col xs={12} sm={12} md={4} lg={4}>
										<label>Cedula</label>
										<input type="text" className="form-control" name="cedula" placeholder="Ingresa tu numero de cedula" />
									</Col>
									<Col xs={12} sm={12} md={12} lg={12}>
										<label>Direccion</label>
										<input type="text" className="form-control" name="direccion" placeholder="Direccion de residencia" />
									</Col>
									<Col xs={12} sm={12} md={12} lg={12}>
										<label>Correo electronico</label>
										<input type="text" className="form-control" name="email" placeholder="Direccion de correo electronico" />
									</Col>

									<Col xs={12} sm={12} md={6} lg={6}>
										<label>Telefono personal</label>
										<input type="text" className="form-control" name="telefono_personal" placeholder="Telefono personal" />
									</Col>
									<Col xs={12} sm={12} md={6} lg={6}>
										<label>Telefono de contacto</label>
										<input type="text" className="form-control" name="telefono_habitacion" placeholder="Telefono de contacto" />
									</Col>
									<Col xs={12} sm={12} md={6} lg={6}>
										<label>Numero de tarjeta</label>
										<input type="text" className="form-control" name="numero_tarjeta" placeholder="Tarjeta de credito" />
									</Col>
									<Col xs={12} sm={12} md={6} lg={6}>
										<label>Fec. de vencimiento de la TDC</label>
										<input type="date" className="form-control" name="fecha_vencimiento" />
									</Col>
									<br /><br />
									<Col xs={12} sm={12} md={12} lg={6}>
										<br/><br/>
										<Button onClick={ ()=>{this.realizarPago()} } disabled={this.state.pagando} block bsStyle={"success"} >Pagar</Button>
									</Col>
								</Row>
							</form>
						</Col>
					</Row>
				</Grid>
			</div>
		);
	}
}