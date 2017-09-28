<template>
    <li class="todo" :class="{'is-complete':todo.done}">
        <input type="checkbox" :checked="todo.done" @change="toggleTodo(todo)"/>
        
        <span v-show = "!edit">
             <label v-text="todo.body"  @dblclick='edit=true'></label>
        </span>
        <input type="text" 
            v-model="task" 
            v-show='edit'
            @blur="edit=false"
            @keyup.enter='doneEdit'
        />
        <button @click="deleteTodo(todo)">X</button>
    </li>
</template>

<script>
    import {mapMutations} from 'vuex';

    export default {
        props:['todo'],
        data(){
            return {
                edit:false,
                task:this.todo.body,
            };
        },
        mounted() {
            console.log('Component mounted.')
        },

        methods:{
            ...mapMutations(['deleteTodo','toggleTodo','editTodo']),
            
            doneEdit(e){
                const value = e.target.value.trim()
                const { todo } = this
                //this.editTodo({todo,value});
                //console.log(e.e);
                this.$store.commit('editTodo',{todo,value});

                this.edit=false ; 
            },
            /*
            
             editTodo(){
                this.$store.commit('editTodo',);
            }
            */
        },
    }
</script>

<style>
    .todo.is-complete{
        color:grey;
    }
</style>