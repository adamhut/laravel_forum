<template>
    <div class="alert alert-flash" 
        :class="'alert-'+level" 
        role="alert" 
        v-show="show"
        v-text="body"
    >
    </div>
</template>

<script>
const defaultType=[
    'success','danger','warning','info'
];
    export default {
        props:{
            message:{
                default:'Nothing', 
            },
            cate:{
                type:String,
                default:'success',
            }
        },
        data(){
            return {
                body:this.message,
                show:false,
                level:'success',
            };
        },
        created(){
            //this.calcLevel(this.cate)
            if(this.message){
                this.body = this.message;
                this.flash(this.message);
            };
            window.events.$on('flash',data=>{
                this.flash(data);
            });
        },
        computed: {
            
        },
        methods:{
            calcLevel(level)
            {
                if(defaultType.includes(level))
                {
                   this.level = "alert-"+level;
                   return ;
                }

               // this.level="alert-success";
            },
            flash(data){
                //this.calcLevel(level);
                //console.log('level is'+data.level)
                if(data)
                {
                    this.level = data.level;
                    this.body = data.message;
                }
                this.show=true;
                this.hide();
            },
            hide(){
                setTimeout(()=>{
                    this.show = false;
                }, 3000);
            },
        }
    }
</script>

<style type="text/css">
    .alert-flash{
        position: fixed;
        right:25px;
        bottom: 25px;
    }
    

</style>
