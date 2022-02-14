import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)


export default new Vuex.Store({

    state : {
        auth  : null,
        roles : null,
        
        // Not Comment Car 
        counter: null,
        counterDialog: false,
        counterDialogKey:1,

    },

    getters : {

        getAuth(state){
            return state.auth;
        },
        getRoles(state){
            return state.roles;
        },

        getCounter(state){
            return state.counter;
        },

        // Not Comment Dailog
        getCounterDialog(state){
            return state.counterDialog;
        },
        // Not Comment Dailog Rerendar Key 
        getCounterDialogKey(state){
            return state.counterDialogKey;
        },
    
 
    },

    mutations : {

        // Auth User
        setAuth(state, data){
            state.auth = data;
        },

        // Roles User
        setRoles(state, data){
            state.roles = data;
        },

        // Roles User
        setCounter(state, data){
            state.counter = data;
        },


        // Not Comment Dailog
        setCounterDialog(state, data){
            state.counterDialog = data;
        },
        // Not Comment Dailog Rerendar Key 
        setCounterDialogKey(state){
            state.counterDialogKey++ ;
        },
    
    },

    actions :  {

        // carNotCommented(){
        //     axios.get('/carpool/comment/comment_count').then(response => {
        //         let commentCount = response.data;
        //          console.log('car commented data', response.data);
        //         // Data Update in store
        //         context.commit('setCounter', commentCount)
        //         if( commentCount >= 2 ){
        //             // Data Update in store
        //             context.commit('setCounterDialog', true)
        //         }
                
        //     }).catch(error => {
        //         // Data Update in store
        //         context.commit('setCounterDialog', false)
        //         console.log(error)
        //     })
        // },
        
    },

});