
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

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


const app = new Vue({
    el: '#app',
    
});
