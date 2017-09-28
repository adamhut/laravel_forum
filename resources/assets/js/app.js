
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import store from './store';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('flash', require('./components/Flash.vue'));
//Vue.component('reply', require('./components/Reply.vue'));

//Vue.component('replies', require('./components/Replies.vue'));
Vue.component('thread-view', require('./Pages/Thread.vue'));

Vue.component('user-notifications', require('./components/UserNotifications.vue'));
Vue.component('Paginator', require('./components/Paginator.vue'));

Vue.component('favorite', require('./components/Favorite.vue'));
Vue.component('avatar-form', require('./components/AvatarForm.vue'));


Vue.component('chatMessages', require('./components/ChatMessages.vue'));
Vue.component('chatForm', require('./components/ChatForm.vue'));

Vue.component('todo', require('./components/Todo.vue'));

import {mapState,mapMutations} from 'vuex';

Vue.component('counter',require('./components/Counter.vue'));

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
    computed:mapState(['todos']),
    created() {
        this.fetchMessages();
        /*
        Echo.private('chat')
            .listen('MessageSent', (e) => {
                this.messages.push({
                message: e.message.message,
                user: e.user
            });
        });
        */
        
    },

    methods: {
        
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            });


        },

        addMessage(message) {
            this.messages.push(message);

            axios.post('/messages', message).then(response => {
              console.log(response.data);
            });
        }
    }
});
