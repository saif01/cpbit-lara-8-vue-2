import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)


export default new Vuex.Store({

    state : {
        auth  : null,
        roles : null, 
        CountNotProcess: null,
        CountProcess: null,
    },

    getters : {

        getAuth(state){
            return state.auth;
        },
        getRoles(state){
            return state.roles;
        },

        // count
        getCountNotProcess(state){
            return state.CountNotProcess;
        },

        getCountProcess(state){
            return state.CountProcess;
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

        // count process
        setCountNotProcess(state, data){
            state.CountNotProcess = data;
        },

        setCountProcess(state, data){
            state.CountProcess = data;
        },
    
    },

    actions :  {
        
    },

});