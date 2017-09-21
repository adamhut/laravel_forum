<template>
	<li>
       	<a :href="notification.data.link" 
           		v-text="notification.data.message" 
          		@click="markAsRead(notification)"
          	>
       	</a>
    </li>	
</template>

<script>
	export default{
		props:['notification'],

		methods:{
			markAsRead(notification){
				axios.delete(`/profiles/${window.App.user.name}/noticiations/${notification.id}`)
					.then()
					.catch()
			}
		}
	}
</script>