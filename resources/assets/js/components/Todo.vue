<template>
    <li class="todo">
        <input type="checkbox" :checked="todo.done">
        <label v-text="todo.body"></label>
    </li>
</template>

<script>
    export default {
        props:['todo'],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
