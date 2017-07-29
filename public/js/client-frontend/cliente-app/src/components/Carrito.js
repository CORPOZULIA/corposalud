import React from 'react'

import store from '../stores/ReducerCarrito'
import{
	Navbar,
	NavItem,
	NavDropdown,
	Nav,
	Panel,
	PanelGroup,
	Acordion,
	ButtonGroup,
	Collapse,
	Button,
	Well,
	Grid,
	Glyphicon
} from 'react-bootstrap'
import {reactLocalStorage} from 'reactjs-localstorage';


export default class Carrito extends React.Component{

	constructor(props){
		super(props)

		this.state = {
			carrito: []
		}

		console.log(reactLocalStorage.getObject('carrito'))
		store.subscribe(() => {
			this.setState({
				carrito: store.getState().carrito
			})

			reactLocalStorage.setObject('carrito', store.getState().carrito);
		})
	}

	componentDidMount(){
		if( reactLocalStorage.getObject('carrito') ){
			store.dispatch({
				type: 'ADD_TO_CAR',
				producto: reactLocalStorage.getObject('carrito') || []
			})
		}

		console.log(reactLocalStorage.getObject('carrito') )	
	}

	renderCarrito(){
		const items = this.state.carrito.map( (item, indice)=> {
			console.log(indice)
			return(
				<tr>
					<td>{item.nombre_hardware}</td>
					<td>{item.codigo_hardware}</td>
					<td>{item.precio}</td>
					<td>
						<Button bsStyle={'danger'} id={indice} onClick={ (e)=> this.removeFromCar(e)} >
							<Glyphicon glyph="remove-circle" />
						</Button>  
					</td>
				</tr>
			)
		})

		console.log( this.state.carrito );
		return items;
	}

	totalizar(){
		var total = 0;
		for(var i = 0; i< this.state.carrito.length; i++){
			total+= this.state.carrito[i].precio;
		}
		return total;
	}

	removeFromCar = ( position ) =>{
		console.log(position.target.id)

		store.dispatch({
			type: "REMOVE_TO_CAR",
			position
		})
	}

	render(){
		return(
          <div className="contailer">
          	<Grid>
	            <Button onClick={ ()=> this.setState({ open: !this.state.open })}>
	              Mira aqui tu carrito
	            </Button>
	            <Collapse in={this.state.open}>
	              <div>
	                <Well>
	                  <table className="table table-responsive">
	                  	<thead>
	                  		<tr>
	                  			<td>Articulo</td>
	                  			<td>Codigo</td>
	                  			<td>Precio</td>
	                  			<td>Acciones</td>
	                  		</tr>
	                  	</thead>
	                  	<tbody>
	                  		{this.renderCarrito()}
	                  		<tr>
	                  			<td> </td>

	                  			<td> <strong> Total </strong></td>
	                  			<td> <strong>{this.totalizar()}</strong> </td>
	                  			<td><a href="http://localhost:3000/terminar-pedido" className="btn btn-success">Pagar</a></td>
	                  		</tr>
	                  	</tbody>
	                  	

	                  </table>
	                </Well>
	              </div>
	            </Collapse>
	         </Grid>
          </div>
		);
	}
}