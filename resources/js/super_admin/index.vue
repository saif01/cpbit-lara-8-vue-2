<template>
    <div>
        <div class="d-flex">
            <div class="p-0" :class="{'col-md-4 col-sm-6 sidebar_response':response, 'sidebar_mobile col-md-3 col-lg-2 sidebar_noresponse' :!response}">
                <side-bar></side-bar>
            </div>
            <div class="p-0" :class="{'col-lg-12 col-md-12 col-sm-6':response, 'col-lg-10 col-md-9 col-sm-12' :!response}" style="overflow-y:scroll;height:100vh;">
                <div class="d-flex flex-column">
                    <div class="col-lg-12 p-0">
                        <nav-bar :response="getResponse"></nav-bar>
                    </div>
                    <div class="col-lg-12 p-3 px-0">
                        <router-view></router-view>
                    </div>
                </div>
                <page-footer></page-footer>
            </div>
        </div>
    </div>
</template>

<script>

import navBar from './pages/common/navbar.vue'
import sideBar from './pages/common/sidebar.vue'
import pageFooter from './pages/common/footer.vue'


export default {

    props:['authuser'],

    components:{
       'nav-bar'        : navBar,
       'side-bar'       : sideBar,
       'page-footer'    : pageFooter,
    },

    data(){
        return{
            response: false,
            auth: JSON.parse(this.authuser),

          
        }
    },

    methods:{

        getResponse(res) {
            this.response = res;
        },

      

       
    },

   

    created(){

        this.$store.commit('setUser', JSON.parse(this.authuser) )
        // this.$store.commit('setRole', JSON.parse(this.permission) )

        this.$Progress.start();

        //checkUserRole
      
        console.log('Super Admin Index, auth user', this.auth);

        this.$Progress.finish();  
    }
    
}
</script>

<style lang="scss">
.content_right {
    position: fixed;
    top: 80px;
    left: 225px;
}
.content_left {
    position: fixed;
    top: 80px;
    left: 0px;
}
@media (min-width: 300px) and (max-width: 700px) {
    .sidebar_mobile{
        opacity:0;
        position: absolute;
    }
}
@media (min-width: 805px) and (max-width: 2000px) {
    .sidebar_response{
        opacity: 0;
        position: absolute;
    }
    .sidebar_noresponse{
        opacity: 100;
    }
}
</style>

