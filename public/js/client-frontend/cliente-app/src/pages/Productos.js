import React, { Component } from 'react';
import logo from '../logo.svg';
import '../App.css';
import Navigation from '../components/navbar.js';
import Card from '../components/Cards.js'
import axios from 'axios';

import {Button, Row, Col} from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.css'
import store from '../stores/ReducerCarrito.js'
import Carrito from '../components/Carrito'


const styles = {
	cards: {
		backgroundColor: "#ffffff",
		fontFamily: "Helvetica",
		marginTop: "13px"
	},
	imagen:{
		maxHeight: "300px"
	}
}

export default class Productos extends Component{

	constructor(props){
		super(props)

		this.state = {
			productos: [],
		}
		this.renderCard = this.renderCard.bind(this)
		this.insertCarrito = this.insertCarrito.bind(this)

	}


	componentDidMount(){
		axios.get('http://localhost:8000/api/productos')
		.then( (response)=>{
			this.setState({
				productos: response.data.productos
			})
			return true;
		} )
	}

	insertCarrito(producto){
		store.dispatch({type: "ADD_TO_CAR", producto})
	}

	renderCard(){

		if(this.state.productos.length > 0)
		{
			let productos = this.state.productos.filter(Boolean)
			const listado = productos.map( ({producto, categoria}, indice) =>{
				return(
					<Col xs={12} sm={12} md={4} lg={4} key={producto.id} style={ styles.cards }>
						<Row>
							<Col xs={12} sm={12} md={12} lg={12}>
								<img src={producto.imagen} style={styles.imagen} className="img-responsive" />
							</Col>
						</Row>
						<Row>
							<Col xs={12} sm={12} md={12} lg={12}>
								<strong>{producto.nombre_hardware}</strong>
								<hr />
								<p style={{textAligh: "justify"}} >
									<strong>Precio: {producto.precio}</strong>
								</p>
								<br />
								<br />
								<button onClick={()=>this.insertCarrito(producto)} className="btn btn-primary">Comprar</button>
							</Col>							
						</Row>
					</Col>
				)
			} )

			//console.log(listado)
			return listado
		}
	}

	render(){
		return(
			<div>
				<Navigation />
				<Carrito />
				<div id="productos" className="container body">
					<Row>
						{this.renderCard()}
					</Row>
				</div>
			</div>
		)
	}
}