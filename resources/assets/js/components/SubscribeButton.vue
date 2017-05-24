<template>
	<div>
		<button :class="classes"  @click="subscribe">Subscribe</button>
	</div>
</template>

<script>
	export default{
		props:['active'],
		
		data(){
			return {
				isActived:this.active,
			};
		},
		computed:{
			classes(){
				return ['btn',this.isActived ? 'btn-primary':'btn-default']
			}
		},
		methods:{
			subscribe(){
				let requestType = this.isActived ? 'delete':'post';
				axios[requestType](location.pathname+'/subscriptions')
					.then(res=>{
						flash('subscrbed')
					});
				this.isActived=!this.isActived ;
			},
			
		},
	};
</script>