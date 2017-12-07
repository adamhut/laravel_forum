<template>
	<div>
		<div v-if="signedIn">
            <div class="form-group">    
				<wysiwyg name="body" v-model="body" :value="body" placeholder="Have something to say?" :shouldClear="completed"></wysiwyg>
      	    	
            </div>
            <button class="btn btn-default" 
            	type="submit" 
            	@click="addReply"
            >
            	Post
            </button>
        </div>
		
		<p class="text-center"
			v-else 
		>
			Please <a href="/login">sign in</a> to particatate in this discussion
		</p>

	</div>

</template>
<script>
 	import 'jquery.caret';
 	import 'at.js';
	export default{

		data(){
			return {
				body:'',
				completed:false,
			};
		},
		computed:{
			/*
			
			signedIn(){
				return window.App.signedIn;
			},
			*/
		},
		mounted(){
			$('#body').atwho({
				at:'@',
				delay:750,
				callbacks:{
					remoteFilter:function(query,callback){						
						$.getJSON("/api/users",{name:query}, function(usernames){
							callback(usernames);
						});						
					}	
				}
			});
		},
		methods:{
			addReply(){
				axios.post(location.pathname+'/replies',{
					body:this.body,
				})
				.then(response=>{
					this.body ='';
					this.completed= true;
					flash('Your reply Has been Post');
					this.$emit('created',response.data);
				}).catch(error=>{
					console.log(error.response);
					flash(error.response.data,'danger');
					return;
				});
			}
		}
	}
</script>