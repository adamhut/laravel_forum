<template>
	<div>
		<div v-for="( reply , index ) in items" :key="reply.id">
			<reply :data-reply="reply" @deleted="remove(index)"></reply>
		</div>

		<paginator :dataSet="dataSet" @changed="fetch"></paginator>
		
		<p v-if="$parent.locked">
			This thread has been locked . No more replies are allowed
		</p>
		<new-reply :endpoint="endpoint" @created="add" v-else></new-reply>

	</div>
</template>
<script>
	import Reply from './Reply.vue';
	import NewReply from './NewReply.vue';
	import collection from '../mixin/Collection.js';
	/**import Collection from '../Collection';
 	
 	export default Collection.extend({
		components:{Reply,NewReply},
		data(){
			return {
				dataSet:false,
				endpoint:location.pathname+'/replies',
			};
		},
		created(){
			
			this.fetch(); 
		},
		methods:{
			fetch(){
				
				axios.get(this.url())
					.then(this.refresh);
			},
			refresh({data}){
				this.dataSet = data;
				this.items =data.data;
			},
			url(){
				return `${location.pathname}/replies`;
			},
		},

	});*/
	
	export default {
		
		components:{Reply,NewReply},
		mixins: [collection],
		data(){
			return {
				dataSet:false,
				endpoint:'',
			};
		},
		created(){
			
			this.fetch(); 
		},
		methods:{
			fetch(page){
				window.axios.get(this.url(page))
					.then(this.refresh);
			},
			refresh({data}){
				this.dataSet = data;
				this.items =data.data;
				window.scrollTo(0,0);
			},
			url(page){
				if(!page)
				{
					let query = location.search.match(/page=(\d+)/);
				
                    page = query ? query[1] : 1;
				}
		
				return `${location.pathname}/replies?page=${page}`;
			},
		},
	};
	/**/
</script>