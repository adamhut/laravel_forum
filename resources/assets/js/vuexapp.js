
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vuex from 'vuex';


Vue.use(Vuex);

/*
let store = new Vuex.Store({
    state:{
        count:0,
    },
    mutations:{
        increment(){
            this.state.count++;
        },
        decrement(){
            this.state.count--;
        },
    },


})
*/
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import store from './countstore';

Vue.component('counter',require('./components/Counter.vue'));
Vue.component('other',require('./components/Other.vue'));


const app = new Vue({
    el: '#app',
    store:new Vuex.Store(store),
    
});
