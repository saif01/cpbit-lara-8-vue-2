<template>
    <v-app>
        <side-bar></side-bar>
        <v-main>
            <v-container fluid>
                <router-view></router-view>
                <vue-progress-bar></vue-progress-bar>
            </v-container>
        </v-main>
        <page-footer></page-footer>
    </v-app>
</template>

<script>
    import sideBar from './pages/common/sidebar.vue'
    import pageFooter from './pages/common/footer.vue'


    export default {

        props: ['authuser', 'permission'],

        components: {
            'side-bar': sideBar,
            'page-footer': pageFooter,
        },

        data() {
            return {
                response: false,

            }
        },

        methods: {
            // For Navbar 
            getResponse(res) {
                this.response = res;
            },




        },



        created() {

            // Set Auth and Role data in Store
            this.$store.commit('setAuth', JSON.parse(this.authuser))
            this.$store.commit('setRoles', JSON.parse(this.permission))

            this.$Progress.start();

            //checkUserRole

            // console.log('Super Admin Index, auth user', JSON.parse(this.authuser));

            // console.log('Role: ', this.isAdministrator(), this.isAnyRole(['Administrator', 'Ivca']), this.isRole(
            //     'Administrator'))

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
        .sidebar_mobile {
            opacity: 0;
            position: absolute;
        }
    }

    @media (min-width: 805px) and (max-width: 2000px) {
        .sidebar_response {
            opacity: 0;
            position: absolute;
        }

        .sidebar_noresponse {
            opacity: 100;
        }
    }

</style>
