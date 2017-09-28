require('./bootstrap');

//Vue.use(Vuex);

import store from './store';

import {mapState,mapMutations,mapGetters} from 'vuex';

Vue.component('todo', require('./components/Todo.vue'));


const app = new Vue({
    el: '#app',
    
    data: {
        messages: []
    },

    store,
    /*
    computed:{
        todos(){
            return this.$store.state.todos;
        }
    },*/
    computed:{
    	...mapState(['todos']),
        ...mapGetters(['allComplete']),
    	/* 
        allComplete(){
    		return this.todos.every(todo=>todo.done);
    	}
        */

    },
    methods:{
    	...mapMutations(['completeAll','uncompleteAll']),
    	addTodo(event){
    		let body = event.target.value;

    		this.$store.commit('addTodo',body);
    		event.target.value='';
    	}
    }
   
});
