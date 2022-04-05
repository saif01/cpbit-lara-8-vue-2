<template>
    <div>
        <v-toolbar flat dense dark class="nav-color" >

            <v-app-bar-nav-icon href="/">
                <v-img src="/all-assets/common/icon/itemp.png" alt="room" max-height="40" max-width="40" contain
                    class="nav-logo-bg"></v-img>
            </v-app-bar-nav-icon>

            <v-spacer></v-spacer>

            <v-toolbar-items class="hidden-sm-and-down">

                <v-btn text link route :to="{ name: 'Dashboard'}" small exact>
                    Home
                </v-btn>

                <v-btn text link route :to="{ name: 'all_emp'}" small>
                    All Employee
                </v-btn>

                <v-btn text link route :to="{ name: 'emp_rec'}" small>
                    Employee Records
                </v-btn>

                <v-btn text link route :to="{ name: 'others'}" small>
                    Others
                </v-btn>

                <v-btn text link route :to="{ name: 'my_profile'}" small>
                    My Profile
                </v-btn>

                <v-btn text link route href="/logout" small>
                    Logout
                </v-btn>

            </v-toolbar-items>

            <v-app-bar-nav-icon class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

            

        </v-toolbar>


        <v-navigation-drawer v-model="drawer" absolute temporary right style="height:100vh;">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>iTemp User</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense>

                <v-list-item link route :to="{ name: 'Dashboard'}" exact>
                    <v-list-item-content>
                        <v-list-item-title>Ho</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link route :to="{ name: 'all_emp'}">
                    <v-list-item-content>
                        <v-list-item-title>All Employee</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link route :to="{ name: 'emp_rec'}">
                    <v-list-item-content>
                        <v-list-item-title>Employee Records</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link route :to="{ name: 'others'}">
                    <v-list-item-content>
                        <v-list-item-title>Others</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link route :to="{ name: 'my_profile'}">
                    <v-list-item-content>
                        <v-list-item-title>My Profile</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link route href="/logout">
                    <v-list-item-content>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        

    </div>
</template>

<script>

    export default {
       
        data(){
            return{
                drawer: null,
            }
        },

       
    }

</script>

<style scoped>
    .v-btn--active {
        color: #fff;
        background: linear-gradient(90deg, #b86883, #9796f0);
    }

    .nav-color {
        background: linear-gradient(to right, #9796f0, #b86883);
    }

    .nav-logo-bg {
        background-color: white !important;
        border-radius: 8px;
    }

    a:hover {
        text-decoration: none;
    }

</style>
