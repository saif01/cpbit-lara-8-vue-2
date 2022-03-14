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
                <v-list-item-title>Inventory Admin</v-list-item-title>
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

                <v-list-item link router :to="{name: 'NewProduct'}" exact>
                    <v-list-item-icon>
                        <v-icon>mdi-grid-large</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>New Product</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>


                <v-list-item link router :to="{name: 'OldProduct'}" exact>
                    <v-list-item-icon>
                        <v-icon>mdi-grid-large</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Old Product</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>


                <v-list-group no-action prepend-icon="mdi-ballot-outline" active-class="indigo white--text">
                    <template v-slot:activator>
                        <v-list-item-title>Product Section</v-list-item-title>
                    </template>


                    <v-list-item link router :to="{name: 'givenProduct'}">
                        <v-list-item-icon>
                            <v-icon>mdi-grid-large</v-icon>
                        </v-list-item-icon>
                        
                        <v-list-item-content>
                            <v-list-item-title>Given Product</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{name: 'runningProduct'}">
                        <v-list-item-icon>
                            <v-icon>mdi-grid-large</v-icon>
                        </v-list-item-icon>
                        
                        <v-list-item-content>
                            <v-list-item-title>Running Product</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{name: 'damagedProduct'}">
                        <v-list-item-icon>
                            <v-icon>mdi-grid-large</v-icon>
                        </v-list-item-icon>
                        
                        <v-list-item-content>
                            <v-list-item-title>Damaged Product</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                </v-list-group>


                <v-list-group no-action prepend-icon="mdi-timetable" active-class="indigo white--text">
                    <template v-slot:activator>
                        <v-list-item-title>Warranty Section</v-list-item-title>
                    </template>


                    <v-list-item link router :to="{name: 'warrantyProduct'}">
                        <v-list-item-icon>
                            <v-icon>mdi-grid-large</v-icon>
                        </v-list-item-icon>
                        
                        <v-list-item-content>
                            <v-list-item-title>Warranty Product</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{name: 'expireProduct'}">
                        <v-list-item-icon>
                            <v-icon>mdi-grid-large</v-icon>
                        </v-list-item-icon>
                        
                        <v-list-item-content>
                            <v-list-item-title>Expire Product</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                </v-list-group>
                

                <v-list-item link router :to="{name: 'operation'}" exact>
                    <v-list-item-icon>
                        <v-icon>mdi-opera </v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Operation</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-group no-action prepend-icon="mdi-alert-decagram" active-class="indigo white--text">
                    <template v-slot:activator>
                        <v-list-item-title>Deleted Section</v-list-item-title>
                    </template>


                    <v-list-item link router :to="{name: 'deletedNewProduct'}">
                        <v-list-item-icon>
                            <v-icon>mdi-grid-large</v-icon>
                        </v-list-item-icon>
                        
                        <v-list-item-content>
                            <v-list-item-title>New Product</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{name: 'deletedOldProduct'}">
                        <v-list-item-icon>
                            <v-icon>mdi-grid-large</v-icon>
                        </v-list-item-icon>
                        
                        <v-list-item-content>
                            <v-list-item-title>Old Product</v-list-item-title>
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

    .v-list-group__items .v-list-item--active {
        background-color: #3f51b5;
        border-color: #3f51b5;
        color: white;
    }

</style>
