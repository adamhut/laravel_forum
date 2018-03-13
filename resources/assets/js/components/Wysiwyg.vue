<template>
    <div>
        <input id="trix" type="hidden" :name="name" :value="value">
        <trix-editor ref="trix" input="trix" :placeholder="placeholder"></trix-editor>
    </div>
</template>

<script>
    import Trix from 'trix';

    export default{
        props:['name','value','placeholder','shouldClear'],
        
        mounted(){
            this.$refs.trix.addEventListener('trix-change',e => {
                //console.log(e.target.innerHtml);
                this.$emit('input',e.target.innerHTML);
            })

            this.$watch('shouldClear',()=>{
                console.log('it changed');
                this.$refs.trix.value='';
            });
        }
    }
</script>

<style>
.trix-editor{
    min-height: 100px;
}
</style>