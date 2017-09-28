<template>
    <div>  The count is from other num unreleative {{count}}</div>
</template>

<script>
    export default{
    	computed:{
    		count(){
    			return this.$store.state.count;

    		}
    	}
    }
</script>
