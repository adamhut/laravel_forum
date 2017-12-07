<template>
	<div :id="'reply-'+id" class="panel" :class="isBest? 'panel-success':'panel-default'">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/'+reply.owner.name"
                        v-text="reply.owner.name"
                    >
                    </a>
                    said 
                    <span v-text="ago"> </span>
                </h5>

                <div v-if="signedIn">
                    <favorite :reply="reply"></favorite>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div v-if="editing">
            	<form @submit="update">
	                <div class="form-group">
	                    <!-- <textarea  class="form-control" v-model="body" required></textarea>-->
						<wysiwyg name="body" v-model="body"></wysiwyg>
	                </div>
	                <button class="btn btn-xs btn-primary" type="submit">Update</button>
	                <button class="btn btn-xs btn-link" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>
            <div v-else class="body" v-html="body">
               
            </div>
            <hr>
        </div>
     
            <div class="panel-footer level" v-if="authorize('owns',reply) ||authorize('owns',reply.thread)"> 
            	<div v-if="authorize('owns',reply)"> 
                	<button class="btn btn-xs btn-default mr-1" @click="editing = true">Edit</button>
                	<button class="btn btn-xs btn-danger mr-1" @click="destroy">Delete</button>
                </div>
                <div>
                	<button 
                		class="btn btn-xs btn-default ml-a"  
                		@click="markBestReply" 
                		v-show ="!isBest"
                		v-if="authorize('owns',reply.thread)"
                	>
                		Best Reply
                	</button>
                </div>
            </div>
        
    </div>
</template>
<script>
	import Favorite from './Favorite.vue'; 
	import moment from 'moment';
	export default{
		props:[
			'dataReply'
		],
		components:{
			Favorite
		},
		data(){
			return {
				id 		: this.dataReply.id,
				editing	: false,
				body 	: this.dataReply.body,
				isBest 	: this.dataReply.isBest,
				reply 	: this.dataReply,
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
				return moment(this.dataReply.created_at).fromNow() +' ...';
			}
		},
		mounted(){
			console.log(moment(this.dataReply.created_at).fromNow());
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

				axios.post('/replies/'+this.id+'/best');

				window.events.$emit('best-reply-selected',this.id);
			}
		}
	}

</script>