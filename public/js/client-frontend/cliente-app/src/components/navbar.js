import React, { Component } from 'react'
import {Button, Navbar, Nav, NavDropdown, MenuItem, NavItem} from 'react-bootstrap'

import 'bootstrap/dist/css/bootstrap.css'

import '../css/styles.css'
import Carrito from './Carrito'

const logo = require('../img/logo.png');

export default class Navigator extends Component{

	constructor(props){
		super(props)
	}


	render(){

		return(
			<Navbar staticTop className="navigation">
			    <Navbar.Header>
			      <Navbar.Brand>
			        <a href="#">
			        	<img src={logo} className="brand-logo"/>
			        </a>
			      </Navbar.Brand>
			      <Navbar.Toggle />
			    </Navbar.Header>
			    <Navbar.Collapse>
			      <Nav>
			        <NavItem eventKey={1} href="/">Inicio</NavItem>
			        <NavItem eventKey={2} href="consultar">Mis servicios</NavItem>
			        <NavItem eventKey={3} href="productos">Productos</NavItem>
			        <NavItem eventKey={3} href="solicitar-servicio">Solicititar servicio</NavItem>
			        {this.props.children}
			      </Nav>
			    </Navbar.Collapse>
			</Navbar>
		)

	}

}
