import Vue from 'vue'
import axios from 'axios'
import Vuex from 'vuex'
Vue.use(Vuex)

import actions from './actions';
import getters from './getters';
import mutations from './mutations';

import common from './../common/mixin'; 



export default new Vuex.Store({

    state : {
        user  : null,
        roles : null,
        loading : false,
    },

    getters : getters,

    mutations : mutations,

    actions :  actions,

});