<template>
	<div :id="'reply-'+id" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/'+data.owner.name"
                        v-text="data.owner.name">
                    </a>
                    said 
                    {{fromNow}} ...
                </h5>

                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea  class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else class="body" v-text="body">
               
            </div>
            <hr>
        </div>
     
            <div class="panel-footer level" v-if="canUpdate"> 
                <button class="btn btn-xs btn-default mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-xs btn-danger mr-1" @click="destroy">Delete</button>
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
				id: this.data.id,
				editing: false,
				body : this.data.body,
			};
		},
		computed:{
			signedIn(){
				return window.App.signedIn;
			},
			canUpdate(){
				return this.authorize(user=>this.data.user_id == user.id);
				//return this.data.user_id== window.App.user.id;
			},
			fromNow(){
				return moment(this.data.created_at).fromNow();
			}
		},
		mounted(){
			console.log(moment(this.data.created_at).fromNow());
		},

		methods:{
			update(){
				axios.patch('/replies/'+this.id,{
					body:this.body,
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
		}
	}

</script>