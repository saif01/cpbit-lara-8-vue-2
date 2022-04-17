<template>
    <div>
        <div class="pb-6 rounded success pr-1 pl-1 pt-2">
            <h3 class="text-center pb-2 text-white">Remaining Stock</h3>
            <div v-if="allDashboardData.length > 0">
                <v-row>
                    <v-col cols="12" lg="3" v-for="(item, index) in allDashboardData" :key="index">
                        <v-card>
                            <v-card-text>
                                <p v-if="item.category">{{ item.category.name }}:
                                    <b class="float-right">{{ item.total }}</b></p>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </div>
            <div v-if="!overlay && allDashboardData.length <= 0" class="m-auto">
                <p class="text-center h3 text-danger"> Data Not Available </p>
            </div>
        </div>


        <!-- Operation Wise Product -->
        <div class="pb-6 rounded indigo pr-1 pl-1 mt-2 pt-2">
            <h3 class="text-center pb-2 text-white">Operation Wise Product</h3>
            <div v-if="operationWise.length > 0">
                <v-row>
                    <v-col cols="12" lg="4" v-for="(item, index) in operationWise" :key="index">
                        <v-card>
                            <v-card-title> {{ item.lavel }} </v-card-title>
                            <v-card height="150" class="scroll">
                                <v-card-text v-if="item.val.length">
                                    <div v-for="(item2, index) in item.val" :key="index">
                                        <p v-if="item2.category">{{ item2.category.name }}:
                                            <b class="float-right">{{ item2.total }}</b></p>
                                        <hr>
                                    </div>
                                </v-card-text>
                                <v-card-text v-else class="error--text text-center">
                                    <p class="h3">No Data Available</p>
                                    <v-icon x-large color="error">mdi-alert-octagon-outline</v-icon>
                                </v-card-text>
                            </v-card>


                        </v-card>
                    </v-col>
                </v-row>
            </div>
            <div v-if="!overlay && operationWise.length <= 0" class="m-auto">
                <p class="text-center h3 text-danger"> Data Not Available </p>
            </div>
        </div>

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
                currentUrl: '/inventory/admin',
                allDashboardData: '',
                operationWise: '',

                overlay: false,

            }
        },

        methods: {

            getDashboardData() {
                this.overlay = true
                axios.get(this.currentUrl + '/dashboard_data').then(response => {
                    this.overlay = false
                    //console.log(response.data)
                    this.allDashboardData = response.data.remainProduct
                    this.operationWise = response.data.operationWiseProduct
                }).catch(error => {
                    this.overlay = false
                    console.log(error)
                })
            }


        },

        created() {
            this.getDashboardData()

        }
    }

</script>

<style scoped>
    .scroll {
        overflow-y: scroll
    }

</style>
