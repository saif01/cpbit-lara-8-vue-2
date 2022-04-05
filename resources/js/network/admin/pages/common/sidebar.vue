<template>
    <div>
        <v-app-bar app flat dense dark class="bg_gradient">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-spacer></v-spacer>
            <v-app-bar-title v-if="isAdministrator()" small>Administrator</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="toggle()">
                <v-icon v-if="fullscreen">mdi-fullscreen</v-icon>
                <v-icon v-else>mdi-fullscreen-exit</v-icon>
            </v-btn>


            <v-menu bottom left>
                <template v-slot:activator="{ on, attrs }">
                    Admin
                    <v-avatar
                    v-bind="attrs"
                    v-on="on"
                    contain
                    >
                    <img
                        src="https://www.w3schools.com/howto/img_avatar.png"
                        alt="image"
                    >
                    </v-avatar>
                </template>

                <v-list>
                    <v-list-item link router href="/logout">
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>


        <!-- sidebar -->
        <v-navigation-drawer
            app
            dark
            v-model="drawer"
            class="bg_gradient"
            
        >
            <v-list-item class="px-2" link href="/">
                <v-list-item-icon>
                    <img src="/all-assets/common/icon/network.png" alt="" height="40px" contain> 
                </v-list-item-icon>
                <v-list-item-title>Network Admin</v-list-item-title>
            </v-list-item>
            <v-divider></v-divider>

            <v-list dense nav>

                <v-list-item link router :to="{name: 'Dashboard'}" exact>
                    <v-list-item-icon>
                        <v-icon>mdi-view-dashboard-outline </v-icon>
                    </v-list-item-icon>
                    
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link router :to="{name: 'MainIp'}">
                    <v-list-item-icon>
                        <v-icon>mdi-ip-network-outline</v-icon>
                    </v-list-item-icon>
                    
                    <v-list-item-content>
                        <v-list-item-title>Main IP</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link router :to="{name: 'SubIp'}">
                    <v-list-item-icon>
                        <v-icon>mdi-ip-network-outline</v-icon>
                    </v-list-item-icon>
                    
                    <v-list-item-content>
                        <v-list-item-title>Sub IP</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-group no-action prepend-icon="mdi-chart-bar" active-class="indigo white--text">
                    <template v-slot:activator>
                        <v-list-item-title>Report</v-list-item-title>
                    </template>


                    <v-list-item link router :to="{name: 'MainIpReport'}">
                        <v-list-item-icon>
                            <v-icon>mdi-chart-bar</v-icon>
                        </v-list-item-icon>
                        
                        <v-list-item-content>
                            <v-list-item-title>Main IP</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{name: 'SubAllReport'}">
                        <v-list-item-icon>
                            <v-icon>mdi-chart-bar</v-icon>
                        </v-list-item-icon>
                        
                        <v-list-item-content>
                            <v-list-item-title>Sub All</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                </v-list-group>

                <v-list-item link router :to="{name: 'AllGroupName'}">
                    <v-list-item-icon>
                        <v-icon>mdi-road-variant</v-icon>
                    </v-list-item-icon>
                    
                    <v-list-item-content>
                        <v-list-item-title>All Group Name</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link router href="/logout">
                    <v-list-item-icon>
                        <v-icon>mdi-logout</v-icon>
                    </v-list-item-icon>
                    
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
    data() {
        return {
            fullscreen: true,
            drawer: true,
        };
    },
    methods: {
        toggle() {
            this.fullscreen = !this.fullscreen

            if(this.fullscreen == false){
                this.expand()
            }else{
                this.exitExpand()
            }
        },
        expand() {
            var elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            }
        },
        exitExpand() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        },
    },

};
</script>


<style scoped>
.bg_gradient {
    background: rgb(2,0,36);
    background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(4,4,13,1) 35%, rgba(0,212,255,1) 100%);
}
a:hover {
    text-decoration: none;
}

.v-list-group__items .v-list-item--active {
    background-color: #3f51b5;
    border-color: #3f51b5;
    color: white;
}

</style>