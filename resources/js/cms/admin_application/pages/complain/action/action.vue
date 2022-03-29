<template>
    <div>
        <v-card class="mb-5">
            <v-card-title>
                Application Complain Actions
            </v-card-title>
            <v-card-text v-if="complainDeta" class="table-responsive">

                <!-- Complain and user Details -->
                <table class="table mb-0">
                    <tr>
                        <th>Complain No:</th>
                        <td>
                            <div class="pa-1 info rounded-pill h6 text-white text-center">
                                {{ complainDeta.id }}</div>
                        </td>
                        <th>Software:</th>
                        <td><span v-if="complainDeta.category">{{ complainDeta.category.name }}</span></td>
                        <th>Module:</th>
                        <td><span v-if="complainDeta.subcategory">{{ complainDeta.subcategory.name }}</span></td>
                    </tr>

                    <tr>
                        <th>Complain By:</th>
                        <td>
                            <v-btn x-small class="secondary" v-if="complainDeta.makby"
                                @click="currentUserView(complainDeta.makby)">
                                <v-avatar size="20" @click="currentUserView(complainDeta.makby)">
                                    <img v-if="complainDeta.makby.image"
                                        :src="'/images/users/small/' + complainDeta.makby.image" alt="image">
                                </v-avatar> {{ complainDeta.makby.name }}
                            </v-btn>
                        </td>
                        <th>Department:</th>
                        <td><span v-if="complainDeta.makby">{{ complainDeta.makby.department }}</span></td>
                        <th>Register:</th>
                        <td><span
                                v-if="complainDeta.created_at">{{ complainDeta.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                        </td>
                    </tr>
                </table>

                <!-- Documents -->
                <table class="table mb-0">
                    <tr>
                        <th>Files:</th>

                        <td>
                            <a v-if="complainDeta.document" :href="docPath+complainDeta.document"
                                class="btn btn-info btn-sm text-white" download>
                                <v-icon color="white">mdi-download-network-outline</v-icon> Doc-1
                            </a>
                        </td>
                        <td>
                            <a v-if="complainDeta.document2" :href="docPath+complainDeta.document2"
                                class="btn btn-info btn-sm text-white" download>
                                <v-icon color="white">mdi-download-network-outline</v-icon> Doc-2
                            </a>
                        </td>
                        <td>
                            <a v-if="complainDeta.document3" :href="docPath+complainDeta.document3"
                                class="btn btn-info btn-sm text-white" download>
                                <v-icon color="white">mdi-download-network-outline</v-icon> Doc-3
                            </a>
                        </td>
                        <td>
                            <a v-if="complainDeta.document4" :href="docPath+complainDeta.document4"
                                class="btn btn-info btn-sm text-white" download>
                                <v-icon color="white">mdi-download-network-outline</v-icon> Doc-4
                            </a>
                        </td>
                    </tr>
                </table>
                
                <!-- And Final Status -->
                <table class="table mb-0">
                    <tr>
                        <th>Final Status:</th>
                        <td>
                            <div class="pa-1 success rounded-pill h6 text-white text-center">
                                {{ complainDeta.process }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Details:</th>
                        <td>{{ complainDeta.details }}</td>
                    </tr>
                </table>

                <!-- All Remarks -->
                <div v-if="complainDeta.remarks" class="mb-2">
                    <div v-for="(item, index) in  complainDeta.remarks" :key="index">
                        <table class="table mb-0 bg-secondary text-white rounded">

                            <tr>
                                <th>Process: ({{ index+1 }})</th>
                                <td>{{ item.process }}</td>
                                <th>Document:</th>
                                <td>
                                    <span v-if="item.document">
                                        <a v-if="item.document" :href="docPath+item.document"
                                            class="btn btn-info btn-sm text-white" download>
                                            <v-icon color="white" small>mdi-download-network-outline</v-icon> Document
                                        </a>
                                    </span>
                                    <span v-else class="text-warning">No Document's Send</span>
                                </td>
                            </tr>
                            <tr>
                                <th>By:</th>
                                <td>
                                    <v-btn x-small class="secondary" v-if="item.makby"
                                        @click="currentUserView(item.makby)">
                                        <v-avatar size="20">
                                            <img v-if="item.makby.image" :src="'/images/users/small/' + item.makby.image"
                                                alt="image">
                                        </v-avatar> {{ item.makby.name }}
                                    </v-btn>
                                </td>
                                <th>R. Register:</th>
                                <td><span
                                        v-if="item.created_at">{{ item.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                </td>
                            </tr>

                        </table>
                        <table class="table mb-1 bg-secondary text-white rounded border-bottom  border-danger">
                            <tr>
                                <th>Remarks:</th>
                                <td v-html="item.details"></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Action Btn -->
                <div>
                    <v-btn v-if="complainDeta.process != 'Closed'" block class="success" @click="actionDialogShow()" elevation="20" >
                        <v-icon left>mdi-gesture-tap-button</v-icon> Action
                    </v-btn>
                </div>
                


            </v-card-text>
            <v-card-text v-else>
                <div v-if="dataLoading" class="p-5 my-5">
                    <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin
                        </v-icon>
                    </p>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>
            </v-card-text>

        </v-card>

        <!-- user-details -->
        <user-details v-if="CurrentUserData" :userData="CurrentUserData" :key="userDetailsDialogKey"></user-details>

        <!-- Action Model -->
        <action-dialog v-if="CurrentComData" :comData="CurrentComData" :key="comActionsDialogKey" @childToParent="childToParentCall"></action-dialog>

    </div>
</template>

<script>
    // User Details Show By Dialog
    import userDetails from '../../../../../super_admin/pages/users/details/user_details.vue'
    import userDetailsData from '../../../../../super_admin/pages/users/details/js/data'
    import userDetailsMethods from '../../../../../super_admin/pages/users/details/js/methods'

    import actionDialog from './action_dialog.vue'



    export default {

        components: {
            'user-details': userDetails,
            'action-dialog': actionDialog,
        },

        data() {
            return {
                //current page url
                currentUrl: '/cms/a_admin/complain',
                docPath: '/images/application/',

                comId: this.$route.query.id,

                complainDeta: '',

                //Action Dialog
                comActionsDialogKey: 0,
                CurrentComData: '',


                // Current User Show By Dilog
                ...userDetailsData,
            }
        },

        methods: {

            childToParentCall () {
                //console.log('child') // someValue
                // refresh data
                this.getComplainData();
            },

            // CurrentUserData
            ...userDetailsMethods,

            // getComplainData
            getComplainData() {
                this.dataLoading = true
                axios.get(this.currentUrl + '/action/' + this.comId).then(response => {
                    this.dataLoading = false

                    console.log(response.data)
                    this.complainDeta = response.data

                }).catch(error => {
                    this.dataLoading = false
                    console.log(error)
                })

            },

            // actionDialogShow
            actionDialogShow() {

                this.comActionsDialogKey++
                this.CurrentComData = this.complainDeta
            }

        },

        created() {
            this.$Progress.start();
            this.getComplainData();
            console.log(this.comId, this.$route.query.id)
            this.$Progress.finish();
        }

    }

</script>
