import React from 'react'
import {
  BrowserRouter as Router,
  Route,
  Link,
  Switch
} from 'react-router-dom'

import Index from './pages/Index.js'
import Productos from './pages/Productos.js'
import Pedir from './components/Pedir.js'
import ConsultarServicio from './components/ConsultarServicio.js'
import Solicitud from './components/Solicitud.js'



const AppRouters = () => (
	<Router>
	  <Switch>
	      <Route exact path="/" component={Index}/>
	      <Route path="/productos" component={Productos}/>
	      <Route path="/terminar-pedido" component={Pedir}/>
	      <Route path="/consultar" component={ConsultarServicio}/>
	      <Route path="/solicitar-servicio" component={Solicitud}/>
	  </Switch>
  </Router>
)

export default AppRouters;