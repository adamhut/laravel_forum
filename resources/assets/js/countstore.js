export default {
    state:{
        count:0,
    },
    mutations:{
        increment(state){
            
            state.count++;
        },
        decrement(state){
            state.count--;
        },
    },

    actions:{
         increment(context){
            setTimeout(()=>{
                context.commit('increment');
                //state.count++
            },2000);
         }
    },

    getters:{
        sqrt(state){
            return Math.sqrt(state.count);
        }
    }
}