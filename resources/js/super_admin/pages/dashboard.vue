<template>
    <div>
        <v-row>

             <v-col cols="12" lg="3">
                <v-card>
                    <v-card-title>
                        Total User
                    </v-card-title>
                    <v-card-text>
                        {{ allDashboardData.totalUser }}
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" lg="3">
                <v-card>
                    <v-card-title>
                        User Only
                    </v-card-title>
                    <v-card-text>
                        {{ allDashboardData.user }}
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" lg="3">
                <v-card>
                    <v-card-title>
                        Admin Only
                    </v-card-title>
                    <v-card-text>
                        {{ allDashboardData.admin }}
                    </v-card-text>
                </v-card>
            </v-col>



            <v-col cols="12" lg="3">
                <v-card>
                    <v-card-title>
                        Total Admin & User
                    </v-card-title>
                    <v-card-text>
                        {{ allDashboardData.adminUser }}
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" lg="3">
                <v-card>
                    <v-card-title>
                        Total Blocked
                    </v-card-title>
                    <v-card-text>
                        {{ allDashboardData.blockedUser }}
                    </v-card-text>
                </v-card>
            </v-col>

           

            <v-col cols="12" lg="3">
                <v-card>
                    <v-card-title>
                        Total Role
                    </v-card-title>
                    <v-card-text>
                        {{ allDashboardData.totalRole }}
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" lg="3">
                <v-card>
                    <v-card-title>
                        Total Zone
                    </v-card-title>
                    <v-card-text>
                        {{ allDashboardData.totalZone }}
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                // current Url
                currentUrl: '/super_admin',
                allDashboardData: '',

                overlay: false,

            }
        },

        methods: {

            getDashboardData() {
                this.overlay = true
                axios.get(this.currentUrl + '/dashboard_data').then(response => {
                    this.overlay = false
                    //console.log(response.data)
                    this.allDashboardData = response.data
                }).catch(error => {
                    this.overlay = false
                    console.log(error)
                })
            }



        },


        created() {
            this.getDashboardData()
            console.log('I am super admin dashboard')
        }
    }

</script>
