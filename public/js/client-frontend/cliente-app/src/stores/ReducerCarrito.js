import {createStore} from 'redux'


const ReducerCarrito = (state = { carrito: [] }, action)=>{

	switch(action.type){
		case 'ADD_TO_CAR':{
			return {
				...state,
				carrito:  state.carrito.concat(action.producto) 
			}
			break;
		}

		case 'REMOVE_TO_CAR':{
			let otro = state.carrito.splice(action.position.target.id, 1)
			return {
				...state,
				carrito: state.carrito
			}
			break;
		}
	}
}

const store = createStore(ReducerCarrito, { carrito:[] });

export default store;