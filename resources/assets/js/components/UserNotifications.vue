<template>
	<li class="dropdown"  v-if="notifications">
        <a href="#" 
        	class="dropdown-toggle" 
        	data-toggle="dropdown" 
        	role="button" 
        	aria-expanded="false"
        >
           <span class="glyphicon glyphicon-bell"></span>
           <span class="badge" v-text="notifications.length"></span>
        </a>

        <ul class="dropdown-menu" role="menu">
			<notification-item v-for="notification in notifications" :notification="notification"> </notification-item>
            
        </ul>
	</li>
</template>

<script>
	import NotificationItem from './NotificationItem';	
	export default{
		data(){
			return {
				notifications :false,
			};
		},
		components:{NotificationItem},
		created(){
			//alert("profiles/"+window.App.user.name+"/noticiations");
			axios.get("/profiles/"+window.App.user.name+"/noticiations")
				.then(response=>this.notifications = response.data)
		},
		computed:{
			notificationCount(){
				return this.notifications.length;
			}
		},
		mounted(){
			/*
			window.Echo.channel('chat-room.1')
				.listen('ChatMessageWasReceived', (e) => {
					console.log(e.user,e.chatMessage);

			});*/
			Echo.private('App.User.' + window.App.user.id)
				.notification((notification) => {
					console.log(notification);
					let newNotification  ={data:{
						message:notification.message,
						link:notification.link,
						id:notification.id,
					}}
					this.notifications.push(newNotification);
				});
			console.log('Mounted5');
		},

		methods:{
			markAsRead(notification){
				axios.delete(`/profiles/${window.App.user.name}/noticiations/${notification.id}`)
					.then()
					.catch()
			}
		}
	}; 
</script>