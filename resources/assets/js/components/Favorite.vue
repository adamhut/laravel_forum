<template>
	<div>
		<button type="button" :class="classes" @click="toggle">
			<span class="glyphicon glyphicon-heart"></span>
			<span v-text="count" ></span>
		</button>
	</div>
</template>

<script>
	export default{
		props:[
			'reply'
		],
		data(){
			return{
				count: this.reply.favoritesCount,

				isFavorited: this.reply.isFavorited,
			}
		},

		computed:{
			classes(){
				return ['btn' ,  this.isFavorited ? 'btn-primary':'btn-default'];
			},
			
			endpoint(){
				return '/replies/'+this.reply.id+'/favorites';
			}
		},

		methods:{
			toggle(){
				return this.isFavorited ? this.unfavorite():this.favorite()
			},

			unfavorite(){
				axios.delete(this.endpoint);
				flash('unFavorited','success');
				this.count--;
				this.isFavorited =!this.isFavorited;
			},

			favorite(){
				axios.post(this.endpoint);
				flash('Favorited','success');
				this.count++;
				this.isFavorited =!this.isFavorited;
			}
		}

	}

</script>