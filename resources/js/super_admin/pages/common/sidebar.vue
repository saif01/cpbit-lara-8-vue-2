<template>
    <div>
        <v-app-bar app flat dense class="gradient_color">

            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-spacer></v-spacer>

            <span v-if="isAdministrator()">Administrator</span>


            <v-spacer></v-spacer>



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
        <v-navigation-drawer app dark class="gradient_color" v-model="drawer">
            <v-list-item href="/" class="px-2">
                <v-list-item-avatar>
                    <v-img src="/all-assets/common/icon/super-admin.png" alt="" height="40px"></v-img>
                </v-list-item-avatar>
                <v-list-item-title>Super Admin</v-list-item-title>
            </v-list-item>
            <!-- Divider -->
            <v-divider></v-divider>

            <v-list dense>
                <!-- Sidebar Item -->
                <v-list-item link router exact :to="{name: 'Dashboard'}">
                    <v-list-item-icon>
                        <v-icon>mdi-monitor-dashboard</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title> Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>


                <v-list-item v-if="isUserManagement()" link router :to="{ name: 'Users' }">
                    <v-list-item-icon>
                        <v-icon>mdi-account-details</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>All User</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item v-if="isUserManagement()" link router :to="{ name: 'Registered' }">
                    <v-list-item-icon>
                        <v-icon>mdi-account-question-outline </v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>All Registered</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item v-if="isRoleManage()" link router :to="{ name: 'Roles' }">
                    <v-list-item-icon>
                        <v-icon>mdi-clipboard-text</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>All Roles</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>




                <v-list-item link router :to="{ name: 'Zones' }">
                    <v-list-item-icon>
                        <v-icon>mdi-map-clock</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>All Zones</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link router :to="{ name: 'ZoneOffices' }">
                    <v-list-item-icon>
                        <v-icon>mdi-office-building-marker</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>All Zone Offices</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>


                <!-- <v-list-group prepend-icon="mdi-account-group" active-class="dark--text">
                    <template v-slot:activator>
                        <v-list-item-title>Zone Manage</v-list-item-title>
                    </template>

                    <v-list-item link router :to="{ name: 'Zones' }">
                        <v-list-item-icon>
                            <v-icon>mdi-account-details</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>All Zones</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item link router :to="{ name: 'ZoneOffices' }">
                        <v-list-item-icon>
                            <v-icon>mdi-account-details</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>All Zone Offices</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                  
                </v-list-group> -->




                <!-- Sidebar Multi level Item -->
                <!-- <v-list-group prepend-icon="mdi-account-group" active-class="dark--text" no-action>
                    <template v-slot:activator>
                        <v-list-item-title>Dropdown</v-list-item-title>
                    </template>

                    <v-list-item link router to="#">
                        <v-list-item-icon>
                            <v-icon>mdi-account-details</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Lavel-1</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-group sub-group>
                        <template v-slot:activator>
                            <v-list-item-title>Level-2</v-list-item-title>
                        </template>

                        <v-list-item link router to="##">
                            <v-list-item-icon>
                                <v-icon>mdi-account-multiple-outline</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>Level-2 Item-1</v-list-item-title>
                            </v-list-item-content>

                        </v-list-item>
                    </v-list-group>
                </v-list-group> -->



                <!-- Sidebar Item -->
                <v-list-item link href="/logout">
                    <v-list-item-icon>
                        <v-icon color="red">mdi-logout</v-icon>
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
                drawer: true,

            }
        },
        methods: {
            logout() {
                window.location.href = "/logout"
            }
        }
    }

</script>



<style scoped>
    .gradient_color {
        background: linear-gradient(180deg, #a8bfbb, #0cb7bb);
    }

</style>
