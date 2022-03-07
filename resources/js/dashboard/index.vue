<template>
    <v-app>
        <choose-dashboard v-if="dashboard" @showTemp="conponentShow"></choose-dashboard>
        <user-dashboard v-if="userDashboard"></user-dashboard>
        <admin-dashboard v-if="adminDashboard"></admin-dashboard>
        <no-access v-if="noAccess"></no-access>
    </v-app>
</template>

<script> 

    import chooseDashboard from './pages/choose.vue'
    import userDashboard from './pages/user.vue'
    import adminDashboard from './pages/admin.vue'
    import noAccess from './pages/no_access.vue'

    export default {

        props: ['authuser', 'permission'],

        components: {
            'choose-dashboard': chooseDashboard,
            'user-dashboard': userDashboard,
            'admin-dashboard': adminDashboard,
            'no-access': noAccess,
        },

        data() {
            return {
                //auth: JSON.parse(this.authuser),
                dashboard: false,
                userDashboard: false,
                adminDashboard: false,
                noAccess: false
            }
        },

        methods: {

            // Data come from child Component
            conponentShow(val) {

                //alert(val);

                if (val == 'user') {
                    //Show User Dashboard
                    this.dashboard = false
                    this.userDashboard = true
                    this.adminDashboard = false

                } else if (val == 'admin') {
                    // Admin Dashboard
                    this.dashboard = false
                    this.userDashboard = false
                    this.adminDashboard = true

                } else {
                    // Admin User Both Dashboard
                    this.dashboard = true
                    this.userDashboard = false
                    this.adminDashboard = false
                }

            },

            // Check User Role
            checkUserRoleForDashboard() {
                if (this.auth.user == 1 && this.auth.admin == 1) {

                    // Admin User Both Access
                    this.dashboard = true
                    this.userDashboard = false
                    this.adminDashboard = false

                } else if (this.auth.user != 1 && this.auth.admin == 1) {

                    // Only Admin Access
                    this.dashboard = false
                    this.userDashboard = false
                    this.adminDashboard = true

                } else if (this.auth.user == 1 && this.auth.admin != 1) {

                    // Only User Access
                    this.dashboard = false
                    this.userDashboard = true
                    this.adminDashboard = false
                } else {
                    // No Access
                    this.noAccess = true
                }


            }
        },


        

        created() {

            // Set Auth and Role data in Store
            this.$store.commit('setAuth', JSON.parse(this.authuser) )
            this.$store.commit('setRoles', JSON.parse(this.permission) )

            this.$Progress.start();

            //checkUserRole
            this.checkUserRoleForDashboard();
            // console.log('auth user', this.auth, this.auth.roles );

           console.log('Role: ', JSON.parse(this.authuser), this.isAdministrator(), this.isAnyRole(['Administrator', 'Ivca']), this.isRole('Administrator') )

            this.$Progress.finish();
        }

    }

</script>



<style lang="scss">
    /* header */
    .header__logo {
        height: 60px;
    }

    .blink {
        animation-name: blinker;
        animation-duration: 0.6s;
        animation-iteration-count: infinite;
        animation-timing-function: ease-in-out;
        animation-direction: alternate;
    }

    @keyframes blinker {
        from {
            opacity: 1.0;
        }

        to {
            opacity: 0.0;
        }
    }

    /* background */
    .area {
        background-image: linear-gradient(45deg, #85FFBD 0%, #FFFB7D 99%);
        width: 100%;
        min-height: 100vh;
    }

    /* icon and logo */
    .logo_div {
        position: relative;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        transition: .5s;
        box-shadow: -5px 10px 12px rgba(0, 0, 0, 0.5);
    }

    .logo_div:hover {
        box-shadow: -5px 10px 12px rgba(0, 0, 0, 0.5);
        transform: scale(1.2);
    }

    .img__logo {
        transition: .5s;
    }

    /* carpool */
    .logo_div:hover .carpool {
        background: #f8c93d;
        border-radius: 50%;
    }

    /* help-desk */
    .logo_div:hover .helpDesk {
        background: #17a2b8;
        border-radius: 50%;
    }

    /* application */
    .logo_div:hover .application {
        background: #f8c93d;
        border-radius: 50%;
    }

    /* hardware */
    .logo_div:hover .hardware {
        background: #3898ff;
        border-radius: 50%;
    }

    /* inventory */
    .logo_div:hover .inventory {
        background: #48b361;
        border-radius: 50%;
    }

    /* powerBi */
    .logo_div:hover .powerBi {
        background: #33b6ca;
        border-radius: 50%;
    }

    /* network */
    .logo_div:hover .network {
        background: #3898ff;
        border-radius: 50%;
    }

    /* room */
    .logo_div:hover .room {
        background: #f8c93d;
        border-radius: 50%;
    }

    /* audit */
    .logo_div:hover .audit {
        background: #33b6ca;
        border-radius: 50%;
    }

    /* sms */
    .logo_div:hover .sms {
        background: #48b361;
        border-radius: 50%;
    }

    // logout
    .logo_div:hover .logout {
        background: #cc3f4d;
        border-radius: 50%;
    }

    @media all and (max-width:800px) {
        .responsive_gap {
            margin-top: 2rem;
        }

        .nav_text {
            font-size: 18px;
        }
    }

    /* footer */
    .dashboard_footer_bg {
        background: #141e30;
        color: white;
    }

    // dashboard css
    .logo_div:hover .user_section {
        background: #556b9c;
        border-radius: 50%;
    }

    .logo_div:hover .admin_section {
        background: #3f9971;
        border-radius: 50%;
    }

</style>
