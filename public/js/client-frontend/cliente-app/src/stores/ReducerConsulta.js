import {createStore} from 'redux'

const ReducerConsulta =(state = {}, action) =>{

	switch(action.type){
		case "CONSULTAR_SERVICIO":{
			return {
				...state,
				cliente: action.datos.cliente,
				estatus: action.datos.estatus,
				solicitud: action.datos.solicitud,
				datos_solicitud: action.datos.solicitud.datos
			}
		}

		case "SERVICIO_TIPOS_CATEGORIAS": {
			return{
				...state,
				tipos: action.datos.tipos,
				categorias: action.datos.categorias,
			}
		}
	}

}

const storeConsulta = createStore(ReducerConsulta);
export default storeConsulta;