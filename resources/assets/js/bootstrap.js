
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');

require('bootstrap-sass');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');

window.Vue.prototype.authorize= function(handler){
	//Additional admin privilege.
	let user  = window.App.user;
	
	if(!user) return false;
	
	return handler(user);
}

window.moment = require('moment');


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.App.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo" 

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'b12fcbcf3175a9c80082',
    cluster: 'mt1',
    encrypted: true
});
	/*
	window.Echo.channel('chat-room.1')
    .listen('ChatMessageWasReceived', (e) => {
        console.log(e.user,e.chatMessage);

    });
    */
    window.Echo.private('chat-room.1')
    .listen('ChatMessageWasReceived', (e) => {
        console.log(e.user,e.chatMessage);

    });
    /*
    var pusher = new Pusher('b12fcbcf3175a9c80082', {
      encrypted: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      alert(data.message);
    });
    */
window.events = new Vue();

window.flash = function(message,level='success'){
	let payload={
		message,
		level
	}
	window.events.$emit('flash',payload);
}//flash my new message