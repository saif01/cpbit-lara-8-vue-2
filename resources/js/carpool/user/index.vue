<template>
    <v-app>
        <nav-bar :key="navbarKeyIndex" :counter="commentValue"></nav-bar>

        <v-main>
            <v-container fluid>
                <router-view></router-view>
                <vue-progress-bar></vue-progress-bar>
            </v-container>
        </v-main>

        <page-footer></page-footer>



        <!-- not commented component modal -->

        <v-dialog v-model="commentDialogShow" max-width="600">
            <v-card>
                <v-card-title justify-center>
                    <v-row>
                        <v-col cols="10">
                            Important!!
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="commentDialogShow = false" color="red lighten-1 white--text" small class="float-right" icon>
                                <v-icon>mdi-close-octagon</v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>

                </v-card-title>
                
                <v-card-text @click="commentDialogShow = false">
                    <router-link :to="{ name: 'notCommented'}" class="text-decoration-none text-white"  >
                        <div class="rounded-lg px-3 text-center font-weight-bold py-2 indigo lighten-2" > Your non commented booked number &nbsp; <span class="h3 error--text"> {{commentValue}} </span> </div>
                        <div class="rounded-lg px-3 text-center font-weight-bold py-2 deep-purple lighten-1 my-3">Please Fulfill comment section. </div>
                        <div class="rounded-lg px-3 text-center font-weight-bold py-2 cyan darken-1">Otherwise you can't book in future. </div>
                    </router-link>
                </v-card-text>
            </v-card>
        </v-dialog>

    </v-app>
</template>

<script>

import navBar from './pages/common/navbar.vue'
import pageFooter from './pages/common/footer.vue'


export default {

    props: ['authuser', 'permission'],

    components:{
       'nav-bar'        : navBar,
       'page-footer'    : pageFooter,
    },

    data(){
        return{
            response: false,
            commentDialogShow: false,

            commentValue: null,
            
        }
    },

    methods:{

        
        showNonCommentDialog(){

            this.carNotCommented();
        
        },
    

       
    },


    mounted(){

        window.onload = (event) => {
            //this.navbarKeyIndex++

            this.commentValue = this.commentCount
            console.log(this.commentCount)
            if(this.commentCount > 2){
                
                this.commentDialogShow = true

            };
        }


        
        
        
    },


   

    created(){

        // Set Auth and Role data in Store
        this.$store.commit('setAuth', JSON.parse(this.authuser) )
        this.$store.commit('setRoles', JSON.parse(this.permission) )

        this.$Progress.start();

        this.showNonCommentDialog()
        

        //checkUserRole
      
       // console.log('Index, auth user', JSON.parse(this.authuser));

        //console.log('Role: ', this.isAdministrator(), this.isAnyRole(['Administrator', 'Ivca']), this.isRole('Administrator') )

        this.$Progress.finish();

    }
    
}
</script>

<style lang="scss">

</style>

