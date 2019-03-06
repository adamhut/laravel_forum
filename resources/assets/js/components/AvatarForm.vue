<template>
	<div>
		<div class="level">
			<img :src="avatar" alt="" width="50" height="50" class="mr-1">
			<h1>
				{{user.name}}
				<small>{{reputation}}</small>
			</h1>
		</div>
		
			<form v-if="canUpdate"
				method="POST" 
				enctype="multipart/form-data"
			>
				<image-upload name="avatar" @loaded="onLoad" ></image-upload>	
				<!--<input type="file" name="avatar" accept="image/*" @change="onChange">-->
				
			</form> 
		
	</div>
</template>

<script>
	import ImageUpload from './ImageUpload.vue';
	export default{
		props:['user','data'],
		
		components:{ImageUpload},

		data(){
			return {
				avatar:this.user.avatar_path,
			}
		},

		computed:{
			canUpdate(){
				return this.authorize(user => user.id === this.user.id)
			},
			reputation(){
				return this.user.reputation+'XP';
			}
		},

		methods:{
			onLoad(avatar){
				//persist to the server
				this.avatar = avatar.src;
				this.persist(avatar.file);
					
			},
			persist(avatar){
				let data = new FormData();
				data.append('avatar',avatar)
				axios.post(`/api/users/${this.user.name}/avatar`,data)
					.then(()=>flash('Avatar uploaded!'));
					.then(response=>{
						this.model.data= response.data
					});
			}

		}

	}
</script>