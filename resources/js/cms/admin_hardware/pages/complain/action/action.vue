<template>
    <div>
        <v-card class="mb-5">
            <v-card-title>
                Hardware Complain Actions
            </v-card-title>
            <v-card-text v-if="complainDeta" class="table-responsive">

                <!-- Start Complain and user Details -->
                <table class="table mb-0">
                    <tr>
                        <th>Complain No:</th>
                        <td>
                            <div class="pa-1 info rounded-pill h6 text-white text-center">
                                {{ complainDeta.id }}</div>
                        </td>
                        <th>Category:</th>
                        <td>
                            <v-btn v-if="complainDeta.category" @click="modifyDialogShow()" color="info" small
                                elevation="20">
                                <v-icon left>mdi-playlist-edit</v-icon> {{ complainDeta.category.name }}
                            </v-btn>
                            <v-btn @click="modifyDialogShow()" v-else class="error">N/A</v-btn>
                        </td>
                        <th>Subcategory:</th>
                        <td>
                            <v-btn v-if="complainDeta.subcategory" @click="modifyDialogShow()" color="info" small
                                elevation="20">
                                <v-icon left>mdi-playlist-edit</v-icon> {{ complainDeta.subcategory.name }}
                            </v-btn>
                            <v-btn @click="modifyDialogShow()" v-else class="error">N/A</v-btn>
                        </td>
                    </tr>

                    <tr>
                        <th>Complain By:</th>
                        <td>
                            <button class="btn btn-secondary btn-sm" v-if="complainDeta.makby"
                                @click="currentUserView(complainDeta.makby)">
                                <v-avatar size="20" @click="currentUserView(complainDeta.makby)">
                                    <img v-if="complainDeta.makby.image"
                                        :src="'/images/users/small/' + complainDeta.makby.image" alt="image">
                                </v-avatar> {{ complainDeta.makby.name }}
                            </button>
                        </td>
                        <th>Department:</th>
                        <td><span v-if="complainDeta.makby">{{ complainDeta.makby.department }}</span></td>
                        <th>Register:</th>
                        <td><span
                                v-if="complainDeta.created_at">{{ complainDeta.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                        </td>
                    </tr>
                </table>

                <!-- Final Status And Documents  -->
                <table class="table mb-0">
                    <tr>
                        <th>Final Status:</th>
                        <td>
                            <div class="pa-1 success rounded-pill h6 text-white text-center">
                                {{ complainDeta.process }}</div>
                        </td>

                        <th v-if="complainDeta.computer_name">C. Name:</th>
                        <td v-if="complainDeta.computer_name">
                            {{ complainDeta.computer_name }}
                        </td>

                        <th>Files:</th>
                        <td>
                            <a v-if="complainDeta.document" :href="docPath+complainDeta.document"
                                class="btn btn-info btn-sm text-white" download>
                                <v-icon color="white">mdi-paperclip</v-icon> Doc-1
                            </a>
                            <span v-else class="text-danger">Not Attached</span>
                        </td>
                    </tr>
                </table>

                <!-- Details -->
                <table class="table mb-0">
                    <tr v-if="complainDeta.accessories">
                        <th>Accessories: </th>
                        <td>{{ complainDeta.accessories }}</td>
                    </tr>
                    <tr>
                        <th>Details:</th>
                        <td v-html="complainDeta.details"></td>
                    </tr>
                </table>
                <!-- End Complain and user Details -->









                <!-- All Remarks -->
                <div v-if="complainDeta.remarks" class="mb-2">
                    <div v-for="(item, index) in  complainDeta.remarks" :key="index">
                        <!--Start remarks -->
                        <table class="table mb-1 bg-secondary text-white rounded border-bottom border-danger">
                            <!-- remarks -->
                            <tr>
                                <th>Process: ({{ index + 1 }})</th>
                                <td>
                                    <span v-if="(item.process == 'Damaged')"
                                        class="text-danger bg-white rounded">Damaged</span>
                                    <span v-else-if="(item.process == 'Closed')"
                                        class="text-danger bg-white rounded">Closed</span>
                                    <span v-else>{{ item.process }}</span>
                                </td>
                                <th>Document:</th>
                                <td>
                                    <span v-if="item.document">
                                        <a v-if="item.document" :href="docPath+item.document"
                                            class="btn btn-info btn-sm text-white" download>
                                            <v-icon color="white" small>mdi-paperclip</v-icon> Document
                                        </a>
                                    </span>
                                    <span v-else class="text-warning">No Document's Send</span>
                                </td>
                            </tr>
                            <tr>
                                <th>By:</th>
                                <td>
                                    <button class="btn btn-secondary btn-sm" v-if="item.makby"
                                        @click="currentUserView(item.makby)">
                                        <v-avatar size="20">
                                            <img v-if="item.makby.image"
                                                :src="'/images/users/small/' + item.makby.image" alt="image">
                                        </v-avatar> {{ item.makby.name }}
                                    </button>
                                </td>
                                <th>Action At:</th>
                                <td><span
                                        v-if="item.created_at">{{ item.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                </td>
                            </tr>

                            <!-- Damage Apply by User -->
                            <!-- {{ complainDeta.damage }} -->
                            <tr v-if="(item.process == 'Damaged' ||  item.process == 'Partial Damaged') && complainDeta.damage && complainDeta.damage.apply_by"
                                class="bg-info">
                                <th>Replace Applied:</th>
                                <td>Successfully </td>
                                <th>Apply At:</th>
                                <td><span v-if="complainDeta.damage.apply_at"
                                        class="text-warning">{{ complainDeta.damage.apply_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                </td>
                            </tr>
                            <!-- Start Email send  -->
                            <tr v-if="item.mail">
                                <th>E-Mail:</th>
                                <td>
                                    <span v-if="item.mail.status" class="text-success">Successfully Sent</span>
                                    <span v-else class="text-warning">Sending</span>
                                    <v-btn @click="mailSendManual(item.mail.id)" small class="float-right"
                                        elevation="20">
                                        <v-icon>mdi-email-send</v-icon>
                                    </v-btn>
                                </td>
                                <th>Send At:</th>
                                <td><span
                                        v-if="item.mail.status">{{ item.mail.updated_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                    <span v-else class="text-warning">Sending</span>
                                </td>
                            </tr>
                            <!-- End Email send  -->
                            <tr>
                                <th>Remarks:</th>
                                <td colspan="3" v-html="item.details"></td>
                            </tr>


                        </table>
                        <!--End remarks -->




                        <!--Start ho_remarks -->
                        <div v-if="(item.process == 'HO Service')">
                            <div v-for="(item, index) in  complainDeta.ho_remarks" :key="index">
                                <table class="table mb-0 bg-info text-white rounded">

                                    <tr>

                                        <th>HO Process: ({{ index+1 }})</th>
                                        <td>
                                            <span v-if="(item.process == 'Damaged')"
                                                class="text-danger bg-white rounded">Damaged</span>
                                            <span v-else-if="(item.process == 'Closed')"
                                                class="text-danger bg-white rounded">Closed</span>
                                            <span v-else>{{ item.process }}</span>
                                        </td>
                                        <th>Document:</th>
                                        <td>
                                            <span v-if="item.document">
                                                <a v-if="item.document" :href="docPath+item.document"
                                                    class="btn btn-info btn-sm text-white" download>
                                                    <v-icon color="white" small>mdi-paperclip</v-icon>
                                                    Document
                                                </a>
                                            </span>
                                            <span v-else class="text-warning">No Document's Send</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>By:</th>
                                        <td>
                                            <button class="btn btn-secondary btn-sm" v-if="item.makby"
                                                @click="currentUserView(item.makby)">
                                                <v-avatar size="20">
                                                    <img v-if="item.makby.image"
                                                        :src="'/images/users/small/' + item.makby.image" alt="image">
                                                </v-avatar> {{ item.makby.name }}
                                            </button>
                                        </td>
                                        <th>Action At:</th>
                                        <td><span
                                                v-if="item.created_at">{{ item.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                        </td>
                                    </tr>
                                    <!-- Email send  -->
                                    <tr v-if="item.mail">
                                        <th>E-Mail:</th>
                                        <td colspan="1">
                                            <span v-if="item.mail.status">Successfully Sent</span>
                                            <span v-else class="text-warning">Sending</span>
                                            <v-btn @click="mailSendManual(item.mail.id)" small class="float-right"
                                                elevation="20">
                                                <v-icon>mdi-email-send</v-icon>
                                            </v-btn>
                                        </td>
                                        <th>Send At:</th>
                                        <td colspan="1"><span
                                                v-if="item.mail.status">{{ item.mail.updated_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                            <span v-else class="text-warning">Sending</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Remarks:</th>
                                        <td colspan="3" v-html="item.details"></td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                        <!--End ho_remarks -->

                    </div>
                </div>





                <!-- Start Damaged Replaced received -->
                <table class="table mb-1 bg-secondary text-white rounded border-bottom border-danger"
                    v-if="complainDeta.damage && complainDeta.damage.rep_pro_id ">
                    <!-- {{ complainDeta.damage }} -->

                    <tr>
                        <td colspan="8" class="text-center h3 text-success">Damaged Replaced</td>
                    </tr>
                    <tr>
                        <th>By:</th>
                        <td colspan="3">
                            <button class="btn btn-secondary btn-sm" v-if="complainDeta.damage.makby"
                                @click="currentUserView(complainDeta.damage.makby)">
                                <v-avatar size="20">
                                    <img v-if="complainDeta.damage.makby.image"
                                        :src="'/images/users/small/' + complainDeta.damage.makby.image" alt="image">
                                </v-avatar> {{ complainDeta.damage.makby.name }}
                            </button>
                        </td>
                        <th>Action At:</th>
                        <td colspan="3"><span
                                v-if="complainDeta.damage.created_at">{{ complainDeta.damage.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                        </td>
                    </tr>
                    <tr class="bg-info">
                        <th>Receiver Name:</th>
                        <td> {{ complainDeta.damage.rec_name }} </td>
                        <th>Receiver Contact:</th>
                        <td> {{ complainDeta.damage.rec_contact }} </td>
                        <th>Receiver Position:</th>
                        <td> {{ complainDeta.damage.rec_position }} </td>
                        <th>Received At:</th>
                        <td><span v-if="complainDeta.damage.updated_at"
                                class="text-warning">{{ complainDeta.damage.updated_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                        </td>
                    </tr>
                </table>
                <!-- Start Damaged Replaced received -->






                <!-- Start Delivered -->
                <table class="table mb-1 bg-success text-white rounded border-bottom border-danger"
                    v-if="complainDeta.delivery">
                    <!-- {{ complainDeta.delivery }} -->

                    <tr>
                        <td colspan="8" class="text-center h3">----- Delivered -----</td>
                    </tr>
                    <tr>
                        <th>By:</th>
                        <td colspan="3">
                            <button class="btn btn-secondary btn-sm" v-if="complainDeta.delivery.makby"
                                @click="currentUserView(complainDeta.delivery.makby)">
                                <v-avatar size="20">
                                    <img v-if="complainDeta.delivery.makby.image"
                                        :src="'/images/users/small/' + complainDeta.delivery.makby.image" alt="image">
                                </v-avatar> {{ complainDeta.delivery.makby.name }}
                            </button>
                        </td>
                        <th>Action At:</th>
                        <td colspan="3"><span
                                v-if="complainDeta.delivery.created_at">{{ complainDeta.delivery.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                        </td>
                    </tr>

                    <!-- End Email send  -->
                    <tr v-if="complainDeta.delivery.mail">
                        <th>E-Mail:</th>
                        <td colspan="3">
                            <span v-if="complainDeta.delivery.mail.status">Successfully Sent</span>
                            <span v-else class="text-warning">Sending</span>
                            <v-btn @click="mailSendManual(complainDeta.delivery.mail.id)" small class="float-right"
                                elevation="20">
                                <v-icon>mdi-email-send</v-icon>
                            </v-btn>
                        </td>
                        <th>Send At:</th>
                        <td colspan="3"><span
                                v-if="complainDeta.delivery.mail.status">{{ complainDeta.delivery.mail.updated_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                            <span v-else class="text-warning">Sending</span>
                        </td>
                    </tr>
                    <!-- End Email send  -->
                    <tr>
                        <th>Receiver Name:</th>
                        <td> {{ complainDeta.delivery.rec_name }} </td>
                        <th>Receiver Contact:</th>
                        <td> {{ complainDeta.delivery.rec_contact }} </td>
                        <th>Receiver Position:</th>
                        <td> {{ complainDeta.delivery.rec_position }} </td>
                        <th>Received At:</th>
                        <td><span v-if="complainDeta.delivery.updated_at"
                                class="text-warning">{{ complainDeta.delivery.updated_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Remarks:</th>
                        <td colspan="7" v-html="complainDeta.delivery.details"> </td>
                    </tr>
                </table>
                <!-- Start Delivered -->



                <!-- Action Btn  -->
                <div>
                    <!-- <v-btn v-if="checkActionBtnAccess()" :loading="actionBtnLoading" block :class="actionBtnColor"
                        @click="actionDialogShow()" elevation="20">
                        <v-icon left>mdi-gesture-tap-button</v-icon> {{ actionBtnText }}
                    </v-btn> -->

                    <v-btn v-if="actionAccess" :loading="actionBtnLoading" block :class="actionBtnColor"
                        @click="actionDialogShow()" elevation="20">
                        <v-icon left>mdi-gesture-tap-button</v-icon> {{ actionBtnText }}
                    </v-btn>

                    <v-btn v-else block :class="actionBtnColor"
                        elevation="20">
                        <v-icon left>mdi-gesture-tap-button</v-icon> {{ actionBtnText }}
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

        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>

        <!-- user-details -->
        <user-details v-if="CurrentUserData" :userData="CurrentUserData" :key="userDetailsDialogKey"></user-details>

        <!-- Modify Dialog -->
        <cat-sub-modify-dialog v-if="CurrentComDataModify" :comData="CurrentComDataModify" :key="comModifyDialogKey"
            @childToParent="childToParentCall"></cat-sub-modify-dialog>





        <!-- Not Process Action Dialog -->
        <action-dialog v-if="actionVal" :comData="CurrentComData" :key="comActionsDialogKey"
            @childToParent="childToParentCall"></action-dialog>

        <!-- Processing Action Dialog -->
        <action-dialog-2 v-if="actionVal2" :comData="CurrentComData" :key="comActionsDialogKey"
            @childToParent="childToParentCall"></action-dialog-2>

        <!-- H.O. Action Dialog -->
        <action-dialog-3 v-if="actionVal3" :comData="CurrentComData" :key="comActionsDialogKey"
            @childToParent="childToParentCall"></action-dialog-3>

        <!-- Damaged Action Dialog -->
        <action-dialog-4 v-if="actionVal4" :comData="CurrentComData" :key="comActionsDialogKey"
            @childToParent="childToParentCall"></action-dialog-4>
        <!-- Damaged Quotation -->
        <action-dialog-5 v-if="actionVal5" :comData="CurrentComData" :key="comActionsDialogKey"
            @childToParent="childToParentCall"></action-dialog-5>
        <!-- Delivery -->
        <action-dialog-6 v-if="actionVal6" :comData="CurrentComData" :key="comActionsDialogKey"
            @childToParent="childToParentCall"></action-dialog-6>


    </div>
</template>

<script>
    // User Details Show By Dialog
    import userDetails from '../../../../../super_admin/pages/users/details/user_details.vue'
    import userDetailsData from '../../../../../super_admin/pages/users/details/js/data'
    import userDetailsMethods from '../../../../../super_admin/pages/users/details/js/methods'

    import catSubModifyDialog from './cat_sub_modify.vue'
    import actionDialog from './dialog/action_dialog.vue'
    import actionDialog2 from './dialog/action_dialog_2.vue'
    import actionDialog3 from './dialog/action_dialog_3.vue'
    import actionDialog4 from './dialog/action_dialog_4.vue'
    import actionDialog5 from './dialog/action_dialog_5.vue'
    import actionDialog6 from './dialog/action_dialog_6.vue'




    export default {

        components: {
            'user-details': userDetails,
            'cat-sub-modify-dialog': catSubModifyDialog,
            'action-dialog': actionDialog,
            'action-dialog-2': actionDialog2,
            'action-dialog-3': actionDialog3,
            'action-dialog-4': actionDialog4,
            'action-dialog-5': actionDialog5,
            'action-dialog-6': actionDialog6,
        },

        data() {
            return {
                //current page url
                currentUrl: '/cms/h_admin/complain',

                docPath: '/images/hardware/',

                comId: this.$route.query.id,

                complainDeta: '',

                //Action Dialog
                actionBtnLoading: false,
                actionVal: false,
                actionVal2: false,
                actionVal3: false,
                actionVal4: false,
                actionVal5: false,
                actionVal6: false,
                comActionsDialogKey: 3,
                CurrentComData: '',

                // comModifyDialog
                comModifyDialogKey: 5,
                CurrentComDataModify: '',

                actionBtnText: 'Action',
                actionBtnColor: 'success',
                actionAccess: true,


                // Current User Show By Dilog
                ...userDetailsData,


            }
        },

        methods: {

            childToParentCall() {
                //console.log('child') // someValue
                // refresh data
                this.getComplainData();

                // For sidebar counter
                this.countAll();
            },

            // CurrentUserData
            ...userDetailsMethods,


            // check action btn access
            checkActionBtnAccess() {

                if (this.complainDeta.process == 'HO Service') {
                    return true;
                }

                if (this.complainDeta.process != 'Closed') {
                    return true;
                }

                return false;
            },

            // getComplainData
            getComplainData() {
                this.dataLoading = true
                axios.get(this.currentUrl + '/action/' + this.comId).then(response => {
                    this.dataLoading = false

                    console.log(response.data)
                    this.complainDeta = response.data
                    this.actionBtn()

                }).catch(error => {
                    this.dataLoading = false
                    console.log(error)
                })

            },


            // modifyDialogShow
            modifyDialogShow() {
                this.comModifyDialogKey++
                this.CurrentComDataModify = this.complainDeta
            },

            // mailSendManual
            mailSendManual(val) {
                this.overlay = true
                axios.get(this.currentUrl + '/send_rem_email?id=' + val)
                    .then(response => {
                        //console.log(response.data);
                        this.getComplainData();
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.msg,
                        })
                        this.overlay = false
                    }).catch(error => {
                        this.overlay = false
                        console.log(error);
                    });

            },


            // actionDialogShow
            actionDialogShow() {
                this.actionBtnLoading = true

                //console.log('Process ', val)
                let currPro = this.complainDeta.process
                this.actionVal = false
                this.actionVal2 = false
                this.actionVal3 = false
                this.actionVal4 = false
                this.actionVal5 = false
                this.actionVal6 = false

                if (currPro == 'Not Process') {
                    this.actionVal = true
                    //this.actionVal2 = false
                }

                // Processing
                if (currPro == 'Processing' || currPro == 'Send Service' || currPro == 'Back Service' || currPro ==
                    'Again Send Service' || currPro ==
                    'Service Quotation') {
                    // this.actionVal = false
                    this.actionVal2 = true
                }

                // HO Service
                if (currPro == 'HO Service' && this.isHardwareHoService()) {
                    //console.log('HO Service')
                    // HO service
                    this.actionVal3 = true
                }

                // Damaged
                if (currPro == 'Damaged' || currPro == 'Partial Damaged') {
                    let damagedData = this.complainDeta.damage
                    // Check Applicable
                    if (damagedData.applicable_type == 'Applicable' && !damagedData.apply_quotation) {
                        // Check user applied
                        if (!damagedData.apply_at) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Sorry!! User not yet applied',
                            })
                        } else {
                            this.actionVal5 = true
                        }

                    } else {
                        // this.actionVal = false
                        this.actionVal4 = true
                    }

                }

                // Deliverable
                if (currPro == 'Deliverable') {
                    //console.log('Deliverable')
                    // HO service
                    this.actionVal6 = true
                }

                this.comActionsDialogKey++
                this.CurrentComData = this.complainDeta

                // this.comActionsDialogKey++
                // this.CurrentComData = this.complainDeta

                this.actionBtnLoading = false
            },


            actionBtn() {

                //console.log('Process ', val)
                let currPro = this.complainDeta.process
                // For Action BTN

                // HO access
                if ( !this.isHardwareHoService() && currPro == 'HO Service' ) {
                    this.actionBtnText = 'Sorry! You have no HO access'
                    this.actionBtnColor = 'error'
                    this.actionAccess = false
                }

                // Delivery access
                if ( !this.isHardwareDelivery() && currPro == 'Deliverable' ) {
                    this.actionBtnText = 'Sorry! You have no Delivery access'
                    this.actionBtnColor = 'error'
                    this.actionAccess = false
                }

                // Damaged access
                if ( !this.isHardwareDamaged() &&  (currPro == 'Damaged' || currPro == 'Partial Damaged') ) {
                    this.actionBtnText = 'Sorry! You have no Damage access'
                    this.actionBtnColor = 'error'
                    this.actionAccess = false
                }

                // Closed
                if ( currPro == 'Closed' ) {
                    this.actionBtnText = 'Sorry! Complain already closed'
                    this.actionBtnColor = 'error'
                    this.actionAccess = false
                }

            }





        },

        mounted() {
            // console.log('drafts', this.drafts)
        },

        created() {
            this.$Progress.start();
            this.getComplainData();

            this.allReplayDraft();

            //console.log(this.comId, this.$route.query.id, this.isHardwareHoService() )
            this.$Progress.finish();
        }

    }

</script>
