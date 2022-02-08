<template>
    <div>
        <v-app-bar app flat dense dark class="bg_gradient">

            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-spacer></v-spacer>

            <v-btn color="success" link route href="/" small>
                Home
            </v-btn>

            <v-btn v-if="auth" text small dense>{{ auth.name }} <span class="red--text">&nbsp; Administrator</span></v-btn>


        </v-app-bar>


        <!-- sidebar -->
        <v-navigation-drawer app dark v-model="drawer" class="bg_gradient">
            <v-list-item href="/" class="px-2">
                <v-list-item-avatar>
                    <v-img src="/all-assets/common/icon/audit.png" alt="" height="40px"></v-img>
                </v-list-item-avatar>
                <v-list-item-title>iVCA Admin</v-list-item-title>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense>
                <v-list-item link router exact :to="{name: 'admin_ivca_dashboard'}">
                    <v-list-item-icon>
                        <v-icon>mdi-home-variant-outline</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>Home</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <!-- User -->
                <v-list-group prepend-icon="mdi-account-group-outline" no-action v-if="isAdmin()"
                    active-class="indigo lighten-3 indigo--text">
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title>User</v-list-item-title>
                        </v-list-item-content>
                    </template>

                    <v-list-item link router :to="{ name:'admin_ivca_user_list' }">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>User List</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{ name:'admin_ivca_user_role' }" v-if="isAdministrator()">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>User Role</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>

                <!-- Vendor -->
                <v-list-group prepend-icon="mdi-badge-account-alert-outline " no-action v-if="isVendorList()"
                    active-class="indigo lighten-3 indigo--text">
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title>
                                Vendor <v-badge v-if="incativeData.ivcaVendorListInactive"
                                    :content="incativeData.ivcaVendorListInactive" class="ml-2"></v-badge>
                            </v-list-item-title>
                        </v-list-item-content>
                    </template>

                    <v-list-item link router :to="{ name:'admin_ivca_vendor_list' }">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Vendor List <v-badge v-if="incativeData.ivcaVendorListInactive"
                                    :content="incativeData.ivcaVendorListInactive" class="ml-2"></v-badge>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{ name:'admin_ivca_vendor_black_list' }">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Vendor Blacklist <v-badge v-if="incativeData.ivcaVendorBlackListInactive"
                                    :content="incativeData.ivcaVendorBlackListInactive" class="ml-2"></v-badge>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>

                <!-- Audit Templates -->
                <v-list-group prepend-icon="mdi-clipboard-file-outline" no-action v-if="isTemplate()"
                    active-class="indigo lighten-3 indigo--text">
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title>Audit Templates</v-list-item-title>
                        </v-list-item-content>
                    </template>

                    <v-list-item link router :to="{ name:'admin_ivca_temp_mro_manufacturer' }" v-if="isMro()">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>MRO Manufacturer</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{ name:'admin_ivca_temp_mro_importer' }" v-if="isMro()">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>MRO Importer</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{ name:'admin_ivca_temp_mro_retailer' }" v-if="isMro()">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>MRO Retailer</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{ name:'admin_ivca_temp_food' }" v-if="isFood()">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Food</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>

                <!-- Schedules -->
                <v-list-group prepend-icon="mdi-av-timer" no-action v-if="isSchedule()"
                    active-class="indigo lighten-3 indigo--text">
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title>Schedules 
                                    <v-badge v-if="incativeData.ivcaMroScheduleInactive"
                                    :content="incativeData.ivcaMroScheduleInactive" class="ml-1">M</v-badge>
                                    <v-badge v-if="incativeData.ivcaFoodScheduleInactive"
                                    :content="incativeData.ivcaFoodScheduleInactive" class="ml-3">F</v-badge>
                                    </v-list-item-title>
                        </v-list-item-content>
                    </template>

                    <v-list-item link router :to="{ name:'admin_ivca_schedule_mro' }" v-if="isMro()">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>MRO <v-badge v-if="incativeData.ivcaMroScheduleInactive"
                                    :content="incativeData.ivcaMroScheduleInactive" class="ml-2"></v-badge> </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{ name:'admin_ivca_schedule_food' }" v-if="isFood()">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Food <v-badge v-if="incativeData.ivcaFoodScheduleInactive"
                                    :content="incativeData.ivcaFoodScheduleInactive" class="ml-2"></v-badge></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>

                <!-- Reports -->
                <v-list-group prepend-icon="mdi-file-document-edit-outline " no-action v-if="isReport()"
                    active-class="indigo lighten-3 indigo--text">
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title>Reports</v-list-item-title>
                        </v-list-item-content>
                    </template>

                    <v-list-item link router :to="{ name:'admin_ivca_reports_manufacturer' }" v-if="isMro()">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Manufacturer</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{ name:'admin_ivca_reports_importer' }" v-if="isMro()">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Importer</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{ name:'admin_ivca_reports_retailer' }" v-if="isMro()">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Retailer</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link router :to="{ name:'admin_ivca_reports_food' }" v-if="isFood()">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right-bold-outline </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Food</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>

                <v-list-item link href="/user-logout">
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
                drawer: true,
                incativeData: ''

            }
        },
        methods: {

            getInactiveList() {
                axios.get('/ivca/admin/inactive_list')
                    .then(response => {
                        console.log(response.data);
                        this.incativeData = response.data
                        //console.log( this.incativeData )
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },


        },
        created() {

        },
        mounted() {

            this.getInactiveList();
        },

        // computed: {
        //     // totalNewInactive: function(){
        //     //    return this.inactiveNewsEvent + this.inactiveNewsPress;
        //     // }
        // }



    }

</script>

<style>
    .bg_gradient {
       background: linear-gradient(180deg, #a8bfbb, #0cb7bb);
    }

    .v-list-group__items .v-list-item--active {
        background-color: #3f51b5;
        border-color: #3f51b5;
        color: white;
    }

    a:hover {
        text-decoration: none;
    }

    .v-application--is-ltr .v-list-group--no-action>.v-list-group__items>.v-list-item {
        padding-left: 50px;
    }

</style>
