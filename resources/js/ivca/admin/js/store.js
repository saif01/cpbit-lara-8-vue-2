import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)


export default new Vuex.Store({

    state : {
        auth  : null,
        roles : null,
    },

    getters : {

        getAuth(state){
            return state.auth;
        },
        getRoles(state){
            return state.roles;
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
    
    },

    actions :  {
        
    },

});