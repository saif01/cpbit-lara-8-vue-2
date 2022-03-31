<template>
    <div>
        <v-app-bar app flat dense dark class="bg_gradient">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-spacer></v-spacer>
            <v-app-bar-title v-if="isAdministrator()" class="red--text" small>Administrator</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="toggle()">
                <v-icon v-if="fullscreen">mdi-fullscreen</v-icon>
                <v-icon v-else>mdi-fullscreen-exit</v-icon>
            </v-btn>


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
                    <img src="/all-assets/common/logo/cpb/cpbit.png" alt="" height="40px" contain>
                </v-list-item-icon>
                <v-list-item-title>PBI Admin</v-list-item-title>
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

                <!-- Sidebar Multi level Item -->
                <v-list-group prepend-icon="mdi-format-list-group" active-class="indigo lighten-3 white--text" no-action>
                    <template v-slot:activator>
                        <v-list-item-title>User Manage</v-list-item-title>
                    </template>

                    <v-list-item link router :to="{name: 'User'}">
                        <v-list-item-icon>
                            <v-icon>mdi-account-group</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Users</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{name: 'Role'}">
                        <v-list-item-icon>
                            <v-icon>mdi-account-group</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Roles</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>

        
                <v-list-item link router :to="{name: 'ApiIndex'}">
                    <v-list-item-icon>
                        <v-icon>mdi-chart-bar</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>API</v-list-item-title>
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


        <!-- <div id="navbar-container" class="shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div id="collapseIcon" class="btn ml-1" @click="(active = !active), response(active)">
                    <i class="fas fa-bars"></i>
                </div>

                <div>
                    <span v-if="isAdministrator()" class="text-danger">Administrator</span>
                </div>

                <div class="d-flex flex-items align-items-center">
                    <div class="d-flex align-items-center" :class="{ 'icon-hide-reponsive': active }">
                        <div class="mx-2">
                            <i class="fas fa-search"></i>
                        </div>
                        <b-dropdown variant="none" no-caret>
                            <template #button-content><i class="far fa-comment-dots"></i></template>
                            <b-dropdown-item href="#">An item</b-dropdown-item>
                            <b-dropdown-item href="#">Another item</b-dropdown-item>
                        </b-dropdown>
                        <b-dropdown variant="none" no-caret>
                            <template #button-content><i class="far fa-bell"></i><span class="badge badge-warning badge_notification">9</span>
                            </template>
                            <b-dropdown-item href="#">An item</b-dropdown-item>
                            <b-dropdown-item href="#">Another item</b-dropdown-item>
                        </b-dropdown>
                        <div class="mx-2">
                            <i :class="{'fas fa-compress': fullMode,'fas fa-compress-arrows-alt': !fullMode,}" @click="(fullMode = !fullMode), toggle()"></i>
                        </div>
                    </div>
                    <b-dropdown variant="none" no-caret>
                        <template #button-content>
                            <img src="https://www.w3schools.com/howto/img_avatar.png" class="avatar" alt="User Image" />
                            <span style="color: black">Admin</span>
                        </template>
                        <b-dropdown-item href="/logout">Sign Out</b-dropdown-item>
                    </b-dropdown>
                    
                </div>
            </div>
        </div> -->
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
                    this.expand();
                }else{
                    this.exitExpand();
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
       background: linear-gradient(180deg, #a8bfbb, #0cb7bb);
    }

    a:hover {
        text-decoration: none;
    }

</style>
