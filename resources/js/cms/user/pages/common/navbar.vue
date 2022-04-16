<template>
    <div>
        <v-toolbar flat dense dark class="nav-color" >

            <v-app-bar-nav-icon href="/">
                <v-img  src="/all-assets/common/icon/cms.png" alt="room" max-height="40" max-width="40" contain class="nav-logo-bg"></v-img>
            </v-app-bar-nav-icon>

           

            <v-spacer></v-spacer>
               <span v-if="auth" class="m-1">{{ auth.name }} ({{ auth.login }})</span>
            <v-spacer></v-spacer>

            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn text link route :to="{ name: 'Dashboard'}" small exact>
                    Dashboard
                </v-btn>

                <v-btn text link route :to="{ name: 'HardwareHistory'}" small>
                    Hardware History
                </v-btn>

                <v-btn text link route :to="{ name: 'ApplicationHistory'}" small>
                    Application History
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
                    <v-list-item-title>CMS User</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense>

                <v-list-item link route :to="{ name: 'Dashboard'}" exact>
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link route :to="{ name: 'HardwareHistory'}">
                    <v-list-item-content>
                        <v-list-item-title>Hardware History</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link route :to="{ name: 'ApplicationHistory'}">
                    <v-list-item-content>
                        <v-list-item-title>Application History</v-list-item-title>
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
    .v-btn--active{
        color: #fff;
        background: linear-gradient(90deg,#aa4b6b,#6b6b83,#3b8d99);
    }
    
    .nav-color {
        background: #aa4b6b;
        background: -webkit-linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
        background: linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
    }

    .nav-logo-bg{
        background-color: white !important;
        border-radius: 8px;
    }

    a:hover{
        text-decoration: none;
    }


</style>
