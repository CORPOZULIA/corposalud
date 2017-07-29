import React, { Component } from 'react'
import { Jumbotron, Col, Row } from 'react-bootstrap'
import 'bootstrap/dist/css/bootstrap.css'
import '../css/styles.css'


export default class Card extends Component{
	constructor(props){
		super(props)
	}

	renderCard(){

		const returned = this.props.content.default.contents.map( (objeto, index) =>{
			return (
					<Col xs={12} sm={12} md={4} lg={4} className="card" key={index}>

						<Row>
							<Col xs={12} sm={12} md={12} lg={12}>
								<img src={objeto.imagen} alt={objeto.imagen} />
							</Col>
							<Col xs={12} sm={12} md={12} lg={12}>
								<p className="text-justify">
									{objeto.content}
								</p>
							</Col>
						</Row>
					
					</Col>
				)
		})


		console.log(this.props.content.default)
		return returned;
	}

	render(){
		return(

			<div className="container">

				<Row>
					{this.renderCard()}
				</Row>

			</div>
		);
	}
}