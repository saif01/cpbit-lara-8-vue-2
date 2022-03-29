<template>
    <div>
        <v-app-bar flat dense dark class="bg_gradient">
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
                    <img src="/all-assets/common/icon/hardware.png" alt="" height="40px" contain>
                </v-list-item-icon>
                <v-list-item-title>Hard. Admin</v-list-item-title>
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

                <!-- <v-list-item link router :to="{name: 'User'}" >
                    <v-list-item-icon>
                        <v-icon>mdi-account-group</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Users</v-list-item-title>
                    </v-list-item-content>
                </v-list-item> -->

                <!-- Sidebar Multi level Item -->
                <v-list-group prepend-icon="mdi-account-supervisor" active-class="indigo lighten-3 white--text" no-action>
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

                <v-list-item link router :to="{name: 'NotProcess'}" >
                    <v-list-item-icon>
                        <v-icon>mdi-car-brake-hold</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Not Process
                            <v-badge v-if="notprocess" color="error ml-2" :content="notprocess"></v-badge>
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link router :to="{name: 'Processing'}" >
                    <v-list-item-icon>
                        <v-icon>mdi-run-fast</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Processing
                            <v-badge v-if="process" color="error ml-2" :content="process"></v-badge>
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link router :to="{name: 'Closed'}" >
                    <v-list-item-icon>
                        <v-icon>mdi-close-circle</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Closed</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link router :to="{name: 'Service'}" >
                    <v-list-item-icon>
                        <v-icon>mdi-tools</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Service
                            <v-badge v-if="service" color="error ml-2" :content="service"></v-badge>
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link router :to="{name: 'Deliverable'}" >
                    <v-list-item-icon>
                        <v-icon>mdi-truck-delivery-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Deliverable
                            <v-badge v-if="deliverable" color="error ml-2" :content="deliverable"></v-badge>
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

               

                <!-- Sidebar Multi level Item -->
                <v-list-group prepend-icon="mdi-chart-bell-curve" active-class="indigo lighten-3 white--text" no-action>
                    <template v-slot:activator>
                        <v-list-item-title>Reports</v-list-item-title>
                    </template>

                    <v-list-item link router :to="{name: 'ReportIndex'}">
                        <v-list-item-icon>
                            <v-icon>mdi-select-group</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>All</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{name: 'ReportDamaged'}">
                        <v-list-item-icon>
                            <v-icon>mdi-select-group</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Damaged</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{name: 'ReportDamagedReplace'}">
                        <v-list-item-icon>
                            <v-icon>mdi-select-group</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Damaged Replace</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                  
                 
                </v-list-group>

               

               

               

                <!-- Damaged Sidebar Multi level Item -->
                <v-list-group prepend-icon="mdi-iobroker" active-class="indigo lighten-3 white--text" no-action>
                    <template v-slot:activator>
                        <v-list-item-title>Damaged</v-list-item-title>
                    </template>

                    <v-list-item link router :to="{name: 'AllDamaged'}">
                        <v-list-item-icon>
                            <v-icon>mdi-select-group</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>All</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-group sub-group active-class="indigo lighten-3 white--text">
                        <template v-slot:activator>
                            <v-list-item-title>Applicable</v-list-item-title>
                        </template>

                        <v-list-item link router :to="{ name:'ApplicableDamaged' }">
                            <v-list-item-icon>
                                <v-icon>mdi-select-group</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Damaged</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item link router :to="{ name:'ApplicablePartialDamaged' }">
                            <v-list-item-icon>
                                <v-icon>mdi-select-group</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Partial Damaged</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>

                    <v-list-group sub-group>
                        <template v-slot:activator>
                            <v-list-item-title>Not Applicable</v-list-item-title>
                        </template>

                        <v-list-item link router :to="{ name:'NotApplicableDamaged' }">
                            <v-list-item-icon>
                                <v-icon>mdi-select-group</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Damaged</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item link router :to="{ name:'NotApplicablePartialDamaged' }">
                            <v-list-item-icon>
                                <v-icon>mdi-select-group</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Partial Damaged</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>
                </v-list-group>


                 <!-- Sidebar Multi level Item -->
                <v-list-group prepend-icon="mdi-format-list-group" active-class="indigo lighten-3 white--text" no-action>
                    <template v-slot:activator>
                        <v-list-item-title>H.O. Service</v-list-item-title>
                    </template>

                    <v-list-item link router :to="{name: 'HOServiceIndex'}">
                        <v-list-item-icon>
                            <v-icon>mdi-select-group</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>All</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                  
                 
                </v-list-group>

                 <v-list-item link router :to="{name: 'Draft'}" >
                    <v-list-item-icon>
                        <v-icon>mdi-book-open-page-variant-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Draft</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                

               
                <!-- Sidebar Multi level Item -->
                <v-list-group prepend-icon="mdi-format-list-group" active-class="indigo lighten-3 white--text" no-action>
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

                    <v-list-item link router :to="{name: 'Acsosoris'}">
                        <v-list-item-icon>
                            <v-icon>mdi-format-list-text</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Acsosoris</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                </v-list-group>
                

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
        background: -webkit-linear-gradient(to bottom, #803333, #1c1e1e);
        background: linear-gradient(to bottom, #803333, #1c1e1e);
    }

    a:hover {
        text-decoration: none;
    }

    .v-list-group__items .v-list-item--active {
        background-color: #3f51b5;
        border-color: #3f51b5;
        color: white;
    }

    .v-application--is-ltr .v-list--dense.v-list--nav .v-list-group--no-action > .v-list-group__items > .v-list-item {
        padding-left: 29px;
    }


</style>
