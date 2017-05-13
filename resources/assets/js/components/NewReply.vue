<template>
	<div>
		<div v-if="signedIn">
            <div class="form-group">    
      	    	<textarea name="body" 
      	    		class="form-control" 
      	    		id="body" 
      	    		placeholder="Have something to say" 
      	    		rows=5
      	    		required 
      	    		v-model="body"
      	    	>
      	    		
      	    	</textarea>
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
	export default{

		data(){
			return {
				body:'',
			
			};
		},
		computed:{
			signedIn(){
				return window.App.signedIn;
			},
		},
		methods:{
			addReply(){
				axios.post(location.pathname+'/replies',{
					body:this.body,
				})
				.then(response=>{
					this.body ='';
					flash('Your reply Has been Post');
					this.$emit('created',response.data);
				});
			}
		}
	}
</script>