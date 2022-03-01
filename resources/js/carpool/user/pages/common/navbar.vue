<template>
    <div>
        <v-toolbar flat dense dark class="nav-color" >

            <v-app-bar-nav-icon href="/">
                <v-img src="/all-assets/common/logo/cpb/cpbit.png" alt="room" max-height="40" max-width="40" contain
                    class="nav-logo-bg"></v-img>
            </v-app-bar-nav-icon>

            <v-spacer></v-spacer>
            <v-btn icon link route :to="{ name: 'notCommented'}">
                <v-badge v-if="notComCount" color="error" :content="notComCount" left></v-badge>
                <v-icon>
                    mdi-bell-ring-outline
                </v-icon>
            </v-btn>

            <v-toolbar-items class="hidden-sm-and-down">

                <v-btn text link route :to="{ name: 'Dashboard'}" small exact>
                    Dashboard
                </v-btn>

                <v-btn text link route :to="{ name: 'Booked'}" small>
                    My Booked
                </v-btn>

                <v-btn text link route :to="{ name: 'Canceled'}" small>
                    My Cancelled
                </v-btn>

                <v-btn text link route :to="{ name: 'BookedHistory'}" small>
                    Booked History
                </v-btn>

                <v-btn text link route href="/logout" small>
                    Logout
                </v-btn>

            </v-toolbar-items>

            <v-app-bar-nav-icon class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

            

        </v-toolbar>


        <v-navigation-drawer v-model="drawer" absolute temporary right src="https://asset.cpbangladesh.com/documents/car_side_20220209093005qOCfkoaZjx.jpg" style="height:100vh;">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>Carpool User</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense>

                <v-list-item link route :to="{ name: 'Dashboard'}" exact>
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link route :to="{ name: 'Booked'}">
                    <v-list-item-content>
                        <v-list-item-title>My Booked</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link route :to="{ name: 'Canceled'}">
                    <v-list-item-content>
                        <v-list-item-title>My Cancelled</v-list-item-title>
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
