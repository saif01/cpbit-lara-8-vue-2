<template>
    <v-app>
        <side-bar></side-bar>
        <v-main>
            <div class="pa-3">
                <router-view></router-view>
                <vue-progress-bar></vue-progress-bar>
            </div>
        </v-main>

        <page-footer></page-footer>
    </v-app>
</template>

<script>

import sideBar from './pages/common/sidebar.vue'
import pageFooter from './pages/common/footer.vue'


export default {

    props: ['authuser', 'permission'],

    components:{
       'side-bar'       : sideBar,
       'page-footer'    : pageFooter,
    }, 
    
    methods:{

        zoneAccess(){
            axios.get('/cms/h_admin/zone_access').then(response=>{
                console.log('zone', response.data)
            }).catch(error=>{
                console.log(error)
            })
        }

    },

    mounted(){
        this.countAll();
    },

    created(){

        // Set Auth and Role data in Store
        this.$store.commit('setAuth', JSON.parse(this.authuser) )
        this.$store.commit('setRoles', JSON.parse(this.permission) )
       
        this.$Progress.start();

        //checkUserZone Access
        // this.zoneAccess()
      
        // console.log('CMS Admin Index, auth user');

        // console.log('Role: ', this.isAdministrator(), this.isAnyRole(['Administrator', 'Ivca']), this.isRole('Administrator') )

        this.$Progress.finish();  
    }
    
}
</script>

