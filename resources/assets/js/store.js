import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
	state:{
		todos:[
			{
				body: 'go to sotre',
				done: false,
			},
			{
				body: 'buy stuff',
				done: true,
			},
			{
				body: 'finish homework',
				done: false,
			},
		]
	},

	mutations:{
		completeAll(state){
			state.totos.foreach(todo=>todo.done=true);
		}
	}

});