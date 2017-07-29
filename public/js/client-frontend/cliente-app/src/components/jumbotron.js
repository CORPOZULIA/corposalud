import React, { Component } from 'react'
import { Jumbotron, Col, Row } from 'react-bootstrap'
import 'bootstrap/dist/css/bootstrap.css'
import '../css/styles.css'

const phone = require('../img/phone.png');

export default class Jumbo extends Component{

	constructor(props){
		super(props)
	}

	render(){
		return(

			<Jumbotron className="jumboBox">
				<div className="container">
					<Row>
						<Col xs={12} sm={12} md={6} lg={6} style={ {'color': "#fff"} }>
							<h2>
								Ofrecemos el mejor servicio electronico
							</h2>
							<h3>
								A televisores, computadoras y de mas...
							</h3>
						</Col>

						<Col className="hidden-xs hidden-sm" md={6} lg={6}>
							
						</Col>
					</Row>
				</div>
			</Jumbotron>
		)
	}
}