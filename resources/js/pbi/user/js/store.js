import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)


export default new Vuex.Store({

    state : {
        auth  : null,
        roles : null,
        pbis  : null,
        reportName  : null,
    },

    getters : {

        getAuth(state){
            return state.auth;
        },
        getRoles(state){
            return state.roles;
        },
        getPbis(state){
            return state.pbis;
        },
        getReportName(state){
            return state.reportName;
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

        // Pbis
        setPbis(state, data){
            state.pbis = data;
        },

        //Current Pbi Report reportName
        setReportName(state, data){
            state.reportName = data;
        },
    
    },

    actions :  {
        
    },

});