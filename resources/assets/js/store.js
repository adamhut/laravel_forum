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
			state.todos.forEach(todo=>todo.done=true);
		},
		uncompleteAll(state){
			state.todos.forEach(todo=>todo.done=false);
		},
		deleteTodo(state, todo){
			state.todos.splice(state.todos.indexOf(todo),1);
		},
		editTodo(state, {todo,value}){
		//editTodo(state, todo,value){
		//editTodo(state, value){
		console.log(todo);
			todo.body = value;
			//console.log(value);
			//state.todos.splice(state.todos.indexOf(todo),1);
		},
		toggleTodo(state, todo){
			todo.done = !todo.done;
		},
		addTodo(state,body){
			state.todos.push({
				body:body,
				done:false,
			})
		},
	},
	getters:{
		allComplete(state){
			return state.todos.every(todo=>todo.done);
		}
	}

});