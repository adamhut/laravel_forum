<template>
    <div class="alert alert-flash" :class="level" role="alert" v-show="show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Warning!</strong> {{body}}
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
                level:'alert-success',
            };
        },
        created(){
            this.calcLevel(this.cate)
            if(this.message){
                this.body = this.message;
                this.flash(this.message);
            };
            window.events.$on('flash',payload=>{
                this.flash(payload.message,payload.level);
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

                this.level="alert-success";
            }
            ,
            flash(message,level){
                this.calcLevel(level);
                this.body = message;
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
