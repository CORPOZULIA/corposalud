import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';
import registerServiceWorker from './registerServiceWorker';
import {
  BrowserRouter as Router
} from 'react-router-dom'
import AppRouters from './AppRouters.js'


ReactDOM.render(
	
		<AppRouters />
	,
	document.getElementById('root')
);
registerServiceWorker();
