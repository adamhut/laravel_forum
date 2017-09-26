<template>
	<div :id="'reply-'+id" class="panel" :class="isBest? 'panel-success':'panel-default'">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/'+data.owner.name"
                        v-text="data.owner.name"
                    >
                    </a>
                    said 
                    <span v-text="ago"> </span>
                </h5>

                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div v-if="editing">
            	<form @submit="update">
	                <div class="form-group">
	                    <textarea  class="form-control" v-model="body" required></textarea>
	                </div>
	                <button class="btn btn-xs btn-primary" type="submit">Update</button>
	                <button class="btn btn-xs btn-link" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>
            <div v-else class="body" v-html="body">
               
            </div>
            <hr>
        </div>
     
            <div class="panel-footer level"> 
            	<div v-if="authorize('updateReply',reply)"> 
                	<button class="btn btn-xs btn-default mr-1" @click="editing = true">Edit</button>
                	<button class="btn btn-xs btn-danger mr-1" @click="destroy">Delete</button>
                </div>
                <div>
                	<button class="btn btn-xs btn-default ml-a"  @click="markBestReply" v-show="! isBest">Best Reply</button>
                </div>
            </div>
        
    </div>
</template>
<script>
	import Favorite from './Favorite.vue'
	export default{
		props:[
			'data'
		],
		components:{
			Favorite
		},
		data(){
			return {
				id 		: this.data.id,
				editing	: false,
				body 	: this.data.body,
				isBest 	: this.data.isBest,
				reply 	: this.data,
			};
		},
		computed:{
			/*  //Move to Vue Prototype			
			signedIn(){
				return window.App.signedIn;
			},
			canUpdate(){
				return this.authorize(user=>this.data.user_id == user.id);
				//return this.data.user_id== window.App.user.id;
			},*/
			ago(){
				return moment(this.data.created_at).fromNow() +' ...';
			}
		},
		mounted(){
			console.log(moment(this.data.created_at).fromNow());
		},
		created(){
			window.events.$on('best-reply-selected',id=>{
				this.isBest = (id ==this.id);
			});
		},
		methods:{
			update(){
				axios.patch('/replies/'+this.id,{
					body:this.body,
				})
				
				.catch(error=>{
					console.log(error.response);
					flash(error.response.data,'danger');
					return;
				});

				this.editing = false;
					flash('updated','success');
			},
			destroy(){
				
				axios.delete('/replies/'+this.id);
				/*
				$(this.$el).fadeOut(300,()=>{
					flash('Your Reply Has been Delete','success');	
				});
				*/
				this.$emit('deleted',this.id)
				//this.editing = false;
			},
			markBestReply(){
				
				//this.isBest = true;

				axios.post('/replies/'+this.data.id+'/best');

				window.events.$emit('best-reply-selected',this.data.id);
			}
		}
	}

</script>