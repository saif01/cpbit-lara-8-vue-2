import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)


export default new Vuex.Store({

    state : {
        authUser  : null,
        userRoles : null,
        loading : false,
    },

    getters : {

        getUser(state){
            return state.authUser;
        },
    
        getRole(state){
            return state.userRoles;
        },
    
    },

    mutations : {

        // Auth User
        setUser(state, data){
            state.user = data;
        },
    
        // Auth User
        setRole(state, data){
            state.userRoles = data;
        },
    
    
    },

    actions :  {
        
    },

});