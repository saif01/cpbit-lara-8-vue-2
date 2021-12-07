import Vuex from 'vuex'
Vue.use(Vuex)


export default new Vuex.Store({

    state : {
        user  : null,
        roles : null,
        loading : false,
    },

    getters : {

        getUser(state){
            return state.user;
        },
    
        getRole(state){
            return state.roles;
        },
    
    },

    mutations : {

        // Auth User
        setUser(state, data){
            state.user = data;
        },
    
        // Auth User
        setRole(state, data){
            state.roles = data;
        },
    
    
    },

    actions :  {
        
    },

});