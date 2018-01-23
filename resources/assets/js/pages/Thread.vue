<script>

	import Replies from '../components/replies.vue';
	import Highlight from '../components/Highlight.vue';
	import SubscribeButton from '../components/SubscribeButton.vue';
	export default{
		props:[
			'thread',
		],
		components:{Replies,SubscribeButton,Highlight},
		data(){
			return {
				repliesCount:this.thread.replies_count,
				locked:this.thread.locked,
				editing:false,
				title:this.thread.title,
				body:this.thread.body,
				form:{},
			};
		},

		created(){
			this.resetForm();
		},

		methods:{
			toggleLock(){
				let uri = `/locked-threads/${this.thread.slug}`;

				axios[this.locked? 'delete' : 'post' ](uri);
				
				this.locked=!this.locked;
				
				let level = this.locked ? 'danger':'success';
				
				flash('Thread is '+ (this.locked? 'Locked':'Unlocked'), level);
			},
			update(){
				let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;
				//axios
				axios.patch(uri,this.form).then(()=>{
					
					this.editing = false;
					this.title = this.form.title;
					this.body = this.form.body;
					falsh('Your thread has been updated');
				});				
			},
			resetForm(){
				this.form={
					title: this.thread.title,
					body : this.thread.body,
				}; 
				this.editing=false;
			}
		}
	};
</script>