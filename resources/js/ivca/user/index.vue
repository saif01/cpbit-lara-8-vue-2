<template>
<v-app>
    
    <pageNavbar></pageNavbar>


    <v-main>
        <v-container fluid>
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </v-container>
    </v-main>


    <!-- Back to top btn -->
    <!-- <back-to-top bottom="50px" right="50px">
        <v-btn color="info" elevation="20" small><v-icon>mdi-arrow-up-drop-circle</v-icon></v-btn>
    </back-to-top> -->

    <v-btn
        v-scroll="onScroll"
        v-show="fab"
        fab
        dark
        fixed
        bottom
        right
        color="primary"
        @click="toTop"
        >
        <v-icon>keyboard_arrow_up</v-icon>
    </v-btn>


    <pageFooter></pageFooter>
    
</v-app>
</template>


<script>

import pageNavbar from './pages/common/navbar.vue';
import pageFooter from './pages/common/footer.vue';

export default ({

    props: ['authuser', 'permission'],

    components:{
        pageNavbar,
        pageFooter
    },

    data(){
        return {
            fab: false
        }

    },

   methods: {
        onScroll (e) {
            if (typeof window === 'undefined') return
            const top = window.pageYOffset ||   e.target.scrollTop || 0
            this.fab = top > 20
        },
        toTop () {
            this.$vuetify.goTo(0)
        }
   },


   created() {
        this.$store.commit('setAuth', JSON.parse(this.authuser) )
        this.$store.commit('setRoles', JSON.parse(this.permission) )

        this.$Progress.start();

        // console.log('main iVCA_app created', this.authuser, this.permission, this.auth, this.roles)
        // this.$Progress.finish();
    },



})
</script>



