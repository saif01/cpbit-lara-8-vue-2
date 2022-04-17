<template>
    <div>
        <v-app-bar app flat dense dark class="bg_gradient">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-spacer></v-spacer>
            <v-app-bar-title v-if="isAdministrator()" small>Administrator</v-app-bar-title>
            <v-spacer></v-spacer>
            <!-- <v-btn icon @click="toggle()">
                <v-icon v-if="fullscreen">mdi-fullscreen</v-icon>
                <v-icon v-else>mdi-fullscreen-exit</v-icon>
            </v-btn> -->


            <v-menu bottom left>
                <template v-slot:activator="{ on, attrs }">
                    <span v-if="auth" class="m-1">{{ auth.name }}</span>
                    <v-avatar v-bind="attrs" v-on="on" contain>
                        <img v-if="auth.image" :src="'/images/users/small/'+auth.image" alt="image">
                        <img v-else src="https://www.w3schools.com/howto/img_avatar.png" alt="image">
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
        <v-navigation-drawer app dark v-model="drawer" class="bg_gradient">
            <v-list-item class="px-2" link href="/">
                <v-list-item-icon>
                    <img src="/all-assets/common/icon/application.png" alt="" height="40px" contain>
                </v-list-item-icon>
                <v-list-item-title>App. Admin</v-list-item-title>
            </v-list-item>
            <v-divider></v-divider>

            <v-list dense nav>

                <v-list-item link router :to="{name: 'Dashboard'}" exact>
                    <v-list-item-icon>
                        <v-icon>mdi-view-dashboard-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                 <v-list-item link router :to="{name: 'NotProcess'}">
                    <v-list-item-icon>
                        <v-icon color="pink lighten-3">mdi-car-brake-hold</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Not Process
                            <v-badge v-if="sidebar_notprocess_counter" color="error ml-2" :content="sidebar_notprocess_counter"></v-badge>
                        </v-list-item-title>
                        
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link router :to="{name: 'Processing'}">
                    <v-list-item-icon>
                        <v-icon color="yellow lighten-2">mdi-run-fast</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Processing
                            <v-badge v-if="sidebar_process_counter" color="error ml-2" :content="sidebar_process_counter"></v-badge>
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link router :to="{name: 'Closed'}">
                    <v-list-item-icon>
                        <v-icon color="green darken-2">mdi-close-circle</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Closed</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>


                <!--Reports Multi level Item -->
                <v-list-group prepend-icon="mdi-file-multiple-outline" active-class="dark--text" no-action>
                    <template v-slot:activator>
                        <v-list-item-title>Reports</v-list-item-title>
                    </template>

                    <v-list-item link router :to="{name: 'ReportIndex'}">
                        <v-list-item-icon>
                            <v-icon>mdi-format-list-checks</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>All Reports</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{name: 'ReportCanceled'}">
                        <v-list-item-icon>
                            <v-icon>mdi-format-list-checks</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>All Canceled</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>



                <!-- Sidebar Multi level Item -->
                <v-list-group prepend-icon="mdi-format-list-group" active-class="dark--text" no-action>
                    <template v-slot:activator>
                        <v-list-item-title>Others</v-list-item-title>
                    </template>

                    <v-list-item link router :to="{name: 'Category'}">
                        <v-list-item-icon>
                            <v-icon>mdi-format-list-checks</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Category</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{name: 'Subcategory'}">
                        <v-list-item-icon>
                            <v-icon>mdi-format-list-text</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Subcategory</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                </v-list-group>


                <v-list-item link router href="/logout">
                    <v-list-item-icon>
                        <v-icon color="red lighten-2">mdi-logout</v-icon>
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
        background: linear-gradient(180deg, #a8bfbb, #0cb7bb);
    }

    a:hover {
        text-decoration: none;
    }

    .v-list-item--active {
        color: #29292b !important;
    }

</style>
